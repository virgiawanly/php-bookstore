<?php
session_start();
require_once "connection.php";
require_once "functions.php";
$active_page = 'profile';

?>

<?php require_once "layouts/dashboard-header.php" ?>


<div class="container text-center d-flex align-items-center justify-content-center" style="min-height: 90vh;">
    <div>
        <img src="<?= base_url('img/avatar/') . $_SESSION['user']['avatar'] ?>" style="width: 200px;" alt="">
        <h1 class="mt-4"><?= $_SESSION['user']['name'] ?></h1>
        <p class="mt-3"><?= $_SESSION['user']['email'] ?></p>
    </div>
</div>


<?php require_once "layouts/dashboard-footer.php" ?>