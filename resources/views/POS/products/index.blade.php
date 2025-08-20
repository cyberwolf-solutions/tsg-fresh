@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            {{-- btns --}}

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
                    <!-- Left Buttons -->
                    <div class="col d-flex gap-2">
                        <a href="{{ route('products.create') }}" class="btn btn-sm btn-purple" style="  color: white;">
                            <i class="ri-add-line me-1"></i> Add Product
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
                </div>
            </div>

            {{-- btns --}}
        </div>
    </div>

    <div class="row mt-3">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle" id="example">
                        <thead class="table-light">
                            <th>#</th>
                            <th>&nbsp;</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                @php
                                    if ($item->image_url != null) {
                                        $image = 'uploads/products/' . $item->image_url;
                                    } else {
                                        $image = 'uploads/cutlery.png';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <div class="zoom-box">
                                            <img class="product" src="{{ URL::asset($image) }}" alt=""
                                                height="40">
                                        </div>
                                    </td>
                                    <td>{{ $item->product_code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @foreach ($item->categories as $category)
                                            <span class="badge  me-1" style="background-color: #525252">{{ $category->name }}</span>
                                        @endforeach
                                    </td>

                                    <td>{{ $item->brand->name }}</td>
                                    <td>Rs {{ number_format($item->final_price, 2) }}</td>
                                    <td>{{ $item->product_type }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>

                                        @can('view products')
                                            <a data-url="{{ route('products.show', [$item->id]) }}"
                                                class="btn btn-light btn-sm small btn-icon text-dark show-more">
                                                <i class="bi bi-eye" data-bs-toggle="tooltip" title="View"></i>
                                            </a>
                                        @endcan
                                        @can('edit products')
                                            <a href="{{ route('products.edit', [$item->id]) }}"
                                                class="btn btn-secondary btn-sm small btn-icon">
                                                <i class="bi bi-pencil-square" data-bs-toggle="tooltip" title="Edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete products')
                                            <a href="javascript:void(0)"
                                                data-url="{{ route('products.destroy', [$item->id]) }}"
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
{{-- @include('products.view-ingredients-modal') --}}

@section('script')
    <script>
        $(function() {
            $(".product").jqZoom({
                selectorWidth: 30,
                selectorHeight: 30,
                viewerWidth: 200,
                viewerHeight: 90
            });
        })

        $(document).on('click', '.show-ingredients', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            var id = $(this).data('id');
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "id": id
                },
                success: function(result) {
                    $('.ingredientBody').html(result);
                }
            });
            $('#viewIngredientModal').modal('show');
        });
    </script>
@endsection
