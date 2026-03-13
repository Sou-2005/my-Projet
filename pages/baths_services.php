<?php
include "../config/db.php";

$category = 'حمامات'; // الفئة الخاصة بهذه الصفحة

// جلب كل الخدمات من فئة الأطعام
$stmt = $conn->prepare("SELECT * FROM services WHERE category=? ORDER BY name ASC");
$stmt->execute([$category]);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>خدمات الحمامات - وادي سوف</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{font-family:Arial,sans-serif;background:#f8f9fa;}
.navbar{background:#089d32;color:white;padding:10px 20px;}
.card{border-radius:10px;overflow:hidden;margin-bottom:20px;transition:0.3s;}
.card:hover{transform:translateY(-5px);}
.card img{width:100%;height:200px;object-fit:cover;}
.img-thumbnails img{width:60px;height:60px;object-fit:cover;margin:2px;border-radius:5px;cursor:pointer;}
</style>
</head>
<body>

<nav class="navbar mb-4">
  <div class="container">
    <a href="../index.php" class="text-white">الرئيسية</a>
    <a href="services.php" class="text-white">الخدمات السياحية</a>
    <span class="text-white">/ الحمامات</span>
  </div>
</nav>

<div class="container">
<h2 class="mb-4">خدمات الحمامات</h2>

<!-- صندوق البحث -->
<input type="text" id="search" class="form-control mb-4" placeholder="ابحث عن خدمة الحمامات...">

<div class="row" id="services-row">
<?php foreach($services as $service):
    // جلب كل الصور المرتبطة بالخدمة
    $imgStmt = $conn->prepare("SELECT file_path,title FROM media WHERE related_id=? AND related_type='services'");
    $imgStmt->execute([$service['service_id']]);
    $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
    if(empty($images)) $images[0]['file_path'] = "../images/eloud.jpg";
?>
<div class="col-md-4 mb-4 service-card">
    <div class="card shadow h-100">
        <img src="<?= "../" . $images[0]['file_path'] ?>" alt="<?= $service['name'] ?>" class="main-img">
        <div class="card-body">
            <h5><?= $service['name'] ?></h5>
            <?php if(!empty($service['sub_category'])): ?>
            <p><strong>التصنيف الفرعي:</strong> <?= $service['sub_category'] ?></p>
            <?php endif; ?>
            <p><?= $service['description'] ?? 'لا توجد وصف' ?></p>
            <p><strong>العنوان:</strong> <?= $service['address'] ?></p>
            <p><strong>التواصل:</strong> <?= $service['contact'] ?></p>
            <a href="<?= $service['location'] ?>" target="_blank" class="btn btn-success">📍 الخريطة</a>

            <!-- الصور المصغرة -->
            <div class="img-thumbnails mt-2">
            <?php foreach($images as $img): ?>
                <img src="<?= "../" . $img['file_path'] ?>" alt="<?= $img['title'] ?? $service['name'] ?>">
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
</div>
</div>

<script>
// فلتر البحث
document.getElementById('search').addEventListener('input', function(){
    let query = this.value.toLowerCase();
    document.querySelectorAll('.service-card').forEach(card=>{
        let name = card.querySelector('h5').textContent.toLowerCase();
        card.style.display = name.includes(query) ? 'block' : 'none';
    });
});

// تغيير الصورة الرئيسية عند الضغط على الصور المصغرة
document.querySelectorAll('.card').forEach(card => {
    const mainImg = card.querySelector('.main-img');
    card.querySelectorAll('.img-thumbnails img').forEach(thumb => {
        thumb.addEventListener('click', () => mainImg.src = thumb.src);
    });
});
</script>

</body>
</html>