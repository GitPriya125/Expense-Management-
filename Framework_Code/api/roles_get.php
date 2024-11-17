<?php
// api/get_roles.php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

// try {
//     $db = new DB();
//     $roles = $db->select("SELECT role_id, role_name FROM roles ORDER BY role_name");
//     echo json_encode($roles);
// } catch (Exception $e) {
//     http_response_code(500);
//     echo json_encode(['error' => $e->getMessage()]);
// }

try {
    $db = new DB();
    $roles = $db->select("SELECT * FROM roles ORDER BY role_name");
    echo json_encode(['success' => true, 'data' => $roles]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

?>