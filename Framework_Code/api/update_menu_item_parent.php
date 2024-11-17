<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    
    $data = json_decode(file_get_contents('php://input'), true);
    $itemId = intval($data['itemId']);
    $newParentId = $data['newParentId'] !== null ? intval($data['newParentId']) : null;

    if ($itemId <= 0) {
        throw new Exception("Invalid item ID");
    }

    // Update the parent_id
    $query = "UPDATE modules SET parent_id = ? WHERE module_id = ?";
    $db->query($query, [$newParentId, $itemId]);

    // Update display_order if necessary
    // This is a simplified version. You might want to adjust all siblings' order as well.
    $orderQuery = "UPDATE modules SET display_order = (
        SELECT max_order + 1 FROM (
            SELECT COALESCE(MAX(display_order), 0) as max_order 
            FROM modules 
            WHERE parent_id " . ($newParentId ? "= ?" : "IS NULL") . "
        ) as subquery
    ) WHERE module_id = ?";
    
    $orderParams = $newParentId ? [$newParentId, $itemId] : [$itemId];
    $db->query($orderQuery, $orderParams);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>