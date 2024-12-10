@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Edit Assignment</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Edit
                    Assignment
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.assignments.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.assignments.update', $assignment->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="title-field" class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" id="title-field"
                                            value="{{ $assignment->title }}">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="classes-field" class="form-label">Classes</label>
                                        <select name="class_ids[]" id="classes-field" class="form-select" multiple>
                                            @foreach ($classes as $class)
                                                <option
                                                    {{ $class->id == $assignment->school_work_class->class_id ? 'selected' : null }}
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
                                                    {{ $instructor->id == $assignment->instructor_id ? 'selected' : null }}
                                                    value="{{ $instructor->id }}">{{ $instructor->firstname }}
                                                    {{ $instructor->lastname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="description-field" class="form-label">Description</label>
                                        <textarea name="description" id="description-field" class="form-control" cols="30" rows="5">{{ $assignment->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="notes-field" class="form-label">Notes</label>
                                        <textarea name="notes" id="notes-field" class="form-control" cols="30" rows="5">{{ $assignment->assignment->notes }}</textarea>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="points-field" class="form-label">Points</label>
                                        <input type="text" class="form-control" name="points" id="points-field"
                                            value="{{ $assignment->assignment->points }}">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="due-datetime-field" class="form-label">Due Datetime</label>
                                        <input type="datetime-local" class="form-control" name="due_datetime"
                                            id="due-datetime-field" value="{{ $assignment->due_datetime }}">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label">Status</label>
                                        <div class="form-check">
                                            <input name="status" class="form-check-input" type="radio" value="posted"
                                                id="status-radio-posted"
                                                {{ $assignment->status == 'posted' ? 'checked' : null }} />
                                            <label class="form-check-label" for="status-radio-posted"> Posted
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input name="status" class="form-check-input" type="radio" value="drafted"
                                                id="status-radio-drafted"
                                                {{ $assignment->status == 'drafted' ? 'checked' : null }} />
                                            <label class="form-check-label" for="status-radio-drafted"> Drafted
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary">Save Assignment <i class='bx bxs-download'></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Attachments</h4>
                        <form action="{{ route('admin.school_works.attachments.upload') }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            <input type="hidden" name="school_work_id" value="{{ $assignment->id }}">
                            <div class="form-group mb-3">
                                <label for="" class="form-label">Attachment Type</label>
                                <div class="form-check">
                                    <input name="attachment_type" class="form-check-input" type="radio" value="file"
                                        id="type-radio-first" checked onchange="handleAttachmentTypeChange(this)" />
                                    <label class="form-check-label" for="type-radio-first"> File
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name="attachment_type" class="form-check-input" type="radio" value="link"
                                        id="type-radio-second" onchange="handleAttachmentTypeChange(this)" />
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
                                        @forelse ($assignment->attachments as $attachment)
                                            <a href="javascript:void(0);"
                                                class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex justify-content-between w-100">
                                                    <h6 class="text-uppercase">{{ $attachment->attachment_type }}</h6>
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

    @push('scripts')
        <script>
            function handleAttachmentTypeChange(e) {
                if (e.value == 'file') {
                    $('#file-attachment-field').addClass('d-block');
                    $('#file-attachment-field').removeClass('d-none');
                    $('#link-attachment-field').addClass('d-none');
                    $('#link-attachment-field').removeClass('d-block');
                } else {
                    $('#link-attachment-field').addClass('d-block');
                    $('#link-attachment-field').removeClass('d-none');
                    $('#file-attachment-field').addClass('d-none');
                    $('#file-attachment-field').removeClass('d-block');
                }
            }

            $('#classes-field').select2();
        </script>
    @endpush
@endsection
