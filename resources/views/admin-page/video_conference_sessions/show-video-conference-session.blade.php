@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">View Video Conference Session</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> View Video
                    Conference Session
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.video-conference-sessions.index') }}" class="btn btn-primary"><i
                        class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table-borderless table">
                            <tbody>
                                <tr>
                                    <td width="300" class="fw-bold">Title:</td>
                                    <td>{{ $conference_session->title }}</td>
                                </tr>
                                <tr>
                                    <td width="300" class="fw-bold">Session Code:</td>
                                    <td>{{ $conference_session->session_code }}</td>
                                </tr>
                                <tr>
                                    <td width="300" class="fw-bold">Scheduled DateTime:</td>
                                    <td>{{ \Carbon\Carbon::parse($conference_session->scheduled_datetime)->format('F d, Y h:i a') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="300" class="fw-bold">Class:</td>
                                    <td>{{ $conference_session->classroom->title }}</td>
                                </tr>
                                <tr>
                                    <td width="300" class="fw-bold">Start & End DateTime:</td>
                                    <td>{{ \Carbon\Carbon::parse($conference_session->start_datetime)->format('F d, Y h:i a') }}
                                        -
                                        {{ \Carbon\Carbon::parse($conference_session->end_datetime)->format('F d, Y h:i a') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="300" class="fw-bold">Status:</td>
                                    <td>
                                        <div class="badge bg-primary">{{ $conference_session->status }}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Students Joined</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($conference_session->joined_students as $joined_student)
                                <li class="list-group-item d-flex align-items-start">
                                    <i class="bx bx-user me-2"></i>
                                    <div class="d-flex flex-column">
                                        <div class="h6 mb-1 fw-semibold">{{ $joined_student->student->firstname }}
                                            {{ $joined_student->student->lastname }}</div>
                                        <div>{{ $joined_student->student->student_id }}</div>
                                    </div>
                                </li>

                            @empty
                                <li class="list-group-item d-flex align-items-start justify-content-center">
                                    No Student Found
                                </li>
                            @endforelse

                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
