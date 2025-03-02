@extends('admin.layouts.app')

@section('title', 'Category - Home')

@section('content')

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header d-flex">

                <h6 class="m-0 font-weight-bold text-primary align-content-center">Add Categories To The Home</h6>

            </div>

            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($categories as $key => $category)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{!! $category->name !!}</td>
                                <td data-td="{{ $category->id }}">

                                    @if ($category->impCat == null)
                                        <a href="javascript:void(0);" data-id="{{ $category->id }}"
                                            class="btn btn-sm btn-primary shadow-sm btnAdd">Add</a>
                                    @else
                                        <a href="javascript:void(0);" data-id="{{ $category->id }}"
                                            class="btn btn-sm btn-warning shadow-sm btnRemove">Remove</a>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection

@push('js')
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

            /// add
            $('body').on('click', '.btnAdd', function() {

                let id = $(this).data('id')

                Swal.fire({

                    title: "Are you sure?",
                    text: '',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes ! Add."
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin.category-home.store') }}",
                            data: {
                                id: id
                            },
                            success: function(response) {

                                iziToast.info({
                                    title: 'Success',
                                    message: response.msg
                                })

                                /// change btn
                                let btn = `<a href="javascript:void(0);" data-id="${id}"
                                    class="btn btn-sm btn-warning shadow-sm btnRemove">Remove</a>`

                                $(`[data-td="${id}"]`).html(btn)

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

                    }
                })

            })


            /// remove
            $('body').on('click', '.btnRemove', function() {

                let id = $(this).data('id')
                let url = '{{ route('admin.category-home.destroy' ,':id') }}';
                url = url.replace(':id' ,id)

                Swal.fire({

                    title: "Are you sure?",
                    text: '',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes ! Remove."
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            type: "DELETE",
                            url: url,
                            data: {
                                id: id
                            },
                            success: function(response) {

                                iziToast.info({
                                    title: 'Success',
                                    message: response.msg
                                })

                                /// change btn
                                let btn = `<a href="javascript:void(0);" data-id="${id}"
                                    class="btn btn-sm btn-primary shadow-sm btnAdd">Add</a>`

                                $(`[data-td="${id}"]`).html(btn)

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

                    }
                })

            })

        })
    </script>
@endpush
