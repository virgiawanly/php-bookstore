<?php

session_start();
require_once "connection.php";
require_once "functions.php";

// If user has logged in
if (isset($_SESSION['login'])) {
    // Redirect to 
    if ($_SESSION['user']['role'] == 'Admin') {
        header("Location: admin/index.php");
        exit;
    } else {
        header("Location: admin/index.php");
        exit;
    }
}

if (isset($_POST['login'])) {
    $email = filter_var(strtolower($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST['password']);
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE `email` = '$email'"));

    // Check email
    if ($user != null) {
        // Check Password
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'avatar' => $user['avatar'],
            ];

            if ($user['role'] == 'Admin') {
                header("Location: admin/index.php");
                exit;
            } else {
                header("Location: index.php");
                exit;
            }
            exit;
        } else {
            setFlash("alert", "Wrong Password", "danger");
            header("Location: login.php");
            exit;
        }
    } else {
        setFlash("alert", "Email not found", "danger");
        header("Location: login.php");
        exit;
    }
}

?>

<?php require_once "layouts/header.php" ?>

<div class="container">
    <div class="row">
        <div class="col-lg-6 mx-auto">

            <div class="card px-2 py-4">
                <div class="card-body">
                    <div class="text-center">
                        <h1 class="h3 mt-3 mb-4"><img class="w-25 mb-4" src="<?= base_url('img/literazie-logo.svg') ?>" alt=""></h1>
                    </div>
                    <?php getFlash('alert') ?>
                    <form action="" method="POST">

                        <!-- Email input -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="email">Email address</label>
                            <input type="email" id="email" name="email" value="" class="form-control">
                        </div>

                        <!-- Password input -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>

                        <!-- Submit button -->
                        <button type="submit" style="font-size: 0.9em" name="login" class="btn btn-primary btn-block mb-4 py-2 mt-3 w-100">Login</button>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p style="font-size: 0.9em;">Belum punya akun? <a href="<?= base_url('register.php') ?>" class="link">Daftar</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "layouts/footer.php" ?>