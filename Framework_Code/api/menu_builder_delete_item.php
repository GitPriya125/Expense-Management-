<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    $db->delete('modules', ['module_id' => $_POST['module_id']]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
