<?php

namespace App\Http\Controllers;

use App\Models\Task as ModelsTask;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = ModelsTask::all();
        return view('list', [
            'tasks' => $tasks,
        ]);
    }
}
