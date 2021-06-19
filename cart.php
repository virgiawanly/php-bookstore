<?php

session_start();
require_once "connection.php";
require_once "functions.php";

// Jika belum login
if (!isset($_SESSION['login'])) {
    // Redirect
    header("Location: login.php");
    exit;
}

if (isset($_POST['remove-cart'])) {
    $bookId = $_POST['book-id'];
    $userId = $_SESSION['user']['id'];
    mysqli_query($conn, "DELETE FROM carts WHERE book_id = $bookId AND user_id = $userId");
    if (mysqli_affected_rows($conn) > 0) {
        setFlash('alert', "Item dihapus!");
    } else {
        setFlash('alert', "Terjadi kesalahan.", "danger");
    }
    header("Location: cart.php");
    exit;
}

$userId = $_SESSION['user']['id'];
$sql = "SELECT * FROM carts INNER JOIN books ON `carts`.`book_id` = `books`.`id` WHERE `user_id` = '$userId'";
$result = mysqli_query($conn, $sql);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<?php require_once "layouts/header.php" ?>

<div class="container">
    <?php if (!empty($books)) : ?>
        <div class="card px-5 py-3">
            <?php getFlash('alert') ?>
            <table class="table table-borderless table-sm">
                <form id="cartForm" action="checkout.php" method="post">
                    <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" class="form-check-input fs-4" checked onchange="toggleCheckAll(this)"></th>
                            <th scope="col" colspan="2">Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Menu</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($books as $book) : ?>
                            <input type="hidden" name="books[]" value="<?= $book['id'] ?>">
                            <tr class="cart-item align-middle">
                                <td scope="row"><input name="selected[]" type="checkbox" checked class="form-check-input select-book fs-4" onchange="updateFinalPrice()"></td>
                                <td>
                                    <img src="<?= base_url('img/books/') . $book['thumbnail'] ?>" style="width:100px; height:100px; object-fit: cover;" alt="">
                                </td>
                                <td><?= $book['title'] ?></td>
                                <td class="price" data-price="<?= $book['price'] ?>">Rp <?= $book['price'] ?></td>
                                <td>
                                    <div class="input-group">
                                        <div role="button" class="dcr-button btn btn-outline-primary">
                                            -
                                        </div>
                                        <input type="number" class="amount-value form-control rounded-0 text-center" name="amount[]" min="0" style="width:40px;" value="1">
                                        <div role="button" data-id="<?= $book['id'] ?>" class="incr-button btn btn-outline-primary">
                                            +
                                        </div>
                                    </div>
                                </td>
                                <td class="total-price">
                                    <!-- Total Price goes here -->
                                </td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-danger delete-modal-button" data-book-id="<?= $book['id'] ?>" onclick="changeDeleteId(event)" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        Hapus
                                    </button>

                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5"></td>
                            <td>
                                <h3 class="fw-bold final-price">
                                    <!-- Final Price goes here -->
                                </h3>
                            </td>
                            <?php if (!empty($books)) : ?>
                                <td><button type="submit" class="btn btn-primary">Checkout</button></td>
                            <?php endif; ?>
                        </tr>
                    </tfoot>
                </form>
            </table>

        </div>
    <?php else : ?>
        <div style="min-height: 70vh;" class="d-flex align-items-center justify-content-center">
            <div class="text-center">
                <?php getFlash('alert') ?>
                <img src="img/no-item.svg" class="mb-3" style="width: 200px;" alt="">
                <h2 class="my-3">Tidak ada item</h2>
                <a href="shop.php" class="btn btn-primary">Belanja Sekarang</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Hapus item dari cart?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="" method="post">
                    <input type="hidden" class="delete-book-id" name="book-id">
                    <button type="submit" name="remove-cart" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const items = document.querySelectorAll(".cart-item");
    console.log(items);
    let finalPrice = 0;
    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    });

    document.querySelectorAll(".price").forEach((p) => p.textContent = formatter.format(p.getAttribute('data-price')));

    const toggleCheckAll = (checkBox) => {
        if (checkBox.checked == true) {
            items.forEach((item) => {
                item.querySelector(".select-book").checked = true;
            })
        } else {
            items.forEach((item) => {
                item.querySelector(".select-book").checked = false;
            })
        }

        updateFinalPrice();
    }

    const updateFinalPrice = () => {
        finalPrice = 0;
        items.forEach((item) => {
            const totalPrice = item.querySelector(".total-price");
            const selectBox = item.querySelector(".select-book");
            if (selectBox.checked) {
                finalPrice += parseInt(totalPrice.value);
            }
        });
        document.querySelector(".final-price").textContent = formatter.format(finalPrice);
    }

    items.forEach((item) => {
        const incrBtn = item.querySelector(".incr-button");
        const amount = item.querySelector("input.amount-value");
        const dcrBtn = item.querySelector(".dcr-button");
        const price = item.querySelector(".price").getAttribute('data-price');
        const showTotalPrice = item.querySelector(".total-price");

        const updateTotalPrice = () => {
            let value = parseInt(amount.value);
            if (amount.value == '') value = 0;
            showTotalPrice.textContent = formatter.format(parseInt(price) * value);
            showTotalPrice.value = parseInt(price) * value;
            updateFinalPrice();
        }

        incrBtn.addEventListener('click', () => {
            if (amount.value == '') amount.value = 0;
            amount.value = parseInt(amount.value) + 1;
            updateTotalPrice();
        })

        dcrBtn.addEventListener('click', () => {
            if (amount.value == '') {
                amount.value = 0;
                updateTotalPrice();
            }
            if (amount.value > 0) {
                amount.value = parseInt(amount.value) - 1;
            }
            updateTotalPrice();
        })

        amount.addEventListener('keyup', updateTotalPrice);
        amount.addEventListener('change', updateTotalPrice);
        updateTotalPrice();
    });

    // Modal Hapus Buku
    const changeDeleteId = (event) => {
        let bookId = event.target.getAttribute('data-book-id');
        document.querySelector('input.delete-book-id').value = bookId;
    }
</script>

<?php require_once "layouts/footer.php" ?>