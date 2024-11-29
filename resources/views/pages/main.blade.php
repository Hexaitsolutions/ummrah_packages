@extends('layouts.frontend', ['title' => _lang('Hajj')])
@push('css')
@endpush

@section('content')
<title>Hajj & Umrah Packages in Pakistan 2023 | Umrah Travel Agencies</title>
<link rel="canonical" href="https://ummrahpackages.com/" />
<style>
    .move-right {
        right: -5rem;
    }

    .move-left {
        left: -5rem;
    }

    .sect {
        padding-top: 0 !important;
    }

    .no-hover:hover {
        color: white !important;
    }
</style>
<!--Hero Section start-->
@php
$count = 0;
@endphp
<div class="hero-section section position-relative">

    <!--Hero Slider start-->
    <div class="hero-slider section">
        @if ($slider->count()>0)

        @foreach ($slider as $slide_show)
        <!--Hero Item start-->
        <div class="hero-item"
            style="height:100vh;background-image: url({{asset('storage/slider/'.$slide_show->image)}});">
            <div class="container">
                <div class="row">
                    <div class="col-12">

                        <!--Hero Content start-->
                        <div class="hero-property-content text-center" data-aos="zoom-in-up">

                            <h6 class="title typewriter"><a href="">{{$slide_show?$slide_show->title:'Welcome'}} </a>
                            </h6>

                            <div class="type-wrap">
                                <span class="type">{{$slide_show?$slide_show->btn_text:'For Rent'}}</span>
                                <span class="price">{{$slide_show?$slide_show->sub_title:'$500'}}</span>
                            </div>

                            <div class="type-wrap">
                                <select class="form-control banner-location" name="location" id="location{{$count}}">
                                    <option selected disabled> Filter By Location </option>
                                    <option value=""> All Locations </option>
                                    @foreach ($locations as $location)
                                    <option value="{{$location->city}}"> {{$location->city}} </option>
                                    @endforeach
                                    {{-- <option value="Islamabad"> Islamabad </option>
                                    <option value="Karachi">Karachi</option>
                                    <option value="Multan">Multan</option>
                                    <option value="Peshawar">Peshawar</option> --}}
                                </select>
                            </div>
                            @php
                            $count ++;
                            @endphp

                        </div>
                        <!--Hero Content end-->

                    </div>
                </div>
            </div>
        </div>
        <!--Hero Item end-->
        @php
        break
        @endphp
        @endforeach
        @endif

    </div>
    <!--Hero Slider end-->

</div>
<!--Hero Section end-->

<!--Agent Section start-->
<div class="agent-section section pt-30 mb-4">
    <div class="container">

        <!--Section Title start-->
        <div class="row">
            <div class="col-md-12">
                <div class="section-title center">
                    <h2>ECONOMY PACKAGES</h2>
                </div>
            </div>
        </div>
        <!--Section Title end-->
        <div class=" d-flex flex-wrap justify-content-center">
            {{-- <div class="agent-carousel section"> --}}
                @if ($package->count()>0)

                @foreach ($package as $pkg_show)
                <!--Agent satrt-->
                {{-- <tr style="display: none">
                    <td>{{$pkg_show->location}}</td>
                </tr> --}}
                {{-- <div class="col-md-4" id="packagei">
                    <div class="agent"
                        onclick="window.location='{{ route('/',['type'=>$pkg_show->type,'slug'=>$pkg_show->slug,'id'=>$pkg_show->id]) }}'">
                        <div class="content index_card">
                            <h2 class="title"><a
                                    href="{{ route('/',['type'=>$pkg_show->type,'slug'=>$pkg_show->slug,'id'=>$pkg_show->id]) }}">
                                    {{strtoupper($pkg_show->name)}}</a></h2>
                            <h1 style="color: #E3973F;font-size:4em;">{{strtoupper($pkg_show->duration)}} Days</h1>
                            <h3 style="color: #B1B1B1;letter-spacing: 0.3rem;">
                                {{strtoupper($pkg_show->type)}} PACKAGE
                            </h3>
                            <h3 style="color: #B1B1B1;letter-spacing: 0.3rem;">
                                {{(strtoupper($pkg_show->location))}}
                            </h3>
                            <h2 class="title">{{$pkg_show->price}} {{get_option('currency_symbol')}} Per Person</h2>
                            <div class="row d-flex justify-content-center">
                                <a class="btn btn-warning mx-2"
                                    style="width:50px;font-size:25px;border-radius:0.3rem;background-color:#E3973F"
                                    type="button" href="#"><i class="fa fa-building"> </i> </a>
                                <a class="btn btn-warning"
                                    style="width:50px;font-size:25px;border-radius:0.3rem;background-color:#E3973F"
                                    type="button" href="#"> <i class="fa fa-plane"></i> </a>
                                <a class="btn btn-warning mx-2"
                                    style="width:50px;font-size:25px;border-radius:0.3rem;background-color:#E3973F"
                                    type="button" href="#"> <i class="fa fa-home"></i> </a>
                                <a class="btn btn-warning"
                                    style="width:50px;font-size:25px;border-radius:0.3rem;background-color:#E3973F"
                                    type="button" href="#"> <i class="fa fa-bus"></i> </a>
                            </div>
                        </div>
                    </div>
                </div> --}}
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
                @endif

                <!--Agent end-->

                {{--
            </div> --}}
        </div>
    </div>
</div>
<!--Agent Section end-->

<!--customize Section end-->
<div class="agent-section sect section mt-4 mb-4">
    <div class="custom-section" style="background-image: url({{url('/')}}/assets/img/custom.png)">
        <div class="centered-element">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center justify-content-center"
                        style="color:white;font-size:20px;text-align:center">
                        {{-- <h4 style="color:white">Get Your Customize Umrah Packages On Desired Dates</h4> --}}
                        {{-- <button class="btn btn-outline-light" id="custom">Get Customize Packages On Desired
                            Dates</button> --}}
                        <p style="color:white;font-size:20px;text-align:center">Get Customize Packages On Desired Dates
                        </p>
                    </div>
                    <div class="col-md-6" style="text-align: center">
                        <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#customizeModel"
                            style="background-color:#E3973F">GET YOUR UMRAH PACKAGE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--customize Section end-->

<!-- Featured Packages -->
{{-- <div
    class="agent-section sect section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-100 pb-lg-80 pb-md-70 pb-sm-60 pb-xs-50">
    --}}
    {{-- <div class="container">--}}

        {{--
        <!--Section Title start-->--}}
        {{-- <div class="row">--}}
            {{-- <div class="col-md-12 mb-60 mb-xs-30">--}}
                {{-- <div class="section-title center">--}}
                    {{-- <h2>FEATURED PACKAGES</h2>--}}
                    {{-- </div>--}}
                {{-- </div>--}}
            {{-- </div>--}}
        {{--
        <!--Section Title end-->--}}
        {{-- <div class="row">--}}
            {{-- <div class="col-md-12">--}}
                {{-- <table class="table table-borderless"
                    style="border-collapse:separate;border-spacing:0 5px;border-radius:10px;">--}}
                    {{-- <thead style="height: 100px;text-align:center">--}}
                        {{-- <tr>--}}
                            {{-- <th scope="col">
                                <h2 class="fw-bold tbl-h2">Agent</h2>
                            </th>--}}
                            {{-- <th scope="col">
                                <h2 class="fw-bold tbl-h2">Package</h2>
                            </th>--}}
                            {{-- <th scope="col">
                                <h2 class="fw-bold tbl-h2">Days</h2>
                            </th>--}}
                            {{-- <th scope="col">
                                <h2 class="fw-bold tbl-h2">Facilities</h2>
                            </th>--}}
                            {{-- <th scope="col">
                                <h2 class="fw-bold tbl-h2">2-Bed</h2>
                            </th>--}}
                            {{-- <th scope="col">
                                <h2 class="fw-bold tbl-h2">3-Bed</h2>
                            </th>--}}
                            {{-- <th scope="col">
                                <h2 class="fw-bold tbl-h2">4-Bed</h2>
                            </th>--}}
                            {{-- </tr>--}}
                        {{-- </thead>--}}
                    {{-- <tbody>--}}
                        {{-- @foreach ($featured_packages as $package)--}}
                        {{-- <tr class="shadow p-3 rounded" style="height: 100px;text-align:center;"
                            onclick="window.location='{{ route('/',['type'=>$package->type,'agency'=>$package->agency->name,'slug'=>$package->slug,'id'=>$package->id]) }}'">
                            --}}
                            {{-- <td><img class="rounded-circle" src="{{ $package->agency->img }}" height="120px"
                                    width="120px"></td>--}}
                            {{-- <td>{{$package->name}}</td>--}}
                            {{-- <td>{{$package->duration}} Days</td>--}}
                            {{-- <td>--}}
                                {{-- <a class="btn btn-warning"
                                    style="width:40px;font-size:15px;border-radius:0.3rem;background-color:#A5A5A5"
                                    type="button" href="#"><i class="fa fa-building"> </i> </a>--}}
                                {{-- <a class="btn btn-warning"
                                    style="width:40px;font-size:15px;border-radius:0.3rem;background-color:#A5A5A5"
                                    type="button" href="#"> <i class="fa fa-plane"></i> </a>--}}
                                {{-- <a class="btn btn-warning"
                                    style="width:40px;font-size:15px;border-radius:0.3rem;background-color:#A5A5A5"
                                    type="button" href="#"> <i class="fa fa-home"></i> </a><br>--}}
                                {{-- --}}{{-- <a class="btn btn-warning"
                                    style="width:40px;font-size:15px;border-radius:0.3rem;background-color:#A5A5A5"
                                    type="button" href="#"> <i class="fa fa-bus"></i> </a>--}}
                                {{-- <a class="btn btn-warning"
                                    style="width:40px;font-size:15px;border-radius:0.3rem;background-color:#A5A5A5"
                                    type="button" href="#"> <i class="fa fa-trophy"></i> </a> --}}
                                {{-- </td>--}}
                            {{-- <td>{{$package->price}} PKR</td>--}}
                            {{-- <td>{{$package->price}} PKR</td>--}}
                            {{-- <td>{{$package->price}} PKR</td>--}}
                            {{-- </tr>--}}
                        {{-- @endforeach--}}
                        {{-- </tbody>--}}
                    {{-- </table>--}}
                {{-- </div>--}}
            {{-- </div>--}}
        {{--
    </div>--}}
    {{-- </div>--}}
<!-- Featured Packages end -->
<!-- Top Travel Agents -->
<div
    class="agent-section sect section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-100 pb-lg-80 pb-md-70 pb-sm-60 pb-xs-50">
    <div class="container">

        <!--Section Title start-->
        <div class="row">
            <div class="col-md-12 mb-60 mb-xs-30">
                <div class="section-title center">
                    <h2>Top Travel Agents</h2>
                </div>
            </div>
        </div>
        <!--Section Title end-->
        <div class="row" >
            <div class="col-md-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"
                    style="{{ $agencies->count() === 1 ? 'display: flex; justify-content: center;' : '' }}">
                    <ol class="carousel-indicators">
                        @for ($i = 0; $i < ceil($agencies->count() / 3); $i++)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}"
                                class="{{ $i == 0 ? 'active' : '' }}"></li>
                            @endfor
                    </ol>
                    <div class="carousel-inner">
                        @for ($i = 0; $i < ceil($agencies->count() / 3); $i++)
                            <div class="carousel-item {{ $i == 0 ? 'active' : '' }}"
                                style="{{ $agencies->count() === 1 || $agencies->count() === 2 ? 'flex: 0 0 auto;' : '' }}">
                                <div class="row"
                                    style="{{ $agencies->count() === 1 || $agencies->count() === 2? 'display: flex; justify-content: center;' : '' }}">
                                    @for ($j = 0; $j < 3; $j++) @if(isset($agencies[$i * 3 + $j])) <div
                                        class="col-md-4 text-center">
                                        <img class="rounded-circle travel-agency"
                                            src="{{ $agencies[$i * 3 + $j]->img }}"
                                            style="height:150px; width: 150px; object-fit: cover;">
                                        <h3 class="fw-bold mt-3">{{ $agencies[$i * 3 + $j]->name }}</h3>
                                </div>
                                @endif
                                @endfor
                            </div>
                    </div>
                    @endfor
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon"
                        style="background-color: #E2963F; border-radius: 5px; width: 2rem; height: 2rem;"
                        aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon"
                        style="background-color: #E2963F; border-radius: 5px; width: 2rem; height: 2rem;"
                        aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>


    <!--Section Title end-->
   
</div>
</div>
<!--Services section start-->
<div
    class="agent-section sect section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-100 pb-lg-80 pb-md-70 pb-sm-60 pb-xs-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="p-5">
                    <h2 style="font-size: 24px">Looking for the best Hajj and Umrah packages in Pakistan for 2023?</h2>
                    <p class="lead" style="text-align: justify">Our packages offer a comprehensive and hassle-free
                        experience for pilgrims. From flights and accommodation to transportation and guidance with top
                        travel agencies in Pakistan, we take care of everything so that you can focus on your spiritual
                        journey.
                        Our packages are tailored to suit your needs and budget, ensuring that you have a memorable and
                        meaningful experience. Book your Hajj and Umrah packages for 2023 today and embark on a journey
                        of a lifetime with peace of mind! </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-5">
                    <img class="w-100  mt-4" src="{{asset('img/hajj-and-umrah-packages.jpg')}}" />
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Travel Agents end -->

<!--Welcome Khonike - Real Estate Bootstrap 4 Templatesection-->
<div
    class="feature-section sect section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-100 pb-lg-80 pb-md-70 pb-sm-60 pb-xs-50">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-60 mb-xs-30">
                <div class="section-title center">
                    <h2>Feature Property</h2>
                </div>
            </div>
        </div>
        <div class="feature-wrap row row-25">
            <!--Feature start-->
            <div class="col-lg-4 col-sm-6 col-12 mb-50 align-items-center">
                <div class="feature">
                    <div class="icon"><i class="pe-7s-bookmarks"></i></div>
                    <div class="content">
                        <h4>Cheap Rates</h4>
                        <p>Get incredible savings with our cheap rates. Enjoy quality without breaking the bank.</p>
                    </div>
                </div>
            </div>
            <!--Feature end-->

            <!--Feature start-->
            <div class="col-lg-4 col-sm-6 col-12 mb-50 align-items-center">
                <div class="feature">
                    <div class="icon"><i class="pe-7s-config"></i></div>
                    <div class="content">
                        <h4>Discount Offers</h4>
                        <p>Unlock exclusive discount offers and save big on your favorite Hajj and Umrah Package
                            services.</p>
                    </div>
                </div>
            </div>
            <!--Feature end-->

            <!--Feature start-->
            <div class="col-lg-4 col-sm-6 col-12 mb-50 align-items-center">
                <div class="feature">
                    <div class="icon"><i class="pe-7s-check"></i></div>
                    <div class="content">
                        <h4>Trust & Safety</h4>
                        <p>Your trust and safety are our top priorities. We ensure a secure and reliable experience for
                            all our customers.</p>
                    </div>
                </div>
            </div>
            <!--Feature end-->

            <!--Feature start-->
            <div class="col-lg-4 col-sm-6 col-12 mb-50 align-items-center">
                <div class="feature">
                    <div class="icon"><i class="pe-7s-signal"></i></div>
                    <div class="content">
                        <h4>Free Wifi</h4>
                        <p>Enjoy complimentary high-speed WiFi during your stay. Stay connected and surf the web with
                            our free WiFi service.</p>
                    </div>
                </div>
            </div>
            <!--Feature end-->

            <!--Feature start-->
            <div class="col-lg-4 col-sm-6 col-12 mb-50 align-items-center">
                <div class="feature">
                    <div class="icon"><i class="pe-7s-map"></i></div>
                    <div class="content">
                        <h4>Easy to Find</h4>
                        <p>Our location is easy to find, conveniently situated near major landmarks and accessible
                            transportation routes.</p>
                    </div>
                </div>
            </div>
            <!--Feature end-->

            <!--Feature start-->
            <div class="col-lg-4 col-sm-6 col-12 mb-50 align-items-center">
                <div class="feature">
                    <div class="icon"><i class="pe-7s-shield"></i></div>
                    <div class="content">
                        <h4>Reliable</h4>
                        <p>Count on our reliable services. We prioritize efficiency and consistency to meet your needs
                            with utmost dependability.</p>
                    </div>
                </div>
            </div>
            <!--Feature end-->

        </div>

    </div>
</div>
<!--Welcome Khonike - Real Estate Bootstrap 4 Templatesection end-->

{{-- <div
    class="service-section section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-70 pb-lg-50 pb-md-40 pb-sm-30 pb-xs-20">
    <div class="container">

        <!--Section Title start-->
        <div class="row">
            <div class="col-md-12 mb-60 mb-xs-30">
                <div class="section-title center">
                    <h1>Our Services</h1>
                </div>
            </div>
        </div>
        <!--Section Title end-->

        <div class="row row-30 align-items-center">
            <div class="col-lg-5 col-12 mb-30">
                <div class="property-slider-2">
                    @if ($service_slider->count()>0)
                    @foreach ($service_slider as $srl_show)
                    <div class="property-2">
                        <div class="property-inner">
                            <a href="" class="image"><img src="{{$srl_show->image}}" alt="" width="420"
                                    height="315"></a>
                            <div class="content">
                                <h4 class="title"><a href="#">{{$srl_show->title1}}</a></h4>
                                <span class="location">{{$srl_show->sub_title1}}</span>
                                <h4 class="type">Rent <span>{{$srl_show->title2}} <span>Month</span></span></h4>
                                <span class="location"> {{$srl_show->sub_title2}}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif

                </div>
            </div>
            <div class="col-lg-7 col-12">
                <div class="row row-20">
                    @if ($service->count()>0)
                    @foreach ($service as $sr_show)
                    <!--Service start-->
                    <div class="col-md-6 col-12 mb-30">
                        <div class="service">
                            <div class="service-inner">
                                <div class="head">
                                    <div class="icon"><img src="{{$sr_show->icon}}" alt="" width="40" height="42"></div>
                                    <h4>{{$sr_show->title}}</h4>
                                </div>
                                <div class="content">
                                    <p>{{$sr_show->text}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Service end-->
                    @endforeach
                    @endif

                </div>
            </div>
        </div>

    </div>
</div> --}}
<!--Services section end-->
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="customizeModel" role="dialog">
    <div class="modal-dialog modal-lg modal-newsletter modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h3 class="modal-title" style="font-weight:500;color:#004274">Customize Packages On Desired Dates</h3>
            </div>
            <form action="{{url('/customize-packages')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <label for="start">Start Date:</label>
                    <input type="date" required class="form-control" name="start_date">
                    <label for="end" class="my-2">End Date:</label>
                    <input type="date" required class="form-control" name="end_date">
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-default my-2" data-dismiss="modal"
                                style="float: right">Close</button>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success my-2"
                                style="background-color: #2b9c2b;float: right">Get</button>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal End -->
@stop
@push('scripts')
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>--}}
<script>
    $(document).ready(function(){

        $size = @json($slider);
        for(let i=0; i<$size.length; i++){
            $("#location"+i).change( function() {
              var value = this.value.toUpperCase();
              $("#filter-packages #packagei").filter(function() {
                  $(this).toggle($(this).find('h5').text().indexOf(value) > -1)
              });
            });
        }
    });
</script>
<script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "WebSite",
      "name": "Hajj and Umrah Packages",
      "url": "https://ummrahpackages.com/",
      "description": "Find the best Hajj & Umrah packages in Pakistan for 2023 with our trusted travel agency. Experience a comfortable and affordable religious journey.",
      "image": "https://ummrahpackages.com/assets/images/logo.png",
      "identifier": "",
      "copyrightYear": "2023",
      "creator": {
        "@type": "Organization",
        "logo": "https://ummrahpackages.com/assets/images/logo.png",
        "name": "Hajj and Umrah Packages",
        "url": "https://ummrahpackages.com/",
        "image": "https://ummrahpackages.com/storage/slider/sHjAYgfPO6JrNe1ng8itNfvLzj7np8ey3oHROBad.png"
      },
      "genre": "",
      "headline": "Hajj and Umrah Packages",
      "inLanguage": "en-US",
      "keywords": "Hajj and Umrah packages, hajj and Umrah packages in Pakistan, Hajj and Umrah packages 2023, Umrah Travel Agencies, Best Umrah travel agencies 2023",
      "position": "1"
    }
</script>
<script type="application/ld+json">
    {
    "@context": "https://schema.org/",
    "@type": "BreadcrumbList",
    "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Hajj and Umrah Packages",
        "item": "https://ummrahpackages.com/"
    }]
    }
</script>


<!-- start - This is for export functionality only -->
@endpush