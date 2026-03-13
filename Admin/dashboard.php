<?php
session_start();
include "../config/db.php";

// حماية الصفحة: فقط المسؤول يمكنه الدخول
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// زر تسجيل الخروج
if(isset($_POST['logout'])){
    session_destroy();
    header("Location: login.php");
    exit();
}

// ====== حساب الإحصائيات بدقة ======

// الخدمات السياحية حسب الفئة
function countServiceCategory($conn,$category){
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM services WHERE category=?");
    $stmt->execute([$category]);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}
$servicesCounts = [
    'حمامات' => countServiceCategory($conn,'حمامات'),
    'نقل' => countServiceCategory($conn,'نقل'),
    'وكالات' => countServiceCategory($conn,'وكالات'),
    'مطاعم' => countServiceCategory($conn,'اطعام'),
    'اقامات' => countServiceCategory($conn,'اقامات')
];

// الأماكن السياحية
function countPlaceCategory($conn,$category){
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM places WHERE category=?");
    $stmt->execute([$category]);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}
$placesCounts = [
    'أثرية' => countPlaceCategory($conn,'اثري'),
    'طبيعية' => countPlaceCategory($conn,'طبيعي'),
    'ترفيهية' => countPlaceCategory($conn,'ترفيهي'),
    'دينية' => countPlaceCategory($conn,'ديني'),
    'ثقافية' => countPlaceCategory($conn,'ثقافي')
];

// الموروث الثقافي
function countHeritageCategory($conn,$category){
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM cultural_heritage WHERE category=?");
    $stmt->execute([$category]);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}
$heritageCounts = [
    'لباس تقليدي' => countHeritageCategory($conn,'لباس تقليدي'),
    'اكل تقليدي' => countHeritageCategory($conn,'اكل تقليدي'),
    'حلويات تقليدية' => countHeritageCategory($conn,'حلويات تقليدية'),
    'مشروبات تقليدية' => countHeritageCategory($conn,'مشروبات  تقليدية '),
    'الحرف والصناعات التقليدية' => countHeritageCategory($conn,'الحرف والصناعات التقليدية'),
    'تظاهرات' => countHeritageCategory($conn,'تظاهرات'),
        'استعراضات' => countHeritageCategory($conn,'استعراضات')

];

// الوسائط
function countMediaCategory($conn,$type){
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM media WHERE media_type=?");
    $stmt->execute([$type]);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}
$mediaCounts = [
    'صور' => countMediaCategory($conn,'image'),
    'فيديوهات' => countMediaCategory($conn,'video')
];
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>لوحة التحكم الرئيسية - وادي سوف</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f3f4f6;
    margin:0;
    padding:0;
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

/* الشبكة */
.dashboard-grid {
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap:30px;
    max-width:1200px;
    margin:50px auto;
    padding:0 20px;
}

/* الكروت ثلاثية الأبعاد */
.card-3d {
    background:#fff;
    border-radius:15px;
    padding:20px;
    text-align:center;
    box-shadow:0 10px 20px rgba(0,0,0,0.2);
    transition:0.4s;
    cursor:pointer;
    position:relative;
}
.card-3d:hover {
    transform: translateY(-10px);
    box-shadow:0 15px 35px rgba(0,0,0,0.3);
}

/* العنوان والعدد */
.card-title {
    font-size:22px;
    font-weight:bold;
    margin-bottom:15px;
    color:#2563eb;
}
.card-count {
    font-size:36px;
    font-weight:bold;
    margin-bottom:15px;
    color:#111;
}

/* الرسم البياني داخل الكارت */
.card-chart {
    width:100%;
    height:150px;
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
</style>
</head>

<body>

<div class="topbar">
    <div>لوحة التحكم الرئيسية</div>
    <div>
        <button onclick="location.href='../index.php'">رجوع للوحة التحكم</button>
        <form method="POST" style="display:inline;">
<!-- زر تسجيل الخروج -->
    <form method="POST" style="display:inline;">
</form>
</div>
       <button class="card-btn" onclick="location.href='../Admin/logout.php'"> تسجيل الخروج</button>
    </div>
</div>

<div class="dashboard-grid">
    <!-- خدمات سياحية -->
    <div class="card-3d">
        <div class="card-title">الخدمات السياحية</div>
        <div class="card-count"><?= array_sum($servicesCounts) ?></div>
        <canvas id="chartServices" class="card-chart"></canvas>
        <button class="card-btn" onclick="location.href='services/services_admin.php'">ادارة الخدمات</button>
    </div>

    <!-- أماكن سياحية -->
    <div class="card-3d">
        <div class="card-title">الأماكن السياحية</div>
        <div class="card-count"><?= array_sum($placesCounts) ?></div>
        <canvas id="chartPlaces" class="card-chart"></canvas>
         <button class="card-btn" onclick="location.href='places/places_admin.php'">ادارة الأماكن</button>
    </div>

    <!-- الموروث الثقافي -->
    <div class="card-3d">
        <div class="card-title">الموروث الثقافي</div>
        <div class="card-count"><?= array_sum($heritageCounts) ?></div>
        <canvas id="chartHeritage" class="card-chart"></canvas>
        <button class="card-btn" onclick="location.href='../Admin/adheritage.php'">ادارة الموروث</button>
    </div>

    <!-- الوسائط -->
    <div class="card-3d">
        <div class="card-title">الوسائط</div>
        <div class="card-count"><?= array_sum($mediaCounts) ?></div>
        <canvas id="chartMedia" class="card-chart"></canvas>
        <button class="card-btn" onclick="location.href='media/media_admin.php'">ادارة الوسائط</button>
    </div>
</div>

<script>
// الرسم البياني للخدمات
const ctxServices = document.getElementById('chartServices').getContext('2d');
new Chart(ctxServices, {
    type:'doughnut',
    data:{
        labels: <?= json_encode(array_keys($servicesCounts)) ?>,
        datasets:[{
            data: <?= json_encode(array_values($servicesCounts)) ?>,
            backgroundColor:['#2563eb','#111','#4B5563','#6B7280','#9CA3AF']
        }]
    },
    options:{ responsive:true, plugins:{ legend:{ position:'bottom' } } }
});

// الرسم البياني للأماكن
const ctxPlaces = document.getElementById('chartPlaces').getContext('2d');
new Chart(ctxPlaces, {
    type:'doughnut',
    data:{
        labels: <?= json_encode(array_keys($placesCounts)) ?>,
        datasets:[{
            data: <?= json_encode(array_values($placesCounts)) ?>,
            backgroundColor:['#2563eb','#111','#4B5563','#6B7280','#9CA3AF']
        }]
    },
    options:{ responsive:true, plugins:{ legend:{ position:'bottom' } } }
});

// الرسم البياني للموروث
const ctxHeritage = document.getElementById('chartHeritage').getContext('2d');
new Chart(ctxHeritage, {
    type:'doughnut',
    data:{
        labels: <?= json_encode(array_keys($heritageCounts)) ?>,
        datasets:[{
            data: <?= json_encode(array_values($heritageCounts)) ?>,
            backgroundColor:['#2563eb','#111','#4B5563','#6B7280','#9CA3AF','#1F2937']
        }]
    },
    options:{ responsive:true, plugins:{ legend:{ position:'bottom' } } }
});

// الرسم البياني للوسائط
const ctxMedia = document.getElementById('chartMedia').getContext('2d');
new Chart(ctxMedia, {
    type:'doughnut',
    data:{
        labels: <?= json_encode(array_keys($mediaCounts)) ?>,
        datasets:[{
            data: <?= json_encode(array_values($mediaCounts)) ?>,
            backgroundColor:['#2563eb','#111']
        }]
    },
    options:{ responsive:true, plugins:{ legend:{ position:'bottom' } } }
});
</script>

</body>
</html>