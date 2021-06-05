<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">

    <title>LiteraZie</title>

    <style>
        * {
            font-family: Poppins, sans-serif;
        }

        body {
            background: url("img/bg.png"), #F6F8FD;
            background-repeat: repeat;
            background-size: 35px;
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

        .product-card {
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
            transition: .3s;
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-position: center;
            object-fit: cover;
            border-radius: 10px;
            transition: .3s;
        }

        .category-card {
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            padding-top: 40px;
            transition: .3s;
            text-align: center;
        }

        a.category-card {
            display: inline-block;
            text-decoration: none;
        }

        .category-card img {
            width: 75px;
            height: 75px;
            object-fit: cover;
            background-color: #fff;
            border-radius: 100%;
            transition: .3s;
        }

        .category-card:hover img,
        .product-card:hover img {
            opacity: .5;
        }

        .category-card h5,
        .product-card h5,
        .product-card h6,
        .testimoni-card h5,
        .filter-card h5,
        footer h5 {
            color: #34364A !important;
            text-decoration: none;
        }

        .testimoni-card {
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            transition: .3s;
        }

        .testimoni-card img {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border-radius: 100%;
        }

        .filter-card {
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            transition: .3s;
        }

        .filter-card label {
            font-size: 0.9em;
        }

        .card {
            border: none;
            border-radius: 20px;
            width: 100%;
        }


        form .form-control::placeholder {
            font-size: 0.8em !important;
        }

        form .form-group label {
            font-size: 0.8em;
            font-weight: 500;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container py-4">
            <a class="navbar-brand" href="#">
                <img src="<?= base_url('img/literazie-logo-simplified.svg') ?>" style="height:30px;" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-size: 0.9em;">
                    <li class="nav-item mx-3">
                        <a class="nav-link active" aria-current="page" href="<?= base_url() ?>">Home</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="<?= base_url('shop.php') ?>">Shop</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="#">Cara Order</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="#">Tentang Kami</a>
                    </li>
                </ul>
                <div>
                    <?php if (isset($_SESSION['login'])) : ?>
                        <form action="<?= base_url('logout.php') ?>" method="POST" class="d-inline">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 px-4" name="logout" value="true" style="font-size: 0.9em; background-color: #2447f9;">Logout</button>
                        </form>
                    <?php else : ?>
                        <a href="login.php" class="btn btn-primary rounded-pill py-2 px-4" style="font-size: 0.9em; background-color: #2447f9;">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>