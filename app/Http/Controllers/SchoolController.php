<?php
namespace App\Http\Controllers;

use App\Models\DynamicFormValue;
use App\Models\MasterData;
use App\Models\School;
use App\Models\SchoolProfile;
use App\Models\UpdateTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{

    public function adminUser(Request $request)
    {
        session()->flush();
        $request->session()->put('LoggedAdmin', 1);

        return view('dashboard');
    }

    public function studentUser(Request $request)
    {
        session()->flush();
        $request->session()->put('LoggedStudent', 1);

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

    public function storeSchool(Request $request)
    {

        $validated = $request->validate([
            'school_type'       => 'required|string|max:255',
            'email'             => 'required|email',
            'gender'            => 'required|string|max:50',
            'regional_level'    => 'required|string|max:100',
            'school_ownership'  => 'required|string|max:100',
            'boarding_status'   => 'required|string|max:100',
            'name'              => 'required|string|max:255',
            'school_product'    => 'required',
            'registration_code' => 'required|string|max:50',
            'phone'             => 'required|string|max:20',
            'population'        => 'required|string',
        ]);

        $validated['added_by']   = Session('LoggedStudent');
        $validated['date_added'] = now();

        School::create($validated);

        return response()->json(['success' => true, 'message' => 'School created successfully.']);
    }

    public function editSchool($id)
    {
        $school    = School::findOrFail($id);
        $school_id = $id;

        return view('School.edit-school', compact(['school', 'school_id']));
    }

    public function updateSchool(Request $request)
    {
        $school = School::findOrFail($request->school_id);

        $validated = $request->validate([
            'school_type'       => 'required|string|max:255',
            'email'             => 'required|email',
            'gender'            => 'required|string|max:50',
            'regional_level'    => 'required|string|max:100',
            'school_ownership'  => 'required|string|max:100',
            'boarding_status'   => 'required|string|max:100',
            'name'              => 'required|string|max:255',
            'school_product'    => 'required',
            'registration_code' => 'required|string|max:50',
            'phone'             => 'required|string|max:20',
            'population'        => 'required|string',
        ]);

        $school->update($validated);

        UpdateTracker::create([
            'item_id'         => $request->school_id,
            'item_category'   => 'School Information Updated',
            'updated_by'      => session('LoggedStudent'),
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

    public function schoolProfile($id)
    {
        $school  = School::findOrFail($id);
        $profile = SchoolProfile::where('school_id', $id)->first();

        return view('School.school-profile', compact('school', 'profile'));
    }

    public function schoolOptions($id)
    {
        $school  = School::findOrFail($id);
        $profile = SchoolProfile::where('school_id', $id)->first();

        $genderMasterDataCollection = MasterData::where('md_master_code_id', config('constants.options.SCHOOL_OPTIONALS'))->get();

        $allDynamicFields  = collect();
        $masterDataDetails = collect();

        if ($genderMasterDataCollection->isNotEmpty()) {
            foreach ($genderMasterDataCollection as $masterData) {
                $masterDataId = $masterData->md_id;

                $dynamicFieldsForThisMasterData = DynamicFormValue::where('master_data_id', $masterDataId)->get();

                $allDynamicFields = $allDynamicFields->merge($dynamicFieldsForThisMasterData);

                $masterDataDetails->push([
                    'name'        => $masterData->md_name,
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
            'school_id'         => 'required|integer|exists:schools,id',
            'school_type'       => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'gender'            => 'required|string|max:50',
            'boarding_status'   => 'required|string|max:100',
            'name'              => 'required|string|max:255',
            'registration_code' => 'required|string|max:50',
            'phone'             => 'required|string|max:20',
            'population'        => 'required|string',
            'motto'             => 'nullable|string|max:255',
            'vision'            => 'nullable|string|max:255',
            'admission_prefix'  => 'nullable|string|max:50',
            'admission_start'   => 'nullable|string|max:50',
            'admission_suffix'  => 'nullable|string|max:50',
            'logo'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = SchoolProfile::where('school_id', $validated['school_id'])->first();

        if ($request->hasFile('logo')) {

            if ($profile && $profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }

            $logoFile          = $request->file('logo');
            $logoPath          = $logoFile->store('logos', 'public');
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

}
