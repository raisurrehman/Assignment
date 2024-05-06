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
                    <li class="breadcrumb-item active">users</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <table class="table table-bordered" id="user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>email</th>
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
