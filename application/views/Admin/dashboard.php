

<style>
    .alert-dismissable{display:none;}
    .small-box .inner h3,
    .small-box .inner p { color: #fff !important; }
</style>
<section class="content-header">
    <h1>
        <?php echo __('dashboard'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i><?php echo __('home'); ?></a></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <?php
    require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
    ?>




<?php  if($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer())
{?>

<div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php
                        $yearold = date('Y');
                        $year = date('Y')+1;
                        date_default_timezone_set("America/Chicago");
                        if (date("m-d") < "04-01") {
                            $yearold = $yearold - 1; 
                            $year = date("Y");
                        }
                        if($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer())
                        {
                            echo "".$yearold." - ".$year." Puja Revenue ";
                        }
                        if($this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer())
                        {
                            echo "".$yearold." - ".$year." Puja Merchandise ";
                        }
                       
                        //echo date("Y") .' Puja Revenue'; 
                        
                        ?>
                    </h3>
                    
                </div>
                
    </div>

    <div class="row">
    <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
            <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>
                            <?php echo $tpl['pujaregistrant']; ?>
                        </h3>
                        <p>
                            <?php echo __('Number of Puja Registrations'); ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="<?php echo INSTALL_URL; ?>Pujaregistration/index" class="small-box-footer">
                        <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            <?php } ?>

        <!-- new tile start -->
        <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['pujarevenue']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Puja Registrations' : __('Puja Registration Revenue'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Pujaregistration&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->

          <!-- new tile start -->
          <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['pujadonationnewviewrevenue']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Puja Donations' : __('Puja Donation Revenue'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=donationdata&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->


        <!-- new tile start -->
        <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['pujasankalparevenue']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Puja Sankalpa / Hathe Khori' : __('Puja Sankalpa / Hathe Khori Revenue'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Pujaregistration&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->


         <!-- new tile start -->
         <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-teal">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['pujaparkingrevenue']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Puja Parking' : __('Paid Parking Revenue'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=parkingadmin&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->

           <!-- new tile start -->
           <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['pujaticketrevenue']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Puja Tickets' : __('Puja Ticket Revenue'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=Ticketadmin&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->


           <!-- new tile start -->
           <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['pujapassesrevenue']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Puja Passes' : __('Puja Passes Revenue'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=PujaPassesadmin&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->


          <!-- new tile start -->
          <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['pujamagazinerevenue']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Puja Magazines' : __('Puja Magazine Revenue'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=PujaMagazineadmin&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->



      

  <!-- new tile start -->
  <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['pujafoodrevenue']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Puja Food Coupons' : __('Puja Food Coupon Revenue'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=pujafoodcoupon&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <!-- new  tile end -->

        <!-- merchandise tiles -->
       
        
    </div>

<?php
}?>

</section><!-- /.content -->


<!--17 august-->
 
    <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>

        <div class="small-box bg-green">
            <div class="inner">
                <h3>
                    <?php
                    $yearold = date('Y');
                    $year = date('Y') + 1;
                    date_default_timezone_set("America/Chicago");
                    if (date("m-d") < "04-01") {
                        $yearold = $yearold - 1;
                        $year = date("Y");
                    }
                    if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) {
                        echo "" . $yearold . " - " . $year . " Puja Sponsors ";
                    }
                   

                    //echo date("Y") .' Puja Revenue'; 
                
                    ?>
                </h3>

            </div>

        </div>

        <div class="row">
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
                <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>
                                <?php echo $tpl['ltdytd']['600-999'] ?? 0; ?>
                            </h3>
                            <p>
                                <?php echo __('Silver'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="<?php echo INSTALL_URL; ?>donationdata/index" class="small-box-footer">
                            <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->
            <?php } ?>

            <!-- new tile start -->
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
                <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                <?php echo $tpl['ltdytd']['1000-1399'] ?? 0; ?>
                            </h3>
                            <p>
                                <?php echo __('Gold'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                       <a href="<?php echo INSTALL_URL; ?>donationdata/index" class="small-box-footer">
                            <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <!-- new  tile end -->

            <!-- new tile start -->
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
                <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
                                <?php echo $tpl['ltdytd']['1400-2199'] ?? 0; ?>
                            </h3>
                            <p>
                                <?php echo __('Platinum'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                       <a href="<?php echo INSTALL_URL; ?>donationdata/index" class="small-box-footer">
                            <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <!-- new  tile end -->


            <!-- new tile start -->
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
                <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                <?php echo $tpl['ltdytd']['2200-4999'] ?? 0; ?>
                            </h3>
                            <p>
                                <?php echo __('Emerald'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                        <a href="<?php echo INSTALL_URL; ?>donationdata/index" class="small-box-footer">
                            <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <!-- new  tile end -->


            <!-- new tile start -->
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
                <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3>
                                <?php echo ($tpl['totalDiamond']) ?>
                            </h3>
                            <p>
                                <?php echo __('Diamond'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                        <a href="<?php echo INSTALL_URL; ?>donationdata/index" class="small-box-footer">
                            <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            <?php } ?>


            <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
                <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3>
                                <?php echo ($tpl['totalCount']) ?>
                            </h3>
                            <p>
                                <?php echo __('Total'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                        <a href="<?php echo INSTALL_URL; ?>donationdata/index" class="small-box-footer">
                            <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <!-- new  tile end -->

            <!-- new tile start -->

            <!-- new  tile end -->

            <!-- merchandise tiles -->


        </div>

        <?php
    } ?>


<!-- new food coupon -->


 <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>

        <div class="small-box bg-green">
            <div class="inner">
                <h3>
                    <?php
                    $yearold = date('Y');
                    $year = date('Y') + 1;
                    date_default_timezone_set("America/Chicago");
                    if (date("m-d") < "04-01") {
                        $yearold = $yearold - 1;
                        $year = date("Y");
                    }
                    if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) {
                        echo "" . $yearold . " - " . $year . " Puja Food Coupon ";
                    }
                    

                    //echo date("Y") .' Puja Revenue'; 
                
                    ?>
                </h3>

            </div>

        </div>

        <div class="row">
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
                <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>
                                <?php echo $tpl['adult']; ?>
                            </h3>
                            <p>
                                <?php echo __('Adult Coupon'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="<?php echo INSTALL_URL; ?>pujafoodcoupon/index" class="small-box-footer">
                            <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->
            <?php } ?>

            <!-- new tile start -->
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
                <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                <?php echo $tpl['child']; ?>
                            </h3>
                            <p>
                                <?php echo __('Child Coupon'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                        <a href="<?php echo INSTALL_URL; ?>pujafoodcoupon/index" class="small-box-footer">
                            <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <!-- new  tile end -->

            <!-- new tile start -->
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
                <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
                                <?php echo $tpl['totalCountCoupon']; ?>
                            </h3>
                            <p>
                                <?php echo __('Total Coupon Count'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                       <a href="<?php echo INSTALL_URL; ?>pujafoodcoupon/index" class="small-box-footer">
                            <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <!-- new  tile end -->


            <!-- new tile start -->
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
                <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                <?php echo $tpl['amount']; ?>
                            </h3>
                            <p>
                                <?php echo __('Toal Amount'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                        <a href="<?php echo INSTALL_URL; ?>pujafoodcoupon/index" class="small-box-footer">
                            <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <!-- new  tile end -->


            <!-- new tile start -->
       

            <!-- new tile start -->

            <!-- new  tile end -->

            <!-- merchandise tiles -->


        </div>

        <?php
    } ?>


 

<?php 
 if($this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer() || $this->controller->isAdmin() || $this->controller->isViewer())
 { ?>
<div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php
                        $yearold = date('Y');
                        $year = date('Y')+1;
                        date_default_timezone_set("America/Chicago");
                        if (date("m-d") < "04-01") {
                            $yearold = $yearold - 1; 
                            $year = date("Y");
                        }
                        
                        if($this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer() ||$this->controller->isViewer() || $this->controller->isAdmin())
                        {
                            echo "".$yearold." - ".$year." Puja Merchandise Revenue ";
                        }
                       
                        //echo date("Y") .' Puja Revenue'; 
                        
                        ?>
                    </h3>
                    
                </div>
                
    </div>
 <?php } ?>

    <div class="row">
    

        <!-- merchandise tiles -->
        <?php if ($this->controller->isAdmin()|| $this->controller->isViewer() || $this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer() ) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo ($tpl['BeigeRedCount'][0] ?? [])['combined_total'] ; ?>
                       
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Beige-Red Punjabi Count' : __('Beige-Red Punjabi Count'); ?>
                    </p>
                </div>
                <div class="icon">
                   <!-- <i class="fa fa-dollar"></i> -->
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=pujaMerchandise&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>

        <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer() ) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                    <?php echo ($tpl['WhiteRedCount'][0] ?? [])['combined_total'] ; ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'White-Red Punjabi Count' : __('White-Red Punjabi Count'); ?>
                    </p>
                </div>
                <div class="icon">
                   <!-- <i class="fa fa-dollar"></i> -->
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=pujaMerchandise&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>

        <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer() ) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                    <?php echo ($tpl['totalPunjabiSales'][0] ?? [])['combined_total'] ; ?>
                       
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Punjabi Count' : __('Total Punjabi Count'); ?>
                    </p>
                </div>
                <div class="icon">
                   <!-- <i class="fa fa-dollar"></i> -->
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=pujaMerchandise&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>

        <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer() ) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-teal">
                <div class="inner">
                    <h3>
                    
                    <?php echo ($tpl['SareeTerracotaCount'][0] ?? [])['combined_total'] ; ?>
                       
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Saree Terracotta Count' : __('Saree Terracotta Count'); ?>
                    </p>
                </div>
                <div class="icon">
                   <!-- <i class="fa fa-dollar"></i> -->
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=pujaMerchandise&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        
        <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer() ) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                    
                    <?php echo ($tpl['SareeTusharCount'][0] ?? [])['combined_total'] ; ?>
                        
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Saree Tussar Count' : __('Saree Tussar Count'); ?>
                    </p>
                </div>
                <div class="icon">
                   <!-- <i class="fa fa-dollar"></i> -->
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=pujaMerchandise&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>

        <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer() ) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                    
                    
                    <?php echo ($tpl['totalSareeSales'][0] ?? [])['combined_total'] ; ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Saree Count' : __('Total Saree Count'); ?>
                    </p>
                </div>
                <div class="icon">
                   <!-- <i class="fa fa-dollar"></i> -->
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=pujaMerchandise&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>


        <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer() ) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                    
                    
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], ($tpl['totalPunjabiRevenue'][0] ?? [])['combined_total']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Punjabi Sale Amount' : __('Total Punjabi Sale Amount'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=pujaMerchandise&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>

        <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer() ) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                    
                    
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], ($tpl['totalSareeRevenue'][0] ?? [])['combined_total']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Saree Sale Amount' : __('Total Saree Sale Amount'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=pujaMerchandise&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>

        <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer() ) { ?>
        <div class="<?php echo ($this->controller->isAdmin()) ? "col-lg-3" : "col-lg-4"; ?> col-xs-6">
            <!-- small box -->
           <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                    
                    
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], ($tpl['TotalAmount'][0] ?? [])['total_amount']) ?>
                    </h3>
                    <p>
                        <?php echo ($this->controller->isMember()) ? 'Total Sale Amount' : __('Total Sale Amount'); ?>
                    </p>
                </div>
                <div class="icon">
                   <i class="fa fa-dollar"></i>
                </div>
                <a href="<?php echo INSTALL_URL; ?>?controller=pujaMerchandise&action=index" class="small-box-footer">
                    <?php echo __('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>

      
        
    </div>


 <!-- Custom tabs (Charts with tabs)-->
                                    
<input type="hidden" id="registration" value="<?php echo $tpl['pujarevenue']; ?>">
<input type="hidden" id="donation" value="<?php echo $tpl['pujadonationnewviewrevenue']; ?>">
<input type="hidden" id="sankalpa" value="<?php echo $tpl['pujasankalparevenue']; ?>">
<input type="hidden" id="parking" value="<?php echo $tpl['pujaparkingrevenue']; ?>">
<input type="hidden" id="tickets" value="<?php echo $tpl['pujaticketrevenue']; ?>">
<input type="hidden" id="passes" value="<?php echo $tpl['pujapassesrevenue']; ?>">
<input type="hidden" id="magazines" value="<?php echo $tpl['pujamagazinerevenue']; ?>">
<input type="hidden" id="food" value="<?php echo $tpl['pujafoodrevenue']; ?>">
<div class="row">

<?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
    <div class="col-lg-12">
        <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                        <?php 
                        //echo date("Y") .'  Puja Registrations Revenue(%)'; 
                        echo "".$yearold." - ".$year." Puja Registration System Revenue(%) ";
                        ?>
                    </h3>
                    
                </div>
                
            </div>
      <div id='myDivregi'></div>  
    </div>
    <?php } ?>

    <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isViewer()) { ?>
    <div class="col-lg-12">
        <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                        <?php 
                        //echo date("Y") .'  Associated Payments Revenue(%)'; 
                        echo "".$yearold." - ".$year." Puja Associated System Revenue(%) ";
                        ?>
                    </h3>
                    
                </div>
                
            </div>
       <div id='myDivasso'></div>        
    </div>
    <?php } ?>
</div>



<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!-- Load plotly.js into the DOM -->
 <script src="https://cdn.plot.ly/plotly-2.24.1.min.js" charset="utf-8"></script>
<script>
    
var regi = document.getElementById("registration").value;
var dona = document.getElementById("donation").value;
var sank = document.getElementById("sankalpa").value;
var park = document.getElementById("parking").value;
var tick = document.getElementById("tickets").value;
var pas = document.getElementById("passes").value;
var mag = document.getElementById("magazines").value;
var foo = document.getElementById("food").value;

const xValues = [regi, dona, sank];
const yValues = [park, tick, pas, mag, foo];

var data = [{
  type: "pie",
  values: xValues,
  labels: ["Puja Registration", "Puja Donation", "Puja Sankalpa / Hathe Khori"],
  textinfo: "label+percent",
  insidetextorientation: "radial"
}];

var data2 = [{
  type: "pie",
  values: yValues,
  labels: ["Puja Parking", "Puja Tickets", "Puja Passes", "Puja Magazines", "Puja Food Coupons"],
  textinfo: "label+percent",
  insidetextorientation: "radial"
}];

var layout = [{
  width: 700,
  height: 700
}];

var layout2 = [{
  width: 700,
  height: 700
}];

Plotly.newPlot('myDivregi', data, layout);
Plotly.newPlot('myDivasso', data2, layout2);

</script>

