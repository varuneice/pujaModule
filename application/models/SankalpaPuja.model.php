<?php

require_once MODELS_PATH . 'App.model.php';

class SankalpaPujaModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'pujasank';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
        array('name' => 'Member_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'category', 'type' => 'varchar', 'default' => ''),
        array('name' => 'name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'tele', 'type' => 'varchar', 'default' => ''),
        array('name' => 'alternatenumber', 'type' => 'varchar', 'default' => ''),
        array('name' => 'email', 'type' => 'varchar', 'default' => ''),
        array('name' => 'alternateemail', 'type' => 'varchar', 'default' => ''),
        array('name' => 'modeparticipation', 'type' => 'varchar', 'default' => ''),
        array('name' => 'NoofchildHaateKhori', 'type' => 'varchar', 'default' => ''),
        array('name' => 'child1name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'child2name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'child1age', 'type' => 'varchar', 'default' => ''),
        array('name' => 'child2age', 'type' => 'varchar', 'default' => ''),
        array('name' => 'fathername', 'type' => 'varchar', 'default' => ''),
        array('name' => 'mothername', 'type' => 'varchar', 'default' => ''),
        array('name' => 'offeringPujaSankalpa', 'type' => 'varchar', 'default' => ''),
        array('name' => 'personofferingpujasankalpa', 'type' => 'varchar', 'default' => ''),
        array('name' => 'selectedpuja', 'type' => 'varchar', 'default' => ''),
        array('name' => 'item_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'item_cost', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Status', 'type' => 'varchar', 'default' => ''),
        array('name' => 'remarks', 'type' => 'varchar', 'default' => '') ,
        array('name' => 'pay_date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'regmember', 'type' => 'varchar', 'default' => ''),
        array('name' => 'outoftowner', 'type' => 'varchar', 'default' => ''),
        array('name' => 'street', 'type' => 'varchar', 'default' => ''),
        array('name' => 'streetname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'unit', 'type' => 'varchar', 'default' => ''),
        array('name' => 'city', 'type' => 'varchar', 'default' => ''),
        array('name' => 'state', 'type' => 'varchar', 'default' => ''),
        array('name' => 'zip', 'type' => 'varchar', 'default' => ''),
        array('name' => 'avatar', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pranamifee', 'type' => 'varchar', 'default' => ''),
        array('name' => 'gotra', 'type' => 'varchar', 'default' => ''),    
        array('name' => 'PaymentOption', 'type' => 'varchar', 'default' => ''),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ''),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ''),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ''),
        array('name' => 'oid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ''),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_for', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'pay_type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'bank', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkno', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkdate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'receiveby', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => '')
 
    ); 

    public function ensureChildAgeColumns()
    {
        $columns = array(
            'child1age' => 'VARCHAR(50) DEFAULT NULL',
            'child2age' => 'VARCHAR(50) DEFAULT NULL'
        );

        foreach ($columns as $column => $definition) {
            $safeColumn = addslashes($column);
            $existing = $this->execute("SHOW COLUMNS FROM `" . $this->getTable() . "` LIKE '" . $safeColumn . "'");
            if (empty($existing)) {
                try {
                    $this->execute("ALTER TABLE `" . $this->getTable() . "` ADD `" . $safeColumn . "` " . $definition);
                } catch (Throwable $e) {
                    error_log('PUJA SANKALPA COLUMN ENSURE SKIPPED | column=' . $safeColumn . ' | ' . $e->getMessage());
                }
            }
        }
    }

    public function syncSchemaWithTableColumns()
    {
        $columns = $this->execute("SHOW COLUMNS FROM `" . $this->getTable() . "`");
        if (empty($columns)) {
            return false;
        }

        $existingColumns = array();
        foreach ($columns as $column) {
            if (!empty($column['Field'])) {
                $existingColumns[$column['Field']] = true;
            }
        }

        $this->schema = array_values(array_filter($this->schema, function ($field) use ($existingColumns) {
            $name = trim($field['name'] ?? '');
            return $name !== '' && !empty($existingColumns[$name]);
        }));

        return true;
    }
    
     public function getAlldata($opts)
    {

        $current_year = date("Y");
        $Nextyear = date('Y')+1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "07-01") {
            $current_year = $current_year - 1;
            $Nextyear = $current_year + 1;
        }
        $seasonStart = "$current_year-07-01";
        $seasonEnd = "$Nextyear-06-30";
        $res = 'SELECT ps.*,
            (SELECT pr.sponsorLevel FROM pujaregistration pr WHERE pr.Member_id = ps.Member_id AND pr.pay_date >= "' . $seasonStart . '" AND pr.pay_date <= "' . $seasonEnd . '" ORDER BY pr.id DESC LIMIT 1) AS sponsorLevel,
            (SELECT pr.greenFieldParkingDecision FROM pujaregistration pr WHERE pr.Member_id = ps.Member_id AND pr.pay_date >= "' . $seasonStart . '" AND pr.pay_date <= "' . $seasonEnd . '" ORDER BY pr.id DESC LIMIT 1) AS greenFieldParkingDecision
            FROM '.$this->getTable().' ps WHERE ps.pay_date >= "' . $seasonStart . '" AND ps.pay_date <= "' . $seasonEnd . '"  ORDER BY ps.id DESC';
        $result = array();
        $arr = $this->execute($res);
        return $arr; 
    }  
    
    
    public function getAllPujaSankalRecord($opts)
    {
        $current_year = date("Y");
        $Nextyear = date('Y')+1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "04-01") {
            $current_year = $current_year - 1; 
            $Nextyear = date("Y");
        }
        $res = 'SELECT * FROM '.$this->getTable().' WHERE pay_date >= "'."$current_year-04-01".'" AND pay_date < "'."$Nextyear-03-31".'"  ORDER BY id DESC';
        $result = array();
        $arr = $this->execute($res);
        return $arr; 
    }

   public function documentdata($id) {

        $sql = 'SELECT * FROM '.$this->getTable().' WHERE id="'."$id".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr[0];
    }
    
    // public function checkSankalpPuja($Memberid)
    // {
    //     $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE Member_id = "' . "$Memberid" . '" AND selectedpuja = "' . "sankalpapuja" . '" AND DATE_FORMAT(pay_date, "%Y") = DATE_FORMAT(CURDATE(), "%Y")';

    //     $result = array();
    //     $arr = $this->execute($sql);
       
    //     if (!empty($arr[0]['id'])) {
    //         $pujatype = $arr[0]['item_name'];
    //         $membername = $arr[0]['name'];

    //         echo "<input  id='memberdata' value='true'/> ";
    //         echo "<input  id='selectedPuja' value='$pujatype'/> ";
    //         echo "<input  id='membername' value='$membername'/> ";
           
    //     } else {
    //         echo "<input  id='memberdata' value='false'/> ";
    //     }


        
    // }
    
    
     public function checkSankalpPuja($Memberid)
    {
        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE Member_id = "' . "$Memberid" . '" AND selectedpuja = "' . "sankalpapuja" . '" AND DATE_FORMAT(pay_date, "%Y") = DATE_FORMAT(CURDATE(), "%Y")';

        $result = array();
        $arr = $this->execute($sql);

        $checkRegistration = $this->checkRegistrationPuja($Memberid);

        if ($checkRegistration) {

            if (!empty($arr[0]['id'])) {
                $pujatype = $arr[0]['item_name'];
                $membername = $arr[0]['name'];

                echo "<input  id='memberdata' value='true'/> ";
                echo "<input  id='selectedPuja' value='$pujatype'/> ";
                echo "<input  id='membername' value='$membername'/> ";

            } else {
                echo "<input  id='memberdata' value='false'/> ";
            }

        } else {
            echo "<input  id='memberdata' value='false'/> ";
            echo "<input  id='memberRegister' value='You have not done puja registration '/> ";

        }
    }

    public function checkRegistrationPuja($Memberid)
    {
        // $sql = 'SELECT * FROM  pujaregistration  WHERE Member_id = "' . "$Memberid" . '" AND puja_type != "' . "Saraswati Puja" . '" AND DATE_FORMAT(pay_date, "%Y") = DATE_FORMAT(CURDATE(), "%Y")';
        $sql = 'SELECT * FROM pujaregistration WHERE Member_id = "' . $Memberid . '" AND DATE_FORMAT(pay_date, "%Y") = DATE_FORMAT(CURDATE(), "%Y")';

        $result = array();
        $arr = $this->execute($sql);
        if (!empty($arr[0]['id'])) {
            return true;
        } else {
            return false;
        }
    }

    
     public function getOID($id)
    {
        $sql = 'SELECT oid FROM '.$this->getTable().' WHERE id="' . $id . '"';
        $arr = $this->execute($sql);
        return $arr[0];


    }
}

?>
