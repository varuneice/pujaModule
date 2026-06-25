<?php

require_once MODELS_PATH . 'App.model.php';

class pujaytdtierModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'puja_ytd_tiers';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'season_year', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'tier_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'min_amount', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'max_amount', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'display_order', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'active', 'type' => 'int', 'default' => 1),
        array('name' => 'created_at', 'type' => 'datetime', 'default' => ':NULL'),
        array('name' => 'updated_at', 'type' => 'datetime', 'default' => ':NULL')
    );

    public function ensureTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTable() . "` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `season_year` int(11) NOT NULL,
            `tier_name` varchar(100) NOT NULL,
            `min_amount` int(11) NOT NULL DEFAULT 0,
            `max_amount` int(11) DEFAULT NULL,
            `display_order` int(11) NOT NULL DEFAULT 0,
            `active` tinyint(1) NOT NULL DEFAULT 1,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `idx_puja_ytd_tiers_year_active` (`season_year`, `active`),
            KEY `idx_puja_ytd_tiers_order` (`display_order`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        return $this->execute($sql);
    }

    public function seedDefaults($seasonYear = null)
    {
        $seasonYear = (int) ($seasonYear ?: date('Y'));
        $countSql = "SELECT COUNT(*) AS total FROM `" . $this->getTable() . "` WHERE `season_year` = " . $seasonYear;
        $rows = $this->execute($countSql);

        if (!empty($rows[0]['total'])) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        $defaults = array(
            array('Base 1', 0, 150, 1),
            array('Base 2', 150, 350, 2),
            array('Silver', 750, 999, 3),
            array('Gold', 1000, 1499, 4),
            array('Platinum', 1500, 2199, 5),
            array('Emerald', 2200, 4559, 6),
            array('Diamond', 5000, null, 7)
        );

        foreach ($defaults as $tier) {
            $maxAmount = $tier[2] === null ? 'NULL' : (int) $tier[2];
            $sql = "INSERT INTO `" . $this->getTable() . "` 
                (`season_year`, `tier_name`, `min_amount`, `max_amount`, `display_order`, `active`, `created_at`, `updated_at`)
                VALUES (" . $seasonYear . ", '" . addslashes($tier[0]) . "', " . (int) $tier[1] . ", " . $maxAmount . ", " . (int) $tier[3] . ", 1, '" . $now . "', '" . $now . "')";
            $this->execute($sql);
        }

        return true;
    }

    public function getAllTiers()
    {
        $sql = "SELECT * FROM `" . $this->getTable() . "` ORDER BY `season_year` DESC, `display_order` ASC, `min_amount` ASC";
        return $this->execute($sql);
    }

    public function getActiveTiers($seasonYear = null)
    {
        $seasonYear = (int) ($seasonYear ?: date('Y'));
        $sql = "SELECT * FROM `" . $this->getTable() . "`
            WHERE `season_year` = " . $seasonYear . " AND `active` = 1
            ORDER BY `display_order` ASC, `min_amount` ASC";
        return $this->execute($sql);
    }

    public function getTierForAmount($amount, $seasonYear = null)
    {
        $amount = (float) $amount;
        $seasonYear = (int) ($seasonYear ?: date('Y'));
        $sql = "SELECT * FROM `" . $this->getTable() . "`
            WHERE `season_year` = " . $seasonYear . "
                AND `active` = 1
                AND `min_amount` <= " . $amount . "
                AND (`max_amount` IS NULL OR `max_amount` >= " . $amount . ")
            ORDER BY `display_order` ASC, `min_amount` ASC
            LIMIT 1";
        $rows = $this->execute($sql);
        return !empty($rows[0]) ? $rows[0] : null;
    }

    public function updateTier($data)
    {
        $id = (int) ($data['id'] ?? 0);
        if ($id <= 0) {
            return false;
        }

        $seasonYear = (int) ($data['season_year'] ?? date('Y'));
        $tierName = trim((string) ($data['tier_name'] ?? ''));
        $minAmount = (int) ($data['min_amount'] ?? 0);
        $maxAmountRaw = trim((string) ($data['max_amount'] ?? ''));
        $maxAmount = $maxAmountRaw === '' ? 'NULL' : (int) $maxAmountRaw;
        $displayOrder = (int) ($data['display_order'] ?? 0);
        $active = !empty($data['active']) ? 1 : 0;
        $now = date('Y-m-d H:i:s');

        $sql = "UPDATE `" . $this->getTable() . "` SET
            `season_year` = " . $seasonYear . ",
            `tier_name` = '" . addslashes($tierName) . "',
            `min_amount` = " . $minAmount . ",
            `max_amount` = " . $maxAmount . ",
            `display_order` = " . $displayOrder . ",
            `active` = " . $active . ",
            `updated_at` = '" . $now . "'
            WHERE `id` = " . $id;

        return $this->execute($sql);
    }

    public function addTier($data)
    {
        $seasonYear = (int) ($data['season_year'] ?? date('Y'));
        $tierName = trim((string) ($data['tier_name'] ?? ''));
        $minAmount = (int) ($data['min_amount'] ?? 0);
        $maxAmountRaw = trim((string) ($data['max_amount'] ?? ''));
        $maxAmount = $maxAmountRaw === '' ? 'NULL' : (int) $maxAmountRaw;
        $displayOrder = (int) ($data['display_order'] ?? 0);
        $active = !empty($data['active']) ? 1 : 0;
        $now = date('Y-m-d H:i:s');

        if ($tierName === '') {
            return false;
        }

        $sql = "INSERT INTO `" . $this->getTable() . "`
            (`season_year`, `tier_name`, `min_amount`, `max_amount`, `display_order`, `active`, `created_at`, `updated_at`)
            VALUES (" . $seasonYear . ", '" . addslashes($tierName) . "', " . $minAmount . ", " . $maxAmount . ", " . $displayOrder . ", " . $active . ", '" . $now . "', '" . $now . "')";

        return $this->execute($sql);
    }
}

?>
