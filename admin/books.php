<?php

$active_page = "books";
require_once "layouts/header.php";

$books = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM books"), MYSQLI_ASSOC);
$categories = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM categories"), MYSQLI_ASSOC);

?>


<div class="p-3 mb-3">
    <div class="d-flex align-items-center justify-content-between">
        <h3 style="font-weight: bold;">Buku</h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertBook">
            Tambah Buku
        </button>
    </div>
</div>

<div class="card p-4">
    <table class="table table-sm table-borderless align-middle">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Cover</th>
                <th scope="col">Judul</th>
                <th scope="col">Penulis</th>
                <th scope="col">Penerbit</th>
                <th scope="col">Kategori</th>
                <th scope="col">Harga</th>
                <th scope="col">Stok</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $index => $book) : ?>
                <tr style="font-size: 0.8em;">
                    <th class="px-3" scope="row"><?= $index + 1 ?></th>
                    <td><img loading="lazy" style="width:50px; height:50px; border-radius:25%; object-fit: cover; object-position: center;" src="<?= base_url('img/books/') . $book['thumbnail'] ?>" alt=""></td>
                    <td><b><?= $book['title'] ?></b></td>
                    <td><?= $book['writer'] ?></td>
                    <td><?= $book['publisher'] ?></td>
                    <td>
                        <?php
                        foreach ($categories as $category) {
                            if ($category['id'] == $book['category_id']) {
                                echo $category['name'];
                            }
                        }
                        ?>
                    </td>
                    <td>Rp <?= $book['price'] ?></td>
                    <td><?= $book['stock'] ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-primary btn-sm my-1" data-bs-toggle="modal" data-bs-target="#editBookModal<?= $book['id'] ?>">
                            Edit
                        </button>
                        <!-- Delete Button -->
                        <button type="button" class="btn btn-danger btn-sm my-1" data-bs-toggle="modal" data-bs-target="#deleteBookModal" data-id="<?= $book['id'] ?>" onclick="changeDeleteBookId(this.dataset.id)">
                            Delete
                        </button>
                    </td>

                    <!-- Edit Book Modal -->
                    <div class="modal fade" id="editBookModal<?= $book['id'] ?>" tabindex="-1" aria-labelledby="editBookModal<?= $book['id'] ?>Label" aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 1000px;">
                            <div class="modal-content">
                                <form action="update-book.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" hidden name="id" value="<?= $book['id'] ?>">
                                    <input type="hidden" hidden name="currentThumbnail" value="<?= $book['thumbnail'] ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editBookModal<?= $book['id'] ?>Label">Modal title</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group text-center mb-4">
                                                    <label for="inputThumbnail<?= $book['id'] ?>" class="inputThumbnailLabel" style="cursor: pointer;">
                                                        <img src="<?= base_url('img/books/')  ?><?= ($book['thumbnail'] == null) ? 'default-cover.svg' : $book['thumbnail'] ?>" loading="lazy" id="thumbnailPreview<?= $book['id'] ?>" class="w-100 img-thumbnail" alt="">
                                                    </label>
                                                    <input type="file" name="thumbnail" class="d-none" id="inputThumbnail<?= $book['id'] ?>" data-preview="thumbnailPreview<?= $book['id'] ?>" onchange="previewImage(event)">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group mb-3">
                                                    <label for="">Judul</label>
                                                    <input type="text" name="title" class="form-control" value="<?= $book['title'] ?>" placeholder="Judul">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="">Slug</label>
                                                    <input type="text" name="slug" class="form-control" value="<?= $book['slug'] ?>" placeholder="Slug">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="">Deskripsi</label>
                                                    <textarea name="description" name="description" class="form-control" id="" cols="30" rows="7" placeholder="Deskripsi"><?= $book['description'] ?></textarea>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="">Penulis</label>
                                                    <input type="text" name="writer" class="form-control" value="<?= $book['writer'] ?>" placeholder="Penulis">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="">Penerbit</label>
                                                    <input type="text" name="publisher" class="form-control" value="<?= $book['publisher'] ?>" placeholder="Penerbit">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="">Tahun Terbit</label>
                                                    <input type="number" name="year" class="form-control" value="<?= $book['year'] ?>" placeholder="Tahun Terbit">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="">Harga</label>
                                                    <input type="text" name="price" class="form-control" value="<?= $book['price'] ?>" placeholder="Harga">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="">Stok</label>
                                                    <input type="number" name="stock" class="form-control" value="<?= $book['stock'] ?>" placeholder="Stok">
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Kategori</label>
                                                    <select class="categories-select form-control" name="category_id">
                                                        <?php foreach ($categories as $category) : ?>
                                                            <option value="<?= $category['id'] ?>" <?= ($category['id'] == $book['category_id']) ? 'selected' : '' ?>><?= $category['name'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Edit Book Modal -->

                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

</div>

<!-- Insert Book Modal -->
<div class="modal fade" id="insertBook" tabindex="-1" aria-labelledby="insertBookLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1000px;">
        <div class="modal-content">
            <form action="insert-book.php" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertBookLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group text-center mb-4">
                                <label for="inputThumbnail" class="inputThumbnailLabel" style="cursor: pointer;">
                                    <img src="<?= base_url('img/books/default-cover.svg') ?>" loading="lazy" id="thumbnailPreview" class="w-100 img-thumbnail" alt="">
                                </label>
                                <input type="file" name="thumbnail" class="d-none" id="inputThumbnail" data-preview="thumbnailPreview" onchange="previewImage(event)">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="">Judul</label>
                                <input type="text" name="title" class="form-control" placeholder="Judul">
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Slug</label>
                                <input type="text" name="slug" class="form-control" placeholder="Slug">
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Deskripsi</label>
                                <textarea name="description" name="description" class="form-control" id="" cols="30" rows="7" placeholder="Deskripsi"></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Penulis</label>
                                <input type="text" name="writer" class="form-control" placeholder="Penulis">
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Penerbit</label>
                                <input type="text" name="publisher" class="form-control" placeholder="Penerbit">
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Tahun Terbit</label>
                                <input type="number" name="year" class="form-control" placeholder="Tahun Terbit">
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Harga</label>
                                <input type="text" name="price" class="form-control" placeholder="Harga">
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Stok</label>
                                <input type="number" name="stock" class="form-control" placeholder="Stok">
                            </div>

                            <div class="form-group">
                                <label for="">Kategori</label>
                                <select class="categories-select form-control" name="category_id">
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Insert Book Modal -->

<!-- Delete Book Modal -->
<div class="modal fade" id="deleteBookModal" tabindex="-1" aria-labelledby="deleteBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Hapus?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="delete-book.php" method="POST" class="d-inline">
                    <input type="hidden" name="action" value="delete" hidden>
                    <input type="hidden" class="book-id" name="id" value="0" hidden>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- End Delete Book Modal -->

<script>
    function previewImage(event) {
        outputId = event.target.dataset.preview;
        var output = document.getElementById(outputId);
        output.src = URL.createObjectURL(event.target.files[0]);
    };

    function changeDeleteBookId(id) {
        console.log(id);
        document.querySelector("#deleteBookModal input.book-id").value = id;
        console.log(document.querySelector("#deleteBookModal input.book-id").value);
    }
</script>

<?php require_once "layouts/footer.php" ?>