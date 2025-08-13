@extends('layouts.adminMaster')

@section('title', 'Branches Management')

@section('content')
    <div class="page-header mb-4">
        <h1 class="fw-bold">Branches Management</h1>
        <p class="text-muted">Create and manage tenant branches</p>
    </div>

    <!-- Display success/error messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Create Branch Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-plus-circle me-2"></i> Create New Branch
        </div>
        <div class="card-body">
            <form id="createBranchForm" method="POST" action="{{ route('branches.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="id" class="form-label">Branch ID</label>
                        <input type="text" class="form-control" name="id" placeholder="e.g. branch001" required>
                    </div>
                    <div class="col-md-6">
                        <label for="domain" class="form-label">Domain</label>
                        <input type="text" class="form-control" name="domain" placeholder="e.g. branch1.example.com"
                            required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-save me-1"></i> Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Branches Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-table me-2"></i> Existing Branches
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="branchesTable" class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Domain</th>
                            <th>Created At</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tenants as $tenant)
                            <tr>
                                <td>{{ $tenant->id }}</td>
                                <td>{{ $tenant->domains->first()->domain ?? 'N/A' }}</td>
                                <td>{{ $tenant->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No branches found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#branchesTable').DataTable();
        });
    </script>
@endsection
