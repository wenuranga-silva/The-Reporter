@extends('admin.layouts.app')

@section('title', 'News')

@section('content')

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header d-flex">

                <h6 class="m-0 font-weight-bold text-primary align-content-center">News Images</h6>

                <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-primary shadow-sm"
                    style="margin-inline: auto 0 !important">
                    <i class="fas fa-angle-double-left"></i> Back
                </a>
            </div>

            <div class="card-body">

                <div class="d-flex align-items-baseline">

                    <h6 class="m-0 mb-3 font-weight-bold text-success align-content-center">Title - {!! $post_images->title !!}
                    </h6>
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm shadow-sm ml-auto" data-toggle="modal"
                        data-target="#imageAddModal"><i class="fas fa-plus"></i> Add Images</a>
                </div>

                <table class="table table-hover" id="imageTable">

                    <thead>

                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Caption</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($post_images->PostImage as $key => $image)
                            <tr id="{{ $image->image_id }}">
                                <td style="font-weight: bold" scope="row">{{ $key + 1 }}</td>
                                <td class="image_td">
                                    <img src="{{ asset($image->image) }}" alt="image" width="150px">
                                </td>
                                <td class="caption">
                                    {!! $image->caption !!}
                                </td>
                                <td>
                                    <select name="status" class="form-control image_status" style="width: 180px"
                                        data-post="{{ $post_images->id }}" data-id="{{ $image->image_id }}">
                                        <option value="yes" {{ $image->status == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="no" {{ $image->status == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </td>
                                <td style="width: 120px">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary" data-post="{{ $post_images->id }}"
                                        data-id="{{ $image->image_id }}" id="editImageBtn"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" style="margin-left: 10px" id="deleteImageBtn"
                                        data-post="{{ $post_images->id }}" data-id="{{ $image->image_id }}"><i
                                            class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>

    <!-- Add New Image Modal -->
    <div class="modal fade" id="imageAddModal" tabindex="-1" aria-labelledby="imageAddLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header" style="border-bottom: none !important">
                    <h5 class="modal-title text-primary" id="imageAddLabel">Add Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form method="post" id="addImageForm" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">

                            <label for="image" class="form-label">Image (<code>required</code>)</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <input type="hidden" name="id" value="{{ $post_images->id }}">
                        </div>

                        <div class="mb-3">

                            <label for="image_caption" class="form-label">Image Caption</label>
                            <input type="text" class="form-control" id="image_caption" name="image_caption">
                        </div>

                        <div class="mb-3">

                            <label for="image_copyLink" class="form-label">Copyright Link</label>
                            <input type="text" class="form-control" id="image_copyLink" name="copyrightLink">
                        </div>

                        <div class="mb-3">

                            <label for="image_copyText" class="form-label">Copyright Text</label>
                            <input type="text" class="form-control" id="image_copyText" name="copyrightText">
                        </div>

                        <div class="mb-3 d-flex">

                            <button type="submit" class="btn btn-primary ml-auto mr-3">Add Image</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Edit New Image Modal -->
    <div class="modal fade" id="imageEditModal" tabindex="-1" aria-labelledby="imageEditLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header" style="border-bottom: none !important">
                    <h5 class="modal-title text-primary" id="imageEditLabel">Edit Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form method="post" id="editImageForm" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <img src="" id="_img" alt="image" width="100px">
                        </div>

                        <div class="mb-3">

                            <label for="_image" class="form-label">Image (<code>required</code>)</label>
                            <input type="file" class="form-control" id="_image" name="image">
                            <input type="hidden" name="post_id" value="{{ $post_images->id }}">
                            <input type="hidden" id="image_id" name="image_id" value="">
                        </div>

                        <div class="mb-3">

                            <label for="_image_caption" class="form-label">Image Caption</label>
                            <input type="text" class="form-control" id="_image_caption" name="image_caption">
                        </div>

                        <div class="mb-3">

                            <label for="_image_copyLink" class="form-label">Copyright Link</label>
                            <input type="text" class="form-control" id="_image_copyLink" name="copyrightLink">
                        </div>

                        <div class="mb-3">

                            <label for="_image_copyText" class="form-label">Copyright Text</label>
                            <input type="text" class="form-control" id="_image_copyText" name="copyrightText">
                        </div>

                        <div class="mb-3 d-flex">

                            <button type="submit" class="btn btn-primary ml-auto mr-3">Update Image</button>
                        </div>
                    </form>

                </div>
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

            // request for adding new image
            $('body').on('submit', '#addImageForm', function(e) {
                e.preventDefault()

                //$form_data = $(this).serialize()
                let formData = new FormData(this)
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.news.image.store') }}",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        if (response.status == 'success') {

                            iziToast.info({
                                title: response.status,
                                message: response.msg
                            })

                            $('#imageAddModal').modal('hide')
                            $('#image').val('')
                            $('#image_caption').val('')
                            $('#image_copyLink').val('')
                            $('#image_copyText').val('')

                            // update row
                            $row = `
                            <tr id="${response.image_id}">
                                <th scope="row">New</th>
                                <td>
                                    <img src="${response.path}" alt="image" width="150px">
                                </td>
                                <td>
                                    ${response.caption}
                                </td>
                                <td>
                                    <select name="status" class="form-control image_status" style="width: 180px">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td style="width: 120px">
                                    <a href="javascript:void(0)" class="btn btn-primary" data-id="${response.image_id}"
                                        id="editImageBtn" data-post="${ response.id }"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="javascript:void(0)" id="deleteImageBtn" data-id="${response.image_id}" data-post="${ response.id }" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            `

                            $('#imageTable > tbody').append($row)

                        } else {

                            // display any error
                            iziToast.error({
                                title: response.status,
                                message: response.msg
                            })
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

            // edit button on click event
            $('body').on('click', '#editImageBtn', function() {

                let post = $(this).data('post')
                let image = $(this).data('id')
                let url = '{{ route('admin.news.image.details', [':post', ':image']) }}'
                url = url.replace(':post', post)
                url = url.replace(':image', image)

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {

                        $('#_img').attr('src', response.image)
                        $('#_image_caption').val(response.caption)
                        $('#_image_copyLink').val(response.copyright_link)
                        $('#_image_copyText').val(response.copyright_text)
                    }
                })

                $('#image_id').val(image)
                $('#imageEditModal').modal('show')
            })

            // request for updating image
            $('body').on('submit', '#editImageForm', function(e) {
                e.preventDefault()

                let formData = new FormData(this)
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.news.image.update') }}",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        if (response.status == 'success') {

                            iziToast.info({
                                title: response.status,
                                message: response.msg
                            })

                            $('#imageEditModal').modal('hide')
                            $('#_image').val('')
                            $('#_image_caption').val('')
                            $('#_image_copyLink').val('')
                            $('#_image_copyText').val('')

                            // update row
                            $('#' + response.image_id + ' > .caption').text(response.caption)

                            if (response.path != '') {

                                $('#' + response.image_id + ' > .image_td > img').attr('src',
                                    response.path)
                            }


                        } else {

                            // display any error
                            iziToast.error({
                                title: response.status,
                                message: response.msg
                            })
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

            // delete images
            $('body').on('click', '#deleteImageBtn', function(e) {

                let image_id = $(this).data('id')
                let post_id = $(this).data('post')

                let url = '{{ route('admin.news.image.delete', [':post', ':image']) }}'
                url = url.replace(":post", post_id)
                url = url.replace(":image", image_id)

                Swal.fire({

                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            type: "DELETE",
                            url: url,
                            success: function(response) {

                                if (response.status == 'success') {

                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success"
                                    })

                                    $('#' + image_id).remove()
                                } else if (response.status == 'error') {

                                    // for any errors
                                    Swal.fire({
                                        title: `${response.msg}`,
                                        icon: "error"
                                    })
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

                    }
                })

            })

            // change image status
            $('body').on('change', '.image_status', function() {

                let post_id = $(this).data('post')
                let image_id = $(this).data('id')
                let value = $(this).val()

                $.ajax({
                    type: "PUT",
                    url: '{{ route('admin.news.image.status') }}',
                    data: {
                        post_id: post_id,
                        image_id: image_id,
                        status: value
                    },
                    success: function(response) {

                        iziToast.info({
                            title: 'Info',
                            message: response.msg
                        })
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
