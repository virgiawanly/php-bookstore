<?php

require_once "./functions.php";
require_once "./connection.php";

$books = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM books"), MYSQLI_ASSOC);
$categories = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM categories"), MYSQLI_ASSOC);

?>

<?php require_once "layouts/header.php" ?>

<section class="mt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="filter-card">
                    <h5 style="font-weight: bold;" class="mt-3">Kategori</h5>
                    <?php foreach ($categories as $key => $category) : ?>
                        <label class="d-block mb-2">
                            <input class="form-check-input me-1" type="checkbox" value="">
                            <?= $category['name'] ?>
                        </label>
                    <?php endforeach; ?>

                    <!-- <div class="collapse" id="categoryCollapse">
                        <label class="d-block mb-2">
                            <input class="form-check-input me-1" type="checkbox" value="">
                            Sejarah
                        </label>
                        <label class="d-block mb-2">
                            <input class="form-check-input me-1" type="checkbox" value="">
                            Sains
                        </label>
                    </div>
                    <a class="text-primary" style="font-size: 0.9em; text-decoration: none;" data-bs-toggle="collapse" href="#categoryCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Lainnya
                    </a> -->

                    <h5 style="font-weight: bold;" class="mt-4">Urutkan</h5>
                    <ul class="nav flex-column">
                        <label class="nav-item mb-2 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sortByRadio" id="sortByRadio1">
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
                        <form class="d-flex">
                            <input class="form-control me-2 rounded-pill py-2" type="search" style="font-size: 0.9em; border:none;" placeholder="Search" aria-label="Search">
                            <button class="btn btn-primary rounded-pill px-4 py-2" style="font-size: 0.9em;" type="submit">Search</button>
                        </form>
                    </div>
                </div>
                <div class="row mt-4">
                    <?php foreach ($books as $book) : ?>
                        <div class="col-6 col-sm-4 col-lg-3 mb-4">
                            <div class="product-card">
                                <a href=""><img src="<?= base_url('img/books/') . $book['thumbnail'] ?>" alt="Buku 1"></a>
                                <a href="" class="text-decoration-none">
                                    <h6 style="font-weight: bold;" class="text-dark mt-4"><?= $book['title'] ?></h6>
                                </a>
                                <p class="text-secondary mb-0">Rp <?= $book['price'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once "layouts/footer.php" ?>