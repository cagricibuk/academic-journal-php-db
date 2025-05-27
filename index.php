<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Management System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>

<body>
<header>
    <div class="navbar">
        <div class="logo">
        <?php
session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $isAuthor = $_SESSION['isAuthor'];
    $isEditor = $_SESSION['isEditor'];
    $isReviewer = $_SESSION['isReviewer'];

    // Use these variables to control access or display appropriate content
    echo "Email: $email<br>";
    echo "Is Author: " . ($isAuthor ? 'Yes' : 'No') . "<br>";
    echo "Is Editor: " . ($isEditor ? 'Yes' : 'No') . "<br>";
    echo "Is Reviewer: " . ($isReviewer ? 'Yes' : 'No') . "<br>";
}
else{
    echo "no user logged in...";
} 
?>

        </div>
        <div class="nav-links" id="navLinks">
            <a href="index.php">Home</a>
            <a href="journal2.php">Journals</a>
            <a href="reviewerHome.php">Reviews</a>
            <a href="authorHome.php">Authors</a>
            <a href="editor.php">Editor</a>

            <?php
            if (isset($_SESSION['email'])) {
                echo "<p><a href='logout.php' class='signup'>Logout</a></p>";
            } else {
                echo "<p><a href='login.php' class='signup'>Login</a></p>";
            }
            ?>
        </div>
        <div class="hamburger" id="hamburger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </div>
</header>
    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Welcome to the Journal Management System</h1>
                <p>Explore journals, articles, and volumes. Stay updated with the latest research.</p>
            </div>
        </section>
        <section class="content">
        </section>
        <section class="features">
            <div class="feature">
                <h2>Explore Research Topics</h2>
                <p>Find research papers on a wide range of topics.</p>
            </div>
            <div class="feature">
                <h2>Follow Authors</h2>
                <p>Stay updated with the latest research from your favorite authors.</p>
            </div>
            <div class="feature">
                <h2>Collaborate with Peers</h2>
                <p>Connect with researchers and collaborate on projects.</p>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Journal Management System. All rights reserved.</p>
    </footer>
</body>

</html>