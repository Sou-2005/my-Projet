<?php
session_start();
include "../config/db.php";

// حماية الصفحة: فقط المسؤول
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// جلب جميع الخدمات وترتيبها حسب الفئة
$stmt = $conn->query("SELECT * FROM services ORDER BY category ASC, service_id DESC");

// تنظيم البيانات حسب الفئة
$servicesData = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $servicesData[$row['category']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>إدارة الخدمات السياحية</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: Arial, sans-serif;
    background: #f2f2f2;
    padding: 20px;
}

/* العنوان الرئيسي */
h2 {
    text-align:center;
    margin-bottom:30px;
    color:#333;
}

/* أزرار إضافة وعودة */
.btn-add, .btn-back {
    margin-bottom: 20px;
    border-radius: 8px;
}

/* البطاقات */
.category-section {
    margin-bottom: 40px;
}

.category-title {
    background-color: #2563eb;
    color: #fff;
    padding: 12px 20px;
    border-radius: 8px 8px 0 0;
    font-size: 20px;
    text-transform: uppercase;
}

.card-service {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    padding: 20px;
    margin-bottom: 15px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card-service:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.card-service h4 {
    margin-bottom: 10px;
    color: #111;
}

.card-service p {
    color: #555;
}

/* أزرار التحديث والحذف */
.card-service .btn {
    border-radius: 8px;
    margin-right: 5px;
    transition: 0.3s;
}

.btn-edit {
    background-color: #6c757d;
    color: #fff;
}

.btn-edit:hover {
    background-color: #5a6268;
}

.btn-delete {
    background-color: #dc3545;
    color: #fff;
}

.btn-delete:hover {
    background-color: #b52a37;
}
</style>
</head>
<body>

<div class="container">
    <h2>إدارة الخدمات السياحية</h2>

    <div class="d-flex justify-content-end mb-4">
        <a href="add_services.php" class="btn btn-success btn-add">+ إضافة خدمة جديدة</a>
        <a href="admin.php" class="btn btn-secondary btn-back">رجوع للوحة الإدارة</a>
    </div>

    <?php foreach($servicesData as $category => $items): ?>
    <div class="category-section">
        <div class="category-title"><?= htmlspecialchars($category); ?></div>
        <?php foreach($items as $row): ?>
        <div class="card-service">
            <h4><?= htmlspecialchars($row['name']); ?></h4>
            <?php if(!empty($row['description'])): ?>
            <p><?= htmlspecialchars($row['description']); ?></p>
            <?php endif; ?>
            <div class="text-end">
                <a href="edit_services.php?id=<?= $row['service_id']; ?>" class="btn btn-edit btn-sm">تحديث</a>
                <a href="delete_service.php?id=<?= $row['service_id']; ?>" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>

</body>
</html>