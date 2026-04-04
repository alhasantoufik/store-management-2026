@extends('backend.app')
@section('title','Stock Management')
@section('page-content')

<div class="container">
    <button class="btn btn-primary mb-3" id="addStockBtn">Add Stock</button>

    <table class="table table-bordered" id="stockTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                   <th>Current Stock</th>
                <th>Quantity</th>
                <th>Stock Type</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr id="stock-{{ $stock->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $stock->product->name }}</td>
                 <td>{{ $currentStocks[$stock->product_id] ?? 0 }}</td>
                <td>{{ $stock->quantity }}</td>
                <td>
                    <span class="badge {{ $stock->stock_type=='in'?'bg-success':'bg-danger' }}">
                        {{ strtoupper($stock->stock_type) }}
                    </span>
                </td>
                <td>{{ $stock->note }}</td>
                <td>
                    <button class="btn btn-sm btn-warning editStockBtn" data-id="{{ $stock->id }}">Edit</button>
                    <button class="btn btn-sm btn-info historyBtn" data-id="{{ $stock->product_id }}">History</button>
                    <button class="btn btn-sm btn-danger deleteStockBtn" data-id="{{ $stock->id }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="stockModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="stockForm">
            @csrf
            <input type="hidden" id="stock_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Stock Adjustment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Product</label>
                        <select name="product_id" id="product_id" class="form-control" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Stock Type</label>
                        <select name="stock_type" id="stock_type" class="form-control" required>
                            <option value="in">Stock In</option>
                            <option value="out">Stock Out</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    </div>

                    <div class="mb-2">
                        <label>Note</label>
                        <textarea name="note" id="note" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Stock History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Note</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="historyData"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function(){

    $.ajaxSetup({
        headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Add / Edit Open Modal
    $('#addStockBtn').click(function(){
        $('#stockForm')[0].reset();
        $('#stock_id').val('');
        $('#stockModal').modal('show');
    });

    // Submit Add/Edit
    $('#stockForm').submit(function(e){
        e.preventDefault();
        let id = $('#stock_id').val();
        let url = id ? "{{ url('admin/stocks/update') }}/"+id : "{{ route('stocks.store') }}";
        $.ajax({
            url: url,
            method:'POST',
            data:$(this).serialize(),
            success:function(res){
                if(res.errors){
                    alert(Object.values(res.errors)[0][0]);
                }else{
                    location.reload();
                }
            }
        });
    });

    // Edit Button
    $(document).on('click','.editStockBtn',function(){
        let id = $(this).data('id');
        $.get("{{ url('admin/stocks/edit') }}/"+id,function(stock){
            $('#stock_id').val(stock.id);
            $('#product_id').val(stock.product_id);
            $('#stock_type').val(stock.stock_type);
            $('#quantity').val(stock.quantity);
            $('#note').val(stock.note);
            $('#stockModal').modal('show');
        });
    });

    // Delete Button
    $(document).on('click','.deleteStockBtn',function(){
        if(confirm('Are you sure?')){
            let id = $(this).data('id');
            $.ajax({
                url:"{{ url('admin/stocks/destroy') }}/"+id,
                type:'DELETE',
                success:function(){
                    $('#stock-'+id).remove();
                }
            });
        }
    });

    // History
    $(document).on('click','.historyBtn',function(){
        let productId = $(this).data('id');
        $.get("{{ url('admin/inventory/logs') }}/"+productId,function(logs){
            let html = '';
            logs.forEach(l=>{
                html+=`<tr>
                    <td><span class="badge ${l.stock_type=='in'?'bg-success':'bg-danger'}">${l.stock_type.toUpperCase()}</span></td>
                    <td>${l.quantity}</td>
                    <td>${l.note??''}</td>
                    <td>${l.created_at}</td>
                </tr>`;
            });
            $('#historyData').html(html);
            $('#historyModal').modal('show');
        });
    });

});
</script>
@endpush