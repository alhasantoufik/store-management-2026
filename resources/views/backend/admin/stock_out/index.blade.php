@extends('backend.app')
@section('title', 'Stock Out')

@section('page-content')

<div class="container">
    <button class="btn btn-danger mb-3" id="addBtn">Stock Out</button>

    <table class="table table-bordered" id="stockTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $key => $stock)
            <tr id="row-{{ $stock->id }}">
                <td>{{ $key+1 }}</td>
                <td>{{ $stock->product->name }}</td>
                <td>{{ $stock->quantity }}</td>
                <td>{{ $stock->created_at }}</td>
                <td>
                    <button class="btn btn-sm btn-warning editBtn" data-id="{{ $stock->id }}">Edit</button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $stock->id }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal --}}
<div class="modal fade" id="stockModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="stockForm">
                @csrf
                <input type="hidden" id="id">

                <div class="modal-body">

                    <select name="product_id" id="product_id" class="form-control">
                        <option value="">Select Product</option>
                        @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>

                    <p class="mt-2">Current Stock: <span id="current_stock">0</span></p>

                    <input type="number" name="quantity" id="quantity" class="form-control mt-2" placeholder="Quantity">

                    <textarea name="note" id="note" class="form-control mt-2" placeholder="Note"></textarea>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        // open modal
        $('#addBtn').click(function() {
            $('#stockForm')[0].reset();
            $('#id').val('');
            $('#stockModal').modal('show');
        });

        // get stock
        $('#product_id').change(function() {
            let id = $(this).val();

            if (!id) {
                $('#current_stock').text(0);
                return;
            }

            $.ajax({
                url: '/admin/product-stock/' + id,
                type: 'GET',
                success: function(res) {
                    $('#current_stock').text(res.current_stock);
                },
                error: function() {
                    $('#current_stock').text(0);
                }
            });
        });

        // store/update
        $('#stockForm').submit(function(e) {
            e.preventDefault();

            let id = $('#id').val();
            let url = id ? '/admin/stock-out/update/' + id : '/admin/stock-out/store';

            $.ajax({
                url: url,
                method: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    location.reload();
                }
            });
        });

        // edit
        $('.editBtn').click(function() {
            let id = $(this).data('id');

            $.get('/admin/stock-out/edit/' + id, function(data) {
                $('#id').val(data.id);
                $('#quantity').val(data.quantity);
                $('#note').val(data.note);
                $('#stockModal').modal('show');
            });
        });

        // delete
        $('.deleteBtn').click(function() {
            let id = $(this).data('id');

            if (confirm('Are you sure?')) {
                $.ajax({
                    url: '/admin/stock-out/delete/' + id,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        $('#row-' + id).remove();
                    }
                });
            }
        });

    });
</script>
@endpush