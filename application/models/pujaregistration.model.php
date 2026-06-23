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
        array('name' => 'childone_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'Age1', 'type' => 'int', 'default' => ''),
        array('name' => 'childtwofname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'childtwolname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'childtwo_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'Age2', 'type' => 'int', 'default' => ''),
        array('name' => 'childthreefname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'childthreelname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'childthree_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'Age3', 'type' => 'int', 'default' => ''),
        array('name' => 'co_register_adult_members', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'adult_member_count', 'type' => 'varchar', 'default' => ''),
        array('name' => 'adult1_fname', 'type' => 'text', 'default' => ''),
        array('name' => 'adult1_lname', 'type' => 'text', 'default' => ''),
        array('name' => 'adult1_birth_year', 'type' => 'int', 'default' => ''),
        array('name' => 'adult1_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'adult2_fname', 'type' => 'text', 'default' => ''),
        array('name' => 'adult2_lname', 'type' => 'text', 'default' => ''),
        array('name' => 'adult2_birth_year', 'type' => 'int', 'default' => ''),
        array('name' => 'adult2_veggie', 'type' => 'tinyint', 'default' => ''),
        array('name' => 'adult3_fname', 'type' => 'text', 'default' => ''),
        array('name' => 'adult3_lname', 'type' => 'text', 'default' => ''),
        array('name' => 'adult3_birth_year', 'type' => 'int', 'default' => ''),
        array('name' => 'adult3_veggie', 'type' => 'tinyint', 'default' => ''),
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
        array('name' => 'extrachildregistration', 'type' => 'varchar', 'default' => ''),
        array('name' => 'extraadultregistration', 'type' => 'varchar', 'default' => ''),
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
        array('name' => 'chkdate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'receiveby', 'type' => 'varchar', 'default' => ''),
       // end
        array('name' => 'newytd', 'type' => 'varchar', 'default' => ''),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'pay_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_for', 'type' => 'varchar', 'default' => ''),
        array('name' => 'update_on', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'remarks', 'type' => 'varchar', 'default' => ''), 
        array('name' => 'admin_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'DepositAccount', 'type' => 'varchar', 'default' => '') ,
         array('name' => 'CreatedAt', 'type' => 'date', 'default' => ':NULL'),
         // Dinner coupon fields removed from Puja Registration per 2026 client change.
         // Existing DB columns and aggregate methods are left for old records/admin dashboard.
         // array('name' => 'adultCouponQty', 'type' => 'varchar', 'default' => ''),
         // array('name' => 'childCouponQty', 'type' => 'varchar', 'default' => ''),
         // array('name' => 'totalCouponPrice', 'type' => 'varchar', 'default' => ''),
         array('name' => 'sponsorLevel ', 'type' => 'varchar', 'default' => ''),
          array('name' => 'greenFieldParkingDecision', 'type' => 'varchar', 'default' => '')
        
        
    ); 

    public function ensureAdultChildColumns()
    {
        $columns = array(
            'childone_veggie' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'childtwo_veggie' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'childthree_veggie' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'co_register_adult_members' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'adult_member_count' => 'VARCHAR(10) DEFAULT NULL',
            'adult1_fname' => 'TEXT DEFAULT NULL'
        );

        foreach ($columns as $column => $definition) {
            $safeColumn = addslashes($column);
            $existing = $this->execute("SHOW COLUMNS FROM `" . $this->getTable() . "` LIKE '" . $safeColumn . "'");
            if (empty($existing)) {
                try {
                    $this->execute("ALTER TABLE `" . $this->getTable() . "` ADD `" . $safeColumn . "` " . $definition);
                } catch (Throwable $e) {
                    error_log('PUJA REGISTRATION COLUMN ENSURE SKIPPED | column=' . $safeColumn . ' | ' . $e->getMessage());
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
    
     public function getAllpujaregistrationdata($opts)
    {
        // $res = 'SELECT * FROM '.$this->getTable().'  ORDER BY id DESC';
        // $result = array();
        // $arr = $this->execute($res);
        // return $arr; 
        
        
        $current_year = date("Y");
        $Nextyear = $current_year + 1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "06-01") {
            $current_year = $current_year - 1;
            $Nextyear = $current_year + 1;
        }
        $res = 'SELECT p.*,
                COALESCE(extra.extra_adult_members, 0) AS extra_adult_members,
                COALESCE(extra.extra_adult_member_names, "") AS extra_adult_member_names
            FROM ' . $this->getTable() . ' p
            LEFT JOIN (
                SELECT oid,
                       COUNT(*) AS extra_adult_members,
                       GROUP_CONCAT(TRIM(CONCAT(COALESCE(first_name, ""), " ", COALESCE(last_name, ""))) SEPARATOR ", ") AS extra_adult_member_names
                FROM pujaregistration_extra_members
                WHERE member_type = "Adult"
                GROUP BY oid
            ) extra ON extra.oid = p.oid
            WHERE p.CreatedAt >= "' . "$current_year-06-01" . '"
            AND p.CreatedAt <= "' . "$Nextyear-06-30" . '"
            ORDER BY p.id DESC';
        $result = array();
        $arr = $this->execute($res);
        return $arr;
    }   

    public function hasCurrentSeasonRegistration($memberId)
    {
        $memberId = (int) $memberId;
        if ($memberId <= 0) {
            return false;
        }

        $current_year = date("Y");
        $Nextyear = $current_year + 1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "06-01") {
            $current_year = $current_year - 1;
            $Nextyear = $current_year + 1;
        }

        $seasonStart = $current_year . '-06-01';
        $seasonEnd = $Nextyear . '-06-30';

        $sql = 'SELECT id FROM ' . $this->getTable() . '
            WHERE Member_id = "' . $memberId . '"
            AND (
                (CreatedAt >= "' . $seasonStart . '" AND CreatedAt <= "' . $seasonEnd . '")
                OR (pay_date >= "' . $seasonStart . '" AND pay_date <= "' . $seasonEnd . '")
                OR (DATE(update_on) >= "' . $seasonStart . '" AND DATE(update_on) <= "' . $seasonEnd . '")
            )
            AND (status IS NULL OR status = "" OR status NOT IN ("cancelled", "Cancelled"))
            LIMIT 1';

        $arr = $this->execute($sql);
        return !empty($arr[0]['id']);
    }

    public function getCurrentSeasonRegistrationPujaTypes($memberId)
    {
        $memberId = (int) $memberId;
        if ($memberId <= 0) {
            return array();
        }

        $current_year = date("Y");
        $Nextyear = $current_year + 1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "06-01") {
            $current_year = $current_year - 1;
            $Nextyear = $current_year + 1;
        }

        $seasonStart = $current_year . '-06-01';
        $seasonEnd = $Nextyear . '-06-30';

        $sql = 'SELECT DISTINCT puja_type FROM ' . $this->getTable() . '
            WHERE Member_id = "' . $memberId . '"
            AND (
                (CreatedAt >= "' . $seasonStart . '" AND CreatedAt <= "' . $seasonEnd . '")
                OR (pay_date >= "' . $seasonStart . '" AND pay_date <= "' . $seasonEnd . '")
                OR (DATE(update_on) >= "' . $seasonStart . '" AND DATE(update_on) <= "' . $seasonEnd . '")
            )
            AND (status IS NULL OR status = "" OR status NOT IN ("cancelled", "Cancelled"))';

        $arr = $this->execute($sql);
        $pujaTypes = array();
        foreach ($arr as $row) {
            $pujaType = trim($row['puja_type'] ?? '');
            if ($pujaType !== '') {
                $pujaTypes[] = $pujaType;
            }
        }
        return array_values(array_unique($pujaTypes));
    }

    public function getPujaRegistrationConflict($memberId, $requestedPuja)
    {
        $requestedPuja = trim((string) $requestedPuja);
        if ((int) $memberId <= 0 || $requestedPuja === '') {
            return array('blocked' => false, 'message' => '', 'existing' => array());
        }

        $existing = $this->getCurrentSeasonRegistrationPujaTypes($memberId);
        if (empty($existing)) {
            return array('blocked' => false, 'message' => '', 'existing' => array());
        }

        if (in_array('All 3 Pujas', $existing, true)) {
            return array(
                'blocked' => true,
                'message' => 'This member is already registered for All 3 Pujas and cannot register again for any Puja.',
                'existing' => $existing
            );
        }

        if ($requestedPuja === 'All 3 Pujas') {
            return array(
                'blocked' => true,
                'message' => 'This member already has Puja registration this season. All 3 Pujas registration is not allowed.',
                'existing' => $existing
            );
        }

        if (in_array($requestedPuja, $existing, true)) {
            return array(
                'blocked' => true,
                'message' => 'This member is already registered for ' . $requestedPuja . ' this season.',
                'existing' => $existing
            );
        }

        $hasDurga = in_array('Durga Puja', $existing, true);
        $hasKali = in_array('Kali Puja', $existing, true);

        if ($hasDurga && $hasKali) {
            return array(
                'blocked' => true,
                'message' => 'This member is already registered for Durga Puja and Kali Puja this season.',
                'existing' => $existing
            );
        }

        if ($hasDurga && $requestedPuja !== 'Kali Puja') {
            return array(
                'blocked' => true,
                'message' => 'This member is already registered for Durga Puja. Only Kali Puja can be added.',
                'existing' => $existing
            );
        }

        if ($hasKali && $requestedPuja !== 'Durga Puja') {
            return array(
                'blocked' => true,
                'message' => 'This member is already registered for Kali Puja. Only Durga Puja can be added.',
                'existing' => $existing
            );
        }

        return array('blocked' => false, 'message' => '', 'existing' => $existing);
    }

    public function hasCurrentSeasonConfirmedPujaType($memberId, $pujaTypes)
    {
        $memberId = (int) $memberId;
        if ($memberId <= 0 || empty($pujaTypes) || !is_array($pujaTypes)) {
            return false;
        }

        $current_year = date("Y");
        $Nextyear = $current_year + 1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "06-01") {
            $current_year = $current_year - 1;
            $Nextyear = $current_year + 1;
        }

        $quotedTypes = array();
        foreach ($pujaTypes as $pujaType) {
            $quotedTypes[] = '"' . addslashes($pujaType) . '"';
        }

        $seasonStart = $current_year . '-06-01';
        $seasonEnd = $Nextyear . '-06-30';

        $sql = 'SELECT id FROM ' . $this->getTable() . '
            WHERE Member_id = "' . $memberId . '"
            AND puja_type IN (' . implode(',', $quotedTypes) . ')
            AND (
                (CreatedAt >= "' . $seasonStart . '" AND CreatedAt <= "' . $seasonEnd . '")
                OR (pay_date >= "' . $seasonStart . '" AND pay_date <= "' . $seasonEnd . '")
                OR (DATE(update_on) >= "' . $seasonStart . '" AND DATE(update_on) <= "' . $seasonEnd . '")
            )
            AND (status IS NULL OR status = "" OR status NOT IN ("cancelled", "Cancelled"))
            AND (
                payment_status IN ("confirmed", "succeeded")
                OR status IN ("confirmed", "Confirmed")
            )
            LIMIT 1';

        $arr = $this->execute($sql);
        return !empty($arr[0]['id']);
    }
    
    
  public function checkemberregister($Memberid)
  {
   // $sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id = "'."$Memberid".'" AND puja_type != "'."Saraswati Puja".'" AND year(pay_date) = year(CURDATE())';
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
    // $current_year = date("Y");
    // $Nextyear = date('Y')+1;
    
     $current_year = date("Y");
     $Nextyear = date('Y')+1;
    date_default_timezone_set("America/Chicago");
    if (date("m-d") < "04-01") {
        $current_year = $current_year - 1; 
        $Nextyear = date("Y");
    }
    
    
    
    $sql = 'SELECT  * FROM '.$this->getTable().' WHERE Member_id = "'."$memberId".'"AND pay_date >= "'."$current_year-05-01".'" AND pay_date < "'."$Nextyear-03-31".'" ';
    //$sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id = "'."$memberId".'"AND pay_date >= "'."2023-04-01".'" AND pay_date < "'."2024-03-31".'" ';
    $arr = $this->execute($sql);
    return $arr;
 }
 public function getOID($id)
 {
     $sql = 'SELECT oid FROM '.$this->getTable().' WHERE id="' . $id . '"';
     $arr = $this->execute($sql);
     return $arr[0];

 }
 public function updateDocument($id , $newAvatar)
 {
    $sql = 'UPDATE ' . $this->getTable() . ' SET addressavatar = "' . $newAvatar . '" WHERE id = "' . $id . '"';
   $arr = $this->execute($sql);
   return $sql;
   
 }
 
  public function checkRegistrationPuja30MAY($Memberid)
  {
    $sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id = "'."$Memberid".'" AND puja_type != "'."Saraswati Puja".'" AND DATE_FORMAT(pay_date, "%Y") = DATE_FORMAT(CURDATE(), "%Y")'; 
    $result = array();
    $arr = $this->execute($sql);
    if(!empty($arr[0]['id'])){
       $result = $this->checkRegistrationPaidParking($Memberid);
       if($result){
         echo "<input  id='memberdata' value='false'/> ";
       }else{
        echo "<input  id='memberdata' value='true'/> "; 
       }   
    }else{
        echo "<input  id='memberdata' value='false'/> ";
    }  
  }
  
  public function checkRegistrationPuja($Memberid)
  {
    // $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE Member_id = "' . "$Memberid" . '" AND puja_type != "' . "Saraswati Puja" . '" AND DATE_FORMAT(pay_date, "%Y") = DATE_FORMAT(CURDATE(), "%Y")';
    $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE Member_id = "' . $Memberid . '" AND DATE_FORMAT(pay_date, "%Y") = DATE_FORMAT(CURDATE(), "%Y")';

    $result = array();
    $arr = $this->execute($sql);

    if (!empty($arr[0]['id'])) {
      $pujatype = $arr[0]['puja_type'];
      $senior = $arr[0]['senior'];
      // $result = $this->checkRegistrationPaidParking($Memberid);
      // if ($result) {
      //   echo "<input  id='memberdata' value='false'/> ";
      // } 

      // else {
      // echo "<input  id='memberdata' value='true'/> "; 
      echo "<input  id='memberdata' value='true'/> ";
      echo "<input  id='selectedPuja' value='$pujatype'/> ";
      echo "<input  id='Senior' value='$senior'/> ";
      // }
    } else {
      echo "<input  id='memberdata' value='false'/> ";
    }
  }
  
  
  public function checkRegistrationPuja2($Memberid)
  {
    
                  
                  
                  $year = date('Y'); // Gets current year
$cutoff_date = $year . '-07-01';

// All 3 Pujas
$sql_all3 = 'SELECT * FROM ' . $this->getTable() . ' 
             WHERE Member_id = "' . $Memberid . '" 
             AND puja_type = "All 3 Pujas" 
             AND pay_date > "' . $cutoff_date . '" 
             AND payment_status = "confirmed"';

// Durga Puja
$sql_durga = 'SELECT * FROM ' . $this->getTable() . ' 
              WHERE Member_id = "' . $Memberid . '" 
              AND puja_type = "Durga Puja" 
              AND pay_date > "' . $cutoff_date . '" 
              AND payment_status = "confirmed"';

// Kali Puja
$sql_kali = 'SELECT * FROM ' . $this->getTable() . ' 
             WHERE Member_id = "' . $Memberid . '" 
             AND puja_type = "Kali Puja" 
             AND pay_date > "' . $cutoff_date . '" 
             AND payment_status = "confirmed"';

// Saraswati Puja
$sql_saraswati = 'SELECT * FROM ' . $this->getTable() . ' 
                  WHERE Member_id = "' . $Memberid . '" 
                  AND puja_type = "Saraswati Puja" 
                  AND pay_date > "' . $cutoff_date . '" 
                  AND payment_status = "confirmed"';





    $arr1 = $this->execute($sql_all3);
    $arr2 = $this->execute($sql_durga);
    $arr3 = $this->execute($sql_kali);
    $arr4 = $this->execute($sql_saraswati);


    if (
      !empty($arr1) && !empty($arr1[0]['id']) ||
      !empty($arr2) && !empty($arr2[0]['id']) ||
      !empty($arr3) && !empty($arr3[0]['id']) ||
      !empty($arr4) && !empty($arr4[0]['id'])
    ) {

      if (!empty($arr1[0]['id'])) {
        $pujatype1 = $arr1[0]['puja_type'];
        $senior3p = $arr1[0]['senior'];
        echo "<input  id='all3Puja' value='$pujatype1'/> ";
        echo "<input  id='all3PujaSenior' value='$senior3p'/> ";
      }

      if (!empty($arr2[0]['id'])) {
        
        $pujatype2 = $arr2[0]['puja_type'];
        $seniorDp = $arr2[0]['senior'];
        echo "<input  id='durgaPuja' value='$pujatype2'/> ";
        echo "<input  id='durgaPujaSenior' value='$seniorDp'/> ";
      }

      if (!empty($arr3[0]['id'])) {
        $pujatype3 = $arr3[0]['puja_type'];
        echo "<input  id='kaliPuja' value='$pujatype3'/> ";
      }

      if (!empty($arr4[0]['id'])) {
        $pujatype4 = $arr4[0]['puja_type'];
        echo "<input  id='saraswatiPuja' value='$pujatype4'/> ";
      }


    } else {
      echo "<input  id='memberdata' value='false'/> ";
    }



    // if (!empty($arr[0]['id'])) {
    //   $pujatype = $arr[0]['puja_type'];
    //   $senior = $arr[0]['senior'];

    //   echo "<input  id='memberdata' value='true'/> ";
    //   echo "<input  id='selectedPuja' value='$pujatype'/> ";
    //   echo "<input  id='Senior' value='$senior'/> ";
    //   // }
    // } else {
    //   echo "<input  id='memberdata' value='false'/> ";
    // }
  }


  public function checkRegistrationPaidParking($Memberid)
  {
    $sql = 'SELECT * FROM paidparking WHERE Member_id = "' . $Memberid . '"' . ' AND DATE_FORMAT(pay_date, "%Y") = DATE_FORMAT(CURDATE(), "%Y")';
    $result = array();
    $arr = $this->execute($sql);
    return !empty($arr[0]['id']); 
  }
  
  
  public function getltdytd()
  {
    $sql = "SELECT DISTINCT 
    m.Member_id AS Member_id,
    m.ytd AS YTD
FROM pujaregistration p
INNER JOIN memberltdytd m ON p.Member_id = m.Member_id
WHERE p.CreatedAt >= '2025-07-03'"
    ;

    $ltdytd = $this->execute($sql);



    $count_600_999 = 0;
    $count_1000_1399 = 0;
    $count_1400_2199 = 0;
    $count_2200_4999 = 0;



    foreach ($ltdytd as $row) {
      $ytd = (int) $row['YTD'];

      if ($ytd >= 600 && $ytd <= 999) {
        $count_600_999++;
      } elseif ($ytd >= 1000 && $ytd <= 1399) {
        $count_1000_1399++;
      } elseif ($ytd >= 1400 && $ytd <= 2199) {
        $count_1400_2199++;
      } elseif ($ytd >= 2200 && $ytd <= 4999) {
        $count_2200_4999++;
      }
    }

    // You can return them as an array or just use the variables

    $total = $count_600_999 + $count_1000_1399 + $count_1400_2199 + $count_2200_4999;
    return [
      '600-999' => $count_600_999,
      '1000-1399' => $count_1000_1399,
      '1400-2199' => $count_1400_2199,
      '2200-4999' => $count_2200_4999,
      "total" => $total
    ];




  }


  public function countMembersWithYtd5000OrMore()
  {
    $sql = "SELECT COUNT(*) AS total_members FROM memberltdytd WHERE YTD >= 5000";
    $arr = $this->execute($sql);
    return $arr[0]['total_members'];
  }




  public function getAdultCoupon()
  {
  
    $current_year = date("Y");
    $Nextyear = date('Y') + 1;
    date_default_timezone_set("America/Chicago");
    if (date("m-d") < "04-01") {
      $current_year = $current_year - 1;
      $Nextyear = date("Y");
    }
    $res = 'SELECT SUM(adultCouponQty) AS totalAdultCoupons 
        FROM ' . $this->getTable() . ' 
        WHERE CreatedAt >= "' . "$current_year-07-01" . '"
        AND CreatedAt <= "' . "$Nextyear-06-30" . '"';
    $result = array();
    $arr = $this->execute($res);
    return $arr[0]['totalAdultCoupons'];
  }


  public function getChildCoupon()
  {
   
    $current_year = date("Y");
    $Nextyear = date('Y') + 1;
    date_default_timezone_set("America/Chicago");
    if (date("m-d") < "04-01") {
      $current_year = $current_year - 1;
      $Nextyear = date("Y");
    }
    $res = 'SELECT SUM(childCouponQty) AS totalCildCoupons 
        FROM ' . $this->getTable() . ' 
        WHERE CreatedAt >= "' . "$current_year-07-01" . '"
        AND CreatedAt <= "' . "$Nextyear-06-30" . '"';
    $result = array();
    $arr = $this->execute($res);
    return $arr[0]['totalCildCoupons'];
  }


  public function getTotalCouponAmount()
  {
  
    $current_year = date("Y");
    $Nextyear = date('Y') + 1;
    date_default_timezone_set("America/Chicago");
    if (date("m-d") < "04-01") {
      $current_year = $current_year - 1;
      $Nextyear = date("Y");
    }
    $res = 'SELECT SUM(totalCouponPrice) AS totalCouponAmount
        FROM ' . $this->getTable() . ' 
        WHERE CreatedAt >= "' . "$current_year-07-01" . '"
        AND CreatedAt <= "' . "$Nextyear-06-30" . '"';
    $result = array();
    $arr = $this->execute($res);
    return $arr[0]['totalCouponAmount'];
  }
  
  public function updateSponsorshipLevel($id , $sponsorLevel)
  {
  
   $sql = "UPDATE pujaregistration 
        SET sponsorLevel = '$sponsorLevel' 
        WHERE id = $id";
        $arr = $this->execute($sql);
    return $sql;
  }
  
  public function checkProjectedSponsarLevel($memberid)
  {

    date_default_timezone_set("America/Chicago");

    $current_year = date("Y");
    $next_year = $current_year + 1;

    if (date("m-d") < "04-01") {
      $current_year = $current_year - 1;
      $next_year = $current_year + 1;
    }

    $sql = "SELECT sponsorLevel FROM pujaregistration 
        WHERE Member_id = $memberid 
          AND pay_date >= '{$current_year}-07-01'
          AND pay_date <= '{$next_year}-06-30'";

    $arr = $this->execute($sql);

    $level = $arr[0]['sponsorLevel'];
    echo "<input  id='sponsorLevel' value='$level'/> ";


  }

 
 
}

?>
