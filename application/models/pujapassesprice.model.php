<?php

require_once MODELS_PATH . 'App.model.php';

class pujapassespriceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'pujapassesprice';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'pujaname', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'pricefor', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'pricetype', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'parentprice', 'type' => 'varchar', 'default' => ':NULL')
    );


// get ticket price data
    public function getAllpujapassesprice($opts)
    {
       $res = 'SELECT * FROM '.$this->getTable().' ORDER BY id';
        $result = array();
        $arr = $this->execute($res);
        return $arr; 
    } 

    public function getpujapricedata()
    {
      $pujaname = $_POST['pyjaname'] ?? '';
      $pricefor = $_POST['paymentfor'] ?? '';
      $res = 'SELECT * FROM '.$this->getTable().' WHERE pujaname = "'."$pujaname".'" AND pricefor ="'."$pricefor".'" ORDER BY pujaname';
      $arr = $this->execute($res);
      foreach ($arr as $key => $value) {
        $result[$value['pricefor']] = $value['pricetype'];
     }
     return $arr;
    }

    public function getParentPriceRow($pujaname, $pricefor, $pricetype)
    {
      $pujaname = addslashes((string) $pujaname);
      $pricefor = addslashes((string) $pricefor);
      $pricetype = addslashes((string) $pricetype);
      $res = 'SELECT * FROM '.$this->getTable().' WHERE pujaname = "'.$pujaname.'" AND pricefor ="'.$pricefor.'" AND pricetype ="'.$pricetype.'" LIMIT 1';
      $arr = $this->execute($res);
      if (!empty($arr[0]) && (float) ($arr[0]['parentprice'] ?? 0) > 0) {
        return $arr[0];
      }

      $res = 'SELECT * FROM '.$this->getTable().' WHERE pujaname = "'.$pujaname.'" AND pricetype ="'.$pricetype.'" ORDER BY id LIMIT 1';
      $arr = $this->execute($res);
      return !empty($arr[0]) ? $arr[0] : array();
    }

    
}

?>
