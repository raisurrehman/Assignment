@extends('admin.layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Roles & Permissions</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRoleModal">
                            Add Role
                        </button>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add-role-form" method="POST" action="{{ route('roles.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control" name="name" autofocus>
                                <span class="text-danger" id="error" style="display:none">required *</span>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Modal -->
        <div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-role-form" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="role_id" id="edit-role-id">
                            <div class="form-group">
                                <label for="edit-name">Name</label>
                                <input id="edit-name" type="text" class="form-control" name="name" autofocus>
                                <span class="text-danger" id="error-edit" style="display:none">required *</span>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered" id="roles-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
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
        var dataTable = $('#roles-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('roles') }}",
            columns: [
                { name: 'id', data: 'id' },
                { name: 'name', data: 'name' },
                { name: 'action', data: 'action', orderable: false, searchable: false }
            ],
        });

        // Add Role Form Submission
        $('#add-role-form').on('submit', function (event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '{{ route("roles.store") }}',
                type: 'POST',
                data: formData,
                success: function (response) {
                    toastr.success('Role created successfully.');
                    dataTable.ajax.reload();
                    $('#addRoleModal').modal('hide');
                },
                error: function (xhr, status, error) {
                    $('#error').show();
                }
            });
        });

        // Edit Role Button Click
        $(document).on('click', '.edit-role-btn', function () {
            var roleId = $(this).data('id');
            $.ajax({
                url: '/roles/' + roleId + '/edit',
                type: 'GET',
                success: function (response) {
                    $('#edit-role-id').val(roleId);
                    $('#edit-name').val(response.name);
                    $('#editRoleModal').modal('show');
                }
            });
        });

        // Update Role Form Submission
        $('#edit-role-form').on('submit', function (event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var roleId = $('#edit-role-id').val();
            $.ajax({
                url: '/roles/' + roleId,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    toastr.success('Role updated successfully.');
                    dataTable.ajax.reload();
                    $('#editRoleModal').modal('hide');
                },
                error: function (xhr, status, error) {
                    $('#error-edit').show();
                }
            });
        });
    });
</script>
@endpush
