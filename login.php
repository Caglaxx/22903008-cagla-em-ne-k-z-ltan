<?php
session_start(); 
require_once 'db.php'; 

// Giriş yapmış kullanıcıyı yönlendir
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error_message = '';

if (isset($_POST['login_btn'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error_message = "Lütfen e-posta ve şifrenizi girin.";
    } else {
        try {
            // Kullanıcıyı bulma
            $sql = "SELECT id, password FROM users WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                
                // Oturumu Başlatma
                $_SESSION['user_id'] = $user['id'];
                
                // last_login Güncelleme (Ödev Puanı: last_login güncellemesi)
                $update_sql = "UPDATE users SET last_login = NOW() WHERE id = :id";
                $update_stmt = $db->prepare($update_sql);
                $update_stmt->bindParam(':id', $user['id']);
                $update_stmt->execute();
                
                // Dashboard'a yönlendirme
                header("Location: dashboard.php");
                exit();
                
            } else {
                $error_message = "Hatalı e-posta veya şifre.";
            }

        } catch (PDOException $e) {
            $error_message = "Giriş sırasında bir veritabanı hatası oluştu.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Girişi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Kullanıcı Girişi</h2>
        
        <?php if ($error_message): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <form action="login.php" method="POST">
            <label for="email">E-posta:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login_btn">Giriş Yap</button>
        </form>
        
        <p>Hesabınız yok mu? <a href="register.php">Kayıt Olun</a></p>
    </div>
</body>
</html>