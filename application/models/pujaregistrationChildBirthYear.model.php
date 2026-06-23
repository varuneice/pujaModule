<?php

require_once MODELS_PATH . 'App.model.php';

class pujaRegistrationChildBirthYearModel extends AppModel
{

    var $primaryKey = 'id';
    var $table = 'pujaregistrationChildBirthYear';

    var $schema = array(
        array('name' => 'id', 'type' => 'INT', 'default' => null),
        array('name' => 'birth_year', 'type' => 'DATE', 'default' => null),
        array('name' => 'admin_id', 'type' => 'INT', 'default' => null),
        array('name' => 'admin_name', 'type' => 'VARCHAR', 'default' => ''),
        array('name' => 'update_date', 'type' => 'DATETIME', 'default' => null)
    );

}

?>