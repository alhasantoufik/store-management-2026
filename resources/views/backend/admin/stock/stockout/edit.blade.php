@extends('backend.app')
@section('title', 'Edit Stock Out')
@section('page-content')

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Voucher - <span class="text-danger">{{ $voucher_no }}</span></h5>
                    <a href="{{ route('stock.out.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('stock.out.update', $voucher_no) }}" method="POST">
                        @csrf
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">SL</th>
                                        <th>Product Name</th>
                                        <th width="150">Quantity</th>
                                        <th width="180">Unit Price</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stocks as $key => $stock)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <input type="hidden" name="stocks[{{ $loop->index }}][id]" value="{{ $stock->id }}">
                                            <strong>{{ $stock->product->name ?? 'N/A' }}</strong>
                                        </td>
                                        <td>
                                            <input type="number" name="stocks[{{ $loop->index }}][quantity]" 
                                                   class="form-control" value="{{ $stock->quantity }}" 
                                                   min="1" required>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Tk.</span>
                                                <input type="number" step="0.01" name="stocks[{{ $loop->index }}][price]" 
                                                       class="form-control" value="{{ $stock->quantity > 0 ? $stock->total_price / $stock->quantity : 0 }}" 
                                                       required>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="stocks[{{ $loop->index }}][note]" 
                                                   class="form-control" value="{{ $stock->note }}" 
                                                   placeholder="Optional note...">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 border-top pt-3 text-end">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Update Voucher
                            </button>
                            <a href="{{ route('stock.out.index') }}" class="btn btn-light px-4 border">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection