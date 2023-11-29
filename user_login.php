<?php
// Start the session at the very beginning
session_start();

if (isset($_POST['phone']) && isset($_POST['password'])) {
    $db = mysqli_connect('localhost', 'root', '', 'd-project');
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $stmt = mysqli_prepare($db, "SELECT * FROM Users WHERE phone = ?");
    mysqli_stmt_bind_param($stmt, "s", $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            // Redirect to user dashboard
            header('Location: user_dashboard.php');
            exit;
        } else {
            $errorMsg = "كلمة المرور غير صحيحة!";
        }
    } else {
        $errorMsg = "رقم الهاتف غير موجود!";
    }
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/user_login.css">
    <title>تسجيل الدخول افراد</title>
    
</head>
<body>
  
    <div class="modal">
        <div class="signup-section">
        <button class="close"><a href="home.php" class="s" >X</a></button>
            <div class="signup-content">
                <img src="img/logo.png" class="logo" alt="لوغو">
                <p>سجل و أحفظ ضمانك</p>
                <a href="user_signup.php" class="signup">تسجيل</a>            </div>
        </div>
        <div class="login-section">
            <div class="login-content">
                <h1>تسجيل الدخول إلى حسابك</h1>
                <p>حدد نوع التسجيل:</p>
                <div class="social-buttons">
                <div class="social-buttons">
            <a href="user_login.php" class="social user-btn">أفراد</a>
            <a href="store_login.php" class="social store-btn">المتاجر</a>
            <a href="admin_login.php" class="social admin-btn">أدارة</a>
                 </div>
                </div>
                <?php if (!empty($errorMsg)) { ?>
                    <p class="error-message"><?php echo $errorMsg; ?></p>
                <?php } ?>
                <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="text" name="phone" placeholder="رقم الهاتف" required>
                    <input type="password" name="password" placeholder="كلمة المرور" required>
                    <button type="submit" class="login-btn">تسجيل الدخول</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
