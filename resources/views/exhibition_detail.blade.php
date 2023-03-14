@extends('layouts.app')

@section('title', $pageName)
@section('class', 'exhibutionDetailesPage exhibutionOverview')

@section('content')

<!-- Body Content -->
<div class="page exhibutionDetailesPage exhibutionOverview">
    <div class="container">
    <section class="exhibutionDetailes mt-5">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
            <div class="tab">
                <div class="exhibutionData text-center mb-5">
                <h2 class="exhibutionTitle">{{$exhibition->title}}</h2>
                <p class="exhibutionDate">{{ $exhibition->start_date }} - {{ $exhibition->end_date }}</p>
                </div>
                <ul class="nav nav-line" role="tablist">
                <li class="nav-item">
                    <a class="nav-link title-1 active" data-bs-toggle="tab" href="#exhibutionOverview" role="tab" aria-selected="true">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link title-1" data-bs-toggle="tab" href="#exhibutionGallery" role="tab" aria-selected="false">Gallery</a>
                </li>
                </ul>
                <div class="tab-content">
                <div class="tab-pane fade show active" id="exhibutionOverview" role="tabpanel">
                    <div class="blog-post">
                        <div class="blog-post-item">
                            <div class="text-center">
                                <img alt="{{$exhibition->title}}" src="{{asset('images/exhibition/cover_images/'.$exhibition->cover_image)}}" alt="" width="570" height="625">
                            </div>

                            <div class="content" style="margin-top:2em">
                                {!! $exhibition->description !!}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="exhibutionGallery" role="tabpanel">
                    <div class="isotope row row-30 row-lg-60 row-xl-100" data-lightgallery="">

                        @forelse($exhibition->images as $gallery)
                        <div class="col-xs-6 isotope-item filter-1">
                            <!-- Thumbnail-->
                            <div class="thumbnail">
                            <a class="thumbnail-media lightgallery-item" href="{{ asset('images/exhibition/'.$exhibition->id.'/'.$gallery->filename) }}">
                                <img class="thumbnail-img" src="{{ asset('images/exhibition/'.$exhibition->id.'/'.$gallery->filename) }}" alt="" />
                                <span class="thumbnail-caption"></span>
                            </a>
                            </div>
                        </div>
                        @empty
                        <div style="text-align: center;color: #839799;margin-bottom: 5em;">
                            <h3>No Gallery Item available !</h3>
                        </div>
                        @endforelse

                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
    </div>
</div>

@endsection
