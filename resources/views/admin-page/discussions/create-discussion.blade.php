@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Add Discussion</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Add Discussion
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.discussions.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.discussions.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-group mb-3">
                                <label for="title-field" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="title-field">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group mb-3">
                                <label for="user-type-select-field" class="form-label">User Type</label>
                                <select name="user_type" id="user-type-select-field" class="form-select">
                                    <option value="">--- SELECT USER TYPE ---</option>
                                    <option value="student">Student</option>
                                    <option value="instructor">Instructor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group mb-3">
                                <label for="user-select-field" class="form-label">User</label>
                                <select name="user_id" id="user-select-field" class="form-select"></select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group mb-3">
                                <label for="visibility-select-field" class="form-label">Visibility</label>
                                <select name="visibility" id="visibility-select-field" class="form-select">
                                    <option value="">--- SELECT VISIBILITY ---</option>
                                    <option value="public">Public</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group mb-3">
                                <label for="institute-select-field" class="form-label">Institute</label>
                                <select name="institute_id" id="institute-select-field" class="form-select">
                                    <option value="">--- SELECT INSTITUTE ---</option>
                                    @foreach ($institutes as $institute)
                                        <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group mb-3">
                                <label for="course-select-field" class="form-label">Course</label>
                                <select name="course_id" id="course-select-field" class="form-select">
                                    <option value="">--- SELECT COURSE ---</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="form-group mb-3">
                                <label for="content-field" class="form-label">Content</label>
                                <textarea name="content" id="content-field" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block ">Save Discussion</button>

                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.form-select').select2();
            })

            $('#visibility-select-field').change(function(e) {
                if (e.target.value == 'public') {
                    $('#institute-select-field').attr('disabled', 'disabled');
                    $('#course-select-field').attr('disabled', 'disabled');
                } else {
                    $('#institute-select-field').removeAttr('disabled');
                    $('#course-select-field').removeAttr('disabled');
                }
            })

            $('#user-type-select-field').change(async function(e) {
                // Clear previous select2 data by destroying it
                $('#user-select-field').empty().trigger('change');

                if (e.target.value === 'student') {
                    let students = await fetchStudents();
                    if (Array.isArray(students)) {
                        students = students.map(student => ({
                            id: student.id,
                            text: student.firstname + ' ' + student.lastname
                        }));
                    }

                    console.log(students);
                    // Reinitialize select2 with new data
                    $('#user-select-field').select2({
                        data: students
                    });
                } else {
                    let instructors = await fetchInstructors();
                    if (Array.isArray(instructors)) {
                        instructors = instructors.map(instructor => ({
                            id: instructor.id,
                            text: instructor.firstname + ' ' + instructor.lastname
                        }));
                    }

                    console.log(instructors);
                    // Reinitialize select2 with new data
                    $('#user-select-field').select2({
                        data: instructors
                    });
                }
            });

            const fetchStudents = async () => {
                const response = await fetch('/admin/students/all');
                const data = await response.json();
                return data.students;
            }

            const fetchInstructors = async () => {
                const response = await fetch('/admin/instructors/all');
                const data = await response.json();
                return data.instructors;
            }
        </script>
    @endpush
@endsection
