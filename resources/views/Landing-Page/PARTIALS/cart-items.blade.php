@if ($cart && $cart->items->count() > 0)
    @foreach ($cart->items as $item)
    <span id="cartTotalQty" style="display:none;">
    {{ $cart ? $cart->items->sum('quantity') : 0 }}
</span>

        <div class="d-flex mb-3">
            <img src="{{ asset('uploads/products/' . ($item->product->image_url ?? 'placeholder.png')) }}"
                alt="{{ $item->product->name }}" style="width:60px;height:60px;object-fit:cover;border-radius:5px;">

            <div class="ms-3 flex-grow-1">
                <div style="font-weight:bold;color:#0056b3;">
                    {{ $item->product->name }}
                    @if ($item->variant)
                        - {{ $item->variant->variant_name }}
                    @endif
                </div>
                {{-- <div style="color:#0056b3;">{{ $item->product->description ?? '' }}</div> --}}
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

{{-- store subtotal in a hidden span so JS can read it --}}
<span id="cartSubtotalValue" data-subtotal="{{ $subtotal }}"></span>
