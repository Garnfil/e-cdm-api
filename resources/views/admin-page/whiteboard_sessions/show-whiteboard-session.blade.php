@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Whiteboard Session</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Whiteboard
                    Session
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.whiteboard-sessions.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i>
                    Back to
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
                                    <td>{{ $whiteboard_session->title }}</td>
                                </tr>
                                <tr>
                                    <td width="300" class="fw-bold">Session Code:</td>
                                    <td>{{ $whiteboard_session->session_code }}</td>
                                </tr>
                                <tr>
                                    <td width="300" class="fw-bold">Class:</td>
                                    <td>{{ $whiteboard_session->classroom->title }}</td>
                                </tr>
                                <tr>
                                    <td width="300" class="fw-bold">Agora Whiteboard Room UUID:</td>
                                    <td>{{ $whiteboard_session->agora_whiteboard_room_uuid ?? 'No UUID Found' }}</td>
                                </tr>
                                <tr>
                                    <td width="300" class="fw-bold">Status:</td>
                                    <td>
                                        <div class="badge bg-primary">{{ $whiteboard_session->status }}</div>
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
                        <h4 class="card-title">Participants </h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            {{-- @forelse ($conference_session->joined_students as $joined_student)
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
                            @endforelse --}}

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
