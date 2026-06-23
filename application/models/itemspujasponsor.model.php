<?php

require_once MODELS_PATH . 'App.model.php';
class itemspujasponsorModel extends AppModel
{
    public $primaryKey = 'id';
    public $table = 'items_pujasponsor';
    public $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'donationid', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Member_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'eventsponsorshipcategoryA', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'eventsponsorshipcategoryB', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Freesankalpapuja', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Paydate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'pujasankalpaattempt1', 'type' => 'tinyint', 'default' => ':NULL'),
        array('name' => 'pujasankalpaattempt2', 'type' => 'tinyint', 'default' => ':NULL')
    );

    function getMaxid(){
        $sql = 'SELECT MAX(id) AS id FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['id'])){
            return $res[0]['id'];
        }else{
            return 0;
        }
    }
    


    public function SaveData($value)
    {
            $id =  $value['id'];
            $donationid = $value['donationid'];
            $Member_id = $value['memberid'];
            $eventsponsorshipcategoryA = $value['categone'];
            $eventsponsorshipcategoryB = $value['categtwo'];
            $Freesankalpapuja = $value['pujasankalpa']; 
            $Paydate_raw = $value['paydate'] ?? '';
            $Paydate_sql = (!empty($Paydate_raw) && $Paydate_raw !== '0000-00-00') ? "'$Paydate_raw'" : 'NULL';
            $attempt1_raw = $value['pujasankalpaattempt1'] ?? '';
            $attempt1_sql = is_numeric($attempt1_raw) ? (int)$attempt1_raw : 'NULL';
            $attempt2_raw = $value['pujasankalpaattempt2'] ?? '';
            $attempt2_sql = is_numeric($attempt2_raw) ? (int)$attempt2_raw : 'NULL';

             $sql = "INSERT INTO ".$this->getTable()." VALUES ('$id','$donationid','$Member_id','$eventsponsorshipcategoryA','$eventsponsorshipcategoryB','$Freesankalpapuja',$Paydate_sql,$attempt1_sql,$attempt2_sql)";
             $result = array();
             $arr = $this->execute($sql);
             return $arr;
        
    }


// function for check puja selected or not
public function registersankalpapujacheck($memberid)
{

    //$sql = 'SELECT * FROM '.$this->getTable().' WHERE  Member_id="'."$memberid".'" AND (Freesankalpapuja!="'."NULL".'" OR Freesankalpapuja="'."".'") AND year(Paydate) = year(CURDATE()) ';
    $sql = 'SELECT * FROM '.$this->getTable().' WHERE  Member_id="'."$memberid".'" AND Freesankalpapuja!="'."".'" AND year(Paydate) = year(CURDATE()) ';
   
    $result = array();
    $arr = $this->execute($sql);
    if(!empty($arr)){
        return true;
    }else{
     return false;
    }  
    
}

public function sponsorevent1check($memberid)
{

    //$sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id="'."$memberid".'" AND (eventsponsorshipcategoryA!="'."NULL".'" OR eventsponsorshipcategoryA="'."".'") AND year(Paydate) = year(CURDATE())';
    $sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id="'."$memberid".'" AND  eventsponsorshipcategoryA!="'."".'" AND year(Paydate) = year(CURDATE())';
    $result = array();
    $arr = $this->execute($sql);
    if(!empty($arr)){
        return true;
    }else{
     return false;
    }  
}
public function sponsorevent2check($memberid)
{

    $sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id="'."$memberid".'" AND  eventsponsorshipcategoryB!="'."".'" AND year(Paydate) = year(CURDATE())';
    $result = array();
    $arr = $this->execute($sql);
    if(!empty($arr)){
        return true;
    }else{
     return false;
    }  
}


public function pujasankalpaattempt1($memberid)
{

    //$sql = 'SELECT * FROM '.$this->getTable().' WHERE  Member_id="'."$memberid".'" AND (Freesankalpapuja!="'."NULL".'" OR Freesankalpapuja="'."".'") AND year(Paydate) = year(CURDATE()) ';
    $sql = 'SELECT * FROM '.$this->getTable().' WHERE  Member_id="'."$memberid".'" AND Freesankalpapuja!="'."".'"  AND pujasankalpaattempt1!="'."".'"     AND year(Paydate) = year(CURDATE()) ';
   
    $result = array();
    $arr = $this->execute($sql);
    if(!empty($arr)){
        return true;
    }else{
     return false;
    }  
    
}




public function pujasankalpaattempt2($memberid)
{
    //$sql = 'SELECT * FROM '.$this->getTable().' WHERE  Member_id="'."$memberid".'" AND (Freesankalpapuja!="'."NULL".'" OR Freesankalpapuja="'."".'") AND year(Paydate) = year(CURDATE()) ';
    $sql = 'SELECT * FROM '.$this->getTable().' WHERE  Member_id="'."$memberid".'" AND Freesankalpapuja!="'."".'"  AND pujasankalpaattempt2!="'."".'" AND year(Paydate) = year(CURDATE()) ';
   
    $result = array();
    $arr = $this->execute($sql);
    if(!empty($arr)){
        return true;
    }else{
     return false;
    }  
    
}
  
 function getSposnorRecord($opts = nul){
    GzObject::loadFiles('Model', array('Member'));
    $MemberModel = new MemberModel();
    $current_year = date("Y");
    $Nextyear = date('Y') + 1;
    date_default_timezone_set("America/Chicago");
    if (date("m-d") < "04-01") {
        $current_year = $current_year - 1; 
        $Nextyear = date("Y");
    }
    $query = $this->from($this->getTable() . ' as t1')
    ->where('Paydate >= ?', "$current_year-04-01")
    ->where('Paydate < ?', "$Nextyear-03-31")
    ->where($opts)
    ->select('t1.*, t2.F_Name, t2.M_Name, t2.L_Name')
    ->innerJoin($MemberModel->getTable() . ' as t2 ON t2.Member_id = t1.Member_id');
    $query->orderBy("t1.id DESC");
    $arr = $query->fetchAll();
    return $arr;
} 
  
    
}
?>
