@extends('admin.layouts.app')

@section('title', 'Video - All')

@push('css')
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

@endpush

@section('content')

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header d-flex">

                <h6 class="m-0 font-weight-bold text-primary align-content-center">Videos - All</h6>
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
                    url: "{{ route('admin.video.change.status') }}",
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

        })
    </script>
@endpush
