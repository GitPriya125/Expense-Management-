<?php
require_once '../includes/config.php';
//require_once '../includes/error_handler.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start output buffering
ob_start();

// Function to log debug information
function debug_log($message) {
    if (isset($_GET['debug']) && $_GET['debug'] == 1) {
        echo "DEBUG: " . $message . "<br>";
     }
}

debug_log("get_menu.php script started");

header('Content-Type: application/json');

try {
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($db->connect_error) {
        throw new Exception("Connection failed: " . $db->connect_error);
    }

    debug_log("Database connection successful");

    // Assuming the email is passed as a GET parameter
    $email = isset($_GET['email']) ? $db->real_escape_string($_GET['email']) : null;

    if (!$email) {
        throw new Exception("Email not provided");
        //$email="alok@rpatech.ai";
    }

    debug_log("Email received: " . $email);

$query = "
SELECT DISTINCT m.* 
FROM modules m
JOIN role_modules rm ON m.module_id = rm.module_id
JOIN users u ON rm.role_id = u.role_id
WHERE u.email = ?
ORDER BY m.display_order
 ";
    // $query = "
    //     SELECT DISTINCT m.* 
    //     FROM modules m
    //     JOIN role_modules rm ON m.module_id = rm.module_id
    //     JOIN roles r ON rm.role_id = r.role_id
    //     JOIN user_roles ur ON r.role_id = ur.role_id
    //     WHERE ur.email = ?
    //     ORDER BY m.display_order
    // ";

    debug_log("Query prepared: " . $query);

    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $modules = $result->fetch_all(MYSQLI_ASSOC);

    debug_log("Query executed. Number of modules fetched: " . count($modules));

    echo json_encode($modules);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    debug_log("Exception occurred: " . $e->getMessage());
}

debug_log("get_menu.php script completed");

// Flush the output buffer
ob_end_flush();
?>