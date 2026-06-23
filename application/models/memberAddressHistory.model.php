<?php

require_once MODELS_PATH . 'App.model.php';

class memberAddressHistoryModel extends AppModel
{
    var $primaryKey = 'id';
    var $table = 'member_address_history';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'old_Address1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'old_Address2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'old_Address3', 'type' => 'varchar', 'default' => ''),
        array('name' => 'old_City', 'type' => 'varchar', 'default' => ''),
        array('name' => 'old_State', 'type' => 'varchar', 'default' => ''),
        array('name' => 'old_Zip', 'type' => 'varchar', 'default' => ''),
        array('name' => 'new_Address1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'new_Address2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'new_Address3', 'type' => 'varchar', 'default' => ''),
        array('name' => 'new_City', 'type' => 'varchar', 'default' => ''),
        array('name' => 'new_State', 'type' => 'varchar', 'default' => ''),
        array('name' => 'new_Zip', 'type' => 'varchar', 'default' => ''),
        array('name' => 'source', 'type' => 'varchar', 'default' => ''),
        array('name' => 'created_at', 'type' => 'datetime', 'default' => ':NULL')
    );

    public function ensureTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTable() . "` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `Member_id` INT NOT NULL,
            `old_Address1` VARCHAR(255) NOT NULL DEFAULT '',
            `old_Address2` VARCHAR(255) NOT NULL DEFAULT '',
            `old_Address3` VARCHAR(255) NOT NULL DEFAULT '',
            `old_City` VARCHAR(100) NOT NULL DEFAULT '',
            `old_State` VARCHAR(100) NOT NULL DEFAULT '',
            `old_Zip` VARCHAR(20) NOT NULL DEFAULT '',
            `new_Address1` VARCHAR(255) NOT NULL DEFAULT '',
            `new_Address2` VARCHAR(255) NOT NULL DEFAULT '',
            `new_Address3` VARCHAR(255) NOT NULL DEFAULT '',
            `new_City` VARCHAR(100) NOT NULL DEFAULT '',
            `new_State` VARCHAR(100) NOT NULL DEFAULT '',
            `new_Zip` VARCHAR(20) NOT NULL DEFAULT '',
            `source` VARCHAR(100) NOT NULL DEFAULT '',
            `created_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `idx_member_address_history_member` (`Member_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        return $this->execute($sql);
    }

    public function saveChange($memberId, $oldAddress, $newAddress, $source = 'Puja Registration')
    {
        $this->ensureTable();

        $value = array(
            'Member_id' => (int) $memberId,
            'old_Address1' => $oldAddress['Address1'] ?? '',
            'old_Address2' => $oldAddress['Address2'] ?? '',
            'old_Address3' => $oldAddress['Address3'] ?? '',
            'old_City' => $oldAddress['City'] ?? '',
            'old_State' => $oldAddress['State'] ?? '',
            'old_Zip' => $oldAddress['Zip'] ?? '',
            'new_Address1' => $newAddress['Address1'] ?? '',
            'new_Address2' => $newAddress['Address2'] ?? '',
            'new_Address3' => $newAddress['Address3'] ?? '',
            'new_City' => $newAddress['City'] ?? '',
            'new_State' => $newAddress['State'] ?? '',
            'new_Zip' => $newAddress['Zip'] ?? '',
            'source' => $source,
            'created_at' => date('Y-m-d H:i:s')
        );

        return $this->save($value);
    }
}

?>
