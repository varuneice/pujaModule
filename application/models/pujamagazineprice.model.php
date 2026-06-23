<?php

require_once MODELS_PATH . 'App.model.php';

class pujamagazinepriceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'magazinepujaprice';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'magazinename', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'price', 'type' => 'varchar', 'default' => ':NULL')
    ); 
    

    public function getAllmagazineprice($opts)
    {

       $res = 'SELECT * FROM '.$this->getTable().' ORDER BY magazinename';
        $result = array();
        $arr = $this->execute($res);
        return $arr; 
    } 

}

?>