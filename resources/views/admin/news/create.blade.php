@extends('admin.layouts.app')

@section('title', 'News')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header d-flex">

                <h6 class="m-0 font-weight-bold text-primary align-content-center">Add News</h6>

                <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-primary shadow-sm"
                    style="margin-inline: auto 0 !important">
                    <i class="fas fa-angle-double-left"></i> Back
                </a>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.news.store') }}" method="POST" class="needs-validation" novalidate
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card">

                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary align-content-center">News Image</h6>
                        </div>

                        <div class="card-body">

                            <div class="mb-3 has-validation">
                                <label for="image" class="form-label">Image <code>*</code></label>
                                <img src="" alt="Image" class="d_img" width="180px">
                                <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                    id="image" name="image">
                            </div>

                            <div class="mb-3 has-validation">
                                <label for="image_caption" class="form-label">Image Caption</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('image_caption') ? 'is-invalid' : '' }}"
                                    id="image_caption" name="image_caption" value="{{ old('image_caption') }}">
                            </div>

                            <div class="mb-3 has-validation">
                                <label for="image_copyright_link" class="form-label">Image Copyright Link</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('image_copyright_link') ? 'is-invalid' : '' }}"
                                    id="image_copyright_link" name="image_copyright_link" value="{{ old('image_copyright_link') }}">
                            </div>

                            <div class="mb-3 has-validation">
                                <label for="image_copyright_text" class="form-label">Image Copyright Text</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('image_copyright_text') ? 'is-invalid' : '' }}"
                                    id="image_copyright_text" name="image_copyright_text" value="{{ old('image_copyright_text') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">

                        <div class="mb-3 has-validation">
                            <label for="title" class="form-label">Title <code>*</code></label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                id="title" name="title" value="{{ old('title') }}">
                        </div>

                        <div class="mb-3 has-validation">
                            <label class="form-label">Description <code>*</code></label>
                            <textarea id="summernote" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description">{{ old('description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12">

                                <div class="mb-3 has-validation">
                                    <label for="status" class="form-label">Status <code>*</code></label>
                                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                        name="status" id="status">
                                        <option value="yes" {{ old('status') == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no" {{ old('status') == 'no' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">

                                <div class="mb-3 has-validation">
                                    <label for="is_comment" class="form-label">Is Comment ? <code>*</code></label>
                                    <select class="form-control {{ $errors->has('is_comment') ? 'is-invalid' : '' }}"
                                        name="is_comment" id="is_comment">
                                        <option value="yes" {{ old('is_comment') == 'yes' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="no" {{ old('is_comment') == 'no' ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">

                                <div class="mb-3 has-validation">
                                    <label for="category" class="form-label">Category <code>*</code></label>
                                    <select id="category"
                                        class="selectpicker form-control {{ $errors->has('category') ? 'is-invalid' : '' }}"
                                        name="category" data-live-search="true">

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">

                            <label for="tag" class="form-label">Tags (<code>Multiple</code>)</label>
                            <select class="selectpicker form-control" name="tag[]" id="tag" data-live-search="true"
                                multiple>

                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Create News</button>
                    </div>

                    <div class="mb-3 mt-3">
                        <code>* Required Fields</code>
                    </div>
                </form>

            </div>
        </div>

    </div>

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#summernote').summernote()
            $('select').selectpicker()


            /// display user selected image
            $('body').on('change' ,'#image' , function (e) {

                let source = e.target.files[0]

                $('.d_img').attr('src', URL.createObjectURL(source))
                $('.d_img').css('display', 'block')
            })
        })

    </script>
@endpush
