@extends('landing-page.layouts.app')

@section('content')
    <div class="container-fluid"
        style="background: url('{{ asset('build/images/bg.jpg') }}') no-repeat center center;
        ;background-color:whitesmoke; background-size: cover; padding: 60px 15px;
    margin-top:50px">

        <!-- Heading -->
        <h2 class="text-center fw-bold mb-4" style="font-size: 28px;">Welcome to Taprobane Seafood (Pvt) Ltd.</h2>

        <!-- Vision and Mission -->
        <div class="row text-center mb-4">
            <div class="col-md-6">
                <h4 class="fw-bold mb-2">VISION</h4>
                <p style="font-style: italic;">“To Be The Global Leader In Sustainable & Socially Responsible Seafood”</p>
            </div>
            <div class="col-md-6">
                <h4 class="fw-bold mb-2">MISSION</h4>
                <p style="font-style: italic;">“Create A Premium Quality Seafood Products For Iconic Brands, Sourced
                    Responsibly From Sustainable Managed (Sri Lankan) Fisheries”</p>
            </div>
        </div>

        <!-- Values -->
        <h5 class="text-center fw-semibold mb-4">Our Values</h5>
        <p class="text-center" style="color: #333;">
            ✔ High Quality Standards &nbsp;&nbsp; ✔ Social Responsibility &nbsp;&nbsp;
            ✔ Sustainability &nbsp;&nbsp; ✔ Integrity &nbsp;&nbsp; ✔ Success
        </p>

        <!-- YouTube Videos -->
        <div class="row justify-content-center text-center my-4 g-4">
            <div class="col-sm-12 col-md-3">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/VIDEO_ID1" title="Video 1" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/VIDEO_ID2" title="Video 2" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/VIDEO_ID3" title="Video 3" allowfullscreen></iframe>
                </div>
            </div>
        </div>

        <!-- Company Description -->
        <div class="mt-4"
            style="max-width: 900px; margin: auto; font-size: 14px; color: #444; line-height: 1.8; text-align: justify;">
            <p>Taprobane Seafood Private Limited is Sri Lanka’s leading seafood company founded in 2011 by Mr Timothy O’
                Reilly and Mr Dilan Fernando, whose shared vision for producing seafood of impeccable freshness and quality
                has helped it become a US$25 million dollar company.</p>

            <p>TSG has ten state-of-the-art processing facilities throughout north and north western province employing over
                1500 people. TSG has seen extraordinary growth, and winner of the highest foreign exchange earner 2014/2015
                presidential export award. TSG is the first seafood processing factory in the Northern Province, and the
                pioneer in pasteurized crab meat processing. TSG produces pasteurized crab meat, frozen and fresh tuna,
                shrimps and various other products for some of the most iconic seafood brands in the USA, EU & Japan.</p>

            <p>TSG is the first seafood Company in Sri Lanka to be FSSC 22000 certified, the highest certification for food
                standards. TSG is also a proud member of the Ethical Trading Initiative (ETI) which ensures and promotes the
                ethical conditions for workers through the implementation of codes labour practices based on national law
                and international labour standards. Whilst charging ahead in terms of quality and safety of its seafood, TSG
                has also been in the forefront of ethical labour practices in the industry. Over the last few years, it has
                paid a great deal of attention to the working and living standards, wellbeing and professional development
                of its employees, who hail from some of the most economically-disadvantaged communities in Sri Lanka.</p>

            <p>The company sees this commitment as more than just corporate social responsibility (CSR), but a way in which
                both employers and workers can mutually benefit from a system that incorporates fair sustainable practices.
            </p>
        </div>
    </div>
@endsection
