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
                      @can('create brands')
                        <!-- Left Buttons -->
                        <div class="col d-flex gap-2">
                           

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

    <div class="row mt-3">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle" id="example">
                        <thead class="table-light">
                            <th>#</th>
                            {{-- <th>&nbsp;</th> --}}
                            <th>Date</th>
                            <th>Opening cash</th>
                            <th>Closing cash</th>
                            <th>Total cash received</th>
                            <th>Balance</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                               
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                   
                                    <td>{{ $item->date }}</td>
                                    <td>Rs. {{ $item->opening_cash }}</td>
                                    <td>Rs. {{ $item->closing_cash }}</td>
                                    <td>Rs. {{ $item->total_cash_received }}</td>
                                    <td>Rs. {{ $item->balance }}</td>
                                 
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
    <script>
        $(function(){
            $(".category").jqZoom({
                selectorWidth: 30,
                selectorHeight: 30,
                viewerWidth: 200,
                viewerHeight: 90
            });
        })
    </script>
@endsection
