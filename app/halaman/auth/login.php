<?php
if (isset($_POST['submit'])) {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $result = $mysqli->query("SELECT * FROM pengguna WHERE username='$username' AND password='$password'");
    if($result->num_rows){
        $_SESSION['user'] = $result->fetch_assoc();
        echo "<script>location.href = '?';</script>";
    }else{

    }
}
?>
<div id="auth-left">
    <div class="auth-logo">
        <img src="../assets/images/logo.png" alt="Logo">
    </div>
    <h1 class="auth-title">Log in.</h1>
    <p class="auth-subtitle mb-5">Log in dengan username dan password yang telah diberikan.</p>

    <form action="" method="POST">
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control form-control-xl" placeholder="Username" name="username">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control form-control-xl" placeholder="Password" name="password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5 text-white">Log in</button>
    </form>
    <div class="text-center mt-5 text-lg fs-4">
        <p><a class="font-bold" href="auth-forgot-password.html">Lupa Password?</a></p>
    </div>
</div>