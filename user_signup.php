<?php

$error_message = "";  // Initialize the error message variable

if(isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['password'])) {
    $db = mysqli_connect('localhost','root', '', 'd-project');
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Check for valid phone number format
    if(!preg_match("/^[0-9]{10}$/", $phone)) {
        $error_message = "<p style='color:red;'>رقم الهاتف غير صالح. يرجى إدخال رقم هاتف صحيح.</p>";
    } 
    // Check if password length is at least 8 characters
    elseif(strlen($password) < 8) {
        $error_message = "<p style='color:red;'>يجب أن يكون طول كلمة المرور 8 أحرف على الأقل.</p>";
    } 
    else {
        $stmt = mysqli_prepare($db, "SELECT * FROM Users WHERE phone = ?");
        mysqli_stmt_bind_param($stmt, "s", $phone);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "<p style='color:red;'>رقم الهاتف مستخدم بالفعل. يرجى المحاولة باستخدام رقم هاتف آخر.</p>";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($db, "INSERT INTO Users (username, phone, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $username, $phone, $password_hash);
            mysqli_stmt_execute($stmt);
            $error_message = "<p>تم تسجيل الحساب بنجاح. يرجى تسجيل الدخول.</p>";
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
    <link rel="stylesheet" href="css/user_login.css">

    <title>تسجيل  افراد</title>
  
</head>
<body>
    
    <div class="modal">
        <div class="signup-section">
        <button class="close"><a href="home.php" class="s" >X</a></button>
            <div class="signup-content">
                <img src="img/logo.png" class="logo" alt="لوغو">
                <p> هل لديك حساب بالفعل ؟ </p>
                <a href="user_login.php" class="signup">تسجيل الدخول</a>            </div>
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
                <?php if (!empty($error_message)) { ?>
                    <p class="error-message"><?php echo $error_message; ?></p>
                <?php } ?>
                <form class="login-form" action="user_signup.php" method="post">
                <input type="text" name="username" placeholder="الأسم " required>
                    <input type="text" name="phone" placeholder="رقم الهاتف" required>
                    <input type="password" name="password" placeholder="كلمة المرور" required>
                    <button type="submit" class="login-btn">تسجيل </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
