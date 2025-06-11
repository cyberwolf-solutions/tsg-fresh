<div class="modal-body">
    <div class="row">
        <div class="row">
            @foreach ($modifiers as $item)
                <div class="col-md-12">
                    <div class="card border rounded-3">
                        <div class="card-body">
                            <div class="row align-content-center">
                                <div class="col-6">
                                    <!-- Inline Radios -->
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input modifier" type="checkbox" name="modifier"
                                            id="modifier{{ $item->modifier->id }}" value="{{ $item->modifier->id }}"
                                            data-name="{{ $item->modifier->name }}" data-meal="{{ $id }}"
                                            data-price-lkr="{{ $item->modifier->unit_price_lkr }}"
                                            data-price-usd="{{ $item->modifier->unit_price_usd }}"
                                            data-price-eu="{{ $item->modifier->unit_price_eu }}">
                                        <label class="form-check-label" for="modifier{{ $item->modifier->id }}">
                                            <span class="ok" hidden></span><br>
                                            <h5 class="card-title">{{ $item->modifier->name }}</h5>
                                            <span id="modifierS" class="modifier-price">{{ $settings->currency }}
                                                {{ number_format($item->modifier->unit_price_lkr, 2) }}</span><br>
                                            <span class="small">{{ $item->modifier->description }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($modifiers->isEmpty())
                <div class="col-md-12">
                    <p class="fs-5 fw-light">
                        No Modifiers found for this meal category
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    var mealId = {{ $id }};
    var modifiers = []; // Array to hold selected modifiers

    // Function to get the price based on the currency symbol
    function getPrice(currencySymbol, priceLkr, priceUsd, priceEu) {
        if (currencySymbol === 'USD') {
            return parseFloat(priceUsd).toFixed(2);
        } else if (currencySymbol === 'EURO') {
            return parseFloat(priceEu).toFixed(2);
        } else {
            return parseFloat(priceLkr).toFixed(2);
        }
    }

    $(document).on('click', '.modifier', function() {
        $('#loader').removeClass('d-none');

        var id = $(this).val();
        var meal = $(this).data('meal');
        var name = $(this).data('name');
        var priceLkr = $(this).data('price-lkr');
        var priceUsd = $(this).data('price-usd');
        var priceEu = $(this).data('price-eu');

        var currencySymbol = localStorage.getItem('currencySymbol') || 'LKR';
        var price = getPrice(currencySymbol, priceLkr, priceUsd, priceEu);

        if ($(this).is(':checked')) {
            modifiers.push({ // Add to modifiers array
                id: id,
                price: price,
            });
        } else {
            modifiers = modifiers.filter(modifier => modifier.id !== id); // Remove from modifiers array
        }

        const itemIndex = cart.findIndex(item => item.id === meal);
        if (itemIndex !== -1) {
            cart[itemIndex].modifiers = modifiers;
            // Recalculate cart prices and update UI
            $('#loader').addClass('d-none');
            loadCart();
        }
    });

    $(document).ready(function() {
        const itemIndex = cart.findIndex(item => item.id === mealId);

        var currencySymbol = localStorage.getItem('currencySymbol') || 'LKR';

        // Display the currency symbol in the span with id "ok"
        $('.ok').text(currencySymbol);

        $('.modifier').each(function() {
            var priceLkr = $(this).data('price-lkr');
            var priceUsd = $(this).data('price-usd');
            var priceEu = $(this).data('price-eu');
            var priceSpan = $(this).siblings('label').find('.modifier-price');

            var price = getPrice(currencySymbol, priceLkr, priceUsd, priceEu);
            if (currencySymbol === 'USD') {
                priceSpan.text('USD ' + price);
            } else if (currencySymbol === 'EURO') {
                priceSpan.text('EURO ' + price);
            } else {
                priceSpan.text('LKR ' + price);
            }
        });

        var selectedModifiers = cart[itemIndex].modifiers || [];
        selectedModifiers.forEach(element => {
            $(`#modifier${element.id}`).prop('checked', true);
        });
    });
</script>
