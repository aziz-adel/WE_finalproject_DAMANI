<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin_login.css">

    <title> تسجيل الدخول للإدارة</title>
  
</head>
<body>
    <?php
    // Database connection
    $db = mysqli_connect('localhost','root', '', 'd-project');
    if(!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //  error message
    $errorMsg = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = $_POST['password'];

        // Fetch password from database and verify
        $query = "SELECT password FROM admin WHERE username='$username'";
        $result = mysqli_query($db, $query);
        
        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("Location: admin_dashboard.php");
                exit;
            } else {
                $errorMsg = "كلمة المرور غير صحيحة!";
            }
        } else {
            $errorMsg = "اسم المستخدم غير موجود!";
        }   
    }
    ?>
    <div class="modal">
        <div class="signup-section">
            <button class="close"><a href="home.php" class="s" >X</a></button>
            <div class="signup-content">
                <img src="img/logo.png" class="logo" alt="لوغو">
                
                
            </div>
        </div>
        <div class="login-section">
            <div class="login-content">
                <h1>تسجيل الدخول إلى حسابك</h1>
                <p>حدد نوع التسجيل:</p>
                <div class="social-buttons">
            <a href="user_login.php" class="social">أفراد</a>
            <a href="store_login.php" class="social">المتاجر</a>
            <a href="admin_login.php" class="social admin-btn">أدارة</a>
                 </div>

                <?php if (!empty($errorMsg)) { ?>
                    <p class="error-message"><?php echo $errorMsg; ?></p>
                <?php } ?>
                <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="text" name="username" placeholder="اسم المستخدم" required>
                    <input type="password" name="password" placeholder="كلمة المرور" required>
                    <button type="submit" class="login-btn">تسجيل الدخول</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
