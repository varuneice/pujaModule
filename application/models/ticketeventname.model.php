<?php

require_once MODELS_PATH . 'App.model.php';

class ticketeventnameModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'ticketevent_name';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'ticketevents', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'ticketprice', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'ticketStartdate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'ticketEnddate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'ticketStarttime', 'type' => 'time', 'default' => ':NULL'),
        array('name' => 'ticketEndtime', 'type' => 'time', 'default' => ':NULL'),
        array('name' => 'ticketavatar', 'type' => 'varchar', 'default' => ''),
        array('name' => 'eventtype', 'type' => 'varchar', 'default' => ''),
        array('name' => 'itemeventday', 'type' => 'varchar', 'default' => ''),
        array('name' => 'descriptionTable', 'type' => 'varchar', 'default' => '')
        
   
    );

   public  function getallticket()
    {
        $sql = 'SELECT * FROM '.$this->getTable().' ';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
    }


    // Admin grid show created event
    public function ticketEventAlldata($opts)
    {
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE eventtype ="'."PujaTicket".'" ORDER BY id DESC';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    
// end

    public function getticketevent()
    {
        $res = 'SELECT * FROM '.$this->getTable();
        $result = array();
        $arr = $this->execute($res);
        foreach ($arr as $key => $value) {
            $result[$value['id']] = $value['ticketevents'];
        }
        return $arr;
    }


    public function checkticket()
    {
        $res = 'SELECT * FROM '.$this->getTable().' WHERE ticketEnddate >= CURDATE() AND eventtype ="'."PujaTicket".'" order by ticketEnddate asc LIMIT 1';
        $result = array();
        $arr = $this->execute($res);
        $pricedata = $arr[0]['ticketevents'];
        $ticketavatar = $arr[0]['ticketavatar'];
        $descriptionTable = $arr[0]['descriptionTable'];
        $idevent = $arr[0]['id'];
    return $arr[0];
    }

    public function getticketdata($eventname)
    {
        $res = 'SELECT * FROM '.$this->getTable().' WHERE ticketevents = "'."$eventname".'"';
        $result = array();
        $arr = $this->execute($res);
        $pricedata = $arr[0]['ticketevents'];
        $ticketavatar = $arr[0]['ticketavatar'];
        $descriptionTable = $arr[0]['descriptionTable'];
        $idevent = $arr[0]['id'];
       // echo $pricedata;
        echo  "<input  id='dataprice' value='$pricedata'/> ";
        echo  "<input  id='eventid' value='$idevent'/> "; 
        echo  "<input  id='ticketimage' value='$ticketavatar'/> ";
        echo  "<input  id='descriptiontext' value='$descriptionTable'/> ";

    }


}
 ?>