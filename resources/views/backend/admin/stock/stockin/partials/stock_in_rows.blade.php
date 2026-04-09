@foreach($stockIns as $key => $stock)
<tr id="row-{{ $stock->voucher_no }}">
    <td>{{ $key + 1 }}</td>
    <td><strong>{{ $stock->voucher_no }}</strong></td>
    <td>{{ $stock->total_quantity }}</td>
    <td>{{ number_format($stock->total_price, 2) }}</td>
    <td>{{ \Carbon\Carbon::parse($stock->in_date)->format('d M, Y') }}</td>
    <td class="text-center">
        <a href="{{ route('stock.in.edit', $stock->voucher_no) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <button class="btn btn-sm btn-danger" onclick="deleteStock('{{ $stock->voucher_no }}')">
            <i class="fas fa-trash"></i> Delete
        </button>
    </td>
</tr>
@endforeach