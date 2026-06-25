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
		
		/* .box{
    overflow-x:auto!important;
} */
#table-frm-id .dropdown-menu{
    
}
 </style>
<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['sankalpaarr'] ?? [])) ? "sankalpapuja-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th style="display:none;"><?php echo __('ID'); ?></th> 
            <th><?php echo __('Transaction Date'); ?></th>
            <th><?php echo __('Check Date'); ?></th>
            <th><?php echo __('Member ID'); ?></th>
            <th><?php echo __('Order ID'); ?></th>
            <th><?php echo __('Member Name'); ?></th>
            <th><?php echo __('City'); ?></th>
            <th><?php echo __('State'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Phone'); ?></th> 
            <th><?php echo __('Payment Method'); ?></th>
            <th><?php echo __('Puja Event'); ?></th> 
            <th><?php echo __('Amount'); ?></th>
            <th><?php echo __('Processed By'); ?></th>
            <th><?php echo __('Projected Sponsorship Level'); ?></th>
            <th><?php echo __('Parking'); ?></th>
            <th><?php echo __('Status'); ?></th>    
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['sankalpaarr'] ?? []);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
            $datadesc = $tpl['sankalpaarr'][$i]['id'];

               $statusactive = $tpl['sankalpaarr'][$i]['Status'];
               $admin = $tpl['sankalpaarr'][$i]['admin_name'];
                $adminname =  $admin;
                
                $paymethod = $tpl['sankalpaarr'][$i]['PaymentOption'];
                if ($paymethod == 'stripe') {
                    $paymentdata = 'Credit Card';
                } else if ($paymethod == "others") {
                    $paymentdata = 'Zelle';
                } else if ($paymethod == "cash") {
                    $paymentdata = 'Cash';
                } else if ($paymethod == "check") {
                    $paymentdata = 'Check';
                } else if ($paymethod == "directdeposit") {
                    $paymentdata = 'Direct Deposit';
                }
                else{
                     $paymentdata = '';
                }
                
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
              <td style="display:none;"> <?php echo   $datadesc ?> </td>
              <?php if($tpl['sankalpaarr'][$i]['pay_date'] != ""){
                   ?>
                   <td><?php echo $tpl['sankalpaarr'][$i]['pay_date']; ?></td>
                   <?php
                   }else{
                   ?>
                   <td></td>
                   <?php
                   } ?>
                   <td><?php echo $tpl['sankalpaarr'][$i]['chkdate']; ?></td>	 
                   <td><?php echo $tpl['sankalpaarr'][$i]['Member_id']; ?></td>
                   <td><?php echo $tpl['sankalpaarr'][$i]['oid'] ; ?></td>
                   <td><?php echo $tpl['sankalpaarr'][$i]['name']; ?></td>
                   <td><?php echo $tpl['sankalpaarr'][$i]['city']; ?></td>
                   <td><?php echo $tpl['sankalpaarr'][$i]['state']; ?></td>
                   <td><?php echo $tpl['sankalpaarr'][$i]['email']; ?></td>
                   <td><?php echo $tpl['sankalpaarr'][$i]['tele']; ?></td>
                   <td><?php echo $paymentdata; ?></td>
                   <td><?php echo $tpl['sankalpaarr'][$i]['selectedpuja']; ?></td>
                   <?php if($tpl['sankalpaarr'][$i]['item_cost'] != ""){?>
                   <td><?php echo $tpl['sankalpaarr'][$i]['item_cost']; ?></td>
                   <?php  }
                   ?>
                   <?php if($tpl['sankalpaarr'][$i]['item_cost'] == ""){?>
                   <td><?php echo 'Free Puja'; ?></td>
                   <?php  }
                   ?>
                   <?php if ($admin != "" || $admin != null)  { ?>
                       
                       <td><?php echo $adminname; ?></td>
               
              <?php
                          } else {
                              ?>
               <td><?php echo "User"; ?></td>
               <?php
                       } ?>
                    <td><?php echo $tpl['sankalpaarr'][$i]['sponsorLevel'] ?? ''; ?></td>
                    <td><?php echo $tpl['sankalpaarr'][$i]['greenFieldParkingDecision'] ?? ''; ?></td>
                    <td>
                       <?php if ($statusactive == 'pending')  { ?>
                  <span class="label label-<?php echo $tpl['sankalpaarr'][$i]['Status']; ?>">
                       <?php echo $status_arr[$tpl['sankalpaarr'][$i]['Status']]; ?>
                  </span>
               
                  <?php } else if ($statusactive == 'Active')  { ?>
                  <span class="label" style="background-color:orange;font-size: 15px;color: #fff;"><?php echo $tpl['sankalpaarr'][$i]['Status']; ?></span> 
              

                  <?php } else if ($statusactive == 'confirmed')  { ?>
                  <span class="label label-<?php echo $tpl['sankalpaarr'][$i]['Status']; ?>">
                       <?php echo $status_arr[$tpl['sankalpaarr'][$i]['Status']]; ?>
                  </span>
                  <?php }
                   else{ ?> 
                  <span  style="background-color:red;font-size: 14px;color: #fff;"class="label label-<?php echo $tpl['sankalpaarr'][$i]['Status']; ?>">
                       <?php echo $status_arr[$tpl['sankalpaarr'][$i]['Status']]; ?>
                  </span>
                  <?php } ?> 
                    </td>
                    <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Pujaregistration/sankalpaedit/<?php echo $tpl['sankalpaarr'][$i]['id']; ?>" rev="<?php echo $tpl['sankalpaarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                   <?php } ?> 
                   <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor())  { ?>
                    <td><a  rev="<?php echo $tpl['sankalpaarr'][$i]['id']; ?>" href=""><span></span></a></td>
                    <?php }?>
                  
                   <?php if ($this->controller->isAdmin())  { ?>
                   <td><a cat="3" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['sankalpaarr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Pujaregistration/delete/<?php echo $tpl['sankalpaarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                   <?php }?> 
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a cat="3" rev="<?php echo $tpl['sankalpaarr'][$i]['id']; ?>" href=""><span></span></a></td>
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
            <td colspan="9">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Pujaregistration/sankalpapujaexport"><?php echo __('export'); ?></a></li>
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
if ($('#sankalpapuja-table-id').length > 0) {
            $('#sankalpapuja-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [7, 8]}
                ]
            });
        }
 </script>
