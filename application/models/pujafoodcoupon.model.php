<?php

require_once MODELS_PATH . 'App.model.php';

class pujafoodcouponModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'pujafoodcoupon';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'member_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'oid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'F_Name', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'L_Name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'City', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'State', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Country', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Zip', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'phone', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paydate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'PaymentOption', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'coupontype', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'couponfor', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'number_of_adult_coupon', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'number_of_adult_outsourced_coupon', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'number_of_adult_special_coupon', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'number_of_kid_coupon', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'number_of_kid_outsourced_coupon', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'number_of_kid_special_coupon', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'bankname', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'checkno', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'chkdate', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'receiveby', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'pay_type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'pay_for', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'CreatedAt', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'sessionCode', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'sessionName', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'regmember', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Adult_Coupon_Req', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Kid_Coupon_Req', 'type' => 'varchar', 'default' => ':NULL') ,
          array('name' => 'childCouponInaugration', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'adultCouponInaugration', 'type' => 'varchar', 'default' => ':NULL'),
    );
    
    public function getAlldata_15_sep_2025($opts)
    {
        $current_year = date("Y");
        $Nextyear = date('Y')+1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "04-01") {
            $current_year = $current_year - 1; 
            $Nextyear = date("Y");
        }
        $res = 'SELECT * FROM '.$this->getTable().' WHERE CreatedAt >= "'."$current_year-07-01".'" AND CreatedAt < "'."$Nextyear-03-31".'"  ORDER BY id DESC';
        $result = array();
        $arr = $this->execute($res);
        return $arr;
    }
    public function getAlldata($opts)
{
    date_default_timezone_set("America/Chicago");

    $current_year = date("Y");
    $next_year = $current_year + 1;

    if (date("m-d") < "04-01") {
        $current_year = $current_year - 1; 
        $next_year = date("Y");
    }

    $start_date = "$current_year-07-01";
    $end_date = "$next_year-03-31";

    $sql = 'SELECT * FROM ' . $this->getTable() . ' 
            WHERE paydate >= "' . $start_date . '" 
              AND paydate <= "' . $end_date . '" 
              AND status = "confirmed"
            ORDER BY id DESC';

    $result = $this->execute($sql);
    return $result;
}

    
    function getCouponRecord(){
        GzObject::loadFiles('Model', array('FoodCouponSessionName'));
        $FoodCouponSessionName = new FoodCouponSessionName();
        $query = $this->from($this->getTable() . ' as t1');
        $query->select(null);
        $query->select('t1.*, t2.sessionName, t2.sessionCode as activeSessionCode, t2.Active');
        $query->where('t2.Active = "Y"');
        $query->innerJoin($FoodCouponSessionName->getTable() . ' as t2 ON (t2.sessionName = t1.couponfor OR t2.sessionName = t1.coupontype)');
        $query->orderBy("t2.id DESC");
        $arr = $query->fetchAll();
        return $arr;
    }
    
      
function getAllCouponSum()
{
    date_default_timezone_set("America/Chicago");

    $current_year = date("Y");
    $next_year = $current_year + 1;

    if (date("m-d") < "04-01") {
        $current_year = $current_year - 1;
        $next_year = date("Y");
    }

    $start_date = "$current_year-07-03";
    $end_date = "$next_year-03-31";

    $sql = "SELECT 
        SUM(
            COALESCE(NULLIF(number_of_adult_coupon, ''), '0') + 
            COALESCE(NULLIF(number_of_adult_outsourced_coupon, ''), '0') + 
            COALESCE(NULLIF(number_of_adult_special_coupon, ''), '0') + 
            COALESCE(NULLIF(adultCouponInaugration, ''), '0')
        ) AS total_adult_sum,

        SUM(
            COALESCE(NULLIF(number_of_kid_coupon, ''), '0') + 
            COALESCE(NULLIF(number_of_kid_outsourced_coupon, ''), '0') + 
            COALESCE(NULLIF(number_of_kid_special_coupon, ''), '0') + 
            COALESCE(NULLIF(childCouponInaugration, ''), '0')
        ) AS total_kid_child_sum

    FROM pujafoodcoupon
    WHERE paydate >= '$start_date' AND paydate <= '$end_date';";

    $arr = $this->execute($sql);
    return $arr;
}


function totalFoodCouponAmmount()
{
    date_default_timezone_set("America/Chicago");

    $current_year = date("Y");
    $next_year = $current_year + 1;

    if (date("m-d") < "04-01") {
        $current_year = $current_year - 1;
        $next_year = date("Y");
    }

    $start_date = "$current_year-07-03";
    $end_date = "$next_year-03-31";

    $sql = "SELECT 
        SUM(COALESCE(NULLIF(amount, ''), '0')) AS total_amount
    FROM pujafoodcoupon
    WHERE paydate >= '$start_date' AND paydate <= '$end_date';";

    $arr = $this->execute($sql);
    return $arr[0]['total_amount'];
}
    
   }            

?>
