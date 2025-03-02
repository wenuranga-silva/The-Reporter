@extends('admin.layouts.app')

@section('title', 'Navigation')

@section('content')

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header d-flex">

                <h6 class="m-0 font-weight-bold text-primary align-content-center">Add Items To Navgation</h6>
            </div>

            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($categories as $i => $category)
                            <tr>

                                <th scope="row">{{ $i + 1 }}</th>
                                <td>{{ $category->name }}</td>
                                <td data-td="{{ $category->id }}">

                                    @if ($category->Nav == null)
                                        <a href="javascript:void(0);" data-id="{{ $category->id }}"
                                            class="btn btn-sm btn-primary shadow-sm btnAdd">Add</a>
                                    @else
                                        <a href="javascript:void(0);" data-td="{{ $category->id }}" data-id="{{ $category->nav->id }}"
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $(document).ready(function() {

            //// request to add a item
            $('body').on('click', '.btnAdd', function() {

                let id = $(this).data('id')

                $.ajax({
                    type: "POST",
                    url: '{{ route('admin.settings.nav.store') }}',
                    data: {
                        category: id
                    },
                    success: function(response) {

                        if (response.status == 'error') {

                            iziToast.warning({
                                title: 'W',
                                message: response.msg
                            })
                        } else {

                            iziToast.info({
                                title: 'Success',
                                message: response.msg
                            })

                            /// change btn

                            let btn = `<a href="javascript:void(0);" data-td="${id}" data-id="${ response.id }"
                                            class="btn btn-sm btn-warning shadow-sm btnRemove">Remove</a>`

                            $(`[data-td="${id}"]`).html(btn)
                        }

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

            //// request to remove item
            $('body').on('click', '.btnRemove', function() {

                let id = $(this).data('id')
                let url = '{{ route('admin.settings.nav.delete', ':id') }}'
                url = url.replace(':id', id)


                Swal.fire({

                    title: "Are you sure?",
                    text: '',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes ! Delete."
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            type: "DELETE",
                            url: url,
                            success: function(response) {

                                iziToast.info({
                                    title: 'Success',
                                    message: response.msg
                                })

                                /// change btn
                                let btn = `<a href="javascript:void(0);" data-id="${response.id}"
                                    class="btn btn-sm btn-primary shadow-sm btnAdd">Add</a>`

                                $(`[data-td="${response.id}"]`).html(btn)
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
