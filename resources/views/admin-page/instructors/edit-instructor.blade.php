@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Edit Instructor</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Edit
                    Instructor
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.instructors.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.instructors.update', $instructor->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="email-field" class="form-label">Email</label>
                                <input type="email" name="email" id="email-field" class="form-control"
                                    value="{{ $instructor->email }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="username-field" class="form-label">Username</label>
                                <input type="text" name="username" id="username-field" class="form-control"
                                    value="{{ $instructor->username }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="password-field" class="form-label">Password</label>
                                <input type="password" name="password" id="password-field" class="form-control" disabled
                                    value="{{ $instructor->password }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="firstname"
                                    value="{{ $instructor->firstname }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lastname"
                                    value="{{ $instructor->lastname }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="middlename"
                                    value="{{ $instructor->middlename }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Institute</label>
                                <select name="institute_id" id="institute-field" class="form-select">
                                    @foreach ($institutes as $institute)
                                        <option {{ $institute->id == $instructor->institute_id && 'selected' }}
                                            value="{{ $institute->id }}">{{ $institute->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Course</label>
                                <select name="course_id" id="course-field" class="form-select">
                                    @foreach ($courses as $course)
                                        <option {{ $course->id == $instructor->course_id && 'selected' }}
                                            value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary">Save Instructor</button>
                </form>
            </div>
        </div>
    </div>
@endsection
