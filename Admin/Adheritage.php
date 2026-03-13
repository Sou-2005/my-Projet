<?php
session_start();
include "../config/db.php";

// حماية الصفحة: فقط المسؤول يمكنه الدخول
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// جلب كل الموروث الثقافي وترتيبه حسب التصنيف
$stmt = $conn->query("SELECT * FROM cultural_heritage ORDER BY category ASC, heritage_id DESC");

// تنظيم البيانات حسب التصنيف
$heritageData = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $heritageData[$row['category']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>إدارة الموروث الثقافي</title>
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
    background-color: #333;
    color: #fff;
    padding: 12px 20px;
    border-radius: 8px 8px 0 0;
    font-size: 20px;
    text-transform: uppercase;
}

.card-heritage {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    padding: 20px;
    margin-bottom: 15px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card-heritage:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.card-heritage h4 {
    margin-bottom: 10px;
    color: #111;
}

.card-heritage p {
    color: #555;
}

/* أزرار التحديث والحذف */
.card-heritage .btn {
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
    <h2>إدارة الموروث الثقافي</h2>

    <div class="d-flex justify-content-end mb-4">
        <a href="add_heritage.php" class="btn btn-success btn-add">+ إضافة موروث جديد</a>
        <a href="admin.php" class="btn btn-secondary btn-back">رجوع للوحة الإدارة</a>
    </div>

    <?php foreach($heritageData as $category => $items): ?>
    <div class="category-section">
        <div class="category-title"><?= htmlspecialchars($category); ?></div>
        <?php foreach($items as $row): ?>
        <div class="card-heritage">
            <h4><?= htmlspecialchars($row['name']); ?></h4>
            <p><?= htmlspecialchars($row['description']); ?></p>
            <div class="text-end">
                <a href="edit_heritage.php?id=<?= $row['heritage_id']; ?>" class="btn btn-edit btn-sm">تحديث</a>
                <a href="delete_heritage.php?id=<?= $row['heritage_id']; ?>" class="btn btn-delete btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>

</body>
</html>