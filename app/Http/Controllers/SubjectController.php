<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{

    public function addTopics()
    {
        $teachers = Teacher::with('school')
            ->where('school_id', Session('LoggedSchool'))
            ->orderBy('surname')
            ->get();

        $school_id = Session('LoggedSchool');

        return view('Subjects.dashboard', compact('teachers', 'school_id'));
    }

    public function dashboard()
    {

        $SecondaryClasses = Helper::MasterRecordMerge(
            config('constants.options.O_LEVEL'),
            config('constants.options.A_LEVEL')
        );

        $Subjects = Helper::fetchAllSubjects();

        $topics = Topic::with([
            'senior:md_id,md_name',
            'subject:md_id,md_name',
        ])->get();

        $grouped = [];

        foreach ($topics as $topic) {
            $senior = $topic->senior->md_name ?? 'Unknown Senior';
            $subject = $topic->subject->md_name ?? 'Unknown Subject';
            $competency = $topic->Competency ?? 'General';

            $grouped[$senior][$subject][$competency][] = $topic;
        }

        $firstSenior = count($grouped) ? array_key_first($grouped) : null;

        return view('Subjects.dashboard', [
            'groupedTopics' => $grouped,
            'firstSenior' => $firstSenior,
            'Subjects' => $Subjects,
            'SecondaryClasses' => $SecondaryClasses
        ]);
    }

    public function fetchTopicsBySenior(Request $request)
    {
        $senior = $request->input('senior');

        if (!$senior) {

            $grouped = [];
        } else {
            $topics = Topic::with([
                'senior:md_id,md_name',
                'subject:md_id,md_name',
            ])->get();

            $grouped = [];

            foreach ($topics as $topic) {
                $topicSenior = $topic->senior->md_name ?? 'Unknown Senior';

                if ($topicSenior !== $senior)
                    continue; // Filter by selected senior

                $subject = $topic->subject->md_name ?? 'Unknown Subject';
                $competency = $topic->Competency ?? 'General';

                $grouped[$topicSenior][$subject][$competency][] = $topic;
            }
        }

        // Return view partial with filtered data
        return view('layouts.partials.topics-table', compact('grouped'))->render();
    }

    public function storeNewTopic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'senior_id' => 'required|exists:master_datas,md_id',
            'subject_id' => 'required|exists:master_datas,md_id',
            'Competency' => 'required|min:1',
            'topic_name' => 'required|array|min:1',
            'topic_name.*' => 'required|string|max:255',
            'topic_description' => 'required|array|min:1',
            'topic_description.*' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $senior_id = $request->input('senior_id');
        $subject_id = $request->input('subject_id');
        $Competency = $request->input('Competency');
        $topics = $request->input('topic_name');
        $descriptions = $request->input('topic_description');

        foreach ($topics as $index => $topic) {
            $description = $descriptions[$index] ?? null;

            Topic::create([
                'senior_id' => $senior_id,
                'subject_id' => $subject_id,
                'Competency' => $Competency,
                'topic_name' => $topic,
                'topic_description' => $description,
                'topic_date_added' => now(),
                'topic_added_by' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Topics saved successfully',
        ]);
    }

    public function showTopic($id)
    {
        $topic = Topic::findOrFail($id);

        return response()->json($topic);
    }

    public function updateTopic(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);

        $request->validate([
            // 'Competency' => 'required|min:1',
            'topic_name' => 'required|string|max:255',
            'topic_description' => 'nullable|string',
        ]);

        $topic->update([
            // 'Competency' => $request->Competency,
            'topic_name' => $request->topic_name,
            'topic_description' => $request->topic_description,
        ]);

        return response()->json(['message' => 'Topic updated successfully']);
    }

    public function destroyTopic($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return response()->json(['message' => 'Topic deleted successfully']);
    }

}
