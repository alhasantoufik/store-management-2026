@extends('backend.app')
@section('title', 'Products')
@section('page-content')

<div class="card border-0 shadow-sm mt-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-dark">Product List</h5>
        <button class="btn btn-success px-4 shadow-sm" id="addProductBtn" data-bs-toggle="modal" data-bs-target="#productModal">
            <i class="fas fa-plus-circle me-1"></i> Add Product
        </button>
    </div>

    <div class="card-body">
        <div class="mb-3" style="max-width: 300px;">
            <input type="text" id="productSearch" class="form-control form-control-sm" placeholder="Search Product by Name...">
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Purchase Price</th>
                        <th>Sale Price</th>
                        <th>Unit</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="product-table">
                    @foreach($products as $product)
                    <tr id="product-{{ $product->id }}">
                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $product->name }}</td>
                        <td>{{ $product->category->title }}</td>
                        <td>{{ $product->brand->name }}</td>
                        <td class="text-secondary">{{ number_format($product->product_price, 2) }} Tk.</td>
                        <td class="text-success fw-bold">{{ number_format($product->sale_price, 2) }} Tk.</td>
                        <td>{{ $product->unit }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill {{ strtolower($product->status) == 'active' ? 'bg-success' : 'bg-secondary' }} px-3">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-warning text-white edit-btn" data-id="{{ $product->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $product->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="productForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="product_id">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Brand</label>
                        <select name="brand_id" class="form-control" required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Purchase Price</label>
                        <input type="number" name="product_price" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Sale Price</label>
                        <input type="number" name="sale_price" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Unit</label>
                        <input type="text" name="unit" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    <button type="button" class="btn btn-primary d-none" id="updateBtn">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        // When clicking Add Product
        $('#addProductBtn').click(function() {
            $('#productForm')[0].reset();
            $('#product_id').val('');
            $('#modalTitle').text('Add Product');
            $('#saveBtn').removeClass('d-none');
            $('#updateBtn').addClass('d-none');
        });

        // ===============================
        // Store (Add New Product)
        // ===============================
        $('#productForm').on('submit', function(e) {
            e.preventDefault();
            let productId = $('#product_id').val();
            if (!productId) { // Only store if no product_id
                let url = "{{ route('products.store') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {

                        location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            alert(Object.values(xhr.responseJSON.errors).join("\n"));
                        }
                        console.log(xhr);
                    }
                });
            }
        });

        // ===============================
        // Edit (Load Product into Modal)
        // ===============================
        $('.edit-btn').click(function() {
            let id = $(this).data('id');
            let url = "{{ route('products.edit', ':id') }}".replace(':id', id);
            $.get(url, function(res) {
                $('#modalTitle').text('Edit Product');
                $('#product_id').val(res.product.id);
                $('#productForm [name=name]').val(res.product.name);
                $('#productForm [name=category_id]').val(res.product.category_id);
                $('#productForm [name=brand_id]').val(res.product.brand_id);
                $('#productForm [name=product_price]').val(res.product.product_price);
                $('#productForm [name=sale_price]').val(res.product.sale_price);
                $('#productForm [name=unit]').val(res.product.unit);
                $('#productForm [name=status]').val(res.product.status);
                $('#saveBtn').addClass('d-none');
                $('#updateBtn').removeClass('d-none');
                $('#productModal').modal('show');
            });
        });

        // ===============================
        // Update (Edit Product)
        // ===============================
        $('#updateBtn').click(function(e) {
            e.preventDefault();
            let id = $('#product_id').val();
            if (!id) return;
            let url = "{{ route('products.update', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'POST', // or PUT if your route uses PUT
                data: $('#productForm').serialize(),
                success: function(res) {

                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        alert(Object.values(xhr.responseJSON.errors).join("\n"));
                    }
                    console.log(xhr);
                }
            });
        });

        // ===============================
        // Delete Product
        // ===============================
        $('.delete-btn').click(function() {
            if (!confirm('Are you sure?')) return;
            let id = $(this).data('id');
            let url = "{{ route('products.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {

                    $('#product-' + id).remove();
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

    });



    // Live Search
    $('#productSearch').on('keyup', function() {
        let query = $(this).val();

        $.ajax({
            url: "{{ route('products.index') }}",
            type: 'GET',
            data: {
                search: query
            },
            success: function(res) {
                $('#product-table').html(res.html);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    });
</script>
@endpush