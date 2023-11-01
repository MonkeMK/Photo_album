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
