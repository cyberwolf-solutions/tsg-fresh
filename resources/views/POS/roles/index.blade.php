@extends('layouts.master')

@section('title')
    {{ $title }}
@endsection
@section('content')
    <!-- start page title -->
    

       {{-- btns --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div>
                    <h3 class="mb-sm-0">{{ $title }}</h3>
                    <ol class="breadcrumb m-0 mt-2">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active' : '' }}">
                                @if (!$breadcrumb['active'])
                                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                                @else
                                    {{ $breadcrumb['label'] }}
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
                <!-- Action Buttons Row -->
                <div class="row mt-3">
                      @can('create roles')
                        <!-- Left Buttons -->
                        <div class="col d-flex gap-2">
                            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-purple" style="  color: white;">
                                <i class="ri-add-line me-1"></i> Add role
                            </a>

                            <a href="" class="btn btn-sm" style="background-color: #00cfc8; color: white;">
                                <i class="ri-upload-cloud-line me-1"></i> Import
                            </a>
                        </div>
                        <!-- Right Buttons -->
                        <div class="col text-end d-flex justify-content-end gap-2">
                            <a href="" class="btn btn-sm" style="background-color: #3e3e3e; color: white;">
                                <i class="ri-file-pdf-line me-1"></i> PDF
                            </a>

                            <a href="" class="btn btn-sm" style="background-color: #fb9746; color: white;">
                                <i class="ri-file-line me-1"></i> CSV
                            </a>

                            <button onclick="window.print()" class="btn btn-sm"
                                style="background-color: #2d9cd4; color: white;">
                                <i class="ri-printer-line me-1"></i> Print
                            </button>

                            <button onclick="deleteSelected()" class="btn btn-sm"
                                style="background-color: #ef4444; color: white;">
                                <i class="ri-delete-bin-line me-1"></i> Delete
                            </button>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    {{-- btns --}}

    <div class="collapse" id="collapseExample">
        <div class="card mb-0">
            <div class="card-body">

            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle" id="example">
                        <thead class="table-light">
                            <th>Role</th>
                            <th width="70%">Permissions</th>
                            <th width="10%">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                @if ($item->name == 'Super Admin')
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @foreach ($item->permissions as $permission)
                                            <span
                                                class="badge bg-primary-subtle fw-normal rounded-pill m-1">{{ $permission->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @can('edit roles')
                                            <a href="{{ route('roles.edit', [$item->id]) }}"
                                                class="btn btn-secondary btn-sm small btn-icon">
                                                <i class="bi bi-pencil-square" data-bs-toggle="tooltip" title="Edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete roles')
                                            <a href="javascript:void(0)" data-url="{{ route('roles.destroy', [$item->id]) }}"
                                                class="btn btn-danger btn-sm small btn-icon delete_confirm">
                                                <i class="bi bi-trash" data-bs-toggle="tooltip" title="Delete"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
@endsection
