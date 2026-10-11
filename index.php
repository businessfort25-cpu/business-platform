<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Platform - التسجيل</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; }
        body { background-color: #f4f6f9; display: flex; justify-content: center; align-content: center; min-height: 100vh; padding: 20px; }
        .register-container { background: #ffffff; width: 100%; max-width: 400px; padding: 30px; border-radius: 15px; box-shadow: 0px 10px 25px rgba(0,0,0,0.05); margin: auto; }
        .header-area { text-align: center; margin-bottom: 25px; }
        .header-area h2 { color: #1a2a3a; font-size: 24px; margin-bottom: 5px; }
        .header-area p { color: #7f8c8d; font-size: 14px; }
        .lang-select { width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #dcdde1; background: #fff; font-size: 14px; }
        .form-group { margin-bottom: 15px; text-align: right; }
        .form-group label { display: block; margin-bottom: 8px; color: #2c3e50; font-size: 14px; font-weight: 600; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #dcdde1; border-radius: 8px; font-size: 15px; outline: none; transition: 0.3s; }
        .form-group input:focus { border-color: #3498db; box-shadow: 0px 0px 8px rgba(52, 152, 219, 0.2); }
        .btn-submit { width: 100%; padding: 14px; background-color: #2ecc71; border: none; border-radius: 8px; color: white; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn-submit:hover { background-color: #27ae60; }
    </style>
</head>
<body>

<div class="register-container">
    <div class="header-area">
        <h2>منصة BUSINESS</h2>
        <p>إنشاء حساب استثماري جديد</p>
    </div>

    <select class="lang-select" id="langLanguage">
        <option value="ar">العربية (Arabic)</option>
        <option value="en">English (الإنجليزية)</option>
    </select>

    <form action="register_process.php" method="POST">
        <div class="form-group">
            <label>1. رمز الدعوة (Invitation Code)</label>
            <input type="text" name="invite_code" placeholder="أدخل رمز الدعوة" required>
        </div>
        <div class="form-group">
            <label>2. اسم المستخدم (Username)</label>
            <input type="text" name="username" placeholder="مثال: ahmed2026" required>
        </div>
        <div class="form-group">
            <label>3. رقم الهاتف (Phone Number)</label>
            <input type="tel" name="phone" placeholder="أدخل رقم هاتفك" required>
        </div>
        <div class="form-group">
            <label>4. كلمة المرور (Password)</label>
            <input type="password" name="password" placeholder="أكتب كلمة مرور قوية" required>
        </div>
        <div class="form-group">
            <label>5. تأكيد كلمة المرور (Confirm Password)</label>
            <input type="password" name="confirm_password" placeholder="أعد كتابة كلمة المرور" required>
        </div>
        <div class="form-group">
            <label>6. رمز السحب (Withdrawal PIN)</label>
            <input type="number" name="withdraw_pin" placeholder="رمز من 4 أو 6 أرقام للعمليات المالية" required>
        </div>
        <button type="submit" class="btn-submit">تسجيل الحساب</button>
    </form>
</div>

</body>
</html>
