<section class="content-header" style="display:none;">
    <h1>
      </h1>  
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('title_VendorPayment'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<!-- Main content -->
<section class="content">
    <div class="navbar-inner" style="display:none;">
        <ul class="nav nav-pills">
       <li class="<?php echo (($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>RentalBooking/index"><?php echo __('All Bookings'); ?></a></li>
             <li>
                <a id="search-drop-btn-id" href="#"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;<?php echo __('search'); ?></a>
            </li> 
             <li class="active" style="float: right" >
                <a  href="<?php echo INSTALL_URL; ?>RentalBooking/import">
                    <i class="fa fa-fw fa-upload"></i>
                    <?php echo __('import'); ?>
                </a>
            </li>
        </ul>
        <?php require 'component/search.php'; ?>
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" id="myTabFoodCoupons">
            <li class="active">
                <a href="#foodcoupon_tab_1"><?php echo __('Food Coupons'); ?></a>
            </li>
            <li class="">
                <a href="#foodcoupon_tab_2"><?php echo __('Food Coupons Price'); ?></a>
            </li>
            <li class="">
                <a href="#foodcoupon_tab_3"><?php echo __('Food Coupons Report'); ?></a>
            </li>
            <li class="">
                <a href="#foodcoupon_tab_4"><?php echo __('Coupon Code'); ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="foodcoupon_tab_1" class="tab-pane active">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=foodcoupon&action=deleteSelected">
                                <?php
                                require 'component/foodcoupondata_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="foodcoupon_tab_2" class="tab-pane">
               <div class="box">
                    <div class="box-body table-responsive">
                        <div id="foodcoupon_tab_2_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-2-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=foodcoupon&action=deleteSelected">
                                <?php
                                require 'component/foodcoupon_price_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="foodcoupon_tab_3" class="tab-pane">
               <div class="box">
                    <div class="box-body table-responsive">
                        <div id="foodcoupon_tab_3_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-3-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=foodcoupon&action=deleteSelected">
                                <?php
                                require 'component/foodcoupon_report_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
             <div id="foodcoupon_tab_4" class="tab-pane">
               <div class="box">
                    <div class="box-body table-responsive">
                        <div id="foodcoupon_tab_4_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-4-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=foodcoupon&action=deleteSelected">
                                <?php
                                require 'component/couponCode.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('Food Coupons')); ?>" style="display:none">
    <p><?php echo __('ARE YOU SURE YOU WANT TO DELETE'); ?></p>
</div>
<div id="record_id" style="display:none"></div>
<div id="cat_id" style="display:none"></div>
<div id="dialogDeleteSelected" title="<?php echo htmlspecialchars(__('Food Coupons')); ?>" style="display:none">
    <p><?php echo __('ARE YOU SURE YOU WANT TO DELETE'); ?></p>
</div>
<style>
.nav-tabs-custom .tab-content .tab-pane { display: none !important; }
.nav-tabs-custom .tab-content .tab-pane.active { display: block !important; }
</style>
<script>
$(document).ready(function(){
    var tabKey = 'activeTab_foodcoupon';
    var $tabContainer = $('#myTabFoodCoupons').closest('.nav-tabs-custom');

    $('#myTabFoodCoupons a').on('click', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var target = $(this).attr('href');
        $('#myTabFoodCoupons li').removeClass('active');
        $(this).closest('li').addClass('active');
        $tabContainer.find('.tab-pane').removeClass('active');
        $(target).addClass('active');
        try { localStorage.setItem(tabKey, target); } catch(ex){}
    });
    var activeTab = '';
    try { activeTab = localStorage.getItem(tabKey); } catch(ex){}
    if (activeTab && $('#myTabFoodCoupons a[href="' + activeTab + '"]').length) {
        $('#myTabFoodCoupons a[href="' + activeTab + '"]').trigger('click');
    }
});
</script>