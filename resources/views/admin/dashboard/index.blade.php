@extends('layouts.adminMaster')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h1>Dashboard</h1>
        <p class="text-muted">Overview of your multi-tenant system</p>
    </div>

    <div class="row">
        <!-- Tenant Statistics Widget -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-1">Total Tenants</h6>
                            <h3 class="mb-0">{{ $tenantsCount }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-building text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.branches.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Tenants Widget -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-1">Active Tenants</h6>
                            <h3 class="mb-0">{{ $activeTenantsCount }}</h3>
                            <small class="text-success">{{ $activePercentage }}% of total</small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-check-circle text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-lightbulb text-warning mb-2" style="font-size: 1.5rem;"></i>
                    <h6 class="text-muted mb-1">Quick Tip</h6>
                    <p class="small mb-0">You can monitor tenant activity and system health here.</p>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-4">
        <!-- Recent Tenants Table -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Recently Created Tenants</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Domain</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentTenants as $tenant)
                                    <tr>
                                        <td>{{ $tenant->id }}</td>
                                        <td>{{ $tenant->domains->first()->domain ?? 'N/A' }}</td>
                                        <td>{{ $tenant->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Health Widget -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">System Health</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Database Usage</span>
                            <span>{{ $databaseUsage }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $databaseUsage }}%"
                                aria-valuenow="{{ $databaseUsage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Storage Usage</span>
                            <span>{{ $storageUsage }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $storageUsage }}%"
                                aria-valuenow="{{ $storageUsage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="alert alert-light">
                        <i class="fas fa-info-circle me-2"></i>
                        Last backup: {{ $lastBackup }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
