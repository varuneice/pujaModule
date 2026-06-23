<?php

require_once MODELS_PATH . 'App.model.php';
$search = $_GET['term'] ?? '';
class createPassReportModel extends AppModel
{

   public $table = 'PassReport';

   public $schema = array(
    array('name' => 'OID', 'type' => 'int', 'default' => ':NULL'),
    array('name' => 'Member_id', 'type' => 'varchar', 'default' => ':NULL'),
    array('name' => 'puja_type', 'type' => 'varchar', 'default' => ':NULL'),
    array('name' => 'RateType', 'type' => 'varchar', 'default' => ':NULL'),
    array('name' => 'First_name', 'type' => 'varchar', 'default' => ':NULL'),
    array('name' => 'Last_name', 'type' => 'varchar', 'default' => ':NULL'),
    array('name' => 'city', 'type' => 'varchar', 'default' => ':NULL'),
    array('name' => 'state', 'type' => 'varchar', 'default' => ':NULL'),
    array('name' => 'childYOB', 'type' => 'varchar', 'default' => ':NULL'),
    array('name' => 'veggie', 'type' => 'varchar', 'default' => ':NULL'),
    array('name' => 'SerialNum', 'type' => 'varchar', 'default' => ':NULL'),
    array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
    array('name' => 'Registrant', 'type' => 'varchar', 'default' => ':NULL')
    
   );
    
}
?>