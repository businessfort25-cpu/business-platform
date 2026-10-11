<?php
// إعدادات الاتصال الآمن بسيرفر منصة Business
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // اسم مستخدم السيرفر الافتراضي
define('DB_PASSWORD', '');     // كلمة مرور السيرفر الافتراضية
define('DB_NAME', 'business_platform'); // اسم قاعدة البيانات المعتمدة

/* محاولة الاتصال بقاعدة البيانات والتحقق من سلامة الأكواد */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// فحص الاتصال ومنع تسريب الأخطاء للمخترقين
if($link === false){
    die("عذراً! حدث خطأ تقني أثناء الاتصال بخادم منصة Business المالي.");
}
?>
