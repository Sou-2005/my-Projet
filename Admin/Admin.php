<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>لوحة إدارة الموقع - وادي سوف</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #1f1f1f; /* خلفية داكنة */
    margin:0;
    color: #f1f1f1;
}

.header {
    background: #111; /* داكن جدا */
    color: #f1f1f1;
    padding: 20px 30px;
    text-align: center;
    position: relative;
    font-size: 24px;
    font-weight: bold;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.logout-btn {
    position: absolute;
    right: 30px;
    top: 20px;
    background: #e74c3c; /* أحمر هادئ */
    border:none;
    padding: 10px 20px;
    color:white;
    cursor:pointer;
    border-radius: 8px;
    font-size: 16px;
    transition: 0.3s;
}
.logout-btn:hover {
    background: #c0392b;
}

.container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    padding: 50px 30px;
    max-width: 1200px;
    margin: auto;
}

/* البطاقة */
.card {
    position: relative;
    background: #2c2c2c; /* رمادي غامق */
    border-radius: 20px;
    padding: 40px 20px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.5);
    transition: transform 0.4s, box-shadow 0.4s;
    overflow: hidden;
}
.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.7);
}
.card h3 {
    margin-bottom: 25px;
    font-size: 20px;
    color: #ffffff;
}
.card button {
    padding: 15px 30px;
    border:none;
    border-radius: 50px;
    background: #2563eb; /* أزرق عصري */
    color:white;
    font-weight:bold;
    font-size:16px;
    cursor:pointer;
    transition: 0.3s;
}
.card button:hover {
    background: #1c4fb8;
    transform: scale(1.05);
}
/* زر الدخول للكارت */
.card-btn {
    margin-top:10px;
    padding:10px 15px;
    border:none;
    border-radius:8px;
    background:#2563eb;
    color:white;
    cursor:pointer;
    transition:0.3s;
}
.card-btn:hover {
    opacity:0.85;
}
/* الشريط العلوي */
.topbar {
    background:#111;
    color:white;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.topbar a, .topbar button {
    color:white;
    text-decoration:none;
    margin-left:20px;
    font-weight:bold;
    border:none;
    background:none;
    cursor:pointer;
}
body {
    font-family: Arial, sans-serif;
    background: #f3f4f6;
    margin:0;
    padding:0;
}
</style>
</head>
<body>

<div class="topbar">
    <div>لوحة التحكم الرئيسية</div>
    <div>
        <button onclick="location.href='../index.php'">رجوع للوحة التحكم</button>
        <form method="POST" style="display:inline;">
    </div>        
<!-- زر تسجيل الخروج -->
    <form method="POST" style="display:inline;">
    </form>
    </div>
       <button class="card-btn" onclick="location.href='../Admin/logout.php'"> تسجيل الخروج</button>
    </div>
</div>

<?php
if(isset($_POST['logout'])){
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<div class="container">
    <div class="card">
        <h3>إدارة الأماكن السياحية</h3>
        <button onclick="location.href='places/places_dashboard.php'">اذهب للإدارة</button>
    </div>

    <div class="card">
        <h3>إدارة الخدمات السياحية</h3>
        <button onclick="location.href='../Admin/adservices.php'">اذهب للإدارة</button>
    </div>

    <div class="card">
        <h3>إدارة الوسائط</h3>
        <button onclick="location.href='../Admin/Admedia.php'">اذهب للإدارة</button>
    </div>

    <div class="card">
        <h3>إدارة الموروث الثقافي</h3>
        <button onclick="location.href='../Admin/adheritage.php'">اذهب للإدارة</button>
    </div>
</div>

</body>
</html>