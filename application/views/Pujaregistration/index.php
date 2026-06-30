<section class="content-header">
    <h1>
        <?php echo __('Puja Registration'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('Puja Registration'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<!-- Main content -->
<section class="content">
    <div class="navbar-inner" style="display:none;">
        <ul class="nav nav-pills">
            <li class="<?php echo (($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Pujaregistration/index"><?php echo __('all_Pujaregistration'); ?></a></li>
            <li>
                <a id="search-drop-btn-id" href="#"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;<?php echo __('search'); ?></a>
            </li>
            <!-- <li class="active" style="float: right" >
                <a  href="<?php echo INSTALL_URL; ?>Member/import">
                    <i class="fa fa-fw fa-upload"></i>
                    <?php echo __('import'); ?>
                </a>
            </li>-->
        </ul>
        <?php require 'component/search.php'; ?>
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" id="myTabPujaRegistration">
            <li class="active">
                <a data-toggle="tab" href="#puja_registration_tab_1"><?php echo __('Puja Registration'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#puja_registration_tab_2"><?php echo __('Sankalpa Puja Price'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#puja_registration_tab_3"><?php echo __('Puja Sankalpa'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#puja_registration_tab_4"><?php echo __('All Puja Price'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#puja_registration_tab_5"><?php echo __('Puja Date / Parent YTD'); ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="puja_registration_tab_1" class="tab-pane active">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Pujaregistration&action=deleteSelected">
                                <?php
                                require 'component/puja_registration_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="puja_registration_tab_2" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="puja_registration_tab_2_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Pujaregistration&action=deleteSelected">
                                <?php
                                require 'component/sankalpaprice_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="puja_registration_tab_3" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="puja_registration_tab_3_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Pujaregistration&action=deleteSelected">
                                <?php
                                require 'component/puja__sankalpa_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="puja_registration_tab_4" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="puja_registration_tab_4_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Pujaregistration&action=deleteSelected">
                                <?php
                                require 'component/puja_registrationprice_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="puja_registration_tab_5" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="puja_registration_tab_5_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Pujaregistration&action=registrationDate">
                                <?php
                                require 'component/puja_registrationdate_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('Puja Registration')); ?>" style="display:none">
    <p><?php echo __('ARE YOU SURE YOU WANT TO DELETE'); ?></p>
</div>
<div id="record_id" style="display:none"></div>
<div id="cat_id" style="display:none"></div>
<div id="dialogDeleteSelected" title="<?php echo htmlspecialchars(__('Puja Registration')); ?>" style="display:none">
    <p><?php echo __('ARE YOU SURE YOU WANT TO DELETE'); ?></p>
</div>
<style>
.nav-tabs-custom .tab-content .tab-pane { display: none !important; }
.nav-tabs-custom .tab-content .tab-pane.active { display: block !important; }
</style>
<script>
$(document).ready(function(){
    var tabKey = 'activeTab_registration';
    $('#myTabPujaRegistration a[data-toggle="tab"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $('#myTabPujaRegistration li').removeClass('active');
        $(this).closest('li').addClass('active');
        $('.tab-content .tab-pane').removeClass('active');
        $(target).addClass('active');
        try { localStorage.setItem(tabKey, target); } catch(ex){}
    });
    var activeTab = '';
    try { activeTab = localStorage.getItem(tabKey); } catch(ex){}
    if (activeTab && $('#myTabPujaRegistration a[href="' + activeTab + '"]').length) {
        $('#myTabPujaRegistration a[href="' + activeTab + '"]').trigger('click');
    }
});
</script>
