<?php
session_start();
include "../config/db.php";

// حماية الصفحة: فقط المسؤول يمكنه الدخول
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// جلب كل الوسائط
$stmt = $conn->query("SELECT * FROM media ORDER BY media_type ASC, media_id DESC");
$mediaData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>إدارة الوسائط</title>
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

/* بطاقة الوسائط */
.card-media{
    background:white;
    border-radius:12px;
    box-shadow:0 6px 15px rgba(0,0,0,0.1);
    overflow:hidden;
    margin-bottom:20px;
    transition:0.3s;
}

.card-media:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 20px rgba(0,0,0,0.2);
}

.media-preview{
    width:100%;
    height:200px;
    object-fit:cover;
    display:block;
}

.card-body{
    padding:15px;
}

.media-title{
    font-size:18px;
    font-weight:600;
    margin-bottom:10px;
}

/* أزرار التحديث والحذف */
.card-body .btn{
    border-radius:8px;
    margin-right:5px;
}

/* صندوق البحث */
#searchInput{
    border-radius:8px;
    padding:8px 12px;
}
</style>
</head>
<body>

<div class="container">
    <h2>إدارة الوسائط</h2>

    <div class="d-flex justify-content-between mb-4">
        <a href="add_media.php" class="btn btn-success btn-add">+ إضافة وسائط جديدة</a>
        <a href="admin.php" class="btn btn-secondary btn-back">رجوع للوحة الإدارة</a>
    </div>

    <!-- صندوق البحث -->
    <div class="row mb-4">
        <div class="col-md-6">
            <input 
                type="text" 
                id="searchInput" 
                class="form-control" 
                placeholder="ابحث عن صورة..."
                onkeyup="searchImages()"
                list="titlesList"
            >
            <datalist id="titlesList">
                <?php
                $stmtTitles = $conn->query("SELECT title FROM media");
                while($t = $stmtTitles->fetch(PDO::FETCH_ASSOC)){
                    echo "<option value='".htmlspecialchars($t['title'])."'>";
                }
                ?>
            </datalist>
        </div>
    </div>

    <div class="row">
        <?php foreach($mediaData as $row): ?>
        <div class="col-md-4 media-item">
            <div class="card-media">
                <img src="../<?= htmlspecialchars($row['file_path']); ?>" class="media-preview">
                <div class="card-body">
                    <h5 class="media-title"><?= htmlspecialchars($row['title']); ?></h5>
                    <div>
                        <a href="edit_media.php?id= <?= $row['media_id']; ?>" class="btn btn-secondary btn-sm">تحديث</a>
                        <a href="delete_media.php?id= <?= $row['media_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function searchImages() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let items = document.querySelectorAll(".media-item");
    items.forEach(function(item){
        let title = item.querySelector(".media-title").innerText.toLowerCase();
        if(title.includes(input)){
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    });
}
</script>

</body>
</html>