@if ($cart && $cart->items->count() > 0)

    {{-- cart total qty (only once, not inside foreach) --}}
    <span id="cartTotalQty" style="display:none;">
        {{ $cart->items->sum('quantity') }}
    </span>

    @foreach ($cart->items as $item)
        <div class="d-flex mb-3 cart-item-row" data-id="{{ $item->id }}">
            <img src="{{ asset('uploads/products/' . ($item->product->image_url ?? 'placeholder.png')) }}"
                alt="{{ $item->product->name }}" style="width:60px;height:60px;object-fit:cover;border-radius:5px;">

            <div class="ms-3 flex-grow-1">
                <div style="font-weight:bold;color:#0056b3;">
                    {{ $item->product->name }}
                    @if ($item->variant)
                        - {{ $item->variant->variant_name }}
                    @endif
                </div>

                <div style="font-size:14px;margin-top:5px;color:gray;">
                    {{ $item->quantity }} ×
                    <span style="color:black;font-weight:600;">
                        Rs {{ number_format($item->price, 2) }}
                    </span>
                </div>
            </div>

            <button class="btn p-0 ms-2" style="color: gray;background:white"
                onclick="removeCartItem({{ $item->id }})">
                <i class="fas fa-times-circle" style="font-size:20px;"></i>
            </button>
        </div>
    @endforeach
@else
    <p>Your cart is empty.</p>
@endif

{{-- subtotal for JS --}}
<span id="cartSubtotalValue" data-subtotal="{{ $subtotal }}"></span>


<script>
    function removeCartItem(itemId) {
        if (!confirm("Remove this item from cart?")) return;

        fetch(`/cart/item/${itemId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Replace sidebar content with updated HTML
                    document.getElementById("sidebar-cart-items").innerHTML = data.html;

                    // Update cart count in header (if you show it somewhere)
                    let cartCount = document.getElementById("cart-count");
                    if (cartCount) {
                        cartCount.textContent = data.count;
                    }
                } else {
                    alert(data.message || "Something went wrong!");
                }
            })
            .catch(err => console.error(err));
    }
</script>
