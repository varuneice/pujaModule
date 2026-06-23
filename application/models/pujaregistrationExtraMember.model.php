<?php

require_once MODELS_PATH . 'App.model.php';

class pujaregistrationExtraMemberModel extends AppModel
{
    var $primaryKey = 'id';
    var $table = 'pujaregistration_extra_members';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'registration_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'oid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'first_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'last_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'member_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'is_veggie', 'type' => 'tinyint', 'default' => 0),
        array('name' => 'created_at', 'type' => 'datetime', 'default' => ':NULL')
    );

    public function getByRegistrationId($registrationId)
    {
        $registrationId = (int) $registrationId;
        if ($registrationId <= 0) {
            return array();
        }

        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE registration_id = ' . $registrationId . ' ORDER BY id ASC';
        return $this->execute($sql);
    }

    public function getByOrderId($oid)
    {
        $oid = (int) $oid;
        if ($oid <= 0) {
            return array();
        }

        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE oid = ' . $oid . ' ORDER BY id ASC';
        return $this->execute($sql);
    }

    public function getById($id)
    {
        $id = (int) $id;
        if ($id <= 0) {
            return array();
        }

        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE id = ' . $id . ' LIMIT 1';
        $arr = $this->execute($sql);
        return $arr[0] ?? array();
    }

    public function updateMember($id, $oid, $data)
    {
        $id = (int) $id;
        $oid = (int) $oid;
        if ($id <= 0 || $oid <= 0) {
            return false;
        }

        $firstName = addslashes($data['first_name'] ?? '');
        $lastName = addslashes($data['last_name'] ?? '');
        $memberType = addslashes($data['member_type'] ?? '');
        $isVeggie = !empty($data['is_veggie']) ? 1 : 0;

        $sql = 'UPDATE ' . $this->getTable() . '
            SET first_name = "' . $firstName . '",
                last_name = "' . $lastName . '",
                member_type = "' . $memberType . '",
                is_veggie = ' . $isVeggie . '
            WHERE id = ' . $id . ' AND oid = ' . $oid;

        return $this->execute($sql);
    }

    public function backfillOrderIdForRegistration($registrationId, $oid)
    {
        $registrationId = (int) $registrationId;
        $oid = (int) $oid;
        if ($registrationId <= 0 || $oid <= 0) {
            return false;
        }

        $sql = 'UPDATE ' . $this->getTable() . ' SET oid = ' . $oid . ' WHERE registration_id = ' . $registrationId . ' AND (oid IS NULL OR oid = 0)';
        return $this->execute($sql);
    }
}

?>
