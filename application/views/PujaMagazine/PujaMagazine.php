  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<style>
.disabledbutton { pointer-events: none; opacity: 0.4;}
.puja-wrapper {text-align: center; font-family: Arial, Helvetica, sans-serif;}
.a-box-special a {box-sizing: border-box; width: 235px; text-decoration:none; padding: 20px; font-size: 16px; text-transform: uppercase; font-weight: 600; letter-spacing: 1px; cursor: pointer; border: none;}
.a-box-special { background: red;}
.a-box-special a:focus { outline: none;}
.btn_durga { background: #fff; color: #000; border: 2px solid red; border-radius: 5px;  transition: background 400ms ease-out, color 400ms ease-out; }
.btn_durga:hover { background: #000; color: #fff; border-radius: 5px; }
.layout { max-width: 100%; margin: 0 auto; display: flex; flex-flow: row wrap; justify-content: center;}
.a-box, .a-box-special { width: 280px; height: 150px; margin: 10px; display: flex; justify-content: center; align-items: center;}

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
.page-title .breadcrumb-column h1 { position: relative; font-family: "Open Sans",Arial,Helvetica,Sans-Serif; font-size: 35px; font-weight: 600; margin-bottom: 20px; color: #ffffff; padding-right: 10px; text-transform: capitalize; text-align: right; border-right: 3px solid #ff5252;}
.page-title .breadcrumb-column h3 { position: relative; font-family: "Open Sans",Arial,Helvetica,Sans-Serif; font-size: 24px; font-weight: 600; margin-bottom: 20px; color: #ffffff; padding-right: 10px; text-transform: capitalize; text-align: right; border-right: 3px solid #ff5252;}
.page-title .breadcrumb-column h4 { position: relative; font-family: "Open Sans",Arial,Helvetica,Sans-Serif; font-size: 16px; font-weight: 600; margin-bottom: 20px; color: #ffffff; letter-spacing: .5px ; padding-right: 10px; text-transform: capitalize;text-align: right; border-right: 3px solid #ff5252;}
.page-title .breadcrumb-column h4 span { font-family: "Open Sans",Arial,Helvetica,Sans-Serif; color: #ff5252;}
.page-title .breadcrumb-column h4 a { font-family: "Open Sans",Arial,Helvetica,Sans-Serif; color: #ffffff; text-decoration: none;}
.page-title .bread-crumb li {position: relative; display: inline-block; line-height: 30px; margin-left: 25px; color: #ff5252; font-size: 16px; font-weight: 400;}
.page-title .bread-crumb li:first-child {margin-left: 0px;}
.page-title .bread-crumb li:first-child:before {content: '/'; position: absolute; right: -20px; top: 0px; width: 15px; color: #ffffff; text-align: center; line-height: 30px;}
.sidebar-side .sidebar {padding: 30px 25px 25px; border-radius: 5px; border: 1px solid #e1e1e1;}
.sidebar-title {position: relative; margin-bottom: 22px;}
.sidebar-title h2 {position: relative; color: #333333; font-size: 20px; font-weight: 700; text-transform: uppercase;}
.help-widget .text {position: relative; color: #777777; font-size: 18px; line-height: 1.9em; margin-bottom: 15px;}
.widget-content p {font-size: 20px;}
.widget-content p span {color: #ef260f;}
.help-widget .list {position: relative;}
.help-widget .list li {position: relative; color: #777777; font-size: 14px; line-height: 1.9em; padding-left: 30px; margin-bottom: 8px;}
select.choice {width: 100%; padding: 14px; font-size: 24px; color: #fff; background-color: #ef260f; border-radius: 15px;}
select.choice2 {width: 100%; padding: 12px; font-size: 20px; margin-top: 20px; color: #fff; background-color: #ef260f; border-radius: 15px;}
select.choice3 {width: 100%; padding: 14px; font-size: 22px; margin-top: 0px; color: #fff; background-color: #ef260f; border-radius: 15px;}
select.choice4 { width: 100%; font-size: 20px; color: #fff; background-color: #ef260f; border-radius: 10px;}
select.year { width: 100%; padding: 14px; padding: 12px; font-size: 20px; margin-top: 20px; border-radius: 10px;}
input.MIDnumber {padding: 12px; font-size: 20px; margin-top: 3px; border-radius: 10px;}
input.MIDtext {padding: 10px; margin-top: 3px; border-radius: 10px;}
input.MIDtext2 {padding: 12px; font-size: 20px; margin-top: 20px; border-radius: 10px; width: 100%;}
input.MIDtext2readonly { padding: 12px; font-size: 20px; margin-top: 20px; pointer-events: none; background-color: gainsboro; border-radius: 10px; width: 100%;}
input.number {padding: 12px; width: 100%; font-size: 20px; margin-top: 20px;border-radius: 10px;}
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
.col-md-12.collection {padding-top: 20px;}
button.payment_btn {padding: 10px; font-size: 20px; border-radius: 10px; width: 100%; background-color: #ef260f; color: #fff; font-weight: 600;}
button.go_cart_btn { padding: 10px; font-size: 22px; border-radius: 10px; width: 100%; background-color: #000; color: #fff; margin-top: 30px; font-weight: 600;}
.text_placeholders { position: relative; color: #ef260f; font-weight: 600; letter-spacing: 0.7px; font-size: 14px; line-height: 25px;}
.asso_pay a{ text-decoration: none; font-size: 14px; margin: 0px; line-height: 65px; font-weight: 600; text-transform: uppercase; padding: 15px 15px 15px 15px; background-color: #000; color: #fff; letter-spacing: 0.5px;}
.asso_pay a:hover { text-decoration: none; font-size: 14px; margin: 0px; line-height: 65px; font-weight: 600; text-transform: uppercase; padding: 15px 15px 15px 15px;  background-color: #ef260f; color: #fff; letter-spacing: 0.5px;}
.myDiv{display:none;}  
#showOne{border:1px solid red;}
#showTwo{border:1px solid green;}
#showThree{border:1px solid blue;}
input#yesMG {width: 10%;}
.clear { clear: both;}
.close { text-align: right!important; padding-right: 10px; font-size: 40px; color: red; opacity: .8;}
.popup_title { padding: 5px; margin-top: -30px;}
.modal-content { width: 80% !important; margin: 160px auto auto auto !important;}
.input-sm{ font-size:16px !important; }
#payment_btn_id { padding: 10px; font-size: 22px; border-radius: 10px; width: 100%; background-color: #000; color: #fff; margin-top: 30px; font-weight: 600; }
#otp-verified-banner {display:none;margin:12px 0;}
#zelle-manual-fields {display:none;margin-top:15px;}
#zelle-action-btns {display:none;margin-top:10px;}
#zelle-no-match {display:none;color:#c0392b;font-weight:600;margin-top:10px;}
/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
    .col-md-6.phone { padding-top: 20px;}
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
    .col-md-6.phone { padding-top: 20px;}
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
    .col-md-6.phone { padding-top: 20px;}
}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
.col-md-6.phone { padding-top: 20px;}
input#memphonefam { width: 348px;}
input#memphone2fam { width: 348px;}
}

@media only screen and (min-width: 1400px) {
.col-md-6.phone { padding-top: 20px;}
input#memphonefam { width: 416px;}
input#memphone2fam { width: 416px;}
}
</style>
<title>Paid Magazines for Puja</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-grid.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-grid.rtl.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-reboot.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-reboot.rtl.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-utilities.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-utilities.rtl.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.rtl.min.css"/>

  <section class="page-title" style="background-image:url(<?php echo INSTALL_URL; ?>12.jpg);">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Title -->
                <div class="title-column col-lg-6 col-md-12 col-sm-12">
                    <img style="float:left;padding:20px" src="../1.svg" width="35%">
				<img style="border-radius: 96px;float: left;padding: 0px; margin-top: 2rem;" src="../merchandise.jpg" width="23%">
                </div>
                <!--Bread Crumb -->
                <div class="breadcrumb-column col-lg-6 col-md-12 col-sm-12">
                    <h1>Houston Durga Bari Society</h1>
                    <h3>HDBS
                        <?php
                            $currentYear = date('Y');
                            $nextYear = date('Y') + 1;
                            date_default_timezone_set("America/Chicago");
                            if (date("m-d") < "04-01") {
                                $currentYear = $currentYear - 1; 
                                $nextYear = date("Y");
                            }
                            echo "" . $currentYear . " - " . $nextYear . " Puja Online System ";
                        ?>
                    </h3>
                    <h3>Payment for Puja Magazine</h3>
                    <!--<h4><span>Contact : </span><a href="mailto:registration@durgabari.org"> registration@durgabari.org</a></h4>-->
                    <ul class="bread-crumb clearfix">
                        <li><a style="text-decoration:none;color:#fff;" href="<?php echo INSTALL_URL; ?>Associatepayments/Associatepayments">Home</a></li>
                        <li class="active">Magazine</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>



<div class="container" style="position: relative;padding: 40px 0px 60px;">
<div class="row">


<div class="col-lg-8 col-md-12 col-sm-12">

        <div style="border-left: 3px solid #ef260f; border-right: 3px solid #ef260f; padding: 10px; border-bottom: 3px solid #ef260f;" id="showRegistration" class="myChoice">
        <div class="clear"></div>       
  <form method="POST" action="" enctype="multipart/form-data" id="edit_registration"> 
    <input type="hidden" name="create_magazine_payment_request" value="1" />
    <input type="hidden" id="Zellecode" name="code" value="" />
    <div id="otp-admin-bypass" style="display:none;"><?php echo ($this->controller->isAdmin() || $this->controller->isEditor()) ? '1' : '0'; ?></div>
    <div id="otp-session-verified" style="display:none;"><?php
        $otpVerifiedMember = $_SESSION['otp_verified_member'] ?? '';
        echo htmlspecialchars(is_array($otpVerifiedMember) ? ($otpVerifiedMember['member_id'] ?? '') : $otpVerifiedMember, ENT_QUOTES, 'UTF-8');
    ?></div>
        <div class="row">
 
             <br> 

            <div class="col-md-12">
                <select required class="choice" name="member_status" id="pul2">
                    <option value="" selected>Returning or New User</option>
                    <option value="Member">Returning User</option>
                    <option value="Non-Member">New User</option>

                </select>
                <div class="text_placeholders">Returning or New User *</div>
            </div>
            <div class="col-md-12" id="otp-verified-banner"></div>
            
        </div>

<!--memberall3puja start-->

    <div id="showMember" class="myDiv">
   
        <div id="hide_nm" class="row">


                 <div class="col-md-12">
                    <input class="MIDtext2" type="text" name="term" id="term" placeholder="search records here.... *" tabindex="2" required>
                    <input class="MIDtext2" type="text" style="display:none" name="termMember" id="termMember"  placeholder="search member here....">
                    <div class="text_placeholders">Search by : First Name, Last Name, Zip, MID *</div>
                </div>

              <div class="col-md-4">
                    <input class="MIDtext2readonly" style="width:100%;" type="text" name="Member_id" id="memidfam" placeholder="Member ID *" required/>
                    <div class="text_placeholders">Verified Member ID *</div>
                </div>
                <div class="col-md-4">
                    <input class="MIDtext2readonly" style="width:100%;" type="text" name="membercategory" id="memcatfam" placeholder="Membership Category *" required/>
                    <div class="text_placeholders">Membership Category *</div>
                </div>
                
                <div class="col-md-4">
                    <input class="MIDtext2readonly" style="width:100%;" type="text" name="Member_type" id="memtypefam" placeholder="Membership Status"/>
                    <div class="text_placeholders">Membership Status</div>
                </div>
</div>

<div class="row">

                <div class="col-md-6">
                    <input class="MIDtext2" style="width:100%;" type="text" name="First_name" id="memfnamefam" placeholder="First Name *" required/>
                    <div class="text_placeholders">First Name *</div>
                </div> 

                 <div class="col-md-6">
                    <input class="MIDtext2" style="width:100%;" type="text" name="Last_name" id="memlnamefam" placeholder="Last Name *" required/>
                    <div class="text_placeholders">Last Name *</div>
                </div> 

        </div>


   <div class="row">
                <div class="col-md-3">
                    <input class="MIDtext2" style="width:100%;" type="text" name="street" id="memstreetfam" placeholder="Street # *" required/>
                    <div class="text_placeholders">Street # *</div>
                </div>

                <div class="col-md-6">
                     <input class="MIDtext2" style="width:100%;" type="text" name="streetname" id="memstreetnamefam" placeholder="Street Name *" required/>
                     <div class="text_placeholders">Street Name *</div>
                </div>

                <div class="col-md-3">
                    <input class="MIDtext2" style="width:100%;" type="text" name="unit" id="memunitfam" placeholder="Unit #"/>
                    <div class="text_placeholders">Unit #</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <input class="MIDtext2" style="width:100%;" type="text" name="city" id="memcityfam" placeholder="City *" required/>
                    <div class="text_placeholders">City *</div>
                </div>

                <div class="col-md-4">
                     <input class="MIDtext2" style="width:100%;" type="text" name="state" id="memstatefam" placeholder="State *" required/>
                     <div class="text_placeholders">State *</div>
                </div>

                <div class="col-md-4">
                    <input class="MIDtext2" style="width:100%;" type="text" name="zip" id="mamzipcodefam" placeholder="Zip Code *" required/>
                    <div class="text_placeholders">Zip Code *</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 phone">
                    <input class="MIDtext2readonly" type="text" name="phone" onchange="checkphoneno(this.id)" id="memphonefam" placeholder="##########" maxlength="10" required size="25"/>
                    <div class="text_placeholders">Phone Number *</div>
                </div>
                <div class="col-md-6 phone">
                    <input class="MIDtext2" type="text" name="alternatenumber" onchange="checkphoneno2(this.id)" id="memphone2fam" placeholder="##########"  maxlength="10" required size="25" />
                    <div class="text_placeholders">Mobile Number *</div>
                </div>
                <div class="col-md-6">
                    <input class="MIDtext2readonly" style="width:100%;" type="email" name="email" id="mememailfam" placeholder="name@company.com" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+"/>
                    <div class="text_placeholders">Email ID *</div>
                </div>
                 <div class="col-md-6">
                    <input class="MIDtext2" style="width:100%;" type="email" name="alternateemail" id="mememail2fam" placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+"/>
                    <div class="text_placeholders">Alternate Email ID</div>
                </div>
                 <div class="col-md-12">
                 <input type="hidden" name="magazine_amount" class="value4" value=""  id="total_magazine_amount">
                 <input type="hidden" name="mode_of_collection"  value=""  id="magazinecollectiontype">
                <input class="number" onblur="getAmount4();" style="width:100%;" type="number" value="" min="1" max="2" onchange="checkmagazineno(this.id)" name="magazine" id="mag" placeholder="No. of Magazine(s) *" required />
                <div class="text_placeholders">No. of Magazine(s) ( $15 per copy ) *</div>
            </div>
                
                <div class="col-md-12 collection">
                <select class="choice3" name="magazineTypecollection" value="" id="ddlStatus" onchange="getAmount4();" required >
                    <option value="">Mode of Collection *</option>
                    

     <?php
        $count = count($tpl['magazineregarr']);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
               ?>
              
                  <option value="<?php echo $tpl['magazineregarr'][$i]['price']; ?>" id="<?php echo $tpl['magazineregarr'][$i]['magazinename']; ?>"><?php echo $tpl['magazineregarr'][$i]['magazinename']; ?></option>
                   
                <?php
            }
        } else {
            ?>
                    <?php
                    echo __('No matching records found');
                    ?>
            <?php
        }
        ?>     



                </select>
                <div class="text_placeholders">Mode of Collection *</div>
            </div>   

            
            <div class="col-md-12">
                <input class="MIDtext2readonly" style="width:100%;" type="number" name="totalamount" min="1" title="Please select Number of Magazine and Mode of Collection First." id="total_value4" required placeholder="Total Amount($) *"/>
                <div class="text_placeholders">Requested Amount to Pay($) *</div>
            </div>
                
            </div>

            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                        <table class="table">
                        <tr class="tr">
                            <td class="td" colspan="2">
                            <select name="PaymentOption" style="width:100%;  height:50%;" onchange="paymentmethod(this.id)" id="payment_method" class="choice"
                            required>
                            <option value="">Please Select</option>
                            <option value="check">Check</option>
                            <option value="cash">Cash</option>
                            <option value="directdeposit">Online Deposit</option>
                            <option value="sumup">Sumup</option>
                            <option value="stripe">Credit card</option>
                          <!-- <option value="others">Zelle (Preferred)</option>   --> 
                        </select> 

                                <div class="text_placeholders">Payment Method *</div>
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
                        <label class="control-label" for="F_Name" style="color:rgba(237,237,237) !important;">Payment Details:</label>
                        <!-- <td  class="td" colspan="2" class="auto-widget"> -->
                        <td class="td"><button style="display: none;float:left!important;" type="button" id="checkPaymentData" >Get Zelle Payment Details</button></td>
                        <!-- <input data-rule-required='true' id="MemberID" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>"> -->
                        <td  class="td" colspan="3"><select data-rule-required='true' id="MemberID" name="oid"  class="form-control input-sm" style="font-weight: bold;float:right!important;">
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
<!-- for check -->

<table class="table table-bordered table-hover table-striped" style="display:none;margin-top: -42px;" id="checkdata">
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

<table class="table table-bordered table-hover table-striped" style="display:none;margin-top: -42px;" id="cashdata">
    <thead>
        <tr class="tr">
            <th>Processed By</th>
            <th>Amount</th>  
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input type="text" id="receiveby" name="ReceiveBy"
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
<table class="table table-bordered table-hover table-striped" style="display:none;margin-top: -42px;" id="directdeposite">
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
<table class="table table-bordered table-hover table-striped" style="display:none;margin-top: -42px;" id="Sumupdata">
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
                    <td class="td"><input style="WIDTH: 100%;" type="date" id="date" name="sumupdate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<?php } ?>
<?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                    <table class="table">
                        <tr class="tr">
                            <td class="td" colspan="2">
                                <select name="PaymentOption" style="width:100%; height:50%;" onchange="paymentmethod(this.id)" id="payment_method" class="choice" required>
                                    <option value="">Please Select Payment Method</option>
                                    <option value="others">Zelle (Preferred)</option>
                                    <option value="stripe">Credit card</option>
                                </select>
                                <div class="text_placeholders">Payment Method *</div>
                            </td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr id="stripe_details" class="tr" style="display: none;">
                            <td class="td" colspan="4">
                                <div class="form-group">
                                    <label for="card-element">Credit or debit card</label>
                                    <div id="card-element"></div>
                                    <div id="card-errors" role="alert"></div>
                                </div>
                            </td>
                        </tr>
                        <tr id="others_details" style="display: none;">
                            <td class="td" colspan="4">
                                <div class="form-group">
                                    <input data-rule-required="true" id="confirm_code" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>" style="display:none;">
                                    <div id="error_code"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr>
                            <td id="error_code1" colspan="4"></td>
                        </tr>
                        <tr class="tr" id="MemberID1" style="display: none;" class="form-group">
                            <td class="td" colspan="4">
                                <div id="zelle-manual-fields">
                                    <button type="button" id="checkPaymentData" class="btn btn-danger">Get Zelle Payment Details</button>
                                    <div class="form-group" style="margin-top:10px;">
                                        <label for="zelle_donor_name">Your name as used in Zelle:</label>
                                        <input type="text" id="zelle_donor_name" class="form-control input-sm" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="zelle_date">Zelle payment date:</label>
                                        <input type="date" id="zelle_date" class="form-control input-sm">
                                    </div>
                                    <div id="zelle-no-match">No matching Zelle payment found. Check your Zelle name, amount, and payment date, then try again.</div>
                                </div>
                                <select data-rule-required="true" id="MemberID" name="oid" class="form-control input-sm" style="font-weight:bold;display:none;">
                                    <option value="">Please select your payment details</option>
                                </select>
                                <div id="zelle-action-btns">
                                    <button type="button" id="verifySelectedZelle" class="btn btn-success">Verify Selected Transaction</button>
                                    <button type="button" id="searchZelleManual" class="btn btn-default">Search Manually</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table class="table" id="zelledatadiv">
                        <tr>
                            <td id="error_code2"></td>
                            <td id="error_codeimg"></td>
                        </tr>
                    </table>
<?php } ?>
<input type="hidden" name="stripeToken" id="stripeToken" value="" />

 <div class="row">
            <div class="col-md-6">
                <button type="reset" onClick="window.location.reload();" class="go_cart_btn">Reset</button> 
            </div>
            <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
            <div class="col-md-6">
                <button id="payment_btn_id" type="submit" class="go_cart_btn" name="">Submit Request</button> 
            </div>
            <?php } ?>
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                            <div class="col-md-6">
                                 <button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save" name="Payment" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;Make Payment</button>
                                
                            </div>
                            <?php } ?>
        </div>
           
        <div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key']; ?></div>  
            
    </div> 
  
 <!--memberall3puja end-->
 

</form>

<?php require __DIR__ . '/../components/otp_modal.php'; ?>
    
</div>


  </div>

    <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
        
        <aside class="sidebar">

      

        <!-- Help Widget -->
                        
            <div class="sidebar-widget help-widget">
<?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                    <a style="font-size: 24px; text-decoration: none;color:#000;" href="<?php echo INSTALL_URL; ?>PujaMagazineadmin/index">Go Back to Dashboard</a>
                    <br><br>
                     <?php } ?>

                <div class="sidebar-title">
                    <h2><span style="color: #ef260f;">General</span> Guidelines</h2>
                </div>
                <div class="widget-content">
                    <div class="text"><strong>Step 1 : </strong>Express your interest to purchase copy (ies) of Puja magazine</div>
                    <div class="text"><strong>Step 2 : </strong>Registration Team will validate your application and send a confirmation</div>
                    <div class="text"><strong>Step 3 : </strong>Make the payment </div>
                    <div class="text"><strong>1. </strong>All 3 Pujas and Durga Puja registrants are eligible for a free copy of Sharad Arghya, the Puja Magazine. This site allows purchase of additional copies</div>
                <div class="text"><strong>1. </strong>Onsite collection is free. Please collect at HDBS premises during Durga, Kali or Saraswati Puja </div>
                </div>
            </div>
                            
            <div class="sidebar-widget help-widget">
                <div class="sidebar-title">
                    <h2><span style="color: #ef260f;">Need</span> Help?</h2>
                </div>
                <div class="widget-content">
                    <div class="text">If you have any questions, please contact us</div>
                        <p style="padding-bottom:30px;"><span><i class="fa fa-envelope" aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;" href="mailto:registration@durgabari.org"> registration@durgabari.org</a></p>
                            <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;" href="tel:+18326909062"> <strong style="font-size:26px;">+1 832-690-9062</strong> <br><span style="font-size:20px;color:#000;">Joy Mitra</span></a></p>
                </div>
            </div>
                        
        </aside>
    </div>


</div>
</div>




<script>



function checkmagazineno(elem) {
        //
        const magazineumber = $("#mag").val();
           if (magazineumber > 2) {
                alert("Value must be less than 2");
                $("#mag").val("");
                $("#payment_btn_id").addClass('disabledbutton');
                
            }
            else {
                $("#payment_btn_id").removeClass('disabledbutton');
                $("#mag").prop('required', true);
            }
    }
    

 function checkphoneno(elem) {
        //
        const phonenumber = $("#memphonefam").val();
        if (!!phonenumber) {
            if (isNaN(phonenumber)) {
                alert("Please Enter mobile Number");
                $("#payment_btn_id").addClass('disabled');
                //document.getElementById("totalamount").value = price; 
            }
            else if (phonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#payment_btn_id").addClass('disabledbutton');
            }
            else if (phonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#payment_btn_id").addClass('disabledbutton');
            }
            else if (phonenumber.length == 10) {
                $("#payment_btn_id").removeClass('disabledbutton');
            }
            else {
                $("#payment_btn_id").removeClass('disabledbutton');
            }
        }
        else {
            $("#memphonefam").prop('required', true);
            $("#payment_btn_id").removeClass('disabledbutton');
        }
    }
    
    function checkphoneno2(elem) {
        //
        const phonenumber = $("#memphone2fam").val();
        if (!!phonenumber) {
            if (isNaN(phonenumber)) {
                alert("Please Enter mobile Number");
                $("#payment_btn_id").addClass('disabled');
                //document.getElementById("totalamount").value = price; 
            }
            else if (phonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#payment_btn_id").addClass('disabledbutton');
            }
            else if (phonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#payment_btn_id").addClass('disabledbutton');
            }
            else if (phonenumber.length == 10) {
                $("#payment_btn_id").removeClass('disabledbutton');
            }
            else {
                $("#payment_btn_id").removeClass('disabledbutton');
            }
        }
        else {
            $("#memphone2fam").prop('required', true);
            $("#payment_btn_id").removeClass('disabledbutton');
        }
    }

 ////Lookup.......................Start..............................////
     $(function() {
        //
    $("#term").autocomplete({
        //source: "http://localhost/HDBS_Payment/Parking&Badges/ajax-db-search.php",
        source: '<?php echo INSTALL_URL; ?>ajax-db-search.php',
        select: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelectdonation(this);
        },
         onclick: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelectdonation();
        },
         onchange: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelectdonation();
        },
        // focus: function( event, ui ) {
        //     event.preventDefault();
        //     var name =  ui.item.value;
        //     var f_name = name.split(",");
        //     $("#term").val(f_name[0]);
        //     $("#termMember").val(ui.item.id);
        //     MemberSelectdonation(this);
        // },
       });
    });
    ////Lookup.......................End..............................////

//autocomplete start  
   
   function MemberSelectdonation(e) {
  
        var url2 = $("#container-abc-url-id").text(); 
        //
        var self = this;
        var data = $("#termMember").val();
        var term = $("#term").val();
        // for Ytd condition
       
        $("#sponsor").val("");
        $("#sponsorevent").val("");
        if (term != "") {
        const Memberid = data.split("-");
        //var url = gz$("#container-abc-url-id").text(); 
        if (term.trim() != "") {
            $.ajax({
                type: "POST",
                data: {
                    memberid: data
                },
                //url: self.options.server  +"load.php?controller=Donations&action=AllMember&cid=" + self.options.cal_id,
                url: url2 + "load.php?controller=PujaDonations&action=AllMemberNew",
                success: function (res) {
                    //
                    //var Membertext = $("#MemberSelectValue").text();
                    //document.getElementById("MemberSelect").value = Membertext; 
           

            let email2 = "";
                    const email2Element = $(res).filter("input#email2");
                   if(email2Element.length){
                       email2 = email2Element[0].value; 
                   }
                   document.getElementById("mememail2fam").value = email2;

            let email = "";
                    const emailElement = $(res).filter("input#email");
                   if(emailElement.length){
                       email = emailElement[0].value; 
                       if(email !="" ){
                        $('#mememailfam').prop('readonly', true);
                        $('#mememailfam').addClass('MIDtext2readonly');
                       }
                       else{
                        $('#mememailfam').prop('readonly', false);
                        $('#mememailfam').removeClass('MIDtext2readonly');
                        $('#mememailfam').addClass('MIDtext2');
                       }
                   }
                   document.getElementById("mememailfam").value = email;
          
                  let phoneNo2 = "";
                    const phoneNo2Element = $(res).filter("input#phone_work");
                   if(phoneNo2Element.length){
                      phoneNo2 = phoneNo2Element[0].value;
                    //   if(phoneNo2 !="" ){
                    //     $('#memphone2fam').prop('readonly', true);
                    //     $('#memphone2fam').addClass('MIDtext2readonly');
                    //   }
                    //   else{
                    //     $('#memphone2fam').prop('readonly', false);
                    //     $('#memphone2fam').removeClass('MIDtext2readonly');
                    //   $('#memphone2fam').addClass('MIDtext2');
                           
                    //   }
                   }
                   new_phone2 = phoneNo2.replace(/[-)(]/g,"");
                   document.getElementById("memphone2fam").value = new_phone2;

                   let phoneNo = "";
                    const phoneNoElement = $(res).filter("input#Tele1");
                   if(phoneNoElement.length){
                      phonetext = phoneNoElement[0].value;
                      phoneNo = phonetext.trim();
                      if(phoneNo !="" ){
                        $('#memphonefam').prop('readonly', true);
                        $('#memphonefam').addClass('MIDtext2readonly');
                       }
                       else{
                        $('#memphonefam').prop('readonly', false);
                        $('#memphonefam').removeClass('MIDtext2readonly');
                        $('#memphonefam').addClass('MIDtext2');
                       }
                   }
                   new_phone = phoneNo.replace(/[-)(]/g,"");
                   document.getElementById("memphonefam").value = new_phone;


            let zipcode = "";
                    const zipcodeElement = $(res).filter("input#zip_code");
                   if(zipcodeElement.length){
                    zipcode = zipcodeElement[0].value; 
                   }
                   document.getElementById("mamzipcodefam").value = zipcode;

            let state = "";
                  const stateElement = $(res).filter("input#state");
                 if(stateElement.length){
                   state = stateElement[0].value; 
                 }
                 document.getElementById("memstatefam").value = state; 

            let city = "";
                    const cityElement = $(res).filter("input#city");
                   if(cityElement.length){
                      city = cityElement[0].value; 
                   }
                   document.getElementById("memcityfam").value = city;

                  
            let unit = "";
                    const unitElement = $(res).filter("input#unitAddress");
                    if(unitElement.length){
                    unit = unitElement[0].value; 
                    }
                    document.getElementById("memunitfam").value = unit;

            let streetname = "";
                   const streetnameElement = $(res).filter("input#Address");
                  if(streetnameElement.length){
                    streetname = streetnameElement[0].value; 
                  }
                  document.getElementById("memstreetnamefam").value = streetname;

            let street = "";
                   const streetElement = $(res).filter("input#ressidentalAddress");
                  if(streetElement.length){
                    street = streetElement[0].value; 
                  }
                  document.getElementById("memstreetfam").value = street;      

             
            let memberlname = "";
                  const memberlnameElement = $(res).filter("input#last_name");
                 if(memberlnameElement.length){
                   memberlname = memberlnameElement[0].value; 
                 }
                 document.getElementById("memlnamefam").value = memberlname;


            let memberfname = "";
                  const memberfnameElement = $(res).filter("input#MemberName");
                 if(memberfnameElement.length){
                   memberfname = memberfnameElement[0].value; 
                 }
                 document.getElementById("memfnamefam").value = memberfname;               
            let membershiptype = "";
                  const membershiptypeElement = $(res).filter("input#membershiptype");
                 if(membershiptypeElement.length){
                   membershiptype = membershiptypeElement[0].value; 
                 }
                 document.getElementById("memtypefam").value = membershiptype;          
                  
            let cat = "";
                  const catElement = $(res).filter("input#membercategory");
                 if(catElement.length){
                   cat = catElement[0].value; 
                 }
                 document.getElementById("memcatfam").value = cat;

            let memberid = "";
                    const memberidElement = $(res).filter("input#memberid");
                    if (memberidElement.length) {
                        memberid = memberidElement[0].value;
                    }
                    document.getElementById("memidfam").value = memberid;
                    //checkdatareg(memberid);

                }
            
            });
        } else {
        
            $("#memidfam").val("");Member_id
            $("#memcatfam").val(""); 
            $("#memtypefam").val("");
            $("#memfnamefam").val("");
            $("#memlnamefam").val("");           
            $("#memstreetfam").val("");
            $("#memstreetnamefam").val("");
            $("#memunitfam").val("");
            $("#memcityfam").val("");
            $("#memstatefam").val("");
            $("#mamzipcodefam").val("");
            $("#memphonefam").val("");
            $("#memphone2fam").val("");
            $("#mememailfam").val("");
            $("#mememail2fam").val("");
   
        }
       }
    }
// autocomplete end    



  function getAmount4(){
    var value = $('#ddlStatus').val();
    var value2 = $('#mag').val();
     $('#total_magazine_amount').val(value*value2);
     //get the sum of each column of each row
  var sum_value = 0;
   $('.value4').each(function(){
    sum_value += +$(this).val();
    $('#total_value4').val(sum_value);
  })
    const selectedMode = $("#ddlStatus option:selected").text();
    var collectionMode =   selectedMode.split(":");
     $('#magazinecollectiontype').val(collectionMode[0]);
  }


$("#pul2").change(function () {
    $('#memphonefam').prop('readonly', false);
	$('#mememailfam').prop('readonly', false);
    if ($(this).val() == "Member" || "Non-Member") { 
    $("#showMember").show();
    $("#payment_method").val("");
    $("#stripe_details").hide();
    $("#ddlStatus").val("");
    $("#term").val("");
    $("#memidfam").val("");
    $("#memcatfam").val("");
    $("#memtypefam").val("");
    $("#memfnamefam").val("");
    $("#memlnamefam").val("");
    $("#mag").val("");
    $("#total_value4").val("");
    $("#memstreetfam").val("");
    $("#memstreetnamefam").val("");
    $("#memunitfam").val("");
    $("#memcityfam").val("");
    $("#memstatefam").val("");
    $("#mamzipcodefam").val("");
    $("#memphonefam").val("");
    $("#memphone2fam").val("");
    $("#mememailfam").val("");
    $("#mememail2fam").val("");
} else { 
    $("#showMember").hide();
    $("#stripe_details").hide();
    $("#ddlStatus").val("");
    $("#term").val("");
    $("#memidfam").val("");
    $("#memcatfam").val("");
    $("#memtypefam").val("");
    $("#memfnamefam").val("");
    $("#memlnamefam").val("");
    $("#mag").val("");
    $("#total_value4").val("");
    $("#memstreetfam").val("");
    $("#memstreetnamefam").val("");
    $("#memunitfam").val("");
    $("#memcityfam").val("");
    $("#memstatefam").val("");
    $("#mamzipcodefam").val("");
    $("#memphonefam").val("");
    $("#memphone2fam").val("");
    $("#mememailfam").val("");
    $("#mememail2fam").val("");
}
});

$("#pul2").change(function () {
    $('#memphonefam').prop('readonly', false);
    //$('#memphone2fam').prop('readonly', false);
	$('#mememailfam').prop('readonly', false);
	// $('#memphone2fam').removeClass('MIDtext2readonly');
    //$('#memphone2fam').addClass('MIDtext2');
    if ($(this).val() == "Non-Member") { 
    $("#hide_nm").hide();
    $('#memphonefam').removeClass('MIDtext2readonly');
    $('#memphonefam').addClass('MIDtext2');
    $('#mememailfam').removeClass('MIDtext2readonly');
    $('#mememailfam').addClass('MIDtext2');
} else { 
    $("#hide_nm").show();
    $('#memphonefam').addClass('MIDtext2readonly');
    $('#mememailfam').addClass('MIDtext2readonly');
}
});


$(function () {
$("#ddlStatus").change(function () {
    if ($(this).val() == "Family") { 
    $("#dvFamily").show();
} else {
 $("#dvFamily").hide();
}
});

$("#ddlStatus").change(function () {
    if ($(this).val() == "Individual") { 
    $("#dvIndividual").show();
} else { 
    $("#dvIndividual").hide();
}
});


$("#pul2").change(function () {
    $('#memphonefam').prop('readonly', false);
	$('#mememailfam').prop('readonly', false);
    if ($(this).val() == "Out-of-Towner") { 
    $("#showOut-of-Towner").show();
} else { 
    $("#showOut-of-Towner").hide();
}
});

$("#pul2").change(function () {
    $('#memphonefam').prop('readonly', false);
	$('#mememailfam').prop('readonly', false);
    if ($(this).val() == "Student") { 
    $("#showStudent").show();
} else { 
    $("#showStudent").hide();
}
});


    });
    
    $('#term').on('input', function() {
  $(this).val($(this).val().replace(/[^a-z0-9]/gi, ''));
}); 

 const phoneInputField = document.querySelector("#memphonefam");
    const phoneInput = window.intlTelInput(phoneInputField, {
        // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
        preferredCountries: ["us", "co", "in", "de"],
        utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
    
      const phoneInputField2 = document.querySelector("#memphone2fam");
    const phoneInput2 = window.intlTelInput(phoneInputField2, {
        // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
        preferredCountries: ["us", "co", "in", "de"],
        utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
    
    window.onbeforeunload = function () {
    window.scrollTo(0, 0);
}

 function paymentmethod() {

        var total = $("#total_value4").val();
        var mode_of_collection = $("#ddlStatus").val();
        var mag = $("#mag").val();
        var mememailfam = $("#mememailfam").val();
        var memphone2fam = $("#memphone2fam").val();
        var memphonefam = $("#memphonefam").val();
        var mamzipcodefam = $("#mamzipcodefam").val();
        var memstatefam = $("#memstatefam").val();
        var memcityfam = $('#memcityfam').val();
        var memstreetnamefam = $("#memstreetnamefam").val();
        var memstreetfam = $("#memstreetfam").val();
        var memlnamefam = $("#memlnamefam").val();
        var memfnamefam = $("#memfnamefam").val();
        
              if (!(total >= 1) || mode_of_collection == "" || mag == "" || mememailfam == "" || memphone2fam == "" || memphonefam == "" || mamzipcodefam == "" || memstatefam == "" || memcityfam == "" || memstreetnamefam == "" || memstreetfam == "" || memlnamefam == "" || memfnamefam == ""){
                    alert("Please fill all Required ( * ) fields.");
                    $("#payment_method").val("");
                }else {}

    }
    
    
    /*$('#payment_btn_id').on('click', function() {
    $("#edit_registration").valid();
});*/

$(document).ready(function(e) {
 $('form[id="edit_registration"]').validate({
    submitHandler: function(form) {
      e.preventDefault();
      form.submit();
    }
  });

});
</script>

