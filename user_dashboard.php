
    <?php
// Session start
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location:login.php');
    exit();
}

$db = mysqli_connect('localhost', 'root', '', 'd-project');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$stmt = mysqli_prepare($db, "SELECT * FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

$user_id = $_SESSION['user_id'];

$sql = "SELECT warranty.product, warranty.start_date, warranty.expiry_date, stores.name AS store FROM warranty JOIN stores ON warranty.store_id = stores.store_id WHERE warranty.user_id = $user_id";
if (!empty($_POST['store'])) {
    $store = mysqli_real_escape_string($db, $_POST['store']);
    $sql .= " AND stores.name LIKE '%$store%'";
}

if (!empty($_POST['date'])) {
    $date = mysqli_real_escape_string($db, $_POST['date']);
    $sql .= " AND warranty.start_date <= '$date' AND warranty.expiry_date >= '$date'";
}

if (!empty($_POST['product'])) {
    $product = mysqli_real_escape_string($db, $_POST['product']);
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
    <link rel="stylesheet" href="css/user_dashboard.css">
    <meta charset="UTF-8">
    <title>الرئيسية</title>
</head>
<body>
<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="home.php" class="flex items-center">
      <img src="img/logo.png" class="h-8 mr-3" >
      
  </a>
  <div class="flex md:order-2">
  <div class="flex items-center">

            <a href="user_update.php" class="mr-6 text-sm  text-gray-500 dark:text-white hover:underline"><h1><?php echo $user['username']; ?></h1></a>
            <a href="logout.php" class="text-sm  text-blue-600 dark:text-blue-500 hover:underline">تسجيل خروج</a>
        </div>
    </nav>

    <br><br><br><br><br><br>
    <form action="user_dashboard.php" method="POST">
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

    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <!-- Table headers here -->
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th scope="col" class="px-6 py-3">المتجر</th>
            <th scope="col" class="px-6 py-3">المنتج</th>
            <th scope="col" class="px-6 py-3">تاريخ الشراء</th>
            <th scope="col" class="px-6 py-3">تاريخ الانتهاء</th>
            <th scope="col" class="px-6 py-3">الايام المتبقية</th>
            <th scope="col" class="px-6 py-3">الحالة</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php 
                $today = new DateTime();
                $expiry_date = new DateTime($row['expiry_date']);
                $days_to_expire = $today->diff($expiry_date)->days * ($today <= $expiry_date ? 1 : -1);
                $status = $days_to_expire < 1 ? 'غير فعال' : 'فعال';
                $statusClass = $days_to_expire < 1 ? 'text-red-500' : 'text-green-500';
            ?>
            <tr>
                <td class="px-6 py-4"><?php echo $row['store']; ?></td>
                <td class="px-6 py-4"><?php echo $row['product']; ?></td>
                <td class="px-6 py-4"><?php echo $row['start_date']; ?></td>
                <td class="px-6 py-4"><?php echo $row['expiry_date']; ?></td>
                <td class="px-6 py-4"><?php echo $days_to_expire >= 0 ? $days_to_expire : 'منتهي'; ?></td>
                <td class="px-6 py-4 <?php echo $statusClass; ?>"><?php echo $status; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
