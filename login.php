<?php
session_start();

// إذا كان المستثمر قد سجل دخوله مسبقاً، يتم توجيهه تلقائياً للوحة الأرباح دون الحاجة لإعادة الكتابة
if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit();
}

// محاكاة التحقق البرمجي الآمن عند ضغط زر الدخول
$error_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        // إنشاء جلسة افتراضية آمنة للمستثمر للتجربة الفورية والمباشرة للموقع
        $_SESSION['user_id'] = 101;
        $_SESSION['username'] = "المستثمر التجريبي";
        $_SESSION['email'] = $email;
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "يرجى كتابة البريد الإلكتروني وكلمة المرور بشكل صحيح!";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>منصة BUSINESS - بوابة تسجيل الدخول الآمن</title>
    <style>
        :root {
            --dark-black: #090a0f; /* الأسود الداكن للفخامة */
            --brand-orange: #ff6b00; /* البرتقالي النيون الجاذب للعين */
            --pure-white: #ffffff; /* الأبيض للنصوص */
            --gray-text: #a0aec0;
            --red-danger: #ff3d00;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--dark-black);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* صندوق تسجيل الدخول المطور فوق الخلفية */
        .login-container {
            background: #0f121a;
            border: 1px solid rgba(255, 107, 0, 0.2); /* حدود برتقالية خفيفة */
            padding: 45px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7);
            width: 380px;
            box-sizing: border-box;
            text-align: center;
        }

        /* تصميم رمز الدولار الفخم في أعلى الصندوق */
        .brand-logo {
            font-size: 42px;
            color: var(--brand-orange);
            font-weight: bold;
            margin-bottom: 10px;
        }

        .brand-logo span {
            color: var(--pure-white);
        }

        .login-container h2 {
            color: var(--pure-white);
            margin: 0 0 25px 0;
            font-size: 18px;
            letter-spacing: 0.5px;
        }

        /* الحقول النصية باللون الأسود والأبيض */
        .input-group {
            margin-bottom: 20px;
            text-align: right;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            background: #131722;
            border: 1px solid #2a2e39;
            border-radius: 8px;
            color: var(--pure-white);
            font-size: 15px;
            box-sizing: border-box;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: var(--brand-orange);
            outline: none;
            box-shadow: 0 0 10px rgba(255, 107, 0, 0.2);
        }

        /* زر الدخول باللون البرتقالي النيون */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: var(--brand-orange);
            border: none;
            border-radius: 8px;
            color: var(--pure-white);
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(255, 107, 0, 0.3);
        }

        .btn-login:hover {
            background: #e05e00;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.4);
        }

        .switch-page {
            margin-top: 20px;
            font-size: 13px;
            color: var(--gray-text);
        }

        .switch-page a {
            color: var(--brand-orange);
            text-decoration: none;
            font-weight: bold;
        }

        .error-box {
            background: rgba(255, 61, 0, 0.1);
            border: 1px solid var(--red-danger);
            color: var(--red-danger);
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- هوية وماركة منصة Business الرسمية -->
        <div class="brand-logo">$ <span>BUSINESS</span></div>
        <h2>بوابة المستثمرين الرقمية</h2>
        
        <?php if(!empty($error_message)): ?>
            <div class="error-box"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="البريد الإلكتروني للـحساب" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="كلمة المرور السرية" required>
            </div>
            <button type="submit" class="btn-login">تسجيل الدخول الآمن</button>
        </form>

        <div class="switch-page">
            ليس لديك حساب استثماري؟ <a href="register.html">اضغط لإنشاء حساب</a>
        </div>
    </div>

</body>
</html>
