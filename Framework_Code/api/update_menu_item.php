<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    
    $moduleId = isset($_POST['module_id']) ? intval($_POST['module_id']) : 0;
    $moduleName = $_POST['module_name'] ?? '';
    $icon = $_POST['icon'] ?? '';
    $url = $_POST['url'] ?? '';
    $tooltip = $_POST['tooltip'] ?? '';

    if ($moduleId <= 0 || empty($moduleName)) {
        throw new Exception("Invalid input");
    }

    $query = "UPDATE modules SET module_name = ?, icon = ?, url = ?, tooltip = ? WHERE module_id = ?";
    $params = [$moduleName, $icon, $url, $tooltip, $moduleId];
    $db->query($query, $params);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>