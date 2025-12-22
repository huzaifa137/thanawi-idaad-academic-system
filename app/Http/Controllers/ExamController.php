<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Exports\ClassStudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\CreatedExam;
use App\Models\MasterData;
use App\Models\TermDate;
use App\Models\Student;


class ExamController extends Controller
{

    public function schoolStudents()
    {
        $school_id = session('LoggedSchool');

        if (!$school_id) {
            dd('Please select a school to proceed ...');
        }

        $activeYear = AcademicYear::orderBy('id', 'desc')
            ->where('is_active', 1)
            ->value('name');

        $termDates = TermDate::where('school_id', $school_id)
            ->orderBy('term', 'asc')
            ->get();

        $SecondaryClasses = Helper::MasterRecordMerge(
            config('constants.options.O_LEVEL'),
            config('constants.options.A_LEVEL')
        );

        $schools = MasterData::where('md_master_code_id', config('constants.options.SCHOOL_TERMS'))->get();

        return view(
            'Exam.specific-school-students',
            compact('activeYear', 'termDates', 'SecondaryClasses')
        );
    }


    public function storeCreatedExam(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'exam_name' => 'required|string|max:255',
            'term' => 'required|integer',
            'class_ids' => 'required|array|min:1',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $exam = CreatedExam::create([
            'ce_exam_name' => $request->exam_name,
            'ce_term' => $request->term,
            'ce_class_ids' => json_encode($request->class_ids),
            'ce_exam_year' => Helper::active_year(),
            'ce_created_by' => session('LoggedStudent'),
            'ce_date_created' => now()->toISOString(),
        ]);

        return response()->json(['message' => 'Exam created successfully!']);
    }

    public function manageExams()
    {
        $activeYear = Helper::active_year();

        $exams = CreatedExam::where('ce_exam_year', $activeYear)
            ->orderBy('ce_term')
            ->orderBy('ce_date_created', 'desc')
            ->get()
            ->groupBy('ce_term');

        return view('Exam.manage-exams', compact('exams', 'activeYear'));
    }

    public function editExams()
    {

        return view('Exam.edit-exams');
    }

    public function uploadExams()
    {
        $activeYear = Helper::active_year();

        $exams = CreatedExam::where('ce_exam_year', $activeYear)
            ->where('ce_exam_status', 0)
            ->orderBy('ce_term')
            ->orderBy('ce_date_created', 'desc')
            ->get()
            ->groupBy('ce_term');

        return view('Exam.upload-exams', compact('exams', 'activeYear'));
    }

    public function downloadClassList($examId, $classId)
    {
        $exam = CreatedExam::findOrFail($examId);

        return Excel::download(
            new ClassStudentsExport($classId),
            Helper::item_md_name($classId) . '_Class_List.xlsx'
        );
    }
}
