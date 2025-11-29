<?php
session_start();

// Kullanıcı giriş yapmışsa dashboard'a yönlendirir
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Proje Ana Sayfa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Web Programlama Proje Ödevi</h2>
        <p>Devam etmek için lütfen giriş yapınız veya kayıt olunuz.</p>
        <p>
            <a href="login.php">Giriş Yap</a> | 
            <a href="register.php">Kayıt Ol</a>
        </p>
    </div>
</body>
</html>