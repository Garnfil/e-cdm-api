@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Edit Attendances</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Edit
                    Attendances
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.attendances.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <div class="row">
            <div class="col-xl-3"></div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.attendances.update', $attendance->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="class-field" class="form-label">Class</label>
                                <select name="class_id" id="class-field" class="form-select">
                                    @foreach ($classes as $class)
                                        <option {{ $class->id == $attendance->class_id ? 'selected' : null }}
                                            value="{{ $class->id }}">{{ $class->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="attendance-datetime" class="form-label">Attendance DateTime</label>
                                <input type="datetime-local" class="form-control" name="attendance-datetime"
                                    value="{{ $attendance->attendance_datetime }}">
                            </div>
                            <button class="btn btn-primary w-100 d-block">Save Attendance</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3"></div>
        </div>
    </div>
@endsection
