@extends('layouts.default')
@section('content')
<h2 class="text-center">Task Form</h2>
@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Some of fields have incorrect values.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<form>
    {{ csrf_field() }}
    <div class="row g-3">
        <div class="col-12">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" @class(['form-control', 'is-invalid'=> $errors->has('name')])
            value="{{ old('name') }}">
            @error('name')
            <div class=".invalid-feedback">Name field is required.</div>
            @enderror
        </div>
        <div class="col-6">
            <label for="start" class="form-label">Start</label>
            <input type="date" name="start" id="start" @class(['form-control', 'is-invalid' => $errors->has('start')])
            value="{{ old('start') }}">
            @error('start')
            <div class=".invalid-feedback">Start field is required.</div>
            @enderror
        </div>
        <div class="col-6">
            <label for="end" class="form-label">End</label>
            <input type="date" name="end" id="end" @class(['form-control', 'is-invalid' => $errors->has('end')])
            value="{{ old('end') }}">
            @error('end')
            <div class=".invalid-feedback">End field is required.</div>
            @enderror
        </div>
        <div class="col-6">
            <label for="priority" class="form-label">Priority</label>
            <input type="number" name="priority" id="priority" min="1" max="10"
                @class(['form-control', 'is-invalid' => $errors->has('priority')])
                value="{{ old('priority') ?? 1 }}">
            @error('priority')
            <div class="invalid-feedback">Priority field is required.</div>
            @enderror
        </div>
        <div class="col-6">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" @class(['form-control', 'is-invalid' => $errors->has('status')])>
                <option value="Incomplete" @selected(old('status') == 'Incomplete')>Incomplete</option>
                <option value="In progress" @selected(old('status') == 'In progress')>In progress</option>
                <option value="Completed" @selected(old('status') == 'Completed')>Completed</option>
            </select>
            @error('status')
                <div class="invalid-feedback">Status field is required.</div>
            @enderror
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