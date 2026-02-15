<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\House;
use App\Models\MasterData;
use App\Models\ClassAllocation;
use Illuminate\Http\Request;
use App\Models\Grading;
use App\Models\StudentResult;
use App\Http\Controllers\Helper;
use Illuminate\Support\Facades\DB;

class ItebController extends Controller
{

    public function searchItebStudents(Request $request)
    {
        return view('itemGrading.marks');
    }

    // public function filter(Request $request)
    // {
    //     $thanawiPapers = MasterData::where(
    //         'md_master_code_id',
    //         config('constants.options.ThanawiPapers')
    //     )->get();

    //     $idaadPapers = MasterData::where(
    //         'md_master_code_id',
    //         config('constants.options.IdaadPapers')
    //     )->get();

    //     $year = $request->year;
    //     $category = $request->category;
    //     $schoolNumber = $request->school_number;

    //     $records = ClassAllocation::where('Student_ID', 'LIKE', "%$schoolNumber%")
    //         ->where('Student_ID', 'LIKE', "%-$category-%")
    //         ->where('Student_ID', 'LIKE', "%-$year")
    //         ->select('Student_ID')
    //         ->distinct()
    //         ->get();

    //     $schoolName = Helper::schoolName($schoolNumber);

    //     // Decide which subjectsubjects to use
    //     $subjects = ($category == 'TH') ? $thanawiPapers : $idaadPapers;

    //     // Get existing marks for the first subject by default (optional)
    //     $existingMarks = [];
    //     if ($subjects->isNotEmpty()) {
    //         $firstSubject = $subjects->first();
    //         $existingMarks = Mark::whereIn('student_id', $records->pluck('Student_ID'))
    //             ->where('subject_id', $firstSubject->id)
    //             ->pluck('mark', 'student_id')
    //             ->toArray();
    //     }

    //     return view('itemGrading.results', compact(
    //         'records',
    //         'year',
    //         'category',
    //         'schoolNumber',
    //         'schoolName',
    //         'subjects',
    //         'existingMarks'
    //     ));
    // }


    public function filter(Request $request)
    {
        $thanawiPapers = MasterData::where(
            'md_master_code_id',
            config('constants.options.ThanawiPapers')
        )->get();

        $idaadPapers = MasterData::where(
            'md_master_code_id',
            config('constants.options.IdaadPapers')
        )->get();

        $year = $request->year;
        $category = $request->category;
        $schoolNumber = $request->school_number;

        $records = ClassAllocation::where('Student_ID', 'LIKE', "%$schoolNumber%")
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->select('Student_ID')
            ->distinct()
            ->get();

        $schoolName = Helper::schoolName($schoolNumber);

        // Decide which subjects to use
        $subjects = ($category == 'TH') ? $thanawiPapers : $idaadPapers;

        // Get existing marks for ALL subjects (not just first one)
        $existingMarks = [];
        if ($subjects->isNotEmpty() && $records->isNotEmpty()) {
            $allMarks = Mark::whereIn('student_id', $records->pluck('Student_ID'))
                ->whereIn('subject_id', $subjects->pluck('md_id'))
                ->get();

            foreach ($allMarks as $mark) {
                $existingMarks[$mark->subject_id][$mark->student_id] = $mark->mark;
            }
        }

      
        return view('itemGrading.results', compact(
            'records',
            'year',
            'category',
            'schoolNumber',
            'schoolName',
            'subjects',
            'existingMarks'
        ));
    }

    public function getMarksForSubject(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:master_datas,md_id',
            'student_ids' => 'required|array',
        ]);

        $existingMarks = Mark::whereIn('student_id', $request->student_ids)
            ->where('subject_id', $request->subject_id)
            ->pluck('mark', 'student_id')
            ->toArray();

        return response()->json([
            'success' => true,
            'marks' => $existingMarks
        ]);
    }

    public function getSubjectMarks(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:master_datas,md_id',
            'student_ids' => 'required|array',
        ]);

        $marks = Mark::whereIn('student_id', $request->student_ids)
            ->where('subject_id', $request->subject_id)
            ->pluck('mark', 'student_id');

        return response()->json([
            'success' => true,
            'marks' => $marks
        ]);
    }

    public function enterMarks(Request $request)
    {
        $houses = House::all();

        return view('itemGrading.enterMarks', compact('houses'));
    }

    // public function saveMarks(Request $request)
    // {

    //     $request->validate([
    //         'subject_id' => 'required|exists:master_datas,md_id',
    //         'marks' => 'required|array',
    //         'marks.*' => 'required|numeric|min:0|max:100',
    //     ], [
    //         'subject_id.required' => 'Please select a subject before submitting.',
    //         'marks.*.required' => 'All students must have a mark.',
    //         'marks.*.numeric' => 'Marks must be numbers.',
    //         'marks.*.min' => 'Marks cannot be less than 0.',
    //         'marks.*.max' => 'Marks cannot exceed 100.',
    //     ]);

    //     $subjectId = $request->input('subject_id');
    //     $marks = $request->input('marks');
    //     $students = $request->input('students');

    //     $missing = array_diff($students, array_keys($marks));
    //     if (!empty($missing)) {
    //         return back()->withErrors([
    //             'marks' => 'Missing marks for students: ' . implode(', ', $missing)
    //         ])->withInput();
    //     }

    //     foreach ($marks as $studentKey => $mark) {
    //         $parts = explode('-', $studentKey);
    //         $year = array_pop($parts);
    //         $school_number = implode('-', array_slice($parts, 0, 2));
    //         $category = implode('-', array_slice($parts, 2));

    //         Mark::updateOrCreate(
    //             [
    //                 'student_id' => $studentKey,
    //                 'subject_id' => $subjectId,
    //             ],
    //             [
    //                 'mark' => $mark,
    //                 'year' => $year,
    //                 'category' => $category,
    //                 'school_number' => $school_number
    //             ]
    //         );
    //     }

    //     return redirect()->back()->with('success', 'Marks submitted successfully for ' . count($marks) . ' students!');
    // }


    public function saveMarks(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:master_datas,md_id',
            'marks' => 'required|array',
            'marks.*' => 'required|numeric|min:0|max:100',
        ], [
            'subject_id.required' => 'Please select a subject before submitting.',
            'marks.*.required' => 'All students must have a mark.',
            'marks.*.numeric' => 'Marks must be numbers.',
            'marks.*.min' => 'Marks cannot be less than 0.',
            'marks.*.max' => 'Marks cannot exceed 100.',
        ]);

        $subjectId = $request->input('subject_id');
        $marks = $request->input('marks');
        $students = $request->input('students');

        $missing = array_diff($students, array_keys($marks));
        if (!empty($missing)) {
            return back()->withErrors([
                'marks' => 'Missing marks for students: ' . implode(', ', $missing)
            ])->withInput();
        }

        foreach ($marks as $studentKey => $mark) {
            $parts = explode('-', $studentKey);
            $year = array_pop($parts);
            $school_number = implode('-', array_slice($parts, 0, 2));
            $category = implode('-', array_slice($parts, 2));

            Mark::updateOrCreate(
                [
                    'student_id' => $studentKey,
                    'subject_id' => $subjectId,
                ],
                [
                    'mark' => $mark,
                    'year' => $year,
                    'category' => $category,
                    'school_number' => $school_number
                ]
            );
        }

        return redirect()->back()->with('success', 'Marks submitted successfully for subject!');
    }

    public function gradingSummary(Request $request)
    {
        // Get distinct years from marks or class allocations
        $years = ClassAllocation::select('Student_ID')
            ->get()
            ->map(function ($item) {
                $parts = explode('-', $item->Student_ID);
                return end($parts);
            })
            ->unique()
            ->sort()
            ->values();

        // Get categories
        $categories = ['TH' => 'Thanawi', 'ID' => 'Idaad'];

        $schools = ClassAllocation::select('Student_ID')
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


        // dd($schools);
        return view('itemGrading.grading-summary', compact('years', 'categories', 'schools'));
    }

    /**
     * Process and display grading results
     */
    public function processGrading(Request $request)
    {

        $request->validate([
            'year' => 'required',
            'category' => 'required',
            'school_number' => 'nullable',
        ]);

        $year = $request->year;
        $category = $request->category;
        $schoolNumber = $request->school_number;
        $level = $request->level ?? 'A'; // Default to 'A' level

        // Build query for students
        $studentsQuery = ClassAllocation::select('Student_ID')
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct();

        if ($schoolNumber) {
            $studentsQuery->where('Student_ID', 'LIKE', "$schoolNumber-%");
        }

        $students = $studentsQuery->pluck('Student_ID');

        // Get subjects for this category
        $subjectIds = $this->getSubjectIdsForCategory($category);

        // Get total possible marks (each subject out of 100)
        $totalPossibleMarks = count($subjectIds) * 100;

        // Get all marks for these students and subjects
        $marks = Mark::whereIn('student_id', $students)
            ->whereIn('subject_id', $subjectIds)
            ->get()
            ->groupBy('student_id');

        // Calculate results for each student
        $results = [];
        foreach ($students as $studentId) {
            $studentMarks = $marks->get($studentId, collect());

            $totalMarks = $studentMarks->sum('mark');
            $subjectsAttempted = $studentMarks->count();

            // Calculate percentage based on total possible marks for category
            $percentage = $totalPossibleMarks > 0
                ? round(($totalMarks / $totalPossibleMarks) * 100, 2)
                : 0;

            // Get grade (D1, D2, C3, C4, F)
            $gradeModel = Grading::getGrade($percentage, 'Marks', $level);

            // Get classification (FIRST CLASS, SECOND CLASS UPPER, etc.)
            $classificationModel = Grading::getGrade($percentage, 'Points', $level);

            $results[$studentId] = [
                'student_id' => $studentId,
                'total_marks' => $totalMarks,
                'total_possible' => $totalPossibleMarks,
                'subjects_attempted' => $subjectsAttempted,
                'total_subjects' => count($subjectIds),
                'percentage' => $percentage,
                'grade' => $gradeModel->Grade ?? 'N/A',
                'grade_comment' => $gradeModel->Comment ?? '',
                'classification' => $classificationModel->Grade ?? 'N/A',
                'classification_comment' => $classificationModel->Comment ?? '',
                'level' => $level,
                'marks_details' => $studentMarks,
            ];
        }

        // Sort results by percentage descending
        uasort($results, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        // Get statistics
        $statistics = $this->calculateStatistics($results, $level);

        $schoolName = $schoolNumber ? Helper::schoolName($schoolNumber) : 'All Schools';

        return view('itemGrading.grading-results', compact(
            'results',
            'year',
            'category',
            'schoolNumber',
            'schoolName',
            'statistics',
            'level',
            'totalPossibleMarks'
        ));
    }

    /**
     * Save computed results to database
     */
    public function saveGradingResults(Request $request)
    {
        $request->validate([
            'results' => 'required|array',
            'year' => 'required',
            'category' => 'required',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->results as $studentId => $data) {
                StudentResult::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'year' => $request->year,
                        'category' => $request->category,
                    ],
                    [
                        'school_number' => $request->school_number,
                        'total_marks' => $data['total_marks'],
                        'percentage' => $data['percentage'],
                        'grade' => $data['grade'],
                        'classification' => $data['classification'],
                        'level' => $request->level ?? 'A',
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Grading results saved successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error saving results: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get subject IDs for a category
     */
    private function getSubjectIdsForCategory($category)
    {
        $masterCodeId = ($category == 'TH')
            ? config('constants.options.ThanawiPapers')
            : config('constants.options.IdaadPapers');

        return MasterData::where('md_master_code_id', $masterCodeId)
            ->pluck('md_id')
            ->toArray();
    }

    /**
     * Calculate statistics from results
     */
    private function calculateStatistics($results, $level = 'A')
    {
        $count = count($results);

        if ($count == 0) {
            return [
                'count' => 0,
                'average' => 0,
                'highest' => 0,
                'lowest' => 0,
                'grade_distribution' => [],
                'class_distribution' => [],
            ];
        }

        $percentages = array_column($results, 'percentage');

        // Get grade distribution
        $grades = Grading::marks($level)->get();
        $gradeDistribution = [];
        foreach ($grades as $grade) {
            $gradeDistribution[$grade->Grade] = 0;
        }

        $classDistribution = [];
        $classes = Grading::points($level)->get();
        foreach ($classes as $class) {
            $classDistribution[$class->Grade] = 0;
        }

        foreach ($results as $result) {
            if (isset($gradeDistribution[$result['grade']])) {
                $gradeDistribution[$result['grade']]++;
            }
            if (isset($classDistribution[$result['classification']])) {
                $classDistribution[$result['classification']]++;
            }
        }

        return [
            'count' => $count,
            'average' => round(array_sum($percentages) / $count, 2),
            'highest' => max($percentages),
            'lowest' => min($percentages),
            'grade_distribution' => $gradeDistribution,
            'class_distribution' => $classDistribution,
        ];
    }

    /**
     * Export results to PDF/Excel
     */
    public function exportGrading(Request $request)
    {
        // You can implement PDF/Excel export here
        // Using packages like barryvdh/laravel-dompdf or maatwebsite/excel
    }


    public function analyticsDashboard(Request $request)
    {
        // Get all available years from marks table
        $years = ClassAllocation::select('Student_ID')
            ->get()
            ->map(function ($item) {
                $parts = explode('-', $item->Student_ID);
                return end($parts);
            })
            ->unique()
            ->sort()
            ->values();

        // Get categories
        $categories = [
            'TH' => 'Thanawi',
            'ID' => 'Idaad'
        ];


        $schools = ClassAllocation::select('Student_ID')
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

        // Get quick stats for dashboard
        $quickStats = $this->getQuickStats();

        return view('itemGrading.analytics.dashboard', compact(
            'years',
            'categories',
            'schools',
            'quickStats'
        ));
    }

    /**
     * Get school ranking based on performance
     */
    public function getSchoolRanking(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'category' => 'required',
            'level' => 'nullable|in:A,O'
        ]);

        $year = $request->year;
        $category = $request->category;
        $level = $request->level ?? 'A';

        // Get all students for this year and category
        $studentsQuery = ClassAllocation::select('Student_ID')
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year");

        if ($request->school_number) {
            $studentsQuery->where('Student_ID', 'LIKE', $request->school_number . '-%');
        }

        $students = $studentsQuery->pluck('Student_ID');

        // Get results for these students
        $results = StudentResult::whereIn('student_id', $students)
            ->where('year', $year)
            ->where('category', $category)
            ->where('level', $level)
            ->get();

        // Group by school and calculate statistics
        $schoolStats = [];
        foreach ($results as $result) {
            $schoolNumber = explode('-', $result->student_id)[0];

            if (!isset($schoolStats[$schoolNumber])) {
                $schoolStats[$schoolNumber] = [
                    'school_code' => $schoolNumber,
                    'school_name' => Helper::schoolName($schoolNumber) ?? "School {$schoolNumber}",
                    'total_students' => 0,
                    'total_marks' => 0,
                    'average_percentage' => 0,
                    'grades' => [],
                    'classifications' => [],
                    'students' => []
                ];
            }

            $schoolStats[$schoolNumber]['total_students']++;
            $schoolStats[$schoolNumber]['total_marks'] += $result->percentage;
            $schoolStats[$schoolNumber]['grades'][$result->grade] =
                ($schoolStats[$schoolNumber]['grades'][$result->grade] ?? 0) + 1;
            $schoolStats[$schoolNumber]['classifications'][$result->classification] =
                ($schoolStats[$schoolNumber]['classifications'][$result->classification] ?? 0) + 1;
            $schoolStats[$schoolNumber]['students'][] = [
                'id' => $result->student_id,
                'percentage' => $result->percentage,
                'grade' => $result->grade,
                'classification' => $result->classification
            ];
        }

        // Calculate averages and sort
        foreach ($schoolStats as &$stats) {
            $stats['average_percentage'] = $stats['total_students'] > 0
                ? round($stats['total_marks'] / $stats['total_students'], 2)
                : 0;

            // Calculate pass rate (percentage of students with grade >= C4 or classification not FAIL)
            $passed = 0;
            foreach ($stats['students'] as $student) {
                if (!in_array($student['classification'], ['FAIL', 'F'])) {
                    $passed++;
                }
            }
            $stats['pass_rate'] = $stats['total_students'] > 0
                ? round(($passed / $stats['total_students']) * 100, 2)
                : 0;
        }

        // Sort by average percentage descending
        usort($schoolStats, function ($a, $b) {
            return $b['average_percentage'] <=> $a['average_percentage'];
        });

        // Add rankings
        foreach ($schoolStats as $index => &$stats) {
            $stats['rank'] = $index + 1;
        }

        // Get previous year data for comparison
        $prevYearData = $this->getPreviousYearComparison($year, $category, $level, array_keys($schoolStats));

        return response()->json([
            'success' => true,
            'data' => $schoolStats,
            'previous_year' => $prevYearData,
            'summary' => [
                'total_schools' => count($schoolStats),
                'total_students' => $results->count(),
                'average_across_schools' => count($schoolStats) > 0
                    ? round(array_sum(array_column($schoolStats, 'average_percentage')) / count($schoolStats), 2)
                    : 0,
                'top_school' => $schoolStats[0]['school_name'] ?? 'N/A',
                'top_school_score' => $schoolStats[0]['average_percentage'] ?? 0
            ]
        ]);
    }

    /**
     * Get student ranking (top performers)
     */
    public function getStudentRanking(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'category' => 'required',
            'limit' => 'nullable|integer|min:1|max:500'
        ]);

        $year = $request->year;
        $category = $request->category;
        $level = $request->level ?? 'A';
        $limit = $request->limit ?? 100;
        $schoolNumber = $request->school_number;

        // Build query
        $query = StudentResult::where('year', $year)
            ->where('category', $category)
            ->where('level', $level);

        if ($schoolNumber) {
            $query->where('school_number', $schoolNumber);
        }

        // Get top students
        $topStudents = $query->orderBy('percentage', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item, $index) {
                $schoolNumber = explode('-', $item->student_id)[0];
                return [
                    'rank' => $index + 1,
                    'student_id' => $item->student_id,
                    'school' => Helper::schoolName($schoolNumber) ?? $schoolNumber,
                    'percentage' => $item->percentage,
                    'grade' => $item->grade,
                    'classification' => $item->classification,
                    'total_marks' => $item->total_marks
                ];
            });

        // Get bottom students
        $bottomStudents = StudentResult::where('year', $year)
            ->where('category', $category)
            ->where('level', $level)
            ->where('percentage', '>', 0)
            ->orderBy('percentage', 'asc')
            ->limit(min(50, $limit))
            ->get()
            ->map(function ($item, $index) {
                $schoolNumber = explode('-', $item->student_id)[0];
                return [
                    'rank' => $index + 1,
                    'student_id' => $item->student_id,
                    'school' => Helper::schoolName($schoolNumber) ?? $schoolNumber,
                    'percentage' => $item->percentage,
                    'grade' => $item->grade,
                    'classification' => $item->classification,
                    'total_marks' => $item->total_marks
                ];
            });

        // Get statistics
        $stats = [
            'total_students' => StudentResult::where('year', $year)
                ->where('category', $category)
                ->where('level', $level)
                ->count(),
            'average_percentage' => StudentResult::where('year', $year)
                ->where('category', $category)
                ->where('level', $level)
                ->avg('percentage'),
            'highest_score' => StudentResult::where('year', $year)
                ->where('category', $category)
                ->where('level', $level)
                ->max('percentage'),
            'lowest_score' => StudentResult::where('year', $year)
                ->where('category', $category)
                ->where('level', $level)
                ->min('percentage')
        ];

        return response()->json([
            'success' => true,
            'top_students' => $topStudents,
            'bottom_students' => $bottomStudents,
            'statistics' => $stats
        ]);
    }

    /**
     * Get subject-wise analysis
     */
    public function getSubjectAnalysis(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'category' => 'required'
        ]);

        $year = $request->year;
        $category = $request->category;
        $schoolNumber = $request->school_number;

        // Get subjects for this category
        $subjectIds = $this->getSubjectIdsForCategory($category);

        // Get all students for this year/category
        $studentsQuery = ClassAllocation::select('Student_ID')
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year");

        if ($schoolNumber) {
            $studentsQuery->where('Student_ID', 'LIKE', $schoolNumber . '-%');
        }

        $students = $studentsQuery->pluck('Student_ID');

        // Get marks for all subjects
        $marks = Mark::whereIn('student_id', $students)
            ->whereIn('subject_id', $subjectIds)
            ->with('subject')
            ->get()
            ->groupBy('subject_id');

        $subjectAnalysis = [];
        foreach ($subjectIds as $subjectId) {
            $subjectMarks = $marks->get($subjectId, collect());

            if ($subjectMarks->isEmpty()) {
                continue;
            }

            $marksValues = $subjectMarks->pluck('mark')->toArray();

            $analysis = [
                'subject_id' => $subjectId,
                'subject_name' => $subjectMarks->first()->subject->md_name ?? 'Unknown',
                'total_students' => $subjectMarks->count(),
                'average_mark' => round($subjectMarks->avg('mark'), 2),
                'highest_mark' => max($marksValues),
                'lowest_mark' => min($marksValues),
                'median_mark' => $this->calculateMedian($marksValues),
                'std_deviation' => $this->calculateStdDev($marksValues),
                'pass_count' => $subjectMarks->where('mark', '>=', 50)->count(),
                'fail_count' => $subjectMarks->where('mark', '<', 50)->count(),
                'pass_rate' => round(($subjectMarks->where('mark', '>=', 50)->count() / $subjectMarks->count()) * 100, 2),
                'grade_distribution' => $this->getMarkGradeDistribution($subjectMarks->pluck('mark')->toArray())
            ];

            $subjectAnalysis[] = $analysis;
        }

        // Sort by average mark descending
        usort($subjectAnalysis, function ($a, $b) {
            return $b['average_mark'] <=> $a['average_mark'];
        });

        // Get best and worst subjects
        $bestSubjects = array_slice($subjectAnalysis, 0, 5);
        $worstSubjects = array_slice(array_reverse($subjectAnalysis), 0, 5);

        return response()->json([
            'success' => true,
            'all_subjects' => $subjectAnalysis,
            'best_subjects' => $bestSubjects,
            'worst_subjects' => $worstSubjects,
            'summary' => [
                'total_subjects' => count($subjectAnalysis),
                'overall_average' => count($subjectAnalysis) > 0
                    ? round(array_sum(array_column($subjectAnalysis, 'average_mark')) / count($subjectAnalysis), 2)
                    : 0,
                'best_subject' => $bestSubjects[0]['subject_name'] ?? 'N/A',
                'best_subject_score' => $bestSubjects[0]['average_mark'] ?? 0,
                'worst_subject' => $worstSubjects[0]['subject_name'] ?? 'N/A',
                'worst_subject_score' => $worstSubjects[0]['average_mark'] ?? 0
            ]
        ]);
    }

    /**
     * Get year-over-year comparison
     */
    public function getYearComparison(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'years' => 'required|array|min:2|max:5'
        ]);

        $category = $request->category;
        $years = $request->years;
        $level = $request->level ?? 'A';
        $schoolNumber = $request->school_number;

        $comparison = [];
        $trends = [];

        foreach ($years as $year) {
            $query = StudentResult::where('year', $year)
                ->where('category', $category)
                ->where('level', $level);

            if ($schoolNumber) {
                $query->where('school_number', $schoolNumber);
            }

            $results = $query->get();

            $yearData = [
                'year' => $year,
                'total_students' => $results->count(),
                'average_percentage' => $results->avg('percentage') ?? 0,
                'highest_percentage' => $results->max('percentage') ?? 0,
                'lowest_percentage' => $results->min('percentage') ?? 0,
                'grade_distribution' => $results->groupBy('grade')->map->count(),
                'classification_distribution' => $results->groupBy('classification')->map->count(),
                'pass_rate' => $results->whereNotIn('classification', ['FAIL', 'F'])->count() / max($results->count(), 1) * 100
            ];

            $comparison[] = $yearData;
        }

        // Calculate trends
        for ($i = 1; $i < count($comparison); $i++) {
            $current = $comparison[$i];
            $previous = $comparison[$i - 1];

            $trends[] = [
                'from_year' => $previous['year'],
                'to_year' => $current['year'],
                'average_change' => round($current['average_percentage'] - $previous['average_percentage'], 2),
                'student_count_change' => $current['total_students'] - $previous['total_students'],
                'pass_rate_change' => round($current['pass_rate'] - $previous['pass_rate'], 2)
            ];
        }

        return response()->json([
            'success' => true,
            'comparison' => $comparison,
            'trends' => $trends,
            'summary' => [
                'best_year' => collect($comparison)->sortByDesc('average_percentage')->first()['year'] ?? null,
                'best_year_avg' => collect($comparison)->max('average_percentage') ?? 0,
                'worst_year' => collect($comparison)->sortBy('average_percentage')->first()['year'] ?? null,
                'worst_year_avg' => collect($comparison)->min('average_percentage') ?? 0,
                'overall_trend' => $this->calculateOverallTrend($comparison)
            ]
        ]);
    }

    /**
     * Export analytics report
     */
    public function exportAnalyticsReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:school,student,subject,year',
            'format' => 'required|in:excel,pdf,csv',
            'year' => 'required',
            'category' => 'required'
        ]);

        // Generate report based on type
        $data = [];
        $filename = "report_{$request->report_type}_{$request->year}_{$request->category}";

        switch ($request->report_type) {
            case 'school':
                $response = $this->getSchoolRanking($request);
                $data = $response->getData()->data;
                $filename .= "_school_ranking";
                break;
            case 'student':
                $response = $this->getStudentRanking($request);
                $data = $response->getData();
                $filename .= "_student_performance";
                break;
            case 'subject':
                $response = $this->getSubjectAnalysis($request);
                $data = $response->getData();
                $filename .= "_subject_analysis";
                break;
            case 'year':
                $years = [$request->year, $request->year - 1, $request->year - 2];
                $request->merge(['years' => $years]);
                $response = $this->getYearComparison($request);
                $data = $response->getData();
                $filename .= "_year_comparison";
                break;
        }

        // Store data in session for download
        // session(['report_data' => $data, 'report_format' => $request->format, 'filename' => $filename]);

        return response()->json([
            'success' => true,
            'message' => 'Report generated successfully',
            // 'download_url' => route('iteb.analytics.download', ['format' => $request->format])
        ]);
    }

    /**
     * Download generated report
     */
    public function downloadReport($format)
    {
        $data = session('report_data');
        $filename = session('filename') . '.' . ($format == 'excel' ? 'xlsx' : $format);

        if (!$data) {
            return redirect()->back()->with('error', 'No report data found');
        }

        // Generate file based on format
        switch ($format) {
            case 'excel':
                return $this->generateExcelReport($data, $filename);
            case 'csv':
                return $this->generateCsvReport($data, $filename);
            case 'pdf':
                return $this->generatePdfReport($data, $filename);
            default:
                return redirect()->back()->with('error', 'Invalid format');
        }
    }

    /**
     * Helper function to get quick stats for dashboard
     */
    private function getQuickStats()
    {
        $currentYear = date('Y');

        return [
            'total_students' => StudentResult::count(),
            'total_schools' => StudentResult::distinct('school_number')->count('school_number'),
            'average_score' => round(StudentResult::avg('percentage') ?? 0, 2),
            'this_year_students' => StudentResult::where('year', $currentYear)->count(),
            'top_performer' => StudentResult::orderBy('percentage', 'desc')->first(),
            'pass_rate' => round((StudentResult::whereNotIn('classification', ['FAIL', 'F'])->count() / max(StudentResult::count(), 1)) * 100, 2)
        ];
    }

    /**
     * Helper function for previous year comparison
     */
    private function getPreviousYearComparison($currentYear, $category, $level, $schools)
    {
        $prevYear = $currentYear - 1;

        $prevData = StudentResult::where('year', $prevYear)
            ->where('category', $category)
            ->where('level', $level)
            ->whereIn('school_number', $schools)
            ->get()
            ->groupBy('school_number')
            ->map(function ($items) {
                return [
                    'average' => $items->avg('percentage'),
                    'count' => $items->count()
                ];
            });

        return $prevData;
    }

    /**
     * Calculate median
     */
    private function calculateMedian($arr)
    {
        sort($arr);
        $count = count($arr);
        $middle = floor($count / 2);

        if ($count % 2) {
            return $arr[$middle];
        }

        return ($arr[$middle - 1] + $arr[$middle]) / 2;
    }

    /**
     * Calculate standard deviation
     */
    private function calculateStdDev($arr)
    {
        $avg = array_sum($arr) / count($arr);
        $variance = 0;

        foreach ($arr as $value) {
            $variance += pow($value - $avg, 2);
        }

        return round(sqrt($variance / count($arr)), 2);
    }

    /**
     * Get grade distribution for marks
     */
    private function getMarkGradeDistribution($marks)
    {
        $distribution = [
            'A (80-100)' => 0,
            'B (70-79)' => 0,
            'C (60-69)' => 0,
            'D (50-59)' => 0,
            'F (0-49)' => 0
        ];

        foreach ($marks as $mark) {
            if ($mark >= 80) $distribution['A (80-100)']++;
            elseif ($mark >= 70) $distribution['B (70-79)']++;
            elseif ($mark >= 60) $distribution['C (60-69)']++;
            elseif ($mark >= 50) $distribution['D (50-59)']++;
            else $distribution['F (0-49)']++;
        }

        return $distribution;
    }

    /**
     * Calculate overall trend
     */
    private function calculateOverallTrend($comparison)
    {
        if (count($comparison) < 2) {
            return 'Insufficient data';
        }

        $first = $comparison[0]['average_percentage'];
        $last = $comparison[count($comparison) - 1]['average_percentage'];

        $change = $last - $first;

        if ($change > 5) return 'Strong improvement';
        if ($change > 2) return 'Slight improvement';
        if ($change > -2) return 'Stable';
        if ($change > -5) return 'Slight decline';
        return 'Significant decline';
    }

    /**
     * Generate Excel report
     */
    private function generateExcelReport($data, $filename)
    {
        // Implementation depends on your Excel package (e.g., Laravel Excel, PhpSpreadsheet)
        // This is a placeholder - you'll need to implement based on your preferred package
        return response()->json(['message' => 'Excel generation not implemented']);
    }

    /**
     * Generate CSV report
     */
    private function generateCsvReport($data, $filename)
    {
        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Add headers based on data structure
            if (isset($data->top_students)) {
                fputcsv($file, ['Rank', 'Student ID', 'School', 'Percentage', 'Grade', 'Classification']);
                foreach ($data->top_students as $student) {
                    fputcsv($file, [
                        $student['rank'],
                        $student['student_id'],
                        $student['school'],
                        $student['percentage'],
                        $student['grade'],
                        $student['classification']
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    /**
     * Generate PDF report
     */
    private function generatePdfReport($data, $filename)
    {
        // Implementation depends on your PDF package (e.g., DomPDF, mPDF)
        // This is a placeholder
        return response()->json(['message' => 'PDF generation not implemented']);
    }
}
