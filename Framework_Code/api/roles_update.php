<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    $roleId = $_POST['role_id'] ?? '';
    $roleName = $_POST['role_name'] ?? '';

    if (empty($roleId) || empty($roleName)) {
        throw new Exception("Role ID and name are required");
    }

    $db->update('roles', ['role_name' => $roleName], ['role_id' => $roleId]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>