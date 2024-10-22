@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Add Quiz</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Add Quiz
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.quizzes.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.quizzes.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="title-field" class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" id="title-field">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="class-field" class="form-label">Class</label>
                                        <select name="class_id" id="class-field" class="form-select">
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4">
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
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="description-field" class="form-label">Description</label>
                                        <textarea name="description" id="description-field" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="notes-field" class="form-label">Notes</label>
                                        <textarea name="notes" id="notes-field" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="points-field" class="form-label">Points</label>
                                        <input type="text" class="form-control" name="points" id="points-field">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="quiz-type-field" class="form-label">Quiz Type</label>
                                        <input type="text" class="form-control" name="quiz_type" id="quiz-type-field">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="due-datetime-field" class="form-label">Due Datetime</label>
                                        <input type="datetime-local" class="form-control" name="due_datetime"
                                            id="due-datetime-field">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="form-label">Status</label>
                                                <div class="form-check">
                                                    <input name="status" class="form-check-input" type="radio"
                                                        value="posted" id="status-radio-posted" checked />
                                                    <label class="form-check-label" for="status-radio-posted"> Posted
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input name="status" class="form-check-input" type="radio"
                                                        value="drafted" id="status-radio-drafted" />
                                                    <label class="form-check-label" for="status-radio-drafted"> Drafted
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="has-quiz-form-checkbox" name="has_quiz_form" />
                                                <label class="form-check-label" for="has-quiz-form-checkbox"> Has Quiz
                                                    Form? </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary">Save Assignment <i class='bx bxs-download'></i></button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
