<?php
session_start();
include './dbconnect.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Editor Management Page</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>

<body>

<header>
    <div class="navbar">
        <div class="logo">
        <?php

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
        <div class="container">
            <h1>Welcome Editor</h1>

            <h2>Journals</h2>
            <?php
            // List Journals
            if (isset($_SESSION['email'])) {
                $reviewerEmail = $_SESSION['email'];
                $isReviewer = $_SESSION['isEditor'];
                if ($isReviewer == 1) {
                    echo "<p class='access-granted'>Access granted</p>";
                } else {
                    echo "<p class='access-denied'>You are not authorized to view this page without reviewer permissions!</p>";
                    echo "<a href='index.php' class='return-link'>Return to main page</a>";
                    exit();
                }
            } else {
                header("Location: login.php");
                exit();
            }

            $query = "SELECT name FROM journal";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
            }

            echo "<table>";
            echo "<tr><th>Journal Name</th><th>ID</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                $journalName = htmlspecialchars($row['name']);
                echo "<tr><td><a href=\"editor.php?journal=$journalName\">$journalName</a></td><td></td></tr>";
            }
            echo "</table>";
            ?>

            <?php
            // List Volumes
            if (isset($_GET['journal'])) {
                $journalName = mysqli_real_escape_string($conn, $_GET['journal']);

                // Query for Volumes
                $query = "SELECT V.id, V.name AS volumeName FROM Volume V
                          JOIN VolumeTheme VT on V.id = VT.id
                          JOIN Journal J on VT.name = J.name
                          WHERE J.name = '$journalName'";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                }

                echo "<h2>Volumes for " . htmlspecialchars($journalName) . "</h2>";
                echo "<table>";
                echo "<tr><th>Volume Name</th><th>Volume ID</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    $volumeId = htmlspecialchars($row['id']);
                    $volumeName = htmlspecialchars($row['volumeName']);
                    echo "<tr><td><a href=\"editor.php?journal=$journalName&volume=$volumeId\">$volumeName</a></td><td>$volumeId</td></tr>";
                }
                echo "</table>";
            }
            ?>

            <?php
            // List articles
            if (isset($_GET['journal']) && isset($_GET['volume'])) {
                $journalName = mysqli_real_escape_string($conn, $_GET['journal']);
                $volumeId = mysqli_real_escape_string($conn, $_GET['volume']);

                // Article Query
                $query = "SELECT id, title FROM article WHERE volId = '$volumeId'";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                }

                echo "<h2>Articles in Volume " . htmlspecialchars($volumeId) . "</h2>";
                echo "<table>";
                echo "<tr><th>Title</th><th>Article ID</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    $articleId = htmlspecialchars($row['id']);
                    $articleTitle = htmlspecialchars($row['title']);
                    echo "<tr><td><a href=\"editor.php?journal=$journalName&volume=$volumeId&article=$articleId\">$articleTitle</a></td><td>$articleId</td></tr>";
                }
                echo "</table>";
            }
            ?>

            <?php
            // Show article details 
            if (isset($_GET['article'])) {
                $articleId = mysqli_real_escape_string($conn, $_GET['article']);

                // Article details query
                $query = "SELECT * FROM Article A 
                          JOIN Person P on P.email = A.correspAut 
                          WHERE A.id = '$articleId'";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                }

                $row = mysqli_fetch_assoc($result);
                $articleTitle = htmlspecialchars($row['title']);
                $articleBodyText = htmlspecialchars($row['bodyText']);
                $articleAuthor = htmlspecialchars($row['correspAut']);
                $submissionDate = htmlspecialchars($row['submissionDate']);
                $articleResult = htmlspecialchars($row['result']);

                echo "<h2>Article: $articleTitle</h2>";
                echo "<p><strong>Author:</strong> $articleAuthor</p>";
                echo "<p><strong>Submission Date:</strong> $submissionDate</p>";
                echo "<p><strong>Result:</strong> $articleResult</p>";
                echo "<p><strong>Body Text:</strong> $articleBodyText</p>";

                if ($row['isReviewer'] == 1) {
                    // Show Reviewer
                    $reviewerEmail = $row['email'];
                    $reviewerQuery = "SELECT * FROM Person WHERE email = '$reviewerEmail'";
                    $reviewerResult = mysqli_query($conn, $reviewerQuery);
                    $reviewerRow = mysqli_fetch_assoc($reviewerResult);
                    echo "<p><strong>Reviewer:</strong> " . htmlspecialchars($reviewerRow['name']) . "</p>";
                } else {
                    // If reviewer has not assigned yet 
                    echo "<form method='POST'>";
                    echo "<label for='reviewer'>Assign Reviewer:</label>";
                    echo "<select name='reviewer' id='reviewer'>";

                    // List reviewers
                    $reviewersQuery = "SELECT * FROM Person WHERE isReviewer = 1 AND email NOT IN (SELECT email FROM Person_Volume)";
                    $reviewersResult = mysqli_query($conn, $reviewersQuery);

                    while ($reviewer = mysqli_fetch_assoc($reviewersResult)) {
                        echo "<option value='" . $reviewer['email'] . "'>" . htmlspecialchars($reviewer['name']) . "</option>";
                    }

                    echo "</select>";
                    echo "<button type='submit' name='assignReviewer'>Assign</button>";
                    echo "</form>";
                }

                // Handle reviewer assignment
                if (isset($_POST['assignReviewer'])) {
                    $reviewerMail = mysqli_real_escape_string($conn, $_POST['reviewer']);

                    // Update query
                    $updateQuery = "INSERT INTO ArticleReviews (id, email, scoreOfTheReviewer) VALUES ('$articleId', '$reviewerMail', 0)";


                    if (mysqli_query($conn, $updateQuery)) {
                        echo "<p>Reviewer assigned successfully.</p>";
                    } else {
                        echo "Error assigning reviewer: " . mysqli_error($conn);
                    }
                }
            }
            ?>

        </div>
    </main>

</body>

</html>
