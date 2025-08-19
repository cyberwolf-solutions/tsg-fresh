<div class="modal-body">
    <div class="row justify-content-between">
        <div class="col-md-3">
            <h4>Order No</h4>
            <span>#{{ $settings->invoice($data->id) }}</span>
        </div>
        <div class="col-md-3">
            <h4>Order Date</h4>
            <span>{{ \Carbon\Carbon::parse($data->order_date)->format($settings->date_format) }}</span>
        </div>
        <div class="col-md-3">
            <h4>Order Type</h4>
            <span>{{ $data->type }}</span>
        </div>
        <div class="col-md-3">
            <h4>Status</h4>
            <span>{{ $data->status }}</span>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <h5>Customer</h5>
            @php
                $customer = $data->webCustomer ?? $data->customer;
                $currency = $customer?->currency?->name ?? 'Rs';
            @endphp

            @if (!$customer)
                <p>Walking Customer</p>
            @else
                <p>{{ $customer->name ?? 'Guest' }}</p>
                <p>{{ $customer->contact ?? '-' }}</p>
                <p>{{ $customer->email ?? '-' }}</p>
                <p>{{ $customer->address ?? '-' }}</p>
            @endif
        </div>

        @if ($data->room_id)
            <div class="col-md-3">
                <h5>Room</h5>
                <p>{{ $data->room?->name ?? '-' }}</p>
            </div>
        @endif
        @if ($data->table_id)
            <div class="col-md-3">
                <h5>Table</h5>
                <p>{{ $data->table?->name ?? '-' }}</p>
            </div>
        @endif
    </div>

    <hr>

    <div class="row">
        <h5>Items</h5>
        <div class="col-12">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->items as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                           <td>
                                    {{ $item->product->name }}
                                    @if($item->variant)
                                        - {{ $item->variant->variant_name }}
                                    @endif
                                    <br>
                                    <small class="text-muted">
                                        {{-- MFD: {{ $item->product->manufacture_date ? \Carbon\Carbon::parse($item->manufacture_date)->format('Y-m-d') : 'N/A' }}
                                        | EXP: {{ $item->product->expiry_date ? \Carbon\Carbon::parse($item->product->expiry_date)->format('Y-m-d') : 'N/A' }} --}}
                                        {{-- <br> --}}
                                        Categories: 
                                        @foreach($item->product->categories as $category)
                                            {{ $category->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </small>
                                </td>
                            <td>{{ $currency }} {{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $currency }} {{ number_format($item->total, 2) }}</td>
                        </tr>

                     
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td>Sub Total</td>
                        <td>{{ $currency }} {{ number_format($data->subtotal  ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td>Discount</td>
                        <td>{{ $currency }} {{ number_format($data->discount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td>VAT</td>
                        <td>{{ $currency }} {{ number_format($data->vat ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td><h3>Total</h3></td>
                        <td><h4>{{ $currency }} {{ number_format($data->total ?? 0, 2) }}</h4></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
