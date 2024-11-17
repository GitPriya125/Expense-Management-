<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $roleId = $_POST['role_id'] ?? '';

    if (empty($email) || empty($username) || empty($roleId)) {
        throw new Exception("Email, username, and role are required");
    }

    $userId = $db->insert('users', [
        'email' => $email,
        'username' => $username,
        'role_id' => $roleId
    ]);
    echo json_encode(['success' => true, 'data' => ['user_id' => $userId]]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>