<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// remove all session variables
session_unset();

// destroy the session
session_destroy();
	header('Location: http://localhost/My Project/Project/login.php');
	exit();
?>
</body>
</html>