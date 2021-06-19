<?php


require_once "./functions.php";
require_once "./connection.php";

session_start();

$userId = $_SESSION['user']['id'];
$orderStatus = 'Payment';
$totalPrice = 0;
$books = [];
$error = false;

// Dapatkan total harga
foreach ($_POST['books'] as $key => $bookId) {
    $sql = "SELECT * FROM books WHERE id = '$bookId'";
    $data = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    // Jika buku dipilih
    if ($_POST['amount'][$key] != 0) {
        if (isset($_POST['selected'][$key])) {
            $data['amount'] = $_POST['amount'][$key];
            $books[] = $data;
        };
        $totalPrice += (int)$data['price'] * $_POST['amount'][$key];
    }
}

// Proses Order
if (isset($_POST['process_order'])) {
    $address = $_POST['jalan'] . " kel. " . $_POST['kelurahan'] . " kec. " . $_POST['kecamatan'] . ", " . $_POST['kota'] . ", " . $_POST['provinsi'] . " | " . $_POST['pos'];
    $message = $_POST['message'];
    $courier = $_POST['courier'];
    $orderNumber = "ORDER-" . random_int(10000000, 99999999);
    $sql = "INSERT INTO orders (`user_id`, `order_number`, `address`, `message`, `courier`, `total_price`, `status`) VALUES ('$userId', '$orderNumber', '$address', '$message', '$courier', '$totalPrice', '$orderStatus')";
    mysqli_query($conn,  $sql);

    // Tambahkan ke book_order
    $sql = [];
    $orderId = mysqli_insert_id($conn);
    foreach ($_POST['books'] as $key => $book) {
        $bookAmount = $_POST['amount'][$key];
        $sql[] = "INSERT INTO book_order (`order_id`, `book_id`, `amount`) VALUES ('$orderId', '$book', '$bookAmount');";
    }

    // Hapus Item dari Cart
    foreach ($_POST['books'] as $key => $book) {
        $bookAmount = $_POST['amount'][$key];
        $sql[] = "DELETE FROM carts WHERE `user_id` = '$userId' AND `book_id` = '$book';";
    }

    foreach ($sql as $s) {
        mysqli_query($conn, $s);
    }

    setFlash("alert", "Success", "success");
    header("Location: my-orders.php");
    exit;
}

?>


<?php require_once "layouts/header.php" ?>

<div class="container">
    <form action="" method="POST">
        <div class="row">

            <div class="col-md-4 order-first order-md-last mb-3">
                <div class="card p-3">
                    <div class="w-100 text-center my-4">
                        <h5 class="fw-600 d-inline"><i class="fas fa-shopping-cart me-1"></i> Checkout Buku </h5><small>[<a href="cart.php">edit</a>]</small>
                    </div>
                    <table class="table">
                        <?php foreach ($books as $key => $book) : ?>
                            <input type="hidden" name="books[]" value="<?= $book['id'] ?>">
                            <input type="hidden" name="amount[]" value="<?= $book['amount'] ?>">
                            <tr>
                                <td>
                                    <img src="img/books/<?= $book['thumbnail'] ?>" style="width: 50px; height: 75px; object-fit: cover;" class="me-3">
                                </td>
                                <td>
                                    <div class="fw-bold"><small><?= $book['amount'] ?> x <?= $book['title'] ?></small></div>
                                    <div style="font-size: 0.75em;" class="text-secondary"><?= substr($book['description'], 0, 50) ?></div>
                                </td>
                                <td style="min-width: 100px;">
                                    <small class="fw-bold">
                                        Rp <?= $book['price'] * $book['amount']  ?>
                                    </small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th colspan="2">Total</th>
                            <th>Rp <?= $totalPrice; ?></th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-8 order-last order-md-first">
                <div class="card p-4">

                    <div class="my-3">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">
                        <div class="form-group mb-3">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" disabled value="<?= $_SESSION['user']['name'] ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" id="" cols="30" rows="5">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Kaabupaten / Kota</label>
                            <input type="text" name="kota" class="form-control" id="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" id="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Kelurahan</label>
                            <input type="text" name="kelurahan" class="form-control" id="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Jalan</label>
                            <input type="text" name="jalan" class="form-control" id="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Kode POS</label>
                            <input type="text" name="pos" class="form-control" id="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" id="" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Pesan (Optional)</label>
                            <textarea name="message" class="form-control" id="" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Layanan Pengiriman</label>
                            <select name="courier" class="form-control" id="">
                                <option value="JNT">JNT</option>
                                <option value="JNE">JNE</option>
                                <option value="Gojek">Gojek</option>
                                <option value="NinjaExpress">NinjaExpress</option>
                            </select>
                        </div>
                    </div>
                    <div class="my-3">
                        <h6>Total :</h6>
                        <h3 class="fw-bold">Rp <?= $totalPrice ?></h3>
                    </div>
                    <button type="submit" name="process_order" class="btn btn-primary w-100">Buat Pesanan</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php require_once "layouts/footer.php" ?>