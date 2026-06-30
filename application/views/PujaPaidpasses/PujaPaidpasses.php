<head>
    <title>Paid Passes for Puja</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"  crossorigin="anonymous"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>  -->


</head>
<style>
    .rounded-lg {
        border-radius: 1rem;
    }

    .note-text {
        background-color: rgba(255, 255, 255, .9);
        box-shadow: rgba(239, 68, 68, .3) 0px 2px 4px 0px, rgba(239, 68, 68, .5) 0px 2px 16px 0px;
    }

    .puja-wrapper {
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
    }

    .col-md-4.totalamount {
        padding-top: 10px;
    }

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

    .widget-content p {
        font-size: 20px;
    }

    .widget-content p span {
        color: #ef260f;
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
        font-size: 18px;
        line-height: 1.9em;
        margin-bottom: 15px;
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

    #gocartbutton {
        padding: 10px;
        font-size: 22px;
        border-radius: 10px;
        width: 100%;
        background-color: #000;
        color: #fff;
        margin-top: 30px;
        font-weight: 600;
    }

    #datasubmit {
        padding: 10px;
        font-size: 22px;
        border-radius: 10px;
        width: 100%;
        background-color: #000;
        color: #fff;
        margin-top: 30px;
        font-weight: 600;
    }

    /* payment button css  */
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
            width: 405px;
        }

        input#memphone2fam {
            width: 405px;
        }
    }
</style>
<link rel="shortcut icon" href="<?php echo INSTALL_URL; ?>favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-grid.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-grid.rtl.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-reboot.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-reboot.rtl.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-utilities.min.css" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap-utilities.rtl.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.rtl.min.css" />

<section class="page-title" style="background-image:url(<?php echo INSTALL_URL; ?>12.jpg);">
    <div class="auto-container">
        <div class="row clearfix">
            <!--Title -->
            <!--<div class="title-column col-lg-6 col-md-12 col-sm-12">-->
            <!--    <img style="float:left;padding:20px" src="../1.svg" width="35%">-->
            <!--    <img style="border-radius: 96px;float: left;padding: 0px;" src="../puja_logo.png" width="37%">-->
            <!--</div>-->
             <?php
            if (!defined("ROOT_PATH")) {
                define("ROOT_PATH", dirname(__FILE__) . '/');
            }
            ?>
            <?php include_once ROOT_PATH . 'application/templates/title_images.php'; ?>
            <!--Bread Crumb -->
            <div class="breadcrumb-column col-lg-6 col-md-12 col-sm-12">
                <h1>Houston Durga Bari Society</h1>
                <h3>HDBS <?php
                $currentYear = date('Y');
                $nextYear = date('Y') + 1;
                date_default_timezone_set("America/Chicago");
                if (date("m-d") < "04-01") {
                    $currentYear = $currentYear - 1; 
                    $nextYear = date("Y");
                }
                echo "" . $currentYear . " - " . $nextYear . " Puja Online System ";
                ?></h3>
                <h3>Payment for Puja Passes</h3>
                <!--<h4><span>Contact : </span><a href="mailto:registration@durgabari.org"> registration@durgabari.org</a></h4>-->
                <ul class="bread-crumb clearfix">
                    <li><a style="text-decoration:none;color:#fff;"
                            href="<?php echo INSTALL_URL; ?>Associatepayments/Associatepayments">Home</a>
                    </li>
                    <li class="active">Passes</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="container passes" style="position: relative;padding: 40px 0px 60px;">
    <?php
    $editor = $this->controller->isEditor();
    $mainadminrole = $this->controller->isAdmin();
    $adminrole = null;
    if ($editor == "true") {
        $adminrole = $this->controller->isEditor();
    }
    if ($mainadminrole == "true") {
        $adminrole = $this->controller->isAdmin();
    }
    ?>
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div style="border-left: 3px solid #ef260f;border-right: 3px solid #ef260f;border-bottom: 3px solid #ef260f;padding:10px;"
                id="showRegistration" class="myChoice">
                <div class="clear"></div>

                <form id="pujapasses-frm-id" method="POST" action="" enctype="multipart/form-data">
                    <div id="otp-admin-bypass" style="display:none;"><?php echo ($this->controller->isAdmin() || $this->controller->isEditor()) ? '1' : '0'; ?></div>
                    <div id="otp-session-verified" style="display:none;"><?php
                        $otpVerifiedMember = $_SESSION['otp_verified_member'] ?? '';
                        echo htmlspecialchars(is_array($otpVerifiedMember) ? ($otpVerifiedMember['member_id'] ?? '') : $otpVerifiedMember, ENT_QUOTES, 'UTF-8');
                    ?></div>
                    <div class="row">

                        <br>

                        <div class="col-md-6">
                            <select class="choice" id="pul" name="puja_type" required>
                                <option value="">Puja Day & Time</option>
                                <?php
                                $uniquePujaNames = [];
                                foreach (($tpl['pujaname'] ?? []) as $key => $value) {
                                    if (!in_array($value['pujaname'], $uniquePujaNames)) {
                                        $uniquePujaNames[] = $value['pujaname'];
                                        ?>
                                        <option value="<?php echo $value['pujaname']; ?>"><?php echo $value['pujaname']; ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="text_placeholders">Puja Day & Time <span style="color:#ff0000;">*</span></div>
                        </div>

                        <div class="col-md-6">
                            <select class="choice" name="puja_category" id="pul2" required>
                                <option value="" selected>Returning or New User</option>
                                <option value="member">Returning User</option>
                                <option value="nonmember">New User</option>
                                <!-- <option value="outoftowner">Out of Towner</option>
                                <option value="student">Student</option> -->

                            </select>
                            <div class="text_placeholders">Returning or New User <span style="color:#ff0000;">*</span>
                            </div>
                        </div>
                        <div class="col-md-12" id="otp-verified-banner" style="display:none;margin:12px 0;"></div>

                    </div>
                    <br>
                    <div class="row" style="display:none;" id="membersearchdiv">
                        <div class="col-md-12">
                            <input class="MIDtext2" type="text" name="term" id="term"
                                placeholder="Search your records *"
                                onclick="document.getElementById('futureytd').value = ''" tabindex="2" required>
                            <input class="MIDtext2" type="text" style="display:none" name="termMember" id="termMember"
                                placeholder="Search your records">
                            <div class="text_placeholders">Search by : First Name, Last Name, Zip, MID <span
                                    style="color:#ff0000;">*</span></div>
                            <div id="div1"></div>
                        </div>
                    </div>
                    <br>

                    <div class="row" id="memberinformationdiv" style="display:none;">

                        <div class="col-md-4">
                            <input class="MIDtext2readonly" style="width:100%;" type="text" name="Member_id"
                                id="memidfam" placeholder="Member ID" required />
                            <div class="text_placeholders">Verified Member ID *</div>
                        </div>
                        <div class="col-md-4">
                            <input class="MIDtext2readonly" style="width:100%;" type="text" name="membercategory"
                                id="memcatfam" placeholder="MemberShip Category *" required />
                            <div class="text_placeholders">MemberShip Category *</div>
                        </div>

                        <div class="col-md-4">
                            <input class="MIDtext2readonly" style="width:100%;" type="text" name="Member_type"
                                id="memtypefam" placeholder="Membership Status" readonly />
                            <div class="text_placeholders">Membership Status</div>
                        </div>
                    </div>
                    <br>
                    <!--checkbox for student & outoftowner-->
                    <div class="row" id="studentootcheck" style="display:none;">
                        <div class="col-md-6 checkbox2" id="studentdivcheck">
                            <input style="visibility: visible;margin: 16px 0px 0px 4px;" class="checkbox"
                                type="checkbox" id="studentcheck" name="student" value="1" onclick="showimgdiv()">
                            <label for="student">Student</label>
                        </div>
                        <div class="col-md-6 checkbox3" id="oottdivcheck">
                            <input style="visibility: visible;margin: 16px 0px 0px 4px;" class="checkbox"
                                type="checkbox" id="ottcheck" name="outoftowner" value="1" onclick="showimgoot()">
                            <label for="oot">Out of Towner</label>
                        </div>
                    </div>

                    <!-- end -->
                    <br>

                    <!-- parent registration -->
                    <div class="row" id="parent_register" style="display:none;">
                        <div class="col-md-5">
                            <h2 style="padding-top: 18px; font-size:18px; color: #ef260f;">No. of Parents attending:</h2>
                        </div>
                        <div id="passParentOneWrap" class="col-md-3 checkbox">
                            <input style="visibility: visible;margin: 16px 0px 0px 4px;" class="checkbox"
                                type="checkbox" name="no_of_parent" value="1" id="passParentOne"
                                onclick="myFunction()">
                            <label for="passParentOne">One</label>
                        </div>
                        <div id="passParentTwoWrap" class="col-md-3 checkbox">
                            <input style="visibility: visible;margin: 16px 0px 0px 4px;" class="checkbox"
                                type="checkbox" name="no_of_parent" value="2" id="passParentTwo"
                                onclick="myFunction()">
                            <label for="passParentTwo">Two</label>
                        </div>
                    </div>

                    <!-- 25julyupdate -->
                    <!-- admin end document verify checkbox -->
                    <div class="row">
                        <div class="col-md-6 checkbox" id="admindoccheck" style="display:none;">
                            <label for="documentverified">Document Checked *</label>
                            <input style="visibility: visible;margin: -22px 0px 0px 4px;" class="checkbox"
                                type="checkbox" id="admincheckdocument" name="admindocumentcheck" value="1">

                        </div>
                    </div>

                    <div class="row" id="parent_register_details" style="display:none;">
                        <div class="col-md-6">
                            <input class="MIDtext2" type="text" name="parent1_fname" id="parent_register_fname"
                                placeholder="Parent First Name *">
                            <div class="text_placeholders">Parent First Name <span style="color:#ff0000;">*</span></div>
                        </div>
                        <div class="col-md-6">
                            <input class="MIDtext2" type="text" name="parent1_lname" id="parent_register_lname"
                                placeholder="Parent Last Name *">
                            <div class="text_placeholders">Parent Last Name <span style="color:#ff0000;">*</span></div>
                        </div>
                        <div class="col-md-12 checkbox">
                            <input style="visibility: visible;margin: 16px 0px 0px 4px;" class="checkbox"
                                type="checkbox" id="parent_register_veggie" name="parent1_veggie" value="1">
                            <label for="parent_register_veggie">Tick here, if Veggie</label>
                        </div>
                    </div>

                    <div class="row" id="parent_register_details2" style="display:none;">
                        <div class="col-md-6">
                            <input class="MIDtext2" type="text" name="parent2_fname" id="parent_register2_fname"
                                placeholder="Parent 2 First Name *">
                            <div class="text_placeholders">Parent 2 First Name <span style="color:#ff0000;">*</span></div>
                        </div>
                        <div class="col-md-6">
                            <input class="MIDtext2" type="text" name="parent2_lname" id="parent_register2_lname"
                                placeholder="Parent 2 Last Name *">
                            <div class="text_placeholders">Parent 2 Last Name <span style="color:#ff0000;">*</span></div>
                        </div>
                        <div class="col-md-12 checkbox">
                            <input style="visibility: visible;margin: 16px 0px 0px 4px;" class="checkbox"
                                type="checkbox" id="parent_register2_veggie" name="parent2_veggie" value="1">
                            <label for="parent_register2_veggie">Tick here, if Veggie</label>
                        </div>
                    </div>

                    <!-- end -->
                    <br>
                    <div class="row" style="display:none;" id="commonpricedrop">
                        <div class="col-md-12">
                            <select required name='member_newstatus' id='ddlStatus' class="choice">
                            </select>
                        </div>
                    </div>

                    <!--memberall3puja start-->

                    <div id="showMember" class="myDiv">
                        <div class="row">

                            <div class="col-md-4">
                                <input class="MIDtext2" style="width:100%;" type="text" name="First_name"
                                    id="memfnamefam" placeholder="First Name *" required />
                                <div class="text_placeholders">First Name <span style="color:#ff0000;">*</span></div>
                            </div>

                            <div class="col-md-4">
                                <input class="MIDtext2" style="width:100%;" type="text" name="Last_name"
                                    id="memlnamefam" placeholder="Last Name *" required />
                                <div class="text_placeholders">Last Name <span style="color:#ff0000;">*</span></div>
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
                            <div class="col-md-6 checkbox" style="display:none;">
                                <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                    type="checkbox" id="senior" name="senior" value="1"
                                    onchange="calculateseniordiscount(this)">
                                <label for="senior">Check here, if Senior</label>
                            </div>
                            <div class="col-md-6 checkbox" style="display:none;" id="swapregcheckboxdiv">
                                <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                    type="checkbox" id="swap" name="swap_spouse" value="swapregistration"
                                    onchange="swapspouseregistration(this)">
                                <label for="swap">Check here to Swap Spouse name for Puja Pass</label>
                            </div>
                        </div>
                        <div id="dvFamily" style="display: none">

                            <!-- <input type="hidden" name="member_puja_family_amount" value="400"> -->

                            <div class="row" id="childinputdiv" style="display:none;">
                                <div class="col-md-12">
                                    <select class="choice2" name="member_optional_child" id="ddlOptionalchild">
                                        <option value="">No. of Child(ren)</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <div class="text_placeholders">No. of Child(ren) YOB 2001 or later</div>
                                </div>
                            </div>

                            <div id="dvOptionalchild1" style="display:none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childonefname"
                                            id="memchildfnamefam" readonly placeholder="Child 1 First Name" />
                                        <div class="text_placeholders">Child 1 First Name <span
                                                style="color:#ff0000;">*</span></div>
                                    </div>

                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childonelname"
                                            id="memchildlnamefam" readonly placeholder="Child 1 Last Name" />
                                        <div class="text_placeholders">Child 1 Last Name <span
                                                style="color:#ff0000;">*</span></div>
                                    </div>


                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="Age1"
                                            id="memchildagefam" readonly placeholder="Child 1 Birth Year" />
                                        <div class="text_placeholders">Child 1 Birth Year <span
                                                style="color:#ff0000;">*</span></div>
                                    </div>
                                </div>
                            </div>


                            <div id="dvOptionalchild2" style="display:none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childtwofname"
                                            id="memchildfnamefam2" readonly placeholder="Child 2 First Name" />
                                        <div class="text_placeholders">Child 2 First Name <span
                                                style="color:#ff0000;">*</span></div>
                                    </div>

                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childtwolname"
                                            id="memchildlnamefam2" readonly placeholder="Child 2 Last Name" />
                                        <div class="text_placeholders">Child 2 Last Name <span
                                                style="color:#ff0000;">*</span></div>
                                    </div>


                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="Age2"
                                            id="memchildagefam2" readonly placeholder="Child 2 Birth Year" />
                                        <div class="text_placeholders">Child 2 Birth Year <span
                                                style="color:#ff0000;">*</span></div>
                                    </div>
                                </div>
                            </div>


                            <div id="dvOptionalchild3" style="display:none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childthreefname"
                                            id="memchildfnamefam22" readonly placeholder="Child 3 First Name" />
                                        <div class="text_placeholders">Child 3 First Name <span
                                                style="color:#ff0000;">*</span></div>
                                    </div>

                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="childthreelname"
                                            id="memchildlnamefam22" readonly placeholder="Child 3 Last Name" />
                                        <div class="text_placeholders">Child 3 Last Name <span
                                                style="color:#ff0000;">*</span></div>
                                    </div>


                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text" name="Age3"
                                            id="memchildagefam22" readonly placeholder="Child 3 Birth Year" />
                                        <div class="text_placeholders">Child 3 Birth Year <span
                                                style="color:#ff0000;">*</span></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="display:none;">
                                <div class="col-md-4">
                                    <h2 style="padding-top: 30px; font-size: 24px; color: #ef260f;">No. of Parents:</h2>
                                </div>
                                <div id="one" class="col-md-4 checkbox">
                                    <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                        type="checkbox" value="1" id="myCheck" onclick="myFunction()">
                                    <label for="one">One</label>
                                </div>
                                <div id="two" class="col-md-4 checkbox">
                                    <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                        type="checkbox" value="1" id="myCheck2" onclick="myFunction()">
                                    <label for="two">Two</label>
                                </div>
                            </div>

                            <div id="text" style="display:none">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text"
                                            id="memparentfnamefam" placeholder="Parent 1 First Name" />
                                        <div class="text_placeholders">Parent 1 First Name</div>
                                    </div>

                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text"
                                            id="memparentlnamefam" placeholder="Parent 1 Last Name" />
                                        <div class="text_placeholders">Parent 1 Last Name</div>
                                    </div>

                                    <div class="col-md-4 checkbox">
                                        <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                            type="checkbox" id="legacy_parent1_veggie" value="1">
                                        <label for="veggie">Tick here, if Veggie</label>
                                    </div>
                                </div>
                            </div>

                            <div id="text2" style="display:none">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text"
                                            id="memparent2fnamefam" placeholder="Parent 2 First Name" />
                                        <div class="text_placeholders">Parent 2 First Name</div>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="MIDtext2" style="width:100%;" type="text"
                                            id="memparent2lnamefam" placeholder="Parent 2 Last Name" />
                                        <div class="text_placeholders">Parent 2 Last Name</div>
                                    </div>
                                    <div class="col-md-4 checkbox">
                                        <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                            type="checkbox" id="legacy_parent2_veggie" value="1">
                                        <label for="veggie">Tick here, if Veggie</label>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <!-- hidden field -->
                        <div id="dvIndividual" style="display: none;">
                            <input type="hidden" name="magazineamount" value="15">
                            <input type="text" name="puja_amount" id="pujapriceval">
                            <input type="text" name="member_status" id="hiddenpujaname">
                            <input type="text" name="extraparentregistration" id="parentregprice">

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <input class="MIDtext2" required style="width:100%;" type="text" name="street"
                                    id="memstreetfam" placeholder="Street # *" />
                                <div class="text_placeholders">Street # <span style="color:#ff0000;">*</span></div>
                            </div>

                            <div class="col-md-6">
                                <input class="MIDtext2" required style="width:100%;" type="text" name="streetname"
                                    id="memstreetnamefam" placeholder="Street Name *" />
                                <div class="text_placeholders">Street Name <span style="color:#ff0000;">*</span></div>
                            </div>

                            <div class="col-md-3">
                                <input class="MIDtext2" style="width:100%;" type="text" name="unit" id="memunitfam"
                                    placeholder="Unit #" />
                                <div class="text_placeholders">Unit #</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <input class="MIDtext2" required style="width:100%;" type="text" name="city"
                                    id="memcityfam" placeholder="City *" />
                                <div class="text_placeholders">City <span style="color:#ff0000;">*</span></div>
                            </div>

                            <div class="col-md-4">
                                <input class="MIDtext2" required style="width:100%;" type="text" name="state"
                                    id="memstatefam" placeholder="State *" />
                                <div class="text_placeholders">State <span style="color:#ff0000;">*</span></div>
                            </div>

                            <div class="col-md-4">
                                <input class="MIDtext2" required style="width:100%;" type="text" name="zip"
                                    id="mamzipcodefam" placeholder="Zip Code *" />
                                <div class="text_placeholders">Zip Code <span style="color:#ff0000;">*</span></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 phone">
                                <input class="MIDtext2readonly" required type="text" name="phone" id="memphonefam"
                                    maxlength="10" placeholder="### ### ####" />
                                <div class="text_placeholders">Phone Number <span style="color:#ff0000;">*</span></div>
                            </div>
                            <div class="col-md-6 phone">
                                <input class="MIDtext2" required type="text" name="alternatenumber" id="memphone2fam"
                                    maxlength="10" placeholder="### ### ####" />
                                <div class="text_placeholders">Mobile Number *</div>
                            </div>
                            <div class="col-md-6">
                                <input class="MIDtext2" required style="width:100%;" type="text" name="email"
                                    id="mememailfam" placeholder="name@company.com"
                                    pattern="[^@\s]+@[^@\s]+\.[^@\s]+" />
                                <div class="text_placeholders">Email Id <span style="color:#ff0000;">*</span></div>
                            </div>
                            <div class="col-md-6">
                                <input class="MIDtext2" style="width:100%;" type="text" name="alternateemail"
                                    id="mememail2fam" placeholder="name@company.com"
                                    pattern="[^@\s]+@[^@\s]+\.[^@\s]+" />
                                <div class="text_placeholders">Alternate Email Id</div>
                            </div>
                        </div>



                        <div class="row" style="display:none;">

                            <div class="col-md-6">
                                <input class="number" id="totaldonation" style="width:100%;" type="number"
                                    name="donation" value="" min="25" placeholder="Donation ($)"
                                    onchange="amountvalid(this.id)" />
                                <div class="text_placeholders">Donation($)</div>
                            </div>
                            <div class="col-md-6">
                                <input class="MIDtext2readonly" style="width:100%;" id="ytd1" class="" type="text"
                                    placeholder="Annual Donation" value="" name="YTD" tabindex="13" readonly
                                    style="display:block;">
                                <div class="text_placeholders">Annual Donation($)</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6" style="display:none;">
                                <input type="hidden" name="member_additional_magazine_family_amount" value="10">
                                <input class="number" id="magazinedata" style="width:100%;" type="number" value="0"
                                    min="0" max="2" name="magazine" placeholder="No. of Magazine(s)"
                                    title="1 Free Copy Included, Specify Addl. copies" />
                                <div class="text_placeholders">No. of Magazine(s)</div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <!-- Parking conditions on Donation start ui onchange -->
                                <div class="row" style="display:none;" id="featureytddiv">
                                    <div class="col-md-12">
                                        <input name="newytdfeature" id="futureytd" class="number" type="text"
                                            placeholder="Your future YTD will be" value="" tabindex="16" readonly>
                                        <div class="text_placeholders">Future YTD</div>
                                        <div class="text_placeholders" id="ytdmess" style="display:none;"></div>

                                    </div>


                                </div>

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
                                                            <div class="popup_title"><b>Sponsorship Privileges</b></div>

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
                                                                            style="background-color:red;color:black;">
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
                                                                            style="background-color:white;">$2000+</td>
                                                                        <td class="td" rowspan="2">Main or Kala Bhavan
                                                                            (KB)Parking<br>
                                                                            (in order of date of Sponsorship)</td>


                                                                    </tr>
                                                                    <tr class="tr" id="platinumtr">
                                                                        <td class="td"
                                                                            style="background-color:blue;color:white;">
                                                                            Platinum</td>
                                                                        <td class="td" id="platinum">$1200 - $1999</td>
                                                                        <!-- <td class="td"></td> -->

                                                                    </tr>
                                                                    <tr class="tr" id="goldtr">
                                                                        <td class="td"
                                                                            style="background-color:yellow;color:black;">
                                                                            Gold</td>
                                                                        <td class="td" id="gold"
                                                                            style="background-color:white;">$800 - $1199
                                                                        </td>
                                                                        <td class="td">Green Field<br>Prioritized
                                                                            upgrade to KB Parking if space
                                                                            available.<br> Kb Parking for CT Gold
                                                                            Sponsors.</td>

                                                                    </tr>

                                                                    <tr class="tr" id="silvertr">
                                                                        <td class="td"
                                                                            style="background-color:#E6E6FA;color:black;">
                                                                            Silver</td>
                                                                        <td class="td" id="silver">$400 - $799</td>
                                                                        <td class="td"
                                                                            style="background-color: #f3f4f5;">Jain
                                                                            Temple <br>(Subject to
                                                                            availability;Specified days only)</td>
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
                                <div class="text_placeholders">Name of college or University <span
                                        style="color:#ff0000;">*</span></div>
                            </div>
                        </div>


                        <input type="hidden" name="create_passespayment_request" value="1" />
                        <div class="row">
                            <div class="col-md-6 totalamount">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="totalamount"
                                    id="total_value" required placeholder="Total Amount($) *" />
                                <div class="text_placeholders">Total Amount Request to Pay($) *</div>
                            </div>
                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                <tr style="display:none;">
                                    <td class="td" style="display:none;"> <input id="Zellecode"
                                            class="form-control input-sm" type="text" name="code" style="display:none;">
                                    </td>
                                </tr>
                                <table class="table">
                                    <tr class="tr">
                                        <td class="td" colspan="2">
                                            <select name="PaymentOption" style="width:100%;  height:50%;"
                                                onchange="paymentmethod(this.id)" id="payment_method"
                                                class="choice form-control input-sm  valid" required>
                                                <option value="">Please Select</option>
                                                <option value="check">Check</option>
                                                <option value="cash">Cash</option>
                                                <option value="directdeposit">Online Deposit</option>
                                                <option value="sumup">Sumup</option>
                                                <option value="stripe">Credit card</option>
                                                <!-- <option value="others">Zelle (Preferred)</option> -->
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
                                                <input data-rule-required='true' id="confirm_code"
                                                    class="form-control input-sm" type="text" name="confirm_code" size="25"
                                                    value="" title="<?php echo __('confirm_code'); ?>"
                                                    placeholder="<?php echo __('confirm_code'); ?>">
                                                <div class="control-group"></div>
                                                <div id="error_code"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <table class="table">
                                        <td id="error_code1"></td>
                                        <tr class="tr" id="MemberID1" style="display: none;" class="form-group">
                                            <label class="control-label" for="F_Name"
                                                style="color:rgba(237,237,237) !important;">Payment Details:</label>
                                            <!-- <td  class="td" colspan="2" class="auto-widget"> -->
                                            <td class="td"><button style="display: none;float:left!important;" type="button"
                                                    id="checkPaymentData">Get Zelle Payment Details</button></td>
                                            <!-- <input data-rule-required='true' id="MemberID" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>"> -->
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
                                <!-- for check -->

                                <table class="table table-bordered table-hover table-striped"
                                    style="display:none;margin-top: -42px;" id="checkdata">
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
                                                <input style="WIDTH: 100%;" type="number" id="checkamount"
                                                    name="checkAmount" class="form-control input-sm" value="">
                                            </td>
                                            <td class="td"><input style="WIDTH: 100%;" type="date" id="checkdate"
                                                    name="CheckDate" class="form-control input-sm" value=""></td>
                                            <td class="td"><select name="CheckDepositAccount" class="choice">
                                                    <option value="PujaAccount">Puja Account</option>
                                                    <option value="RegularAccount">Regular Account</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- For Cash  -->

                                <table class="table table-bordered table-hover table-striped"
                                    style="display:none;margin-top: -42px;" id="cashdata">
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
                                                <input type="number" id="cashamount" name="cashAmount"
                                                    class="form-control input-sm" value="">
                                            </td>
                                            <td class="td"><input type="date" id="cashdate" name="cashDate"
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
                                <table class="table table-bordered table-hover table-striped"
                                    style="display:none;margin-top: -42px;" id="directdeposite">
                                    <thead>
                                        <tr class="tr">
                                            <th>Financial Entity</th>
                                            <th>Transaction Code</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Deposit Account</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="tr">
                                            <td class="td"><input style="WIDTH: 100%;" type="text" id="bankname"
                                                    name="directbank" class="form-control input-sm" value=""></td>
                                            <td class="td"><input style="WIDTH: 100%;" type="text" id="ISFCCode"
                                                    name="transactioncode" class="form-control input-sm" value=""></td>

                                            <td class="td">
                                                <input style="WIDTH: 100%;" type="number" id="directamount"
                                                    name="directdepositeamount" class="form-control input-sm" value="">
                                            </td>
                                            <td class="td"><input style="WIDTH: 100%;" type="date" id="date"
                                                    name="transactiondate" class="form-control input-sm" value=""></td>
                                            <td class="td">
                                                <select name="DepositAccount" class="choice">
                                                    <option value="PujaAccount">Puja Account</option>
                                                    <option value="RegularAccount">Regular Account</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                                <!-- New -->
                                <!-- for sumup  -->
                                <table class="table table-bordered table-hover table-striped"
                                    style="display:none;margin-top: -42px;" id="Sumupdata">
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
                                            <td class="td"><input style="WIDTH: 100%;" type="text" id="sumdata"
                                                    name="sumupid" class="form-control input-sm" value=""></td>
                                            <td class="td">
                                                <input style="WIDTH: 100%;" type="number" id="sumupprice" name="sumupamount"
                                                    class="form-control input-sm" value="">
                                            </td>
                                            <td class="td"><input style="WIDTH: 100%;" type="date" id="date"
                                                    name="sumupdate" class="form-control input-sm" value=""></td>
                                            <td class="td">
                                                <select name="DepositAccount" class="choice">
                                                    <option value="PujaAccount">Puja Account</option>
                                                    <option value="RegularAccount">Regular Account</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php } ?>
                            <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                        </div>
                        <article class="note-text p-3 rounded-lg mt-5">
                            <p class="fs-2 fw-bold mb-0" style="font-family: monospace;">
                                HDBS strives to provide a safe and respectful
                                environment for all the attendees. By attending services and
                                events, you acknowledge that you do so at your own risk and agree that HDBS is not
                                responsible for any
                                personal injury, illness, or personal property damage. You agree not to hold HDBS
                                organizers
                                liable for any
                                dispute or limitation with the services or events.
                            </p>
                        </article>
                        <!-- document submit div  -->
                        <div class="row" id="documentuploaddiv" style="display:none;">
                            <div class="col-md-12">
                                <input class="MIDtext2" style="width:100%;" type="file" name="image" id="file"
                                    placeholder="Document Verification">
                                <div class="text_placeholders">Upload Document for Out of Towner Address or Student Age
                                    Verification(jpg,png,jpeg,pdf format) <span style="color:#ff0000;">*</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="reset" onClick="window.location.reload();"
                                    class="go_cart_btn">Reset</button>
                            </div>
                            <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                                <div class="col-md-6" id="addcartbuttondiv">
                                    <button type="submit" id="gocartbutton" class="btn btn-primary" name="get_cart"
                                        onclick="return confirm('Are you sure you want to Submit this Request? If you want to update anything then please press Cancel button to Update and Review the information OR press Ok to Submit this Request for your Puja Pass.')">Submit
                                        Request</button>
                                </div>
                            <?php } ?>
                            <div class="col-md-6" id="documentsubmitbuttondiv" style="display:none;">
                                <button type="submit" id="datasubmit" class="btn btn-primary" name="requesrregirtraton"
                                    onclick="return confirm('Are you sure you want to Submit this Request? If you want to update anything then please press Cancel button to Update and Review the information OR press Ok to Submit this Request for your Puja Pass.')">Submit
                                    Request</button>
                            </div>

                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                <div class="col-md-6">
                                    <button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save"
                                        name="Payment" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;Make
                                        Payment</button>

                                </div>
                            <?php } ?>
                        </div>
                        <div id="stripe_secret_key_id" style="display: none">
                            <?php echo $tpl['option_arr_values']['stripe_publish_key']; ?></div>

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
                        <a style="font-size: 24px; text-decoration: none;color:#000;"
                            href="<?php echo INSTALL_URL; ?>PujaPassesadmin/index">Go Back to Dashboard</a>
                        <br><br>
                    <?php } ?>

                    <div class="sidebar-title">
                        <h2><span style="color: #ef260f;">General</span> Guidelines</h2>
                    </div>
                    <div class="widget-content">
                        <div class="text"><strong>Step 1 : </strong>Express your interest to purchase Day/Evening Passes
                        </div>
                        <div class="text"><strong>Step 2 : </strong>Registration Team will validate your application and
                            send a confirmation</div>
                        <div class="text"><strong>Step 3 : </strong>Make the payment </div>
                        <div class="text"><strong>1. </strong>Passes will be issued in limited quantities and will
                            depend on overall registration level. Out of Towners and 22+ individual children of Puja
                            registrants will have higher priority and can submit requests for all the options offered.
                            Greater Houston residents can apply
                            for all options except for Friday and Saturday. </div>
                        <div class="text"><strong>2. </strong>Day Pass includes lunch and dinner. Evening Pass dinner
                            only. Both Day and Evening Passes include access to cultural programs </div>
                        <div class="text"><strong>3. </strong>For family registration, children allowed free subject to
                            Year of birth being 2003 or later.</div>
                        <div class="text"><strong>4. </strong>Parent passes can be added based on current YTD eligibility.</div>
                        <!-- <div class="text"><strong>5. </strong>Student rate applicable to FULL TIME students only. Part
                            time or Executive MBA students are not eligible.</div>
                        <div class="text"><strong>6. </strong>Student with family only if the spouse is not working
                        </div> -->
                        <div class="text"><strong>5. </strong>Out of Towners are required to submit valid
                            Address proof document online. Registration team will validate and
                            send a confirmation with an individualized payment link. You may blank off date of birth or
                            any other personal information</div>
                        <!-- <div class="text"><strong>8. </strong>Student IDs must have an expiry date or an issue date
                            within the last one year. If none available, submit a recent tuition fee payment receipt or
                            a score card.</div> -->
                        <div class="text"><strong>6. </strong>No onsite parking is available for Day/Evening Pass
                            Registrants.. Registrants can use the free shuttle bus service or Uber/Lyft</div>
                    </div>
                </div>

                <div class="sidebar-widget help-widget">
                    <div class="sidebar-title">
                        <h2><span style="color: #ef260f;">Need</span> Help?</h2>
                    </div>
                    <div class="widget-content">
                        <div class="text">If you have any questions, please contact us</div>
                <p style="padding-bottom:30px;"><span><i class="fa fa-envelope" aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;" href="mailto:registration@durgabari.org"> registration@durgabari.org</a></p>
              <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                style="color:#000;text-decoration:none;" href="tel:+18603825419"> <strong
                                    style="font-size:26px;">+1 860-382-5419</strong> <br><span
                                    style="font-size:20px;color:#000;">Sharmila</span></a></p>
                        <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                style="color:#000;text-decoration:none;" href="tel:+18323027420"> <strong
                                    style="font-size:26px;">+1 832-302-7420</strong> <br><span
                                    style="font-size:20px;color:#000;">Sandip</span></a></p>
                        <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                style="color:#000;text-decoration:none;" href="tel:+15407978261"> <strong
                                    style="font-size:26px;">+1 540-797-8261</strong> <br><span
                                    style="font-size:20px;color:#000;">Raj</span></a></p>
                    </div>
                </div>

            </aside>
        </div>


    </div>
</div>


<script>
    function fillPujaPassReturningUserFromOtp(memberId) {
        $('#otp-session-verified').text(memberId || '');
        $('#showMember').show();
        $('#commonpricedrop').show();
        $('#membersearchdiv').show();
        $('#memberinformationdiv').show();
        $('#termMember').val(memberId || '');
        $('#term').val('Verified Member ' + (memberId || '')).prop('readonly', true).attr('autocomplete', 'off');
        if (typeof MemberSelectdonation === 'function') {
            MemberSelectdonation();
        }
        $('#otp-verified-banner').show().html('<div style="background:#eafaf1;border:1px solid #b7e4c7;color:#1e8449;border-radius:5px;font-size:13px;font-weight:600;padding:8px 12px;">Returning user verified and details auto-filled.</div>');
    }

    function openPujaPassReturningUserOtp() {
        if ($.trim($('#otp-admin-bypass').text() || '') === '1') {
            return true;
        }
        if (typeof window.OtpMemberVerify === 'undefined') {
            alert('OTP verification is not available. Please refresh and try again.');
            return false;
        }
        window.OtpMemberVerify.open({
            onVerified: function (memberId) {
                fillPujaPassReturningUserFromOtp(memberId);
            }
        });
        window.onOtpModalCancelled = function () {
            $('#pul2').val('');
            $('#membersearchdiv').hide();
            $('#memberinformationdiv').hide();
        };
        return true;
    }

    $(document).on('keydown focus paste input', '#term', function (event) {
        if ($('#pul2').val() === 'member' && $.trim($('#otp-admin-bypass').text() || '') !== '1') {
            event.preventDefault();
            $(this).blur();
            return false;
        }
    });

    $(document).on('change', '#pul2', function () {
        if ($(this).val() === 'member' && $.trim($('#otp-admin-bypass').text() || '') !== '1') {
            setTimeout(function () {
                var verifiedMemberId = $.trim($('#otp-session-verified').text() || '');
                if (verifiedMemberId) {
                    fillPujaPassReturningUserFromOtp(verifiedMemberId);
                } else {
                    openPujaPassReturningUserOtp();
                }
            }, 0);
        }
    });

    ////Lookup.......................Start..............................////
    $(function () {
        //
        $("#term").autocomplete({
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

        var url2 = $("#container-abc-url-id").text();
        //
        var self = this;
        var data = $("#termMember").val();
        var term = $("#term").val();
        // for Ytd condition
        document.getElementById('dvOptionalchild3').style.display = 'none';
        document.getElementById('dvOptionalchild2').style.display = 'none';
        document.getElementById('dvOptionalchild1').style.display = 'none';
        document.getElementById("swap").checked = false;
        $("#spousenamediv").hide();
        $("#swapregcheckboxdiv").hide();
        $("#sponsor").val("");
        $("#sponsorevent").val("");
        var compareyear = '2001';
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

                        let ytd1 = "";
                        const ytd1Element = $(res).filter("input#ytd");
                        if (ytd1Element.length) {
                            ytd1 = ytd1Element[0].value;
                        }
                        document.getElementById("ytd1").value = ytd1;

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
                                $('#memphonefam').addClass('MIDtext2readonly');
                            }
                            else {
                                $('#mememailfam').prop('readonly', false);
                                $('#mememailfam').removeClass('MIDtext2readonly');
                                $('#mememailfam').addClass('MIDtext2');
                            }
                        }
                        document.getElementById("mememailfam").value = email;

                        let phoneNo2 = "";
                        const phoneNo2Element = $(res).filter("input#phone_work");
                        if (phoneNo2Element.length) {
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
                        new_phone2 = phoneNo2.replace(/[-)(]/g, "");
                        document.getElementById("memphone2fam").value = new_phone2;

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
                                $('#memphonefam').removeClass('MIDtext2readonly');
                                $('#memphonefam').addClass('MIDtext2');
                            }
                        }
                        new_phone = phoneNo.replace(/[-)(]/g, "");
                        document.getElementById("memphonefam").value = new_phone;


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
                            if (age333 > compareyear && age333 !== '0' && childfirstname != "") {
                                document.getElementById('dvOptionalchild3').style.display = 'block';
                            }
                        }
                        document.getElementById("memchildagefam22").value = age333;

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
                            if (age21 > compareyear && age21 !== '0' && membersecondfname != "") {
                                document.getElementById('dvOptionalchild2').style.display = 'block';
                            }
                        }
                        document.getElementById("memchildagefam2").value = age21;

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
                            if (age1 > compareyear && age1 !== '0' && memberthirdfname != "") {
                                document.getElementById('dvOptionalchild1').style.display = 'block';
                            }
                        }
                        document.getElementById("memchildagefam").value = age1;

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


                        let memberfname = "";
                        const memberfnameElement = $(res).filter("input#MemberName");
                        if (memberfnameElement.length) {
                            memberfname = memberfnameElement[0].value;
                        }
                        document.getElementById("memfnamefam").value = memberfname;
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

    // function myFunction2(element)
    // {
    //     document.getElementById("student_category_family").value = element.options[element.selectedIndex].value;
    //     document.getElementById("oot_category_family").value = element.options[element.selectedIndex].value;
    //      document.getElementById("student_category_individual").value = element.options[element.selectedIndex].value;
    //      document.getElementById("oot_category_individual").value = element.options[element.selectedIndex].value;
    // }

    function getPaidPassSelectedBasePrice() {
        const selectedPrice = parseFloat($("#ddlStatus").val());
        return isNaN(selectedPrice) ? 0 : selectedPrice;
    }

    function getPaidPassTotalWithoutParent() {
        const currentTotal = parseFloat($("#total_value").val());
        const previousParent = parseFloat($("#parentregprice").val());
        if (!isNaN(currentTotal)) {
            return currentTotal - (isNaN(previousParent) ? 0 : previousParent);
        }
        return getPaidPassSelectedBasePrice();
    }

    function resetPaidPassParentFields(clearSelection) {
        if (clearSelection) {
            $("#passParentOne").prop('checked', false);
            $("#passParentTwo").prop('checked', false);
        }
        $("#passParentOneWrap").show();
        $("#passParentTwoWrap").show();
        $("#parent_register_details").hide();
        $("#parent_register_details2").hide();
        $("#parent_register_fname").val("").prop('required', false);
        $("#parent_register_lname").val("").prop('required', false);
        $("#parent_register2_fname").val("").prop('required', false);
        $("#parent_register2_lname").val("").prop('required', false);
        $("#parent_register_veggie").prop('checked', false);
        $("#parent_register2_veggie").prop('checked', false);
        $("#parentregprice").val("");
    }

    function hasPaidPassParentDetails(parentCount) {
        const parentOneReady = $.trim($("#parent_register_fname").val()) !== "" && $.trim($("#parent_register_lname").val()) !== "";
        if (parentCount === 1) {
            return parentOneReady;
        }

        const parentTwoReady = $.trim($("#parent_register2_fname").val()) !== "" && $.trim($("#parent_register2_lname").val()) !== "";
        return parentOneReady && parentTwoReady;
    }

    function getPaidPassParentPriceFor() {
        const membertype = $("#pul2").val();
        const membercategory = $("#memcatfam").val();
        const studentcheckbox = document.getElementById('studentcheck');
        const ootcheckbox = document.getElementById('ottcheck');

        if (studentcheckbox && studentcheckbox.checked) {
            return 'student';
        }
        if (membertype == "member" && ootcheckbox && ootcheckbox.checked && (membercategory == 'GD' || membercategory == 'GC' || membercategory == "")) {
            return 'memberoot';
        }
        if (membertype == "nonmember" && ootcheckbox && ootcheckbox.checked && (membercategory == 'GD' || membercategory == 'GC' || membercategory == "")) {
            return 'nonmemberoot';
        }
        return membertype;
    }

    function getParentRegistrationPujaPrice() {
        debugger;
        const oneParent = $("#passParentOne").is(":checked");
        const twoParents = $("#passParentTwo").is(":checked");
        const parentCount = twoParents ? 2 : (oneParent ? 1 : 0);
        const baseTotal = getPaidPassTotalWithoutParent();
        console.log("[PujaPaidpasses Parent] start", {
            parentCount: parentCount,
            baseTotal: baseTotal,
            previousParentPrice: $("#parentregprice").val()
        });

        if (parentCount === 0) {
            $("#parentregprice").val("");
            $("#total_value").val(baseTotal || "");
            console.log("[PujaPaidpasses Parent] no parent selected", {
                finalTotal: $("#total_value").val()
            });
            return;
        }

        if (!hasPaidPassParentDetails(parentCount)) {
            $("#parentregprice").val("");
            $("#total_value").val(baseTotal || "");
            console.log("[PujaPaidpasses Parent] waiting for parent details", {
                parentCount: parentCount,
                finalTotal: $("#total_value").val()
            });
            return;
        }

        const parentYtdThreshold = Number(<?php echo json_encode((float) ($tpl['parent_ytd_threshold'] ?? 749)); ?>);
        const annualYtd = parseFloat($("#ytd1").val());
        const donationAmount = parseFloat($("#totaldonation").val());
        const futureYtd = (isNaN(annualYtd) ? 0 : annualYtd) + (isNaN(donationAmount) ? 0 : donationAmount);
        console.log("[PujaPaidpasses Parent] ytd check", {
            currentYtd: isNaN(annualYtd) ? 0 : annualYtd,
            donationAmount: isNaN(donationAmount) ? 0 : donationAmount,
            futureYtd: futureYtd,
            parentYtdThreshold: parentYtdThreshold
        });
        if (futureYtd >= parentYtdThreshold) {
            $("#parentregprice").val("");
            $("#total_value").val(baseTotal || "");
            console.log("[PujaPaidpasses Parent] parent price not added due to YTD threshold", {
                futureYtd: futureYtd,
                parentYtdThreshold: parentYtdThreshold,
                finalTotal: $("#total_value").val()
            });
            return;
        }

        const selectedText = $("#ddlStatus option:selected").text();
        const parts = selectedText.split(" ");
        const priceType = parts[0] || "";
        const pujaName = $("#pul").val();
        const priceFor = getPaidPassParentPriceFor();
        if (!pujaName || !priceFor || !priceType || !getPaidPassSelectedBasePrice()) {
            $("#parentregprice").val("");
            $("#total_value").val(baseTotal || "");
            console.log("[PujaPaidpasses Parent] missing price data", {
                pujaName: pujaName,
                priceFor: priceFor,
                priceType: priceType,
                selectedBasePrice: getPaidPassSelectedBasePrice(),
                finalTotal: $("#total_value").val()
            });
            return;
        }

        const url1 = $("#container-abc-url-id").text();
        $.ajax({
            type: "POST",
            data: {
                paymentfor: priceFor,
                pyjaname: pujaName,
                pricetype: priceType
            },
            url: url1 + "load.php?controller=PujaPaidpasses&action=getparentprice",
            success: function (res) {
                debugger;
                const parentPriceElement = $(res).filter("input#parentprice");
                const unitParentPrice = parentPriceElement.length ? parseFloat(parentPriceElement[0].value) : 0;
                const parentTotal = (isNaN(unitParentPrice) ? 0 : unitParentPrice) * parentCount;
                const finalTotal = (baseTotal || 0) + parentTotal;
                debugger;
                $("#parentregprice").val(parentTotal || "");
                $("#total_value").val(finalTotal);
                console.log("[PujaPaidpasses Parent] parent price added", {
                    pujaName: pujaName,
                    priceFor: priceFor,
                    priceType: priceType,
                    parentCount: parentCount,
                    unitParentPrice: isNaN(unitParentPrice) ? 0 : unitParentPrice,
                    parentPriceAdded: parentTotal,
                    currentYtd: isNaN(annualYtd) ? 0 : annualYtd,
                    donationAmount: isNaN(donationAmount) ? 0 : donationAmount,
                    futureYtd: futureYtd,
                    parentYtdThreshold: parentYtdThreshold,
                    baseTotal: baseTotal || 0,
                    finalTotal: finalTotal
                });
            }
        });
    }

    function myFunction() {
        const oneParent = document.getElementById("passParentOne");
        const twoParents = document.getElementById("passParentTwo");

        if (oneParent && oneParent.checked) {
            $("#passParentTwo").prop('checked', false);
            $("#passParentTwoWrap").hide();
            $("#passParentOneWrap").show();
            $("#parent_register_details").show();
            $("#parent_register_details2").hide();
            $("#parent_register_fname").prop('required', true);
            $("#parent_register_lname").prop('required', true);
            $("#parent_register2_fname").val("").prop('required', false);
            $("#parent_register2_lname").val("").prop('required', false);
            $("#parent_register2_veggie").prop('checked', false);
        } else if (twoParents && twoParents.checked) {
            $("#passParentOne").prop('checked', false);
            $("#passParentOneWrap").hide();
            $("#passParentTwoWrap").show();
            $("#parent_register_details").show();
            $("#parent_register_details2").show();
            $("#parent_register_fname").prop('required', true);
            $("#parent_register_lname").prop('required', true);
            $("#parent_register2_fname").prop('required', true);
            $("#parent_register2_lname").prop('required', true);
        } else {
            resetPaidPassParentFields(false);
        }
        getParentRegistrationPujaPrice();
    }

    $("#parent_register_fname, #parent_register_lname, #parent_register2_fname, #parent_register2_lname").on("input change", function () {
        getParentRegistrationPujaPrice();
    });

    $("#pul").change(function () {
        $("#pul2").val("");
        $("#ddlStatus").val("");
        $("#commonpricedrop").hide();
        $("#showMember").hide();
        $("#studentootcheck").hide();
        $("#parent_register").hide();
        $("#membersearchdiv").hide();
        $("#memberinformationdiv").hide();
        resetPaidPassParentFields(true);

        $("#admindoccheck").hide();
        document.getElementById("admincheckdocument").checked = false;
    });

    //  set price dropdown from table
    $("#pul2").change(function () {

        var loginrole = <?php echo (json_encode($adminrole)); ?>;
        var val = $(this).val();
        var pyjaname = $("#pul").val();
        //for hide & clean previous select div value
        $("#ddlOptional").val("");
        resetPaidPassParentFields(true);
        $("#ddlOptionalchild").val("");
        $("#dvOptionalchild1").hide();
        $("#dvOptionalchild2").hide();
        $("#dvOptionalchild3").hide();
        $("#dvOptional1").hide();
        $("#dvOptional2").hide();

        $('#memphonefam').prop('readonly', false);
        //$('#memphone2fam').prop('readonly', false);
        $('#mememailfam').prop('readonly', false);

        document.getElementById("studentcheck").checked = false;
        document.getElementById("ottcheck").checked = false;
        resetPaidPassParentFields(true);

        $("#admindoccheck").hide();
        document.getElementById("admincheckdocument").checked = false;

        document.getElementById("studentdivcheck").style.display = "block";
        document.getElementById("oottdivcheck").style.display = "block";
        if (loginrole != true) {
            document.getElementById("documentuploaddiv").style.display = "none";
            document.getElementById('documentsubmitbuttondiv').style.display = 'none';
        }

        document.getElementById('schoolnamediv').style.display = 'none';
        $("#file").prop('required', false);
        $("#total_value").val("");


        if (pyjaname == "") {
            alert('Please Select Puja Day & Time First');
            $("#pul2").val("");
            return;
        }
        $("#studentootcheck").show();
        $("#parent_register").show();
        var url1 = $("#container-abc-url-id").text();
        $.ajax({
            type: "POST",
            data: {
                paymentfor: val,
                pyjaname: pyjaname,

            },
            url: url1 + "load.php?controller=PujaPaidpasses&action=getpujapricedata",
            success: function (res) {
                $('#ddlStatus').empty();
                var pricefornewOption = $(res);
                var newOption = $('<option value="">Please select price type</option>');
                $('#ddlStatus').append(newOption);
                $('#ddlStatus').append(pricefornewOption);
                $('#ddlStatus').trigger("chosen:updated");

            }
        });

        if (val == "member") {
            $("#showMember").show();
            $("#commonpricedrop").show();
            $("#membersearchdiv").show();
            $("#dvFamily").hide();
            $("#memberinformationdiv").show();
            $('#memphonefam').addClass('MIDtext2readonly');
            //$('#memphone2fam').addClass('MIDtext2readonly');
            $('#mememailfam').addClass('MIDtext2readonly');
            $('#memfnamefam').addClass('MIDtext2readonly');
            $('#memlnamefam').addClass('MIDtext2readonly');

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
            $("#memphonefam").val("");
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
            $("#termMember").val(""); id = ""
            $("#memspfnamefam").val("");
            $("#memsplnamefam").val("");
            $("#memstreetfam").val("");
            $("#memspfnamefam").val("");
            $("#term").val("");

            //makefield readonly
            $('#memfnamefam').prop('readonly', true);
            $('#memlnamefam').prop('readonly', true);
            $('#memidfam').prop('readonly', true);
            $('#memcatfam').prop('readonly', true);
            $('#memtypefam').prop('readonly', true);
            $('#memphonefam').prop('readonly', true);
            //$('#memphone2fam').prop('readonly', true);
            $('#mememailfam').prop('readonly', true);
            $('#total_value').prop('readonly', true);

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
            $("#memfnamefam").val("");
            $("#memlnamefam").val("");
            $("#memspfnamefam").val("");
            $("#memsplnamefam").val("");
            $("#memstreetfam").val("");
            $("#mememailfam").val("");
            $("#total_value").val("");
            $('#memphonefam').removeClass('MIDtext2readonly');
            // $('#memphone2fam').removeClass('MIDtext2readonly');
            $('#mememailfam').removeClass('MIDtext2readonly');
            $('#memphonefam').addClass('MIDtext2');
            // $('#memphone2fam').addClass('MIDtext2');
            $('#mememailfam').addClass('MIDtext2');
            $('#memfnamefam').removeClass('MIDtext2readonly');
            $('#memlnamefam').removeClass('MIDtext2readonly');
            $('#memfnamefam').addClass('MIDtext2');
            $('#memlnamefam').addClass('MIDtext2');
            $("#ddlStatus_NM").val("");
            $("#memidfam").val("");
            $("#memcatfam").val("");
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

            //makefield readonly
            $('#memfnamefam').prop('readonly', false);
            $('#memlnamefam').prop('readonly', false);
            $('#memidfam').prop('readonly', true);
            $('#memcatfam').prop('readonly', true);
            $('#memtypefam').prop('readonly', true);
            $('#memphonefam').prop('readonly', false);
            // $('#memphone2fam').prop('readonly', false);
            $('#mememailfam').prop('readonly', false);
            $('#total_value').prop('readonly', true);

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
        else {
            $("#showMember").hide();
            $("#commonpricedrop").hide();
            $("#membersearchdiv").hide();
            $("#studentootcheck").hide();
            $("#parent_register").hide();
            $("#memberinformationdiv").hide();
            $('#memphonefam').addClass('MIDtext2readonly');
            //  $('#memphone2fam').addClass('MIDtext2readonly');
            $('#mememailfam').addClass('MIDtext2readonly');
            $('#memfnamefam').addClass('MIDtext2readonly');
            $('#memlnamefam').addClass('MIDtext2readonly');
        }
    });

    $("#ddlStatus").change(function () {
        //
        var membertype = $("#pul2").val();
        var statusddlval = $("#pul").val();
        var spousefirstname = $("#memspfnamefam").val();

        // clean seniordiscound hidden field  value

        document.getElementById("swap").checked = false;
        $("#spousenamediv").hide();
        $("#swapregcheckboxdiv").hide();
        $("#totaldonation").val("");
        $("#futureytd").val("");
        $("#total_value").val("");
        resetPaidPassParentFields(true);
        //for hide & clean previous select div value
        $("#ddlOptional").val("");
        $("#ddlOptionalchild").val("");
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
        var compareyear = '2001';
        //var statusddlval = $("#pul option:selected").text();

        var txtselectpujaname = $("#ddlStatus option:selected").text();
        text = txtselectpujaname.split(" ");
        var pujaname = text[0];
        var pujaprice = text[1].replace('$', "");
        document.getElementById("hiddenpujaname").value = pujaname;
        document.getElementById("pujapriceval").value = pujaprice;
        if (pujaname == "family" && membertype == "member") {
            $("#dvFamily").show();
            $("#spousenamediv").show();
            $("#childinputdiv").hide();
            $("#ddlOptionalchild").hide();
            $("#childinformationdiv").hide();
            $("#swapregcheckboxdiv").hide();
            $("#swapregcheckboxdiv").hide();
            document.getElementById("total_value").value = pujaprice;
            if (memberchild1 > compareyear && memberchild1 !== '0' && memberchild1 != "" && childonefirstname != "") {
                document.getElementById('dvOptionalchild1').style.display = 'block';
            }
            if (memberchild2 > compareyear && memberchild2 !== '0' && memberchild2 != "" && childtwofirstname != "") {
                document.getElementById('dvOptionalchild2').style.display = 'block';
            }
            if (memberchild3 > compareyear && memberchild3 !== '0' && memberchild3 != "" && childthreefirstname != "") {
                document.getElementById('dvOptionalchild3').style.display = 'block';
            }
        }
        else if (pujaname == "individual" && membertype == "member" && spousefirstname == "") {
            $("#dvFamily").hide();
            $("#spousenamediv").hide();
            $("#ddlOptionalchild").hide();
            $("#childinformationdiv").hide();
            $("#swapregcheckboxdiv").hide();
            document.getElementById("total_value").value = pujaprice;
        }
        else if (pujaname == "individual" && spousefirstname != "") {
            $("#swapregcheckboxdiv").show();
            $("#dvFamily").hide();
            $("#spousenamediv").hide();
            $("#ddlOptionalchild").hide();
            $("#childinformationdiv").hide();
            document.getElementById("total_value").value = pujaprice;
        }

        else if (pujaname == "family" && membertype == "nonmember") {
            $("#dvFamily").show();
            $("#spousenamediv").show();
            $("#childinputdiv").show();
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

            document.getElementById("total_value").value = pujaprice;
        }
        else if (pujaname == "individual" && membertype == "nonmember") {
            $("#dvFamily").hide();
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
        getParentRegistrationPujaPrice();
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
        if ($(this).val() == "1") {
            $("#dvOptionalchild1").show();
            $("#dvOptionalchild2").hide();
            $("#dvOptionalchild3").hide();
        }
        else if ($(this).val() == "2") {
            $("#dvOptionalchild1").show();
            $("#dvOptionalchild2").show();
            $("#dvOptionalchild3").hide();
        }
        else if ($(this).val() == "3") {
            $("#dvOptionalchild1").show();
            $("#dvOptionalchild2").show();
            $("#dvOptionalchild3").show();
        }

        else {
            $("#dvOptionalchild1").hide();
            $("#dvOptionalchild2").hide();
            $("#dvOptionalchild3").hide();
        }
    });


    // Donation parking based start work javascript

    function ListCreate() {

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
            else if (ytd >= 1200 && ytd < 1999) {
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
            else if (ytd >= 2000) {
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

        const price = parseInt($("#totaldonation").val());
        const ytd = parseInt($("#ytd1").val());
        //var regmember = $("#registrationmember").val();
        var membertype = $("#memcatfam").val();
        $("#total_value").val("");
        var txtselectpujaname = $("#ddlStatus option:selected").text();
        text = txtselectpujaname.split(" ");
        var pujaprice = text[1].replace('$', "");
        var checkbox = document.getElementById('senior');

        if (!isNaN(price) && checkbox.checked != true) {
            document.getElementById('featureytddiv').style.display = 'block';
            newtotalprice = parseInt(pujaprice) + parseInt(price);
            document.getElementById("total_value").value = newtotalprice;


        }
        else if (!isNaN(price) && checkbox.checked == true) {
            calculateseniordiscount();
        }
        else if ((isNaN(price) || price == "") && checkbox.checked == true) {
            calculateseniordiscount();
        }
        else {
            document.getElementById('featureytddiv').style.display = 'none';
            document.getElementById("total_value").value = pujaprice;

        }
        // if(regmember == 'member'){
        if (isNaN(ytd)) {
            document.getElementById("futureytd").value = price;
            if (price > 25 && price < 399) {
                $('#sponsorcheck').show();
                $('#ytdmess').hide();
            }

            else if (isNaN(ytd) && isNaN(price)) {
                document.getElementById("futureytd").value = '';
                $('#ytdmess').hide();
                $('#sponsorcheck').hide();
            }
            else if (price > 399 && price <= 799) {
                $('#ytdmess').html("On completion of your payment, You will be assigned Jain Temple Parking.");
                $('#ytdmess').show();
                //$('#sponsorcheck').show();
                $('#sponsorcheck').hide();
            }
            else if (price > 799 && price <= 1199 && membertype != "PM" && membertype != "FP") {
                $('#ytdmess').html("On completion of your payment, You will be assigned Gold Sponsor Parking.");
                $('#ytdmess').show();
                $('#sponsorcheck').hide();
            }
            else if (price > 799 && price <= 1199 && (membertype == "PM" || membertype == "FP")) {
                $('#ytdmess').html("On completion of your payment, You will be assigned  Kala Bhavan Parking.");
                $('#ytdmess').show();
                $('#sponsorcheck').hide();
            }
            else if (price > 1199 && price <= 1999) {
                $('#ytdmess').html("On completion of your payment, You will be assigned Main or Kala Bhavan(KB) Parking.");
                $('#ytdmess').show();
                $('#sponsorcheck').hide();
            }
            else if (price > 1999 && price <= 4599) {
                $('#ytdmess').html("On completion of your payment, You will be assigned Main or Kala Bhavan(KB) Parking.");
                $('#ytdmess').show();
                $('#sponsorcheck').hide();
            }
            else if (price > 4599) {
                $('#ytdmess').html("On completion of your payment, You will be assigned Main Parking.");
                $('#ytdmess').show();
                $('#sponsorcheck').hide();
            }

            else {
                $('#sponsorcheck').hide();
                $('#ytdmess').hide();
            }
        } else {
            const newytd = price + ytd;
            document.getElementById("futureytd").value = newytd;
            if (newytd > 25 && newytd < 399) {
                //alert("Are You Intersted in assigned Sponsor Parking");
                $('#sponsorcheck').show();
                $('#ytdmess').hide();
            }
            else if (isNaN(newytd)) {
                document.getElementById("futureytd").value = '';
                $('#ytdmess').hide();
                $('#sponsorcheck').hide();
            }
            else if (newytd > 399 && newytd <= 799) {
                $('#ytdmess').html("On completion of your payment, You will be assigned Jain Temple Parking.");
                $('#ytdmess').show();
                //$('#sponsorcheck').show();
                $('#sponsorcheck').hide();
            }
            else if (newytd > 799 && newytd <= 1199 && membertype != "PM" && membertype != "FP") {
                $('#ytdmess').html("On completion of your payment, You will be assigned Gold Sponsor Parking.");
                $('#ytdmess').show();
                $('#sponsorcheck').hide();
            }
            else if (price > 799 && price <= 1199 && (membertype == "PM" || membertype == "FP")) {
                $('#ytdmess').html("On completion of your payment, You will be assigned  Kala Bhavan Parking.");
                $('#ytdmess').show();
                $('#sponsorcheck').hide();
            }
            else if (newytd > 1199 && newytd <= 1999) {
                $('#ytdmess').html("On completion of your payment, You will be assigned Main or Kala Bhavan(KB) Parking.");
                $('#ytdmess').show();
                $('#sponsorcheck').hide();
            }
            else if (newytd > 1999 && newytd <= 4599) {
                $('#ytdmess').html("On completion of your payment, You will be assigned Main or Kala Bhavan(KB) Parking.");
                $('#ytdmess').show();
                $('#sponsorcheck').hide();
            }
            else if (newytd > 4599) {
                $('#ytdmess').html("On completion of your payment, You will be assigned Main Parking.");
                $('#ytdmess').show();
                $('#sponsorcheck').hide();
            }
            else {
                $('#sponsorcheck').hide()
                $('#ytdmess').hide();
            }


        }
        getParentRegistrationPujaPrice();

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
                //$("#gocartbutton").addClass('disabled');
                //document.getElementById("gocartbutton").disabled = true;
                $('#gocartbutton').attr('disabled', 'disabled');
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

        var checkbox = document.getElementById('studentcheck');
        var membercategory = $("#memcatfam").val();
        var pujaname = $("#pul").val();
        var paypricefor = $("#pul2").val();
        var loginrole = <?php echo (json_encode($adminrole)); ?>;
        $("#total_value").val("");
        $('#swapregcheckboxdiv').hide();
        $('#spousenamediv').hide();
        document.getElementById("swap").checked = false;

        if (checkbox.checked == true && (membercategory == 'GD' || membercategory == 'GC' || membercategory == "")) {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'block';
                document.getElementById('documentsubmitbuttondiv').style.display = 'block';
                document.getElementById('addcartbuttondiv').style.display = 'none';
                $("#file").prop('required', true);

                $("#admindoccheck").hide();
                document.getElementById("admincheckdocument").checked = false;
            }

            //25julyupdate
            if (loginrole == true) {
                document.getElementById('admindoccheck').style.display = 'block';
                $("#admincheckdocument").prop('required', true);
            }

            document.getElementById('schoolnamediv').style.display = 'block';
            $("#oottdivcheck").hide();
            $("#parentinputdiv").hide();
            $("#totalamount").val("");
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: 'student',
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaPaidpasses&action=getpujapricedata",
                success: function (res) {
                    $('#ddlStatus').empty();
                    var pricefornewOption = $(res);
                    var newOption = $('<option value="">Please select price type</option>');
                    $('#ddlStatus').append(newOption);
                    $('#ddlStatus').append(pricefornewOption);
                    $('#ddlStatus').trigger("chosen:updated");

                }
            });

        }
        else if (checkbox.checked == true && (membercategory != 'GD' || membercategory != 'GC' || membercategory != "")) {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'none';
                document.getElementById('documentsubmitbuttondiv').style.display = 'none';

                $("#admindoccheck").hide();
                document.getElementById("admincheckdocument").checked = false;
            }


            //25julyupdate
            if (loginrole == true) {
                document.getElementById('admindoccheck').style.display = 'block';
                $("#admincheckdocument").prop('required', true);
            }

            document.getElementById('schoolnamediv').style.display = 'none';
            document.getElementById('addcartbuttondiv').style.display = 'block';
            $("#file").prop('required', false);
            $("#parentinputdiv").hide();
            $("#oottdivcheck").hide();
            $("#totalamount").val("");
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: 'student',
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaPaidpasses&action=getpujapricedata",
                success: function (res) {
                    $('#ddlStatus').empty();
                    var pricefornewOption = $(res);
                    var newOption = $('<option value="">Please select price type</option>');
                    $('#ddlStatus').append(newOption);
                    $('#ddlStatus').append(pricefornewOption);
                    $('#ddlStatus').trigger("chosen:updated");

                }
            });
        }
        else {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'none';
                document.getElementById('documentsubmitbuttondiv').style.display = 'none';
                document.getElementById('addcartbuttondiv').style.display = 'block';
            }

            if (loginrole == true) {
                $("#admindoccheck").hide();
                document.getElementById("admincheckdocument").checked = false;
            }

            document.getElementById('schoolnamediv').style.display = 'none';
            $("#file").prop('required', false);
            $("#oottdivcheck").show();
            $("#parentinputdiv").show();
            $("#totalamount").val("");
            var url1 = $("#container-abc-url-id").text();
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: paypricefor,
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaPaidpasses&action=getpujapricedata",
                success: function (res) {
                    $('#ddlStatus').empty();
                    var pricefornewOption = $(res);
                    var newOption = $('<option value="">Please select price type</option>');
                    $('#ddlStatus').append(newOption);
                    $('#ddlStatus').append(pricefornewOption);
                    $('#ddlStatus').trigger("chosen:updated");

                }
            });

        }
    }

    function showimgoot() {

        var checkbox = document.getElementById('ottcheck');
        var membercategory = $("#memcatfam").val();
        var pujaname = $("#pul").val();
        var paypricefor = $("#pul2").val();
        var loginrole = <?php echo (json_encode($adminrole)); ?>;
        $("#total_value").val("");
        $('#swapregcheckboxdiv').hide();
        $('#spousenamediv').hide();
        document.getElementById("swap").checked = false;

        $('#swapregcheckboxdiv').hide();
        if (checkbox.checked == true && (membercategory == 'GD' || membercategory == 'GC' || membercategory == "")) {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'block';
                document.getElementById('documentsubmitbuttondiv').style.display = 'block';
                document.getElementById('addcartbuttondiv').style.display = 'none';
                $("#file").prop('required', true);

                $("#admindoccheck").hide();
                document.getElementById("admincheckdocument").checked = false;
            }

            //25julyupdate
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
                    paymentfor: 'outoftowner',
                    pyjaname: pujaname,

                },
                url: url1 + "load.php?controller=PujaPaidpasses&action=getpujapricedata",
                success: function (res) {
                    $('#ddlStatus').empty();
                    var pricefornewOption = $(res);
                    var newOption = $('<option value="">Please select price type</option>');
                    $('#ddlStatus').append(newOption);
                    $('#ddlStatus').append(pricefornewOption);
                    $('#ddlStatus').trigger("chosen:updated");

                }
            });

        }
        else if (checkbox.checked == true && (membercategory != 'GD' || membercategory != 'GC' || membercategory != "")) {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'none';
                document.getElementById('documentsubmitbuttondiv').style.display = 'none';

                $("#admindoccheck").hide();
                document.getElementById("admincheckdocument").checked = false;
            }

            //25julyupdate
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
                url: url1 + "load.php?controller=PujaPaidpasses&action=getpujapricedata",
                success: function (res) {
                    $('#ddlStatus').empty();
                    var pricefornewOption = $(res);
                    var newOption = $('<option value="">Please select price type</option>');
                    $('#ddlStatus').append(newOption);
                    $('#ddlStatus').append(pricefornewOption);
                    $('#ddlStatus').trigger("chosen:updated");

                }
            });
        }
        else {
            if (loginrole != true) {
                document.getElementById('documentuploaddiv').style.display = 'none';
                document.getElementById('documentsubmitbuttondiv').style.display = 'none';
                document.getElementById('addcartbuttondiv').style.display = 'block';
            }

            //25julyupdate
            if (loginrole == true) {
                $("#admindoccheck").hide();
                document.getElementById("admincheckdocument").checked = false;
            }

            $("#file").prop('required', false);
            $("#studentdivcheck").show();
            $("#totalamount").val("");
            $.ajax({
                type: "POST",
                data: {
                    paymentfor: paypricefor,
                    pyjaname: pujaname,
                },
                url: url1 + "load.php?controller=PujaPaidpasses&action=getpujapricedata",
                success: function (res) {
                    $('#ddlStatus').empty();
                    var pricefornewOption = $(res);
                    var newOption = $('<option value="">Please select price type</option>');
                    $('#ddlStatus').append(newOption);
                    $('#ddlStatus').append(pricefornewOption);
                    $('#ddlStatus').trigger("chosen:updated");

                }
            });
        }
    }

    function calculateseniordiscount() {

        var pricepuja = parseInt($("#ddlStatus").val());
        var pujaname = $("#pul").val();
        var txtselectpujaname = $("#ddlStatus option:selected").text();
        text = txtselectpujaname.split(" ");
        var pricefor = text[0];
        var pujaprice = text[1].replace('$', "");
        var doantionamount = parseInt($("#totaldonation").val());
        var checkbox = document.getElementById('senior');
        if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "All 3 Pujas" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 20;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "All 3 Pujas" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 20;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "All 3 Pujas" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 40;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "All 3 Pujas" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 40;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "Durga Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 15;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "Durga Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 15;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "Durga Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 30;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "Durga Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 30;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "Kali Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 10;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "Kali Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 10;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "Kali Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 20;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "Kali Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 20;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "Saraswati Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 10;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "Saraswati Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 10;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "Saraswati Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 20;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "Saraswati Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 20;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "Durga Puja + Kali Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 25;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "Durga Puja + Kali Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 25;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "Durga Puja + Kali Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 50;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "Durga Puja + Kali Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 50;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "kali Puja + Saraswati Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 20;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "kali Puja + Saraswati Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 20;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "kali Puja + Saraswati Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 40;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "kali Puja + Saraswati Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 40;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "Durga Puja + Saraswati Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 25;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "Durga Puja + Saraswati Puja" && pricefor == "individual") {
            var afterdiscountprice = pricepuja - 25;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else if (checkbox.checked == true && (!isNaN(doantionamount)) && pujaname == "Durga Puja + Saraswati Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 50;
            var finaltotalamount = afterdiscountprice + doantionamount;
            document.getElementById("total_value").value = finaltotalamount;
        }
        else if (checkbox.checked == true && isNaN(doantionamount) && pujaname == "Durga Puja + Saraswati Puja" && pricefor == "family") {
            var afterdiscountprice = pricepuja - 50;
            document.getElementById("total_value").value = afterdiscountprice;
        }
        else {
            document.getElementById("total_value").value = pujaprice;
        }
        getParentRegistrationPujaPrice();
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
        //
        var total = $("#total_value").val();
        var mode_of_collection = $("#ddlStatus").val();
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

        if (!(total >= 1) || mode_of_collection == "" || mememailfam == "" || memphone2fam == "" || memphonefam == "" || mamzipcodefam == "" || memstatefam == "" || memcityfam == "" || memstreetnamefam == "" || memstreetfam == "" || memlnamefam == "" || memfnamefam == "") {
            alert("Please fill all Required ( * ) fields.");
            $("#payment_method").val("");
        } else { }

    }

    $(document).ready(function () {
        $('form[id="pujapasses-frm-id"]').validate({
            submitHandler: function (form) {
                e.preventDefault();
                form.submit();
            }
        });

    });

</script>
