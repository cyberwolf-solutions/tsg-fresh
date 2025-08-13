@extends('layouts.adminMaster')

@section('title', 'Web Settings')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <h1>Web Settings</h1>
        </div>

        <div class="card">
            <div class="card-body">
                @foreach ($sections as $section)
                    <div class="mb-5 p-3 border rounded">
                        <h3 class="mb-4">{{ $section->title ?? ucfirst(str_replace('_', ' ', $section->name)) }}</h3>

                        <div class="row mb-3">
                            @foreach ($section->items as $item)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        @if ($item->image_path)
                                            <img src="{{ asset('storage/' . $item->image_path) }}" class="card-img-top"
                                                style="height: 200px; object-fit: cover;" alt="{{ $item->title }}">
                                        @endif
                                        <div class="card-body">
                                            @if ($item->title)
                                                <h5 class="card-title">{{ $item->title }}</h5>
                                            @endif
                                            @if ($item->description)
                                                <p class="card-text">{{ Str::limit($item->description, 100) }}</p>
                                            @endif
                                        </div>
                                        <div class="card-footer bg-white">
                                            <div class="d-flex justify-content-between">
                                                <a href="#" class="btn btn-sm btn-primary edit-item-btn"
                                                    data-bs-toggle="modal" data-bs-target="#itemModal"
                                                    data-item='@json($item)'>
                                                    Edit
                                                </a>
                                                <form action="{{ route('delete-item', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="btn btn-success add-item-btn" data-section-id="{{ $section->id }}"
                            data-section-name="{{ $section->name }}" data-bs-toggle="modal" data-bs-target="#itemModal">
                            Add Item to {{ $section->title ?? ucfirst(str_replace('_', ' ', $section->name)) }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add/Edit Item Modal -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="itemForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="section_id" id="section_id">
                    <input type="hidden" name="_method" id="form_method" value="POST">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add New Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" id="item_title" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" id="item_description" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Button Text</label>
                                    <input type="text" name="button_text" id="item_button_text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Button Link</label>
                                    <input type="text" name="button_link" id="item_button_link" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="image" id="item_image" class="form-control">
                                    <small class="text-muted">Image will be resized to fit the section</small>
                                    <div id="imagePreview" class="mt-2"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Order</label>
                                    <input type="number" name="order" id="item_order" class="form-control">
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="is_active" id="item_is_active" class="form-check-input"
                                        checked>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle add item button
            $('.add-item-btn').click(function() {
                $('#modalTitle').text('Add Item to ' + $(this).data('section-name'));
                $('#section_id').val($(this).data('section-id'));
                $('#itemForm').attr('action', "{{ route('store-item') }}");
                $('#form_method').val('POST');
                $('#itemForm')[0].reset();
                $('#imagePreview').empty();
            });

            // Handle edit item button
            $('.edit-item-btn').click(function() {
                const item = $(this).data('item');
                $('#modalTitle').text('Edit Item');
                $('#section_id').val(item.section_id);
                $('#item_title').val(item.title);
                $('#item_description').val(item.description);
                $('#item_button_text').val(item.button_text);
                $('#item_button_link').val(item.button_link);
                $('#item_order').val(item.order);
                $('#item_is_active').prop('checked', item.is_active);

                if (item.image_path) {
                    $('#imagePreview').html(
                        `<img src="{{ asset('storage') }}/${item.image_path}" class="img-thumbnail" style="max-height: 150px;">`
                    );
                }

                $('#itemForm').attr('action', "{{ route('update-item', '') }}/" + item.id);
                $('#form_method').val('PUT');
            });

            // Preview image before upload
            $('#item_image').change(function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').html(
                            `<img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">`
                        );
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endpush
