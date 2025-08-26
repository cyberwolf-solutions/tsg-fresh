@extends('landing-page.layouts.app')



@section('content')
    <div class="" style="margin-top: 200Px">
        <p>You requested a password reset.</p>
        <p>Click the link below to reset your password:</p>
        <a href="{{ $resetLink }}">{{ $resetLink }}</a>
        <p>If you did not request this, please ignore.</p>


    </div>



    @include('Landing-Page.partials.products')
@endsection
