<?php

require_once MODELS_PATH . 'App.model.php';

class DonationnewviewModel extends AppModel {

    var $primaryKey = 'id';
   // var $table = 'donationnewview';
    var $table = 'donationpujaviewwithytd';
    
    var $schema = array(
        array('name' => 'pay_date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
        array('name' => 'membercategory', 'type' => 'varchar', 'default' => ''),
        array('name' => 'oid', 'type' => 'int', 'default' => ''),
        array('name' => 'MemberName', 'type' => 'varchar', 'default' => ''),
        array('name' => 'spousename', 'type' => 'varchar', 'default' => ''),
        array('name' => 'city', 'type' => 'varchar', 'default' => ''),
        array('name' => 'state', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Amount', 'type' => 'float', 'default' => ''),
		array('name' => 'pay_type', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'pay_for', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'alternatenumber', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'ytd', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'purpose', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paymentfor', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'admin_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'membercategory', 'type' => 'varchar', 'default' => ''),
        array('name' => 'alternatenumber', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'City', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'State', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'spousename', 'type' => 'varchar', 'default' => ''),
        array('name' => 'YTD', 'type' => 'varchar', 'default' => '')
         
    );

   public function DonationAll($opts)
    {
        $current_year = date("Y");
        $Nextyear = date('Y')+1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "04-01") {
            $current_year = $current_year - 1; 
            $Nextyear = date("Y");
        }
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE pay_date >= "'."$current_year-04-01".'" AND pay_date < "'."$Nextyear-03-31".'" AND paymentfor ="'."Puja Donation".'" ORDER BY pay_date DESC';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    // public function SaveDataInDonation($value)
    // {
    //         $donid = $this->getMaxid();
    //         $id =  $donid +1;
    //         $Member_id = $value['Member_id'];
    //         $type = $value['type'];
    //         $gift =  $value['gift'];
    //         $Payment_For =$value['Payment_For'];
    //         $MemberName = $value['MemberName'];
    //         $Amount = $value['Amount'];
    //         $PaymentOption = $value['PaymentOption'];
    //         $payment_status = $value['payment_status'];
    //         $payment_timestamp = $value['payment_timestamp'];
    //         //$payment_timestamp = mktime($payment_times);
    //         $stripe_return = $value['stripe_return'];
    //         $transaction_id =  $value['transaction_id'];
    //         $paid_amount = $value['paid_amount'];
    //         $stripe_product = $value['stripe_product'];
    //         $update_on = $value['update_on']; 
    //         $pay_date = $value['pay_date'];
    //         $cc_name = $value['MemberName'];
    //         $remarks = $value['remarks'];
    //         $oid =  Util::incrementalHash(4);
    //         $pay_type = $value['pay_type'];
    //         $pay_for = $value['pay_for'];
    //         $Address = $value['Address'];
    //         $street = $value['Street'];
    //         $state = $value['State'];
    //         $zip =  $value['Zip_Code'];
    //         $tele = $value['Tele1'];
    //         $email =  $value['email'];
    //         $city = $value['City'];
    //         $spousename = $value['spousename'];
    //         $eventdonation = $value['eventdonation'];
    //         $purpose = $value['purpose'];
    //         $Address3 = $value['Address3'];
    //         $sql=  "INSERT INTO ".$this->getTable()." VALUES ('$id','$type','$gift','$Payment_For','$MemberName','$Amount','$PaymentOption','$payment_status','$payment_timestamp','$stripe_return','$transaction_id','$paid_amount','$stripe_product','$update_on','$Member_id','$pay_date','$cc_name','$remarks','$oid','$pay_type','$pay_for','$Address','$street','$state','$zip','$tele','$email','$city','$eventdonation','$spousename','$purpose','$Address3')";
    //         $result = array();
    //          $arr = $this->execute($sql);
    //          return $arr;
        
    // }
    public function MemberData($opts)
    {
        //$pay_type =trim($cmCode);
        //$pay_for =trim($cmCode);
        //$year =trim($cmCode);
        //SELECT Donationnewview.pay_for AS EventName,sum(Donationnewview.Amount) AS Revenue FROM Donationnewview WHERE pay_type ="OTHER"  AND year(Donationnewview.pay_date) < 2023 GROUP BY EventName
        //$sql = 'SELECT * FROM '.$this->getTable().' WHERE pay_type ="'."Donation".'"';ORDER BY  year(curdate())
        $sql = 'SELECT ANY_VALUE(donationnewview.id) as ID,donationnewview.pay_for AS MemberType,sum(donationnewview.Amount) AS Revenue FROM '.$this->getTable().' WHERE (donationnewview.pay_for ="'."DB / HDBS Annual General Membership (GM)".'") OR  (donationnewview.pay_for ="'."DB / HDBS Annual Maintenance".'") OR  (donationnewview.pay_for ="'."New Membership".'") AND  (donationnewview.pay_type ="'."REGISTRATION".'") AND year(`donationnewview`.`pay_date`) < year(curdate()) GROUP BY MemberType';
        //$sql = 'SELECT Donationnewview.id as ID,Donationnewview.pay_for AS EventName,sum(Donationnewview.Amount) AS Revenue FROM '.$this->getTable().' WHERE  year(`Donationnewview`.`pay_date`) < 2023 GROUP BY EventName';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    
    // for giftshop grid
     public function donationgiftmisc($opts)
    {
  
         $sql = 'SELECT * FROM '.$this->getTable().' WHERE pay_type IN("gift", "misc") ORDER BY pay_date DESC';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    
    
    public function emrald()
    {
        $sql = "SELECT 
    m.Member_id,
    m.F_Name,
    m.M_Name,
    m.L_Name,
    m.Sp_FName,
    m.Sp_LName,
    m.YTD,
    m.email,
    m.tele1,
    ps.selectedpuja,
    ps.item_name
FROM 
    memberltdytd m
LEFT JOIN pujasank ps
    ON m.Member_id = ps.regmember
    AND ps.pay_date > CONCAT(IF(MONTH(CURDATE()) >= 7, YEAR(CURDATE()), YEAR(CURDATE())-1), '-07-01')
WHERE 
    EXISTS (
        SELECT 1
        FROM puja_ytd_tiers pyt
        WHERE pyt.season_year = YEAR(CURDATE())
          AND pyt.active = 1
          AND LOWER(pyt.tier_name) = 'emerald'
          AND m.YTD >= pyt.min_amount
          AND (pyt.max_amount IS NULL OR m.YTD <= pyt.max_amount)
    );
";

        $emrald = $this->execute($sql);
        return $emrald;

    }


    public function Diamond()
    {
        $sql = "SELECT 
    m.Member_id,
    m.F_Name,
    m.M_Name,
    m.L_Name,
    m.Sp_FName,
    m.Sp_LName,
    m.YTD,
    m.email,
    m.tele1,
    ps.selectedpuja,
    ps.item_name,
    ips.eventsponsorshipcategoryA,
    ips.eventsponsorshipcategoryB,
    ips.Freesankalpapuja
FROM 
    memberltdytd m
LEFT JOIN pujasank ps
    ON m.Member_id = ps.regmember
    AND ps.pay_date > CONCAT(IF(MONTH(CURDATE()) >= 7, YEAR(CURDATE()), YEAR(CURDATE())-1), '-07-01')
LEFT JOIN items_pujasponsor ips
    ON m.Member_id = ips.Member_id
    AND ips.Paydate > CONCAT(IF(MONTH(CURDATE()) >= 7, YEAR(CURDATE()), YEAR(CURDATE())-1), '-07-01')
WHERE 
    EXISTS (
        SELECT 1
        FROM puja_ytd_tiers pyt
        WHERE pyt.season_year = YEAR(CURDATE())
          AND pyt.active = 1
          AND LOWER(pyt.tier_name) = 'diamond'
          AND m.YTD >= pyt.min_amount
          AND (pyt.max_amount IS NULL OR m.YTD <= pyt.max_amount)
    );
";


 $diamond = $this->execute($sql);
return $diamond;
    }

    public function donationgiftmiscytd()
    {
  
        $sql = 'SELECT SUM(Amount) as misc FROM '.$this->getTable().' WHERE (year(pay_date) = year(curdate())) and pay_type IN("gift", "misc")';
        $result = array();
        $arr = $this->execute($sql);
        return $arr[0]['misc'];
        
    }
    
    public function projectedDiamond()
    {
        $sql = "SELECT 
    m.Member_id,
    m.F_Name,
    m.M_Name,
    m.L_Name,
    m.Sp_FName,
    m.Sp_LName,
    m.YTD,
    m.email,
    m.tele1,
    ps.selectedpuja,
    ps.item_name,
    ips.eventsponsorshipcategoryA,
    ips.eventsponsorshipcategoryB,
    ips.Freesankalpapuja
FROM 
    memberltdytd m
LEFT JOIN pujasank ps
    ON m.Member_id = ps.regmember
    AND ps.pay_date > CONCAT(IF(MONTH(CURDATE()) >= 7, YEAR(CURDATE()), YEAR(CURDATE())-1), '-07-01')
LEFT JOIN items_pujasponsor ips
    ON m.Member_id = ips.Member_id
    AND ips.Paydate > CONCAT(IF(MONTH(CURDATE()) >= 7, YEAR(CURDATE()), YEAR(CURDATE())-1), '-07-01')
LEFT JOIN pujaregistration pr
    ON m.Member_id = pr.Member_id
WHERE 
    pr.sponsorLevel = 'Diamond';

";
        $projectediamond = $this->execute($sql);
        return $projectediamond;
    }



     public function projectedEmrald()
    {
        $sql = "SELECT 
    m.Member_id,
    m.F_Name,
    m.M_Name,
    m.L_Name,
    m.Sp_FName,
    m.Sp_LName,
    m.YTD,
    m.email,
    m.tele1,
    ps.selectedpuja,
    ps.item_name
FROM 
    memberltdytd m
LEFT JOIN pujasank ps
    ON m.Member_id = ps.regmember
    AND ps.pay_date > CONCAT(IF(MONTH(CURDATE()) >= 7, YEAR(CURDATE()), YEAR(CURDATE())-1), '-07-01')
LEFT JOIN pujaregistration pr
    ON m.Member_id = pr.Member_id
WHERE 
    pr.sponsorLevel = 'Emerald';

";

        $projectedemrald = $this->execute($sql);
        return $projectedemrald;
    }
    
    
    
    public function donationAllwithParking($opts)
{
    $current_year = date("Y");
    $next_year = $current_year + 1;

    // timezone set karna zaroori hai before date()
    date_default_timezone_set("America/Chicago");

    // agar financial year ke hisaab se shift karna hai
    if (date("m-d") < "04-01") {
        $current_year = $current_year - 1;
        $next_year = date("Y");
    }

    $sql = 'SELECT d.*, n.greenFieldParkingDecision
            FROM ' . $this->getTable() . ' d
            LEFT JOIN noparking n 
                ON d.oid COLLATE utf8mb4_unicode_ci = n.oid COLLATE utf8mb4_unicode_ci
               AND d.pay_type COLLATE utf8mb4_unicode_ci = n.pay_type COLLATE utf8mb4_unicode_ci
            WHERE d.pay_date >= "' . $current_year . '-04-01"
              AND d.pay_date < "' . $next_year . '-03-31"
            ORDER BY d.pay_date DESC
            LIMIT 0, 25';

    $arr = $this->execute($sql);
    return $arr;
}

    
}

?>
