<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>تسجيل الخروج - وادي سوف</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body {
    margin:0;
    font-family: Arial, sans-serif;
    background: #f3f4f6;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* الشريط العلوي */
.topbar {
    position: fixed;
    top:0;
    width:100%;
    background:#111;
    color:white;
    padding:15px 30px;
    display:flex;
    justify-content: space-between;
    align-items: center;
    z-index:10;
}
.topbar a {
    color:white;
    text-decoration:none;
    font-weight:bold;
    margin-left:20px;
}
.topbar a:hover { text-decoration: underline; }

/* صندوق تسجيل الخروج */
.logout-box {
    background:white;
    padding:50px 40px;
    border-radius:20px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    text-align:center;
    max-width:400px;
    width:90%;
    transition:0.4s;
}
.logout-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
}
.logout-box i {
    font-size:50px;
    color:#2563eb;
    margin-bottom:20px;
}
.logout-box h2 {
    font-size:24px;
    margin-bottom:20px;
}
.logout-box p {
    color:#555;
    margin-bottom:25px;
}
.logout-box a.btn {
    display:inline-block;
    padding:12px 25px;
    background:#2563eb;
    color:white;
    font-weight:bold;
    border-radius:10px;
    text-decoration:none;
    transition:0.3s;
}
.logout-box a.btn:hover {
    opacity:0.85;
    transform:translateY(-2px);
}
</style>
</head>
<body>

<div class="topbar">
    تسجيل الخروج
    <a href="../index.php"><i class="fa fa-arrow-right"></i> العودة للصفحة الرئيسية</a>
</div>

<div class="logout-box">
    <i class="fa fa-user-slash"></i>
    <h2>تم تسجيل الخروج بنجاح</h2>
    <p>شكراً لاستخدامك لوحة التحكم. يمكنك العودة للصفحة الرئيسية أو تسجيل الدخول مرة أخرى.</p>
    <a href="login.php" class="btn"><i class="fa fa-user-plus"></i> تسجيل الدخول</a>
</div>

</body>
</html>