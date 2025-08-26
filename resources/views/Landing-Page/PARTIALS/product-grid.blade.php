<div class="row">
    @forelse ($products as $product)
        <div class="col-md-3 col-sm-4 col-4 mb-4">
            <a href="{{ route('single.index', ['product' => $product->id]) }}" class="text-decoration-none text-dark">

                <div class="card product-card mb-0">
                    <div class="image-wrapper" style="position: relative; display: inline-block;">
                        <img src="{{ asset('uploads/products/' . $product->image_url) }}" class="card-img-top"
                            alt="{{ $product->name }}" style="height: 215px; object-fit: cover;">

                        <!-- OUT OF STOCK Banner -->
                        @if ($product->is_out_of_stock)
                            <div class="out-of-stock-banner">OUT OF STOCK</div>
                        @endif

                        <!-- Logo overlay -->
                        <img src="{{ asset('build/images/landing/flogo.png') }}" alt="Logo"
                            style="
                                position: absolute;
                                bottom: 5px;
                                left: 50%;
                                transform: translateX(-50%);
                                width: 70px;
                                height: auto;
                                opacity: 0.9;
                            ">
                    </div>

                    <div class="card-body text-center">
                        <div class="category text-uppercase" style="margin-bottom:-1px;font-size: 12px">
                            {{ $product->categories->pluck('name')->join('/') ?? 'Item' }}
                        </div>

                        <h5 class="card-title text-uppercase text-secondary"
                            style="font-weight: 100; margin-bottom: -1px;">
                            {{ $product->name }}
                        </h5>

                        <p class="price-row">
                            <span class="label" style="font-size: 15px">From:</span>
                            <span class="price" style="font-size: 15px">
                                රු {{ $product->final_price ?? $product->product_price }}
                            </span>
                        </p>
                    </div>
                </div>

            </a>
        </div>
    @empty
        <p class="text-center">No products found in this category.</p>
    @endforelse
</div>


<style>
    .out-of-stock-banner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        /* span full image width */
        background: rgba(255, 255, 255, 0.8);
        /* white with transparency */
        color: #000;
        /* black text */
        font-size: 18px;
        font-weight: 50px;
        padding: 12px 0;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
        /* nice spacing */
        z-index: 10;
    }


    .product-card {
        background: #fff;
        border: 1px solid #ddd;
        /* Light gray border */
        border-radius: 0px;
        /* Slight rounding */
        margin-bottom: 30px;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
    }


    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .product-card .card-img-top {
        height: 150px;
        object-fit: cover;
        width: 100%;
        border-radius: 0;
    }

    .product-card .card-body {
        padding: 15px;
        text-align: center;
    }

    .product-card .card-body>div {
        color: gray;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .product-card .card-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #007bff;
        /* bootstrap blue */
    }

    .product-card p {
        font-size: 0.9rem;
    }

    .product-card p span:first-child {
        color: gray;
    }

    .product-card p span:last-child {
        color: black;
    }

    .pagination {
        gap: 8px;
    }

    .pagination .page-link {
        border-radius: 50% !important;
        width: 38px;
        height: 38px;
        line-height: 36px;
        text-align: center;
        padding: 0;
        font-weight: 600;
        font-size: 16px;
    }

    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        /* bootstrap primary blue */
        border-color: #0d6efd;
        color: #fff;
    }
</style>
