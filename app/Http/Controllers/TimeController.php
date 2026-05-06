<?php

namespace App\Http\Controllers;

use App\Models\ExamTime;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function index()
    {
        $time = ExamTime::latest()->first();

        return view('admin.time.index', compact('time'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        ExamTime::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return redirect('/')
            ->with('success', 'Vaqt saqlandi');    }
}
