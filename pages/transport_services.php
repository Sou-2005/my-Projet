<?php
include "../config/db.php";

// جلب كل خدمات النقل
$stmt = $conn->prepare("SELECT * FROM services WHERE category='نقل'");
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>خدمات النقل - وادي سوف</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: Arial; background:#f8f9fa; padding:20px; }
h2 { text-align:center; margin-bottom:30px; }
.card { margin-bottom:20px; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.1); overflow:hidden; }
.card img { width:100%; height:200px; object-fit:cover; cursor:pointer; transition: transform 0.3s; }
.card img:hover { transform: scale(1.05); }
.card-body { padding:15px; }
</style>
</head>
<body>

<div class="container">
    <h2>خدمات النقل</h2>

    <div class="row">
        <?php foreach($services as $service): ?>
        <div class="col-md-4">
            <div class="card">
                <img src="../<?= $service['file_path'] ?? 'images/default.jpg'; ?>" alt="<?= htmlspecialchars($service['name']); ?>">
                <div class="card-body">
                    <h5><?= htmlspecialchars($service['name']); ?></h5>
                    <p><strong>العنوان:</strong> <?= htmlspecialchars($service['address']); ?></p>
                    <p><strong>الاتصال:</strong> <?= htmlspecialchars($service['contact']); ?></p>
                    <a href="<?= $service['location']; ?>" target="_blank" class="btn btn-success">📍 الخريطة</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>