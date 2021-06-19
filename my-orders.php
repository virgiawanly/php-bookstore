<?php
session_start();
require_once "connection.php";
require_once "functions.php";
$active_page = 'order';

$userId =  $_SESSION['user']['id'];
$sql = "SELECT * FROM orders WHERE user_id = '$userId'";
$result = mysqli_query($conn, $sql);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<?php require_once "layouts/dashboard-header.php" ?>

<h3 style="font-weight: bold;" class="ms-4 mb-4">Pembelian</h3>

<div class="container">
    <div class="card p-3">
        <table class="table table-borderless" style="font-size: 0.9em;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nomor</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Buku</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col">Status</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $key => $order) : ?>
                    <tr class="align-middle">
                        <th scope="row"><?= $key + 1 ?></th>
                        <td><?= $order['order_number'] ?></td>
                        <td><?= date('d-m-y', strtotime($order['created_at'])) ?></td>
                        <td>
                            <?php $orderId = $order['id'] ?>
                            <?php $bookOrder = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM book_order LEFT JOIN books ON book_order.book_id = books.id WHERE order_id = '$orderId'"), MYSQLI_ASSOC); ?>
                            <?php foreach ($bookOrder as $book) : ?>
                                <a href="product.php?p=<?= $book['slug'] ?>"><img src="<?= base_url('img/books/') . $book['thumbnail'] ?>" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" alt=""></a>
                            <?php endforeach ?>
                        </td>
                        <td>Rp <?= $order['total_price'] ?></td>
                        <td>
                            <?php
                            switch ($order['status']) {
                                case 'Payment':
                                    echo 'Pembayaran';
                                    break;
                                case 'Delivery':
                                    echo 'Pengiriman';
                                    break;
                                default:
                                    echo 'Selesai';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="order-detail.php?order=<?= $order['order_number'] ?>" class="btn btn-light rounded-pill">Detail</a>
                            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#bayarModal">
                                Bayar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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

<?php require_once "layouts/dashboard-footer.php" ?>