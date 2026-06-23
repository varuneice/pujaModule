<?php

require_once MODELS_PATH . 'App.model.php';

class ticketModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'tickets';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'oid', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'regmember', 'type' => 'varchar', 'default' => ''),
        array('name' => 'numberofadults', 'type' => 'varchar', 'default' => ''),
        array('name' => 'additional_adult_amount', 'type' => 'varchar', 'default' => ''),
        array('name' => 'adult1_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'adult2_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'adult3_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'adult4_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'numberofchilds', 'type' => 'varchar', 'default' => ''),
        array('name' => 'additional_child_amount', 'type' => 'varchar', 'default' => ''),
        array('name' => 'child1_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'child2_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'child3_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
        array('name' => 'street', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'address', 'type' => 'varchar', 'default' => ':NULL'),
         array('name' => 'city', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'state', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'zip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'email2', 'type' => 'varchar', 'default' => ':NULL'),
         array('name' => 'tele', 'type' => 'varchar', 'default' => ':NULL'),
         array('name' => 'tele2', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'item_cost', 'type' => 'varchar', 'default' => ':NULL'),
         array('name' => 'item_number', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'item_name', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'amount', 'type' => 'float', 'default' => ''),
        array('name' => 'pay_for', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_date', 'type' => 'datetime', 'default' => ''),
        array('name' => 'txn_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'PaymentOption', 'type' => 'varchar', 'default' => ''),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'cc_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'remarks', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'created_on', 'type' => 'datetime', 'default' => ''),
        array('name' => 'UpdateOn', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'eventid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'itemeventday', 'type' => 'varchar', 'default' => ''),
        array('name' => 'bank', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkno', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkdate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'ReceiveBy', 'type' => 'varchar', 'default' => ''),
        array('name' => 'eventtype', 'type' => 'varchar', 'default' => ''),
        // new field add
        array('name' => 'tickettype', 'type' => 'varchar', 'default' => ''),
        array('name' => 'spousename', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Child1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age1', 'type' => 'int', 'default' => ''),
        array('name' => 'Child2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age2', 'type' => 'int', 'default' => ''),
        array('name' => 'Child3', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age3', 'type' => 'int', 'default' => ''),
        array('name' => 'Parent1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Parent2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_id', 'type' => 'int', 'default' => ''),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'DepositAccount', 'type' => 'varchar', 'default' => '')
    );
 
    function getticketMaxid(){
        $sql = 'SELECT MAX(id) AS id FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['id'])){
            return $res[0]['id'];
        }else{
            return 0;
        }
    }

    public function ticketAlldata($opts)
    {
        $current_year = date("Y");
        $Nextyear = date('Y')+1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "04-01") {
            $current_year = $current_year - 1; 
            $Nextyear = date("Y");
        }
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE created_on >= "'."$current_year-04-01".'" AND created_on < "'."$Nextyear-03-31".'" AND eventtype ="'."PujaTicket".'" ORDER BY id DESC';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    
    public function getAllticketdata($opts)
    {

        $res = 'SELECT * FROM '.$this->getTable().'  ORDER BY id DESC';
        $result = array();
        $arr = $this->execute($res);
        return $arr; 
    } 
}            

?>