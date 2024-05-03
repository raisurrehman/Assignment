@extends('admin.layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Products</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        Add Product
                    </a>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="alert alert-success fade in alert-dismissible show" id="alertDiv" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="font-size:20px">×</span>
                </button>
                <div id="message">
                </div>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <table id="products-table" class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Categories</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</section>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var dataTable = $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'price', name: 'price' },
                {
                    data: 'categories',
                    name: 'categories',
                    render: function (data) {
                        var categoriesHtml = '';
                        data.forEach(function (category) {
                            categoriesHtml += '<span class="badge badge-primary">' + category.name + '</span> ';
                        });
                        return categoriesHtml;
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $(document).on('click', '.delete', function () {
            var productId = $(this).data('id');
            $('#confirmationModal').modal('show');

            $('#confirmDeleteBtn').off().one('click', function () {
                $.ajax({
                    url: '/products/' + productId,
                    type: 'DELETE',
                    success: function () {
                        toastr.success('Product deleted successfully.');
                        dataTable.ajax.reload();
                        $('#confirmationModal').modal('hide');
                    },
                    error: function (xhr, status, error) {
                        toastr.error('Error deleting product.');
                        $('#confirmationModal').modal('hide');
                    }
                });
            });
        });
        $('.toastrDefaultError').click(function () {
            toastr.error('This is an error toast message.');
        });
    });


</script>
@endpush