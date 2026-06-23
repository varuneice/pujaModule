<?php

require_once MODELS_PATH . 'App.model.php';

class noparkingModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'noparking';
    
     var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'bank', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkno', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkdate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'MemberName', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Amount', 'type' => 'float', 'default' => ''),
        array('name' => 'PaymentOption', 'varchar' => 'decimal', 'default' => ''),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'update_on', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
        array('name' => 'pay_date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'cc_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'remarks', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'oid', 'type' => 'int', 'default' => ''),
        array('name' => 'pay_type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'pay_for', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Address', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Street', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'State', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Zip_Code', 'type' => 'varchar', 'default' => ':NULL'),
        //array('name' => 'Phone_Number', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Tele1', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'alternatenumber', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'alternateemail', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'City', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'eventid', 'type' => 'float', 'default' => ''),
        array('name' => 'spousename', 'type' => 'varchar', 'default' => ''),
        array('name' => 'purpose', 'type' => 'varchar', 'default' => ''),
        array('name' => 'ReceiveBy', 'type' => 'varchar', 'default' => ''),
        array('name' => 'paymentfor', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'admin_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'membercategory', 'type' => 'varchar', 'default' => ''),
        array('name' => 'DepositAccount', 'type' => 'varchar', 'default' => '') ,
        array('name' => 'greenFieldParkingDecision', 'type' => 'varchar', 'default' => '')
       

    );
    
    
}

?>