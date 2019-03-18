<?php
session_start();
include_once 'pages/classes.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Shop Dream</title>
</head>
<body>
<div class="container">
    <div class="row">
        <header class="col-md-12">

        </header>
    </div>
    <div class="row">
        <nav class="col-md-12">
            <?php include_once 'pages/menu.php' ?>
        </nav>
    </div>
    <div class="row">
        <section class="col-md-12 ">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if ($page == 1) {
                    include_once 'pages/tours.php';
                } else if ($page == 2) {
                        include_once 'pages/comments.php';
                } else if ($page == 3) {
                    include_once 'pages/registration.php';
                } else if ($page == 4) {
                    include_once 'pages/admin.php';
                }
            }
            ?>
        </section>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>