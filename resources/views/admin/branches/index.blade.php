@extends('layouts.adminMaster')

@section('title')
    {{-- {{ $title }} --}}
@endsection
@section('content')
    <form method="POST" action="{{ route('branches.store') }}">
        {{-- @csrf --}}
        <input type="text" name="id" placeholder="Branch ID (e.g., branch1)" required>
        <input type="text" name="domain" placeholder="Domain (e.g., branch1.yourdomain.com)" required>
        <button type="submit">Create Branch</button>
    </form>
@endsection
