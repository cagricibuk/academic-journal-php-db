<html>

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journals - Academia Clone</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>

<body>

<?php
include './dbconnect.php';

$query = "SELECT j.name as journal_name, v.id as volume_id
From Journal j join VolumeTheme VT on J.name = VT.name
Join Volume V on VT.id = V.id;";
$result = mysqli_query($conn, $query);

mysqli_close($conn);
?>

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
        <section class="category">
            <h2>Journals</h2>
            <table border="2" cellspacing="2" cellpadding="2">
            <tr>
                <th>Volume Name</th>
                <th>Journal Name</th>
                
            </tr>


            <?php
            $i = 0;
            while ($row= mysqli_fetch_assoc($result)) {  //retrieve a tuple
                $journalName = $row['journal_name'];
                $volumeId = $row['volume_id'];
                
                
                ?>
                <tr>
                    <td>
                    <a href="volume.php?journalName=<?php echo $journalName; ?>&volumeId=<?php echo $volumeId; ?>"><?php echo $volumeId; ?></a>


                     
                    </td>
                    <td><?php echo $journalName; ?></td>
                   
                </tr>

                <?php                
            }
            ?>
            </table>

            
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Academia Clone. All rights reserved.</p>
    </footer>

</body>

</html>