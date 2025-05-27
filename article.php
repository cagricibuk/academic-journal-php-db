<!DOCTYPE html>
<html>
<head>
    <title>Volume Details</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <div class="container">

    <?php
$articleId = $_GET['id'];
$journalName = $_GET['journalName'];
$volId = $_GET['volId'];
include './dbconnect.php';


// SQL injection protection part (fetch article and volume details)
$stmt = $conn->prepare("SELECT a.*, v.*
                       FROM Article a 
                       JOIN Volume v ON a.volId = v.id
                       WHERE a.id = ? AND v.id = ?");

$stmt->bind_param("ss", $articleId, $volId);
$stmt->execute();
$articleResult = $stmt->get_result();
echo "Deneme  ";
if ($articleResult->num_rows > 0) { 
    echo "Deneme  ";
    $article = $articleResult->fetch_assoc();

 

        // To find related article
        $stmt = $conn->prepare("SELECT * FROM article WHERE volId = ? and id =  ? "); // For preventing sql injection
        $stmt->bind_param("ss", $volId, $articleId );
        $stmt->execute();
        $articleResult = $stmt->get_result();

        if ($articleResult->num_rows > 0) {
            echo "<h3>Submitted Articles:</h3>";
            echo "<table>";
            echo "<tr><th>Title</th><th>Body Text</th><th>Corresponding Author</th><th>Submission Date</th><th>Result</th></tr>";

            while ($article = $articleResult->fetch_assoc()) {
                echo "<tr>";
                

                // Fetch corresponding author's name using email
                $correspAutEmail = $article['correspAut'];
                $authorStmt = $conn->prepare("SELECT name FROM person WHERE email = ?");
                $authorStmt->bind_param("s", $correspAutEmail);
                $authorStmt->execute();
                $authorResult = $authorStmt->get_result();
                $author = $authorResult->fetch_assoc();

                echo "<td>{$article['title']}</td>";
                echo "<td>{$article['bodyText']}</td>";
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
