<?php
session_start();
include "../config/db.php";

// حماية الصفحة: فقط المسؤول
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// التحقق من وجود المعرف
if(!isset($_GET['id'])){
    header("Location: media.php");
    exit();
}

$media_id = $_GET['id'];

// جلب بيانات الوسيط الحالي
$stmt = $conn->prepare("SELECT * FROM media WHERE media_id = ?");
$stmt->execute([$media_id]);
$media = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$media){
    header("Location: media.php");
    exit();
}

// معالجة الفورم عند الضغط على تحديث
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $media_type = $_POST['media_type'];
    $related_type = $_POST['related_type'];
    $related_id = $_POST['related_id'];
    $filePath = $media['file_path'];

    // التحقق من رفع ملف جديد
    if(isset($_FILES['media_file']) && $_FILES['media_file']['error'] == 0){
        $fileName = $_FILES['media_file']['name'];
        $fileTmp = $_FILES['media_file']['tmp_name'];
        $filePath = "images/".$fileName;

        // رفع الملف الجديد
        if(!move_uploaded_file($fileTmp, "../".$filePath)){
            $error = "فشل رفع الملف الجديد.";
            $filePath = $media['file_path']; // الاحتفاظ بالقديم
        }
    }

    // تحديث قاعدة البيانات
    $stmt = $conn->prepare("UPDATE media SET file_path=?, media_type=?, related_type=?, related_id=?, title=? WHERE media_id=?");
    $stmt->execute([$filePath, $media_type, $related_type, $related_id, $title, $media_id]);
    $success = "تم تحديث الوسيط بنجاح!";
    // إعادة جلب البيانات بعد التحديث
    $stmt = $conn->prepare("SELECT * FROM media WHERE media_id = ?");
    $stmt->execute([$media_id]);
    $media = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>تحديث الوسائط</title>
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
img.preview{
    max-width:100%;
    border-radius:8px;
    margin-bottom:15px;
}
</style>
</head>
<body>

<div class="form-card">
    <h2>تحديث الوسائط</h2>

    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>عنوان الوسيط</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($media['title']); ?>" required>
        </div>

        <div class="form-group">
            <label>نوع الوسائط</label>
            <select name="media_type" class="form-control" required>
                <option value="image" <?= $media['media_type']=='image'?'selected':'' ?>>صورة</option>
                <option value="video" <?= $media['media_type']=='video'?'selected':'' ?>>فيديو</option>
                <option value="audio" <?= $media['media_type']=='audio'?'selected':'' ?>>صوت</option>
            </select>
        </div>

        <div class="form-group">
            <label>جهة مرتبطة</label>
            <select name="related_type" class="form-control" required>
                <option value="heritage" <?= $media['related_type']=='heritage'?'selected':'' ?>>الموروث الثقافي</option>
<option value="places" <?= $media['related_type']=='places'?'selected':'' ?>>أماكن سياحية</option>
                <option value="services" <?= $media['related_type']=='services'?'selected':'' ?>>خدمات سياحية</option>
            </select>
        </div>

        <div class="form-group">
            <label>رقم الجهة المرتبطة</label>
            <input type="number" name="related_id" class="form-control" value="<?= $media['related_id']; ?>" required>
        </div>

        <div class="form-group">
            <label>استبدال الملف</label>
            <input type="file" name="media_file" class="form-control">
            <?php if($media['media_type']=='image'): ?>
                <img src="../<?= $media['file_path']; ?>" class="preview">
            <?php else: ?>
                <p>ملف حالي: <?= $media['file_path']; ?></p>
            <?php endif; ?>
        </div>

        <button type="submit" name="submit" class="btn btn-success btn-submit">تحديث</button>
        <a href="admedia.php" class="btn btn-secondary btn-submit">رجوع لإدارة الوسائط</a>
    </form>
</div>

</body>
</html>