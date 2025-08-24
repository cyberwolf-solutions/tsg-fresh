@extends('layouts.adminMaster')

@section('title', 'Product Reviews Management')

@section('content')
    <div class="page-header mb-4">
        <h1 class="fw-bold">Product Reviews Management</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach ($tenantReviews as $tenantId => $data)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                Tenant: {{ $data['tenant']->id }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Review</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['reviews'] as $review)
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>{{ $review->customer->first_name ?? 'N/A' }}
                                        {{ $review->customer->last_name ?? '' }}</td>
                                    <td>{{ $review->product->name ?? 'N/A' }}</td>
                                    <td>{{ $review->review }}</td>
                                    <td>{{ $review->status }}</td>
                                    <td>
                                        <form
                                            action="{{ route('admin.reviews.approve', ['tenant' => $tenantId, 'review' => $review->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <button class="btn btn-sm btn-success">Approve</button>
                                        </form>

                                        <form
                                            action="{{ route('admin.reviews.destroy', ['tenant' => $tenantId, 'review' => $review->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No reviews found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Tenant-specific pagination --}}
                    {{ $data['reviews']->links() }}
                </div>
            </div>
        </div>
    @endforeach
@endsection
