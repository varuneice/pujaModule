<?php

use Twilio\Values;

require_once MODELS_PATH . 'App.model.php';

class FoodCouponSessionName extends AppModel
{

    var $table = 'foodcouponsessionname';
    var $primaryKey = 'id';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'sessionCode', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'sessionName', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Active', 'type' => 'varchar', 'default' => ':NULL')
    );


    public function setFoodCouponSession($updateCodeVal, $OldSessionCode)
    {

        $sql = " UPDATE " . $this->table . " SET sessionCode = '$updateCodeVal' WHERE sessionCode = '$OldSessionCode'";
        $arr = $this->execute($sql);
        return $sql;
    }


    public function getFoodCouponSession()
    {
        $sql = "SELECT * FROM " . $this->table. " WHERE Active = 'Y'";
        // $result = array();
        $arr = $this->execute($sql);
        return $arr;
    }


    public function getSesionCodeById($id)
    {
        $sql = "SELECT * FROM " . $this->table . ' WHERE id = ' . $id;
        $arr = $this->execute($sql);
        return $arr;
    }

    public function updateSession($sessionCode , $sessionName , $id)
    {
        $sql = "UPDATE " . $this->table . " SET sessionCode = '$sessionCode', sessionName = '$sessionName' WHERE id = $id ";
        $arr = $this->execute($sql);
        return $arr;
    }

    public function getFoodCoupon($sessionCode)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE sessionCode = '$sessionCode'";
        $arr = $this->execute($sql);
    
        foreach($arr as $value)
        {
            return $value["sessionName"];
        }
        
    }
}
