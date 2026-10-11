<?php
session_start();
// حماية الصفحة ومنع الدخول غير المصرح به
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$error_message = "";
$success_message = "";
$wallet_balance = 500.00; // محاكاة الرصيد الحالي المتاح للسحب من محفظة العميل
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>BUSINESS | سحب الأرباح والعوائد</title>
    <script src="https://jquery.com"></script>
    <style>
        :root {
            --bg-dark: #06070a;
            --card-dark: #0d1017;
            --orange-neon: #ff6b00;
            --white: #ffffff;
            --gray-text: #8e96a7;
            --green: #00e676;
            --red: #ff3d00;
        }
        body {
            background-color: var(--bg-dark);
            color: var(--white);
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container { max-width: 600px; margin: 40px auto; }
        .withdraw-card {
            background: var(--card-dark);
            padding: 35px;
            border-radius: 16px;
            border: 1px solid rgba(255, 107, 0, 0.2);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        h2 { color: var(--orange-neon); text-align: center; margin-bottom: 25px; }
        
        .balance-box {
            background: #141923;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 25px;
            border: 1px solid #1f2433;
        }
        .balance-box span { font-size: 26px; font-weight: bold; color: var(--green); display: block; margin-top: 5px; }
        
        .input-group { margin-bottom: 20px; text-align: right; }
        .input-group label { display: block; margin-bottom: 8px; color: var(--gray-text); font-size: 14px; }
        .input-group input {
            width: 100%; padding: 12px; background: #06070a; border: 1px solid #242b3d;
            border-radius: 8px; color: #fff; box-sizing: border-box; font-size: 15px;
        }
        .input-group input:focus { border-color: var(--orange-neon); outline: none; }
        
        .btn-withdraw {
            background: var(--orange-neon); color: var(--white); border: none;
            padding: 13px; width: 100%; border-radius: 8px; font-weight: bold;
            cursor: pointer; font-size: 16px; transition: 0.2s;
        }
        .btn-withdraw:hover { background: #e05e00; box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3); }
        .back-link { display: block; text-align: center; margin-top: 20px; color: var(--gray-text); text-decoration: none; font-size: 14px; }
        .back-link:hover { color: var(--white); }
        .msg-box { padding: 12px; border-radius: 6px; margin-bottom: 20px; font-weight: bold; text-align: center; font-size: 14px; }
    </style>
</head>
<body>

<div class="container">
    <div class="withdraw-card">
        <h2>طلب سحب الأموال بالدولار</h2>
        
        <div class="balance-box">
            <label style="color: var(--gray-text); font-size: 13px;">الرصيد المتاح للسحب الفوري:</label>
            <span id="current-bal">$ <?php echo number_format($wallet_balance, 2); ?></span>
        </div>

        <div id="status-message"></div>

        <form id="withdrawForm">
            <div class="input-group">
                <label>المبلغ المراد سحبه ($):</label>
                <input type="number" id="withdraw-amount" placeholder="الحد الأدنى للسحب هو $10" required>
            </div>
            <div class="input-group">
                <label>عنوان محفظتك الشخصية (USDT - TRC20):</label>
                <input type="text" id="crypto-wallet" placeholder="أدخل عنوان محفظتك الرقمية بدقة" required>
            </div>
            <button type="submit" class="btn-withdraw">تأكيد طلب السحب الآمن</button>
        </form>

        <a href="dashboard.php" class="back-link">⬅ العودة إلى لوحة الحساب الرئيسية</a>
    </div>
</div>

<script>
    let balance = 500.00;

    $('#withdrawForm').on('submit', function(e) {
        e.preventDefault();
        let amount = parseFloat($('#withdraw-amount').val());
        let wallet = $('#crypto-wallet').val();

        if (amount < 10) {
            $('#status-message').html('<div class="msg-box" style="background:rgba(255,61,0,0.1); color:var(--red); border:1px solid var(--red);">عذراً، الحد الأدنى للسحب هو 10 دولار!</div>');
            return;
        }
        if (amount > balance) {
            $('#status-message').html('<div class="msg-box" style="background:rgba(255,61,0,0.1); color:var(--red); border:1px solid var(--red);">رصيدك الحالي غير كافٍ لإتمام عملية السحب!</div>');
            return;
        }

        // محاكاة معالجة وحسم الرصيد
        balance -= amount;
        $('#current-bal').text('$ ' + balance.toFixed(2));
        $('#withdraw-amount').val('');
        $('#crypto-wallet').val('');
        
        $('#status-message').html('<div class="msg-box" style="background:rgba(0,230,118,0.1); color:var(--green); border:1px solid var(--green);">✔ تم إرسال طلب السحب بنجاح! جارِ المراجعة والتحويل لمحفظتك من قبل الإدارة.</div>');
    });
</script>

</body>
</html>
