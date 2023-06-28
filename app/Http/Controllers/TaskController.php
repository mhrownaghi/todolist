<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
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

    /**
     * Store a newly task in database
     * 
     * @param TaskRequest $request
     */
    public function store(TaskRequest $request)
    {
        $request->validated();
        $newTask = new TaskModel;
        $newTask->fill($request->all());
        if ($newTask->save()) {
            session()->flash(key: 'message', value: 'Task created successfully');
            return redirect()->route('tasks.index');
        }
    }
}
