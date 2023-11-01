<?php
session_start();
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false) {
    if (!isset($_GET['username']) || !isset($_GET['password'])) {
        header("Location: https://www.google.com/search?q=why+am+i+stupid&rlz=1C1UEAD_nlNL969NL969&oq=why+am+i+stupid&gs_lcrp=EgZjaHJvbWUyBggAEEUYOdIBCDE4MzdqMGoxqAIAsAIA&sourceid=chrome&ie=UTF-8");
    } else {
        require 'dbconnect.php';
        $stmt = $conn->prepare('SELECT username, password FROM accounts WHERE username = :username');
        $stmt->bindParam(':username', $_GET['username']);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (password_verify($_GET['password'], $result[0]['password'])) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $_GET['username'];
            header("Location: index.php");
        } else {
            header("Location: https://www.google.com/search?q=why+am+i+stupid&rlz=1C1UEAD_nlNL969NL969&oq=why+am+i+stupid&gs_lcrp=EgZjaHJvbWUyBggAEEUYOdIBCDE4MzdqMGoxqAIAsAIA&sourceid=chrome&ie=UTF-8");
        }
    }
} else {
    echo '<h1>Welcome ' . $_SESSION['username'] . '</h1>';
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Photo Album</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <h2>Photo Gallery</h2>
    <p class="keuze_text">Please select an option:</p>

    <!-- Custom button to go to the Upload page -->
    <div class="custom-button" class="upload" onclick="goToUploadPage()">Go to Upload Page</div>

    <!-- Custom button to go to the View page -->
    <div class="custom-button" class="view" onclick="goToViewPage()">Go to View Page</div>

    <script>
        // Function to redirect to the Upload page
        function goToUploadPage() {
            window.location.href = "upload_image.html";
        }

        // Function to redirect to the View page
        function goToViewPage() {
            window.location.href = "display_images.php";
        }
    </script>
</body>

</html>