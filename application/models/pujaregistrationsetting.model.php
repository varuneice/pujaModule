<?php

require_once MODELS_PATH . 'App.model.php';

class pujaregistrationsettingModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'puja_registration_settings';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'season_year', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'setting_key', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'setting_value', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'active', 'type' => 'int', 'default' => 1),
        array('name' => 'created_at', 'type' => 'datetime', 'default' => ':NULL'),
        array('name' => 'updated_at', 'type' => 'datetime', 'default' => ':NULL')
    );

    public function ensureTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTable() . "` (
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        return $this->execute($sql);
    }

    public function seedDefaults($seasonYear = null)
    {
        $seasonYear = (int) ($seasonYear ?: date('Y'));
        return $this->seedSetting($seasonYear, 'child_yob_cutoff', '2004');
    }

    public function seedSetting($seasonYear, $key, $value)
    {
        $seasonYear = (int) $seasonYear;
        $key = addslashes($key);
        $rows = $this->execute("SELECT COUNT(*) AS total FROM `" . $this->getTable() . "` WHERE `season_year` = " . $seasonYear . " AND `setting_key` = '" . $key . "'");

        if (!empty($rows[0]['total'])) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `" . $this->getTable() . "`
            (`season_year`, `setting_key`, `setting_value`, `active`, `created_at`, `updated_at`)
            VALUES (" . $seasonYear . ", '" . $key . "', '" . addslashes($value) . "', 1, '" . $now . "', '" . $now . "')";

        return $this->execute($sql);
    }

    public function getAllSettings()
    {
        $sql = "SELECT * FROM `" . $this->getTable() . "` ORDER BY `season_year` DESC, `setting_key` ASC";
        return $this->execute($sql);
    }

    public function getActiveSettingValue($key, $defaultValue = '', $seasonYear = null)
    {
        $seasonYear = (int) ($seasonYear ?: date('Y'));
        $key = addslashes($key);
        $sql = "SELECT `setting_value` FROM `" . $this->getTable() . "`
            WHERE `season_year` = " . $seasonYear . "
            AND `setting_key` = '" . $key . "'
            AND `active` = 1
            LIMIT 1";
        $rows = $this->execute($sql);

        if (!empty($rows[0]['setting_value'])) {
            return $rows[0]['setting_value'];
        }

        return $defaultValue;
    }

    public function updateSetting($data)
    {
        $id = (int) ($data['id'] ?? 0);
        if ($id <= 0) {
            return false;
        }

        $seasonYear = (int) ($data['season_year'] ?? date('Y'));
        $settingKey = trim((string) ($data['setting_key'] ?? ''));
        $settingValue = trim((string) ($data['setting_value'] ?? ''));
        $active = !empty($data['active']) ? 1 : 0;
        $now = date('Y-m-d H:i:s');

        if ($settingKey === '') {
            return false;
        }

        $sql = "UPDATE `" . $this->getTable() . "` SET
            `season_year` = " . $seasonYear . ",
            `setting_key` = '" . addslashes($settingKey) . "',
            `setting_value` = '" . addslashes($settingValue) . "',
            `active` = " . $active . ",
            `updated_at` = '" . $now . "'
            WHERE `id` = " . $id;

        return $this->execute($sql);
    }
}

?>
