@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h3 class="mb-sm-0">{{ $title }}</h3>
                    <ol class="breadcrumb m-0 mt-2">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active' : '' }}">
                                @if (!$breadcrumb['active'])
                                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                                @else
                                    {{ $breadcrumb['label'] }}
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="page-title-right">
                    <form action="" id="form">
                        <div class="row">
                            <div class="col">
                                <select class="form-select" name="status" onchange="$('#form').submit()">
                                    <option value="" {{ $status == '' ? 'selected' : '' }}>All</option>
                                    <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="InProgress" {{ $status == 'InProgress' ? 'selected' : '' }}>In Progress
                                    </option>
                                    <option value="Complete" {{ $status == 'Complete' ? 'selected' : '' }}>Completed
                                    </option>
                                </select>
                            </div>
                            <a href="{{ route('orders.web') }}" class="btn btn-primary btn-icon" data-bs-toggle="tooltip"
                                title="Refresh">
                                <i class="ri-restart-line"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle" id="example">
                        <thead class="table-light">
                            <th>#</th>
                            <th>Order ID</th>
                            {{-- <th>Guest Name</th> --}}
                            <th>Email</th>
                            {{-- <th>Phone</th> --}}
                            <th>Items</th>
                            <th>Subtotal</th>
                            <th>Discount</th>
                            <th>VAT</th>
                            <th>Total</th>
                            <th>Delivery Method</th>
                            <th>Payment Method</th>
                            <th>Payment status</th>
                            <th>Order status</th>
                            {{-- <th>change Order status</th> --}}
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>#{{ $settings->invoice($item->id) }}</td>
                                    {{-- <td>{{ $item->webCustomer ? $item->webCustomer->first_name : 'Guest' }}</td> --}}
                                    <td>{{ $item->webCustomer ? $item->webCustomer->email : '-' }}</td>
                                    {{-- <td>{{ $item->webCustomer ? $item->webCustomer->phone : '-' }}</td> --}}
                                    <td>
                                        @foreach ($item->items as $i)
                                            {{ $i->product->name ?? '' }}
                                            @if ($i->variant)
                                                ({{ $i->variant->variant_name }})
                                            @endif
                                            x{{ $i->quantity }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ number_format($item->subtotal, 2) }}</td>
                                    <td>{{ number_format($item->discount, 2) }}</td>
                                    <td>{{ number_format($item->vat, 2) }}</td>
                                    <td>{{ number_format($item->total, 2) }}</td>
                                    <td>{{ $item->delivery_method ?? '-' }}</td>
                                    <td>{{ $item->payment_method ?? '-' }}</td>
                                    <td>{{ $item->payment_status }}</td>
                                    {{-- <td>{{ $item->status }}</td> --}}
                                    <td>
                                        <select class="form-select order-status" data-id="{{ $item->id }}" style="width:150px">
                                            @foreach ($item->nextStatuses() as $status)
                                                <option value="{{ $status }}"
                                                    {{ $item->status == $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        @can('view orders')
                                            <a href="javascript:void(0)" data-url="{{ route('orders.show', [$item->id]) }}"
                                                data-title="View Order" data-size="xl" data-location="centered"
                                                data-ajax-popup="true" data-bs-toggle="tooltip" title="View Order"
                                                class="btn btn-sm btn-light"><i class="mdi mdi-eye"></i>
                                            </a>
                                        @endcan
                                        <a href="{{ route('order.print', [$item->id]) }}" target="__blank"
                                            class="btn btn-sm btn-soft-warning ms-1" data-bs-toggle="tooltip"
                                            title="Print">
                                            <i class="mdi mdi-printer"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.order-status').forEach(select => {
                select.addEventListener('change', function() {
                    let orderId = this.dataset.id;
                    let newStatus = this.value;

                    fetch("{{ route('orders.updateStatus') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                id: orderId,
                                status: newStatus
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert('Status updated to ' + data.status);
                                location.reload(); // or update row in table
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Something went wrong!');
                        });

                });
            });
        });
    </script>
@endsection
