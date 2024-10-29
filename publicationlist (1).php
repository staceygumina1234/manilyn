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
            background-color: #040454;
            background-size: cover;
        }

        .container {
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
    border-radius: 5px;
    transition: background-color 0.3s, box-shadow 0.3s;
    font-weight: bold; /* Bold text for emphasis */
    font-size: 16px; /* Slightly larger font size */
}

/* Search button specific styling */
.btn-search {
    background-color: #007bff;
    color: #fff;
}

.btn-search:hover {
    background-color: #0056b3;
}

/* Print button specific styling */
.btn-print {
    background-color: #6c757d;
    color: #fff;
}

.btn-print:hover {
    background-color: #5a6268;
}

/* Edit button specific styling */
.btn-edit {
    background-color: #28a745;
    color: #fff;
}

.btn-edit:hover {
    background-color: #218838;
}

/* Delete button specific styling */
.btn-delete {
    background-color: #dc3545;
    color: #fff;
}

.btn-delete:hover {
    background-color: #c82333;
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

        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
            color: black;
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

        .jumbotron {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: auto;
            margin-top: 20px;
            width: 80%;
        }

        .sidebar a:first-child {
            margin-top: 20px;
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
        $query = "SELECT * FROM publication WHERE 
                   title LIKE '%$searchKeyword%'";
    } else {
        // If search box is empty, show all data
        $query = "SELECT * FROM publication";
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
            <h2>Publication list</h2>
            
            <div class="col-md-12">
            <a href="publication.php" class="btn btn-success" style="border-radius: 15px; background-color: green; padding: 5px 5px; font-size: 15px; text-transform: uppercase; letter-spacing: 1px; color: white;">
    <i class="fas fa-plus-circle" style="margin-right: 10px;"></i> Add publication
    </a>
    <hr style="border-top: 2px solid #ccc; margin-top: 20px;">
</div>
        </div>

        <div class="row">
            <!-- Search form -->
            <form action="" method="GET">
                <div class="input-group mb-3">
                <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search Data">
                    <button type="submit" class="btn btn-search">Search</button>   
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
            <button onclick="printTable()" class="btn btn-print">Print</button>
            <table class="table table-bordered" style="background-color: #ffa500;">
    <thead class="table-dark">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
            <th>Edit</th>
            <th>Delete</th>
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
            <td>
                <form action="edit_pub.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                    <button type="submit" name="edit" class="btn btn-edit"><i class="fas fa-edit"></i></button>
                </form>
            </td>
            <td>
            <form action="deletepub.php" method="post">
    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
    <button type="submit" name="delete_button" class="btn btn-delete"><i class="fas fa-trash-alt"></i></button>
</form>
            </td>
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
    function printTable() {
        const printContents = document.querySelector('.table').outerHTML;
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();  // To reload the page after printing and restore the original content
    }
</script>

</body>
</html> 