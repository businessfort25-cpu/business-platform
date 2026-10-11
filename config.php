<?php
// إعدادات الاتصال بقاعدة البيانات (سندخل البيانات الحقيقية عند رفعها للاستضافة لاحقاً)
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'business_db');

/* محاولة الاتصال بقاعدة بيانات MySQL */
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USERNAME, DB_PASSWORD);
    // ضبط وضع الأخطاء لإظهار التحذيرات في حال وجود مشكلة تقنية
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("خطأ: لم نتمكن من الاتصال بقاعدة البيانات. " . $e->getMessage());
}
?>
