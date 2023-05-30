<!DOCTYPE html>
        <html dir="rtl" lang="ar">
    <head>
        <link rel="stylesheet" href="css/login_signin.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

        <meta charset="UTF-8">
            <title>تسجيل </title>
    </head>
    <body>
    
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






        <br><br><br><br><br>
        <h2>تسجيل حساب جديد</h2>
        <form method="post" action="signup.php">
            <label for="name">الاسم:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="phone">رقم الهاتف :</label>
            <input type="phone" id="phone" name="phone" required><br><br>
            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">تسجيل </button>
            <p><a href="login.php">تسجيل الدخول</a></p>

        <?php

            if(isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['password'])) {
                $db = mysqli_connect('localhost','root', '', 'd-project');
                $username = mysqli_real_escape_string($db, $_POST['username']);
                $phone = mysqli_real_escape_string($db, $_POST['phone']);
                $password = mysqli_real_escape_string($db, $_POST['password']);

            
                if(!preg_match("/^[0-9]{10}$/", $phone)) {
                    echo "<p style='color:red;'>رقم الهاتف غير صالح. يرجى إدخال رقم هاتف صحيح.</p>";
                    exit();
                }

            
                $stmt = mysqli_prepare($db, "SELECT * FROM Users WHERE phone = ?");
                mysqli_stmt_bind_param($stmt, "s", $phone);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    
                    echo "<p style='color:red;'>رقم الهاتف مستخدم بالفعل. يرجى المحاولة باستخدام رقم هاتف آخر.</p>";
                } else {
            
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($db, "INSERT INTO Users (username, phone, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $username, $phone, $password_hash);
            mysqli_stmt_execute($stmt);
            echo "<p>تم تسجيل الحساب بنجاح. يرجى تسجيل الدخول.</p>";
            }

            
            
            }

        ?>  


    

    </form>
    </body>
</html>