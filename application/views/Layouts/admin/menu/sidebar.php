<style>
            @media only screen and (max-width: 1280px){
              .user-panel{
                margin-top: 46px; 
              }  
            }

            @media only screen and (max-width: 1160px){
                .user-panel{
                margin-top: 46px; 
              }  
               
            }
            @media only screen  and (min-width: 1282px) and (min-width : 1824px) {
                .user-panel{
                margin-top: 46px; 
              }  
            } 
            /* @media screen and (max-width: )  */

            @media only screen  and (min-width: 1825px) and (min-width : 1920px )  {
                .user-panel{
                margin-top: 46px; 
              }  
            } 
</style>


<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' . $user['avatar'])) { ?>
                    <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . $user['avatar']; ?>" />
                    <?php
                } else {
                    ?>
                    <img src="<?php echo INSTALL_URL . IMG_PATH . 'user.png'; ?>" />
                    <?php
                }
                ?>
            </div>
            <div class="pull-left info">
                <?php
                if (!empty($user['first']) && !empty($user['last'])) {
                    ?>
                    <p><?php echo $user['first'] . ' ' . $user['last']; ?></p>
                    <?php
                } else { /*
                  ?>
                  <p><?php echo $user['email']; ?></p>
                  <?php */
                }
                ?>
            </div>
        </div>
        <ul class="sidebar-menu">
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor() ||  $this->controller->isViewer()) { ?>
            <li class="<?php echo (@$_REQUEST['controller'] == 'Admin') ? "active" : ""; ?>">
                <a href="<?php echo INSTALL_URL; ?>Admin/dashboard">
                    <i class="fa fa-dashboard"></i> <span><?php echo __('dashboard'); ?></span>
                </a>
            </li>
             <?php } ?>
             <?php if ($this->controller->isAdmin()) { ?>
                <li style = "display:none;" class="treeview <?php echo (@$_REQUEST['controller'] == 'Calendar') ? "active" : ""; ?>">
                    <a href="#">
                        <i class="fa fa-fw fa-calendar"></i>
                        <span><?php echo __('calendars'); ?></span>
                        <i class="fa fa-angle-down pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php echo (@$_REQUEST['controller'] == 'Calendar' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Calendar/index"><i class="fa    fa-caret-right"></i><?php echo __('all_calendars'); ?></a></li>
                    </ul>
                </li>
                <li style = "display:none;" class="treeview <?php echo (@$_REQUEST['controller'] == 'Booking') ? "active" : ""; ?>">
                    <a href="#">
                        <i class="fa fa-fw fa-calendar-o"></i>
                        <span><?php echo __('bookings'); ?></span>
                        <i class="fa fa-angle-down pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php echo (@$_REQUEST['controller'] == 'Booking' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Booking/index"><i class="fa    fa-caret-right"></i><?php echo __('all_bookings'); ?></a></li>
                    </ul>
                </li>
               
                <?php if ($this->controller->isAdmin()) { ?>
                    <li style = "display:none;" class="<?php echo (in_array($_REQUEST['controller'], array('TimePrice'))) ? "active" : ""; ?>">
                        <a href="<?php echo INSTALL_URL; ?>TimePrice/index">
                            <i class="fa fa-fw fa-clock-o"></i>
                            <?php echo __('price_plan'); ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($this->controller->isAdmin()) { ?>
                    <li style = "display:none;" class="treeview <?php echo (@$_REQUEST['controller'] == 'User') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('users'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'User' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>User/index"><i class="fa    fa-caret-right"></i><?php echo __('all_users'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'User' && @($_REQUEST['action'] ?? '') == 'create') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>User/create"><i class="fa    fa-caret-right"></i><?php echo __('add_users'); ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
                <!-- new menu added-- -->
                <?php if ($this->controller->isAdmin()) { ?>
                    <li style = "display:none;" class="treeview <?php echo (@$_REQUEST['controller'] == 'Member') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Members'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Member' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Member/index"><i class="fa    fa-caret-right"></i><?php echo __('all_members'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Member' && @($_REQUEST['action'] ?? '') == 'create') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Member/create"><i class="fa    fa-caret-right"></i><?php echo __('add_members'); ?></a></li>
                        </ul>
                    </li>

                <?php }
                else if($this->controller->isVolunteer() || $this->controller->isParkingAdmin()) {?>
                
            <?php } else {
                ?>
                <li class="<?php echo (@$_REQUEST['controller'] == 'Member') ? "active" : ""; ?>">
                    <a href="<?php echo INSTALL_URL; ?>Member/edit/<?php echo $_SESSION[$this->controller->default_user]['ID']; ?>">
                        <i class="fa fa-fw fa-user"></i> <span><?php echo __('profile'); ?></span>
                    </a>
                </li>
                <?php }
             }
            ?>
                
               
               

                <?php if ($this->controller->isAdmin()) { ?>
                    <li style="display:none;" class="treeview <?php echo (@$_REQUEST['controller'] == 'donationdata') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Puja Donation'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'donationdata' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>donationdata/index"><i class="fa    fa-caret-right"></i><?php echo __('Donation'); ?></a></li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ($this->controller->isAdmin()) { ?>
                    <li style="display:none;" class="treeview <?php echo (@$_REQUEST['controller'] == 'PujaAdminpayment') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Puja Admin Payment'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                             <li class="<?php echo (@$_REQUEST['controller'] == 'PujaAdminpayment' && @($_REQUEST['action'] ?? '') == 'PujaAdminpayment') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>PujaAdminpayment/PujaAdminpayment"><i class="fa    fa-caret-right"></i><?php echo __('Admin Payment'); ?></a></li> 
                             <!-- <li class="<?php echo (@$_REQUEST['controller'] == 'Ticketadmin' && @($_REQUEST['action'] ?? '') == 'adminpaymentcreate') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Ticketadmin/adminpaymentcreate"><i class="fa  fa-caret-right"></i><?php echo __('Admin Payment Ticket'); ?></a></li> -->
                             
                        </ul>
                    </li>
                <?php } ?>
                <!-- Ticket menu code  start -->
                 <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isEditor() ) { ?>
                    <li style = "display:block;" class="treeview <?php echo (@$_REQUEST['controller'] == 'Ticketadmin') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Puja Ticket'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Ticketadmin' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Ticketadmin/index"><i class="fa    fa-caret-right"></i><?php echo __('View Reports'); ?></a></li>
                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'PujaTicket' && @($_REQUEST['action'] ?? '') == 'PujaTicket') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>PujaTicket/PujaTicket"><i class="fa fa-caret-right"></i><?php echo __('Process New'); ?></a></li>
                            <?php } ?> 
                            <?php if ($this->controller->isAdmin()) { ?>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Ticketadmin' && @($_REQUEST['action'] ?? '') == 'create') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Ticketadmin/create"><i class="fa  fa-caret-right"></i><?php echo __('Process New Event'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Ticketadmin' && @($_REQUEST['action'] ?? '') == 'ticketpricecreate') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Ticketadmin/ticketpricecreate"><i class="fa  fa-caret-right"></i><?php echo __('Process New Price'); ?></a></li>
                           <?php } ?> 
                        </ul>
                    </li>
                    <?php } ?> 
                <!--  end -->
           
           <?php if ($this->controller->isAdmin()|| $this->controller->isViewer() || $this->controller->isEditor()) { ?>
                    <li class="treeview <?php echo (@$_REQUEST['controller'] == 'donationdata') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Puja Donation'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'donationdata' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>donationdata/index"><i class="fa    fa-caret-right"></i><?php echo __('View Reports'); ?></a></li>
                        <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'PujaDonations' && @($_REQUEST['action'] ?? '') == 'pujadonation') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>PujaDonations/pujadonation"><i class="fa fa-caret-right"></i><?php echo __('Process New'); ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
           
            <!-- puja registration menu code  start -->
 <?php if ($this->controller->isAdmin()|| $this->controller->isViewer() || $this->controller->isEditor()) { ?>
                    <li  class="treeview <?php echo (@$_REQUEST['controller'] == 'Pujaregistration') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Puja Registration'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Pujaregistration' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Pujaregistration/index"><i class="fa    fa-caret-right"></i><?php echo __('View Reports'); ?></a></li> 
                              <?php if ($this->controller->isAdmin() || $this->controller->isEditor() ) { ?>
                             <li  style = "target= '_blank'";class="<?php echo (@$_REQUEST['controller'] == 'PujaOnlinePayments' && @($_REQUEST['action'] ?? '') == 'PujaOnlinePayments') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>PujaOnlinePayments/PujaOnlinePayments"><i class="fa    fa-caret-right"></i><?php echo __('Process New'); ?></a></li> 
                              <li class="<?php echo (@$_REQUEST['controller'] == 'PujaSankalpa' && @($_REQUEST['action'] ?? '') == 'PujaSankalpa') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa"><i class="fa fa-caret-right"></i><?php echo __('Process New Puja Sankalpa / Hathe Khori'); ?></a></li> 
                             <?php } ?> 
                             <?php if ($this->controller->isAdmin()) { ?>
                             <li class="<?php echo (@$_REQUEST['controller'] == 'Pujaregistration' && @($_REQUEST['action'] ?? '') == 'sankalpapricecreate') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Pujaregistration/sankalpapricecreate"><i class="fa fa-caret-right"></i><?php echo __('Process New Puja Sankalpa / Hathe Khori Price'); ?></a></li> 
                               <li class="<?php echo (@$_REQUEST['controller'] == 'Pujaregistration' && @($_REQUEST['action'] ?? '') == 'pujaregistrationpricecreate') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Pujaregistration/pujaregistrationpricecreate"><i class="fa fa-caret-right"></i><?php echo __('Process New Puja Price'); ?></a></li> 
                               <li class="<?php echo (@$_REQUEST['controller'] == 'PujaYtdTiers') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>PujaYtdTiers/index"><i class="fa fa-caret-right"></i><?php echo __('YTD Sponsorship Levels'); ?></a></li>
                        <?php } ?> 
                        </ul>
                        
                    </li>
                    
                    <?php } ?> 
                <!--  end -->
                
                      <!-- puja Magazine menu code  start -->
                <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isEditor() ) { ?>
                    <li style = "display:block;" class="treeview <?php echo (@$_REQUEST['controller'] == 'PujaMagazineadmin') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Puja Magazine'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'PujaMagazineadmin' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>PujaMagazineadmin/index"><i class="fa    fa-caret-right"></i><?php echo __('View Reports'); ?></a></li> 
                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                          <li class="<?php echo (@$_REQUEST['controller'] == 'PujaMagazine' && @($_REQUEST['action'] ?? '') == 'PujaMagazine') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>PujaMagazine/PujaMagazine"><i class="fa fa-caret-right"></i><?php echo __('Process New'); ?></a></li> 
                         <?php } ?> 
                          <?php if ($this->controller->isAdmin()) { ?>
                          <li class="<?php echo (@$_REQUEST['controller'] == 'PujaMagazineadmin' && @($_REQUEST['action'] ?? '') == 'pujamagazinepricecreate') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>PujaMagazineadmin/pujamagazinepricecreate"><i class="fa fa-caret-right"></i><?php echo __('Process New Price'); ?></a></li> 
                          <?php } ?> 
                        
                        </ul>

                    </li>
                    <?php } ?>  
                <!--  end -->
                
                	 <!-- puja Passes menu code  start -->
                  <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isEditor() ) { ?>
                    <li style = "display:block;" class="treeview <?php echo (@$_REQUEST['controller'] == 'PujaPassesadmin') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Puja Passes'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'PujaPassesadmin' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>">
							<a href="<?php echo INSTALL_URL; ?>PujaPassesadmin/index"><i class="fa    fa-caret-right"></i>
							<?php echo __('View Reports'); ?></a></li> 
                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'PujaPaidpasses' && @($_REQUEST['action'] ?? '') == 'PujaPaidpasses') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>PujaPaidpasses/PujaPaidpasses"><i class="fa fa-caret-right"></i><?php echo __('Process New'); ?></a></li>
                            <?php } ?> 
                            <?php if ($this->controller->isAdmin()) { ?>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'PujaPassesadmin' && @($_REQUEST['action'] ?? '') == 'pujapassespricecreate') ? "active" : ""; ?>">
							<a href="<?php echo INSTALL_URL; ?>PujaPassesadmin/pujapassespricecreate"><i class="fa fa-caret-right"></i>
							<?php echo __('Process New Price'); ?></a></li> 
							<?php } ?>
                        </ul>
                    </li>
                    <?php } ?>
                <!--  end -->
                
                <!-- Puja Food Coupons menu start -->
                
                 <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isEditor()) { ?>
                    <li style = "display:block;" class="treeview <?php echo (@$_REQUEST['controller'] == 'pujafoodcoupon') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Puja Food Coupons'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                        <li class="<?php echo (@$_REQUEST['controller'] == 'pujafoodcoupon' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>pujafoodcoupon/index"><i class="fa    fa-caret-right"></i><?php echo __('View Reports'); ?></a></li>  
                             <?php if ($this->controller->isAdmin()|| $this->controller->isEditor()) { ?>  
                            <li class="<?php echo (@$_REQUEST['controller'] == 'pujafoodcoupon' && @($_REQUEST['action'] ?? '') == 'pujafoodcoupon') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>pujafoodcoupon/pujafoodcoupon"><i class="fa    fa-caret-right"></i><?php echo __('Process New'); ?></a></li> 
                             <?php } ?> 
                        <?php if ($this->controller->isAdmin()) { ?>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'pujafoodcoupon' && @($_REQUEST['action'] ?? '') == 'foodcouponpricecreate') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>pujafoodcoupon/foodcouponpricecreate"><i class="fa    fa-caret-right"></i><?php echo __('Process New Price'); ?></a></li> 
                        <?php } ?>
                          <?php if ($this->controller->isAdmin()|| $this->controller->isEditor()) { ?>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'pujafoodcoupon' && @($_REQUEST['action'] ?? '') == 'processNewCode') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>pujafoodcoupon/processNewCode"><i class="fa    fa-caret-right"></i><?php echo __('Process New Code'); ?></a></li>
                        <?php } ?>
                        </ul>
                    </li>
                    <?php } ?> 
                
                <!-- End -->
                
                <!-- Admin Payment Menu Start -->
                 <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                    <li style="display:none;" class="treeview <?php echo (@$_REQUEST['controller'] == 'Adminpayment') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Admin Payment'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                        <li class="<?php echo (@$_REQUEST['controller'] == 'Adminpayment' && @($_REQUEST['action'] ?? '') == 'Adminpayment') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Adminpayment/Adminpayment"><i class="fa    fa-caret-right"></i><?php echo __('Admin Payment'); ?></a></li> 
                    
                            </ul>
                    </li>
                    <?php } ?>
                
                <!-- End -->
                
                
                 <!-- Paid parking registration menu code  start -->
                   <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isEditor()) { ?>
                    <li style = "display:block;" class="treeview <?php echo (@$_REQUEST['controller'] == 'parkingadmin') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Puja Benefactor'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'parkingadmin' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>parkingadmin/index"><i class="fa    fa-caret-right"></i><?php echo __('View Reports'); ?></a></li> 
                         <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                          <li class="<?php echo (@$_REQUEST['controller'] == 'PujaPaidparking' && @($_REQUEST['action'] ?? '') == 'PujaPaidparking') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>PujaPaidparking/PujaPaidparking"><i class="fa    fa-caret-right"></i><?php echo __('Process New'); ?></a></li> 
                            <?php } ?> 
                        </ul>
                    </li>
                    <?php } ?> 
                <!--  end -->




                  <!--puja mercahndise start-->


                <?php if ($this->controller->isAdmin() || $this->controller->isViewer() || $this->controller->isEditor() || $this->controller->isMerchandiseEditor() || $this->controller->isMerchandiseViewer()) { ?>
                    <li style = "display:block;" class="treeview <?php echo (@$_REQUEST['controller'] == 'pujaMerchandise') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Puja Merchandise'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                        <li class="<?php echo (@$_REQUEST['controller'] == 'pujaMerchandise' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>pujaMerchandise/index"><i class="fa    fa-caret-right"></i><?php echo __('View Reports'); ?></a></li>  
                             <?php if ($this->controller->isAdmin()|| $this->controller->isEditor() || $this->controller->isMerchandiseEditor()) { ?>  
                            <li class="<?php echo (@$_REQUEST['controller'] == 'pujaMerchandise' && @($_REQUEST['action'] ?? '') == 'pujaMerchandise') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>pujaMerchandise/pujaMerchandise"><i class="fa    fa-caret-right"></i><?php echo __('Process New'); ?></a></li> 
                             <?php } ?> 
                        <?php if ($this->controller->isAdmin()) { ?>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'pujaMerchandise' && @($_REQUEST['action'] ?? '') == 'priceLimitDate') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>pujaMerchandise/priceLimitDate"><i class="fa    fa-caret-right"></i><?php echo __('Punjabi/Saree price limit'); ?></a></li> 
                        <?php } ?>
                        </ul>
                    </li>
                    <?php } ?> 


                  <!-- End -->
                
                
             <?php if ($this->controller->isAdmin()) { ?>
                    <li style="display:block;" class="treeview <?php echo (@$_REQUEST['controller'] == 'SponsorItem') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <!-- <span><?php echo __('Event Sponsor Items'); ?></span> -->
                             <span><?php echo __('Event Sponsorship '); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                           <li class="<?php echo (@$_REQUEST['controller'] == 'SponsorItem' && @($_REQUEST['action'] ?? '') == 'SponsorshipReport') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>SponsorItem/SponsorshipReport"><i class="fa    fa-caret-right"></i><?php echo __('View Reports'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'SponsorItem' && @($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>SponsorItem/index"><i class="fa    fa-caret-right"></i><?php echo __('All Sponsor Items'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'SponsorItem' && @($_REQUEST['action'] ?? '') == 'SponsorshipItemProcess') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>SponsorItem/SponsorshipItemProcess"><i class="fa fa-caret-right"></i><?php echo __('Process New'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'SponsorItem' && @($_REQUEST['action'] ?? '') == 'sponsorcreate') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>SponsorItem/sponsorcreate"><i class="fa fa-caret-right"></i><?php echo __('Add New Item'); ?></a></li>
                           
                        </ul>
                    </li>
                <?php } ?>
            </ul>
    </section>
</aside>
