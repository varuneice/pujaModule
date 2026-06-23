<?php

require_once MODELS_PATH . 'App.model.php';

class FoodCouponTotalReportModel extends AppModel
{
    
    public $table = 'CouponTotalReport';
    public $schema = array(
        array('name' => 'Type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'TotalAdultCoupon', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'TotalChildCoupon', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'TotalCoupon', 'type' => 'varchar', 'default' => ':NULL')
    );
    
}
?>