<?php
session_start();
include "../config/db.php";
$error = "";
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    // البحث عن المستخدم بالاسم فقط
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    if($admin && password_verify($password, $admin['password'])){
        $_SESSION['admin'] = $admin['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "اسم المستخدم أو كلمة المرور غير صحيحة";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>تسجيل الدخول </title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#2563eb,#0f172a);
height:100vh;
display:flex;
flex-direction:column;
}
/* الشريط العلوي */
.topbar{
background:#111;
color:white;
padding:15px 40px;
display:flex;
justify-content:space-between;
align-items:center;
}
.topbar a{
color:white;
text-decoration:none;
margin-left:20px;
}
/* زر العودة */
.back-btn{
background:#2563eb;
padding:8px 15px;
border-radius:6px;
}
/* صندوق تسجيل الدخول */
.login-container{
flex:1;
display:flex;
justify-content:center;
align-items:center;
}
.login-box{
background:white;
padding:40px;
width:320px;
border-radius:12px;
box-shadow:
0 10px 30px rgba(0,0,0,0.3),
0 3px 10px rgba(0,0,0,0.2);
text-align:center;
}
/* العنوان */
.login-box h2{
margin-bottom:20px;
}
/* الحقول */
input{
width:100%;
padding:12px;
margin:10px 0;
border-radius:6px;
border:1px solid #ccc;
}
/* حقل كلمة المرور مع زر العين */
.password-box{
position:relative;
}
.password-box i{
position:absolute;
right:10px;
top:50%;
transform:translateY(-50%);
cursor:pointer;
color:#555;
}
/* زر الدخول */
button{
width:100%;
padding:12px;
border:none;
background:#2563eb;
color:white;
font-size:16px;
border-radius:6px;
cursor:pointer;
transition:0.3s;
}
button:hover{
background:#1d4ed8;
transform:translateY(-2px);
}
.error{
color:red;
margin-bottom:10px;
}
</style>
</head>
<body>
<div class="topbar">
<h3>لوحة التحكم</h3>
<div>
<a href="../index.php" class="back-btn">
<i class="fa fa-arrow-right"></i>
العودة للصفحة الرئيسية
</a>
</div>
</div>
<div class="login-container">
<div class="login-box">
<h2><i class="fa fa-user"></i> تسجيل الدخول</h2>
<?php
if($error != ""){
echo "<div class='error'>$error</div>";
}
?>
<form method="POST">
<input type="text" name="username" placeholder="اسم المستخدم" required>
<div class="password-box">
<input type="password" id="password" name="password" placeholder="كلمة المرور" required>
<i class="fa fa-eye" onclick="togglePassword()"></i>
</div>
<button name="login">
<i class="fa fa-sign-in"></i>
دخول
</button>
</form>
</div>
</div>
<script>
function togglePassword(){
         var pass = document.getElementById("password");
             if(pass.type === "password"){
                pass.type = "text";
             }else{
             pass.type = "password"
            }

}
</script>
</body>
</html>