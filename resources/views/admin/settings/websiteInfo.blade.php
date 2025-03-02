@extends('admin.layouts.app')

@section('title', 'Web Info')

@push('css')

@endpush

@section('content')

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header d-flex">

                <h6 class="m-0 font-weight-bold text-primary align-content-center">Web Site's General Infomation</h6>
            </div>

            <div class="card-body">

                @if ($info == null)

                <form class="needs-validation" action="{{ route('admin.settings.webInfo.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="mb-3 has-validation">
                        <label for="mail" class="form-label">E-Mail <code>*</code></label>
                        <input type="email"
                            class="form-control {{ $errors->has('mail') ? 'is-invalid' : '' }}" id="mail"
                            name="mail" value="{{ old('mail') }}" required>
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="contact_number" class="form-label">Contact Number <code>*</code></label>
                        <input type="text"
                            class="form-control {{ $errors->has('contact_number') ? 'is-invalid' : '' }}" id="contact_number"
                            name="contact_number" value="{{ old('contact_number') }}" required>
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="address" class="form-label">Address <code>*</code></label>
                        <input type="text"
                            class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address"
                            name="address" value="{{ old('address') }}" required>
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="twitter_url" class="form-label">Twitter Url <code>*</code></label>
                        <input type="url"
                            class="form-control {{ $errors->has('twitter_url') ? 'is-invalid' : '' }}" id="twitter_url"
                            name="twitter_url" value="{{ old('twitter_url') }}" required>
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="facebook_url" class="form-label">Facebook Url <code>*</code></label>
                        <input type="url"
                            class="form-control {{ $errors->has('facebook_url') ? 'is-invalid' : '' }}" id="facebook_url"
                            name="facebook_url" value="{{ old('facebook_url') }}" required>
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="youtube_url" class="form-label">Youtube Url <code>*</code></label>
                        <input type="url"
                            class="form-control {{ $errors->has('youtube_url') ? 'is-invalid' : '' }}" id="youtube_url"
                            name="youtube_url" value="{{ old('youtube_url') }}" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Web Info</button>
                    </div>

                    <div class="mb-3">
                        <code>* Required Fields</code>
                    </div>
                </form>
                @else

                <form class="needs-validation" action="{{ route('admin.settings.webInfo.update' ,$info->id) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="mb-3 has-validation">
                        <label for="mail" class="form-label">E-Mail <code>*</code></label>
                        <input type="email"
                            class="form-control {{ $errors->has('mail') ? 'is-invalid' : '' }}" id="mail"
                            name="mail" value="{{ $info->email }}" required>
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="contact_number" class="form-label">Contact Number <code>*</code></label>
                        <input type="text"
                            class="form-control {{ $errors->has('contact_number') ? 'is-invalid' : '' }}" id="contact_number"
                            name="contact_number" value="{{ $info->tel }}" required>
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="address" class="form-label">Address <code>*</code></label>
                        <input type="text"
                            class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address"
                            name="address" value="{{ $info->address }}" required>
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="twitter_url" class="form-label">Twitter Url <code>*</code></label>
                        <input type="url"
                            class="form-control {{ $errors->has('twitter_url') ? 'is-invalid' : '' }}" id="twitter_url"
                            name="twitter_url" value="{{ $info->tw_url }}" required>
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="facebook_url" class="form-label">Facebook Url <code>*</code></label>
                        <input type="url"
                            class="form-control {{ $errors->has('facebook_url') ? 'is-invalid' : '' }}" id="facebook_url"
                            name="facebook_url" value="{{ $info->fb_url }}" required>
                    </div>

                    <div class="mb-3 has-validation">
                        <label for="youtube_url" class="form-label">Youtube Url <code>*</code></label>
                        <input type="url"
                            class="form-control {{ $errors->has('youtube_url') ? 'is-invalid' : '' }}" id="youtube_url"
                            name="youtube_url" value="{{ $info->yt_url }}" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Web Info</button>
                    </div>

                    <div class="mb-3">
                        <code>* Required Fields</code>
                    </div>
                </form>
                @endif

            </div>
        </div>
    </div>

@endsection

@push('js')

@endpush
