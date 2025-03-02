@extends('admin.layouts.app')

@section('title', 'News')

@push('css')
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

@endpush

@section('content')

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header d-flex">

                <h6 class="m-0 font-weight-bold text-primary align-content-center">All News (<code>Created By
                        {!! Auth::user()->name !!}</code>)</h6>

                <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-primary shadow-sm"
                    style="margin-inline: auto 0 !important">
                    <i class="fas fa-plus"></i> Create News</a>
            </div>

            <div class="card-body">

                {{ $dataTable->table() }}

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

            // change status
            $('body').on('change', '.change_status', function() {

                let val = $(this).val()
                let id = $(this).data('id')

                $.ajax({
                    type: "PUT",
                    url: "{{ route('admin.news.change.status') }}",
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
            })

            // change is comment
            $('body').on('change', '.change_comment', function() {

                let val = $(this).val()
                let id = $(this).data('id')

                $.ajax({
                    type: "PUT",
                    url: "{{ route('admin.news.change.comment') }}",
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
            })

        });
    </script>
@endpush
