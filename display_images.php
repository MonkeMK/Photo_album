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
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "fotos";

        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve image data from the database and sort by date
        $sql = "SELECT * FROM images ORDER BY upload_date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="row">';
            while ($row = $result->fetch_assoc()) {
                $image_path = $row["image_path"];
                $upload_date = isset($row["upload_date"]) ? $row["upload_date"] : "Date not available";

                echo '
                <div class="col-4 mb-4">
                    <div class="card h-100">
                        <a href="' . $image_path . '" target="_blank"> <!-- Added target="_blank" to open the image in a new tab -->
                            <img src="' . $image_path . '" alt="Uploaded Image" class="card-img-top img-thumbnail">
                        </a>
                        <div class="card-body">
                            <p class="card-date">' . $upload_date . '</p>
                        </div>
                    </div>
                </div>';
            }

            echo '</div>';
        } else {
            echo "No images found.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
