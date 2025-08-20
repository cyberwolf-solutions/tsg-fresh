<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="cartSidebarLabel">
    <div class="offcanvas-header">
        <h5 id="cartSidebarLabel" style="font-weight: 700; margin: 0 auto;">CART</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column justify-content-between p-3" style="padding-bottom: 0;">
        <!-- Cart Items -->
        <div id="cartItems">
            {{-- Items will be injected here via AJAX --}}
        </div>

        <!-- Footer -->
        <div>
            <hr>
            <div class="d-flex justify-content-between mb-2" style="font-weight: 600;">
                <span style="color: gray;">Subtotal:</span>
                <span id="cartSubtotal" style="color: black;">Rs 0.00</span>
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
</div>
