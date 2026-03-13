<?php
include "../config/db.php";

/* البحث */
$search="";
if(isset($_GET['search']) && !empty($_GET['search'])){
$search=$_GET['search'];

$stmt=$conn->prepare("SELECT * FROM places WHERE category='ثقافي' AND name LIKE ?");
$stmt->execute(["%$search%"]);
$places=$stmt->fetchAll(PDO::FETCH_ASSOC);
}
else{
$stmt=$conn->prepare("SELECT * FROM places WHERE category='ثقافي'");
$stmt->execute();
$places=$stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>الأماكن الثقافية</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
font-family:Arial;
background:#f6f7fb;
padding:20px;
}

/* الشريط العلوي */

.topbar{
display:flex;
justify-content:space-between;
align-items:center;
background:#1f2937;
padding:12px 20px;
border-radius:8px;
margin-bottom:30px;
}

.topbar a{
color:white;
text-decoration:none;
margin-right:10px;
padding:7px 14px;
background:#374151;
border-radius:5px;
}

.topbar a:hover{
background:#111827;
}

.topbar input{
padding:6px 10px;
border-radius:5px;
border:none;
}

/* بطاقة المكان */

.place-card{
background:white;
border-radius:12px;
box-shadow:0 6px 18px rgba(0,0,0,0.1);
margin-bottom:25px;
display:flex;
overflow:hidden;
transition:0.3s;
}

.place-card:hover{
transform:translateY(-4px);
box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

/* الصورة */

.place-img{
width:320px;
height:220px;
object-fit:cover;
cursor:pointer;
}

/* المعلومات */

.content{
padding:20px;
flex:1;
}

.content h3{
margin-bottom:10px;
}

.content p{
color:#555;
}

/* معرض الصور */

.gallery{
display:flex;
gap:8px;
margin-top:10px;
flex-wrap:wrap;
}

.gallery img{
width:90px;
height:70px;
object-fit:cover;
border-radius:5px;
cursor:pointer;
transition:0.3s;
}

.gallery img:hover{
transform:scale(1.05);
border:2px solid #3b82f6;
}

/* زر الموقع */

.map-btn{
display:inline-block;
margin-top:10px;
background:#3b82f6;
color:white;
padding:6px 12px;
border-radius:5px;
text-decoration:none;
}

/* عرض الصورة الكبيرة */

#lightbox{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.9);
display:none;
justify-content:center;
align-items:center;
z-index:999;
}

#lightbox img{
max-width:90%;
max-height:90%;
border-radius:10px;
}

</style>
</head>

<body>

<!-- الشريط العلوي -->

<div class="topbar">

<div>
<a href="../index.php">الرئيسية</a>
<a href="places.php">الأماكن</a>
</div>

<form method="GET">
<input type="text" name="search" placeholder="ابحث عن مكان ثقافي..." value="<?= $search ?>">
<button class="btn btn-light btn-sm">🔍</button>
</form>

</div>

<div class="container">

<h2 class="text-center mb-4">الأماكن الثقافية في وادي سوف</h2>

<?php foreach($places as $place):

$imgStmt=$conn->prepare("SELECT file_path FROM media WHERE related_type='places' AND related_id=?");
$imgStmt->execute([$place['place_id']]);
$images=$imgStmt->fetchAll(PDO::FETCH_ASSOC);

if(empty($images)){
$images[0]['file_path']="images/default.jpg";
}

?>

<div class="place-card">

<img src="../<?= $images[0]['file_path'] ?>" class="place-img light">

<div class="content">

<h3><?= $place['name'] ?></h3>

<p><?= $place['description'] ?></p>

<a href="<?= $place['maps_link'] ?>" target="_blank" class="map-btn">📍 الموقع على الخريطة</a>

<div class="gallery">

<?php foreach($images as $img): ?>

<img src="../<?= $img['file_path'] ?>" class="light">

<?php endforeach; ?>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<div id="lightbox">
<img src="">
</div>

<script>

const lightbox=document.getElementById("lightbox");
const imgBox=lightbox.querySelector("img");

document.querySelectorAll(".light").forEach(img=>{
img.onclick=()=>{
lightbox.style.display="flex";
imgBox.src=img.src;
}
})

lightbox.onclick=()=>{
lightbox.style.display="none";
}

</script>

</body>
</html>