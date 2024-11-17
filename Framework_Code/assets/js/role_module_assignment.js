$(document).ready(function() {
    const roleSelect = $('#roleSelect');
    const moduleAssignmentList = $('#moduleAssignmentList');

    // Load roles
    function loadRoles() {
        $.ajax({
            url: 'api/roles_get.php',
            method: 'GET',
            dataType: 'json',
            success: function(roles) {
                roles.data.forEach(role => {
                    roleSelect.append(`<option value="${role.role_id}">${role.role_name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                showError('Failed to load roles: ' + error);
            }
        });
    }

    // Load module structure
    function loadModuleStructure(roleId) {
        moduleAssignmentList.html('<p>Loading modules...</p>');
        $.ajax({
            url: 'api/role_menu_get_structure.php',
            method: 'GET',
            data: { role_id: roleId },
            dataType: 'json',
            success: function(response) {
                const tree = buildModuleTree(response);
                const html = renderModuleTree(tree, roleId);
                moduleAssignmentList.html(html);
            },
            error: function(xhr, status, error) {
                showError('Failed to load module structure: ' + error);
                moduleAssignmentList.html('<p class="text-danger">Failed to load modules. Please try again later.</p>');
            }
        });
    }

    // Build module tree
    function buildModuleTree(modules, parentId = null) {
        return modules
            .filter(module => module.parent_id == parentId)
            .map(module => ({
                ...module,
                children: buildModuleTree(modules, module.module_id)
            }));
    }

    // Render module tree
    function renderModuleTree(tree, roleId, level = 0) {
        let html = '<ul class="list-group">';
        tree.forEach(module => {
            html += `
                <li class="list-group-item">
                    <div class="form-check">
                        <input class="form-check-input module-checkbox" type="checkbox" 
                               id="module${module.module_id}" 
                               data-module-id="${module.module_id}" 
                               data-role-id="${roleId}"
                               ${module.assigned ? 'checked' : ''}>
                        <label class="form-check-label" for="module${module.module_id}">
                            ${'&nbsp;'.repeat(level * 4)}${module.module_name}
                        </label>
                    </div>
                    ${module.children.length ? renderModuleTree(module.children, roleId, level + 1) : ''}
                </li>
            `;
        });
        html += '</ul>';
        return html;
    }

    // Update module assignment
    function updateModuleAssignment(moduleId, roleId, assigned) {
        $.ajax({
            url: 'api/role_module_assignment_update.php',
            method: 'POST',
            data: { module_id: moduleId, role_id: roleId, assigned: assigned },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showSuccess('Module assignment updated successfully');
                } else {
                    showError('Failed to update module assignment: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                showError('Failed to update module assignment: ' + error);
            }
        });
    }

    // Event listeners
    roleSelect.on('change', function() {
        const roleId = $(this).val();
        if (roleId) {
            loadModuleStructure(roleId);
        } else {
            moduleAssignmentList.empty();
        }
    });

    moduleAssignmentList.on('change', '.module-checkbox', function() {
        const moduleId = $(this).data('module-id');
        const roleId = $(this).data('role-id');
        const assigned = $(this).is(':checked');
        updateModuleAssignment(moduleId, roleId, assigned);
    });

    // Initialize
    loadRoles();

});