
<style>
    .top-nav-text{
   font-family: "Poppins", sans-serif;;
  font-size:1em;
  color: #94C1E0;
  /* color: white; */
  text-align: center;
}
/* .btn {
    padding: 0;
    background-color: none;
} */
.top-nav{
  background-color: #004274;
}
/* .navbar-default{background:#3285D1;border-color: #3285D1;}
.navbar-default .navbar-nav > li > a{color:#FFF;}
.nav > li > a{margin:15px; font-size: 17px; color:#FFF;}
.nav .open > a, .nav .open > a:hover,
.nav .open > a:focus,
.nav > li > a:hover, .nav > li > a:focus{background-color:transparent !important;}

.navbar-brand{
    margin: 15px !important;
    padding: 13px !important;
    color: #fff !important;
    font-size: 2em !important;
    font-weight: bold !Important;
    } */

.navbar-toggle{margin-top:20px !important;}
.dropdown-menu{background:#fff !important;}
.navbar-login
{
    width: 350px;
    padding: 10px;
    padding-bottom: 0px;
}

.navbar-login-session
{
    padding: 10px;
    padding-bottom: 0px;
    padding-top: 0px;
}

.icon-size
{
    font-size: 87px;
}
    </style>


<div class="header-bottom menu-center">
    <div class="row top-nav">
        <div class="col-md-6 d-flex align-items-center justify-content-center top-nav-text">
          Providing The Best Hajj And Umrah Packages In An Easy Way
        </div>
        <div class="col-md-6 top-nav-text">
          <i class="fa fa-envelope" ></i>
            contact@ummrahpackages.com
          <a class="btn btn-default my-2" type= "button" href="#"><i  class="fa fa-twitter"> </i> </a>
          <a class="btn btn-default my-2" type= "button" href="#"> <i  class="fa fa-facebook-square"></i> </a>
          <a class="btn btn-default my-2" type= "button" href="#"> <i  class="fa fa-youtube-play"></i> </a>
          <a class="btn btn-default my-2" type= "button" href="#"> <i  class="fa fa-instagram"></i> </a>
        </div>
    </div>
</div>

<div class="header-bottom menu-center">
    <div class="container">
        <div class="row justify-content-between">
            <!--Logo start-->
            <div class="col mt-10 mb-10">
                <div class="logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo.png') }}" alt=""></a>
                </div>
            </div>
            <!--Logo end-->
            <!--Menu start-->
            <div class="col d-none d-lg-flex">
                <nav class="main-menu">
                    <ul>
                        <li class="{{ Request::is('/') ? ' active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                        <li class="{{ Request::is('umrah') ? ' active' : '' }}"><a href="{{ route('umrah') }}">Umrah  </a></li>
                         <li class="{{ Request::is('hajj') ? ' active' : '' }}"><a href="{{ route('hajj') }}">Hajj </a> </li>
                         <li class="{{ Request::is('blog') ? ' active' : '' }}"><a href="{{ route('blogs') }}">Blogs </a> </li>
                         <li class="{{ Request::is('about') ? ' active' : '' }}"><a href="{{ route('about') }}">About Us </a> </li>
                         <li class="{{ Request::is('contact') ? ' active' : '' }}"><a href="{{ route('contact') }}">Contact Us </a> </li>
                         @if (Auth::guard('user')->user())
                            <li class="dropdown" id="logedInmobile">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-user"></span> 
                                    <strong>{{Auth::guard('user')->user()->name}}</strong>
                                    <span class="glyphicon glyphicon-chevron-down"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="navbar-login">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="text-center">
                                                        <span class="glyphicon glyphicon-user icon-size"><img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"></span>
                                                    </p>
                                                </div>
                                                <div class="col-lg-8">
                                                    <p class="text-left"><strong>{{Auth::guard('user')->user()->name}}</strong></p>
                                                    <p class="text-left small">{{Auth::guard('user')->user()->email}}</p>
                                                    {{-- <p class="text-left">
                                                        <a href="{{ route('logout') }}" class="btn btn-primary btn-block btn-sm">Logout</a>
                                                    </p> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="navbar-login navbar-login-session mt-2">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p>
                                                        <a href="{{ route('profile',['id'=>Auth()->guard('user')->user()->id]) }}" style="background-color: #004274" class="btn btn-default btn-block">My Profile</a>
                                                        <a href="{{ route('profile',['id'=>Auth()->guard('user')->user()->id]) }}" class="btn btn-danger btn-block">Change Password</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li id="logOutmobile" class="{{ Request::is('/Vendor') ? ' active' : '' }}"><a href="{{ route('logout') }}">Logout</a></li>
                        @else
                            <li id="signInmobile" class="{{ Request::is('/Vendor') ? ' active' : '' }}">
                                <a href="#" data-toggle="modal" data-target="#loginModel">SignIn</a>
                            </li>
                            <li id="signOutmobile" class="{{ Request::is('/Vendor') ? ' active' : '' }}">
                                <a href="#" data-toggle="modal" data-target="#signupModel">SignUp</a>
                            </li>
                        @endif

                    </ul>
                </nav>
            </div>
            <!--Menu end-->
            <!--User start-->
            <div class="col mr-sm-50 mr-xs-50" style="max-width: 300px">
                <nav class="main-menu">
                    <ul>
                        @if (Auth::guard('user')->user())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-user"></span> 
                                <strong>{{Auth::guard('user')->user()->name}}</strong>
                                <span class="glyphicon glyphicon-chevron-down"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="navbar-login">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="text-center">
                                                    <span class="glyphicon glyphicon-user icon-size"><img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"></span>
                                                </p>
                                            </div>
                                            <div class="col-lg-8">
                                                <p class="text-left"><strong>{{Auth::guard('user')->user()->name}}</strong></p>
                                                <p class="text-left small">{{Auth::guard('user')->user()->email}}</p>
                                                {{-- <p class="text-left">
                                                    <a href="{{ route('logout') }}" class="btn btn-primary btn-block btn-sm">Logout</a>
                                                </p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="navbar-login navbar-login-session mt-2">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>
                                                    <a href="{{ route('profile',['id'=>Auth()->guard('user')->user()->id]) }}" style="background-color: #004274" class="btn btn-default btn-block">My Profile</a>
                                                    <a href="{{ route('profile',['id'=>Auth()->guard('user')->user()->id]) }}" class="btn btn-danger btn-block">Change Password</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('/Vendor') ? ' active' : '' }}"><a href="{{ route('logout') }}">Logout</a></li>
                        @else
                        <li class="{{ Request::is('/Vendor') ? ' active' : '' }}"><a href="#" data-toggle="modal" data-target="#loginModel">SignIn</a></li>
                        <li class="{{ Request::is('/Vendor') ? ' active' : '' }}"><a href="#" data-toggle="modal" data-target="#signupModel">SignUp</a></li>
                        @endif
                    </ul>
                </nav>
            </div>
            <!--User end-->
        </div>
        <!--Mobile Menu start-->
        <div class="row">
            <div class="col-12 d-flex d-lg-none">
                <div class="mobile-menu"></div>
            </div>
        </div>
        <!--Mobile Menu end-->
    </div>
</div>



@push('scripts')


@endpush
