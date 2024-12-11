@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Edit Quiz</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Edit Quiz
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.quizzes.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>


        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">
                    Quiz Details
                </button>
            </li>
            <!-- <li class="nav-item">
                                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                                    data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">
                                                                    Quiz Form
                                                                </button>
                                                            </li> -->

        </ul>
        <div class="tab-content px-0">
            <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="mb-3">
                                                <label for="title-field" class="form-label">Title</label>
                                                <input type="text" class="form-control" name="title" id="title-field"
                                                    value="{{ $quiz->title }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="mb-3">
                                                <label for="classes-field" class="form-label">Classes</label>
                                                <select name="class_ids[]" id="classes-field" class="form-select" multiple>
                                                    @foreach ($classes as $class)
                                                        <option
                                                            {{ $quiz->school_work_class->class_id == $class->id ? 'selected' : null }}
                                                            value="{{ $class->id }}">{{ $class->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="mb-3">
                                                <label for="instructor-field" class="form-label">Instructor</label>
                                                <select name="instructor_id" id="instructor-field" class="form-select">
                                                    @foreach ($instructors as $instructor)
                                                        <option
                                                            {{ $quiz->instructor_id == $instructor->id ? 'selected' : null }}
                                                            value="{{ $instructor->id }}">{{ $instructor->firstname }}
                                                            {{ $instructor->lastname }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="description-field" class="form-label">Description</label>
                                                <textarea name="description" id="description-field" class="form-control" cols="30" rows="5">{{ $quiz->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="notes-field" class="form-label">Notes</label>
                                                <textarea name="notes" id="notes-field" class="form-control" cols="30" rows="5">{{ $quiz->quiz->notes }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="mb-3">
                                                <label for="points-field" class="form-label">Points</label>
                                                <input type="text" class="form-control" name="points" id="points-field"
                                                    value="{{ $quiz->quiz->points }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="mb-3">
                                                <label for="quiz-type-field" class="form-label">Quiz Type</label>
                                                <input type="text" class="form-control" name="quiz_type"
                                                    id="quiz-type-field" value="{{ $quiz->quiz->quiz_type }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="mb-3">
                                                <label for="due-datetime-field" class="form-label">Due Datetime</label>
                                                <input type="datetime-local" class="form-control" name="due_datetime"
                                                    id="due-datetime-field" value="{{ $quiz->due_datetime }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group mb-3">
                                                        <label for="" class="form-label">Status</label>
                                                        <div class="form-check">
                                                            <input name="status" class="form-check-input" type="radio"
                                                                value="posted" id="status-radio-posted"
                                                                {{ $quiz->status == 'posted' ? 'checked' : null }} />
                                                            <label class="form-check-label" for="status-radio-posted">
                                                                Posted
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input name="status" class="form-check-input" type="radio"
                                                                value="drafted" id="status-radio-drafted"
                                                                {{ $quiz->status == 'drafted' ? 'checked' : null }} />
                                                            <label class="form-check-label" for="status-radio-drafted">
                                                                Drafted
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" type="checkbox" value="1"
                                                            id="has-quiz-form-checkbox" name="has_quiz_form"
                                                            {{ $quiz->quiz->has_quiz_form == 1 ? 'checked' : null }} />
                                                        <label class="form-check-label" for="has-quiz-form-checkbox"> Has
                                                            Quiz
                                                            Form? </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary">Save Quiz <i class='bx bxs-download'></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4>Attachments</h4>
                                <form action="{{ route('admin.school_works.attachments.upload') }}"
                                    enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <input type="hidden" name="school_work_id" value="{{ $quiz->id }}">
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label">Attachment Type</label>
                                        <div class="form-check">
                                            <input name="attachment_type" class="form-check-input" type="radio"
                                                value="file" id="type-radio-first" checked
                                                onchange="handleAttachmentTypeChange(this)" />
                                            <label class="form-check-label" for="type-radio-first"> File
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input name="attachment_type" class="form-check-input" type="radio"
                                                value="link" id="type-radio-second"
                                                onchange="handleAttachmentTypeChange(this)" />
                                            <label class="form-check-label" for="type-radio-second"> Link
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Attachment</label>
                                        <input type="file" class="form-control" id="file-attachment-field"
                                            name="attachment" />
                                        <input type="url" class="form-control d-none" id="link-attachment-field"
                                            name="attachment" placeholder="Drop your link" />
                                    </div>
                                    <button class="btn btn-primary w-100 btn-block">Save Attachment <i
                                            class='bx bxs-download'></i></button>
                                </form>
                                <hr>
                                <div class="d-flex gap-3">
                                    <div class="w-100">
                                        <div class="demo-inline-spacing mt-3">
                                            <div class="list-group">
                                                @forelse ($quiz->attachments as $attachment)
                                                    <a href="javascript:void(0);"
                                                        class="list-group-item list-group-item-action flex-column align-items-start">
                                                        <div class="d-flex justify-content-between w-100">
                                                            <h6 class="text-uppercase">{{ $attachment->attachment_type }}
                                                            </h6>
                                                            <small>Upload At:
                                                                {{ $attachment->created_at->format('M d, Y') }}</small>
                                                        </div>
                                                        <p class="mb-1 text-primary">
                                                            {{ $attachment->attachment_name }}
                                                        </p>
                                                        <small>{{ $attachment->school_work_type }}</small>
                                                    </a>
                                                @empty
                                                    <a href="javascript:void(0);"
                                                        class="list-group-item list-group-item-action flex-column align-items-start text-center">
                                                        No Attachment Found
                                                    </a>
                                                @endforelse


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                @if ($quiz->quiz->has_quiz_form == 1)
                    <div class="row">
                        <div class="col-xl-3">

                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-4">Create Quiz</h4>
                                    <form id="quizForm" method="POST"
                                        action="{{ route('admin.quiz_questions.store') }}">
                                        @csrf
                                        <input type="hidden" name="quiz_id" value="{{ $quiz->quiz->id }}">
                                        <div id="questionsContainer">
                                            @forelse ($quiz->quiz->questions as $questionIndex => $question)
                                                <div class="mb-4 questions-con border p-3 rounded">
                                                    <!-- Question Text -->
                                                    <div class="d-flex justify-content-between">
                                                        <label for="question_{{ $questionIndex }}">Question
                                                            {{ $questionIndex + 1 }}</label>
                                                        <button type="button" class="btn btn-danger btn-sm mb-2"
                                                            onclick="removeQuestion({{ $questionIndex }})">Remove
                                                            Question</button>
                                                    </div>
                                                    <input type="text"
                                                        name="questions[{{ $questionIndex }}][question_text]"
                                                        class="form-control mb-3" placeholder="Enter the question"
                                                        value="{{ $question->question_text }}">

                                                    <!-- Question Type -->
                                                    <select name="questions[{{ $questionIndex }}][type]"
                                                        class="form-select mb-3">
                                                        <option value="choice"
                                                            {{ $question->type == 'choice' ? 'selected' : '' }}>Multiple
                                                            Choice</option>
                                                        <option value="paragraph"
                                                            {{ $question->type == 'paragraph' ? 'selected' : '' }}>Long
                                                            Answer</option>
                                                    </select>

                                                    <!-- Choices -->
                                                    @if ($question->type == 'choice')
                                                        <div id="choices_{{ $questionIndex }}">
                                                            @foreach ($question->choices as $choiceIndex => $choice)
                                                                <div class="input-group mb-2">
                                                                    <input type="text"
                                                                        name="questions[{{ $questionIndex }}][choices][{{ $choiceIndex }}][choice_text]"
                                                                        class="form-control"
                                                                        value="{{ $choice->choice_text }}"
                                                                        placeholder="Choice {{ $choiceIndex + 1 }}">

                                                                    <div class="input-group-text">
                                                                        <input type="checkbox"
                                                                            name="questions[{{ $questionIndex }}][choices][{{ $choiceIndex }}][is_correct]"
                                                                            {{ $choice->is_correct ? 'checked' : '' }}>
                                                                        Correct
                                                                    </div>

                                                                    <button type="button" class="btn btn-danger"
                                                                        onclick="removeChoice({{ $questionIndex }}, {{ $choiceIndex }})">Remove</button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <button type="button" class="btn btn-primary mb-3"
                                                            onclick="addChoice({{ $questionIndex }})">Add Choice</button>
                                                    @endif

                                                    @if ($question->type == 'paragraph')
                                                        <textarea class="form-control" disabled>Long answer text</textarea>
                                                    @endif
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>

                                        <button type="button" class="btn btn-secondary w-100 mt-3"
                                            onclick="addQuestion()">Add Another Question</button>
                                        <button type="submit" class="btn btn-primary w-100 mt-3">Submit Quiz</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">

                        </div>
                    </div>
                @else
                    The quiz form is not available for this quiz
                @endif
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function addQuestion() {
                const questionsContainer = document.getElementById('questionsContainer');
                const questionIndex = document.querySelectorAll('.questions-con').length;

                const questionHtml = `
                <div class="mb-4 questions-con border p-3 rounded">
                    <div class="d-flex justify-content-between">
                        <label for="question_${questionIndex}">Question ${questionIndex + 1}</label>
                        <button type="button" class="btn btn-danger btn-sm mb-2" onclick="removeQuestion(${questionIndex})">Remove Question</button>
                    </div>
                    <input type="text" name="questions[${questionIndex}][question_text]" class="form-control mb-3" placeholder="Enter the question">
                    <select name="questions[${questionIndex}][type]" class="form-select mb-3">
                        <option value="choice">Multiple Choice</option>
                        <option value="paragraph">Long Answer</option>
                    </select>
                    <div id="choices_${questionIndex}"></div>
                    <button type="button" class="btn btn-primary mb-3" onclick="addChoice(${questionIndex})">Add Choice</button>
                </div>
            `;

                questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
            }

            function addChoice(questionIndex) {
                const choicesContainer = document.getElementById(`choices_${questionIndex}`);
                const choiceIndex = choicesContainer.querySelectorAll('.input-group').length;

                const choiceHtml = `
                <div class="input-group mb-2">
                    <input type="text" name="questions[${questionIndex}][choices][${choiceIndex}][choice_text]" class="form-control" placeholder="Choice ${choiceIndex + 1}">
                    <div class="input-group-text">
                        <input type="checkbox" name="questions[${questionIndex}][choices][${choiceIndex}][is_correct]"> Correct
                    </div>
                    <button type="button" class="btn btn-danger" onclick="removeChoice(${questionIndex}, ${choiceIndex})">Remove</button>
                </div>
            `;

                choicesContainer.insertAdjacentHTML('beforeend', choiceHtml);
            }

            function removeChoice(questionIndex, choiceIndex) {
                document.getElementsByName(`questions[${questionIndex}][choices][${choiceIndex}][choice_text]`)[0].parentElement
                    .remove();
            }

            function removeQuestion(questionIndex) {
                document.getElementsByName(`questions[${questionIndex}][question_text]`)[0].parentElement.remove();
            }

            $('#classes-field').select2();
        </script>
    @endpush
@endsection
