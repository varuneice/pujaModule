<?php

require_once MODELS_PATH . 'App.model.php';

class BadgeReportModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'badgesdata';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'MID', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'OID', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Category', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'F_Name', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'L_Name', 'type' => 'varchar', 'default' => ':NULL'),
	    array('name' => 'Sp_FName', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'City', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'State', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Country', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Zip', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Phone', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Parent2', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Parent1', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Child3', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Child2', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Child1', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Total', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Child', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Adult', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'YTD', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Magazines', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Sponsorship_Amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Sponsor', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Student', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'SeqNo', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'StudentVerified', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'PendingIssues', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Signature', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'Status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Name_Authorized', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'total_badges', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Veggies', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'createdDate', 'type' => 'date', 'default' => ':NULL')
    );
    
    function GetBadgeDetails(){
        $memberId = $_POST['MID'] ?? '';
        $current_year = date("Y");
        $Nextyear = $current_year + 1;
        if (date("m-d") < "07-01") {
            $current_year = $current_year - 1;
            $Nextyear = $current_year + 1;
        }
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE MID = "'."$memberId".'"AND createdDate >= "'."$current_year-07-01".'" AND createdDate <= "'."$Nextyear-06-30".'" ';
        $arr = $this->execute($sql);
        return $arr;
     }


}            

?>