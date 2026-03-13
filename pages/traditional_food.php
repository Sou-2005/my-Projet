<?php
include "../config/db.php";

/* البحث */

$search="";

if(isset($_GET['search'])){
$search=$_GET['search'];

$stmt=$conn->prepare("SELECT * FROM cultural_heritage 
WHERE category='اكل تقليدي' AND name LIKE ?");
$stmt->execute(["%$search%"]);

}else{

$stmt=$conn->query("SELECT * FROM cultural_heritage 
WHERE category='اكل تقليدي'");
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>الأكل التقليدي</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f3f4f6;
font-family:Arial;
margin:0;
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

/* البحث */

.search-box{
max-width:400px;
margin:30px auto;
}

/* الشبكة */

.food-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
gap:25px;
max-width:1100px;
margin:auto;
padding-bottom:40px;
}

/* البطاقة */

.food-card{
background:white;
border-radius:15px;
box-shadow:0 8px 20px rgba(0,0,0,0.1);
overflow:hidden;
transition:0.3s;
}

.food-card:hover{
transform:translateY(-5px);
box-shadow:0 15px 30px rgba(0,0,0,0.2);
}

/* الصورة الرئيسية */

.food-img{
width:100%;
height:200px;
object-fit:cover;
cursor:pointer;
}

/* المحتوى */

.food-content{
padding:15px;
}

.food-title{
font-size:20px;
font-weight:bold;
margin-bottom:8px;
}

.food-desc{
color:#555;
font-size:14px;
line-height:1.7;
}

/* معرض الصور */

.food-gallery{
display:flex;
gap:8px;
margin-top:10px;
flex-wrap:wrap;
}

.food-gallery img{
width:70px;
height:60px;
object-fit:cover;
border-radius:6px;
cursor:pointer;
transition:0.3s;
}

.food-gallery img:hover{
transform:scale(1.05);
}

</style>
</head>

<body>

<!-- الشريط العلوي -->

<div class="topbar">

<div>الأكل التقليدي</div>

<div>
<a href="../index.php">الرئيسية</a>
<a href="heritage.php">الموروث الثقافي</a>
</div>

</div>


<!-- البحث -->

<div class="search-box">

<form method="GET">
<input type="text" name="search" class="form-control" placeholder="ابحث عن أكلة تقليدية...">
</form>

</div>


<div class="food-grid">

<?php while($row=$stmt->fetch(PDO::FETCH_ASSOC)): ?>

<?php

$stmtImg=$conn->prepare("SELECT * FROM media 
WHERE related_type='cultural_heritage' AND related_id=?");

$stmtImg->execute([$row['heritage_id']]);

$images=$stmtImg->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="food-card">

<?php if(!empty($images)): ?>

<img src="../<?= $images[0]['file_path'] ?>" class="food-img">

<?php endif; ?>

<div class="food-content">

<div class="food-title">
<?= htmlspecialchars($row['name']) ?>
</div>

<div class="food-desc">
<?= htmlspecialchars($row['description']) ?>
</div>

<?php if(!empty($images)): ?>

<div class="food-gallery">

<?php foreach($images as $img): ?>

<img src="../<?= $img['file_path'] ?>">

<?php endforeach; ?>

</div>

<?php endif; ?>

</div>

</div>

<?php endwhile; ?>

</div>


<!-- نافذة تكبير الصورة -->

<div id="imgModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); justify-content:center; align-items:center; z-index:999;">

<img id="modalImg" style="max-width:90%; max-height:90%; border-radius:10px;">

</div>


<script>

const modal=document.getElementById("imgModal");
const modalImg=document.getElementById("modalImg");

document.querySelectorAll(".food-img, .food-gallery img").forEach(img=>{

img.onclick=function(){

modal.style.display="flex";
modalImg.src=this.src;

}

});

modal.onclick=function(){

modal.style.display="none";

}

</script>


</body>
</html>