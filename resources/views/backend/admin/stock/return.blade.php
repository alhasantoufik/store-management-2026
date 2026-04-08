@extends('backend.app')
@section('title', 'Stock Management')

@section('page-content')

<style>
    .input-group-text {
        border-right: none;
    }

    #transaction_date {
        border-left: none;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .removeRow:hover {
        background-color: #dc3545;
        color: white;
    }

    /* Mobile Responsive Logic */
    @media (max-width: 768px) {

        /* Header controls auto-stacking */
        .card-header.d-flex {
            flex-direction: column !important;
            gap: 15px !important;
        }

        .card-header div,
        .card-header .input-group {
            width: 100% !important;
        }

        /* Table to Card Transformation */
        #stockTable thead {
            display: none;
            /* Hide headers on mobile */
        }

        #stockTable tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            padding: 10px;
            border-radius: 8px;
            position: relative;
            background: #fff;
        }

        #stockTable td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: none;
            padding: 5px 0;
            text-align: right !important;
        }

        /* Add labels before data on mobile */
        #stockTable td::before {
            content: attr(data-label);
            font-weight: bold;
            text-transform: capitalize;
            text-align: left;
            flex: 1;
        }

        #stockTable td:first-child {
            border-bottom: 1px solid #eee;
            margin-bottom: 5px;
            padding-bottom: 10px;
        }

        .removeRow {
            position: absolute;
            top: 5px;
            right: 5px;
        }
    }

    /* Mobile Responsive Logic */
    @media (max-width: 768px) {
        .card-header.d-flex {
            flex-direction: column !important;
            gap: 15px !important;
        }

        .card-header div,
        .card-header .input-group {
            width: 100% !important;
        }

        #stockTable thead {
            display: none;
        }

        #stockTable tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            padding: 15px;
            /* প্যাডিং একটু বাড়ানো হয়েছে */
            border-radius: 8px;
            position: relative;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        #stockTable td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: none;
            padding: 8px 0;
            text-align: right !important;
        }

        /* প্রোডাক্ট নামের সেকশন ফিক্স */
        #stockTable td:first-child {
            display: block;
            /* নামকে পুরো লাইনে দেখাবে */
            text-align: left !important;
            border-bottom: 1px solid #eee;
            margin-bottom: 10px;
            padding-bottom: 10px;
            padding-right: 40px;
            /* ডিলিট বাটনের জন্য জায়গা রাখা হয়েছে */
        }

        #stockTable td::before {
            content: attr(data-label);
            font-weight: bold;
            text-transform: capitalize;
            text-align: left;
            flex: 1;
            color: #666;
        }

        /* প্রথম সেলে (Product Name) লেবেল প্রয়োজন নেই */
        #stockTable td:first-child::before {
            content: "";
        }

        /* ডিলিট বাটন পজিশন ফিক্স */
        .removeRow {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 10;
            background: #fff5f5;
            /* হালকা লাল ব্যাকগ্রাউন্ড */
        }
    }

    /* Select2-এর হাইট ফিক্স করার জন্য */
    .select2-container--bootstrap-5 .select2-selection {
        height: calc(2.5rem + 1px) !important;
        /* অথবা সরাসরি 38px বা 40px দিতে পারেন */
        min-height: 20px !important;
        display: flex;
        align-items: center;
    }

    /* সার্চ বক্সের ভেতরের টেক্সট এলাইনমেন্ট ঠিক করার জন্য */
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
        padding-left: 12px !important;
    }

    /* ক্লিয়ার (x) বাটন এবং অ্যারো কি-এর পজিশন ঠিক করার জন্য */
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow,
    .select2-container--bootstrap-5 .select2-selection__clear {
        height: 38px !important;
    }
</style>
<div class="container-fluid mt-4">
    <form action="{{ route('stock.return') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                <h4 class="mb-0">Stock Return</h4>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 220px;">
                        <span class="input-group-text bg-light"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" name="transaction_date" id="transaction_date"
                            class="form-control"
                            value="{{ date('Y-m-d') }}">
                    </div>

                    <div style="width: 300px;">
                        <select id="mainProductSelect" class="form-control select2">
                            <option value="">Add Product</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="stockTable">
                        <thead class="bg-light">
                            <tr>
                                <th width="30%">Product Name</th>
                                <th class="text-center">Current Stock</th>
                                <th width="15%">Quantity</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Total Price</th>
                                <th class="text-center">New Stock</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div id="emptyMsg" class="text-center py-4 text-muted">
                    <p>No products added yet. Select a product from the dropdown above.</p>
                </div>

                <div class="text-end mt-4">
                    <hr>
                    <button type="submit" class="btn btn-warning btn-lg px-5 shadow-sm">
                        <i class="fas fa-undo me-1"></i> Stock Return
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
    let rowCount = 0;

    $(document).ready(function() {
        // Initialize Select2
        if ($.isFunction($.fn.select2)) {
            $('.select2').select2({
                placeholder: "Search Products",
                allowClear: true,
                theme: 'bootstrap-5' // Omit if not using Bootstrap 5 theme for Select2
            });
        }

        // 1. Add row when product is selected
        $('#mainProductSelect').on('change', function() {
            let productId = $(this).val();
            let productName = $("#mainProductSelect option:selected").text();

            if (productId) {
                let exists = false;
                $('.row-product-id').each(function() {
                    if ($(this).val() == productId) exists = true;
                });

                if (exists) {
                    alert('This product is already in the list!');
                    $(this).val(null).trigger('change');
                    return;
                }

                $('#emptyMsg').hide();
                addNewRow(productId, productName);
                $(this).val(null).trigger('change');
            }
        });
    });

    // 2. Add Row Function
    function addNewRow(productId, productName) {
        let row = `
    <tr id="row_${rowCount}" class="align-middle">
        <td data-label="Product">
            <input type="hidden" name="products[${rowCount}][product_id]" value="${productId}" class="row-product-id">
            <span class="fw-bold text-dark">${productName}</span>
        </td>
        <td data-label="Current Stock" class="currentStockText text-center text-muted">Loading...</td>
        <td data-label="Quantity">
            <input type="number" name="products[${rowCount}][quantity]" class="form-control qty shadow-sm" 
                   placeholder="Qty" min="1" required style="max-width: 120px; margin-left: auto;">
        </td>
        <td data-label="Unit Price">
    <input type="number" step="0.01"
        name="products[${rowCount}][price]"
        class="form-control unitPriceInput text-end shadow-sm"
        placeholder="0.00"
        style="max-width: 120px; margin-left: auto;">
</td>
        <td data-label="Total Price" class="totalPriceText text-end fw-bold">0.00</td>
        <td data-label="New Stock" class="newStockText text-center font-weight-bold text-primary">0</td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger removeRow px-2">
                <i class="fas fa-trash-alt"></i>
            </button>
        </td>
    </tr>`;

        $('#stockTable tbody').append(row);
        fetchProductData(productId, $(`#row_${rowCount}`));
        rowCount++;
    }

    // 3. AJAX for Product Info
    function fetchProductData(productId, row) {
        let url = "{{ route('admin.product.info', ':id') }}".replace(':id', productId);

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                row.find('.currentStockText').text(data.stock || 0);

                // ✅ default product_price
                row.find('.unitPriceInput').val(data.price || 0);

                row.data('stock', data.stock || 0);

                calculateRow(row);
            }
        });
    }

    // 4. Remove Row
    $(document).on('click', '.removeRow', function() {
        $(this).closest('tr').remove();
        if ($('#stockTable tbody tr').length === 0) {
            $('#emptyMsg').show();
        }
    });

    // 5. Calculation
    $(document).on('input', '.qty', function() {
        calculateRow($(this).closest('tr'));
    });

    function calculateRow(row) {
        let qty = parseInt(row.find('.qty').val()) || 0;
        let currentStock = parseFloat(row.data('stock')) || 0;
        let unitPrice = parseFloat(row.find('.unitPriceInput').val()) || 0;

        let newStock = currentStock + qty;
        let totalPrice = unitPrice * qty;

        row.find('.newStockText').text(newStock);
        row.find('.totalPriceText').text(totalPrice.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
    }
    $(document).on('input', '.unitPriceInput', function() {
        calculateRow($(this).closest('tr'));
    });
    
</script>


<style>
    .input-group-text {
        border-right: none;
    }

    #transaction_date {
        border-left: none;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .removeRow:hover {
        background-color: #dc3545;
        color: white;
    }
</style>
@endpush