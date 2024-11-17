@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Add Class</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Add Class
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.classes.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>


        <div class="row">
            <div class="col-xl-3"></div>
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.classes.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="current-assessment-category-field" class="form-label">Current Assessment
                                            Category</label>
                                        <select name="current_assessment_category" id="current-assessment-category-field"
                                            class="form-select">
                                            <option value="prelim">Prelim</option>
                                            <option value="midterm">Midterm</option>
                                            <option value="finals">Finals</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="section-field" class="form-label">section</label>
                                        <select name="section_id" id="section-field" class="form-select">
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="instructor-field" class="form-label">Instructor</label>
                                        <select name="instructor_id" id="instructor-field" class="form-select">
                                            @foreach ($instructors as $instructor)
                                                <option value="{{ $instructor->id }}">{{ $instructor->firstname }}
                                                    {{ $instructor->lastname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="subject-field" class="form-label">Subject</label>
                                        <select name="subject_id" id="subject-field" class="form-select">
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->title }} -
                                                    {{ $subject->course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="description-field" class="form-label">Description</label>
                                        <input type="text" class="form-control" name="description"
                                            id="description-field">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="form-label">Semester</label>
                                                <div class="form-check">
                                                    <input name="semester" class="form-check-input" type="radio"
                                                        value="1st" id="type-radio-first" checked />
                                                    <label class="form-check-label" for="type-radio-first"> 1st Semester
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input name="semester" class="form-check-input" type="radio"
                                                        value="2nd" id="type-radio-second" />
                                                    <label class="form-check-label" for="type-radio-second"> 2nd Semester
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="form-label">Status</label>
                                                <div class="form-check">
                                                    <input name="status" class="form-check-input" type="radio"
                                                        value="active" id="status-radio-active" checked />
                                                    <label class="form-check-label" for="status-radio-active"> Active
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input name="status" class="form-check-input" type="radio"
                                                        value="inactive" id="status-radio-inactive" />
                                                    <label class="form-check-label" for="status-radio-inactive"> Inactive
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block w-100">Save Subject</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3"></div>
        </div>


    </div>
@endsection
