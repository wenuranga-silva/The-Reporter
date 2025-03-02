@extends('admin.layouts.app')

@section('title', 'Tag')

@push('css')
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

@endpush

@section('content')

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header d-flex">

                <h6 class="m-0 font-weight-bold text-primary align-content-center">All Tags</h6>

                <button class="btn btn-sm btn-primary shadow-sm" style="margin-inline: auto 0 !important" data-toggle="modal"
                    data-target="#createModel">
                    <i class="fas fa-plus"></i> Create Tag</button>
            </div>

            <div class="card-body">

                {{ $dataTable->table() }}

            </div>
        </div>
    </div>

    <!-- create tag model -->
    <div class="modal fade" id="createModel" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form class="needs-validation form" novalidate>
                        @csrf

                        <div class="mb-3 has-validation">
                            <label for="tag" class="form-label">Tag Name <code>*</code></label>
                            <input type="text" class="form-control {{ $errors->has('tag_name') ? 'is-invalid' : '' }}"
                                id="tag" name="tag_name" value="{{ old('tag_name') }}" required>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Create Tag</button>
                        </div>

                        <div class="mb-3">
                            <code>* Required Fields</code>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- edit tag model -->
    <div class="modal fade" id="editModel" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form class="needs-validation edit_form" novalidate>
                        @csrf

                        <div class="mb-3 has-validation">
                            <label for="tag" class="form-label">Tag Name <code>*</code></label>
                            <input type="text"
                                class="tag_name form-control {{ $errors->has('tag_name') ? 'is-invalid' : '' }}"
                                id="tag" name="tag_name" required>
                            <input type="hidden" name="id" class="tag_id">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update Tag</button>
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
            });

            // create form submit
            $('.form').on('submit', function(e) {
                e.preventDefault()

                let form_data = $(this).serialize()
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.tag.store') }}",
                    data: form_data,
                    success: function(response) {

                        iziToast.info({
                            title: 'Success',
                            message: response.msg
                        });

                        $(".form")[0].reset()
                        $('#tag-table').DataTable().ajax.reload()
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

            // edit form open
            $('body').on('click', '.edit_btn', function(e) {
                e.preventDefault()

                let url = $(this).attr('href')

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {

                        $('.tag_name').val(response.name)
                        $('.tag_id').val(response.id);
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

            // update data
            $('.edit_form').on('submit', function(e) {
                e.preventDefault()

                let id = $('.tag_id').val()
                let url = '{{ route('admin.tag.update', ':id') }}'
                url = url.replace(':id', id)

                let form_data = $(this).serialize()

                $.ajax({
                    type: "PUT",
                    url: url,
                    data: form_data,
                    success: function(response) {

                        iziToast.info({
                            title: 'Success',
                            message: response.msg
                        })

                        $('#editModel').modal('hide')
                        $(".edit_form")[0].reset()
                        $('#tag-table').DataTable().ajax.reload()

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

        })
    </script>
@endpush
