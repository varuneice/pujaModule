<?php

require_once MODELS_PATH . 'App.model.php';

class MemberModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'members';
    var $schema = array(
        array('name' => 'ID', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'information', 'type' => 'varchar', 'default' => ''),
        array('name' => 'GovtissueID', 'type' => 'varchar', 'default' => ''),
        array('name' => 'membership_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
        array('name' => 'Category', 'type' => 'enum', 'default' => ''),
        array('name' => 'fav_language', 'type' => 'varchar', 'default' => ''),
        array('name' => 'fav', 'type' => 'varchar', 'default' => ''),
        array('name' => 'F_Name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'M_Name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'L_Name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Mob_No', 'type' => 'bigint', 'default' => ''),
        array('name' => 'Sp_FName', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Sp_LName', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Address1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Address2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Address3', 'type' => 'varchar', 'default' => ''),
        array('name' => 'City', 'type' => 'varchar', 'default' => ''),
        array('name' => 'State', 'type' => 'varchar', 'default' => ':TX'),
        array('name' => 'Country', 'type' => 'varchar', 'default' => ':USA'),
        array('name' => 'Zip', 'type' => 'varchar', 'default' => ''),
        array('name' => 'email', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Email2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Tele1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Tele2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Child1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Child2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Child3', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age3', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Child4', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age4', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Parent1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Parent2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'remarks', 'type' => 'text', 'default' => ''),
        array('name' => 'swap', 'type' => 'enum', 'default' => ''),
        array('name' => 'FirstSal', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Payment_method', 'type' => 'varchar', 'default' => ''),
        array('name' => 'avatar', 'type' => 'varchar', 'default' => ''),
        array('name' => 'SpouseSal', 'type' => 'varchar', 'default' => ''),
        array('name' => 'CreatedOn', 'type' => 'datetime', 'default' => ':NULL'),
        array('name' => 'password', 'type' => 'varchar', 'default' => ''),
        array('name' => 'type', 'type' => 'int', 'default' => '1'),
        array('name' => 'status', 'type' => 'enum', 'default' => 'T'),
        
        
        array('name' => 'rate', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'amount', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'donation', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'total', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'UpdateBy', 'type' => 'varchar', 'default' => ''),
        array('name' => 'UpdateOn', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'Renew_date', 'type' => 'date','default' => ':NULL' ),
        array('name' => 'Ref_Phone', 'type' => 'varchar','default' => ':NULL' ),
        array('name' => 'pay_date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'pay_type', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'pay_for', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Active', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Gotra', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Senior', 'type' => 'varchar', 'default' => ':NULL')
        
    );

    private function logAddressUpdate($message)
    {
        error_log($message);
        if (defined('ROOT_PATH')) {
            @file_put_contents(ROOT_PATH . 'pujaregistrationlog.log', '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL, FILE_APPEND);
        }
    }

    private function getAddressRowForSubmittedMemberId($datamember)
    {
        $datamember = (int) $datamember;
        if ($datamember <= 0) {
            return array('row' => array(), 'where' => '');
        }

        $memberIdWhere = 'Member_id="' . $datamember . '"';
        $rows = $this->execute('SELECT ID, Member_id, Address1, Address2, Address3, City, State, Zip FROM ' . $this->getTable() . ' WHERE ' . $memberIdWhere . ' LIMIT 1');
        if (!empty($rows[0])) {
            return array('row' => $rows[0], 'where' => $memberIdWhere);
        }

        $idWhere = 'ID="' . $datamember . '"';
        $rows = $this->execute('SELECT ID, Member_id, Address1, Address2, Address3, City, State, Zip FROM ' . $this->getTable() . ' WHERE ' . $idWhere . ' LIMIT 1');
        if (!empty($rows[0])) {
            return array('row' => $rows[0], 'where' => $idWhere);
        }

        return array('row' => array(), 'where' => '');
    }
    
     public function update($data = array()) {
        $save = array();
        foreach ($this->schema as $field) {

            if (isset($data[$field['name']])) {
                $raw = $this->getScalarSchemaValue($data[$field['name']]);
                if ($this->normalizeSchemaValue($field, $raw, $normalized)) {
                    $save["`" . $field['name'] . "`"] = $normalized;
                }
            }
        }

        if (empty($save)) {
            return false;
        }

        $query = new UpdateQuery($this, $this->getTable());
        $query->set($save);
       
        if (!empty($data['ID'])) {
            $query = $query->where('ID', $data['ID']);
        }

        return $query->execute();
    }
     public function AllMember()
    {
        $Memberid=$_POST['memberid'] ?? '';
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id="'."$Memberid".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }

    public function getMemberF_name($ID)
      {

     $res = 'SELECT FirstSal, SpouseSal, CONCAT(`F_Name`, " / ",`Sp_FName`) AS Name FROM ' . $this->getTable() . ' WHERE  Member_id="' . "$ID" . '"';
        $result = array();
        $arr = $this->execute($res);
        $name =$arr[0]['Name'];
        $firstSal =$arr[0]['FirstSal'];
        $spousesal =$arr[0]['SpouseSal'];
        
        if(!empty($arr[0]['Name'])){
            echo  "<input  id='latemem' value='$name' /> ";
            echo  "<input  id='spousesalfield' value='$spousesal' /> ";
            echo  "<input  id='firstSalfield' value='$firstSal' /> ";
        }
        
    }

    function getMax(){
        $sql = 'SELECT MAX(Member_id) AS Member_id FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['Member_id'])){
            return $res[0]['Member_id'];
        }else{
            return 0;
        }
    }

    function getMaxid(){
        $sql = 'SELECT MAX(ID) AS ID FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['ID'])){
            return $res[0]['ID'];
        }else{
            return 0;
        }
    }
    
     public function checkduplicatemember()
    {
        $email=$_POST['email'] ?? '';
		$Tele=$_POST['Tele1'] ?? '';
        //$res = 'SELECT * FROM '.$this->getTable().' WHERE  Tele1="'."$Tele".'" OR email="'."$email".'"';
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE (REPLACE(Tele1, "-", "") = "' . "$Tele" . '" OR email="' . "$email" . '") AND (Active IS NULL OR ACTIVE="")';
        $result = array();
        $arr = $this->execute($res);
        $memberid = $arr[0]['Member_id'] ?? null;

        return $memberid;
    }
    
       public function rentalmemberduplicate()
    {
        $email=$_POST['email'] ?? '';
		$Tele=$_POST['phone'] ?? '';
        //$res = 'SELECT * FROM '.$this->getTable().' WHERE  Tele1="'."$Tele".'" OR email="'."$email".'"';
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE (REPLACE(Tele1, "-", "") = "' . $Tele . '" OR email = "' . $email . '") AND (Active IS NULL OR ACTIVE="")' ;
        $result = array();
        $arr = $this->execute($res);
        $memberid = $arr[0]['Member_id'] ?? null;

        return $memberid;
    }
    
     public function ticketduplicatemember()
    {
        $email=$_POST['email'] ?? '';
		$Tele=$_POST['tele'] ?? '';
        //$res = 'SELECT * FROM '.$this->getTable().' WHERE  Tele1="'."$Tele".'" OR email="'."$email".'"';
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE (REPLACE(Tele1, "-", "") = "' . "$Tele" . '" OR email="' . "$email" . '") AND (Active IS NULL OR ACTIVE="")';
        $result = array();
        $arr = $this->execute($res);
        $memberid = $arr[0]['Member_id'] ?? null;

        return $memberid;
    }
     public function studentcheckduplicatemember()
    {
        $email=$_POST['email'] ?? '';
		$Tele=$_POST['phone_number'] ?? '';

        $res = 'SELECT * FROM '.$this->getTable().' WHERE  Tele1="'."$Tele".'" OR email="'."$email".'"';
        $result = array();
        $arr = $this->execute($res);
        $memberid = $arr[0]['Member_id'] ?? null;

        return $memberid;
    }
    
    public function memberphone()
    {
        $Tele=$_POST['Tele'] ?? '';
        //$res = 'SELECT * FROM '.$this->getTable().' WHERE  Tele1="'."$Tele".'"';
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE REPLACE(Tele1, "-", "") = "' . $Tele . '"';
        $result = array();
        $arr = $this->execute($res);
        if(!empty($arr[0]['ID'])){
            echo "<input  id='phone_mobile' value='true'/> ";
            
        }else{
            echo "<input  id='phone_mobile' value='false'/> ";
        }  
    }

/*
     public function Membercheck()
    {
        $email=$_POST['email'] ?? '';

        $res = 'SELECT * FROM '.$this->getTable().' WHERE  email="'."$email".'"';
        $result = array();
        $arr = $this->execute($res);
        if(!empty($arr[0]['ID'])){
                echo "<input  id='email' value='true'/> ";
        }else{
            echo "<input  id='email' value='false'/> ";
        }  
    }
    
    */
    
    public function membercheck($memberid)
    {
        $res = 'SELECT * FROM '.$this->getTable().' WHERE  Member_id="'."$memberid".'"';
        $result = array();
        $arr = $this->execute($res);

        if(!empty($arr[0]['ID'])){
            return true;
       }else{
         return false;
       }  
        // if(!empty($arr[0]['ID'])){
        //         echo "<input  id='memberid' value='true'/> ";
        // }else{
        //     echo "<input  id='memberid' value='false'/> ";
        // }  
    }

      public function getid($mid)
    {
         
        $sql = 'SELECT ID FROM '.$this->getTable().' WHERE Member_id='.$mid.'';
        $res = $this->execute($sql);
        
        if(!empty($res[0]['ID'])){
            return $res[0]['ID'];
        }else{
            return 0;
        }
        
    }
    public function ctmember($opts)
    {
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE Category  NOT IN("GM", "GD", "LM", "BF")';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    
    public function checkmemberregisterornot()
    {
        $email=$_POST['email'] ?? '';
		$Tele=$_POST['tele'] ?? '';

        $res = 'SELECT * FROM '.$this->getTable().' WHERE  Tele1="'."$Tele".'" OR email="'."$email".'"';
        $result = array();
        $arr = $this->execute($res);
        $memberid = $arr[0]['Member_id'] ?? null;

        return $memberid;
    }
     //11july update
    public function checktele2($datamember)
    {
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id="'."$datamember".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    public function updatetelephone($datamember, $mobileno)
    {
        $sql = 'UPDATE '.$this->getTable().' SET Tele2="'."$mobileno".'" WHERE Member_id="'."$datamember".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }

    public function updateprimaryno($datamember, $phone)
    {
        $sql = 'UPDATE '.$this->getTable().' SET Tele1="'."$phone".'" WHERE Member_id="'."$datamember".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    public function updateemail($datamember, $email)
    {
        $sql = 'UPDATE '.$this->getTable().' SET email="'."$email".'" WHERE Member_id="'."$datamember".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }

    public function updateAddress($datamember, $data, $whereSql = '')
    {
        $datamember = (int) $datamember;
        if ($datamember <= 0) {
            $this->logAddressUpdate('MEMBER ADDRESS UPDATE SKIPPED | invalid member_id=' . $datamember);
            return false;
        }

        $street = addslashes(trim((string) ($data['street'] ?? '')));
        $streetname = addslashes(trim((string) ($data['streetname'] ?? '')));
        $unit = addslashes(trim((string) ($data['unit'] ?? '')));
        $city = addslashes(trim((string) ($data['city'] ?? '')));
        $state = addslashes(trim((string) ($data['state'] ?? '')));
        $zip = addslashes(trim((string) ($data['zip'] ?? '')));
        $updateOn = date('Y-m-d H:i:s');

        if ($whereSql === '') {
            $resolved = $this->getAddressRowForSubmittedMemberId($datamember);
            $whereSql = $resolved['where'];
        }

        if ($whereSql === '') {
            $this->logAddressUpdate('MEMBER ADDRESS UPDATE SKIPPED | member not found for update | submitted_id=' . $datamember);
            return false;
        }

        $sql = 'UPDATE ' . $this->getTable() . ' SET
            Address1="' . $street . '",
            Address2="' . $streetname . '",
            Address3="' . $unit . '",
            City="' . $city . '",
            State="' . $state . '",
            Zip="' . $zip . '",
            UpdateOn="' . $updateOn . '"
            WHERE ' . $whereSql;

        $this->execute($sql);
        $this->logAddressUpdate('MEMBER ADDRESS UPDATE EXECUTED | submitted_id=' . $datamember . ' | where=' . $whereSql . ' | street=' . stripslashes($street) . ' | streetname=' . stripslashes($streetname) . ' | unit=' . stripslashes($unit) . ' | city=' . stripslashes($city) . ' | state=' . stripslashes($state) . ' | zip=' . stripslashes($zip));
        return true;
    }

    public function updateAddressWithHistory($datamember, $data, $source = 'Puja Registration')
    {
        $datamember = (int) $datamember;
        if ($datamember <= 0) {
            $this->logAddressUpdate('MEMBER ADDRESS UPDATE WITH HISTORY SKIPPED | invalid member_id=' . $datamember . ' | source=' . $source);
            return false;
        }

        $resolved = $this->getAddressRowForSubmittedMemberId($datamember);
        $oldAddress = $resolved['row'];
        if (empty($oldAddress)) {
            $this->logAddressUpdate('MEMBER ADDRESS UPDATE WITH HISTORY SKIPPED | member not found | submitted_id=' . $datamember . ' | source=' . $source);
            return false;
        }

        $newAddress = array(
            'Address1' => trim((string) ($data['street'] ?? '')),
            'Address2' => trim((string) ($data['streetname'] ?? '')),
            'Address3' => trim((string) ($data['unit'] ?? '')),
            'City' => trim((string) ($data['city'] ?? '')),
            'State' => trim((string) ($data['state'] ?? '')),
            'Zip' => trim((string) ($data['zip'] ?? ''))
        );

        if ($newAddress['Address1'] === '' || $newAddress['Address2'] === '' || $newAddress['City'] === '' || $newAddress['State'] === '' || $newAddress['Zip'] === '') {
            $this->logAddressUpdate('MEMBER ADDRESS UPDATE WITH HISTORY SKIPPED | incomplete new address | submitted_id=' . $datamember . ' | source=' . $source . ' | new=' . json_encode($newAddress));
            return false;
        }

        $hasChanged = false;
        foreach ($newAddress as $field => $newValue) {
            if (trim((string) ($oldAddress[$field] ?? '')) !== $newValue) {
                $hasChanged = true;
                break;
            }
        }

        if (!$hasChanged) {
            $this->logAddressUpdate('MEMBER ADDRESS UPDATE WITH HISTORY SKIPPED | no address change | submitted_id=' . $datamember . ' | resolved_member_id=' . ($oldAddress['Member_id'] ?? '') . ' | source=' . $source . ' | address=' . json_encode($newAddress));
            return true;
        }

        $this->logAddressUpdate('MEMBER ADDRESS UPDATE WITH HISTORY START | submitted_id=' . $datamember . ' | resolved_member_id=' . ($oldAddress['Member_id'] ?? '') . ' | resolved_id=' . ($oldAddress['ID'] ?? '') . ' | source=' . $source . ' | old=' . json_encode(array(
            'Address1' => $oldAddress['Address1'] ?? '',
            'Address2' => $oldAddress['Address2'] ?? '',
            'Address3' => $oldAddress['Address3'] ?? '',
            'City' => $oldAddress['City'] ?? '',
            'State' => $oldAddress['State'] ?? '',
            'Zip' => $oldAddress['Zip'] ?? ''
        )) . ' | new=' . json_encode($newAddress));

        try {
            GzObject::loadFiles('Model', 'memberAddressHistory');
            $memberAddressHistoryModel = new memberAddressHistoryModel();
            $memberAddressHistoryModel->saveChange($datamember, $oldAddress, $newAddress, $source);
        } catch (Throwable $historyEx) {
            $this->logAddressUpdate('MEMBER ADDRESS HISTORY ERROR | submitted_id=' . $datamember . ' | ' . $historyEx->getMessage());
        }

        return $this->updateAddress($datamember, $data, $resolved['where']);
    }

    public function updupdatealternateemail($datamember, $alternateemail)
    {
        $sql = 'UPDATE '.$this->getTable().' SET Email2="'."$alternateemail".'" WHERE Member_id="'."$datamember".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }

    // create general donor as  member 
        public function SaveDataInmember($value)
            {
            $memberunique = $this->getMaxid();
            $ID = $memberunique +1;	

            $Member_id =  $value['Member_id'] ?? null;
            $Member_id_sql = ($Member_id === null || $Member_id === '') ? 'NULL' : (int)$Member_id;
            $Category = 'GC';
            $membername = $value['MemberName'] ?? '';
            $nameParts = explode(" ", trim($membername), 2);
            $F_Name = $nameParts[0] ?? '';
            $L_Name = $nameParts[1] ?? '';
            $spousename = $value['spousename'] ?? '';
            $snameParts = explode(" ", trim($spousename), 2);
            $Sp_FName = $snameParts[0] ?? '';
            $Sp_LName = $snameParts[1] ?? '';

            $Address1 =  $value['Street'] ?? '';
            $Address2 = $value['Address'] ?? '';
            $Address3 = $value['Address3'] ?? '';
            $City = $value['City'] ?? '';
            $State =  $value['State'] ?? '';
            $Country = $value['Country'] ?? '';
            $Zip = $value['Zip_Code'] ?? '';
            $email = $value['email'] ?? '';
            $Tele1 = $value['Tele1'] ?? '';
            $Tele2 = $value['Tele2'] ?? '';
            $Child1 = $value['Child1'] ?? '';
            $Age1 = is_numeric($value['Age1'] ?? '') ? (int)$value['Age1'] : 0;
            $Child2 = $value['Child2'] ?? '';
            $Age2 = is_numeric($value['Age2'] ?? '') ? (int)$value['Age2'] : 0;
            $Child3 = $value['Child3'] ?? '';
            $Age3 = is_numeric($value['Age3'] ?? '') ? (int)$value['Age3'] : 0;
            $Parent1 = $value['Parent1'] ?? '';
            $Parent2 = $value['Parent2'] ?? '';
            $remarks = $value['remarks'] ?? '';
            $swap_raw = $value['swap'] ?? '';
            $swap_sql = in_array($swap_raw, ['0', '1']) ? "'$swap_raw'" : 'DEFAULT';
            $FirstSal = $value['FirstSal'] ?? '';
            $SpouseSal = $value['SpouseSal'] ?? '';
            $membership_type = $value['MType'] ?? '';
            $CreatedOn = !empty($value['CreatedOn']) ? $value['CreatedOn'] : date('Y-m-d H:i:s');
            $UpdateBy = $value['UpdateBy'] ?? '';
            $UpdateOn = !empty($value['UpdateOn']) ? $value['UpdateOn'] : date('Y-m-d H:i:s');
            $rate = null;//$_POST['rate'] ?? '';
            $payment_status = $value['payment_status'] ?? '';
            $payment_timestamp = $value['payment_timestamp'] ?? '';
            $stripe_return = 'succeeded';
            $transaction_id = $value['transaction_id'] ?? '';
            $paid_amount = $value['paid_amount'] ?? '';
            $stripe_product = $value['stripe_product'] ?? '';
            $donation = null;//$_POST['donation'] ?? '';
            $amount = $value['Amount'] ?? null;
            $fav_language = null;//$_POST['fav_language'] ?? '';
            $fav =  null;//$_POST['fav'] ?? '';
            $total = $value['Amount'] ?? null;
            $Child4 = null;//$_POST['Child4'] ?? '';
            $Age4 = null;//$_POST['Age4'] ?? '';
            $information = null;//$_POST['information'] ?? '';
            $GovtissueID = null;//$_POST['GovtissueID'] ?? '';
            $M_Name = null;//$_POST['M_Name'] ?? '';
            $Mob_No =  $value['Tele1'] ?? '';
            $Email2 = null;//$_POST['Email2'] ?? '';
            $password = null;//$_POST['password'] ?? '';
            $type = $value['type'] ?? null;
            $avatar = null;//$_POST['avatar'] ?? '';
            $Renew_date = null;//$_POST['Renew_date'] ?? '';
            $status = $value['status'] ?? null;
            $Payment_method = $value['PaymentOption'] ?? '';
            $Ref_Phone = null;//$_POST['Ref_Phone'] ?? '';
            $pay_date = $value['pay_date'] ?? '';
            $pay_type = $value['pay_type'] ?? '';
            $pay_for = $value['pay_for'] ?? '';
            $Active = $value['ACTIVE'] ?? '';
            $gotra = $value['Gotra'] ?? '';
            $senior = $value['Senior'] ?? '';

            // SQL-safe NULL literals for typed columns that have no value in payment flows
            $donation_sql   = ($donation   !== null && $donation   !== '') ? "'$donation'"   : 'NULL';
            $rate_sql       = ($rate       !== null && $rate       !== '') ? "'$rate'"       : 'NULL';
            $type_sql       = is_numeric($type) ? (int)$type : 1;
            $status_sql     = in_array($status, ['T', 'F', 'E'], true) ? "'$status'" : "'T'";
            $Renew_date_sql = !empty($Renew_date)                         ? "'$Renew_date'" : 'NULL';
            $Mob_No_sql     = is_numeric($Mob_No)                         ? $Mob_No         : (($Mob_No !== '' && $Mob_No !== null) ? "'$Mob_No'" : 'NULL');
            $amount_sql     = ($amount     !== null && $amount     !== '') ? "'$amount'"     : 'NULL';
            $total_sql      = ($total      !== null && $total      !== '') ? "'$total'"      : 'NULL';
            $pay_date_sql   = (!empty($pay_date) && $pay_date !== '0000-00-00') ? "'$pay_date'" : 'NULL';

			 $sql = "INSERT INTO members  VALUES ('$ID',$Member_id_sql,'$Category','$F_Name','$L_Name','$Sp_FName','$Sp_LName','$Address1','$Address2','$Address3','$City','$State','$Country','$Zip','$email','$Tele1','$Tele2','$Child1','$Age1','$Child2','$Age2','$Child3','$Age3','$Parent1','$Parent2','$remarks',$swap_sql,'$FirstSal','$SpouseSal','$membership_type','$CreatedOn','$UpdateBy','$UpdateOn',$rate_sql,'$payment_status','$payment_timestamp','$stripe_return','$transaction_id','$paid_amount','$stripe_product',$donation_sql,$amount_sql,'$fav_language','$fav',$total_sql,'$Child4','$Age4','$information','$GovtissueID','$M_Name',$Mob_No_sql,'$Email2','$password',$type_sql,'$avatar',$Renew_date_sql,$status_sql,'$Payment_method','$Ref_Phone',$pay_date_sql,'$pay_type','$pay_for','$Active','$gotra','$senior')";
             $result = array();
             $arr = $this->execute($sql);
             return $arr;
           
            }


      // end
    
    public function getMemberDetails($id) {
        GzObject::loadFiles('Model', array('Member'));
        // $CalendarModel = new CalendarModel();
        // $BookingSlotModel = new BookingSlotModel();
        // $TimePriceModel = new TimePriceModel();
        // $CustomDateModel = new CustomDateModel();
        $MemberModel = new MemberModel();

        $arr = $this->get($id);
        $opts = array();

        $opts['Member_id'] = $arr['Member_id'];
        $slots = $MemberModel->getAll($opts);

        // $arr = $this->get($id);
        // $booked_calendar = $CalendarModel->getI18n($arr['calendar_id']);

        // $arr['booked_calendar'] = $booked_calendar;

        // $language_arr = $_SESSION['lang'];
        // $language_id = $language_arr['id'];

        // $arr['calendar'] = $booked_calendar['i18n'][$language_id]['title'];

        // $opts = array();

        // $opts['booking_id'] = $arr['id'];
        // $slots = $BookingSlotModel->getAll($opts);
        // $opts = array();
        // $opts['calendar_id'] = $arr['calendar_id'];
        // $working_time = $TimePriceModel->getAll($opts, 'id');
        
        // $opts = array();
        // $opts['calendar_id'] = $arr['calendar_id'];
        // $custom_dates = $CustomDateModel->getAll($opts);

        // if (!empty($custom_dates)) {
        //     foreach ($custom_dates as $k => $v) {
        //         for($i = $v['timestamp']; $i <= $v['timestamp_end']; $i+=86400){
        //             $custom_dates[mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
        //         }
        //     }
        // }

        // $slot = array();
        
        // foreach ($slots as $k => $v) {
        //     $i = $v['timestamp'];
        //     $count = $v['count'];
            
        //     if(!empty($custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))])){
        //         $slot_lenght = $custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['slot_lenght'];
        //         $price = $custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['price'];
        //     }else{

        //         switch (date('N', $i)) {
        //             case '1':
        //                 $slot_lenght = $working_time[0]['monday_slot_lenght'];
        //                 $price = $working_time[0]['monday_price'];
        //                 break;
        //             case '2':
        //                 $slot_lenght = $working_time[0]['tuesday_slot_lenght'];
        //                 $price = $working_time[0]['tuesday_price'];
        //                 break;
        //             case '3':
        //                 $slot_lenght = $working_time[0]['wednesday_slot_lenght'];
        //                 $price = $working_time[0]['wednesday_price'];
        //                 break;
        //             case '4':
        //                 $slot_lenght = $working_time[0]['thursday_slot_lenght'];
        //                 $price = $working_time[0]['thursday_price'];
        //                 break;
        //             case '5':
        //                 $slot_lenght = $working_time[0]['friday_slot_lenght'];
        //                 $price = $working_time[0]['friday_price'];
        //                 break;
        //             case '6':
        //                 $slot_lenght = $working_time[0]['saturday_slot_lenght'];
        //                 $price = $working_time[0]['saturday_price'];
        //                 break;
        //             case '7':
        //                 $slot_lenght = $working_time[0]['sunday_slot_lenght'];
        //                 $price = $working_time[0]['sunday_price'];
        //                 break;
        //         }
        //     }

        //     $slot[] = date('F d, Y H:i', $i) . "-" . date('H:i', ($i + $slot_lenght * 60));
        // }
        //$arr['slots'] = $slot;
        return $arr;
    }
  function getNewMemberWithPayment($opts = null) {
        
        GzObject::loadFiles('Model', array('Donation'));
        $DonationModel = new DonationModel();

        $query = $this->from($this->getTable() . ' as t1');
        $query->select(null);
        $query->select('SUM(t2.Amount) as newMemberCount');
        $query->where('(Category="GM" or Category="LM") AND DATE_FORMAT(CreatedOn,"%y-%m-%d") >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), "-01-01"),"%y-%m-%d")');
        $query->leftJoin($DonationModel->getTable() . ' as t2 ON t2.Member_id = t1.Member_id');
        $query->orderBy("t1.ID DESC");
        $arr = $query->fetchAll();
        
        //echo $query->getQuery();

        return $arr;
    }
    
    //METHOD FOR UPDATE GOTRA FIELD IN MEMBER TABLE 
    function UpdateGotra($MemberId, $Gotra)
    {
        $sql = 'UPDATE ' . $this->getTable() . ' SET Gotra="' . "$Gotra" . '" WHERE Member_id="' . "$MemberId" . '"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
    }

    //Method for check email exist or not
    public function checkMobileExist()
    {
        $Tele = $_POST['Tele'] ?? '';

        //$res = 'SELECT * FROM ' . $this->getTable() . ' WHERE  Tele1="' . "$Tele" . '"';
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE REPLACE(Tele1, "-", "") = "' . $Tele . '"';
        $result = array();
        $arr = $this->execute($res);
        if (!empty($arr[0]['ID'])) {
            echo "<input  id='phone_mobile' value='true'/> ";

        } else {
            echo "<input  id='phone_mobile' value='false'/> ";
        }
    }

    //method for check tele1 exist or not
    public function checkEmailExist()
    {
        $email = $_POST['email'] ?? '';
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE  email="' . "$email" . '"';
        $result = array();
        $arr = $this->execute($res);
        if (!empty($arr[0]['ID'])) {
            echo "<input  id='email' value='true'/> ";
        } else {
            echo "<input  id='email' value='false'/> ";
        }
    }
    
    //METHOD FOR UPDATE Senior FIELD IN MEMBER TABLE 
    function UpdateSenior($MemberId, $Senior)
    {
        $sql = 'UPDATE ' . $this->getTable() . ' SET Senior="' . "$Senior" . '" WHERE Member_id="' . "$MemberId" . '"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
    }

    //Method for get senior seventy plus check
    public function GetSeniorCheck($memb_id)
    {
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE  Member_id="' . "$memb_id" . '"';
        $result = array();
        $arr = $this->execute($res);

        if (!empty($arr[0]['Senior'])) {
            return true;
        } else {
            return false;
        }
    }

}

?>
