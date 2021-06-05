<?php

session_start();
require_once "connection.php";
require_once "functions.php";

if (isset($_POST['register'])) {
	$name = htmlspecialchars($_POST['name']);
	$email = filter_var(strtolower($_POST['email']), FILTER_SANITIZE_EMAIL);
	$password = htmlspecialchars($_POST['password']);
	$passconf = htmlspecialchars($_POST['passconf']);
	$role = 'User';

	// Cek apakah email sudah terdaftar
	$user = mysqli_query($conn, "SELECT * FROM users WHERE `email` = '$email'");
	if (mysqli_fetch_assoc($user)) {
		setFlash("alert", "This email already registered", "danger");
		header("Location: register.php");
		exit;
	}

	// Validasi Password
	if ($password != $passconf) {
		setFlash("alert", "Konfirmasi Password tidak sesuai!", "danger");
		header("Location: register.php");
		exit;
	}

	// Hash Password
	$newPass = password_hash($password, PASSWORD_DEFAULT);

	// Buat Akun
	$sql = "INSERT INTO users (`name`, `email`, `password`, `role`) VALUES('$name', '$email', '$newPass', '$role')";
	mysqli_query($conn, $sql);


	if (mysqli_affected_rows($conn) > 0) {
		setFlash("alert", "Akun berhasil dibuat, silahkan login!.", "success");
		header("Location: login.php");
		exit;
	} else {
		setFlash("alert", "Error", "danger");
		// header("Location: register.php");
		// exit;
	}
}

?>

<?php require_once "layouts/header.php" ?>
<div class="container">

	<div class="row">
		<div class="col-md-6 mx-auto">

			<div class="card px-2 py-4 my-5" style="max-width: 500px;">
				<div class="card-body">
					<div class="text-center">
						<h1 class="h3 mt-3 mb-4"><img class="w-25 mb-4" src="<?= base_url('img/literazie-logo.svg') ?>" alt=""></h1>
					</div>
					<?php getFlash('alert'); ?>
					<form action="" method="POST">
						<!-- Name input -->
						<div class="form-group mb-4">
							<label class="form-label" for="name">Nama</label>
							<input type="name" id="name" name="name" value="" required class="form-control" />
						</div>

						<!-- Email input -->
						<div class="form-group mb-4">
							<label class="form-label" for="email">Email</label>
							<input type="email" id="email" name="email" value="" required class="form-control" />
						</div>

						<!-- Password input -->
						<div class="form-group mb-4">
							<label class="form-label" for="password">Password</label>
							<input type="password" id="password" name="password" class="form-control" required />
						</div>

						<!-- Konfirmasi Password -->
						<div class="form-group mb-4">
							<label class="form-label" for="passconf">Konfirmasi Password</label>
							<input type="password" id="passconf" name="passconf" class="form-control" required />
						</div>

						<!-- Submit button -->
						<button type="submit" name="register" style="font-size: 0.9em;" class="btn btn-primary w-100 py-2 mb-4">Buat Akun</button>

						<!-- Login Link -->
						<div class="text-center mt-4">
							<p style="font-size: 0.9em;">Sudah punya akun? <a href="<?= base_url('login.php') ?>" class="link">Login</a></p>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>

<?php require_once "layouts/footer.php" ?>