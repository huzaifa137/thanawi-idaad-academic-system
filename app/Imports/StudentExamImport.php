<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\Student;
use App\Models\StudentExamResult;

class StudentExamImport implements ToCollection
{
    protected $exam;
    protected $subjects;

    public function __construct($exam, $subjects)
    {
        $this->exam = $exam;       // Exam record (school, year, type)
        $this->subjects = $subjects; // Collection of subjects for this exam
    }

    public function collection(Collection $rows)
    {
        // skip header row
        foreach ($rows->skip(1) as $row) {

            // row format: [No, Admission Number, Name, ActiveYear, Subject1, Subject2,...]
            $admissionNumber = $row[1] ?? null;
            if (!$admissionNumber)
                continue;

            $student = Student::where('admission_number', $admissionNumber)
                ->where('school_id', $this->exam->school_id)
                ->first();

            if (!$student)
                continue; // skip unmatched students

            foreach ($this->subjects as $index => $subject) {
                $marks = $row[$index + 4] ?? null; // subject columns start at 4
                if ($marks === null || $marks === '')
                    continue;

                StudentExamResult::updateOrCreate(
                    [
                        'exam_id' => $this->exam->id,
                        'student_id' => $student->id,
                        'subject_id' => $subject->md_id,
                    ],
                    [
                        'marks' => $marks
                    ]
                );
            }
        }
    }
}
