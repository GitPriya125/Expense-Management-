<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    $roleId = $_POST['role_id'] ?? '';

    if (empty($roleId)) {
        throw new Exception("Role ID is required");
    }

    $db->delete('roles', ['role_id' => $roleId]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>