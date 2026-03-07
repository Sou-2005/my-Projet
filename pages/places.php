<?php
include "../config/db.php";

// جلب كل الأماكن
$stmt = $conn->query("SELECT * FROM places");
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>الأماكن السياحية</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
}
.navbar {
    background-color: #089d32;
    color: white;
    padding: 10px 20px;
}
.card {
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s;
}
.card:hover {
    transform: translateY(-5px);
}
.card img {
    object-fit: cover;
    width: 100%;
    height: 200px;
    cursor: pointer;
    transition: transform 0.3s;
}
.card img:hover {
    transform: scale(1.05);
}
.img-thumbnails img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    margin: 2px;
    cursor: pointer;
    border-radius: 5px;
    transition: transform 0.2s;
}
.img-thumbnails img:hover {
    transform: scale(1.1);
    border: 2px solid #007bff;
}
/* Lightbox */
#lightbox {
    position: fixed;
    display: none;
    justify-content: center;
    align-items: center;
    top:0; left:0;
    width:100%; height:100%;
    background: rgba(0,0,0,0.8);
    z-index: 9999;
}
#lightbox img {
    max-width: 90%;
    max-height: 90%;
    border-radius: 10px;
}
</style>
</head>
<body>
<nav class="navbar mb-4">
   
<div class="container">
<a href="../index.php"class="navbar-brand text-white">الصفحة الرئيسية </a>

<a href="../index.php" class="navbar-brand text-white">🌴 سياحة وادي سوف</a>

<a href="../heritage.html" class="btn btn-light">الموروث الثقافي </a>


<a href="services.php" class="btn btn-light">الخدمات السياحية </a>

<a href="../info.html" class="btn btn-light">المعلومات العامة </a>
</div>


<div class="container">
    <h2 class="mb-4">الأماكن السياحية</h2>
    <div class="row">
        <?php while($place = $stmt->fetch(PDO::FETCH_ASSOC)):

            // جلب الصور الخاصة بالمكان (3 صور)
            $imgStmt = $conn->prepare("SELECT file_path FROM media WHERE related_type='places' AND related_id=? LIMIT 6");
            $imgStmt->execute([$place['place_id']]);
            $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);

            // إضافة ../ للصور لأن الصفحة داخل pages/
            foreach($images as &$img){
                $img['file_path'] = "../" . $img['file_path'];
            }

            // إذا لم توجد صور ضع صورة افتراضية
            if(empty($images)){
                $images[0]['file_path'] = "../images/eloud.jpg";
            }
        ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <!-- الصورة الرئيسية -->
                <img src="<?= $images[0]['file_path']; ?>" alt="<?= $place['name']; ?>" class="main-img">

                <div class="card-body">
                    <h5 class="card-title"><?= $place['name']; ?></h5>
                    <p class="card-text"><?= $place['description']; ?></p>
                    <p class="card-text"><strong>العنوان:</strong> <?= $place['address']; ?></p>
                    <a href="<?= $place['maps_link']; ?>" target="_blank" class="btn btn-success mt-2">📍 الخريطة</a>

                    <!-- الصور المصغرة -->
                    <?php if(count($images) > 1): ?>
                    <div class="img-thumbnails mt-2">
                        <?php foreach(array_slice($images, 0, 3) as $img): ?>
                            <img src="<?= $img['file_path']; ?>" class="thumb-img" alt="<?= $place['name']; ?>">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox"><img src="" alt="Lightbox"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// تغيير الصورة الرئيسية عند الضغط على المصغرات
document.querySelectorAll('.card').forEach(card => {
    const mainImg = card.querySelector('.main-img');
    card.querySelectorAll('.thumb-img').forEach(thumb => {
        thumb.addEventListener('click', () => {
            mainImg.src = thumb.src;
        });
    });
});
// Lightbox عند الضغط على أي صورة
const lightbox = document.getElementById('lightbox');
const lightboxImg = lightbox.querySelector('img');

document.querySelectorAll('.main-img, .thumb-img').forEach(img => {
    img.addEventListener('click', () => {
        lightbox.style.display = 'flex';
        lightboxImg.src = img.src;
    });
});

lightbox.addEventListener('click', () => {
    lightbox.style.display = 'none';
});
</script>
</body>
</html>