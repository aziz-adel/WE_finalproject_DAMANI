<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $db = mysqli_connect('localhost', 'root', '', 'd-project');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $user_id = $_SESSION['user_id'];

    // Initialize variables
    $name = '';
    $phone = '';

    // Fetch user data
    $stmt = mysqli_prepare($db, "SELECT * FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['username'];
        $phone = $row['phone'];
    }
    mysqli_stmt_close($stmt);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['username'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        if (!empty($password)) {
            if (strlen($password) >= 8) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE users SET username = ?, phone = ?, password = ? WHERE user_id = ?";
                $update_stmt = mysqli_prepare($db, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "sssi", $name, $phone, $password_hash, $user_id);

                if (mysqli_stmt_execute($update_stmt)) {
                    echo "<script>alert('تم تحديث المعلومات بنجاح!'); window.location.href='home.php';</script>";
                    exit();
                } else {
                    echo "<script>alert('Error: " . mysqli_error($db) . "');</script>";
                }
                mysqli_stmt_close($update_stmt);
            } else {
                echo "<script>alert('كلمة المرور يجب أن تكون على الأقل 8 أحرف');</script>";
            }
        } else {
            $update_sql = "UPDATE users SET username = ?, phone = ? WHERE user_id = ?";
            $update_stmt = mysqli_prepare($db, $update_sql);
            mysqli_stmt_bind_param($update_stmt, "ssi", $name, $phone, $user_id);

            if (mysqli_stmt_execute($update_stmt)) {
                echo "<script>alert('تم تحديث المعلومات بنجاح!'); window.location.href='home.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error: " . mysqli_error($db) . "');</script>";
            }
            mysqli_stmt_close($update_stmt);
        }
    }

    mysqli_close($db);
?>


<!DOCTYPE html>
    <html dir="rtl" lang="ar">
    <head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    
     
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
        <link rel="stylesheet" href="css/create.css">


    <meta charset="UTF-8">
        <title>الحساب</title>
    </head>

    
    <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="" class="flex items-center">
        
        
    </a>
    <div class="flex md:order-2">
    <div class="flex items-center">
                <a href="logout.php" class="text-sm  text-blue-600 dark:text-blue-500 hover:underline">تسجيل خروج</a>
            </div>
    </div>
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
        
            <a href="index.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">   <img src="img/logo.png" class="h-8 mr-3" > </a>
        </li>
        </li>
        </ul>
    </div>
    </div>
    </nav>   
    <body>
 
        <br><br><br><br>
        
        <form method="post" action="user_update.php">
        <h1>تعديل معلومات الحساب</h1>
        <br>
            <label for="name">الاسم:</label>
            <input type="text" id="username" name="username" value="<?php echo $name; ?> "required><br><br>
            <label for="phone">رقم الهاتف :</label><br>
            <input type="phone" id="phone" name="phone" value="<?php echo $phone ?>" required><br><br>
            <label for="password">كلمة المرور الجديدة:</label><br>
            <input type="password" id="password" name="password" value="" required><br><br>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">حفظ </button>
</form> 
        </body>
</html>
