<?php

require_once "./functions.php";
require_once "./connection.php";

session_start();

$keyword = isset($_GET['search']) ? $_GET['search'] : '';
$dataPerPage = 3;
$activePage = isset($_GET['page']) ? $_GET['page'] : 1;
$dataStart = ($activePage - 1) * $dataPerPage;
$totalData = (int) mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM books WHERE title LIKE '%$keyword%'"))[0];
$totalPage = ceil($totalData / $dataPerPage);

if ($activePage > $totalPage && $totalPage > 0) {
    header("location: ?search=$keyword&page=1");
    exit;
}

if ($activePage < 1) {
    header("location: ?search=$keyword&page=1");
    exit;
}

if ($totalData != 0) {
    $books = mysqli_fetch_all(mysqli_query($conn, ("SELECT * FROM books  WHERE title LIKE '%$keyword%' LIMIT $dataStart, $dataPerPage")), MYSQLI_ASSOC);
} else {
    $books = [];
}

$categories = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM categories"), MYSQLI_ASSOC);

?>

<?php require_once "layouts/header.php" ?>

<section class="mt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="filter-card">
                    <h5 class="mt-3 fw-bold">Kategori</h5>
                    <label class="d-block mb-2">
                        <input class="form-check-input me-1" type="checkbox" value="" checked>
                        Semua Kategori
                    </label>
                    <?php foreach ($categories as $key => $category) : ?>
                        <label class="d-block mb-2">
                            <input class="form-check-input me-1" type="checkbox" value="">
                            <?= $category['name'] ?>
                        </label>
                    <?php endforeach; ?>

                    <h5 class="mt-4 fw-bold">Urutkan</h5>
                    <ul class="nav flex-column">
                        <label class="nav-item mb-2 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sortByRadio" id="sortByRadio1" checked>
                                <label class="form-check-label" for="sortByRadio1">
                                    Paling Relevan
                                </label>
                            </div>
                        </label>
                        <label class="nav-item mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sortByRadio" id="sortByRadio2">
                                <label class="form-check-label" for="sortByRadio2">
                                    Terbaru
                                </label>
                            </div>
                        </label>
                        <label class="nav-item mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sortByRadio" id="sortByRadio3">
                                <label class="form-check-label" for="sortByRadio3">
                                    Paling Murah
                                </label>
                            </div>
                        </label>
                        <label class="nav-item mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sortByRadio" id="sortByRadio4">
                                <label class="form-check-label" for="sortByRadio4">
                                    Paling Mahal
                                </label>
                            </div>
                        </label>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="text-secondary" style="font-size: 0.9em;">Menampilkan 1-10 dari 100 hasil</p>
                    </div>
                    <div class="col-md-6">
                        <form class="d-flex" action="" method="get">
                            <input class="form-control me-2 rounded-pill py-2 border-0" value="<?= $keyword ?>" name="search" type="search" style="font-size: 0.9em;" placeholder="Search" aria-label="Search">
                            <button class="btn btn-primary rounded-pill px-4 py-2" style="font-size: 0.9em;" type="submit">Search</button>
                        </form>
                    </div>
                </div>
                <div class="row mt-4">
                    <?php foreach ($books as $book) : ?>
                        <div class="col-6 col-sm-4 col-lg-3 mb-4">
                            <div class="product-card">
                                <a href="product.php?p=<?= $book['slug'] ?>"><img src="<?= base_url('img/books/') . $book['thumbnail'] ?>" alt="Buku 1"></a>
                                <a href="product.php?p=<?= $book['slug'] ?>" class="text-decoration-none">
                                    <h6 class="text-dark fw-bold mt-4"><?= $book['title'] ?></h6>
                                </a>
                                <p class="text-secondary mb-0">Rp <?= $book['price'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($books)) : ?>
                        <div class="col d-flex justify-content-center align-items-center" style="min-height: 300px;">
                            <div class="text-center">
                                <img src="<?= base_url('img/no-item.svg') ?>" style="max-width:200px;" class="mb-3">
                                <h3>Gak ada :(</h3>
                            </div>
                        </div>
                    <?php endif; ?>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php if ($activePage > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?search=<?= $keyword ?>&page=<?= $activePage - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                <li class="page-item<?= $i == $activePage ? ' active' : '' ?>"><a class="page-link" href="?search=<?= $keyword ?>&page=<?= $i ?>"><?= $i ?></a></li>
                            <?php endfor; ?>
                            <?php if ($activePage < $totalPage) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?search=<?= $keyword ?>&page=<?= $activePage + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once "layouts/footer.php" ?>