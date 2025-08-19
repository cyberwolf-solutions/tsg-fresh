@php $subtotal = 0; @endphp

@if($cart && $cart->items->count() > 0)
    @foreach($cart->items as $item)
        @php
            $price = $item->variant ? $item->variant->variant_price : $item->product->price;
            $qty = $item->quantity;
            $itemTotal = $price * $qty;
            $subtotal += $itemTotal;
            $stockQty = $item->inventory->quantity ?? 0;
        @endphp
        <tr class="cart-item" data-id="{{ $item->id }}" data-stock="{{ $stockQty }}">
            <td class="align-middle">
                <div class="d-flex align-items-center">
                    <button onclick="removeCartItem({{ $item->id }})" class="btn p-0 me-2 text-danger"><i class="fas fa-times-circle"></i></button>
                    <img src="{{ asset('uploads/products/' . ($item->product->image_url ?? 'placeholder.png')) }}" 
                         alt="{{ $item->product->name }}" class="img-thumbnail me-2" style="width: 80px; height: 80px;">
                    <span class="text-dark small">{{ $item->product->name }} @if($item->variant) - {{ $item->variant->variant_name }} @endif</span>
                </div>
            </td>
            <td class="align-middle text-dark fw-semibold">රු {{ number_format($price,2) }}</td>
            <td class="align-middle">
                <div class="input-group input-group-sm custom-qty-group" style="width: 90px;">
                    <button class="btn custom-qty-btn" onclick="updateQuantity({{ $item->id }}, -1)">−</button>
                    <input type="text" class="form-control text-center qty-input" value="{{ $qty }}" onchange="updateQuantity({{ $item->id }}, 0, this.value)">
                    <button class="btn custom-qty-btn" onclick="updateQuantity({{ $item->id }}, 1)">+</button>
                </div>
            </td>
            <td class="align-middle text-dark fw-semibold subtotal">රු {{ number_format($itemTotal,2) }}</td>
        </tr>
    @endforeach
@else
    <tr><td colspan="4" class="text-center">Your cart is empty.</td></tr>
@endif
