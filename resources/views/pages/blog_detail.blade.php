@extends('layouts.frontend', ['title' => _lang('Latest Blogs')])
@push('css')
@endpush

@section('content')
        <!--Page Banner Section start-->
        <div class="page-banner-section section" style="background-image: url({{$aboutinfo?asset('storage/pages/'.$aboutinfo->about_banner):''}})">
            <div class="container">
                <div class="row">
                    <div class="col" data-aos="zoom-in-up">
                        <h1 class="page-banner-title">Latest Blogs</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">Blogs</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--Page Banner Section end-->

        <!--Welcome Satt It - Real Estate Bootstrap 4 Templatesection-->
        <div class="feature-section feature-section-border-top section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-60 pb-lg-40 pb-md-30 pb-sm-20 pb-xs-10">
            <div class="container">
                <div class="row row-25 align-items-center">
                    <div class="col-md-8">
                        {{-- <div class="card shadow rounded mb-3" data-aos="zoom-in-up"> --}}
                            <img src="{{$bloginfo?asset('storage/pages/'.$bloginfo->photo):''}}" class="card-img-top" alt="..." height="350">
                            <div class="card-body">
                                <p class="card-text"><small class="text-muted">Updated At {{date('d-m-Y', strtotime($bloginfo->created_at))}}</small></p>
                                <h3 class="card-title">{{$bloginfo ? $bloginfo->heading : '' }}</h3>
                                <h4 class="card-text">{!! $bloginfo ? $bloginfo->description: '' !!}</h4>
                            </div>
                        {{-- </div> --}}
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card shadow rounded" data-aos="zoom-in-up">
                          <div class="card-body">
                            <h5>Hajj Umrah Packages</h5>
                            <hr/>
                            <p>Welcome! We strive to make this journey of our pilgrims, easy and comfortable at lowest possible prices.</p>
                          </div>
                        </div><br/>
                        <div class="card shadow rounded" data-aos="zoom-in-up">
                          <div class="card-body">
                            <h5>Contacts</h5>
                            <hr/>
                            <ul>
                                <li><i class="fa fa-phone"></i><span> {{$contactinfo ? $contactinfo->contact_phone : ""}}</span></li>
                                <li><i class="fa fa-envelope-o"></i><span> {{$contactinfo ? $contactinfo->contact_email : ""}}</span></li>
                            </ul>
                          </div>
                        </div> <br/>
                        <div class="card shadow rounded">
                          <div class="card-body">
                            <h5>Presentation</h5>
                            <hr/>
                            <div class="ratio ratio-16x9">
                                <iframe class="w-100" src="https://www.youtube.com/embed/qZ9n4V9lZkE" title="YouTube video" allowfullscreen></iframe>
                            </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop
@push('scripts')

@endpush