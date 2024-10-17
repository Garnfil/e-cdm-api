@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Sections</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Sections
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary"><i class="bx bx-plus"></i> Add
                    Section</a>
            </div>
        </section>
    @endsection
