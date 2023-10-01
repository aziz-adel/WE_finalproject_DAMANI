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

// Fetch all stores
$result = mysqli_query($db, "SELECT store_id, name, email, verified FROM stores");

echo "<h1>Welcome, " . $_SESSION['username'] . "!</h1>";
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
