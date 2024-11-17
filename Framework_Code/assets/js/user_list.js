$(document).ready(function() {
    let userTable;

    function initializeDataTable(data) {
        if (userTable) {
            userTable.destroy();
        }

        userTable = $('#userTable').DataTable({
            data: data,
            columns: [
                { 
                    data: 'user_id',
                    render: function(data, type, row) {
                        return `<a href="user_details.php?id=${data}">${data}</a>`;
                    }
                },
                { data: 'username' },
                { data: 'email' },
                { data: 'role_name' },
                { 
                    data: 'is_active',
                    render: function(data) {
                        return data ? 'Active' : 'Inactive';
                    }
                },
                { data: 'last_login' }
            ],
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    }

    function loadUsers(activeOnly = true) {
        $.ajax({
            url: 'api/users_get.php',
            method: 'GET',
            data: { active_only: activeOnly },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    initializeDataTable(response.data);
                } else {
                    showError('Failed to load users: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                showError('Failed to load users: ' + error);
            }
        });
    }

    $('#activeUsersOnly').on('change', function() {
        loadUsers(this.checked);
    });

    // Helper function for error messages
    function showError(message) {
        // Implement error notification (e.g., toast)
        console.error('Error:', message);
    }

    // Initial load
    loadUsers();
});