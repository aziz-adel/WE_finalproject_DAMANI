<!DOCTYPE html>
    <html dir="rtl" lang="ar">
<head>
    <link rel="stylesheet" href="css/login_signin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

    <meta charset="UTF-8">
        <title>تسجيل الدخول</title>
</head>
<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="" class="flex items-center">
      
      
  </a>
  <div class="flex md:order-2">
  
  </div>
  <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
  <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
      
      <a href="home.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">   <img src="img/logo.png" class="h-8 mr-3" > </a>
    </li>
    </li>
  </ul>
  </div>
</nav>   

    <body>    
     
            <br><br><br><br><br>
            <h2>تسجيل الدخول المتاجر</h2>
            <form method="post" action="login_cmp.php">
                <label for="phone">البريد الالكتروني :</label>
                <input type="text" id="email" name="email" required><br><br>
                <label for="password">كلمة المرور:</label>
                <input type="password" id="password" name="password" required><br><br>
                
        














        <?php
        
            if(isset($_POST['email']) && isset($_POST['password'])) {
            
                $db = mysqli_connect('localhost','root', '', 'd-project');

            
                $email = mysqli_real_escape_string($db, $_POST['email']);
                $password = mysqli_real_escape_string($db, $_POST['password']);
                $stmt = mysqli_prepare($db,"SELECT * FROM stores WHERE email = ?");
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    $user = mysqli_fetch_assoc($result);

                    if (password_verify($password, $user['password'])) {

                        session_start();
                        $_SESSION['store_id'] = $user['store_id'];
                        $_SESSION['username'] = $user['username'];
                        header('Location: index _cmp.php');
                        ob_flush();
                        exit();
                    } else {
                        echo "<p style='color:red;'>كلمة المرور غير صحيحة. يرجى المحاولة مرة أخرى.</p>";
                    }
                } else {
                    echo "<p style='color:red;'>البريد الإلكتروني غير موجود. يرجى التأكد من البريد الإلكتروني والمحاولة مرة أخرى.</p>";
                }

                mysqli_close($db);
            }
        ?>


        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">تسجيل </button>
                        <p><a href="signup_cmp.php">تسجيل حساب جديد</a></p>
        </form>
</body>
</html>
