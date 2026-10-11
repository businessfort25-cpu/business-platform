<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Platform - لوحة التحكم</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; }
        body { background-color: #f4f6f9; padding-bottom: 80px; }
        
        /* الهيدر العلوي */
        .top-header { background: #1a2a3a; color: white; padding: 20px; text-align: center; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; }
        .top-header h2 { font-size: 20px; }
        
        /* كارت المحفظة والأموال */
        .wallet-card { background: linear-gradient(135deg, #2ecc71, #27ae60); color: white; margin: 20px; padding: 25px; border-radius: 15px; box-shadow: 0 8px 15px rgba(46, 204, 113, 0.2); text-align: center; }
        .wallet-card .balance-title { font-size: 14px; opacity: 0.9; margin-bottom: 5px; }
        .wallet-card .balance-amount { font-size: 32px; font-weight: bold; margin-bottom: 15px; }
        
        /* تفاصيل الأرباح الداخلية */
        .stats-grid { display: flex; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 15px; }
        .stat-box { flex: 1; text-align: center; }
        .stat-box:first-child { border-left: 1px solid rgba(255,255,255,0.3); }
        .stat-title { font-size: 11px; opacity: 0.8; }
        .stat-value { font-size: 16px; font-weight: bold; }

        /* أزرار العمليات السريعة */
        .action-buttons { display: flex; justify-content: space-around; margin: 20px; }
        .action-btn { flex: 1; margin: 0 10px; padding: 14px; border: none; border-radius: 10px; font-size: 16px; font-weight: bold; color: white; cursor: pointer; text-align: center; text-decoration: none; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .btn-deposit { background-color: #3498db; }
        .btn-withdraw { background-color: #e74c3c; }

        /* قسم الخطط النشطة */
        .section-title { margin: 20px; font-size: 18px; color: #2c3e50; }
        .active-plans { background: white; margin: 20px; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); text-align: center; color: #7f8c8d; }

        /* شريط التنقل السفلي للهاتف */
        .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; background: white; height: 65px; display: flex; justify-content: space-around; align-items: center; border-top: 1px solid #e0e0e0; box-shadow: 0 -4px 10px rgba(0,0,0,0.05); }
        .nav-item { text-align: center; color: #7f8c8d; text-decoration: none; font-size: 12px; font-weight: 600; flex: 1; }
        .nav-item.active { color: #27ae60; }
        .nav-icon { font-size: 20px; display: block; margin-bottom: 2px; }
    </style>
</head>
<body>

    <!-- الهيدر العلوي -->
    <div class="top-header">
        <h2>منصة BUSINESS للاستثمار 🚀</h2>
    </div>

    <!-- كارت الرصيد والأرباح -->
    <div class="wallet-card">
        <div class="balance-title">إجمالي الرصيد المتاح</div>
        <div class="balance-amount">$0.00</div>
        
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-title">أرباح اليوم</div>
                <div class="stat-value">$0.00</div>
            </div>
            <div class="stat-box">
                <div class="stat-title">إجمالي السحوبات</div>
                <div class="stat-value">$0.00</div>
            </div>
        </div>
    </div>

    <!-- أزرار الإيداع والسحب السريعة -->
    <div class="action-buttons">
        <a href="#" class="action-btn btn-deposit">📥 إيداع أموال</a>
        <a href="#" class="action-btn btn-withdraw">📤 سحب الأرباح</a>
    </div>

    <!-- الخطط الاستثمارية النشطة -->
    <div class="section-title">مشاريعك الاستثمارية الحالية</div>
    <div class="active-plans">
        <p>ليس لديك أي خطط استثمارية نشطة حالياً. اذهب لقسم الخطط وابدأ الاستثمار!</p>
    </div>

    <!-- شريط التنقل السفلي الثابت للهاتف -->
    <div class="bottom-nav">
        <a href="dashboard.php" class="nav-item active">
            <span class="nav-icon">🏠</span>
            الرئيسية
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon">📊</span>
            الخطط
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon">👥</span>
            الفريق
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon">👤</span>
            الحساب
        </a>
    </div>

</body>
</html>
