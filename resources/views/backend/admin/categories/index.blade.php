@extends('backend.app')
@section('title', 'Category List')
@section('page-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0">Category List</h3>

    <button class="btn btn-success px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus-circle me-1"></i> Add Category
    </button>
</div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>SL</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="categoryTable">
                @foreach($categories as $key => $cat)
                <tr data-id="{{ $cat->id }}">
                    <td>{{ $key+1 }}</td>
                    <td>{{ $cat->title }}</td>
                    <td>
                        @if($cat->image)
                        <img src="{{ asset('uploads/category/'.$cat->image) }}" width="50" alt="{{ $cat->title }}">
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $cat->status ? 'bg-success' : 'bg-secondary' }}">
                            {{ $cat->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm editBtn" data-id="{{ $cat->id }}">Edit</button>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $cat->id }}">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form id="addForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="title" class="form-control mb-3" placeholder="Category Title" required>
                    <input type="file" name="image" class="form-control mb-3" accept="image/*">
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <form id="editForm">
            @csrf
            <input type="hidden" id="edit_id" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="edit_title" name="title" class="form-control mb-3" required>

                    <div class="mb-3">
                        <label>Current Image:</label><br>
                        <img id="current_image" src="" width="80" class="mb-2" style="display:none; border:1px solid #ddd; padding:3px;">
                    </div>

                    <input type="file" name="image" class="form-control mb-3" accept="image/*">

                    <select id="edit_status" name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });


    // ==================== EDIT CATEGORY ====================
    $(document).on('click', '.editBtn', function() {
        let id = $(this).data('id');

        $.ajax({
            url: "{{ route('categories.edit.ajax', ':id') }}".replace(':id', id),
            method: "GET",
            success: function(category) {
                $('#edit_id').val(category.id);
                $('#edit_title').val(category.title);
                $('#edit_status').val(category.status);

                if (category.image) {
                    $('#current_image').attr('src', "{{ asset('uploads/category/') }}/" + category.image).show();
                } else {
                    $('#current_image').hide();
                }

                $('#editModal').modal('show');
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Failed to load category data for editing.');
            }
        });
    });

    // ==================== UPDATE CATEGORY ====================
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_id').val();
        let formData = new FormData(this);
        formData.append('_method', 'PUT'); // Required for Laravel PUT

        $.ajax({
            url: "{{ route('categories.update', ':id') }}".replace(':id', id), // ✅ Use named route
            method: "POST", // Keep POST, Laravel treats it as PUT because of _method
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#editModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                console.error(xhr);
                let msg = xhr.responseJSON?.message || 'Failed to update category!';
                alert(msg);
            }
        });
    });
    // ==================== DELETE CATEGORY ====================
    $(document).on('click', '.deleteBtn', function() {
        if (!confirm('Are you sure you want to delete this category?')) return;

        let id = $(this).data('id');

        $.ajax({
            url: "{{ route('categories.destroy', ':id') }}".replace(':id', id),
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Failed to delete category!');
            }
        });
    });
    // ==================== ADD CATEGORY ====================
    $('#addForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('categories.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#addModal').modal('hide');
                    $('#addForm')[0].reset();
                    location.reload();
                }
            },
            error: function(xhr) {
                console.error(xhr);
                let msg = xhr.responseJSON?.message || 'Failed to add category!';
                alert(msg);
            }
        });
    });
</script>
@endpush