<?php
// بدء جلسة العمل
session_start();

// إذا كان المستخدم مسجلاً دخوله بالفعل، يتم توجيهه مباشرة للوحة التحكم
if(isset($_SESSION["username"])){
    header("location: dashboard.php");
    exit;
}

// استدعاء ملف الاتصال بقاعدة البيانات
require_once "config.php";

$username = $password = "";
$error = "";

// معالجة البيانات عند إرسال الاستمارة
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = $_POST["password"];
    
    if(empty($username) || empty($password)){
        $error = "خطأ: يرجى إدخال اسم المستخدم وكلمة المرور.";
    } else {
        // التحقق من الحساب في قاعدة البيانات
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = $username;
            
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $hashed_password = $row["password"];
                        // فحص ومطابقة كلمة المرور المشفرة
                        if(password_verify($password, $hashed_password)){
                            // كلمة المرور صحيحة، بدء جلسة جديدة وحفظ اليوزر
                            $_SESSION["username"] = $username;
                            
                            // التوجيه إلى لوحة التحكم
                            header("location: dashboard.php");
                            exit;
                        } else {
                            $error = "خطأ: كلمة المرور التي أدخلتها غير صحيحة.";
                        }
                    }
                } else {
                    $error = "خطأ: لا يوجد حساب مسجل باسم المستخدم هذا.";
                }
            } else {
                $error = "حدث خطأ ما في السيرفر، يرجى المحاولة لاحقاً.";
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Platform - تسجيل الدخول</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; }
        body { background-color: #f4f6f9; display: flex; justify-content: center; align-content: center; min-height: 100vh; padding: 20px; }
        .login-container { background: #ffffff; width: 100%; max-width: 400px; padding: 30px; border-radius: 15px; box-shadow: 0px 10px 25px rgba(0,0,0,0.05); margin: auto; }
        .header-area { text-align: center; margin-bottom: 25px; }
        .header-area h2 { color: #1a2a3a; font-size: 24px; margin-bottom: 5px; }
        .header-area p { color: #7f8c8d; font-size: 14px; }
        .form-group { margin-bottom: 20px; text-align: right; }
        .form-group label { display: block; margin-bottom: 8px; color: #2c3e50; font-size: 14px; font-weight: 600; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #dcdde1; border-radius: 8px; font-size: 15px; outline: none; transition: 0.3s; }
        .form-group input:focus { border-color: #2ecc71; box-shadow: 0px 0px 8px rgba(46, 204, 113, 0.2); }
        .btn-submit { width: 100%; padding: 14px; background-color: #1a2a3a; border: none; border-radius: 8px; color: white; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-submit:hover { background-color: #2c3e50; }
        .footer-link { text-align: center; margin-top: 20px; font-size: 14px; color: #7f8c8d; }
        .footer-link a { color: #2ecc71; text-decoration: none; font-weight: bold; }
        .error-msg { background-color: #fce4e4; border: 1px solid #fcc2c2; color: #cc0000; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

<div class="login-container">
    <div class="header-area">
        <h2>منصة BUSINESS</h2>
        <p>تسجيل الدخول لمتابعة استثماراتك</p>
    </div>

    <!-- عرض رسالة الخطأ إن وجدت -->
    <?php if(!empty($error)): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <!-- اسم المستخدم -->
        <div class="form-group">
            <label>اسم المستخدم (Username)</label>
            <input type="text" name="username" placeholder="أدخل اسم المستخدم الخاص بك" required>
        </div>

        <!-- كلمة المرور -->
        <div class="form-group">
            <label>كلمة المرور (Password)</label>
            <input type="password" name="password" placeholder="أدخل كلمة المرور" required>
        </div>

        <!-- زر الدخول -->
        <button type="submit" class="btn-submit">تسجيل الدخول</button>
    </form>

    <div class="footer-link">
        ليس لديك حساب؟ <a href="index.php">سجل حساباً جديداً الآن</a>
    </div>
</div>

</body>
</html>
