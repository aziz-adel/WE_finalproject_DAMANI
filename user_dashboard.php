<?php
  // Session start
  session_start();
  
  if(!isset($_SESSION['user_id'])) {
      header('Location:login.php');
      exit();
  }
  
  $db = mysqli_connect('localhost','root', '', 'd-project');
  
  // Get the user's ID
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
</head>
<body>
    <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
        <!-- ... (rest of your navbar code) ... -->
    </nav>
    
    <br><br><br><br><br><br>
    <form action="index.php" method="POST">
        <fieldset>
            <label for="phone">المتجر:</label>
            <input type="text" name="phone" id="phone">
            <label for="product"> المنتج:</label>
            <input type="text" name="product" id="product">
            <label for="date">تاريخ الانتهاء:</label>
            <input type="date" name="date" id="date">
            <input type="submit" name="submit" value="Search">
        </fieldset>
    </form>
    <br><br>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th scope="col" class="px-6 py-3">Store</th>
            <th scope="col" class="px-6 py-3">Product</th>
            <th scope="col" class="px-6 py-3">Start Date</th>
            <th scope="col" class="px-6 py-3">Expiry Date</th>
            <th scope="col" class="px-6 py-3">Days to Expire</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <?php 
            $today = new DateTime();
            $expiry_date = new DateTime($row['expiry_date']);
            $days_to_expire = $today->diff($expiry_date)->days * ($today <= $expiry_date ? 1 : -1); 
        ?>
        <tr>
            <td class="px-6 py-4"><?php echo $row['store']; ?></td>
            <td class="px-6 py-4"><?php echo $row['product']; ?></td>
            <td class="px-6 py-4"><?php echo $row['start_date']; ?></td>
            <td class="px-6 py-4"><?php echo $row['expiry_date']; ?></td>
            <td class="px-6 py-4 <?php echo $days_to_expire <= 0 ? 'text-red-500' : ($days_to_expire <= 7 ? 'text-yellow-500' : ''); ?>">
                <?php echo $days_to_expire <= 0 ? 'Expired' : $days_to_expire; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
