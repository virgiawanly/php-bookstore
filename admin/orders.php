<?php

$active_page = "orders";
require_once "layouts/header.php";

if (isset($_POST['update-order-status'])) {
    $status = $_POST['status'];
    $order_id = $_POST['order-id'];

    $sql = "UPDATE orders SET status = '$status' WHERE id = '$order_id'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        setFlash("alert", "Order berhasil diupdate");
        echo "<script>window.location.href = 'orders.php';</script>";
        exit;
    }
}

$orders = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM orders"), MYSQLI_ASSOC);
$categories = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM categories"), MYSQLI_ASSOC);

?>


<div class="p-3 mb-3">
    <div>
        <h3 style="font-weight: bold;">Order</h3>
    </div>
</div>

<div class="card p-4">
    <?php getFlash('alert') ?>
    <table class="table table-sm table-borderless align-middle">
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
                    <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                    <td>
                        <?php $orderId = $order['id'] ?>
                        <?php $bookOrder = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM book_order LEFT JOIN books ON book_order.book_id = books.id WHERE order_id = '$orderId'"), MYSQLI_ASSOC); ?>
                        <?php foreach ($bookOrder as $book) : ?>
                            <a href="product.php?p=<?= $book['slug'] ?>"><img src="<?= base_url('img/books/') . $book['thumbnail'] ?>" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" alt=""></a>
                        <?php endforeach ?>
                    </td>
                    <td><?= $order['total_price'] ?></td>
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

                        <button type="button" class="btn btn-success rounded-pill" data-bs-toggle="modal" data-bs-target="#statusOrder<?= $order['id'] ?>">
                            Ubah status
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="statusOrder<?= $order['id'] ?>" tabindex="-1" aria-labelledby="statusOrder<?= $order['id'] ?>Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="" method="post">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="statusOrder<?= $order['id'] ?>Label">Ubah status pesanan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="hidden" name="order-id" value="<?= $order['id'] ?>">
                                                <label for="status<?= $order['id'] ?>">Status Pesanan</label>
                                                <select name="status" id="status<?= $order['id'] ?>" class="form-control" id="">
                                                    <option value="Payment" <?= $order['status'] == 'Payment' ? ' selected' : '' ?>>Pembayaran</option>
                                                    <option value="Delivery" <?= $order['status'] == 'Delivery' ? ' selected' : '' ?>>Pengiriman</option>
                                                    <option value="Received" <?= $order['status'] == 'Received' ? ' selected' : '' ?>>Diterima</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="update-order-status">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>

<?php require_once "layouts/footer.php" ?>