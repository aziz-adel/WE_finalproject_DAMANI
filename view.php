<?php
  //session part
  session_start();

  if(!isset($_SESSION['store_id'])) {
      header('Location: login_cmp.php');
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

      <link rel="stylesheet" href="css/view.css">


    <meta charset="UTF-8">
        <title>عرض</title>
    </head>
  <body>
    
    <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="" class="flex items-center">
          <img src="img/logo.png" class="h-8 mr-3" >
          
      </a>
      <div class="flex md:order-2">
      <div class="flex items-center">
                <a href="store_update.php"class="mr-6 text-sm  text-gray-500 dark:text-white hover:underline"><?php echo $user['name']; ?></h2></a>
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
            <a href="create.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">اضافة</a>
          </li>
          <li><li></li>
            <a href="view.php" class="block py-2 pl-3 pr-4 text-blue-700 rounded hover:bg-blue-700 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">عرض الضمانات </a>
          </li>
          <li><li></li>
            <a href="search.php " class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">بحث</a>
          </li>
        </ul>
      </div>
      </div>
    </nav>   

    <br><br><br><br>
  

    <?php if(isset($_SESSION['store_id'])) { ?>
            <?php
          
            $db = mysqli_connect('localhost', 'root', '', 'd-project');

            // get the warranties for the  user_id
            $store_id = $_SESSION['store_id'];
            $query = "SELECT *FROM warranty WHERE store_id='$store_id'";
            $result = mysqli_query($db, $query);
            ?>

            <?php if(mysqli_num_rows($result) == 0) { ?>
                <p>لا يوجد ضمانات مسجلة.</p>
            <?php } else { ?>
                <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="col" class="px-6 py-3">رقم الضمان  </th>
                        <th scope="col" class="px-6 py-3">اسم المنتح</th>
                        <th  scope="col" class="px-6 py-3">تاريخ البداية</th>
                        <th  scope="col" class="px-6 py-3">تاريخ الانتهاء</th>
                    </tr>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                          <td class="px-6 py-4"><?php echo $row['warranty_id']; ?></td>
                            <td class="px-6 py-4"><?php echo $row['product']; ?></td>
                            <td class="px-6 py-4"><?php echo $row['start_date']; ?></td>
                            <td class="px-6 py-4"><?php echo $row['expiry_date']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
            
        <?php } else { ?>
            <p>يجب تسجيل الدخول لعرض الضمانات.</p>
        <?php } 
        
        mysqli_close($db);
    ?>

        </div >

  </body>
</html>
