<?php
session_start();
include "../config/db.php";

// حماية الصفحة: فقط المسؤول
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// جلب id الخدمة من الرابط
if(!isset($_GET['id'])){
    header("Location: services_admin.php");
    exit();
}

$id = intval($_GET['id']);

// جلب بيانات الخدمة
$stmt = $conn->prepare("SELECT * FROM services WHERE service_id = ?");
$stmt->execute([$id]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$service){
    echo "الخدمة غير موجودة";
    exit();
}

// معالجة النموذج عند الضغط على حفظ
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $stmtUpdate = $conn->prepare("UPDATE services SET name=?, category=?, description=? WHERE services_id=?");
    $stmtUpdate->execute([$name, $category, $description, $id]);

    header("Location: services_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>تحديث الخدمة - لوحة التحكم</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    font-family: Arial;
    background: #f3f4f6;
    padding: 20px;
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

/* النموذج */
.form-container{
    max-width:600px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.form-container h2{
    text-align:center;
    margin-bottom:25px;
    color:#2563eb;
}

.form-container label{
    font-weight:bold;
}

.form-container input, 
.form-container select, 
.form-container textarea{
    margin-bottom:15px;
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
    width:100%;
}

.btn-group{
    display:flex;
    justify-content:space-between;
}

.btn{
    border:none;
    border-radius:8px;
    padding:10px 20px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn-save{
    background:#2563eb;
    color:white;
}
.btn-save:hover{
    opacity:0.85;
}

.btn-back{
    background:#6c757d;
    color:white;
}
.btn-back:hover{
    opacity:0.85;
}
</style>
</head>
<body>

<div class="topbar">
    <div>تحديث الخدمة</div>
    <a href="../Admin/Admin.php">رجوع للوحة الإدارة</a>
</div>

<div class="form-container">
    <h2>تحديث الخدمة</h2>
    <form method="POST">
        <label>اسم الخدمة:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($service['name']); ?>" required>

        <label>التصنيف:</label>
        <select name="category" required>
            <option value="">اختر تصنيف</option>
            <option value="حمامات" <?= $service['category']=='حمامات'?'selected':''; ?>>حمامات</option>
            <option value="نقل" <?= $service['category']=='نقل'?'selected':''; ?>>نقل</option>
            <option value="وكالات" <?= $service['category']=='وكالات'?'selected':''; ?>>وكالات</option>
            <option value="مطاعم" <?= $service['category']=='مطاعم'?'selected':''; ?>>مطاعم</option>
            <option value="إقامات" <?= $service['category']=='إقامات'?'selected':''; ?>>إقامات</option>
        </select>

        <label>الوصف:</label>
        <textarea name="description" rows="5" required><?= htmlspecialchars($service['description']); ?></textarea>

        <div class="btn-group">
            <button type="submit" name="update" class="btn btn-save">حفظ التعديلات</button>
            <a href="adservices.php" class="btn btn-back">إلغاء</a>
        </div>
    </form>
</div>

</body>
</html>