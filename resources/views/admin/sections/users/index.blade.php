@extends('admin.layouts.master')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="modal fade" id="assign-role">
    <div class="modal-dialog">
        <form id="edit-category-form" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="category_id" id="edit-category-id">
                    <div class="form-group">
                        <label for="edit-name">
                            Name</label>
                        <input id="edit-name" type="text" class="form-control" name="name" autofocus>
                        <span class="text-danger" id="name-error-edit"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit-description">Description</label>
                        <textarea id="edit-description" class="form-control" name="description" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <!-- Corrected class -->
                </div>
            </div>
        </form>
    </div>
</div>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card" id="list-users-page">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title">Users</h3>
                            </div>
                            <div class="col-auto">
                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addCategoryModal">
                                    Add Users
                                </button> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="user-table" class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>email</th>
                                <th>Action</th>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>email</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card" id="assign-role-page">
                </div>
            </div>
        </div>
    </section>
</section>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var dataTable = $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users') }}",
            columns: [
                { name: 'id', data: 'id' },
                { name: 'name', data: 'name' },
                { email: 'email', data: 'email' },
                { name: 'action', data: 'action', orderable: false, searchable: false }
            ],
        });
    });

    $(document).on('click', '.assign-role', function (e) {
        e.preventDefault();
        var userId = $(this).data('id');

        $.ajax({
            url: '/users/' + userId + '/assign-role',
            type: 'GET',
            success: function (response) {
                $('#list-users-page').hide();
                $('#assign-role-page').html(response).show();
                $('.select2').select2();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while loading the edit page');
            }
        });
    });

</script>
@endpush