<?php

require_once MODELS_PATH . 'App.model.php';
$search = $_GET['term'] ?? '';
class ConfirmCodeModel extends AppModel
{
    public $primaryKey = 'id';
    public $table = 'confirm_code';
    public $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'date', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Confirmation', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Description', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'DonarName', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'UpdatedOn', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'paymentfrom', 'type' => 'varchar', 'default' => ':NULL')

    );
    public function getMaxAll()
    {
       // $sql = 'SELECT CONCAT(date," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().'; ';
        //$sql = 'SELECT CONCAT(DATE_FORMAT(date,"%d-%M-%Y")," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().' where UpdatedOn="0000-00-00" and `date` >= last_day(now()) + interval 1 day - interval 2 month order by date desc';
       // $sql = 'SELECT CONCAT(DATE_FORMAT(date,"%d-%M-%Y")," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().' where UpdatedOn="0000-00-00" and paymentfrom ="pujaregistration" and `date` > now() - INTERVAL 2 day order by date desc';
        $sql = 'SELECT CONCAT(DATE_FORMAT(date,"%d-%M-%Y")," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().' WHERE (UpdatedOn IS NULL OR CAST(UpdatedOn AS CHAR) = \'0000-00-00\') and paymentfrom ="pujaregistration" and DATE(`date`) >= CURDATE() - INTERVAL 7 DAY order by date desc';
        $result = array();
        $arr = $this->execute($sql);
        foreach ($arr as $key => $value) {
            $result[$value['Amount']] = $value['value'];
        }
        return $arr;
       
    }

    public function getByPaymentDate($date)
    {
        $timestamp = strtotime((string)$date);
        if ($timestamp === false) {
            return array();
        }
        $requestDate = date('Y-m-d', $timestamp);

        $pdo = $this->getPdo();
        $sql = 'SELECT CONCAT(DATE_FORMAT(date,"%d-%M-%Y")," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount
            FROM ' . $this->getTable() . '
            WHERE (UpdatedOn IS NULL OR CAST(UpdatedOn AS CHAR) = \'0000-00-00\')
            AND paymentfrom = "pujaregistration"
            AND DATE(`date`) = ?
            ORDER BY date DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($requestDate));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function UpdateCode20August($cmCode)
    {
        $code =trim($cmCode);
        date_default_timezone_set("America/Chicago");
        $Date = date("Y/m/d");
         $sql = 'UPDATE '.$this->getTable().' SET UpdatedOn="'."$Date".'" WHERE Confirmation="'."$code".'"';
        // $sql = 'SELECT CONCAT(date," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().'; ';
        $result = array();
        $arr = $this->execute($sql);
        
        return $arr;
        
    }
    
     public function UpdateCode($cmCode)
    {
        $code =trim($cmCode);
        date_default_timezone_set("America/Chicago");
        $Date = date("Y/m/d");
        //  $sql = 'UPDATE '.$this->getTable().' SET UpdatedOn="'."$Date".'" WHERE Confirmation="'."$code".'"';
        // $sql = 'SELECT CONCAT(date," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().'; ';
        $sql = 'UPDATE '.$this->getTable().' 
            SET UpdatedOn="' . $Date . '" 
            WHERE Confirmation="' . $code . '" 
            AND (UpdatedOn IS NULL OR CAST(UpdatedOn AS CHAR)="0000-00-00")';
        $result = array();
        $arr = $this->execute($sql);
        
        return $arr;
        
    }
    
    public function ConfirmCheckCode($cmCode)
    {
        $code = trim($cmCode);

        $sql = 'SELECT COUNT(*) as cnt 
            FROM ' . $this->getTable() . ' 
            WHERE Confirmation="' . $code . '" 
            AND (UpdatedOn IS NULL OR CAST(UpdatedOn AS CHAR)="0000-00-00")';

        $result = $this->execute($sql);

        if (!empty($result) && isset($result[0]['cnt']) && $result[0]['cnt'] == 1) {
            return true;   // exactly one record found
        } else {
            return false;  // either no record or more than one
        }
    }

    public function getAllcode($options = null, $column = null, $limit = null)
    {
        $query = $this->from($this->getTable() . ' as t1')->where($options);

        if (!empty($column)) {
            if (strpos($column, ' ')) {
                $query->orderBy($column);
            } else {
                $query->orderBy("`" . $column . "`");
            }
        }
        if (!empty($limit)) {
            $query->limit($limit);
        }
    }

    public function getMaxAll1()
    {
        $sql = 'SELECT CONCAT(date," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().'; ';
        $result = array();
        $arr = $this->execute($sql);
        foreach ($arr as $key => $value) {
            $result[$value['Amount']] = $value['value'];
        }
        return $arr;
        
    }
     public function getConfirmCodeCheck($code)
    {
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE Confirmation="'."$code".'"';
        $result = array();
        $arr = $this->execute($sql);
        foreach ($arr as $key => $value) {
            $result[$value['Amount']] = $value['value'];
        }
        return $arr;
        
    }

    public function update1($data = array())
    {
        foreach ($this->schema as $field) {
            if (isset($data[$field['name']])) {
                if (!is_array($data[$field['name']])) {
                    $save["`" . $field['name'] . "`"] = $data[$field['name']];
                } else {
                    if (isset($data[$field['name']][0])) {
                        $save["`" . $field['name'] . "`"] = $data[$field['name']][0];
                    }
                }
            }
        }

        $query = new UpdateQuery($this, $this->getTable());
        $query->set($save);
        $primaryKeyName = $this->getStructure()->getPrimaryKey($this->getTable());
        if (!empty($data[$primaryKeyName])) {
            $query = $query->where($primaryKeyName, $data[$primaryKeyName]);
        }

        return $query->execute();
    }
}
?>
