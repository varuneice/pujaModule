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
if (!empty($_POST['passes_payment'])) {
    ?>
    <section class="content left width_100"  style= "text-align: -webkit-center;">
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
          
                    $datefor = $_POST['pay_date'];
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    
                    $pujaprice = $_POST['amount'];
                    $magazineprice = $_POST['magazineprice'];
                    $seniordiscount = $_POST['discountseniorprice'];
                    $parentregistration = $_POST['extraparentregistration'];
                    $donation = $_POST['donation'];
                    ?>
                     <table border="4" width='585px'>
                                 <tr>
                                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style="margin-left:14em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                            </tr>
                                <tr>
                                <tr><td style="width:50%">Order Id</td> <td style="width:50%"><?php echo $_POST['oid'];?></td></td></tr>
                                <tr><td>Member Id</td><td><?php echo $_POST['Member_id']; ?></td></tr>
                                <tr><td>Member Name</td> <td><?php echo $_POST['membername'];?></td></td></tr>
                                <tr><td>Puja Type</td> <td><?php echo $_POST['puja_type']; ?></td></tr>
                                <tr><td>Total Amount</td> <td><span style="color:red;">$</span><?php echo $_POST['totalamount']; ?></td></tr>
                                <tr><td>Payment Method</td> <td><?php echo "Credit Card"; ?></td></tr>
                                <tr><td>Pay Date</td> <td><?php echo $payfinaldate; ?></td></tr>
                                <tr><td colspan="2" style="font-weight: bold;color:red;">An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                            </tr> 
                        </table> 
                        
                    <?php
                } else if($_POST['PaymentOption'] == 'others'){
                    $datefor = $_POST['pay_date'];
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    
                    $pujaprice = $_POST['amount'];
                    
                    ?>
                     <table border="4" width='585px' style= "margin-left:33em;" >
                                 <tr>
                                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style="margin-left:14em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                            </tr>
                                <tr>
                                <tr><td style="width:50%">Order Id</td> <td style="width:50%"><?php echo $_POST['oid'];?></td></td></tr>
                                <tr><td>Member Id</td><td><?php echo $_POST['Member_id']; ?></td></tr>
                                <tr><td>Member Name</td> <td><?php echo $_POST['membername'];?></td></td></tr>
                                <tr><td>Puja Type</td> <td><?php echo $_POST['registration_for']; ?></td></tr>
                                <tr><td>Total Amount</td> <td><span style="color:red;">$</span><?php echo $_POST['totalamount']; ?></td></tr>
                                <tr><td>Payment Method</td> <td><?php echo "Zelle"; ?></td></tr>
                                <tr><td>Pay Date</td> <td><?php echo $payfinaldate; ?></td></tr>
                                <tr><td colspan="2" style="font-weight: bold;color:red;">An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
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
        <?php echo __('Puja Paid Passes'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>PujaPassesadmin/index"><?php echo __('Puja Passes'); ?></a></li>
        <li class="active"><?php echo __('Puja Passes'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$state = $tpl['passesarr']['state']; 
$paymentstatus = $tpl['passesarr']['status'];
$registermember = $tpl['passesarr']['regmember']; 

?>
<form id="pujapasses-frm-id" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>PujaPassesadmin/payment" method="post" name="payment">
<td colspan='2'>
     <img src="<?php echo INSTALL_URL; ?>thankyouscreen.jpg" class="profile" />
     <h2  style="text-align:center;font-family:fangsong; font-size:30px;margin-top:-10px;">HDBS Puja Passes Payment</h2>
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
                                    <h3 class="box-title"><?php echo __('Information'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="registrationfor">
                                            <?php echo __('Puja Type'); ?>:
                                        </label>
                                        <input id="registrationfor" class="form-control input-sm" type="text"
                                            name="puja_type" size="25"
                                            value="<?php echo $tpl['passesarr']['puja_type']; ?>" title="Passes Type"
                                            placeholder="" required readonly >
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="category">
                                            <?php echo __('Category'); ?>:
                                        </label>
                                    <input id="category" class="form-control input-sm" type="text" name="membercategory"
                                            size="25" value="<?php echo $tpl['passesarr']['membercategory']; ?>" title="Category"
                                            placeholder="" required readonly> 
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="memberid">
                                            <?php echo __('Member Id'); ?>:
                                        </label>
                                        <input id="memberid" class="form-control input-sm" type="text" name="Member_id"
                                            size="25" value="<?php echo $tpl['passesarr']['Member_id']; ?>" title="Member Id"
                                            maxlength="10" placeholder="Member ID" required readonly>
                                    </div>
                                     <?php if ($tpl['passesarr']['schoolname'] !="" )  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="memberid">
                                            <?php echo __('University or College Name'); ?>:
                                        </label>
                                        <input id="memberid" class="form-control input-sm" type="text" name="schoolname"
                                            size="25" value="<?php echo $tpl['passesarr']['schoolname']; ?>" title="Member Id"
                                            maxlength="10" placeholder="Member ID" required readonly>
                                    </div>
                                    <?php
                                      } ?>
                                     </div>
                        <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Items'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                               
                                    <div class="form-group">
                                        <label class="control-label" for="registrationamount">
                                            <?php echo __('Puja Name, Day & Time'); ?>:
                                        </label>
                                        
                                            <input id="category" class="form-control input-sm" type="text" name="puja_type"
                                            size="25" value="<?php echo $tpl['passesarr']['puja_type']; ?>" title="passes name"
                                            placeholder="" required readonly>
                                    </div>
                                    <?php if ($tpl['passesarr']['donation'] !="" && $tpl['passesarr']['donation'] > 0)  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="donationpuja">
                                            <?php echo __('Donation Puja'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                        <input id="donationpuja" class="form-control input-sm" type="text" name="donation"
                                            size="25" value="<?php echo $tpl['passesarr']['donation']; ?>"
                                            title="<?php echo __('Donations'); ?>" placeholder="" readonly>
                                    </div>
                                    </div>
                                    <?php
                                      } ?>
                                      <?php if ($tpl['passesarr']['discountseniorprice'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="seniordiscount">
                                            <?php echo __('Senior Discount'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                        <input id="seniordiscount" class="form-control input-sm" type="text" name="discountseniorprice"
                                            size="25" value="<?php echo $tpl['passesarr']['discountseniorprice']; ?>"
                                            title="<?php echo __('Senior Discount'); ?>" placeholder="" readonly>
                                    </div>
                                      </div>
                                    <?php
                                      } ?>
                                       <?php if ($tpl['passesarr']['extraparentregistration'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="parentregistration">
                                            <?php echo __('Parent Registration'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                        <input id="parentregistration" class="form-control input-sm" type="text" name="extraparentregistration"
                                            size="25" value="<?php echo $tpl['passesarr']['extraparentregistration']; ?>"
                                            title="<?php echo __('Parent Registration'); ?>" placeholder="" readonly>
                                    </div>
                                       </div>
                                    <?php
                                      } ?>
                                       <?php if ($tpl['passesarr']['magazineprice'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="pricemagazine">
                                            <?php echo __('Additional Magazine Price'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                        <input id="pricemagazine" class="form-control input-sm" type="text" name="magazineprice"
                                            size="25" value="<?php echo $tpl['passesarr']['magazineprice']; ?>"
                                            title="<?php echo __('Additional Magazine Price'); ?>" placeholder="" readonly>
                                    </div>
                                       </div>
                                    <?php
                                      } ?>
                                    <div class="form-group">
                                        <label class="control-label" for="totalamount">
                                            <?php echo __('Total Amount'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                            <input id="totalamount" class="form-control input-sm" type="number"
                                                name="totalamount" size="25"
                                                value="<?php echo $tpl['passesarr']['totalamount']; ?>"
                                                title="<?php echo __('totalamount'); ?>" placeholder="Total Amount"
                                                readonly>
                                        </div>
                                    </div>
                               </div>
                                <!-- status div start -->
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Satus'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                          <label class="control-label" for="status">
                                                <?php echo __('Status'); ?>:
                                            </label>
                                            <!-- <select data-rule-required="true" name="status" id="status"
                                                class="form-control input-sm">
                                                <option value="">---</option>
                                                <?php
                                                $status_arr = __('status_arr');
                                                foreach ($status_arr as $k => $v) {
                                                    ?>
                                                    <option <?php echo ($tpl['passesarr']['status'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select> -->
                                            <input id="status" class="form-control input-sm" type="text"
                                                name="status" size="25"
                                                value="<?php echo $tpl['passesarr']['status']; ?>"
                                                title="<?php echo __('status'); ?>" placeholder="Status"
                                                readonly>
                                           </div>
                                            </div>
<!-- end -->
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
                                        <select data-rule-required="true" name="PaymentOption" id="payment_method" class="form-control input-sm" required>
                                            <option value="">Please Select Payment Method</option>
                                            <?php
                                $payment_method_arr = __('payment_method_arr');
                                foreach ($payment_method_arr as $k => $v) {
                                   // if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                     if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
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
                                <input type="hidden" name="passes_payment" value="1" /> 
                                    <input type="hidden" name="id" value="<?php echo $tpl['passesarr']['id']; ?>" />
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
                                            <?php echo __('Member Name'); ?>:
                                        </label>
                                        <input id="membername" class="form-control input-sm" type="text" name="membername"
                                            size="25" value="<?php echo $tpl['passesarr']['First_name']. ' ' . $tpl['passesarr']['Last_name']; ?>"
                                            title="<?php echo __('Member Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <?php if ($tpl['passesarr']['Sp_fname'] !="")  { ?>
                                <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Spouse Name'); ?>:
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="spousename"
                                            size="25" value="<?php echo $tpl['passesarr']['Sp_fname']. ' ' . $tpl['passesarr']['Sp_lname']; ?>"
                                            title="<?php echo __('Spouse Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <?php
                                      } ?>
                                       <?php if ($tpl['passesarr']['childonefname'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 1 Full Name'); ?>:
                                        </label>
                                        <input id="child1" class="form-control input-sm" type="text" name="Child1"
                                            size="25" value="<?php echo $tpl['passesarr']['childonefname']. ' ' . $tpl['passesarr']['childonelname']; ?>"
                                            title="<?php echo __('Child 1 Full Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Year of Birth Child 1'); ?>:
                                        </label>
                                        <input id="dobchild1" class="form-control input-sm" type="text" name="Age1"
                                            size="25" value="<?php echo $tpl['passesarr']['Age1']; ?>"
                                            title="<?php echo __('Year of Birth Child 1'); ?>" placeholder="" readonly>
                                    </div>
                                    <?php
                                    } ?>
                                       <?php if ($tpl['passesarr']['childtwofname'] !="")  { ?>
                                    <div class="form-group">
                                            <label class="control-label" for="status">
                                                <?php echo __('Child 2 Full Name'); ?>:
                                            </label>
                                            <input id="child2" class="form-control input-sm" type="text" name="Child2"
                                            size="25" value="<?php echo $tpl['passesarr']['childtwofname']. ' ' . $tpl['passesarr']['childtwolname']; ?>"
                                            title="<?php echo __('Child 2 Full Name'); ?>" placeholder="" readonly>
                                        </div>

                                        <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Year of Birth Child 2'); ?>:
                                        </label>
                                        <input id="dobchild2" class="form-control input-sm" type="text" name="Age2"
                                            size="25" value="<?php echo $tpl['passesarr']['Age2']; ?>"
                                            title="<?php echo __('Year of Birth Child 2'); ?>" placeholder="" readonly>
                                    </div>
                                    <?php
                                    } ?>
                                      <?php if ($tpl['passesarr']['childthreefname'] !="")  { ?>
                                        <div class="form-group">
                                            <label class="control-label" for="status">
                                                <?php echo __('Child 3 Full Name'); ?>:
                                            </label>
                                            <input id="child3" class="form-control input-sm" type="text" name="Child3"
                                            size="25" value="<?php echo $tpl['passesarr']['childthreefname']. ' ' . $tpl['passesarr']['childthreelname']; ?>"
                                            title="<?php echo __('Child 3 Full Name'); ?>" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Year of Birth Child 3'); ?>:
                                        </label>
                                        <input id="dobchild3" class="form-control input-sm" type="text" name="Age3"
                                            size="25" value="<?php echo $tpl['passesarr']['Age3']; ?>"
                                            title="<?php echo __('Year of Birth Child 3'); ?>" placeholder="" readonly>
                                    </div>
                                    <?php
                                    } ?>
                                      <?php if ($tpl['passesarr']['parent1_fname'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="parent1">
                                            <?php echo __('Parent 1 Full Name'); ?>:
                                        </label>
                                        <input id="parent1" class="form-control input-sm" type="text" name="Parent1"
                                            size="25" value="<?php echo $tpl['passesarr']['parent1_fname']. ' ' . $tpl['passesarr']['parent1_lname']; ?>"
                                            title="<?php echo __('Parent 1 Full Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <?php
                                    } ?>
                                     <?php if ($tpl['passesarr']['parent2_fname'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="parent2">
                                            <?php echo __('Parent 2 Full Name'); ?>:
                                        </label>
                                        <input id="parent2" class="form-control input-sm" type="text" name="Parent2"
                                            size="25" value="<?php echo $tpl['passesarr']['parent2_fname']. ' ' . $tpl['passesarr']['parent2_lname']; ?>"
                                            title="<?php echo __('Parent 2 Full Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <?php
                                    } ?>
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
                                            size="25" value="<?php echo $tpl['passesarr']['street']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="streetname">
                                            <?php echo __('Street Name'); ?>:
                                        </label>
                                        <input id="streetname" class="form-control input-sm" type="text" name="streetname"
                                            size="25" value="<?php echo $tpl['passesarr']['streetname']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="unit">
                                            <?php echo __('Unit'); ?>:
                                        </label>
                                        <input id="unit" class="form-control input-sm" type="text" name="unit"
                                            size="25" value="<?php echo $tpl['passesarr']['unit']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="city">
                                            <?php echo __('City'); ?>:
                                        </label>
                                        <input id="city" class="form-control input-sm" type="text" name="city" size="25"
                                            value="<?php echo $tpl['passesarr']['city']; ?>" title="<?php echo __('City'); ?>"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="state">
                                            <?php echo __('State'); ?>:
                                        </label>
                                      <input id="state" class="form-control input-sm" type="text" name="state" size="25" value="<?php echo ($tpl['arr'] ?? [])['state'] ?? ''; ?>" title="<?php echo __('State'); ?>" readonly>  
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('Zip'); ?>:
                                        </label>
                                        <input id="zip" class="form-control input-sm" type="text" name="zip" size="25"
                                            value="<?php echo $tpl['passesarr']['zip']; ?>"
                                            title="<?php echo __('Zip_Code'); ?>" placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="phone">
                                            <?php echo __('phone'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="phone"
                                            size="25" value="<?php echo $tpl['passesarr']['phone']; ?>" title="phone"
                                            maxlength="10" placeholder="### ###-####" required readonly>
                                    </div>
                                    <?php if ($tpl['passesarr']['alternatenumber'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="phone">
                                            <?php echo __('Alternate Conatct'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="tele1"
                                            size="25" value="<?php echo $tpl['passesarr']['alternatenumber']; ?>" title="Alternate Conatct"
                                            maxlength="10" placeholder="### ###-####" required readonly>
                                    </div>
                                    <?php
                                      } ?>
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('email'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="email"
                                            size="25" value="<?php echo $tpl['passesarr']['email']; ?>" title="email"
                                            placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required readonly>
                                    </div>
                                    <?php if ($tpl['passesarr']['alternateemail'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('Alternate Email'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="alternateemail"
                                            size="25" value="<?php echo $tpl['passesarr']['alternateemail']; ?>" title="Alternate Email"
                                            placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required readonly>
                                    </div>
                                    <?php
                                      } ?>
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
        //
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

    if(paystatus == 'confirmed' || paystatus == 'pending' || paystatus == null || paystatus == 'cancelled'){
      $("#paymentdropdown").hide();
      $("#payment_btn_id").hide();
      
   }
   if(paystatus == 'Active'){
    $("#paymentdropdown").show();
    $("#payment_btn_id").show();
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