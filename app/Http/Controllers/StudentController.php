<?php
namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Classroom;
use App\Models\Stream;
use App\Models\Student;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;

class StudentController extends Controller
{
    public function register(Request $request)
    {
        return view('users.register');
    }

    public function user_terms_and_conditions(Request $request)
    {
        return view('users.terms-and-conditions');
    }

    public function flushSession()
    {
        session()->flush();

        return redirect('/');
    }

    public function userRegistrationOTP()
    {
        return view('users.LoginOTP');
    }

    public function userAccountCreation(Request $request)
    {

        // ACCOUNT STATUSES
// --------------------------------------
        // 1.Banned     ====> 0
        // 2.Locked     ====> 8
        // 3.Suspended  ====> 9
        // 4.Active     ====> 10

        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ],
        ], [
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
        ]);

        $password = $request->password;
        $confirm_password = $request->confirmPassword;

        if ($password != $confirm_password) {
            return response()->json([
                'status' => false,
                'message' => 'Provided Passwords do not match',
            ]);
        }

        $user = new User;

        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($password);
        $save = $user->save();

        $generatedOTP = rand(10000, 99999);
        $info = DB::table('users')->where('email', $request->email)->update(['temp_otp' => $generatedOTP]);
        $registeredUser = DB::table('users')->where('email', $request->email)->first();

        if ($registeredUser && Hash::check($request->password, $registeredUser->password)) {

            $generatedOTP = rand(10000, 99999);
            DB::table('users')->where('email', $request->email)->update(['temp_otp' => $generatedOTP]);

            $userId = $registeredUser->id;
            $username = $registeredUser->username;
            $useremail = $registeredUser->email;

            $data = [
                'subject' => 'Smart Schools REGISTRATION OTP',
                'body' => 'Enter the Sent OTP to confirm registration : ',
                'generatedOTP' => $generatedOTP,
                'username' => $username,
                'email' => $useremail,
            ];

            try {
                Mail::send('emails.otp', $data, function ($message) use ($data) {
                    $message->to($data['email'], $data['email'])->subject($data['subject']);
                });
            } catch (Exception $e) {
                DB::table('users')->where('email', $request->email)->delete();
                return back()->with('error', 'Email Not, Check Internet or re-register');
            }

            $request->session()->put('userId', $userId);
            $request->session()->put('userEmail', $useremail);
            $request->session()->put('userPassword', $request->password);

            return response()->json([
                'status' => true,
                'message' => 'OTP has been sent,check your email to proceed',
                'redirect_url' => '/users/user-otp',
            ]);

        } else {
            return response()->json([
                'status' => false,
                'message' => 'There was something wrong in creating this account,try registering again or contact admins',
                'redirect_url' => '/',
            ]);
        }
    }

    public function supplierOtpVerification(Request $request)
    {

        $otp_1 = $request->input('otp_1');
        $otp_2 = $request->input('otp_2');
        $otp_3 = $request->input('otp_3');
        $otp_4 = $request->input('otp_4');
        $otp_5 = $request->input('otp_5');

        $new_otp = $otp_1 . $otp_2 . $otp_3 . $otp_4 . $otp_5;
        $user_id = $request->input('hidden_otp');

        $temp_otp_stored = DB::table('users')->where('id', $user_id)->value('temp_otp');
        $supplier_username = DB::table('users')->where('id', $user_id)->value('username');
        $userRole = DB::table('users')->where('id', $user_id)->value('user_role');

        if ($new_otp == $temp_otp_stored) {

            if ($userRole != 1) {
                $request->session()->put('LoggedAdmin', $user_id);
            } else {
                $request->session()->put('LoggedStudent', $user_id);
            }

            $url = '/';
            $url2 = session()->get('url.intended');
            $url3 = '/student/dashboard';

            if ($userRole != 1) {
                if ($url2 != null) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login successful',
                        'redirect_url' => $url2,
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',
                    'redirect_url' => $url,
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',
                    'redirect_url' => $url3,
                ]);
            }

        } else {

            return response()->json([
                'status' => false,
                'title' => 'Invalid OTP',
                'message' => 'Entered OTP is invalid, please check your email for correct OTP code',
            ]);
        }
    }

    public function studentDashboard()
    {
        $studentId = session('LoggedStudent');
        $student = DB::table('users')->where('id', $studentId)->first();

        return view('student.dashboard', compact('student'));
    }

    public function selectCurrentSchool()
    {

        if (session('login_email')) {

            $email = session('login_email');
            $user = DB::table('users')->where('email', $email)->first();
            $userInfo = DB::table('teachers')->where('id', $user->username)->first();

            $teacherSchools = DB::table('teachers')
                ->where('email', session(key: 'login_email'))
                ->pluck('school_id')
                ->unique();


            $schoolsInExistance = DB::table('schools')
                ->whereIn('id', $teacherSchools)
                ->get()
                ->map(function ($school) {
                    $profile = DB::table('school_profiles')->where('school_id', $school->id)->first();
                    $school->profile = $profile;
                    return $school;
                });


            return view('users.schools-teacher-belongs-in', compact(['schoolsInExistance', 'userInfo', 'email']));

        } else {
            session()->flush();
            return redirect('/');
        }
    }

    public function studentProfile(Request $request)
    {
        $user = DB::table('users')->where('id', session('LoggedStudent'))->first();

        return view('student.profile', compact(['user']));
    }

    public function editStudentProfile()
    {

        $info = DB::table('users')->where('id', Session('LoggedStudent'))->first();

        return view('student.edit-profile', compact(['info']));
    }

    public function studentPortal()
    {
        $school_id = Session('LoggedSchool');

        $classRecord = Classroom::where('school_id', Session('LoggedSchool'))->get();
        $StreamRecord = Stream::where('school_id', Session('LoggedSchool'))->get();

        return view('student.student-portal', compact('school_id', 'classRecord', 'StreamRecord'));
    }

    public function storeStudent(Request $request)
    {

        $validated = $request->validate([
            // Required fields
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'senior' => 'required|max:255',
            'stream' => 'required|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'school_id' => 'required|integer|exists:schools,id',

            // Optional fields
            'admission_number' => 'nullable|string|max:255|unique:students,admission_number',
            'primary_contact' => 'nullable|string|max:255',
            'other_contact' => 'nullable|string|max:255',
            'date_of_admission' => 'nullable|date',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'ple_score' => 'nullable|numeric|between:0,999.99',
            'uce_score' => 'nullable|numeric|between:0,999.99',
            'previous_school' => 'nullable|string|max:255',
            'primary_school_name' => 'nullable|string|max:255',
            'guardian_names' => 'nullable|string|max:255',
            'relation' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:255',
            'guardian_email' => 'nullable|email|max:255',
            'home_address' => 'nullable|string',
            'birth_certificate_entry_number' => 'nullable|string|max:255',
            'medical_history' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);


        $student = Student::create($validated);

        return response()->json(['message' => 'Student added successfully!']);
    }

    public function searchStudent()
    {
        $classRecord = Classroom::where('school_id', session('LoggedSchool'))->get();

        return view('student.student-search', compact(['classRecord']));
    }

    public function searchAjax(Request $request)
    {
        $criteria = $request->input('criteria');

        switch ($criteria) {
            case 'admission_number':
                $students = Student::where('admission_number', $request->admission_number)->get();
                break;
            case 'name':
                $students = Student::where('firstname', 'like', '%' . $request->firstname . '%')
                    ->where('lastname', 'like', '%' . $request->lastname . '%')
                    ->where('senior', $request->senior)
                    ->get();
                break;
            case 'phone':
                $students = Student::where('primary_contact', $request->phone)
                    ->orWhere('other_contact', $request->phone)
                    ->get();
                break;
            case 'student_id':
                $students = Student::where('id', $request->student_id)->get();
                break;
            default:
                return response()->json(['message' => 'Invalid criteria'], 400);
        }

        $html = view('student.partials.results', compact('students'))->render();

        return response()->json(['html' => $html]);
    }

    public function updateProfiles()
    {
        $students = Student::orderBy('created_at', 'desc')->get();

        $classRecord = Classroom::where('school_id', Session('LoggedSchool'))->get();
        $StreamRecord = Stream::where('school_id', Session('LoggedSchool'))->get();

        return view('student.student-information', compact(['students', 'classRecord', 'StreamRecord']));
    }

    public function update(Request $request, Student $student)
    {

        $validated = $request->validate([

            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'senior' => 'required|max:255',
            'stream' => 'required|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'school_id' => 'required|integer|exists:schools,id',
            'admission_number' => 'nullable|string|max:255|unique:students,admission_number,' . $student->id,

        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }


    public function showStudentInformation($id)
    {
        $student = Student::findOrFail($id);

        return response()->json([
            'id' => $student->id,
            'firstname' => $student->firstname,
            'lastname' => $student->lastname,
            'gender' => $student->gender,
            'admission_number' => $student->admission_number,

            'senior_id' => $student->senior,
            'senior' => Helper::recordMdname($student->senior),

            'stream_id' => $student->stream,
            'stream' => Helper::recordMdname($student->stream),

            'primary_contact' => $student->primary_contact,
            'other_contact' => $student->other_contact,
            'date_of_birth' => $student->date_of_birth,
            'nationality' => $student->nationality,
            'guardian_names' => $student->guardian_names,
            'guardian_phone' => $student->guardian_phone
        ]);
    }

    public function updateStudentInformation(Request $request, $id)
    {

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'senior' => 'nullable|max:255',
            'stream' => 'nullable|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'school_id' => 'sometimes|integer|exists:schools,id',

            'admission_number' => 'nullable|string|max:255|unique:students,admission_number,' . $id,
            'primary_contact' => 'nullable|string|max:255',
            'other_contact' => 'nullable|string|max:255',
            'date_of_admission' => 'nullable|date',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'ple_score' => 'nullable|numeric|between:0,999.99',
            'uce_score' => 'nullable|numeric|between:0,999.99',
            'previous_school' => 'nullable|string|max:255',
            'primary_school_name' => 'nullable|string|max:255',
            'guardian_names' => 'nullable|string|max:255',
            'relation' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:255',
            'guardian_email' => 'nullable|email|max:255',
            'home_address' => 'nullable|string',
            'birth_certificate_entry_number' => 'nullable|string|max:255',
            'medical_history' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);

        $student = Student::findOrFail($id);
        $student->update($validated);

        return response()->json(['message' => 'Student updated successfully']);
    }

    public function moveStudentForm()
    {
        $school_id = Session('LoggedSchool');

        $classrooms = Classroom::where('school_id', $school_id)->get();

        return view('student.move-student', compact('school_id', 'classrooms'));
    }

    public function getStreamsByClass(Request $request)
    {
        $classId = $request->input('class_id');
        $streams = Stream::where('class_id', $classId)->get();
   
        // Map streams to include helper processed names
        $streams = $streams->map(function ($stream) {
            $stream->display_name = Helper::recordMdname($stream->stream_id);
            
            return $stream;
        });

        return response()->json($streams);
    }
    public function searchStudentsByClassStream(Request $request)
    {

        $validated = $request->validate([
            'school_id' => 'required|integer',
            'senior' => 'required|string',
            'stream' => 'required|string',
        ]);

        $students = Student::where('school_id', $validated['school_id'])
            ->where('senior', $validated['senior'])
            ->where('stream', $validated['stream'])
            ->select('id', 'firstname', 'lastname', 'admission_number')
            ->get();

        return response()->json($students);
    }

    public function moveStudent(Request $request)
    {

        $validated = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'integer|exists:students,id',
            'new_senior' => 'required|string|max:255',
            'new_stream' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {

            Student::whereIn('id', $validated['student_ids'])->update([
                'senior' => $validated['new_senior'],
                'stream' => $validated['new_stream'],
            ]);

            DB::commit();

            return response()->json(['message' => 'Student(s) moved successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to move student(s).',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
