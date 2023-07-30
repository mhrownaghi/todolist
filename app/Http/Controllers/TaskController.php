<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::all();

        return view('list', compact('tasks'));
    }

    /**
     * Display the form for creating a new task.
     */
    public function create(): View
    {
        return view('create');
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        $task = Task::create($request->validated());

        if ($task) {
            $message = 'Task created successfully';
            session()->flash('message', $message);

            return redirect()->route('tasks.index');
        }

        return redirect()->back();
    }
}
