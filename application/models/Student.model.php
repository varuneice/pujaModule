<?php

require_once MODELS_PATH . 'App.model.php';

class StudentModel extends AppModel {

    var $primaryKey = 'uid';
    var $table = 'students';
    var $schema = array(
        array('name' => 'uid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'reg_uid', 'type' => 'int', 'default' => ''),
        array('name' => 'oid', 'type' => 'int', 'default' => ''),
        array('name' => 'St_Name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'school', 'type' => 'enum', 'default' => ''),
        array('name' => 'subject', 'type' => 'varchar', 'default' => ''),
        array('name' => 'fee', 'type' => 'decimal', 'default' => ''),
        array('name' => 'session', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'remarks', 'type' => 'text', 'default' => ''),
        array('name' => 'State', 'type' => 'varchar', 'default' => ':TX'),
        array('name' => 'payment_method', 'type' => 'text', 'default' => ''),
        array('name' => 'payment_status', 'type' => 'text', 'default' => ''),
        array('name' => 'payment_timestamp', 'type' => 'text', 'default' => ''),
        array('name' => 'stripe_return', 'type' => 'text', 'default' => ''),
        array('name' => 'transaction_id', 'type' => 'text', 'default' => ''),
        array('name' => 'paid_amount', 'type' => 'text', 'default' => ''),
        array('name' => 'stripe_product', 'type' => 'text', 'default' => ''),
        array('name' => 'CreatedOn', 'type' => 'datetime', 'default' => ':NULL'),
        array('name' => 'update_on', 'type' => 'timestamp', 'default' => ':0000-00-00 00:00:00')
    );
    
    public function get($id = null) {

        if (!empty($id)) {

            return $this->from($this->getTable())->where('uid', $id)->fetch();
        }
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
       
        if (!empty($data['uid'])) {
            $query = $query->where('uid', $data['uid']);
        }

        return $query->execute();
    }

}

?>
