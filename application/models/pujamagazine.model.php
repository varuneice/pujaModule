<?php

require_once MODELS_PATH . 'App.model.php';

class pujamagazineModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'pujamagazine';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'member_status', 'type' => 'varchar', 'default' => ''),
        array('name' => 'mode_of_collection', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
        array('name' => 'membercategory', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Member_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'First_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Last_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'street', 'type' => 'varchar', 'default' => ''),
        array('name' => 'streetname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'unit', 'type' => 'varchar', 'default' => ''),
        array('name' => 'city', 'type' => 'varchar', 'default' => ''),
        array('name' => 'state', 'type' => 'varchar', 'default' => ''),
        array('name' => 'zip', 'type' => 'varchar', 'default' => ''),
        array('name' => 'phone', 'type' => 'varchar', 'default' => ''),
        array('name' => 'alternatenumber', 'type' => 'varchar', 'default' => ''),
        array('name' => 'email', 'type' => 'varchar', 'default' => ''),
        array('name' => 'alternateemail', 'type' => 'varchar', 'default' => ''),
        array('name' => 'magazine', 'type' => 'varchar', 'default' => ''),
        array('name' => 'status', 'type' => 'varchar', 'default' => ''),
        array('name' => 'per_mag_amount', 'type' => 'float', 'default' => ''),
        array('name' => 'totalamount', 'type' => 'float', 'default' => ''),
        array('name' => 'PaymentOption', 'type' => 'varchar', 'default' => ''),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ''),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ''),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ''),
        array('name' => 'oid', 'type' => 'int', 'default' => ''),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ''),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'pay_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_for', 'type' => 'varchar', 'default' => ''),
        array('name' => 'update_on', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'remarks', 'type' => 'varchar', 'default' => ''), 
        array('name' => 'admin_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'bank', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkno', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkdate', 'type' => 'varchar', 'default' => ''),
        array('name' => 'ReceiveBy', 'type' => 'varchar', 'default' => ''),
        array('name' => 'CreatedAt', 'type' => 'date', 'default' => ':NULL')
        
    ); 
     public function getAlldata($opts)
    {
        $current_year = date("Y");
        $Nextyear = date('Y')+1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "04-01") {
            $current_year = $current_year - 1; 
            $Nextyear = date("Y");
        }
        $res = 'SELECT * FROM '.$this->getTable().' WHERE CreatedAt >= "'."$current_year-04-01".'" AND CreatedAt < "'."$Nextyear-03-31".'"  ORDER BY id DESC';
        $result = array();
        $arr = $this->execute($res);
        return $arr; 
    } 
}

?>