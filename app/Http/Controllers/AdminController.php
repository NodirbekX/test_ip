<?php

namespace App\Http\Controllers;

use App\Models\AllowedIp;
use App\Models\ExamTime;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $time = ExamTime::latest()->first();

        $status = 'not_set';

        if ($time) {
            $now = Carbon::now();

            if ($now < $time->start_time) {
                $status = 'not_started';
            } elseif ($now >= $time->start_time && $now <= $time->end_time) {
                $status = 'active';
            } else {
                $status = 'finished';
            }
        }
    $questionsCount = Question::count();

    return view('admin.dashboard', compact('time', 'status', 'questionsCount'));
}

    public function ips()
    {
        $ips = AllowedIp::all();
        return view('admin.ips', compact('ips'));
    }

    public function storeIp(Request $request)
    {
        $request->validate([
            'ip' => 'required|ip'
        ]);

        AllowedIp::create([
            'ip' => $request->ip
        ]);

        return back()->with('success', 'IP added');
    }

    public function deleteIp($id)
    {
        AllowedIp::findOrFail($id)->delete();
        return back();
    }

    function index()
    {
        $tests = Test::latest()->paginate(10);
        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        return view('admin.tests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answers' => 'required|array|min:2',
            'answers.*' => 'required|string',
            'correct_answer' => 'required|integer',
            'points' => 'nullable|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Create Test
            $test = Test::create();

            // Create Question
            $question = Question::create([
                'test_id' => $test->id,
                'question' => $validated['question'],
                'points' => $validated['points'] ?? 1,
            ]);

            // Create Answers
            foreach ($validated['answers'] as $index => $answerText) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $answerText,
                    'is_correct' => $validated['correct_answer'] == $index,
                ]);
            }

            DB::commit();

            return redirect()->route('tests.index')
                ->with('success', 'Test created successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors('Error: ' . $e->getMessage());
        }
    }

    public function show(Test $test)
    {
        $questions = Question::where('test_id', $test->id)->get();

        // attach answers manually
        foreach ($questions as $q) {
            $q->answers = Answer::where('question_id', $q->id)->get();
        }

        return view('admin.tests.show', [
            'test' => $test,
            'questions' => $questions,
        ]);
    }

    public function edit(Test $test)
    {
        $questions = Question::where('test_id', $test->id)->get();

        foreach ($questions as $q) {
            $q->answers = Answer::where('question_id', $q->id)->get();
        }

        return view('admin.tests.edit', [
            'test' => $test,
            'questions' => $questions,
        ]);
    }

    public function update(Request $request, Test $test)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answers' => 'required|array|min:2',
            'answers.*' => 'required|string',
            'correct_answer' => 'required|integer',
            'points' => 'nullable|integer|min:1',
        ]);

        $question = Question::where('test_id', $test->id)->first();

        // update question
        $question->update([
            'question' => $validated['question'],
            'points' => $validated['points'] ?? 1,
        ]);

        // update answers
        $answers = Answer::where('question_id', $question->id)->get();

        foreach ($answers as $index => $answer) {
            $answer->update([
                'answer' => $validated['answers'][$index],
                'is_correct' => $validated['correct_answer'] == $index,
            ]);
        }

        return redirect()->route('tests.index')
            ->with('success', 'Updated successfully');
    }

    public function destroy(Test $test)
    {
        $test->delete();

        return redirect()->route('tests.index')
            ->with('success', 'Test deleted successfully');
    }
}
