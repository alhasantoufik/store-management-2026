@extends('backend.app')
@section('page-content')

<div class="container-fluid">
    <div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <!-- Title Left -->
        <h5 class="mb-0 fw-bold text-secondary">Brand Management</h5>
        
        <!-- Add Button Right (Optional, but usually better on the right) 
             If you want it strictly on the left under the title, 
             we can adjust the layout. -->
        <button class="btn btn-primary btn-sm px-4" data-bs-toggle="modal" data-bs-target="#brandModal">
            <i class="fas fa-plus-circle me-1"></i> Add Brand
        </button>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 80px;">#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody id="brandTable">
                    @foreach($brands as $key => $brand)
                    <tr>
                        <td class="ps-3 fw-medium text-muted">{{ $key + 1 }}</td>
                        <td class="fw-bold">{{ $brand->name }}</td>
                        <td>
                            @if($brand->image)
                                <img src="{{ asset($brand->image) }}" 
                                     class="rounded border" 
                                     style="width: 45px; height: 45px; object-fit: cover;">
                            @else
                                <span class="badge bg-light text-dark border">No Image</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <div class="btn-group">
                                <button class="btn btn-outline-warning btn-sm editBtn" data-id="{{ $brand->id }}">
                                    Edit
                                </button>
                                <button class="btn btn-outline-danger btn-sm deleteBtn" data-id="{{ $brand->id }}">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- Modal -->
    <div class="modal fade" id="brandModal">
        <div class="modal-dialog">
            <form id="brandForm">
                @csrf
                <input type="hidden" id="brand_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Brand</h5>
                    </div>

                    <div class="modal-body">
                        <input type="text" name="name" id="name" class="form-control mb-2" placeholder="Name">

                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // =========================
        // CREATE / UPDATE
        // =========================
        $('#brandForm').on('submit', function(e) {
            e.preventDefault();

            let id = $('#brand_id').val();

            let url = id ?
                "{{ route('brands.update', ':id') }}".replace(':id', id) :
                "{{ route('brands.store') }}";

            let formData = new FormData(this);

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {

                    location.reload();
                },
                error: function(err) {
                    console.log(err.responseText);
                    alert('Error!');
                }
            });
        });

        // =========================
        // EDIT
        // =========================
        $(document).on('click', '.editBtn', function() {

            let id = $(this).data('id');

            $('#brandForm')[0].reset();
            $('#brand_id').val('');

            let url = "{{ route('brands.edit', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {

                    $('#name').val(data.name);
                    $('#brand_id').val(data.id);

                    // Bootstrap 5 modal
                    let modal = new bootstrap.Modal(document.getElementById('brandModal'));
                    modal.show();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        // =========================
        // DELETE
        // =========================
        $(document).on('click', '.deleteBtn', function() {

            if (confirm('Are you sure?')) {

                let id = $(this).data('id');

                let url = "{{ route('brands.delete', ':id') }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: "DELETE",
                    success: function() {

                        location.reload();
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
        });

    });
</script>
@endpush