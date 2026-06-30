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
<table id="<?php echo (count($tpl['arr'] ?? [])) ? "tab-1-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
        <th style="display:none;"><?php echo __('ID'); ?></th>
            <th><?php echo __('Transaction Date'); ?></th>
            <th><?php echo __('Check Date'); ?></th>
            <th><?php echo __('Member ID'); ?></th>
            <th><?php echo __('Order ID'); ?></th>
            <th><?php echo __('First Name'); ?></th>
            <th><?php echo __('Last Name'); ?></th>
            <th><?php echo __('Spouse Name'); ?></th>
            <th><?php echo __('City'); ?></th>
            <th><?php echo __('State'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Mobile Number'); ?></th> 
            <th><?php echo __('Puja Type'); ?></th>
            <th><?php echo __('Registration Amount'); ?></th>
            <th><?php echo __('Senior Discount'); ?></th>
             <th><?php echo __('22+ Adult Price'); ?></th>
            <th><?php echo __('Total Amount'); ?></th>
           
            <th><?php echo __('Magazine'); ?></th>
            <th><?php echo __('Student or Out of Towner'); ?></th>
            <th><?php echo __('Membership Category'); ?></th>
            <th><?php echo __('Adult'); ?></th>
            <th><?php echo __('Child'); ?></th>
            <th><?php echo __('Total Count'); ?></th> 
            <th><?php echo __('Payment Method'); ?></th>
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
        $count = count($tpl['arr'] ?? []);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $datadesc = $tpl['arr'][$i]['id'];
               $statusactive = $tpl['arr'][$i]['status'];
                $admin = $tpl['arr'][$i]['admin_name'];
                 $adminname =  $admin;
                 $child1 = $tpl['arr'][$i]['childonefname'];
                 if($child1 !=""){
                  $studentone = '1'; 
                 }
                 else{
                    $studentone = '0'; 
                 }
                 $child2 = $tpl['arr'][$i]['childtwofname'];
                 if($child2 !=""){
                    $studenttwo = '1'; 
                   }
                   else{
                    $studenttwo = '0'; 
                 }
                 $child3 = $tpl['arr'][$i]['childthreefname'];
                 if($child3 !=""){
                    $studentthree = '1'; 
                   }
                   else{
                    $studentthree = '0'; 
                 }
                 $memberfname = $tpl['arr'][$i]['First_name'];
                 if($memberfname !=""){
                    $mainmember = '1'; 
                   }
                   else{
                    $mainmember = '0'; 
                 }
                 $spouse = $tpl['arr'][$i]['Sp_fname'];
                 if($spouse !=""){
                    $spousedata = '1'; 
                   }
                   else{
                    $spousedata = '0'; 
                 }

                 //$parentregistration = $tpl['arr'][$i]['no_of_parent'];
                 
                 $parentfname = $tpl['arr'][$i]['parent1_fname'];
                 if($parentfname !=""){
                    $parentfname = '1'; 
                   }
                   else{
                    $parentfname = '0'; 
                 }
                 $parenttwofname= $tpl['arr'][$i]['parent2_fname'];
                 if($parenttwofname !=""){
                    $parenttwofname = '1'; 
                   }
                   else{
                    $parenttwofname = '0'; 
                 }
                 
                 
                 $extraAdultMembers = (int) ($tpl['arr'][$i]['extra_adult_members'] ?? 0);
                 $adultMemberCount = (int) ($tpl['arr'][$i]['adult_member_count'] ?? 0);
                 $adultMemberPrice = $tpl['arr'][$i]['extraadultregistration'] ?? '';
                 if (($adultMemberPrice === '' || $adultMemberPrice === null) && !empty($tpl['arr'][$i]['adult1_fname'])) {
                    $adultPayload = json_decode($tpl['arr'][$i]['adult1_fname'], true);
                    if (is_array($adultPayload) && isset($adultPayload['amount']) && $adultPayload['amount'] !== '') {
                        $adultMemberPrice = $adultPayload['amount'];
                    }
                 }
                 $adultregisteration  = $mainmember + $spousedata +  $parentfname + $parenttwofname + $extraAdultMembers + $adultMemberCount;
                 $totalregistration  = $studentone + $studenttwo + $studentthree + $mainmember + $spousedata +  $parentfname + $parenttwofname + $extraAdultMembers + $adultMemberCount;
            
                $paymethod = $tpl['arr'][$i]['PaymentOption'];
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
                else if ($paymethod == "sumup") {
                    $paymentdata = 'SumUp';
                }
                else{
                     $paymentdata = '';
                }
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
                   <td><?php echo $tpl['arr'][$i]['chkdate']; ?></td>	 
                   <td><?php echo $tpl['arr'][$i]['Member_id']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['oid'] ; ?></td>
                   <td><?php echo $tpl['arr'][$i]['First_name']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['Last_name']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['Sp_fname'] .' '. $tpl['arr'][$i]['Sp_lname']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['city']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['state']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['email']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['alternatenumber']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['puja_type'] ; ?></td>
                 
                  <?php if (($tpl['arr'][$i]['amount'] == 0 &&  $tpl['arr'][$i]['totalamount'] == 0 &&  $tpl['arr'][$i]['status'] == 'confirmed' && $tpl['arr'][$i]['payment_status'] == 'confirmed'))  { ?>
                   <td ><span class="label" style="background-color:red;font-size: 15px;color: #fff;"><?php echo "Complimentary Registrations"; ?></span></td>
                  <?php
                    } else {
                    ?>
                    <td><?php echo $tpl['arr'][$i]['amount']; ?></td>
                  <?php
                      } ?>
                      
                   <td><?php echo $tpl['arr'][$i]['discountseniorprice']; ?></td>
                   
                   <td><?php echo ($adultMemberPrice !== '' && $adultMemberPrice !== null) ? $adultMemberPrice : ''; ?></td>
                   <td><?php echo $tpl['arr'][$i]['totalamount']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['magazine']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['student_or_oot']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['membercategory']; ?></td>
                    <td><?php echo $adultregisteration; ?></td>
                    <td><?php echo $studentone + $studenttwo + $studentthree; ?></td>
                    <td><?php echo $totalregistration; ?></td>
                   <td><?php echo $paymentdata; ?></td>
                   <?php if ($admin != "" || $admin != null)  { ?>
                       
                       <td><?php echo $adminname; ?></td>
               
              <?php
                          } else {
                              ?>
               <td><?php echo "User"; ?></td>
               <?php
                       } ?>
               <td><?php echo $tpl['arr'][$i]['sponsorLevel'] ?? ''; ?></td>
               <td><?php echo $tpl['arr'][$i]['greenFieldParkingDecision'] ?? ''; ?></td>
               <td>
                    <?php if ($statusactive == 'pending')  { ?>
                  <span class="label label-<?php echo $tpl['arr'][$i]['status']; ?>">
                       <?php echo $status_arr[$tpl['arr'][$i]['status']]; ?>
                  </span>
               
                  <?php } else if ($statusactive == 'Active')  { ?>
                  <span class="label" style="background-color:orange;font-size: 15px;color: #fff;"><?php echo $tpl['arr'][$i]['status']; ?></span> 
              

                   <?php } else if ($statusactive == 'confirmed')  { ?>
                   <span class="label label-<?php echo $tpl['arr'][$i]['status']; ?>">
                       <?php echo $status_arr[$tpl['arr'][$i]['status']] ?? $tpl['arr'][$i]['status']; ?>
                   </span>
                   <?php }
                  else if ($statusactive == "newdocument")  { ?>
                    <span class="label" style="background-color:orange;font-size: 15px;color: #fff;">New Document Required</span>
                  <?php }
                  else if ($statusactive == '' || $statusactive == null)  { ?>
                    <span style="background-color:red;font-size: 14px;color: #fff;" class="label label-<?php echo $tpl['arr'][$i]['status']; ?>">
                         <?php echo "Cancelled"; ?>
                    </span>
                    <?php }
                  
                   else{ ?> 
                  <span  style="background-color:red;font-size: 14px;color: #fff;"class="label label-<?php echo $tpl['arr'][$i]['status']; ?>">
                       <?php echo $status_arr[$tpl['arr'][$i]['status']] ?? $tpl['arr'][$i]['status']; ?>
                  </span>
                  <?php } ?> 
              </td>
                    <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Pujaregistration/edit/<?php echo $tpl['arr'][$i]['id']; ?>" rev="<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <?php } ?> 
                   <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor())  { ?>
                    <td><a  rev="<?php echo $tpl['arr'][$i]['id']; ?>" href=""><span></span></a></td>
                    <?php }?>
                    
                    <?php if ($this->controller->isAdmin())  { ?>
                   <td><a cat="1" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Pujaregistration/delete/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                   <?php }?> 
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
            <td colspan="9">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Pujaregistration/export"><?php echo __('export'); ?></a></li>
                        <li class="divider"></li>
                        <li><a  href="<?php echo INSTALL_URL ?>Pujaregistration/getBadgeReport"><?php echo __('Badge Report Export'); ?></li>
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
if ($('#tab-1-table-id').length > 0) {
            $('#tab-1-table-id').dataTable({
                "aaSorting": [[0, "desc"]],
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [7, 8]}
                ]
            });
        }
 </script>
