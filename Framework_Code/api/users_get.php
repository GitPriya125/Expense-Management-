<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    $userId = $_GET['user_id'] ?? null;
    $activeOnly = isset($_GET['active_only']) ? filter_var($_GET['active_only'], FILTER_VALIDATE_BOOLEAN) : false;

    $query = "
        SELECT u.*, r.role_name 
        FROM users u 
        LEFT JOIN roles r ON u.role_id = r.role_id 
    ";

    $params = [];

    if ($userId) {
        $query .= " WHERE u.user_id = ?";
        $params[] = $userId;
    } elseif ($activeOnly) {
        $query .= " WHERE u.is_active = 1";
    }

    $query .= " ORDER BY u.username";

    $users = $db->select($query, $params);
    echo json_encode(['success' => true, 'data' => $users]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>