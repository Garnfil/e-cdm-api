@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Add Course</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Add Course
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>


        <div class="row">
            <div class="col-xl-3 col-sm-12"></div>
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.sections.update', $section->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="name-field" class="form-label">Name</label>
                                        <input type="text" name="name" id="name-field" class="form-control"
                                            value="{{ $section->name }}">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="year-level-field" class="form-label">Year Level</label>
                                        <select name="year_level" id="year-level-field" class="form-select">
                                            <option {{ $section->year_level == 1 ? 'selected' : null }} value="1">1st
                                                Year
                                            </option>
                                            <option {{ $section->year_level == 2 ? 'selected' : null }} value="2">2nd
                                                Year
                                            </option>
                                            <option {{ $section->year_level == 3 ? 'selected' : null }} value="3">3rd
                                                Year
                                            </option>
                                            <option {{ $section->year_level == 4 ? 'selected' : null }} value="4">4th
                                                Year
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="description-field" class="form-label">Course</label>
                                        <select name="course_id" id="course-field" class="form-select">
                                            @foreach ($courses as $course)
                                                <option {{ $course->id == $section->course_id && 'selected' }}
                                                    value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="description-field" class="form-label">Description</label>
                                        <input type="text" name="description" id="description-field" class="form-control"
                                            value="{{ $section->description }}">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block w-100">Save Section</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-12"></div>
        </div>


    </div>
@endsection
