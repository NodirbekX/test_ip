<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\StudentAnswer;
use App\Models\ExamTime;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
class StudentController extends Controller
{
    public function index()
    {
        $questions = Question::all();

        foreach ($questions as $q) {
            $q->answers = Answer::where('question_id', $q->id)->get();
        }

        $time = ExamTime::latest()->first();

        $now = Carbon::now();

        $status = 'closed';

        if ($time) {
            if ($now < $time->start_time) {
                $status = 'not_started';
            } elseif ($now >= $time->start_time && $now <= $time->end_time) {
                $status = 'active';
            } else {
                $status = 'finished';
            }
        }

        $questions = Question::with('answers')->paginate(1);

        return view('student.exam', compact('questions', 'time', 'status'));
    }

    public function submit(Request $request)
    {
        if (!$request->has('answers')) {
            return back()->withErrors('No answers selected');
        }

        $userId = User::first()->id;

        foreach ($request->answers as $questionId => $answerId) {
            StudentAnswer::updateOrCreate(
                [
                    'user_id' => $userId,
                    'question_id' => $questionId,
                ],
                [
                    'answer_id' => $answerId,
                ]
            );
        }

        return redirect()->route('student.result');
    }

    public function result()
    {
        $userId = User::first()->id;

        $answers = StudentAnswer::where('user_id', $userId)->get();

        $correct = 0;
        $total = $answers->count();

        foreach ($answers as $a) {
            $answer = Answer::find($a->answer_id);
            if ($answer && $answer->is_correct) {
                $correct++;
            }
        }

        return view('student.result', compact('correct', 'total'));
    }
}
