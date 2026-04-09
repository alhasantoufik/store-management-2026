@extends('backend.app')
@section('title', 'All Stock Management')
@section('page-content')
<style>
    /* Select2 এর উচ্চতা বুটস্ট্র্যাপের ইনপুটের সমান করার জন্য */
    .select2-container .select2-selection--single {
        height: 38px !important;
        /* বুটস্ট্র্যাপ ৪/৫ এর স্ট্যান্ডার্ড হাইট */
        display: flex;
        align-items: center;
        border: 1px solid #dee2e6;
        /* বর্ডারের রঙ ইনপুটের মতো রাখা */
    }

    /* টেক্সটকে সেন্টারে রাখার জন্য */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
        padding-left: 12px;
    }

    /* ড্রপডাউন অ্যারো (Arrow) এর পজিশন ঠিক করার জন্য */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>
<div class="card border-0 shadow-sm mt-3">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark">Product Stock List</h5>
    </div>

    <div class="card-body">
        <!-- Filter Section -->
        <div class="row mb-3 g-2 align-items-center">
            <div class="col-md-3">
                <select id="filterCategory" class="form-control select2">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select id="filterBrand" class="form-control select2">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select id="filterProduct" class="form-control select2">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button id="btnFilter" class="btn btn-primary flex-grow-1">Filter</button>
                <button id="btnReset" class="btn btn-secondary flex-grow-1">Reset</button>
            </div>
        </div>

        <!-- Stock Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Stock Available</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $key => $product)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->title ?? 'N/A' }}</td>
                        <td>{{ $product->brand->name ?? 'N/A' }}</td>
                        <td>{{ $product->total_stock }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="4" class="text-end">Total Stock:</th>
                        <th>
                            {{ $products->sum('total_stock') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {

        $('#filterCategory').select2({
            placeholder: "Category Search",
            allowClear: true
        });

    })
    $(document).ready(function() {

        $('#filterBrand').select2({
            placeholder: "Brand Search",
            allowClear: true
        });

    })
    $(document).ready(function() {

        $('#filterProduct').select2({
            placeholder: "Product Search",
            allowClear: true
        });

    })
</script>
<script>
    $(document).ready(function() {
        // Filter button click
        $('#btnFilter').click(function() {
            let category_id = $('#filterCategory').val();
            let brand_id = $('#filterBrand').val();
            let product_id = $('#filterProduct').val();

            let query = '?';
            if (category_id) query += 'category_id=' + category_id + '&';
            if (brand_id) query += 'brand_id=' + brand_id + '&';
            if (product_id) query += 'product_id=' + product_id + '&';

            window.location.href = "{{ route('admin.stocks.index') }}" + query.slice(0, -1);
        });

        // Reset button click
        $('#btnReset').click(function() {
            window.location.href = "{{ route('admin.stocks.index') }}";
        });
    });
</script>
@endpush