<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "skcon";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array('status' => '', 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = date('Y-m-d H:i:s');
    $attached_file = "images/default.png"; // Default image path

    // Check if a file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size
        if ($_FILES["file"]["size"] > 500000000) { // Adjust maximum file size here (e.g., 500MB)
            $response['status'] = 'error';
            $response['message'] = 'Sorry, your file is too large.';
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedFormats = array("jpg", "png", "jpeg", "gif", "pdf", "mp4", "mov", "avi"); // Add video formats here
        if (!in_array($fileType, $allowedFormats)) {
            $response['status'] = 'error';
            $response['message'] = 'Sorry, invalid file format.';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo json_encode($response);
            exit;
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $attached_file = $target_file;
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Sorry, there was an error uploading your file.';
                echo json_encode($response);
                exit;
            }
        }
    }

    // Insert into database
    $sql = "INSERT INTO publication (title, description, date, attached_file) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $title, $description, $date, $attached_file);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'The Publication has been uploaded.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $sql . ' - ' . $conn->error;
    }

    $stmt->close();
    echo json_encode($response);
    exit;
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Publication</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-box {
            background-color: #040454;
            color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
        }

        .form-box h2 {
            margin: 0 0 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            text-align: center;
        }

        .form-box label {
            display: block;
            margin-bottom: 5px;
        }

        .form-box input[type="text"],
        .form-box textarea,
        .form-box input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-box textarea {
            height: 100px;
        }

        .form-box button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .form-box button:hover {
            background-color: #0056b3;
        }

        .form-box button + button {
            margin-top: 10px;
            background-color: #6c757d;
        }

        .form-box button + button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-box">
            <h2>Create Publication</h2>
            <form id="activitiesForm" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
                
                <label for="file">Attached file:</label>
                <input type="file" id="file" name="file" accept="image/*, video/*"> <!-- Allow both images and videos -->
                
                <button type="button" onclick="submitForm()">Save</button>
                <button type="button" onclick="redirectToactivitylist()">Back</button> 
            </form>
        </div>
    </div>

    <script>
        function submitForm() {
            const form = document.getElementById('activitiesForm');
            const formData = new FormData(form);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    window.location.href = 'publicationlist.php';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function redirectToactivitylist() {
            window.location.href = 'publicationlist.php';
        }
    </script>
</body>
</html>
