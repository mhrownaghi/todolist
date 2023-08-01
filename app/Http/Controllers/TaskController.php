<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::paginate(15);

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

    public function changeStatus(int $id, ChangeStatusRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $task = Task::findOrFail($id);
        $task->status = $data['status'];
        $task->save();

        return redirect()->route('tasks.index');
    }

    public function edit(int $id): View
    {
        $task = Task::findOrFail($id);

        return view('edit', compact('task'));
    }

    public function update(int $id, TaskRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $task = Task::findOrFail($id);
        $task->fill($data);
        $isUpdated = $task->save();

        if ($isUpdated) {
            session()->flash('message', 'Task updated successfully');

            return redirect()->route('tasks.index');
        }

        return redirect()->back();
    }
}
