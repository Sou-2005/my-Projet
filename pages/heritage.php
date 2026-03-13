<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>الموروث الثقافي - وادي سوف</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
font-family:Arial;
background:#f4f6f9;
margin:0;
padding:0;
}

/* الشريط العلوي */

.topbar{
background:#111;
color:white;
padding:15px 30px;
display:flex;
justify-content:space-between;
align-items:center;
}

.topbar a{
color:white;
text-decoration:none;
margin-left:20px;
font-weight:bold;
}

/* العنوان */

.title{
text-align:center;
margin:40px 0;
font-size:32px;
font-weight:bold;
color:#333;
}

/* الشبكة */

.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:25px;
max-width:1100px;
margin:auto;
padding:20px;
}

/* البطاقة */

.card-box{
background:white;
border-radius:15px;
padding:35px 20px;
text-align:center;
box-shadow:0 8px 20px rgba(0,0,0,0.1);
transition:0.3s;
cursor:pointer;
text-decoration:none;
color:#333;
}

.card-box:hover{
transform:translateY(-5px);
box-shadow:0 15px 30px rgba(0,0,0,0.2);
background:#1f2937;
color:white;
}

/* الأيقونة */

.icon{
font-size:40px;
margin-bottom:15px;
}

</style>
</head>

<body>

<div class="topbar">
<div>الموروث الثقافي</div>

<div>
<a href="../index.php">الرئيسية</a>
<a href="places.php">الأماكن</a>
<a href="services.php">الخدمات</a>
</div>
</div>

<div class="title">
الموروث الثقافي لوادي سوف
</div>

<div class="grid">

<a href="traditional_clothes.php" class="card-box">
<div class="icon">👗</div>
لباس تقليدي
</a>

<a href="traditional_food.php" class="card-box">
<div class="icon">🍲</div>
اكل تقليدي
</a>

<a href="traditional_drinks.php" class="card-box">
<div class="icon">☕</div>
مشروبات تقليدية
</a>

<a href="traditional_sweets.php" class="card-box">
<div class="icon">🍯</div>
حلويات تقليدية
</a>

<a href="traditional_crafts.php" class="card-box">
<div class="icon">🧵</div>
حرف وصناعات تقليدية
</a>

<a href="events.php" class="card-box">
<div class="icon">🎭</div>
تظاهرات
</a>

</div>

</body>
</html>