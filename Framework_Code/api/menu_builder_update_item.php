<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    $data = [
        'module_name' => $_POST['module_name'],
        'icon' => $_POST['icon'],
        'url' => $_POST['url'],
        'tooltip' => $_POST['tooltip'],
        'parent_id' => $_POST['parent_id'] ?: null,
        'display_order' => $_POST['display_order']
    ];

    $db->update('modules', $data, ['module_id' => $_POST['module_id']]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
