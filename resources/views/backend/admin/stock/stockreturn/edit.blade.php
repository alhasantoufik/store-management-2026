@extends('backend.app')
@section('title', 'Edit Stock Return')
@section('page-content')

<div class="container-fluid mt-4">
    <form action="{{ route('stockReturn.update', $voucher_no) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                <h4 class="mb-0 text-primary">Edit Stock Return - <span class="text-dark">#{{ $voucher_no }}</span></h4>
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar-alt text-muted"></i></span>
                    <input type="date" name="in_date" class="form-control border-start-0"
                        value="{{ old('in_date', date('Y-m-d', strtotime($returns->first()->in_date))) }}">
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-2 d-none d-md-flex fw-bold text-muted">
                    <div class="col-md-5">Product Name</div>
                    <div class="col-md-2">Quantity</div>
                    <div class="col-md-3">Unit Price</div>
                    <div class="col-md-2">Total (Preview)</div>
                </div>

                @foreach($returns as $index => $return)
                <div class="row mb-3 align-items-end border-bottom pb-3">
                    <div class="col-md-5">
                        <label class="form-label d-md-none">Product</label>
                        <select name="products[{{ $index }}][product_id]" class="form-control select2">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                {{ $product->id == $return->product_id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="products[{{ $index }}][id]" value="{{ $return->id }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label d-md-none">Quantity</label>
                        <input type="number" name="products[{{ $index }}][quantity]" class="form-control qty-input"
                            min="1" value="{{ old('products.'.$index.'.quantity', $return->quantity) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label d-md-none">Unit Price</label>
                        <div class="input-group">
                            <span class="input-group-text">Tk.</span>
                            <input type="number" name="products[{{ $index }}][price]" class="form-control price-input" step="0.01"
                                value="{{ old('products.'.$index.'.price', abs($return->total_price / $return->quantity)) }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label d-md-none">Total</label>
                        <input type="text" class="form-control bg-light row-total" readonly value="{{ abs($return->total_price) }}">
                    </div>
                </div>
                @endforeach

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <hr>
                        <a href="{{ route('stockReturn.all') }}" class="btn btn-outline-secondary btn-lg px-4 me-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-warning btn-lg px-5 shadow-sm fw-bold">
                            <i class="fas fa-save me-1"></i> Update Stock Return
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        // Simple calculation script to show row total
        function calculateRowTotal(row) {
            let qty = parseFloat(row.find('.qty-input').val()) || 0;
            let price = parseFloat(row.find('.price-input').val()) || 0;
            let total = qty * price;
            row.find('.row-total').val(total.toFixed(2));
        }

        $(document).on('input', '.qty-input, .price-input', function() {
            calculateRowTotal($(this).closest('.row'));
        });
    });
</script>

<style>
    .card {
        border-radius: 10px;
        border: none;
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
        border-bottom: 1px solid #eee;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #ffc107;
    }

    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 0.375rem;
    }
</style>
@endpush