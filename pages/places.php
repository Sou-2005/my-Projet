<!DOCTYPE html>
<html lang="ar">
<head>

<meta charset="UTF-8">
<title>الأماكن السياحية</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
font-family:Arial;
background:#f5f5f5;
padding:30px;
}

/* الشريط العلوي */

.topbar{
display:flex;
justify-content:space-between;
align-items:center;
background:#1f2937;
padding:12px 20px;
border-radius:8px;
margin-bottom:40px;
}

.topbar a{
color:white;
text-decoration:none;
margin-right:10px;
padding:7px 14px;
background:#374151;
border-radius:5px;
}

.topbar a:hover{
background:#111827;
}

/* العنوان */

.title{
text-align:center;
margin-bottom:40px;
font-weight:bold;
}

/* شبكة الأزرار */

.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:25px;
}

/* بطاقة المكان */

.place-btn{
background:white;
border-radius:12px;
padding:35px;
text-align:center;
font-size:20px;
font-weight:bold;
text-decoration:none;
color:#333;
box-shadow:0 6px 15px rgba(0,0,0,0.1);
transition:0.3s;
}

.place-btn:hover{
transform:translateY(-8px);
box-shadow:0 12px 25px rgba(0,0,0,0.2);
}

/* ألوان مختلفة */

.natural{border-top:6px solid #22c55e;}
.cultural{border-top:6px solid #3b82f6;}
.archaeological{border-top:6px solid #a16207;}
.religious{border-top:6px solid #9333ea;}
.entertainment{border-top:6px solid #ef4444;}

</style>

</head>

<body>

<div class="topbar">

<div>
<a href="../index.php">الرئيسية</a>
<a href="services.php">الخدمات</a>
</div>

</div>

<h2 class="title">الأماكن السياحية في وادي سوف</h2>

<div class="grid">

<a href="natural_places.php" class="place-btn natural">
🌿 مكان طبيعي
</a>

<a href="cultural_places.php" class="place-btn cultural">
🏛 مكان ثقافي
</a>

<a href="archaeological_places.php" class="place-btn archaeological">
🗿 مكان أثري
</a>

<a href="religious_places.php" class="place-btn religious">
🕌 مكان ديني
</a>

<a href="entertainment_places.php" class="place-btn entertainment">
🎡 مكان ترفيهي
</a>

</div>

</body>
</html>