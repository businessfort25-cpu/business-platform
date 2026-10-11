-- 4. إنشاء جدول طلبات سحب الأرباح للمستثمرين
CREATE TABLE IF NOT EXISTS `business_withdrawals` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `crypto_wallet` VARCHAR(255) NOT NULL,
  `status` VARCHAR(20) DEFAULT 'pending', -- معلق حتى يوافق الأدمن
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
