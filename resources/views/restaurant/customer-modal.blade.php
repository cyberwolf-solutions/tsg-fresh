<div class="modal-body">
    <div class="row">
        <div class="row">
            <div class="col-12">
                <label for="">Select a Guest</label>
                <select name="" id="customer" class="form-control js-example-basic-single">
                    <option value="0" {{ $customer == 0 ? 'selected' : '' }} data-name="Walking Customer" disabled >Walking
                        Customer</option>
                    {{-- @foreach ($customers as $item)
                        <option value="{{ $item->id }}" {{ $customer == $item->id ? 'selected' : '' }}
                            data-name="{{ $item->name }}">{{ $item->name }} |
                            {{ $item->contact }}</option>
                    @endforeach --}}
                    @foreach ($customers as $item)
                        <option value="{{ $item->id }}" {{ $customer == $item->id ? 'selected' : '' }}
                            data-name="{{ $item->name }}" data-currency-id="{{ $item->currency_id }} " data-currency-symbol="{{ $item->currency->symbol }}" >
                            {{ $item->name }} |
                            {{ $item->contact }}</option>
                    @endforeach
                </select>

                <span class="currency" id="currency" hidden></span>

            </div>
        </div>
        <div class="row">
            <a href="javascript:void(0)" class="link-info" data-ajax-popup="true" data-title="Add Customer"
                data-size="lg" data-url="{{ route('restaurant.customer-add') }}">Need to add a new customer? Click
                Here!</a>
        </div>
    </div>
</div>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    
    $(document).ready(function() {

        var currencySymbol = 'LKR';

     

        $('#customer').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var currencyId = selectedOption.data('currency-id');
            // console.log('Selected Currency ID:', currencyId);



       



            $('#currency').text(currencyId);
            // Set the currency symbol based on the currencyId
            if (currencyId == 1) {
                currencySymbol = 'LKR';
            } else if (currencyId == 2) {
                currencySymbol = 'USD';
            } else if (currencyId == 3) {
                currencySymbol = 'EURO';
            }

            localStorage.setItem('currencySymbol', currencySymbol);

            // Update the total span with the selected currency symbol
            $('#currencySymbol1').text(currencySymbol);
            $('#currencySymbol2').text(currencySymbol);
            $('#currencySymbol3').text(currencySymbol);
            $('#currencySymbol4').text(currencySymbol);
            // $('#ok').text(currencySymbol);


            // Update the data-price attribute of each meal item
            $('.meal-item').each(function() {
                var price;
                if (currencyId == 2) {
                    price = $(this).data('price-usd');
                    currencySymbol = 'USD';

                } else if (currencyId == 3) {
                    price = $(this).data('price-eu');
                    currencySymbol = 'EURO';
                } else {
                    price = $(this).data('price-lkr');
                    currencySymbol = 'LKR';
                }
                $(this).attr('data-price', price);
            });
            // alert(currencyId);
            $('#total').text(' 0.00');
            $('#sub').text('0.00');
            $('#discount_html').text('0.00');
            $('#vat_html').text('0.00');
            // $('#modifierS').text(currencySymbol + '0.00');
            // modifierS

        });
    });
</script>
