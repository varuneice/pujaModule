<?php

require_once MODELS_PATH . 'App.model.php';

class pujaRegistrationDateModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'pujaregistrationdate';
    
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'registrationDate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'admin_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => '')


    );

}

?>