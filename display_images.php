<?php
require 'sessionCheck.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Display Images</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Your existing styles */
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        /* Style the date in the card */
        .card-date {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
        }

        /* Style the modal background and content */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.7);
        }

        /* Hide the modal */
        .modal {
            display: none;
        }

        /* Style the modal content */
        .modal-content img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Uploaded Images</h2>

        <!-- Button to go to the Upload page -->
        <a href="upload_image.html" class="btn btn-primary mb-3">Upload Picture</a>

        <?php
        // Connect to your MySQL database (replace with your credentials)
        require 'dbconnect.php';

        // Handle the "Remove All Files" button
        if (isset($_GET['remove_all'])) {
            $stmt = $conn->prepare('SELECT image_path FROM images');
            $stmt->execute();
            $imagePaths = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            $stmt = $conn->prepare('DELETE FROM images');
            $stmt->execute();
            foreach($imagePaths as $imagePath) {
                unlink($imagePath);
            }
        }

        // Handle the removal of individual images
        if (isset($_GET['remove_image'])) {
            $imagePath = $_GET['remove_image'];
            $stmt = $conn->prepare('DELETE FROM images WHERE image_path = :imgPath');
            $stmt->bindParam(':imgPath', $imagePath);
            if ($stmt->execute()) {
                // Successfully deleted the record from the database
                echo '<div class="alert alert-success" role="alert">The file has been removed from the database.</div>';

                // Delete the image from the computer
                unlink($imagePath);
            } else {
                echo '<div class="alert alert-danger" role="alert">Error removing the file from the database.</div>';
            }
        }


        // Retrieve image data from the database and sort by date
        $stmt = $conn->prepare("SELECT * FROM images ORDER BY upload_date DESC");
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $image_path = $row["image_path"];
            $upload_date = isset($row["upload_date"]) ? $row["upload_date"] : "Date not available";
            $formatted_date = date("l, jS F Y H:i", strtotime($upload_date));
        
            echo '
            <div class="col-4 mb-4">
                <div class="card h-100">
                    <a href="' . $image_path . '" target="_blank"> <!-- Added target="_blank" to open the image in a new tab -->
                        <img src="' . $image_path . '" alt="Uploaded Image" class="card-img-top img-thumbnail">
                    </a>
                    <div class="card-body">
                        <p class="card-date">Uploaded on ' . $formatted_date . '</p>
                        <a href="' . $image_path . '" download="image.jpg" class="btn btn-primary">Download</a>
                        <a href="?remove_image=' . $image_path . '" class="btn btn-danger">Remove</a>
                    </div>
                </div>
            </div>';
        }
        echo '</div>
        </div>';
        ?>
        <!-- Button to go back to index.html -->
        <form method="GET">
        <button type="submit" name="remove_all" class="btn btn-danger mt-3">Remove All Files</button>
        <a href="index.php" class="btn btn-primary mt-3">Back to Index</a>
        </form>
    </div>
</body>

</html>