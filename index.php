<!DOCTYPE html>
<html lang="ar">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta charset="UTF-8">
    <title>وادي سوف</title>
    <link rel="stylesheet" href="index.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* ====== Navbar ====== */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 15px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.4);
            z-index: 10;
        }
        .navbar h2 { color: white; }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; font-size: 15px; }
        .navbar a:hover { text-decoration: underline; }

        /* ====== Hero Section ====== */
        .hero {
            height: 100vh;
            background-image: url("images/eloud8.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero-content h1 { color: white; font-size: 52px; text-shadow: 0 4px 10px rgba(0,0,0,0.8); }
        .hero-content p { color: #f1f1f1; font-size: 22px; margin-top: 15px; text-shadow: 0 3px 8px rgba(0,0,0,0.8); }

        /* ====== Hamburger Button ====== */
        .hamburger {
            font-size: 30px;
            cursor: pointer;
            position: fixed;
            top: 15px;
            right: 20px;
            z-index: 1001;
            color: #2563eb;
        }

        /* ====== Sidebar ====== */
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.4s;
            padding-top: 60px;
            z-index: 1000;
            color: white;
        }
        .sidebar-header {
            position: absolute;
            top: 0;
            width: 100%;
            background-color: #2563eb;
            padding: 20px;
            text-align: center;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 30px;
            cursor: pointer;
        }
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            margin-top: 50px;
            padding-left: 20px;
        }
        .sidebar-nav a {
            padding: 15px 20px;
            text-decoration: none;
            color: white;
            font-size: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: 0.2s;
        }
        .sidebar-nav a:hover { background-color: #2563eb; border-radius: 5px; }
        /* زر تسجيل الدخول */
.login-btn{
    background:#2563eb;
    padding:10px 14px;
    border-radius:50%;
    margin-left:20px;
    transition:0.3s;
}

.login-btn i{
    color:white;
    font-size:16px;
}

.login-btn:hover{
    background:#1e4ed8;
    transform:scale(1.1);
}
/* زر تسجيل الدخول */
.login-link{
    font-size:16px;
    padding:10px 15px;
}

.login-link i{
    font-size:15px;
}
    </style>
</head>
<body>

<!-- زر الهامبرغر -->
<div id="hamburger" class="hamburger">&#9776;</div>

<!-- الشريط الجانبي -->
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <h2>لوحة التحكم</h2>
        <span id="closeBtn" class="close-btn">&times;</span>
    </div>
    <nav class="sidebar-nav">
        <!-- زر تسجيل الدخول -->
    <a href="Admin/login.php" class="login-link">
        <i class="fa-solid fa-user-plus"></i>
    </a>
        <a href="Admin/dashboard.php">الرئيسية</a>
        <a href="Admin/admin.php">الإدارة</a>
    </nav>
</div>

<header class="navbar">
    <h2>Oued Souf</h2>
    <nav>
    <a href="index.php">الرئيسية</a>
    <a href="info.html">معلومات عامة</a>
    <a href="pages/heritage.php">الموروث الثقافي</a>
    <a href="pages/places.php">أماكن سياحية</a>
    <a href="pages/services.php">خدمات سياحية</a>
</nav>
</header>

<section class="hero">
    <div class="hero-content">
        <h1>اكتشف سحر وادي سوف</h1>
        <p>مدينة الألف قبة وعبق التاريخ</p>
    </div>
</section>

<!-- ======= JavaScript ======= -->
<script>
const hamburger = document.getElementById("hamburger");
const sidebar = document.getElementById("sidebar");
const closeBtn = document.getElementById("closeBtn");
hamburger.addEventListener("click", () => {
    sidebar.style.width = "250px";
});

closeBtn.addEventListener("click", () => {
    sidebar.style.width = "0";
});

// إغلاق الشريط عند النقر في أي مكان خارج الشريط
window.addEventListener("click", (e) => {
    if (e.target !== sidebar && e.target !== hamburger && !sidebar.contains(e.target)) {
        sidebar.style.width = "0";
    }
});
</script>

</body>
</html>