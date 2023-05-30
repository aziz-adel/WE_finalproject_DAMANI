<?php
      //session part
      session_start();

      if(!isset($_SESSION['user_id'])) {
          header('Location:login.php');
          exit();
      }
      $db = mysqli_connect('localhost','root', '', 'd-project');

      $stmt = mysqli_prepare($db,"SELECT * FROM Users WHERE user_id = ?");
      mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $user = mysqli_fetch_assoc($result);
      mysqli_close($db);
?>
<?php

  $db = mysqli_connect('localhost','root', '', 'd-project');

  // get the users_id
  $user_id = $_SESSION['user_id'];

  $sql = "SELECT warranty.product, warranty.start_date, warranty.expiry_date, stores.name AS store FROM warranty JOIN stores ON warranty.store_id = stores.store_id WHERE warranty.user_id = $user_id";
  if (!empty($_POST['store'])) {
    $store = $_POST['store'];
    $sql .= " AND stores.name LIKE '$store'";
  }

  if (!empty($_POST['date'])) {
    $date = $_POST['date'];
    $sql .= " AND warranty.start_date <= '$date' AND warranty.expiry_date >= '$date'";
  }

  if (!empty($_POST['product'])) {
    $product = $_POST['product'];
    $sql .= " AND warranty.product LIKE '%$product%'";
  }
  $result = mysqli_query($db, $sql);
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

  
  <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="" class="flex items-center">
          
          
      </a>
      <div class="flex md:order-2">
      <div class="flex items-center">
                <a href="update.php" class="mr-6 text-sm  text-gray-500 dark:text-white hover:underline"><?php echo $user['username']; ?></h2></a><li></li>
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
  <style>
          body {
            margin-left:10px;
            margin-right:10px;
          }
          
     

      form fieldset input[type="text"],
      form fieldset input[type="date"],
      form fieldset input[type="submit"] {
        display: inline-block;
        width: 200px;
        margin-bottom: 10px;
      }
          input[type="text"],
          input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
          }
          
          input[type="submit"] {
            background-color: red;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
          }
          
          input[type="submit"]:hover {
            background-color: blue;
          }
          
          table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: white;
          }
          
          th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
          }
          
          th {
            background-color: gray;
            color: black;
          }
    </style>
    <br><br><br><br><br><br>
      <form action="index.php" method="POST">
 
        <fieldset>



<label for="phone">المتجر:</label>
<input type="text" name="phone" id="phone">

<label for="product">  المنتج:</label>
<input type="text" name="product" id="product">

<label for="date">تاريخ الانتهاء:</label>
<input type="date" name="date" id="date">

<input type="submit" name="submit" value="Search">

</fieldset>

      </form>

      <br><br>
      <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <th scope="col" class="px-6 py-3">Product</th>
          <th scope="col" class="px-6 py-3">Start Date</th>
          <th scope="col" class="px-6 py-3">Expiry Date</th>
          <th scope="col" class="px-6 py-3">Store</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td class="px-6 py-4"><?php echo $row['product']; ?></td>
          <td class="px-6 py-4"><?php echo $row['start_date']; ?></td>
          <td class="px-6 py-4"><?php echo $row['expiry_date']; ?></td>
          <td class="px-6 py-4"><?php echo $row['store']; ?></td>
        </tr>
        <?php endwhile; ?>
      </table>

    <style>

    body {
      font-family: Arial, sans-serif;
      margin-right:20px;
    }
    </style>

  </body>
</html>


