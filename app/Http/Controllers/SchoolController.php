<?php
namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\DynamicFormValue;
use App\Models\MasterData;
use App\Models\School;
use App\Models\SchoolProfile;
use App\Models\TermDate;
use App\Models\UpdateTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{

    public function adminUser(Request $request)
    {
        session()->flush();
        $request->session()->put('LoggedAdmin', 1);

        $request->session()->put('LoggedSchool', 457);

        return view('dashboard');
    }

    public function studentUser(Request $request)
    {
        session()->flush();
        $request->session()->put('LoggedStudent', 1);
        $request->session()->put('LoggedAdmin', 1);
        $request->session()->put('LoggedSchool', 2);

        return view('student.dashboard');
    }

    public function createSchool()
    {
        return view('School.create-school');
    }

    public function allSchools()
    {
        $schools = School::latest()->get();

        return view('School.all-schools', compact('schools'));
    }

    public function termDates()
    {
        $school_id = Session('LoggedSchool');
        $academicYears = AcademicYear::orderBy('id', 'desc')->where('is_active', 1)->get();
        $termDates = TermDate::where('school_id', $school_id)->orderBy('term', 'asc')->get();

        return view('School.term-dates', compact('school_id', 'academicYears', 'termDates'));
    }

    public function createNewSchool(Request $request)
    {

        $validated = $request->validate([
            'school_type' => 'required|string|max:255',
            'email' => 'required|email',
            'gender' => 'required|string|max:50',
            'regional_level' => 'required|string|max:100',
            'school_ownership' => 'required|string|max:100',
            'boarding_status' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'school_product' => 'required',
            'registration_code' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'population' => 'required|string',
        ]);

        $validated['added_by'] = Session('LoggedStudent');
        $validated['date_added'] = now();

        School::create($validated);

        return response()->json(['success' => true, 'message' => 'School created successfully.']);
    }

    public function editSchool($id)
    {
        $school = School::findOrFail($id);
        $school_id = $id;

        return view('School.edit-school', compact(['school', 'school_id']));
    }

    public function updateSchool(Request $request)
    {
        $school = School::findOrFail($request->school_id);

        $validated = $request->validate([
            'school_type' => 'required|string|max:255',
            'email' => 'required|email',
            'gender' => 'required|string|max:50',
            'regional_level' => 'required|string|max:100',
            'school_ownership' => 'required|string|max:100',
            'boarding_status' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'school_product' => 'required',
            'registration_code' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'population' => 'required|string',
        ]);

        $school->update($validated);

        UpdateTracker::create([
            'item_id' => $request->school_id,
            'item_category' => 'School Information Updated',
            'updated_by' => session('LoggedStudent'),
            'date_updated_on' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'School Information updated successfully.',
        ]);
    }

    public function deleteSchool(School $schoolId)
    {
        try {

            $schoolId->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Delete failed'], 500);
        }
    }

    public function schoolProfile()
    {

        $school = School::findOrFail(Session('LoggedSchool'));
        $profile = SchoolProfile::where('school_id', Session('LoggedSchool'))->first();

        return view('School.school-profile', compact('school', 'profile'));
    }

    public function schoolOptions($id)
    {
        $school = School::findOrFail($id);
        $profile = SchoolProfile::where('school_id', $id)->first();

        $genderMasterDataCollection = MasterData::where('md_master_code_id', config('constants.options.SCHOOL_OPTIONALS'))->get();

        $allDynamicFields = collect();
        $masterDataDetails = collect();

        if ($genderMasterDataCollection->isNotEmpty()) {
            foreach ($genderMasterDataCollection as $masterData) {
                $masterDataId = $masterData->md_id;

                $dynamicFieldsForThisMasterData = DynamicFormValue::where('master_data_id', $masterDataId)->get();

                $allDynamicFields = $allDynamicFields->merge($dynamicFieldsForThisMasterData);

                $masterDataDetails->push([
                    'name' => $masterData->md_name,
                    'description' => $masterData->md_description ?? 'N/A',
                ]);
            }
        }

        return view('School.school-options', compact(
            'school',
            'profile',
            'masterDataDetails',
            'allDynamicFields'
        ));
    }

    public function storeSchoolProfile(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|integer|exists:schools,id',
            'school_type' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'required|string|max:50',
            'boarding_status' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'registration_code' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'population' => 'required|string',
            'motto' => 'nullable|string|max:255',
            'vision' => 'nullable|string|max:255',
            'admission_prefix' => 'nullable|string|max:50',
            'admission_start' => 'nullable|string|max:50',
            'admission_suffix' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = SchoolProfile::where('school_id', $validated['school_id'])->first();

        if ($request->hasFile('logo')) {

            if ($profile && $profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }

            $logoFile = $request->file('logo');
            $logoPath = $logoFile->store('logos', 'public');
            $validated['logo'] = $logoPath;
        } else if ($profile) {
            $validated['logo'] = $profile->logo;
        } else {
            $validated['logo'] = null;
        }

        $validated['updated_at'] = now();

        if ($profile) {
            $profile->update($validated);
            $message = 'School profile updated successfully.';
        } else {
            $validated['created_at'] = now();
            SchoolProfile::create($validated);
            $message = 'School profile created successfully.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function configureSchoolOptions(Request $request)
    {
        dd($request->all());
    }

    public function addAcademicYear()
    {

        $academicYears = AcademicYear::orderBy('id', 'desc')->get();

        return view('AcademicYear.add-year', compact(['academicYears']));
    }

    public function storeYear(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:academic_years,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        $academicYear = AcademicYear::create($validated);

        return response()->json([
            'message' => 'Academic Year created successfully.',
            'data' => $academicYear,
        ], 201);
    }

    public function activate($id)
    {
        AcademicYear::query()->update(['is_active' => false]); // Deactivate all
        $year = AcademicYear::findOrFail($id);
        $year->update(['is_active' => true]);

        return response()->json(['message' => 'Academic year activated.']);
    }

    public function deactivate($id)
    {
        $year = AcademicYear::findOrFail($id);
        $year->update(['is_active' => false]);

        return response()->json(['message' => 'Academic year deactivated.']);
    }

    public function destroy($id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        if ($academicYear->is_active) {
            return response()->json(['error' => 'Cannot delete an active academic year.'], 403);
        }

        $academicYear->delete();

        return response()->json(['message' => 'Academic year deleted successfully.']);
    }

    public function updateYear(Request $request, $id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:academic_years,name,' . $id,
            'is_active' => 'required|boolean',
        ]);

        if ($request->is_active == 1) {
            AcademicYear::query()->update(['is_active' => false]);
            $year = AcademicYear::findOrFail($id);
            $year->update(['is_active' => true]);
        }

        $academicYear->update($validated);

        return response()->json([
            'message' => 'Academic Year updated successfully.',
            'data' => $academicYear,
        ]);
    }

    public function storeTermDate(Request $request)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'term' => 'required|string|max:255',
            'start_date' => 'required|date',
            'school_id' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'week_starts_on' => 'required|in:1,2',
        ]);

        $exists = TermDate::where('school_id', $validated['school_id'])
            ->where('term', $validated['term'])
            ->where('academic_year_id', $validated['academic_year_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'This term already exists for the selected school.',
            ], 409);
        }

        $termDate = TermDate::create($validated);

        return response()->json([
            'message' => 'Term date added successfully.',
            'data' => $termDate,
        ], 201);
    }

    public function destroyTerm($id)
    {
        $academicTerm = TermDate::findOrFail($id);
        $academicTerm->delete();

        return response()->json(['message' => 'Term deleted successfully.']);
    }

    public function selectSchool(Request $request)
    {
        $schoolId = $request->input('school_id');
        $school = School::find($schoolId);

        if (!$school) {
            return response()->json([
                'status' => false,
                'message' => 'School not found.'
            ]);
        }

        $request->session()->put('LoggedSchool', $schoolId);

        return response()->json([
            'status' => true,
            'message' => "School switched to {$school->name}"
        ]);
    }
}
