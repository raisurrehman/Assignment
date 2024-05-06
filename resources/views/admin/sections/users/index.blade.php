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
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
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
</script>
@endpush