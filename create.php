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





<?php 


if (isset($_POST['submit'])) {
    $product = $_POST['product'];
    $user_p = $_POST['phone'];
    $start_date = $_POST['start_date'];
    $expiry_date = $_POST['expiry_date'];
    $store_id = $_SESSION['store_id'];
    
    // Establish a database connection
    $db = mysqli_connect('localhost', 'root', '', 'd-project');
    
    // Prepare a statement to select the user ID from the users table using the provided phone number
    $user_id_stmt = mysqli_prepare($db, "SELECT user_id FROM users WHERE phone = ?");
    mysqli_stmt_bind_param($user_id_stmt, "s", $user_p);
    mysqli_stmt_execute($user_id_stmt);
    mysqli_stmt_bind_result($user_id_stmt, $user_id);
    mysqli_stmt_fetch($user_id_stmt);
    mysqli_stmt_close($user_id_stmt);
    
    // Prepare a statement to insert a new warranty record into the warranty table
    $warranty_stmt = mysqli_prepare($db, "INSERT INTO warranty (product, start_date, expiry_date, user_id, store_id) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($warranty_stmt, "ssssi", $product, $start_date, $expiry_date, $user_id,$store_id);
    mysqli_stmt_execute($warranty_stmt);
    
    // Check if the warranty record was successfully inserted
    if (mysqli_affected_rows($db) > 0) {
        echo "New warranty record created successfully.";
    } else {
        echo "Error inserting warranty record: " . mysqli_error($db);
    }
    
    // Close the database connection
    mysqli_close($db);
}

?>
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
            <a href="#4" class="mr-6 text-sm  text-gray-500 dark:text-white hover:underline"><?php echo $user['name']; ?></h2></a>
            <a href="logout.php" class="text-sm  text-blue-600 dark:text-blue-500 hover:underline">تسجيل خروج</a>
        </div>
  </div>
  <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
    <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
      <li><li></li>
        <a href="search.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">بحث</a>
      </li>
      <li><li></li>
        <a href="create.php" class="block py-2 pl-3 pr-4 text-blue-700 rounded hover:bg-blue-700 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">اضافة</a>
      </li>
      <li><li></li>
        <a href="view.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">عرض الضمانات </a>
      </li>
      <li><li></li>
        <a href="store_home.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">الرئيسية</a>
      </li>
    </ul>
  </div>
  </div>
</nav>   




</body>

</html>


<br><br><br><br><br><br>
<form action="" method="POST">

  <fieldset>

    <h3>اضافة ضمان</h3>

  رقم الهاتف:<br>

    <input type="text" name="phone">

    المنتج:<br>

<input type="text" name="product">


    تاريخ الشراء:<br>

    <input type="date" name="start_date">

    <br>

   تاريخ الانتهاء:<br>

    <input type="date" name="expiry_date">

    

    <br><br>

    <input type="submit" name="submit" value="اضافة الضمات">

  </fieldset>

</form>
<style>
 
    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      margin: 0 auto;
    }
    
    fieldset {
      border: none;
      margin: 0;
      padding: 0;
    }
    
    legend {
     font-size: 20px;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
    }
    
    label {
      display: block;
      margin-bottom: 10px;
      color: #333;
    }
    
    input[type="phone"],
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
      background-color: blue;
      color: #fff;
      padding: 20px 30px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }
    
   
  </style>

</body>

</html>