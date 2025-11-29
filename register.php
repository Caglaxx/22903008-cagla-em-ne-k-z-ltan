<?php
require_once 'db.php'; 

$error_message = '';
$success_message = '';

if (isset($_POST['register_btn'])) {
    
    // 1. Veri Temizliği ve Toplama
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $school_number = trim($_POST['school_number']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        $error_message = "Lütfen tüm alanları doldurun.";
    } else {
        
        // 2. E-posta Tekrar Kontrolü (UNIQUE kontrolü)
        try {
            $check_sql = "SELECT id FROM users WHERE email = :email";
            $stmt = $db->prepare($check_sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $error_message = "Bu e-posta adresi zaten kullanımda.";
            } else {
                
                // 3. Şifreyi Hashleme (Ödev Puanı: password_hash kullanımı)
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // 4. Veritabanına Kayıt
                $insert_sql = "INSERT INTO users (name, surname, school_number, email, password) 
                               VALUES (:name, :surname, :school_number, :email, :password)";
                
                $stmt = $db->prepare($insert_sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':surname', $surname);
                $stmt->bindParam(':school_number', $school_number);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->execute();
                
                $success_message = "Kayıt başarılı! Şimdi <a href='login.php'>Giriş yapabilirsiniz</a>.";
                
            }
            
        } catch (PDOException $e) {
            $error_message = "Kayıt sırasında bir veritabanı hatası oluştu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Kayıt Sistemi</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <h2>Kullanıcı Kayıt Formu</h2>
        
        <?php if ($error_message): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <p style="color: green;"><?php echo $success_message; ?></p>
        <?php endif; ?>
        
        <form action="register.php" method="POST">
            
            <label for="name">Ad:</label>
            <input type="text" id="name" name="name" required>

            <label for="surname">Soyad:</label>
            <input type="text" id="surname" name="surname" required>

            <label for="school_number">Okul Numarası:</label>
            <input type="text" id="school_number" name="school_number" required>

            <label for="email">E-posta:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="register_btn">Kayıt Ol</button>
            
        </form>
        
        <p>Zaten hesabınız var mı? <a href="login.php">Giriş Yap</a></p>
    </div>
</body>
</html>