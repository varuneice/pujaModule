<?php

require_once MODELS_PATH . 'App.model.php';

class pujaregistrationModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'pujaregistration';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'registration_for', 'type' => 'varchar', 'default' => ''),
        array('name' => 'puja_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'puja_category', 'type' => 'varchar', 'default' => ''),
        array('name' => 'member_status', 'type' => 'varchar', 'default' => ''),
        array('name' => 'regmember', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
        array('name' => 'membercategory', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Member_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'First_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Last_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'member_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'Sp_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Sp_lname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'spouse_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'swap_spouse', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'member_optional_child', 'type' => 'varchar', 'default' => ''),
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
        array('name' => 'student_or_oot', 'type' => 'varchar', 'default' => ''),
        array('name' => 'city', 'type' => 'varchar', 'default' => ''),
        array('name' => 'state', 'type' => 'varchar', 'default' => ''),
        array('name' => 'zip', 'type' => 'varchar', 'default' => ''),
        array('name' => 'phone', 'type' => 'varchar', 'default' => ''),
        array('name' => 'alternatenumber', 'type' => 'varchar', 'default' => ''),
        array('name' => 'email', 'type' => 'varchar', 'default' => ''),
        array('name' => 'alternateemail', 'type' => 'varchar', 'default' => ''),
        array('name' => 'senior', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'senior_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'no_of_parent', 'type' => 'varchar', 'default' => ''),
        array('name' => 'parent1_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'parent1_lname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'parent1_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'parent2_fname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'parent2_lname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'parent2_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'magazine', 'type' => 'varchar', 'default' => ''),
        array('name' => 'donation', 'type' => 'float', 'default' => ''),
        array('name' => 'schoolname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'studentavatar', 'type' => 'varchar', 'default' => ''),
        array('name' => 'addressavatar', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Adultveggie', 'type' => 'varchar', 'default' => ''),
        array('name' => 'status', 'type' => 'varchar', 'default' => ''),
        array('name' => 'amount', 'type' => 'float', 'default' => ''),
        array('name' => 'discountseniorprice', 'type' => 'varchar', 'default' => ''),
        array('name' => 'magazineprice', 'type' => 'varchar', 'default' => ''),
        array('name' => 'extraparentregistration', 'type' => 'varchar', 'default' => ''),
        array('name' => 'totalamount', 'type' => 'float', 'default' => ''),
        array('name' => 'PaymentOption', 'type' => 'varchar', 'default' => ''),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ''),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ''),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ''),
        array('name' => 'oid', 'type' => 'int', 'default' => ''),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ''),
        //  add new field for cash check
        array('name' => 'bank', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkno', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkdate', 'type' => 'Date', 'default' => ''),
        array('name' => 'receiveby', 'type' => 'varchar', 'default' => ''),
       // end
        array('name' => 'newytd', 'type' => 'varchar', 'default' => ''),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_date', 'type' => 'Date', 'default' => ''),
        array('name' => 'pay_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_for', 'type' => 'varchar', 'default' => ''),
        array('name' => 'update_on', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'remarks', 'type' => 'varchar', 'default' => ''), 
        array('name' => 'admin_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'DepositAccount', 'type' => 'varchar', 'default' => ''),
        array('name' => 'CreatedAt', 'type' => 'Date', 'default' => '')
        
    ); 
    
     public function getAllpujaregistrationdata($opts)
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
    
    
    public function checkemberregister($Memberid)
  {
    //$sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id = "'."$Memberid".'" AND puja_type != "'."Saraswati Puja".'" AND year(pay_date) = year(CURDATE())';
    $sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id = "'."$Memberid".'" AND puja_type != "'."Saraswati Puja".'" AND DATE_FORMAT(pay_date, "%Y") = DATE_FORMAT(CURDATE(), "%Y")'; 
    $result = array();
    $arr = $this->execute($sql);
    $seniorcheck = $arr[0]['senior'];
    $pujatype = $arr[0]['puja_type'];
    
    $memberid = $arr[0]['Member_id'];
    $membercategory = $arr[0]['membercategory'];
    $membershiptype = $arr[0]['Member_type'];
    $MemberName = $arr[0]['First_name'];
    $last_name = $arr[0]['Last_name'];
    $Spouse = $arr[0]['Sp_fname'];
    $Spouselast = $arr[0]['Sp_lname'];
    $ressidentalAddress = $arr[0]['street'];
    $Address = $arr[0]['streetname'];
    $unitAddress = $arr[0]['unit'];
    $city = $arr[0]['city'];
    $state = $arr[0]['state'];
    $zip_code = $arr[0]['zip'];
    $Tele1 = $arr[0]['phone'];
    $phone_work = $arr[0]['alternatenumber'];
    $email = $arr[0]['email'];
    $email2 = $arr[0]['alternateemail'];
    if(!empty($arr[0]['id'])){

        echo "<input  id='memberdata' value='true'/> ";
        echo "<input  id='membersenior' value='$seniorcheck'/> ";
        echo "<input  id='pujaname' value='$pujatype'/> ";
        
        echo "<input  id='memberid' value='$memberid'/> ";
        echo "<input  id='membercategory' value='$membercategory'/> ";
        echo "<input  id='membershiptype' value='$membershiptype'/> ";
        echo "<input  id='MemberName' value='$MemberName'/> ";
        echo "<input  id='last_name' value='$last_name'/> ";
        echo "<input  id='Spouse' value='$Spouse'/> ";
        echo "<input  id='Spouselast' value='$Spouselast'/> ";
        echo "<input  id='ressidentalAddress' value='$ressidentalAddress'/> ";
        echo "<input  id='Address' value='$Address'/> ";
        echo "<input  id='unitAddress' value='$unitAddress'/> ";
        echo "<input  id='city' value='$city'/> ";
        echo "<input  id='state' value='$state'/> ";
        echo "<input  id='zip_code' value='$zip_code'/> ";
        echo "<input  id='Tele1' value='$Tele1'/> ";
        echo "<input  id='phone_work' value='$phone_work'/> ";
        echo "<input  id='email' value='$email'/> ";
        echo "<input  id='email2' value='$email2'/> ";
        
    }else{
        echo "<input  id='memberdata' value='false'/> ";
    }  
  }


  public function getdocumentdata($id) {

    $sql = 'SELECT * FROM '.$this->getTable().' WHERE id="'."$id".'"';
    $result = array();
    $arr = $this->execute($sql);
    return $arr[0];
}
//Method for get member puja registration status 
 function GetPujaRegistrationStatus(){
    $memberId = $_POST['memberId'] ?? '';
    $current_year = date("Y");
    $Nextyear = date('Y')+1;
    date_default_timezone_set("America/Chicago");
    if (date("m-d") < "04-01") {
        $current_year = $current_year - 1; 
        $Nextyear = date("Y");
    }
    $sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id = "'."$memberId".'"AND pay_date >= "'."$current_year-04-01".'" AND pay_date < "'."$Nextyear-03-31".'" ';
    $arr = $this->execute($sql);
    return $arr;
 }
}

?>