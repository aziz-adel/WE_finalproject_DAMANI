<?php
session_start();

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'd-project');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Search functionality
$searchQuery = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($db, $_GET['search']);
    $searchQuery = " WHERE name LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'";
}

// Verify/unverify store
if (isset($_GET['store_id']) && isset($_GET['action'])) {
    $store_id = mysqli_real_escape_string($db, $_GET['store_id']);
    $action = $_GET['action'];

    if ($action == "verify") {
        $query = "UPDATE stores SET verified=1 WHERE store_id='$store_id'";
    } elseif ($action == "unverify") {
        $query = "UPDATE stores SET verified=0 WHERE store_id='$store_id'";
    } else {
        die("Invalid action.");
    }

    if (mysqli_query($db, $query)) {
        echo "Verification status updated successfully!";
    } else {
        echo "Error updating verification status: " . mysqli_error($db);
    }
}

// Fetch all stores with search filtering
$result = mysqli_query($db, "SELECT store_id, name, email, verified FROM stores" . $searchQuery);

// Count unread messages
$unreadCountResult = mysqli_query($db, "SELECT COUNT(*) AS unread_count FROM messages WHERE status = 0");
$unreadCountRow = mysqli_fetch_assoc($unreadCountResult);
$unreadCount = $unreadCountRow['unread_count'];

// Count verified stores
$verifiedStoresResult = mysqli_query($db, "SELECT COUNT(*) AS verified_count FROM stores WHERE verified = 1");
$verifiedStoresRow = mysqli_fetch_assoc($verifiedStoresResult);
$verifiedCount = $verifiedStoresRow['verified_count'];

// Count unverified stores
$unverifiedStoresResult = mysqli_query($db, "SELECT COUNT(*) AS unverified_count FROM stores WHERE verified = 0");
$unverifiedStoresRow = mysqli_fetch_assoc($unverifiedStoresResult);
$unverifiedCount = $unverifiedStoresRow['unverified_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

header {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px;
    position: relative;
}


a.logout-link {
    position: absolute;
    top: 10px;
    right: 10px;
    text-decoration: none;
    color: white;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 2px #888888;
}

h1 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #333;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

form {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}


input[type="text"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: 10px; 
}


button {
    background-color: #333;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    margin-left: -220px; 
}

button:hover {
    background-color: #555;
}

a {
    text-decoration: none;
    color: #333;
}

a:hover {
    text-decoration: underline;}
    img {
position: absolute;

height: 50px; 
margin-right: 1rem; 
.custom-logo {
height: 30px; 
width: auto; 
position: absolute; 


}
}

.d-container {
    display: flex;
    justify-content: center; 
    align-items: center; 
    gap: 0;
    margin-top: 10px;
}

.s-container {
    text-align: center;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 2px #888888;
    width: 200px; 
    height: 200px; 
    margin: 0; 
    display: flex;
    justify-content: center; 
    align-items: center; 
    flex-direction: column; 
}
.container.square {
    background-color: #f2f2f2;
    margin: 10px;
    text-align: center;
}

    </style>
    <header>
        <a href="admin_logout.php" class="logout-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <h1>Admin Dashboard</h1>
    </header>

    <div class="d-container">
    <div class="container square">
        <a href="messages.php" >
        <h3>Unread Messages: </h3>
        <h3 style="color: orange;"><?php echo $unreadCount; ?></h3>
        </a>
    </div>

  
    <div class="container square">
        <h3>Verified Stores:</h3>
        <h3 style="color: green;"><?php echo $verifiedCount; ?></h3>
    </div>

    
    <div class="container square">
        <h3>Unverified Stores:</h3>
        <h3 style="color: red;"> <?php echo $unverifiedCount; ?></h3>
    </div>
</div>
   

    <div class="container">
    
      
        <form action="admin_dashboard.php" method="get">
        <img src="img/logo.png"class="custom-logo">
        <br><br><br>
            <input type="text" name="search" placeholder="Search..." value="<?php echo (isset($_GET['search']) ? $_GET['search'] : ''); ?>">
            <button type="submit">Search</button><br><br><br>
        </form>
        <h2>All Stores:</h2>
        <table>
            <thead>
                <tr>
                    <th>Store Name</th>
                    <th>Email</th>
                    <th>Verification Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><a href='store_warranties.php?store_id=<?php echo $row['store_id']; ?>'><?php echo $row['name']; ?></a></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo ($row['verified'] ? "Verified" : "Not Verified"); ?></td>
                        <td>
                            <?php
                            if ($row['verified']) {
                                echo "<a href='admin_dashboard.php?store_id=" . $row['store_id'] . "&action=unverify' style='color: red;'>Unverify</a>";
                            } else {
                                echo "<a href='admin_dashboard.php?store_id=" . $row['store_id'] . "&action=verify' style='color: green;'>Verify</a>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
       
    </div>
</body>
</html>
