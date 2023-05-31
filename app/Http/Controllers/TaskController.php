<?php

namespace App\Http\Controllers;

use App\Models\Task as ModelsTask;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = ModelsTask::all();
        return view('list', [
            'tasks' => $tasks,
        ]);
    }

    public function create()
    {
        return view('form');
    }
}
