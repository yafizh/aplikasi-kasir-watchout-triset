<?php
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $nomor_telepon = $mysqli->real_escape_string($_POST['nomor_telepon']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $tempat_lahir = $mysqli->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $mysqli->real_escape_string($_POST['tanggal_lahir']);
    $alamat = $mysqli->real_escape_string($_POST['alamat']);

    $query = "
        UPDATE pembeli SET 
            nama='$nama',
            nomor_telepon='$nomor_telepon',
            email='$email',
            tempat_lahir='$tempat_lahir',
            tanggal_lahir='$tanggal_lahir',
            alamat='$alamat' 
        WHERE 
            id=" . $_SESSION['user']['pembeli']['id'] . "
    ";
    if (!$mysqli->query($query)) {
        die($mysqli->error);
    }
}

$result = $mysqli->query("SELECT * FROM pembeli WHERE id=" . $_SESSION['user']['pembeli']['id']);
$profil = $result->fetch_assoc();
?>
<div class="col-12 col-md-6">
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $profil['nama']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?= $profil['nomor_telepon']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $profil['email']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $profil['tempat_lahir']; ?>">
        </div>
        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $profil['tanggal_lahir']; ?>">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" required><?= $profil['alamat']; ?></textarea>
        </div>
        <div class="mb-3 d-flex justify-content-end">
            <button type="submit" name="submit" class="btn btn-primary text-white">Perbaharui Profile</button>
        </div>
    </form>
</div>