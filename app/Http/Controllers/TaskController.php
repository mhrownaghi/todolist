<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\SaveTaskRequest;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

    public function store(SaveTaskRequest $request): RedirectResponse
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

    public function update(int $id, SaveTaskRequest $request): RedirectResponse
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

    public function destroy(Request $request): JsonResponse
    {
        $count = Task::destroy($request->tasks);

        if ($count) {
            session()->flash('message', 'Tasks deleted successfully');
        }

        return response()->json([
            'success' => true,
            'count' => $count,
            'tasks' => $request->tasks
        ]);
    }
}
