<section class="content-header">
    <h1>
        <?php echo __('Puja Donation'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('Puja Donation'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<!-- Main content -->
<section class="content">
    <div class="navbar-inner" style="display:none;">
        <ul class="nav nav-pills">
            <li class="<?php echo (($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>donationdata/index"><?php echo __('all_donation'); ?></a></li>
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
    <div class="nav-tabs-custom" id="donation-dashboard-tabs">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#tab_1"><?php echo __('Puja Donation'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_2"><?php echo __('Emerald Dashboard'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_3"><?php echo __('Diamond Dashboard'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_4"><?php echo __('Projected Diamond Sponsors'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_5"><?php echo __('Projected Emerald Sponsors'); ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="tab_1" class="tab-pane active">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=donationdata&action=deleteSelected">
                                <?php
                                require 'component/tab_1_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_2" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm2" id="table-frm-id2" method="post" action="<?php echo INSTALL_URL; ?>?controller=donationdata&action=deleteSelected">
                                <?php require 'component/emrald.php'; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_3" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="example3_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm3" id="table-frm-id3" method="post" action="<?php echo INSTALL_URL; ?>?controller=donationdata&action=deleteSelected">
                                <?php require 'component/diamond.php'; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_4" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="example4_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm4" id="table-frm-id4" method="post" action="<?php echo INSTALL_URL; ?>?controller=donationdata&action=deleteSelected">
                                <?php require 'component/projectedDiamond.php'; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_5" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="example5_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm5" id="table-frm-id5" method="post" action="<?php echo INSTALL_URL; ?>?controller=donationdata&action=deleteSelected">
                                <?php require 'component/projectedEmerald.php'; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('member')); ?>" style="display:none">
    <p><?php echo __('member_del_body'); ?></p>
</div>
<div id="record_id" style="display:none"></div>
<div id="cat_id" style="display:none"></div>
<div id="dialogDeleteSelected" title="<?php echo htmlspecialchars(__('member')); ?>" style="display:none">
    <p><?php echo __('member_del_selected_body'); ?></p>
</div>
<script>
    (function ($) {
        $(function () {
            $('#donation-dashboard-tabs .nav-tabs a[data-toggle="tab"]').on('click', function (event) {
                event.preventDefault();

                var target = $(this).attr('href');
                $('#donation-dashboard-tabs .nav-tabs li').removeClass('active');
                $(this).parent('li').addClass('active');

                $('#donation-dashboard-tabs .tab-pane').removeClass('active in').hide();
                $(target).addClass('active in').show();
            });
        });
    })(jQuery);
</script>
