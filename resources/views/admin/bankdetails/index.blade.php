@extends('layouts.adminMaster')

@section('title', 'Bank Details Management')

@section('content')
    <div class="page-header mb-4">
        <h1 class="fw-bold">Bank Details Management</h1>
        <p class="text-muted">Add and manage bank account details</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create Bank Detail Form -->
    <!-- Create Bank Detail Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-plus-circle me-2"></i> Add Bank Detail
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('bank-details.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Tenant</label>
                        <select name="tenant_id" class="form-control" required>
                            <option value="">-- Select Tenant --</option>
                            @foreach ($tenants as $tenant)
                                <option value="{{ $tenant->id }}">{{ $tenant->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Branch</label>
                        <input type="text" name="branch" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Account Number</label>
                        <input type="text" name="account_number" class="form-control" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-save me-1"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bank Details Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-table me-2"></i> Existing Bank Details
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tenant</th>
                            <th>Bank Name</th>
                            <th>Branch</th>
                            <th>City</th>
                            <th>Account Number</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($banks as $bank)
                            <tr>
                                <td>{{ $bank->tenant->id ?? 'N/A' }}</td>

                                <td>{{ $bank->bank_name }}</td>
                                <td>{{ $bank->branch }}</td>
                                <td>{{ $bank->city }}</td>
                                <td>{{ $bank->account_number }}</td>
                                <td>{{ $bank->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form action="{{ route('bank-details.destroy', $bank->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this bank detail?');">
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
                                <td colspan="7" class="text-center text-muted">No bank details found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
