@extends('layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <!-- start page title -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="card">
            <div class="card-body">
                <form method="POST" class="ajax-form"
                    action="{{ $is_edit ? route('coupon.update', $data->id) : route('coupons.store') }}">
                    @csrf
                    @if ($is_edit)
                        @method('PATCH')
                    @endif

                    <div class="row">
                        <!-- Code -->
                        <div class="col-md-6 mb-3 required">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" name="code" class="form-control"
                                value="{{ $is_edit ? $data->code : '' }}" placeholder="Enter coupon code" required>
                        </div>

                        <!-- Type -->
                        <div class="col-md-6 mb-3 required">
                            <label class="form-label">Discount Type</label>
                            <select name="type" class="form-select" required>
                                <option value="">-- Select Type --</option>
                                <option value="fixed" {{ $is_edit && $data->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="percentage" {{ $is_edit && $data->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Value -->
                        <div class="col-md-6 mb-3 required">
                            <label class="form-label">Value</label>
                            <input type="number" step="0.01" name="value" class="form-control"
                                value="{{ $is_edit ? $data->value : '' }}" placeholder="Enter discount value" required>
                        </div>

                        <!-- Expiry Date -->
                        <div class="col-md-6 mb-3 required">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control"
                                value="{{ $is_edit ? $data->expiry_date : '' }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Max Uses -->
                        <div class="col-md-6 mb-3 required">
                            <label class="form-label">Max Uses</label>
                            <input type="number" name="max_uses" class="form-control"
                                value="{{ $is_edit ? $data->max_uses : '' }}" placeholder="Enter max uses" required>
                        </div>

                        <!-- Active -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="active" class="form-select">
                                <option value="1" {{ $is_edit && $data->active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $is_edit && !$data->active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-light me-2"
                                onclick="window.location='{{ route('coupon.index') }}'">Cancel</button>
                            <button class="btn btn-primary">{{ $is_edit ? 'Update Coupon' : 'Create Coupon' }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
