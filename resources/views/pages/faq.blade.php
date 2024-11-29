@extends('layouts.frontend', ['title' => _lang('FAQ')])
<link rel="canonical" href="https://ummrahpackages.com/faq" />
@push('css')
<style>

    .hero {
        display: flex;
        justify-content: center;
        transform: translateY(-55%);
    }
    .hero .img {
        filter: drop-shadow(0rem 1.5rem rgba(0,0,0,0.1));
        transition: 0.3s ease-out;
    }
    .card:hover .img {
        filter: drop-shadow(0rem 2.5rem rgba(0,0,0,0.1));
    }

    .title {
        text-align: center;
        font-size: 5rem;
        padding: 1rem;
    }

    .acc-container {
        padding: 4rem 2rem;
    }
    .acc-btn {
        width: 100%;
        padding: 1.6rem 2rem;
        font-size: 1.6rem;
        cursor: pointer;
        background: inherit;
        border: none;
        outline: none;
        text-align: left;
        transition: all 0.5s linear;
    }
    .acc-btn:after {
        content: "\27A4";
        color: #ae8b42;
        float: right;
        transition: all 0.3s linear;
    }
    .acc-btn.is-open:after {
        transform: rotate(90deg);
    }
    .acc-btn:hover, .acc-btn.is-open {
        color: #000;
        font-weight: bold;
    }

    .acc-content {
        max-height: 0;
        color: rgba(0,0,0,0.75);
        font-size: 1.5rem;
        margin: 0 2rem;
        padding-left: 1rem;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
        border-bottom: 1px solid #ccc;
    }

    .credit {
        text-align: center;
        padding: 1rem;
    }
    .credit a {
        text-decoration: wavy underline;
        color: dodgerblue;
    }
</style>
@endpush

@section('content')

        <!--Page Banner Section start-->
        <div class="page-banner-section section" style="background-image: url({{$aboutinfo?asset('storage/pages/'.$aboutinfo->about_banner):''}})">
            <div class="container">
                <div class="row">
                    <div class="col" data-aos="zoom-in-up" data-aos-duration="1500" >
                        <h1 class="page-banner-title">FAQ</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">FAQ</li>
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
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12 mt-4" data-aos="zoom-in-up" data-aos-duration="1500">
                          <h2 class="title">FAQ</h2>
                        
                          <div class="acc-container">
                        
                            <button class="acc-btn">What is the difference between Hajj and Umrah?</button>
                            <div class="acc-content">
                              <p>
                                Hajj is a mandatory pilgrimage that every Muslim who is physically and financially capable must perform at least once in their lifetime, while Umrah is a voluntary pilgrimage that can be performed at any time of the year.
                              </p>
                            </div>
                        
                            <button class="acc-btn">
                                What is included in your Hajj and Umrah packages?
                            </button>
                            <div class="acc-content">
                              <p>
                                Our packages include flights, accommodation, transportation, guidance, and other services to ensure a hassle-free and comfortable pilgrimage experience.
                              </p>
                            </div>
                        
                            <button class="acc-btn">
                                Can I customize my Hajj or Umrah package?
                            </button>
                            <div class="acc-content">
                              <p>
                                Yes, we offer customizable packages to meet your specific needs and budget. You can choose from a range of options to create a package that suits your preferences.
                              </p>
                            </div>
                        
                            <button class="acc-btn">
                                What are the visa requirements for Hajj and Umrah?
                            </button>
                            <div class="acc-content">
                              <p>
                                Visa requirements may vary depending on your country of origin and the type of package you choose. We will assist you with the visa application process and provide all necessary guidance.
                              </p>
                            </div>
                        
                            <button class="acc-btn">
                                What are the health and safety measures in place during Hajj and Umrah?
                            </button>
                            <div class="acc-content">
                              <p>
                                We prioritize the health and safety of our pilgrims and have implemented strict measures to ensure a safe pilgrimage experience during Hajj and Umrah. Our team will guide you through the necessary precautions, such as wearing masks, practicing social distancing, and undergoing regular health screenings. We also work closely with local authorities and follow all recommended guidelines to minimize any potential risks. Rest assured that we will do everything possible to keep you safe and healthy during your spiritual journey.
                              </p>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop
@push('scripts')
<script>
    const btns = document.querySelectorAll(".acc-btn");

    // fn
    function accordion() {
    // this = the btn | icon & bg changed
    this.classList.toggle("is-open");

    // the acc-content
    const content = this.nextElementSibling;

    // IF open, close | else open
    if (content.style.maxHeight) content.style.maxHeight = null;
    else content.style.maxHeight = content.scrollHeight + "px";
    }

    // event
    btns.forEach((el) => el.addEventListener("click", accordion));

</script>

<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [{
        "@type": "Question",
        "name": "What is the difference between Hajj and Umrah?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Hajj is a mandatory pilgrimage that every Muslim who is physically and financially capable must perform at least once in their lifetime, while Umrah is a voluntary pilgrimage that can be performed at any time of the year."
        }
      },{
        "@type": "Question",
        "name": "What is included in your Hajj and Umrah packages?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Our packages include flights, accommodation, transportation, guidance, and other services to ensure a hassle-free and comfortable pilgrimage experience."
        }
      },{
        "@type": "Question",
        "name": "Can I customize my Hajj or Umrah package?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Yes, we offer customizable packages to meet your specific needs and budget. You can choose from a range of options to create a package that suits your preferences."
        }
      },{
        "@type": "Question",
        "name": "What are the visa requirements for Hajj and Umrah?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Visa requirements may vary depending on your country of origin and the type of package you choose. We will assist you with the visa application process and provide all necessary guidance."
        }
      },{
        "@type": "Question",
        "name": "What are the health and safety measures in place during Hajj and Umrah?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "We prioritize the health and safety of our pilgrims and have implemented strict measures to ensure a safe pilgrimage experience during Hajj and Umrah. Our team will guide you through the necessary precautions, such as wearing masks, practicing social distancing, and undergoing regular health screenings. We also work closely with local authorities and follow all recommended guidelines to minimize any potential risks. Rest assured that we will do everything possible to keep you safe and healthy during your spiritual journey."
        }
      }]
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
      },{
        "@type": "ListItem", 
        "position": 2, 
        "name": "Faqs",
        "item": "https://ummrahpackages.com/faq"  
      }]
    }
</script>
@endpush