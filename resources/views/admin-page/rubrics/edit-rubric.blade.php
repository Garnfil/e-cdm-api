@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Edit Rubric</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Edit Rubric
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.rubrics.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <div class="row">
            <div class="col-xl-3"></div>
            <div class="col-xl-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.rubrics.update', $rubric->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="class-field" class="form-label">Class</label>
                                <select name="class_id" id="class-field" class="select2 form-select">
                                    @foreach ($classes as $class)
                                        <option {{ $class->id == $rubric->class_id ? 'selected' : null }}
                                            value="{{ $class->id }}">
                                            {{ $class->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="assessment-type-field" class="form-label">Assessment Type</label>
                                <select name="assessment_type" id="assessment-type-field" class="form-select">
                                    <option {{ $rubric->assessment_type == 'prelim' ? 'selected' : null }} value="prelim">
                                        Prelim</option>
                                    <option {{ $rubric->assessment_type == 'midterm' ? 'selected' : null }} value="midterm">
                                        Midterm</option>
                                    <option {{ $rubric->assessment_type == 'final' ? 'selected' : null }} value="final">
                                        Final</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="assignment-percentage">Assignment Percentage</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="assignment-percentage"
                                            name="assignment_percentage" />
                                        <span id="basic-default-password2" class="input-group-text cursor-pointer">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="quiz-percentage">quiz Percentage</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="quiz-percentage"
                                            name="quiz_percentage" />
                                        <span id="basic-default-password2" class="input-group-text cursor-pointer">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="activity-percentage">activity Percentage</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="activity-percentage"
                                            name="activity_percentage" />
                                        <span id="basic-default-password2" class="input-group-text cursor-pointer">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="exam-percentage">exam Percentage</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="exam-percentage"
                                            name="exam_percentage" />
                                        <span id="basic-default-password2" class="input-group-text cursor-pointer">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="attendance-percentage">attendance Percentage</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="attendance-percentage"
                                            name="attendance_percentage" />
                                        <span id="basic-default-password2" class="input-group-text cursor-pointer">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="other-performance-percentage">Other Performance
                                        Percentage</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="other-performance-percentage"
                                            name="other_performance_percentage" />
                                        <span id="basic-default-password2" class="input-group-text cursor-pointer">%</span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary w-100">Save Rubric</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3"></div>
        </div>
    </div>
@endsection
