@extends('layouts.adminMaster')

@section('title', 'Delivery Charges Management')

@section('content')
    <div class="page-header mb-4">
        <h1 class="fw-bold">Delivery Charges Management</h1>
        <p class="text-muted">Set delivery charges for tenants</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create Delivery Charge Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-plus-circle me-2"></i> Add Delivery Charge
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('delivery-charges.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Tenant</label>
                        <select name="tenant_id" class="form-control" required>
                            <option value="">-- Select Tenant --</option>
                            @foreach ($tenants as $tenant)
                                <option value="{{ $tenant->id }}">{{ $tenant->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Price From</label>
                        <input type="number" step="0.01" name="price_from" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Price To</label>
                        <input type="number" step="0.01" name="price_to" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Charge</label>
                        <input type="number" step="0.01" name="charge" class="form-control" required>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-save me-1"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delivery Charges Table -->
    <!-- Delivery Charges Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-table me-2"></i> Existing Delivery Charges
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tenant</th>
                            <th>Price From</th>
                            <th>Price To</th>
                            <th>Charge</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($charges as $charge)
                            <tr>
                                <td>{{ $charge->tenant->id }}</td>
                                <td>{{ $charge->price_from }}</td>
                                <td>{{ $charge->price_to }}</td>
                                <td>{{ $charge->charge }}</td>
                                <td>{{ $charge->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form action="{{ route('delivery-charges.destroy', $charge->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this charge?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No delivery charges found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
