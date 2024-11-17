<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

try {
    $db = new DB();
    $itemId = $_POST['module_id'];
    $newParentId = $_POST['parent_id'];
    $newIndex = $_POST['new_index'];

    // Start transaction
    $db->beginTransaction();

    // Update parent_id
    $db->update('modules', ['parent_id' => $newParentId], ['module_id' => $itemId]);

    // Get siblings with the same parent
    $siblings = $db->select("SELECT module_id FROM modules WHERE parent_id = ? ORDER BY display_order", [$newParentId]);
    
    // Remove the moved item from the array if it's already a sibling
    $siblings = array_filter($siblings, function($sibling) use ($itemId) {
        return $sibling['module_id'] != $itemId;
    });
    
    // Insert the moved item at the new index
    array_splice($siblings, $newIndex, 0, [['module_id' => $itemId]]);

    // Update display_order for all siblings
    foreach ($siblings as $index => $sibling) {
        $db->update('modules', ['display_order' => $index + 1], ['module_id' => $sibling['module_id']]);
    }

    // Commit transaction
    $db->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $db->rollBack();
    http_response_code(500);
    
    $errorDetails = [
        'success' => false,
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString() // Optional: includes the stack trace
    ];
    
    echo json_encode($errorDetails);
}


?>
