
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Warranties</title>
    <link rel="stylesheet" href="#">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/store_warranties.css">
   
</head>
<body>
    <?php
    session_start();

    // Database connection
    $db = mysqli_connect('localhost', 'root', '', 'd-project');
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_GET['store_id'])) {
        $store_id = mysqli_real_escape_string($db, $_GET['store_id']);
        
        // Fetch store details
        $storeQuery = "SELECT * FROM stores WHERE store_id='$store_id'";
        $storeResult = mysqli_query($db, $storeQuery);
        $store = mysqli_fetch_assoc($storeResult);

        $searchTerm = "";
        $searchQuery = "";

        // Handle search
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = mysqli_real_escape_string($db, $_GET['search']);
            $searchQuery = " WHERE product LIKE '%$searchTerm%' OR warranty_id='$searchTerm'";
        }

        // Fetch warranties
        $warrantyQuery = "SELECT * FROM warranty WHERE store_id='$store_id'" . $searchQuery;
        $warrantyResult = mysqli_query($db, $warrantyQuery);
        $numWarranties = mysqli_num_rows($warrantyResult);

        if ($numWarranties === 0) {
            $searchError = "No warranties found for the provided search term.";
        }
    } else {
        header("Location: admin_dashboard.php");
        exit;
    }
    ?>

    <header>
        <h1>Store Warranties for <?php echo $store['name']; ?></h1>
        <p>Email: <?php echo $store['email']; ?></p>
        <a href="admin_dashboard.php" class="back-to-dashboard">Back to Admin Dashboard <i class="fas fa-arrow-right"></i></a>
    </header>

    <div class="container">
        <div class="search-container">
            <form action="store_warranties.php?store_id=<?php echo $store_id; ?>" method="get">
                <input type="text" class="search-input" name="search" placeholder="Search by Product Name or ID" value="<?php echo $searchTerm; ?>">
                <button class="search-button" type="submit">Search</button>
            </form>
        </div>

        <?php if (isset($searchError)) { ?>
            <p class="search-error"><?php echo $searchError; ?></p>
        <?php } ?>

        <?php if ($numWarranties > 0) { ?>
            <h2>Warranties:</h2>
            <table>
                <thead>
                    <tr>
                        <th>Warranty ID</th>
                        <th>Product</th>
                        <th>Start Date</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($warranty = mysqli_fetch_assoc($warrantyResult)) { ?>
                        <tr>
                            <td><?php echo $warranty['warranty_id']; ?></td>
                            <td><?php echo $warranty['product']; ?></td>
                            <td><?php echo $warranty['start_date']; ?></td>
                            <td><?php echo $warranty['expiry_date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="search-error">No warranties found for the provided search term.</p>
        <?php } ?>
    </div>
</body>
</html>
