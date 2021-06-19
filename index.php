<?php

session_start();
require_once "functions.php";
$bestProducts = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM books LIMIT 3"), MYSQLI_ASSOC);

?>

<?php require_once "layouts/header.php" ?>

<header style="min-height: 85vh;" class="d-flex align-items-center">
    <div class="container">
        <!-- Desktop -->
        <div class="d-none d-md-block">
            <div class="row">
                <div class="col-lg-6 py-5">
                    <h1 style="color: #34364A;" class="mb-4 mb-lg-5 fw-bold">Distributor Buku Resmi dan Terbaik se-Smakzie</h1>
                    <p class="mb-4 mb-lg-5 lh-lg">Lorem ipsum dolor sit amet consectetur, adipisicing elit. A distinctio, molestiae et saepe sit perferendis voluptatibus nemo vel, alias in quia expedita, nesciunt culpa autem?</p>
                    <div class="row">
                        <div class="col-md-7">
                            <a href="shop.php" class="btn btn-primary rounded-pill w-100 mb-3" style="padding: 10px 40px">Belanja Sekarang!</a>
                        </div>
                        <div class="col-md-5">
                            <a class="btn rounded-pill w-100 btn-light" style="padding: 10px 40px;">Cara Order</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <img class="w-75" src="<?= base_url('img/header-image.svg') ?>" alt="">
                </div>
            </div>
        </div>

        <!-- Mobile -->
        <div class="d-block d-md-none">
            <div class="row text-center px-3">
                <div class="col-lg-6 py-5">
                    <h1 style="color: #34364A;" class="fw-bold mb-4 mb-lg-5 display-3">Distributor Buku Resmi dan Terbaik se-Smakzie</h1>
                    <p class="mb-4 mb-lg-5 lh-lg">Lorem ipsum dolor sit amet consectetur, adipisicing elit. A distinctio, molestiae et saepe sit perferendis voluptatibus nemo vel, alias in quia expedita, nesciunt culpa autem?</p>
                    <div class="row">
                        <div class="col-md-7">
                            <a href="shop.php" class="btn btn-primary rounded-pill w-100 mb-3" style="padding: 10px 40px">Belanja Sekarang!</a>
                        </div>
                        <div class="col-md-5">
                            <a class="btn rounded-pill w-100 btn-light" style="padding: 10px 40px;">Cara Order</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="mt-5">
    <div class="container pb-5">
        <div class="row justify-content-center text-center">
            <div class="col-md-5">
                <h2 style="color: #34364A;" class="fw-bold">Buku Paling Populer Sepanjang Tahun 2021</h2>
                <p class="text-secondary mt-3 mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam ea provident obcaecati pariatur.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($bestProducts as $p) : ?>
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="product-card">
                        <a href="product.php?p=<?= $p['slug'] ?>"><img src="<?= base_url('img/books/') . $p['thumbnail'] ?>" alt="Buku 1"></a>
                        <a href="product.php?p=<?= $p['slug'] ?>" class="text-decoration-none">
                            <h6 class="text-dark fw-bold mt-4"><?= $p['title'] ?></h6>
                        </a>
                        <p class="text-secondary mb-0">Rp <?= $p['price'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="mt-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-5">
                <h2 style="color: #34364A;" class="fw-bold">Tersedia Berbagai Kategori Buku!</h2>
                <p class="text-secondary mt-3 mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni et vitae qui, error id quia!</p>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-lg-2 col-sm-4 col-6 mb-4">
                <a href="" class="category-card">
                    <img src="<?= base_url('img/categories/c-novel.svg') ?>" alt="">
                    <h5 style="font-weight: bold;" class="mt-4">Novel</h5>
                </a>
            </div>
            <div class="col-lg-2 col-sm-4 col-6 mb-4">
                <a href="" class="category-card">
                    <img src="<?= base_url('img/categories/c-comic.svg') ?>" alt="">
                    <h5 style="font-weight: bold;" class="mt-4">Komik</h5>
                </a>
            </div>
            <div class="col-lg-2 col-sm-4 col-6 mb-4">
                <a href="" class="category-card">
                    <img src="<?= base_url('img/categories/c-technology.svg') ?>" alt="">
                    <h5 style="font-weight: bold;" class="mt-4">Teknologi</h5>
                </a>
            </div>
            <div class="col-lg-2 col-sm-4 col-6 mb-4">
                <a href="" class="category-card">
                    <img src="<?= base_url('img/categories/c-science.svg') ?>" alt="">
                    <h5 style="font-weight: bold;" class="mt-4">Sains</h5>
                </a>
            </div>
            <div class="col-lg-2 col-sm-4 col-6 mb-4">
                <a href="" class="category-card">
                    <img src="<?= base_url('img/categories/c-bussiness.svg') ?>" alt="">
                    <h5 style="font-weight: bold;" class="mt-4">Bisnis</h5>
                </a>
            </div>
            <div class="col-lg-2 col-sm-4 col-6 mb-4">
                <a href="" class="category-card">
                    <img src="<?= base_url('img/categories/c-language.svg') ?>" alt="">
                    <h5 style="font-weight: bold;" class="mt-4">Bahasa</h5>
                </a>
            </div>
            <div class="col-lg-2 col-sm-4 col-6 mb-4">
                <a href="" class="category-card">
                    <img src="<?= base_url('img/categories/c-geography.svg') ?>" alt="">
                    <h5 style="font-weight: bold;" class="mt-4">Geografi</h5>
                </a>
            </div>
            <div class="col-lg-2 col-sm-4 col-6 mb-4">
                <a href="" class="category-card">
                    <img src="<?= base_url('img/categories/c-history.svg') ?>" alt="">
                    <h5 style="font-weight: bold;" class="mt-4">Sejarah</h5>
                </a>
            </div>
        </div>

        <div class="mx-auto text-center">
            <a href="" class="btn btn-primary rounded-pill mb-5" style="padding: 10px 40px">Lihat Lainnya</a>
        </div>
    </div>
</section>

<section class="mt-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-5">
                <h2 style="color: #34364A;" class="mb-5 fw-bold">Testimonials</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="testimoni-card">
                    <img src="<?= base_url('img/iqbal.jpg') ?>" alt="">
                    <h5 class="mt-4 fw-bold">Iqbal Maulana Asyari</h5>
                    <p class="text-secondary">Pelajar SMK</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque quod quasi repellat ab veritatis. Sunt, quas laboriosam. Sint voluptatibus nulla eos id.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="testimoni-card">
                    <img src="<?= base_url('img/rajah.jpg') ?>" alt="">
                    <h5 class="mt-4 fw-bold">Rajah Rayvles Pangkey</h5>
                    <p class="text-secondary">Wibu</p>
                    <p>Jangan menghancurkan hati seseorang, mereka hanya memilikinya satu. Hancurkan saja tulang mereka, manusia memiliki 206 tulang.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="testimoni-card">
                    <img src="<?= base_url('img/padika.jpg') ?>" alt="">
                    <h5 class="mt-4 fw-bold">Sandhika Galih</h5>
                    <p class="text-secondary">Dosen & Youtuber</p>
                    <p>Halo temen-temen semua! apa kabar? Kembali lagi di channel Web Programming Unpas Bersama saya Sandhika Galih dan jangan lupa titik koma!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once "layouts/footer.php" ?>