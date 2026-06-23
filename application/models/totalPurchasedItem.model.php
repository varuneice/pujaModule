<?php

require_once MODELS_PATH . 'App.model.php';

class totalPurchasedItemModel extends AppModel
{

    var $primaryKey = 'id';
    var $table = 'totalpurchaseditem';
    var $schema = array(
    array('name' => 'id', 'type' => 'int', 'primary' => true, 'auto_increment' => true),
    array('name' => 'Payment_For', 'type' => 'varchar', 'default' => ''),
    array('name' => 'member_id', 'type' => 'varchar', 'default' => ''),
    array('name' => 'F_Name', 'type' => 'varchar', 'default' => ''),
    array('name' => 'L_Name', 'type' => 'varchar', 'default' => ''),
    array('name' => 'SFirst_Name', 'type' => 'varchar', 'default' => ''),
    array('name' => 'SLast_Name', 'type' => 'varchar', 'default' => ''),
    array('name' => 'City', 'type' => 'varchar', 'default' => ''),
    array('name' => 'State', 'type' => 'varchar', 'default' => ''),
    array('name' => 'Zip', 'type' => 'varchar', 'default' => ''),
    array('name' => 'fullAddress', 'type' => 'varchar', 'default' => ''),
    array('name' => 'phone', 'type' => 'varchar', 'default' => ''),
    array('name' => 'email', 'type' => 'varchar', 'default' => ''),
    array('name' => 'total_kurta_price', 'type' => 'varchar', 'default' => ''),
    array('name' => 'punjabi_name', 'type' => 'varchar', 'default' => ''),
    array('name' => 'punjabi_beige_red_qty', 'type' => 'varchar', 'default' => ''),
    array('name' => 'punjabi_white_red_qty', 'type' => 'varchar', 'default' => ''),
    array('name' => 'punjabi_beige_red_size', 'type' => 'varchar', 'default' => ''),
    array('name' => 'punjabi_white_red_size', 'type' => 'varchar', 'default' => ''),
    
     array('name' => 'punjabi_white_red_amount', 'type' => 'varchar', 'default' => ''),
    array('name' => 'punjabi_beige_red_amount', 'type' => 'varchar', 'default' => ''),
    array('name' => 'sarre_terracotta_amount', 'type' => 'varchar', 'default' => ''),
    array('name' => 'sarre_tussar_amount', 'type' => 'varchar', 'default' => ''),

    array('name' => 'saree_name', 'type' => 'varchar', 'default' => ''),
    array('name' => 'total_saree_price', 'type' => 'varchar', 'default' => ''),
    array('name' => 'saree_terracotta_qty', 'type' => 'varchar', 'default' => ''),
    array('name' => 'saree_tussar_qty', 'type' => 'varchar', 'default' => ''),
    array('name' => 'amount', 'type' => 'varchar', 'default' => ''),
    array('name' => 'PaymentOption', 'type' => 'varchar', 'default' => ''),
    array('name' => 'confirm_code', 'type' => 'varchar', 'default' => ''),
    array('name' => 'oid', 'type' => 'int', 'default' => ''),
    array('name' => 'admin_id', 'type' => 'int', 'default' => ':NULL'),
    array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
    array('name' => 'checkbankname', 'type' => 'varchar', 'default' => ''),
    array('name' => 'checkno', 'type' => 'varchar', 'default' => ''),
    array('name' => 'checkAmount', 'type' => 'varchar', 'default' => ''),
    array('name' => 'CheckDate', 'type' => 'varchar', 'default' => ''),
    array('name' => 'receiveby', 'type' => 'varchar', 'default' => ''),
    array('name' => 'cashAmount', 'type' => 'varchar', 'default' => ''),
    array('name' => 'cashDate', 'type' => 'varchar', 'default' => ''),
    array('name' => 'BankName', 'type' => 'varchar', 'default' => ''),
    array('name' => 'ISFCCode', 'type' => 'varchar', 'default' => ''),
    array('name' => 'directamount', 'type' => 'varchar', 'default' => ''),
    array('name' => 'transactiondate', 'type' => 'varchar', 'default' => ''),
    array('name' => 'sumupid', 'type' => 'varchar', 'default' => ''),
    array('name' => 'sumupamount', 'type' => 'varchar', 'default' => ''),
    array('name' => 'sumupdate', 'type' => 'varchar', 'default' => ''),
    array('name' => 'paydesc', 'type' => 'varchar', 'default' => ''),
   
    
    array('name' => 'stripeToken', 'type' => 'varchar', 'default' => ''),
    array('name' => 'pay_date', 'type' => 'varchar', 'default' => ''),
    array('name' => 'pay_type', 'type' => 'varchar', 'default' => ''),
    array('name' => 'pay_for', 'type' => 'varchar', 'default' => ''),
    array('name' => 'DepositAccount', 'type' => 'varchar', 'default' => ''),
   
    array('name' => 'status', 'type' => 'varchar', 'default' => ''),
    array('name' => 'created_at', 'type' => 'timestamp', 'default' => 'CURRENT_TIMESTAMP')

    );

    public function getdata()
    {

        $sql = 'SELECT * FROM '.$this->getTable().'  ORDER BY id DESC';
        $arr = $this->execute($sql);
        return $arr;
    }

}

?>