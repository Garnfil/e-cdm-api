@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Create Whiteboard Session</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Create
                    Whiteboard Session
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.whiteboard-sessions.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i>
                    Back to
                    List</a>
            </div>
        </section>

        <div class="row">
            <div class="col-xl-3"></div>
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.whiteboard-sessions.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="class-field" class="form-label">Class</label>
                                <select name="class_id" id="class-field" class="form-select">
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary w-100">Save Whiteboard</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3"></div>
        </div>
    </div>
@endsection
