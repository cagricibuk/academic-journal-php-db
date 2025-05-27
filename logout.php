<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Logout</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="logout-container">
        <h1>Logout Successful</h1>
        <p>You have been logged out.</p>
        <a href="index.php" class="return-link">Return to main page</a>
    </div>
</body>

</html>