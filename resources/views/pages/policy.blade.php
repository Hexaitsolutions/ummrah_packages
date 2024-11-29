@extends('layouts.frontend', ['title' => _lang('About Us')])
@push('css')
@endpush

@section('content')

        <!--Page Banner Section start-->
        <div class="page-banner-section section" style="    background-image: url({{$aboutinfo?asset('storage/pages/'.$aboutinfo->about_banner):''}})">
            <div class="container">
                <div class="row">
                    <div class="col" data-aos="zoom-in-up" data-aos-duration="1500" >
                        <h1 class="page-banner-title">{{$title}}</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">{{$title}}</li>
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

                    <!--Feature Image start-->
                    <div class="col-lg-5 col-12 order-1 order-lg-2 mb-40" data-aos="zoom-in-up"data-aos-duration="2000">
                        <div class="feature-image"><img class="w-100" src="{{$aboutinfo?asset('storage/pages/'.$aboutinfo->about_image):''}}" alt=""></div>
                    </div>
                    <!--Feature Image end-->

                    <div class="col-lg-7 col-12 order-2 order-lg-1 mb-40" data-aos="zoom-in" data-aos-duration="3000">
                        <div class="row">
                            <div class="col">
                                <div class="about-content">
                                    @if ($policy)
                                        <h3 style="line-height: 1.5;">
                                          We are dedicated to safeguard your privacy and ensuring the security of your personal information.
                                          We prioritize transparency and trust while you use our website. Our priority is to prioritize 
                                          the privacy and security of our users. We understand the importance of protecting your personal 
                                          information while using our website. Our Privacy Policy outlines the types of data we collect, 
                                          how we use it, and the measures we take to safeguard your information.
                                        </h3>
                                        <h3 style="line-height: 1.5;">
                                          We gather basic data such as your name, contact details, and preferences when you interact with our website. 
                                          This information helps us improve your user experience. This website also uses cookies and similar 
                                          technologies to analyze website traffic and understand how our users engage with our content.
                                        </h3>
                                        <h3 style="line-height: 1.5;">
                                          We assure you that we will never share, sell, or rent your personal information to any third parties without 
                                          your explicit consent. We may disclose your data when required by law or to protect our legal rights.
                                        </h3>
                                        <h3 style="line-height: 1.5;">
                                          To ensure the security of your information, we implement appropriate administrative, technical, and physical 
                                          measures. However, please note that no method of transmission over the internet or electronic storage is 
                                          completely secure, and thus, we cannot guarantee absolute protection.
                                        </h3>
                                        <h3 style="line-height: 1.5;">
                                          We may update our Privacy Policy from time to time. We encourage you to review it periodically 
                                          for any changes. By using our website, you acknowledge that you have read, understood, and agreed
                                           to our Privacy Policy. If you have any questions or concerns, please feel free to contact us.
                                        </h3>
                                        @else
                                        <h3 style="line-height: 1.5;">
                                            By using our website and services, you agree to comply with our Terms of Use. 
                                            You agree to use our website and services only for lawful purposes and not to transmit 
                                            any content that is unlawful, harmful, threatening, abusive, harassing, defamatory, vulgar, 
                                            obscene, or invasive of another's privacy. You are responsible for maintaining the confidentiality 
                                            of your account information and password. We reserve the right to modify or terminate our website 
                                            and services at any time, without notice. We are not responsible for any loss or damage resulting 
                                            from your use of our website or services. These terms and conditions are governed by the laws of
                                            [insert jurisdiction] and any dispute arising under these terms and conditions shall be resolved 
                                            in the courts of [insert jurisdiction].
                                        </h3>
                                    @endif
                                {{-- <h2>{!!  $aboutinfo?$aboutinfo->about_content:'' !!}</h2> --}}
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