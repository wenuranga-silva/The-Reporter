@extends('admin.layouts.app')

@section('title', 'Category')

@push('css')
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

@endpush

@section('content')

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header d-flex">

                <h6 class="m-0 font-weight-bold text-primary align-content-center">All Categories</h6>

                <a href="javascript:void(0)" class="btn btn-sm btn-primary shadow-sm" style="margin-inline: auto 0 !important"
                    data-toggle="modal" data-target="#createFormModal">
                    <i class="fas fa-plus"></i> Create Category</a>
            </div>

            <div class="card-body">

                {{ $dataTable->table() }}

            </div>
        </div>
    </div>

    {{-- Modal for creating Category --}}
    <div class="modal fade" id="createFormModal" tabindex="-1" aria-labelledby="createFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFormModalLabel">Create Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="needs-validation createFrom" novalidate>
                        @csrf

                        <div class="mb-3 has-validation">
                            <label for="category" class="form-label">Category Name <code>*</code></label>
                            <input type="text" class="category_name form-control" id="category" name="category_name"
                                required>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>

                        <div class="mb-3">
                            <code>* Required Fields</code>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal for updating Category --}}
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="needs-validation updateFrom" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3 has-validation">
                            <label for="category" class="form-label">Category Name <code>*</code></label>
                            <input type="text" class="category_name form-control" id="edit_category" name="category_name"
                                required>
                            <input type="hidden" id="category_id" name="id" value="">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                        <div class="mb-3">
                            <code>* Required Fields</code>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

@endpush

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}


    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            ////////// ctreate category
            $('.createFrom').on('submit', function(e) {
                e.preventDefault()

                let category = $('#category').val()

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.category.store') }}",
                    data: {
                        category_name: category
                    },
                    success: function(response) {

                        iziToast.info({
                            title: 'Success',
                            message: response.msg
                        });

                        $(".createFrom")[0].reset()
                        $('#categories-table').DataTable().ajax.reload()

                    },
                    error: function(data) {

                        let x = JSON.parse(data.responseText)

                        $.each(x.errors, function(index, val) {

                            iziToast.error({
                                title: 'Error',
                                message: val
                            })

                        })

                    }
                })
            })

            /////////  show edit form
            $('body').on('click' ,'.editBtn' , function (e) {
                e.preventDefault()

                $url = $(this).attr('href')

                $.ajax({
                    type: "GET",
                    url: $url,
                    success: function (response) {

                        $('#edit_category').val(response.name)
                        $('#category_id').val(response.id)

                    },
                    error: function (data) {

                        let x = JSON.parse(data.responseText)

                        $.each(x.errors, function(index, val) {

                            iziToast.error({
                                title: 'Error',
                                message: val
                            })

                        })

                    }
                })
            })

            /////////  update category
            $('.updateFrom').on('submit', function (e) {
                e.preventDefault()

                let id = $('#category_id').val()
                let category_name = $('#edit_category').val()

                let url = '{{ route('admin.category.update' ,':id') }}'
                url = url.replace(':id' ,id)

                $.ajax({
                    type: "PUT",
                    url: url,
                    data: {
                        category_name: category_name
                    },
                    success: function (response) {

                        iziToast.info({
                            title: 'Success',
                            message: response.msg
                        })

                        $('#updateModal').modal('hide')
                        $(".updateFrom")[0].reset()
                        $('#categories-table').DataTable().ajax.reload()

                    },
                    error: function (data) {

                        let x = JSON.parse(data.responseText)

                        $.each(x.errors, function(index, val) {

                            iziToast.error({
                                title: 'Error',
                                message: val
                            })

                        })

                    }
                })

            })

        })
    </script>
@endpush
