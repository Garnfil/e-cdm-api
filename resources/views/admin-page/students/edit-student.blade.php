@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Edit Student</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Edit Student
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="#" class="btn btn-primary"><i class="bx bx-undo"></i> Back to List</a>
            </div>
        </section>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Student ID</label>
                                    <input type="text" class="form-control" name="student_id"
                                        value="{{ $student->student_id }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $student->email }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" disabled
                                        value="{{ $student->password }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="firstname"
                                        value="{{ $student->firstname }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="lastname"
                                        value="{{ $student->lastname }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename"
                                        value="{{ $student->middlename }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Year Level</label>
                                    <input type="text" class="form-control" name="year_level"
                                        value="{{ $student->year_level }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Section</label>
                                    <select name="section" id="section-field" class="form-select">
                                        @foreach ($sections as $section)
                                            <option {{ $section->name == $student->section ? 'selected' : null }}
                                                value="{{ $section->name }}">{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Institute</label>
                                    <select name="institute_id" id="institute-field" class="form-select"
                                        value="{{ $student->institute_id }}">
                                        @foreach ($institutes as $institute)
                                            <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Course</label>
                                    <select name="course_id" id="course-field" class="form-select"
                                        value="{{ $student->course_id }}">
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Birthdate</label>
                                    <input type="date" class="form-control" name="birthdate"
                                        value="{{ $student->birthdate }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Age</label>
                                    <input type="number" class="form-control" name="age"
                                        value="{{ $student->age }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Gender</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Male"
                                            id="gender-radio-male" name="gender"
                                            {{ $student->gender == 'Male' ? 'checked' : null }} />
                                        <label class="form-check-label" for="gender-radio-male"> Male </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Female"
                                            id="gender-radio-female" name="gender"
                                            {{ $student->gender == 'Female' ? 'checked' : null }} />
                                        <label class="form-check-label" for="gender-radio-female"> Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Current Address</label>
                                    <input type="text" class="form-control" name="current_address"
                                        value="{{ $student->current_address }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <select name="status" id="status-field" class="form-select"
                                        value="{{ $student->status }}">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="blocked">Blocked</option>
                                        <option value="locked">Locked</option>
                                        <option value="dropped">Dropped</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary">Save Student</button>
                </form>
            </div>
        </div>
    </div>
@endsection
