<?php
    //session part
    session_start();
    if(!isset($_SESSION['store_id'])) {
        header('Location: store_login.php');
        exit();
    }
    $db = mysqli_connect('localhost','root', '', 'd-project');


    $stmt = mysqli_prepare($db,"SELECT * FROM stores WHERE store_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['store_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_close($db);
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

  <meta charset="UTF-8">
      <title>الرئيسية</title>
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
            <a href="logout.php" class="text-sm  text-blue-600 dark:text-blue-500 hover:underline">تسجيل خروج</a>
        </div>
  </div>
  <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
    <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
      <li><li></li>
        <a href="search.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">بحث</a>
      </li>
      <li><li></li>
        <a href="create.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">اضافة</a>
      </li>
      <li><li></li>
        <a href="view.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">عرض الضمانات </a>
      </li>
      <li><li></li>
        <a href="store_home.php" class="block py-2 pl-3 pr-4 text-blue-700 rounded hover:bg-blue-700 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">الرئيسية</a>
      </li>
    </ul>
  </div>
  </div>
</nav>   
<br><br><br><br>
<h1>مرحبا بكم متجر <?php echo $user['name']; ?></h1>
<h2>سنخبركم عن طريقة استخدام النظام كالاتي :</h2>
<h3>صفحة  عرض البيانات :</h3>
<p>تمكنكم من عرض جميع الضمانات المسجلة لديكم</p><br>
<h3>صفحة البحث :</h3>
<p>تمكنكم من البحث عن ضمان معين عن طريق المنتج او رقم هاتف العميل او تاريخ الانتهاء</p><br>
<h3>صفحة اضافة:</h3>
<p>تمكنكم من اضافة ضمان جديد للعملاء المسجلين في النظام 
يمكنكم تعديل معلومات الحساب بالضغط على اسم المتجر</p><br>
<h3>تعديل معلومات الحساب :</h3>
<p>مكنكم تعديل معلومات الحساب بالضغط على اسم المتجر</p><br>

<h3>في حال حدوث اي خلل في النظام يمكنكم التواصل عن طريق الصفحة الرئيسية بالظغط على اتصل بنا او مراسلتنا على admin@admin.com</h3>
<h3></h3>

<p></p>
<p></p>
<style>
  body{
    margin-right:10px;
  }
</style>
</body>
</html>



















