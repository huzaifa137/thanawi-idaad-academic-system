<?php
namespace App\Exports;

use App\Models\Student;
use App\Models\ClassStreamAssignment;
use App\Models\ClassSubject;
use App\Models\MasterData;
use App\Http\Controllers\Helper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ClassStudentsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $classId;
    protected $subjects = [];

    public function __construct($classId)
    {
        $this->classId = $classId;
        $this->loadSubjects();
    }

    /**
     * Load all subjects attached to this class (all streams combined)
     */
    protected function loadSubjects()
    {
        $assignmentIds = ClassStreamAssignment::where('class_id', $this->classId)
            ->where('school_id', session('LoggedSchool'))
            ->pluck('id');

        $this->subjects = ClassSubject::whereIn('class_stream_assignment_id', $assignmentIds)
            ->join('master_datas', 'class_subjects.subject_id', '=', 'master_datas.md_master_code_id')
            ->select(
                'master_datas.md_master_code_id',
                'master_datas.md_name as subject_name'
            )
            ->distinct()
            ->orderBy('subject_name')
            ->get();
    }

    public function collection()
    {
        return Student::where('school_id', session('LoggedSchool'))
            ->where('senior', $this->classId)
            ->orderBy('stream')
            ->orderBy('firstname')
            ->get();
    }

    public function headings(): array
    {
        $headers = [
            'No',
            'Full Name',
            'Class',
            'Stream',
        ];

        foreach ($this->subjects as $subject) {
            $headers[] = $subject->subject_name;
        }

        return $headers;
    }

    public function map($student): array
    {
        static $no = 1;

        $row = [
            $no++,
            $student->firstname . ' ' . $student->lastname,
            Helper::item_md_name($this->classId),
            Helper::item_md_name($student->stream),
        ];

        // Empty columns for subject marks
        foreach ($this->subjects as $subject) {
            $row[] = '';
        }

        return $row;
    }

    public function title(): string
    {
        return Helper::item_md_name($this->classId);
    }
}
