<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new mysqli('localhost', 'root', '', 'd-project');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $stmt = $db->prepare("INSERT INTO messages (name, phone_number, email, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $phone_number, $email, $subject, $message);

    // Input validation and sanitization
    $name = htmlspecialchars($db->real_escape_string($_POST['name']));
    $phone_number = htmlspecialchars($db->real_escape_string($_POST['phone']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($db->real_escape_string($_POST['subject']));
    $message = htmlspecialchars($db->real_escape_string($_POST['message']));

    // Execute and provide feedback
    if ($stmt->execute()) {
        $feedback = "<div class='alert-success'>Message sent successfully</div>";
    } else {
        $feedback = "<div class='alert-error'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Contact Form</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .alert-success { color: green; }
        .alert-error { color: red; }
        input, textarea, button {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 100%;
            margin-top: 5px;
        }
        label { 
            display: block; 
            margin-bottom: 5px;
        }
        button { 
            width: auto; 
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .form-container {
            width: 800px; 
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background: #f9f9f9;
        }
        .back-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>


<div class="back-icon" onclick="window.history.back();">
    <i class="fas fa-arrow-right">العودة</i>
</div>

<div class="form-container">
    
    <form action="support.php" method="post">
        <div>
            <label for="name">الاسم</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="phone">رقم الهاتف</label>
            <input type="text" id="phone" name="phone">
        </div>
        <div>
            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email">
        </div>
        <div>
            <label for="subject">الموضوع</label>
            <input type="text" id="subject" name="subject">
        </div>
        <div>
            <label for="message">الرسالة</label>
            <textarea id="message" name="message" style="height: 100px;"></textarea>
        </div>
        <?php if (isset($feedback)) echo $feedback; ?>
        <button type="submit">أرسل</button>
    </form>
</div>

</body>
</html>
