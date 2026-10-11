<?php
// بدء جلسة العمل
session_start();

// 1. استدعاء ملف الاتصال بقاعدة البيانات
require_once "config.php";

// التحقق من أن البيانات تم إرسالها عبر نموذج التسجيل (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // استقبال وتطهير البيانات لحماية المنصة من الاختراق وحقن الأكواد
    $invite_code     = htmlspecialchars(trim($_POST['invite_code']));
    $username        = htmlspecialchars(trim($_POST['username']));
    $phone           = htmlspecialchars(trim($_POST['phone']));
    $password        = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $withdraw_pin    = trim($_POST['withdraw_pin']);

    $errors = [];

    // التحقق من مطابقة كلمتي المرور
    if ($password !== $confirm_password) {
        $errors[] = "خطأ: كلمتا المرور غير متطابقتين!";
    }

    // التحقق من قوة كلمة المرور
    if (strlen($password) < 6) {
        $errors[] = "خطأ: يجب أن تكون كلمة المرور مكونة من 6 خانات أو أكثر!";
    }

    // التحقق من طول رمز السحب
    if (strlen($withdraw_pin) != 4 && strlen($withdraw_pin) != 6) {
        $errors[] = "خطأ: يجب أن يكون رمز السحب (PIN) مكوناً من 4 أو 6 أرقام فقط!";
    }

    // 2. فحص ما إذا كان اسم المستخدم مسجلاً مسبقاً في قاعدة البيانات لمنع التكرار
    if (empty($errors)) {
        $sql = "SELECT id FROM users WHERE username = :username";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = $username;
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $errors[] = "خطأ: اسم المستخدم هذا مأخوذ بالفعل، اختر اسماً آخر.";
                }
            }
            unset($stmt);
        }
    }

    // 3. إذا لم تكن هناك أخطاء، نبدأ بحفظ الحساب الجديد
    if (count($errors) == 0) {
        
        $sql = "INSERT INTO users (invite_code, username, phone, password, withdraw_pin) VALUES (:invite_code, :username, :phone, :password, :withdraw_pin)";
        
        if ($stmt = $pdo->prepare($sql)) {
            // ربط المتغيرات بالاستعلام
            $stmt->bindParam(":invite_code", $param_invite_code, PDO::PARAM_STR);
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password_hash, PDO::PARAM_STR);
            $stmt->bindParam(":withdraw_pin", $param_withdraw_pin, PDO::PARAM_STR);
            
            // تعيين قيم المتغيرات وتعميد (تشفير كلمة المرور لحمايتها)
            $param_invite_code = $invite_code;
            $param_username = $username;
            $param_phone = $phone;
            $param_password_hash = password_hash($password, PASSWORD_DEFAULT); // تشفير آمن للغاية
            $param_withdraw_pin = $withdraw_pin; // أو يمكنك تشفيره أيضاً حسب رغبتك
            
            // تنفيذ الاستعلام وحفظ البيانات
            if ($stmt->execute()) {
                // إنشاء جلسة باسم المستخدم لنقله للوحة التحكم كعضو مسجل
                $_SESSION["username"] = $username;
                
                echo "<div style='text-align:center; margin-top:50px; font-family: Arial, sans-serif;'>";
                echo "<h2 style='color:green;'>تم إنشاء حسابك بنجاح في منصة Business! 🎉</h2>";
                echo "<p>جاري توجيهك تلقائياً إلى لوحة التحكم الخاصة بك...</p>";
                echo "</div>";
                
                // التوجيه للوحة التحكم
                header("refresh:2;url=dashboard.php");
                exit();
            } else {
                echo "<p style='color:red; text-align:center;'>حدث خطأ ما أثناء حفظ البيانات، يرجى المحاولة لاحقاً.</p>";
            }
            unset($stmt);
        }
    } else {
        // عرض الأخطاء في حال وجودها
        foreach ($errors as $error) {
            echo "<p style='color:red; text-align:center; margin-top:20px; font-weight:bold;'>" . $error . "</p>";
        }
        echo "<p style='text-align:center;'><a href='index.php'>العودة لصفحة التسجيل</a></p>";
    }
}
unset($pdo);
?>
