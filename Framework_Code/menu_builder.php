<?php
define('INCLUDED', true);
$pageTitle = "Menu Builder";
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/error_handler.php';
include 'includes/header.php';

?>

<div class="content-wrapper">
  <?php include 'includes/sidebar.php'; ?>  

    <main id="main-content" class="container-fluid">
        
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-menu-button-fill"></i>
        
                   Add New Menu
                </span>
               
            </div>
        </div>
        <div id="formdiv" class="card-body">
        <!-- Add New Menu Item Form -->
        <form id="menuItemForm" class="row g-3 mb-4 ">
            <div class="col-lg-2 col-md-4 col-sm-12">
                <label for="icon" class="form-label">Icon Class</label>
                <input type="text" class="form-control" id="icon" name="icon" required>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <label for="moduleName" class="form-label">Module Name</label>
                <input type="text" class="form-control" id="moduleName" name="module_name" required>
            </div>
            
            <div class="col-lg-2 col-md-4 col-sm-12">
                <label for="url" class="form-label">URL</label>
                <input type="text" class="form-control" id="url" name="url" required>
            </div>
            <div class="col-lg-1 col-md-4 col-sm-12">
                <label for="tooltip" class="form-label">Tooltip</label>
                <input type="text" class="form-control" id="tooltip" name="tooltip" required>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <label for="parentItem" class="form-label">Parent Item</label>
                <select class="form-select" id="parentItem" name="parent_id">
                    <option value="">None</option>
                </select>
            </div>
            <div class="col-lg-1 col-md-4 col-sm-12">
                <label for="displayOrder" class="form-label">Order</label>
                <input type="number" class="form-control" id="displayOrder" name="display_order" required>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12 mt-4 text-end">
                <button type="submit" class="btn btn-primary mt-4 ms-0">
                    <i class="bi bi-plus-square"></i> Add
                </button>
                <button type="button" class="btn btn-secondary cancel-btn mt-4 ms-0" style ="display:none"><i class="bi bi-x-square"></i></button>
              
            </div>
        </form>
        </div>
    </div>
 <div class="card mt-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-menu-button-fill"></i> Current menu structure</span>
                        </div>
                    </div>
                    <div class="card-body">
        <!-- Menu Visualization -->
        <div id="menuVisualization" class="mb-4"></div>
        </div>
    </main>
</div>


<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="/assets/js/menu_builder.js"></script>
<?php include 'includes/footer.php'; ?>

