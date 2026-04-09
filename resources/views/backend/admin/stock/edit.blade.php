@extends('backend.app')
@section('title', 'Edit Stock Transaction')

@section('page-content')

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="mb-0">Edit Stock Transaction</h4>
        </div>

        <div class="card-body">

            {{-- Alert --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('stock.update', $transaction->id) }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Product --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Product</label>
                        <select name="product_id" class="form-control select2" required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                    {{ $transaction->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Type (readonly) --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Type</label>
                        <input type="text" class="form-control" 
                               value="{{ ucfirst($transaction->type) }}" readonly>
                    </div>

                    {{-- Quantity --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" 
                               name="quantity" 
                               value="{{ $transaction->quantity }}" 
                               class="form-control" 
                               min="1" required>
                    </div>

                    {{-- Voucher --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Voucher No</label>
                        <input type="text" class="form-control" 
                               value="{{ $transaction->voucher_no }}" readonly>
                    </div>

                    {{-- Previous Stock --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Previous Stock</label>
                        <input type="text" class="form-control" 
                               value="{{ $transaction->previous_stock }}" readonly>
                    </div>

                    {{-- Current Stock --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Current Stock</label>
                        <input type="text" class="form-control" 
                               value="{{ $transaction->current_stock }}" readonly>
                    </div>

                    {{-- Date --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" 
                               name="transaction_date"
                               value="{{ \Carbon\Carbon::parse($transaction->in_date)->format('Y-m-d') }}" 
                               class="form-control">
                    </div>

                    {{-- Note --}}
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Note</label>
                        <input type="text" 
                               name="note" 
                               value="{{ $transaction->note }}" 
                               class="form-control">
                    </div>

                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('stock.report') }}" class="btn btn-secondary me-2">
                        Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Product",
            allowClear: true
        });
    });
</script>
@endpush