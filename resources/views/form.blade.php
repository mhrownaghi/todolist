@extends('layouts.default')
@section('content')
<h2 class="text-center">Task Form</h2>
<form>
    {{ csrf_field() }}
    <div class="row g-3">
        <div class="col-12">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="col-6">
            <label for="start" class="form-label">Start</label>
            <input type="date" name="start" id="start" class="form-control">
        </div>
        <div class="col-6">
            <label for="end" class="form-label">End</label>
            <input type="date" name="end" id="end" class="form-control">
        </div>
        <div class="col-6">
            <label for="priority" class="form-label">Priority</label>
            <input type="number" name="priority" id="priority" class="form-control" min="1" max="10" value="1">
        </div>
        <div class="col-6">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="Incomplete">Incomplete</option>
                <option value="In progress">In progress</option>
                <option value="Completed">Completed</option>
            </select>
        </div>
        <div class="col-12">
            <label for="description" class="form-label">Description <span class="text-muted">(Optional)</span></label>
            <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
        </div>
    </div>
    <hr class="my-4">
    <button type="submit" class="btn btn-primary btn-large">Save Task</button>
    <a href="{{ route('tasks.index') }}" class="btn">List Tasks</a>
</form>
@endsection