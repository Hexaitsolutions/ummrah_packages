@extends('layouts.frontend', ['title' => _lang('Umrah-Package')])
@push('css')
@endpush

<head>
    <title>Umrah Packages in Pakistan 2023 With Best Umrah Agencies</title>
    <meta name="description"
        content="Discover the best Umrah packages in Pakistan for 2023 with top-rated Umrah travel agencies. Plan a seamless religious journey with peace of mind.">
</head>
<link rel="canonical" href="https://ummrahpackages.com/umrah" />
@section('content')

<!--Page Banner Section start-->
<div class="page-banner-section section"
    style="background-image: url({{$aboutinfo?asset('storage/pages/'.$aboutinfo->about_banner):''}})">
    <div class="container">
        <div class="row">
            <div class="col" data-aos="zoom-in-up" data-aos-duration="1500">
                <h1 class="page-banner-title">Umrah Packages</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Umrah Packages</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!--Agent Section start-->
<div class="agent-section section pt-30 pb-60">
    <div class="container">

        <!--Section Title start-->
        <div class="row">
            <div class="col-md-12 mb-60 mb-xs-30">
                <div class="section-title center">
                    <h2><span class="temp-blue">UMRAH</span><span class="temp-blue"> PACKAGES</span><span
                            class="temp-yellow"> IN</span> <span class="temp-yellow"> PAKISTAN</span> </h2>
                </div>
            </div>
        </div>
        <!--Section Title end-->

        <div class="row d-flex justify-content-center">
            <!--Agent satrt-->

            @foreach ($packages as $pkg_show)
            <div class="" id="packagei" style="width: 300px;padding: 20px;display: flex;flex-direction: column;">
                <div class="agent" style="margin-top: 0rem;border-radius: 10px"
                    onclick="window.location='{{ route('/',['type'=>$pkg_show->type,'agency'=>$pkg_show->agency->name,'slug'=>$pkg_show->slug,'id'=>$pkg_show->id]) }}'">
                    <div class="image">
                        <a class="img"
                            href="{{ route('/',['type'=>$pkg_show->type,'agency'=>$pkg_show->agency->name,'slug'=>$pkg_show->slug,'id'=>$pkg_show->id]) }}"><img
                                src="{{$pkg_show->photo}}"
                                style="width: 100%;border-top-right-radius: 10px;border-top-left-radius: 10px;"
                                height="150"></a>
                    </div>
                    {{-- {{$pkg_show->agency->img}} --}}
                    <div class="content index_card" style="border-top-right-radius: 0;border-top-left-radius: 0;">
                        <img src="{{$pkg_show->agency->img}}" alt="profile-image" class="profile">
                        <br>
                        <h3 class="title"><a
                                href="{{ route('/',['type'=>$pkg_show->type,'agency'=>$pkg_show->agency->name,'slug'=>$pkg_show->slug,'id'=>$pkg_show->id]) }}">
                                {{strtoupper($pkg_show->name)}}</a></h3>
                        <h4 style="color: #E3973F;">{{strtoupper($pkg_show->duration)}} Days</h4>
                        <h4 style="color: #B1B1B1">
                            {{strtoupper($pkg_show->type)}} PACKAGE
                        </h4>
                        <h5 style="color: #B1B1B1">
                            {{(strtoupper($pkg_show->location))}}
                        </h5>
                        <div class="row d-flex justify-content-center mt-3">
                            <a class="btn btn-warning mx-2 no-hover"
                                style="font-size:20px;border-radius:0.3rem;background-color:#E3973F" type="button"
                                href="#"><i class="fa fa-globe"> </i> </a>
                            <a class="btn btn-warning no-hover"
                                style="font-size:20px;border-radius:0.3rem;background-color:#E3973F" type="button"
                                href="#"> <i class="fa fa-plane"></i> </a>
                            <a class="btn btn-warning mx-2 no-hover"
                                style="font-size:20px;border-radius:0.3rem;background-color:#E3973F" type="button"
                                href="#"> <i class="fa fa-home"></i> </a>
                            <a class="btn btn-warning no-hover"
                                style="font-size:20px;border-radius:0.3rem;background-color:#E3973F" type="button"
                                href="#"> <i class="fa fa-bus"></i> </a>
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
<script type="application/ld+json">
    {
    "@context": "https://schema.org/", 
    "@type": "BreadcrumbList", 
    "itemListElement": [{
      "@type": "ListItem", 
      "position": 1, 
      "name": "Hajj and Umrah Packages",
      "item": "https://ummrahpackages.com/"  
    },{
      "@type": "ListItem", 
      "position": 2, 
      "name": "Umrah Packages in Pakistan",
      "item": "https://ummrahpackages.com/umrah"  
    }]
  }
</script>
<script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Umrah Packages",
    "url": "https://ummrahpackages.com/umrah",
    "logo": "https://ummrahpackages.com/assets/images/logo.png",
     "description":"Discover the best Umrah packages in Pakistan for 2023 with top-rated Umrah travel agencies. Plan a seamless religious journey with peace of mind.",
    "keywords": "Umrah Packages, umrah packages prices, umrah packages prices in pakistan, umrah packages 2023, umrah packages in pakistan"
  }
</script>

@endpush