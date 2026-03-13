<?php
include "../config/db.php";

// جلب معلومات عامة
$stmt = $conn->query("SELECT * FROM generall_information LIMIT 1");
$info = $stmt->fetch(PDO::FETCH_ASSOC);

// جلب الصور المرتبطة بالصفحة الرئيسية / المعلومات العامة
$mediaStmt = $conn->prepare("SELECT * FROM media WHERE related_type='generall_information' ORDER BY media_id ASC");
$mediaStmt->execute();
$images = $mediaStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>معلومات عامة - وادي سوف</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: Arial, sans-serif; background:#f3f4f6; margin:0; padding:0; }
.topbar{background:#111;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;}
.topbar a{color:white;text-decoration:none;margin-left:20px;font-weight:bold;transition:0.3s;}
.topbar a:hover{color:#2563eb;}
.info-section{max-width:1200px;margin:40px auto;padding:0 20px;}
.info-card{background:white;padding:25px;border-radius:15px;box-shadow:0 8px 25px rgba(0,0,0,0.1);margin-bottom:40px;}
.info-card h2{text-align:center;color:#2563eb;margin-bottom:25px;}
.info-card p{font-size:16px;line-height:1.7;margin-bottom:10px;}
.btn-tourism{background:#2563eb;color:white;border:none;padding:10px 20px;border-radius:8px;text-decoration:none;font-weight:bold;display:inline-block;margin-top:10px;transition:0.3s;}
.btn-tourism:hover{opacity:0.85;}

/* معرض الصور */
.gallery{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;margin:auto;margin-bottom:50px;}
.gallery-card{position:relative;overflow:hidden;border-radius:12px;cursor:pointer;transition:0.3s;background:white;box-shadow:0 8px 20px rgba(0,0,0,0.1);}
.gallery-card img{width:100%;height:180px;object-fit:cover;transition:0.4s;}
.gallery-card:hover img{transform:scale(1.05);}
.gallery-card span{position:absolute;bottom:10px;left:10px;background:rgba(0,0,0,0.6);color:white;padding:5px 10px;border-radius:5px;font-weight:bold;font-size:14px;}

/* عرض الصورة في نافذة عند الضغط */
#imgModal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.9);justify-content:center;align-items:center;z-index:999;}
#modalImg{max-width:90%; max-height:90%;border-radius:10px;}
</style>
</head>
<body>

<!-- شريط علوي -->
<div class="topbar">
    <div>معلومات عامة عن وادي سوف</div>
    <div>
        <a href="index.php">الرئيسية</a>
        <a href="pages/services.php">الخدمات</a>
        <a href="pages/places.php">الأماكن السياحية</a>
    </div>
</div>

<div class="info-section">
    <div class="info-card">
        <h2><?= htmlspecialchars($info['wilaya_name']) ?></h2>
        <p><strong>الوصف:</strong> <?= nl2br(htmlspecialchars($info['description'])) ?></p>
        <p><strong>مكتب السياحة:</strong> <?= htmlspecialchars($info['tourism_office']) ?></p>
        <p><strong>جهة الاتصال:</strong> <?= htmlspecialchars($info['contact']) ?></p>
        <?php if(!empty($info['maps_link'])): ?>
        <a href="<?= htmlspecialchars($info['maps_link']) ?>" target="_blank" class="btn-tourism">رابط الخريطة</a>
        <?php endif; ?>
    </div>
</div>

<!-- معرض الصور -->
<div class="info-section">
<h2 style="color:#2563eb; text-align:center; margin-bottom:25px;">صور متنوعة</h2>
<div class="gallery">
<?php foreach($images as $img): ?>
<div class="gallery-card" onclick="location.href='<?= htmlspecialchars($img['related_type']) ?>.php'">
    <img src="<?= htmlspecialchars($img['file_path']) ?>" alt="<?= htmlspecialchars($img['title']) ?>">
    <span><?= htmlspecialchars($img['title']) ?></span>
</div>
<?php endforeach; ?>
</div>
</div>

<!-- نافذة تكبير الصورة -->
<div id="imgModal">
    <img id="modalImg">
</div>

<script>
const modal=document.getElementById("imgModal");
const modalImg=document.getElementById("modalImg");
document.querySelectorAll(".gallery-card img").forEach(img=>{
    img.onclick=function(){
        modal.style.display="flex";
        modalImg.src=this.src;
    }
});
modal.onclick=function(){modal.style.display="none";}
</script>

</body>
</html>