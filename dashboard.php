<?php
// Oturum Güvenliği (Zorunlu)
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); 
}

require_once 'db.php'; 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Hoş Geldiniz, Yönetim Paneli</h2>
        <p>Bu sayfayı sadece giriş yapmış kullanıcılar görebilir. Oturum güvenliği başarılı.</p>
        <p><a href="profile.php">Profilim</a></p>
        <p><a href="logout.php">Çıkış Yap</a></p>
    </div>
</body>
</html>