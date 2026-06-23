<style>
    .form-select {
    display: block;
    width: 100%;
    padding: .375rem 2.25rem .375rem .75rem !important;
    -moz-padding-start: calc(0.75rem - 3px);
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e);
    background-repeat: no-repeat;
    background-position: right .75rem center !important;
    background-size: 16px 12px;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
#MemberID {
    font-size:1.35rem !important;
}
.btn-style-1 {
            background-color: #f43f5e !important;
            color: #fff !important;
            border-radius: .5rem;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px !important;
            font-size: 1.5rem !important;
         }
         .d-flex {
            display: flex !important;
         }
          .justify-content-between {
            justify-content: space-between;
          } 
          .gap-3 {
            gap: 1rem;
          }
          .shadow {
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px !important;
          }
          .zelle-panel {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: flex-end;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 16px;
            box-shadow: rgba(50, 50, 93, 0.12) 0 4px 12px -2px, rgba(0, 0, 0, 0.12) 0 2px 6px -3px;
            text-align: left;
          }
          .zelle-panel .btn-style-1 {
            min-height: 42px;
            padding: 10px 18px !important;
            font-size: 1rem !important;
            white-space: nowrap;
          }
          .zelle-manual-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-end;
            flex: 1 1 420px;
          }
          .zelle-field {
            flex: 1 1 210px;
          }
          .zelle-field label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 6px;
          }
          .zelle-field input {
            width: 100%;
          }
          .zelle-search-again-btn {
            padding: 8px 18px !important;
            font-size: 14px !important;
            font-weight: 700;
          }
          @media (max-width: 767px) {
            .zelle-panel,
            .zelle-manual-grid {
                display: block;
            }
            .zelle-panel .btn-style-1,
            .zelle-field {
                width: 100%;
                margin-bottom: 10px;
            }
          }
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
.rounded-lg {
             border-radius:1rem;
            }

.note-text {
            background-color: rgba(255, 255, 255, .9);
            box-shadow: rgba(239, 68, 68, .3) 0px 2px 4px 0px, rgba(239, 68, 68, .5) 0px 2px 16px 0px;
        }
</style>
<title>Payment for Puja Registration</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-grid.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-grid.rtl.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-reboot.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-reboot.rtl.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-utilities.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-utilities.rtl.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.rtl.min.css"/>

<section class="page-title" style="background-image:url(../12.jpg);">
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
                    <h3>Payment for Puja Registration</h3>
                   <!-- <h4><span>Contact : </span><a href="mailto:registration@durgabari.org"> registration@durgabari.org</a></h4>-->
                    <ul class="bread-crumb clearfix">
                        <li><a style="text-decoration:none;color:#fff;" href="<?php echo INSTALL_URL; ?>onlinepujapayments/onlinepujapayments">Home</a></li>
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
                    <h2><span style="color: #ef260f;">Payment</span> Info</h2>        
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
$magazine_additional_amount = $_POST['extramagazineamount'] ?? 0;
$adult_registration_amount = $_POST['extraadultregistration'] ?? 0;
$adult_registration_count = $_POST['adult_member_count'] ?? 0;
?>

 <hr>
        <div class="row">
            <div class="col-md-6">
                <h4 class="item_heading">Items</h4>
            </div>
            <div class="col-md-6">
                <p class="item_count"><?php echo 1 + $donation_quantity + (int)($_POST['magazine'] ?? 0) + ((float)$adult_registration_amount > 0 ? 1 : 0); ?></p>
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

              <?php if((float)$adult_registration_amount > 0){ ?>
                <div class="col-md-6">
                <h4 class="item_heading2">22+ Unmarried Adult Registration</h4>
                <p class="item_heading2">Qty : <strong><?php echo htmlspecialchars($adult_registration_count, ENT_QUOTES); ?></strong></p>
            </div>
            <div class="col-md-6">
                <p class="item_count2">$<?php echo htmlspecialchars($adult_registration_amount, ENT_QUOTES); ?></p>
            </div>
            <hr>
            <?php } ?>

             <div class="col-md-6">
                <h4 class="item_heading2">Total USD</h4>
            </div>

           <div class="col-md-6">
                <p class="item_count2" id="finalprice">$<?php
                    echo (float)($_POST['donation'] ?? 0) + (float)($_POST['puja_amount'] ?? 0) + (float)($_POST['extraparentregistration'] ?? 0) + (float)$adult_registration_amount + (float)$magazine_additional_amount - (float)($_POST['discountseniorprice'] ?? 0);
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
<!--        <h5 class="card_details">Payment for : <span class="payment_for">Donation (non-refundable), PUJA / <?php //echo $_POST['puja_type']; ?> / <?php //echo $_POST['puja_category']; ?>-<?php //echo $_POST['member_status']; ?></span></h5>-->
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
                            <option value="directdeposit">Direct Deposit</option>
                            <option value="sumup">Sumup</option>
                            <option value="stripe">Credit card</option>
                            <option value="ComplimentaryRegistration">Complimentary Registration</option>
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
                                        //if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
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
                        <td style="display: block;">
                            <div class="zelle-panel">
                                <button class="btn btn-style-1"
                                                                    style="display: none;"
                                                                    type="button" id="checkPaymentData">Get Zelle Payment Details</button>
                                                                    <select  data-rule-required='true'
                                                                    id="MemberID" name="oid" class="form-control form-select shadow"
                                                                    style="font-weight: bold;">
                                                                    <option value="">Please select your payment details
                                                                    </option>
                                                                    <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) {
                                                                        foreach (($tpl['Amount'] ?? []) as $key => $value) {
                                                                            ?>
                                                                            <option value="<?php echo $value['Amount']; ?>">
                                                                                <?php echo $value['Amount']; ?></option>
                                                                            <?php
                                                                        }
                                                                    } ?>
                                                                </select>
                                                                <div id="zelle-action-btns" style="display:none;width:100%;margin-top:8px;">
                                                                    <!-- Selection already verifies through the MemberID change handler. -->
                                                                    <!-- <button type="button" id="zelle-verify-btn" class="btn btn-success btn-sm">Verify Selected Transaction</button> -->
                                                                    <button type="button" id="zelle-retry-btn" class="btn btn-default zelle-search-again-btn">Search Again</button>
                                                                </div>
                                                                <div id="zelle-manual-fields" class="zelle-manual-grid" style="display:none;">
                                                                    <div class="zelle-field">
                                                                        <label>Your name as used in Zelle:</label>
                                                                        <input type="text" id="zelle_donor_name" class="form-control input-sm" placeholder="Full name used for Zelle transfer" value="<?php echo htmlspecialchars(trim(($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '')), ENT_QUOTES); ?>">
                                                                    </div>
                                                                    <div class="zelle-field">
                                                                        <label>Zelle payment date:</label>
                                                                        <input type="date" id="zelle_date" class="form-control input-sm">
                                                                    </div>
                                                                </div>
                                                                <div id="zelle-no-match" style="display:none;width:100%;color:#c0392b;font-size:13px;margin-top:8px;padding:8px;background:#fdecea;border-radius:4px;text-align:left;">
                                                                    No matching Zelle payment found. Please check your Zelle name, amount, and payment date.
                                                                </div>
                            </div>
                                                                </td>
                        <!--<td id="error_code2"></td>-->
                        <!-- </td> -->
                
                        </tr>
                </table>
                        <table class="table">
                        <tr>
                    <td id="error_code2"></td>
                    <!-- <td id="error_code"></td>-->
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
                            <th>Deposit Account</th>
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
        <td class="td">
	<select name="CheckDepositAccount" class="choice">
		<option value="PujaAccount">Puja Account</option>
		<option value="RegularAccount">Regular Account</option>
	</select>
</td>
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
            <th>Deposit Account</th>
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
                    	<td class="td">
		<select name="CashDepositAccount" class="choice">
			<option value="PujaAccount">Puja Account</option>
			<option value="RegularAccount">Regular Account</option>
		</select>
	</td>
        </tr>
    </tbody>
</table>

<!-- for direct deposite -->
<table class="table table-bordered table-hover table-striped" style="display:none" id="directdeposite">
    <thead>
        <tr class="tr">
            <th>Bank Name</th>
            <th>Transaction Code</th>
            <th>Amount</th> 
            <th>Date</th>
            <th>Deposit Account</th>
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
                    	<td class="td">
		<select name="DirectPayDepositAccount" class="choice">
			<option value="PujaAccount">Puja Account</option>
			<option value="RegularAccount">Regular Account</option>
		</select>
	</td>
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
        <th>Deposit Account</th>
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
               <td class="td">
		<select name="SumUpDepositAccount" class="choice">
			<option value="PujaAccount">Puja Account</option>
			<option value="RegularAccount">Regular Account</option>
		</select>
	</td>     
        </tr>
    </tbody>
</table>

                                
<input type="hidden" name="stripeToken" id="stripeToken" value="" />
<div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key']; ?></div>

<input type="hidden" name="puja_type" value="<?php echo htmlspecialchars($_POST['puja_type'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="puja_category" value="<?php echo htmlspecialchars($_POST['puja_category'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="outoftowner" value="<?php echo (int)($_POST['outoftowner'] ?? 0); ?>"/>
<input type="hidden" name="student" value="<?php echo (int)($_POST['student'] ?? 0); ?>"/>
<input type="hidden" name="Member_id" value="<?php echo htmlspecialchars($_POST['Member_id'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="membercategory" value="<?php echo htmlspecialchars($_POST['membercategory'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="Member_type" value="<?php echo htmlspecialchars($_POST['Member_type'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="First_name" value="<?php echo htmlspecialchars($_POST['First_name'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="Last_name" value="<?php echo htmlspecialchars($_POST['Last_name'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="member_veggie" value="<?php echo (int)($_POST['member_veggie'] ?? 0); ?>"/>
<input type="hidden" name="Sp_fname" value="<?php echo htmlspecialchars($_POST['Sp_fname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="Sp_lname" value="<?php echo htmlspecialchars($_POST['Sp_lname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="spouse_veggie" value="<?php echo (int)($_POST['spouse_veggie'] ?? 0); ?>"/>
<input type="hidden" name="co_register_adult_members" value="<?php echo !empty($_POST['co_register_adult_members']) ? '1' : ''; ?>"/>
<input type="hidden" name="adult_member_count" value="<?php echo htmlspecialchars($_POST['adult_member_count'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="adult1_fname" value="<?php echo htmlspecialchars($_POST['adult1_fname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="adult1_lname" value="<?php echo htmlspecialchars($_POST['adult1_lname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="adult1_birth_year" value="<?php echo (int)($_POST['adult1_birth_year'] ?? 0); ?>"/>
<input type="hidden" name="adult1_veggie" value="<?php echo (int)($_POST['adult1_veggie'] ?? 0); ?>"/>
<input type="hidden" name="adult2_fname" value="<?php echo htmlspecialchars($_POST['adult2_fname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="adult2_lname" value="<?php echo htmlspecialchars($_POST['adult2_lname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="adult2_birth_year" value="<?php echo (int)($_POST['adult2_birth_year'] ?? 0); ?>"/>
<input type="hidden" name="adult2_veggie" value="<?php echo (int)($_POST['adult2_veggie'] ?? 0); ?>"/>
<input type="hidden" name="adult3_fname" value="<?php echo htmlspecialchars($_POST['adult3_fname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="adult3_lname" value="<?php echo htmlspecialchars($_POST['adult3_lname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="adult3_birth_year" value="<?php echo (int)($_POST['adult3_birth_year'] ?? 0); ?>"/>
<input type="hidden" name="adult3_veggie" value="<?php echo (int)($_POST['adult3_veggie'] ?? 0); ?>"/>
<input type="hidden" name="member_optional_child" value="<?php echo htmlspecialchars($_POST['member_optional_child'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="childonefname" value="<?php echo htmlspecialchars($_POST['childonefname'] ?? '', ENT_QUOTES); ?>"/>
<!--<input type="hidden" name="childonefname" value="<?php //echo $_POST['childonefname'];  ?>"/>-->
<input type="hidden" name="childonelname" value="<?php echo htmlspecialchars($_POST['childonelname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="Age1" value="<?php echo (int)($_POST['Age1'] ?? 0); ?>"/>
<input type="hidden" name="childtwofname" value="<?php echo htmlspecialchars($_POST['childtwofname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="childtwolname" value="<?php echo htmlspecialchars($_POST['childtwolname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="Age2" value="<?php echo (int)($_POST['Age2'] ?? 0); ?>"/>
<input type="hidden" name="childthreefname" value="<?php echo htmlspecialchars($_POST['childthreefname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="childthreelname" value="<?php echo htmlspecialchars($_POST['childthreelname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="Age3" value="<?php echo (int)($_POST['Age3'] ?? 0); ?>"/>
<input type="hidden" name="no_of_parent" value="<?php echo htmlspecialchars($_POST['no_of_parent'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="parent1_fname" value="<?php echo htmlspecialchars($_POST['parent1_fname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="parent1_lname" value="<?php echo htmlspecialchars($_POST['parent1_lname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="parent1_veggie" value="<?php echo (int)($_POST['parent1_veggie'] ?? 0); ?>"/>
<input type="hidden" name="parent2_fname" value="<?php echo htmlspecialchars($_POST['parent2_fname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="parent2_lname" value="<?php echo htmlspecialchars($_POST['parent2_lname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="parent2_veggie" value="<?php echo (int)($_POST['parent2_veggie'] ?? 0); ?>"/>
<input type="hidden" name="Sp_fname" value="<?php echo htmlspecialchars($_POST['Sp_fname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="Sp_lname" value="<?php echo htmlspecialchars($_POST['Sp_lname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="spouse_veggie" value="<?php echo (int)($_POST['spouse_veggie'] ?? 0); ?>"/>
<input type="hidden" name="swap_spouse" value="<?php echo (int)($_POST['swap_spouse'] ?? 0); ?>"/>
<input type="hidden" name="street" value="<?php echo htmlspecialchars($_POST['street'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="streetname" value="<?php echo htmlspecialchars($_POST['streetname'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="unit" value="<?php echo htmlspecialchars($_POST['unit'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="student_or_oot" value="<?php echo htmlspecialchars($_POST['student_or_oot'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_POST['city'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="state" value="<?php echo htmlspecialchars($_POST['state'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="zip" value="<?php echo htmlspecialchars($_POST['zip'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="alternatenumber" value="<?php echo htmlspecialchars($_POST['alternatenumber'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="alternateemail" value="<?php echo htmlspecialchars($_POST['alternateemail'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="senior" value="<?php echo (int)($_POST['senior'] ?? 0); ?>"/>
<input type="hidden" name="magazine" value="<?php echo htmlspecialchars($_POST['magazine'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="donation" value="<?php echo htmlspecialchars($_POST['donation'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="YTD" value="<?php echo htmlspecialchars($_POST['YTD'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="newytd" value="<?php echo htmlspecialchars($_POST['newytdfeature'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="totalamount" value="<?php echo htmlspecialchars($_POST['totalamount'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="magazineamount" value="<?php echo htmlspecialchars($_POST['magazineamount'] ?? '', ENT_QUOTES); ?>"/>

<!-- //for puja price & puja name  -->
<input type="hidden" name="amount" value="<?php echo htmlspecialchars($_POST['puja_amount'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="member_status" value="<?php echo htmlspecialchars($_POST['member_status'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="discountseniorprice" value="<?php echo htmlspecialchars($_POST['discountseniorprice'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="extraparentregistration" value="<?php echo htmlspecialchars($_POST['extraparentregistration'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="extrachildregistration" value="<?php echo htmlspecialchars($_POST['extrachildregistration'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="extraadultregistration" value="<?php echo htmlspecialchars($_POST['extraadultregistration'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="magazineprice" value="<?php echo htmlspecialchars($_POST['extramagazineamount'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="Parent_Puja_Type" value="<?php echo htmlspecialchars($_POST['Parent_Puja_Type'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="studentavatar" value="<?php echo htmlspecialchars($_POST['studentavatar'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="addressavatar" value="<?php echo htmlspecialchars($_POST['addressavatar'] ?? '', ENT_QUOTES); ?>"/>
<!-- Dinner coupon fields removed from Puja Registration per 2026 client change.
<input type="hidden" name="adultCouponQty" value="<?php echo htmlspecialchars($_POST['adultCouponQty'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="childCouponQty" value="<?php echo htmlspecialchars($_POST['childCouponQty'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="totalCouponPrice" value="<?php echo htmlspecialchars($_POST['totalCouponPrice'] ?? '', ENT_QUOTES); ?>"/>
-->
<input type="hidden" name="greenFieldParkingDecision" value="<?php echo htmlspecialchars($_POST['greenFieldParkingDecision'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="regmember" value="<?php echo htmlspecialchars($_POST['regmember'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="puja_amount" value="<?php echo htmlspecialchars($_POST['puja_amount'] ?? '', ENT_QUOTES); ?>"/>
<input type="hidden" name="newytdfeature" value="<?php echo htmlspecialchars($_POST['newytdfeature'] ?? '', ENT_QUOTES); ?>"/>
<input id="Zellecode" class="form-control input-sm" type="text" name="code" style="display:none;">
<div id="zelle-modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9100;justify-content:center;align-items:center;">
    <div style="background:#fff;border-radius:8px;width:660px;max-width:96vw;max-height:90vh;overflow-y:auto;box-shadow:0 8px 32px rgba(0,0,0,0.25);position:relative;font-family:Arial,sans-serif;">
        <div style="background:#357ca5;padding:16px 20px 12px;text-align:center;position:relative;border-radius:8px 8px 0 0;">
            <button id="zelle-modal-close" type="button" style="position:absolute;top:10px;right:14px;background:none;border:none;color:#fff;font-size:24px;cursor:pointer;line-height:1;padding:0;opacity:0.85;">&times;</button>
            <h4 style="color:#fff;margin:0;font-size:18px;font-weight:bold;">Pay via Zelle</h4>
            <p style="color:rgba(255,255,255,0.88);margin:4px 0 0;font-size:13px;">Send to treasurerpuja@durgabari.org</p>
        </div>
        <div style="padding:18px 24px 16px;font-size:14px;color:#333;line-height:1.8;">
            <b>Step 1</b> - Open your bank app and navigate to Zelle.<br>
            <b>Step 2</b> - Send your total cart amount to <b>treasurerpuja@durgabari.org</b>.<br>
            <b>Step 3</b> - After sending, click <b>"I've Completed Zelle Payment"</b> below.
        </div>
        <div style="padding:0 24px 22px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <button id="zelle-modal-paid-btn" type="button" class="btn btn-primary" style="min-width:200px;font-size:15px;">I've Completed Zelle Payment</button>
            <button id="zelle-modal-cancel-btn" type="button" class="btn btn-default" style="min-width:120px;font-size:15px;background:#f5f5f5;border:1px solid #ccc;">Cancel</button>
        </div>
    </div>
</div>
<div class="col-md-6 checkbox">
<article class="note-text p-3 rounded-lg mt-5" style="width:206% !important;">
            <p class="fs-2 fw-bold mb-0" style="font-family: monospace;">
                HDBS strives to provide a safe and respectful
                environment for all the attendees. By attending services and
                events, you acknowledge that you do so at your own risk and agree that HDBS is not
                responsible for any
                personal injury, illness, or personal property damage. You agree not to hold HDBS organizers
                liable for any
                dispute or limitation with the services or events.
            </p>
            </article>
</div>
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
        <a href="#" onclick="window.history.go(-1); return false;">Back</a>
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
 


