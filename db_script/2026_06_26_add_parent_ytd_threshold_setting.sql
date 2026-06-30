-- Adds the configurable YTD threshold used to decide whether parent registration fee applies.
-- Run this once on local and Azure before changing the value from the admin panel.

CREATE TABLE IF NOT EXISTS `puja_registration_settings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `season_year` int(11) NOT NULL,
    `setting_key` varchar(100) NOT NULL,
    `setting_value` varchar(255) NOT NULL,
    `active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_puja_registration_setting` (`season_year`, `setting_key`),
    KEY `idx_puja_registration_settings_active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @season_year = YEAR(CURDATE());
SET @now = NOW();

INSERT INTO `puja_registration_settings`
    (`season_year`, `setting_key`, `setting_value`, `active`, `created_at`, `updated_at`)
VALUES
    (@season_year, 'parent_ytd_threshold', '749', 1, @now, @now)
ON DUPLICATE KEY UPDATE
    `setting_value` = VALUES(`setting_value`),
    `active` = 1,
    `updated_at` = @now;
