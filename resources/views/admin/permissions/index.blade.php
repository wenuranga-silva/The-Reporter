@extends('admin.layouts.app')

@section('title', 'Add /Remove Permissions')

@push('css')
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

@endpush

@section('content')

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header d-flex">

                <h6 class="m-0 font-weight-bold text-primary align-content-center">All Users</h6>
            </div>

            <div class="card-body">

                <table id="userTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Status</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $('#userTable').DataTable({
                'processing': true,
                'serverSide': true,
                'ajax': "{{ route('admin.permission.get.users') }}",
                'columns': [{
                        'data': 'name'
                    },
                    {
                        'data': 'email'
                    },
                    {
                        'data': 'status'
                    },
                    {
                        'data': 'role'
                    }
                ]
            })

            // change status
            $('body').on('change', '.change_status', function() {

                let val = $(this).val()
                let id = $(this).data('id')

                Swal.fire({

                    title: "Are you sure?",
                    text: "",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes ! Change Status"
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            type: "PUT",
                            url: "{{ route('admin.permission.change.status') }}",
                            data: {

                                id: id,
                                value: val
                            },
                            success: function(response) {

                                iziToast.info({
                                    title: 'Success',
                                    message: response.msg
                                })

                            },
                            error: function(data) {

                                let err = JSON.parse(data.responseText)

                                $.each(err.errors, function(index, value) {

                                    iziToast.error({
                                        title: 'Error',
                                        message: value
                                    })
                                })

                            }
                        })

                    }
                })


            })

            // change role
            $('body').on('change', '.change_role', function() {

                let val = $(this).val()
                let id = $(this).data('id')
                let mail = $(this).data('mail')

                Swal.fire({

                    title: "Are you sure?",
                    text: `User (${mail}) Role Will Be Changed !`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes ! Change Role"
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            type: "PUT",
                            url: "{{ route('admin.permission.change.role') }}",
                            data: {

                                id: id,
                                value: val
                            },
                            success: function(response) {

                                iziToast.info({
                                    title: 'Success',
                                    message: response.msg
                                })

                            },
                            error: function(data) {

                                let err = JSON.parse(data.responseText)

                                $.each(err.errors, function(index, value) {

                                    iziToast.error({
                                        title: 'Error',
                                        message: value
                                    })
                                })

                            }
                        })

                    }
                })


            })

        })
    </script>
@endpush
