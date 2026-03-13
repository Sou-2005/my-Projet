<?php
include "../config/db.php";

/* البحث */
$search = "";
if(isset($_GET['search'])){
    $search = $_GET['search'];
    $stmt = $conn->prepare("SELECT * FROM cultural_heritage 
    WHERE category='لباس تقليدي' AND name LIKE ?");
    $stmt->execute(["%$search%"]);
}else{
    $stmt = $conn->query("SELECT * FROM cultural_heritage 
    WHERE category='لباس تقليدي'");
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>اللباس التقليدي</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
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

/* البطاقة */

.heritage-card{
background:white;
border-radius:15px;
box-shadow:0 8px 20px rgba(0,0,0,0.1);
padding:15px;
margin-bottom:40px;
max-width:700px;
margin-left:auto;
margin-right:auto;
}

/* الصورة الرئيسية */

.main-img{
width:100%;
height:300px;
object-fit:cover;
border-radius:10px;
cursor:pointer;
}

/* العنوان */

.title{
font-size:22px;
font-weight:bold;
margin-top:15px;
text-align:center;
}

/* الوصف */

.desc{
color:#555;
margin-top:10px;
line-height:1.8;
text-align:center;
}

/* معرض الصور */

.gallery{
display:flex;
gap:10px;
margin-top:15px;
justify-content:center;
flex-wrap:wrap;
}

.gallery img{
width:110px;
height:80px;
object-fit:cover;
border-radius:8px;
cursor:pointer;
transition:0.3s;
}

.gallery img:hover{
transform:scale(1.05);
}

</style>
</head>

<body>

<!-- الشريط العلوي -->

<div class="topbar">

<div>اللباس التقليدي</div>

<div>
<a href="../index.php">الرئيسية</a>
<a href="heritage.php">الموروث الثقافي</a>
</div>

</div>

<!-- البحث -->

<div class="search-box">

<form method="GET">
<input type="text" name="search" class="form-control" placeholder="ابحث عن لباس تقليدي...">
</form>

</div>


<div class="container">

<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>

<?php
/* جلب الصور */

$stmtImg = $conn->prepare("SELECT * FROM media 
WHERE related_type='cultural_heritage' AND related_id=?");
$stmtImg->execute([$row['heritage_id']]);
$images = $stmtImg->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="heritage-card">

<?php if(!empty($images)): ?>

<img src="../<?= $images[0]['file_path'] ?>" class="main-img">

<?php endif; ?>


<div class="title">
<?= htmlspecialchars($row['name']) ?>
</div>


<div class="desc">
<?= htmlspecialchars($row['description']) ?>
</div>


<div class="gallery">

<?php foreach($images as $img): ?>

<img src="../<?= $img['file_path'] ?>">

<?php endforeach; ?>

</div>

</div>

<?php endwhile; ?>

</div>


<!-- نافذة تكبير الصورة -->

<div id="imgModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); justify-content:center; align-items:center;">

<img id="modalImg" style="max-width:90%; max-height:90%; border-radius:10px;">

</div>


<script>

const modal = document.getElementById("imgModal");
const modalImg = document.getElementById("modalImg");

document.querySelectorAll(".main-img, .gallery img").forEach(img=>{
img.onclick = function(){
modal.style.display="flex";
modalImg.src=this.src;
}
})

modal.onclick = function(){
modal.style.display="none";
}

</script>


</body>
</html>