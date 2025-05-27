<!DOCTYPE html>
<html>
<head>
    <title>Volume Details</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="container">

    <?php
    $volId = $_GET['volumeId'];
    $journalName = $_GET['journalName'];
    include './dbconnect.php';

    // For preventing sql injection
    $stmt = $conn->prepare("SELECT v.*, v.id AS volId 
                            FROM Volume v
                            WHERE v.id = ?");

    $stmt->bind_param("s", $volId);
    $stmt->execute();
    $volumeResult = $stmt->get_result();

    if ($volumeResult->num_rows > 0) { 
        $volume = $volumeResult->fetch_assoc();

        echo "<h2>Volume: {$volume['id']} ({$journalName})</h2>"; // Display Volume and journalName
        echo "<p>Publication Date: {$volume['publicationDate']}</p>"; //Display Publication Date
        echo "<p>First Submission Deadline: {$volume['firstSubDeadline']}</p>"; //Display First Submission Deadline
        echo "<p>Review Start Date: {$volume['reviewStarts']}</p>"; // Display ...
        echo "<p>Review Deadline: {$volume['reviewDeadline']}</p>";
        echo "<p>Results Announcement Date: {$volume['resultsAnnouncement']}</p>";
        echo "<p>Second Submission Open: {$volume['secondSubOpen']}</p>";
        echo "<p>Second Submission Deadline: {$volume['secondSubDeadline']}</p>";

        // To find related article
        $stmt = $conn->prepare("SELECT * FROM article WHERE volId = ?"); // For preventing sql injection
        $stmt->bind_param("s", $volId);
        $stmt->execute();
        $articleResult = $stmt->get_result();

        if ($articleResult->num_rows > 0) {
            echo "<h3>Submitted Articles:</h3>";
            echo "<table>";
            echo "<tr><th>Title</th><th>Corresponding Author</th><th>Submission Date</th><th>Result</th></tr>";

            while ($article = $articleResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='article.php?journalName=" . htmlspecialchars($journalName) . "&volId=" . htmlspecialchars($volId) . "&id={$article['id']}'>{$article['title']}</a></td>";

                // Fetch corresponding author's name using email
                $correspAutEmail = $article['correspAut'];
                $authorStmt = $conn->prepare("SELECT name FROM person WHERE email = ?");
                $authorStmt->bind_param("s", $correspAutEmail);
                $authorStmt->execute();
                $authorResult = $authorStmt->get_result();
                $author = $authorResult->fetch_assoc();

                echo "<td>{$author['name']}</td>";
                echo "<td>{$article['submissionDate']}</td>";
                echo "<td>{$article['result']}</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No article found.";
        }
    } else {
        echo "Volume not found.";
    }

    mysqli_close($conn);
    #buttom part for return to journal and home page 
    ?>
    
    <p><a href="journal2.php?journalName=<?php echo htmlspecialchars($journalName); ?>">Return to Journal</a></p> 
    <p><a href="index.php" > Return to main page</a></p>
    </div>
</body>
</html>
