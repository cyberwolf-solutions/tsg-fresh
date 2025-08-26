@extends('landing-page.layouts.app')



@section('content')
    <div class="" style="margin-top: 200Px">
        <div class="container my-4">
            <h4>Reset Password</h4>

            <form method="POST" action="{{ route('customer.reset-password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>New Password *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success"
                    style="background-color:#0d6efd !important; border-color:#0d6efd !important; color:#fff !important;">Update
                    Password</button>
            </form>
        </div>


    </div>



    @include('Landing-Page.partials.products')
@endsection
