<?php

require_once MODELS_PATH . 'App.model.php';

class DonationModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'donation';
    
    var $schema = array(
       array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'varchar', 'default' => ''),
         array('name' => 'bank', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkno', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkdate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'MemberName', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Amount', 'type' => 'float', 'default' => ''),
        array('name' => 'PaymentOption', 'type' => 'varchar', 'default' => ''),
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
        array('name' => 'DepositAccount', 'type' => 'varchar', 'default' => '')
       
    );
    function getMaxid(){
        $sql = 'SELECT MAX(id)
 AS id FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['id'])){
            return $res[0]['id'];
        }else{
            return 0;
        }
    }
    
   public function DonationAll($opts)
    {
        //  $sql = 'SELECT * FROM '.$this->getTable().' WHERE pay_type ="'."DONATION".'" AND pay_for like "%DONATION%" ORDER BY id DESC';
         $sql = 'SELECT * FROM '.$this->getTable().' WHERE paymentfor ="'."Puja Donation".'"  ORDER BY id DESC';
        // $sql = 'SELECT * FROM '.$this->getTable().' WHERE pay_for ="'."DONATION / Unrestricted".'" ORDER BY id DESC';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    
     public function getDonationdata($transaction)
    {
       // $Memberid=$_POST['memberid'] ?? '';
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE transaction_id="'."$transaction".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr[0];
        
    }
    public function donationgiftmisc($opts)
    {
  
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE pay_type IN("gift", "misc")';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }

    public function SaveDataInDonation($value)
    {
            $donid = $this->getMaxid();
            $id =  $donid +1;
            $type = $value['type'] ?? '';
            $bank = $value['bank'] ?? '';
            $chkno = $value['chkno'] ?? '';
            $chkdate_raw = $value['chkdate'] ?? '';
            $chkdate_sql = (!empty($chkdate_raw) && $chkdate_raw !== '0000-00-00') ? "'$chkdate_raw'" : 'NULL';
            $MemberName = $value['MemberName'] ?? '';
            $PaymentOption = $value['PaymentOption'] ?? '';
            $payment_status = $value['payment_status'] ?? '';
            $payment_timestamp = $value['payment_timestamp'] ?? '';
            $stripe_return = $value['stripe_return'] ?? '';
            $transaction_id = $value['transaction_id'] ?? '';
            $paid_amount = $value['paid_amount'] ?? '';
            $stripe_product = $value['stripe_product'] ?? '';
            $update_on_raw = $value['update_on'] ?? '';
            $update_on_sql = !empty($update_on_raw) ? "'$update_on_raw'" : 'NOW()';
            $pay_date_raw = $value['pay_date'] ?? '';
            $pay_date_sql = (!empty($pay_date_raw) && $pay_date_raw !== '0000-00-00') ? "'$pay_date_raw'" : 'NULL';
            $cc_name = $value['MemberName'] ?? '';
            $remarks = $value['remarks'] ?? '';
            $pay_type = $value['pay_type'] ?? '';
            $pay_for = $value['pay_for'] ?? '';
            $Address = $value['Address'] ?? '';
            $street = $value['Street'] ?? '';
            $state = $value['State'] ?? '';
            $zip = $value['Zip_Code'] ?? '';
            $tele = $value['Tele1'] ?? '';
            $alternatenumber = $value['alternatenumber'] ?? '';
            $email = $value['email'] ?? '';
            $alternateemail = $value['alternateemail'] ?? '';
            $city = $value['City'] ?? '';
            $spousename = $value['spousename'] ?? '';
            $purpose = $value['purpose'] ?? '';
            $ReceiveBy = $value['ReceiveBy'] ?? '';
            $paymentfor = $value['paymentfor'] ?? '';
            $admin_name = $value['admin_name'] ?? '';
            $membercategory = $value['membercategory'] ?? '';
            $DepositAccount = $value['DepositAccount'] ?? '';
            // Integer/float columns — use NULL instead of '' to satisfy MySQL STRICT_TRANS_TABLES
            $Member_id_sql = is_numeric($value['Member_id'] ?? '') ? (int)$value['Member_id']   : 'NULL';
            $oid_sql       = is_numeric($value['oid']       ?? '') ? (int)$value['oid']         : 'NULL';
            $eventid_sql   = is_numeric($value['eventid']   ?? '') ? (float)$value['eventid']   : 'NULL';
            $admin_id_sql  = is_numeric($value['admin_id']  ?? '') ? (int)$value['admin_id']    : 'NULL';
            $Amount_sql    = is_numeric($value['Amount']    ?? '') ? (float)$value['Amount']    : 'NULL';

            $sql = "INSERT INTO ".$this->getTable()." VALUES ('$id','$type','$bank','$chkno',$chkdate_sql,'$MemberName',$Amount_sql,'$PaymentOption','$payment_status','$payment_timestamp','$stripe_return','$transaction_id','$paid_amount','$stripe_product',$update_on_sql,$Member_id_sql,$pay_date_sql,'$cc_name','$remarks',$oid_sql,'$pay_type','$pay_for','$Address','$street','$state','$zip','$tele','$alternatenumber','$email','$alternateemail','$city',$eventid_sql,'$spousename','$purpose','$ReceiveBy','$paymentfor',$admin_id_sql,'$admin_name','$membercategory','$DepositAccount')";
            $result = array();
             $arr = $this->execute($sql);
             return $arr;
        
    }
    
    // function for  update event and select free sankalpapuja
    public function Updatedonationparking($value)
    {
        $id=$value['donationid']; 
        $pujasankalpa = $value['pujasankalpa'];
        $eventfirst = $value['categone'];
        $eventsecond = $value['categtwo'];
      
        $sql = 'UPDATE '.$this->getTable().' SET Freesankalpapuja="'."$pujasankalpa".'",eventsponsorship1="'."$eventfirst".'",eventsponsorship2="'."$eventsecond".'" WHERE id="'."$id".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
    }
    
    public function ExportDonationRecord($opts)
    {
        $current_year = date("Y");
        $Nextyear = date('Y')+1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "07-01") {
            $current_year = $current_year - 1;
            $Nextyear = $current_year + 1;
        }
        $res = 'SELECT * FROM donationForPuja
        WHERE pay_date >= "' . $current_year . '-07-01"
        AND pay_date <= "' . $Nextyear . '-06-30"
        AND paymentfor = "Puja Donation"
        ORDER BY id DESC';

        // $res = 'SELECT * FROM '.$this->getTable().' WHERE paymentfor ="'."Puja Donation".'"  ORDER BY id DESC';
        $result = array();
        $arr = $this->execute($res);
        return $arr; 
    } 
    
    
    public function editPaymentStatus($pujaOid , $paymentStatus , $Isfrom)
    {
        
        // $sql = 'UPDATE ' . $this->getTable() . ' SET payment_status="' . $paymentStatus . '" WHERE oid="' . $pujaOid['oid'] . '"';
        // $sql = 'UPDATE ' . $this->getTable() . ' 
        // SET payment_status="' . $paymentStatus . '", 
        //     remarks="Transaction cancelled from ' . $Isfrom . '" 
        // WHERE oid="' . $pujaOid['oid'] . '"';
        
        $sql = 'UPDATE ' . $this->getTable() . ' 
        SET payment_status="' . $paymentStatus . '" 
        WHERE oid="' . $pujaOid['oid'] . '" 
        AND UPPER(pay_type) != "DONATION"';
        $arr = $this->execute($sql);
        return $arr; 


    }

}

?>
