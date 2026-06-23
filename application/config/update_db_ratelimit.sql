-- Rate-limiting table for login and payment brute-force protection
-- Run once on every environment (local, test, prod) before deploying Phase 6.

CREATE TABLE IF NOT EXISTS `login_attempts` (
    `id`           INT          NOT NULL AUTO_INCREMENT,
    `action`       VARCHAR(50)  NOT NULL,
    `identifier`   VARCHAR(255) NOT NULL,
    `attempted_at` DATETIME     NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_action_id_time` (`action`, `identifier`, `attempted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
