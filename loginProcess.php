<?php

include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Fetch the user's details from the database
    $sql = "SELECT * FROM person WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user's details
        $user = $result->fetch_assoc();

        // Store user details in session
        $_SESSION['email'] = $user['email'];
        $_SESSION['isAuthor'] = $user['isAuthor'];
        $_SESSION['isEditor'] = $user['isEditor'];
        $_SESSION['isReviewer'] = $user['isReviewer'];

        // Redirect to the next page
        header("Location: index.php");
        
    } else {
        // Email not found

        echo "<h1>Email Not Found!</h1>";
        echo "<p>YLogin failed!.</p>";
        echo "<a href='index.php' class='return-link'>Return to main page</a>";
            session_start();
        session_unset();
        session_destroy();
    }
    $stmt->close();
}
?>