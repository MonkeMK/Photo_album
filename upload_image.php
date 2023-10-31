<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"]["name"])) {
    $target_dir = "uploads/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
        chmod($target_dir, 0777);
    }

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an actual image or a fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            exit();
        }
    }

    // Check if the file already exists
    if (file_exists($target_file)) {
        echo "Sorry, the file already exists.";
        exit();
    }

    // Check the file size (You can set your own limit, e.g., 2MB here)
    if ($_FILES["image"]["size"] > 2097152) {
        echo "Sorry, the file is too large.";
        exit();
    }

    // Allow only certain file formats (you can customize this list)
    $allowed_formats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_formats)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        exit();
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "The file has been uploaded and saved successfully.";

        // Connect to your MySQL database using PDO
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "fotos";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create a table to store the image data (if not already created)
            $sql = "CREATE TABLE IF NOT EXISTS images (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                image_path VARCHAR(255) NOT NULL,
                upload_date DATE NOT NULL
            )";

            $conn->exec($sql);

            // Get the current date
            $upload_date = date("Y-m-d");

            // Insert the image path and upload date into the database
            $sql = "INSERT INTO images (image_path, upload_date) VALUES (:image_path, :upload_date)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':image_path', $target_file);
            $stmt->bindParam(':upload_date', $upload_date);
            $stmt->execute();

            // After successful upload and data insertion, redirect to display_images.php
            header("Location: display_images.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
