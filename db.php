<?php

$host = 'localhost'; 
$dbname = 'system_db'; 
$username = 'root'; // XAMPP varsayılan kullanıcı
$password = ''; // XAMPP varsayılan şifre (Mac'te genellikle boş)

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Bağlantı testi için yazılmıştı, canlıda kapatın.
    // echo "Veritabanı bağlantısı başarılı!"; 
    
} catch (PDOException $e) {
    // Bağlantı hatası durumunda mesajı göster
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

?>