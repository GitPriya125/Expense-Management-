<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    //$roleId = $_POST['role_id'] ?? null;
    $roleId = isset($_GET['role_id']) ? $_GET['role_id'] : null;
    //echo $roleId;

    $query = "SELECT m.*, CASE WHEN rm.role_id IS NOT NULL THEN 1 ELSE 0 END AS assigned
              FROM modules m
              LEFT JOIN role_modules rm ON m.module_id = rm.module_id AND rm.role_id = ?
              ORDER BY m.parent_id, m.display_order";

    $modules = $db->select($query, [$roleId]);
    echo json_encode($modules);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>