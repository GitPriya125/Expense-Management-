<?php
header('Content-Type: application/json');
require_once '../includes/config.php';
require_once '../includes/db.php';

$db = new DB();

try {
    $managers = $db->select("SELECT employee_id, name FROM employees WHERE is_manager = 1 ORDER BY name");
    echo json_encode(['success' => true, 'managers' => $managers]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error fetching managers: ' . $e->getMessage()]);
}