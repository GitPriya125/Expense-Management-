<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    $userId = $_POST['user_id'] ?? '';
    $isActive = isset($_POST['is_active']) ? (bool)$_POST['is_active'] : null;

    if (empty($userId) || $isActive === null) {
        throw new Exception("User ID and active status are required");
    }

    $db->update('users', 
        ['is_active' => $isActive],
        ['user_id' => $userId]
    );
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>