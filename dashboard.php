<?php

// Start the session
session_start();
if(!isset($_SESSION['user'])) header('location:login.php');
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        SA HomePage - Stock-Aid
    </title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="https://kit.fontawesome.com/199857ee6e.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="dashboardMainContainer">
     <?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dasboard_content_container">
         <?php include('partials/app-topNav.php') ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">

                </div>
            </div>
        </div>

    </div>

    <script src="js/script.js"></script>
</body>

</html>