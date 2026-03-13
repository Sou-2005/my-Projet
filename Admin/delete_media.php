<?php
session_start();
include "../config/db.php";

// حماية الصفحة
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// تحقق من وجود المعرف
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // حذف الصورة من المجلد إذا كانت موجودة
    $stmt = $conn->prepare("SELECT file_path FROM media WHERE media_id=?");
    $stmt->execute([$id]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);
    if($file && file_exists("../".$file['file_path'])){
        unlink("../".$file['file_path']); // حذف الملف فعليًا
    }

    // حذف السجل من قاعدة البيانات
    $stmt = $conn->prepare("DELETE FROM media WHERE media_id=?");
    $stmt->execute([$id]);
}

header("Location:admedia.php");
exit();
?>