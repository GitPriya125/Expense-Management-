<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    $menuItems = $db->select("SELECT * FROM modules ORDER BY parent_id, display_order");
    echo json_encode($menuItems);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
