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
                                        <label for="instructor-field" class="form-label">Instructor</label>
                                        <select name="instructor_id" id="instructor-field" class="form-select">
                                            <option value="">--- SELECT INSTRUCTOR ---</option>
                                            @foreach ($instructors as $instructor)
                                                <option value="{{ $instructor->id }}"
                                                    data-course-id="{{ $instructor->course_id }}">
                                                    {{ $instructor->firstname }}
                                                    {{ $instructor->lastname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="section-field" class="form-label">section</label>
                                        <select name="section_id" id="section-field" class="form-select">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="subject-field" class="form-label">Subject</label>
                                        <select name="subject_id" id="subject-field" class="form-select">

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
                            <button class="btn btn-primary btn-block w-100">Save Class</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#instructor-field').change(function() {
                // Get the selected option
                var selectedOption = $(this).find(':selected');

                // Get the data-course-id attribute value
                var courseId = selectedOption.data('course-id');

                // Log or use the value
                fetchSections(courseId);
                fetchSubjects(courseId);
            });
        });

        function fetchSections(course_id) {
            $.ajax({
                url: `/admin/sections/all?course_id=${course_id}`, // URL to your PHP file
                type: 'GET', // HTTP method
                dataType: 'json', // Response format
                success: function(response) {
                    if (Array.isArray(response.sections)) {
                        response.sections.forEach(function(section) {
                            // Create option elements dynamically
                            $('#section-field').append(
                                `<option value="${section.id}">${section.name}</option>`
                            );
                        });
                    } else {
                        toastr.error("Invalid sections");
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error("An error occurred while fetching sections.");
                }
            });
        }

        function fetchSubjects(course_id) {
            $.ajax({
                url: `/admin/subjects/all?course_id=${course_id}`, // URL to your PHP file
                type: 'GET', // HTTP method
                dataType: 'json', // Response format
                success: function(response) {
                    if (Array.isArray(response.subjects)) {
                        response.subjects.forEach(function(subject) {
                            // Create option elements dynamically
                            $('#subject-field').append(
                                `<option value="${subject.id}">${subject.title}</option>`
                            );
                        });
                    } else {
                        toastr.error("Invalid subjects");
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    toastr.error("An error occurred while fetching subjects.");
                }
            });
        }
    </script>
@endpush
