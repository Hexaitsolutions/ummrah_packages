@extends('layouts.frontend', ['title' => _lang('Contact')])
@push('css')
@endpush
<style>
    .gradient-custom {
/* fallback for old browsers */
background: #f6d365;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
}
</style>
@section('content')

  <!--Page Banner Section start-->
    <div class="page-banner-section section" style="background-image: url({{$contactinfo?asset('storage/pages/'.$contactinfo->contact_image):''}})">
        <div class="container">
            <div class="row">
                <div class="col" data-aos="zoom-in-up">
                    <h1 class="page-banner-title">Profile</h1>
                    <ul class="page-breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Page Banner Section end-->

    <!--New property section start-->
    <div class="feature-section feature-section-border-top section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-60 pb-lg-40 pb-md-30 pb-sm-20 pb-xs-10">
        <div class="container">
            <div class="row row-25 align-items-center">

                <!--Feature Image start-->
                <div class="col-md-5 col-12 order-1 order-lg-2 mb-40" data-aos="zoom-in-up"data-aos-duration="2000">
                    <div class="contact-form">
                        <form action="{{ route('update') }}" method="post">
                            @csrf
                            <div class="row">
                                <input type="hidden" value="{{Auth()->guard('user')->user()->id}}" name="user_id">
                                <div class="col-md-6 col-12 mb-30"><input class="form-control" name="name" type="text" value="{{Auth()->guard('user')->user()->name}}"></div>
                                <div class="col-md-6 col-12 mb-30"><input class="form-control" name="email" type="email" value="{{Auth()->guard('user')->user()->email}}"></div>
                                <div class="col-md-6 col-12 mb-30"><input class="form-control" name="phone" type="text" value="{{Auth()->guard('user')->user()->phone}}"></div>
                                <div class="col-md-6 col-12 mb-30"><input class="form-control" minlength="8" name="password" type="password" placeholder="password"></div>
                                <div class="col-12 mb-30"><textarea class="form-control" name="messege" id="messege" placeholder="Country" value="{{Auth()->guard('user')->user()->country}}"></textarea></div>
                                <div class="col-12 text-center"><button class="btn btn-danger" type="submit">Change</button></div>
                            </div>
                        </form>
                        <p class="form-messege"></p>
                    </div>
                </div>
                <!--Feature Image end-->

                <div class="col-md-7 col-12 order-2 order-lg-1 mb-40" data-aos="zoom-in" data-aos-duration="3000">
                    <section class="vh-100" style="background-color: #f4f5f7;">
                        <div class="container h-100">
                          <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col col-md-12 mb-4 mb-lg-0">
                              <div class="card mb-3" style="border-radius: .5rem;">
                                <div class="row g-0">
                                  <div class="col-md-4 gradient-custom text-center text-white"
                                    style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"
                                      alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                                    <h5>{{Auth()->guard('user')->user()->name}}</h5>
                                    <p>Website User</p>
                                  </div>
                                  <div class="col-md-8">
                                    <div class="card-body p-4">
                                      <h6>Information</h6>
                                      <hr class="mt-0 mb-4">
                                      <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                          <h6>Email</h6>
                                          <p class="text-muted">{{Auth()->guard('user')->user()->email}}</p>
                                        </div>
                                        <div class="col-6 mb-3">
                                          <h6>Phone</h6>
                                          <p class="text-muted">{{Auth()->guard('user')->user()->phone}}</p>
                                        </div>
                                      </div>
                                      <h6>Projects</h6>
                                      <hr class="mt-0 mb-4">
                                      <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                          <h6>Total Packages</h6>
                                          <p class="text-muted">{{sizeof($packages)}}</p>
                                        </div>
                                        <div class="col-6 mb-3">
                                          <h6>Most Rated</h6>
                                          <p class="text-muted">0</p>
                                        </div>
                                      </div>
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
        </div>
    </div>
    <!--New property section end-->
    <!--Agent Section start-->
    @if (sizeof($packages) > 0)    
    <div class="agent-section section">
        <div class="container">

            <!--Section Title start-->
            <div class="row">
                <div class="col-md-12 mb-60 mb-xs-30">
                    <div class="section-title center">
                        <h2><span class="temp-blue">My Packages</span> </h2>
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
                            <h3 style="color: #E3973F;font-size:4em;">{{strtoupper($pkg_show->duration)}} Days</h3>
                            <h4 style="color: #B1B1B1;letter-spacing: 0.3rem;">
                                {{strtoupper($pkg_show->type)}} PACKAGE
                            </h4>
                            <h5 class="title">{{$pkg_show->price}} {{get_option('currency_symbol')}} Per Person</h5>
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
    @endif
@stop
