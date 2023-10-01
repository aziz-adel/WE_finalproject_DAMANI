<?php
// Database connection
$db = mysqli_connect('localhost','root', '', 'd-project');
if(!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = $_POST['password'];

    // Fetch password from database and verify
    $query = "SELECT password FROM admin WHERE username='$username'";
    $result = mysqli_query($db, $query);
    
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: admin_dashboard.php");
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Username not found!";
    }   
}

?>

<form action="admin_login.php" method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>
<a href="admin_regst.php">registeration</a>