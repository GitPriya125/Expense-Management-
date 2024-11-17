<?php

// api/update_role_module_assignment.php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    $moduleId = $_POST['module_id'] ?? null;
    $roleId = $_POST['role_id'] ?? null;
    $assigned = $_POST['assigned'] ?? null;

    if (!$moduleId || !$roleId || !isset($assigned)) {
        throw new Exception("Missing required parameters");
    }

    if ($assigned == 'true') {
        $db->query("INSERT IGNORE INTO role_modules (role_id, module_id) VALUES (?, ?)", [$roleId, $moduleId]);
    } else {
        $db->query("DELETE FROM role_modules WHERE role_id = ? AND module_id = ?", [$roleId, $moduleId]);
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>