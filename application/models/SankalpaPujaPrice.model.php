<?php

require_once MODELS_PATH . 'App.model.php';

class SankalpaPujaPriceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'sankalpapujaprice';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Pujaname', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'online_discount', 'type' => 'float', 'default' => ':NULL') ,
        
         array('name' => 'pujaStatus', 'type' => 'varchar', 'default' => ':NULL') ,
        array('name' => 'admin_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'update_on', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
    ); 
    
    public function getAllprice($opts)
    {

       $res = 'SELECT * FROM '.$this->getTable().' ORDER BY Pujaname';
        $result = array();
        $arr = $this->execute($res);
        return $arr; 
    } 

  // Avinash get puja price & name for payment page 

  // public function pujaprice($membertype)
  // {
  //   $res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "'."$membertype".'" ORDER BY Pujaname';
  //   $result = array();
  //   $arr = $this->execute($res);
  //   return $arr; 
  // }

  public function getonlinepricedata()
  {
    $pujaname = $_POST['pyjaname'] ?? '';
    $membertype = $_POST['paymentfor'] ?? '';
    $res = 'SELECT * FROM '.$this->getTable().' WHERE Pujaname = "'."$pujaname".'" AND  Type = "'."$membertype".'"';
    $result = array();
    $arr = $this->execute($res);
    $onlineprice = $arr[0]['online_discount'];
        if(!empty($arr[0]['id'])){
          echo "<input  id='onlinediscount' value='$onlineprice'/> ";
         }
  }

  public function pujaprice()
  {
   // $res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "'."member".'" AND Pujaname !="'."Haate Khori".'" AND Pujaname NOT LIKE "'."%Tithi%".'" ORDER BY Pujaname';
    // $res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "'."member".'" AND Pujaname !="'."Haate Khori".'" AND Pujaname NOT LIKE "'."%Tithi%".'" OR Pujaname LIKE "%Tithi Kali Puja%" AND Type != "'."nonmember".'" AND Type != "'."nonmemberoot".'" ORDER BY Pujaname';
    // $res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "member" AND Pujaname !="Haate Khori" AND Type != "nonmember" AND Type != "nonmemberoot" ORDER BY Pujaname';
    $res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "'."member".'" AND pujaStatus ="'."y".'" AND Type != "'."nonmember".'" AND Type != "'."nonmemberoot".'" ';
    $result = array();
    $arr = $this->execute($res);
    return $arr; 
  }
 


  public function nonmember()
  {
    //$res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "'."nonmember".'" AND Pujaname !="'."Haate Khori".'" AND Pujaname NOT LIKE "'."%Tithi%".'" ORDER BY Pujaname';
    // $res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "'."nonmember".'" AND Pujaname !="'."Haate Khori".'" AND Pujaname NOT LIKE "'."%Tithi%".'"  OR Pujaname LIKE "%Tithi Kali Puja%" AND Type != "'."member".'" AND Type != "'."nonmemberoot".'" ORDER BY Pujaname';
    // $res = 'SELECT * FROM ' . $this->getTable() . ' 
    //     WHERE Type = "nonmember" 
    //     AND Pujaname != "Haate Khori" 
    //     AND Pujaname != "Tithi Kali Puja"
    //     AND Type != "member" 
    //     AND Type != "nonmemberoot" 
    //     ORDER BY Pujaname';
    
    $res = 'SELECT * FROM ' . $this->getTable() . ' 
        WHERE Type = "nonmember" 
        AND Pujaname != "Haate Khori" 
        AND pujaStatus ="'."y".'"
        AND Type != "member" 
        AND Type != "nonmemberoot" 
       ';
    $result = array();
    $nonmemberarr = $this->execute($res);
    return $nonmemberarr; 
  }

 

  public function outoftowner()
  {
     //$res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "'."nonmemberoot".'" AND Pujaname !="'."Haate Khori".'" AND Pujaname NOT LIKE "'."%Tithi%".'" ORDER BY Pujaname';
    // $res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "'."nonmemberoot".'" AND Pujaname !="'."Haate Khori".'" AND Pujaname NOT LIKE "'."%Tithi%".'" OR Pujaname LIKE "%Tithi Kali Puja%" AND Type != "'."member".'" AND Type != "'."nonmember".'" ORDER BY Pujaname';
    // $res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "nonmemberoot" AND Pujaname != "Haate Khori" AND Type != "member" AND Type != "nonmember" ORDER BY Pujaname';
     $res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "nonmemberoot" AND Pujaname != "Haate Khori" AND Type != "member" AND pujaStatus ="'."y".'" AND Type != "nonmember" ';
    $result = array();
    $ootarr = $this->execute($res);
    return $ootarr; 
  }
  
 public function hathekhoripujaprice($membertype)
  {
    $res = 'SELECT * FROM '.$this->getTable().' WHERE Type = "'."$membertype".'" AND Pujaname ="'."Haate Khori".'"ORDER BY Pujaname';
    $result = array();
    $arr = $this->execute($res);
    foreach ($arr as $key => $value) {
      $result[$value['pricefor']] = $value['pricetype'];
   
  }
    return $arr; 
  }


}

?>