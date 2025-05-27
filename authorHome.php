<?php
session_start();
include './dbconnect.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Author Home Page</title>
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
            <h2>Articles</h2>
            <?php
            if (isset($_SESSION['email'])) {
                $authorEmail = $_SESSION['email'];
                $isAuthor = $_SESSION['isAuthor'];
                if ($isAuthor == 1) {
                    echo "<p class='access-granted'>Access granted</p>";
                } else {
                    echo "<p class='access-denied'>You are not authorized to view this page without author permissions!</p>";
                    echo "<a href='index.php' class='return-link'>Return to main page</a>";
                    exit();
                }
            } else {
                header("Location: login.php");
                exit();
            }

            $stmt = $conn->prepare("SELECT a.id as aid, a.title as atitle, a.submissionDate as asubmissionDate, a.correspAut as acorrespAut, a.result as aresult
                                    FROM Person P 
                                    JOIN Article A on P.email = A.correspAut
                                    JOIN Volume V on V.id = A.volId
                                    WHERE P.email = ?");
            $stmt->bind_param("s", $authorEmail);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Submission Date</th>
                        <th>Author</th>
                        <th>Result</th>
                      </tr>";

                while ($row = $result->fetch_assoc()) {
                    $articleId = $row['aid'];
                    $articleTitle = $row['atitle'];
                    $submissionDate = $row['asubmissionDate'];
                    $correspAut = $row['acorrespAut'];
                    $aresult = $row['aresult'] ? $row['aresult'] : 'In progress';

                    echo "<tr>";
                    echo "<td>$articleId</td>";
                    echo "<td>$articleTitle</td>";
                    echo "<td>$submissionDate</td>";
                    echo "<td>$correspAut</td>";
                    echo "<td>$aresult</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No articles to display.</p>";
            }

            mysqli_close($conn);
            ?>
        </div>
    </main>

</body>

</html>
