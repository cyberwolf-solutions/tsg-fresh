@extends('landing-page.layouts.app')

@section('content')
    {{-- Carousel Section --}}
    @if ($carousel = $sections->where('name', 'carousel')->first())
        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel" style="margin-top: 100px">
            <div class="carousel-indicators">
                @foreach ($carousel->items as $key => $item)
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="{{ $key }}"
                        class="{{ $key === 0 ? 'active' : '' }}" aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($carousel->items as $key => $item)
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                        <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('build/images/landing/product/f' . ($key + 1) . '.jpg') }}"
                            class="d-block w-100" alt="{{ $item->title }}" style="height: 500px; object-fit: cover;">

                        @if ($key === 0)
                            <div
                                class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100 text-center">
                                <p class="mb-2 italic" style="font-style: italic; font-size: 18px; color: #ffffff;">
                                    {!! $item->subtitle ?? 'Export Quality...' !!}
                                </p>
                                <h1 class="mb-2 italic"
                                    style="font-size: 48px; font-weight: bold; color: #fff; text-transform: uppercase;">
                                    {!! $item->title !!}
                                </h1>
                                <h2 class="mb-3"
                                    style="font-size: 50px; font-weight: bold; color: #fff; text-transform: uppercase;">
                                    {!! $item->description !!}
                                </h2>
                                <a href="{{ $item->button_link ?? '#' }}" class="btn"
                                    style="background: #fff; color: #000; border-radius: 30px; padding: 10px 25px; font-weight: bold; text-transform: uppercase;">
                                    {{ $item->button_text ?? 'OUR PRODUCTS' }} <i class="fas fa-shopping-cart ms-2"></i>
                                </a>
                            </div>
                        @elseif ($key === 1)
                            {{-- Pattern 2: Right overlay box --}}
                            <div class="carousel-caption d-flex justify-content-end align-items-center"
                                style="height: 100%;">
                                <div
                                    style="background: rgba(0,0,0,0.5); padding: 30px; border-radius: 10px; max-width: 300px; text-align: left;">
                                    <p style="font-style: italic; font-size: 18px;" class=" text-center">
                                        {!! $item->subtitle ?? 'Best Quality' !!}</p>
                                    <h2 style="font-size: 36px; font-weight: bold;" class=" text-center">
                                        {!! $item->title !!}</h2>
                                    <p style="font-size: 20px;" class=" text-center">{!! $item->description ?? 'Hurry Up !!' !!}</p>
                                    <a href="{{ $item->button_link ?? '#' }}" class="btn btn-primary d-block mx-auto"
                                        style="border-radius: 30px; padding: 10px 25px;">
                                        {{ $item->button_text ?? 'ORDER NOW' }}
                                    </a>


                                </div>
                            </div>
                        @elseif ($key === 2)
                            {{-- Pattern 3: Circular overlay --}}
                            <div class="carousel-caption d-flex flex-column justify-content-center h-100 text-start">
                                <div
                                    style="background: rgba(255,255,255,0.85); border-radius: 50%; padding: 50px; max-width: 350px; text-align: center; color: #000;">
                                    <p style="font-style: italic; font-size: 18px;">{!! $item->subtitle ?? 'Fresh Seafood' !!}</p>
                                    <h2 style="font-size: 50px; font-weight: bold;" class=" italic">{!! $item->title ?? 'GET DISCOUNT' !!}
                                    </h2>
                                    <p style="font-size: 20px;">{!! $item->description ?? 'Hurry Up!' !!}</p>
                                    <a href="{{ $item->button_link ?? '#' }}" class="btn"
                                        style="background: red; color: white; border-radius: 30px; padding: 10px 25px; font-weight: bold;">
                                        {{ $item->button_text ?? 'SHOP NOW' }} <i class="fas fa-shopping-cart ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        @elseif ($key === 3)
                            {{-- Pattern 2: Right overlay box --}}
                            <div class="carousel-caption d-flex justify-content-end align-items-center"
                                style="height: 100%;">
                                <div
                                    style="background: rgba(0,0,0,0.5); padding: 30px; border-radius: 10px; max-width: 300px; text-align: left;">
                                    <p style="font-style: italic; font-size: 18px;" class=" text-center">
                                        {!! $item->subtitle ?? 'Best Quality' !!}</p>
                                    <h2 style="font-size: 36px; font-weight: bold;" class=" text-center">
                                        {!! $item->title !!}</h2>
                                    <p style="font-size: 20px;" class=" text-center">{!! $item->description ?? 'Hurry Up !!' !!}</p>
                                    <a href="{{ $item->button_link ?? '#' }}" class="btn btn-primary d-block mx-auto"
                                        style="border-radius: 30px; padding: 10px 25px;">
                                        {{ $item->button_text ?? 'ORDER NOW' }}
                                    </a>


                                </div>
                            </div>
                        @endif


                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    @endif

    {{-- Button Line Section --}}
    @if ($buttonLine = $sections->where('name', 'button_line')->first())
        <section class="text-center my-2">
            <div class="row g-0">
                @foreach ($buttonLine->items as $item)
                    <div class="col-lg-4 col-md-4 col-sm-12 col-4">
                        <div class="position-relative overflow-hidden" style="height: 150px; cursor: pointer;"
                            onmouseover="this.querySelector('img').style.transform='scale(1.1)'; this.querySelector('a').style.display='inline-block';"
                            onmouseout="this.querySelector('img').style.transform='scale(1)'; this.querySelector('a').style.display='show';">
                            <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('build/images/landing/our.jpg') }}"
                                class="w-100 h-100" style="object-fit: cover; transition: transform 0.5s ease;" />
                            <a href="{{ $item->button_link ?? '#' }}"
                                class="position-absolute top-50 start-50 translate-middle fw-bold"
                                style="background-color: rgba(128, 128, 128, 0.6); color: white; padding: 10px 20px; text-decoration: none; border: none; font-size: 30px;">
                                {{ $item->button_text ?? 'Button' }}
                            </a>

                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Paralax Section --}}
    @if ($paralax = $sections->where('name', 'paralax')->first()?->items->first())
        <section
            style="
        background-image: url('{{ $paralax->image_path ? asset('storage/' . $paralax->image_path) : asset('build/images/landing/fishart.jpg') }}');
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
                @if ($paralax->title)
                    <h1 style="font-size: 25px; font-weight: bold;" class="text-secondary">
                        {{ $paralax->title }}
                    </h1>
                @endif
                @if ($paralax->description)
                    <p style="font-size: 17px;" class=" text-secondary">{{ $paralax->description }}</p>
                @endif
            </div>
        </section>
    @endif

    {{-- Best Selling Products --}}
    @if ($bestSelling = $sections->where('name', 'best_selling')->first())
        <section class="text-center my-5">
            <div class="d-flex align-items-center justify-content-center my-5">
                <hr class="flex-grow-1 mx-3"
                    style="border: none; border-top: 1px solid grey; max-width: 300px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                <h5 class="mb-0 text-muted text-uppercase text-dark fw-bold">Best Selling Products</h5>
                <hr class="flex-grow-1 mx-3"
                    style="border: none; border-top: 1px solid grey; max-width: 300px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            </div>


            <div class="container">
                <div class="row justify-content-center g-4">
                    @foreach ($bestSelling->items as $item)
                        <div class="col-6 col-md-2 text-center">
                            <div class="position-relative rounded-circle overflow-hidden mx-auto"
                                style="width: 180px; padding-top: 100%; height: 180px;">
                                <img src="{{ $item->image_path
                                    ? asset('storage/' . $item->image_path)
                                    : asset('build/images/landing/product/f' . ($index + 1) . '.jpg') }}"
                                    alt="{{ $item->title ?? 'Product' }}"
                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                            </div>
                            @if (!empty($item->title))
                                <div class="mt-2 fw-bold">{{ $item->title }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Boat to Plate --}}
    @if ($boatToPlate = $sections->where('name', 'boat_to_plate')->first())
        <section class="text-center my-5">
            <div class="d-flex align-items-center justify-content-center my-5">
                <hr class="flex-grow-1 mx-3"
                    style="border: none; border-top: 1px solid grey; max-width: 300px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                <h5 class="mb-0 text-muted text-uppercase fw-bold">BOAT TO PLATE</h5>
                <hr class="flex-grow-1 mx-3"
                    style="border: none; border-top: 1px solid grey; max-width: 300px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            </div>

            <p class="mb-4 px-3" style="color: gray;font-size:16px">
                {{ $boatToPlate->items->first()?->description ?? 'TSG deals directly with the fisherman thus cutting out all the middlemen and markets to supply you premium quality seafood at competitive pricing.' }}
            </p>

            @if ($boatToPlate->items->first()?->image_path)
                <div class="container">
                    <img src="{{ asset('storage/' . $boatToPlate->items->first()->image_path) }}"
                        alt="Boat to Plate Process" class="img-fluid mx-auto d-block" style="max-width: 100%;">
                </div>
            @endif
        </section>
    @endif

    {{-- Browse Categories --}}
    @if ($categories = $sections->where('name', 'categories')->first())
        <section class="text-center my-5">
            <div class="d-flex align-items-center justify-content-center my-5">
                <hr class="flex-grow-1 mx-3"
                    style="border: none; border-top: 1px solid grey; max-width: 300px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                <h5 class="mb-0 text-muted text-uppercase fw-bold " style="color: black">Browse our categories</h5>
                <hr class="flex-grow-1 mx-3"
                    style="border: none; border-top: 1px solid grey; max-width: 300px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            </div>

            <div class="container">
                <div class="row justify-content-center g-4">
                    @foreach ($categories->items as $item)
                        <div class="col-6 col-md-2 text-center">
                            <div class="rounded-circle overflow-hidden mx-auto" style="width: 180px; height: 180px;">
                                <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('build/images/landing/product/f' . ($loop->index + 1) . '.jpg') }}"
                                    alt="{{ $item->title }}" class="img-fluid w-100 h-100 object-fit-cover">
                            </div>
                            @if ($item->title)
                                <div class="mt-2 fw-bold" style="font-seze:13px;color:gray">{{ $item->title }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Latest News --}}
    @if ($news = $sections->where('name', 'news')->first())
        <section class="text-center my-5">


            <div id="newsCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach ($news->items as $key => $item)
                        <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="{{ $key }}"
                            class="{{ $key === 0 ? 'active' : '' }}" aria-label="Slide {{ $key + 1 }}"></button>
                    @endforeach
                </div>

                <div class="carousel-inner">
                    @foreach ($news->items as $key => $item)
                        @php
                            $bgColor =
                                $item->style['bg_color'] ??
                                ($loop->index % 3 == 0
                                    ? 'bg-primary'
                                    : ($loop->index % 3 == 1
                                        ? 'bg-secondary'
                                        : 'bg-dark'));
                        @endphp
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }} {{ $bgColor }} text-white d-flex justify-content-center align-items-center"
                            style="height: 300px;" data-bs-interval="1000">
                            <div class="text-center">
                                @if ($item->title)
                                    <h5>{{ $item->title }}</h5>
                                @endif
                                @if ($item->description)
                                    <p>{{ $item->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="d-flex align-items-center justify-content-center my-5">
                <hr class="flex-grow-1 mx-3"
                    style="border: none; border-top: 1px solid grey; max-width: 300px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                <h5 class="mb-0 text-muted text-uppercase  fw-bold" style="color: black">Latest News</h5>
                <hr class="flex-grow-1 mx-3"
                    style="border: none; border-top: 1px solid grey; max-width: 300px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            </div>

        </section>
    @endif
@endsection
