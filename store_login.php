<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <link rel="stylesheet" href="css/login_signin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
</head>
<body>
    <!-- Navigation and other HTML content here ... -->

    <h2>تسجيل الدخول المتاجر</h2>
    <form method="post" action="store_login.php">
        <!-- Form fields here ... -->
        <label for="email">البريد الالكتروني :</label>
        <input type="text" id="email" name="email" required><br><br>
        <label for="password">كلمة المرور:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">تسجيل </button>
         
        <p><a href="store_signup.php" class="color=blue;">تسجيل جديد</a></p>

    <?php
        session_start(); // Start the session at the beginning.

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = mysqli_connect('localhost','root', '', 'd-project');

            $email = mysqli_real_escape_string($db, $_POST['email']);
            $password = $_POST['password']; // No need to escape passwords.

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
            
                        if($verified_status['verified'] == 1) {
                            // Proceed if verified
                            header('Location: store_home.php');
                            exit();
                        
                    } else {
                        echo "<p style='color:red;'>البريد الإلكتروني غير موجود. يرجى التأكد من البريد الإلكتروني والمحاولة مرة أخرى.</p>
                </form>";
                      
                        
                    }
                } else {
                    echo "<p style='color:red;'>الحساب غير مفعل. يرجى انتظار التوثيق.</p> 
                        </form>";
                }
            } else {
                echo "<p style='color:red;'>كلمة المرور غير صحيحة. يرجى المحاولة مرة أخرى.</p>
                </form>";
            }
            mysqli_close($db);
            }}
    ?>
    <!-- Additional HTML content ... -->
</body>
</html>
