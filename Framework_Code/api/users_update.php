<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    $userId = $_POST['user_id'] ?? '';
    $username = $_POST['username'] ?? '';
    $roleId = $_POST['role_id'] ?? '';

    if (empty($userId) || empty($username) || empty($roleId)) {
        throw new Exception("User ID, username, and role are required");
    }

    $db->update('users', 
        ['username' => $username, 'role_id' => $roleId],
        ['user_id' => $userId]
    );
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>