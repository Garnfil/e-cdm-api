@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Add Student</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Add Student
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.students.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="list-style-type: square;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.students.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Student ID <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="student_id"
                                        value="{{ old('student_id') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email <span style="font-size: 10px;"
                                            class="text-info info">(Email
                                            should be
                                            student.pnm.edu.ph)</span></label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" value="">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">First Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="firstname"
                                        value="{{ old('firstname') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="lastname"
                                        value="{{ old('lastname') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename"
                                        value="{{ old('middlename') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Year Level <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="year_level"
                                        value="{{ old('year_level') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Section <span
                                            class="text-danger">*</span></label>
                                    <select name="section" id="section-field" class="form-select">
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Institute <span
                                            class="text-danger">*</span></label>
                                    <select name="institute_id" id="institute-field" class="form-select">
                                        @foreach ($institutes as $institute)
                                            <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Course</label>
                                    <select name="course_id" id="course-field" class="form-select">
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
                                        value="{{ old('birthdate') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Age</label>
                                    <input type="number" class="form-control" name="age"
                                        value="{{ old('age') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Current Address</label>
                                    <input type="text" class="form-control" name="current_address">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <select name="status" id="status-field" class="form-select">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="blocked">Blocked</option>
                                        <option value="locked">Locked</option>
                                        <option value="dropped">Dropped</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Gender</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Male"
                                            id="gender-radio-male" name="gender" checked />
                                        <label class="form-check-label" for="gender-radio-male"> Male </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="female"
                                            id="gender-radio-female" name="gender" />
                                        <label class="form-check-label" for="gender-radio-female"> Female
                                        </label>
                                    </div>
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
