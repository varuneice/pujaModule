<?php

require_once MODELS_PATH . 'App.model.php';

class sponsoritemmodel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'sponsoritem';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'itemname', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'category', 'type' => 'varchar', 'default' => ':NULL') ,
        array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL')
       
    );

//     public function sponsorCategoryA()
//   {
//     $res = 'SELECT * FROM '.$this->getTable().' WHERE category = "'."Category A".'" ';
//     $result = array();
//     $arr = $this->execute($res);
//     return $arr; 
//   }

//   public function sponsorCategoryB()
//   {
//     $res = 'SELECT * FROM '.$this->getTable().' WHERE category = "'."Category B".'" ';
//     $result = array();
//     $arr = $this->execute($res);
//     return $arr; 
//   }
  
  public function sponsorCategoryA()
  {
    $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE category = "Category A" AND status = "active"';
    $arr = $this->execute($res);
    return $arr;
  }

  public function sponsorCategoryB()
  {
    $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE category = "Category B" AND status = "active"';
    $arr = $this->execute($res);
    return $arr;
  }
    
}

?>