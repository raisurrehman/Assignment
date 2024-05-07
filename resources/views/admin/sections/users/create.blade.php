<div class="card-header">
    <div class="row">
        <div class="col">
            <h3 class="card-title">Add New User</h3>
        </div>
    </div>
</div>
<div class="card-body">
    <form id="create-user-form" method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-2 form-group">
                <label for="name">Name</label>
            </div>
            <div class="col-md-10 form-group">
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Name..." class="form-control">
                <span class="text-danger" id="name-error"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 form-group">
                <label for="email">Email</label>
            </div>
            <div class="col-md-10 form-group">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email..." class="form-control">
                <span class="text-danger" id="email-error"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 form-group">
                <label for="password">Password</label>
            </div>
            <div class="col-md-10 form-group">
                <input type="password" name="password" placeholder="Password..." class="form-control">
                <span class="text-danger" id="password-error"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 form-group">
                <label for="password_confirmation">Confirm Password</label>
            </div>
            <div class="col-md-10 form-group">
                <input type="password" name="password_confirmation" placeholder="Confirm Password..."
                    class="form-control">
                <span class="text-danger" id="password_confirmation-error"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 form-group">
                <label for="description">Description</label>
            </div>
            <div class="col-md-10 form-group">
                <textarea name="description" placeholder="Description..." class="form-control" cols="30"
                    rows="5">{{ old('description') }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 form-group">
                <label for="active">Active</label>
            </div>
            <div class="col-md-10">
                <input type="checkbox" name="active" data-bootstrap-switch data-off-color="danger"
                    data-on-color="primary" data-size="small" data-on-text="Yes" data-off-text="No" value="1">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group text-right">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>

<script>
    $('#create-user-form').submit(function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);

        // Password validation
        var password = $('input[name="password"]').val();
        var confirmPassword = $('input[name="password_confirmation"]').val();
        if (password !== confirmPassword) {
            $('#password_confirmation-error').text('Passwords do not match');
            return;
        }

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                toastr.success('User created successfully.');
                $('#create-user-form')[0].reset();
            },
            error: function (xhr, status, error) {
                var errors = JSON.parse(xhr.responseText).errors;

                for (var fieldName in errors) {
                    $('#' + fieldName + '-error').text(errors[fieldName][0]);
                }
            }
        });
    });
</script>