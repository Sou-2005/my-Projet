<?php
session_start();
include "../config/db.php";

// حماية الصفحة
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// عند الضغط على زر الحفظ
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $media_type = $_POST['media_type'];
    $related_type = $_POST['related_type'];
    $related_id = $_POST['related_id'];

    // رفع الملف
    if(isset($_FILES['media_file']) && $_FILES['media_file']['error'] == 0){
        $fileName = $_FILES['media_file']['name'];
        $fileTmp = $_FILES['media_file']['tmp_name'];
        $filePath = "images/".$fileName;

        // تحريك الملف لمجلد الصور
        if(move_uploaded_file($fileTmp, "../".$filePath)){
            $stmt = $conn->prepare("INSERT INTO media (file_path, media_type, related_type, related_id, title) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$filePath, $media_type, $related_type, $related_id, $title]);
            $success = "تمت إضافة الوسيط بنجاح!";
        } else {
            $error = "فشل رفع الملف.";
        }
    } else {
        $error = "اختر ملفًا صالحًا للرفع.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>إضافة وسائط جديدة</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    font-family: Arial,sans-serif;
    background:#f2f2f2;
    padding:20px;
}
h2{
    text-align:center;
    margin-bottom:30px;
    color:#333;
}
.form-card{
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 6px 15px rgba(0,0,0,0.1);
    max-width:600px;
    margin:auto;
    transition:0.3s;
}
.form-card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 20px rgba(0,0,0,0.2);
}
.form-group{
    margin-bottom:20px;
}
.btn-submit{
    border-radius:8px;
}
.alert{
    border-radius:8px;
}
</style>
</head>
<body>

<div class="form-card">
    <h2>إضافة وسائط جديدة</h2>

    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>عنوان الوسيط</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label>نوع الوسائط</label>
            <select name="media_type" class="form-control" required>
                <option value="image">صورة</option>
                <option value="video">فيديو</option>
                <option value="audio">صوت</option>
            </select>
        </div>

        <div class="form-group">
            <label>جهة مرتبطة</label>
            <select name="related_type" class="form-control" required>
                <option value="heritage">الموروث الثقافي</option>
                <option value="places">أماكن سياحية</option>
                <option value="services">خدمات سياحية</option>
            </select>
        </div>

        <div class="form-group">
            <label>رقم الجهة المرتبطة</label>
            <input type="number" name="related_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label>اختر ملف الوسيط</label>
            <input type="file" name="media_file" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-success btn-submit">حفظ</button>
        <a href="Admedia.php" class="btn btn-secondary btn-submit">رجوع لإدارة الوسائط</a>
    </form>
</div>

</body>
</html>