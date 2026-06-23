<?php

require_once MODELS_PATH . 'App.model.php';

class merchandisePriceLimitModel extends AppModel
{

    var $primaryKey = 'id';
    var $table = 'merchandisepricelimit';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => null, 'primary' => true, 'auto_increment' => true),
        array('name' => 'admin_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'cloth_type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'cloth_name', 'type' => 'varchar', 'default' => ':NULL'),
       
        array('name' => 'price_regular', 'type' => 'varchar', 'default' => ''),
        array('name' => 'limit_regular', 'type' => 'varchar', 'default' => ''),
        array('name' => 'price_early', 'type' => 'varchar', 'default' => ''),
        array('name' => 'limit_early', 'type' => 'varchar', 'default' => ''),
        array('name' => 'image_path', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'createdAt', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
    );

    // for oid row 
    public function getAllData()
    {
        //$code =trim($cmCode);
        // $Date = date("Y/m/d");
        $sql = 'SELECT * FROM ' . $this->getTable();
        $result = array();
        $arr = $this->execute($sql);

        return $arr;


    }

    function getBasedOnId($id)
    {
        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE id = "' . intval($id) . '"';

        $result = array();
        $arr = $this->execute($sql);

        return $arr;


    }

    function deletBasedOnId($id)
    {
        $sql = 'DELETE FROM ' . $this->getTable() . ' WHERE id = ' . intval($id);
        $result = $this->execute($sql);
        return $result;

    }


    // for mid row

    public function Updatemid($id)
    {
        //$code =trim($cmCode);
        // $Date = date("Y/m/d");
        $sql = 'UPDATE ' . $this->getTable() . ' SET reg_uid ="' . $id . '" WHERE id="' . "1" . '"';
        $result = array();
        $arr = $this->execute($sql);

        return $arr;

    }
    function getMaxmid()
    {
        $sql = 'SELECT MAX(reg_uid) AS reg_uid FROM ' . $this->getTable() . '; ';

        $res = $this->execute($sql);

        if (!empty($res[0]['reg_uid'])) {
            return $res[0]['reg_uid'];
        } else {
            return 0;
        }
    }

}

?>