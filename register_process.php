<?php
// بدء جلسة العمل لتخزين الأخطاء أو التنبيهات
session_start();

// التحقق من أن البيانات تم إرسالها عبر نموذج التسجيل (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // استقبال وتطهير البيانات لحماية المنصة من الاختراق وحقن الأكواد
    $invite_code     = htmlspecialchars(trim($_POST['invite_code']));
    $username        = htmlspecialchars(trim($_POST['username']));
    $phone           = htmlspecialchars(trim($_POST['phone']));
    $password        = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $withdraw_pin    = trim($_POST['withdraw_pin']);

    // [ مصفوفة لتخزين الأخطاء إن وجدت ]
    $errors = [];

    // 1. التحقق من مطابقة كلمتي المرور
    if ($password !== $confirm_password) {
        $errors[] = "خطأ: كلمتا المرور غير متطابقتين!";
    }

    // 2. التحقق من قوة كلمة المرور (مثال: ألا تقل عن 6 خانات)
    if (strlen($password) < 6) {
        $errors[] = "خطأ: يجب أن تكون كلمة المرور مكونة من 6 خانات أو أكثر!";
    }

    // 3. التحقق من طول رمز السحب (يجب أن يكون 4 أو 6 أرقام فقط للحماية المالية)
    if (strlen($withdraw_pin) != 4 && strlen($withdraw_pin) != 6) {
        $errors[] = "خطأ: يجب أن يكون رمز السحب (PIN) مكوناً من 4 أو 6 أرقام فقط!";
    }

    // [ فحص النتيجة ]
    if (count($errors) > 0) {
        // إذا وُجدت أخطاء، يتم عرضها للمستخدم لمنع التسجيل الخاطئ
        foreach ($errors as $error) {
            echo "<p style='color:red; text-align:center; margin-top:20px; font-weight:bold;'>" . $error . "</p>";
        }
        echo "<p style='text-align:center;'><a href='index.php'>العودة لصفحة التسجيل</a></p>";
    } else {
        // إذا كانت كل الشروط صحيحة (هنا سنربط قاعدة البيانات لاحقاً لحفظ الحساب)
        // حالياً سنعرض له رسالة نجاح مؤقتة وينتقل للخطوة التالية بطلبك
        echo "<div style='text-align:center; margin-top:50px; font-family: Arial, sans-serif;'>";
        echo "<h2 style='color:green;'>تم التحقق من بيانات الحساب بنجاح! 🎉</h2>";
        echo "<p>اسم المستخدم: <strong>" . $username . "</strong></p>";
        echo "<p>جاري توجيهك الآن إلى لوحة التحكم الخاصة بمنصة Business...</p>";
        echo "</div>";
        
        // التوجيه تلقائياً إلى لوحة التحكم بعد 3 ثوانٍ
        header("refresh:3;url=dashboard.php");
    }
} else {
    // حماية الملف من الدخول المباشر بدون تسجيل
    header("Location: index.php");
    exit();
}
?>
