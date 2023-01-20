<?php

$data = $mysqli->query("SELECT * FROM pengguna WHERE id=" . ($_GET['id'] ?? $_SESSION['user']['id']))->fetch_assoc();

if (isset($_POST['submit'])) {
    $password_baru = $mysqli->real_escape_string($_POST['password_baru']);

    if (isset($_GET['id'])) {
        $q = "UPDATE pengguna SET password='$password_baru' WHERE id=" . $data['id'];

        if ($mysqli->query($q))
            echo "<script>sessionStorage.setItem('tambah','Ganti Password Berhasil!.')</script>";
        else {
            echo "<script>alert('Ganti Password Gagal!')</script>";
            die($mysqli->error);
        }
    } else {
        $password_lama = $mysqli->real_escape_string($_POST['password_lama']);
        $konfirmasi_password_baru = $mysqli->real_escape_string($_POST['konfirmasi_password_baru']);
        if ($password_lama == $data['password']) {

            if ($password_baru == $konfirmasi_password_baru) {
                $q = "UPDATE pengguna SET password='$password_baru' WHERE id=" . $data['id'];

                if ($mysqli->query($q))
                    echo "<script>sessionStorage.setItem('tambah','Ganti Password Berhasil!.')</script>";
                else {
                    echo "<script>alert('Ganti Password Gagal!')</script>";
                    die($mysqli->error);
                }
            } else echo "<script>alert('Password Baru Tidak Sama!')</script>";
        } else echo "<script>alert('Password Lama Salah!')</script>";
    }
}

?>
<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 text-center mb-3">
                    <h3>Ganti Password</h3>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <div class="row match-height justify-content-center">
                <div class="col-md-6 col-xxl-4 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical" action="" method="POST">
                                    <div class="form-body">
                                        <div class="row">
                                            <?php if (!isset($_GET['id'])) : ?>
                                                <div class="col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="password_lama">Password Lama</label>
                                                        <input type="password" id="password_lama" class="form-control" name="password_lama" autofocus autocomplete="off" required>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="password_baru">Password Baru</label>
                                                    <input type="password" id="password_baru" class="form-control" name="password_baru" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <?php if (!isset($_GET['id'])) : ?>
                                                <div class="col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="konfirmasi_password_baru">Konfirmasi Password Baru</label>
                                                        <input type="password" id="konfirmasi_password_baru" class="form-control" name="konfirmasi_password_baru" autocomplete="off" required>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" name="submit" class="btn btn-primary mb-1 text-white">Ganti Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>