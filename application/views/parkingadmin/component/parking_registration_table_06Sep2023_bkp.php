<style>
 @media only screen and (max-width: 499px){
		 .right-side {
              margin-left:0px!important;
             }
	}
		@media (min-width: 500px) and (max-width: 767px) {
			.right-side {
              margin-left:0px!important;
             }
		}

		@media (min-width: 768px) and (max-width: 830px) {
            .right-side {
              margin-left:0px!important;
             }
		}

		@media(min-width: 831px) and (max-width: 990px) {
			.right-side {
              margin-left:0px!important;
             }
		}
		
		.box{
    overflow-x:auto!important;
} 
#table-frm-id .dropdown-menu{
    
}
 </style>
<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['arr'])) ? "paidparking_registration_table" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
        <th style="display:none;"><?php echo __('ID'); ?></th> 
        <th><?php echo __('Date'); ?></th>
        <th><?php echo __('Member ID'); ?></th>
        <th><?php echo __('Membership Category'); ?></th>
            <th><?php echo __('Order ID'); ?></th>
            <th><?php echo __('First Name'); ?></th>
            <th><?php echo __('Last Name'); ?></th>
            <th><?php echo __('Spouse Name'); ?></th>
            <th><?php echo __('City'); ?></th>
            <th><?php echo __('State'); ?></th>
            <th><?php echo __('Puja Type'); ?></th>
            <th><?php echo __('YTD'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Mobile Number'); ?></th> 
            <th><?php echo __('Parking Spot'); ?></th>
            <th><?php echo __('Amount'); ?></th>
            <th><?php echo __('Processed By'); ?></th>
            <th><?php echo __('Status'); ?></th>    
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['arr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $statusactive = $tpl['arr'][$i]['status'];
                
                 $dataid =strtotime($tpl['arr'][$i]['id']);
                $datadesc = ksort($dataid);
                $admin = $tpl['arr'][$i]['admin_name'];
                 $adminname =  $admin;
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td style="display:none;"> <?php echo   $datadesc ?> </td>
                   <?php if($tpl['arr'][$i]['pay_date'] != ""){
                   ?>
                   <td><?php echo $tpl['arr'][$i]['pay_date']; ?></td>
                   <?php
                   }else{
                   ?>
                   <td></td>
                   <?php
                   } ?>
                    <td><?php echo $tpl['arr'][$i]['Member_id']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['membercategory']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['oid']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['First_name']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['Last_name']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['Sp_fname'] .' '. $tpl['arr'][$i]['Sp_lname']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['city']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['state']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['puja_type']; ?></td>
                     <td><?php echo $tpl['arr'][$i]['ytddata']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['email']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['alternatenumber']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['parkingfield']; ?></td>
                   <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['arr'][$i]['amount']); ?></td>
                   <?php if ($admin != "" || $admin != null)  { ?>
                       <td><?php echo $adminname; ?></td>
                        <?php
                          } else {
                              ?>
                             <td><?php echo "User"; ?></td>
                                 <?php
                           } ?>
                  
                   <td>
                        <?php if ($statusactive != 'Active' && $statusactive != 'confirmed')  { ?>
                        <span class="label label-pending"><?php echo $tpl['arr'][$i]['status']; ?></span>
                        <?php } ?> 
                        <?php if ($statusactive == 'Active' || $statusactive == 'confirmed')  { ?>
                        <span class="label label-confirmed"><?php echo $tpl['arr'][$i]['status']; ?></span> 
                        <?php } ?> 
                    </td>
                    <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>parkingadmin/edit/<?php echo $tpl['arr'][$i]['id']; ?>" rev="<?php echo $v['id']; ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                   <?php }?>
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a  rev="<?php echo $tpl['arr'][$i]['id']; ?>" href=""><span></span></a></td>
                    <?php }?>
                   <?php if ($this->controller->isAdmin())  { ?>
                   <td><a cat="1" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>parkingadmin/delete/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                   <?php } ?>
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a cat="1" rev="<?php echo $tpl['arr'][$i]['id']; ?>" href=""><span></span></a></td>
                    <?php }?>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="9">
                    <?php
                    echo __('No matching records found');
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
             <?php if ($this->controller->isAdmin())  { ?>
            <td colspan="9" >
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>parkingadmin/export"><?php echo __('export'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a href="<?php echo INSTALL_URL; ?>Member/create"><?php echo __('add_members'); ?></a></li>
                    </ul>
                </div>
            </td>
             <?php } ?> 
        </tr>
    </tfoot>
</table> 
<script>
if ($('#paidparking_registration_table').length > 0) {
            $('#paidparking_registration_table').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [1, 4]}
                ]
            });
        }
 </script>