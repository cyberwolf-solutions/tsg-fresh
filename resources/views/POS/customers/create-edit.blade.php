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
                    {{-- <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
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
                    action="{{ $is_edit ? route('customers.update', $data->id) : route('customers.store') }}">
                    @csrf
                    @if ($is_edit)
                        @method('PATCH')
                    @endif
                    <div class="row">
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Customer group</label>
                         
                                <select class="form-control js-example-basic-single" name="cgroup" id="">
                                    <option value="" selected>Select...</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ $is_edit && $data->currency_id == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                        
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" id="" class="form-control"
                                value="{{ $is_edit ? $data->name : '' }}" placeholder="Enter Name" required />
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
                            <label for="" class="form-label">Tax number</label>
                            <input type="text" name="tax" id="" class="form-control"
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
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                                <label class="form-check-label" for="checkDefault">
                                    Add user
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Country</label>
                            <input type="text" name="country" id="" class="form-control"
                                value="{{ $is_edit ? $data->nationality : '' }}" placeholder="Enter Nationality" />
                        </div>

                    </div>
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="signature-pad">
                                <canvas id="signature-pad" class="signature-pad"></canvas>
                                <button id="clear">Clear</button>
                                
                            </div>
                            <input type="hidden" name="signature" id="signature">
                        </div>
                        
                    </div> --}}
                    {{-- <div class="row">
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Currency</label>
                            <select class="form-control js-example-basic-single" name="currency" id="">
                                <option value="" selected>Select...</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}"
                                        {{ $is_edit && $data->currency_id == $currency->id ? 'selected' : '' }}>
                                        {{ $currency->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label required">Type</label>
                            <select class="form-control js-example-basic-single" name="type" id="">
                                <option value="" selected>Select...</option>

                                <option value="customer">
                                    Customer
                                </option>
                                <option value="ta">
                                    Travel agent
                                </option>
                            </select>
                        </div>

                    </div> --}}
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-light me-2"
                                onclick="window.location='{{ route('customers.index') }}'">Cancel</button>
                            <button class="btn btn-primary" id="save">{{ $is_edit ? 'Update' : 'Create' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

    <script>
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas);

        document.getElementById('clear').addEventListener('click', () => {
            signaturePad.clear();
        });

        document.getElementById('save').addEventListener('click', function() {


            document.getElementById('signature').value = signatureData;

            //    var sig =  document.getElementById('signature').val;

            //     alert(sig);

            // const signatureData = signaturePad.toDataURL();


            // document.getElementById('signature').value = signatureData;




            // document.querySelector('.ajax-form').submit();
        });
    </script>
@endsection
