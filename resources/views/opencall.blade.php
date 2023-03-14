@extends('layouts.app')

@section('title', $pageName)
@section('class', 'openCallPage')

@section('content')
<!-- Hero Section -->
<section class="herosection mt-0 mt-xl-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 m-0 p-4">
                <img class="image mx-auto w-100" src="/site_data/images28.jpg" alt="">
                <h2 class="fs-3 text-center text-uppercase">Open Calls</h2>
            </div>
        </div>
    </div>
</section>
<section class="works text-center text-md-start mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="row col-12 col-md-10">

                @forelse($pageData as $call)
                <div class="col-12 col-md-4 mb-4 card animated fadeIn" data-animate="{&quot;class&quot;:&quot;fadeIn&quot;}">
                    <a class="card-title" href="#">
                        <img src="{{asset('images/opencall/'.$call->cover_image)}}" class="card-img-top" alt="{{$call->title}}">
                    </a>
                    <div class="card-body py-2 px-2">
                        <a class="card-title" href="#">
                            <b>{{$call->title}}</b>
                        </a>
                        <p class="subtitle">{{$call->short_description}}</p>
                        <p class="subtitle">{{ $opencall->start_date }} - {{ $opencall->end_date }}</p>
                        <a class="btn btn-outline mt-3 p-2" href="{{ route('opencall.apply', $call->id) }}">Apply Now</a>
                    </div>
                </div>
                @empty
                <div style="text-align: center;color: #839799;margin-bottom: 5em;">
                    <h4>No Data Found !</h4>
                </div>
                @endforelse

            </div>
        </div>
    </div>
</section>
@endsection
