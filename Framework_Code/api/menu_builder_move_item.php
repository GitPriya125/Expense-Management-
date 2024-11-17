<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

try {
    $db = new DB();
    $itemId = $_POST['module_id'];
    $direction = $_POST['direction'];

    // Get current item info
    $currentItem = $db->selectOne("SELECT * FROM modules WHERE module_id = ?", [$itemId]);

    // Get siblings
    if (is_null($currentItem['parent_id'])) {
    $siblings = $db->select("SELECT module_id, display_order FROM modules WHERE parent_id IS NULL ORDER BY display_order");
    } else {
        $siblings = $db->select("SELECT module_id, display_order FROM modules WHERE parent_id = ? ORDER BY display_order", [$currentItem['parent_id']]);
    }

    // $siblings = $db->select("SELECT module_id, display_order FROM modules WHERE parent_id = ? ORDER BY display_order", [$currentItem['parent_id']]);

    $currentIndex = array_search($itemId, array_column($siblings, 'module_id'));


    if ($direction === 'up' && $currentIndex > 0) {
        $swapIndex = $currentIndex - 1;
    } elseif ($direction === 'down' && $currentIndex < count($siblings) - 1) {
        $swapIndex = $currentIndex + 1;
    } else {
        throw new Exception("Cannot move item " . $direction .$currentIndex );
    }

    // Swap display_order
    $db->beginTransaction();
    $db->update('modules', ['display_order' => $siblings[$swapIndex]['display_order']], ['module_id' => $itemId]);
    $db->update('modules', ['display_order' => $currentItem['display_order']], ['module_id' => $siblings[$swapIndex]['module_id']]);
    $db->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $db->rollBack();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
