<?php
include "../config/db.php";

// جلب كل الوكالات
$stmt = $conn->prepare("SELECT * FROM services WHERE category='وكالات'");
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

// معالجة البحث
$search = "";
if(isset($_GET['search']) && !empty(trim($_GET['search']))){
    $search = trim($_GET['search']);
    $stmt = $conn->prepare("SELECT * FROM services WHERE category='وكالات' AND name LIKE ?");
    $stmt->execute(["%$search%"]);
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>خدمات الوكالات - وادي سوف</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: Arial; background:#f8f9fa; padding:20px; }
h2 { text-align:center; margin-bottom:30px; color:#333; }

/* ===== شريط علوي ===== */
.top-bar {
    display:flex;
    justify-content: space-between;
    align-items: center;
    background:#2563eb;
    color:white;
    padding:10px 20px;
    border-radius:8px;
    margin-bottom:20px;
}
.top-bar a {
    color:white;
    text-decoration:none;
    margin-right:10px;
    padding:8px 15px;
    background:#1e4bb8;
    border-radius:5px;
    transition:0.3s;
}
.top-bar a:hover {
    background:#173a8a;
}
.top-bar form input {
    padding:7px 10px;
    border-radius:5px;
    border:none;
    width:200px;
}

/* ===== بطاقات الوكالات ===== */
.card { margin-bottom:20px; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.1); overflow:hidden; background:white; transition: transform 0.3s, box-shadow 0.3s; }
.card:hover { transform: translateY(-5px); box-shadow:0 12px 25px rgba(0,0,0,0.2); }
.card img { width:100%; height:200px; object-fit:cover; cursor:pointer; transition: transform 0.3s; border-bottom:1px solid #ddd; }
.card img:hover { transform: scale(1.05); }
.card-body { padding:15px; text-align:center; }
.card-body h5 { margin-bottom:10px; color:#111; }
.card-body p { margin-bottom:5px; color:#555; }
.img-thumbnails img { width:70px; height:70px; object-fit:cover; margin:2px; cursor:pointer; border-radius:5px; transition:0.2s; }
.img-thumbnails img:hover { transform: scale(1.1); border:2px solid #2563eb; }
#lightbox { position:fixed; display:none; justify-content:center; align-items:center; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999; }
#lightbox img { max-width:90%; max-height:90%; border-radius:10px; }
.btn-map { background:#2563eb; color:white; border:none; padding:8px 12px; border-radius:5px; transition:0.3s; }
.btn-map:hover { opacity:0.85; }
</style>
</head>
<body>

<!-- الشريط العلوي -->
<div class="top-bar">
    <div>
        <a href="services.php">عودة إلى الخدمات</a>
        <a href="../index.php">الرئيسية</a>
    </div>
    <form method="GET" class="d-flex">
        <input type="text" name="search" placeholder="ابحث عن وكالة..." value="<?= htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-light ms-2">🔍</button>
    </form>
</div>

<div class="container">
    
    <h2> خدمة الوكالات AGENCY </h2>
    <div class="row">
        <?php foreach($services as $service):
            $imgStmt = $conn->prepare("SELECT file_path FROM media WHERE related_type='services' AND related_id=?");
            $imgStmt->execute([$service['service_id']]);
            $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);

            if(empty($images)){
                $images[0]['file_path'] = "../images/default.jpg";
            } else {
                foreach($images as &$img){
                    $img['file_path'] = "../" . $img['file_path'];
                }
            }
        ?>
        <div class="col-md-4">
            <div class="card">
                <img src="<?= $images[0]['file_path']; ?>" class="main-img" alt="<?= htmlspecialchars($service['name']); ?>">

                <div class="card-body">
                    <h5><?= htmlspecialchars($service['name']); ?></h5>
                    <p><?= htmlspecialchars($service['description']); ?></p>
                    <?php if(count($images) > 1): ?>
                    <div class="img-thumbnails mt-2">
                        <?php foreach(array_slice($images,0,3) as $img): ?>
                            <img src="<?= $img['file_path']; ?>" class="thumb-img" alt="<?= htmlspecialchars($service['name']); ?>">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <a href="<?= $service['location']; ?>" target="_blank" class="btn-map mt-2">📍 الخريطة</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox"><img src="" alt="Lightbox"></div>

<script>
// تغيير الصورة الرئيسية عند الضغط على المصغرات
document.querySelectorAll('.card').forEach(card => {
    const mainImg = card.querySelector('.main-img');
    card.querySelectorAll('.thumb-img').forEach(thumb => {
        thumb.addEventListener('click', () => { mainImg.src = thumb.src; });
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
lightbox.addEventListener('click', () => { lightbox.style.display = 'none'; });
</script>

</body>
</html>