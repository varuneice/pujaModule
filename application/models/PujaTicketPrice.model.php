<?php

require_once MODELS_PATH . 'App.model.php';

class PujaTicketPriceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'pujaticketprice';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'pujaname', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'price', 'type' => 'varchar', 'default' => ':NULL')
    );


// get ticket price data
     public function getpriceticket()
    {
        $tickettype = $_POST['tickettype'] ?? '';
		$pujatype = $_POST['pujatype'] ?? '';

        $res = 'SELECT * FROM '.$this->getTable().' WHERE  pujaname="'."$pujatype".'" AND type="'."$tickettype".'"';
        $result = array();
        $arr = $this->execute($res);
        $price = $arr[0]['price'];
        echo  "<input  id='ticketprice' value='$price'/> ";
    }

    
}

?>