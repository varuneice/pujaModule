<?php

require_once MODELS_PATH . 'App.model.php';

class pujaregistrationpriceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'registrationpujaprice';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'pujaname', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'pricefor', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'pricetype', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'latefee', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'seniordiscount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'parentregisration', 'type' => 'varchar', 'default' => ':NULL')

    ); 
    

    public function getAllregistrationprice($opts)
    {

       $res = 'SELECT * FROM '.$this->getTable().' ORDER BY pujaname';
        $result = array();
        $arr = $this->execute($res);
        return $arr; 
    } 

    public function ensureCurrentRegistrationRates()
    {
        $rates = array(
            array('All 3 Pujas', 'member', 'individual', 250, 50, 25, 125),
            array('All 3 Pujas', 'member', 'family', 500, 100, 50, 125),
            array('All 3 Pujas', 'memberoot', 'individual', 250, 50, 25, 125),
            array('All 3 Pujas', 'memberoot', 'family', 500, 100, 50, 125),
            array('All 3 Pujas', 'nonmember', 'individual', 325, 50, 25, 125),
            array('All 3 Pujas', 'nonmember', 'family', 650, 100, 50, 125),
            array('All 3 Pujas', 'nonmemberoot', 'individual', 325, 50, 25, 125),
            array('All 3 Pujas', 'nonmemberoot', 'family', 650, 100, 50, 125),
            array('All 3 Pujas', 'student', 'individual', 125, 0, 25, 125),
            array('All 3 Pujas', 'student', 'family', 250, 0, 50, 125),

            array('Durga Puja', 'member', 'individual', 220, 45, 25, 110),
            array('Durga Puja', 'member', 'family', 440, 90, 45, 110),
            array('Durga Puja', 'memberoot', 'individual', 220, 45, 25, 110),
            array('Durga Puja', 'memberoot', 'family', 440, 90, 45, 110),
            array('Durga Puja', 'nonmember', 'individual', 285, 45, 25, 110),
            array('Durga Puja', 'nonmember', 'family', 570, 90, 45, 110),
            array('Durga Puja', 'nonmemberoot', 'individual', 285, 45, 25, 110),
            array('Durga Puja', 'nonmemberoot', 'family', 570, 90, 45, 110),
            array('Durga Puja', 'student', 'individual', 110, 0, 25, 110),
            array('Durga Puja', 'student', 'family', 220, 0, 45, 110),

            array('Kali Puja', 'member', 'individual', 75, 0, 10, 40),
            array('Kali Puja', 'member', 'family', 150, 0, 15, 40),
            array('Kali Puja', 'memberoot', 'individual', 75, 0, 10, 40),
            array('Kali Puja', 'memberoot', 'family', 150, 0, 15, 40),
            array('Kali Puja', 'nonmember', 'individual', 100, 0, 10, 40),
            array('Kali Puja', 'nonmember', 'family', 200, 0, 15, 40),
            array('Kali Puja', 'nonmemberoot', 'individual', 100, 0, 10, 40),
            array('Kali Puja', 'nonmemberoot', 'family', 200, 0, 15, 40),
            array('Kali Puja', 'student', 'individual', 40, 0, 10, 40),
            array('Kali Puja', 'student', 'family', 80, 0, 15, 40),

            array('Saraswati Puja', 'member', 'individual', 50, 0, 5, 25),
            array('Saraswati Puja', 'member', 'family', 100, 0, 10, 25),
            array('Saraswati Puja', 'memberoot', 'individual', 50, 0, 5, 25),
            array('Saraswati Puja', 'memberoot', 'family', 100, 0, 10, 25),
            array('Saraswati Puja', 'nonmember', 'individual', 65, 0, 5, 25),
            array('Saraswati Puja', 'nonmember', 'family', 130, 0, 10, 25),
            array('Saraswati Puja', 'nonmemberoot', 'individual', 65, 0, 5, 25),
            array('Saraswati Puja', 'nonmemberoot', 'family', 130, 0, 10, 25),
            array('Saraswati Puja', 'student', 'individual', 25, 0, 5, 25),
            array('Saraswati Puja', 'student', 'family', 50, 0, 10, 25),
        );

        foreach ($rates as $rate) {
            $this->updateCurrentRegistrationRate($rate[0], $rate[1], $rate[2], $rate[3], $rate[4], $rate[5], $rate[6]);
        }
    }

    private function updateCurrentRegistrationRate($pujaname, $pricefor, $pricetype, $price, $latefee, $seniordiscount, $parentregisration)
    {
        $sql = 'UPDATE ' . $this->getTable() . '
            SET price = "' . (int) $price . '",
                latefee = "' . (int) $latefee . '",
                seniordiscount = "' . (int) $seniordiscount . '",
                parentregisration = "' . (int) $parentregisration . '"
            WHERE pujaname = "' . addslashes($pujaname) . '"
            AND pricefor = "' . addslashes($pricefor) . '"
            AND pricetype = "' . addslashes($pricetype) . '"';
        return $this->execute($sql);
    }

    public function getRegistrationPriceRow($pujaname, $pricefor, $pricetype)
    {
        $res = 'SELECT * FROM ' . $this->getTable() . '
            WHERE pujaname = "' . addslashes($pujaname) . '"
            AND pricefor = "' . addslashes($pricefor) . '"
            AND pricetype = "' . addslashes($pricetype) . '"
            LIMIT 1';
        $arr = $this->execute($res);
        return !empty($arr[0]) ? $arr[0] : array();
    }



    public function getpujapricedata()
  {
      $pujaname = $_POST['pyjaname'] ?? '';
      $pricefor = $_POST['paymentfor'] ?? '';
    $res = 'SELECT * FROM '.$this->getTable().' WHERE pujaname = "'."$pujaname".'" AND pricefor ="'."$pricefor".'"ORDER BY pujaname';
    $arr = $this->execute($res);
    foreach ($arr as $key => $value) {
        $result[$value['pricefor']] = $value['pricetype'];
     
    }
    return $arr;
  }


  public function getparentprice()
   { 
      $pujaname = $_POST['pyjaname'] ?? '';
      $pricefor = $_POST['paymentfor'] ?? '';
      $pricetype = $_POST['pricetype'] ?? '';
      $row = $this->getRegistrationPriceRow($pujaname, $pricefor, $pricetype);
      $parentreg = $row['parentregisration'] ?? '';
       if(!empty($row['id'])){
         echo "<input  id='parentprice' value='$parentreg'/> ";
        }
    }

    public function getseniorpricedata()
    { 
       $pujaname = $_POST['pyjaname'] ?? '';
       $pricefor = $_POST['paymentfor'] ?? '';
       $pricetype = $_POST['pricetype'] ?? '';
       $res = 'SELECT * FROM '.$this->getTable().' WHERE pujaname = "'."$pujaname".'" AND pricefor ="'."$pricefor".'" AND pricetype ="'."$pricetype".'"';
       $arr = $this->execute($res);
       $seniordiscount = $arr[0]['seniordiscount'];
        if(!empty($arr[0]['id'])){
          echo "<input  id='seniorprice' value='$seniordiscount'/> ";
         }
     }
 


}

?>
