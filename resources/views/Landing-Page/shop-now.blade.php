@extends('landing-page.layouts.app')

@section('content')
    <div class="container-fluid"
        style="background: url('{{ asset('build/images/bg.jpg') }}') no-repeat center center;
        background-color:whitesmoke; background-size: cover; padding: 60px 15px;
        margin-top:50px">

        <div class="text-center mb-5">
            <h2 class="fw-bold">OUR OUTLETS</h2>
            <p>Please choose your nearest outlet for a better service.</p>
        </div>

        <div class="row justify-content-center text-center">
            <div class="col-md-3 col-10 mb-4">
                <a href="{{ route('select.branch', 'galle') }}" style="text-decoration: none;">
                    <img src="{{ asset('build/images/colombo-store.png') }}" alt="Colombo 3 Store" class="img-fluid mb-2">
                </a>
            </div>

            <div class="col-md-3 col-10 mb-4">
                <a href="{{ route('select.branch', 'kandy') }}" style="text-decoration: none;">
                    <img src="{{ asset('build/images/kandy-store.png') }}" alt="Kandy Store" class="img-fluid mb-2">
                </a>
            </div>

            <div class="col-md-3 col-10 mb-4">
                <a href="{{ route('select.branch', 'galle') }}" style="text-decoration: none;">
                    <img src="{{ asset('build/images/tissamaharama-store.png') }}" alt="Tissamaharama Store"
                        class="img-fluid mb-2">
                </a>
            </div>

        </div>
    </div>
@endsection
