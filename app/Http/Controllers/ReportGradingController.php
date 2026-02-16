<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassAllocation;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Http\Controllers\Helper;
use Illuminate\Support\Facades\DB;

class ReportGradingController extends Controller
{
    // ... existing methods ...

    /**
     * Show advanced analytics dashboard with dynamic filtering
     */
    public function gradingAnalytics(Request $request)
    {
        // Get filter data for dropdowns
        $years = $this->getAvailableYears();
        $levels = ['A' => 'Level A', 'O' => 'Level O', 'All' => 'All Levels'];
        $categories = ['TH' => 'Thanawi', 'ID' => 'Idaad', 'All' => 'All Categories'];
        $genders = ['Male' => 'Male', 'Female' => 'Female', 'All' => 'All Genders'];

        // Get schools with proper names
        $schools = $this->getSchools();

        // Get all subjects
        $subjects = Subject::select('id', 'PaperName')->orderBy('id')->get();

        // Default statistics (if no filters applied)
        $statistics = $this->calculateAdvancedStatistics([]);

        return view('itemGrading.grading-analytics', compact(
            'years',
            'levels',
            'categories',
            'genders',
            'schools',
            'subjects',
            'statistics'
        ));
    }

    /**
     * Process advanced filtering and return results
     */
    public function advancedFilter(Request $request)
    {
        $request->validate([
            'year' => 'nullable|string',
            'level' => 'nullable|string',
            'category' => 'nullable|string',
            'gender' => 'nullable|string',
            'school_number' => 'nullable|string',
            'subject_id' => 'nullable|integer',
            'min_percentage' => 'nullable|numeric|min:0|max:100',
            'max_percentage' => 'nullable|numeric|min:0|max:100',
            'sort_by' => 'nullable|string|in:percentage,total_marks,student_id',
            'sort_order' => 'nullable|string|in:asc,desc',
            'limit' => 'nullable|integer|min:1|max:1000',
        ]);

        // Build query for students with marks
        $query = $this->buildAdvancedFilterQuery($request);

        // Get results
        $results = $query->get();

        // Calculate statistics based on filtered results
        $statistics = $this->calculateAdvancedStatistics($results);

        // Get subject performance if a specific subject is selected
        $subjectPerformance = null;
        if ($request->subject_id) {
            $subjectPerformance = $this->getSubjectPerformance($request->subject_id, $results->pluck('student_id')->toArray());
        }

        // Get gender-based analysis
        $genderAnalysis = $this->getGenderAnalysis($results);

        // Get top/bottom performers
        $topPerformers = $results->take(10);
        $bottomPerformers = $results->sortBy('percentage')->take(10);

        // Get grade distribution
        $gradeDistribution = $this->getGradeDistribution($results);

        // Store filters for display
        $appliedFilters = $request->all();

        return response()->json([
            'success' => true,
            'results' => $results,
            'statistics' => $statistics,
            'subjectPerformance' => $subjectPerformance,
            'genderAnalysis' => $genderAnalysis,
            'topPerformers' => $topPerformers,
            'bottomPerformers' => $bottomPerformers,
            'gradeDistribution' => $gradeDistribution,
            'appliedFilters' => $appliedFilters
        ]);
    }

    /**
     * Get top performers with detailed analysis
     */
    public function topPerformers(Request $request)
    {
        $request->validate([
            'year' => 'nullable|string',
            'category' => 'nullable|string',
            'limit' => 'nullable|integer|min:1|max:500',
            'school_number' => 'nullable|string',
        ]);

        $limit = $request->limit ?? 50;

        // Build query
        $query = $this->buildBaseStudentPerformanceQuery($request);

        // Get top performers by percentage
        $topPerformers = $query->orderBy('percentage', 'desc')
            ->take($limit)
            ->get();

        // Get subject-wise breakdown for top performers
        foreach ($topPerformers as $student) {
            $student->subject_breakdown = $this->getStudentSubjectBreakdown($student->student_id);
        }

        // Calculate statistics for top performers
        $statistics = [
            'count' => $topPerformers->count(),
            'avg_percentage' => $topPerformers->avg('percentage'),
            'min_percentage' => $topPerformers->min('percentage'),
            'max_percentage' => $topPerformers->max('percentage'),
            'grade_distribution' => $topPerformers->groupBy('grade')->map->count(),
            'gender_distribution' => $topPerformers->groupBy('gender')->map->count(),
            'school_distribution' => $topPerformers->groupBy('school_name')->map->count(),
        ];

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'topPerformers' => $topPerformers,
                'statistics' => $statistics
            ]);
        }

        return view('itemGrading.top-performers', compact('topPerformers', 'statistics'));
    }

    /**
     * Subject-wise performance analysis
     */
    public function subjectAnalysis(Request $request)
    {
        $request->validate([
            'year' => 'nullable|string',
            'category' => 'nullable|string',
            'school_number' => 'nullable|string',
        ]);

        // Get all subjects
        $subjects = Subject::all();

        $subjectPerformance = [];

        foreach ($subjects as $subject) {
            $query = Mark::where('subject_id', $subject->id)
                ->join('class_allocations', 'marks.student_id', '=', 'class_allocations.Student_ID');

            // Apply filters
            if ($request->year) {
                $query->where('class_allocations.Student_ID', 'LIKE', "%-$request->year");
            }

            if ($request->category && $request->category !== 'All') {
                $query->where('class_allocations.Student_ID', 'LIKE', "%-$request->category-%");
            }

            if ($request->school_number) {
                $query->where('class_allocations.Student_ID', 'LIKE', "$request->school_number-%");
            }

            $marks = $query->pluck('mark');

            $subjectPerformance[$subject->id] = [
                'subject_name' => $subject->name,
                'subject_code' => $subject->code,
                'avg_mark' => $marks->avg(),
                'max_mark' => $marks->max(),
                'min_mark' => $marks->min(),
                'total_students' => $marks->count(),
                'pass_rate' => $marks->filter(function ($mark) {
                    return $mark >= 50; // Assuming pass mark is 50
                })->count() / max($marks->count(), 1) * 100,
                'distribution' => [
                    'A' => $marks->filter(fn($m) => $m >= 80)->count(),
                    'B' => $marks->filter(fn($m) => $m >= 70 && $m < 80)->count(),
                    'C' => $marks->filter(fn($m) => $m >= 60 && $m < 70)->count(),
                    'D' => $marks->filter(fn($m) => $m >= 50 && $m < 60)->count(),
                    'F' => $marks->filter(fn($m) => $m < 50)->count(),
                ]
            ];
        }

        // Sort subjects by average mark
        usort($subjectPerformance, function ($a, $b) {
            return $b['avg_mark'] <=> $a['avg_mark'];
        });

        // Get best and worst performing subjects
        $bestSubject = !empty($subjectPerformance) ? $subjectPerformance[0] : null;
        $worstSubject = !empty($subjectPerformance) ? end($subjectPerformance) : null;

        return view('itemGrading.subject-analysis', compact(
            'subjectPerformance',
            'bestSubject',
            'worstSubject'
        ));
    }

    /**
     * Gender-based performance analysis
     */
    public function genderAnalysis(Request $request)
    {
        $request->validate([
            'year' => 'nullable|string',
            'category' => 'nullable|string',
            'school_number' => 'nullable|string',
        ]);

        // Get students with their genders (assuming you have a students table with gender)
        // If not, you'll need to join with your student information table
        $maleStudents = $this->buildBaseStudentPerformanceQuery($request)
            ->where('students.Gender', 'Male')
            ->get();

        $femaleStudents = $this->buildBaseStudentPerformanceQuery($request)
            ->where('students.Gender', 'Female')
            ->get();

        $analysis = [
            'male' => [
                'count' => $maleStudents->count(),
                'avg_percentage' => $maleStudents->avg('percentage'),
                'max_percentage' => $maleStudents->max('percentage'),
                'min_percentage' => $maleStudents->min('percentage'),
                'grade_distribution' => $maleStudents->groupBy('grade')->map->count(),
                'top_performers' => $maleStudents->sortByDesc('percentage')->take(5)->values(),
            ],
            'female' => [
                'count' => $femaleStudents->count(),
                'avg_percentage' => $femaleStudents->avg('percentage'),
                'max_percentage' => $femaleStudents->max('percentage'),
                'min_percentage' => $femaleStudents->min('percentage'),
                'grade_distribution' => $femaleStudents->groupBy('grade')->map->count(),
                'top_performers' => $femaleStudents->sortByDesc('percentage')->take(5)->values(),
            ],
            'comparison' => [
                'avg_difference' => $femaleStudents->avg('percentage') - $maleStudents->avg('percentage'),
                'total_students' => $maleStudents->count() + $femaleStudents->count(),
                'male_percentage' => $maleStudents->count() / ($maleStudents->count() + $femaleStudents->count()) * 100,
                'female_percentage' => $femaleStudents->count() / ($maleStudents->count() + $femaleStudents->count()) * 100,
            ]
        ];

        // Subject-wise gender performance
        $subjectGenderPerformance = $this->getSubjectGenderPerformance($request);

        return view('itemGrading.gender-analysis', compact('analysis', 'subjectGenderPerformance'));
    }

    /**
     * Export analytics data to Excel/CSV
     */
    public function exportAnalytics(Request $request)
    {
        $type = $request->type ?? 'all'; // all, top-performers, subject-analysis, gender-analysis

        $query = $this->buildAdvancedFilterQuery($request);
        $results = $query->get();

        $filename = 'grading-analytics-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = ['Student ID', 'School', 'Category', 'Year', 'Gender', 'Total Marks', 'Percentage', 'Grade', 'Classification'];

        $callback = function () use ($results, $columns, $type) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($results as $row) {
                fputcsv($file, [
                    $row->student_id,
                    $row->school_name,
                    $row->category,
                    $row->year,
                    $row->gender ?? 'N/A',
                    $row->total_marks,
                    $row->percentage . '%',
                    $row->grade,
                    $row->classification,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ==================== HELPER METHODS ====================

    private function getAvailableYears()
    {
        return ClassAllocation::select('Student_ID')
            ->get()
            ->map(function ($item) {
                $parts = explode('-', $item->Student_ID);
                return end($parts);
            })
            ->unique()
            ->sort()
            ->values();
    }

    private function getSchools()
    {
        return ClassAllocation::select('Student_ID')
            ->get()
            ->map(function ($item) {
                $parts = explode('-', $item->Student_ID);
                return implode('-', array_slice($parts, 0, 2));
            })
            ->unique()
            ->filter()
            ->values()
            ->mapWithKeys(function ($item) {
                return [$item => Helper::schoolName($item) ?? $item];
            });
    }

    private function buildBaseStudentPerformanceQuery($request)
    {
        $subjectIds = $this->getSubjectIdsForCategory($request->category ?? 'TH');
        $totalPossibleMarks = count($subjectIds) * 100;

        return DB::table('class_allocations')
            ->leftJoin('students', 'class_allocations.Student_ID', '=', 'students.Student_ID')
            ->leftJoin('marks', 'class_allocations.Student_ID', '=', 'marks.student_id')
            ->select(
                'class_allocations.Student_ID as student_id',
                DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(class_allocations.Student_ID, '-', 2), '-', -1) as school_code"),
                DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(class_allocations.Student_ID, '-', -2), '-', 1) as category"),
                DB::raw("SUBSTRING_INDEX(class_allocations.Student_ID, '-', -1) as year"),
                'students.Gender as gender',
                DB::raw("SUM(marks.mark) as total_marks"),
                DB::raw("COUNT(marks.id) as subjects_attempted"),
                DB::raw("(SUM(marks.mark) / $totalPossibleMarks * 100) as percentage"),
                DB::raw("CASE 
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 80 THEN 'D1'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 75 THEN 'D2'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 70 THEN 'C3'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 65 THEN 'C4'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 60 THEN 'C5'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 55 THEN 'C6'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 50 THEN 'P7'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 45 THEN 'P8'
                    ELSE 'F9'
                END as grade")
            )
            ->whereIn('marks.subject_id', $subjectIds)
            ->groupBy('class_allocations.Student_ID', 'students.Gender');
    }

    private function buildAdvancedFilterQuery($request)
    {
        $subjectIds = $this->getSubjectIdsForCategory($request->category ?? 'TH');
        $totalPossibleMarks = count($subjectIds) * 100;

        $query = DB::table('class_allocations')
            ->leftJoin('students', 'class_allocations.Student_ID', '=', 'students.Student_ID')
            ->leftJoin('marks', 'class_allocations.Student_ID', '=', 'marks.student_id')
            ->select(
                'class_allocations.Student_ID as student_id',
                DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(class_allocations.Student_ID, '-', 2), '-', -1) as school_code"),
                DB::raw("CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(class_allocations.Student_ID, '-', 2), '-', -1), '-', 
                         SUBSTRING_INDEX(SUBSTRING_INDEX(class_allocations.Student_ID, '-', -2), '-', 1)) as school_category"),
                DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(class_allocations.Student_ID, '-', -2), '-', 1) as category"),
                DB::raw("SUBSTRING_INDEX(class_allocations.Student_ID, '-', -1) as year"),
                'students.Gender as gender',
                DB::raw("SUM(marks.mark) as total_marks"),
                DB::raw("COUNT(marks.id) as subjects_attempted"),
                DB::raw("(SUM(marks.mark) / $totalPossibleMarks * 100) as percentage"),
                DB::raw("CASE 
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 80 THEN 'D1'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 75 THEN 'D2'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 70 THEN 'C3'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 65 THEN 'C4'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 60 THEN 'C5'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 55 THEN 'C6'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 50 THEN 'P7'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 45 THEN 'P8'
                    ELSE 'F9'
                END as grade"),
                DB::raw("CASE 
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 70 THEN 'FIRST CLASS'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 60 THEN 'SECOND CLASS UPPER'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 50 THEN 'SECOND CLASS LOWER'
                    WHEN (SUM(marks.mark) / $totalPossibleMarks * 100) >= 40 THEN 'PASS'
                    ELSE 'FAIL'
                END as classification"),
                DB::raw("(SELECT COUNT(*) FROM marks m2 WHERE m2.student_id = class_allocations.Student_ID AND m2.mark >= 50) as subjects_passed")
            )
            ->whereIn('marks.subject_id', $subjectIds);

        // Apply filters
        if ($request->year && $request->year !== 'All') {
            $query->where('class_allocations.Student_ID', 'LIKE', "%-$request->year");
        }

        if ($request->category && $request->category !== 'All') {
            $query->where('class_allocations.Student_ID', 'LIKE', "%-$request->category-%");
        }

        if ($request->school_number) {
            $query->where('class_allocations.Student_ID', 'LIKE', "$request->school_number-%");
        }

        if ($request->gender && $request->gender !== 'All') {
            $query->where('students.Gender', $request->gender);
        }

        // Subject-specific filter
        if ($request->subject_id) {
            $query->where('marks.subject_id', $request->subject_id);
        }

        // Percentage range filter
        if ($request->min_percentage) {
            $query->having('percentage', '>=', $request->min_percentage);
        }

        if ($request->max_percentage) {
            $query->having('percentage', '<=', $request->max_percentage);
        }

        $query->groupBy('class_allocations.Student_ID', 'students.Gender');

        // Sorting
        $sortBy = $request->sort_by ?? 'percentage';
        $sortOrder = $request->sort_order ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        // Limit
        if ($request->limit) {
            $query->limit($request->limit);
        }

        return $query;
    }

    private function calculateAdvancedStatistics($results)
    {
        if (is_array($results)) {
            $results = collect($results);
        }

        if ($results->isEmpty()) {
            return [
                'total_students' => 0,
                'avg_percentage' => 0,
                'max_percentage' => 0,
                'min_percentage' => 0,
                'total_marks_sum' => 0,
                'avg_marks' => 0,
                'pass_rate' => 0,
                'grade_distribution' => [],
                'classification_distribution' => []
            ];
        }

        return [
            'total_students' => $results->count(),
            'avg_percentage' => round($results->avg('percentage'), 2),
            'max_percentage' => round($results->max('percentage'), 2),
            'min_percentage' => round($results->min('percentage'), 2),
            'total_marks_sum' => $results->sum('total_marks'),
            'avg_marks' => round($results->avg('total_marks'), 2),
            'pass_rate' => round($results->filter(function ($item) {
                return $item['percentage'] >= 50;
            })->count() / $results->count() * 100, 2),
            'grade_distribution' => $results->groupBy('grade')->map->count(),
            'classification_distribution' => $results->groupBy('classification')->map->count()
        ];
    }

    private function getSubjectPerformance($subjectId, $studentIds)
    {
        return Mark::where('subject_id', $subjectId)
            ->whereIn('student_id', $studentIds)
            ->selectRaw('AVG(mark) as avg_mark, MAX(mark) as max_mark, MIN(mark) as min_mark, COUNT(*) as total')
            ->first();
    }

    private function getGenderAnalysis($results)
    {
        $maleResults = $results->where('gender', 'Male');
        $femaleResults = $results->where('gender', 'Female');

        return [
            'male' => [
                'count' => $maleResults->count(),
                'avg_percentage' => $maleResults->avg('percentage'),
                'max_percentage' => $maleResults->max('percentage'),
            ],
            'female' => [
                'count' => $femaleResults->count(),
                'avg_percentage' => $femaleResults->avg('percentage'),
                'max_percentage' => $femaleResults->max('percentage'),
            ],
            'gap' => $femaleResults->avg('percentage') - $maleResults->avg('percentage')
        ];
    }

    private function getGradeDistribution($results)
    {
        $grades = ['D1', 'D2', 'C3', 'C4', 'C5', 'C6', 'P7', 'P8', 'F9'];
        $distribution = [];

        foreach ($grades as $grade) {
            $distribution[$grade] = $results->where('grade', $grade)->count();
        }

        return $distribution;
    }

    private function getStudentSubjectBreakdown($studentId)
    {
        return Mark::where('student_id', $studentId)
            ->join('subjects', 'marks.subject_id', '=', 'subjects.id')
            ->select('subjects.name as subject_name', 'marks.mark')
            ->get();
    }

    private function getSubjectGenderPerformance($request)
    {
        $subjects = Subject::all();
        $analysis = [];

        foreach ($subjects as $subject) {
            $maleMarks = Mark::where('subject_id', $subject->id)
                ->join('students', 'marks.student_id', '=', 'students.Student_ID')
                ->where('students.Gender', 'Male');

            $femaleMarks = Mark::where('subject_id', $subject->id)
                ->join('students', 'marks.student_id', '=', 'students.Student_ID')
                ->where('students.Gender', 'Female');

            // Apply year/category filters if provided
            if ($request->year) {
                $maleMarks->where('marks.student_id', 'LIKE', "%-$request->year");
                $femaleMarks->where('marks.student_id', 'LIKE', "%-$request->year");
            }

            $analysis[$subject->id] = [
                'subject_name' => $subject->name,
                'male_avg' => $maleMarks->avg('mark'),
                'female_avg' => $femaleMarks->avg('mark'),
                'male_count' => $maleMarks->count(),
                'female_count' => $femaleMarks->count(),
                'gap' => $femaleMarks->avg('mark') - $maleMarks->avg('mark')
            ];
        }

        return $analysis;
    }

    private function getSubjectIdsForCategory($category)
    {
        // Implement this based on your subject-category mapping
        // This is a placeholder - adjust according to your database structure
        return Subject::where('category', $category)->pluck('id')->toArray();
    }


    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

}
