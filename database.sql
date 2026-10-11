-- إنشاء جدول المستخدمين لمنصة Business للاستثمار
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,            -- الرقم التعريفي الفريد لكل مستخدم
    `invite_code` VARCHAR(50) NOT NULL,             -- 1. رمز الدعوة الذي سجل من خلاله
    `username` VARCHAR(50) NOT NULL UNIQUE,         -- 2. اسم المستخدم (فريد ولا يتكرر)
    `phone` VARCHAR(20) NOT NULL,                   -- 3. رقم الهاتف
    `password` VARCHAR(255) NOT NULL,               -- 4 & 5. كلمة المرور (ستخزن مشفرة للأمان)
    `withdraw_pin` VARCHAR(6) NOT NULL,             -- 6. رمز السحب المالي لحماية الأموال
    `balance` DECIMAL(10, 2) DEFAULT 0.00,          -- رصيد المستخدم الحالي في المنصة
    `today_earnings` DECIMAL(10, 2) DEFAULT 0.00,    -- أرباح المستخدم لهذا اليوم
    `total_withdrawals` DECIMAL(10, 2) DEFAULT 0.00, -- إجمالي سحوبات المستخدم
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- تاريخ ووقت إنشاء الحساب تلقائياً
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
