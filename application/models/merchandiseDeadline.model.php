<?php

require_once MODELS_PATH . 'App.model.php';

class merchandiseDeadlineModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'merchandisedeadline';

    
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => null, 'primary' => true, 'auto_increment' => true),
        array('name' => 'admin_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'createdAt', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'deadline', 'type' => 'datetime', 'default' => ':NULL')  
    );
    

    

    public function getDeadLine()
    {
        $sql = 'SELECT * FROM ' . $this->getTable();
        $result = array();
        $arr = $this->execute($sql);

        return $arr;


    }
    
   

}

?>