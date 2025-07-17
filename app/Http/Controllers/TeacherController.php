<?php
namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function addTeachers($id)
    {
        $school_id = $id;

        return view('Teacher.add-teachers', compact('school_id'));
    }

    public function storeTeacher(Request $request)
    {

        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'surname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'othername' => 'nullable|string|max:255',
            'initials' => 'nullable|string|max:255',
            'phonenumber' => 'required|string|max:20',
            'registration_number' => 'nullable|string|max:50',
            'gender' => 'nullable|in:male,female',
            'national_id' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'employee_number' => 'nullable|string|max:50',
            'group_teacher' => 'nullable|integer',
        ]);

        Teacher::create($validated);

        return response()->json(['message' => 'Teacher added successfully']);
    }

    public function allTeachers()
    {
        $teachers = Teacher::orderBy('surname')->get();

        return view('Teacher.teachers-in-school', compact('teachers'));
    }

    public function teacherProfile($id)
    {
        $teacher = Teacher::with('school')->findOrFail($id);
        $school_id = $teacher->school_id;

        return view('Teacher.teacher-profile', compact('teacher', 'school_id'));
    }

    public function updateteacherProfile($id)
    {
        $teacher = Teacher::with('school')->findOrFail($id);
        $school_id = $teacher->school_id;

        return view('Teacher.update-teacher-profile', compact('teacher', 'school_id'));
    }

    public function storeUpdatedTeacherProfile(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'surname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:20',
            'othername' => 'nullable|string|max:255',
            'initials' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:50',
            'gender' => 'nullable|in:male,female',
            'national_id' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'employee_number' => 'nullable|string|max:50',
            'group_teacher' => 'nullable|integer|between:1,5',
            'teacher_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = Teacher::where('id', $teacher->id)->first();

        if ($request->hasFile('teacher_profile')) {

            if ($profile && $profile->teacher_profile) {
                Storage::disk('public')->delete($profile->teacher_profile);
            }

            $logoFile = $request->file('teacher_profile');
            $logoPath = $logoFile->store('teacherProfiles', 'public');
            $validated['teacher_profile'] = $logoPath;
        } else if ($profile) {
            $validated['teacher_profile'] = $profile->teacher_profile;
        } else {
            $validated['teacher_profile'] = null;
        }

        $teacher->update($validated);

        return response()->json(['message' => 'Teacher updated successfully']);
    }

    public function schoolTeachers()
    {
        $teachers = Teacher::with('school')
            ->where('school_id', Session('LoggedSchool'))
            ->orderBy('surname')
            ->get();

        $school_id = Session('LoggedSchool');

        return view('Teacher.teachers-in-school', compact('teachers', 'school_id'));
    }

    public function destroyTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return response()->json(['message' => 'Teacher deleted successfully.']);
    }

}
