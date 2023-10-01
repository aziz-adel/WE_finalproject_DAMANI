<?php
// Database connection
$db = mysqli_connect('localhost','root', '', 'd-project');
if(!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($db, $_POST['username']); // Escape special characters
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert into database
    $query = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";
    
    if (mysqli_query($db, $query)) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    }   
}

?>

<form action="admin_regst.php" method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Register">
</form>
<a href="admin_login.php">login</a>