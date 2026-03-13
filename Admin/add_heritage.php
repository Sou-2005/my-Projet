<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['add'])){

$name = $_POST['name'];
$category = $_POST['category'];
$description = $_POST['description'];

$stmt = $conn->prepare("INSERT INTO cultural_heritage(name,category,description) VALUES(?,?,?)");
$stmt->execute([$name,$category,$description]);

header("Location: Adheritage.php");
exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>إضافة موروث</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f2f2f2">

<div class="container mt-5">

<h3 class="mb-4">إضافة موروث ثقافي</h3>

<form method="POST">

<div class="mb-3">
<label>اسم الموروث</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>التصنيف</label>
<input type="text" name="category" class="form-control" required>
</div>

<div class="mb-3">
<label>الوصف</label>
<textarea name="description" class="form-control"></textarea>
</div>

<button name="add" class="btn btn-success">إضافة</button>
<a href="../Admin/Adheritage.php" class="btn btn-secondary">رجوع</a>

</form>

</div>

</body>
</html>