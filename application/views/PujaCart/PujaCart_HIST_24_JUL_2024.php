<style>
.puja-wrapper {text-align: center; font-family: Arial, Helvetica, sans-serif;}
.a-box-special a {box-sizing: border-box; width: 235px; text-decoration:none; padding: 20px; font-size: 16px; text-transform: uppercase; font-weight: 600; letter-spacing: 1px; cursor: pointer; border: none;}
.a-box-special { background: red;}
.a-box-special a:focus { outline: none;}
.btn_durga { background: #fff; color: #000; border: 2px solid red; border-radius: 5px;  transition: background 400ms ease-out, color 400ms ease-out; }
.btn_durga:hover { background: #000; color: #fff; border-radius: 5px; }
.layout { max-width: 100%; margin: 0 auto; display: flex; flex-flow: row wrap; justify-content: center;}
.a-box, .a-box-special { width: 280px; height: 150px; margin: 10px; display: flex; justify-content: center; align-items: center;}
.widget-content p { font-size: 20px; }
.widget-content p span { color: #ef260f; }
.tab { overflow: hidden; border: 1px solid #ccc; background-color: #f1f1f1;}
.tab button { background-color: inherit; float: left; border: none; outline: none; cursor: pointer; transition: 0.3s;  padding: 20px; font-size: 30px;}
.tab button:hover { background-color: #ddd; color: #fff; padding: 20px; font-size: 30px;}
.tab button.active { background-color: #100f0f; color: #fff; padding: 20px; font-size: 30px;}
.tabcontent { display: none; padding: 6px 12px; border: 1px solid #ccc; border-top: none;}
.page-title {position: relative; color: #ffffff; padding: 40px 0px 40px; background-position: center center; background-size: cover; background-repeat: no-repeat;}
.page-title:before {position: absolute; content: ''; left: 0px; top: 0px; width: 100%; height: 100%; display: block; background-color: rgba(0,0,0,0.80);}
.page-title .auto-container {position: relative; z-index: 1;}
.auto-container {position: static; max-width: 1200px; padding: 0px 15px; margin: 0 auto;}
.row {display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;}
.clearfix::after {display: block; clear: both; content: "";}
.page-title h1 {position: relative;font-size: 38px;line-height: 1.2em;font-weight: 700;margin-bottom: 20px;color: #ffffff;padding-left: 30px;text-transform: capitalize;}
.page-title .bread-crumb {position: relative; padding-top: 18px; text-align: right; margin-right: 30px;}
.page-title .breadcrumb-column h1 { position: relative; font-family: "Open Sans",Arial,Helvetica,Sans-Serif; font-size: 35px; font-weight: 600; margin-bottom: 20px; color: #ffffff; padding-right: 10px; text-transform: capitalize; text-align: right; border-right: 3px solid #ff5252; }
.page-title .breadcrumb-column h3 { position: relative; font-family: "Open Sans",Arial,Helvetica,Sans-Serif; font-size: 24px; font-weight: 600; margin-bottom: 20px; color: #ffffff; padding-right: 10px; text-transform: capitalize; text-align: right; border-right: 3px solid #ff5252; }
.page-title .breadcrumb-column h4 { position: relative; font-family: "Open Sans",Arial,Helvetica,Sans-Serif; font-size: 16px; font-weight: 600; margin-bottom: 20px; color: #ffffff; letter-spacing: .5px ; padding-right: 10px; text-transform: capitalize;text-align: right; border-right: 3px solid #ff5252; }
.page-title .breadcrumb-column h4 span { font-family: "Open Sans",Arial,Helvetica,Sans-Serif; color: #ff5252; }
.page-title .breadcrumb-column h4 a { font-family: "Open Sans",Arial,Helvetica,Sans-Serif; color: #ffffff; text-decoration: none; }
.page-title .bread-crumb li {position: relative; display: inline-block; line-height: 30px; margin-left: 25px; color: #ff5252; font-size: 16px; font-weight: 400;}
.page-title .bread-crumb li:first-child {margin-left: 0px;}
.page-title .bread-crumb li:first-child:before {content: '/'; position: absolute; right: -20px; top: 0px; width: 15px; color: #ffffff; text-align: center; line-height: 30px;}
.sidebar-side .sidebar {padding: 30px 25px 25px; border-radius: 5px; border: 1px solid #e1e1e1;}
.sidebar-title {position: relative; margin-bottom: 22px;}
.sidebar-title h2 {position: relative; color: #333333; font-size: 20px; font-weight: 700; text-transform: uppercase;}
.help-widget .text { position: relative; color: #777777; font-size: 16px; line-height: 1.9em; margin-bottom: 15px; }
.help-widget .list {position: relative;}
.help-widget .list li {position: relative; color: #777777; font-size: 14px; line-height: 1.9em; padding-left: 30px; margin-bottom: 8px;}
select.choice {width: 100%; padding: 14px; font-size: 24px; color: #fff; background-color: #ef260f; border-radius: 15px;}
select.choice2 {width: 100%; padding: 12px; font-size: 20px; margin-top: 20px; color: #fff; background-color: #ef260f; border-radius: 15px;}
select.choice3 {width: 100%; padding: 14px; font-size: 22px; margin-top: 0px; color: #fff; background-color: #ef260f; border-radius: 15px;}
select.year { width: 100%; padding: 14px; padding: 12px; font-size: 20px; margin-top: 20px; border-radius: 10px;}
input.MIDnumber {padding: 12px; font-size: 20px; margin-top: 3px; border-radius: 10px;}
input.MIDtext {padding: 10px; margin-top: 3px; border-radius: 10px;}
input.MIDtext2 {padding: 12px; font-size: 20px; margin-top: 20px; border-radius: 10px; width: 100%;}
input.MIDtext2readonly { padding: 12px; font-size: 20px; margin-top: 20px; background-color: gainsboro; border-radius: 10px; width: 100%;}
input.number {padding: 12px; font-size: 20px; margin-top: 20px;border-radius: 10px;}
.checkbox label {font-size: 14px; font-weight: 600; display: block; color: #ef260f; margin: 36px 0px 0px 36px!important;}
input.lookup {width: 100%; padding: 12px; font-size: 20px; border-radius: 10px;}
button.lookup_btn {padding: 5px; font-size: 21px; border-radius: 10px; width: 50%; background-color: #ef260f; color: #fff; font-weight: 600;}
h4.item_heading {font-size: 26px; font-weight: 600;}
p.item_count {color: #ef260f; font-size: 22px; font-weight: 600; border-right: 3px solid #000; text-align: right; margin: 0px 0px 0px 0px; padding: 0px 10px 0px 0px;}
p.item_count2 {text-align: right; font-weight: 600; font-size: 18px;}
p.item_heading2 {font-size: 12px; font-weight: 600;}
h4.item_heading2 {font-size: 16px; font-weight: 600;}
h5.card_details{font-size: 18px; font-weight: 600;}
h3.card_details {text-align: left; font-size: 18px; font-weight: 600; font-family: inherit;}
p.card_details { font-size: 19px; color: #ef260f;}
span.payment_for {color: #ef260f;}
button.payment_btn {padding: 10px; font-size: 20px; border-radius: 10px; width: 100%; background-color: #ef260f; color: #fff; font-weight: 600;}
button.go_cart_btn { padding: 10px; font-size: 22px; border-radius: 10px; width: 100%; background-color: #000; color: #fff; margin-top: 30px; font-weight: 600;}
.text_placeholders { position: relative; color: #ef260f; font-weight: 600; letter-spacing: 0.7px; font-size: 14px; line-height: 25px;}
.asso_pay a{ text-decoration: none; font-size: 14px; margin: 0px; line-height: 65px; font-weight: 600; text-transform: uppercase; padding: 15px 15px 15px 15px; background-color: #000; color: #fff; letter-spacing: 0.5px;}
.asso_pay a:hover { text-decoration: none; font-size: 14px; margin: 0px; line-height: 65px; font-weight: 600; text-transform: uppercase; padding: 15px 15px 15px 15px;  background-color: #ef260f; color: #fff; letter-spacing: 0.5px;}
.myDiv{display:none; padding:10px; margin-top:20px;}  
#showOne{border:1px solid red;}
#showTwo{border:1px solid green;}
#showThree{border:1px solid blue;}
input#yesMG {width: 10%;}
.clear { clear: both;}

#payment_btn {
    padding: 10px;
    font-size: 20px;
    border-radius: 10px;
    width: 100%;
    background-color: #ef260f;
    color: #fff;
    font-weight: 600;
}

/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
    
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
   
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
    
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
  .asso_pay a { text-decoration: none; font-size: 10px; margin: 0px; line-height: 45px; font-weight: 600; text-transform: uppercase; padding: 10px 10px 10px 10px; background-color: #000; color: #fff; letter-spacing: 0.5px;}
.asso_pay a:hover { text-decoration: none; font-size: 10px; margin: 0px; line-height: 45px; font-weight: 600; text-transform: uppercase; padding: 10px 10px 10px 10px;  background-color: #ef260f; color: #fff; letter-spacing: 0.5px;}
}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
.asso_pay a { text-decoration: none; font-size: 10px; margin: 0px; line-height: 45px; font-weight: 600; text-transform: uppercase; padding: 10px 10px 10px 10px; background-color: #000; color: #fff; letter-spacing: 0.5px;}
.asso_pay a:hover { text-decoration: none; font-size: 10px; margin: 0px; line-height: 45px; font-weight: 600; text-transform: uppercase; padding: 10px 10px 10px 10px;  background-color: #ef260f; color: #fff; letter-spacing: 0.5px;}
}
@media only screen and (min-width: 1400px) {
.asso_pay a{ text-decoration: none; font-size: 14px; margin: 0px; line-height: 65px; font-weight: 600; text-transform: uppercase; padding: 15px 15px 15px 15px; background-color: #000; color: #fff; letter-spacing: 0.5px;}
.asso_pay a:hover { text-decoration: none; font-size: 14px; margin: 0px; line-height: 65px; font-weight: 600; text-transform: uppercase; padding: 15px 15px 15px 15px;  background-color: #ef260f; color: #fff; letter-spacing: 0.5px;}
}
</style>
<title>Cart / Payment for Puja Registration</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-grid.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-grid.rtl.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-reboot.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-reboot.rtl.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-utilities.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-utilities.rtl.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.rtl.min.css"/>

<section class="page-title" style="background-image:url(https://durgabari.org/HDBS_Puja_Payments/12.jpg);">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Title -->
                 <div class="title-column col-lg-6 col-md-12 col-sm-12">
                    <img style="float:left;padding:20px" src="../1.svg" width="35%">
					<img style="border-radius: 96px;float: left;padding: 0px;" src="../puja_logo.png" width="37%">
                </div>
                <!--Bread Crumb -->
                <div class="breadcrumb-column col-lg-6 col-md-12 col-sm-12">
                    <h1>Houston Durga Bari Society</h1>
                    <h3>HDBS
                        <?php
                            $currentYear = date('Y');
                            $nextYear = date('Y') + 1;
                            echo "" . $currentYear . " - " . $nextYear . " Puja Online System ";
                        ?>
                    </h3>
                    <h3>Cart / Payment for Puja Registration</h3>
                   <!-- <h4><span>Contact : </span><a href="mailto:registration@durgabari.org"> registration@durgabari.org</a></h4>-->
                    <ul class="bread-crumb clearfix">
                        <li><a style="text-decoration:none;color:#fff;" href="https://durgabari.org/HDBS_Puja_Payments/onlinepujapayments/onlinepujapayments">Home</a></li>
                        <li class="active">Payment</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


<div class="container" style="position: relative;padding: 40px 0px 60px;">
<div class="row">


<div class="col-lg-8 col-md-12 col-sm-12">

<aside style="border-left: 3px solid #ef260f;border-right: 3px solid #ef260f;border-bottom: 3px solid #ef260f; padding: 15px;" class="sidebar">
<?php
$adminrole = $this->controller->isEditor();
// if($adminrole == 'true'){
//     echo "<script>alert('editorrole')</script>";
// }
       ?>

        <?php
if (isset($_POST["get_cart"])) {         
    ?>

            <div class="sidebar-widget help-widget">
                <div class="sidebar-title">
                    <h2><span style="color: #ef260f;">Cart</span> Information</h2>        
                </div>
            </div>

<form id="donation-frm-id" method="POST" action="" enctype="multipart/form-data"> 
<input type="hidden" name="create_registrationpayment" value="1"/>
 <?php
if($_POST['donation'] >= 25){ 
$donation_quantity = 1; 
}else{
$donation_quantity = 0;
}
$magazine_additional_amount = $_POST['extramagazineamount'];
?>

 <hr>
        <div class="row">
            <div class="col-md-6">
                <h4 class="item_heading">Items</h4>
            </div>
            <div class="col-md-6">
                <p class="item_count"><?php echo 1+$donation_quantity+$_POST['magazine']; ?></p>
            </div>
        </div>
        <hr>
            
            <div class="row">
            <?php if($_POST['donation']  >= 25){ ?>
            <div class="col-md-6">
                <h4 class="item_heading2">Donation : Puja</h4>
                <p class="item_heading2">Qty : <strong>1</strong></p>
            </div>
            <div class="col-md-6">
                <p class="item_count2">$<?php  echo $_POST['donation']; ?></p>
            </div>
            <hr>
            <?php } ?>
            
            
             <div class="col-md-6">
                <h4 class="item_heading2">Registration : PUJA / <?php echo $_POST['puja_type']; ?> / <?php echo $_POST['puja_category']; ?>-<?php echo $_POST['member_status']; ?></h4>
                <p class="item_heading2">Qty : <strong>1</strong></p>
            </div>
            <div class="col-md-6">
                <p class="item_count2">$<?php  echo $_POST['puja_amount']; ?></p>
            </div>
            <hr>
             <div class="col-md-6">
                <h4 class="item_heading2">Other : Magazine (Free)</h4>
                <p class="item_heading2">Qty : <strong>1</strong></p>
            </div>
            <div class="col-md-6">
                <p class="item_count2">$0</p>
            </div>
            <hr>
              <?php if($_POST['magazine'] >= 1){ ?>
              <div class="col-md-6">
                <h4 class="item_heading2">Other : Magazine(Additional)</h4>
                <p class="item_heading2">Qty : <strong><?php  echo $_POST['magazine']; ?></strong></p>
            </div>
            <div class="col-md-6">
                <p class="item_count2">$<?php echo $_POST['extramagazineamount']; ?></p>
            </div>
            <hr>
            <?php } ?>
            
              <?php if($_POST['extraparentregistration'] >= 1){ ?>
                <div class="col-md-6">
                <h4 class="item_heading2">Parent Registration Fee</h4>
                <!-- <p class="item_heading2">Qty : <strong>1</strong></p> -->
            </div>
            <div class="col-md-6">
                <p class="item_count2">$<?php  echo $_POST['extraparentregistration']; ?></p>
            </div>
            <hr>
            <?php } ?>
           
              <?php if($_POST['discountseniorprice'] >= 1){ ?>
                <div class="col-md-6">
                <h4 class="item_heading2">Senior Discount</h4>
                <p class="item_heading2">Qty : <strong>1</strong></p>
            </div>
            <div class="col-md-6">
                <p class="item_count2">$<?php  echo $_POST['discountseniorprice']; ?></p>
            </div>
            <hr>

             <?php } ?>
             <div class="col-md-6">
                <h4 class="item_heading2">Total USD</h4>
            </div>

           <div class="col-md-6">
                <p class="item_count2" id="finalprice">$<?php 
                    echo $_POST['donation']+$_POST['puja_amount'] +$_POST['extraparentregistration']+$magazine_additional_amount-$_POST['discountseniorprice']; 
                    ?>
                 </p>
            </div>  
          <hr>
          <?php if($_POST['newytdfeature']  >= 1){ ?>
            <div class="col-md-6">
                <h4 class="item_heading2">Your Future YTD will be</h4>
            </div>
            <div class="col-md-6">
                <p class="item_count2">$<?php echo $_POST['newytdfeature']; ?></p>
            </div>
        </div>
        <hr>
        <?php } ?>
        <!--<h5 class="card_details">Payment for : <span class="payment_for">Donation (non-refundable), PUJA / <?php //echo $_POST['puja_type']; ?> / <?php //echo $_POST['puja_category']; ?>-<?php //echo $_POST['member_status']; ?></span></h5>-->
        <h3 class="card_details">Payment Info : </h3>
        <p class="card_details" id="userpaymethode"></p>  
 
 <table class="table">
                        <tr class="tr">
                            <td class="td" colspan="2" style="font-size: 18px;font-weight: 600;font-family: inherit;">
                               Payment Method
                            </td>
                            <td class="td" colspan="2">

                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                            <select name="PaymentOption" id="PaymentOption" class="choice"
                            required>
                            <option value="">Please Select</option>
                            <option value="check">Check</option>
                            <option value="cash">Cash</option>
                            <option value="directdeposit">Online Deposit</option>
                            <option value="sumup">Sumup</option>
                            <option value="stripe">Credit card</option>
                            <option value="ComplimentaryRegistration">Complimentary Registrations</option>
                           <option value="others">Zelle (Preferred)</option>  
                        </select>
                        <?php } ?> 
                        <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                            <select required="" name="PaymentOption" id="PaymentOption"
                                    class="choice form-control input-sm  valid" aria-required="true" aria-invalid="false"
                                    style="width:100%;  height:50%;" tabindex="17">
                                    <option value="" class="amd">---</option>
                                    <?php
                                    $payment_method_arr = __('payment_method_arr');
                                    foreach ($payment_method_arr as $k => $v) {
                                        if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                            ?>
                                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php } ?> 

                            </td>
                        </tr>
                    </table>
                    <table class="table">
                    <tr id="stripe_details" class="tr" style="display: none;">
                            <td class="td" colspan="4">
                                <div class="form-group">
                                    <label for="card-element">
                                        Credit or debit card
                                    </label> 
                                    <div id="card-element" >
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
                        <tr class="tr"  id="MemberID1" style="display: none;" class="form-group">
                        <td id="error_code1"></td>
                        <label class="control-label" for="F_Name" style="color:rgba(237,237,237) !important;">Payment Details:</label>
                        <!-- <td  class="td" colspan="2" class="auto-widget"> -->
                        <td class="td"><button style="display: none;float:left!important;" type="button" id="checkPaymentData" >Get Zelle Payment Details</button></td>
                        <!-- <input data-rule-required='true' id="MemberID" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo _('confirm_code'); ?>" placeholder="<?php echo _('confirm_code'); ?>"> -->
                        <td  class="td" colspan="3"><select data-rule-required='true' id="MemberID" name="oid"  class="form-control input-sm" style="font-weight: bold;float:right!important;">
                        <option value="">Please select your payment details</option>
                            <?php
                            foreach ($tpl['Amount'] as $key => $value) {
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
                        <table class="table">
                        <tr>
                    <td id="error_code2"></td>
                    <!-- <td id="error_code"></td> -->
                    <td id="error_codeimg"></td>
                         </tr>
                        </table>
                                </table>
<!-- for check -->

                                <table class="table table-bordered table-hover table-striped" style="display:none" id="checkdata">
                    <thead>
                        <tr class="tr">
                            <th>Bank Name</th>
                            <th>Check No</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tr">
                            <td class="td"><input style="WIDTH: 100%;" type="text" id="checkbankname"
                                    name="checkbankname" class="form-control input-sm" value=""></td>
                            <td class="td"><input style="WIDTH: 100%;" type="text" id="checkno" name="chkno"
                                    class="form-control input-sm" value=""></td>

                            <td class="td">
                                         <input style="WIDTH: 100%;" type="number" id="checkamount" name="checkAmount"
                                            class="form-control input-sm" value=""> 
                            </td> 
<td class="td"><input style="WIDTH: 100%;" type="date" id="checkdate" name="CheckDate" class="form-control input-sm"
        value=""></td>
</tr>
</tbody>
</table>

<!-- For Cash  -->

<table class="table table-bordered table-hover table-striped" style="display:none" id="cashdata">
    <thead>
        <tr class="tr">
            <th>Processed By</th>
            <th>Amount</th>  
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input type="text" id="receiveby" name="receiveby"
                    class="form-control input-sm" value=""></td>

            <td class="td">
              <input type="number" id="cashamount" name="cashAmount" class="form-control input-sm" value="">
            </td>  
            <td class="td"><input  type="date" id="cashdate" name="cashDate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>

<!-- for direct deposite -->
<table class="table table-bordered table-hover table-striped" style="display:none" id="directdeposite">
    <thead>
        <tr class="tr">
            <th>Financial Entity</th>
            <th>Transaction Code</th>
            <th>Amount</th> 
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="bankname" name="directbank"
                    class="form-control input-sm" value=""></td>
            <td class="td"><input style="WIDTH: 100%;" type="text" id="ISFCCode" name="transactioncode"
                    class="form-control input-sm" value=""></td>

             <td class="td">
                        <input style="WIDTH: 100%;" type="number" id="directamount" name="directdepositeamount"
                            class="form-control input-sm" value="">
            </td> 
            <td class="td"><input style="WIDTH: 100%;" type="date" id="date" name="transactiondate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>

</table>
<!-- New -->
<!-- for sumup  -->
<table class="table table-bordered table-hover table-striped" style="display:none" id="Sumupdata">
    <thead>
        <tr class="tr">
        <th>Transaction Id</th>
        <th>Amount</th> 
        <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="sumdata" name="sumupid"
                    class="form-control input-sm" value=""></td>
                    <td class="td">
                        <input style="WIDTH: 100%;" type="number" id="sumupprice" name="sumupamount"
                            class="form-control input-sm" value="">
            </td>
                    <td class="td"><input style="WIDTH: 100%;" type="date" id="sumdatedate" name="sumupdate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>

                                
<input type="hidden" name="stripeToken" id="stripeToken" value="" />
<div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key']; ?></div>

<input type="hidden" name="puja_type" value="<?php echo $_POST['puja_type']; ?>"/>
<input type="hidden" name="puja_category" value="<?php echo $_POST['puja_category']; ?>"/>
<input type="hidden" name="outoftowner" value="<?php echo $_POST['outoftowner']; ?>"/>
<input type="hidden" name="student" value="<?php echo $_POST['student']; ?>"/>
<input type="hidden" name="Member_id" value="<?php echo $_POST['Member_id']; ?>"/>
<input type="hidden" name="membercategory" value="<?php echo $_POST['membercategory']; ?>"/>
<input type="hidden" name="Member_type" value="<?php echo $_POST['Member_type']; ?>"/>
<input type="hidden" name="First_name" value="<?php echo $_POST['First_name']; ?>"/>
<input type="hidden" name="Last_name" value="<?php echo $_POST['Last_name']; ?>"/>
<input type="hidden" name="member_veggie" value="<?php  echo $_POST['member_veggie']; ?>"/>
<input type="hidden" name="Sp_fname" value="<?php echo $_POST['Sp_fname'];  ?>"/>
<input type="hidden" name="Sp_lname" value="<?php echo $_POST['Sp_lname']; ?>"/>
<input type="hidden" name="spouse_veggie" value="<?php echo $_POST['spouse_veggie']; ?>"/>
<input type="hidden" name="member_optional_child" value="<?php echo $_POST['member_optional_child'];  ?>"/>
<input type="hidden" name="childonefname" value="<?php echo $_POST['childonefname'];  ?>"/>
<input type="hidden" name="childonefname" value="<?php echo $_POST['childonefname'];  ?>"/>
<input type="hidden" name="childonelname" value="<?php  echo $_POST['childonelname']; ?>"/>
<input type="hidden" name="Age1" value="<?php echo $_POST['Age1']; ?>"/>
<input type="hidden" name="childtwofname" value="<?php echo $_POST['childtwofname']; ?>"/>
<input type="hidden" name="childtwolname" value="<?php echo $_POST['childtwolname']; ?>"/>
<input type="hidden" name="Age2" value="<?php  echo $_POST['Age2']; ?>"/>
<input type="hidden" name="childthreefname" value="<?php  echo $_POST['childthreefname']; ?>"/>
<input type="hidden" name="childthreelname" value="<?php echo $_POST['childthreelname']; ?>"/>
<input type="hidden" name="Age3" value="<?php  echo $_POST['Age3']; ?>"/>
<input type="hidden" name="no_of_parent" value="<?php  echo $_POST['no_of_parent'];  ?>"/>
<input type="hidden" name="parent1_fname" value="<?php  echo $_POST['parent1_fname'];  ?>"/>
<input type="hidden" name="parent1_lname" value="<?php echo $_POST['parent1_lname']; ?>"/>
<input type="hidden" name="parent1_veggie" value="<?php echo $_POST['parent1_veggie']; ?>"/>
<input type="hidden" name="parent2_fname" value="<?php echo $_POST['parent2_fname'];  ?>"/>
<input type="hidden" name="parent2_lname" value="<?php  echo $_POST['parent2_lname'];  ?>"/>
<input type="hidden" name="parent2_veggie" value="<?php  echo $_POST['parent2_veggie'];  ?>"/>
<input type="hidden" name="Sp_fname" value="<?php  echo $_POST['Sp_fname'];  ?>"/>
<input type="hidden" name="Sp_lname" value="<?php  echo $_POST['Sp_lname']; ?>"/>
<input type="hidden" name="spouse_veggie" value="<?php echo $_POST['spouse_veggie'];  ?>"/>
<input type="hidden" name="swap_spouse" value="<?php  echo $_POST['swap_spouse'];  ?>"/>
<input type="hidden" name="street" value="<?php echo $_POST['street'];  ?>"/>
<input type="hidden" name="streetname" value="<?php echo $_POST['streetname']; ?>"/>
<input type="hidden" name="unit" value="<?php echo $_POST['unit'];  ?>"/>
<input type="hidden" name="student_or_oot" value="<?php echo $_POST['student_or_oot'];  ?>"/>
<input type="hidden" name="city" value="<?php  echo $_POST['city'];  ?>"/>
<input type="hidden" name="state" value="<?php  echo $_POST['state'];  ?>"/>
<input type="hidden" name="zip" value="<?php  echo $_POST['zip'];  ?>"/>
<input type="hidden" name="phone" value="<?php echo $_POST['phone']; ?>"/>
<input type="hidden" name="alternatenumber" value="<?php   echo $_POST['alternatenumber']; ?>"/>
<input type="hidden" name="email" value="<?php  echo $_POST['email']; ?>"/>
<input type="hidden" name="alternateemail" value="<?php  echo $_POST['alternateemail']; ?>"/>
<input type="hidden" name="senior" value="<?php  echo $_POST['senior'];  ?>"/>
<input type="hidden" name="magazine" value="<?php  echo $_POST['magazine'];  ?>"/>
<input type="hidden" name="donation" value="<?php  echo $_POST['donation']; ?>"/>
<input type="hidden" name="YTD" value="<?php  echo $_POST['YTD']; ?>"/>
<input type="hidden" name="newytd" value="<?php  echo $_POST['newytdfeature']; ?>"/>
<input type="hidden" name="totalamount" value="<?php  echo $_POST['totalamount'] ?>"/>
<input type="hidden" name="magazineamount" value="<?php  echo $_POST['magazineamount'] ?>"/>

<!-- //for puja price & puja name  -->
<input type="hidden" name="amount" value="<?php  echo $_POST['puja_amount'] ?>"/>
<input type="hidden" name="member_status" value="<?php  echo $_POST['member_status'];  ?>"/>
<input type="hidden" name="discountseniorprice" value="<?php  echo $_POST['discountseniorprice']; ?>"/>
<input type="hidden" name="extraparentregistration" value="<?php  echo $_POST['extraparentregistration']; ?>"/>
<input type="hidden" name="magazineprice" value="<?php  echo $_POST['extramagazineamount']; ?>"/>
<input id="Zellecode" class="form-control input-sm" type="text" name="code" style="display:none;"> 


<button type="submit" id="payment_btn" class="btn btn-primary" >Make Payment</button>
        <br><br>
</form> 
<?php
} else {    
    echo "<h2><center>Cart is Empty!</center><h2>";
}
?>
               
        </aside>

  </div>

    <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
        
        <aside class="sidebar">


        <!-- Help Widget -->
                        
            <div class="sidebar-widget help-widget">

<div class="row">
    <div class="col-md-6 asso_pay">
        <a href="#" onclick="window.history.go(-1); return false;">Go Back</a>
    </div>
    <!--<div class="col-md-6 asso_pay">
        <a href="https://durgabari.org/HDBS_PaymentTesting/Underconstruction/Underconstruction">Cart / Payment</a>
    </div>
     <div class="col-md-6 asso_pay">
        <a href="https://durgabari.org/HDBS_PaymentTesting/Sponsorship/Sponsorship">Sponsorship</a>
    </div>
     <div class="col-md-6 asso_pay">
        <a href="https://durgabari.org/HDBS_PaymentTesting/Mailinoption/Mailinoption">Mail-in Option</a>
    </div>
     <div class="col-md-6 asso_pay">
        <a href="https://durgabari.org/HDBS_PaymentTesting/Underconstruction/Underconstruction">Instructions FAQ</a>
    </div>
      <div class="col-md-12 asso_pay">
        <a href="https://durgabari.org/HDBS_PaymentTesting/Help/Help">Help?</a>
    </div>
    <div class="col-md-12 asso_pay">
        <a href="https://durgabari.org/payments/">Membership New Renewal Maintenance</a>
    </div>-->
</div>               
<br><br>
<!--<div class="sidebar-title">
                    <h2><span style="color: #ef260f;">Associated</span> Payments</h2>
                </div>-->

            <!--   <div class="row">
    <div class="col-md-6 asso_pay">
        <a href="https://durgabari.org/HDBS_PaymentTesting/PujaPaidparking/PujaPaidparking">Puja Parking</a>
    </div>
     <div class="col-md-6 asso_pay">
        <a href="https://durgabari.org/HDBS_PaymentTesting/PujaTicket/PujaTicket">Puja Tickets</a>
    </div>
     <div class="col-md-6 asso_pay">
        <a href="https://durgabari.org/HDBS_PaymentTesting/PujaPaidpasses/PujaPaidpasses/">Puja Passes</a>
    </div>
     <div class="col-md-6 asso_pay">
        <a href="https://durgabari.org/HDBS_PaymentTesting/PujaMagazine/PujaMagazine">Puja Magazines</a>
    </div>
      <div class="col-md-12 asso_pay">
        <a href="https://durgabari.org/payments/">Membership New Renewal Maintenance</a>
    </div>
</div>
<br><br>-->
            </div>
                            
            <div class="sidebar-widget help-widget">
                <div class="sidebar-title">
                    <h2><span style="color: #ef260f;">Need</span> Help?</h2>
                </div>
               <div class="widget-content">
                    <div class="text">If you have any questions, please contact us</div>
                        <p style="padding-bottom:30px;"><span><i class="fa fa-envelope" aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;" href="mailto:registration@durgabari.org"> registration@durgabari.org</a></p>
               <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;" href="tel:+17134948782"> <strong style="font-size:26px;"> +1 713-494-8782</strong> <br><span style="font-size:20px;color:#000;">Enakshi Lahiri</span></a></p>
               <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;" href="tel:+18322055665"> <strong style="font-size:26px;"> +1 832-205-5665</strong> <br><span style="font-size:20px;color:#000;">Amit Bhaduri</span></a></p>
               <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;" href="tel:+18326770860"> <strong style="font-size:26px;"> +1 832-677-0860</strong> <br><span style="font-size:20px;color:#000;">Subhas Das</span></a></p>
               </div>
            </div>
                        
        </aside>
    </div>


</div>
</div>
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.esm.min.js"></script>


