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

    #freeDiamondBtn {
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
</style>
<title>Puja Food Coupons</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />

<!-- Start -->




<!-- End -->

<section class="page-title" style="background-image:url(<?php echo INSTALL_URL; ?>12.jpg);">
    <div class="auto-container">
        <div class="row clearfix">
            <!--Title -->
            <!--<div class="title-column col-lg-6 col-md-12 col-sm-12">-->
            <!--    <img style="float:left;padding:20px" src="../1.svg" width="35%">-->
            <!--    <img style="border-radius: 96px;float: left;padding: 0px;" src="../puja_logo.png" width="37%">-->
            <!--</div>-->
            
             <?php
            # Add this in top of page to prevent fallback of ROOT_PATH 
            if (!defined("ROOT_PATH")) {
                define("ROOT_PATH", dirname(__FILE__) . '/');
            }
            ?>
            
            <?php 
            # Include this to get Header Title Images 
            include_once ROOT_PATH . 'application/templates/title_images.php'; ?>
            <!--Bread Crumb -->
            <div class="breadcrumb-column col-lg-6 col-md-12 col-sm-12">
                <h1>Houston Durga Bari Society</h1>
                <h3>
                    <?php
                    $currentYear = date('Y');
                    $nextYear = date('Y') + 1;
                    echo "" . $currentYear . " - " . $nextYear . " Puja Online System ";
                    ?>
                </h3>
                <h3>1 Event Sponsorship</h3>
                <ul class="bread-crumb clearfix">
                    <li><a style="text-decoration:none;color:#fff;" href="#">Home</a></li>
                    <li class="active">1 Event Sponsorship</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<br><br>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>


<form id="edit_Pujafoodcoupondata" class="frm-class booking-frm-class"
    action="<?php echo INSTALL_URL; ?>SponsorItem/SponsorshipItemProcess" method="post" name="pujafoodcoupon">

    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-md-8 col-sm-12">

                <div style="border-left: 3px solid #03a9f4; border-right: 3px solid #03a9f4; padding: 10px; border-bottom: 3px solid #03a9f4;"
                    class="row">

                    <!-- <div class="col-lg-12 col-md-12 col-sm-12">
                        <select required="" name="regmember" id="registrationmember" class="choice" aria-required="true"
                            aria-invalid="false" onchange="membercheck(this)">
                            <option value="">Returning or New User *</option>
                            <option value="member">Returning User</option>
                            <option value="nonmember">New User</option>
                        </select>
                        <div class="text_placeholders">Returning or New User *</div>
                    </div> -->


                    <div id="termdiv" class="col-lg-12 col-md-12 col-sm-12">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <input type="text" style="display:none" name="termMember" id="termMember"
                                placeholder="search member here...." class="MIDtext2">
                            <input type="text" name="term" id="term" placeholder="search records here....*"
                                class="MIDtext2">
                            <div class="text_placeholders">Search by : First Name, Last Name, Zip, MID *</div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <input id="idmem" class="MIDtext2readonly" type="text" name="Member_id" size="25" value=""
                                title="<?php echo __('Member Id'); ?>" placeholder="Verified Member ID *" readonly>
                            <div class="text_placeholders">Verified Member ID *</div>
                        </div>

                    </div>

                    <div style="margin-top: 2rem; display: none;" class="col-lg-12 col-md-12 col-sm-12" id="sponsardiv">
                        <select style="display: none;" name="eventsponsorshipcategoryB" id="sponsarItem2" class="choice"
                            aria-required="true" aria-invalid="false">
                            <option value="" disabled selected>Please select</option>
                            <?php


                            foreach (($tpl['sponsorItemArrA'] ?? []) as $key => $value) {
                                ?>
                                <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                <?php
                            }

                            foreach (($tpl['sponsorItemArrB'] ?? []) as $key => $value) {
                                ?>

                                <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                <?php
                            }



                            ?>
                        </select>


                        <select style="display: none;" name="eventsponsorshipcategoryA" id="sponsarItem1" class="choice"
                            aria-required="true" aria-invalid="false">
                            <option value="" disabled selected>Please select</option>
                            <?php


                            foreach (($tpl['sponsorItemArrA'] ?? []) as $key => $value) {
                                ?>
                                <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div class="text_placeholders">SponsorShip Event</div>
                    </div>



                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <input id="first_name" class="MIDtext2" type="text" name="F_Name" size="25" value=""
                            title="<?php echo __('First Name'); ?>" placeholder="First Name *" required="">
                        <div class="text_placeholders">First Name *</div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <input id="second_name" class="MIDtext2" type="text" name="L_Name" size="25" value=""
                            title="<?php echo __('Last Name'); ?>" placeholder="Last Name*" required="">
                        <div class="text_placeholders">Last Name *</div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <input id="city" class="MIDtext2" type="text" name="City" size="25" value=""
                            title="<?php echo __('City'); ?>" placeholder="City *" required="">
                        <div class="text_placeholders">City *</div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <input id="state" class="MIDtext2" type="text" name="State" size="25"
                            value="<?php echo htmlspecialchars(($tpl['arr']['state'] ?? ''), ENT_QUOTES); ?>" title="<?php echo __('State'); ?>"
                            placeholder="State *" required="">
                        <div class="text_placeholders">State *</div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <input id="zip" class="MIDtext2" type="text" name="Zip" size="25" value="" required=""
                            title="<?php echo __('Zip_Code'); ?>" placeholder="Zip Code *">
                        <div class="text_placeholders">Zip Code *</div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <input id="phone" class="MIDtext2" type="text" name="phone" size="25" value="" title="phone"
                            onchange="checkmobileno(this.id)" maxlength="10" placeholder="##########" required="">
                        <div class="text_placeholders">Mobile Number *</div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <input id="email" required="" class="MIDtext2" type="text" name="email" size="25" value=""
                            title="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" placeholder="name@company.com">
                        <div class="text_placeholders">Email ID *</div>
                    </div>

                    <div class=" col-md-12 col-sm-6">
                        <input id="ytd" class="MIDtext2 MIDtext2readonly" type="text" name="ytd" size="25" value=""
                            title="ytd" readonly placeholder="ytd">
                        <div class="text_placeholders">Curren tYTD</div>
                    </div>



                    <!-- End -->


                    <div
                        style="font-weight: 600; padding: 2rem 1rem; font-size: 20px ; line-height: 1.2; color: red;  border-radius: 1rem; background-color: #fff; margin-top: 1rem; box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;">
                        NOTE: Please ensure the information provided is correct. If you want to review/update
                        any
                        information, please scroll up, or if you want a fresh start, click the Reset button. To
                        proceed with the transaction, click the ‘Make Payment’ button.
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <input type="hidden" name="sponsarshipitemprocess" value="1" />

                        <button  style="display: none;" id="freeDiamondBtn" class="btn btn-primary" autocomplete="off" value="Savefree"
                            name="freeDiamondBtn" tabindex="17" type="submit"><i
                                class="fa fa-fw fa-save"></i>&nbsp;&nbsp; Submit</button>
                    </div>


                </div>

            </div>

            <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">

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
        debugger;
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

    // function membercheck() {
    //     debugger;


    //     // var selectedString = select.options[select.selectedIndex].value;



    //     var checkdata = $("#registrationmember").val();
    //     //var checkdata = selectedString;

    //     if (checkdata == "member") {
    //         //$('#term option:not(:selected)').attr('disabled', false);
    //         document.getElementById('termdiv').style.display = "block";

    //     } else {
    //         document.getElementById('termdiv').style.display = "none";


    //     }
    // }
     let level = ""

    $(function () {
        debugger;
        $("#term").autocomplete({
           source: '<?php echo INSTALL_URL; ?>ajax-db-search.php',
            select: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                checkProjectedSponsarLevel();
                MemberSelectdonation();
            }
        });
    });

    //autocomplete 


    function MemberSelectdonation() {

        var url2 = $("#container-abc-url-id").text();
        debugger
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
                    success: function (res) {
                        // debugger;
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


                        let ytd = ""
                        const ytdElement = $(res).filter("input#ytd");
                        if (ytdElement.length) {
                            const rawValue = ytdElement[0].value;
                            const numeric = rawValue && !isNaN(rawValue) ? parseInt(rawValue) : 0;
                            ytd = numeric;
                        }

                        document.getElementById("ytd").value = ytd

                        showSponsarItem()





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



    let sponsarItem2 = document.getElementById("sponsarItem2")
    let sponsarItem1 = document.getElementById("sponsarItem1")
    let sponsardiv = document.getElementById("sponsardiv")
    let freeDiamondBtn = document.getElementById("freeDiamondBtn")
    function showSponsarItem() {


        let totalytdInput = document.getElementById("ytd");
        let totalytdValue = totalytdInput.value.trim();

        // Convert to number and handle invalid or empty input
        let totalytd = parseFloat(totalytdValue);
        if (isNaN(totalytd)) {
            totalytd = 0;
        }

        if (totalytd > 9999) {
            sponsardiv.style.display = "block"
            sponsarItem2.style.display = "block"
            freeDiamondBtn.style.display = "block"
            $('#sponsarItem2').prop('required', true)
            $('#sponsarItem1').prop('required', false)


            sponsarItem1.style.display = "none"
        }

        else if ((totalytd >= 5000 && totalytd <= 9999) || level == "Diamond") {
            sponsardiv.style.display = "block"
            sponsarItem1.style.display = "block"
            sponsarItem2.style.display = "none"
             freeDiamondBtn.style.display = "block"
            $('#sponsarItem1').prop('required', true)
            $('#sponsarItem2').prop('required', false)
        }

        else {
            sponsardiv.style.display = "none"
            sponsarItem1.style.display = "none"
            sponsarItem2.style.display = "none"
            freeDiamondBtn.style.display = "none"
            
        }
    }
    
    
    function checkProjectedSponsarLevel() {

        var url2 = $("#container-abc-url-id").text();
      
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
                    
                    url: url2 + "load.php?controller=Pujaregistration&action=projectedSponsarLevel",
                    success: function (res) {
                       
                        debugger
                        level = ""
                        const levelElement = $(res).filter("input#sponsorLevel");
                        if (levelElement.length) {
                            level = levelElement[0].value;
                        }
                        
                    }

                });
            } 
        }
    }



















</script>
