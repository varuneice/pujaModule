<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<style>
    .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }

    .puja-wrapper {
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
    }

    .a-box-special a {
        box-sizing: border-box;
        width: 235px;
        text-decoration: none;
        padding: 20px;
        font-size: 16px;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
        cursor: pointer;
        border: none;
    }

    .a-box-special {
        background: red;
    }

    .a-box-special a:focus {
        outline: none;
    }

    .btn_durga {
        background: #fff;
        color: #000;
        border: 2px solid red;
        border-radius: 5px;
        transition: background 400ms ease-out, color 400ms ease-out;
    }

    .btn_durga:hover {
        background: #000;
        color: #fff;
        border-radius: 5px;
    }

    .layout {
        max-width: 100%;
        margin: 0 auto;
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
    }

    .a-box,
    .a-box-special {
        width: 280px;
        height: 150px;
        margin: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        transition: 0.3s;
        padding: 20px;
        font-size: 30px;
    }

    .tab button:hover {
        background-color: #ddd;
        color: #fff;
        padding: 20px;
        font-size: 30px;
    }

    .tab button.active {
        background-color: #100f0f;
        color: #fff;
        padding: 20px;
        font-size: 30px;
    }

    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    #lunch label {
        font-size: 22px;
    }

    #dinner label {
        font-size: 22px;
    }

    #lunch .icheckbox_minimal {
        outline: 2px solid;
    }

    #dinner .icheckbox_minimal {
        outline: 2px solid;
    }

    #dvAdult .icheckbox_minimal {
        outline: 2px solid;
    }

    #dvAdultOutsourced .icheckbox_minimal {
        outline: 2px solid;
    }

    #dvAdultspecial .icheckbox_minimal {
        outline: 2px solid;
    }

    #dvKid .icheckbox_minimal {
        outline: 2px solid;
    }

    #dvKidOutsourced .icheckbox_minimal {
        outline: 2px solid;
    }

    #dvKidspecial .icheckbox_minimal {
        outline: 2px solid;
    }

    .page-title {
        position: relative;
        color: #ffffff;
        padding: 40px 0px 40px;
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .page-title:before {
        position: absolute;
        content: '';
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        display: block;
        background-color: rgba(0, 0, 0, 0.80);
    }

    .page-title .auto-container {
        position: relative;
        z-index: 1;
    }

    .auto-container {
        position: static;
        max-width: 1200px;
        padding: 0px 15px;
        margin: 0 auto;
    }

    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .clearfix::after {
        display: block;
        clear: both;
        content: "";
    }

    .page-title h1 {
        position: relative;
        font-size: 38px;
        line-height: 1.2em;
        font-weight: 700;
        margin-bottom: 20px;
        color: #ffffff;
        padding-left: 30px;
        text-transform: capitalize;
    }

    .page-title .bread-crumb {
        position: relative;
        padding-top: 18px;
        text-align: right;
        margin-right: 30px;
    }

    .page-title .breadcrumb-column h1 {
        position: relative;
        font-family: "Open Sans", Arial, Helvetica, Sans-Serif;
        font-size: 35px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #ffffff;
        padding-right: 10px;
        text-transform: capitalize;
        text-align: right;
        border-right: 3px solid #03a9f4;
    }

    .page-title .breadcrumb-column h3 {
        position: relative;
        font-family: "Open Sans", Arial, Helvetica, Sans-Serif;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #ffffff;
        padding-right: 10px;
        text-transform: capitalize;
        text-align: right;
        border-right: 3px solid #03a9f4;
    }

    .page-title .breadcrumb-column h4 {
        position: relative;
        font-family: "Open Sans", Arial, Helvetica, Sans-Serif;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #ffffff;
        letter-spacing: .5px;
        padding-right: 10px;
        text-transform: capitalize;
        text-align: right;
        border-right: 3px solid #03a9f4;
    }

    .page-title .breadcrumb-column h4 span {
        font-family: "Open Sans", Arial, Helvetica, Sans-Serif;
        color: #03a9f4;
    }

    .page-title .breadcrumb-column h4 a {
        font-family: "Open Sans", Arial, Helvetica, Sans-Serif;
        color: #ffffff;
        text-decoration: none;
    }

    .page-title .bread-crumb li {
        position: relative;
        display: inline-block;
        line-height: 30px;
        margin-left: 25px;
        color: #03a9f4;
        font-size: 16px;
        font-weight: 400;
    }

    .page-title .bread-crumb li:first-child {
        margin-left: 0px;
    }

    .page-title .bread-crumb li:first-child:before {
        content: '/';
        position: absolute;
        right: -20px;
        top: 0px;
        width: 15px;
        color: #ffffff;
        text-align: center;
        line-height: 30px;
    }

    .sidebar-side .sidebar {
        padding: 30px 25px 25px;
        border-radius: 5px;
        border: 1px solid #e1e1e1;
    }

    .sidebar-title {
        position: relative;
        margin-bottom: 22px;
    }

    .sidebar-title h2 {
        position: relative;
        color: #333333;
        font-size: 20px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .help-widget .text {
        position: relative;
        color: #777777;
        font-size: 18px;
        line-height: 1.9em;
        margin-bottom: 15px;
    }

    .widget-content p {
        font-size: 20px;
    }

    .widget-content p span {
        color: #03a9f4;
    }

    .help-widget .list {
        position: relative;
    }

    .help-widget .list li {
        position: relative;
        color: #777777;
        font-size: 14px;
        line-height: 1.9em;
        padding-left: 30px;
        margin-bottom: 8px;
    }

    select.choice {
        width: 100%;
        padding: 14px;
        font-size: 24px;
        color: #fff;
        background-color: #03a9f4;
        border-radius: 15px;
    }

    select.choiceA {
        width: 106%;
        padding: 8px;
        font-size: 16px;
        color: #fff;
        background-color: #03a9f4;
        border-radius: 15px;
    }

    select.choice2 {
        width: 100%;
        padding: 12px;
        font-size: 20px;
        margin-top: 20px;
        color: #fff;
        background-color: #03a9f4;
        border-radius: 15px;
    }

    select.choice3 {
        width: 100%;
        padding: 14px;
        font-size: 22px;
        margin-top: 0px;
        color: #fff;
        background-color: #03a9f4;
        border-radius: 15px;
    }

    select.choice4 {
        width: 100%;
        font-size: 20px;
        color: #fff;
        background-color: #03a9f4;
        border-radius: 10px;
    }

    select.year {
        width: 100%;
        padding: 14px;
        padding: 12px;
        font-size: 20px;
        margin-top: 20px;
        border-radius: 10px;
    }

    input.MIDnumber {
        width: 100%;
        padding: 12px;
        font-size: 20px;
        margin-top: 3px;
        border-radius: 10px;
    }

    input.MIDtext {
        padding: 10px;
        margin-top: 3px;
        border-radius: 10px;
    }

    input.MIDtext2 {
        padding: 12px;
        font-size: 20px;
        margin-top: 20px;
        border-radius: 10px;
        width: 100%;
    }

    input.MIDtext2readonly {
        padding: 12px;
        font-size: 20px;
        margin-top: 20px;
        pointer-events: none;
        background-color: gainsboro;
        border-radius: 10px;
        width: 100%;
    }

    input.number {
        padding: 12px;
        width: 100%;
        font-size: 20px;
        margin-top: 20px;
        border-radius: 10px;
    }

    .checkbox label {
        font-size: 14px;
        font-weight: 600;
        display: block;
        color: #03a9f4;
        margin: 36px 0px 0px 36px !important;
    }

    input.lookup {
        width: 100%;
        padding: 12px;
        font-size: 20px;
        border-radius: 10px;
    }

    button.lookup_btn {
        padding: 5px;
        font-size: 21px;
        border-radius: 10px;
        width: 50%;
        background-color: #03a9f4;
        color: #fff;
        font-weight: 600;
    }

    h4.item_heading {
        font-size: 26px;
        font-weight: 600;
    }

    p.item_count {
        color: #03a9f4;
        font-size: 22px;
        font-weight: 600;
        border-right: 3px solid #000;
        text-align: right;
        margin: 0px 0px 0px 0px;
        padding: 0px 10px 0px 0px;
    }

    p.item_count2 {
        text-align: right;
        font-weight: 600;
        font-size: 18px;
    }

    p.item_heading2 {
        font-size: 12px;
        font-weight: 600;
    }

    h4.item_heading2 {
        font-size: 16px;
        font-weight: 600;
    }

    h5.card_details {
        font-size: 18px;
        font-weight: 600;
    }

    h3.card_details {
        text-align: left;
        font-size: 18px;
        font-weight: 600;
        font-family: inherit;
    }

    p.card_details {
        font-size: 19px;
        color: #03a9f4;
    }

    span.payment_for {
        color: #03a9f4;
    }

    .col-md-12.collection {
        padding-top: 20px;
    }

    button.payment_btn {
        padding: 10px;
        font-size: 20px;
        border-radius: 10px;
        width: 100%;
        background-color: #03a9f4;
        color: #fff;
        font-weight: 600;
    }

    button.go_cart_btn {
        padding: 10px;
        font-size: 22px;
        border-radius: 10px;
        width: 100%;
        background-color: #000;
        color: #fff;
        margin-top: 30px;
        font-weight: 600;
    }

    .text_placeholders {
        position: relative;
        color: #03a9f4;
        font-weight: 600;
        letter-spacing: 0.7px;
        font-size: 14px;
        line-height: 25px;
    }

    .asso_pay a {
        text-decoration: none;
        font-size: 14px;
        margin: 0px;
        line-height: 65px;
        font-weight: 600;
        text-transform: uppercase;
        padding: 15px 15px 15px 15px;
        background-color: #000;
        color: #fff;
        letter-spacing: 0.5px;
    }

    .asso_pay a:hover {
        text-decoration: none;
        font-size: 14px;
        margin: 0px;
        line-height: 65px;
        font-weight: 600;
        text-transform: uppercase;
        padding: 15px 15px 15px 15px;
        background-color: #03a9f4;
        color: #fff;
        letter-spacing: 0.5px;
    }

    .myDiv {
        display: none;
    }

    #showOne {
        border: 1px solid red;
    }

    #showTwo {
        border: 1px solid green;
    }

    #showThree {
        border: 1px solid blue;
    }

    input#yesMG {
        width: 10%;
    }

    .clear {
        clear: both;
    }

    .close {
        text-align: right !important;
        padding-right: 10px;
        font-size: 40px;
        color: red;
        opacity: .8;
    }

    .popup_title {
        padding: 5px;
        margin-top: -30px;
    }

    .modal-content {
        width: 80% !important;
        margin: 160px auto auto auto !important;
    }

    .input-sm {
        font-size: 16px !important;
    }

    #payment_btn_id {
        padding: 10px;
        font-size: 22px;
        border-radius: 10px;
        width: 100%;
        background-color: #000;
        color: #fff;
        margin-top: 30px;
        font-weight: 600;
    }

    /* Extra small devices (phones, 600px and down) */
    @media only screen and (max-width: 600px) {
        .col-md-6.phone {
            padding-top: 20px;
        }
    }

    /* Small devices (portrait tablets and large phones, 600px and up) */
    @media only screen and (min-width: 600px) {
        .col-md-6.phone {
            padding-top: 20px;
        }
    }

    /* Medium devices (landscape tablets, 768px and up) */
    @media only screen and (min-width: 768px) {}

    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (min-width: 992px) {
        .col-md-6.phone {
            padding-top: 20px;
        }
    }

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {
        .col-md-6.phone {
            padding-top: 20px;
        }

        input#memphonefam {
            width: 348px;
        }

        input#memphone2fam {
            width: 348px;
        }
    }

    @media only screen and (min-width: 1400px) {
        .col-md-6.phone {
            padding-top: 20px;
        }

        input#memphonefam {
            width: 416px;
        }

        input#memphone2fam {
            width: 416px;
        }
    }

    .sessionCode {
        width: 45%;
        padding: 10px;
        font-size: 18px;
        color: #fff;
        background-color: #03a9f4;
        border-radius: 10px;
        margin: 20px 0px;
        /* text-align: center; */
        margin-left: 20px;
    }
</style>
<title>Puja Food Coupons</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />

<!-- Start -->




<!-- End -->

<section class="page-title" style="background-image:url(https://durgabari.org/HDBS_Puja_Payments/12.jpg); display:none;">
    <div class="auto-container">
        <div class="row clearfix">
            <!--Title -->
            <div class="title-column col-lg-6 col-md-12 col-sm-12">
                <img style="float:left;padding:20px" src="../../1.svg" width="35%">
                <img style="border-radius: 96px;float: left;padding: 0px;" src="../../puja_logo.png" width="37%">
            </div>
            <!--Bread Crumb -->
            <div  class="breadcrumb-column col-lg-6 col-md-12 col-sm-12">
                <!-- <h1>Houston Durga Bari Society</h1> -->
                <!-- <h3>
                    <?php
                    $currentYear = date('Y');
                    $nextYear = date('Y') + 1;
                    echo "" . $currentYear . " - " . $nextYear . " Puja Online System ";
                    ?>
                </h3> -->
                <!-- <h3>Payment for Puja Food Coupons</h3> -->
                <ul class="bread-crumb clearfix">
                    <li><a style="text-decoration:none;color:#fff;" href="#">Home</a></li>
                    <li class="active">Puja Food Coupon</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<br><br>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$memberType = $tpl['userData']['regmember'];
$couponSessionCode = $tpl['userData']['sessionCode'];
$couponSessionName = $tpl['userData']['sessionName'];
?>

<form id="edit_Pujafoodcoupondata" class="frm-class booking-frm-class" action="" method="post" name="ProcessFoodCouponPayment">

    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-md-8 col-sm-12">

                <div style="border-left: 3px solid #03a9f4; border-right: 3px solid #03a9f4; padding: 10px; border-bottom: 3px solid #03a9f4;"
                    class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <select style="pointer-events: none; " required="" name="regmember" id="registrationmember" class="choice" aria-required="true"
                            aria-invalid="false">
                            <option value="">Returning or New User *</option>
                            <option value="member">Returning User</option>
                            <option value="nonmember">New User</option>  
                        </select>
                    </div>


                    <div id="termdiv" class="col-lg-12 col-md-12 col-sm-12">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                        <select required="" name="sessionCode" id="ddlCouponType" class="choice" aria-required="true" aria-invalid="false" style="pointer-events: none; margin-top: 20px;">
                        <?php foreach (($tpl['foodcoupon'] ?? []) as $value) {?>
                                    <option value="<?php echo $value['sessionCode']; ?>">
                                        <span style="font-size: 10px;">
                                            <?php echo $value['sessionName']; ?>
                                        </span>
                                    </option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="sessionName" id="selectedSessionName" value="">
                            <div class="text_placeholders">Coupon Type *</div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <input id="idmem" class="MIDtext2readonly" type="text" name="member_id" size="25" value="<?php echo $tpl['userData']['member_id'];?>" title="<?php echo __('Member Id'); ?>" placeholder="Verified Member ID *" readonly>
                            <div class="text_placeholders">Verified Member ID *</div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <input autocomplete="off" id="first_name" class="MIDtext2" type="text" name="F_Name" size="25" value="<?php echo $tpl['userData']['F_Name']; ?>"
                            title="<?php echo __('First Name'); ?>" placeholder="First Name *" required="">
                        <div class="text_placeholders">First Name *</div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <input autocomplete="off" id="second_name" class="MIDtext2" type="text" name="L_Name" size="25" value="<?php echo $tpl['userData']['L_Name']; ?>" title="<?php echo __('Last Name'); ?>" placeholder="Last Name*" required="">
                        <div class="text_placeholders">Last Name *</div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <input autocomplete="off" id="city" class="MIDtext2" type="text" name="City" size="25" value="<?php echo $tpl['userData']['City']; ?>" 
                            title="<?php echo __('City'); ?>" placeholder="City *" required="">
                        <div class="text_placeholders">City *</div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <input autocomplete="off" id="state" class="MIDtext2" type="text" name="State" size="25"
                            value="<?php echo $tpl['userData']['State']; ?>"   title="<?php echo __('State'); ?>"
                            placeholder="State *" required="">
                        <div class="text_placeholders">State *</div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <input autocomplete="off" id="zip" class="MIDtext2" type="text" name="Zip" size="25" value="<?php echo $tpl['userData']['Zip']; ?>" required=""
                            title="<?php echo __('Zip_Code'); ?>" placeholder="Zip Code *">
                        <div class="text_placeholders">Zip Code *</div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <input autocomplete="off" id="phone" class="MIDtext2" type="text" name="phone" size="25" value="<?php echo $tpl['userData']['phone']; ?>" title="phone"
                            onchange="checkmobileno(this.id)" maxlength="10" placeholder="##########" required="">
                        <div class="text_placeholders">Mobile Number *</div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <input autocomplete="off" id="email" required="" class="MIDtext2" type="text" name="email" size="25" value="<?php echo $tpl['userData']['email']; ?>" title="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" placeholder="name@company.com">
                        <div class="text_placeholders">Email ID *</div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <input autocomplete="off" id="adultCoupon" class="MIDtext2" type="number" name="Adult_Coupon_Req"  value="<?php echo $tpl['userData']['Adult_Coupon_Req']; ?>" title="adult" max="4">
                        <div class="text_placeholders">Adult Coupon # Request</div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <input autocomplete="off" id="kidCoupon" class="MIDtext2" type="number" name="Kid_Coupon_Req"  value="<?php echo $tpl['userData']['Kid_Coupon_Req']; ?>" title="kid" maxlength="3">
                        <div class="text_placeholders">Child Coupon # Request</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:20px;">
                            <div class="col-lg-6 col-md-6 col-sm-6" id="lunch">
                                <label for="chkLunch">
                                    <input type="checkbox" id="chkLunch" name="coupontype" value="Lunch" />
                                    LUNCH
                                </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6" id="dinner">
                                <label for="chkDinner">
                                    <input type="checkbox" id="chkDinner" name="coupontype" value="Dinner" />
                                    DINNER
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom: 20px;">
                                <div id="dvAdult" style="display: none;">
                                    <input type="checkbox" id="chkAdult" />
                                    <strong
                                        style="padding: 4px; font-size: 14px; text-transform: uppercase; color: #03a9f4;">Adult
                                        Regular</strong>
                                </div>
                                <div id="dvAdultcoupon" style="display: none;margin-top:20px;">
                                    <input type="number" class="MIDnumber" onblur="findTotal()" onChange="multiplyBy()"
                                        value="" name="number_of_adult_coupon" placeholder="No. of Coupons"
                                        id="NumberofAdult" />
                                    <br>
                                    <?php
                                    $count = count($tpl['foodcouponpricearr']);
                                    //echo $count;
                                    $status_arr = __('status_arr');
                                    if ($count > 0) {
                                        for ($i = 0; $i < $count; $i++) {
                                            $code = $tpl['foodcouponpricearr'][$i]['code'];
                                            //echo $code;
                                            if ($code == 'F1') {
                                    ?>
                                                <input type="hidden" value="<?php echo $tpl['foodcouponpricearr'][$i]['price']; ?>"
                                                    id="AdultPercouponprice" />
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <br>
                                    <input type="hidden" value="" id="AdultTotalcouponprice" class="amount" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom: 20px;">
                                <div id="dvAdultOutsourced" style="display: none;">
                                    <input type="checkbox" id="chkAdultOutsourced" />
                                    <strong
                                        style="padding: 4px; font-size: 14px; text-transform: uppercase; color: #03a9f4;">Adult
                                        Outsourced</strong>
                                </div>
                                <div id="dvAdultOutsourcedcoupon" style="display: none;margin-top:20px;">
                                    <input type="number" class="MIDnumber" onblur="findTotal()" onChange="multiplyBy5()"
                                        value="" name="number_of_adult_outsourced_coupon" placeholder="No. of Coupons"
                                        id="NumberofAdultOutsourced" />
                                    <br>
                                    <?php
                                    $count = count($tpl['foodcouponpricearr']);
                                    //echo $count;
                                    $status_arr = __('status_arr');
                                    if ($count > 0) {
                                        for ($i = 0; $i < $count; $i++) {
                                            $code = $tpl['foodcouponpricearr'][$i]['code'];
                                            //echo $code;
                                            if ($code == 'F2') {
                                    ?>
                                                <input type="hidden" value="<?php echo $tpl['foodcouponpricearr'][$i]['price']; ?>"
                                                    id="AdultOutsourcedPercouponprice" />
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <br>
                                    <input type="hidden" value="" id="AdultOutsourcedTotalcouponprice" class="amount" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom: 20px;">
                                <div id="dvAdultspecial" style="display: none;">
                                    <input type="checkbox" id="chkAdultspecial" />
                                    <strong
                                        style="padding: 4px; font-size: 14px; text-transform: uppercase; color: #03a9f4;">Adult
                                        Special</strong>
                                </div>
                                <div id="dvAdultspecialcoupon" style="display: none;margin-top:20px;">
                                    <input type="number" class="MIDnumber" onblur="findTotal()" onChange="multiplyBy2()"
                                        value="" name="number_of_adult_special_coupon" placeholder="No. of Coupons"
                                        id="NumberofAdultspecial" />
                                    <br>
                                    <?php
                                    $count = count($tpl['foodcouponpricearr']);
                                    //echo $count;
                                    $status_arr = __('status_arr');
                                    if ($count > 0) {
                                        for ($i = 0; $i < $count; $i++) {
                                            $code = $tpl['foodcouponpricearr'][$i]['code'];
                                            //echo $code;
                                            if ($code == 'F3') {
                                    ?>
                                                <input type="hidden" value="<?php echo $tpl['foodcouponpricearr'][$i]['price']; ?>"
                                                    id="AdultspecialPercouponprice" />
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <br>
                                    <input type="hidden" value="" id="AdultspecialTotalcouponprice" class="amount" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom: 20px;">
                                <div id="dvKid" style="display: none;">
                                    <input type="checkbox" id="chkKid" />
                                    <strong
                                        style="padding: 4px; font-size: 14px; text-transform: uppercase; color: #03a9f4;">Kid
                                        / Student Regular</strong>
                                </div>
                                <div id="dvKidcoupon" style="display: none;margin-top:20px;">
                                    <input type="number" class="MIDnumber" onblur="findTotal()" onChange="multiplyBy3()"
                                        value="" name="number_of_kid_coupon" placeholder="No. of Coupons"
                                        id="NumberofKid" />
                                    <br>
                                    <?php
                                    $count = count($tpl['foodcouponpricearr']);
                                    //echo $count;
                                    $status_arr = __('status_arr');
                                    if ($count > 0) {
                                        for ($i = 0; $i < $count; $i++) {
                                            $code = $tpl['foodcouponpricearr'][$i]['code'];
                                            //echo $code;
                                            if ($code == 'F4') {
                                    ?>
                                                <input type="hidden" value="<?php echo $tpl['foodcouponpricearr'][$i]['price']; ?>"
                                                    id="KidPercouponprice" />
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <br>
                                    <input type="hidden" value="" id="KidTotalcouponprice" class="amount" />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom: 20px;">
                                <div id="dvKidOutsourced" style="display: none;">
                                    <input type="checkbox" id="chkKidOutsourced" />
                                    <strong
                                        style="padding: 4px; font-size: 14px; text-transform: uppercase; color: #03a9f4;">Kid
                                        / Student Outsourced</strong>
                                </div>
                                <div id="dvKidOutsourcedcoupon" style="display: none;margin-top:20px;">
                                    <input type="number" class="MIDnumber" onblur="findTotal()" onChange="multiplyBy6()"
                                        value="" name="number_of_kid_outsourced_coupon" placeholder="No. of Coupons"
                                        id="NumberofKidOutsourced" />
                                    <br>
                                    <?php
                                    $count = count($tpl['foodcouponpricearr']);
                                    //echo $count;
                                    $status_arr = __('status_arr');
                                    if ($count > 0) {
                                        for ($i = 0; $i < $count; $i++) {
                                            $code = $tpl['foodcouponpricearr'][$i]['code'];
                                            //echo $code;
                                            if ($code == 'F5') {
                                    ?>
                                                <input type="hidden" value="<?php echo $tpl['foodcouponpricearr'][$i]['price']; ?>"
                                                    id="KidOutsourcedPercouponprice" />
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <br>
                                    <input type="hidden" value="" id="KidOutsourcedTotalcouponprice" class="amount" />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom: 20px;">
                                <div id="dvKidspecial" style="display: none;">
                                    <input type="checkbox" id="chkKidspecial" />
                                    <strong
                                        style="padding: 4px; font-size: 14px; text-transform: uppercase; color: #03a9f4;">Kid
                                        / Student Special</strong>
                                </div>
                                <div id="dvKidspecialcoupon" style="display: none;margin-top:20px;">
                                    <input type="number" class="MIDnumber" onblur="findTotal()" onChange="multiplyBy4()"
                                        value="" name="number_of_kid_special_coupon" placeholder="No. of Coupons"
                                        id="NumberofKidspecial" />
                                    <br>
                                    <?php
                                    $count = count($tpl['foodcouponpricearr']);
                                    //echo $count;
                                    $status_arr = __('status_arr');
                                    if ($count > 0) {
                                        for ($i = 0; $i < $count; $i++) {
                                            $code = $tpl['foodcouponpricearr'][$i]['code'];
                                            //echo $code;
                                            if ($code == 'F6') {
                                    ?>
                                                <input type="hidden" value="<?php echo $tpl['foodcouponpricearr'][$i]['price']; ?>"
                                                    id="KidspecialPercouponprice" />
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <br>
                                    <input type="hidden" value="" id="KidspecialTotalcouponprice" class="amount" />
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom: 30px;">
                        <input data-rule-required="true" id="totalcost" class="MIDtext2readonly" type="number"
                            name="amount" size="25" value="" title="Amount" placeholder="$ Amount *" readonly>
                        <div class="text_placeholders">Requested Amount to Pay ($) *</div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12" id="paymentdropdown">


                        <select name="PaymentOption" id="PaymentOption" class="choice" required>
                            <option value="">Please Select Payment Method *</option>
                            <option value="check">Check</option>
                            <option value="cash">Cash</option>
                          <!--  <option value="directdeposit">Online Deposit</option> -->
                            <option value="stripe">Credit card</option>
                            <!-- <option value="others">Zelle (Preferred)</option> -->
                            <option value="sumup">Sumup</option>
                        </select>
                        <div class="text_placeholders">Payment Method *</div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
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
                                <tr class="tr" id="MemberID1" style="display: none;" class="form-group">
                                    <td class="td"><button style="display: none;float:left!important;" type="button"
                                            id="checkPaymentData">Get Zelle Payment Details</button></td>
                                    <td class="td" colspan="3"><select data-rule-required='true' id="MemberID"
                                            name="oid" class="form-control input-sm"
                                            style="font-weight: bold;float:right!important;">
                                            <option value="">Please select your payment details</option>
                                            <?php
                                            foreach (($tpl['Amount'] ?? []) as $key => $value) {
                                            ?>

                                                <option value="<?php echo $value['Amount']; ?>">
                                                    <?php echo $value['Amount']; ?></option>
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
                    </div>

                    <!-- check dropdown-->
                    <div class="box-body" style="display:none" id="checkdata">
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped" style="margin-top: -88px;">
                                <thead>
                                    <tr>
                                        <th>Bank Name</th>
                                        <th>Check No</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="td"><input style="WIDTH: 100%;" type="text" id="checkbankname"
                                                name="checkbankname" class="form-control input-sm" value=""></td>
                                        <td class="td"><input style="WIDTH: 100%;" type="number" id="checkno"
                                                name="checkno" class="form-control input-sm" value=""></td>
                                        <td class="td"><input style="WIDTH: 100%;" type="number" id="checkamount"
                                                name="checkAmount" class="form-control input-sm" value=""></td>
                                        <td class="td"><input style="WIDTH: 100%;" type="date" id="checkdate"
                                                name="CheckDate" class="form-control input-sm" value="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--check dropdown end-->
                    <!-- cash start-->

                    <div class="box-body" style="display:none" id="cashdata">
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped" style="margin-top: -88px;">
                                <thead>
                                    <tr>
                                        <th>Processed By</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="td"><input style="WIDTH: 100%;" type="text" id="receiveby"
                                                name="receiveby" class="form-control input-sm" value="">
                                        </td>
                                        <td class="td"><input style="WIDTH: 100%;" type="number" id="cashamount"
                                                name="cashAmount" class="form-control input-sm" value=""></td>
                                        <td class="td"><input style="WIDTH: 100%;" type="date" id="cashdate"
                                                name="cashDate" class="form-control input-sm" value="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- cash end-->
                    <!-- Direct deposit-->
                    <div class="box-body" style="display:none" id="directdepositedata">
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped" style="margin-top: -88px;">
                                <thead>
                                    <tr>
                                        <th>Financial Entity</th>
                                        <th>Transaction Code</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="td"><input style="WIDTH: 100%;" type="text" id="bankname"
                                                name="BankName" class="form-control input-sm" value=""></td>
                                        <td class="td"><input style="WIDTH: 100%;" type="text" id="ISFCCode"
                                                name="ISFCCode" class="form-control input-sm" value=""></td>
                                        <td class="td"><input style="WIDTH: 100%;" type="number" id="directamount"
                                                name="directamount" class="form-control input-sm" value=""></td>
                                        <td class="td"><input style="WIDTH: 100%;" type="date" id="directdepositdate"
                                                name="transactiondate" class="form-control input-sm" value="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Direct deposit end-->

                    <!-- New Sumup -->

                    <table class="table table-bordered table-hover table-striped"
                        style="display:none;margin-top: -42px;" id="Sumupdata">
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

                    <!-- End -->

                    <tr style="display:none;">
                        <td class="td" style="display:none;"> <input id="paydesc" class="form-control input-sm"
                                type="text" name="paydesc" style="display:none;"> </td>
                    </tr>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <input id="Zellecode" class="form-control input-sm" type="text" name="code"
                            style="display:none;">
                        <input type="hidden" name="create_Pujafoodcoupon" value="1" />
                        <!-- <button id="submit" class="btn btn-primary" autocomplete="off" value="Save" name="Payment"
                        tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;
                        <?php echo __('save'); ?>
                    </button> -->

                        <button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save"
                            name="Payment" tabindex="17" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Make
                            Payment</button>
                    </div>
                    <input type="hidden" name="foodcoupon_payment" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['userData']['id']; ?>" />
                    <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                    <div id="stripe_secret_key_id" style="display: none">
                        <?php echo $tpl['option_arr_values']['stripe_publish_key']; ?></div>

                </div>

            </div>

            <div class="sidebar-side col-lg-4 col-md-12 col-sm-12" style="display:none;">

                <aside class="sidebar">



                    <!-- Help Widget -->

                    <div class="sidebar-widget help-widget">
                        <div class="sidebar-title">
                            <h2><span style="color: #03a9f4;">Need</span> Help?</h2>
                        </div>
                        <div class="widget-content">
                            <div class="text">If you have any questions, please contact us</div>
                            <p style="padding-bottom:30px;"><span><i class="fa fa-envelope"
                                        aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;"
                                    href="mailto:registration@durgabari.org"> registration@durgabari.org</a></p>
                            <!-- <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;" href="tel:+18326909062"> <strong style="font-size:26px;">+1 832-690-9062</strong> <br><span style="font-size:20px;color:#000;">Joy Mitra</span></a></p>-->
                        </div>
                    </div>

                </aside>
            </div>

        </div>

    </div>

</form>
<div id="dialogSlots" title="<?php echo __('tooltip_selected_slots'); ?>" style="display:none">
    <div name="dialogSlotsDivId" id="dialogSlotsDivId">
    </div>
</div>

<script>
    // Checkphoneno
    function checkmobileno(elem) {

        const phonenumber = $("#phone").val();
        if (!!phonenumber) {
            if (isNaN(phonenumber)) {
                alert("Please Enter mobile Number");
                $("#payment_btn_id").addClass('disabled');
            } else if (phonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#payment_btn_id").addClass('disabled');
            } else if (phonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#payment_btn_id").addClass('disabled');
            } else if (phonenumber.length == 10) {
                $("#payment_btn_id").removeClass('disabled');
            } else {
                $("#payment_btn_id").removeClass('disabled');
            }
        } else {
            $("#phone").prop('required', true);
            $("#payment_btn_id").removeClass('disabled');
        }
    }

    function membercheck() {

        // var selectedString = select.options[select.selectedIndex].value;
        var checkdata = $("#registrationmember").val();
        //var checkdata = selectedString;

        if (checkdata == "member") {
            //$('#term option:not(:selected)').attr('disabled', false);
            document.getElementById('termdiv').style.display = "block";

        } else {
            document.getElementById('termdiv').style.display = "none";


        }
    }

    $(function() {
        //
        $("#term").autocomplete({
            //source: "http://localhost/HDBS_Payment/pujaModule/ajax-db-search.php",
            source: '<?php echo INSTALL_URL; ?>ajax-db-search.php',
            select: function(event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                MemberSelectdonation();
            }
        });
    });

    //autocomplete  
    function MemberSelectdonation() {
        var url2 = $("#container-abc-url-id").text();

        var self = this;
        var data = $("#termMember").val();
        var term = $("#term").val();
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
                    success: function(res) {

                        //var Membertext = $("#MemberSelectValue").text();
                        //document.getElementById("MemberSelect").value = Membertext;
                        let MemberName = "";

                        const memberNameElement = $(res).filter("input#MemberName");
                        if (memberNameElement.length) {
                            MemberName = memberNameElement[0].value;
                        }
                        document.getElementById("first_name").value = MemberName;


                        let LastName = "";
                        const LastNameElement = $(res).filter("input#last_name");
                        if (LastNameElement.length) {
                            LastName = LastNameElement[0].value;
                        }
                        document.getElementById("second_name").value = LastName;



                        let memberid = "";
                        const memberElement = $(res).filter("input#memberid");
                        if (memberElement.length) {
                            memberid = memberElement[0].value;
                        }
                        document.getElementById("idmem").value = memberid;


                        let phoneNo = "";
                        let MNo = "";
                        const phoneNoElement = $(res).filter("input#phone_work");
                        if (phoneNoElement.length) {
                            phoneNo = phoneNoElement[0].value;
                            phoneNo = phoneNo.replace("-", "");
                            MNo = phoneNo;
                            MNo = MNo.replace("-", "");
                        }
                        new_phone = MNo.replace(/[-)(]/g, "");
                        document.getElementById("phone").value = new_phone;

                        let email = "";
                        const emailElement = $(res).filter("input#email");
                        if (emailElement.length) {
                            email = emailElement[0].value;
                        }
                        document.getElementById("email").value = email;

                        let state = "";
                        const stateElement = $(res).filter("input#state");
                        if (stateElement.length) {
                            state = stateElement[0].value;
                        }
                        document.getElementById("state").value = state;

                        let city = "";
                        const cityElement = $(res).filter("input#city");
                        if (cityElement.length) {
                            city = cityElement[0].value;
                        }
                        document.getElementById("city").value = city;


                        let zipcode = "";
                        const zipcodeElement = $(res).filter("input#zip_code");
                        if (zipcodeElement.length) {
                            zipcode = zipcodeElement[0].value;
                        }
                        document.getElementById("zip").value = zipcode;

                    }

                });
            } else {
                $("#MemberName").val("");
                $("#phone").val("");
                $("#Your_E-mail").val("");
                $("#memberid").val("");
                $("#spousename").val("");
                $("#Street").val("");
                $("#ressidentalAddress").val("");
                $("#state").val("");
                $("#city").val("");
                $("#zip_code").val("");
                $("#phone").val("");
                $("#email").val("");
                $("#MembCategory").val("");

            }
        }
    }


    $('input:checkbox[id=chkLunch]').on('ifChecked', function(event) {
        //alert("Lunch");
        $("#dvAdult").show();
        $("#dvAdultOutsourced").show();
        $("#dvAdultspecial").show();
        $("#dvKid").show();
        $("#dvKidOutsourced").show();
        $("#dvKidspecial").show();

        $("#dinner").hide();

        $("#NumberofAdult").hide();
        $("#NumberofAdultOutsourced").hide();
        $("#NumberofAdultspecial").hide();
        $("#NumberofKid").hide();
        $("#NumberofKidOutsourced").hide();
        $("#NumberofKidspecial").hide();

        $("#dvAdultcoupon").hide();
        $("#dvAdultOutsourcedcoupon").hide();
        $("#dvAdultspecialcoupon").hide();
        $("#dvKidcoupon").hide();
        $("#dvKidOutsourcedcoupon").hide();
        $("#dvKidspecialcoupon").hide();

        $("#NumberofAdult").val("");
        $("#AdultTotalcouponprice").val("");

        $("#NumberofAdultOutsourced").val("");
        $("#AdultOutsourcedTotalcouponprice").val("");

        $("#NumberofAdultspecial").val("");
        $("#AdultspecialTotalcouponprice").val("");

        $("#NumberofKid").val("");
        $("#KidTotalcouponprice").val("");

        $("#NumberofKidOutsourced").val("");
        $("#KidOutsourcedTotalcouponprice").val("");

        $("#NumberofKidspecial").val("");
        $("#KidspecialTotalcouponprice").val("");

        $('input[id="chkAdult"]').removeAttr('checked').iCheck('update');
        $('input[id="chkAdultOutsourced"]').removeAttr('checked').iCheck('update');
        $('input[id="chkAdultspecial"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKid"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKidOutsourced"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKidspecial"]').removeAttr('checked').iCheck('update');


        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;
    });

    $('input:checkbox[id=chkLunch]').on('ifUnchecked', function(event) {
        //alert("No Lunch");
        $("#dvAdult").hide();
        $("#dvAdultOutsourced").hide();
        $("#dvAdultspecial").hide();
        $("#dvKid").hide();
        $("#dvKidOutsourced").hide();
        $("#dvKidspecial").hide();

        $("#dinner").show();

        $("#NumberofAdult").hide();
        $("#NumberofAdultOutsourced").hide();
        $("#NumberofAdultspecial").hide();
        $("#NumberofKid").hide();
        $("#NumberofKidOutsourced").hide();
        $("#NumberofKidspecial").hide();

        $("#dvAdultcoupon").hide();
        $("#dvAdultOutsourcedcoupon").hide();
        $("#dvAdultspecialcoupon").hide();
        $("#dvKidcoupon").hide();
        $("#dvKidOutsourcedcoupon").hide();
        $("#dvKidspecialcoupon").hide();

        $("#NumberofAdult").val("");
        $("#AdultTotalcouponprice").val("");

        $("#NumberofAdultOutsourced").val("");
        $("#AdultOutsourcedTotalcouponprice").val("");

        $("#NumberofAdultspecial").val("");
        $("#AdultspecialTotalcouponprice").val("");

        $("#NumberofKid").val("");
        $("#KidTotalcouponprice").val("");

        $("#NumberofKidOutsourced").val("");
        $("#KidOutsourcedTotalcouponprice").val("");

        $("#NumberofKidspecial").val("");
        $("#KidspecialTotalcouponprice").val("");

        $('input[id="chkAdult"]').removeAttr('checked').iCheck('update');
        $('input[id="chkAdultOutsourced"]').removeAttr('checked').iCheck('update');
        $('input[id="chkAdultspecial"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKid"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKidOutsourced"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKidspecial"]').removeAttr('checked').iCheck('update');

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;
    });



    $('input:checkbox[id=chkDinner]').on('ifChecked', function(event) {
        //alert("Dinner");
        $("#dvAdult").show();
        $("#dvAdultOutsourced").show();
        $("#dvAdultspecial").show();
        $("#dvKid").show();
        $("#dvKidOutsourced").show();
        $("#dvKidspecial").show();

        $("#lunch").hide();

        $("#NumberofAdult").hide();
        $("#NumberofAdultOutsourced").hide();
        $("#NumberofAdultspecial").hide();
        $("#NumberofKid").hide();
        $("#NumberofKidOutsourced").hide();
        $("#NumberofKidspecial").hide();

        $("#dvAdultcoupon").hide();
        $("#dvAdultOutsourcedcoupon").hide();
        $("#dvAdultspecialcoupon").hide();
        $("#dvKidcoupon").hide();
        $("#dvKidOutsourcedcoupon").hide();
        $("#dvKidspecialcoupon").hide();

        $("#NumberofAdult").val("");
        $("#AdultTotalcouponprice").val("");

        $("#NumberofAdultOutsourced").val("");
        $("#AdultOutsourcedTotalcouponprice").val("");

        $("#NumberofAdultspecial").val("");
        $("#AdultspecialTotalcouponprice").val("");

        $("#NumberofKid").val("");
        $("#KidTotalcouponprice").val("");

        $("#NumberofKidOutsourced").val("");
        $("#KidOutsourcedTotalcouponprice").val("");

        $("#NumberofKidspecial").val("");
        $("#KidspecialTotalcouponprice").val("");

        $('input[id="chkAdult"]').removeAttr('checked').iCheck('update');
        $('input[id="chkAdultOutsourced"]').removeAttr('checked').iCheck('update');
        $('input[id="chkAdultspecial"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKid"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKidOutsourced"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKidspecial"]').removeAttr('checked').iCheck('update');

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;

    });

    $('input:checkbox[id=chkDinner]').on('ifUnchecked', function(event) {
        //alert("No Dinner");
        $("#dvAdult").hide();
        $("#dvAdultOutsourced").hide();
        $("#dvAdultspecial").hide();
        $("#dvKid").hide();
        $("#dvKidOutsourced").hide();
        $("#dvKidspecial").hide();

        $("#lunch").show();

        $("#NumberofAdult").hide();
        $("#NumberofAdultOutsourced").hide();
        $("#NumberofAdultspecial").hide();
        $("#NumberofKid").hide();
        $("#NumberofKidOutsourced").hide();
        $("#NumberofKidspecial").hide();

        $("#dvAdultcoupon").hide();
        $("#dvAdultOutsourcedcoupon").hide();
        $("#dvAdultspecialcoupon").hide();
        $("#dvKidcoupon").hide();
        $("#dvKidOutsourcedcoupon").hide();
        $("#dvKidspecialcoupon").hide();

        $("#NumberofAdult").val("");
        $("#AdultTotalcouponprice").val("");

        $("#NumberofAdultOutsourced").val("");
        $("#AdultOutsourcedTotalcouponprice").val("");

        $("#NumberofAdultspecial").val("");
        $("#AdultspecialTotalcouponprice").val("");

        $("#NumberofKid").val("");
        $("#KidTotalcouponprice").val("");

        $("#NumberofKidOutsourced").val("");
        $("#KidOutsourcedTotalcouponprice").val("");

        $("#NumberofKidspecial").val("");
        $("#KidspecialTotalcouponprice").val("");

        $('input[id="chkAdult"]').removeAttr('checked').iCheck('update');
        $('input[id="chkAdultOutsourced"]').removeAttr('checked').iCheck('update');
        $('input[id="chkAdultspecial"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKid"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKidOutsourced"]').removeAttr('checked').iCheck('update');
        $('input[id="chkKidspecial"]').removeAttr('checked').iCheck('update');

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;

    });

    $('input:checkbox[id=chkAdult]').on('ifChecked', function(event) {
        //alert("Adult");
        $("#dvAdultcoupon").show();
        $("#NumberofAdult").show();
        $("#NumberofAdult").val("");
        $("#AdultTotalcouponprice").val("");

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;
    });

    $('input:checkbox[id=chkAdult]').on('ifUnchecked', function(event) {
        //alert("No Adult");
        $("#dvAdultcoupon").hide();
        $("#NumberofAdult").hide();
        $("#NumberofAdult").val("");
        $("#AdultTotalcouponprice").val("");

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;
    });

    $('input:checkbox[id=chkAdultOutsourced]').on('ifChecked', function(event) {
        //alert("Adult");
        $("#dvAdultOutsourcedcoupon").show();
        $("#NumberofAdultOutsourced").show();
        $("#NumberofAdultOutsourced").val("");
        $("#AdultOutsourcedTotalcouponprice").val("");

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;
    });

    $('input:checkbox[id=chkAdultOutsourced]').on('ifUnchecked', function(event) {
        //alert("No Adult");
        $("#dvAdultOutsourcedcoupon").hide();
        $("#NumberofAdultOutsourced").hide();
        $("#NumberofAdultOutsourced").val("");
        $("#AdultOutsourcedTotalcouponprice").val("");

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;
    });

    $('input:checkbox[id=chkAdultspecial]').on('ifChecked', function(event) {
        //alert("Adult Special");
        $("#dvAdultspecialcoupon").show();
        $("#NumberofAdultspecial").show();
        $("#NumberofAdultspecial").val("");
        $("#AdultspecialTotalcouponprice").val("");
        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;

    });

    $('input:checkbox[id=chkAdultspecial]').on('ifUnchecked', function(event) {
        //alert("No Adult Special");
        $("#dvAdultspecialcoupon").hide();
        $("#NumberofAdultspecial").hide();
        $("#NumberofAdultspecial").val("");
        $("#AdultspecialTotalcouponprice").val("");
        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;

    });

    $('input:checkbox[id=chkKid]').on('ifChecked', function(event) {
        //alert("Kid");
        $("#dvKidcoupon").show();
        $("#NumberofKid").show();
        $("#NumberofKid").val("");
        $("#KidTotalcouponprice").val("");

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;
    });

    $('input:checkbox[id=chkKid]').on('ifUnchecked', function(event) {
        //alert("No Kid");
        $("#dvKidcoupon").hide();
        $("#NumberofKid").hide();
        $("#NumberofKid").val("");
        $("#KidTotalcouponprice").val("");

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;
    });

    $('input:checkbox[id=chkKidOutsourced]').on('ifChecked', function(event) {
        //alert("Kid");
        $("#dvKidOutsourcedcoupon").show();
        $("#NumberofKidOutsourced").show();
        $("#NumberofKidOutsourced").val("");
        $("#KidOutsourcedTotalcouponprice").val("");

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;
    });

    $('input:checkbox[id=chkKidOutsourced]').on('ifUnchecked', function(event) {
        //alert("No Kid");
        $("#dvKidOutsourcedcoupon").hide();
        $("#NumberofKidOutsourcedspecial").hide();
        $("#NumberofKidOutsourced").val("");
        $("#KidOutsourcedTotalcouponprice").val("");

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;
    });

    $('input:checkbox[id=chkKidspecial]').on('ifChecked', function(event) {
        //alert("Kid Special");
        $("#dvKidspecialcoupon").show();
        $("#NumberofKidspecial").show();
        $("#NumberofKidspecial").val("");
        $("#KidspecialTotalcouponprice").val("");
        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;

    });

    $('input:checkbox[id=chkKidspecial]').on('ifUnchecked', function(event) {
        //alert("No Kid Special");
        $("#dvKidspecialcoupon").hide();
        $("#NumberofKidspecial").hide();
        $("#NumberofKidspecial").val("");
        $("#KidspecialTotalcouponprice").val("");

        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;

    });


    function multiplyBy() {
        num1 = document.getElementById("NumberofAdult").value;
        num2 = document.getElementById("AdultPercouponprice").value;
        document.getElementById("AdultTotalcouponprice").value = num1 * num2;
    }

    function multiplyBy2() {
        num3 = document.getElementById("NumberofAdultspecial").value;
        num4 = document.getElementById("AdultspecialPercouponprice").value;
        document.getElementById("AdultspecialTotalcouponprice").value = num3 * num4;
    }

    function multiplyBy3() {
        num5 = document.getElementById("NumberofKid").value;
        num6 = document.getElementById("KidPercouponprice").value;
        document.getElementById("KidTotalcouponprice").value = num5 * num6;
    }

    function multiplyBy4() {
        num7 = document.getElementById("NumberofKidspecial").value;
        num8 = document.getElementById("KidspecialPercouponprice").value;
        document.getElementById("KidspecialTotalcouponprice").value = num7 * num8;
    }

    function multiplyBy5() {
        num9 = document.getElementById("NumberofAdultOutsourced").value;
        num10 = document.getElementById("AdultOutsourcedPercouponprice").value;
        document.getElementById("AdultOutsourcedTotalcouponprice").value = num9 * num10;
    }

    function multiplyBy6() {
        num11 = document.getElementById("NumberofKidOutsourced").value;
        num12 = document.getElementById("KidOutsourcedPercouponprice").value;
        document.getElementById("KidOutsourcedTotalcouponprice").value = num11 * num12;
    }

    function findTotal() {
        var arr = document.getElementsByClassName('amount');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('totalcost').value = tot;
    }

    $(document).ready(function() {
        document.querySelector('#registrationmember').value = "member";
         const memberType = <?php echo(json_encode($memberType)); ?>;
         if(memberType){
            $("#registrationmember").val(memberType);
         }
         const sessionCode = <?php echo(json_encode($couponSessionCode)); ?>;
         showSelectedCoupon(sessionCode);
         updateCodeHiddenField();
    });

    //Method for show selected fodcoupon name value
    function showSelectedCoupon(code){
        const sessionCodeVal = code.substring(0, 5);
        $('#ddlCouponType option').each(function() {
            var optionValue = $(this).val();
            var substringValue = optionValue.substring(0, 5);
            if (substringValue === sessionCodeVal) {
                $(this).prop('selected', true);
                $(this).val(code);
                return false;
            }
        });
    }
    const hiddenField = document.getElementById('selectedSessionName');
    const dropdown = document.getElementById('ddlCouponType');
    const form = document.getElementById('edit_Pujafoodcoupondata');
    function updateCodeHiddenField() {
            const selectedText = dropdown.options[dropdown.selectedIndex].text;
            hiddenField.value = selectedText;
        }
    form.addEventListener('submit', function () {
        updateCodeHiddenField();
    });

</script>