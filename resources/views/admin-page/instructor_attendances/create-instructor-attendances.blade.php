@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Add Attendance</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Add Attendance
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.institutes.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>


        <div class="row">
            <div class="col-xl-3 col-sm-12"></div>
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.institutes.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="instructor-select-field" class="form-label">Instructor</label>
                                        <select name="instructor_id" id="instructor-select-field" class="form-select">
                                            <option value="">SELECT INSTRUCTOR</option>
                                            @foreach ($instructors as $instructor)
                                                <option value="{{ $instructor->id }}">
                                                    {{ $instructor->firstname . ' ' . $instructor->lastname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="class-field" class="form-label">Class</label>
                                        <select name="instructor" id="instructor-select-field" class="form-select">
                                            <option value="">SELECT CLASS</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">
                                                    {{ $class->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block w-100">Save Attendance</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-12"></div>
        </div>


    </div>
@endsection
