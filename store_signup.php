
<?php

if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {

    $db = mysqli_connect('localhost','root', '', 'd-project');
    $username = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    
    if(strlen($password) < 8) {
        $error_message = "يجب أن يكون طول كلمة المرور 8 خانات على الأقل";
    } else {
        $stmt = mysqli_prepare($db, "SELECT * FROM stores WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "البريد الالكتروني مستخدم";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($db, "INSERT INTO stores (name, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);
            mysqli_stmt_execute($stmt);
            $error_message = "تم تسجيل الحساب بنجاح. يرجى تسجيل الدخول";
        }
    }

    mysqli_close($db);
}

?>
   
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/store_signup.css">
    <title>تسجيل  المتاجر</title>
   
    
</head>
<body>
    <div class="modal">
        <div class="signup-section">
            <button class="close"><a href="home.php" class="s">X</a></button>
            <div class="signup-content">
                <img src="img/logo.png" class="logo" alt="لوغو">
                <p> هل لديك حساب بالفعل ؟ </p>
                <a href="store_login.php" class="signup">تسجيل الدخول</a>   
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
                <form class="login-form" action="store_signup.php" method="post">
                    <input type="text" name="name" placeholder="الأسم " required>
                    <input type="email" name="email" placeholder="البريد الالكتروني " required>
                    <input type="password" name="password" placeholder="كلمة المرور" required>
                    <button type="submit" class="login-btn">تسجيل </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
