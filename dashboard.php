<?php
session_start();
// التحقق من أن العميل قام بتسجيل الدخول الفعلي لحماية الصفحة من المتطفلين
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// محاكاة بيانات المستثمر من قاعدة بيانات منصة Business للتجربة الفورية
$username = $_SESSION['username'] ?? "المستثمر";
$wallet_balance = 500.00; // رصيد المحفظة المتاح للسحب كاش
$total_invested = 0.00;   // إجمالي رأس المال المحجوز في الباقات
$total_earned = 0.00;     // مجموع الأرباح المستلمة حتى الآن
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>BUSINESS | لوحة المستثمر الرقمية</title>
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
        .container { max-width: 1100px; margin: 0 auto; }
        
        /* الهيدر العلوي للمنصة */
        header {
            border-bottom: 2px solid var(--orange-neon);
            padding-bottom: 15px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo { font-size: 32px; font-weight: bold; color: var(--orange-neon); }
        .logo span { color: var(--white); }
        .user-welcome { font-size: 15px; color: var(--gray-text); }
        
        /* تقسيم شاشة الداشبورد */
        .grid-dashboard { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-bottom: 30px; }
        .main-panel, .side-panel { background: var(--card-dark); padding: 25px; border-radius: 16px; border: 1px solid #1a1f2c; }
        
        /* عدادات الرصيد بالدولار */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px; }
        .stat-box { background: #141923; padding: 20px; border-radius: 12px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.3); }
        .stat-box h4 { margin: 0; color: var(--gray-text); font-size: 13px; text-transform: uppercase; }
        .stat-box .num { font-size: 26px; font-weight: bold; margin-top: 10px; }
        .stat-box .num.orange { color: var(--orange-neon); }
        .stat-box .num.green { color: var(--green); }
        
        .section-title { font-size: 18px; font-weight: bold; margin-bottom: 20px; border-right: 4px solid var(--orange-neon); padding-right: 10px; }
        
        /* كروت خطط الاستثمار المباشر المحدثة */
        .plans-list { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
        .plan-item { background: #141923; border: 1px solid #242b3d; padding: 20px; border-radius: 12px; text-align: center; transition: 0.3s; }
        .plan-item:hover { border-color: var(--orange-neon); transform: translateY(-3px); }
        .plan-item h4 { margin: 0; font-size: 18px; color: var(--white); }
        .plan-price { font-size: 30px; color: var(--orange-neon); font-weight: bold; margin: 15px 0; }
        .plan-details { font-size: 13px; color: var(--gray-text); line-height: 1.8; margin-bottom: 15px; }
        
        /* أزرار العمليات */
        .btn-action { background: var(--orange-neon); color: var(--white); border: none; padding: 12px 15px; width: 100%; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.2s; font-size: 14px; }
        .btn-action:hover { background: #e05e00; box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3); }
        
        .input-crypto { width: 100%; padding: 12px; background: #06070a; border: 1px solid #242b3d; border-radius: 8px; color: #fff; margin-bottom: 15px; box-sizing: border-box; }
        .log-box { background: #06070a; border: 1px dashed #242b3d; padding: 15px; border-radius: 8px; font-size: 14px; text-align: center; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <header>
        <div class="logo">$ <span>BUSINESS</span></div>
        <div class="user-welcome">مرحباً بك، <span style="color: var(--orange-neon); font-weight: bold;"><?php echo htmlspecialchars($username); ?></span> 👤 | <a href="logout.php" style="color: var(--red); text-decoration: none; margin-right: 15px;">تسجيل الخروج</a></div>
    </header>

    <div class="grid-dashboard">
        <!-- لوحة المستثمر الرئيسية وعرض المحفظة -->
        <div class="main-panel">
            <div class="stats-row">
                <div class="stat-box"><h4>المحفظة (المتاحة للسحب)</h4><div class="num" id="ui-balance">$ <?php echo number_format($wallet_balance, 2); ?></div></div>
                <div class="stat-box"><h4>رأس المال المستثمر</h4><div class="num orange" id="ui-invested">$ <?php echo number_format($total_invested, 2); ?></div></div>
                <div class="stat-box"><h4>الأرباح المستلمة</h4><div class="num green" id="ui-earned">$ <?php echo number_format($total_earned, 2); ?></div></div>
            </div>

            <div class="section-title">الباقات الاستثمارية ذات العوائد المباشرة الثابتة</div>
            <div class="plans-list">
                <div class="plan-item">
                    <h4>باقة الاستثمار الفضية</h4>
                    <div class="plan-price">$100</div>
                    <div class="plan-details">الربح اليومي: <b>$5.00</b><br>العقد: <b>30 يومًا</b><br>عائد تلقائي مباشر بدون تداول</div>
                    <button class="btn-action" onclick="activateInvestment(100, 5.00, 'الفضية')">تفعيل الباقة</button>
                </div>
                <div class="plan-item">
                    <h4>باقة الاستثمار الذهبية</h4>
                    <div class="plan-price">$300</div>
                    <div class="plan-details">الربح اليومي: <b>$18.00</b><br>العقد: <b>30 يومًا</b><br>عائد تلقائي مباشر بدون تداول</div>
                    <button class="btn-action" onclick="activateInvestment(300, 18.00, 'الذهبية')">تفعيل الباقة</button>
                </div>
                <div class="plan-item">
                    <h4>باقة الاستثمار الماسية</h4>
                    <div class="plan-price">$500</div>
                    <div class="plan-details">الربح اليومي: <b>$35.00</b><br>العقد: <b>30 يومًا</b><br>عائد تلقائي مباشر بدون تداول</div>
                    <button class="btn-action" onclick="activateInvestment(500, 35.00, 'الماسية')">تفعيل الباقة</button>
                </div>
            </div>
            
            <div class="log-box" id="system-log" style="color: var(--gray-text);">نظام الأرباح الآلي مستقر وفي وضع الاستعداد...</div>
        </div>

        <!-- البوابة الجانبية للشحن وعمليات السيرفر التلقائية -->
        <div class="side-panel">
            <div class="section-title">بوابة شحن الرصيد (USDT-TRC20)</div>
            <p style="font-size: 12px; color: var(--gray-text); line-height: 1.6;">قم بالتحويل لعنوان المحفظة أدناه لتنشيط حسابك:<br><code style="color:var(--green); font-size:13px; font-family:monospace;">TY6rX9PqZ7WvM4N1K3B8H5J2L9V4C7X2Z1</code></p>
            <input type="number" id="deposit-amount" class="input-crypto" placeholder="أدخل مبلغ الشحن بالدولار">
            <input type="text" id="deposit-txid" class="input-crypto" placeholder="أدخل رقم معاملة البلوكشين TxID">
            <button class="btn-action" onclick="sendDeposit()">إرسال إشعار الإيداع للتدقيق</button>

            <div style="margin-top: 35px;" class="section-title">محاكي السيرفر السريع لفحص الأرباح</div>
            <p style="font-size: 12px; color: var(--gray-text);">اضغط هنا لمحاكاة مرور 24 ساعة وتأكيد نزول الأرباح في رصيدك مباشرة دون الحاجة لانتظار ليلة كاملة:</p>
            <button class="btn-action" style="background:#141923; border: 1px solid var(--orange-neon);" onclick="triggerDailyProfit()">⏱️ محاكاة مرور 24 ساعة وضخ العوائد</button>
        </div>
    </div>
</div>

<script>
    let currentBalance = 500.00;
    let investedCapital = 0.00;
    let earnedProfits = 0.00;
    let activeDailyYield = 0.00;

    // دالة محاكاة تفعيل الباقات الاستثمارية الصافية
    function activateInvestment(cost, dailyProfit, planName) {
        if (currentBalance < cost) {
            $('#system-log').text('❌ فشل الاشتراك: رصيد المحفظة الحالي غير كافٍ لشراء هذه الباقة!').css('color', 'var(--red)');
            return;
        }
        currentBalance -= cost;
        investedCapital += cost;
        activeDailyYield += dailyProfit;

        $('#ui-balance').text('$ ' + currentBalance.toFixed(2));
        $('#ui-invested').text('$ ' + investedCapital.toFixed(2));
        $('#system-log').text(`✅ نجح الفحص: تم تفعيل الباقة ${planName} بنجاح، وسيبدأ السكربت بتوليد الأرباح المباشرة!`).css('color', 'var(--green)');
    }

    // دالة إرسال إشعار الإيداع بالدولار الرقمي
    function sendDeposit() {
        let amount = parseFloat($('#deposit-amount').val());
        let txid = $('#deposit-txid').val();
        if(!amount || !txid) { alert('يرجى كتابة القيمة ورقم التحويل أولاً!'); return; }

        currentBalance += amount;
        $('#ui-balance').text('$ ' + currentBalance.toFixed(2));
        $('#system-log').text(`💸 تمت محاكاة الموافقة التلقائية: تم تأكيد المعاملة وضخ $${amount.toFixed(2)} في محفظتك!`).css('color', 'var(--green)');
        $('#deposit-amount').val(''); $('#deposit-txid').val('');
    }

    // دالة محاكاة الأتمتة (Cron Job) لتوليد الأرباح تلقائياً بمجرد مرور الوقت
    function triggerDailyProfit() {
        if (investedCapital === 0) {
            $('#system-log').text('⚠️ تنبيه السيرفر: لا توجد باقات استثمارية نشطة حالياً لتوليد أرباح عليها.').css('color', 'var(--orange-neon)');
            return;
        }
        currentBalance += activeDailyYield;
        earnedProfits += activeDailyYield;

        $('#ui-balance').text('$ ' + currentBalance.toFixed(2));
