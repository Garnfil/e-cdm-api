@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Video Conference Sessions</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Video
                    Conference Sessions
                </h6>
            </div>
        </section>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive text-wrap">
                    <table class="table table-striped w-100" id="video-conference-sessions-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Session Code</th>
                                <th>Scheduled Datetime</th>
                                <th>Class</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let table;

            function loadTable() {
                table = $('#video-conference-sessions-table').DataTable({
                    processing: true,
                    pageLength: 10,
                    responsive: true,
                    serverSide: true,
                    lengthChange: false,
                    ordering: true,
                    searching: false,
                    ajax: {
                        url: "{{ route('admin.video-conference-sessions.index') }}",
                        data: function(d) {
                            d.search = $('#search-field').val(),
                                d.type = $('#type-field').val(),
                                d.status = $('#status-field').val()
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'session_code',
                            name: 'session_code'
                        },
                        {
                            data: 'scheduled_datetime',
                            name: 'scheduled_datetime'
                        },
                        {
                            data: 'class',
                            name: 'class'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                        }
                    ],
                    order: [
                        [0, 'desc'] // Sort by the first column (index 0) in descending order
                    ]
                });
            }

            $("#search-field").on('input', function(e) {
                if (table) {
                    table.draw();
                }
            })

            $('#type-field').change(function(e) {
                if (table) {
                    table.draw();
                }
            })

            $(document).on("click", ".remove-btn", function(e) {
                let id = $(this).attr("id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Remove video conference session from list",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0b4c11',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/video-conference-sessions/${id}`,
                            method: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(response) {
                                Swal.fire('Removed!', response.message, 'success').then(
                                    result => {
                                        if (result.isConfirmed) {
                                            toastr.success(response.message, 'Success');
                                            location.reload();
                                        }
                                    })
                            }
                        })
                    }
                })
            });

            loadTable();
        </script>
    @endpush
@endsection