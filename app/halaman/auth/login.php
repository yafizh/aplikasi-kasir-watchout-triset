<?php
if (isset($_POST['submit'])) {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $query = "
        SELECT 
            p.*, 
            k.id AS id_kasir, 
            k.nama, 
            k.foto 
        FROM 
            pengguna AS p 
        LEFT JOIN 
            kasir AS k 
        ON 
            p.id=k.id_pengguna 
        WHERE 
            p.username='$username' 
            AND 
            p.password='$password'
    ";
    $result = $mysqli->query($query);
    if ($result->num_rows) {
        $_SESSION['user'] = $result->fetch_assoc();
        if ($_SESSION['user']['status'] == 3) {
            $query = "
                SELECT 
                    * 
                FROM 
                    pembeli 
                WHERE 
                    id_pengguna=" . $_SESSION['user']['id'] . "
            ";
            $result = $mysqli->query($query);
            $_SESSION['user']['pembeli'] = $result->fetch_assoc();
            echo "<script>location.href = 'online_store/index.php';</script>";
        } else
            echo "<script>location.href = '?';</script>";
    } else {
        echo "<script>alert('username atau password salah')</script>";
    }
}
?>
<div id="auth-left" class="m-5 p-4 shadow rounded">
    <div class="auth-logo mb-4">
        <img src="../assets/images/logo.png" alt="Logo">
    </div>
    <h1>Log in.</h1>
    <p class="mb-3">Log in dengan username dan password yang telah terdaftar.</p>
    <form action="" method="POST" class="mb-3">
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control" placeholder="Username" name="username" autocomplete="off">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-block shadow text-white">Log in</button>
    </form>
    <div class="text-center text-lg">
        <p><a class="font-bold" href="auth-forgot-password.html">Lupa Password?</a></p>
    </div>
</div>