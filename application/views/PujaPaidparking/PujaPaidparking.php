<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<style>
.checkReadonly {
        pointer-events: none; 
    }
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
        ont-size: 40px;
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

    #submitbutton {
        padding: 10px;
        font-size: 22px;
        border-radius: 10px;
        width: 100%;
        background-color: #000;
        color: #fff;
        margin-top: 30px;
        font-weight: 600;
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
</style>
<title>Paid Parking for Puja</title>
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
                    date_default_timezone_set("America/Chicago");
                    if (date("m-d") < "04-01") {
                        $currentYear = $currentYear - 1; 
                        $nextYear = date("Y");
                    }
                    echo "" . $currentYear . " - " . $nextYear . " Puja Online System ";
                    ?>
                </h3>
                <h3>Payment for Puja Parking</h3>
                <!-- <h4><span>Contact : </span><a href="mailto:registration@durgabari.org"> registration@durgabari.org</a></h4>-->
                <ul class="bread-crumb clearfix">
                    <li><a style="text-decoration:none;color:#fff;"
                            href="<?php echo INSTALL_URL; ?>Associatepayments/Associatepayments">Home</a>
                    </li>
                    <li class="active">Paid Parking</li>
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


    ?>

    <div class="row">

        <div class="col-lg-8 col-md-12 col-sm-12">

            <div style="border-left: 3px solid #ef260f;border-right: 3px solid #ef260f;border-bottom: 3px solid #ef260f;"
                id="showRegistration" class="myChoice">
                <div class="clear"></div>
                <form method="POST" action="" enctype="multipart/form-data" id="paidparking-frm-id">
                    <input type="hidden" name="create_parkingregistration" value="1" />
                    <!--memberall3puja start-->

                    <div id="showMember" class="myDiv" style="display:block;">

                        <div class="row">
                            <div id="hide_nm" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input class="MIDtext2" type="text" name="term" id="term"
                                    placeholder="Search your records *" tabindex="2" required>
                                <input class="MIDtext2" type="text" style="display:none" name="termMember"
                                    id="termMember" placeholder="search member here....">
                                <div class="text_placeholders">Search by : First Name, Last Name, Zip, MID *</div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="puja_type"
                                    id="selectedpujatype" placeholder="Puja Type *" required />
                                <div class="text_placeholders">Puja Type *</div>
                            </div>

                            <div class="text_placeholders" id="notregistermsg"
                                style="display:none;font-size:17px;font-weight: bold;"></div>

                            <div class="col-md-4">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="Member_id"
                                    id="memidfam" placeholder="Member ID *" required />
                                <div class="text_placeholders">Verified Member ID *</div>
                            </div>
                            <div class="col-md-4">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="membercategory"
                                    id="memcatfam" placeholder="Membership Category *" required />
                                <div class="text_placeholders">Membership Category *</div>
                            </div>

                            <div class="col-md-4">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="Member_type"
                                    id="memtypefam" placeholder="Membership Status" />
                                <div class="text_placeholders">Membership Status</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="First_name"
                                    id="memfnamefam" placeholder="First Name *" required />
                                <div class="text_placeholders">First Name *</div>
                            </div>

                            <div class="col-md-6">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" name="Last_name"
                                    id="memlnamefam" placeholder="Last Name *" required />
                                <div class="text_placeholders">Last Name *</div>
                            </div>

                            <div class="col-md-6">
                                <input class="MIDtext2" style="width:100%;" type="text" name="Sp_fname"
                                    id="memspfnamefam" placeholder="Spouse First Name" />
                                <div class="text_placeholders">Spouse First Name</div>
                            </div>

                            <div class="col-md-6">
                                <input class="MIDtext2" style="width:100%;" type="text" name="Sp_lname"
                                    id="memsplnamefam" placeholder="Spouse Last Name" />
                                <div class="text_placeholders">Spouse Last Name</div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 checkbox" style="display:none;">
                                <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                    type="checkbox" id="senior" name="senior" value="1"
                                    onchange="parkingfielddata(this)">
                                <label for="senior">Check here, if Senior</label>
                            </div>

                            <div class="col-md-6 checkbox">
                                <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox"
                                    type="checkbox" id="seniorseventyabove" name="seniorseventyplus" value="yes"
                                    onchange="parkingfielddata(this)">
                                <label for="senior">Check here, if Senior 70+ (Primary Registrant/Spouse only)</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <input class="MIDtext2" style="width:100%;" type="text" name="street" id="memstreetfam"
                                    placeholder="Street # *" required />
                                <div class="text_placeholders">Street # *</div>
                            </div>

                            <div class="col-md-6">
                                <input class="MIDtext2" style="width:100%;" type="text" name="streetname"
                                    id="memstreetnamefam" placeholder="Street Name *" required />
                                <div class="text_placeholders">Street Name *</div>
                            </div>

                            <div class="col-md-3">
                                <input class="MIDtext2" style="width:100%;" type="text" name="unit" id="memunitfam"
                                    placeholder="Unit #" />
                                <div class="text_placeholders">Unit #</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <input class="MIDtext2" style="width:100%;" type="text" name="city" id="memcityfam"
                                    placeholder="City *" required />
                                <div class="text_placeholders">City *</div>
                            </div>

                            <div class="col-md-4">
                                <input class="MIDtext2" style="width:100%;" type="text" name="state" id="memstatefam"
                                    placeholder="State *" required />
                                <div class="text_placeholders">State *</div>
                            </div>

                            <div class="col-md-4">
                                <input class="MIDtext2" style="width:100%;" type="text" name="zip" id="mamzipcodefam"
                                    placeholder="Zip Code *" required />
                                <div class="text_placeholders">Zip Code *</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 phone">
                                <input class="MIDtext2readonly" type="text" name="phone" id="memphonefam"
                                    placeholder="##########" maxlength="10" required />
                                <div class="text_placeholders">Phone Number *</div>
                            </div>
                            <div class="col-md-6 phone">
                                <input class="MIDtext2" type="text" name="alternatenumber" id="memphone2fam"
                                    placeholder="##########" maxlength="10" required />
                                <div class="text_placeholders">Mobile Number *</div>
                            </div>
                            <div class="col-md-6">
                                <input class="MIDtext2readonly" style="width:100%;" type="text" required name="email"
                                    id="mememailfam" placeholder="name@company.com"
                                    pattern="[^@\s]+@[^@\s]+\.[^@\s]+" />
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
                            <div class="col-md-6">
                                <input class="MIDtext2readonly" type="text" name="ytddata" id="ytd"
                                    style="display:block;" placeholder="Annual YTD($)">
                                <div class="text_placeholders">YTD ($)</div>
                            </div>

                            <div class="col-md-6">
                                <input class="MIDtext2readonly" type="number" name="futureYTD" id="futureYTD"
                                    style="display:block;" placeholder="Future YTD ($)" />
                                <div class="text_placeholders">Future YTD ($)</div>
                            </div>
                            <!-- <div class="col-md-6" style="display:none;margin-top: 16px;" id="parkingfielddiv">
                                <select class="choice" id="parkingfield" name="parking" required
                                    onchange="parkingprice(this)">
                                </select>
                                <div class="text_placeholders">Parking Field *</div>
                            </div> -->

                            <!-- <div class="col-md-6">
                                <input class="MIDtext2readonly" type="number" required name="amount" id="total_value4"
                                    readonly placeholder="Total Amount($) *" />
                                <div class="text_placeholders">Requested Amount to Pay($)* </div>
                            </div> -->

                            <div class="col-md-12" style="display:none;" id="featureytddiv">
                                <div class="text_placeholders" id="ytdmess"
                                    style="font-size: 24px;padding: 10px;color: #adff2f;background-color: #000;margin-top: 12px;border-radius: 10px;text-transform: uppercase;line-height: 30px;text-align: center;font-weight: 700;">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <input class="MIDtext2" type="number" required name="amount" id="total_value4"
                                    placeholder="Total Amount($) *" />
                                <div id="donationHeading" class="text_placeholders">Puja Benefactor donation</div>
                            </div>
                        </div>
                        <div class="text_placeholders" id="discountmsgdiv"
                            style="display:none;font-size: 24px;padding: 10px;color: #adff2f;background-color: #000;margin-top: 12px;border-radius: 10px;line-height: 30px;text-align: center;font-weight: 700;">
                        </div>
                        <!-- hidden field for parking area  and ytd -->

                        <input type="text" name="parkingfield" id="hiddenparkingarea" style="display:none;">
                        <input id="Zellecode" class="form-control input-sm" type="text" name="code"
                            style="display:none;">
                        <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                            <table class="table" id="tblPaymentOption">
                                <tr class="tr">
                                    <td class="td" colspan="2" style="width:800px !important">

                                        <select name="PaymentOption" style="width:100%;  height:50%;"
                                            onchange="paymentmethod(this.id)" id="PaymentOption" class="choice" required>
                                            <option value="">Please Select</option>
                                            <option value="check">Check</option>
                                            <option value="cash">Cash</option>
                                            <option value="directdeposit">Online Deposit</option>
                                            <option value="sumup">Sumup</option>
                                            <option value="stripe">Credit card</option>
                                            <option value="zelleProxy">Zelle Proxy</option>
                                            <!-- <option value="others">Zelle (Preferred)</option>   -->
                                        </select>



                                        <div class="text_placeholders">Payment Method</div>
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
                                            <input style="WIDTH: 100%;" type="number" id="checkamount" name="checkAmount"
                                                class="form-control input-sm" value="">
                                        </td>
                                        <td class="td"><input style="WIDTH: 100%;" type="date" id="checkdate"
                                                name="CheckDate" class="form-control input-sm" value=""></td>
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
                                        <td class="td"><input type="text" id="receiveby" name="ReceiveBy"
                                                class="form-control input-sm" value=""></td>

                                        <td class="td">
                                            <input type="number" id="cashamount" name="cashAmount"
                                                class="form-control input-sm" value="">
                                        </td>
                                        <td class="td"><input type="date" id="cashdate" name="cashDate"
                                                class="form-control input-sm" value=""></td>
                                        <td class="td"><select name="CashDepositAccount" class="choice">
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
                                        <td class="td"><input style="WIDTH: 100%;" type="text" id="sumdata" name="sumupid"
                                                class="form-control input-sm" value=""></td>
                                        <td class="td">
                                            <input style="WIDTH: 100%;" type="number" id="sumupprice" name="sumupamount"
                                                class="form-control input-sm" value="">
                                        </td>
                                        <td class="td"><input style="WIDTH: 100%;" type="date" id="date" name="sumupdate"
                                                class="form-control input-sm" value=""></td>
                                        <td class="td">
                                            <select name="DepositAccount" class="choice">
                                                <option value="PujaAccount">Puja Account</option>
                                                <option value="RegularAccount">Regular Account</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- zelle proxy -->
                            <table class="table table-bordered table-hover table-striped"
                                style="display:none;margin-top: -42px;" id="zelleProxyData">
                                <thead>
                                    <tr class="tr">
                                        <th>Transaction Id</th>
                                        <th>Transaction Date</th>
                                        <th>Amount</th>
                                        <th>Deposit Account</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="tr">
                                        <td class="td"><input style="WIDTH: 100%;" type="text" id="proxyTrId"
                                                name="zelleProxyTid" class="form-control input-sm" value=""></td>
                                        <td class="td"><input style="WIDTH: 100%;" type="date" id="proxyTrdate"
                                                name="proxydate" class="form-control input-sm" value=""></td>
                                        <td class="td">
                                            <input style="WIDTH: 100%;" type="number" id="proxyprice" name="proxyamount"
                                                class="form-control input-sm" value="">
                                        </td>
                                        <td class="td">
                                            <select name="zelleProxyDepositAccount" class="choice">
                                                <option value="PujaAccount">Puja Account</option>
                                                <option value="RegularAccount">Regular Account</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } ?>
                        <div
                            style="font-weight: 600; padding: 2rem 1rem; font-size: 20px ; line-height: 1.2; color: red;  border-radius: 1rem; background-color: #fff; margin-top: 1rem; box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;">
                            NOTE: Please ensure the information provided is correct. If you want to review/update
                            any
                            information, please scroll up, or if you want a fresh start, click the Reset button. To
                            proceed with the transaction, click the 'Make Payment' button.
                        </div>
                        <article class="note-text p-3 rounded-lg mt-5">
                            <p class="fs-2 fw-bold mb-0" style="font-family: monospace;">Processing of Parking requests
                                will follow a priority schedule. A payment link will be sent once a parking spot has
                                been confirmed. The parking spot will be released if no payment is made within a week of
                                receiving the payment link.</p>
                        </article>
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
                        <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                        <div class="row">
                            <div class="col-md-6">
                                <button type="reset" onClick="window.location.reload();"
                                    class="go_cart_btn">Reset</button>
                            </div>
                            <div id="stripe_secret_key_id" style="display: none">
                                <?php echo $tpl['option_arr_values']['stripe_publish_key']; ?></div>
                            <div id="free_btn_div" class="col-md-6">
                                <button style="display: none;" id="free_btn" class="btn btn-primary" autocomplete="off"
                                    value="Save" name="free_submit" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;
                                    Submit Request</button>
                            </div>
                            <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                                <div class="col-md-6">
                                    <button id="submitbutton" type="submit" class="btn btn-primary" name="">Submit
                                        Request</button>
                                </div>
                            <?php } ?>
                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                <div class="col-md-6">
                                    <button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save"
                                        name="Payment" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;Make
                                        Payment</button>

                                </div>
                            <?php } ?>

                        </div>


                    </div>

                    <!--memberall3puja end-->


                </form>


            </div>


        </div>

        <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">

            <aside class="sidebar">
                <!-- Help Widget -->

                <div class="sidebar-widget help-widget">

                    <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                        <a style="font-size: 24px; text-decoration: none;color:#000;"
                            href="<?php echo INSTALL_URL; ?>parkingadmin/index">Go Back to Dashboard</a>
                        <br><br>
                    <?php } ?>
                    <div class="sidebar-title">
                        <h2><span style="color: #ef260f;">General</span> Guidelines</h2>
                    </div>
                    <div class="widget-content">
                        <div class="text"><strong>Step 1 : </strong>Express your interest to purchase a parking spot
                        </div>
                        <div class="text"><strong>Step 2 : </strong>Registration Team will validate your application and
                            send a confirmation</div>
                        <div class="text"><strong>Step 3 : </strong>Make the payment </div>
                        <div class="text"><strong>1. </strong>Parking for Durga Puja and Kali Puja only. Open parking
                            during Saraswati Puja.</div>
                        <div class="text"><strong>2. </strong>Prior Puja registration is mandatory. Please submit this
                            after you have completed your registration.</div>
                        <div class="text"><strong>3. </strong>All Gold+ and Senior CT Silver Sponsors will have assigned
                            parking and are not
                            required to submit this request. Silver Sponsors may opt for Green Field parking at a
                            discounted rate thru this process</div>
                        <div class="text"><strong>4. </strong>Due to limited space, Sponsors, Senior Registrants and
                            Registrants with accompanying (registered) parents will be prioritized for Green Field
                            parking. General Registrants will be held on a priority list and notified based on any
                            remaining parking space availability. Reservation is final only after due payment processing
                            and confirmation. </div>
                        <div class="text"><strong>5. </strong>Senior designation starts at 70 years. Senior
                            status/discount applies to primary registrant and spouse only (and not to any accompanying
                            parents)</div>
                        <div class="text"><strong>6. </strong>Parking in Green Field is subject to weather and ground
                            conditions. Payment will be refunded if the Green Field is not in a usable condition for at
                            least two days out of Fri/Sat/Sun during Durga Puja</div>
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
                        <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                style="color:#000;text-decoration:none;" href="tel:+18322055665"> <strong
                                    style="font-size:26px;">+1 832-205-5665</strong> <br><span
                                    style="font-size:20px;color:#000;">Amit Bhaduri</span></a></p>
                        <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                style="color:#000;text-decoration:none;" href="tel:+18326909062"> <strong
                                    style="font-size:26px;">+1 832-723-4829</strong> <br><span
                                    style="font-size:20px;color:#000;">Debashish Sarkar</span></a></p>
                        <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                style="color:#000;text-decoration:none;" href="tel:+18326770860"> <strong
                                    style="font-size:26px;"> +1 832-677-0860</strong> <br><span
                                    style="font-size:20px;color:#000;">Subhas Das</span></a></p>

                    </div>
                </div>

            </aside>
        </div>


    </div>
</div>


<script>
var loginrole = "";
$(document).ready(function () {
  loginrole = <?php echo (json_encode($adminrole)); ?>;
});

    ////Lookup.......................Start..............................////
    $(function () {
        //
        $("#term").autocomplete({
            //source: "http://localhost:/HDBS_Payment/Parking&Badges/ajax-db-search.php",
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
        $('#mememailfam').prop('readonly', false);
        $('#memphonefam').prop('readonly', false);
        var self = this;
        var data = $("#termMember").val();
        var term = $("#term").val();
        // for Ytd condition
        $('#total_value4').val("");
        $('#notregistermsg').hide();
        $("#submitbutton").removeClass('disabled');
        document.getElementById("senior").checked = false;
        $("#selectedpujatype").val("");
        $("#parkingfield").val("");
        $("#parkingfielddiv").hide();
        $("#sponsor").val("");
        $("#sponsorevent").val("");

        $('#discountmsgdiv').hide();

        if (term != "") {
            const Memberid = data.split("-");
            $.ajax({
                type: "POST",
                data: {
                    memberid: data
                },

                //url: self.options.server  +"load.php?controller=Donations&action=AllMember&cid=" + self.options.cal_id,
                url: url2 + "load.php?controller=PujaOnlinePayments&action=checkemberregister",
                success: function (res) {

                    let datamember = "";
                    const memberregcheckElement = $(res).filter("input#memberdata");
                    if (memberregcheckElement.length) {
                        datamember = memberregcheckElement[0].value;
                        if (datamember == 'true') {
                            let seniormember = "";
                            const seniorcheckElement = $(res).filter("input#membersenior");
                            if (seniorcheckElement.length) {
                                seniormember = seniorcheckElement[0].value;

                                //console.log(seniormember);
                                 if (seniormember == 1) {
                                    $("#seniorseventyabove").removeClass('checkReadonly');
                                    $("#seniorseventyabove").prop('checked', true);
                                    $("#seniorseventyabove").addClass('checkReadonly');
                                }
                                else {
                                    $("#seniorseventyabove").prop('checked', false);
                                   $("#seniorseventyabove").addClass('checkReadonly');
                                }

                            }
                            let selectedpuja = "";
                            const registerpujaElement = $(res).filter("input#pujaname");
                            if (registerpujaElement.length) {
                                selectedpuja = registerpujaElement[0].value;
                            }
                            document.getElementById("selectedpujatype").value = selectedpuja;

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
                                }
                                else {
                                    $('#mememailfam').prop('readonly', false);
                                }
                            }
                            document.getElementById("mememailfam").value = email;


                            let phoneNo = "";
                            const phoneNoElement = $(res).filter("input#Tele1");
                            if (phoneNoElement.length) {
                                phoneNo = phoneNoElement[0].value;
                                if (phoneNo != "") {
                                    $('#memphonefam').prop('readonly', true);
                                }
                                else {
                                    $('#memphonefam').prop('readonly', false);
                                }
                            }
                            new_phone = phoneNo.replace(/[-)(]/g, "");
                            document.getElementById("memphonefam").value = new_phone;

                            //add 11 july
                            let mobile = "";
                            const mobileNoElement = $(res).filter("input#phone_work");
                            if (mobileNoElement.length) {
                                mobile = mobileNoElement[0].value;

                                // if(mobile !="" ){
                                //     $('#memphone2fam').prop('readonly', true);
                                //     $('#memphone2fam').addClass('MIDtext2readonly');
                                // }
                                // else{
                                //     $('#memphone2fam').prop('readonly', false);
                                //     $('#memphone2fam').removeClass('MIDtext2readonly')
                                //     $('#memphone2fam').addClass('MIDtext2');
                                // }

                            }
                            document.getElementById("memphone2fam").value = mobile;

                            let zipcode = "";
                            const zipcodeElement = $(res).filter("input#zip_code");
                            if (zipcodeElement.length) {
                                zipcode = zipcodeElement[0].value;
                                if (zipcode != "") {
                                    $('#mamzipcodefam').prop('readonly', true);
                                    $('#mamzipcodefam').addClass('MIDtext2readonly');
                                }
                                else {
                                    $('#mamzipcodefam').prop('readonly', false);
                                    $('#mamzipcodefam').removeClass('MIDtext2readonly')
                                    $('#mamzipcodefam').addClass('MIDtext2');
                                }
                            }
                            document.getElementById("mamzipcodefam").value = zipcode;

                            let state = "";
                            const stateElement = $(res).filter("input#state");
                            if (stateElement.length) {
                                state = stateElement[0].value;
                                if (state != "") {
                                    $('#memstatefam').prop('readonly', true);
                                    $('#memstatefam').addClass('MIDtext2readonly');
                                }
                                else {
                                    $('#memstatefam').prop('readonly', false);
                                    $('#memstatefam').removeClass('MIDtext2readonly')
                                    $('#memstatefam').addClass('MIDtext2');
                                }
                            }
                            document.getElementById("memstatefam").value = state;

                            let city = "";
                            const cityElement = $(res).filter("input#city");
                            if (cityElement.length) {
                                city = cityElement[0].value;
                                if (city != "") {
                                    $('#memcityfam').prop('readonly', true);
                                    $('#memcityfam').addClass('MIDtext2readonly');
                                }
                                else {
                                    $('#memcityfam').prop('readonly', false);
                                    $('#memcityfam').removeClass('MIDtext2readonly')
                                    $('#memcityfam').addClass('MIDtext2');
                                }
                            }
                            document.getElementById("memcityfam").value = city;


                            let unit = "";
                            const unitElement = $(res).filter("input#unitAddress");
                            if (unitElement.length) {
                                unit = unitElement[0].value;
                                if (unit != "") {
                                    $('#memunitfam').prop('readonly', true);
                                    $('#memunitfam').addClass('MIDtext2readonly');
                                }
                                else {
                                    $('#memunitfam').prop('readonly', false);
                                    $('#memunitfam').removeClass('MIDtext2readonly')
                                    $('#memunitfam').addClass('MIDtext2');
                                }
                            }
                            document.getElementById("memunitfam").value = unit;

                            let streetname = "";
                            const streetnameElement = $(res).filter("input#Address");
                            if (streetnameElement.length) {
                                streetname = streetnameElement[0].value;
                                if (streetname != "") {
                                    $('#memstreetnamefam').prop('readonly', true);
                                    $('#memstreetnamefam').addClass('MIDtext2readonly');
                                }
                                else {
                                    $('#memstreetnamefam').prop('readonly', false);
                                    $('#memstreetnamefam').removeClass('MIDtext2readonly')
                                    $('#memstreetnamefam').addClass('MIDtext2');
                                }
                            }
                            document.getElementById("memstreetnamefam").value = streetname;

                            let street = "";
                            const streetElement = $(res).filter("input#ressidentalAddress");
                            if (streetElement.length) {
                                street = streetElement[0].value;
                                if (street != "") {
                                    $('#memstreetfam').prop('readonly', true);
                                    $('#memstreetfam').addClass('MIDtext2readonly');
                                }
                                else {
                                    $('#memstreetfam').prop('readonly', false);
                                    $('#memstreetfam').removeClass('MIDtext2readonly')
                                    $('#memstreetfam').addClass('MIDtext2');
                                }
                            }
                            document.getElementById("memstreetfam").value = street;


                            let memberlname = "";
                            const memberlnameElement = $(res).filter("input#last_name");
                            if (memberlnameElement.length) {
                                memberlname = memberlnameElement[0].value;
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
                            //parkingfielddata();

                            let memberid = "";
                            const memberidElement = $(res).filter("input#memberid");
                            if (memberidElement.length) {
                                memberid = memberidElement[0].value;
                            }
                            document.getElementById("memidfam").value = memberid;

                            let memberspfname = "";
                            const memberspfnameElement = $(res).filter("input#Spouse");
                            if (memberspfnameElement.length) {
                                memberspfname = memberspfnameElement[0].value;
                                if (memberspfname != "") {
                                    $('#memspfnamefam').prop('readonly', true);
                                    $('#memspfnamefam').addClass('MIDtext2readonly');
                                }
                                else {
                                    $('#memspfnamefam').prop('readonly', false);
                                    $('#memspfnamefam').removeClass('MIDtext2readonly')
                                    $('#memspfnamefam').addClass('MIDtext2');
                                }
                            }
                            document.getElementById("memspfnamefam").value = memberspfname;

                            let membersplname = "";
                            const membersplnameElement = $(res).filter("input#Spouselast");
                            if (membersplnameElement.length) {
                                membersplname = membersplnameElement[0].value;
                                if (membersplname != "") {
                                    $('#memsplnamefam').prop('readonly', true);
                                    $('#memsplnamefam').addClass('MIDtext2readonly');
                                }
                                else {
                                    $('#memsplnamefam').prop('readonly', false);
                                    $('#memsplnamefam').removeClass('MIDtext2readonly')
                                    $('#memsplnamefam').addClass('MIDtext2');
                                }
                            }
                            document.getElementById("memsplnamefam").value = membersplname;

                            $('#notregistermsg').hide();
                            const Memberid = data.split("-");
                            $.ajax({
                                type: "POST",
                                data: {
                                    memberid: data
                                },
                                url: url2 + "load.php?controller=PujaDonations&action=AllMemberNew",
                                success: function (res) {
                                    let ytd1 = "";
                                    const ytd1Element = $(res).filter("input#ytd");
                                    const memberCategory = $("#memcatfam").val();
                                    var seniorChecked = document.getElementById('seniorseventyabove');
                                    if (ytd1Element.length) {
                                        ytd1 = ytd1Element[0].value;
                                        if (ytd1 >= 750) {
                                            $('#notregistermsg').html("You are eligible for Sponsor Parking. You do not need to use this site.<br><a href='<?php echo INSTALL_URL; ?>Sponsorship/Sponsorship'>Click Here For Sponsor Parking</a>");
                                            alert("This site is reserved for general donors (non-Sponsors) and do not proceed");
                                            $('#notregistermsg').show();
                                            $("#submitbutton").addClass('disabled');
                                            $("#payment_btn_id").addClass('disabled');
                                            $("#tblPaymentOption").hide();
                                        }
                                        //else if(399 < ytd1 < 799)
                                        // else if (ytd1 > 399 && ytd1 < 799 && (memberCategory === 'PM' || memberCategory === "FP") && seniorChecked.checked == true) {
                                        //     $('#notregistermsg').html("Your parking is already assigned. You do not need to use this site.");
                                        //     $('#notregistermsg').show();
                                        //     $("#submitbutton").addClass('disabled');
                                        //     $("#payment_btn_id").addClass('disabled');
                                        //     $("#tblPaymentOption").hide();
                                        // }
                                        // else if (ytd1 > 399 && ytd1 < 799) {
                                        //     $('#notregistermsg').html("You are a Silver Sponsor. Use this site if you would like to opt for Green Field parking at a discounted rate.");
                                        //     $('#notregistermsg').show();
                                        //     $("#submitbutton").removeClass('disabled');
                                        //     $("#payment_btn_id").removeClass('disabled');
                                        //     if(loginrole == true){
                                        //         //$("#tblPaymentOption").Show();
                                        //         document.getElementById('tblPaymentOption').style.display = 'block';
                                        //     }
                                        //     document.getElementById("ytd").value = ytd1;
                                        //     parkingfielddata();
                                        // }
                                        // else if(ytd1 <400){
                                        //     $("#submitbutton").removeClass('disabled');
                                        //     $("#payment_btn_id").removeClass('disabled');
                                        //     if(loginrole == true){
                                        //          document.getElementById('tblPaymentOption').style.display = 'block';
                                        //     }
                                        //     document.getElementById("ytd").value = ytd1;
                                        //     parkingfielddata();
                                        // }
                                    }
                                    document.getElementById("ytd").value = ytd1;
                                    updateFutureYTD();
                                }

                            });
                        }
                        else {
                            $('#notregistermsg').html("You have not registered for Puja (All 3 Pujas or Durga Puja). Please complete your registration first.<br><a href='<?php echo INSTALL_URL; ?>Sponsorship/Sponsorship'>Click Here For Puja Registration</a>");
                            $('#notregistermsg').show();
                            $("#submitbutton").addClass('disabled');
                            $("#payment_btn_id").addClass('disabled');
                            $("#tblPaymentOption").hide();
                            $("#memidfam").val("");
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
                            $("#selectedpujatype").val("");
                            $("#memspfnamefam").val("");
                            $("#memsplnamefam").val("");
                        }
                    }
                }
            })

        }

    }
    // autocomplete end     

    // parkingfield show dropdown
    function parkingfielddata() {

        $('#total_value4').val("");
        $("#parkingfielddiv").hide();
        $('#discountmsgdiv').hide();
        var newOption = $('<option value="">Please select Parking</option>');
        //var newOption1 = $('<option value="250">Kala Bhavan Parking</option>');
        var newOption2 = $('<option value="200">Green Field</option>');
        var newOption3 = $('<option value="100">Green Field</option>');
        var newOption4 = $('<option value="100">Green Field</option>');
        //var newOption5 = $('<option value="75">Jain Temple</option>');

        //var checkbox = document.getElementById('senior');
        var checkboxseventy = document.getElementById('seniorseventyabove');
        const membercategory = $("#memcatfam").val();
        const memberytd = $("#ytd").val();

        if (checkboxseventy.checked == true && (membercategory == "PM" || membercategory == "FP")) {
            $('#parkingfield').empty();
            $('#parkingfield').append(newOption);
            //$('#parkingfield').append(newOption1);
            $('#parkingfield').append(newOption4);
            $("#parkingfielddiv").show();
        }
         // else if (checkboxseventy.checked != true && (membercategory == "PM" || membercategory == "FP")) {
        //     $('#parkingfield').empty();
        //     $('#parkingfield').append(newOption);
        //     $('#parkingfield').append(newOption2);
        //     //$('#parkingfield').append(newOption5);
        //     $("#parkingfielddiv").show();
        // }
        else if (checkboxseventy.checked != true && memberytd > 399 && memberytd < 799 && (membercategory == "PM" || membercategory == "FP")) {
            $('#parkingfield').empty();
            $('#parkingfield').append(newOption);
            $('#parkingfield').append(newOption4);
            $("#parkingfielddiv").show();
        }
        else if (checkboxseventy.checked != true && memberytd > 399 && memberytd < 799 && (membercategory != "PM" || membercategory != "FP")) {
            $('#parkingfield').empty();
            $('#parkingfield').append(newOption);
            $('#parkingfield').append(newOption4);
            $("#parkingfielddiv").show();
        }
        // 21 july update

        else if (checkboxseventy.checked == true && memberytd > 399 && memberytd < 799 && (membercategory != "PM" || membercategory != "FP")) {
            $('#parkingfield').empty();
            $('#parkingfield').append(newOption);
            $('#parkingfield').append(newOption4);
            $("#parkingfielddiv").show();
        }

        else if (checkboxseventy.checked != true && memberytd < 400) {
            $('#parkingfield').empty();
            $('#parkingfield').append(newOption);
            $('#parkingfield').append(newOption2);
            //$('#parkingfield').append(newOption5);
            $("#parkingfielddiv").show();
        }

        else if (checkboxseventy.checked == true && memberytd < 400) {
            $('#parkingfield').empty();
            $('#parkingfield').append(newOption);
            $('#parkingfield').append(newOption3);
            //$('#parkingfield').append(newOption5);
            $("#parkingfielddiv").show();
        }

        else {
            $('#parkingfield').empty();
            $('#parkingfield').append(newOption);
            $('#parkingfield').append(newOption2);
            // 13july update 
            // $('#parkingfield').append(newOption5);
            $("#parkingfielddiv").show();

        }

    }

    // 21 july update
    function parkingprice() {
        //
        const parkingvalue = $("#parkingfield").val();
        var parkingname = $("#parkingfield option:selected").text();
        if (parkingvalue != "") {
            $('#total_value4').val(parkingvalue);
            $('#hiddenparkingarea').val(parkingname);

        }
        else {
            $("#total_value4").val("");
            $("#hiddenparkingarea").val("");
        }

    }

    $(function () {
        $('input[type="text"]').change(function () {
            this.value = $.trim(this.value);
        });
    });


    $('#term').on('input', function () {
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

    // for validate phone no field
    $("#memphonefam").change(function () {
        const phonenumber = $("#memphonefam").val();
        if (!!phonenumber) {
            if (isNaN(phonenumber)) {
                alert("Please Enter mobile Number");
                $("#submitbutton").addClass('disabled');

            }
            else if (phonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#submitbutton").addClass('disabled');

            }
            else if (phonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#submitbutton").addClass('disabled');

            }
            else if (phonenumber.length == 10) {
                $("#submitbutton").removeClass('disabled');

            }
            else {
                $("#submitbutton").removeClass('disabled');

            }
        }
        else {
            $("#memphonefam").prop('required', true);
            $("#submitbutton").removeClass('disabled');

        }
    });

    $("#memphone2fam").change(function () {
        const phonenumber = $("#memphone2fam").val();
        if (!!phonenumber) {
            if (isNaN(phonenumber)) {
                alert("Please Enter mobile Number");
                $("#submitbutton").addClass('disabled');

            }
            else if (phonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#submitbutton").addClass('disabled');

            }
            else if (phonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#submitbutton").addClass('disabled');

            }
            else if (phonenumber.length == 10) {
                $("#submitbutton").removeClass('disabled');

            }
            else {
                $("#submitbutton").removeClass('disabled');

            }
        }
        else {
            $("#memphone2fam").prop('required', true);
            $("#submitbutton").removeClass('disabled');

        }
    });

    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    }

    function paymentmethod() {
        //
        var total = $("#total_value4").val();
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

        if (!(total >= 0) || mememailfam == "" || memphone2fam == "" || memphonefam == "" || mamzipcodefam == "" || memstatefam == "" || memcityfam == "" || memstreetnamefam == "" || memstreetfam == "" || memlnamefam == "" || memfnamefam == "") {
            alert("Please fill all Required ( * ) fields.");
            $("#PaymentOption").val("");
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

    let seniorValueCheck = document.getElementById("seniorseventyabove");
    let featureytddiv = document.getElementById("featureytddiv");
    let ytdmess = document.getElementById("ytdmess");
    const paymentBtn = document.getElementById('payment_btn_id');
    const requestBtn = document.getElementById('submitbutton');
    const free_btn = document.getElementById("free_btn");
    const tblPaymentOption = document.getElementById("tblPaymentOption");
    const donationInput = document.getElementById('total_value4');
    const donationHeading = document.getElementById("donationHeading");
    const PaymentOption = document.getElementById("PaymentOption");

    function updateFutureYTD() {
        const totalInput = document.getElementById('total_value4') ? document.getElementById('total_value4').value : '';
        const ytdInput = document.getElementById('ytd') ? document.getElementById('ytd').value : '';

        const totalValue = isNaN(parseFloat(totalInput)) ? 0 : parseFloat(totalInput);
        const ytdValue = isNaN(parseFloat(ytdInput)) ? 0 : parseFloat(ytdInput);
        const futureYTDInput = document.getElementById('futureYTD');
        if (futureYTDInput) {
            futureYTDInput.value = totalValue + ytdValue;
        }

        if (seniorValueCheck && seniorValueCheck.checked && ytdValue > 149 && ytdValue <= 749) {
            if (free_btn) free_btn.style.display = "block";
            if (paymentBtn) paymentBtn.style.display = 'none';
            if (requestBtn) requestBtn.style.display = 'none';
            if (tblPaymentOption) tblPaymentOption.style.display = "none";
            if (donationInput) {
                donationInput.style.display = "none";
                donationInput.required = false;
            }
            if (donationHeading) donationHeading.style.display = "none";
            if (PaymentOption) PaymentOption.required = false;
        } else if (seniorValueCheck && !seniorValueCheck.checked && ytdValue > 399 && ytdValue <= 749) {
            if (free_btn) free_btn.style.display = "block";
            if (paymentBtn) paymentBtn.style.display = 'none';
            if (requestBtn) requestBtn.style.display = 'none';
            if (tblPaymentOption) tblPaymentOption.style.display = "none";
            if (donationInput) {
                donationInput.style.display = "none";
                donationInput.required = false;
            }
            if (donationHeading) donationHeading.style.display = "none";
            if (PaymentOption) PaymentOption.required = false;
        } else {
            if (free_btn) free_btn.style.display = "none";
            if (tblPaymentOption) tblPaymentOption.style.display = "block";
            if (donationInput) {
                donationInput.style.display = "block";
                donationInput.required = true;
            }
            if (donationHeading) donationHeading.style.display = "block";
            if (PaymentOption) PaymentOption.required = true;
        }
    }

    let userRoleValue = '';

    document.addEventListener('DOMContentLoaded', function () {
        let userRole = '';
        <?php
        if ($this->controller->isAdmin()) {
            echo "userRole = 'admin';";
        } elseif ($this->controller->isEditor()) {
            echo "userRole = 'admin';";
        } else {
            echo "userRole = '';";
        }
        ?>
        userRoleValue = userRole;

        if (paymentBtn) paymentBtn.style.display = 'none';
        if (requestBtn) requestBtn.style.display = 'none';

        futureYTDMessage();
    });

    if (document.getElementById('total_value4')) {
        document.getElementById('total_value4').addEventListener('change', function () {
            updateFutureYTD();
            futureYTDMessage();
        });
    }

    function futureYTDMessage() {
        const futureYTDInput = document.getElementById('futureYTD');
        const futureYTD = futureYTDInput ? parseFloat(futureYTDInput.value) : 0;

        if (futureYTD > 749) {
            if (featureytddiv) featureytddiv.style.display = "block";
            if (ytdmess) ytdmess.innerText = "Please go to the Donation page to make your donation, do not proceed here";
            if (paymentBtn) paymentBtn.style.display = 'none';
            if (requestBtn) requestBtn.style.display = 'none';
        } else {
            if (featureytddiv) featureytddiv.style.display = "none";
            if (ytdmess) ytdmess.innerText = "";

            if (paymentBtn) paymentBtn.style.display = 'none';
            if (requestBtn) requestBtn.style.display = 'none';

            if (seniorValueCheck && seniorValueCheck.checked) {
                if (futureYTD >= 150 && futureYTD <= 749) {
                    if (userRoleValue === 'admin') {
                        if (paymentBtn) paymentBtn.style.display = 'block';
                    } else {
                        if (requestBtn) requestBtn.style.display = 'block';
                    }
                }
                if (futureYTD >= 0 && futureYTD <= 149) {
                    alert("please donate for ytd to be between $150 to 749");
                }
            } else {
                if (futureYTD >= 400 && futureYTD <= 749) {
                    if (userRoleValue === 'admin') {
                        if (paymentBtn) paymentBtn.style.display = 'block';
                    } else {
                        if (requestBtn) requestBtn.style.display = 'block';
                    }
                }
                if (futureYTD >= 0 && futureYTD <= 399) {
                    alert("please donate for ytd to be between $400 to 749");
                }
            }
        }
    }
</script>
