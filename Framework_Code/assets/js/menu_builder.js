$(document).ready(function() {
    const menuVisualization = $('#menuVisualization');
    const menuItemForm = $('#menuItemForm');

    // Load initial menu structure
    loadMenuStructure();

    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Handle form submission for adding new menu item
    menuItemForm.on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        addMenuItem(formData);
    });

    // Event delegation for edit, delete, move up, and move down buttons
    menuVisualization.on('click', '.edit-btn, .delete-btn, .move-up-btn, .move-down-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const menuItem = $(this).closest('.menu-item');
        
        const action = $(this).attr('class').split(' ')[3].replace('-btn', '');
        //alert("here" + $(this).attr('class').split(' ')[3]);
        switch(action) {
            case 'edit':
                editMenuItem(menuItem);
                break;
            case 'delete':
                deleteMenuItem(menuItem.data('id'));
                break;
            case 'move-up':
                moveMenuItem(menuItem.data('id'), 'up');
                break;
            case 'move-down':
                moveMenuItem(menuItem.data('id'), 'down');
                break;
        }
    });

    function loadMenuStructure() {
        $.ajax({
            url: 'api/menu_builder_get_structure.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                renderMenuStructure(data);
                populateParentDropdown(data);
            },
            error: function(xhr, status, error) {
                showError('Failed to load menu structure: ' + error);
            }
        });
    }

    function renderMenuStructure(menuItems) {
        menuVisualization.empty();
        const tree = buildMenuTree(menuItems);
        tree.forEach(item => {
            menuVisualization.append(createMenuItemElement(item));
        });

        // // Initialize SortableJS
        // new Sortable(menuVisualization[0], {
        //     animation: 150,
        //     ghostClass: 'blue-background-class',
        //     onEnd: function (evt) {
        //         updateMenuItemPosition(evt.item.dataset.id, evt.to.closest('.menu-item')?.dataset.id, evt.newIndex);
        //     }
        // });
    }

    function buildMenuTree(items, parentId = null) {
        return items.filter(item => item.parent_id == parentId)
            .map(item => ({
                ...item,
                children: buildMenuTree(items, item.module_id)
            }));
    }

    function createMenuItemElement(item) {
        const div = $('<div>')
            .addClass('menu-item')
            .attr('data-id', item.module_id);
        
        div.html(`
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <i class="${item.icon}"></i> 
                            <span>${item.module_name}</span>
                            <span>(${item.url})</span>
                            <span>ToolTip: ${item.tooltip || 'None'}</span>
                            <span>Parent ID: ${item.parent_id || 'None'}</span>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-12 text-end">
                            <button class="btn btn-sm btn-primary edit-btn" data-bs-toggle="tooltip" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn" data-bs-toggle="tooltip" title="Delete">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary move-up-btn" data-bs-toggle="tooltip" title="Move Up">
                                <i class="bi bi-arrow-up"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary move-down-btn" data-bs-toggle="tooltip" title="Move Down">
                                <i class="bi bi-arrow-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="drop-area">Drop here to make it submenu</div>
        `);

        if (item.children && item.children.length > 0) {
            const submenu = $('<div>').addClass('submenu ms-4 mt-2');
            item.children.forEach(child => {
                submenu.append(createMenuItemElement(child));
            });
            div.append(submenu);
        }

        return div;
    }

    function addMenuItem(formData) {
        $.ajax({
            url: 'api/menu_builder_add_item.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    loadMenuStructure();
                    menuItemForm[0].reset();
                    showSuccess('Menu item added successfully');
                } else {
                    showError('Failed to add menu item: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                showError('Failed to add menu item: ' + error);
            }
        });
    }

    function editMenuItem(menuItem) {
        const moduleId = menuItem.data('id');
        
        // Populate form with item data
        $('#moduleName').val(menuItem.find('.card-body span:first').text());
        $('#icon').val(menuItem.find('i:first').attr('class'));
        $('#url').val(menuItem.find('.card-body span:eq(1)').text().replace(/[()]/g, ''));
        $('#tooltip').val(menuItem.find('.card-body span:eq(2)').text().replace('ToolTip: ', ''));
        $('#parentItem').val(menuItem.find('.card-body span:eq(3)').text().replace('Parent ID: ', '') || '');
        $('#displayOrder').val(menuItem.index());

        // Change form submission to update instead of add
        menuItemForm.off('submit').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('module_id', moduleId);
            updateMenuItem(formData);
        });

        // Change button text and show cancel button
        menuItemForm.find('button[type="submit"]').html('<i class="bi bi-floppy"></i> Update');
        menuItemForm.find('.cancel-btn').show();

        // Scroll to form
        $('html, body').animate({
            scrollTop: menuItemForm.offset().top
        }, 500);
    }

    function updateMenuItem(formData) {
        $.ajax({
            url: 'api/menu_builder_update_item.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    loadMenuStructure();
                    resetForm();
                    showSuccess('Menu item updated successfully');
                } else {
                    showError('Failed to update menu item: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                showError('Failed to update menu item: ' + error);
            }
        });
    }

    function deleteMenuItem(moduleId) {
        if (confirm('Are you sure you want to delete this menu item?')) {
            $.ajax({
                url: 'api/menu_builder_delete_item.php',
                method: 'POST',
                data: { module_id: moduleId },
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        loadMenuStructure();
                        showSuccess('Menu item deleted successfully');
                    } else {
                        showError('Failed to delete menu item: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    showError('Failed to delete menu item: ' + error);
                }
            });
        }
    }

    function updateMenuItemPosition(itemId, newParentId, newIndex) {
        $.ajax({
            url: 'api/menu_builder_update_position.php',
            method: 'POST',
            data: {
                module_id: itemId,
                parent_id: newParentId,
                new_index: newIndex
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    loadMenuStructure();
                    showSuccess('Menu item position updated successfully');
                } else {
                    showError('Failed to update menu item position: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                showError('Failed to update menu item position: ' + error);
            }
        });
    }

    function moveMenuItem(moduleId, direction) {
        $.ajax({
            url: 'api/menu_builder_move_item.php',
            method: 'POST',
            data: {
                module_id: moduleId,
                direction: direction
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    loadMenuStructure();
                    showSuccess('Menu item moved successfully');
                } else {
                    showError('Failed to move menu item: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                showError('Failed to move menu item: ' + error);
            }
        });
    }

    function populateParentDropdown(menuItems) {
        const parentDropdown = $('#parentItem');
        parentDropdown.empty().append('<option value="">None</option>');
        menuItems.forEach(item => {
            parentDropdown.append(`<option value="${item.module_id}">${item.module_name}</option>`);
        });
    }

    function resetForm() {
        menuItemForm[0].reset();
        menuItemForm.off('submit').on('submit', function(e) {
            e.preventDefault();
            addMenuItem(new FormData(this));
        });
        menuItemForm.find('button[type="submit"]').html('<i class="bi bi-plus-square"></i> Add');
        menuItemForm.find('.cancel-btn').hide();
    }

    menuItemForm.find('.cancel-btn').on('click', function() {
        resetForm();
    });

  
});