@extends('layouts.frontend', ['title' => _lang('Package-Details')])
@push('css')
@endpush

@section('content')
<style>
  .checked{
    color: #E2963F
  }
</style>
<img src="{{asset('img/load.gif')}}" alt="" style="position: absolute;bottom: -20%;left: 50%;z-index: 1;display: none;" id="submiting">
<!--Page Banner Section start-->
<div class="page-banner-section section" style="background-image: url({{$package->banner}})">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1 class="page-banner-title">{{strtoupper($package->name)}}</h1>
        <ul class="page-breadcrumb">
          <li><a href="#">Home</a></li>
          <li class="active">{{$package->name}}</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!--Page Banner Section end-->
<!--Agent Section start-->
<div class="agent-section section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-70 pb-lg-50 pb-md-40 pb-sm-30 pb-xs-20">
  <div class="container">

    <div class="row row-25">


      <div class="col-lg-8">
        <table class="table table-bordered pb-8">
         <thead>
           <tr>
             <th>Booking Start:</th>
             <th>{{date('F jS, Y ', strtotime($package->start))}}</th>
             <th>To</th>
             <th>{{date('F jS, Y ', strtotime($package->end))}}</th>
           </tr>

           <tr>
             <th>{{$package->name}}</th>
             <th>{{$package->duration}} Duration</th>
             <th>Price Per Person</th>
             <th>{{$package->price}} {{get_option('currency_symbol')}}</th>
           </tr>
         </thead> 
       </table>
       <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">PACKAGE OVERVIEW</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">VISA DETAILS</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">HOTEL DETAILS</a>
        </li>

        {{-- <li class="nav-item">
          <a class="nav-link" id="pills-faq-tab" data-toggle="pill" href="#pills-faq" role="tab" aria-controls="pills-faq" aria-selected="false">FAQ</a>
        </li> --}}

        <li class="nav-item">
          <a class="nav-link" id="pills-policy-tab" data-toggle="pill" href="#pills-policy" role="tab" aria-controls="pills-policy" aria-selected="false">POLICY</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" id="pills-rate-tab" data-toggle="pill" href="#pills-rate" role="tab" aria-controls="pills-rate" aria-selected="false">Terms And Condition</a>
        </li>
      </ul>

      <!--     tab details -->
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
          <!--  first   tab details -->
          <div class="agent-content border p-4">
            <img src="{{ $package->agency->img }}" height="100" width="100" style="border: 1px solid #E2963F;border-radius:50%">
            <h3 class="title mt-2"> Overview: </h3>
            <p class="text-justify">Hajj is one of the five pillars of Islam. At Hajjumrahbd we try our level best to help the pilgrims of holy Makkah & Medinah. We offer affordable hajj packages at a reasonable cost. Our regular / exclusive / custom hajj packages are designed to provide the best experience and satisfaction to Pilgrims or the guest of Allah (SWT). Please check out our list of hajj packages 2022 from Pakistan.</p>
            <div class="row">
              <div class="col-md-12 col-12 mb-30">
                {!! $package->description !!}
              </div>
            </div>
          </div>
        </div>

        <!--                            secand tab details -->
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

          <div class="border p-4" style="color: black !important">
            {!! $package->itinary !!}
          </div>
        </div>

        <!--  three tab details -->
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

          <div class="border p-4">
            {!! $package->hotel !!}
          </div>
        </div>

        <!--  four tab details -->
        <div class="tab-pane fade" id="pills-faq" role="tabpanel" aria-labelledby="pills-faq-tab">
          <div class="border p-4">
            <div class="row">
              @foreach ($package->question as $ques)
              @if ($ques->ans)
             
              <ul>
                <li> <i data-brackets-id="4234" class="fa fa-share" aria-hidden="true"></i> &nbsp; <span>ASK : {{$ques->ques}}</span></li>
                <li><span style="color: #008000;">ANSWER {{$ques->ans}}</span></li>
              </ul>
               @endif
              @endforeach

              <hr>
              <div class="col-12">
                <p ><b style="color: #f00">Ask Question </b><span style="color: #008000;">
                  Please Fill Up and Submit
                </span> </p>
                <form action="{{ route('question') }}" id="question" method="post">
                  <div class="form-group">

                    <input type="text" class="form-control" name="qname" id="qname" placeholder="Name">
                    <input type="hidden" name="package_id" value="{{$package->id}}">
                  </div>
                  <div class="form-group">

                    <input type="text" class="form-control" name="qemail" id="qemail" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <textarea name="ques" id="ques" cols="4" rows="4" placeholder="Question"></textarea>
                  </div>
                   <div class="col-12 text-center"><button class="btn" id="submit" type="submit">Ask</button></div>
                  
                </form>
              </div>
            </div>
          </div>
        </div>

        <!--  five tab details -->
        <div class="tab-pane fade" id="pills-policy" role="tabpanel" aria-labelledby="pills-policy-tab">
          <div class="border p-4">
            {!! $package->policy !!}
          </div>
        </div>

        <!--  six tab details -->
        <div class="tab-pane fade" id="pills-rate" role="tabpanel" aria-labelledby="pills-rate-tab">
          <div class="border p-4">
            {!! $package->term_condition !!}
          </div>
        </div>
      </div>
      @php
      $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/details/".$package->id;

      @endphp

      <div class="sharethis-inline-share-buttons st-left st-has-labels  st-inline-share-buttons st-animated" id="st-1" style="margin-top: 10px">
        <div class="st-btn st-first" data-network="facebook" style="display: inline-block; color: #fff">
          <a href="javascript:void(0)"  onclick="javascript:genericSocialShare('https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link; ?>')">
            <img src="https://platform-cdn.sharethis.com/img/facebook.svg">
            <span class="st-label">Share</span>
          </a>
        </div>
        <div class="st-btn" data-network="twitter" style="display: inline-block; color: #fff">
          <a href="javascript:void(0)"  onclick="javascript:genericSocialShare('https://twitter.com/home?status=<?php echo $actual_link; ?>')">
            <img src="https://platform-cdn.sharethis.com/img/twitter.svg">
            <span class="st-label">Tweet</span>
          </a>
        </div>
        <div class="st-btn" data-network="pinterest" style="display: inline-block;color: #fff">
          <a href="javascript:void(0)" onclick="javascript:genericSocialShare('http://pinterest.com/pin/create/button/?url=<?php echo $actual_link; ?>]')">
            <img src="https://platform-cdn.sharethis.com/img/pinterest.svg">
            <span class="st-label">Pin</span>
          </a>
        </div>

      </div>


    </div>

    <!--Agent Content-->
    <div class="col-lg-4">
      <h3 class="pt-15 pb-10">Book Now</h3>
      <div class="contact-form-wrap">
        <div class="contact-form">
          <form id="content_form" action="{{ route('book') }}" method="post">
            <div class="row">
              <div class="col-12 mb-10">
                <input class="form-control" name="name" value="{{Auth::guard('user')->check() ? Auth::guard('user')->user()->name : ''}}" id="name" type="text" placeholder="Name">
                <input class="form-control" type="hidden" name="package_id" value="{{$package->id}}">
                <input class="form-control" type="hidden" name="user_id" value="{{Auth::guard('user')->check() ? Auth::guard('user')->user()->id : ''}}">
              </div>

              <div class="col-12 mb-10">
                <input class="form-control" name="email" id="email" value="{{Auth::guard('user')->check() ? Auth::guard('user')->user()->email : ''}}" type="email" placeholder="Email">
              </div>

              <div class=" col-12 mb-10">
                <input class="form-control" name="phone" id="phone" value="{{Auth::guard('user')->check() ? Auth::guard('user')->user()->phone : ''}}" type="text" placeholder="Phone">
              </div>

              <div class=" col-12 mb-10">
                <input class="form-control" name="subject" id="subject" type="text" placeholder="Subject">
              </div>

              <div class=" col-12 mb-10">
                <textarea class="form-control" name="messege" id="messege" cols="30" rows="10" class="" resize="false" placeholder="Messege"></textarea>
              </div>

              <div class="col-12 text-center"><button class="btn btn-danger" id="submit" type="submit">submit</button></div>
            </div>
          </form>
          <p class="form-messege"></p>
        </div>
      </div>
    </div>

    <div class="col-lg-8 my-3">
      <div class="tab-content">
          <div class="agent-content border p-4">
            <div class="row d-flex justify-content-center">
              <div class="col-md-12 col-lg-12 col-xl-12">
                <h3 class="title"> Comments: </h3>
                <div class="card" style="border: 0px">
                  <div class="card-body">
                    @foreach ($comments as $comment)
                    <div class="d-flex flex-start align-items-center">
                      <img class="rounded-circle shadow-1-strong me-3"
                        src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="avatar" width="60"
                        height="60" />
                      <div class="mx-2 mt-2">
                        <h6 class="fw-bold" style="color: black;font-weight:bold">{{$comment->user->name}}</h6>
                        <p class="text-muted small mb-0" style="color: black;font-weight:bold">
                          {{date('d-M-Y', strtotime($comment->created_at))}} At {{date('h : i A', strtotime($comment->created_at))}}
                        </p>
                      </div>
                    </div>
                      <div class="container">
                        <p class="mt-3 mb-4 pb-2">
                          {{$comment->code_body}}
                        </p>
                        <div class="small d-flex justify-content-start">
                          <a href="#!" class="d-flex align-items-center me-3">
                            <i class="fa fa-thumbs-up"></i>
                            <p class="mb-0 mx-1">Like</p>
                          </a>
                          <a href="#!" class="d-flex align-items-center me-3">
                            <i class="fa fa-reply ml-4"></i>
                            <p class="mb-0 mx-1">Reply</p>
                          </a>
                        </div>
                      </div><br>
                      @endforeach
                      <div class="small d-flex justify-content-center my-4">
                        <a href="#!" class="d-flex align-items-center me-3">
                            <i class="fa fa-arrow-down me-2"></i>
                            <p class="mb-0 mx-1">See All Comments </p>
                        </a>
                      </div>
                  </div>
                  <form id="comment_form" method="post" action="{{route('add_comment')}}">
                    @csrf
                    <input class="d-none" type="text" name="package_id" value="{{$package->id}}">
                    <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                      <div class="d-flex flex-start w-100">
                        <img class="rounded-circle shadow-1-strong mx-3"
                          src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="avatar" width="40"
                          height="40" />
                        <div class="form-outline w-100">
                          <textarea class="form-control" required id="textAreaExample" name="comment" rows="4" placeholder="Leave a comment"
                            style="background: #fff;"></textarea>
                        </div>
                      </div>
                      <div class="mt-2 pt-1" style="float: right">
                        <button type="submit" id="submit_comment" class="border-0 me-3 my-btn"><i class="fa fa-send fa-2x me-2"></i></button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
      </div>
  
    </div>
    <!--Review Content-->
    <div class="col-lg-4 my-3">
      <div class="tab-content">
        <div class="agent-content border p-4">
          <h1 class="pt-15 pb-10">Reviews</h1>
          <div class="card justify-content-center shadow border" style="height: 100px;background-color:#E2963F;border-radius:20px">
            <h3 style="text-align: center;color:white;font-size:2rem">
            @php
              $rate = $package->review->sum('stars');
              if($rate){
                $rate = $rate / count($package->review);
              }
            @endphp {{$rate}} Stars</h3>
          </div>
          <div class="contact-form-wrap my-2" style="text-align: center">
            @for ($i=0 ; $i < intval($rate) ; $i++)
              <span class="fa fa-star fa-2x checked"></span>
            @endfor
            @for ($i=0 ; $i < 5 - intval($rate) ; $i++)
              <span class="fa fa-star fa-2x"></span>
            @endfor
          </div>
          <div style="text-align: center">
            <a href="#review" class="trigger-btn bg-orange" data-toggle="modal" style="color: #E2963F"><p>Write a Review <i class="fa fa-pencil"></i></p></a>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</div>
<!--Agent Section end-->
<!-- Modal Review -->
<div id="review" class="modal fade" style="margin-top: 8rem">
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="my-4" style="text-align:center">
        <h5 class="fw-bold"> What's Your Opinion About Umrah Pakage</h5>
      </div>
      <div class="modal-body" style="padding:40px 50px;">
        @foreach ($reviews as $review)
        <div class="d-flex flex-start align-items-center">
          <img class="rounded-circle shadow-1-strong me-3"
            src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="avatar" width="60"
            height="60" />
          <div>
            <h6 class="fw-bold mb-1 mx-2" style="color: black;font-weight:bold">{{$review->user->name}}</h6>
            <p class="text-muted small mb-0 mx-2" style="color: black;font-weight:bold">
              {{date('d-M-Y', strtotime($review->created_at))}} At {{date('h:i', strtotime($review->created_at))}}
            </p>
          </div>
            <div class="mx-4">
              @for ($i = 0; $i < $review->stars; $i++)
              <span class="fa fa-star fa-1x checked "></span>
              @endfor
              @for ($i = 0; $i < 5 - $review->stars; $i++)
              <span class="fa fa-star fa-1x"></span>
              @endfor
            </div>
        </div>
        <div>
          <p class="mt-3 mb-4 pb-2">
              {{$review->code_body}}               
          </p>
        </div>
        @endforeach
      </div>
      <div class="modal-footer">
        <a class="btn btn-warning trigger-btn" href="#write-review" data-toggle="modal"  data-dismiss="modal">Write Review</a>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>   
<!-- Modal Write Review -->
<div id="write-review" class="modal fade" style="margin-top: 8rem">
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="modal-body" style="padding:40px 50px;">
          <form id="review_form" method="post" action="{{route('add_review')}}">
            @csrf
            <input class="d-none" type="text" name="package_id" value="{{$package->id}}">
            <div class="form-group" style="margin-bottom: 0">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Rate your experience</label>
              <div class="rate">
                  <input type="radio" id="star5" name="rate" value="5" />
                  <label for="star5" title="text">5 stars</label>
                  <input type="radio" id="star4" name="rate" value="4" />
                  <label for="star4" title="text">4 stars</label>
                  <input type="radio" id="star3" name="rate" value="3" />
                  <label for="star3" title="text">3 stars</label>
                  <input type="radio" id="star2" name="rate" value="2" />
                  <label for="star2" title="text">2 stars</label>
                  <input type="radio" id="star1" name="rate" value="1" />
                  <label for="star1" title="text">1 star</label>
              </div><br>
            </div><br>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Leave Message</label>
              <textarea type="text" class="form-control orange-input" required name="comment" rows="3" placeholder="Enter review"></textarea>
            </div><br>
            <button type="submit" id="submit_review" class="btn btn-danger btn-block"><span class="fa fa-login"></span> Send</button>
          </form>
      </div>
    </div>
  </div>
</div> 
@stop
@push('scripts')
<script>
  $('#content_form').on('submit', function(e) {
    e.preventDefault();
    $('#submit').hide();
    $('#submiting').show();
    $(".parsley-required").remove();
    var submit_url = $('#content_form').attr('action');
        //Start Ajax
        var formData = new FormData($("#content_form")[0]);
        $.ajax({
          url: submit_url,
          type: 'POST',
          data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function(data) {
              if(data.status == 'danger'){
                $.toast({
                  heading: 'Error',
                  text: data.message,
                  position: 'toast-bottom-center',
                  loaderBg:'#ff6849',
                  icon: 'error',
                  hideAfter: 2500

                });
                // $('#submit').show()
                $('#submiting').hide();
                // $("#content_form")[0].reset();
              }
              else {
                $.toast({
                  heading: 'Success',
                  text: data.message,
                  position: 'toast-bottom-center',
                  loaderBg:'#ff6849',
                  icon: 'success',
                  hideAfter: 3500

                });
                $('#submit').show();
                $('#submiting').hide();
                $("#content_form")[0].reset();
                if (data.goto) {
                 setTimeout(function(){

                   window.location.href=data.goto;
                 },2500);
               }
             }
           },
           error: function(data) {
            var jsonValue = $.parseJSON(data.responseText);
            const errors = jsonValue.errors;
            if (errors) {
              var i = 0;
              $.each(errors, function(key, value) {
                const first_item = Object.keys(errors)[i]
                const message = errors[first_item][0];

                if ($('#' + first_item).length>0) {
                  
                  $('#' + first_item).parsley().removeError('required', {
                    updateClass: true
                  });
                  $('#' + first_item).parsley().addError('required', {
                    message: value,
                    updateClass: true
                  });
                }
                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        $.toast({
                          heading: 'Error',
                          text: value,
                          position: 'toast-bottom-center',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                        i++;
                      });
            } else {
             $.toast({
              heading: 'Error',
              text: jsonValue.message,
              position: 'toast-bottom-center',
              loaderBg:'#ff6849',
              icon: 'error',
              hideAfter: 3500

            });

           }
           $('#submit').show();
           $('#submiting').hide();
         }
       });
      });

    $('#review_form').on('submit', function(e) {
    e.preventDefault();
    $('#submit_review').hide();
    $('#submiting').show();
    $(".parsley-required").remove();
    var submit_url = $('#review_form').attr('action');
        //Start Ajax
        var formData = new FormData($("#review_form")[0]);
        $.ajax({
          url: submit_url,
          type: 'POST',
          data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function(data) {
              if(data.status == 'danger'){
                $.toast({
                  heading: 'Error',
                  text: data.message,
                  position: 'toast-bottom-center',
                  loaderBg:'#ff6849',
                  icon: 'error',
                  hideAfter: 3500
                  
                });
                $('#submiting').hide();
              }
              else {
                $.toast({
                  heading: 'Success',
                  text: data.message,
                  position: 'toast-bottom-center',
                  loaderBg:'#ff6849',
                  icon: 'success',
                  hideAfter: 3500
                  
                });
                $('#submit_review').show();
                $('#submiting').hide();
                  $("#question")[0].reset();
                if (data.goto) {
                 setTimeout(function(){

                   window.location.href=data.goto;
                 },2500);
               }
             }
           },
           error: function(data) {
            var jsonValue = $.parseJSON(data.responseText);
            const errors = jsonValue.errors;
            if (errors) {
              var i = 0;
              $.each(errors, function(key, value) {
                const first_item = Object.keys(errors)[i]
                const message = errors[first_item][0];
                if ($('#' + first_item).length>0) {
                  $('#' + first_item).parsley().removeError('required', {
                    updateClass: true
                  });
                  $('#' + first_item).parsley().addError('required', {
                    message: value,
                    updateClass: true
                  });
                }
                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        $.toast({
                          heading: 'Error',
                          text: value,
                          position: 'toast-bottom-center',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500
                          
                        });
                        i++;
                      });
            } else {
             $.toast({
              heading: 'Error',
              text: jsonValue.message,
              position: 'toast-bottom-center',
              loaderBg:'#ff6849',
              icon: 'error',
              hideAfter: 3500
              
            });

           }
           $('#submit_review').show();
           $('#submiting').hide();
         }
       });
      });

    $('#comment_form').on('submit', function(e) {
    e.preventDefault();
    $('#submit_comment').hide();
    $('#submiting').show();
    $(".parsley-required").remove();
    var submit_url = $('#comment_form').attr('action');
        //Start Ajax
        var formData = new FormData($("#comment_form")[0]);
        $.ajax({
          url: submit_url,
          type: 'POST',
          data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function(data) {
              if(data.status == 'danger'){
                $.toast({
                  heading: 'Error',
                  text: data.message,
                  position: 'toast-bottom-center',
                  loaderBg:'#ff6849',
                  icon: 'error',
                  hideAfter: 3500
                  
                });
                $('#submiting').hide();
              }
              else {
                $.toast({
                  heading: 'Success',
                  text: data.message,
                  position: 'toast-bottom-center',
                  loaderBg:'#ff6849',
                  icon: 'success',
                  hideAfter: 3500
                  
                });
                $('#submit_comment').show();
                $('#submiting').hide();
                  $("#question")[0].reset();
                if (data.goto) {
                 setTimeout(function(){

                   window.location.href=data.goto;
                 },2500);
               }
             }
           },
           error: function(data) {
            var jsonValue = $.parseJSON(data.responseText);
            const errors = jsonValue.errors;
            if (errors) {
              var i = 0;
              $.each(errors, function(key, value) {
                const first_item = Object.keys(errors)[i]
                const message = errors[first_item][0];
                if ($('#' + first_item).length>0) {
                  $('#' + first_item).parsley().removeError('required', {
                    updateClass: true
                  });
                  $('#' + first_item).parsley().addError('required', {
                    message: value,
                    updateClass: true
                  });
                }
                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        $.toast({
                          heading: 'Error',
                          text: value,
                          position: 'toast-bottom-center',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500
                          
                        });
                        i++;
                      });
            } else {
             $.toast({
              heading: 'Error',
              text: jsonValue.message,
              position: 'toast-bottom-center',
              loaderBg:'#ff6849',
              icon: 'error',
              hideAfter: 3500
              
            });

           }
           $('#submit_comment').show();
           $('#submiting').hide();
         }
       });
      });
    </script>

    <script>
      function genericSocialShare(url){
        window.open(url,'sharer','toolbar=0,status=0,width=648,height=395');
        return true;
      }

    </script>
    <!-- start - This is for export functionality only -->
    @endpush