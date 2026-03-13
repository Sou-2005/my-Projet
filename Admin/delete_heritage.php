<?php

include "../config/db.php";

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM cultural_heritage WHERE heritage_id=?");
$stmt->execute([$id]);

header("Location: Adheritage.php");
exit();