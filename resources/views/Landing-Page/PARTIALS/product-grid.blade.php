<div class="row">
    @forelse ($products as $product)
        <div class="col-md-3 col-sm-4 mb-4">
            <a href="{{ route('single.index', ['product' => $product->id]) }}" class="text-decoration-none text-dark">
                <div class="card product-card mb-0">
                    <img src="{{ asset('uploads/products/' . $product->image_url) }}" class="card-img-top"
                        alt="{{ $product->name }}">
                    <div class="card-body text-center">
                        <div class="category">
                            {{ $product->categories->first()->name ?? 'Item' }}
                        </div>
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="price-row">
                            <span class="label">From:</span>
                            <span class="price">Rs {{ $product->final_price ?? $product->product_price }}</span>
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
    .product-card {
        background: #fff;
        border: none;
        border-radius: 0;
        margin-bottom: 30px;
        transition: all 0.3s ease;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .product-card .card-img-top {
        height: 200px;
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
