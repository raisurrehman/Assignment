@extends('admin.layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Categories</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @can('create-category')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
                        Add Category
                    </button>
                    @endcan
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
            aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add-category-form" method="POST" action="{{ route('categories.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control" name="name" autofocus>
                                <span class="text-danger" id="error" style="display:none">required *</span>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control" name="description" rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- edit Modal -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog"
            aria-labelledby="editCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-category-form" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="category_id" id="edit-category-id">
                            <div class="form-group">
                                <label for="edit-name">
                                    Name</label>
                                <input id="edit-name" type="text" class="form-control" name="name" autofocus>
                                <span class="text-danger" id="error-edit" style="display:none">required *</span>
                            </div>
                            <div class="form-group">
                                <label for="edit-description">Description</label>
                                <textarea id="edit-description" class="form-control" name="description"
                                    rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this category?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered" id="categories-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>
</section>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var dataTable = $('#categories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('categories') }}",
            columns: [
                { name: 'id', data: 'id' },
                { name: 'name', data: 'name' },
                { name: 'description', data: 'description' },
                { name: 'action', data: 'action', orderable: false, searchable: false }
            ],
        });
        $('#add-category-form').on('submit', function (event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '{{ route("categories.store") }}',
                type: 'POST',
                data: formData,
                success: function (response) {
                    toastr.success('Category created successfully.');
                    dataTable.ajax.reload();
                    $('#add-category-form')[0].reset();
                    $('#addCategoryModal').modal('hide');
                },
                error: function (xhr, status, error) {
                    $('#error').show();
                }
            });
        });

        $(document).on('click', '.edit-category-btn', function () {
            var categoryId = $(this).data('id');
            $.ajax({
                url: '/categories/' + categoryId + '/edit',
                type: 'GET',
                success: function (response) {
                    $('#edit-category-form input[name="name"]').val(response.name);
                    $('#edit-category-form textarea[name="description"]').val(response.description);
                    $('#edit-category-id').val(categoryId);
                    $('#editCategoryModal').modal('show');
                }
            });
        });

        $('#edit-category-form').on('submit', function (event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var categoryId = $('#edit-category-id').val();
            $.ajax({
                url: '/categories/' + categoryId,
                type: 'PUT',
                data: formData,
                success: function (response) {

                    toastr.success('Category updated successfully.');
                    dataTable.ajax.reload();
                    $('#editCategoryModal').modal('hide');

                },
                error: function (xhr, status, error) {

                    $('#error-edit').show();
                }
            });
        });


        $(document).on('click', '.delete-category-btn', function () {
            var categoryId = $(this).attr('id').replace('delete-category-btn-', '');
            $('#confirmationModal').modal('show');

            $('#confirmDeleteBtn').data('category-id', categoryId);
        });

        $(document).on('click', '#confirmDeleteBtn', function () {
            var categoryId = $(this).data('category-id');

            $.ajax({
                url: '/categories/' + categoryId,
                type: 'DELETE',
                success: function (response) {
                    dataTable.ajax.reload();

                    toastr.success('Category deleted successfully.');
                },
                error: function (xhr, status, error) {

                    var errorMessage = xhr.responseJSON.error || 'Error deleting category';
                    toastr.error(errorMessage);
                }
            });
            $('#confirmationModal').modal('hide');
        });


    });


</script>
@endpush