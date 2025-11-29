<?php
// Oturum Güvenliği (Zorunlu)
session_start(); 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php'; 

$user_id = $_SESSION['user_id'];
$user_data = null;

try {
    // Veritabanından kullanıcının tüm verilerini çekme (Ödev Puanı: Veri Çekme)
    $sql = "SELECT name, surname, school_number, email, last_login FROM users WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Profilim</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Profil Bilgilerim</h2>
        
        <?php if ($user_data): ?>
            <table>
                <tr><th>Ad:</th><td><?php echo htmlspecialchars($user_data['name']); ?></td></tr>
                <tr><th>Soyad:</th><td><?php echo htmlspecialchars($user_data['surname']); ?></td></tr>
                <tr><th>Okul No:</th><td><?php echo htmlspecialchars($user_data['school_number']); ?></td></tr>
                <tr><th>E-posta:</th><td><?php echo htmlspecialchars($user_data['email']); ?></td></tr>
                <tr><th>Son Giriş:</th><td><?php echo htmlspecialchars($user_data['last_login']); ?></td></tr>
            </table>
        <?php else: ?>
            <p style="color: red;">Kullanıcı bilgileri bulunamadı.</p>
        <?php endif; ?>
        
        <p><a href="dashboard.php">Panele Dön</a> | <a href="logout.php">Çıkış Yap</a></p>
    </div>
</body>
</html>