<?php
session_start();
include "../config/db.php";

$id = $_GET['id'] ?? null;

if(!$id){
    header("Location: Adheritage.php");
    exit();
}

// حماية الصفحة
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// جلب كل الموروثات السابقة للاقتراحات
$nameListStmt = $conn->query("SELECT DISTINCT name FROM cultural_heritage");
$names = $nameListStmt->fetchAll(PDO::FETCH_COLUMN);

$categoryListStmt = $conn->query("SELECT DISTINCT category FROM cultural_heritage");
$categories = $categoryListStmt->fetchAll(PDO::FETCH_COLUMN);

$descListStmt = $conn->query("SELECT DISTINCT description FROM cultural_heritage");
$descriptions = $descListStmt->fetchAll(PDO::FETCH_COLUMN);

// تحديث البيانات عند الإرسال
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE cultural_heritage SET name=?, category=?, description=? WHERE heritage_id=?");
    $stmt->execute([$name, $category, $description, $id]);

    header("Location: Adheritage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>تحديث الموروث الثقافي</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f2f2f2; font-family:Arial; padding:30px; }
.container { max-width:700px; margin:auto; }
h3 { text-align:center; margin-bottom:30px; }
input, textarea { position: relative; padding-right:30px; }
.triangle-btn {
    position: absolute;
    right:5px;
    top:50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size:18px;
    color:#2563eb;
}
.input-wrapper { position: relative; margin-bottom:20px; }
</style>
</head>
<body>

<div class="container">
<h3>تحديث الموروث الثقافي</h3>

<form method="POST">

<!-- اسم الموروث -->
<div class="input-wrapper">
<label>اسم الموروث</label>
<input list="nameList" name="name" class="form-control" placeholder="اكتب اسم الموروث هنا">
<span class="triangle-btn" onclick="document.getElementById('nameList').style.display='block'">&#9662;</span>
<datalist id="nameList">
<?php foreach($names as $n): ?>
<option value="<?= htmlspecialchars($n); ?>"></option>
<?php endforeach; ?>
</datalist>
</div>

<!-- التصنيف -->
<div class="input-wrapper">
<label>التصنيف</label>
<input list="categoryList" name="category" class="form-control" placeholder="اكتب التصنيف هنا">
<span class="triangle-btn" onclick="document.getElementById('categoryList').style.display='block'">&#9662;</span>
<datalist id="categoryList">
<?php foreach($categories as $c): ?>
<option value="<?= htmlspecialchars($c); ?>"></option>
<?php endforeach; ?>
</datalist>
</div>

<!-- الوصف -->
<div class="input-wrapper">
<label>الوصف</label>
<textarea list="descList" name="description" class="form-control" placeholder="اكتب وصف الموروث هنا"></textarea>
<span class="triangle-btn" onclick="document.getElementById('descList').style.display='block'">&#9662;</span>
<datalist id="descList">
<?php foreach($descriptions as $d): ?>
<option value="<?= htmlspecialchars($d); ?>"></option>
<?php endforeach; ?>
</datalist>
</div>

<button name="update" class="btn btn-primary">تحديث</button>
<a href="Adheritage.php" class="btn btn-secondary">رجوع</a>

</form>
</div>

</body>
</html>