<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Manage Publication</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #040454;
            background-size: cover;
            
        }


        .container {
            display: flex;
            margin-top: -190px; 
            margin-left: 150px; 
            display: flex;
            flex-direction: column;
            width: 100%;
            margin-left: 50px;
            
        }

        h2{
            color: white;
        }

        .btn {
    display: inline-block;
    padding: 10px 15px;
    margin: 10px 0;
    text-decoration: none;
    color: #fff; /* Change text color to white for better contrast */
    background-color: #bf0000;
    border-radius: 5px;
    transition: background-color 0.3s, box-shadow 0.3s;
    font-weight: bold; /* Bold text for emphasis */
    font-size: 16px; /* Slightly larger font size */
}

        .delete-btn {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px 0;
            text-decoration: none;
            background-color: #f44336;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .delete-btn:hover {
            background-color: #00a86b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Added margin-top to separate table from content */
            border-radius: 8px; /* Added border-radius for rounded corners */
            overflow: hidden; /* Added overflow for rounded corners */
            color: blacks;
        }

        table th{
            color: white;
        }

        table th,
        table td {
            padding: 12px;
            border: 2px solid #ccc;
            text-align: left;
        }

        table th,
        table td {
            transition: background-color 0.3s;
        }

        table th:hover,
        table td:hover {
            background-color: none;
        }

        .jumbotron {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: auto; /* Center the jumbotron horizontally */
            margin-top: 20px;
            width: 80%; /* You can adjust the width as needed */
        }

        .sidebar a:first-child {
            margin-top: 20px; /* Provide space between hamburger and Home button */
        }

        .form-control {
    /* Ensure the input takes the full width of its container */
    padding: 10px 15px; /* Add padding inside the input */
    margin: 10px 0; /* Add some margin for spacing */
    font-size: 16px; /* Increase font size */
    border: 2px solid #ddd; /* Light gray border */
    border-radius: 5px; /* Rounded corners */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for a 3D effect */
    transition: border-color 0.3s, box-shadow 0.3s; /* Smooth transition for border and shadow */
}
    </style>
    </style>
</head>

<body>

<?php
    include 'config.php';
    session_start();
    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)) {
        header('location:login.php');
        exit();
    }

    if (isset($_GET['logout'])) {
        unset($user_id);
        session_destroy();
        header('location:login.php');
        exit();
    }

    $connection = mysqli_connect("localhost", "root", "", "skcon");

    // Check if the search form is submitted
    if(isset($_GET['search']) && !empty($_GET['search'])) {
        $searchKeyword = $_GET['search'];
        $query = "SELECT * FROM publicationarchive WHERE 
                   title LIKE '%$searchKeyword%'";
    } else {
        // If search box is empty, show all data
        $query = "SELECT * FROM publicationarchive";
    }

    $query_run = mysqli_query($connection, $query);
?>
    
    <div class="container">
<div class="navbar" style="background-color: #040454; color: white; text-align: right; padding: 10px;">
    <a href="activitydashboard.php" style="color: white; text-decoration: none; margin-left: 20px;">Activity Dashboard</a>
    <a href="announcementdashboard.php" style="color: white; text-decoration: none; margin-left: 20px;">Announcement Dashboard</a>
    <a href="publicationdashboard.php" style="color: white; text-decoration: none; margin-left: 20px;">Publication Dashboard</a>
    <a href="dashboard.php" style="color: white; text-decoration: none; margin-left: 20px;">Home</a>
</div>

    <div class="row">
        <div class="col-md-7">
            <h2>Publication Archive list</h2>
            
            <div class="col-md-12">
            <div class="col-md-7">
            <div class="col-md-12">
                </a>
                <!-- Three new buttons -->
                <button class="btn btn-primary" id="skBtn">Sk Archive</button>
                <button class="btn btn-primary" id="publicationBtn">Publication Archive</button>
                <button class="btn btn-primary" id="announcementBtn">Announcement Archive</button>
                <button class="btn btn-primary" id="activityBtn">Activity Archive</button>
                <button class="btn btn-primary" id="homeBtn">Home</button>
                <hr>
            </div>
        </div>
    </div>
</div>
        </div>

        <div class="row">
            <!-- Search form -->
            <form action="" method="GET">
                <div class="input-group mb-3">
                    <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search Data">
                    <button type="submit" class="btn btn-primary">Search</button> 
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered" style="background-color: #ffa500;">
    <thead class="table-dark">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if($query_run) {
            while($row = mysqli_fetch_array($query_run)) {
        ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['date']; ?></td>
        </tr>
        <?php
            }
        } else {
        ?>
        <tr>
            <td colspan="5">No Record Found</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    // JavaScript to handle button clicks
    document.addEventListener('DOMContentLoaded', function() {
        // Get button elements
        const skBtn = document.getElementById('skBtn');
        const publicationBtn = document.getElementById('publicationBtn');
        const announcementBtn = document.getElementById('announcementBtn');
        const activityBtn = document.getElementById('activityBtn');
        const homeBtn = document.getElementById('homeBtn');

        skBtn.addEventListener('click', function() {
            // Redirect to the publication archive page
            window.location.href = 'archive.php';
        });
        // Add event listeners to buttons
        publicationBtn.addEventListener('click', function() {
            // Redirect to the publication archive page
            window.location.href = 'pubarchive.php';
        });

        announcementBtn.addEventListener('click', function() {
            // Redirect to the announcement archive page
            window.location.href = 'announcementarchive.php';
        });

        activityBtn.addEventListener('click', function() {
            // Redirect to the activity archive page
            window.location.href = 'activityarchive.php';
        });

        
        homeBtn.addEventListener('click', function() {
            // Redirect to the activity archive page
            window.location.href = 'dashboard.php';
        });
    });
</script>

</body>
</html>
