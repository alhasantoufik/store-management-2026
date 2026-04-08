@extends('backend.app')
@section('title','Stock History')

@section('page-content')

<div class="container">

    <h3>Stock Ledger</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Type</th>
                <th>Previous</th>
                <th>Qty</th>
                <th>Current</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            @foreach($transactions as $key => $t)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $t->product->name }}</td>
                    <td>
                        @if($t->type == 'in')
                            <span class="badge bg-success">IN</span>
                        @else
                            <span class="badge bg-danger">OUT</span>
                        @endif
                    </td>
                    <td>{{ $t->previous_stock }}</td>
                    <td>{{ $t->quantity }}</td>
                    <td>{{ $t->current_stock }}</td>
                    <td>{{ $t->created_at }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

</div>

@endsection