<?php
$conn = new mysqli("localhost","root","","tourism_db");
if($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$id = intval($_GET['id']);
$sql = "SELECT * FROM general_images WHERE id=$id";
$result = $conn->query($sql);

if($result->num_rows == 1){
    $row = $result->fetch_assoc();
} else {
    echo "الصورة غير موجودة!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row['title']; ?></title>
    <link rel="stylesheet" href="image.css">
</head>
<body>

<header class="navbar">
    <h2>Oued Souf</h2>
    <nav>
        <a href="index.html">الرئيسية</a>
        <a href="info.html">معلومات عامة</a>
    </nav>
</header>

<section class="image-section">
    <h1><?php echo $row['title']; ?></h1>
    <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['title']; ?>">
    <p><?php echo $row['description']; ?></p>
</section>

</body>
</html>