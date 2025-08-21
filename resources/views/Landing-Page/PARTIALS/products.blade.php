<footer class="footer ml-4">
    <div class="container">
        <div class="row" style="margin-left: 60px; margin-right: 60px;">

            <!-- Latest Products -->
            <div class="col-md-4 ml-4">
                <div class="footer-widget">
                    <h5 class="text-secondary" style="text-transform: uppercase; margin-bottom: 5px;">LATEST</h5>
                    <hr style="border: 0.3px solid currentColor; opacity: 0.4; margin-top: 0; width: 30px;" class="mb-4">

                    @foreach($latestProducts as $product)
                        <div class="footer-product mt-2 d-flex align-items-start mb-3">
                            <img src="{{ asset('uploads/products/' . $product->image_url) }}"
                                        alt="{{ $product->name }}" 
                                 style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info flex-1">
                                <h6 style="margin:0 0 5px; font-size:16px;color:rgb(64, 64, 148);font-weight:150">
                                    {{ $product->name }}
                                </h6>
                                <p class="price text-dark" style="margin:0; font-size:16px;">
                                    රු {{ number_format($product->final_price, 2) }}
                                </p>
                            </div>
                        </div>
                        <hr style="border: 0.3px solid #ccc; margin-top: 0; width: 100%;" class="mb-4">

                    @endforeach
                </div>
            </div>

            <!-- Best Selling -->
            <div class="col-md-4 ml-4">
                <div class="footer-widget">
                    <h5 class="text-secondary" style="text-transform: uppercase; margin-bottom: 5px;">BEST SELLING</h5>
                    <hr style="border: 0.3px solid currentColor; opacity: 0.4; margin-top: 0; width: 30px;" class="mb-4">

                    @foreach($bestSellingProducts as $product)
                        <div class="footer-product mt-2 d-flex align-items-start mb-3">
                            <img src="{{ asset('uploads/products/' . $product->image_url) }}"
                                        alt="{{ $product->name }}" 
                                 style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info flex-1">
                               <h6 style="margin:0 0 5px; font-size:16px;color:rgb(64, 64, 148);font-weight:150">
                                    {{ $product->name }}
                                </h6>
                                <p class="price text-dark" style="margin:0; font-size:16px;">
                                    රු {{ number_format($product->final_price, 2) }}
                                </p>
                            </div>
                        </div>
                        <hr style="border: 0.3px solid #ccc; margin-top: 0; width: 100%;" class="mb-4">

                    @endforeach
                </div>
            </div>

            <!-- Top Rated (empty for now) -->
            <div class="col-md-4 ml-4">
                <div class="footer-widget">
                    <h5 class="text-secondary" style="text-transform: uppercase; margin-bottom: 5px;">TOP RATED</h5>
                    <hr style="border: 0.3px solid currentColor; opacity: 0.4; margin-top: 0; width: 30px;" class="mb-4">

                    @if($topRatedProducts->isEmpty())
                        <p class="text-muted">Coming soon...</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>
