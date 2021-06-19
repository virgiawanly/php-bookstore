<?php

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['user']['role'] != 'Admin') {
    header("Location: ../index.php");
    exit;
}
require_once "../connection.php";
require_once "../functions.php";
if (!isset($active_page)) {
    $active_page = "";
}


$userId = $_SESSION['user']['id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$userId'"));

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <title>Literazie</title>

    <style>
        * {
            font-family: Poppins, sans-serif;
        }

        body {
            background: url("../img/bg.png"), #F6F8FD;
            background-repeat: repeat;
            background-size: 35px;
            padding: 20px;
        }

        .btn-light {
            background-color: #E5E9F2;
            border-color: #E5E9F2;
            color: #34364A;
        }

        .btn-light:hover {
            background-color: #d8dbe3;
            border-color: #d8dbe3;
            color: #34364A;
        }

        .btn-light:focus {
            border-color: #d8dbe3;
            background-color: #d8dbe3;
        }

        #sidebar {
            background-color: #ffffff;
            border-radius: 20px;
            position: fixed;
            top: 30px;
            bottom: 30px;
            left: 30px;
            right: 75%;
            overflow-y: scroll;
            -webkit-transition: 0.3s ease-out;
            -moz-transition: 0.3s ease-out;
            -o-transition: 0.3s ease-out;
            transition: 0.3s ease-out;
        }

        #sidebar .nav a span {
            color: #6C757D;
        }

        #sidebar .nav a {
            color: #aeafbd;
            font-weight: 400;
            -webkit-transition: .3s ease-out;
            -moz-transition: .3s ease-out;
            -o-transition: .3s ease-out;
            transition: .3s ease-out;
        }

        #sidebar .nav a.active i {
            border-color: #0D6EFD;

        }

        #sidebar .nav a:hover span,
        #sidebar .nav a.active span {
            color: #34364A;
        }

        #sidebar .nav a.active i {
            color: #0D6EFD;
        }

        #content-wrapper {
            width: 75%;
        }

        .card {
            border: none;
            border-radius: 25px;
        }

        form .form-control::placeholder {
            font-size: 0.8em !important;
        }

        form .form-group label {
            font-size: 0.8em;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .inputThumbnailLabel {
            transition: .3s;
        }

        .inputThumbnailLabel:hover {
            opacity: .8;
        }

        @media screen and (max-width: 768px) {
            #sidebar-wrapper {
                display: none;
            }

            #content-wrapper {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="row">
        <div class="col-md-3 col-sm-0" id="sidebar-wrapper">
            <div class="px-3 py-5" id="sidebar">

                <div class="px-3 pb-3">
                    <img src="<?= base_url('img/avatar/default-avatar.svg') ?>" style="max-width: 75px; max-height:75px; border-radius: 100%;" alt="">
                    <h6 style="font-weight: bold;" class="text-dark mt-4"><?= $user['name'] ?></h6>
                    <p class="text-secondary" style="font-size: 0.9em;"><?= $user['role'] ?></p>
                </div>

                <!-- Sidebar Items -->
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="<?= base_url() ?>" class="nav-link my-2 py-2"><i class="fas fa-fw fa-home me-2"></i> <span>Home</span></a></li>
                    <li class="nav-item">
                        <a href="index.php" class="nav-link my-2 py-2<?= ($active_page == '' ? ' active' : ''); ?>"><i class="fas fa-fw fa-tachometer-alt me-2"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="nav-item"><a href="books.php" class="nav-link my-2 py-2<?= ($active_page == 'books' ? ' active' : ''); ?>"><i class="fas fa-fw fa-book me-2"></i> <span>Buku</span></a></li>
                    <li class="nav-item"><a href="categories.php" class="nav-link my-2 py-2<?= ($active_page == 'categories' ? ' active' : ''); ?>"><i class="fas fa-fw fa-tags me-2"></i> <span>Kategori</span></a></li>

                    <li class="nav-item"><a href="orders.php" class="nav-link my-2 py-2<?= ($active_page == 'orders' ? ' active' : ''); ?>"><i class="fas fa-fw fa-shopping-bag me-2"></i> <span>Order</span></a></li>
                    <li class="nav-item"><a type="button" data-bs-toggle="modal" data-bs-target="#logoutModal" class="nav-link my-1 py-2"><i class="fas fa-fw fa-sign-out-alt me-2"></i> <span>Logout</span></a></li>

                </ul>
            </div>
        </div>
        <div class="col-sm-12 col-md-9 mt-3" id="content-wrapper">