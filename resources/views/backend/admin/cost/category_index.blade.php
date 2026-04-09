@extends('backend.app')
@section('title','Expense Category')
@section('page-content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-dark m-0">Expense Categories</h4>

        <button class="btn btn-info px-3 shadow-sm" onclick="addCategory()">
            <i class="fas fa-plus-circle me-1"></i> Add Category
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr id="row-{{ $category->id }}">
                    <td>{{ $loop->iteration }}</td> <!-- Serial number -->
                    <td>{{ $category->name }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editCategory({{ $category->id }})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteCategory({{ $category->id }})">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="categoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="category_id">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addCategory() {
        $('#category_id').val('');
        $('#name').val('');
        $('#categoryModal .modal-title').text('Add Category');
        $('#categoryModal').modal('show');
    }

    $('#categoryForm').submit(function(e) {
        e.preventDefault();
        let id = $('#category_id').val();
        let name = $('#name').val();
        let url = id ?
            "{{ route('cost.category.update', ['id' => ':id']) }}".replace(':id', id) :
            "{{ route('cost.category.store') }}";

        $.post(url, {
            _token: "{{ csrf_token() }}",
            name: name
        }, function(res) {
            location.reload();
        });
    });

    function editCategory(id) {
        let url = "{{ route('cost.category.edit', ['id' => ':id']) }}".replace(':id', id);
        $.get(url, function(res) {
            $('#category_id').val(res.id);
            $('#name').val(res.name);
            $('#categoryModal .modal-title').text('Edit Category');
            $('#categoryModal').modal('show');
        });
    }

   function deleteCategory(id) {

    let url = "{{ route('cost.category.delete', ['id' => ':id']) }}".replace(':id', id);

    Swal.fire({
        title: 'Are you sure?',
        text: "This category will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {

                    // row remove with animation
                    $('#row-' + id).fadeOut(400, function() {
                        $(this).remove();
                    });

                    Swal.fire(
                        'Deleted!',
                        'Category has been deleted.',
                        'success'
                    );
                },
                error: function() {

                    Swal.fire(
                        'Error!',
                        'Something went wrong!',
                        'error'
                    );
                }
            });
        }
    });
}
</script>
@endpush