<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Warranties</title>
    
    <!-- Add a link to a CSS file for icon fonts (e.g., Font Awesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
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
            position: relative; /* Added position relative */
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

        a {
            text-decoration: none;
            color: #333;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Style for the search input and button */
        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-button {
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #555;
        }

        /* Style for search error message */
        .search-error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Style for the back-to-dashboard link */
        .back-to-dashboard {
            position: absolute;
            top: 10px;
            right: 10px;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    // Database connection
    $db = mysqli_connect('localhost', 'root', '', 'd-project');
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the store_id is provided in the URL
    if (isset($_GET['store_id'])) {
        $store_id = mysqli_real_escape_string($db, $_GET['store_id']);

        // Fetch store information
        $storeQuery = "SELECT * FROM stores WHERE store_id='$store_id'";
        $storeResult = mysqli_query($db, $storeQuery);
        $store = mysqli_fetch_assoc($storeResult);

        // Initialize search variables
        $searchTerm = "";
        $searchQuery = "";

        // Check if a search query is provided
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = mysqli_real_escape_string($db, $_GET['search']);
            // Modify the SQL query to search by product name or warranty ID
            $searchQuery = " WHERE product LIKE '%$searchTerm%' OR warranty_id='$searchTerm'";
        }

        // Fetch warranties for the selected store with the search filter
        $warrantyQuery = "SELECT * FROM warranty WHERE store_id='$store_id'" . $searchQuery;
        $warrantyResult = mysqli_query($db, $warrantyQuery);

        // Check if any warranties were found
        $numWarranties = mysqli_num_rows($warrantyResult);

        if ($numWarranties === 0) {
            $searchError = "No warranties found for the provided search term.";
        }
    } else {
        // If store_id is not provided, redirect to admin_dashboard.php or display an error
        header("Location: admin_dashboard.php");
        exit;
    }
    ?>

    <header>
        <h1>Store Warranties for <?php echo $store['name']; ?></h1>
        <p>Email: <?php echo $store['email']; ?></p>
        
        <!-- Add an icon and a link to go back to the admin dashboard -->
        <a href="admin_dashboard.php" class="back-to-dashboard">
        Back to Admin Dashboard  <i class="fas fa-arrow-right"></i> 
        </a>
    </header>

    <div class="container">
        <!-- Search form -->
        <div class="search-container">
            <form action="store_warranties.php?store_id=<?php echo $store_id; ?>" method="get">
                <input type="text" class="search-input" name="search" placeholder="Search by Product Name or ID" value="<?php echo $searchTerm; ?>">
                <button class="search-button" type="submit">Search</button>
            </form>
        </div>

        <!-- Display search error message if any -->
        <?php if (isset($searchError)) { ?>
            <p class="search-error"><?php echo $searchError; ?></p>
        <?php } ?>

        <!-- Display warranties if found -->
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
            <!-- Display no warranties found message -->
            <p class="search-error">No warranties found for the provided search term.</p>
        <?php } ?>
    </div>
</body>
</html>
