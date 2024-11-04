</div>


<div id="addUserModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('', array('id' => 'addUserForm')); ?>
                <div class="modal-header">                        
                    <h4 class="modal-title">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                        <div class="error text-danger" id="name_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                        <div class="error text-danger" id="email_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                        <div class="error text-danger" id="password_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" required>
                        <div class="error text-danger" id="confirm_password_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" required>
                        <div class="error text-danger" id="phone_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" name="address" rows="3" required></textarea>
                        <div class="error text-danger" id="address_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-success" value="Add">
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div id="editUserModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('', array('id' => 'editUserForm')); ?>
                <div class="modal-header">                        
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="enc_id" id="edit_user_id"> <!-- Hidden field for user ID -->
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                        <div class="error text-danger" id="edit_name_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="edit_email" required>
                        <div class="error text-danger" id="edit_email_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" id="edit_password">
                        <div class="error text-danger" id="edit_password_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" id="edit_confirm_password">
                        <div class="error text-danger" id="edit_confirm_password_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" id="edit_phone" required>
                        <div class="error text-danger" id="edit_phone_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" name="address" id="edit_address" rows="3" required></textarea>
                        <div class="error text-danger" id="edit_address_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-success" value="Update">
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Delete Modal HTML -->
<div id="deleteUserModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('', array('id' => 'deleteUserForm')); ?>
                <input type="hidden" name="delete_ids" id="delete_ids">
                <div class="modal-header">                        
                    <h4 class="modal-title">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">                    
                    <p>Are you sure you want to delete these Records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" value="Delete">
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<!-- Include csrf.js -->
<script src="<?php echo base_url('assets/js/csrf.js'); ?>"></script>

<script>
var refreshCsrfUrl = "<?php echo base_url('refresh_csrf'); ?>";

$('#selectAll').prop('checked', false);

function showAlert(message, alertType = 'success', duration = 4000) {
    var alertDiv = $('#alertMessage');
    var alertText = $('#alertText');

    alertDiv.removeClass('alert-success alert-danger alert-warning alert-info');
    alertDiv.addClass('alert-' + alertType);
    alertText.text(message);

    alertDiv.fadeIn();

    setTimeout(function() {
        alertDiv.fadeOut();
    }, duration);
}



$(document).ready(function() {
    // Initialize DataTables
    var dataTable = $('.table').DataTable({
        "paging": true,
        "searching": true,
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'users_list'; ?>", 
            type: "POST",
            data: {
                
            }
        },
        "columnDefs": [
            {
                "targets": [0,5],
                "orderable": false
            }
        ]
    });

    // Event delegation for checkboxes
    $(document).on('click', '#selectAll', function() {
        var checkboxes = $('table tbody input[type="checkbox"]');
        checkboxes.prop('checked', this.checked);
    });

    $(document).on('click', 'table tbody input[type="checkbox"]', function() {
        if (!this.checked) {
            $('#selectAll').prop('checked', false);
        }
    });
});


$(document).ready(function() {
    $('#addUserForm').on('submit', function(event) {
        event.preventDefault();
        
        // Clear previous errors
        $('.error').html('');

        $.ajax({
            url: "<?php echo base_url('add'); ?>",
            method: "POST",
            data: $(this).serialize(), // CSRF token is already included in the form
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    // Display validation errors
                    $.each(data.error, function(key, value) {
                        $('#' + key).html(value); // Use correct ID selectors
                    });

                     // Refresh the CSRF token again in case of errors
                    $.get("<?php echo base_url('refresh_csrf'); ?>", function(data) {
                        var csrfData = JSON.parse(data);
                        $('input[name="' + csrfData.csrf_token_name + '"]').val(csrfData.csrf_hash);
                    });
                    refreshCsrfToken();
                } else {
                    // Handle success
                    if(data.success){
                        showAlert(data.message, 'success');
                    }else{
                        showAlert(data.message, 'danger');
                    }
                    
                    //$('#addUserModal').modal('hide');
                    $('#addUserForm')[0].reset();
                    $('#addUserModal').modal('hide');
                    $('.table').DataTable().ajax.reload();
                    refreshCsrfToken();
                }
            }
        });
    });


});



$(document).ready(function() {
    // Handle edit button click
    $(document).on('click', '.edit', function() {
        var encryptedId = $(this).data('enc_id');

        var csrfName = $('meta[name="csrf-token-name"]').attr('content');
        var csrfHash = $('meta[name="csrf-token-hash"]').attr('content');
        
        $.ajax({
            url: "<?php echo base_url('get_user'); ?>",
            method: "POST",
            data: {
                id: encryptedId,
                [csrfName]: csrfHash
            },
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    $('#editUserForm #edit_name').val(data.user.name);
                    $('#editUserForm #edit_email').val(data.user.email);
                    $('#editUserForm #edit_phone').val(data.user.phone);
                    $('#editUserForm #edit_address').val(data.user.address);
                    $('#editUserForm #edit_user_id').val(encryptedId);

                    $('#editUserModal').modal('show');
                    refreshCsrfToken();
                } else {
                    showAlert(data.message, 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                showAlert('An error occurred while fetching the user data.', 'danger');
            }
        });
    });
});

 $(document).ready(function() {
    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();

        // Clear previous errors
        $('.error').html('');

        var csrfName = $('meta[name="csrf-token-name"]').attr('content');
        var csrfHash = $('meta[name="csrf-token-hash"]').attr('content');
        
        var formData = $(this).serializeArray();
        formData.push({ name: csrfName, value: csrfHash });

        $.ajax({
            url: "<?php echo base_url('edit'); ?>",
            method: "POST",
            data: $.param(formData),
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    $.each(data.error, function(key, value) {
                        $('#' + key).html(value);
                    });
                    refreshCsrfToken();
                } else {
                    if(data.success){
                        showAlert(data.message, 'success');
                    }else{
                        showAlert(data.message, 'danger');
                    }
                    
                    $('#editUserModal').modal('hide');
                    $('#editUserForm')[0].reset();
                    $('.table').DataTable().ajax.reload();
                    refreshCsrfToken();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                showAlert('An error occurred while updating the user.', 'danger');
            }
        });
    });
});


$(document).ready(function() {
    // Handle delete button click for individual user
    $(document).on('click', '.delete', function() {
        var encryptedId = $(this).data('enc_id');
        $('#delete_ids').val(encryptedId); // Store single ID
        $('#deleteUserModal').modal('show');
    });

    // Handle delete button click in the modal for multiple users
    $(document).on('click', '.delete_selected', function() {
        var selectedIds = [];
        $('input[name="options[]"]:checked').each(function() {
            selectedIds.push($(this).val());
        });
        $('#delete_ids').val(selectedIds.join(',')); // Store multiple IDs as comma-separated string
        $('#deleteUserModal').modal('show');
    });

    // Handle delete form submission
    $('#deleteUserForm').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: "<?php echo base_url('delete'); ?>",
            method: "POST",
            data: $(this).serialize(), // CSRF token is already included in the form
            dataType: "json",
            success: function(data) {
               
                showAlert(data.message, data.success ? 'success' : 'danger');
                
                $('#deleteUserModal').modal('hide');
                $('.table').DataTable().ajax.reload();
                $('#selectAll').prop('checked', false);
                refreshCsrfToken();
               
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                showAlert('An error occurred while deleting the user data.', 'danger');
            }
        });
    });
});


</script>
</body>
</html>

