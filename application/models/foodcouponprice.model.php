<?php

require_once MODELS_PATH . 'App.model.php';

class foodcouponpriceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'foodcouponprice';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'code', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'item', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'price', 'type' => 'varchar', 'default' => ':NULL')
	    
       
	 );
    

     public function getfoodcouponpriceedata($paymentfor)
     {
         $res = 'SELECT * FROM '.$this->getTable().' WHERE  code="'."$paymentfor".'"';
         $result = array();
         $arr = $this->execute($res);
         $price = $arr[0]['price'];
         echo  "<input  id='coupon' value='$price'/> ";
     }


   }            

?>