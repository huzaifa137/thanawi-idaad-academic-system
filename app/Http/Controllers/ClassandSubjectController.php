<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Helper;

class ClassandSubjectController extends Controller
{

    public function createClass()
    {
        $SecondaryClasses = Helper::MasterRecordMerge(
            config('constants.options.O_LEVEL'),
            config('constants.options.A_LEVEL')
        );

        $TECHNICAL_SUBJECTS = Helper::MasterRecords(config('constants.options.TECHNICAL_SUBJECTS'));
        $OPTIONALS = Helper::MasterRecords(config('constants.options.OPTIONALS'));
        $VOCATIONALS = Helper::MasterRecords(config('constants.options.VOCATIONALS'));
        $MATHEMATICS = Helper::MasterRecords(config('constants.options.MATHEMATICS'));
        $LANGUAGES = Helper::MasterRecords(config('constants.options.LANGUAGES'));
        $SCIENCES = Helper::MasterRecords(config('constants.options.SCIENCES'));
        $HUMANITIES = Helper::MasterRecords(config('constants.options.HUMANITIES'));
        $CLASS_STREAMS = Helper::MasterRecords(config('constants.options.CLASS_STREAMS'));

        return view('Class.create-class', compact(
            'SecondaryClasses',
            'TECHNICAL_SUBJECTS',
            'OPTIONALS',
            'VOCATIONALS',
            'MATHEMATICS',
            'LANGUAGES',
            'SCIENCES',
            'HUMANITIES',
            'CLASS_STREAMS'
        ));
    }

     public function storeSchool(Request $request)
    {

        dd($request->all());
        
        // $validated = $request->validate([
        //     'school_type'       => 'required|string|max:255',
        //     'email'             => 'required|email',
        //     'gender'            => 'required|string|max:50',
        //     'regional_level'    => 'required|string|max:100',
        //     'school_ownership'  => 'required|string|max:100',
        //     'boarding_status'   => 'required|string|max:100',
        //     'name'              => 'required|string|max:255',
        //     'school_product'    => 'required',
        //     'registration_code' => 'required|string|max:50',
        //     'phone'             => 'required|string|max:20',
        //     'population'        => 'required|string',
        // ]);

        // $validated['added_by']   = Session('LoggedStudent');
        // $validated['date_added'] = now();

        // School::create($validated);

        return response()->json(['success' => true, 'message' => 'School created successfully.']);
    }
}

