@php
    $contact = App\Page::where('key', 'contact')->select('key','value')->first();
           $contactinfo =null;
    if ($contact) {
        $contactinfo=json_decode($contact->value);
     }
@endphp

            <!--Footer Top start-->
            <div class="footer-top section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-60 pb-lg-40 pb-md-30 pb-sm-20 pb-xs-10">
                <div class="container">
                    <div class="row row-25">

                        <!--Footer Widget start-->
                        <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                            <div class="logo">
                                <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="" width="160" height="70"></a>
                            </div>
                            <p>Get in Touch with Us through Social Media.</p>
                            <div class="footer-social">
                                <a href="{{URL::to(get_option('fb'))}}" class="facebook"><i class="fa fa-facebook"></i></a>
                                <a href="{{URL::to(get_option('twiter'))}}" class="twitter"><i class="fa fa-twitter"></i></a>
                                <a href="{{URL::to(get_option('linkedin'))}}" class="linkedin"><i class="fa fa-linkedin"></i></a>
                                <a href="{{URL::to(get_option('youtube'))}}" class="pinterest"><i class="fa fa-pinterest-p"></i></a>
                            </div>
                        </div>
                        <!--Footer Widget end-->

                        <!--Footer Widget start-->
                        <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                            <h4 class="title"><span class="text temp-orange">Contact us</span><span class="shape"></span></h4>
                            <ul>
                                <li><i class="fa fa-map-o"></i><span>{{$contactinfo?$contactinfo->contact_address:null}}</span></li>
                                <li><i class="fa fa-phone"></i><span> {!! $contactinfo?$contactinfo->contact_phone:null!!}</span></li>
                                <li><i class="fa fa-envelope-o"></i><span>{!! $contactinfo?$contactinfo->contact_email:null  !!}</span></li>
                            </ul>
                        </div>
                        <!--Footer Widget end-->

                        <!--Footer Widget start-->
                        <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                            <h4 class="title"><span class="text temp-orange">Useful links</span><span class="shape"></span></h4>
                            <ul>
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                <li><a href="{{ route('faq') }}">FAQs</a></li>
                                <li><a href="{{ route('terms-of-condition') }}">Terms of Condition</a></li>
                                <li><a href="{{ route('policy') }}">Privacy Policy</a></li>
                            </ul>
                        </div>
                        <!--Footer Widget end-->

                        <!--Footer Widget start-->
                        <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                            <h4 class="title"><span class="text temp-orange">Newsletter</span><span class="shape"></span></h4>

                            <p>Subscribe our newsletter and get all latest news about our latest properties, promotions, offers and discount</p>

                            <form id="mc_form" action="{{ route('subscibers') }}" class="mc-form footer-newsletter" method="post" >
                                <input id="email" type="email" autocomplete="off" name="sub_email" placeholder="Email Here.." />
                                <button id="mc-submit" style="background-color: #ae8b42 " type="submit"><i class="fa fa-paper-plane-o"></i></button>
                            </form>
                            <!-- mailchimp-alerts Start -->
                            <div class="mailchimp-alerts text-centre">
                                <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                                <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                                <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                            </div><!-- mailchimp-alerts end -->

                        </div>
                        <!--Footer Widget end-->

                    </div>
                </div>
            </div>
            <!--Footer Top end-->

            <!--Footer bottom start-->
            <div class="footer-bottom section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="copyright text-center">
                                <p>Copyright &copy;
                                    <script>
                                        var dt = new Date();
                                        document.write(dt.toLocaleDateString('en-pk', { year:"numeric"})) 
                                    </script> 
                                    <a href="#">{{ get_option('company_name')}}</a>. All rights reserved.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Footer bottom end-->