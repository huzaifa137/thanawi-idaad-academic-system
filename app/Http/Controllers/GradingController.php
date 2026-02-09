<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentExamImport;
use App\Models\AnnualExamination;
use App\Models\Exam;
use App\Models\MasterData;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\TermDate;
use App\Models\Student;

class GradingController extends Controller
{
    public function importMarks()
    {
        $students = Student::with('school')
            ->fromSub(function ($query) {
                $query->from('students')
                    ->select('*')
                    ->selectRaw(
                        'ROW_NUMBER() OVER (
                    PARTITION BY school_id
                    ORDER BY id
                ) as row_num'
                    );
            }, 'students')
            ->where('row_num', '<=', 1)
            ->orderBy('school_id')
            ->orderBy('id')
            ->get();

        $groupedStudents = $students->groupBy(function ($student) {
            return $student->school->name;
        });

        $thanawiPapers = MasterData::where(
            'md_master_code_id',
            config('constants.options.ThanawiPapers')
        )->get();

        $idaadPapers = MasterData::where(
            'md_master_code_id',
            config('constants.options.IdaadPapers')
        )->get();


        return view('Grading.import-marks', compact(
            'groupedStudents',
            'thanawiPapers',
            'idaadPapers'
        ));
    }

    public function createExamination()
    {
        // Admin
        $school_id = session('LoggedSchool');

        if (!$school_id) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Please select a school to proceed.');
        }

        $activeYear = AcademicYear::orderBy('id', 'desc')
            ->where('is_active', 1)
            ->value('name');

        $termDates = TermDate::where('school_id', $school_id)
            ->orderBy('term', 'asc')
            ->get();

        $schools = MasterData::where('md_master_code_id', config('constants.options.SCHOOL_TERMS'))->get();

        return view(
            'Grading.create-examination',
            compact('activeYear', 'termDates')
        );
    }

    public function storeCreatedExamination(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'ExaminationName' => 'required|string',
            'year' => 'required|integer',
            'marks_upload_enabled' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $examination_name = ($request->ExaminationName === "194") ? "Idaad" : "Thanawi";

        $existingExam = AnnualExamination::where('year', $request->year)
            ->where('examination_name', $examination_name)
            ->first();

        if ($existingExam) {
            return response()->json([
                'errors' => ['year' => ["An examination with name '{$examination_name}' for this year already exists."]]
            ], 422);
        }

        $activeExam = AnnualExamination::where('year', $request->year)
            ->where('examination_name', $examination_name)
            ->where('is_active', true)
            ->first();

        if ($activeExam) {
            return response()->json([
                'errors' => ['is_active' => ["There is an existing active examination '{$examination_name}' for this year. Please disable it first."]]
            ], 422);
        }

        $oldActiveExam = AnnualExamination::where('year', '!=', $request->year)
            ->where('examination_name', $examination_name)
            ->where('is_active', true)
            ->first();

        if ($oldActiveExam) {
            return response()->json([
                'errors' => ['is_active' => ["There is an existing old active examination '{$examination_name}' for the '{$oldActiveExam->year}'. Please disable this year '{$oldActiveExam->year}' first."]]
            ], 422);
        }

        AnnualExamination::create([
            'examination_name' => $examination_name,
            'examination_classification' => $examination_name,
            'year' => $request->year,
            'is_active' => (bool) $request->marks_upload_enabled,
        ]);

        return response()->json(['success' => true, 'message' => 'Examination created successfully.']);
    }

    public function toggleExamActive(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:annual_examinations,id',
            'is_active' => 'required|boolean',
        ]);

        $exam = AnnualExamination::findOrFail($request->exam_id);

        if ($request->is_active) {
            AnnualExamination::where('examination_name', $exam->examination_name)
                ->where('id', '!=', $exam->id)
                ->update(['is_active' => false]);
        }

        $exam->is_active = $request->is_active;
        $exam->save();

        return response()->json([
            'success' => true,
            'message' => $request->is_active
                ? "Exam '{$exam->examination_name}' activated."
                : "Exam '{$exam->examination_name}' deactivated."
        ]);
    }

    public function getExamYears()
    {
        $years = AnnualExamination::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return response()->json($years);
    }

    public function getExamsByYear($year)
    {
        $exams = AnnualExamination::where('year', $year)
            ->orderBy('examination_name', 'asc')
            ->get();

        return response()->json($exams);
    }


    public function uploadExamResults(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'type' => 'required|in:thanawi,idaad',
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        $activeYear = Helper::active_year();
        if ($activeYear == 'No Active year Set') {
            return back()->with('error', 'No Active Academic Year Set.');
        }

        $subjects = $request->type === 'thanawi'
            ? MasterData::where('md_master_code_id', config('constants.options.ThanawiPapers'))->get()
            : MasterData::where('md_master_code_id', config('constants.options.IdaadPapers'))->get();

        if ($subjects->isEmpty()) {
            return back()->with('error', 'No subjects found for this exam type.');
        }

        // Create Exam record
        $exam = Exam::create([
            'school_id' => $request->school_id,
            'exam_type' => $request->type,
            'academic_year' => $activeYear
        ]);

        // Import Excel
        Excel::import(new StudentExamImport($exam, $subjects), $request->file('file'));

        return back()->with('success', 'Exam results uploaded successfully.');
    }

    public function getActiveExams()
    {
        $activeExams = AnnualExamination::where('is_active', true)
            ->orderBy('examination_name')
            ->get();

        return response()->json($activeExams);
    }

    public function importIdaadResults(Request $request)
    {
        dd($request->all());
    }

    public function importThanawiResults(Request $request)
    {
        dd($request->all());
    }
}
