@extends('layouts.frontend', ['title' => _lang('Latest Blogs')])
@push('css')
@endpush
<head>
    <title>Blogs- Umrah Packages </title>
    <meta name="description" content="Stay informed with our comprehensive blogs on Umrah packages. Learn about destinations, visas, rituals and more to plan a memorable journey.">
</head>

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
                <!--Section Title start-->
                <div class="row">
                    <div class="col-md-12 mb-60 mb-xs-30">
                        <div class="section-title center">
                            <h2>HAJJ UMRAH BLOGS</h2>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    @foreach ($blogs as $blog)
                      <div class="col-md-4 mt-4" data-aos="zoom-in-up" data-aos-duration="1500">
                        <div class="blog-card shadow profile-card-4">
                            <div class="">
                                <img class="card-img-top" height="200" src="{{$blog?asset('storage/pages/'.$blog->photo):''}}" alt="" style="border-top-right-radius: 17px;border-top-left-radius: 17px;">
                            </div>
                            <div class="card-body align-middle">
                                {{-- <p><small>Islamabad, March 8, 2022 </small></p> --}}
                                <p><small>Created By Admin </small></p>
                                <h4 class="fw-bold">{{$blog ? $blog->heading : '' }}</h4>
                                {{-- <p style="color: #B1B1B1">{{$blog ? substr($blog->description,0,90) : '' }} . . . . .  </p> --}}
                                <a href="{{ route('blog',$blog->slug) }}" class="btn btn-dark my-2 blog-btn" style="background: black;border-radius: 1rem;">Read More</a>
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
      }{
        "@type": "ListItem", 
        "position": 2, 
        "name": "Blogs",
        "item": "https://ummrahpackages.com/blogs"  
      },]
    }
</script>
@endpush