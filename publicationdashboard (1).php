<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activities Table</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: gainsboro;
        }
        .navbar {
            background-color: #040454;
            color: white;
            text-align: right;
            padding: 10px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .activity-item {
            background-color: whitesmoke;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .activity-item img {
            width: 400px;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }
        .activity-content {
            flex: 1;
        }
        .activity-title {
            font-size: 1.5em;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .activity-date {
            color: #777;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        .activity-description {
            font-size: 1em;
            margin-bottom: 10px;
            color: #555;
        }
        .activity-link {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
        }
        .activity-full-description {
            display: none;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="activitydashboard.php">Activity Dashboard</a>
        <a href="announcementdashboard.php">Announcement Dashboard</a>
        <a href="publicationdashboard.php">Publication Dashboard</a>
        <a href="dashboard.php">Home</a>
    </div>

    <div class="container">
        <h1>Activities</h1>
        <?php
            // Database connection
            $connection = mysqli_connect("localhost", "root", "", "skcon");
            if ($connection) {
                // Query to fetch data from the database
                $query = "SELECT * FROM publication";
                $result = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    // Output the data dynamically
                    echo '<div class="activity-item">';
                    echo '<img src="' . $row['attached_file'] . '" alt="Activity Image" class="activity-image">';
                    echo '<div class="activity-content">';
                    echo '<div class="activity-title">' . $row['title'] . '</div>';
                    echo '<div class="activity-date">Date: ' . $row['date'] . '</div>';
                    echo '<div class="activity-description">' . substr($row['description'], 0, 100) . '...</div>';
                    echo '<div class="activity-full-description">' . $row['description'] . '</div>';
                    echo '<span class="activity-link" onclick="toggleDescription(this)">Read more</span>';
                    echo '</div>';
                    echo '</div>';
                }

                // Free result set
                mysqli_free_result($result);
                // Close connection
                mysqli_close($connection);
            } else {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
        ?>
    </div>

    <script>
        function toggleDescription(element) {
            var fullDescription = element.previousElementSibling;
            if (fullDescription.style.display === "none" || fullDescription.style.display === "") {
                fullDescription.style.display = "block";
                element.textContent = "Read less";
            } else {
                fullDescription.style.display = "none";
                element.textContent = "Read more";
            }
        }
    </script>
</body>
</html>
