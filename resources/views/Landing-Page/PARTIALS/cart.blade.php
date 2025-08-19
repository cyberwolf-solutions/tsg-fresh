<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 id="cartSidebarLabel" style="font-weight: 700; margin: 0 auto;">CART</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column justify-content-between p-3" style="padding-bottom: 0;">

        <!-- Cart Items -->
        <div>
            <div class="d-flex mb-3">
                <!-- Image -->
                <img src="{{ asset('build/images/landing/l1.png') }}" alt="Product"
                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">

                <!-- Product Info -->
                <div class="ms-3 flex-grow-1">
                    <div style="font-weight: bold; color: #0056b3;">CLEAN PRAWNS 1KG -</div>
                    <div style="color: #0056b3;">Clean Prawns Large 16/20</div>
                    <div style="font-size: 14px; margin-top: 5px; color: gray;">
                        2 × <span style="color: black; font-weight: 600;">Rs 4,150.00</span>
                    </div>
                </div>

                <!-- Remove Button -->
                <button class="btn  p-0 ms-2" style="color: gray;background:white">
                    <i class="fas fa-times-circle" style="font-size: 20px;"></i>
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div>
            <hr>
            <div class="d-flex justify-content-between mb-2" style="font-weight: 600;">
                <span style="color: gray;">Subtotal:</span>
                <span style="color: black;">Rs 8,300.00</span>
            </div>

            <a href="{{ route('cart.index') }}" class="btn w-100"
                style="background-color: #1261a0; color: white; font-weight: 600; margin-bottom: 10px;">
                VIEW CART
            </a>
            <button class="btn w-100" style="background-color: #4ea7f8; color: white; font-weight: 600;">
                CHECKOUT
            </button>
        </div>
    </div>
</div
