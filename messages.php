<?php

session_start();

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'd-project');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

//message status
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($db, $_GET['id']);
    $currentStatus = mysqli_real_escape_string($db, $_GET['current_status']);
    $newStatus = $currentStatus == 0 ? 1 : 0;

    $query = "UPDATE messages SET status = $newStatus WHERE id = $id";
    if (mysqli_query($db, $query)) {
        echo $newStatus == 1 ? "<p>Message marked as read.</p>" : "<p>Message marked as unread.</p>";
    } else {
        echo "<p>Error changing message status: " . mysqli_error($db) . "</p>";
    }
}

$searchTerm = '';
$searchQuery = '';


if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($db, $_GET['search']);
    $searchQuery = " WHERE email LIKE '%$searchTerm%' OR phone_number LIKE '%$searchTerm%' OR subject LIKE '%$searchTerm%'";
}

// Fetch all messages with search filtering
$query = "SELECT * FROM messages" . $searchQuery . " ORDER BY status, id DESC";
$result = mysqli_query($db, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/store_warranties.css">
    <link rel="stylesheet" href="css/massages.css">
</head>
<body>

    <header>
        <h1>ALL MESSAGES</h1>
        <a href="admin_dashboard.php" class="back-to-dashboard">Back to Admin Dashboard<i class="fas fa-arrow-right"></i> </a>
    </header>
    
    <form method="GET">
        <input type="text" name="search" placeholder="Search messages..." value="<?php echo $searchTerm; ?>">
        <button type="submit">Search</button>
    </form>

    <div>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="message-container<?php echo $row['status'] == 0 ? ' unread' : ''; ?>">
                <p><strong>From:</strong> <?php echo htmlspecialchars($row['name']); ?> (<?php echo htmlspecialchars($row['email']); ?>)</p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($row['phone_number']); ?></p>
                <p><strong>Subject:</strong> <?php echo htmlspecialchars($row['subject']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                <p><strong>Status:</strong> <?php echo $row['status'] == 0 ? 'Unread' : 'Read'; ?></p>
                <a href="?toggle_status=true&id=<?php echo $row['id']; ?>&current_status=<?php echo $row['status']; ?>" class="mark-read">
                    <?php echo $row['status'] == 0 ? 'Mark as Read' : 'Mark as Unread'; ?>
                </a>
            </div>
        <?php endwhile; ?>
    </div>

</body>
</html>
