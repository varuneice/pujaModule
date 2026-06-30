<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<style>
    .checkbox label#admindocumentcheck-error {
        margin: 0px 0px 0px 0px !important;
    }

    select.ui-datepicker-year {
        width: 90% !important;
        padding: 7px 0px 7px 0px;
        background-color: #000;
        color: #fff;
        border-radius: 10px;
    }

    .ui-datepicker .ui-datepicker-title select {
        font-size: 16px;
        font-weight: 800;
        width: 90% !important;
        letter-spacing: 1px;
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

    .additional_amount.input-sm {
        font-size: 22px !important;
        font-weight: 800;
        color: red !important;
    }

    .preference {
        display: flex;
        justify-content: space-between;
        width: 90%;
        margin: 0.5rem;
    }

    .preference label {
        font-size: 22px;
        padding: 0px 5px 0px 0px;
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
        border-right: 3px solid #ff5252;
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
        border-right: 3px solid #ff5252;
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
        border-right: 3px solid #ff5252;
    }

    .page-title .breadcrumb-column h4 span {
        font-family: "Open Sans", Arial, Helvetica, Sans-Serif;
        color: #ff5252;
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
        color: #ff5252;
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
        font-size: 16px;
        line-height: 1.9em;
        margin-bottom: 15px;
    }

    .widget-content p {
        font-size: 20px;
    }

    .widget-content p span {
        color: #ef260f;
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
        text-transform: capitalize;
        color: #fff;
        background-color: #ef260f;
        border-radius: 15px;
    }

    select.choice2 {
        width: 100%;
        padding: 12px;
        font-size: 20px;
        margin-top: 20px;
        color: #fff;
        background-color: #ef260f;
        border-radius: 15px;
    }

    select.choice3 {
        width: 100%;
        padding: 14px;
        font-size: 22px;
        margin-top: 0px;
        color: #fff;
        background-color: #ef260f;
        border-radius: 15px;
    }

    select.choice4 {
        width: 100%;
        font-size: 20px;
        color: #fff;
        background-color: #ef260f;
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
        color: #ef260f;
        margin: 34px 0px 0px 36px !important;
    }

    .checkbox2 label {
        font-size: 14px;
        font-weight: 600;
        display: block;
        color: #ef260f;
        margin: 16px 0px 16px 36px !important;
    }

    .checkbox3 label {
        font-size: 14px;
        font-weight: 600;
        display: block;
        color: #ef260f;
        margin: 16px 0px 16px 36px !important;
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
        background-color: #ef260f;
        color: #fff;
        font-weight: 600;
    }

    h4.item_heading {
        font-size: 26px;
        font-weight: 600;
    }

    p.item_count {
        color: #ef260f;
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
        color: #ef260f;
    }

    span.payment_for {
        color: #ef260f;
    }

    button.payment_btn {
        padding: 10px;
        font-size: 20px;
        border-radius: 10px;
        width: 100%;
        background-color: #ef260f;
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
        color: #ef260f;
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
        background-color: #ef260f;
        color: #fff;
        letter-spacing: 0.5px;
    }

    .myDiv {
        display: none;
        padding: 10px;
        margin-top: 20px;
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
            width: 410px;
        }

        input#memphone2fam {
            width: 410px;
        }
    }

    #greenFieldParkingModal {
        display: none;
        position: fixed;
        z-index: 99999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
    }

    .greenFieldParking-modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 24px;
        border: 1px solid #888;
        width: min(520px, calc(100% - 32px));
        border-radius: 8px;
        text-align: center;
    }

    .greenFieldParking-modal-content .subHeading {
        margin: 12px 0 20px;
        font-size: 18px;
        font-weight: 600;
    }

    .greenFieldParking-btn {
        display: block;
        width: 100%;
        margin: 10px 0;
        padding: 12px 14px;
        border: 0;
        border-radius: 6px;
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
    }

    .greenFieldParking-continue-btn {
        background: #1f8b4c;
    }

    .greenFieldParking-change-btn {
        background: #c0392b;
    }

    .greenFieldParking-cancel-btn {
        background: #555;
    }
</style>
<title>Puja Registration</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-grid.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-grid.rtl.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-reboot.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-reboot.rtl.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-utilities.min.css" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-utilities.rtl.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.rtl.min.css" />

<section class="page-title" style="background-image:url(../12.jpg);">
    <div class="auto-container">
        <div class="row clearfix">
            <!--Title -->
            <?php
            if (!defined("ROOT_PATH")) {
                define("ROOT_PATH", dirname(__FILE__) . '/');
            }
            include_once ROOT_PATH . 'application/templates/title_images.php';
            ?>
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
                <h3>Payment for Puja Registration</h3>
                <h3 id="lastDateRegistration">Early Registration deadline</h3>
                <!--<h4><span>Contact : </span><a href="mailto:registration@durgabari.org"> registration@durgabari.org</a></h4>-->
                <ul class="bread-crumb clearfix">
                    <li><a style="text-decoration:none;color:#fff;"
                            href="<?php echo INSTALL_URL; ?>onlinepujapayments/onlinepujapayments">Home
                        </a></li>
                    <li class="active">Registration</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="container" style="position: relative;padding: 40px 0px 60px;">
    <?php
    $editor = $this->controller->isEditor();
    $mainadminrole = $this->controller->isAdmin();
    $adminrole = false; // default for public users
    if ($editor == "true") {
        $adminrole = $this->controller->isEditor();
    }
    if ($mainadminrole == "true") {
        $adminrole = $this->controller->isAdmin();
    }
    $registrationDate = $tpl['latefeedate'];
    $currentToday = $tpl['currentDate'];

    ?>
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div style="border-left: 3px solid #ef260f;border-right: 3px solid #ef260f;border-bottom: 3px solid #ef260f; padding: 7px;"
                id="showRegistration" class="myChoice">
                <div class="clear"></div>
                <!-- <form id="pujaregistration-frm-id" method="POST" action="https://durgabari.org/HDBS_PaymentTesting/PujaCart/PujaCart" enctype="multipart/form-data"> -->
                 <div id="otp-admin-bypass" style="display:none;"><?php echo ($this->controller->isAdmin() || $this->controller->isEditor()) ? '1' : '0'; ?></div>
                 <div id="otp-session-verified" style="display:none"><?php
                    $otpVerifiedMember = $_SESSION['otp_verified_member'] ?? '';
                    if (is_array($otpVerifiedMember)) {
                        $otpVerifiedMember = $otpVerifiedMember['member_id'] ?? '';
                    }
                    echo htmlspecialchars((string) $otpVerifiedMember, ENT_QUOTES);
                 ?></div>
                 <form id="pujaregistration-frm-id" method="POST" action="<?php echo INSTALL_URL; ?>PujaCart/PujaCart" enctype="multipart/form-data">
                    <!--<form id="pujaregistration-frm-id" method="POST" action="http://localhost/HDBS_Payment/pujaModule/PujaCart/PujaCart" enctype="multipart/form-data"> -->
                    
                    <div class="row">
                        <br>
                        <div class="col-md-6">
                            <select class="choice" id="pul" name="puja_type">
                                <option value="">Puja Type</option>
                                <option value="All 3 Pujas">All 3 Pujas</option>
                                <option value="Durga Puja">Durga Puja</option>
                                <option value="Kali Puja">Kali Puja</option>
                                <option value="Saraswati Puja">Saraswati Puja</option>
                                <!-- 11july comment  -->
                                <!--<option value="Durga Puja + Kali Puja">Durga Puja + Kali Puja</option>-->
                                <!--<option value="kali Puja + Saraswati Puja">Kali Puja + Saraswati Puja</option>-->
                                <!--<option value="Durga Puja + Saraswati Puja">Durga Puja + Saraswati Puja</option>-->
                            </select>
                            <div class="text_placeholders">Puja Type *</div>
                        </div>

                        <div class="col-md-6">
                            <select class="choice" name="puja_category" id="pul2">
                                <option value="" selected>Returning or New User</option>
                                <option value="member">Returning User</option>
                                <option value="nonmember">New User</option>
                                <!-- <option value="outoftowner">Out of Towner</option>
                    <option value="student">Student</option> -->

                            </select>
                            <div class="text_placeholders">Returning or New User *</div>
                        </div>

                    </div>
                    <br>
                    <div class="row" style="display:none;" id="membersearchdiv">
                        <div class="col-md-12">
                            <input class="MIDtext2" type="text" name="term" id="term"
                                placeholder="Search your records *"
                                onclick="document.getElementById('futureytd').value = ''" tabindex="2" required>
                            <input class="MIDtext2" type="text" style="display:none" name="termMember" id="termMember"
                                placeholder="Search your records">
                            <div class="text_placeholders">Search by : First Name, Last Name, Zip, MID *</div>
                        </div>
                    </div>
                    <div class="row" id="otp-verified-banner" style="display:none;">
                        <div class="col-md-12">
                            <div style="background:#eafaf1;border:1px solid #b7e4c7;color:#1e8449;border-radius:5px;font-size:13px;font-weight:600;padding:8px 12px;margin-bottom:10px;">
                                Returning user verified and details auto-filled.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" id="memberinformationdiv" style="display:none;">

                        <div class="col-md-4">
                            <input class="MIDtext2readonly" style="width:100%;" type="text" name="Member_id"
                                id="memidfam" required placeholder="Member ID *" />
                            <div class="text_placeholders">Verified Member ID *</div>
                        </div>
                        <div class="col-md-4">
                            <input class="MIDtext2readonly" style="width:100%;" type="text" name="membercategory"
                                id="memcatfam" required placeholder="Membership Category *" />
                            <div class="text_placeholders">Membership Category *</div>
                        </div>

                        <div class="col-md-4">
                            <input class="MIDtext2readonly" style="width:100%;" type="text" name="Member_type"
                                id="memtypefam" placeholder="Membership Status" />
                            <div class="text_placeholders">Membership Status</div>
                        </div>
                    </div>
                    <br>
                    <!--checkbox for student & outoftowner-->
                    <div class="row" id="studentootcheck" style="display:none;">
                        <div class="col-md-6 checkbox2" id="studentdivcheck">
                            <input style="visibility: visible;margin: 31px 0px 0px 4px;" class="checkbox"
                                type="checkbox" id="studentcheck" name="student_or_oot" value="Student"
                                onclick="showimgdiv()">
                            <label for="student">Student</label>
                        </div>
                        <div class="col-md-6 checkbox3" id="oottdivcheck">
                            <input style="visibility: visible;margin: 16px 0px 0px 4px;" class="checkbox"
                                type="checkbox" id="ottcheck" name="student_or_oot" value="Out of Towner"
                                onclick="showimgoot()">
                            <label for="oot">Out of Towner</label>
                        </div>


                    </div>

                    <!-- end -->
                    <br>
                    <div class="row" style="display:none;" id="commonpricedrop">
                        <div class="col-md-12">
                            <select required="" name='member_newstatus' id='ddlStatus' class="choice">
                            </select>
                            <div class="col-md-12" style="display:none;" id="alredayRegisterDiv">
                                <div class="text_placeholders" id="alredayRegisterMessage"
                                    style="font-size: 24px;padding: 10px;color: #adff2f;background-color: #000;margin-top: 12px;border-radius: 10px;text-transform: uppercase;line-height: 30px;text-align: center;font-weight: 700;">
                                    You have already done Puja Registration
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--memberall3puja start-->

                    <div id="showMember" class="myDiv">
                        <div class="row">

                            <div class="col-md-4">
                                <input class="MIDtext2" style="width:100%;" type="text" name="First_name"
                                    id="memfnamefam" placeholder="First Name" required />
                                <div class="text_placeholders">First Name *</div>
                            </div>

                            <div class="col-md-4">
                                <input class="MIDtext2" style="width:100%;" type="text" name="Last_name"
                                    id="memlnamefam" placeholder="Last Name" required />
                                <div class="text_placeholders">Last Name *</div>
                            </div>

                            <div class="col-md-4 checkbox">
                                <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                    type="checkbox" id="veggie" name="member_veggie" value="1">
                                <label for="veggie">Tick here, if Veggie</label>
                            </div>

                        </div>

                        <div class="row" id="spousenamediv" style="display:none;">

                            <div class="col-md-4">
                                <input class="MIDtext2" style="width:100%;" type="text" name="Sp_fname"
                                    id="memspfnamefam" placeholder="Spouse First Name" />
                                <div class="text_placeholders">Spouse First Name</div>
                            </div>

                            <div class="col-md-4">
                                <input class="MIDtext2" style="width:100%;" type="text" name="Sp_lname"
                                    id="memsplnamefam" placeholder="Spouse Last Name" />
                                <div class="text_placeholders">Spouse Last Name</div>
                            </div>

                            <div class="col-md-4 checkbox">
                                <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                    type="checkbox" id="veggie" name="spouse_veggie" value="1">
                                <label for="veggie">Tick here, if Veggie</label>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 checkbox" id="seniorcheckdiv">
                                <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                    type="checkbox" id="senior" name="senior" value="1"
                                    onchange="calculateseniordiscount(this)">
                                <label for="senior">Check here, if Senior 70+(Primary Registrant/Spouse only)</label>
                                <div class="text_placeholders" id="seniordismsg"
                                    style="display:none;font-size: 24px;padding: 10px;color: #adff2f;background-color: #000;margin-top: 12px;border-radius: 10px;line-height: 30px;text-align: center;font-weight: 700;">
                                </div>
                            </div>

                            <div class="col-md-6 checkbox" style="display:none;" id="swapregcheckboxdiv">
                                <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                    type="checkbox" id="swap" name="swap_spouse" value="swapregistration"
                                    onchange="swapspouseregistration(this)">
                                <label for="swap">Check here to Swap Spouse name for Registration</label>
                            </div>
                        </div>

                        <!-- 24julyupdate -->
                        <!-- admin end document verify checkbox -->
                        <div class="row">
                            <div class="col-md-6 checkbox" id="admindoccheck" style="display:none;">
                                <label for="documentverified">Document Checked *</label>
                                <input style="visibility: visible;margin: -22px 0px 0px 4px;" class="checkbox"
                                    type="checkbox" id="admincheckdocument" name="admindocumentcheck" value="1">

                            </div>
                        </div>


                        <div id="dvFamily" style="display: none">

                            <!-- <input type="hidden" name="member_puja_family_amount" value="400"> -->

                            <div id="childinputdiv" style="display:none;">
                            </div>

                            <div id="dvOptionalchild1" style="display:block;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childonefname"
                                            id="memchildfnamefam" readonly placeholder="Child First Name" />
                                        <div class="text_placeholders">Child First Name</div>
                                    </div>

                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childonelname"
                                            id="memchildlnamefam" readonly placeholder="Child Last Name" />
                                        <div class="text_placeholders">Child Last Name</div>
                                    </div>


                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="Age1"
                                            id="memchildagefam" readonly placeholder="Birth Year" />
                                        <div class="text_placeholders">Child Birth Year</div>
                                    </div>
                                    <div class="col-md-4 checkbox">
                                        <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                            type="checkbox" id="childoneveggie" name="childone_veggie" value="1">
                                        <label for="childoneveggie">Tick here, if Veggie</label>
                                    </div>
                                </div>
                            </div>


                            <div id="dvOptionalchild2" style="display:none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childtwofname"
                                            id="memchildfnamefam2" readonly placeholder="Child First Name" />
                                        <div class="text_placeholders">Child First Name</div>
                                    </div>

                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childtwolname"
                                            id="memchildlnamefam2" readonly placeholder="Child Last Name" />
                                        <div class="text_placeholders">Child Last Name</div>
                                    </div>


                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="Age2"
                                            id="memchildagefam2" readonly placeholder="Birth Year" />
                                        <div class="text_placeholders">Child Birth Year</div>
                                    </div>
                                    <div class="col-md-4 checkbox">
                                        <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                            type="checkbox" id="childtwoveggie" name="childtwo_veggie" value="1">
                                        <label for="childtwoveggie">Tick here, if Veggie</label>
                                    </div>
                                </div>
                            </div>


                            <div id="dvOptionalchild3" style="display:none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childthreefname"
                                            id="memchildfnamefam22" readonly placeholder="Child First Name" />
                                        <div class="text_placeholders">Child First Name</div>
                                    </div>

                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childthreelname"
                                            id="memchildlnamefam22" readonly placeholder="Child Last Name" />
                                        <div class="text_placeholders">Child Last Name</div>
                                    </div>


                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="Age3"
                                            id="memchildagefam22" readonly placeholder="Birth Year" />
                                        <div class="text_placeholders">Child Birth Year</div>
                                    </div>
                                    <div class="col-md-4 checkbox">
                                        <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                            type="checkbox" id="childthreeveggie" name="childthree_veggie" value="1">
                                        <label for="childthreeveggie">Tick here, if Veggie</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="adultChildOptInRow" style="display:none;">
                                <div class="col-md-12 checkbox">
                                    <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                        type="checkbox" id="coRegisterAdultChildren" name="co_register_adult_members"
                                        value="1" onchange="toggleAdultChildRegistration()">
                                    <label for="coRegisterAdultChildren">Do you want to co-register 22+ unmarried adult members?</label>
                                </div>
                            </div>
                            <div class="row" id="adultChildCountRow" style="display:none;">
                                <div class="col-md-12">
                                    <select class="choice2" name="member_optional_child" id="ddlOptionalchild">
                                        <option value="">No. of 22+ Unmarried Adult(s)</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <input type="hidden" name="adult_member_count" id="adultMemberCount" value="">
                                    <div class="text_placeholders">No. of 22+ Unmarried Adult(s) YOB 2003 or earlier</div>
                                </div>
                            </div>
                            <div id="dvAdultMember1" style="display:none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="adult1_fname"
                                            id="adult1fname" readonly placeholder="Adult First Name *" />
                                        <div class="text_placeholders">Adult First Name *</div>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="adult1_lname"
                                            id="adult1lname" readonly placeholder="Adult Last Name *" />
                                        <div class="text_placeholders">Adult Last Name *</div>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="adult1_birth_year"
                                            id="adult1birthyear" readonly placeholder="Birth Year *" />
                                        <div class="text_placeholders">Adult Birth Year *</div>
                                    </div>
                                    <div class="col-md-4 checkbox">
                                        <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                            type="checkbox" id="adult1veggie" name="adult1_veggie" value="1">
                                        <label for="adult1veggie">Tick here, if Veggie</label>
                                    </div>
                                </div>
                            </div>
                            <div id="dvAdultMember2" style="display:none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="adult2_fname"
                                            id="adult2fname" readonly placeholder="Adult First Name *" />
                                        <div class="text_placeholders">Adult First Name *</div>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="adult2_lname"
                                            id="adult2lname" readonly placeholder="Adult Last Name *" />
                                        <div class="text_placeholders">Adult Last Name *</div>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="adult2_birth_year"
                                            id="adult2birthyear" readonly placeholder="Birth Year *" />
                                        <div class="text_placeholders">Adult Birth Year *</div>
                                    </div>
                                    <div class="col-md-4 checkbox">
                                        <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                            type="checkbox" id="adult2veggie" name="adult2_veggie" value="1">
                                        <label for="adult2veggie">Tick here, if Veggie</label>
                                    </div>
                                </div>
                            </div>
                            <div id="dvAdultMember3" style="display:none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="adult3_fname"
                                            id="adult3fname" readonly placeholder="Adult First Name *" />
                                        <div class="text_placeholders">Adult First Name *</div>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="adult3_lname"
                                            id="adult3lname" readonly placeholder="Adult Last Name *" />
                                        <div class="text_placeholders">Adult Last Name *</div>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="adult3_birth_year"
                                            id="adult3birthyear" readonly placeholder="Birth Year *" />
                                        <div class="text_placeholders">Adult Birth Year *</div>
                                    </div>
                                    <div class="col-md-4 checkbox">
                                        <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                            type="checkbox" id="adult3veggie" name="adult3_veggie" value="1">
                                        <label for="adult3veggie">Tick here, if Veggie</label>
                                    </div>
                                </div>
                            </div>
                            <!-- for parent registration section  -->
                            <div class="row">
                                <div class="col-md-5">
                                    <h2 style="padding-top: 30px; font-size:18px; color: #ef260f;">No. of Parents  attending:</h2>
                                </div>
                                <div id="one" class="col-md-3 checkbox">
                                    <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                        type="checkbox" name="no_of_parent" value="1" id="myCheck"
                                        onclick="myFunction()">
                                    <label for="one">One</label>
                                </div>
                                <div id="two" class="col-md-3 checkbox">
                                    <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                        type="checkbox" name="no_of_parent" value="2" id="myCheck2"
                                        onclick="myFunction()">
                                    <label for="two">Two</label>
                                </div>
                            </div>
                            <div class="row" id="rowForParentPujaOption" style="display:none;">
                                <div class="col-md-12">
                                    <select class="choice" id="parentPuja" name="Parent_Puja_Type" onchange="getParentRegistrationPujaPrice()">
                                    </select>
                                    <div class="text_placeholders">Puja Type Parent Registration</div>
                                </div>
                            </div>
                            <div id="text" style="display:none">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="parent1_fname"
                                            id="memparentfnamefam" placeholder="Parent First Name" />
                                        <div class="text_placeholders">Parent First Name *</div>
                                    </div>

                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="parent1_lname"
                                            id="memparentlnamefam" placeholder="Parent Last Name" />
                                        <div class="text_placeholders">Parent Last Name *</div>
                                    </div>

                                    <div class="col-md-4 checkbox">
                                        <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                            type="checkbox" id="oneparentveggie" name="parent1_veggie" value="1">
                                        <label for="veggie">Tick here, if Veggie</label>
                                    </div>
                                </div>
                            </div>

                            <div id="text2" style="display:none">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="parent2_fname"
                                            id="memparent2fnamefam" placeholder="Parent First Name" />
                                        <div class="text_placeholders">Parent First Name *</div>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="parent2_lname"
                                            id="memparent2lnamefam" placeholder="Parent Last Name" />
                                        <div class="text_placeholders">Parent Last Name *</div>
                                    </div>
                                    <div class="col-md-4 checkbox">
                                        <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                            type="checkbox" id="parent2veggie" name="parent2_veggie" value="1">
                                        <label for="veggie">Tick here, if Veggie</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- hidden field -->

                        <div id="dvIndividual" style="display: none;">
                            <input type="hidden" name="magazineamount" value="10">
                            <input type="text" name="puja_amount" id="pujapriceval">
                            <input type="text" name="member_status" id="hiddenpujaname">
                            <input type="text" name="discountseniorprice" id="seniordiscountamount">
                            <input type="text" name="extraparentregistration" id="parentregprice">
                            <input type="text" name="extraadultregistration" id="adultregprice">
                            <input type="text" id="adultchildunitprice">
                            <input type="text" name="extramagazineamount" id="magazinefinalamount">
                        </div>
                        <div class="row" id="updateAddressRow">
                            <div class="col-md-12 checkbox">
                                <input style="visibility: visible;margin: 31px 0px 0px 4px;" class="checkbox"
                                    type="checkbox" id="updateAddressCheck" name="update_address" value="1"
                                    onchange="applyAddressUpdateState()">
                                <label for="updateAddressCheck">Update address?</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="street" id="memstreetfam"
                                    placeholder="Street #" required readonly />
                                <div class="text_placeholders">Street # *</div>
                            </div>

                            <div class="col-md-6">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="streetname"
                                    id="memstreetnamefam" placeholder="Street Name" required readonly />
                                <div class="text_placeholders">Street Name *</div>
                            </div>

                            <div class="col-md-3">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="unit" id="memunitfam"
                                    placeholder="Unit #" readonly />
                                <div class="text_placeholders">Unit #</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="city" id="memcityfam"
                                    placeholder="City" required readonly />
                                <div class="text_placeholders">City *</div>
                            </div>

                            <div class="col-md-4">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="state" id="memstatefam"
                                    placeholder="State" required readonly />
                                <div class="text_placeholders">State *</div>
                            </div>

                            <div class="col-md-4">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="zip" id="mamzipcodefam"
                                    placeholder="Zip" required readonly />
                                <div class="text_placeholders">Zip Code *</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 phone">
                                <input class="MIDtext2readonly" type="text" name="phone" id="memphonefam" maxlength="10"
                                    placeholder="##########" required />
                                <div class="text_placeholders">Phone Number *</div>
                            </div>
                            <div class="col-md-6 phone">
                                <input class="MIDtext2" type="text" name="alternatenumber" id="memphone2fam"
                                    maxlength="10" placeholder="##########" required />
                                <div class="text_placeholders">Mobile Number *</div>
                            </div>
                            <div class="col-md-6">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="email"
                                    id="mememailfam" placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+"
                                    required />
                                <div class="text_placeholders">Email ID *</div>
                            </div>
                            <div class="col-md-6">
                                <input class="MIDtext2" style="width:100%;" type="text" name="alternateemail"
                                    id="mememail2fam" placeholder="name@company.com"
                                    pattern="[^@\s]+@[^@\s]+\.[^@\s]+" />
                                <div class="text_placeholders">Alternate Email ID</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <input class="MIDtext2readonly" style="width:100%;" id="ytd1" class="" type="text"
                                    placeholder="Current YTD Donation" value="" name="YTD" tabindex="13" readonly
                                    style="display:block;">
                                <div class="text_placeholders">Current YTD Donation($)</div>
                            </div>
                            <div class="col-md-4">
                                <input class="number" id="totaldonation" style="width:100%;" type="number"
                                    name="donation" value="" min="25" placeholder="Donation ($)"
                                    onchange="amountvalid(this.id)" />
                                <div class="text_placeholders">Donation($)</div>
                            </div>
                            <div class="col-md-4">
                                <input class="MIDtext2readonly" name="newytdfeature" id="futureytd" class="number"
                                    type="text" placeholder="Future YTD" value="" tabindex="16" readonly>
                                <input type="hidden" name="greenFieldParkingDecision" id="greenFieldParkingDecision" value="">
                                <div class="text_placeholders">Future YTD Donation($)</div>

                            </div>

                            <div class="col-md-12" style="display:none;" id="featureytddiv">
                                <div class="text_placeholders" id="ytdmess"
                                    style="display:none;font-size: 24px;padding: 10px;color: #adff2f;background-color: #000;margin-top: 12px;border-radius: 10px;text-transform: uppercase;line-height: 30px;text-align: center;font-weight: 700;">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="member_additional_magazine_family_amount" value="10">
                                <input type="hidden" id="magazinedata" name="magazine" value="">
                            </div>
                            <div class="col-md-6">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="totalamount"
                                    id="total_value" readonly placeholder="Total Amount($)" />
                                <div class="text_placeholders">Total Amount Request to Pay($)</div>
                                <div id="adultChildPriceSummary" class="text_placeholders" style="display:none;">22+ Unmarried Adult Registration: $<span id="adultChildPriceSummaryAmount">0</span></div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <!-- Parking conditions on Donation start ui onchange -->


                                <table class="table">
                                    <tr class="tr" style="display:none;" id="sponsorcheck">
                                        <td class="td" colspan="2">Are You Interested in Sponsor Parking ?</td>
                                        <td class="td" colspan="2">

                                            <select name="" id="sponser" onchange="ListCreate()"
                                                class="choice4 form-control input-sm" aria-required="true"
                                                aria-invalid="false">
                                                <option value="">Please select</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- Adding bootstrap table classes to style a table-->

                                                    <!-- The Modal start-->
                                                    <div id="myModal" class="modal">

                                                        <!-- Modal content -->
                                                        <div class="modal-content">
                                                            <span id="close" class="close">&times;</span>
                                                            <div class="popup_title"><b>Sponsorship Privileges
                                                                    (Information only, please go back to Donation field
                                                                    to adjust your donation)</b></div>

                                                            <table
                                                                class="table table-bordered table-condensed table-hover table-striped text-center popup_table">
                                                                <tbody id="data" class="feature text-left popup_tbody">
                                                                    <tr class="tr">
                                                                        <td class="td"
                                                                            style="background-color:black;color:white;">
                                                                            Category</td>
                                                                        <td class="td"
                                                                            style="background-color:black;color:white;">
                                                                            Sponsorship Amount</td>
                                                                        <td class="td"
                                                                            style="background-color:black;color:white;">
                                                                            Parking Assigned</td>
                                                                        <td class="td"
                                                                            style="background-color:black;color:white;">
                                                                            Additional</br>Donation Needed</td>
                                                                    </tr>
                                                                    <tr class="tr" id="diamondtr">
                                                                        <td class="td"
                                                                            style="background-color:#cc2900;color:white;">
                                                                            Diamond</td>
                                                                        <td class="td" id="diamond">$5000+( Registration
                                                                            optional)</td>
                                                                        <td class="td"
                                                                            style="background-color: #f3f4f5;">Main
                                                                            Parking.<br> Named slots for $10K</td>

                                                                    </tr>
                                                                    <tr class="tr" id="emeraldtr">
                                                                        <td class="td"
                                                                            style="background-color:#98FB98;color:black;">
                                                                            Emerald</td>
                                                                        <td class="td" id="emerald"
                                                                            style="background-color:white;">$2200 -
                                                                            $4559</td>
                                                                        <td class="td">Main Parking<br>
                                                                            (in order of date of Sponsorship)</td>


                                                                    </tr>
                                                                    <tr class="tr" id="platinumtr">
                                                                        <td class="td"
                                                                            style="background-color:#000080;color:white;">
                                                                            Platinum</td>
                                                                        <td class="td" id="platinum">$1500 - $2199</td>
                                                                        <td class="td">Main or Kala Bhavan
                                                                            (KB)Parking<br>
                                                                            (in order of date of Sponsorship)</td>

                                                                    </tr>
                                                                    <tr class="tr" id="goldtr">
                                                                        <td class="td"
                                                                            style="background-color:yellow;color:black;">
                                                                            Gold</td>
                                                                        <td class="td" id="gold"
                                                                            style="background-color:white;">$1000 - $1499
                                                                        </td>
                                                                        <td class="td">Green Field. <br> KB Parking for CT Gold Sponsors</td>

                                                                    </tr>

                                                                    <tr class="tr" id="silvertr">
                                                                        <td class="td"
                                                                            style="background-color:#E6E6FA;color:black;">
                                                                            Silver</td>
                                                                        <td class="td" id="silver">$750 - $999</td>
                                                                        <td class="td"
                                                                            style="background-color: #f3f4f5;">Green Field. <br> KB Parking for CT Senior Silver Sponsors</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>

                                                        </div>

                                                    </div>
                                                    <!-- The Modal end-->

                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                </table>
                                <!-- Parking conditions on Donation changes end -->

                            </div>
                        </div>
                        <div class="row" id="schoolnamediv" style="display:none;">
                            <div class="col-md-12">
                                <input class="MIDtext2" style="width:100%;" type="text" name="schoolname"
                                    placeholder="Name of College or University">
                                <div class="text_placeholders">Name of college or University</div>
                            </div>
                        </div>

                        <!-- document submit div  -->
                        <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                            <div class="row" id="documentuploaddiv" style="display:none;">
                                <div class="col-md-12">
                                    <input class="MIDtext2" style="width:100%;" type="file" name="image" id="file"
                                        placeholder="Document Verification" accept=".jpg,.jpeg,.png,.pdf"
                                        onchange="validateDocumentUpload(this)">
                                    <div class="text_placeholders">Upload document (Student ID or Out of Towner Address
                                        Verification as applicable). (jpg,png,jpeg,pdf format)
                                    </div>
                                    <div id="documentUploadError" style="display:none;color:#d71920;font-weight:bold;margin-top:6px;"></div>
                                    <div id="documentPreview" style="display:none;margin-top:8px;">
                                        <img id="documentPreviewImage" src="" alt="Document preview" style="display:none;max-width:260px;max-height:180px;border:1px solid #ccc;padding:4px;">
                                        <span id="documentPreviewPdf" style="display:none;font-size:13px;color:#333;"></span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="reset" name="Reset" id="reset-btn-id" class="go_cart_btn">Reset</button>
                            </div>
                            <div class="col-md-6" id="addcartbuttondiv">
                                <button type="submit" id="gocartbutton" class="go_cart_btn" name="get_cart"
                                    onclick="return confirm('Please ensure the information provided is correct. If you want to review/update any information, please click Cancel button or press OK to go the payment page.')">Make Payment</button>
                            </div>
                            <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                                <div class="col-md-6" id="documentsubmitbuttondiv" style="display:none;">
                                    <input type="hidden" name="create_requestpujaregistration" value="1" />
                                    <button type="submit" id="gocartbutton" class="go_cart_btn" name="requesrregirtraton"
                                        onclick="return confirm('Please ensure the information provided is correct. If you want to review/update any information, please click Cancel button or press OK to go the payment page.')">Make Payment</button>
                                </div>
                            <?php } ?>
                        </div>


                    </div>
                </form>
                <?php require __DIR__ . '/../components/otp_modal.php'; ?>
            </div>
        </div>

        <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">

            <aside class="sidebar">
                <!-- Help Widget -->

                <div class="sidebar-widget help-widget">
                    <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                        <a style="font-size: 24px; text-decoration: none;color:#000;font-weight:600;"
                            href="<?php echo INSTALL_URL; ?>Pujaregistration/index">Go Back to Dashboard</a>
                        <br><br>
                    <?php } ?>
                    <div class="sidebar-title">
                        <h2><span style="color: #ef260f;">General</span> Guidelines</h2>
                    </div>
                    <div class="widget-content">
                        <div class="text">1. Sign up as a new member or renew your membership to avail lower rates
                            <a style="text-decoration: none; color: #333; font-weight: 700;"
                                href="https://durgabari.org/payments/" target="_blank">Click here for Membership</a>.
                        </div>
                        <div class="text">2. Registration provides access to the auditorium for cultural programs.</div>
                        <div class="text">3. All 3 Pujas and Durga Puja registrants eligible for a free copy of Sharad
                            Arghya, the Puja Magazine Kali Puja and Saraswati Puja registrants 
                            can purchase at the time of registration, subject to available copies</div>
                        <div class="text">4. Children of registrants above 22* years must register separately.</div>
                        <div class="text">5. *Age limit to be relaxed to 26 years for children if unmarried and still a
                            student or unemployed. Please contact registration team with details.</div>
                        <div class="text">6. Returning Users: Please contact the Registration team or HDBS Treasurer to
                            add (newly born) children or to update primary email address and phone number</div>
                        <div class="text">7. Senior discount applies to a minimum age of 70 years and refers to the
                            primary registrant and spouse only (and not to any accompanying parents)</div>
                        <div class="text">8. Out-of-Towners (OOT) are eligible for registration at Member rates
                            irrespective of membership status</div>
                        <div class="text">9. Parents visiting from abroad or residing with the registrants as dependents
                            can be included free of cost with Sliver+ sponsorship. Nominal rates apply in other cases.
                        </div>
                        <div class="text">10. Student rate applicable to FULL TIME students only. Part time or Executive
                            MBA students are not eligible. </div>
                        <div class="text">11. Students opting for family registration can include spouse only if spouse
                            is not employed.</div>
                        <div class="text">12. Parents of students cannot be included in student registration and will
                            need to register separately.</div>
                        <div class="text">13. OOT and Students need to submit relevant documents (Address proof for
                            OOT/Student ID for Students) online. Registration team will validate and send a confirmation
                            with an individualized payment link. You may blank off date of birth or any other personal
                            information</div>
                        <div class="text">14. Student IDs must have an expiry date or an issue date within the last one
                            year. If none available, submit a recent tuition fee payment receipt or a score card. </div>
                        <div class="text">15. Puja Benefactors (minimum YTD $150 for Seniors,
                          $300 for general Registrants) may apply for Green
                          Field Parking via the Puja Benefactor icon.
                          Registration is mandatory to apply. Parking
                          privilege is subject to availability.
                        </div>
                    </div>
                </div>

                <div class="sidebar-widget help-widget">
                    <div class="sidebar-title">
                        <h2><span style="color: #ef260f;">Need</span> Help?</h2>
                    </div>
                    <div class="widget-content">
                        <div class="text">If you have any questions, please contact us</div>
                        <p style="padding-bottom:30px;"><span><i class="fa fa-envelope" aria-hidden="true"></i></span><a
                                style="color:#000;text-decoration:none;" href="mailto:registration@durgabari.org">
                                registration@durgabari.org</a></p>
                        <!-- <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                style="color:#000;text-decoration:none;" href="tel:+17134948782"> <strong
                                    style="font-size:26px;"> +1 713-494-8782</strong> <br><span
                                    style="font-size:20px;color:#000;">Enakshi Lahiri</span></a></p> -->
                        <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                style="color:#000;text-decoration:none;" href="tel:+14134046740"> <strong
                                    style="font-size:26px;">413-404-6740</strong> <br><span
                                    style="font-size:20px;color:#000;">Sourima</span></a></p>
                        <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                style="color:#000;text-decoration:none;" href="tel:+18327234829"> <strong
                                    style="font-size:26px;">832-723-4829</strong> <br><span
                                    style="font-size:20px;color:#000;">Debashish</span></a></p>
                        <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                style="color:#000;text-decoration:none;" href="tel:+18322055665"> <strong
                                    style="font-size:26px;">832-205-5665</strong> <br><span
                                    style="font-size:20px;color:#000;">Amit</span></a></p>

                    </div>
                </div>

            </aside>
        </div>


    </div>
</div>

<div id="greenFieldParkingModal">
    <div class="greenFieldParking-modal-content">
        <p><strong>Parking for Silver, Gold and Platinum sponsors are no longer available</strong></p>
        <div class="subHeading">Are you sure you want to continue with your donation?</div>
        <button type="button" class="greenFieldParking-btn greenFieldParking-continue-btn"
            onclick="handleGreenFieldParkingChoice('Continue without parking')">Continue without parking</button>
        <button type="button" class="greenFieldParking-btn greenFieldParking-change-btn"
            onclick="handleGreenFieldParkingChoice('donation')">Change my donation</button>
        <button type="button" class="greenFieldParking-btn greenFieldParking-cancel-btn"
            onclick="handleGreenFieldParkingChoice('Cancelled')">Cancel</button>
    </div>
</div>


<script>
    var pujaYtdTiers = <?php echo json_encode($tpl['puja_ytd_tiers'] ?? array()); ?>;

    function getPujaYtdTier(amount) {
        var value = parseFloat(amount);
        if (isNaN(value)) {
            return null;
        }

        for (var i = 0; i < pujaYtdTiers.length; i++) {
            var tier = pujaYtdTiers[i];
            var minAmount = parseFloat(tier.min_amount);
            var maxAmount = tier.max_amount === null || tier.max_amount === '' ? null : parseFloat(tier.max_amount);
            if (value >= minAmount && (maxAmount === null || value <= maxAmount)) {
                return tier;
            }
        }

        return null;
    }

    function getPujaYtdTierByName(name) {
        var expectedName = (name || '').toLowerCase();
        for (var i = 0; i < pujaYtdTiers.length; i++) {
            var tier = pujaYtdTiers[i];
            var tierName = tier && tier.tier_name ? tier.tier_name.toLowerCase() : '';
            if (tierName === expectedName) {
                return tier;
            }
        }

        return null;
    }

    function getPujaYtdTierMin(name, fallback) {
        var tier = getPujaYtdTierByName(name);
        var minAmount = tier ? parseFloat(tier.min_amount) : NaN;
        return isNaN(minAmount) ? fallback : minAmount;
    }

    function getPujaYtdParkingMessage(amount, membertype, isRegisteredForParkingPuja) {
        decodeURI
        var tier = getPujaYtdTier(amount);
        var tierName = tier && tier.tier_name ? tier.tier_name.toLowerCase() : '';
        var isPmOrFp = membertype === "PM" || membertype === "FP";

        if (tierName === 'silver') {
            return isPmOrFp && isRegisteredForParkingPuja
                ? "On completion of your payment, you will be assigned Kala Bhavan Parking, contingent on Puja registration (All 3 Pujas / Durga Puja)."
                : "On completion of your payment, you will be assigned parking at Green Field, contingent on Puja registration (All 3 Pujas / Durga Puja).";
        }
        if (tierName === 'gold') {
            return isPmOrFp && isRegisteredForParkingPuja
                ? "On completion of your payment, you will be assigned Kala Bhavan Parking, contingent on Puja registration (All 3 Pujas / Durga Puja)."
                : "On completion of your payment, you will be assigned Gold Sponsor Parking, contingent on Puja registration (All 3 Pujas / Durga Puja).";
        }
        if (tierName === 'platinum') {
            return "On completion of your payment, you will be assigned Main or Kala Bhavan(KB) Parking, contingent on Puja registration (All 3 Pujas / Durga Puja).";
        }
        if (tierName === 'emerald' || tierName === 'diamond' || isPujaYtdEmeraldDiamondGap(amount)) {
            return "On completion of your payment, you will be assigned Main Parking, contingent on Puja registration (All 3 Pujas / Durga Puja).";
        }

        return "";
    }

    function isPujaYtdEmeraldDiamondGap(amount) {
        var value = parseFloat(amount);
        if (isNaN(value)) {
            return false;
        }

        var emeraldMax = null;
        var diamondMin = null;
        for (var i = 0; i < pujaYtdTiers.length; i++) {
            var tier = pujaYtdTiers[i];
            var tierName = tier && tier.tier_name ? tier.tier_name.toLowerCase() : '';
            if (tierName === 'emerald' && tier.max_amount !== null && tier.max_amount !== '') {
                emeraldMax = parseFloat(tier.max_amount);
            }
            if (tierName === 'diamond') {
                diamondMin = parseFloat(tier.min_amount);
            }
        }

        return emeraldMax !== null && !isNaN(emeraldMax) && !isNaN(diamondMin) && value > emeraldMax && value < diamondMin;
    }

    function showPujaYtdParkingMessage(amount, membertype, isRegisteredForParkingPuja) {
        var message = getPujaYtdParkingMessage(amount, membertype, isRegisteredForParkingPuja);
        $("#greenFieldParkingDecision").val(message);
        if (message !== "") {
            $("#ytdmess").html(message);
            $("#featureytddiv").show();
            $("#ytdmess").show();
        } else {
            $("#ytdmess").hide();
        }
    }

    ////Lookup.......................Start..............................////
    $(function () {
        //
        $("#term").autocomplete({
            //source: "http://localhost/HDBS_Payment/pujaModule/ajax-db-search.php",
            //source: 'https://durgabari.org/HDBS_PaymentTesting/ajax-db-search.php',
             source: '<?php echo INSTALL_URL; ?>ajax-db-search.php',
            select: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                MemberSelectdonation(this);
            },
            onclick: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                MemberSelectdonation();
            },
            onchange: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                MemberSelectdonation();
            },
            // focus: function (event, ui) {
            //     event.preventDefault();
            //     var name = ui.item.value;
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
        debugger

        var url2 = $("#container-abc-url-id").text();
        //
        var self = this;
        var data = $("#termMember").val();
        var term = $("#term").val();
        // for Ytd condition
        // document.getElementById('dvOptionalchild3').style.display = 'none';
        // document.getElementById('dvOptionalchild2').style.display = 'none';
        // document.getElementById('dvOptionalchild1').style.display = 'none';
        document.getElementById("swap").checked = false;
        $("#spousenamediv").hide();
        $("#swapregcheckboxdiv").hide();
        $("#sponsor").val("");
        $("#sponsorevent").val("");
        $("#totaldonation").val("");
        $("#futureytd").val("");
        $("#total_value").val("");
        $("#ddlStatus").val("");
        var compareyear = '<?php echo htmlspecialchars($tpl['child_yob_cutoff'] ?? '2004', ENT_QUOTES); ?>';
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
                        let ytd1 = "";
                        const ytd1Element = $(res).filter("input#ytd");
                        if (ytd1Element.length) {
                            ytd1 = ytd1Element[0].value;
                        }
                        document.getElementById("ytd1").value = ytd1;

                        debugger
                        console.log(res)

                        // let parent2 = "";
                        // let parent2firstname = "";
                        // let parent2lastname = "";
                        // const parent2Element = $(res).filter("input#parent2");
                        // if (parent2Element.length) {
                        //     parent2 = parent2Element[0].value;
                        //     if (parent2 != "") {
                        //         var parentname2 = parent2.split(" ");
                        //         parent2firstname = parentname2[0];
                        //         if (parentname2[1] !== undefined) {
                        //             parent2lastname = parentname2[1];
                        //         }
                        //     }
                        // }
                        // document.getElementById("memparent2fnamefam").value = parent2firstname;
                        // document.getElementById("memparent2lnamefam").value = parent2lastname;


                        // let parent1 = "";
                        // let parentfirstname = "";
                        // let parentlastname = "";
                        // const parent1Element = $(res).filter("input#parent1");
                        // if (parent1Element.length) {
                        //     parent1 = parent1Element[0].value;
                        //     if (parent1 != "") {
                        //         var parentname = parent1.split(" ");
                        //         parentfirstname = parentname[0];
                        //         if (parentname[1] !== undefined) {
                        //             parentlastname = parentname[1];
                        //         }
                        //     }
                        // }
                        // document.getElementById("memparentfnamefam").value = parentfirstname;
                        // document.getElementById("memparentlnamefam").value = parentlastname;


                        let email2 = "";
                        const email2Element = $(res).filter("input#email2");
                        if (email2Element.length) {
                            email2 = email2Element[0].value;
                        }
                        document.getElementById("mememail2fam").value = email2;

                        let email = "";
                        const emailElement = $(res).filter("input#email");
                        if (emailElement.length) {
                            email = emailElement[0].value;
                            if (email != "") {
                                $('#mememailfam').prop('readonly', true);
                                $('#mememailfam').addClass('MIDtext2readonly');
                            }
                            else {
                                $('#mememailfam').prop('readonly', false);
                                $('#mememailfam').removeClass('MIDtext2readonly')
                                $('#mememailfam').addClass('MIDtext2');
                            }

                        }
                        document.getElementById("mememailfam").value = email;

                        let phoneNo = "";
                        const phoneNoElement = $(res).filter("input#Tele1");
                        if (phoneNoElement.length) {
                            phonetext = phoneNoElement[0].value;
                            phoneNo = phonetext.trim();

                            if (phoneNo != "") {
                                $('#memphonefam').prop('readonly', true);
                                $('#memphonefam').addClass('MIDtext2readonly');
                            }
                            else {
                                $('#memphonefam').prop('readonly', false);
                                $('#memphonefam').removeClass('MIDtext2readonly')
                                $('#memphonefam').addClass('MIDtext2');
                            }

                        }
                        new_phone = phoneNo.replace(/[-)(]/g, "");
                        document.getElementById("memphonefam").value = new_phone;

                        //add 11 july
                        let mobile = "";
                        const mobileNoElement = $(res).filter("input#phone_work");
                        if (mobileNoElement.length) {
                            mobiletext = mobileNoElement[0].value;
                            mobile = mobiletext.trim();
                            // 21-Julyupdate
                            // if(mobile !="" ){
                            //     $('#memphone2fam').prop('readonly', true);
                            //     $('#memphone2fam').addClass('MIDtext2readonly');
                            //    }
                            //    else{
                            //     $('#memphone2fam').prop('readonly', false);
                            //      $('#memphone2fam').removeClass('MIDtext2readonly')
                            //      $('#memphone2fam').addClass('MIDtext2');
                            //    }


                        }
                        const new_mobile = mobile.replace(/[-)(]/g, "");
                        document.getElementById("memphone2fam").value = new_mobile;

                        let zipcode = "";
                        const zipcodeElement = $(res).filter("input#zip_code");
                        if (zipcodeElement.length) {
                            zipcode = zipcodeElement[0].value;
                        }
                        document.getElementById("mamzipcodefam").value = zipcode;

                        let state = "";
                        const stateElement = $(res).filter("input#state");
                        if (stateElement.length) {
                            state = stateElement[0].value;
                        }
                        document.getElementById("memstatefam").value = state;

                        let city = "";
                        const cityElement = $(res).filter("input#city");
                        if (cityElement.length) {
                            city = cityElement[0].value;
                        }
                        document.getElementById("memcityfam").value = city;


                        let unit = "";
                        const unitElement = $(res).filter("input#unitAddress");
                        if (unitElement.length) {
                            unit = unitElement[0].value;
                        }
                        document.getElementById("memunitfam").value = unit;

                        let streetname = "";
                        const streetnameElement = $(res).filter("input#Address");
                        if (streetnameElement.length) {
                            streetname = streetnameElement[0].value;
                        }
                        document.getElementById("memstreetnamefam").value = streetname;

                        let street = "";
                        const streetElement = $(res).filter("input#ressidentalAddress");
                        if (streetElement.length) {
                            street = streetElement[0].value;
                        }
                        document.getElementById("memstreetfam").value = street;
                        $("#updateAddressCheck").prop("checked", false);
                        applyAddressUpdateState();
                        setTimeout(applyAddressUpdateState, 100);
                        checkDuplicatePujaRegistrationForSelectedType();
                        let child333 = "";
                        let childfirstname = "";
                        let childsecondname = "";
                        const child333Element = $(res).filter("input#child3");
                        if (child333Element.length) {
                            child333 = child333Element[0].value;
                            if (child333 != "") {
                                // document.getElementById('dvOptionalchild3').style.display = 'block';
                                var childname5 = child333.split(" ");
                                childfirstname = childname5[0];
                                if (childname5[1] !== undefined) {
                                    childsecondname = childname5[1];
                                }

                            }

                        }
                        document.getElementById("memchildfnamefam22").value = childfirstname;
                        document.getElementById("memchildlnamefam22").value = childsecondname;


                        let age333 = "";
                        const age333Element = $(res).filter("input#age3");
                        if (age333Element.length) {
                            age333 = age333Element[0].value;
                        }
                        if (parseInt(age333, 10) >= parseInt(compareyear, 10) && age333 !== '0' && childfirstname != "") {
                            document.getElementById('dvOptionalchild3').style.display = 'block';
                            document.getElementById("memchildagefam22").value = age333;
                        }
                        else {
                            $("#memchildfnamefam22").val("");
                            $("#memchildlnamefam22").val("");
                            $("#memchildagefam22").val("");
                            $("#dvOptionalchild3").hide();
                        }

                        let child21 = "";
                        let membersecondfname = "";
                        let membersecondlname = "";

                        const child21Element = $(res).filter("input#child2");
                        if (child21Element.length) {
                            child21 = child21Element[0].value;
                            if (child21 != "") {
                                //document.getElementById('dvOptionalchild2').style.display = 'block';
                                var childname2 = child21.split(" ");
                                membersecondfname = childname2[0];
                                if (childname2[1] !== undefined) {
                                    membersecondlname = childname2[1];
                                }
                            }
                        }
                        document.getElementById("memchildfnamefam2").value = membersecondfname;
                        document.getElementById("memchildlnamefam2").value = membersecondlname;

                        let age21 = "";
                        const age21Element = $(res).filter("input#age2");
                        if (age21Element.length) {
                            age21 = age21Element[0].value;
                        }
                        if (parseInt(age21, 10) >= parseInt(compareyear, 10) && age21 !== '0' && membersecondfname != "") {
                            document.getElementById('dvOptionalchild2').style.display = 'block';
                            document.getElementById("memchildagefam2").value = age21;
                        } else {
                            $("#memchildfnamefam2").val("");
                            $("#memchildlnamefam2").val("");
                            $("#memchildagefam2").val("");
                            $("#dvOptionalchild2").hide();
                        }

                        let child1 = "";
                        let memberthirdfname = "";
                        let memberthirdlname = "";

                        const child1Element = $(res).filter("input#child1");
                        if (child1Element.length) {
                            child1 = child1Element[0].value;
                            if (child1 != "") {
                                //document.getElementById('dvOptionalchild1').style.display = 'block';
                                var childname = child1.split(" ");
                                memberthirdfname = childname[0];
                                if (childname[1] !== undefined) {
                                    memberthirdlname = childname[1];
                                }
                            }
                        }
                        document.getElementById("memchildfnamefam").value = memberthirdfname;
                        document.getElementById("memchildlnamefam").value = memberthirdlname;


                        let age1 = "";
                        const age1Element = $(res).filter("input#age1");
                        if (age1Element.length) {
                            age1 = age1Element[0].value;
                        }
                        if (parseInt(age1, 10) >= parseInt(compareyear, 10) && age1 !== '0' && memberthirdfname != "") {
                            document.getElementById('dvOptionalchild1').style.display = 'block';
                            document.getElementById("memchildagefam").value = age1;
                        }
                        else {
                            $("#memchildfnamefam").val("");
                            $("#memchildlnamefam").val("");
                            $("#memchildagefam").val("");
                            $("#dvOptionalchild1").hide();
                        }

                        let membersplname = "";
                        const membersplnameElement = $(res).filter("input#Spouselast");
                        if (membersplnameElement.length) {
                            membersplname = membersplnameElement[0].value;
                        }
                        document.getElementById("memsplnamefam").value = membersplname;


                        let memberspfname = "";
                        const memberspfnameElement = $(res).filter("input#Spouse");
                        if (memberspfnameElement.length) {
                            memberspfname = memberspfnameElement[0].value;
                            var txtselectpujaname = $("#ddlStatus option:selected").text();
                            text = txtselectpujaname.split(" ");
                            var pricefor = text[0];
                            if (memberspfname != "" && pricefor == "individual") {
                                $("#swapregcheckboxdiv").show();
                            }
                        }
                        document.getElementById("memspfnamefam").value = memberspfname;


                        let memberlname = "";
                        const memberlnameElement = $(res).filter("input#last_name");
                        if (memberlnameElement.length) {
                            memberlname = memberlnameElement[0].value;
                            if (memberlname != "") {
                                $('#memlnamefam').prop('readonly', true);
                            }
                            else {
                                $('#memlnamefam').prop('readonly', false);
                            }
                        }
                        document.getElementById("memlnamefam").value = memberlname;


                        let memberMname = "";
                        const memberMnameElement = $(res).filter("input#middle_name");
                        if (memberMnameElement.length) {
                            memberMname = memberMnameElement[0].value;
                        }
                        //document.getElementById("memMnamefam").value = memberMname;

                        let memberfname = "";
                        const memberfnameElement = $(res).filter("input#MemberName");
                        if (memberfnameElement.length) {
                            memberfname = memberfnameElement[0].value;
                        }
                        //document.getElementById("memfnamefam").value = memberfname;
                        if (memberMname != "") {
                            document.getElementById("memfnamefam").value = memberfname.concat(" ", memberMname);
                        } else {
                            document.getElementById("memfnamefam").value = memberfname;
                        }

                        let SeniorCHeck = "";
                        const SeniorElement = $(res).filter("input#Senior");
                        if (SeniorElement.length) {
                            SeniorCHeck = SeniorElement[0].value;
                            if(SeniorCHeck ==='YES'){
                                $("#senior").prop('checked', true);
                            }
                            else{
                                $("#senior").prop('checked', false);
                            }
                        }
                        
                        let membershiptype = "";
                        const membershiptypeElement = $(res).filter("input#membershiptype");
                        if (membershiptypeElement.length) {
                            membershiptype = membershiptypeElement[0].value;
                        }
                        document.getElementById("memtypefam").value = membershiptype;

                        let cat = "";
                        const catElement = $(res).filter("input#membercategory");
                        if (catElement.length) {
                            cat = catElement[0].value;
                            if (cat != "") {
                                if (cat == "GD" || cat == "GC") {
                                    var paymentfor = "nonmember";
                                    var ootcheckbox = document.getElementById('ottcheck');
                                    var Studentcheckbox = document.getElementById('studentcheck');
                                    if (ootcheckbox.checked == true || Studentcheckbox.checked == true) {
                                        $("#documentuploaddiv").show();
                                        $("#documentsubmitbuttondiv").show();
                                        $("#addcartbuttondiv").hide();
                                    }
                                    //    if(Studentcheckbox.checked == true){
                                    //     $("#documentuploaddiv").show();
                                    //     $("#documentsubmitbuttondiv").show();
                                    //     $("#addcartbuttondiv").hide();
                                    //    }
                                }
                                else {
                                    var paymentfor = "member";
                                    $("#documentuploaddiv").hide();
                                    $("#documentsubmitbuttondiv").hide();
                                    $("#addcartbuttondiv").show();
                                }
                                var pyjaname = $("#pul").val();
                                var url1 = $("#container-abc-url-id").text();
                                $.ajax({
                                    type: "POST",
                                    data: {
                                        paymentfor: paymentfor,
                                        pyjaname: pyjaname,

                                    },
                                    url: url1 + "load.php?controller=PujaOnlinePayments&action=getpujapricedata",
                                    success: function (res) {
                                        replacePujaPriceOptions(res);

                                    }
                                });
                            }
                        }
                        document.getElementById("memcatfam").value = cat;
                        let memberid = "";
                        const memberidElement = $(res).filter("input#memberid");
                        if (memberidElement.length) {
                            memberid = memberidElement[0].value;
                        }
                        document.getElementById("memidfam").value = memberid;

                        let ytd = "";
                        const ytdElement = $(res).filter("input#ytd");
                        if (ytdElement.length) {
                            ytd = ytdElement[0].value;
                        }
                        document.getElementById("ytd1").value = ytd;

                        syncFilledChildRowsVisibility();


                    }

                });
            } else {

                $("#memidfam").val("");
                $("#memcatfam").val("");
                $("#memtypefam").val("");
                $("#memfnamefam").val("");
                $("#memlnamefam").val("");
                $("#memspfnamefam").val("");
                $("#memsplnamefam").val("");
                $("#memchildfnamefam").val("");
                $("#memchildlnamefam").val("");
                $("#memchildagefam").val("");
                $("#memchildfnamefam2").val("");
                $("#memchildlnamefam2").val("");
                $("#memchildagefam2").val("");
                $("#memchildfnamefam22").val("");
                $("#memchildlnamefam22").val("");
                $("#memchildagefam22").val("");
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
                $("#memparentfnamefam").val("");
                $("#memparentlnamefam").val("");
                $("#memparent2fnamefam").val("");
                $("#memparent2lnamefam").val("");

            }
        }
    }
    // autocomplete end    

    function syncFilledChildRowsVisibility() {
        var childRows = [
            {
                row: "#dvOptionalchild1",
                first: "#memchildfnamefam",
                last: "#memchildlnamefam",
                year: "#memchildagefam"
            },
            {
                row: "#dvOptionalchild2",
                first: "#memchildfnamefam2",
                last: "#memchildlnamefam2",
                year: "#memchildagefam2"
            },
            {
                row: "#dvOptionalchild3",
                first: "#memchildfnamefam22",
                last: "#memchildlnamefam22",
                year: "#memchildagefam22"
            }
        ];

        childRows.forEach(function (childRow) {
            var hasChildData =
                $.trim($(childRow.first).val() || "") !== "" ||
                $.trim($(childRow.last).val() || "") !== "" ||
                $.trim($(childRow.year).val() || "") !== "";

            $(childRow.row).toggle(hasChildData);
        });
    }

    function applyAddressUpdateState() {
        var isNewUser = $("#pul2").val() == "nonmember";
        if (isNewUser) {
            $("#updateAddressRow").hide();
            $("#updateAddressCheck").prop("checked", false);
        } else {
            $("#updateAddressRow").show();
        }

        var hasReturningMember = $.trim($("input[name='Member_id']").val() || "") !== "";
        var canEditAddress = !hasReturningMember || $("#updateAddressCheck").is(":checked");
        var addressFields = $("#memstreetfam, #memstreetnamefam, #memunitfam, #memcityfam, #memstatefam, #mamzipcodefam");

        if (canEditAddress) {
            addressFields.prop("readonly", false).removeAttr("readonly");
            addressFields.removeClass("MIDtext2readonly").addClass("MIDtext2");
        } else {
            addressFields.prop("readonly", true).attr("readonly", "readonly");
            addressFields.removeClass("MIDtext2").addClass("MIDtext2readonly");
        }
    }

    function isAddressLockedForReturningMember() {
        return $.trim($("input[name='Member_id']").val() || "") !== "" && !$("#updateAddressCheck").is(":checked");
    }

    $(document).on("keydown paste input", "#memstreetfam, #memstreetnamefam, #memunitfam, #memcityfam, #memstatefam, #mamzipcodefam", function (event) {
        if (isAddressLockedForReturningMember()) {
            applyAddressUpdateState();
            event.preventDefault();
            return false;
        }
    });

    var pujaPriceRequestToken = 0;

    function replacePujaPriceOptions(res, requestToken) {
        if (requestToken && requestToken !== pujaPriceRequestToken) {
            return;
        }

        var previousValue = $("#ddlStatus").val();
        var previousType = $.trim($("#ddlStatus option:selected").text() || "").split(" ")[0];
        var restoredValue = "";
        $('#ddlStatus').empty();
        var pricefornewOption = $(res);
        var newOption = $('<option value="">Please select price type*</option>');
        $('#ddlStatus').append(newOption);
        $('#ddlStatus').append(pricefornewOption);

        if (previousValue !== "" && $('#ddlStatus option[value="' + previousValue + '"]').length) {
            $('#ddlStatus').val(previousValue);
            restoredValue = previousValue;
        } else if (previousType !== "" && previousType.toLowerCase() !== "please") {
            $('#ddlStatus option').each(function () {
                var optionType = $.trim($(this).text() || "").split(" ")[0];
                if (optionType === previousType) {
                    $('#ddlStatus').val($(this).val());
                    restoredValue = $(this).val();
                    return false;
                }
            });
        }
        $('#ddlStatus').trigger("chosen:updated");
        if (restoredValue !== "" && restoredValue !== previousValue) {
            $('#ddlStatus').trigger("change");
        }
    }

    function setPujaRegistrationDuplicateState(isDuplicate, message) {
        var buttons = $("#gocartbutton, #documentsubmitbuttondiv button[type='submit'], #addcartbuttondiv button[type='submit']");
        if (message) {
            $("#alredayRegisterMessage").text(message);
        } else {
            $("#alredayRegisterMessage").text("You have already done Puja Registration");
        }
        $("#alredayRegisterDiv").toggle(!!isDuplicate);
        buttons.prop("disabled", !!isDuplicate);
        buttons.toggleClass("disabled", !!isDuplicate);
    }

    function checkDuplicatePujaRegistrationForSelectedType() {
        var memberId = $.trim($("input[name='Member_id']").val() || "");
        var requestedPuja = $.trim($("#pul").val() || "");
        var selectedText = $.trim($("#ddlStatus option:selected").text() || "").toLowerCase();

        if (memberId === "" || requestedPuja === "" || selectedText === "" || selectedText.indexOf("please select") === 0) {
            setPujaRegistrationDuplicateState(false);
            return;
        }

        $.ajax({
            type: "POST",
            data: { memberid: memberId, puja_type: requestedPuja },
            url: "<?php echo INSTALL_URL; ?>load.php?controller=PujaOnlinePayments&action=checkCurrentSeasonPujaRegistration",
            success: function (res) {
                var hasRegistration = $(res).filter("input#memberdata").val() === "true";
                var message = $(res).filter("input#membermessage").val() || "";
                setPujaRegistrationDuplicateState(hasRegistration, message);
            },
            error: function () {
                setPujaRegistrationDuplicateState(false);
            }
        });
    }

    function isAdultChildEligibleMember() {
        var membertype = $("#pul2").val();
        var selectedStatus = $.trim($("#ddlStatus option:selected").text() || "").split(" ")[0].toLowerCase();
        return membertype == "member" && (selectedStatus == "family" || selectedStatus == "individual") && !isGdGcMembershipCategory();
    }

    function isGdGcMembershipCategory() {
        var membercategory = $.trim($("#memcatfam").val()).toUpperCase();
        return membercategory === "" || membercategory === "GD" || membercategory === "GC";
    }

    var adultChildMemberSnapshot = null;

    function setAdultChildFieldsEditable(isEditable) {
        $("#adult1fname, #adult1lname, #adult1birthyear, #adult2fname, #adult2lname, #adult2birthyear, #adult3fname, #adult3lname, #adult3birthyear").prop("readonly", !isEditable);
    }

    function getAdultChildFieldRows() {
        return [
            { index: 1, wrapper: "#dvAdultMember1", first: "#adult1fname", last: "#adult1lname", yob: "#adult1birthyear", veggie: "#adult1veggie" },
            { index: 2, wrapper: "#dvAdultMember2", first: "#adult2fname", last: "#adult2lname", yob: "#adult2birthyear", veggie: "#adult2veggie" },
            { index: 3, wrapper: "#dvAdultMember3", first: "#adult3fname", last: "#adult3lname", yob: "#adult3birthyear", veggie: "#adult3veggie" }
        ];
    }

    function captureAdultChildMemberSnapshot() {
        adultChildMemberSnapshot = getAdultChildFieldRows().map(function (child) {
            return {
                first: $(child.first).val(),
                last: $(child.last).val(),
                yob: $(child.yob).val(),
                veggie: $(child.veggie).is(":checked")
            };
        });
    }

    function restoreAdultChildMemberSnapshot() {
        if (!adultChildMemberSnapshot) {
            return;
        }
        getAdultChildFieldRows().forEach(function (child, index) {
            var saved = adultChildMemberSnapshot[index] || {};
            $(child.first).val(saved.first || "");
            $(child.last).val(saved.last || "");
            $(child.yob).val(saved.yob || "");
            $(child.veggie).prop("checked", !!saved.veggie);
        });
    }

    function getAdultChildRows() {
        var cutoff = 2003;
        return getAdultChildFieldRows().filter(function (child) {
            var birthYear = parseInt($(child.yob).val(), 10);
            return !isNaN(birthYear) && birthYear <= cutoff && birthYear > 0 && $.trim($(child.first).val()) != "";
        });
    }

    function syncAdultChildDropdownOptions() {
        var eligibleCount = isAdultChildEligibleMember() ? 3 : 0;
        var currentValue = parseInt($("#ddlOptionalchild").val(), 10);
        var labels = ["", "One", "Two", "Three"];

        $("#ddlOptionalchild").empty().append('<option value="">No. of 22+ Unmarried Adult(s)</option>');
        for (var i = 1; i <= eligibleCount; i++) {
            $("#ddlOptionalchild").append('<option value="' + i + '">' + labels[i] + '</option>');
        }
        if (!isNaN(currentValue) && currentValue <= eligibleCount) {
            $("#ddlOptionalchild").val(currentValue);
        }
        $("#adultMemberCount").val($("#ddlOptionalchild").val() || "");

        return eligibleCount;
    }

    function showSelectedAdultChildRows(selectedCount) {
        var eligibleChildren = getAdultChildFieldRows();
        $("#dvAdultMember1, #dvAdultMember2, #dvAdultMember3").hide();
        $("#adult1fname, #adult1lname, #adult1birthyear, #adult2fname, #adult2lname, #adult2birthyear, #adult3fname, #adult3lname, #adult3birthyear").prop("required", false);

        for (var i = 0; i < selectedCount && i < eligibleChildren.length; i++) {
            $(eligibleChildren[i].wrapper).show();
            $(eligibleChildren[i].first + ", " + eligibleChildren[i].last + ", " + eligibleChildren[i].yob).prop("required", true);
        }
    }

    function clearAdultChildRegistrationFields() {
        $("#adult1fname, #adult1lname, #adult1birthyear, #adult2fname, #adult2lname, #adult2birthyear, #adult3fname, #adult3lname, #adult3birthyear").val("");
        $("#adult1veggie, #adult2veggie, #adult3veggie").prop("checked", false);
    }

    function showExistingMemberAdultChildren() {
        $("#dvAdultMember1, #dvAdultMember2, #dvAdultMember3").hide();
        $("#adult1fname, #adult1lname, #adult1birthyear, #adult2fname, #adult2lname, #adult2birthyear, #adult3fname, #adult3lname, #adult3birthyear").prop("required", false);
    }

    function validateExtraAdultChildRows(showAlert) {
        if (!$("#coRegisterAdultChildren").is(":checked")) {
            return true;
        }

        var cutoff = 2003;
        var selectedCount = parseInt($("#ddlOptionalchild").val(), 10);
        if (isNaN(selectedCount) || selectedCount <= 0) {
            return true;
        }

        var rows = [
            { first: "#adult1fname", last: "#adult1lname", yob: "#adult1birthyear" },
            { first: "#adult2fname", last: "#adult2lname", yob: "#adult2birthyear" },
            { first: "#adult3fname", last: "#adult3lname", yob: "#adult3birthyear" }
        ];

        for (var i = 0; i < selectedCount && i < rows.length; i++) {
            var birthYear = parseInt($(rows[i].yob).val(), 10);
            if ($.trim($(rows[i].first).val()) === "" || $.trim($(rows[i].last).val()) === "" || isNaN(birthYear) || birthYear <= 0 || birthYear > cutoff) {
                if (showAlert) {
                    alert("For 22+ unmarried adult registration, enter first name, last name, and birth year " + cutoff + " or earlier.");
                }
                return false;
            }
        }

        return true;
    }

    function getAdultChildPriceFor() {
        var membertype = $("#pul2").val();
        var membercategory = $.trim($("#memcatfam").val());
        var studentcheckbox = document.getElementById('studentcheck');
        var ootcheckbox = document.getElementById('ottcheck');

        if (studentcheckbox && studentcheckbox.checked) {
            return "student";
        }
        if (membertype == "nonmember" && ootcheckbox && ootcheckbox.checked && (membercategory == "GD" || membercategory == "GC" || membercategory == "")) {
            return "nonmemberoot";
        }
        if (membertype == "nonmember") {
            return "nonmember";
        }
        if (membertype == "member" && ootcheckbox && ootcheckbox.checked && (membercategory == "GD" || membercategory == "GC" || membercategory == "")) {
            return "memberoot";
        }
        return "member";
    }

    function refreshAdultChildUnitPrice(callback) {
        var selectedText = $("#ddlStatus option:selected").text();
        var textParts = selectedText.split(" ");
        var priceType = textParts[0] || "";
        var pujaname = $("#pul").val();
        var url1 = $("#container-abc-url-id").text();

        if (pujaname == "" || priceType == "") {
            $("#adultchildunitprice").val("");
            if (typeof callback === "function") {
                callback();
            }
            return;
        }

        $.ajax({
            type: "POST",
            data: {
                paymentfor: getAdultChildPriceFor(),
                pyjaname: pujaname,
                pricetype: "individual"
            },
            url: url1 + "load.php?controller=PujaOnlinePayments&action=getadultchildprice",
            success: function (res) {
                var adultChildPrice = "";
                var adultChildPriceElement = $(res).filter("input#adultchildprice");
                if (adultChildPriceElement.length) {
                    adultChildPrice = adultChildPriceElement[0].value;
                }
                $("#adultchildunitprice").val(adultChildPrice);
                if (typeof callback === "function") {
                    callback();
                }
            }
        });
    }

    function resetAdultChildRegistration() {
        var previousChildAmount = parseFloat($("#adultregprice").val());
        var totalAmount = parseFloat($("#total_value").val());
        if (!isNaN(previousChildAmount) && previousChildAmount > 0 && !isNaN(totalAmount)) {
            $("#total_value").val(totalAmount - previousChildAmount);
        }
        $("#coRegisterAdultChildren").prop("checked", false);
        $("#ddlOptionalchild").val("");
        $("#adultMemberCount").val("");
        $("#adultregprice").val("");
        $("#adultchildunitprice").val("");
        $("#adultChildCountRow").hide();
        $("#dvAdultMember1, #dvAdultMember2, #dvAdultMember3").hide();
        $("#adult1veggie, #adult2veggie, #adult3veggie").prop("checked", false);
        $("#adult1fname, #adult1lname, #adult1birthyear, #adult2fname, #adult2lname, #adult2birthyear, #adult3fname, #adult3lname, #adult3birthyear").prop("required", false);
        setAdultChildFieldsEditable(false);
        restoreAdultChildMemberSnapshot();
        showExistingMemberAdultChildren();
        updateAdultChildPriceSummary();
    }

    function hideAdultChildRegistrationOption() {
        $("#adultChildOptInRow").hide();
        $("#adultChildCountRow").hide();
        $("#ddlOptionalchild").hide();
        resetAdultChildRegistration();
    }

    function updateAdultChildPriceSummary() {
        var childAmount = parseFloat($("#adultregprice").val());
        if (!isNaN(childAmount) && childAmount > 0) {
            $("#adultChildPriceSummaryAmount").text(childAmount);
            $("#adultChildPriceSummary").show();
        } else {
            $("#adultChildPriceSummaryAmount").text("0");
            $("#adultChildPriceSummary").hide();
        }
    }

    function showAdultChildRegistrationOption() {
        var eligibleCount = syncAdultChildDropdownOptions();
        if (eligibleCount <= 0) {
            $("#childinputdiv").hide();
            hideAdultChildRegistrationOption();
            return;
        }
        captureAdultChildMemberSnapshot();
        $("#childinputdiv").show();
        $("#adultChildOptInRow").show();
        $("#ddlOptionalchild").show();
        resetAdultChildRegistration();
        syncAdultChildDropdownOptions();
        refreshAdultChildUnitPrice();
    }

    function toggleAdultChildRegistration() {
        if ($("#coRegisterAdultChildren").is(":checked")) {
            syncAdultChildDropdownOptions();
            $("#adultChildCountRow").show();
            $("#ddlOptionalchild").show();
            setAdultChildFieldsEditable(true);
            clearAdultChildRegistrationFields();
            $("#dvAdultMember1, #dvAdultMember2, #dvAdultMember3").hide();
        } else {
            resetAdultChildRegistration();
        }
        applyChildRegistrationAmount();
    }

    function getSelectedPujaPrice() {
        var price = parseFloat($("#pujapriceval").val());
        if (!isNaN(price)) {
            return price;
        }

        price = parseFloat($("#ddlStatus").val());
        return isNaN(price) ? 0 : price;
    }

    function applyChildRegistrationAmount() {
        var previousChildAmount = parseFloat($("#adultregprice").val());
        var totalAmount = parseFloat($("#total_value").val());
        var childCount = parseInt($("#ddlOptionalchild").val());
        var childAmount = 0;
        $("#adultMemberCount").val(isNaN(childCount) ? "" : childCount);

        if (isNaN(previousChildAmount)) {
            previousChildAmount = 0;
        }
        if (isNaN(totalAmount)) {
            totalAmount = 0;
        }
        if ($("#coRegisterAdultChildren").is(":checked") && !isNaN(childCount) && childCount > 0) {
            var eligibleCount = syncAdultChildDropdownOptions();
            var unitPrice = parseFloat($("#adultchildunitprice").val());
            childCount = Math.min(childCount, eligibleCount);
            $("#adultMemberCount").val(childCount);

            if ((isNaN(unitPrice) || unitPrice <= 0) && eligibleCount > 0) {
                refreshAdultChildUnitPrice(applyChildRegistrationAmount);
                return;
            }
            showSelectedAdultChildRows(childCount);
            childAmount = unitPrice * childCount;
        }

        $("#adultregprice").val(childAmount);
        $("#total_value").val(totalAmount - previousChildAmount + childAmount);
        updateAdultChildPriceSummary();
    }

    var adultChildReapplyTimer = null;

    function reapplyAdultChildRegistrationAfterBaseTotal() {
        if (!$("#coRegisterAdultChildren").is(":checked")) {
            updateAdultChildPriceSummary();
            return;
        }
        $("#adultregprice").val("0");
        applyChildRegistrationAmount();
    }

    function scheduleAdultChildRegistrationAfterBaseTotal(delay) {
        if (adultChildReapplyTimer) {
            clearTimeout(adultChildReapplyTimer);
        }
        adultChildReapplyTimer = setTimeout(function () {
            adultChildReapplyTimer = null;
            reapplyAdultChildRegistrationAfterBaseTotal();
        }, delay || 0);
    }

    function myFunction() {
        //
        var checkBox = document.getElementById("myCheck");
        var checkBox2 = document.getElementById("myCheck2");
        document.getElementById("total_value").value = "";
        $("#memparentfnamefam").val('');
        $("#memparentlnamefam").val('');
        $("#memparent2fnamefam").val('');
        $("#memparent2lnamefam").val('');
        $("#oneparentveggie").prop('checked', false);
        $("#parent2veggie").prop('checked', false);

        if (checkBox.checked == true) {
           // $("#rowForParentPujaOption").show();
            document.getElementById("text").style.display = "block";
            document.getElementById("two").style.display = "none";
            $("#memparentfnamefam").prop('required', true);
            $("#memparentlnamefam").prop('required', true);
            $("#memparent2fnamefam").prop('required', false);
            $("#memparent2lnamefam").prop('required', false);

        } else if (checkBox2.checked == true) {
            //$("#rowForParentPujaOption").show();
            document.getElementById("text").style.display = "block";
            document.getElementById("text2").style.display = "block";
            document.getElementById("one").style.display = "none";

            $("#memparentfnamefam").prop('required', true);
            $("#memparentlnamefam").prop('required', true);
            $("#memparent2fnamefam").prop('required', true);
            $("#memparent2lnamefam").prop('required', true);

        } else {
           // $("#rowForParentPujaOption").hide();
            document.getElementById("one").style.display = "block";
            document.getElementById("two").style.display = "block";
            document.getElementById("text").style.display = "none";
            document.getElementById("text2").style.display = "none";

            $("#memparentfnamefam").prop('required', true);
            $("#memparentlnamefam").prop('required', true);
            $("#memparent2fnamefam").prop('required', true);
            $("#memparent2lnamefam").prop('required', true);
        }
        //Method call for get parent registration puja price
        getParentRegistrationPujaPrice();
        scheduleAdultChildRegistrationAfterBaseTotal(300);
    }

//METHOD CALL FOR GET PARENT PUJA REGISTRATION PRICE
function getParentRegistrationPujaPrice(){
        var checkBox = document.getElementById("myCheck");
        var checkBox2 = document.getElementById("myCheck2");
        var text = document.getElementById("text");

        document.getElementById("total_value").value = "";

        var txtselectpujaname = $("#ddlStatus option:selected").text();
        text = txtselectpujaname.split(" ");
        var pricefor = text[0];
        var pujaprice = text[1].replace('$', "");
        var membertype = $("#pul2").val();
        var membercategory = $("#memcatfam").val();
        var donationamount = parseFloat($("#totaldonation").val());
        var senioramount = parseInt($("#seniordiscountamount").val());
        var seniorcheckbox = document.getElementById('senior');
        var studentcheckbox = document.getElementById('studentcheck');
        var ootcheckbox = document.getElementById('ottcheck');
        var magazineval = $("#magazinedata").val();
        var magazineprice = "15";

        let annualytd = ($("#ytd1").val() * 1);
        let pujaDonationAmount = ($("#totaldonation").val() * 1);
        let fututrYtdParentRegistration = annualytd + pujaDonationAmount;
        let parentYtdThreshold = Number(<?php echo json_encode((float) ($tpl['parent_ytd_threshold'] ?? 749)); ?>);
        if ((fututrYtdParentRegistration < parentYtdThreshold || isNaN(fututrYtdParentRegistration) || fututrYtdParentRegistration == "") && (checkBox.checked == true || checkBox2.checked == true)) {
            var pujaname = $("#pul").val();
           // var parentRegiatrationaPujaName = $("#parentPuja").val();

            var url1 = $("#container-abc-url-id").text();
            if (membertype == "member" && studentcheckbox.checked != true && ootcheckbox.checked != true) {
                seniorpricefor = "member";
            }
            else if (membertype == "nonmember" && studentcheckbox.checked != true && ootcheckbox.checked != true) {
                seniorpricefor = "nonmember";
            }
            else if (membertype == "member" && studentcheckbox.checked == true && ootcheckbox.checked != true) {
                seniorpricefor = "student";
            }
            else if (membertype == "nonmember" && studentcheckbox.checked == true && ootcheckbox.checked != true) {
                seniorpricefor = "student";
            }
            else if (membertype == "member" && studentcheckbox.checked != true && ootcheckbox.checked == true && (membercategory != 'GD' || membercategory != 'GC' || membercategory != "")) {
                seniorpricefor = "member";
            }

            else if (membertype == "member" && studentcheckbox.checked != true && ootcheckbox.checked == true && (membercategory == 'GD' || membercategory == 'GC' || membercategory == "")) {
                seniorpricefor = "memberoot";
            }
            else if (membertype == "nonmember" && studentcheckbox.checked != true && ootcheckbox.checked == true && (membercategory == 'GD' || membercategory == 'GC' || membercategory == "")) {
                seniorpricefor = "nonmemberoot";
            }
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: seniorpricefor,
                    pyjaname: pujaname,
                    //pyjaname: parentRegiatrationaPujaName,
                    pricetype: pricefor,
                },
                url: url1 + "load.php?controller=PujaOnlinePayments&action=getparentprice",
                success: function (res) {
                    let parentregistrationprice = "";
                    const parentpriceElement = $(res).filter("input#parentprice");
                    if (parentpriceElement.length) {
                        parentregistrationprice = parentpriceElement[0].value;

                        if (checkBox2.checked == true) {
                            parentprice = parentregistrationprice * 2
                            document.getElementById("parentregprice").value = parentprice;
                        }
                        else {
                            parentprice = parentregistrationprice;
                            document.getElementById("parentregprice").value = parentprice;
                        }
                    }

                    if (seniorcheckbox.checked == true && isNaN(donationamount) && magazineval == "") {
                        var afterdiscountprice = pujaprice - senioramount;
                        var amountwithparentfee = parseInt(afterdiscountprice) + parseInt(parentprice);
                        document.getElementById("total_value").value = amountwithparentfee;
                    }
                    else if (seniorcheckbox.checked == true && (!isNaN(donationamount)) && magazineval == "") {
                        var afterdiscountprice = pujaprice - senioramount;
                        var amountwithparentfee = parseInt(afterdiscountprice) + parseInt(donationamount) + parseInt(parentprice);
                        document.getElementById("total_value").value = amountwithparentfee;
                    }
                    else if (seniorcheckbox.checked == true && isNaN(donationamount) && magazineval != "") {
                        var afterdiscountprice = pujaprice - senioramount;
                        var amountwithparentfee = parseInt(afterdiscountprice) + parseInt(parentprice);
                        var totalmagazineprice = parseInt(magazineprice) * magazineval;
                        document.getElementById("magazinefinalamount").value = totalmagazineprice;
                        document.getElementById("total_value").value = amountwithparentfee + totalmagazineprice;
                    }
                    else if (seniorcheckbox.checked == true && (!isNaN(donationamount)) && magazineval != "") {
                        var afterdiscountprice = pujaprice - senioramount;
                        var amountwithparentfee = parseInt(afterdiscountprice) + parseInt(parentprice) + parseInt(donationamount);
                        var totalmagazineprice = parseInt(magazineprice) * magazineval;
                        document.getElementById("magazinefinalamount").value = totalmagazineprice;
                        document.getElementById("total_value").value = amountwithparentfee + totalmagazineprice;
                    }

                    else if (seniorcheckbox.checked != true && isNaN(donationamount) && magazineval == "") {
                        var amountwithparentfee = parseInt(pujaprice) + parseInt(parentprice);
                        document.getElementById("total_value").value = amountwithparentfee;
                    }
                    else if (seniorcheckbox.checked != true && (!isNaN(donationamount)) && magazineval == "") {
                        var amountwithparentfee = parseInt(pujaprice) + parseInt(donationamount) + parseInt(parentprice);
                        document.getElementById("total_value").value = amountwithparentfee;
                    }
                    else if (seniorcheckbox.checked != true && isNaN(donationamount) && magazineval != "") {
                        var amountwithparentfee = parseInt(pujaprice) + parseInt(parentprice);
                        var totalmagazineprice = parseInt(magazineprice) * magazineval;
                        document.getElementById("magazinefinalamount").value = totalmagazineprice;
                        document.getElementById("total_value").value = amountwithparentfee + totalmagazineprice;
                    }
                    //new parent Done
                    else if (seniorcheckbox.checked != true && (!isNaN(donationamount)) && magazineval != "") {
                        var amountfee = parseInt(pujaprice) + parseInt(donationamount) + parseInt(parentprice);
                        var totalmagazineprice = parseInt(magazineprice) * magazineval;
                        document.getElementById("magazinefinalamount").value = totalmagazineprice;
                        document.getElementById("total_value").value = amountfee + totalmagazineprice;
                    }
                    else if (seniorcheckbox.checked != true && (!isNaN(donationamount)) && magazineval == "") {
                        var amountfee = parseInt(pujaprice) + parseInt(donationamount) + parseInt(parentprice);
                        document.getElementById("total_value").value = amountfee;
                    }
                    else {
                        document.getElementById("total_value").value = pujaprice;
                    }
                    scheduleAdultChildRegistrationAfterBaseTotal();
                }
            });
        }
        else {
            document.getElementById("parentregprice").value = "";
            if (seniorcheckbox.checked == true && isNaN(donationamount) && magazineval == "") {
                var afterdiscountprice = pujaprice - senioramount;
                var amountwithparentfee = parseInt(afterdiscountprice);
                document.getElementById("total_value").value = amountwithparentfee;
            }
            else if (seniorcheckbox.checked == true && (!isNaN(donationamount)) && magazineval == "") {
                var afterdiscountprice = pujaprice - senioramount;
                var amountwithparentfee = parseInt(afterdiscountprice) + parseInt(donationamount);
                document.getElementById("total_value").value = amountwithparentfee;
            }
            else if (seniorcheckbox.checked == true && isNaN(donationamount) && magazineval != "") {
                var afterdiscountprice = pujaprice - senioramount;
                var totalmagazineprice = parseInt(magazineprice) * magazineval;
                document.getElementById("magazinefinalamount").value = totalmagazineprice;
                document.getElementById("total_value").value = afterdiscountprice + totalmagazineprice;
            }
            else if (seniorcheckbox.checked == true && (!isNaN(donationamount)) && magazineval != "") {
                var afterdiscountprice = pujaprice - senioramount;
                var amountwithparentfee = parseInt(afterdiscountprice) + parseInt(donationamount);
                var totalmagazineprice = parseInt(magazineprice) * magazineval;
                document.getElementById("magazinefinalamount").value = totalmagazineprice;
                document.getElementById("total_value").value = amountwithparentfee + totalmagazineprice;
            }
            else if (seniorcheckbox.checked != true && isNaN(donationamount) && magazineval == "") {
                var amountwithparentfee = parseInt(pujaprice);
                document.getElementById("total_value").value = amountwithparentfee;
            }
            else if (seniorcheckbox.checked != true && (!isNaN(donationamount)) && magazineval == "") {
                var amountwithparentfee = parseInt(pujaprice) + parseInt(donationamount);
                document.getElementById("total_value").value = amountwithparentfee;
            }
            else if (seniorcheckbox.checked != true && isNaN(donationamount) && magazineval != "") {
                var amountfee = parseInt(pujaprice);
                var totalmagazineprice = parseInt(magazineprice) * magazineval;
                document.getElementById("magazinefinalamount").value = totalmagazineprice;
                document.getElementById("total_value").value = amountfee + totalmagazineprice;
            }
            else if (seniorcheckbox.checked != true && (!isNaN(donationamount)) && magazineval != "") {
                var amountfee = parseInt(pujaprice) + parseInt(donationamount);
                var totalmagazineprice = parseInt(magazineprice) * magazineval;
                document.getElementById("magazinefinalamount").value = totalmagazineprice;
                document.getElementById("total_value").value = amountfee + totalmagazineprice;
            }
            else if (seniorcheckbox.checked != true && isNaN(donationamount) && magazineval != "") {
                var amountfee = parseInt(pujaprice);
                var totalmagazineprice = parseInt(magazineprice) * magazineval;
                document.getElementById("magazinefinalamount").value = totalmagazineprice;
                document.getElementById("total_value").value = amountfee + totalmagazineprice;
            }
            else {
                document.getElementById("total_value").value = pujaprice;
            }
            scheduleAdultChildRegistrationAfterBaseTotal();
        }
    }

    function openReturningUserOtpForPuja() {
        if (typeof window.OtpMemberVerify === 'undefined') {
            alert('OTP verification is not available. Please refresh and try again.');
            return false;
        }
        window.OtpMemberVerify.open({
            onVerified: function (memberId) {
                $('#otp-session-verified').text(memberId || '');
                $('#termMember').val(memberId || '');
                $('#term').val('Verified Member ' + (memberId || '')).prop('readonly', true).attr('autocomplete', 'off');
                $('#membersearchdiv').hide();
                $('#memberinformationdiv').show();
                $('#otp-verified-banner').show();
                MemberSelectdonation();
            }
        });
        window.onOtpModalCancelled = function () {
            $('#pul2').val('');
            $('#membersearchdiv').hide();
            $('#memberinformationdiv').hide();
            $('#otp-verified-banner').hide();
        };
        return true;
    }

    $("#pul").change(function () {
        $("#pul2").val("");
        $("#ddlStatus").val("");
        $("#commonpricedrop").hide();
        $("#showMember").hide();
        $("#studentootcheck").hide();
        $("#membersearchdiv").hide();
        $("#memberinformationdiv").hide();
        $("#futureytd").val("");
        $('#ytdmess').hide();
        // clean seniordiscound hidden field  value
        document.getElementById("seniordiscountamount").value = "";
        document.getElementById("parentregprice").value = "";

        $("#admindoccheck").hide();
        document.getElementById("admincheckdocument").checked = false;

    });

    //set price dropdown from table
    $("#pul2").change(function () {
        //
        // clean seniordiscound hidden field  value
        document.getElementById("seniordiscountamount").value = "";
        document.getElementById("parentregprice").value = "";
        var loginrole = <?php echo (json_encode($adminrole)); ?>;
        var val = $(this).val();
        var pyjaname = $("#pul").val();
        //for hide & clean previous select div value
        $("#ddlOptional").val("");
        $("#ddlOptionalchild").val("");
        $("#dvOptionalchild1").hide();
        $("#dvOptionalchild2").hide();
        $("#dvOptionalchild3").hide();
        $("#dvOptional1").hide();
        $("#dvOptional2").hide();

        document.getElementById("studentcheck").checked = false;
        document.getElementById("ottcheck").checked = false;
        document.getElementById("senior").checked = false;

        // 24julyupdate
        $("#admindoccheck").hide();
        document.getElementById("admincheckdocument").checked = false;

        //new condition
        document.getElementById("studentdivcheck").style.display = "block";
        document.getElementById("oottdivcheck").style.display = "block";
        if (loginrole != true) {
            document.getElementById("documentuploaddiv").style.display = "none";
            document.getElementById('documentsubmitbuttondiv').style.display = 'none';
        }
        document.getElementById('schoolnamediv').style.display = 'none';
        $("#file").prop('required', false);

        document.getElementById("addcartbuttondiv").style.display = "block";

        //11july add
        $("#memphone2fam").val("");
        // 21-july update
        //$('#memphone2fam').removeClass('MIDtext2readonly')
        //$('#memphone2fam').addClass('MIDtext2');


        $('#mememailfam').prop('readonly', false);
        $('#memphonefam').prop('readonly', false);
        // 21-july update
        //$('#memphone2fam').prop('readonly', false);

        $("#memparentfnamefam").prop('required', false);
        $("#memparentlnamefam").prop('required', false);
        $("#memparent2fnamefam").prop('required', false);
        $("#memparent2lnamefam").prop('required', false);

        $('#sponsorcheck').hide();
        $('#ytdmess').hide();
        $('#seniordismsg').hide();

        if (pyjaname == "") {
            alert('Please Select Puja Name First');
            $("#pul2").val("");
            return;
        }
        $("#studentootcheck").show();
        var url1 = $("#container-abc-url-id").text();
        $.ajax({
            type: "POST",
            data: {
                paymentfor: val,
                pyjaname: pyjaname,

            },
            url: url1 + "load.php?controller=PujaOnlinePayments&action=getpujapricedata",
            success: function (res) {
                replacePujaPriceOptions(res);

            }
        });

        if (val == "member") {
            $("#showMember").show();
            $("#commonpricedrop").show();
            $("#membersearchdiv").show();
            $("#dvFamily").hide();
            $("#memberinformationdiv").show();
            $("#futureytd").val("");
            $('#ytdmess').hide();

            //clean field
            $("#ddlStatus").val("");
            $("#memidfam").val("");
            $("#memcatfam").val("");
            $("#memfnamefam").val("");
            $("#memlnamefam").val("");
            $("#memtypefam").val("");
            $("#memstreetnamefam").val("");
            $("#memstreetnamefam").val("");
            $("#memcityfam").val("");
            $("#memstatefam").val("");
            $("#mamzipcodefam").val("");
            $("#memphonefam").val("");
            $("#memphone2fam").val("");
            $("#ddlOptional").val("");
            $("#memparentfnamefam").val("");
            $("#memparentfnamefam").val("");
            $("#memparent2fnamefam").val("");
            $("#memparent2lnamefam").val("");
            $("#ytd1").val("");
            $("#magazinedata").val("");
            $("#totaldonation").val("");
            $("#memchildfnamefam").val("");
            $("#memchildlnamefam").val("");
            $("#memchildagefam").val("");
            $("#memchildagefam").val("");
            $("#memchildfnamefam2").val("");
            $("#memchildlnamefam2").val("");
            $("#memchildagefam2").val("");
            $("#memchildfnamefam22").val("");
            $("#memchildlnamefam22").val("");
            $("#memchildagefam22").val("");
            $("#termMember").val("");
            $("#memspfnamefam").val("");
            $("#memsplnamefam").val("");
            $("#memstreetfam").val("");
            $("#term").val("");
            $("#mememailfam").val("");
            $("#total_value").val("");
            $("#updateAddressCheck").prop("checked", false);
            applyAddressUpdateState();

            //makefield readonly
            $('#memfnamefam').prop('readonly', true);
            $('#memlnamefam').prop('readonly', true);
            $('#memphonefam').addClass('MIDtext2readonly');
            // 21-july update
            //$('#memphone2fam').addClass('MIDtext2readonly');
            $('#mememailfam').addClass('MIDtext2readonly');

            $('#memchildagefam').removeClass('hasDatepicker');
            $('#memchildagefam2').removeClass('hasDatepicker');
            $('#memchildagefam22').removeClass('hasDatepicker');
            if (loginrole != true) {
                var verifiedMemberId = $.trim($('#otp-session-verified').text() || '');
                $("#membersearchdiv").hide();
                $('#term').prop('readonly', true).attr('autocomplete', 'off');
                if (verifiedMemberId) {
                    $('#termMember').val(verifiedMemberId);
                    $('#term').val('Verified Member ' + verifiedMemberId);
                    $('#otp-verified-banner').show();
                    MemberSelectdonation();
                } else {
                    $('#otp-verified-banner').hide();
                    openReturningUserOtpForPuja();
                }
            }
            //make field required
            // $("#ddlStatus").prop('required',true);
            // $("#term").prop('required',true);
            // $("#memstreetfam").prop('required',true);
            // $("#memstreetnamefam").prop('required',true);
            // $("#memcityfam").prop('required',true);
            // $("#memstatefam").prop('required',true);
            // $("#mamzipcodefam").prop('required',true);
            // $("#memphonefam").prop('required',true);
            // $("#mememailfam").prop('required',true);

        }

        else if (val == "nonmember") {
            $("#showMember").show();
            $("#commonpricedrop").show();
            $("#membersearchdiv").hide();
            $("#dvFamily").hide();
            $("#childinputdiv").hide();
            $("#memberinformationdiv").hide();
            //clean field
            $("#ddlStatus_NM").val("");
            $("#memidfam").val("");
            $("#memcatfam").val("");
            $("#memtypefam").val("");
            $("#futureytd").val("");
            $('#ytdmess').hide();
            $("#memfnamefam").val("");
            $("#memlnamefam").val("");
            $("#memspfnamefam").val("");
            $("#memsplnamefam").val("");
            $("#memstreetfam").val("");
            $("#mememailfam").val("");
            $("#total_value").val("");

            $("#memstreetnamefam").val("");
            $("#memstreetnamefam").val("");
            $("#memcityfam").val("");
            $("#memstatefam").val("");
            $("#mamzipcodefam").val("");
            $("#memphonefam").val("");
            $("#memphone2fam").val("");
            $("#ddlOptional").val("");
            $("#memparentfnamefam").val("");
            $("#memparentfnamefam").val("");
            $("#memparent2fnamefam").val("");
            $("#memparent2lnamefam").val("");
            $("#ytd1").val("");
            $("#magazinedata").val("");
            $("#totaldonation").val("");
            $("#memchildfnamefam").val("");
            $("#memchildlnamefam").val("");
            $("#memchildagefam").val("");
            $("#memchildagefam").val("");
            $("#memchildfnamefam2").val("");
            $("#memchildlnamefam2").val("");
            $("#memchildagefam2").val("");
            $("#memchildfnamefam22").val("");
            $("#memchildlnamefam22").val("");
            $("#memchildagefam22").val("");

            //makefield readonly
            $('#memfnamefam').prop('readonly', false);
            $('#memlnamefam').prop('readonly', false);
            $('#mememailfam').prop('readonly', false);
            $('#memphonefam').prop('readonly', false);
            // 21-july update
            //$('#memphone2fam').prop('readonly', false);

            $('#memphonefam').removeClass('MIDtext2readonly');
            $('#memphonefam').addClass('MIDtext2');

            // 21-july update
            //$('#memphone2fam').removeClass('MIDtext2readonly');
            //$('#memphone2fam').addClass('MIDtext2');
            $('#mememailfam').removeClass('MIDtext2readonly');
            $('#mememailfam').addClass('MIDtext2');
            $("#updateAddressCheck").prop("checked", false);
            applyAddressUpdateState();

        }
        else {
            $("#showMember").hide();
            $("#commonpricedrop").hide();
            $("#membersearchdiv").hide();
            $("#studentootcheck").hide();
            $("#memberinformationdiv").hide();
            $('#mememailfam').prop('readonly', false);
            $('#memphonefam').prop('readonly', false);
            $('#memphonefam').addClass('MIDtext2readonly');

            // 21-july update
            //$('#memphone2fam').prop('readonly', false);
            //$('#memphone2fam').addClass('MIDtext2readonly');
            $('#mememailfam').addClass('MIDtext2readonly');
        }
    });

    $("#ddlStatus").change(function () {
        checkDuplicatePujaRegistrationForSelectedType();

        var membertype = $("#pul2").val();
        var statusddlval = $("#pul").val();
        var spousefirstname = $("#memspfnamefam").val();
        var membercategory = $.trim($("#memcatfam").val());
        var studentcheckbox = document.getElementById('studentcheck');
        // clean seniordiscound hidden field  value
        document.getElementById("seniordiscountamount").value = "";
        document.getElementById("parentregprice").value = "";
        $('#sponsorcheck').hide();
        $('#ytdmess').hide();

        document.getElementById("swap").checked = false;
        document.getElementById("senior").checked = false;
        document.getElementById("myCheck").checked = false;
        document.getElementById("myCheck2").checked = false;
        $('#seniordismsg').hide();
        $("#spousenamediv").hide();
        $("#swapregcheckboxdiv").hide();
        $("#totaldonation").val("");
        $("#magazinedata").val("");
        $("#futureytd").val("");
        $("#total_value").val("");
        //for hide & clean previous select div value
        $("#ddlOptional").val("");
        $("#ddlOptionalchild").val("");
        $("#adultChildOptInRow").hide();
        $("#adultChildCountRow").hide();
        $("#coRegisterAdultChildren").prop("checked", false);
        $("#adultregprice").val("");
        updateAdultChildPriceSummary();
        $("#dvOptionalchild1").hide();
        $("#dvOptionalchild2").hide();
        $("#dvOptionalchild3").hide();
        $("#dvOptional1").hide();
        $("#dvOptional2").hide();
        $('#memchildfnamefam').prop('readonly', true);
        $('#memchildlnamefam').prop('readonly', true);
        $('#memchildagefam').prop('readonly', true);

        $('#memchildfnamefam2').prop('readonly', true);
        $('#memchildlnamefam2').prop('readonly', true);
        $('#memchildagefam2').prop('readonly', true);

        $('#memchildfnamefam22').prop('readonly', true);
        $('#memchildlnamefam22').prop('readonly', true);
        $('#memchildagefam22').prop('readonly', true);


        $("#memparentfnamefam").prop('required', false);
        $("#memparentlnamefam").prop('required', false);
        $("#memparent2fnamefam").prop('required', false);
        $("#memparent2lnamefam").prop('required', false);

        document.getElementById("one").style.display = "block";
        document.getElementById("two").style.display = "block";

        //for hide child div
        document.getElementById('dvOptionalchild1').style.display = 'none';
        document.getElementById('dvOptionalchild2').style.display = 'none';
        document.getElementById('dvOptionalchild3').style.display = 'none';

        var childonefirstname = $("#memchildfnamefam").val();
        var childtwofirstname = $("#memchildfnamefam2").val();
        var childthreefirstname = $("#memchildfnamefam22").val();

        var memberchild1 = $("#memchildagefam").val();
        var memberchild2 = $("#memchildagefam2").val();
        var memberchild3 = $("#memchildagefam22").val();
        var compareyear = '<?php echo htmlspecialchars($tpl['child_yob_cutoff'] ?? '2004', ENT_QUOTES); ?>';
        //var statusddlval = $("#pul option:selected").text();

        var txtselectpujaname = $("#ddlStatus option:selected").text();
        text = txtselectpujaname.split(" ");
        var pujaname = text[0];
        var pujaprice = text[1].replace('$', "");
        document.getElementById("hiddenpujaname").value = pujaname;
        document.getElementById("pujapriceval").value = pujaprice;
        //7july update new condition for student checkbox
        if (pujaname == "family" && membertype == "member" && studentcheckbox.checked != true) {
            $('#memchildagefam').removeClass('hasDatepicker');
            $('#memchildagefam2').removeClass('hasDatepicker');
            $('#memchildagefam22').removeClass('hasDatepicker');

            $("#dvFamily").show();
            //Method call for append puja options for parent registration
            //showParentPujaRegistrationOption();
            $("#spousenamediv").show();
            if (isAdultChildEligibleMember()) {
                showAdultChildRegistrationOption();
            } else {
                $("#childinputdiv").hide();
                $("#ddlOptionalchild").hide();
            }
            $("#childinformationdiv").hide();
            $("#swapregcheckboxdiv").hide();
            $("#swapregcheckboxdiv").hide();
            document.getElementById("total_value").value = pujaprice;
        }
        else if (pujaname == "family" && membertype == "member" && studentcheckbox.checked == true) {
            $("#dvFamily").hide();
            $("#spousenamediv").hide();
            $("#childinputdiv").hide();
            $("#ddlOptionalchild").hide();
            $("#childinformationdiv").hide();
            $("#swapregcheckboxdiv").hide();
            $("#swapregcheckboxdiv").hide();
            document.getElementById("total_value").value = pujaprice;

        }
        else if (pujaname == "individual" && membertype == "member" && spousefirstname == "" && studentcheckbox.checked != true) {
            // $("#dvFamily").hide();
            $("#dvFamily").show();
            //Method call for append puja options for parent registration
            //showParentPujaRegistrationOption();
            if (isAdultChildEligibleMember()) {
                showAdultChildRegistrationOption();
            } else {
                $("#childinputdiv").hide();
                $("#ddlOptionalchild").hide();
            }
            $("#spousenamediv").hide();
            $("#childinformationdiv").hide();
            $("#swapregcheckboxdiv").hide();
            document.getElementById("total_value").value = pujaprice;
        }
        else if (pujaname == "individual" && membertype == "member" && spousefirstname == "" && studentcheckbox.checked == true) {
            $("#dvFamily").hide();
            //$("#dvFamily").show();
            $("#childinputdiv").hide();
            $("#spousenamediv").hide();
            $("#ddlOptionalchild").hide();
            $("#childinformationdiv").hide();
            $("#swapregcheckboxdiv").hide();
            document.getElementById("total_value").value = pujaprice;
        }
        //11julyupdate
        else if (pujaname == "individual" && spousefirstname != "" && studentcheckbox.checked != true) {
            $("#swapregcheckboxdiv").show();
            //$("#dvFamily").hide();
            $("#dvFamily").show();
            //Method call for append puja options for parent registration
            //showParentPujaRegistrationOption();
            if (isAdultChildEligibleMember()) {
                showAdultChildRegistrationOption();
            } else {
                $("#childinputdiv").hide();
                $("#ddlOptionalchild").hide();
            }
            $("#spousenamediv").hide();
            $("#childinformationdiv").hide();
            document.getElementById("total_value").value = pujaprice;
        }

        //11july add new 
        else if (pujaname == "individual" && spousefirstname != "" && studentcheckbox.checked == true) {
            $("#dvFamily").hide();
            //$("#dvFamily").show();
            $("#childinputdiv").hide();
            $("#swapregcheckboxdiv").hide();
            $("#spousenamediv").hide();
            $("#ddlOptionalchild").hide();
            $("#childinformationdiv").hide();
            document.getElementById("total_value").value = pujaprice;
        }


        else if (pujaname == "family" && membertype == "nonmember" && studentcheckbox.checked != true) {
            $("#dvFamily").show();
            //Method call for append puja options for parent registration
            //showParentPujaRegistrationOption();
            $("#spousenamediv").show();
            $("#childinputdiv").show();
            $("#adultChildOptInRow").hide();
            $("#adultChildCountRow").show();
            $("#childinformationdiv").show();
            $("#ddlOptionalchild").show();
            $("#swapregcheckboxdiv").hide();

            $('#memchildfnamefam').prop('readonly', false);
            $('#memchildlnamefam').prop('readonly', false);
            $('#memchildagefam').prop('readonly', false);

            $('#memchildfnamefam2').prop('readonly', false);
            $('#memchildlnamefam2').prop('readonly', false);
            $('#memchildagefam2').prop('readonly', false);

            $('#memchildfnamefam22').prop('readonly', false);
            $('#memchildlnamefam22').prop('readonly', false);
            $('#memchildagefam22').prop('readonly', false);
            document.getElementById("total_value").value = pujaprice;

            $('#memchildagefam').datepicker({
                dateFormat: "yy",
                yearRange: "c-22:c",
                changeMonth: false,
                changeYear: true,
                showButtonPanel: false,
                closeText: 'Select',
                currentText: 'This year',
                onClose: function (dateText, inst) {
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).val($.datepicker.formatDate("yy", new Date(year, 0, 1)));
                }
            }).focus(function () {
                $(".ui-datepicker-month").hide();
                $(".ui-datepicker-calendar").hide();
                $(".ui-datepicker-current").hide();
                $(".ui-datepicker-prev").hide();
                $(".ui-datepicker-next").hide();
                $("#ui-datepicker-div").position({
                    my: "left top",
                    at: "left bottom",
                    of: $(this)
                });
            }).attr("readonly", true);

            $('#memchildagefam2').datepicker({
                dateFormat: "yy",
                yearRange: "c-22:c",
                changeMonth: false,
                changeYear: true,
                showButtonPanel: false,
                closeText: 'Select',
                currentText: 'This year',
                onClose: function (dateText, inst) {
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).val($.datepicker.formatDate("yy", new Date(year, 0, 1)));
                }
            }).focus(function () {
                $(".ui-datepicker-month").hide();
                $(".ui-datepicker-calendar").hide();
                $(".ui-datepicker-current").hide();
                $(".ui-datepicker-prev").hide();
                $(".ui-datepicker-next").hide();
                $("#ui-datepicker-div").position({
                    my: "left top",
                    at: "left bottom",
                    of: $(this)
                });
            }).attr("readonly", true);

            $('#memchildagefam22').datepicker({
                dateFormat: "yy",
                yearRange: "c-22:c",
                changeMonth: false,
                changeYear: true,
                showButtonPanel: false,
                closeText: 'Select',
                currentText: 'This year',
                onClose: function (dateText, inst) {
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).val($.datepicker.formatDate("yy", new Date(year, 0, 1)));
                }
            }).focus(function () {
                $(".ui-datepicker-month").hide();
                $(".ui-datepicker-calendar").hide();
                $(".ui-datepicker-current").hide();
                $(".ui-datepicker-prev").hide();
                $(".ui-datepicker-next").hide();
                $("#ui-datepicker-div").position({
                    my: "left top",
                    at: "left bottom",
                    of: $(this)
                });
            }).attr("readonly", true);

        }
        else if (pujaname == "family" && membertype == "nonmember" && studentcheckbox.checked == true) {
            $("#dvFamily").hide();
            $("#spousenamediv").hide();
            $("#childinputdiv").hide();
            $("#childinformationdiv").hide();
            $("#ddlOptionalchild").hide();
            $("#swapregcheckboxdiv").hide();

            document.getElementById("total_value").value = pujaprice;

        }
        else if (pujaname == "individual" && membertype == "nonmember" && studentcheckbox.checked != true) {
            //$("#dvFamily").hide();
            $("#dvFamily").show();
            //Method call for append puja options for parent registration
            //showParentPujaRegistrationOption();
            $("#childinputdiv").hide();
            $("#spousenamediv").hide();
            $("#childinformationdiv").hide();
            $("#dvIndividual").hide();
            $("#swapregcheckboxdiv").hide();
            document.getElementById("total_value").value = pujaprice;
        }
        else if (pujaname == "individual" && membertype == "nonmember" && studentcheckbox.checked == true) {
            $("#dvFamily").hide();
            //$("#dvFamily").show();
            $("#childinputdiv").hide();
            $("#spousenamediv").hide();
            $("#childinformationdiv").hide();
            $("#dvIndividual").hide();
            $("#swapregcheckboxdiv").hide();
            document.getElementById("total_value").value = pujaprice;
        }
        else {
            $("#dvFamily").hide();
            $("#swapregcheckboxdiv").hide();
            $("#spousenamediv").hide();
            $("#childinputdiv").hide();
            $("#childinformationdiv").hide();
            $("#dvIndividual").hide();
            $("#ddlOptionalchild").hide();
            $("#total_value").val("");
        }

        if (isGdGcMembershipCategory()) {
            hideAdultChildRegistrationOption();
        }

        syncFilledChildRowsVisibility();
    });

    $("#ddlOptional").change(function () {
        if ($(this).val() == "1") {
            $("#dvOptional1").show();
            $("#dvOptional2").hide();
        } else if ($(this).val() == "2") {
            $("#dvOptional1").show();
            $("#dvOptional2").show();
        }
        else {
            $("#dvOptional1").hide();
            $("#dvOptional2").hide();
        }
    });


    $("#ddlOptionalchild").change(function () {
        if ($("#coRegisterAdultChildren").is(":checked")) {
            var selectedCount = parseInt($(this).val(), 10);
            if (isNaN(selectedCount)) {
                selectedCount = 0;
            }
            syncAdultChildDropdownOptions();
            showSelectedAdultChildRows(selectedCount);
            applyChildRegistrationAmount();
            return;
        }
        $("#memchildfnamefam, #memchildlnamefam, #memchildfnamefam2, #memchildlnamefam2, #memchildfnamefam22, #memchildlnamefam22").prop("required", false);
        if ($(this).val() == "1") {
            $("#dvOptionalchild1").show();
            $("#dvOptionalchild2").hide();
            $("#dvOptionalchild3").hide();
            $("#memchildfnamefam, #memchildlnamefam").prop("required", true);
        }
        else if ($(this).val() == "2") {
            $("#dvOptionalchild1").show();
            $("#dvOptionalchild2").show();
            $("#dvOptionalchild3").hide();
            $("#memchildfnamefam, #memchildlnamefam, #memchildfnamefam2, #memchildlnamefam2").prop("required", true);
        }
        else if ($(this).val() == "3") {
            $("#dvOptionalchild1").show();
            $("#dvOptionalchild2").show();
            $("#dvOptionalchild3").show();
            $("#memchildfnamefam, #memchildlnamefam, #memchildfnamefam2, #memchildlnamefam2, #memchildfnamefam22, #memchildlnamefam22").prop("required", true);
        }

        else {
            $("#dvOptionalchild1").hide();
            $("#dvOptionalchild2").hide();
            $("#dvOptionalchild3").hide();
        }
        applyChildRegistrationAmount();
    });

    $("#memchildfnamefam, #memchildlnamefam, #memchildagefam, #memchildfnamefam2, #memchildlnamefam2, #memchildagefam2, #memchildfnamefam22, #memchildlnamefam22, #memchildagefam22").on("keyup change", function () {
        if ($("#coRegisterAdultChildren").is(":checked")) {
            applyChildRegistrationAmount();
        }
    });


    // Donation parking based start work javascript

    function ListCreate() {
        //
        var sponsortype = $("#sponser").val();
        if (sponsortype == 'yes') {
            var ytd = $("#futureytd").val();
            var diamondval = $("#diamond").text().replace(/[^\w\s]/gi, '').split(" ");
            var emeraldval = $("#emerald").text().replace(/[^\w\s]/gi, '').split(" ");
            var platinumval = $("#platinum").text().replace(/[^\w\s]/gi, '').split(" ");
            var goldval = $("#gold").text().replace(/[^\w\s]/gi, '').split(" ");
            var silverval = $("#silver").text().replace(/[^\w\s]/gi, '').split(" ");

            var dollarsign = "$";
            var diamond = diamondval[0];
            var diamondfinal = dollarsign.concat("", diamond);
            var emerald = emeraldval[0];
            var emeraldfinal = dollarsign.concat("", emerald);
            var platinum = platinumval[0];
            var platinumfinal = dollarsign.concat("", platinum);
            var Gold = goldval[0];
            var Goldfinal = dollarsign.concat("", Gold);
            var silver = silverval[0];
            var silverfinal = dollarsign.concat("", silver);

            var newdiamondprice = "";
            var newemeraldprice = "";
            var newplatinumprice = "";
            var newGoldprice = "";
            var newsilverprice = "";

            var modal = document.getElementById("myModal");
            modal.style.display = "block";
            $("#newdiamondtd").remove();
            $("#newemeraldtd").remove();
            $("#newplatinumtd").remove();
            $("#newgold").remove();
            $("#newsilvertd").remove();

            var ytdAmount = parseFloat(ytd) || 0;
            function sponsorNeeded(minAmount) {
                var needed = minAmount - ytdAmount;
                return needed > 0 ? "$" + needed : "";
            }

            var newdiamondprice = sponsorNeeded(getPujaYtdTierMin('diamond', 5000));
            var newemeraldprice = sponsorNeeded(getPujaYtdTierMin('emerald', 2200));
            var newplatinumprice = sponsorNeeded(getPujaYtdTierMin('platinum', 1500));
            var newgoldprice = sponsorNeeded(getPujaYtdTierMin('gold', 1000));
            var newsilverprice = sponsorNeeded(getPujaYtdTierMin('silver', 750));

            $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control" value="${newdiamondprice}"></td>`);
            $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control" value="${newemeraldprice}"></td>`);
            $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver" onclick="buttonval(this)" class="form-control" value="${newplatinumprice}"></td>`);
            $('#goldtr').append(`<td class="td" id="newgold"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver" onclick="buttonval(this)" class="form-control" value="${newgoldprice}"></td>`);
            $('#silvertr').append(`<td class="td" id="newsilvertd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control" value="${newsilverprice}"></td>`);
            return;

            if (ytd == 0 || ytd == null || ytd == "") {
                $('#diamondtr').append(`<td class="td"  id="newdiamondtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngrand" class="form-control" value= "${diamondfinal}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngold" class="form-control" value="${emeraldfinal}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver" class="form-control" value="${platinumfinal}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver" class="form-control" value="${Goldfinal}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;"  readonly type="text" id="btnplat" class="form-control" value="${silverfinal}"></td>`);
            }
            else if (ytd < 399) {
                //
                newpricediamond = diamond - ytd;
                var dollarsign = "$";
                var newdiamondprice = dollarsign.concat("", newpricediamond);
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newpriceemerald = emerald - ytd;
                var newemeraldprice = dollarsign.concat("", newpriceemerald);
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newpriceplatinum = platinum - ytd;
                var newplatinumprice = dollarsign.concat("", newpriceplatinum);
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newpricegold = Gold - ytd;
                var newgoldprice = dollarsign.concat("", newpricegold);
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newpricesilver = silver - ytd;
                var newsilverprice = dollarsign.concat("", newpricesilver);
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control" value= "${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;"  readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control" value="${newsilverprice}"></td>`);
            }

            else if (ytd >= 400 && ytd < 799) {
                //
                newpricediamond = diamond - ytd;
                var dollarsign = "$";
                var newdiamondprice = dollarsign.concat("", newpricediamond);
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newpriceemerald = emerald - ytd;
                var newemeraldprice = dollarsign.concat("", newpriceemerald);
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newpriceplatinum = platinum - ytd;
                var newplatinumprice = dollarsign.concat("", newpriceplatinum);
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newpricegold = Gold - ytd;
                var newgoldprice = dollarsign.concat("", newpricegold);
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newpricesilver = silver - ytd;
                var newsilverprice = dollarsign.concat("", newpricesilver);
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control" value="${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control" value="${newsilverprice}"></td>`);
            }
            else if (ytd >= 800 && ytd < 1199) {
                newpricediamond = diamond - ytd;
                var dollarsign = "$";
                var newdiamondprice = dollarsign.concat("", newpricediamond);
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newpriceemerald = emerald - ytd;
                var newemeraldprice = dollarsign.concat("", newpriceemerald);
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newpriceplatinum = platinum - ytd;
                var newplatinumprice = dollarsign.concat("", newpriceplatinum);
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newpricegold = Gold - ytd;
                var newgoldprice = dollarsign.concat("", newpricegold);
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newpricesilver = silver - ytd;
                var newsilverprice = dollarsign.concat("", newpricesilver);
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control" value= "${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control" value="${newsilverprice}"></td>`);
            }
            else if (ytd >= 1200 && ytd < 2000) {
                newpricediamond = diamond - ytd;
                var dollarsign = "$";
                var newdiamondprice = dollarsign.concat("", newpricediamond);
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newpriceemerald = emerald - ytd;
                var newemeraldprice = dollarsign.concat("", newpriceemerald);
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newpriceplatinum = platinum - ytd;
                var newplatinumprice = dollarsign.concat("", newpriceplatinum);
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newpricegold = Gold - ytd;
                var newgoldprice = dollarsign.concat("", newpricegold);
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newpricesilver = silver - ytd;
                var newsilverprice = dollarsign.concat("", newpricesilver);
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;"  readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control" value= "${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;"  readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control" value="${newsilverprice}"></td>`);
            }
            else if (ytd >= 2000 && ytd < 5000) {
                newpricediamond = diamond - ytd;
                var dollarsign = "$";
                var newdiamondprice = dollarsign.concat("", newpricediamond);
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newpriceemerald = emerald - ytd;
                var newemeraldprice = dollarsign.concat("", newpriceemerald);
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newpriceplatinum = platinum - ytd;
                var newplatinumprice = dollarsign.concat("", newpriceplatinum);
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newpricegold = Gold - ytd;
                var newgoldprice = dollarsign.concat("", newpricegold);
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newpricesilver = silver - ytd;
                var newsilverprice = dollarsign.concat("", newpricesilver);
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control" value= "${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control" value="${newsilverprice}"></td>`);
            }
            else if (ytd >= 5000) {
                newpricediamond = diamond - ytd;
                var dollarsign = "$";
                var newdiamondprice = dollarsign.concat("", newpricediamond);
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newpriceemerald = emerald - ytd;
                var newemeraldprice = dollarsign.concat("", newpriceemerald);
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newpriceplatinum = platinum - ytd;
                var newplatinumprice = dollarsign.concat("", newpriceplatinum);
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newpricegold = Gold - ytd;
                var newgoldprice = dollarsign.concat("", newpricegold);
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newpricesilver = silver - ytd;
                var newsilverprice = dollarsign.concat("", newpricesilver);
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control" value= "${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control" value="${newsilverprice}"></td>`);
            }
        }

    };
    function ListCreatepreviousbackup() {
        //
        var sponsortype = $("#sponser").val();
        if (sponsortype == 'yes') {
            var ytd = $("#futureytd").val();
            var diamondval = $("#diamond").text().replace(/[^\w\s]/gi, '').split(" ");
            var emeraldval = $("#emerald").text().replace(/[^\w\s]/gi, '').split(" ");
            var platinumval = $("#platinum").text().replace(/[^\w\s]/gi, '').split(" ");
            var goldval = $("#gold").text().replace(/[^\w\s]/gi, '').split(" ");
            var silverval = $("#silver").text().replace(/[^\w\s]/gi, '').split(" ");

            var diamond = diamondval[0];
            var emerald = emeraldval[0];
            var platinum = platinumval[0];
            var Gold = goldval[0];
            var silver = silverval[0];

            var newdiamondprice = "";
            var newemeraldprice = "";
            var newplatinumprice = "";
            var newGoldprice = "";
            var newsilverprice = "";

            var modal = document.getElementById("myModal");
            modal.style.display = "block";
            $("#newdiamondtd").remove();
            $("#newemeraldtd").remove();
            $("#newplatinumtd").remove();
            $("#newgold").remove();
            $("#newsilvertd").remove();
            if (ytd == 0 || ytd == null || ytd == "") {
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input readonly type="text" id="btngrand"  class="form-control input-sm" value= "${diamond}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input  readonly type="text" id="btngold"  class="form-control input-sm" value="${emerald}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input  readonly type="text" id="btnsilver"   class="form-control input-sm" value="${platinum}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input  readonly type="text" id="btnsilver"   class="form-control input-sm" value="${Gold}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input  readonly type="text" id="btnplat"  class="form-control input-sm" value="${silver}"></td>`);
            }
            else if (ytd < 399) {
                //
                newdiamondprice = diamond - ytd;
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newemeraldprice = emerald - ytd;
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newplatinumprice = platinum - ytd;
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newgoldprice = Gold - ytd;
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newsilverprice = silver - ytd;
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input  readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control input-sm" value= "${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input  readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control input-sm" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input  readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input  readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input  readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control input-sm" value="${newsilverprice}"></td>`);
            }

            else if (ytd >= 400 && ytd < 799) {
                //
                newdiamondprice = diamond - ytd;
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newemeraldprice = emerald - ytd;
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newplatinumprice = platinum - ytd;
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newgoldprice = Gold - ytd;
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newsilverprice = silver - ytd;
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input  readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control input-sm" value= "${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input  readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control input-sm" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input  readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input  readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input  readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control input-sm" value="${newsilverprice}"></td>`);
            }
            else if (ytd >= 800 && ytd < 1199) {
                newdiamondprice = diamond - ytd;
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newemeraldprice = emerald - ytd;
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newplatinumprice = platinum - ytd;
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newgoldprice = Gold - ytd;
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newsilverprice = silver - ytd;
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input  readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control input-sm" value= "${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input  readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control input-sm" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input  readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input  readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input  readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control input-sm" value="${newsilverprice}"></td>`);
            }
            else if (ytd >= 1200 && ytd < 2000) {
                newdiamondprice = diamond - ytd;
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newemeraldprice = emerald - ytd;
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newplatinumprice = platinum - ytd;
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newgoldprice = Gold - ytd;
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newsilverprice = silver - ytd;
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input  readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control input-sm" value= "${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input  readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control input-sm" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input  readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input  readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control input-sm" value="${newsilverprice}"></td>`);
            }
            else if (ytd >= 2000 && ytd < 5000) {
                newdiamondprice = diamond - ytd;
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newemeraldprice = emerald - ytd;
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newplatinumprice = platinum - ytd;
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newgoldprice = Gold - ytd;
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newsilverprice = silver - ytd;
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input  readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control input-sm" value= "${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input  readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control input-sm" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input  readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input  readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input  readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control input-sm" value="${newsilverprice}"></td>`);
            }
            else if (ytd >= 5000) {
                newdiamondprice = diamond - ytd;
                if (Math.sign(newdiamondprice) === -1) {
                    newdiamondprice = "";
                }
                newemeraldprice = emerald - ytd;
                if (Math.sign(newemeraldprice) === -1) {
                    newemeraldprice = "";
                }
                newplatinumprice = platinum - ytd;
                if (Math.sign(newplatinumprice) === -1) {
                    newplatinumprice = "";
                }
                newgoldprice = Gold - ytd;
                if (Math.sign(newgoldprice) === -1) {
                    newgoldprice = "";
                }
                newsilverprice = silver - ytd;
                if (Math.sign(newsilverprice) === -1) {
                    newsilverprice = "";
                }
                $('#diamondtr').append(`<td class="td" id="newdiamondtd"><input  readonly type="text" id="btngrand" onclick="buttonval(this)" class="form-control input-sm" value= "${newdiamondprice}"></td>`);
                $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input  readonly type="text" id="btngold" onclick="buttonval(this)" class="form-control input-sm" value="${newemeraldprice}"></td>`);
                $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newplatinumprice}"></td>`);
                $('#goldtr').append(`<td class="td" id="newgold"><input readonly type="text" id="btnsilver"  onclick="buttonval(this)" class="form-control input-sm" value="${newgoldprice}"></td>`);
                $('#silvertr').append(`<td class="td" id="newsilvertd"><input  readonly type="text" id="btnplat" onclick="buttonval(this)" class="form-control input-sm" value="${newsilverprice}"></td>`);
            }
        }

    };

    $('#close').click(function (e) {
        //
        var modal = document.getElementById("myModal");
        modal.style.display = "none";

    });

    // end
    function amountvalid() {
        checkDuplicatePujaRegistrationForSelectedType();
        //
        const price = parseFloat($("#totaldonation").val());
        const ytd = parseFloat($("#ytd1").val());
        //var regmember = $("#registrationmember").val();
        var membertype = $("#memcatfam").val();
        $("#total_value").val("");
        var txtselectpujaname = $("#ddlStatus option:selected").text();
        text = txtselectpujaname.split(" ");
        var pujaprice = text[1].replace('$', "");
        var checkbox = document.getElementById('senior');
        var parentone = document.getElementById('myCheck');
        var parenttwo = document.getElementById('myCheck2');
        var magazineval = $("#magazinedata").val();
        if (isNaN(pujaprice)) {
            alert("Please select Puja price first");
            $("#totaldonation").val("");
            return;

        }

        if (!isNaN(price) && checkbox.checked != true && parentone.checked != true && parenttwo.checked != true && magazineval == "") {
            document.getElementById('featureytddiv').style.display = 'block';
            newtotalprice = parseInt(pujaprice) + parseInt(price);
            document.getElementById("total_value").value = newtotalprice;


        }
        else if (!isNaN(price) && checkbox.checked == true && parentone.checked != true && parenttwo.checked != true) {
            calculateseniordiscount();
        }
        else if ((isNaN(price) || price == "") && checkbox.checked == true && parentone.checked != true && parenttwo.checked != true) {
            calculateseniordiscount();
        }
        else if (!isNaN(price) && checkbox.checked == true && parentone.checked == true && parenttwo.checked != true) {
            myFunction();
        }
        else if (!isNaN(price) && checkbox.checked == true && parentone.checked != true && parenttwo.checked == true) {
            myFunction();
        }
        else if ((isNaN(price) || price == "") && checkbox.checked == true && parentone.checked == true && parenttwo.checked != true) {
            myFunction();
        }
        else if ((isNaN(price) || price == "") && checkbox.checked == true && parentone.checked != true && parenttwo.checked == true) {
            myFunction();
        }

        else if (((!isNaN(price)) || price == "") && checkbox.checked != true && parentone.checked != true && parenttwo.checked == true) {
            myFunction();
        }
        else if (((!isNaN(price)) || price == "") && checkbox.checked != true && parentone.checked == true && parenttwo.checked != true) {
            myFunction();
        }
        else if ((isNaN(price) || price == "") && checkbox.checked != true && parentone.checked == true && parenttwo.checked != true) {
            myFunction();
        }
        else if ((isNaN(price) || price == "") && checkbox.checked != true && parentone.checked != true && parenttwo.checked == true) {
            myFunction();
        }
        // new donation casedone
        else if ((isNaN(price) || price == "") && checkbox.checked != true && parentone.checked != true && parenttwo.checked != true && magazineval != "") {
            myFunction();
        }
        else if (((!isNaN(price)) || price == "") && checkbox.checked != true && parentone.checked != true && parenttwo.checked != true && magazineval != "") {
            myFunction();
        }
        else {
            document.getElementById('featureytddiv').style.display = 'none';
            document.getElementById("total_value").value = pujaprice;

        }
        var futureYtd = isNaN(ytd) ? price : price + ytd;
        if (isNaN(futureYtd)) {
            document.getElementById("futureytd").value = '';
            $("#greenFieldParkingDecision").val("");
            $("#sponsorcheck").hide();
            $("#ytdmess").hide();
            $("#featureytddiv").hide();
        } else {
            document.getElementById("futureytd").value = futureYtd;
            var isRegisteredForParkingPuja = txtselectpujaname.indexOf("All 3 Pujas") !== -1 || txtselectpujaname.indexOf("Durga Puja") !== -1;
            var tier = getPujaYtdTier(futureYtd);
            var tierName = tier && tier.tier_name ? tier.tier_name.toLowerCase() : '';
            var silverMinAmount = getPujaYtdTierMin('silver', 750);
            if (futureYtd > 25 && futureYtd < silverMinAmount) {
                $("#sponsorcheck").show();
                $("#greenFieldParkingDecision").val("");
                $("#ytdmess").hide();
                $("#featureytddiv").hide();
            } else {
                $("#sponsorcheck").hide();
                showPujaYtdParkingMessage(futureYtd, membertype, isRegisteredForParkingPuja);
            }
        }
        scheduleAdultChildRegistrationAfterBaseTotal(350);

    }


    // for validate phone no field
    $("#memphonefam").change(function () {
        const phonenumber = $("#memphonefam").val();
        if (!!phonenumber) {
            if (isNaN(phonenumber)) {
                alert("Please Enter mobile Number");
                $("#gocartbutton").addClass('disabled');
                $("#datasubmit").addClass('disabled');
            }
            else if (phonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#gocartbutton").addClass('disabled');
                $("#datasubmit").addClass('disabled');
            }
            else if (phonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#gocartbutton").addClass('disabled');
                $("#datasubmit").addClass('disabled');
            }
            else if (phonenumber.length == 10) {
                $("#gocartbutton").removeClass('disabled');
                $("#datasubmit").removeClass('disabled');
            }
            else {
                $("#gocartbutton").removeClass('disabled');
                $("#datasubmit").removeClass('disabled');
            }
        }
        else {
            $("#memphonefam").prop('required', true);
            $("#memphone2fam").prop('required', true);
            $("#gocartbutton").removeClass('disabled');
            $("#datasubmit").removeClass('disabled');
        }
    });

    $("#memphone2fam").change(function () {
        const phonenumber = $("#memphone2fam").val();
        if (!!phonenumber) {
            if (isNaN(phonenumber)) {
                alert("Please Enter mobile Number");
                $("#gocartbutton").addClass('disabled');
                $("#datasubmit").addClass('disabled');
            }
            else if (phonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#gocartbutton").addClass('disabled');
                $("#datasubmit").addClass('disabled');
            }
            else if (phonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#gocartbutton").addClass('disabled');
                $("#datasubmit").addClass('disabled');
            }
            else if (phonenumber.length == 10) {
                $("#gocartbutton").removeClass('disabled');
                $("#datasubmit").removeClass('disabled');
            }
            else {
                $("#gocartbutton").removeClass('disabled');
                $("#datasubmit").removeClass('disabled');
            }
        }
        else {
            $("#memphone2fam").prop('required', true);
            $("#gocartbutton").removeClass('disabled');
            $("#datasubmit").removeClass('disabled');
        }
    });


    // image  upload validation student 

    $("#file").change(function () {
        //
        var fileInput =
            document.getElementById('file');

        var filePath = fileInput.value;

        // Allowing file type
        var allowedExtensions =
            /(\.jpg|\.jpeg|\.png|\.pdf|\.gif)$/i;

        if (!allowedExtensions.exec(filePath)) {
            alert('Invalid file type');
            fileInput.value = '';
            return false;
            $("#file").prop('required', true);
        }
        else {
            // Image preview
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById(
                        'imagePreview').innerHTML =
                        '<img src="' + e.target.result
                        + '"/>';
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    });

    // Calculate magazine amount
    $("#mag").change(function () {
        //
        var quantity = parseInt($("#mag").val());
        var totalamountprevious = parseInt($("#ddlStatus").val());
        $("#total_value").val('');
        if (isNaN(quantity)) {
            document.getElementById("total_value").value = totalamountprevious;
        }
        else {
            var magzineprice = quantity * 10;
            document.getElementById("total_value").value = totalamountprevious + magzineprice;
        }
    });
    function showimgdiv() {

        var loginrole = <?php echo (json_encode($adminrole)); ?>;
        $("#total_value").val("");
        var checkbox = document.getElementById('studentcheck');
        var membercategory = $("#memcatfam").val();
        var pujaname = $("#pul").val();
        var paypricefor = $("#pul2").val();

        // hide condition for show msg and div 
        $('#seniordismsg').hide();
        $('#sponsorcheck').hide();
        $('#ytdmess').hide();

        document.getElementById("swap").checked = false;
        document.getElementById("senior").checked = false;
        document.getElementById("myCheck").checked = false;
        document.getElementById("myCheck2").checked = false;

        $('#one').show();
        $('#two').show();

        $('#text').hide();
        $('#text2').hide();
        $('#dvFamily').hide();

        $("#memparentfnamefam").val("");
        $("#memparentlnamefam").val("");
        document.getElementById("oneparentveggie").checked = false;
        $("#memparent2fnamefam").val("");
        $("#memparent2lnamefam").val("");
        document.getElementById("parent2veggie").checked = false;

        $("#totaldonation").val("");
        $("#futureytd").val("");
        $("#magazinedata").val("");

        if (checkbox.checked == true && (membercategory == 'GD' || membercategory == 'GC' || membercategory == "")) {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'block';
                document.getElementById('documentsubmitbuttondiv').style.display = 'block';
                document.getElementById('addcartbuttondiv').style.display = 'none';
                $("#file").prop('required', true);

                //24julyupdate
                document.getElementById('admindoccheck').style.display = 'none';
                $("#admincheckdocument").prop('required', false);
            }

            //24julyupdate
            if (loginrole == true) {
                document.getElementById('admindoccheck').style.display = 'block';
                $("#admincheckdocument").prop('required', true);
            }


            document.getElementById('schoolnamediv').style.display = 'block';
            //new add
            $("#seniorcheckdiv").hide();
            $("#oottdivcheck").hide();
            $("#dvFamily").hide();
            $("#totalamount").val("");
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: 'student',
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaOnlinePayments&action=getpujapricedata",
                success: function (res) {
                    replacePujaPriceOptions(res);

                }
            });

        }
        else if (checkbox.checked == true && (membercategory != 'GD' || membercategory != 'GC' || membercategory != "")) {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'none';
                document.getElementById('documentsubmitbuttondiv').style.display = 'none';

                //24julyupdate
                document.getElementById('admindoccheck').style.display = 'none';
                $("#admincheckdocument").prop('required', false);
            }

            //24julyupdate
            if (loginrole == true) {
                document.getElementById('admindoccheck').style.display = 'block';
                $("#admincheckdocument").prop('required', true);
            }
            document.getElementById('schoolnamediv').style.display = 'none';
            document.getElementById('addcartbuttondiv').style.display = 'block';
            // new add
            $("#seniorcheckdiv").hide();
            $("#file").prop('required', false);
            $("#dvFamily").hide();
            $("#oottdivcheck").hide();
            $("#totalamount").val("");
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: 'student',
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaOnlinePayments&action=getpujapricedata",
                success: function (res) {
                    replacePujaPriceOptions(res);

                }
            });
        }
        // update new condition
        else if (checkbox.checked != true && (membercategory == 'GD' || membercategory == 'GC' || membercategory == "") && paypricefor == "member") {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'none';
                document.getElementById('documentsubmitbuttondiv').style.display = 'none';
                document.getElementById('addcartbuttondiv').style.display = 'block';
                $("#file").prop('required', false);
                document.getElementById('addcartbuttondiv').style.display = 'block';
                $("#file").prop('required', false);
            }

            //24julyupdate
            if (loginrole == true) {
                document.getElementById('admindoccheck').style.display = 'none';
                $("#admincheckdocument").prop('required', false);
                document.getElementById("admincheckdocument").checked = false;
            }
            document.getElementById('schoolnamediv').style.display = 'none';

            //  new add
            $("#seniorcheckdiv").show();
            $("#oottdivcheck").show();
            $("#dvFamily").show();
            $("#totalamount").val("");
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: 'nonmember',
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaOnlinePayments&action=getpujapricedata",
                success: function (res) {
                    replacePujaPriceOptions(res);

                }
            });

        }
        else {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'none';
                document.getElementById('documentsubmitbuttondiv').style.display = 'none';
            }
            if (loginrole == true) {
                document.getElementById('admindoccheck').style.display = 'none';
                $("#admincheckdocument").prop('required', false);
                document.getElementById("admincheckdocument").checked = false;
            }
            document.getElementById('schoolnamediv').style.display = 'none';

            document.getElementById('addcartbuttondiv').style.display = 'block';

            // new add
            $("#seniorcheckdiv").show();
            $("#file").prop('required', false);
            $("#oottdivcheck").show();
            $("#dvFamily").show();
            $("#totalamount").val("");
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: paypricefor,
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaOnlinePayments&action=getpujapricedata",
                success: function (res) {
                    replacePujaPriceOptions(res);

                }
            });

        }
    }

    function showimgoot() {

        var loginrole = <?php echo (json_encode($adminrole)); ?>;
        $("#total_value").val("");
        var checkbox = document.getElementById('ottcheck');
        var membercategory = $("#memcatfam").val();
        var pujaname = $("#pul").val();
        var paypricefor = $("#pul2").val();

        // hide condition for show msg and div 
        $('#seniordismsg').hide();
        $('#sponsorcheck').hide();
        $('#ytdmess').hide();

        document.getElementById("swap").checked = false;
        document.getElementById("senior").checked = false;
        document.getElementById("myCheck").checked = false;
        document.getElementById("myCheck2").checked = false;

        $('#one').show();
        $('#two').show();

        $('#text').hide();
        $('#text2').hide();
        $('#dvFamily').hide();

        $("#memparentfnamefam").val("");
        $("#memparentlnamefam").val("");
        document.getElementById("oneparentveggie").checked = false;
        $("#memparent2fnamefam").val("");
        $("#memparent2lnamefam").val("");
        document.getElementById("parent2veggie").checked = false;

        $("#totaldonation").val("");
        $("#futureytd").val("");
        $("#magazinedata").val("");

        if (checkbox.checked == true && (membercategory == 'GD' || membercategory == 'GC' || membercategory == "") && paypricefor == "member") {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'block';
                document.getElementById('documentsubmitbuttondiv').style.display = 'block';
                document.getElementById('addcartbuttondiv').style.display = 'none';
                $("#file").prop('required', true);
                //24julyupdate
                document.getElementById('admindoccheck').style.display = 'none';
                $("#admincheckdocument").prop('required', false);
            }

            //24julyupdate
            if (loginrole == true) {
                document.getElementById('admindoccheck').style.display = 'block';
                $("#admincheckdocument").prop('required', true);
            }

            $("#studentdivcheck").hide();
            $("#totalamount").val("");


            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: 'memberoot',
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaOnlinePayments&action=getpujapricedata",
                success: function (res) {
                    replacePujaPriceOptions(res);

                }
            });

        }
        else if (checkbox.checked == true && (membercategory != 'GD' || membercategory != 'GC' || membercategory != "") && paypricefor == "member") {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'none';
                document.getElementById('documentsubmitbuttondiv').style.display = 'none';

                //24julyupdate
                document.getElementById('admindoccheck').style.display = 'none';
                $("#admincheckdocument").prop('required', false);
            }

            //24julyupdate
            if (loginrole == true) {
                document.getElementById('admindoccheck').style.display = 'block';
                $("#admincheckdocument").prop('required', true);
            }

            document.getElementById('addcartbuttondiv').style.display = 'block';
            $("#file").prop('required', false);
            $("#studentdivcheck").hide();
            $("#totalamount").val("");
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: 'member',
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaOnlinePayments&action=getpujapricedata",
                success: function (res) {
                    replacePujaPriceOptions(res);

                }
            });
        }
        //update new condition
        else if (checkbox.checked == true && (membercategory != 'GD' || membercategory != 'GC' || membercategory != "") && paypricefor == "nonmember") {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'block';
                document.getElementById('documentsubmitbuttondiv').style.display = 'block';
                document.getElementById('addcartbuttondiv').style.display = 'none';
                $("#file").prop('required', true);
                //24julyupdate
                document.getElementById('admindoccheck').style.display = 'none';
                $("#admincheckdocument").prop('required', false);
            }


            //24julyupdate
            if (loginrole == true) {
                document.getElementById('admindoccheck').style.display = 'block';
                $("#admincheckdocument").prop('required', true);
            }
            $("#studentdivcheck").hide();
            $("#totalamount").val("");
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    //11julyupdate
                    //paymentfor: 'nonmemberoot',
                    paymentfor: 'member',
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaOnlinePayments&action=getpujapricedata",
                success: function (res) {
                    replacePujaPriceOptions(res);

                }
            });
        }
        else if (checkbox.checked != true && (membercategory == 'GD' || membercategory == 'GC') && paypricefor == "member") {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'none';
                document.getElementById('documentsubmitbuttondiv').style.display = 'none';
                document.getElementById('addcartbuttondiv').style.display = 'block';
                $("#file").prop('required', false);

                //24julyupdate
                document.getElementById('admindoccheck').style.display = 'none';
                $("#admincheckdocument").prop('required', false);
            }


            //24julyupdate
            if (loginrole == true) {
                document.getElementById('admindoccheck').style.display = 'none';
                $("#admincheckdocument").prop('required', false);
                document.getElementById("admincheckdocument").checked = false;
            }

            $("#studentdivcheck").show();
            $("#totalamount").val("");
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: 'nonmember',
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaOnlinePayments&action=getpujapricedata",
                success: function (res) {
                    replacePujaPriceOptions(res);

                }
            });
        }

        else {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'none';
                document.getElementById('documentsubmitbuttondiv').style.display = 'none';
            }

            //24julyupdate
            if (loginrole == true) {
                document.getElementById('admindoccheck').style.display = 'none';
                $("#admincheckdocument").prop('required', false);
                document.getElementById("admincheckdocument").checked = false;
            }

            document.getElementById('addcartbuttondiv').style.display = 'block';
            $("#file").prop('required', false);
            $("#studentdivcheck").show();
            $("#totalamount").val("");
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: paypricefor,
                    pyjaname: pujaname,
                },
                url: url1 + "load.php?controller=PujaOnlinePayments&action=getpujapricedata",
                success: function (res) {
                    replacePujaPriceOptions(res);

                }
            });
        }
    }

    function calculateseniordiscount() {

        var parentamount = parseInt($("#parentregprice").val());
        var pricepuja = parseInt($("#ddlStatus").val());
        var pujaname = $("#pul").val();
        var txtselectpujaname = $("#ddlStatus option:selected").text();
        text = txtselectpujaname.split(" ");
        var pricefor = text[0];
        var pujaprice = text[1].replace('$', "");
        var doantionamount = parseFloat($("#totaldonation").val());
        var checkbox = document.getElementById('senior');

        var membertype = $("#pul2").val();
        var membercategory = $("#memcatfam").val();
        var studentcheckbox = document.getElementById('studentcheck');
        var ootcheckbox = document.getElementById('ottcheck');

        $('#seniordismsg').hide();
        document.getElementById("seniordiscountamount").value = "";
        //document.getElementById("parentregprice").value = "";

        var magazineval = $("#magazinedata").val();
        var magazineprice = "15";

        if (isNaN(pujaprice)) {
            alert("Please select Puja price first");
            document.getElementById("senior").checked = false;
            return;

        }
        if (checkbox.checked == true) {
            if (membertype == "member" && studentcheckbox.checked != true && ootcheckbox.checked != true) {
                seniorpricefor = "member";
            }
            else if (membertype == "nonmember" && studentcheckbox.checked != true && ootcheckbox.checked != true) {
                seniorpricefor = "nonmember";
            }
            else if (membertype == "member" && studentcheckbox.checked == true && ootcheckbox.checked != true) {
                seniorpricefor = "student";
            }
            else if (membertype == "nonmember" && studentcheckbox.checked == true && ootcheckbox.checked != true) {
                seniorpricefor = "student";
            }
            else if (membertype == "member" && studentcheckbox.checked != true && ootcheckbox.checked == true && (membercategory != 'GD' || membercategory != 'GC' || membercategory != "")) {
                seniorpricefor = "member";
            }

            else if (membertype == "member" && studentcheckbox.checked != true && ootcheckbox.checked == true && (membercategory == 'GD' || membercategory == 'GC' || membercategory == "")) {
                seniorpricefor = "memberoot";
            }
            else if (membertype == "nonmember" && studentcheckbox.checked != true && ootcheckbox.checked == true && (membercategory == 'GD' || membercategory == 'GC' || membercategory == "")) {
                seniorpricefor = "nonmemberoot";
            }
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: seniorpricefor,
                    pyjaname: pujaname,
                    pricetype: pricefor,

                },
                url: url1 + "load.php?controller=PujaOnlinePayments&action=getseniorpricedata",
                success: function (res) {
                    let Seniordiscountprice = "";
                    const discountpriceElement = $(res).filter("input#seniorprice");
                    if (discountpriceElement.length) {
                        Seniordiscountprice = discountpriceElement[0].value;
                        document.getElementById("seniordiscountamount").value = Seniordiscountprice;
                        var dollarsign = "$";
                        var discountprice = Seniordiscountprice.concat("", " Senior Discount Applied.");
                        var discountmsg = dollarsign.concat(" ", discountprice);
                        //var discountmsg = (`${dollarsign} ${discountprice}`)
                        if (checkbox.checked == true && isNaN(doantionamount) && isNaN(parentamount) && magazineval == "") {
                            var afterdiscountprice = pricepuja - Seniordiscountprice;
                            document.getElementById("total_value").value = afterdiscountprice;
                            $('#seniordismsg').html(discountmsg);
                            $('#seniordismsg').show();
                        }
                        else if (checkbox.checked == true && (!isNaN(doantionamount)) && isNaN(parentamount) && magazineval == "") {
                            var afterdiscountprice = pricepuja - Seniordiscountprice;
                            var finaltotalamount = afterdiscountprice + doantionamount;
                            document.getElementById("total_value").value = finaltotalamount;
                            $('#seniordismsg').html(discountmsg);
                            $('#seniordismsg').show();
                        }
                        else if (checkbox.checked == true && isNaN(doantionamount) && (!isNaN(parentamount)) && magazineval == "") {
                            //var afterdiscountprice = pricepuja - 40;
                            var afterdiscountprice = pricepuja - Seniordiscountprice;
                            var amountallcalculation = afterdiscountprice + parseInt(parentamount);
                            document.getElementById("total_value").value = amountallcalculation;
                            $('#seniordismsg').html(discountmsg);
                            $('#seniordismsg').show();
                        }
                        else if (checkbox.checked == true && isNaN(doantionamount) && (!isNaN(parentamount)) && magazineval != "") {
                            var afterdiscountprice = pricepuja - Seniordiscountprice;
                            var amountallcalculation = afterdiscountprice + parseInt(parentamount);
                            var totalmagazineprice = parseInt(magazineprice) * magazineval;
                            document.getElementById("total_value").value = amountallcalculation + totalmagazineprice;
                            $('#seniordismsg').html(discountmsg);
                            $('#seniordismsg').show();
                        }
                        else if (checkbox.checked == true && isNaN(doantionamount) && isNaN(parentamount) && magazineval != "") {
                            //var afterdiscountprice = pricepuja - 40;
                            var afterdiscountprice = pricepuja - Seniordiscountprice;
                            var totalmagazineprice = parseInt(magazineprice) * magazineval;
                            document.getElementById("magazinefinalamount").value = totalmagazineprice;
                            document.getElementById("total_value").value = afterdiscountprice + totalmagazineprice;
                            $('#seniordismsg').html(discountmsg);
                            $('#seniordismsg').show();
                        }

                        else if (checkbox.checked == true && (!isNaN(doantionamount)) && (!isNaN(parentamount)) && magazineval != "") {
                            //var afterdiscountprice = pricepuja - 40;
                            var afterdiscountprice = pricepuja - Seniordiscountprice;
                            var finaltotalamount = afterdiscountprice + doantionamount + parseInt(parentamount);
                            var totalmagazineprice = parseInt(magazineprice) * magazineval;
                            document.getElementById("magazinefinalamount").value = totalmagazineprice;
                            document.getElementById("total_value").value = finaltotalamount + totalmagazineprice;
                            $('#seniordismsg').html(discountmsg);
                            $('#seniordismsg').show();
                        }
                        else if (checkbox.checked == true && (!isNaN(doantionamount)) && isNaN(parentamount) && magazineval != "") {
                            //var afterdiscountprice = pricepuja - 40;
                            var afterdiscountprice = pricepuja - Seniordiscountprice;
                            var finaltotalamount = afterdiscountprice + doantionamount;
                            var totalmagazineprice = parseInt(magazineprice) * magazineval;
                            document.getElementById("magazinefinalamount").value = totalmagazineprice;
                            document.getElementById("total_value").value = finaltotalamount + totalmagazineprice;
                            $('#seniordismsg').html(discountmsg);
                            $('#seniordismsg').show();
                        }
                        else if (checkbox.checked == true && (!isNaN(doantionamount)) && (!isNaN(parentamount)) && magazineval == "") {
                            var afterdiscountprice = pricepuja - Seniordiscountprice;
                            var amountwithparentfee = parseInt(afterdiscountprice) + parseInt(doantionamount) + parseInt(parentamount);
                            document.getElementById("total_value").value = amountwithparentfee;
                            $('#seniordismsg').html(discountmsg);
                            $('#seniordismsg').show();
                        }
                        else if (checkbox.checked != true && (!isNaN(doantionamount)) && (!isNaN(parentamount)) && magazineval != "") {
                            var finaltotalamount = pricepuja + doantionamount + parseInt(parentamount);
                            var totalmagazineprice = parseInt(magazineprice) * magazineval;
                            document.getElementById("magazinefinalamount").value = totalmagazineprice;
                            document.getElementById("total_value").value = finaltotalamount + totalmagazineprice;
                            $('#seniordismsg').hide();
                        }
                        else if (checkbox.checked != true && isNaN(doantionamount) && (!isNaN(parentamount)) && magazineval == "") {
                            var finaltotalamount = pricepuja + parseInt(parentamount);
                            document.getElementById("total_value").value = finaltotalamount;
                            $('#seniordismsg').hide();
                        }
                        else if (checkbox.checked != true && (!isNaN(doantionamount)) && isNaN(parentamount)) {
                            var finaltotalamount = pricepuja + doantionamount;
                            document.getElementById("total_value").value = finaltotalamount;
                            $('#seniordismsg').hide();
                        }
                        else if (checkbox.checked != true && isNaN(doantionamount) && isNaN(parentamount) && magazineval != "") {
                            var finaltotalamount = pricepuja;
                            var totalmagazineprice = parseInt(magazineprice) * magazineval;
                            document.getElementById("magazinefinalamount").value = totalmagazineprice;
                            document.getElementById("total_value").value = finaltotalamount + totalmagazineprice;
                            $('#seniordismsg').hide();
                        }
                        else {
                            document.getElementById("total_value").value = pujaprice;
                            $('#seniordismsg').hide();
                        }
                    }
                    scheduleAdultChildRegistrationAfterBaseTotal();

                }
            });
        }

        else {
            if (checkbox.checked != true && (!isNaN(doantionamount)) && (!isNaN(parentamount)) && magazineval != "") {
                var finaltotalamount = pricepuja + doantionamount + parseInt(parentamount);
                var totalmagazineprice = parseInt(magazineprice) * magazineval;
                document.getElementById("magazinefinalamount").value = totalmagazineprice;
                document.getElementById("total_value").value = finaltotalamount + totalmagazineprice;
                $('#seniordismsg').hide();
            }
            else if (checkbox.checked != true && isNaN(doantionamount) && (!isNaN(parentamount)) && magazineval == "") {
                var finaltotalamount = pricepuja + parseInt(parentamount);
                document.getElementById("total_value").value = finaltotalamount;
                $('#seniordismsg').hide();
            }
            else if (checkbox.checked != true && (!isNaN(doantionamount)) && isNaN(parentamount) && magazineval == "") {
                var finaltotalamount = pricepuja + doantionamount;
                document.getElementById("total_value").value = finaltotalamount;
                $('#seniordismsg').hide();
            }
            else if (checkbox.checked != true && isNaN(doantionamount) && isNaN(parentamount) && magazineval != "") {
                var finaltotalamount = pricepuja;
                var totalmagazineprice = parseInt(magazineprice) * magazineval;
                document.getElementById("magazinefinalamount").value = totalmagazineprice;
                document.getElementById("total_value").value = finaltotalamount + totalmagazineprice;
                $('#seniordismsg').hide();
            }
            else if (checkbox.checked != true && isNaN(doantionamount) && (!isNaN(parentamount)) && magazineval != "") {
                var totalmagazineprice = parseInt(magazineprice) * magazineval;
                var finaltotalamount = pricepuja + parseInt(parentamount);
                document.getElementById("total_value").value = finaltotalamount + totalmagazineprice;
                $('#seniordismsg').hide();
            }
            else if (checkbox.checked != true && (!isNaN(doantionamount)) && isNaN(parentamount) && magazineval != "") {
                var finaltotalamount = pricepuja + doantionamount;
                var totalmagazineprice = parseInt(magazineprice) * magazineval;
                document.getElementById("magazinefinalamount").value = totalmagazineprice;
                document.getElementById("total_value").value = finaltotalamount + totalmagazineprice;
                $('#seniordismsg').hide();
            }
            else if (checkbox.checked != true && (!isNaN(doantionamount)) && (!isNaN(parentamount)) && magazineval == "") {
                var amountwithparentfee = parseInt(pujaprice) + parseInt(doantionamount) + parseInt(parentamount);
                document.getElementById("total_value").value = amountwithparentfee;
            }
            else {
                document.getElementById("total_value").value = pujaprice;
                $('#seniordismsg').hide();
            }
            scheduleAdultChildRegistrationAfterBaseTotal();
        }
    }

    function swapspouseregistration() {
        //
        var checkbox = document.getElementById('swap');
        var memberfirstname = $("#memfnamefam").val();
        var memberlastname = $("#memlnamefam").val();
        var spousefname = $("#memspfnamefam").val();
        var spouselname = $("#memsplnamefam").val();

        if (checkbox.checked == true) {
            //$("#spousenamediv").show();

            $("#memfnamefam").val(spousefname);
            if (spouselname != "") {
                $("#memlnamefam").val(spouselname);
            }
            else {
                $("#memlnamefam").val("");
            }
            $("#memspfnamefam").val(memberfirstname);
            if (memberlastname != "") {
                $("#memsplnamefam").val(memberlastname);
            }
            else {
                $("#memsplnamefam").val("");
            }
        }
        else {
            //$("#spousenamediv").hide();
            $("#memfnamefam").val(spousefname);
            if (spouselname != "") {
                $("#memlnamefam").val(spouselname);
            }
            else {
                $("#memlnamefam").val("");
            }
            $("#memspfnamefam").val(memberfirstname);
            if (memberlastname != "") {
                $("#memsplnamefam").val(memberlastname);
            }
            else {
                $("#memsplnamefam").val("");
            }
        }
    }

    $("#magazinedata").change(function () {
        //
        var magazineval = $("#magazinedata").val();
        var magazineprice = "15";
        const price = parseFloat($("#totaldonation").val());
        var txtselectpujaname = $("#ddlStatus option:selected").text();
        text = txtselectpujaname.split(" ");
        var pujaprice = text[1].replace('$', "");
        var checkbox = document.getElementById('senior');
        var parentone = document.getElementById('myCheck');
        var parenttwo = document.getElementById('myCheck2');
        if (magazineval > 2) {
            alert("Maximum 2 Magazine");
            $("#magazinedata").val("");
            myFunction();
            return;
        }

        if (isNaN(pujaprice)) {
            alert("Please select Puja price first");
            $("#magazinedata").val("");
            return;

        }
        if (!isNaN(price) && checkbox.checked != true && parentone.checked != true && parenttwo.checked != true) {
            newtotalprice = parseInt(pujaprice) + parseInt(price);
            totalmagazineprice = parseInt(magazineprice) * magazineval;
            document.getElementById("magazinefinalamount").value = totalmagazineprice;
            document.getElementById("total_value").value = newtotalprice + totalmagazineprice;
        }
        else if (isNaN(price) && checkbox.checked != true && parentone.checked != true && parenttwo.checked != true) {
            totalmagazineprice = parseInt(magazineprice) * magazineval;
            document.getElementById("magazinefinalamount").value = totalmagazineprice;
            document.getElementById("total_value").value = parseInt(pujaprice) + totalmagazineprice;
        }
        else if (!isNaN(price) && checkbox.checked == true && parentone.checked != true && parenttwo.checked != true) {
            calculateseniordiscount();
        }
        else if ((isNaN(price) || price == "") && checkbox.checked == true && parentone.checked != true && parenttwo.checked != true) {
            calculateseniordiscount();
        }
        else if (!isNaN(price) && checkbox.checked == true && parentone.checked == true && parenttwo.checked != true) {
            myFunction();
        }
        else if (!isNaN(price) && checkbox.checked == true && parentone.checked != true && parenttwo.checked == true) {
            myFunction();
        }
        else if ((isNaN(price) || price == "") && checkbox.checked == true && parentone.checked == true && parenttwo.checked != true) {
            myFunction();
        }
        else if ((isNaN(price) || price == "") && checkbox.checked != true && parentone.checked == true && parenttwo.checked != true) {
            myFunction();
        }
        else if ((isNaN(price) || price == "") && checkbox.checked != true && parentone.checked != true && parenttwo.checked == true) {
            myFunction();
        }
        else if ((isNaN(price) || price == "") && checkbox.checked == true && parentone.checked != true && parenttwo.checked == true) {
            myFunction();
        }
        else if ((!isNaN(price)) && checkbox.checked != true && parentone.checked != true && parenttwo.checked == true) {
            myFunction();
        }
        else if ((!isNaN(price)) && checkbox.checked != true && parentone.checked == true && parenttwo.checked != true) {
            myFunction();
        }
        else {
            newtotalprice = parseInt(pujaprice);
            totalmagazineprice = parseInt(magazineprice) * magazineval;
            document.getElementById("total_value").value = newtotalprice + totalmagazineprice;

        }

    });

    var documentUploadValid = true;

    function setDocumentUploadError(message) {
        documentUploadValid = false;
        $("#documentUploadError").text("Upload failed: " + message).show();
        $("#documentPreview").hide();
        $("#documentPreviewImage").hide().attr("src", "");
        $("#documentPreviewPdf").hide().text("");
        $("#file").val("");
    }

    function clearDocumentUploadError() {
        documentUploadValid = true;
        $("#documentUploadError").hide().text("");
    }

    function validateDocumentUpload(input) {
        clearDocumentUploadError();
        $("#documentPreview").hide();
        $("#documentPreviewImage").hide().attr("src", "");
        $("#documentPreviewPdf").hide().text("");

        if (!input.files || !input.files[0]) {
            return true;
        }

        var file = input.files[0];
        var fileName = file.name.toLowerCase();
        var allowed = /\.(jpg|jpeg|png|pdf)$/i.test(fileName);
        var maxSize = 8 * 1024 * 1024;

        if (!allowed) {
            setDocumentUploadError("only jpg, jpeg, png, or pdf files are allowed.");
            return false;
        }

        if (file.size > maxSize) {
            setDocumentUploadError("file size must be 8 MB or less.");
            return false;
        }

        if (fileName.endsWith(".pdf")) {
            $("#documentPreview").show();
            $("#documentPreviewPdf").text("Selected PDF: " + file.name).show();
            return true;
        }

        documentUploadValid = false;
        var reader = new FileReader();
        reader.onload = function (event) {
            var img = new Image();
            img.onload = function () {
                if (img.width < 800 || img.height < 500) {
                    setDocumentUploadError("document image is too small or not clear enough. Please upload a clearer document.");
                    return;
                }

                var aspectRatio = img.width / Math.max(1, img.height);
                if (aspectRatio < 0.45 || aspectRatio > 3.2) {
                    setDocumentUploadError("document image is not framed clearly. Please upload the full document.");
                    return;
                }

                var canvas = document.createElement("canvas");
                var sampleWidth = Math.min(120, img.width);
                var sampleHeight = Math.max(1, Math.round(sampleWidth * img.height / img.width));
                canvas.width = sampleWidth;
                canvas.height = sampleHeight;
                var ctx = canvas.getContext("2d");
                if (ctx) {
                    ctx.drawImage(img, 0, 0, sampleWidth, sampleHeight);
                    var pixels = ctx.getImageData(0, 0, sampleWidth, sampleHeight).data;
                    var count = 0;
                    var sum = 0;
                    var sumSquares = 0;

                    for (var i = 0; i < pixels.length; i += 16) {
                        var gray = (0.299 * pixels[i]) + (0.587 * pixels[i + 1]) + (0.114 * pixels[i + 2]);
                        sum += gray;
                        sumSquares += gray * gray;
                        count++;
                    }

                    var average = sum / Math.max(1, count);
                    var variance = Math.max(0, (sumSquares / Math.max(1, count)) - (average * average));
                    var contrast = Math.sqrt(variance);

                    if (average < 45) {
                        setDocumentUploadError("document image is too dark. Please upload a clearer document.");
                        return;
                    }

                    if (average > 235) {
                        setDocumentUploadError("document image is too light or washed out. Please upload a clearer document.");
                        return;
                    }

                    if (contrast < 18) {
                        setDocumentUploadError("document image has low contrast and may not be legible. Please upload a clearer document.");
                        return;
                    }
                }

                documentUploadValid = true;
                $("#documentPreview").show();
                $("#documentPreviewImage").attr("src", event.target.result).show();
            };
            img.onerror = function () {
                setDocumentUploadError("document image could not be read.");
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);

        return true;
    }

    const phoneInputField = document.querySelector("#memphonefam");
    if (phoneInputField && window.intlTelInput) {
        window.intlTelInput(phoneInputField, {
            preferredCountries: ["us", "co", "in", "de"],
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    }

    const phoneInputField2 = document.querySelector("#memphone2fam");
    if (phoneInputField2 && window.intlTelInput) {
        window.intlTelInput(phoneInputField2, {
            preferredCountries: ["us", "co", "in", "de"],
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    }

    $(document).ready(function () {
        applyAddressUpdateState();
        var lastClickedSubmitter = null;
        $('#pujaregistration-frm-id').on('click', 'button[type="submit"], input[type="submit"]', function () {
            lastClickedSubmitter = this;
        });
        $('form[id="pujaregistration-frm-id"]').validate({
            submitHandler: function (form) {
                if ($("#alredayRegisterDiv").is(":visible")) {
                    return false;
                }
                if ($("#documentuploaddiv").is(":visible") && !documentUploadValid) {
                    return false;
                }
                if (!validateExtraAdultChildRows(true)) {
                    return false;
                }
                if (lastClickedSubmitter && lastClickedSubmitter.name) {
                    $(form).find('input[data-submit-proxy="1"]').remove();
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', lastClickedSubmitter.name)
                        .attr('value', lastClickedSubmitter.value || '1')
                        .attr('data-submit-proxy', '1')
                        .appendTo(form);
                }
                form.submit();
            }
        });
       //
       var currentDateCompare = <?php echo (json_encode($currentToday)); ?>;
       var lastregistrationdate = <?php echo (json_encode($registrationDate)); ?>;
         currentDateCompare = new Date(currentDateCompare);
        const earlyRegistrationdate = new Date(lastregistrationdate);
        var h3Element = document.getElementById("lastDateRegistration");
        if (currentDateCompare > earlyRegistrationdate) {
            $("#lastDateRegistration").hide();
        }
        else {
            $("#lastDateRegistration").show();
            h3Element.innerHTML += " " + lastregistrationdate;
        }
 
    });


    //Method for append puja option for parent registration 
    function showParentPujaRegistrationOption() {
        var pujaOption = $('<option value="All 3 Pujas">All 3 Pujas (For Parent Registration)</option>');
        var pujaOption1 = $('<option value="Durga Puja">Durga Puja (For Parent Registration)</option>');
        var pujaOption2 = $('<option value="Kali Puja">Kali Puja (For Parent Registration)</option>');
        var pujaOption3 = $('<option value="Saraswati Puja">Saraswati Puja (For Parent Registration)</option>');
        const selectedPrimaryPuja = $("#pul").val();
        $("#parentPuja").empty();

        switch (selectedPrimaryPuja) {
            case "All 3 Pujas":
                $("#parentPuja").append(pujaOption);
                $("#parentPuja").append(pujaOption1);
                break;
            case "Durga Puja":
                $("#parentPuja").append(pujaOption1);
                break;
            case "Kali Puja":
                $("#parentPuja").append(pujaOption2);
                break;
            case "Saraswati Puja":
                $("#parentPuja").append(pujaOption3);
                break;
        }
    }

    function showGreenFieldParkingPopup() {
        document.getElementById("greenFieldParkingModal").style.display = "block";
        document.getElementById("greenFieldParkingDecision").value = "";
    }

    function handleGreenFieldParkingChoice(choice) {
        document.getElementById("greenFieldParkingDecision").value = choice;
        document.getElementById("greenFieldParkingModal").style.display = "none";

        console.log("Green field parking choice:", choice);
        if (choice == "Cancelled") {
            document.getElementById("pujaregistration-frm-id").reset();
        }

        if (choice == "donation") {
            document.getElementById("totaldonation").focus();
        }
    }

</script>
