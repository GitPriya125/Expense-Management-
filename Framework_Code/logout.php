<?php
session_start();  
session_unset();  
session_destroy();
header("Location: default.php");

header("Location: https://login.microsoftonline.com/common/oauth2/v2.0/logout?post_logout_redirect_uri=" . urlencode('https://helpdesk.emp.center/default.php'));
exit();
?>