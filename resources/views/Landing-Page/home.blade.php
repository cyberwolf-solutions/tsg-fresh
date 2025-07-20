@extends('landing-page.layouts.app')

@section('content')
    {{-- couresel --}}

    <div id="carouselExampleCaptions" data-bs-ride="carousel" style="margin-top: 100px">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            {{-- 0 --}}
            <div class="carousel-item active">
                <img src="{{ asset('build/images/landing/product/f1.jpg') }}" class="d-block w-100" alt="..."
                    style="height:500px">

                <div class="carousel-caption d-none d-md-block text-center">
                    <div class="card border-0"
                        style="background-color: rgba(0, 67, 139, 0.6); max-width: 300px; margin-left: auto;border-radius:30px;margin-bottom:auto%;margin-top:auto%">

                        <div class="card-body text-white">
                            <p class="card-title" style="font-size: 40px;font-weight:bold">BUY FRESH <br />SEAFOOD</p>
                            <p class="card-title" style="font-size: 30px;">PROCESSED IN SRI LANKA</p>
                            <p class="card-title" style="font-size: 20px;">BY THAPROBANE</p>

                            <a href="#" class="btn btn-primary border-0"
                                style="background-color:rgba(0, 33, 69, 0.6);border-radius:20px">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 1 --}}
            <div class="carousel-item">
                <img src="{{ asset('build/images/landing/product/f2.jpg') }}" class="d-block w-100" alt="..."
                    style="height:500px">

                <div class="carousel-caption d-none d-md-block text-center">
                    <div class="card border-0"
                        style="background-color: rgba(236, 245, 255, 0.6); max-width: 300px; margin-left: auto;border-radius:1000px;margin-bottom:auto%;margin-top:auto%">

                        <div class="card-body text-black">
                            <p class="card-title" style="font-size: 50px;font-weight:bold">GET DISCOUNT</p>
                            <p class="card-title" style="font-size: 30px;">HURRY UP!</p>

                            <a href="#" class="btn btn-primary border-0"
                                style="background-color:rgba(181, 12, 0, 0.6);border-radius:20px">SHOW NOW</a>
                        </div>
                    </div>
                </div>

            </div>
            {{-- 2 --}}
            <div class="carousel-item">
                <img src="{{ asset('build/images/landing/product/f3.jpg') }}" class="d-block w-100" alt="..."
                    style="height:500px">


                <div class="carousel-caption d-none d-md-block text-center"
                    style="top: 50%; transform: translateY(-50%); left: 50%; transform: translate(-50%, -50%); position: absolute; width: 100%;">
                    <div class="card border-0 mx-auto"
                        style="background-color: transparent; max-width: 80%; border-radius: 30px;">

                        <div class="card-body text-white">
                            <p class="card-title" style="font-size: 50px; font-weight: bold;">FRESH SEAFOOD</p>
                            <p class="card-title" style="font-size: 30px;">DELIVER TO YOUR DOORSTEP</p>

                            <a href="#" class="btn btn-primary border-0"
                                style="background-color:whitesmoke; border-radius: 20px; color: black;">
                                OUR PRODUCT
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    {{-- btn line --}}
    <section class="text-center my-2">
        <div class="row g-0">
            <div class="col-lg-4 col-md-4 col-sm-12 col-4">
                <div class="position-relative overflow-hidden" style="height: 150px; cursor: pointer;"
                    onmouseover="this.querySelector('img').style.transform='scale(1.1)'; this.querySelector('a').style.display='inline-block';"
                    onmouseout="this.querySelector('img').style.transform='scale(1)'; this.querySelector('a').style.display='show';">

                    <!-- Image -->
                    <img src="{{ asset('build/images/landing/our.jpg') }}" class="w-100 h-100"
                        style="object-fit: cover; transition: transform 0.5s ease;" />

                    <!-- Centered Button -->
                    <a href="#" class="position-absolute top-50 start-50 translate-middle"
                        style="background-color: rgba(128, 128, 128, 0.6); color: white; padding: 10px 20px; text-decoration: none; border: none; display: show;
                        font-size:25px">
                        OUR PRODUCTS
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-4">
                <div class="position-relative overflow-hidden" style="height: 150px; cursor: pointer;"
                    onmouseover="this.querySelector('img').style.transform='scale(1.1)'; this.querySelector('a').style.display='inline-block';"
                    onmouseout="this.querySelector('img').style.transform='scale(1)'; this.querySelector('a').style.display='show';">

                    <!-- Image -->
                    <img src="{{ asset('build/images/landing/order.jpg') }}" class="w-100 h-100"
                        style="object-fit: cover; transition: transform 0.5s ease;" />

                    <!-- Centered Button -->
                    <a href="#" class="position-absolute top-50 start-50 translate-middle"
                        style="background-color: rgba(128, 128, 128, 0.6); color: white; padding: 10px 20px; text-decoration: none; border: none; display: show;
                        font-size:25px">
                        ORDER NOW
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-4">
                <div class="position-relative overflow-hidden" style="height: 150px; cursor: pointer;"
                    onmouseover="this.querySelector('img').style.transform='scale(1.1)'; this.querySelector('a').style.display='inline-block';"
                    onmouseout="this.querySelector('img').style.transform='scale(1)'; this.querySelector('a').style.display='show';">

                    <!-- Image -->
                    <img src="{{ asset('build/images/landing/staff.jpg') }}" class="w-100 h-100"
                        style="object-fit: cover; transition: transform 0.5s ease;" />

                    <!-- Centered Button -->
                    <a href="#" class="position-absolute top-50 start-50 translate-middle"
                        style="background-color: rgba(128, 128, 128, 0.6); color: white; padding: 10px 20px; text-decoration: none; border: none; display: show;
                        font-size:25px">
                        OUR STAFF
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- paralax imgs --}}
    <section
        style="
    background-image: url('{{ asset('build/images/landing/fishart.jpg') }}');
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
    height: 300px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
">
        <div
            style="
        background-color: transparent;
        padding: 40px;
        border-radius: 10px;
        max-width: 70%;
    ">
            <h1 style="font-size: 15px; font-weight: bold;">WELCOME TO TAPROBANE FRESH</h1>
            <p style="font-size: 13px;">Taprobane Seafood Group Sri Lanka’s leading seafood company was founded in 2011
                by Dilan & Sathya Fernando and Tim O’Reilly, whose shared vision for producing seafood of impeccable
                freshness while ensuring social equity through out the supply chain. Taprobane Seafoods is a global leader
                in sustainable and socially responsible seafood. Taprobane
                is very proud to now offer its export quality seafood products for the Sri Lankan market.</p>
        </div>
    </section>


    {{-- best selling products --}}
    <section class="text-center my-5">
        <div class="d-flex align-items-center justify-content-center my-5">
            <hr class="flex-grow-1 mx-3" style="border: none; border-top: 1px solid grey; max-width: 200px;">
            <h6 class="mb-0 text-muted text-uppercase small">Best Selling Products</h6>
            <hr class="flex-grow-1 mx-3" style="border: none; border-top: 1px solid grey; max-width: 200px;">
        </div>


        <div class="container">
            <div class="row justify-content-center g-4">
                @foreach (['f1', 'f2', 'f3', 'f4', 'f5'] as $product)
                    <div class="col-6 col-md-2 text-center">
                        <div class="rounded-circle overflow-hidden mx-auto" style="width: 200px; height: 200px;">
                            <img src="{{ URL::asset('build/images/landing/product/' . $product . '.jpg') }}"
                                alt="{{ ucfirst($product) }}" class="img-fluid w-100 h-100 object-fit-cover">
                        </div>
                        {{-- <div class="mt-2 fw-bold">{{ ucfirst($product) }}</div> --}}
                    </div>
                @endforeach
            </div>
        </div>


    </section>


    {{-- BOAT TO PLATE --}}

    <section class="text-center my-5">
        <div class="d-flex align-items-center justify-content-center my-5">
            <hr class="flex-grow-1 mx-3" style="border: none; border-top: 1px solid grey; max-width: 200px;">
            <h6 class="mb-0 text-muted text-uppercase small">BOAT TO PLATE</h6>
            <hr class="flex-grow-1 mx-3" style="border: none; border-top: 1px solid grey; max-width: 200px;">
        </div>

        <p class="mb-4 px-3" style="color: gray;font-size:12px">
            TSG deals directly with the fisherman thus cutting out all the middlemen and markets to supply you premium
            quality seafood at competitive pricing.
        </p>
        <div class="container">
            <img src="{{ asset('build/images/landing/l1.png') }}" alt="Boat to Plate Process"
                class="img-fluid mx-auto d-block" style="max-width: 75%;">
        </div>
    </section>

    {{-- Browse our categories --}}

    <section class="text-center my-5">
        <div class="d-flex align-items-center justify-content-center my-5">
            <hr class="flex-grow-1 mx-3" style="border: none; border-top: 1px solid grey; max-width: 200px;">
            <h6 class="mb-0 text-muted text-uppercase small" style="color: black">Browse our categories</h6>
            <hr class="flex-grow-1 mx-3" style="border: none; border-top: 1px solid grey; max-width: 200px;">
        </div>


        <div class="container">
            <div class="row justify-content-center g-4">
                @foreach (['f1', 'f2', 'f3', 'f4'] as $product)
                    <div class="col-6 col-md-2 text-center">
                        <div class="rounded-circle overflow-hidden mx-auto" style="width: 200px; height: 200px;">
                            <img src="{{ URL::asset('build/images/landing/product/' . $product . '.jpg') }}"
                                alt="{{ ucfirst($product) }}" class="img-fluid w-100 h-100 object-fit-cover">
                        </div>
                        <div class="mt-2 fw-bold" style="font-seze:13px;color:gray">{{ ucfirst($product) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- Latest News --}}

    <section class="text-center my-5">
        <div class="d-flex align-items-center justify-content-center my-5">
            <hr class="flex-grow-1 mx-3" style="border: none; border-top: 1px solid grey; max-width: 200px;">
            <h6 class="mb-0 text-muted text-uppercase small" style="color: black">Latest News</h6>
            <hr class="flex-grow-1 mx-3" style="border: none; border-top: 1px solid grey; max-width: 200px;">
        </div>


        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                <div class="carousel-item active bg-primary text-white d-flex justify-content-center align-items-center"
                    style="height: 300px;" data-bs-interval="1000">
                    <div class="text-center">
                        <h5>Welcome to TSG Fish Shop</h5>
                        <p>We bring the ocean to your table – Fresh. Fast. Flavorful.</p>
                    </div>
                </div>

                <div class="carousel-item bg-secondary text-white d-flex justify-content-center align-items-center"
                    style="height: 300px;" data-bs-interval="1000">
                    <div class="text-center">
                        <h5>Daily Fresh Seafood</h5>
                        <p>Handpicked catch every morning for unbeatable taste and quality.</p>
                    </div>
                </div>

                <div class="carousel-item bg-dark text-white d-flex justify-content-center align-items-center"
                    style="height: 300px;" data-bs-interval="1000">
                    <div class="text-center">
                        <h5>Order Online</h5>
                        <p>Experience convenience with doorstep delivery and online ordering.</p>
                    </div>
                </div>
            </div>

            <!-- Prev Button -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>

            <!-- Next Button -->
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>



    </section>
@endsection
