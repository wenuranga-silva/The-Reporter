@extends('admin.layouts.app')

@section('title', 'Video')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

@endpush

@section('content')

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header d-flex">

                <h6 class="m-0 font-weight-bold text-primary align-content-center">Add Videos</h6>

                <a href="{{ route('admin.video.index') }}" class="btn btn-sm btn-primary shadow-sm"
                    style="margin-inline: auto 0 !important">
                    <i class="fas fa-angle-double-left"></i> Back
                </a>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.video.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf


                    <div class="mb-3 has-validation">
                        <label for="url" class="form-label">Url <code>*</code></label>
                        <input type="url" class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}"
                            id="url" name="url" value="{{ old('url') }}">
                    </div>

                    <div class="mb-3 has-validation">
                        <label class="form-label">Description <code>*</code></label>
                            <textarea id="summernote" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="copyright_link" class="form-label">Video Copyright Link</label>
                        <input type="url"
                            class="form-control {{ $errors->has('copyright_link') ? 'is-invalid' : '' }}"
                            id="copyright_link" name="copyright_link" value="{{ old('copyright_link') }}">
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="copyright_text" class="form-label">Video Copyright Text</label>
                        <input type="text"
                            class="form-control {{ $errors->has('copyright_text') ? 'is-invalid' : '' }}"
                            id="copyright_text" name="copyright_text" value="{{ old('copyright_text') }}">
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="status" class="form-label">Status <code>*</code></label>
                        <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}"
                            name="status" id="status">
                            <option value="yes" {{ old('status') == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('status') == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

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

                    <div class="mt-4">

                        <label for="tag" class="form-label">Tags (<code>Multiple</code>)</label>
                        <select class="selectpicker form-control" name="tag[]" id="tag" data-live-search="true"
                            multiple>

                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
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
        })
    </script>
@endpush
