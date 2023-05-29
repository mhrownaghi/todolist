@extends('layouts.default')
@section('content')

<h2 class="text-center">Task list</h2>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">pr*</th>
                <th scope="col">name</th>
                <th scope="col">start</th>
                <th scope="col">end</th>
                <th scope="col">status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $task->priority }}</td>
                <td nowrap>{{ $task->name }}</td>
                <td nowrap>{{ $task->start->format('d F Y') }}</td>
                <td nowrap>{{ $task->end->format('d F Y') }}</td>
                <td nowrap>{{ $task->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No task found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<p>*: "pr" means "priority"</p>

@endsection