$(document).ready(function() {
    const userId = $('#userId').val();
    const isEditMode = !userId;
    const form = $('#userForm');
    const editBtn = $('#editBtn');
    const deactivateBtn = $('#deactivateBtn');
    const formButtons = $('#formButtons');

function loadRoles() {
    $.ajax({
        url: 'api/roles_get.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            const roleSelect = $('#roleId');
            roleSelect.empty();

            // Check if the response contains the success key
            if (response.success !== undefined) {
                if (response.success) {
                    response.data.forEach(role => {
                        roleSelect.append(`<option value="${role.role_id}">${role.role_name}</option>`);
                    });
                    if (userId) loadUserDetails();
                } else {
                    showError('Failed to load roles 1: ' + response.error);
                }
            } else {
                // Handle the second type of response
                response.forEach(role => {
                    roleSelect.append(`<option value="${role.role_id}">${role.role_name}</option>`);
                });
                if (userId) loadUserDetails();
            }
        },
        error: function(xhr, status, error) {
            showError('Failed to load roles 2: ' + error);
        }
    });
}


    function loadUserDetails() {
        $.ajax({
            url: 'api/users_get.php',
            method: 'GET',
            data: { user_id: userId },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    const user = response.data[0];
                    $('#email').val(user.email);
                    $('#username').val(user.username);
                    $('#roleId').val(user.role_id);
                    $('#isActive').val(user.is_active ? 'Active' : 'Inactive');
                    $('#lastLogin').val(user.last_login);
                    setReadOnly(true);
                } else {
                    showError('Failed to load user details: ' + (response.error || 'User not found'));
                }
            },
            error: function(xhr, status, error) {
                showError('Failed to load user details: ' + error);
            }
        });
    }

    function setReadOnly(readonly) {
        $('#username, #roleId').prop('readonly', readonly);
        if (readonly) {
            formButtons.addClass('d-none');
            editBtn.removeClass('d-none');
            deactivateBtn.removeClass('d-none');
        } else {
            formButtons.removeClass('d-none');
            editBtn.addClass('d-none');
            deactivateBtn.addClass('d-none');
        }
    }

    editBtn.on('click', function() {
        setReadOnly(false);
    });

    deactivateBtn.on('click', function() {
        if (confirm('Are you sure you want to deactivate this user?')) {
            $.ajax({
                url: 'api/users_toggle_active.php',
                method: 'POST',
                data: { user_id: userId, is_active: false },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showSuccess('User deactivated successfully');
                        loadUserDetails();
                    } else {
                        showError('Failed to deactivate user: ' + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    showError('Failed to deactivate user: ' + error);
                }
            });
        }
    });

    form.on('submit', function(e) {
        e.preventDefault();
        const formData = {
            user_id: userId,
            email: $('#email').val(),
            username: $('#username').val(),
            role_id: $('#roleId').val()
        };

        $.ajax({
            url: isEditMode ? 'api/users_add.php' : 'api/users_update.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showSuccess(isEditMode ? 'User added successfully' : 'User updated successfully');
                    if (isEditMode) {
                        window.location.href = 'user_list.php';
                    } else {
                        loadUserDetails();
                    }
                } else {
                    showError(`Failed to ${isEditMode ? 'add' : 'update'} user: ` + response.error);
                }
            },
            error: function(xhr, status, error) {
                showError(`Failed to ${isEditMode ? 'add' : 'update'} user: ` + error);
            }
        });
    });

    $('#cancelBtn').on('click', function() {
        if (isEditMode) {
            window.location.href = 'user_list.php';
        } else {
            loadUserDetails();
        }
    });



    // Initialize
    if (isEditMode) {
        setReadOnly(false);
    }
    loadRoles();
});