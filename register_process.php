<?php
// بدء الجلسة لحفظ بيانات المستخدم بعد التسجيل
session_start();

// 1. الاتصال بقاعدة البيانات الخاصة بمنصة Business
$host = "localhost";
$db_user = "root"; // اسم مستخدم قاعدة البيانات الافتراضي
$db_pass = "";     // كلمة المرور الافتراضية
$db_name = "business_platform"; // اسم قاعدة البيانات المعتمدة

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// التحقق من سلامة الاتصال بالسيرفر
if ($conn->connect_error) {
    die("خطأ في الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// 2. استقبال البيانات القادمة من واجهة التسجيل وتنقيتها من الثغرات
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // فحص الحقول للتأكد من عدم تركها فارغة
    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "يرجى ملء كافة الحقول المطلوبة!"]);
        exit();
    }

    // 3. التحقق من أن البريد الإلكتروني غير مسجل مسبقاً في منصة Business
    $check_email = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($check_email);
    
    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "هذا البريد الإلكتروني مسجل بالفعل في المنصة!"]);
        exit();
    }

    // 4. تشفير كلمة المرور لحماية حسابات المستثمرين من السرقة واختراق السيرفر
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // توليد كود إحالة فريد وتلقائي لكل مستثمر جديد ينضم للمنصة
    $referral_code = "BUS-" . strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));

    // 5. إدخال المستثمر الجديد إلى قاعدة البيانات وضخ رصيد تجريبي ترحيبي
    $insert_user = "INSERT INTO users (username, email, password, referral_code, wallet_balance) 
                    VALUES ('$username', '$email', '$hashed_password', '$referral_code', 0.00)";

    if ($conn->query($insert_user) === TRUE) {
        echo json_encode(["status" => "success", "message" => "تم إنشاء حسابك بنجاح في منصة Business! 🚀"]);
    } else {
        echo json_encode(["status" => "error", "message" => "حدث خطأ أثناء التسجيل: " . $conn->error]);
    }

    $conn->close();
}
?>
