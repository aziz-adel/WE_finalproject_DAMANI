<?php
// Start the session
session_start();
if (!isset($_SESSION['store_id'])) {
    header('Location: login_cmp.php');
    exit();
}

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'd-project');
$stmt = mysqli_prepare($db, "SELECT * FROM stores WHERE store_id = ?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['store_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_close($db);

// Generate today's date for default start date
$today_date = date('Y-m-d');

// Initialize message variable
$message = '';

// Form processing
if (isset($_POST['submit'])) {
    $product = $_POST['product'];
    $user_p = $_POST['phone'];
    $start_date = $_POST['start_date'];
    $manual_expiry_date = $_POST['manual_expiry_date'];
    $store_id = $_SESSION['store_id'];

    // Determine expiry date
    if (!empty($manual_expiry_date)) {
        $expiry_date = $manual_expiry_date;
    } else {
        $warranty_period = $_POST['warranty_period'];
        $expiry_date = date('Y-m-d', strtotime($start_date . ' + ' . $warranty_period));
    }

    // Re-establish database connection
    $db = mysqli_connect('localhost', 'root', '', 'd-project');

    // Prepare and execute user ID query
    $user_id_stmt = mysqli_prepare($db, "SELECT user_id FROM users WHERE phone = ?");
    mysqli_stmt_bind_param($user_id_stmt, "s", $user_p);
    mysqli_stmt_execute($user_id_stmt);
    mysqli_stmt_bind_result($user_id_stmt, $user_id);
    mysqli_stmt_fetch($user_id_stmt);
    mysqli_stmt_close($user_id_stmt);

    // Prepare and execute warranty insert
    $warranty_stmt = mysqli_prepare($db, "INSERT INTO warranty (product, start_date, expiry_date, user_id, store_id) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($warranty_stmt, "ssssi", $product, $start_date, $expiry_date, $user_id, $store_id);
    mysqli_stmt_execute($warranty_stmt);

    if (mysqli_affected_rows($db) > 0) {
        $message = 'تم اصدار الضمان بنجاح';
    } else {
        $message = 'خطأ في النظام';
    }

    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="css/create.css">
</head>
<body>
<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="" class="flex items-center">
      <img src="img/logo.png" class="h-8 mr-3" >
      
  </a>
  <div class="flex md:order-2">
  <div class="flex items-center">
            <a href="store_update.php" class="mr-6 text-sm  text-gray-500 dark:text-white hover:underline"><?php echo $user['name']; ?></h2></a>
            <li>
            <a href="admin_logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i></a>
                  </div>
  </div>
  <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
    <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
      <li><li></li>
        <a href="store_home.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">الرئيسية</a>
      </li>
      <li><li></li>
        <a href="create.php" class="block py-2 pl-3 pr-4 text-blue-700 rounded hover:bg-blue-700 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">اضافة</a>
      </li>
      <li><li></li>
        <a href="view.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">عرض الضمانات </a>
      </li>
      <li><li></li>
        <a href="search.php " class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">بحث</a>
      </li>
    </ul>
  </div>
  </div>
</nav>   
<br><br><br>
<script>
        // Check if a message is set and display it
        window.onload = function() {
            <?php if (!empty($message)): ?>
                alert('<?php echo $message; ?>');
            <?php endif; ?>
        };
    </script>
<form action="" method="POST">
        <fieldset>
            <h3>اضافة ضمان</h3>
            رقم الهاتف:<br>
            <input type="text" name="phone"><br>
            المنتج:<br>
            <input type="text" name="product"><br>
            تاريخ الشراء:<br>
            <input type="date" name="start_date" value="<?php echo $today_date; ?>"><br>

            مدة الضمان:<br>
            <select name="warranty_period" id="warranty_period">
                <option value="1 year">1 سنة</option>
                <option value="2 years">2 سنوات</option>
                <option value="5 years">5 سنوات</option>
            </select><br>

            أو أدخل تاريخ انتهاء الصلاحية يدويًا:<br>
            <input type="date" name="manual_expiry_date"><br>

            <input type="submit" name="submit" value="اضافة الضمانات">
        </fieldset>
    </form>
</body>
</html>