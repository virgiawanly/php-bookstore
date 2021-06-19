<?php

require_once "./functions.php";
require_once "./connection.php";

session_start();
$slug = $_GET['p'];

$book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT books.*, categories.name AS category_name, categories.slug AS category_slug FROM `books` LEFT JOIN categories ON books.category_id = categories.id  WHERE books.slug = '$slug'"));

// Apakah ada aksi untuk menambahkan ke cart?
if (isset($_POST['addToCart'])) {
    // Cek apakah user sudah login?
    if (!isset($_SESSION['login'])) header("Location: login.php");

    // Tambahkan product ke cart
    $cart = addToCart($_POST['productId'], $_SESSION['user']['id']);

    // Cek Status
    if ($cart->success == true) {
        setFlash("alert", $cart->message);
    } else {
        setFlash("alert", $cart->message, "danger");
    }

    // Redirect
    header("Location: " . $_SERVER['PHP_SELF'] . "?p=" . $slug);
    exit;
}


if (!isset($_SESSION['login'])) {
    $cart = [];
} else {
    $userId = $_SESSION['user']['id'];
    $bookId = $book['id'];
    $cart = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM carts WHERE user_id = $userId AND book_id = $bookId"));
}

?>

<?php require_once "layouts/header.php" ?>

<section class="mt-5 pb-5">
    <div class="container">
        <?php getFlash('alert'); ?>
        <div class="row justify-content-center">
            <div class="col-md-3">
                <img src="img/books/<?= $book['thumbnail'] ?>" class="w-100" style="height:300px; object-fit: cover;" alt="">
            </div>
            <div class="col-md-5">
                <h5 class="my-3 fw-bold"><?= $book['title'] ?></h5>
                <p class="lh-1"><small>Penulis : <?= $book['writer'] ?></small></p>
                <p class="lh-1"><small>Penerbit : <?= $book['publisher'] ?></small></p>
                <p class="lh-1"><small>Tahun terbit : <?= $book['year'] ?></small></p>
                <p class="lh-1"><small>Kategori : <a href="shop.php?category=<?= $book['category_slug'] ?>"><?= $book['category_name'] ?></a></small></p>
                <p><?= $book['description'] ?></p>
                <?php if (empty($cart)) :  ?>
                    <form action="?p=<?= $book['slug'] ?>" method="POST">
                        <input type="hidden" name="productId" value="<?= $book['id'] ?>">
                        <button class="btn btn-primary mt-3" name="addToCart"><i class="fas fa-fw fa-plus-circle me-1"></i> Keranjang</button>
                    </form>
                <?php else : ?>
                    <a href="cart.php" class="btn btn-primary mt-3"><i class="fas fa-fw fa-shopping-bag me-1"></i> Lihat di Cart</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once "layouts/footer.php" ?>