@extends('layouts.default')
@section('content')

<h2 class="text-center">Task list</h2>
<div class="toolbar p-2 border">
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i>
        Create Task
    </a>
    <button type="button" class="btn btn-outline-primary">
        <i class="bi bi-x-lg"></i>
        Delete Task(s)
    </button>
    <button type="button" class="btn btn-outline-primary">
        <i class="bi bi-pencil-square"></i>
        Edit Task
    </button>
</div>
@if ($message = session('message'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">pr*</th>
                <th scope="col">name</th>
                <th scope="col">start</th>
                <th scope="col">end</th>
                <th scope="col">remaining/total</th>
                <th scope="col">status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $task->priority }}</td>
                <td nowrap>
                    <a href="{{ route('tasks.edit', $task->id) }}">{{ $task->name }}</a>
                </td>
                <td nowrap>{{ $task->start->format('d F Y') }}</td>
                <td nowrap>{{ $task->end->format('d F Y') }}</td>
                <td nowrap>{{ $task->remainingDays . '/' . $task->totalDays }}</td>
                <td nowrap>
                    <form action="{{ route('tasks.changeStatus', $task->id) }}" method="POST">
                        {{ csrf_field() }}
                        <select name="status" onchange="event.target.form.submit()">
                            <option value="Incomplete" @selected($task->status == 'Incomplete')>Incomplete</option>
                            <option value="In Progress" @selected($task->status == 'In Progress')>In progress</option>
                            <option value="Completed" @selected($task->status == 'Completed')>Completed</option>
                        </select>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No task found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $tasks->links() }}
</div>
<p>*: "pr" means "priority"</p>

@endsection