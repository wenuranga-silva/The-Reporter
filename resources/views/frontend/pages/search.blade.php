@extends('frontend.layouts.app')

@section('content')


<div class="container-fluid">

    <h5 class="csutom-5 mt-4 mb-3">Search Result For : {!! $txt !!}</h5>

    <div class="row g-4 justify-content-around mb-4">

        @foreach ($results as $result)

        <div class="col-lg-3 col-md-4 col-sm-8">
            <div class="bg-light rounded">
                <div class="rounded-top overflow-hidden">
                    <img src="{{ asset($result->PostImage[0]->image) }}" style="width: auto;height: 200px;" class="img-zoomin img-fluid rounded-top w-100" alt="image">
                </div>
                <div class="d-flex flex-column p-4">
                    <a href="{{ route('post' ,$result->id) }}" class="h5">{!! Str::length($result->title) > 100 ? Str::substr($result->title, 0, 110) . '...' : $result->title !!}</a>
                    <div class="d-flex justify-content-between">
                        <a href="javascript:void(0)" class="small text-body link-hover">by {!! $result->author->name !!}</a>
                        <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i> {!! $result->formatted_date !!}</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{ $results->links() }}

    </div>
</div>

@endsection
