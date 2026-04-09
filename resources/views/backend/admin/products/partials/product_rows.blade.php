@foreach($products as $product)
<tr id="product-{{ $product->id }}">
    <td class="text-center text-muted">{{ $loop->iteration }}</td>

      <td>{{ $product->product_code ?? 'N/A' }}</td> {{-- ✅ add here --}}

    <td class="text-center">
        @if($product->image)
            <img src="{{ asset($product->image) }}" alt="Product Image" width="50" height="50">
        @else
            N/A
        @endif
    </td>

  

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