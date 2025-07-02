@extends('layouts.master')

@section('content')
    <h1>Create Branch</h1>
    <form method="POST" action="{{ route('branches.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Branch Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="domain">Domain/Subdomain</label>
            <input type="text" name="domain" class="form-control" placeholder="e.g., branch1.localhost"
                value="{{ old('domain') }}" required>
            @error('domain')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="contact_email">Contact Email</label>
            <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email') }}">
            @error('contact_email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="contact_phone">Contact Phone</label>
            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone') }}">
            @error('contact_phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" class="form-control">{{ old('address') }}</textarea>
            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
