<?php
// auth.php
session_start();
require_once 'includes/config.php';
require_once 'includes/db.php'; // Include your database connection script

// Constants (replace with your actual values)
define('CLIENT_ID', MS_CLIENT_ID);
define('CLIENT_SECRET', MS_CLIENT_SECRET); // You need to obtain and set your client secret
define('REDIRECT_URI', MS_REDIRECT_URI);
define('AUTHORITY', 'https://login.microsoftonline.com/' . MS_TENANT_ID);
define('AUTHORIZE_ENDPOINT', AUTHORITY . '/oauth2/v2.0/authorize');
define('TOKEN_ENDPOINT', AUTHORITY . '/oauth2/v2.0/token');

// Step 1: If there's no "code" parameter, redirect to Microsoft's authorization page
if (!isset($_GET['code'])) {
    // Generate a random state value for security
    $_SESSION['oauth_state'] = bin2hex(random_bytes(16));

    $authorizationUrl = AUTHORIZE_ENDPOINT . '?' . http_build_query([
        'client_id' => CLIENT_ID,
        'response_type' => 'code',
        'redirect_uri' => REDIRECT_URI,
        'response_mode' => 'query',
        'scope' => 'openid profile offline_access User.Read',
        'state' => $_SESSION['oauth_state'],
    ]);

    header('Location: ' . $authorizationUrl);
    exit();
}

// Step 2: Validate the state parameter to prevent CSRF attacks
if (isset($_GET['state'])) {
    if ($_GET['state'] !== $_SESSION['oauth_state']) {
        unset($_SESSION['oauth_state']);
        exit('Invalid state parameter');
    }
} else {
    exit('State parameter missing');
}

// Step 3: Exchange the authorization code for an access token
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $tokenRequestData = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => REDIRECT_URI,
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
    ];

    $ch = curl_init(TOKEN_ENDPOINT);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($tokenRequestData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $tokenResponse = curl_exec($ch);
    curl_close($ch);

    $tokenData = json_decode($tokenResponse, true);

    if (isset($tokenData['access_token'])) {
        $accessToken = $tokenData['access_token'];

        // Step 4: Use the access token to call Microsoft Graph API and get user info
        $userInfo = getUserInfo($accessToken);
        $profilePic = getUserProfilePicture($accessToken);

        // Step 5: Store user info in PHP session
        $_SESSION['email'] = $userInfo['mail'] ?? $userInfo['userPrincipalName'];
        $_SESSION['name'] = $userInfo['displayName'];
        $_SESSION['profilePic'] = $profilePic;

        // Step 6: Check internal database for authorization
        if (checkUserAuthorization($_SESSION['email'])) {
            // User is authorized, proceed to dashboard
            session_regenerate_id(true); // Regenerate session ID for security
            // Retrieve the redirect URL from the session
            if (isset($_SESSION['redirect_after_login'])) {
                $redirectUrl = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']); // Clean up the session
            } else {
                $redirectUrl = 'dashboard.php'; // Default page if no redirect URL is set
            }
        
            // Redirect the user to the original page
            header("Location: $redirectUrl");
            exit();
        } else {
            // User is not authorized, redirect to an error page or display a message
            echo $_SESSION['email'] . 'You are not authorized to access this application.';
            session_destroy();
            echo 'You are not authorized to access this application.';
            exit();
        }
    } else {
        // Handle error - failed to get access token
        echo 'Error retrieving access token.';
        exit();
    }
}

// Function to get user info from Microsoft Graph API
function getUserInfo($accessToken) {
    $ch = curl_init('https://graph.microsoft.com/v1.0/me');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Accept: application/json',
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $userResponse = curl_exec($ch);
    curl_close($ch);

    return json_decode($userResponse, true);
}

// Function to get user profile picture from Microsoft Graph API
function getUserProfilePicture($accessToken) {
    $ch = curl_init('https://graph.microsoft.com/v1.0/me/photo/$value');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $photoData = curl_exec($ch);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpStatus == 200) {
        // Return the base64-encoded photo
        return 'data:image/jpeg;base64,' . base64_encode($photoData);
    } else {
        // Return null if no photo is found
        return null;
    }
}

// Function to check internal database for user authorization
function checkUserAuthorization($email) {
    // Create a new DB instance
    $db = new DB();

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT u.user_id, u.username, r.role_name FROM users u JOIN roles r ON u.role_id = r.role_id WHERE u.email = :email";
    $params = [':email' => $email];

    try {
        $user = $db->selectOne($sql, $params);

        if ($user) {
            // You can store additional user data in the session if needed
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_role'] = $user['role_name'];
            // ... any other user data

            return true; // User is authorized
        } else {
            return false; // User is not found in the database
        }
    } catch (PDOException $e) {
        // Log the error and return false
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}
?>
