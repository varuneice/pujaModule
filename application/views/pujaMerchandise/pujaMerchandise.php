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

    select.choice6 {
        width: 100%;
        padding: 8px;
        font-size: 18px;

        border-radius: 15px;
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

    #fullAddressInput {
        padding: 12px;
        font-size: 20px;
        margin-top: 20px;
        border-radius: 10px;
        width: 70rem;

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
        width: 43%;
        background-color: #000;
        color: #fff;
        margin-top: 30px;
        font-weight: 600;
    }

    #reset_btn_id {
        padding: 10px;
        font-size: 22px;
        border-radius: 10px;
        width: 43%;
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




    .priceHeading {
        font-size: 24px;

    }

    .priceHeading {
        font-size: 24px;
    }


    #sareepunjabiConatiner {
        display: flex;
        /* flex-direction: row-reverse; */
        /* Default */
        column-gap: 23rem;
        padding: 0 2rem;
        flex-direction: column;
        row-gap: 2rem;
    }

    .sareeImageContainer {
        width: 65rem;
        height: 35rem;
        display: flex;
        margin-bottom: 1rem;
    }

    /* Media Query for screens between 970px and 1210px */
    @media (min-width: 970px) and (max-width: 1210px) {
        .sareeImageContainer {
            width: 59rem;
        }

        select.choice6 {
            width: 92%;



        }

        input.MIDtext2 {

            width: 92%;
        }
    }


/*punjabi size chart css*/

    .modal {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 10px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .modal-content h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #007BFF;
    }


    table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    table,
    th,
    td {
        border: 1px solid #ccc;
    }

    th,
    td {
        padding: 10px;
    }

    .close-btn {
        float: right;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }


    .sizebtn {
        padding: 10px 14px;
        background-color: #007BFF;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        margin: 20px;
         font-size: 18px;
    }

    .sizebtn:hover {
        background-color: #0056b3;
    }


#sizeTable th {
        text-align: center;
    }
    
    
     #sareeNameDiv {
        display: flex;
        column-gap: 21rem;
        font-size: 20px;
        margin-bottom: 0.5rem;
        font-weight: 800;

    }


    #punjabiNameDiv {
        display: flex;
        column-gap: 16rem;
        font-size: 20px;
        margin-bottom: 0.5rem;
        font-weight: 800;

    }

    #whiteRedPunjabi
    {
        margin-left: 8rem;
    }

    


    @media (max-width: 1210px) {

        #sareeNameDiv {
            column-gap: 17rem;
        }


        #punjabiNameDiv {
        column-gap: 13rem;
       }

          #whiteRedPunjabi
         {
        margin-left: 7rem;
         }
    
    
    }


.accountDropdown {
        padding: 8px 6px;
        border-radius: 3px;
        border-color: #f9fcfa;
        background-color: #03a9f4;
        color: white;
        font-size: 18px;

    }



    @media (min-width: 970px) and (max-width: 1210px) {
        #sareepunjabiConatiner {
            column-gap: 4rem;
        }
    }
</style>
<title>Puja Merchandise</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />

<!-- Start -->




<!-- End -->

<section class="page-title" style="background-image:url(<?php echo INSTALL_URL; ?>12.jpg);">
    <div class="auto-container">
        <div class="row clearfix">
            <!--Title -->
            <div style="display: flex;" class="title-column col-lg-6 col-md-12 col-sm-12">

                <div style="width: 21rem;">
                    <img style="float:left;padding:20px ; width: 100%" src="../1.svg">
                </div>

                <div style="width: 15rem; margin-top: 1.9rem;">
                    <img style="border-radius: 43px;float: left;padding: 0px;  width: 94%" src="../merchandise.jpg">
                </div>






            </div>
            <!--Bread Crumb -->
            <div class="breadcrumb-column col-lg-6 col-md-12 col-sm-12">
                <h1>Houston Durga Bari Society</h1>
                <!-- <h3>
                    <?php
                    $currentYear = date('Y');
                    $nextYear = date('Y') + 1;
                    echo "" . $currentYear . " - " . $nextYear . " Puja Merchandise ";
                    ?>
                </h3> -->

                <h3>25th Anniversary Puja</h3>
                <h3>Payment for Puja Merchandise</h3>
                <ul class="bread-crumb clearfix">
                    <li><a style="text-decoration:none;color:#fff;" href="#">Home</a></li>
                    <li class="active">Puja Merchandise</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<br><br>
<div?php require_once VIEWS_PATH . 'Layouts/admin/error_notice.php' ; ?>


    <form id="edit_Pujafoodcoupondata" class="frm-class booking-frm-class" 
        action="<?php echo INSTALL_URL; ?>pujaMerchandise/pujaMerchandise" method="post" name="pujafoodcoupon">
        <div id="otp-admin-bypass" style="display:none;"><?php echo ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isMerchandiseEditor()) ? '1' : '0'; ?></div>
        <div id="otp-session-verified" style="display:none;"><?php
            $otpVerifiedMember = $_SESSION['otp_verified_member'] ?? '';
            echo htmlspecialchars(is_array($otpVerifiedMember) ? ($otpVerifiedMember['member_id'] ?? '') : $otpVerifiedMember, ENT_QUOTES, 'UTF-8');
        ?></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-md-8 col-sm-12">

                    <div style="border-left: 3px solid #03a9f4; border-right: 3px solid #03a9f4; padding: 10px; border-bottom: 3px solid #03a9f4;"
                        class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <select required="" name="regmember" id="registrationmember" class="choice"
                                aria-required="true" aria-invalid="false" onchange="membercheck(this)">
                                <option value="">Returning or New User *</option>
                                <option value="member">Returning User</option>
                                <option value="nonmember">New User</option>
                            </select>
                            <div class="text_placeholders">Returning or New User *</div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12" id="otp-verified-banner" style="display:none;margin:12px 0;"></div>


                        <div id="termdiv" class="col-lg-12 col-md-12 col-sm-12">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <input type="text" style="display:none" name="termMember" id="termMember"
                                    placeholder="search member here...." class="MIDtext2">
                                <input type="text" name="term" id="term" placeholder="search records here....*"
                                    class="MIDtext2">
                                <div class="text_placeholders">Search by : First Name, Last Name, Zip, MID *</div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <input id="idmem" class="MIDtext2readonly" type="text" name="member_id" size="25"
                                    value="" title="<?php echo __('Member Id'); ?>" placeholder="Verified Member ID *"
                                    readonly>
                                <div class="text_placeholders">Verified Member ID *</div>
                            </div>

                        </div>



                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <input readonly id="first_name" class="MIDtext2" type="text" name="F_Name" size="25" value=""
                                title="<?php echo __('First Name'); ?>" placeholder="First Name *" required="">
                            <div class="text_placeholders">First Name *</div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <input readonly id="second_name" class="MIDtext2" type="text" name="L_Name" size="25" value=""
                                title="<?php echo __('Last Name'); ?>" placeholder="Last Name*" required="">
                            <div class="text_placeholders">Last Name *</div>
                        </div>


                        <div  class="col-lg-6 col-md-6 col-sm-6">
                            <input readonly id="SF_name" class="MIDtext2" type="text" name="SFirst_Name" size="25" value=""
                                title="<?php echo __('Spouse First Name'); ?>" placeholder="Spouse First Name">
                            <div class="text_placeholders">Spouse First Name </div>
                        </div>

                        <div  class="col-lg-6 col-md-6 col-sm-6">
                            <input readonly id="SL_name" class="MIDtext2" type="text" name="SLast_Name" size="25" value=""
                                title="<?php echo __('Spouse Last Name'); ?>" placeholder="Spouse Last Name">
                            <div class="text_placeholders">Spouse Last Name </div>
                        </div>


                        <div  class="col-lg-12 col-md-12 col-sm-12">
                            <input readonly id="fullAddress" class="MIDtext2" type="text" name="fullAddress" value="" required=""
                                title="<?php echo __('Full Address'); ?>" placeholder="Full Address *">
                            <div class="text_placeholders">Full Address *</div>
                        </div>

                        <div  class="col-lg-4 col-md-4 col-sm-4">
                            <input readonly id="city" class="MIDtext2" type="text" name="City" size="25" value=""
                                title="<?php echo __('City'); ?>" placeholder="City *" required="">
                            <div class="text_placeholders">City *</div>
                        </div>
                        <div  class="col-lg-4 col-md-4 col-sm-4">
                            <input readonly id="state" class="MIDtext2" type="text" name="State" size="25"
                                value="<?php echo ($tpl['arr'] ?? [])['state'] ?? ''; ?>" title="<?php echo __('State'); ?>"
                                placeholder="State *" required="">
                            <div class="text_placeholders">State *</div>
                        </div>

                        <div  class="col-lg-4 col-md-4 col-sm-4">
                            <input readonly id="zip" class="MIDtext2" type="text" name="Zip" size="25" value="" required=""
                                title="<?php echo __('Zip_Code'); ?>" placeholder="Zip Code *">
                            <div class="text_placeholders">Zip Code *</div>
                        </div>

                        <div  class="col-lg-6 col-md-6 col-sm-6">
                            <input readonly id="phone" class="MIDtext2" type="text" name="phone" size="25" value="" title="phone"
                                onchange="checkmobileno(this.id)" maxlength="10" placeholder="##########" required="">
                            <div class="text_placeholders">Mobile Number *</div>
                        </div>

                        <div  class="col-lg-6 col-md-6 col-sm-6">
                            <input readonly id="email" required="" class="MIDtext2" type="text" name="email" size="25" value=""
                                title="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" placeholder="name@company.com">
                            <div class="text_placeholders">Email ID *</div>
                        </div>


                        <!-- saree punjabi -->


                        <div style="margin-top: 5rem;">

                            <h1>Saree and Punjabi Selection</h1>

                            <div style="margin-top: 2rem;" id="sareepunjabiConatiner">

                                <div id="saree_Box">

                                    <h2>Saree</h2>
                                    <div>

                                        <div id="sareeNameDiv">

                                            <div style="margin-left: 9rem;">Saree Tussar</div>
                                            <div>Saree Terracotta</div>
                                        </div>

                                        <div class="sareeImageContainer">
                                            <!-- Default Image for punjabi -->

                                            <img style="width: 100%; height: 100%; object-fit: cover;" id="sareeImage"
                                                src="../images/clothes/sdA.jpg" alt="saree">

                                            <img style="width: 100%; height: 100%; object-fit: cover;" id="sareeImage"
                                                src="../images/clothes/sdB.jpg" alt="saree">

                                        </div>

                                        <div
                                            style="display: flex; column-gap: 18rem; font-size:  14px; margin-bottom: 0.5rem;">
                                            
                                            <div id="sareeTusharPrice" style="margin-left: 7rem;"> </div>
                                            <div id="sareeTerracottaPrice"></div>

                                        </div>


                                        <select name="saree_name" class="choice6" id="sareeType"
                                            onchange="handleSareeTypeChange()">

                                            <option value="" disabled selected>--Select--</option>

                                            <?php
                                            foreach (($tpl['AllClothData'] ?? []) as $value => $details) {

                                                if ($details['cloth_type'] == "saree") {
                                                    $clothname = "";

                                                    if ($details['cloth_name'] == "saree_terracotta") {
                                                        $clothname = "Saree Terracotta";
                                                    }
                                                    if ($details['cloth_name'] == "saree_tussar") {
                                                        $clothname = "Saree Tussar";
                                                    }

                                                    $price = "";
                                                    if ($tpl['deadLinePassed']) {
                                                        $price = $details['price_regular'];


                                                    } else {
                                                        $price = $details['price_early'];

                                                    }


                                                    echo "<option value='{$details['cloth_name']}' 
                                                data-price='{$price}'
                                               

                                                data-image='{$details['image_path']}'>
                                                {$clothname}
                                         </option>";

                                                }

                                            }
                                            ?>

                                            <option value="both">Both</option>
                                            <option value="none">None</option>
                                        </select>
                                        <div class="text_placeholders">Choose a Saree Type *</div>

                                        <div style="display: flex;  justify-content: space-between;">

                                            <div>
                                                <div id="saree_tussarQtyField" style="margin-top: 1rem; display: none;">

                                                    <input name="saree_tussar_qty" class="MIDtext2" type="number"
                                                        id="saree_tussarQty" value="1"
                                                        max="<?php echo htmlspecialchars($tpl['saree_tussar_limit']); ?>"
                                                        min="1" onchange="calculateTotal()">
                                                    <div class="text_placeholders"> Saree Tussar Quantity:</div>

                                                    <div style="font-size: 1.7rem;">
                                                        <span>Total Saree Tussar price</span>
                                                        <span class="price-label" id="saree_tussarPriceLabel"></span>
                                                    </div>
                                                    
                                                     <input type="hidden" name="sarre_tussar_amount" id="tussarAmount">

                                                </div>
                                            </div>
                                            <div>

                                                <div id="saree_terracottaQtyField"
                                                    style="margin-top: 1rem; display: none;">

                                                    <input name="saree_terracotta_qty" class="MIDtext2" type="number"
                                                        id="saree_terracottaQty" value="1"
                                                        max="<?php echo htmlspecialchars($tpl['saree_terracotta_limit']); ?>"
                                                        min="1" onchange="calculateTotal()">
                                                    <div class="text_placeholders"> Saree Terracotta Quantity:</div>

                                                    <div style="font-size: 1.7rem;">
                                                        <span>Total Saree Terracotta price</span>
                                                        <span class="price-label"
                                                            id="saree_terracottaPriceLabel"></span>
                                                    </div>
                                                    
                                                     <input type="hidden" name="sarre_terracotta_amount"
                                                        id="terracottaAmount">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="punjabi_box">

                                    <h2>Punjabi</h2>
                                    <div style="margin-bottom: 2rem;">
                                         <div id="punjabiNameDiv">
                                            <div id="whiteRedPunjabi" >Punjabi White-Red</div>
                                            <div>Punjabi Beige-Red</div>
                                        </div>

                                        <div class="sareeImageContainer">
                                            <!-- Default Image for punjabi -->
                                            <img style="width: 100%; height: 100%; object-fit: cover;" id="punjabiImage"
                                                src="../images/clothes/pdA.jpg" alt="punjabi">

                                            <img style="width: 100%; height: 100%; object-fit: cover;" id="punjabiImage"
                                                src="../images/clothes/pdB.jpg" alt="punjabi">
                                        </div>


                                        <div
                                            style="display: flex; column-gap: 13rem; font-size:  14px; margin-bottom: 0.5rem;">
                                            <div id="punjabiWhiteRed" style="margin-left: 7rem;"></div>
                                            <div id="punjabiBeigeRed"></div>

                                        </div>
                                        
                                        <select name="punjabi_name" class="choice6" id="punjabiType"
                                            onchange="handlepunjabiTypeChange()">

                                            <option value="" disabled selected>--Select--</option>

                                            <?php
                                            foreach (($tpl['AllClothData'] ?? []) as $value => $details) {

                                                if ($details['cloth_type'] == "punjabi") {
                                                    $clothname = "";

                                                    if ($details['cloth_name'] == "punjabi_beige_red") {
                                                        $clothname = "Punjabi Beige-Red";
                                                    }
                                                    if ($details['cloth_name'] == "punjabi_white_red") {
                                                        $clothname = "Punjabi White-Red";
                                                    }

                                                    $price = "";
                                                    if ($tpl['deadLinePassed']) {
                                                        $price = $details['price_regular'];
                                                    } else {
                                                        $price = $details['price_early'];
                                                    }


                                                    echo "<option value='{$details['cloth_name']}' 
                                                data-price='{$price}' 
                                                data-image='{$details['image_path']}'>
                                                {$clothname}
                                         </option>";

                                                }

                                            }
                                            ?>

                                            <option value="both">Both</option>
                                            <option value="none">None</option>

                                        </select>
                                        <div class="text_placeholders">Choose a Punjabi Type *</div>


                                        <div style="display: flex; justify-content: space-between;">

                                            <div>
                                                <div id="punjabi_white_redFields"
                                                    style="margin-top: 1rem; display: none;">


                                                    <input name="punjabi_white_red_qty" class="MIDtext2" type="number"
                                                        id="punjabi_white_redQty" value="1"
                                                        max="<?php echo htmlspecialchars($tpl['punjabi_white_red_limit']); ?>"
                                                        min="1" onchange="calculateTotal()">
                                                    <div class="text_placeholders"> Punjabi White-Red Quantity:</div>

                                                    <select name="punjabi_white_red_size" class="choice6"
                                                        id="size-select">

                                                        <option value="S">Small</option>
                                                        <option value="M">Medium</option>
                                                        <option value="L">Large</option>
                                                        <option value="XL">Extra Large</option>
                                                    </select>
                                                    <div class="text_placeholders"> Punjabi White-Red Size:</div>


                                                    <div style="font-size: 1.7rem;">
                                                        <span>Total Punjabi White-Red Price </span>
                                                        <span class="price-label"
                                                            id="punjabi_white_redPriceLabel"></span>
                                                    </div>
                                                    <input type="hidden" name="punjabi_white_red_amount"
                                                        id="punjabi_white_redAmount">


                                                </div>
                                            </div>

                                            <div>
                                                <div id="punjabi_beige_redFields"
                                                    style="margin-top: 1rem; display: none;">



                                                    <input name="punjabi_beige_red_qty" class="MIDtext2" type="number"
                                                        id="punjabi_beige_redQty" value="1"
                                                        max="<?php echo htmlspecialchars($tpl['punjabi_beige_red_limit']); ?>"
                                                        min="1" onchange="calculateTotal()">
                                                    <div class="text_placeholders">Punjabi Beige-Red Quantity:</div>



                                                    <select name="punjabi_beige_red_size" class="choice6"
                                                        id="size-select">

                                                        <option value="S">Small</option>
                                                        <option value="M">Medium</option>
                                                        <option value="L">Large</option>
                                                        <option value="XL">Extra Large</option>
                                                    </select>
                                                    <div class="text_placeholders"> Punjabi Beige-Red Size:</div>


                                                    <div style="font-size: 1.7rem;">
                                                        <span>Total Punjabi Beige-Red Price </span>
                                                        <span class="price-label"
                                                            id="punjabi_beige_redPriceLabel"></span>

                                                    </div>
                                                    
                                                     <input type="hidden" name="punjabi_beige_red_amount"
                                                        id="punjabi_beige_redAmount">

                                                </div>
                                            </div>

                                        </div>

                                        
                                        
                                         <div style="display: flex; justify-content: center;">
                                            <div class="sizebtn" onclick="openModal()">Show Punjabi Size Chart</div>
                                        </div>

                                        <div class="modal" id="sizeModal">
                                            <div class="modal-content">
                                                <span class="close-btn" onclick="closeModal()">&times;</span>
                                                <h2>PUNJABI SIZE CHART</h2>
                                                <table id = "sizeTable">
                                                    <tr>
                                                        <th>SIZE</th>
                                                        <th >SHOULDER (Inches)</th>
                                                        <th>Range (Inches)</th>
                                                        <th>CHEST (Inches)</th>
                                                        <th>Range (Inches)</th>
                                                        <th>LENGTH (Inches)</th>
                                                    </tr>
                                                    <tr>
                                                        <td>SMALL (S)</td>
                                                        <td>17</td>
                                                        <td>17.5-18.5</td>
                                                        <td>21</td>
                                                        <td>20.5-21.5</td>
                                                        <td>38</td>
                                                    </tr>

                                                    <tr>
                                                        <td>MEDIUM (M)</td>
                                                        <td>18</td>
                                                        <td>18.5-19.5</td>
                                                        <td>22</td>
                                                        <td>21.5-22.5</td>
                                                        <td>40</td>
                                                    </tr>
                                                    <tr>
                                                        <td>LARGE (L)</td>
                                                        <td>19</td>
                                                        <td>18.5-19.5</td>
                                                        <td>23</td>
                                                        <td>22.5-23.5</td>
                                                        <td>42</td>
                                                    </tr>
                                                    <tr>
                                                        <td>X-LARGE (XL)</td>
                                                        <td>20</td>
                                                        <td>19.5-20.5</td>
                                                        <td>24</td>
                                                        <td>23.5-24.5</td>
                                                        <td>42</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <!-- saree punjabi -->


                        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom: 30px;">
                            <input data-rule-required="true" id="totalcost" class="MIDtext2readonly" type="number"
                                name="amount" size="25" value="" title="Amount" placeholder="$ Amount *" readonly>
                            <div class="text_placeholders">Requested Amount to Pay ($) *</div>
                        </div>

                        <?php if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isMerchandiseEditor()) { ?>

                            <div class="col-lg-12 col-md-12 col-sm-12" id="paymentdropdown">


                                <select name="PaymentOption" id="PaymentOption" class="choice" required>
                                    <option value="">Please Select Payment Method *</option>
                                    <option value="check">Check</option>
                                    <option value="cash">Cash</option>
                                    <option value="directdeposit">Online Deposit</option>
                                    <option value="stripe">Credit card</option>
                                    <option value="others">Zelle </option>
                                    <option value="sumup">Sumup</option>
                                </select>
                                <div class="text_placeholders">Payment Method *</div>
                            </div>
                            <?php
                        } ?>

                        <?php if (!($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isMerchandiseEditor())) { ?>

                            <div class="col-lg-12 col-md-12 col-sm-12" id="paymentdropdown">
                                <select name="PaymentOption" id="PaymentOption" class="choice" required>
                                    <option value="">Please Select Payment Method *</option>

                                    <option value="stripe">Credit card</option>
                                    <option value="others">Zelle</option>

                                </select>
                                <div class="text_placeholders">Payment Method *</div>
                            </div>

                        <?php } ?>

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
                                            <input data-rule-required='true' id="confirm_code"
                                                class="form-control input-sm" type="text" name="confirm_code" size="25"
                                                value="" title="<?php echo __('confirm_code'); ?>"
                                                placeholder="<?php echo __('confirm_code'); ?>" style="<?php echo ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isMerchandiseEditor()) ? '' : 'display:none;'; ?>">
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
                                                if ($this->controller->isAdmin() || $this->controller->isEditor() || $this->controller->isMerchandiseEditor()) {
                                                foreach (($tpl['Amount'] ?? []) as $key => $value) {
                                                    ?>

                                                    <option value="<?php echo $value['Amount']; ?>">
                                                        <?php echo $value['Amount']; ?>
                                                    </option>
                                                    <?php
                                                    //echo '<option value="'.$value['Amount'].'">'.$value['Amount']. '</option>';
                                                }
                                                }
                                                ?>
                                            </select>
                                            <div id="zelle-manual-fields" style="display:none;margin-top:15px;">
                                                <button type="button" id="zelleLookupBtn" class="btn btn-danger">Get Zelle Payment Details</button>
                                                <div class="form-group" style="margin-top:10px;">
                                                    <label for="zelle_donor_name">Your name as used in Zelle:</label>
                                                    <input type="text" id="zelle_donor_name" class="form-control input-sm" autocomplete="off">
                                                </div>
                                                <div class="form-group">
                                                    <label for="zelle_date">Zelle payment date:</label>
                                                    <input type="date" id="zelle_date" class="form-control input-sm">
                                                </div>
                                                <div id="zelle-no-match" style="display:none;color:#c0392b;font-weight:600;margin-top:10px;">No matching Zelle payment found. Check your Zelle name, amount, and payment date, then try again.</div>
                                            </div>
                                            <div id="zelle-action-btns" style="display:none;margin-top:10px;">
                                                <button type="button" id="verifySelectedZelle" class="btn btn-success">Verify Selected Transaction</button>
                                                <button type="button" id="searchZelleManual" class="btn btn-default">Search Manually</button>
                                            </div>
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
                                <table class="table table-bordered table-hover table-striped"
                                    style="margin-top: -88px;">
                                    <thead>
                                        <tr>
                                            <th>Bank Name</th>
                                            <th>Check No</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Deposit Account</th>
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

                                            <td class="td"><select name="CheckDepositAccount" class="accountDropdown">
                                                    <option value="PujaAccount">Puja Account</option>
                                                    <option value="RegularAccount">Regular Account</option>
                                                </select>
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
                                <table class="table table-bordered table-hover table-striped"
                                    style="margin-top: -88px;">
                                    <thead>
                                        <tr>
                                            <th>Processed By</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Deposit Account</th>
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

                                            <td class="td"><select name="CashDepositAccount" class="accountDropdown">
                                                    <option value="PujaAccount">Puja Account</option>
                                                    <option value="RegularAccount">Regular Account</option>
                                                </select>
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
                                <table class="table table-bordered table-hover table-striped"
                                    style="margin-top: -88px;">
                                    <thead>
                                        <tr>
                                            <th>Financial Entity</th>
                                            <th>Transaction Code</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Deposit Account</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="td"><input style="WIDTH: 100%;" type="text" id="bankname"
                                                    name="BankName" class="form-control input-sm" value=""></td>
                                            <td class="td"><input style="WIDTH: 100%;" type="text" id="ISFCCode"
                                                    name="ISFCCode" class="form-control input-sm" value=""></td>
                                            <td class="td"><input style="WIDTH: 100%;" type="number" id="directamount"
                                                    name="directamount" class="form-control input-sm" value=""></td>
                                            <td class="td"><input style="WIDTH: 100%;" type="date"
                                                    id="directdepositdate" name="transactiondate"
                                                    class="form-control input-sm" value="">
                                            </td>


                                            <td class="td"><select name="DirectPayDepositAccount" class="accountDropdown">
                                                    <option value="PujaAccount">Puja Account</option>
                                                    <option value="RegularAccount">Regular Account</option>
                                                </select>
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

                                    <td class="td"><select name="SumUpDepositAccount" class="accountDropdown">
                                            <option value="PujaAccount">Puja Account</option>
                                            <option value="RegularAccount">Regular Account</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- End -->

                        <div style="margin-top: 2rem; line-height: 2rem; padding: 0 2rem;">
                            <label style="color: red; font-weight: 500; font-size: 2rem; line-height: 2rem;">
                                <input type="checkbox" name="policy_accept" id="policyCheckbox" required
                                    style="margin-right: 8px;">
                                <span>
                                    I agree that the merchandise I have ordered is final. I also understand
                                    that once ordered - return, replacement or refund of payment will not
                                    be allowed.
                                </span>
                            </label>
                        </div>


                        <tr style="display:none;">
                            <td class="td" style="display:none;"> <input id="paydesc" class="form-control input-sm"
                                    type="text" name="paydesc" style="display:none;"> </td>
                        </tr>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <input id="Zellecode" class="form-control input-sm" type="text" name="code"
                                style="display:none;">
                            <!-- <input type="hidden" name="create_Pujafoodcoupon" value="1" /> -->
                            <!-- <button id="submit" class="btn btn-primary" autocomplete="off" value="Save" name="Payment"
                        tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;
                        <?php echo __('save'); ?>
                    </button> -->

                            <div style="display: flex; justify-content: space-between; margin-bottom: 3rem;">
                                <button onclick="return confirm('Please ensure the information provided is correct. If you want to review/update any information, please click Cancel button or press OK for the final submission.')" id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save"
                                    name="Payment" tabindex="17" type="submit" disabled>
                                    <i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Make Payment
                                </button>

                                <button id="reset_btn_id" class="btn btn-primary" autocomplete="off" name="reset"
                                    tabindex="17" type="reset"><i class="fa fa-fw fa-refresh"></i>&nbsp;&nbsp;
                                    Reset</button>
                            </div>




                            <!-- <button id="reset_btn_id" class="btn btn-primary" autocomplete="off" type="reset" tabindex="18">
                            <i class="fa fa-fw fa-refresh"></i>&nbsp;&nbsp;Reset Form
                        </button> -->
                        </div>
                    </div>

                    <div>


                        <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                        <div style="display: none;"  id="stripe_secret_key_id" style="">
                        <?php echo $tpl['option_arr_values']['stripe_publish_key']; ?>
                    </div> 

                        

                    </div>

                </div>

                <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">

                    <aside class="sidebar">

                        <div class="sidebar-widget help-widget">
                            <!-- <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                <a style="font-size: 24px; text-decoration: none;color:#000; font-weight:600;"
                                    href="<?php echo INSTALL_URL; ?>donationdata/index">Go Back to Dashboard</a>
                                <br><br>
                            <?php } ?> -->
                            <div class="sidebar-title">
                                <h2><span style="color: #03a9f4;">General</span> Guidelines</h2>
                            </div>
                            <div class="widget-content">
                                <div class="text">1. Search your membership records using your membership number, first
                                    name
                                    or last name
                                    </div>

                                <div class="text">2. If using the system for the first time, create a new record for
                                    yourself (if there is a conflict with existing phone number or email, the system
                                    will
                                    not complete the process)
                                </div>

                                <div class="text">3. Select the type(s) and quantities of Sarees and/or Punjabis. For
                                    Punjabis, specify the size(s)
                                </div>
                                <div class="text">4. Rates are subject to change based on prevailing taxes, tariffs and
                                    duties as well as shipping/freight rates. Once ordered, the rates are final. No
                                    returns
                                    or exchanges are allowed.
                                </div>
                                <div class="text">5. Public site for payment by credit card and zelle. Contact any of
                                    the
                                    Team members if you want to pay by cash or check
                                </div>

                                <div class="text">6. Check your spam folder if you don’t receive the transaction
                                    confirmation by email </div>

                            </div>
                        </div>



                        <!-- Help Widget -->

                        <div style="margin-top: 2rem;" class="sidebar-widget help-widget">
                            <div class="sidebar-title">
                                <h2><span style="color: #03a9f4;">Need</span> Help?</h2>
                            </div>
                            <div class="widget-content">
                                <div class="text">If you have any questions, please contact us</div>
                                <p style="padding-bottom:30px;"><span><i class="fa fa-envelope"
                                            aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;"
                                        href="mailto: pujamerchandise@durgabari.org"> pujamerchandise@durgabari.org</a>
                                </p>
                                <!-- <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;" href="tel:+18326909062"> <strong style="font-size:26px;">+1 832-690-9062</strong> <br><span style="font-size:20px;color:#000;">Joy Mitra</span></a></p>-->
                                <!--<p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a-->
                                <!--        style="color:#000;text-decoration:none;" href="tel:+18322055665"> <strong-->
                                <!--            style="font-size:26px;"> +1 832-205-5665-->
                                <!--        </strong> <br><span style="font-size:20px;color:#000;"> Amit Bhaduri</span></a>-->
                                <!--</p>-->

                                <!--<p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a-->
                                <!--        style="color:#000;text-decoration:none;" href="tel:+18326770860"> <strong-->
                                <!--            style="font-size:26px;"> +1 832-677-0860</strong> <br><span-->
                                <!--            style="font-size:20px;color:#000;">Subhas Das</span></a></p>-->


                                <p style="margin-bottom: 2.5rem;"><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                        style="color:#000;text-decoration:none;" href="tel:+18326772722"> <strong
                                            style="font-size:26px;"> +1-832-677-2722</strong> <br><span
                                            style="font-size:20px;color:#000;">Malobika Das</span></a></p>

                                <p style="margin-bottom: 2.5rem;"><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                        style="color:#000;text-decoration:none;" href="tel:+ 12815082847"> <strong
                                            style="font-size:26px;"> +1-281-508-2847</strong> <br><span
                                            style="font-size:20px;color:#000;">Jharna Sarkar</span></a></p>

                                <p style="margin-bottom: 2.5rem;"><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                        style="color:#000;text-decoration:none;" href="tel:+17135179406"> <strong
                                            style="font-size:26px;"> +1-713-517-9406</strong> <br><span
                                            style="font-size:20px;color:#000;">Rituparna Roy</span></a></p>

                            </div>
                        </div>

                    </aside>
                </div>

            </div>

        </div>

    </form>
    <?php require __DIR__ . '/../components/otp_modal.php'; ?>

    <div id="dialogSlots" title="<?php echo __('tooltip_selected_slots'); ?>" style="display:none">
        <div name="dialogSlotsDivId" id="dialogSlotsDivId">
        </div>
    </div>

    <script>
        function fillMerchandiseReturningUserFromOtp(memberId) {
            $('#otp-session-verified').text(memberId || '');
            $('#registrationmember').val('member');
            $('#termdiv').show();
            $('#termMember').val(memberId || '');
            $('#term').val('Verified Member ' + (memberId || '')).prop('readonly', true).attr('autocomplete', 'off');
            if (typeof MemberSelectdonation === 'function') {
                MemberSelectdonation();
            }
            $('#otp-verified-banner').show().html('<div style="background:#eafaf1;border:1px solid #b7e4c7;color:#1e8449;border-radius:5px;font-size:13px;font-weight:600;padding:8px 12px;">Returning user verified and details auto-filled.</div>');
        }

        function openMerchandiseReturningUserOtp() {
            if ($.trim($('#otp-admin-bypass').text() || '') === '1') {
                return true;
            }
            if (typeof window.OtpMemberVerify === 'undefined') {
                alert('OTP verification is not available. Please refresh and try again.');
                return false;
            }
            window.OtpMemberVerify.open({
                onVerified: function (memberId) {
                    fillMerchandiseReturningUserFromOtp(memberId);
                }
            });
            window.onOtpModalCancelled = function () {
                $('#registrationmember').val('');
                $('#termdiv').hide();
            };
            return true;
        }

        $(document).on('keydown focus paste input', '#term', function (event) {
            if ($('#registrationmember').val() === 'member' && $.trim($('#otp-admin-bypass').text() || '') !== '1') {
                event.preventDefault();
                $(this).blur();
                return false;
            }
        });

        $(document).on('change', '#registrationmember', function () {
            if ($(this).val() === 'member' && $.trim($('#otp-admin-bypass').text() || '') !== '1') {
                setTimeout(function () {
                    var verifiedMemberId = $.trim($('#otp-session-verified').text() || '');
                    if (verifiedMemberId) {
                        fillMerchandiseReturningUserFromOtp(verifiedMemberId);
                    } else {
                        openMerchandiseReturningUserOtp();
                    }
                }, 0);
            }
        });
    
    
    
        // function confirmSubmit() {
        //     alert("Are you sure you want to submit? Once submitted, You cannot change this later.")
        // }
    
    
    
    
        // Checkphoneno
        function checkmobileno(elem) {

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

        function membercheck() {




            // var selectedString = select.options[select.selectedIndex].value;
            var checkdata = $("#registrationmember").val();
            //var checkdata = selectedString;



            if (checkdata == "member") {
                //$('#term option:not(:selected)').attr('disabled', false);
                document.getElementById('termdiv').style.display = "block";
                
                 document.getElementById("first_name").readOnly = true;
                document.getElementById("second_name").readOnly = true;
                document.getElementById("phone").readOnly = true;
                document.getElementById("email").readOnly = true;
                document.getElementById("state").readOnly = true;
                document.getElementById("city").readOnly = true;
                document.getElementById("zip").readOnly = true;
                document.getElementById("SF_name").readOnly = true;
                document.getElementById("SL_name").readOnly = true;
                document.getElementById("fullAddress").readOnly = true;
               

            } else {
                document.getElementById('termdiv').style.display = "none";
                document.getElementById('SF_name').value = "";
                document.getElementById('SL_name').value = "";

                document.getElementById('fullAddress').value = "";
                
                document.getElementById("first_name").readOnly = false;
                document.getElementById("second_name").readOnly = false;
                document.getElementById("phone").readOnly = false;
                document.getElementById("email").readOnly = false;
                document.getElementById("state").readOnly = false;
                document.getElementById("city").readOnly = false;
                document.getElementById("zip").readOnly = false;
                document.getElementById("SF_name").readOnly = false;
                document.getElementById("SL_name").readOnly = false;
                document.getElementById("fullAddress").readOnly = false;

              
            }

            document.getElementById('punjabiType').selectedIndex = 0;

            document.getElementById("sareeType").selectedIndex = 0;

            handleSareeTypeChange()
            handlepunjabiTypeChange()

        }

        $(function () {

            $("#term").autocomplete({
                source: '<?php echo INSTALL_URL; ?>ajax-db-search.php',
                select: function (event, ui) {
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
            $("#first_name").val('');
			$("#second_name").val('');
			$("#phone").val('');
			$("#email").val('');
			$("#state").val('');
			$("#city").val('');
			$("#zip").val('');
			$("#SF_name").val('');
			$("#SL_name").val('');
			$("#fullAddress").val('');
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

                            let MemberName = "";
                            const memberNameElement = $(res).filter("input#MemberName");
                            if (memberNameElement.length) {
                                MemberName = memberNameElement[0].value;
                            }
                            if(MemberName != ""){
                                document.getElementById("first_name").value = MemberName;
                                $('#first_name').prop('readonly', true);
                            }
                            else{
                                $('#first_name').prop('readonly', false);
                            }

                            let LastName = "";
                            const LastNameElement = $(res).filter("input#last_name");
                            if (LastNameElement.length) {
                                LastName = LastNameElement[0].value;
                            }
                            if(LastName != ""){
                                document.getElementById("second_name").value = LastName;
                                $('#second_name').prop('readonly', true);
                            }
                            else{
                                $('#second_name').prop('readonly', false);
                            }
                            

                            let memberid = "";
                            const memberElement = $(res).filter("input#memberid");
                            if (memberElement.length) {
                                memberid = memberElement[0].value;
                            }
                            document.getElementById("idmem").value = memberid;

                            let phoneNo = "";
                            let MNo = "";
                            let new_phone = "";
                            const phoneNoElement = $(res).filter("input#phone_work");
                            if (phoneNoElement.length) {
                                phoneNo = phoneNoElement[0].value;
                                phoneNo = phoneNo.replace("-", "");
                                MNo = phoneNo;
                                MNo = MNo.replace("-", "");
                            }
                            new_phone = MNo.replace(/[-)(]/g, "");
                            if(new_phone != ""){
                                document.getElementById("phone").value = new_phone;
                                $('#phone').prop('readonly', true);
                            }
                            else{
                                $('#phone').prop('readonly', false);
                            }
                            

                            let email = "";
                            const emailElement = $(res).filter("input#email");
                            if (emailElement.length) {
                                email = emailElement[0].value;
                            }
                            if(email != ""){
                                document.getElementById("email").value = email;
                                $('#email').prop('readonly', true);
                            }
                            else{
                                $('#email').prop('readonly', false);
                            }
                            
                            let state = "";
                            const stateElement = $(res).filter("input#state");
                            if (stateElement.length) {
                                state = stateElement[0].value;
                            }
                            if(state.trim() != ""){
                                document.getElementById("state").value = state;
                                $('#state').prop('readonly', true);
                            }
                            else{
                                $('#state').prop('readonly', false);
                            }
                            
                            let city = "";
                            const cityElement = $(res).filter("input#city");
                            if (cityElement.length) {
                                city = cityElement[0].value;
                            }
                            if(city.trim() != ""){
                                document.getElementById("city").value = city;
                                $('#city').prop('readonly', true);
                            }
                            else{
                                $('#city').prop('readonly', false);
                            }

                            let zipcode = "";
                            const zipcodeElement = $(res).filter("input#zip_code");
                            if (zipcodeElement.length) {
                                zipcode = zipcodeElement[0].value;
                            }
                            if(zipcode.trim() != ""){
                                document.getElementById("zip").value = zipcode;
                                $('#zip').prop('readonly', true);
                            }
                            else{
                                $('#zip').prop('readonly', false);
                            }
                           
                            let spouseFirstName = "";
                            const spouseFirstNameElement = $(res).filter("input#Spouse");
                            if (spouseFirstNameElement.length) {
                                spouseFirstName = spouseFirstNameElement[0].value;
                            }
                            if(spouseFirstName != ""){
                                document.getElementById("SF_name").value = spouseFirstName;
                                $('#SF_name').prop('readonly', true);
                            }
                            else{
                                $('#SF_name').prop('readonly', false);
                            }
                            
                            let spouseLastName = "";
                            const spouseLastNameElement = $(res).filter("input#Spouselast");
                            if (spouseLastNameElement.length) {
                                spouseLastName = spouseLastNameElement[0].value;
                            }
                            if(spouseLastName != ""){
                                document.getElementById("SL_name").value = spouseLastName;
                                $('#SL_name').prop('readonly', true);
                            }
                            else{
                                $('#SL_name').prop('readonly', false);
                            }
                            

                            let fullAddress = "";
                            const residentalAddress = $(res).filter("input#ressidentalAddress").val() || "";
                            const address = $(res).filter("input#Address").val() || "";
                            const unitAddress = $(res).filter("input#unitAddress").val() || "";
                            let completeAddress = `${residentalAddress} ${address} ${unitAddress}`.trim();
                            if (completeAddress.length) {
                                fullAddress = completeAddress;
                            }
                            if(fullAddress != ""){
                                document.getElementById("fullAddress").value = fullAddress;
                                $('#fullAddress').prop('readonly', true);
                            }
                            else{
                                $('#fullAddress').prop('readonly', false);
                            }
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
                    $("#SF_Name").val("");
                    $("#SL_Name").val("");
                    $("#fullAddress").val("");
                }
            }
        }


        $('input:checkbox[id=chkLunch]').on('ifChecked', function (event) {
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

        $('input:checkbox[id=chkLunch]').on('ifUnchecked', function (event) {
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



        $('input:checkbox[id=chkDinner]').on('ifChecked', function (event) {
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

        $('input:checkbox[id=chkDinner]').on('ifUnchecked', function (event) {
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

        $('input:checkbox[id=chkAdult]').on('ifChecked', function (event) {
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

        $('input:checkbox[id=chkAdult]').on('ifUnchecked', function (event) {
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

        $('input:checkbox[id=chkAdultOutsourced]').on('ifChecked', function (event) {
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

        $('input:checkbox[id=chkAdultOutsourced]').on('ifUnchecked', function (event) {
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

        $('input:checkbox[id=chkAdultspecial]').on('ifChecked', function (event) {
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

        $('input:checkbox[id=chkAdultspecial]').on('ifUnchecked', function (event) {
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

        $('input:checkbox[id=chkKid]').on('ifChecked', function (event) {
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

        $('input:checkbox[id=chkKid]').on('ifUnchecked', function (event) {
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

        $('input:checkbox[id=chkKidOutsourced]').on('ifChecked', function (event) {
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

        $('input:checkbox[id=chkKidOutsourced]').on('ifUnchecked', function (event) {
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

        $('input:checkbox[id=chkKidspecial]').on('ifChecked', function (event) {
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

        $('input:checkbox[id=chkKidspecial]').on('ifUnchecked', function (event) {
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

        $(document).ready(function () {
            if ($.trim($('#otp-admin-bypass').text() || '') === '1') {
                document.querySelector('#registrationmember').value = "member";
            } else {
                var verifiedMemberId = $.trim($('#otp-session-verified').text() || '');
                if (verifiedMemberId) {
                    document.querySelector('#registrationmember').value = "member";
                    setTimeout(function () {
                        fillMerchandiseReturningUserFromOtp(verifiedMemberId);
                    }, 0);
                }
            }
        });



// saree kurta js 
        const sareeTypeSelect = document.getElementById("sareeType");
        // const sareeImage = document.getElementById("sareeImage");
        const saree_terracottaQtyDiv = document.getElementById("saree_terracottaQtyField");
        const saree_tussarQtyDiv = document.getElementById("saree_tussarQtyField");

        const saree_terracottaQtyInput = document.getElementById("saree_terracottaQty");
        const saree_tussarQtyInput = document.getElementById("saree_tussarQty");

        const saree_terracottaPriceLabel = document.getElementById("saree_terracottaPriceLabel");
        const saree_tussarPriceLabel = document.getElementById("saree_tussarPriceLabel");



        const punjabiTypeSelect = document.getElementById("punjabiType");
        // const punjabiImage = document.getElementById("punjabiImage");

        const punjabi_beige_redDiv = document.getElementById("punjabi_beige_redFields");
        const punjabi_white_redDiv = document.getElementById("punjabi_white_redFields");

        const punjabi_beige_redQtyInput = document.getElementById("punjabi_beige_redQty");
        const punjabi_white_redQtyInput = document.getElementById("punjabi_white_redQty");

        const punjabi_beige_redPriceLabel = document.getElementById("punjabi_beige_redPriceLabel");
        const punjabi_white_redPriceLabel = document.getElementById("punjabi_white_redPriceLabel");

        // const totalPriceSpan = document.getElementById("totalPrice");


        let punjabi_beige_redPrice = ""
        // let punjabi_beige_redimg = ""

        let punjabi_white_redPrice = ""
        // let punjabi_white_redimg = ""


        let saree_terracottaPrice = ""
        let saree_terracottaimg = ""

        let saree_tussarPrice = ""
        let saree_tussarimg = ""
        
          let punjabiWhiteRedAmount = document.getElementById("punjabi_white_redAmount");
        let punjabiBeigeRedAmount = document.getElementById("punjabi_beige_redAmount");
        let terracottaAmount = document.getElementById("terracottaAmount");
        let tussarAmount = document.getElementById("tussarAmount");



        const punjabiElement = document.getElementById("punjabiType");
        const options = punjabiElement.options;
        for (let i = 0; i < options.length; i++) {
            if (options[i].value === "punjabi_beige_red") {
                punjabi_beige_redPrice = options[i].getAttribute("data-price");
                // punjabi_beige_redimg = options[i].getAttribute("data-image");



                // document.getElementById("punjabiBeigeRed").innerText = `Punjabi Beige-Red price - $  ${punjabi_beige_redPrice} `

            }
            if (options[i].value === "punjabi_white_red") {
                punjabi_white_redPrice = options[i].getAttribute("data-price");
                // punjabi_white_redimg = options[i].getAttribute("data-image");
                // document.getElementById("punjabiWhiteRed").innerText = `Punjabi White-Red price - $  ${punjabi_white_redPrice} `
            }
        }


        const sareeElement = document.getElementById("sareeType");
        const SareeOptions = sareeElement.options;
        for (let i = 0; i < SareeOptions.length; i++) {
            if (SareeOptions[i].value === "saree_terracotta") {
                saree_terracottaPrice = SareeOptions[i].getAttribute("data-price");
                // saree_terracottaimg = SareeOptions[i].getAttribute("data-image");

                // document.getElementById("sareeTerracottaPrice").innerText = `Saree Terracotta price - $  ${saree_terracottaPrice} `



            }
            if (SareeOptions[i].value === "saree_tussar") {
                saree_tussarPrice = SareeOptions[i].getAttribute("data-price");
                // saree_tussarimg = SareeOptions[i].getAttribute("data-image");

                // document.getElementById("sareeTusharPrice").innerText = `Saree Tussar price - $  ${saree_tussarPrice} `

            }
        }

        // console.log(punjabi_beige_redPrice, punjabi_beige_redimg, punjabi_white_redPrice, punjabi_white_redimg, saree_terracottaPrice, saree_terracottaimg, saree_tussarPrice, saree_tussarimg)




        function handleSareeTypeChange() {
            const type = sareeTypeSelect.value;

           let img = "<?php echo INSTALL_URL; ?>images/clothes/sdA.jpg"

            // Reset saree image & fields
            // sareeImage.src = img;
            saree_terracottaQtyDiv.style.display = "none";
            saree_tussarQtyDiv.style.display = "none";
            saree_terracottaPriceLabel.textContent = "";
            saree_tussarPriceLabel.textContent = "";

            saree_terracottaQtyInput.value = 1
            saree_tussarQtyInput.value = 1

            if (type === "saree_terracotta") {
                // sareeImage.src = `http://localhost:8080/HDBS_Payment/pujaModule/${saree_terracottaimg}`;
                saree_terracottaQtyDiv.style.display = "block";
            } else if (type === "saree_tussar") {
                // sareeImage.src = `http://localhost:8080/HDBS_Payment/pujaModule/${saree_tussarimg}`;
                saree_tussarQtyDiv.style.display = "block";
            } else if (type === "both") {
                // sareeImage.src = img;
                saree_terracottaQtyDiv.style.display = "block";
                saree_tussarQtyDiv.style.display = "block";
            }



            calculateTotal();
        }

        function handlepunjabiTypeChange() {
            const type = punjabiTypeSelect.value;
            let img = "<?php echo INSTALL_URL; ?>images/clothes/pdA.jpg"
            // punjabiImage.src = img;
            punjabi_beige_redDiv.style.display = "none";
            punjabi_white_redDiv.style.display = "none";
            punjabi_beige_redPriceLabel.textContent = "";
            punjabi_white_redPriceLabel.textContent = "";

            punjabi_beige_redQtyInput.value = 1
            punjabi_white_redQtyInput.value = 1
            if (type === "punjabi_beige_red") {
                // punjabiImage.src = `http://localhost:8080/HDBS_Payment/pujaModule/${punjabi_beige_redimg}`;
                punjabi_beige_redDiv.style.display = "block";
            } else if (type === "punjabi_white_red") {
                // punjabiImage.src = `http://localhost:8080/HDBS_Payment/pujaModule/${punjabi_white_redimg}`;
                punjabi_white_redDiv.style.display = "block";
            } else if (type === "both") {
                // punjabiImage.src = img;
                punjabi_beige_redDiv.style.display = "block";
                punjabi_white_redDiv.style.display = "block";
            }

            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;

            // Helper function to validate a field
            function validateInput(input) {
                const value = parseInt(input.value);
                const min = parseInt(input.min);
                const max = parseInt(input.max);

                if (isNaN(value)) {
                    alert("Please enter a valid number.");
                    input.value = min;
                    return min;
                }

                if (value < min) {
                    alert(`Value  cannot be less than ${min}.`);
                    input.value = min;
                    return min;
                }

                if (value > max) {
                    alert(`Value  cannot be more than ${max}.`);
                    input.value = max;
                    return max;
                }

                return value;
            }

            // terracotta Saree
            if (sareeTypeSelect.value === "saree_terracotta" || sareeTypeSelect.value === "both") {
                const qty = validateInput(saree_terracottaQtyInput);
                const price = qty * saree_terracottaPrice;
                total += price;
                saree_terracottaPriceLabel.textContent = `- $ ${price}`;
                terracottaAmount.value = price
            }

            // Btussar Saree
            if (sareeTypeSelect.value === "saree_tussar" || sareeTypeSelect.value === "both") {
                const qty = validateInput(saree_tussarQtyInput);
                const price = qty * saree_tussarPrice;
                total += price;
                saree_tussarPriceLabel.textContent = ` - $ ${price}`;
                 tussarAmount.value = price
            }

            // beige red punjabi
            if (punjabiTypeSelect.value === "punjabi_beige_red" || punjabiTypeSelect.value === "both") {
                const qty = validateInput(punjabi_beige_redQtyInput);
                const price = qty * punjabi_beige_redPrice;
                total += price;
                punjabi_beige_redPriceLabel.textContent = ` - $ ${price}`;
                 punjabiBeigeRedAmount.value = price;
            }
 
            // white red punjabi
            if (punjabiTypeSelect.value === "punjabi_white_red" || punjabiTypeSelect.value === "both") {
                const qty = validateInput(punjabi_white_redQtyInput);
                const price = qty * punjabi_white_redPrice;
                total += price;
                punjabi_white_redPriceLabel.textContent = `- $ ${price}`;
                punjabiWhiteRedAmount.value = price;
            }

            document.getElementById("totalcost").value = total;
        }









        function openModal() {
            document.getElementById("sizeModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("sizeModal").style.display = "none";
        }

        window.onclick = function (event) {
            var modal = document.getElementById("sizeModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }







    </script>
