@extends('layouts.frontend', ['title' => _lang('Customize-Package')])
@push('css')
@endpush

@section('content')

        <!--Page Banner Section start-->
        <div class="page-banner-section section" style="    background-image: url({{$aboutinfo?asset('storage/pages/'.$aboutinfo->about_banner):''}})">
            <div class="container">
                <div class="row">
                    <div class="col" data-aos="zoom-in-up" data-aos-duration="1500" >
                        <h1 class="page-banner-title">Customize Packages</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">Customize Packages</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      

        <!--Agent Section start-->
        <div class="agent-section section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-lg-80 pb-md-70 pb-sm-60 pb-xs-50">
            <div class="container">
                <!--Section Title start-->
                <div class="row">
                    <div class="col-md-12 mb-60 mb-xs-30">
                        <div class="section-title center">
                            @if ($packages->count() > 0)
                            <h1>CUSTOMIZE PACKAGE</h1>
                            @else
                            <h1>NO PACKAGES ON DESIRED DATES</h1>
                            @endif
                        </div>
                    </div>
                </div>
                <!--Section Title end-->

                <div class="row d-flex justify-content-center">
                    <!--Agent satrt-->

                    @foreach ($packages as $pkg_show)
                  
                    <div class="col-md-4" data-aos="zoom-in-up" data-aos-duration="1500">
                        <div class="agent" onclick="window.location='{{ route('/',['type'=>$pkg_show->type,'agency'=>$pkg_show->agency->name,'slug'=>$pkg_show->slug,'id'=>$pkg_show->id]) }}'">
                            <div class="image">
                                <a class="img" href="{{ route('/',['type'=>$pkg_show->type,'agency'=>$pkg_show->agency->name,'slug'=>$pkg_show->slug,'id'=>$pkg_show->id]) }}"><img src="{{asset('storage/packege/'.$pkg_show->photo)}}" alt=""  width="270" height="202.5"></a>
                            </div>
                            {{-- {{$pkg_show->agency->img}} --}}
                            <div class="content index_card">
                                <img src="{{ $pkg_show->agency->img }}" alt="profile-image" class="profile"><br>
                                <h2 class="title"><a href="{{ route('/',['type'=>$pkg_show->type,'agency'=>$pkg_show->agency->name,'slug'=>$pkg_show->slug,'id'=>$pkg_show->id]) }}">
                                    {{strtoupper($pkg_show->name)}}</a></h2>
                                <h1 style="color: #E3973F;font-size:5em;">{{strtoupper($pkg_show->duration)}} Days</h1>
                                <h3 style="color: #B1B1B1;letter-spacing: 0.3rem;">
                                    {{strtoupper($pkg_show->type)}} PACKAGE
                                </h3>
                                <h2 class="title">{{$pkg_show->price}} {{get_option('currency_symbol')}} Per Person</h2>
                                <div class="row d-flex justify-content-center">
                                    <a class="btn btn-warning mx-2" style="width:50px;font-size:25px;border-radius:0.3rem;background-color:#E3973F" type="button" href="#"><i class="fa fa-globe"> </i> </a>  
                                    <a class="btn btn-warning" style="width:50px;font-size:25px;border-radius:0.3rem;background-color:#E3973F" type="button" href="#"> <i class="fa fa-plane"></i> </a> 
                                    <a class="btn btn-warning mx-2" style="width:50px;font-size:25px;border-radius:0.3rem;background-color:#E3973F" type="button" href="#"> <i class="fa fa-home"></i> </a>
                                    <a class="btn btn-warning" style="width:50px;font-size:25px;border-radius:0.3rem;background-color:#E3973F" type="button" href="#"> <i class="fa fa-bus"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

            </div>
        </div>
@stop
@push('scripts')

@endpush