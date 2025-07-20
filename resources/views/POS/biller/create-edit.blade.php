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
                    {{-- Add Buttons Here --}}
                    {{-- <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                        title="Create">
                        <i class="ri-add-line fs-5"></i>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="card">
            <div class="card-body">
                <form method="POST" class="ajax-form"
                    action="{{ $is_edit ? route('suppliers.update', $data->id) : route('suppliers.store') }}">
                    @csrf
                    @if ($is_edit)
                        @method('PATCH')
                    @endif
                    <div class="row">
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" id="" class="form-control"
                                value="{{ $is_edit ? $data->name : '' }}" placeholder="Enter Name" required />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Image</label>
                            <input type="file" id="imageUpload" name="image" accept="image/*" class="form-control"
                                value="{{ $is_edit ? $data->contact_primary : '' }}" placeholder="Enter primary contact"
                                required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Company Name</label>
                            <input type="text" name="companyname" id="" class="form-control"
                                value="{{ $is_edit ? $data->name : '' }}" placeholder="Enter Name" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="text" name="email" id="" class="form-control"
                                value="{{ $is_edit ? $data->email : '' }}" placeholder="Enter email" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Phone number</label>
                            <input type="text" name="contact" id="" class="form-control"
                                value="{{ $is_edit ? $data->contact : '' }}" placeholder="Enter Contact No" required />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">VAT number</label>
                            <input type="text" name="vat" id="" class="form-control"
                                value="{{ $is_edit ? $data->contact : '' }}" placeholder="Enter Contact No" required />
                        </div>

                    </div>

                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Address</label>
                            <textarea class="form-control" name="address" id="" rows="1" placeholder="Enter Address">{{ $is_edit ? $data->address : '' }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">City</label>
                            <input type="text" name="city" id="" class="form-control"
                                value="{{ $is_edit ? $data->passport_no : '' }}" placeholder="Enter Passport Number" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">State</label>
                            <input type="text" name="state" id="" class="form-control"
                                value="{{ $is_edit ? $data->nationality : '' }}" placeholder="Enter Nationality" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Postal code</label>
                            <input type="text" name="postal" id="" class="form-control"
                                value="{{ $is_edit ? $data->nationality : '' }}" placeholder="Enter Nationality" />
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Country</label>
                            <input type="text" name="country" id="" class="form-control"
                                value="{{ $is_edit ? $data->nationality : '' }}" placeholder="Enter Nationality" />
                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-light me-2"
                                onclick="window.location='{{ route('suppliers.index') }}'">Cancel</button>
                            <button class="btn btn-primary">{{ $is_edit ? 'Update' : 'Create' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
