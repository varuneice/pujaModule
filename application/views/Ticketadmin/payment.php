<style>
    .profile {
    margin-left: 50%;
    border-radius: 25%;
    transform: translate(-50%);
    filter: brightness(94%);
    padding: 10px;
    height: 166px;
}
#gz-time-slot-booking-container-id > aside > div.box-body > div{display:none;}
</style>
<?php
if (!empty($_POST['create_ticketpayment'])) {
    ?>
    <section style="text-align: -webkit-center;" class="content left width_100" >
        <div class="padding-19 nav-tabs-custom left width_100">
            <?php
            if (!empty($_SESSION['status'])) {
                ?>
                <div class="alert alert-danger in">
                    <strong><?php echo $_SESSION['status']; ?></strong>
                </div>
                <?php
                unset($_SESSION['status']);
            } else {
                if ($_POST['PaymentOption'] == 'stripe') {
                    $name = $_POST['type'];
        if($name == 'kalipuja'){
            $eventname = 'Kali Puja';
        }
        else{
            $eventname = 'Saraswati Puja';
        }
        $tickettype = $_POST['tickettype'];
        if($tickettype == 'individual'){
         $typeticket = 'Individual';
        }
        else{
          $typeticket = 'Family';
        }
        $datefor = $_POST['pay_date'];
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    ?>
                     <table border="4" width='585px'>
                                 <tr>
                                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style="margin-left:14em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                            </tr>
                                <tr>
                                <tr><td style="width:50%">Order Id</td> <td style="width:50%"><?php echo $_POST['oid'];?></td></td></tr>
                                <tr><td>Member Id</td><td><?php echo $_POST['Member_id']; ?></td></tr>
                                <tr><td>Member Name</td> <td><?php echo $_POST['name'];?></td></td></tr>
                                <tr><td>Puja Type</td> <td><?php echo $eventname; ?></td></tr>
                                <tr><td>No. of Tickets</td> <td><?php echo $_POST['item_number']; ?></td></tr>
								 <tr><td>Total Amount</td> <td><span style="color:red;">$</span><?php echo $_POST['amount'];; ?></td></tr>
                                <tr><td>Payment Method</td> <td><?php echo "Credit Card"; ?></td></tr>
                                <tr><td>Pay Date</td> <td><?php echo $payfinaldate; ?></td></tr>
                                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                            </tr> 
                        </table> 
                        
                    <?php
                } else if($_POST['PaymentOption'] == 'others'){
                    $name = $_POST['type'];
                    if($name == 'kalipuja'){
                        $eventname = 'Kali Puja';
                    }
                    else{
                        $eventname = 'Saraswati Puja';
                    }
                    $tickettype = $_POST['tickettype'];
                    if($tickettype == 'individual'){
                     $typeticket = 'Individual';
                    }
                    else{
                      $typeticket = 'Family';
                    }
                    $datefor = $_POST['pay_date'];
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    ?>
                     <table border="4" width='585px'>
                                 <tr>
                                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style="margin-left:14em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                            </tr>
                                <tr>
                                <tr><td style="width:50%">Order Id</td> <td style="width:50%"><?php echo $_POST['oid'];?></td></td></tr>
                                <tr><td>Member Id</td><td><?php echo $_POST['Member_id']; ?></td></tr>
                                <tr><td>Member Name</td> <td><?php echo $_POST['name'];?></td></td></tr>
                                <tr><td>Puja Type</td> <td><?php echo $eventname; ?></td></tr>
                                <tr><td>No. of Tickets</td> <td><?php echo $_POST['item_number']; ?></td></tr>
								<tr><td>Total Amount</td> <td><span style="color:red;">$</span><?php echo $_POST['amount'];; ?></td></tr>
                                <tr><td>Payment Method</td> <td><?php echo "Zelle"; ?></td></tr>
                                <tr><td>Pay Date</td> <td><?php echo $payfinaldate; ?></td></tr>
                                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                            </tr> 
                        </table> 
                        
                    <?php

                } else {
                    ?>
                    <div class="alert alert-success  in">
                        <i class="fa-fw fa fa-check"></i>
                        <strong><?php echo __('success'); ?></strong>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <?php
} else {
    ?>

<section class="content-header" style="display:none;">
    <h1>
        <?php echo __('Ticket Payment'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Ticketadmin/index"><?php echo __('Ticket Payment'); ?></a></li>
        <li class="active"><?php echo __('Ticket Payment'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$state = $tpl['userticketarr']['state']; 
$paymentstatus = $tpl['userticketarr']['status'];
$registermember = $tpl['userticketarr']['regmember']; 

?>
<form id="ticket-frm-id" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>Ticketadmin/payment" method="post" name="ticket_userpayment">
<td colspan='2'>
     <img src="<?php echo INSTALL_URL; ?>thankyouscreen.jpg" class="profile" />
     <h2  style="text-align:center;font-family:fangsong; font-size:30px;margin-top:-10px;">HDBS Ticket Payment</h2>
    </td> 
<div class="padding-19">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1"><?php echo __('pay_details'); ?></a>
                </li>
                 </ul>
            <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                    <fieldset>
                        <section class="col-lg-7 connectedSortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('Ticket Data'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="first_name">
                                            <?php echo __('Member Name'); ?>:
                                        </label>
                                        <input id="first_name" class="form-control input-sm" type="text"
                                            name="name" size="25" value="<?php echo $tpl['userticketarr']['name']; ?>"
                                            title="Name" placeholder="Member Name" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="first_name">
                                            <?php echo __('Puja Type'); ?>:
                                        </label>
                                        <input id="first_name" class="form-control input-sm" type="text"
                                            name="type" size="25"
                                            value="<?php echo $tpl['userticketarr']['type']; ?>" title="Puja Type"
                                            placeholder="" required readonly>
                                            
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="tickettype">
                                            <?php echo __('Ticket Type'); ?>:
                                        </label>
                                        <input id="pujadata" class="form-control input-sm" type="text" name="tickettype"
                                            size="25" value="<?php echo $tpl['userticketarr']['tickettype']; ?>" title="Ticket Type"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="phone">
                                            <?php echo __('phone'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="tele"
                                            size="25" value="<?php echo $tpl['userticketarr']['tele']; ?>" title="phone"
                                            maxlength="10" placeholder="### ###-####" onchange="checkphoneno(this.id)" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="AlternateConatct">
                                            <?php echo __('Alternate Conatct'); ?>:
                                        </label>
                                        <input id="alternateNumber" class="form-control input-sm" type="text" name="tele2"
                                            size="25" value="<?php echo $tpl['userticketarr']['tele2']; ?>" title="Alternate Number"
                                            maxlength="10" placeholder="### ###-####" required onchange="checkphoneno(this.id)" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('email'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="email"
                                            size="25" value="<?php echo $tpl['userticketarr']['email']; ?>" title="email"
                                            placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" readonly>
                                    </div>
                        </div>
                        <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Member Details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Registered in HDBS System'); ?>:
                                        </label>
                                        <!-- <input id="registeredmember" class="form-control input-sm" type="text" name="regmember"
                                            size="25" value="<?php echo $tpl['userticketarr']['regmember']; ?>"
                                            title="<?php echo __('Registered in HDBS System'); ?>" placeholder="" readonly> -->
                                         <select required="" name="regmember" id="registeredmember"
                                         class="form-control input-sm" aria-required="true" aria-invalid="false" disabled="">
                                        <option value="">Please select Member type</option>
                                        <option value="member">Yes</option>
                                        <option value="nonmember">No</option>
                                    </select>
                                    
                                        </div>
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Member Id'); ?>:
                                        </label>
                                        <input id="memberid" class="form-control input-sm" type="text" name="Member_id"
                                            size="25" value="<?php echo $tpl['userticketarr']['Member_id']; ?>"
                                            title="<?php echo __('Member Id'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                            <label class="control-label" for="status">
                                                <?php echo __('Status'); ?>:
                                            </label>
                                            <input id="status" class="form-control input-sm" type="text" name="status" size="25" value="<?php echo $tpl['userticketarr']['status']; ?>" title="<?php echo __('status'); ?>" placeholder="Status" readonly>
                                        </div>
                                    
                                </div>
                        <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Price Details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('Additional Adult'); ?>:
                                        </label>
                                        <input id="quantity" class="form-control input-sm" type="number"
                                            name="numberofadults" size="25" min="1" oninput="validity.valid||(value='');"
                                            value="<?php echo $tpl['userticketarr']['numberofadults']; ?>"
                                            title="<?php echo __('Additional Adult'); ?>" placeholder=""  onChange="ticketqunatity()" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="totalamount">
                                            <?php echo __('Total Amount'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                            <input id="total" class="form-control input-sm" type="number"
                                                name="amount" size="25"
                                                value="<?php echo $tpl['userticketarr']['amount']; ?>"
                                                title="<?php echo __('totalamount'); ?>" placeholder="Total Amount"
                                                required readonly>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group" style="display:none;">
                                    <label class="control-label" for=""><?php echo __('Zellecode'); ?>:</label>                     
                                    <input class="form-control input-sm medium" type="text" name="code" value="" id="Zellecode" />
                                 </div>
                                 
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('payment_details'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group" id="paymentdropdown">
                                        <label class="control-label" for="payment_method"><?php echo __('payment_method'); ?>:</label>
                                        <select data-rule-required="true" name="PaymentOption" id="payment_method" class="form-control input-sm" >
                                            <option value="">Please Select Payment Method</option>
                                            <?php
                                $payment_method_arr = __('payment_method_arr');
                                foreach ($payment_method_arr as $k => $v) {
                                    if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                        ?>
                                <option  value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                                    }
                                }
                                ?>
                                        </select>
                                    </div>
                                </div>
                                <table class="table">
                <tr id="stripe_details" class="tr" style="display: none;">
                        <td class="td" colspan="4">
                            <div class="form-group">
                                <label for="card-element">
                                    Credit or debit card
                                </label>
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display Element errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>            
                        
                        </td>
                    </tr>
                    <tr id="others_details" style="display: none;">
                        <td class="td" colspan="4">
                            <div class="form-group">
                                <label class="control-label"
                                    for="confirm_code"><?php echo __('confirm_code'); ?>:</label>
                                <input data-rule-required='true' id="confirm_code" class="form-control input-sm"
                                    type="text" name="confirm_code" size="25" value=""
                                    title="<?php echo __('confirm_code'); ?>"
                                    placeholder="<?php echo __('confirm_code'); ?>">
                                <div class="control-group"></div>
                                <div id="error_code"></div>
                            </div>
                        </td>
                    </tr>
                    <table class="table">
                        <td id="error_code1"></td>
                    <tr class="tr"  id="MemberID1" style="display: none;" class="form-group">
                    <label class="control-label" for="F_Name" style="color:white !important;">Payment Details:</label>
                    <!-- <td  class="td" colspan="2" class="auto-widget"> -->
                    <td class="td"><button style="display: none;float:left!important;" type="button" id="checkPaymentData" >Get Zelle Payment Details</button></td>
                    <!-- <input data-rule-required='true' id="MemberID" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>"> -->
                    <td  class="td" colspan="3"><select data-rule-required='true' id="MemberID" name="oid"  class="form-control input-sm" style="font-weight: bold;float:right!important;" >
                    <option value="">Please select your payment details</option>
                        <?php
                        foreach (($tpl['Amount'] ?? []) as $key => $value) {
                            ?>
                           
                            <option value="<?php echo $value['Amount']; ?>"><?php echo $value['Amount']; ?></option> 
                            <?php
                            //echo '<option value="'.$value['Amount'].'">'.$value['Amount']. '</option>';
                        }
                        ?>
                    </select>
                    </td>
                    <!-- </td> -->
                
                    </tr>
            </table>
                    <table class="table" id="zelledatadiv">
                        <tr>
                    <td id="error_code2"></td>
                    <!-- <td id="error_code"></td>-->
                   <td id="error_codeimg"></td>
                         </tr>
                        </table>
                            </table>
                                
                                <fieldset class="form-actions">
                                <input type="hidden" name="create_ticketpayment" value="1" /> 
                                    <input type="hidden" name="id" value="<?php echo $tpl['userticketarr']['id']; ?>" />
                                    <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                                    <td><button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save" name="Payment" tabindex="17" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Make Payment</button></td>
                                
                                </fieldset>
                                
                            </div>
                           
                            <div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key']; ?></div>
                
                        </section>
<!-- start #state -->

<section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Family Details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Spouse Name'); ?>:
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="spousename"
                                            size="25" value="<?php echo $tpl['userticketarr']['spousename']; ?>"
                                            title="<?php echo __('Spouse Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 1 Full Name'); ?>:
                                        </label>
                                        <input id="child1" class="form-control input-sm" type="text" name="Child1"
                                            size="25" value="<?php echo $tpl['userticketarr']['Child1']; ?>"
                                            title="<?php echo __('Child 1 Full Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Year of Birth Child 1'); ?>:
                                        </label>
                                        <input id="dobchild1" class="form-control input-sm" type="text" name="Age1"
                                            size="25" value="<?php echo $tpl['userticketarr']['Age1']; ?>"
                                            title="<?php echo __('Year of Birth Child 1'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                            <label class="control-label" for="status">
                                                <?php echo __('Child 2 Full Name'); ?>:
                                            </label>
                                            <input id="child2" class="form-control input-sm" type="text" name="Child2"
                                            size="25" value="<?php echo $tpl['userticketarr']['Child2']; ?>"
                                            title="<?php echo __('Child 2 Full Name'); ?>" placeholder="" readonly>
                                        </div>

                                        <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Year of Birth Child 2'); ?>:
                                        </label>
                                        <input id="dobchild2" class="form-control input-sm" type="text" name="Age2"
                                            size="25" value="<?php echo $tpl['userticketarr']['Age2']; ?>"
                                            title="<?php echo __('Year of Birth Child 2'); ?>" placeholder="" readonly>
                                    </div>
                                        <div class="form-group">
                                            <label class="control-label" for="status">
                                                <?php echo __('Child 3 Full Name'); ?>:
                                            </label>
                                            <input id="child3" class="form-control input-sm" type="text" name="Child3"
                                            size="25" value="<?php echo $tpl['userticketarr']['Child3']; ?>"
                                            title="<?php echo __('Child 3 Full Name'); ?>" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Year of Birth Child 3'); ?>:
                                        </label>
                                        <input id="dobchild3" class="form-control input-sm" type="text" name="Age3"
                                            size="25" value="<?php echo $tpl['userticketarr']['Age3']; ?>"
                                            title="<?php echo __('Year of Birth Child 3'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="parent1">
                                            <?php echo __('Parent 1 Full Name'); ?>:
                                        </label>
                                        <input id="parent1" class="form-control input-sm" type="text" name="Parent1"
                                            size="25" value="<?php echo $tpl['userticketarr']['Parent1']; ?>"
                                            title="<?php echo __('Parent 1 Full Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="parent2">
                                            <?php echo __('Parent 2 Full Name'); ?>:
                                        </label>
                                        <input id="parent2" class="form-control input-sm" type="text" name="Parent2"
                                            size="25" value="<?php echo $tpl['userticketarr']['Parent2']; ?>"
                                            title="<?php echo __('Parent 2 Full Name'); ?>" placeholder="" readonly>
                                    </div>
                                </div>
                        </section>
<!-- end -->
                        <section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('Address details'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">

                                <div class="form-group">
                                        <label class="control-label" for="street">
                                            <?php echo __('Street No'); ?>:
                                        </label>
                                        <input id="street" class="form-control input-sm" type="text" name="street"
                                            size="25" value="<?php echo $tpl['userticketarr']['street']; ?>" title="Address"
                                            placeholder="" readonly>
                                    </div>
                        
                                    <div class="form-group">
                                        <label class="control-label" for="address_1">
                                            <?php echo __('Address'); ?>:
                                        </label>
                                        <input id="address_1" class="form-control input-sm" type="text" name="address"
                                            size="25" value="<?php echo $tpl['userticketarr']['address']; ?>" title="Address"
                                            placeholder="" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="city">
                                            <?php echo __('City'); ?>:
                                        </label>
                                        <input id="city" class="form-control input-sm" type="text" name="city" size="25"
                                            value="<?php echo $tpl['userticketarr']['city']; ?>" title="<?php echo __('City'); ?>"
                                            placeholder="" readonly>
                                    </div>
                                        
                                        <div class="form-group">
                                    <label class="control-label" for="state"><?php echo __('State'); ?>:</label>
                                   <input id="state" class="form-control input-sm" type="text" name="state" size="25" value="<?php echo $tpl['userticketarr']['state']; ?>" title="<?php echo __('State'); ?>" placeholder=""> 
                                </div>
                                <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('Zip'); ?>:
                                        </label>
                                        <input id="zip" class="form-control input-sm" type="text" name="zip" size="25"
                                            value="<?php echo $tpl['userticketarr']['zip']; ?>"
                                            title="<?php echo __('Zip_Code'); ?>" placeholder="" readonly>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label" for="parentcountry">
                                            <?php echo __('Parents Base Country'); ?>:
                                        </label>
                                        <input id="zip" class="form-control input-sm" type="text" name="country" size="25"
                                            value="<?php echo $tpl['userticketarr']['country']; ?>"
                                            title="<?php echo __('Parents Base Country'); ?>" placeholder="">
                                    </div> -->
                            </div>
                        </section>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="dialogSlots" title="<?php echo __('tooltip_selected_slots'); ?>" style="display:none">
    <div name="dialogSlotsDivId" id="dialogSlotsDivId">
    </div>
</div>
<?php } ?> 
<script>
    
    $( document ).ready(function() {
        statedrop();
        paydropdown();
        checkmember();
    });
var state = <?php echo(json_encode($state)); ?>;
function statedrop(){
    if(state != null || state == "" || state == " "){
      $("#state").val(state);

   }
}

var memberregister = <?php echo (json_encode($registermember)); ?>;
    function checkmember() {

        if (memberregister != null || memberregister == "" || memberregister == " ") {
            $("#registeredmember").val(memberregister);

        }
    }
 
var paystatus = <?php echo(json_encode($paymentstatus)); ?>;
function paydropdown(){

    if(paystatus == 'confirmed' || paystatus == 'pending'){
      $("#paymentdropdown").hide();
		
   }
   if(paystatus == 'Active'){
    $("#paymentdropdown").show();
   }
}

    // function for phone no validation
    function checkphoneno(elem) {
        //
        const phonenumber = $("#phone").val();
        if (!!phonenumber) {
            if (isNaN(phonenumber)) {
                alert("Please Enter mobile Number");
                $("#payment_btn_id").addClass('disabled');
            }
            else if (phonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#payment_btn_id").addClass('disabled');
            }
            else if (phonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#payment_btn_id").addClass('disabled');
            }
            else if (phonenumber.length == 10) {
                $("#payment_btn_id").removeClass('disabled');
            }
            else {
                $("#payment_btn_id").removeClass('disabled');
            }
        }
        else {
            $("#phone").prop('required', true);
            $("#payment_btn_id").removeClass('disabled');
        }
    }


</script>