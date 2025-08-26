@extends('landing-page.layouts.app')



@section('content')
    <div class="" style="margin-top: 200Px">
        <div class="container my-4" style="margin-top: 50px;">

            <p class="text-secondary ">
                Lost your password? Please enter your username or email address.
                You will receive a link to create a new password via email.
            </p>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('customer.forgot-password.send') }}">
                @csrf
                <div class="mb-3">
                    <label class=" fw-semibold small">Username or email *</label>
                    <input type="email" name="email" class="form-control" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary"
                    style="background-color:#0d6efd !important; border-color:#0d6efd !important; color:#fff !important;">
                    RESET PASSWORD
                </button>

            </form>
        </div>

    </div>



    @include('Landing-Page.partials.products')
@endsection
