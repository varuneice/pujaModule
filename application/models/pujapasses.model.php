<?php

require_once MODELS_PATH . 'App.model.php';

class pujapassesModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'pujapasses';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'puja_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'puja_category', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'member_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'student', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'outoftowner', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
        array('name' => 'membercategory', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Member_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'First_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Last_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'member_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'Sp_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Sp_lname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'spouse_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'childonefname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'childonelname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age1', 'type' => 'int', 'default' => ''),
        array('name' => 'childtwofname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'childtwolname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age2', 'type' => 'int', 'default' => ''),
        array('name' => 'childthreefname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'childthreelname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age3', 'type' => 'int', 'default' => ''),
        array('name' => 'street', 'type' => 'varchar', 'default' => ''),
        array('name' => 'streetname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'unit', 'type' => 'varchar', 'default' => ''),
        array('name' => 'city', 'type' => 'varchar', 'default' => ''),
        array('name' => 'state', 'type' => 'varchar', 'default' => ''),
        array('name' => 'zip', 'type' => 'varchar', 'default' => ''),
        array('name' => 'phone', 'type' => 'varchar', 'default' => ''),
        array('name' => 'alternatenumber', 'type' => 'varchar', 'default' => ''),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'alternateemail', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'senior', 'type' => 'tinyint', 'default' => ':NULL'),
        array('name' => 'senior_veggie', 'type' => 'tinyint', 'default' => ':NULL'),
        array('name' => 'no_of_parent', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'parent1_fname', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'parent1_lname', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'parent1_veggie', 'type' => 'tinyint', 'default' => ':NULL'), 
		array('name' => 'parent2_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'parent2_lname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'parent2_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'schoolname', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'studentavatar', 'type' => 'varchar', 'default' => ''),
        array('name' => 'addressavatar', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'extraparentregistration', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'amount', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'totalamount', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'PaymentOption', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'payment_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'oid', 'type' => 'int', 'default' => ''),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ''),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'pay_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_for', 'type' => 'varchar', 'default' => ''),
        array('name' => 'update_on', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'remarks', 'type' => 'varchar', 'default' => ''),
        array('name' => 'bank', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkno', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkdate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'receiveby', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'DepositAccount', 'type' => 'varchar', 'default' => ''),
        array('name' => 'CreatedAt', 'type' => 'date', 'default' => ':NULL')
        
    );
    
    
    
    public function getAlldata_29_sep($opts)
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
    
    
    public function getAlldata($opts)
   {
       date_default_timezone_set("America/Chicago");
       $current_year = date("Y");
       $next_year = $current_year + 1;


      if (date("m-d") < "07-01") {
        $current_year = $current_year - 1;
        $next_year = $current_year + 1;
        }

        // Range covers full Jul–Jun cycle so Apr/May/Jun records are not excluded
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE CreatedAt >= "' . $current_year . '-07-01" AND CreatedAt <= "' . $next_year . '-06-30" ORDER BY id DESC';

        $arr = $this->execute($res);
        return $arr;
   }

    
 public function documentdata($id) {

        $sql = 'SELECT * FROM '.$this->getTable().' WHERE id="'."$id".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr[0];
    }
    public function getOID($id)
    {
        $sql = 'SELECT oid FROM '.$this->getTable().' WHERE id="' . $id . '"';
        $arr = $this->execute($sql);
        return $arr[0];
   
    }
    
}            

?>
