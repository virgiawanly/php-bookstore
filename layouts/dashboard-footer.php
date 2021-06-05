</div>
</div>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <form action="<?= base_url('logout.php') ?>" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-primary" name="logout" value="true">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap CSS -->
<script src="js/bootstrap.min.js"></script>

<!-- Fontawesome -->
<script src="https://kit.fontawesome.com/536d761c41.js" crossorigin="anonymous"></script>

</body>

</html>