@extends('layouts.master')

@section('content')
    <h1>Branches</h1>
    <a href="{{ route('branches.create') }}" class="btn btn-primary">Add Branch</a>

    @if ($branches->isEmpty())
        <p>No branches found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Domain</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($branches as $branch)
                    <tr>
                        <td>{{ isset($branch->data['name']) ? $branch->data['name'] : 'Unnamed Branch' }}</td>
                        <td>{{ $branch->domains->first()->domain ?? 'No domain' }}</td>
                        <td>
                            @if ($branch->domains->first())
                                <a href="http://{{ $branch->domains->first()->domain }}/products" target="_blank">Visit</a>
                            @else
                                <span>No domain</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
