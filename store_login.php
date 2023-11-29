<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = mysqli_connect('localhost', 'root', '', 'd-project');

    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($db, "SELECT * FROM stores WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            if ($user['verified'] == 1) {
                // Set session variables and redirect.
                $_SESSION['store_id'] = $user['store_id'];
                $_SESSION['name'] = $user['name'];

                $verify_stmt = mysqli_prepare($db, "SELECT verified FROM stores WHERE store_id = ?");
                mysqli_stmt_bind_param($verify_stmt, "i", $user['store_id']);
                mysqli_stmt_execute($verify_stmt);
                $verify_result = mysqli_stmt_get_result($verify_stmt);
                $verified_status = mysqli_fetch_assoc($verify_result);

                if ($verified_status['verified'] == 1) {
                    // Proceed if verified
                    header('Location: store_home.php');
                    exit();
                } else {
                    $error_message = "البريد الإلكتروني غير موجود. يرجى التأكد من البريد الإلكتروني والمحاولة مرة أخرى.";
                }
            } else {
                $error_message = "الحساب غير مفعل. يرجى انتظار التوثيق.";
            }
        } else {
            $error_message = "كلمة المرور غير صحيحة. يرجى المحاولة مرة أخرى.";
        }
        mysqli_close($db);
    }
}
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/store_login.css">
    <title>تسجيل الدخول للمتاجر</title>
   
    
</head>
<body>
    <div class="modal">
        <div class="signup-section">
            <button class="close"><a href="home.php" class="s">X</a></button>
            <div class="signup-content">
                <img src="img/logo.png" class="logo" alt="لوغو">
                <p>سجل و أحفظ ضمانك</p>
                <a href="store_signup.php" class="signup">تسجيل</a>
            </div>
        </div>
        <div class="login-section">
            <div class="login-content">
                <h1>تسجيل الدخول إلى حسابك</h1>
                <p>حدد نوع التسجيل:</p>
                <div class="social-buttons">
                    <a href="user_login.php" class="social user-btn">أفراد</a>
                    <a href="store_login.php" class="social store-btn">المتاجر</a>
                    <a href="admin_login.php" class="social admin-btn">أدارة</a>
                </div>
                <?php
        if (isset($error_message)) {
            echo "<p style='color:red;'>$error_message</p>";
        }
        ?>
                <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="text" name="email" placeholder="البريد الإلكتروني" required>
                    <input type="password" name="password" placeholder="كلمة المرور" required>
                    <button type="submit" class="login-btn">تسجيل </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
