<?php
if (isset($_POST['submit'])) {
    $password_lama = $mysqli->real_escape_string($_POST['password_lama']);
    $password_baru = $mysqli->real_escape_string($_POST['password_baru']);
    $konfirmasi_password_baru = $mysqli->real_escape_string($_POST['konfirmasi_password_baru']);

    if ($password_lama == $_SESSION['user']['password']) {
        if ($password_baru == $konfirmasi_password_baru) {
            $query = "
            UPDATE pengguna SET 
                password='$password_baru' 
            WHERE 
                id=" . $_SESSION['user']['id'] . "
        ";
            if ($mysqli->query($query)) {
                echo "<script>alert('Berhasil Ganti Password!')</script>";
            } else {
                die($mysqli->error);
            }
        } else {
            echo "<script>alert('Password Baru Tidak Sama!')</script>";
        }
    } else {
        echo "<script>alert('Password Lama Salah!')</script>";
    }
}
?>
<div class="col-12 col-md-6">
    <form action="" method="POST">
        <div class="mb-3">
            <label for="password_lama" class="form-label">Pasasword Lama</label>
            <input type="password" class="form-control" id="password_lama" name="password_lama" required>
        </div>
        <div class="mb-3">
            <label for="password_baru" class="form-label">Pasasword Baru</label>
            <input type="password" class="form-control" id="password_baru" name="password_baru" required>
        </div>
        <div class="mb-3">
            <label for="konfirmasi_password_baru" class="form-label">Pasasword Baru</label>
            <input type="password" class="form-control" id="konfirmasi_password_baru" name="konfirmasi_password_baru" required>
        </div>
        <div class="mb-3 d-flex justify-content-end">
            <button type="submit" name="submit" class="btn btn-primary text-white">Perbaharui Password</button>
        </div>
    </form>
</div>