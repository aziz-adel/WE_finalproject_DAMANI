<?php
session_start();

// Database connection
$db = mysqli_connect('localhost','root', '', 'd-project');
if(!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure admin is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$searchQuery = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($db, $_GET['search']);
    $searchQuery = " WHERE name LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'";
}

// If an action to verify/unverify a store is triggered
if(isset($_GET['store_id']) && isset($_GET['action'])) {
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

echo '<form action="admin_dashboard.php" method="get">
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-3xl font-bold">Welcome, ' . $_SESSION['username'] . '!</h1>
        <div class="flex items-center">
            <input type="text" name="search" placeholder="Search..." class="mr-2 p-2 border rounded" value="'.(isset($_GET['search']) ? $_GET['search'] : '').'">
            <button type="submit" class="flex items-center">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form>';

echo "<h2>All Stores:</h2>";
echo "<table border='1'>";
echo "<tr><th>Store Name</th><th>Email</th><th>Verification Status</th><th>Action</th></tr>";

while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . ($row['verified'] ? "Verified" : "Not Verified") . "</td>";
    echo "<td>";
    if ($row['verified']) {
        echo "<a href='admin_dashboard.php?store_id=".$row['store_id']."&action=unverify'>Unverify</a>";
    } else {
        echo "<a href='admin_dashboard.php?store_id=".$row['store_id']."&action=verify'>Verify</a>";
    }
    echo "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br><a href='logout.php'>Logout</a>";
?>
