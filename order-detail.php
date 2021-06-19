<?php


require_once "./functions.php";
require_once "./connection.php";

session_start();
if (!isset($_GET['order']) || !isset($_SESSION['login'])) {
    header("location: my-orders.php");
    exit;
}

$order_number = $_GET['order'];
$order = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE order_number = '$order_number'"));
if (empty($order)) {
    header("location: my-orders.php");
    exit;
}

$userLoginId = $_SESSION['user']['id'];
$userLogin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$userLoginId'"));
if ($order['user_id'] != $_SESSION['user']['id']) {
    header("location: my-orders.php");
    exit;
}

$user_id = $order['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));

$order_id = $order['id'];
$books = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM book_order LEFT JOIN books ON book_order.book_id = books.id WHERE order_id = $order_id"), MYSQLI_ASSOC);

?>


<?php require_once "layouts/header.php" ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card p-3">
                <table class="table table-bordered">
                    <tr class="text-center">
                        <th colspan="2">Detail Pesanan</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="d-flex">
                                <?php foreach ($books as $book) : ?>
                                    <img src="img/books/<?= $book['thumbnail'] ?>" style="max-width:100px; object-fit: cover; border-radius:20px;" class="me-2" alt="">
                                <?php endforeach; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Nomor Order</th>
                        <td><?= $order['order_number'] ?></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><?= $user['name'] ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?= $order['address'] ?></td>
                    </tr>
                    <tr>
                        <th>Pengiriman</th>
                        <td><?= $order['courier'] ?></td>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <td>Rp <?= number_format($order['total_price'], 0, '.', '') ?> </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php
                            switch ($order['status']) {
                                case 'Payment':
                                    echo 'Menunggu pembayaran';
                                    break;
                                case 'Delivery':
                                    echo 'Dalam pengiriman';
                                    break;
                                default:
                                    echo 'Selesai';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <?php if ($order['status']) : ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bayarModal">
                        Bayar
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-none">
                <h5 class="modal-title" id="bayarModalLabel">Bayar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-5">
                <img src="img/pay.svg" alt="" style="width: 150px;">
                <h6 class="mt-5">Silahkan hubungi Whatsapp</h6>
                <a href="https://web.whatsapp.com" target="_blank" class="text-decoration-none text-dark">
                    <h6 class="fw-bold">081 222 333 444</h6>
                </a>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-primary btn-lg mx-auto" data-bs-dismiss="modal">Oke</button>
            </div>
        </div>
    </div>
</div>

<?php require_once "layouts/footer.php" ?>