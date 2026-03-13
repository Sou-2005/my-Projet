<?php
session_start();
include "../config/db.php";

// حماية الصفحة: فقط المسؤول
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// معالجة النموذج عند الضغط على زر الإضافة
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO services (name, category, description) VALUES (?, ?, ?)");
    $stmt->execute([$name, $category, $description]);

    header("Location: services_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>إضافة خدمة جديدة - لوحة التحكم</title>
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

.btn-add{
    background:#28a745;
    color:white;
}
.btn-add:hover{
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
    <div>إضافة خدمة جديدة</div>
    <a href="services_admin.php">رجوع للوحة الإدارة</a>
</div>

<div class="form-container">
    <h2>إضافة خدمة جديدة</h2>
    <form method="POST">
        <label>اسم الخدمة:</label>
        <input type="text" name="name" required>

        <label>التصنيف:</label>
        <select name="category" required>
            <option value="">اختر تصنيف</option>
            <option value="حمامات">حمامات</option>
            <option value="نقل">نقل</option>
            <option value="وكالات">وكالات</option>
            <option value="مطاعم">مطاعم</option>
            <option value="إقامات">إقامات</option>
        </select>

        <label>الوصف:</label>
        <textarea name="description" rows="5" required></textarea>

        <div class="btn-group">
            <button type="submit" name="add" class="btn btn-add">إضافة الخدمة</button>
            <a href="adservices.php" class="btn btn-back">إلغاء</a>
        </div>
    </form>
</div>

</body>
</html>