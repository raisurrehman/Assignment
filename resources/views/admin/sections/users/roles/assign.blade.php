<div class="card-header">
    <div class="row">
        <div class="col">
            <h3 class="card-title">Assign Role</h3>
        </div>
    </div>
</div>
<div class="card-body">
    <form method="post" id="assign-role-form" action="{{ route('users.assign-role', ['userId' => $user->id]) }}">
        @csrf
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="role">Select Role</label>
                <select class="select2" multiple="multiple" data-placeholder="Select Roles" name="roles[]"
                    style="width: 100%;">
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->roles->contains('id', $role->id) ?
                        'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary">Assign Role</button>
            </div>
        </div>
    </form>
</div>

<script>
    $('#assign-role-form').submit(function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#list-users-page').show();
                $('#assign-role-page').hide();

                toastr.success('Role updated successfully.');

                if ($.fn.DataTable.isDataTable('#user-table')) {
                    $('#user-table').DataTable().ajax.reload();
                } else {
                    $('#user-table').DataTable({
                    });
                }
            },
            error: function (xhr, status, error) {
                var errors = JSON.parse(xhr.responseText).errors;
            }
        });
    });
</script>