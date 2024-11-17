<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    
    // Decode JSON input
    $newOrder = json_decode(file_get_contents('php://input'), true);

    // Check if input is a valid array
    if (!is_array($newOrder)) {
        throw new Exception("Invalid input format. Expected an array.");
    }

    // Start transaction
    $db->getConnection()->beginTransaction();

    // Update display_order for each module
    foreach ($newOrder as $index => $moduleId) {
        $query = "UPDATE modules SET display_order = ? WHERE module_id = ?";
        $db->query($query, [$index + 1, $moduleId]);
    }

    // Commit the transaction
    $db->getConnection()->commit();

    // Respond with success
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Rollback transaction if there is an error
    if ($db->getConnection()->inTransaction()) {
        $db->getConnection()->rollBack();
    }
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

