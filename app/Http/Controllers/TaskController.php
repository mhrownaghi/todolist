<?php

namespace App\Http\Controllers;

use App\Models\Task as TaskModel;
use Illuminate\Contracts\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks
     */
    public function index(): View
    {
        return view('list')->with('tasks', TaskModel::all());
    }

    /**
     * Display form for creating a task
     */
    public function create(): View
    {
        return view('create');
    }
}
