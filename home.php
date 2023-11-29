<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>صفحة الويب الرئيسية</title>
  <link rel="stylesheet" href="css/style.css">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</head>
<body>
  <header id = "home">

  <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="" class="flex items-center">
      <img src="img/logo.png" class="h-8 mr-3" >
      
  </a>
  <div class="flex md:order-2">
      <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><a href="#servec">تسجيل</a></button>
      <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
      </button>
  </div>
  <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
    <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
      <li>
        <a href="#conntact" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">اتصل بنا</a>
      </li>
      <li>
        <a href="#servec" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">خدماتنا</a>
      </li>
      <li>
        <a href="#" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">من نحن</a>
      </li>
      <li>
        <a href="#" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">الرئيسية</a>
      </li>
    </ul>
  </div>
  </div>
</nav>


</header>
  <main>
  <section></section>

 <section>
<div class="container">
    <img src="img/logo.png" class="h-40 mr-5" >
</div>
<h1>
  يهدف مشروعك إلى تطوير موقع إلكتروني يقدم خدمة
  الضمانات الإلكترونية للمتاجر والعملاء.<br>
  يساعد الموقع المتاجر في إصدار ضمانات
    إلكترونية للمنتجات التي يبيعوها،<br>
  ويوفر للعملاء إمكانية متابعة تفاصيل ضماناتهم، مثل تاريخ 
  الانتهاء وتفاصيل المنتج الذي تم شراؤه

</h1>
<div class="h-50 mr-9" class="container"></div>
</section>

<section></section>
<section></section>
<section id="servec">
<div class="container">
    <h2>خدماتنا</h2></div>
  <div class="container">
      <div class="box ">
        <p>يقدم الموقع للمتاجر خدمة<br> إصدار ضمانات إلكترونية للمنتجات التي يبيعوها. <br>يمكن للمتاجر إنشاء ضمانات جديدة وتعديلها وحذفها وفقًا لسياسة الضمان الخاصة </p>
        <a href="store_login.php"> تسجيل دخول المتاجر</a>
    </div>
      <div class="box">
      
        تسجيل دخول العملاء
            <p>            
              يتيح الموقع للعملاء متابعة تفاصيل ضماناتهم،<br> مثل تاريخ الانتهاء وتفاصيل المنتج الذي تم شراؤه. يمكن
            </p>
        <a href="user_login.php">تسجيل دخول العملاء</a>
      </div>
</div>
</section>
 <section></section> <section></section> <section></section>


<section id="conntact">
        <h2>اتصل بنا</h2>
    <div class="container">
      
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new mysqli('localhost', 'root', '', 'd-project');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $stmt = $db->prepare("INSERT INTO messages (name, phone_number, email, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $phone_number, $email, $subject, $message);

    $name = $db->real_escape_string($_POST['name']);
    $phone_number = $db->real_escape_string($_POST['phone']);
    $email = $db->real_escape_string($_POST['email']);
    $subject = $db->real_escape_string($_POST['subject']);
    $message = $db->real_escape_string($_POST['message']);

    if ($stmt->execute()) {
      echo "<script>alert('Message sent successfully');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>
    <form action="home.php" method="post" style="width: 800px;">
    <div style="margin-bottom: 10px;">
        <label for="name" style="display: block;">الاسم</label>
        <input type="text" id="name" name="name" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc; width: 100%;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="phone" style="display: block;">رقم الهاتف</label>
        <input type="phone" id="phone" name="phone" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc; width: 100%;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="email" style="display: block;">البريد الإلكتروني</label>
        <input type="email" id="email" name="email" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc; width: 100%;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="text" style="display: block;">الموضوع</label>
        <input type="text" id="text" name="subject" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc; width: 100%;">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="message" style="display: block;">الرسالة</label>
        <textarea id="message" name="message" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc; width: 100%; height: 100px;"></textarea>
    </div>
    <button type="submit" >أرسل </button>
</form>
</section> 
</div>

<footer>
    <div class="footer-container">
        
        <div class="footer-section">
            <h3>روابط سريعة</h3>
            <ul>
                <li><a href="#home">الرئيسية</a></li>
                <li><a href="#servec">خدماتنا</a></li>
                <li><a href="#contact">اتصل بنا</a></li>
            </ul>
        </div>
</footer>
  
</body>
</html>