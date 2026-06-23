<head>
    <title>Puja Food Coupons Request</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    
    <script>

        function InvalidMsg(textbox) {
            var selectValmember = $('#registrationmember').val();
            if (selectValmember != "nonmember") {
                if (textbox.value === '') {
                    textbox.setCustomValidity('Please search the name in the autocomplete of member name and select name.');
                    $('#demmember').addClass('point')

                } else {
                    textbox.setCustomValidity('');
                    $('#demmember').addClass('point')
                }
            } else {
                textbox.setCustomValidity('');
                $('#demmember').addClass('point')
            }
            return true;

        }
    </script>
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .point {
            pointer-events: none;
            opacity: 0.3;
        }

        .body {
            padding: 0px;
            margin: 0px;
        }

        .logo .profile {
            margin-left: 50%;
            border-radius: 25%;
            transform: translate(-50%);
            filter: brightness(123%);
            padding: 10px;

        }

        .logo .logo-caption {
            font-family: 'Poiret One', cursive;
            color: #FFFFFF;
            text-align: center;

        }

        .logo-caption .h1 {
            font-size: 2.5rem;
            ;
        }

        h3 {

            /* font-size:30px; */
            color: #FFFFFF;
            font-weight: 400;
            margin-left: 4%;
            font-family: initial;
            line-height: normal;
        }

        h4 {
            text-align: center;
            color: #FFFFFF;
            font-family: initial;
        }

        .logo .tweak {
            color: #ff5252;
            font-weight: bold;
        }

        .abd {
            font-weight: bold;
            font-family: 'Poiret One', cursive;
            font-size: 20px;
            color: 00000;
        }

        .btn-custom {
            background: #ff5252;
            border-color: rgba(48, 46, 45, 1);
            color: #ffffff;
            font-weight: bold;
            font-size: 20px;
            width: -webkit-fill-available;
        }

        .btn-custom:hover {
            -webkit-transition: all 500ms ease;
            -moz-transition: all 500ms ease;
            -ms-transition: all 500ms ease;
            -o-transition: all 500ms ease;
            transition: all 500ms ease;
            background: rgba(48, 46, 45, 1);
            border-color: #ff5252;
        }

        .footer {
            padding-top: 10px;
            margin-left: 15%;
            width: 85%;
            background: #111111;
            position: relative;
            bottom: 0;
            z-index: 1;
        }

        .form-group label {
            display: inline-block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            background-color: #f9fcfa;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgb(0 0 0 / 8%) inset;
            color: #555;
            display: block;
            font-size: 14px;
            height: 34px;
            line-height: 1.42857;
            padding: 6px 12px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
            width: 100%;
        }

        .form-horizontal .form-group {
            margin: 10px;
        }

        .asb {
            border-width: 0;
            border: 0 none;
            margin: 0;
            padding: 0;
        }

        .text-center {
            text-align: center;
        }

        .btn.btn-primary {
            background-color: #00a5c5;
            border-color: #367fa9;
            color: #fff;
            font-size: 20px;
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
            font-size: 24px;
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

        input.MIDtext3 {
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

        .col-md-4.phone {
            padding-top: 20px;
        }

        .col-md-12.state {
            padding-top: 20px;
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
            /*margin-top: -30px;*/

        }

        .modal-content {
            width: 80% !important;
            margin: 160px auto auto auto !important;
        }

        .input-sm {
            font-size: 16px !important;
        }

        @media screen and (max-width: 992px) {
            #menu-container {
                width: 90% !important;
            }
        }

        /* .disabledbutton {
    pointer-events: none;
    opacity: 0.4;
} */

        /* dropdown popup css */

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }


        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        input.MIDtext3 {
            width: 100%;
        }

        /* end */


        /* Extra small devices (phones, 600px and down) */
        @media only screen and (max-width: 600px) {
            select.choice {
                width: 100%;
            }

            input.MIDtext3 {
                width: 100%;
            }

            input.MIDtext2 {
                width: 355px;
            }

            .col-sm-4 input.MIDtext2 {
                width: 238px;
            }

            .city {
                width: 33%;
            }

            .state {
                width: 33%;
            }

            .zip {
                width: 33%;
            }

            .city .MIDtext2 {
                width: 100%;
            }

            .state .MIDtext2 {
                width: 100%;
            }

            .zip .MIDtext2 {
                width: 100%;
            }

            input.number {
                width: 355px;
            }

            .col-md-6.phone {
                padding-top: 20px;
            }

            input#total {
                width: 355px;
            }

            input#phone {
                width: 355px;
            }

            input#zip_code {
                width: 224px;
            }
        }

        /* Small devices (portrait tablets and large phones, 600px and up) */
        @media only screen and (min-width: 600px) {
            select.choice {
                width: 100%;
            }

            input.MIDtext3 {
                width: 100%;
            }

            input.MIDtext2 {
                width: 355px;
            }

            .col-sm-4 input.MIDtext2 {
                width: 238px;
            }

            .city {
                width: 33%;
            }

            .state {
                width: 33%;
            }

            .zip {
                width: 33%;
            }

            .city .MIDtext2 {
                width: 100%;
            }

            .state .MIDtext2 {
                width: 100%;
            }

            .zip .MIDtext2 {
                width: 100%;
            }

            input.number {
                width: 355px;
            }

            .col-md-6.phone {
                padding-top: 20px;
            }

            input#total {
                width: 355px;
            }

            input#phone {
                width: 356px;
            }

            input#zip_code {
                width: 224px;
            }
        }

        /* Medium devices (landscape tablets, 768px and up) */
        @media only screen and (min-width: 768px) {}

        /* Large devices (laptops/desktops, 992px and up) */
        @media only screen and (min-width: 992px) {
            select.choice {
                width: 462px;
            }

            input.MIDtext3 {
                width: 100%;
            }

            input.MIDtext2 {
                width: 462px;
            }

            input.number {
                width: 462px;
            }

            .col-md-6.phone {
                padding-top: 20px;
            }

            input#total {
                width: 302px;
            }
        }

        /* Extra large devices (large laptops and desktops, 1200px and up) */
        @media only screen and (min-width: 1200px) {
            select.choice {
                width: 100%;
            }

            input.MIDtext3 {
                width: 100%;
            }

            input.MIDtext2 {
                width: 100%;
            }

            input.number {
                width: 100%;
            }

            .col-md-6.phone {
                padding-top: 20px;
            }

            input#total {
                width: 100%;
            }

            input#phone {
                width: 368px;
            }

            input#memphone2fam {
                width: 368px;
            }
        }

        /* 
        Button style
        Author: Anmol Singh
         */
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

        .page-title {
            margin: 12px 0 0px !important;
        }
    </style>


<section class="page-title" style="background-image:url(<?php echo INSTALL_URL; ?>12.jpg);">
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
                    <h3>
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
                    <h3>Puja Food Coupon Request</h3>
                    <ul class="bread-crumb clearfix">
                         <li style="text-decoration:none;color:#fff;">Home</li>
                        <li class="active">Food Coupon</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div style="position: relative;padding: 0px 0px 60px;" class="container">
        <div class="row">

            <div class="col-lg-8 col-md-12 col-sm-12" style="padding:0px;">
                <div id="page-body"
                    style="border-left: 3px solid #ef260f;border-right: 3px solid #ef260f;border-bottom: 3px solid #ef260f; padding: 2rem;">
                    <form id="foodCoupon-frm-id" class="form-horizontal" method="post" action="" role="form">
                        <input type="hidden" name="create_FoodCouponRequest" value="1" />
                        <div id="otp-admin-bypass" style="display:none;"><?php echo ($this->controller->isAdmin() || $this->controller->isEditor()) ? '1' : '0'; ?></div>
                        <div id="otp-session-verified" style="display:none;"><?php
                            $otpVerifiedMember = $_SESSION['otp_verified_member'] ?? '';
                            echo htmlspecialchars(is_array($otpVerifiedMember) ? ($otpVerifiedMember['member_id'] ?? '') : $otpVerifiedMember, ENT_QUOTES, 'UTF-8');
                        ?></div>
                        <fieldset class="asb">

                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select required="" name="regmember" id="registrationmember" class="choice"
                                        aria-required="true" aria-invalid="false" tabindex="1"
                                        onchange="removeRecordOnChange()">
                                        <option value="">Returning or New User</option>
                                        <option value="member">Returning User</option>
                                        <option value="nonmember">New User</option>
                                    </select>
                                    <div class="text_placeholders">Returning or New User *</div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12" id="otp-verified-banner" style="display:none;margin:12px 0;"></div>

                                <div id="IDMembertd" class="col-lg-6 col-md-6 col-sm-6 disabledbutton">
                                    <input type="text" name="term" id="term" placeholder="search records here.... *"
                                        class="MIDtext3" tabindex="2" required>
                                    <div class="text_placeholders">Search by : First Name, Last Name, Zip, MID *
                                    </div>
                                </div>

                                <input type="text" style="display:none" name="termMember" id="termMember"
                                    placeholder="search member here...." class="MIDtext2 form-control">

                                <div class="col-lg-6 col-md-6 col-sm-6" id="memberiddiv">
                                    <input type="text" name='demmember' id="demmember" class="MIDtext2 point"
                                        oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);">
                                    <div class="text_placeholders">Member ID</div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12" id="membercategorydiv">
                                    <select required="" name="sessionCode" id="ddlCouponType" class="choice"
                                        aria-required="true" aria-invalid="false">
                                        <?php
                                        foreach (($tpl['foodcoupon'] ?? []) as $value) {
                                            ?>
                                            <option value="<?php echo $value['sessionCode']; ?>">
                                                <span style="font-size: 10px;">
                                                    <?php echo $value['sessionName']; ?>
                                                </span>
                                            </option>
                                            <?php
                                        } ?>
                                    </select>
                                    <input type="hidden" name="sessionName" id="selectedSessionName" value="">
                                    <div class="text_placeholders">Coupon Type</div>
                                </div>

                                <!-- Add new field for split first name and last name  -->

                                <div class="col-lg-6 col-md-4 col-sm-6" id="fnamediv">
                                    <input type="text" name='F_Name' id="First_name" placeholder="First Name"
                                        class="MIDtext2" required>
                                    <div class="text_placeholders">First Name *</div>
                                </div>


                                <div class="col-lg-6 col-md-4 col-sm-6" id="lnamediv">
                                    <input type="text" name='L_Name' id="last_name" placeholder="Last Name*"
                                        class="MIDtext2" required>
                                    <div class="text_placeholders">Last Name *</div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-4" id="citydiv">
                                    <input id="city" class="MIDtext2" type="text" name="City" size="25" value=""
                                        placeholder="City *" tabindex="7" required="">
                                    <div class="text_placeholders">City *</div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-4" id="statediv">
                                    <input id="state" class="MIDtext2" type="text" name="State" size="25" value=""
                                        placeholder="State *" tabindex="7" required="">
                                    <div class="text_placeholders">State *</div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4" id="zipdiv">
                                    <input id="zip_code" class="MIDtext2" type="text" placeholder="Zip Code *" value=""
                                        name="Zip" tabindex="9" required="">
                                    <div class="text_placeholders">Zip Code *</div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 phone" id="phonenodiv">
                                    <input id="phone" class="MIDtext2readonly" type="text" required=""
                                        placeholder="##########" value="" name="phone" onchange="sponsoramount(this.id)"
                                        maxlength="10" tabindex="11">
                                    <div class="text_placeholders">Phone Number *</div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6" id="emaildiv">
                                    <input required="" id="email" class="MIDtext2readonly" type="text"
                                        placeholder="name@company.com" value="" name="email" tabindex="11"
                                        pattern="[^@\s]+@[^@\s]+\.[^@\s]+">
                                    <div class="text_placeholders">Email *</div>
                                </div>
                                 <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input id="adultCoupon" class="MIDtext2" type="number"
                                         value="" name="Adult_Coupon_Req" 
                                        max="4" onchange="maxAdultCoupon()">
                                    <div class="text_placeholders">Adult Coupon # </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 ">
                                    <input id="kidCoupon" class="MIDtext2" type="number"
                                         value="" name="Kid_Coupon_Req"
                                        max="3" onchange="maxKidCoupon()">
                                    <div class="text_placeholders">Child/ Student Coupon # </div>
                                </div>
                            </div>
                            <div class="row" id="submitdatadiv">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <button id="reset-btn-id" class="go_cart_btn btn" autocomplete="off" value="Save"
                                        name="Reset" tabindex="16" type="submit"><i
                                            class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Reset</button>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <button id="submit_btn_id" class="go_cart_btn btn" autocomplete="off" value="Save"
                                        name="submit" tabindex="17" type="submit"><i
                                            class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Submit</button>
                                </div>

                            </div>
                    </form>
                    <?php require __DIR__ . '/../components/otp_modal.php'; ?>
                </div>

            </div>

            <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                <aside class="sidebar">
                    <div class="sidebar-widget help-widget">
                         <div class="sidebar-title">
                                <h2><span style="color: #ef260f;">General</span> Guidelines</h2>
                            </div>
                            <div class="widget-content">
                                <div class="text">1. Use this system to submit requests for food coupons.</div>
                                <div class="text">2. Food coupon type (Adult, Kid, Student) and numbers will be asked for during the payment process. </div>
                                <div class="text">3. Food coupons prices vary by session and type. Ask the Registration team for prices for the current session.</div>
                                <div class="text">4. Food coupons are not guaranteed. It will depend on availability and distributed on a first come first served basis.</div>
                                <div class="text">5. While the sequence of submission will be considered (among other factors), the person needs to be present at the time of actual distribution. Else, it will go to the next in queue.</div>
                            </div>
                        <div class="sidebar-title">
                            <h2><span style="color: #ef260f;">Need</span> Help?</h2>
                        </div>
                        <div class="widget-content">
                            <div class="text">If you have any questions, please contact us</div>
                            <p style="padding-bottom:30px;"><span><i class="fa fa-envelope"
                                        aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;"
                                    href="mailto:registration@durgabari.org"> registration@durgabari.org</a></p>
                        </div>
                    </div>

                </aside>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            updateHiddenField();
        });
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
            preferredCountries: ["us", "co", "in", "de"],
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        $(function () {
            $('input[type="text"]').change(function () {
                this.value = $.trim(this.value);
            });
        });

        ////Lookup.......................Start..............................////
        $(function () {
            $("#term").autocomplete({
                //source: "http://localhost/NewFoodCoupon/ajax-db-search.php",
                source: '<?php echo INSTALL_URL; ?>ajax-db-search.php',
                select: function (event, ui) {
                    event.preventDefault();
                    var name = ui.item.value;
                    var f_name = name.split(",");
                    $("#term").val(f_name[0]);
                    $("#termMember").val(ui.item.id);
                    getMemberRecordDetails(this);
                },
                onclick: function (event, ui) {
                    event.preventDefault();
                    var name = ui.item.value;
                    var f_name = name.split(",");
                    $("#term").val(f_name[0]);
                    $("#termMember").val(ui.item.id);
                    getMemberRecordDetails();
                },
                onchange: function (event, ui) {
                    event.preventDefault();
                    var name = ui.item.value;
                    var f_name = name.split(",");
                    $("#term").val(f_name[0]);
                    $("#termMember").val(ui.item.id);
                    getMemberRecordDetails();
                },
            });
        });
        ////Lookup.......................End..............................////

        function optionreq() {

            if (GdSelect != null) {
                document.getElementById('MemberName').required = true;
                document.getElementById('Street').required = true;
                document.getElementById('Tele1').required = true;
                document.getElementById('email').required = true;
                document.getElementById('PaymentOption').required = true;
                document.getElementById('zip_code').required = true;
                document.getElementById('state').required = true;
                document.getElementById('city').required = true;
                document.getElementsByClassName("form-control input-sm").required = true;

            } else {
                document.getElementById('MemberName').required = false;
                document.getElementById('Street').required = false;
                document.getElementById('Tele1').required = true;
                document.getElementById('email').required = true;
                document.getElementById('PaymentOption').required = false;
                document.getElementById('zip_code').required = false;
                document.getElementById('state').required = false;
                document.getElementById('city').required = false;
                document.getElementsByClassName("form-control input-sm").required = false;
            }
        }

        $('#demmember').keydown(function (e) {
            e.preventDefault();
            return false;
        });

        //for replcase all special character from input field
        $('#term').on('input', function () {
            $(this).val($(this).val().replace(/[^a-z0-9]/gi, ''));
        });

        function fillFoodCouponReturningUserFromOtp(memberId) {
            $('#otp-session-verified').text(memberId || '');
            $('#registrationmember').val('member');
            $('#IDMembertd').show().removeClass('disabledbutton');
            $('#memberiddiv').show();
            $('#termMember').val(memberId || '');
            $('#term').val('Verified Member ' + (memberId || '')).prop('readonly', true).attr('autocomplete', 'off');
            if (typeof getMemberRecordDetails === 'function') {
                getMemberRecordDetails();
            }
            $('#otp-verified-banner').show().html('<div style="background:#eafaf1;border:1px solid #b7e4c7;color:#1e8449;border-radius:5px;font-size:13px;font-weight:600;padding:8px 12px;">Returning user verified and details auto-filled.</div>');
        }

        function openFoodCouponReturningUserOtp() {
            if ($.trim($('#otp-admin-bypass').text() || '') === '1') {
                return true;
            }
            if (typeof window.OtpMemberVerify === 'undefined') {
                alert('OTP verification is not available. Please refresh and try again.');
                return false;
            }
            window.OtpMemberVerify.open({
                onVerified: function (memberId) {
                    fillFoodCouponReturningUserFromOtp(memberId);
                }
            });
            window.onOtpModalCancelled = function () {
                $('#registrationmember').val('');
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
                        fillFoodCouponReturningUserFromOtp(verifiedMemberId);
                    } else {
                        openFoodCouponReturningUserOtp();
                    }
                }, 0);
            }
        });

        //validate phone no 
        function sponsoramount(elem) {
            //
            const phonenumber = $("#phone").val();
            if (!!phonenumber) {
                if (isNaN(phonenumber)) {
                    alert("Please Enter mobile Number");
                    $("#payment_btn_id").addClass('disabled');
                    //document.getElementById("totalamount").value = price; 
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

        //Set autocomplete value 
        function getMemberRecordDetails(e) {
            var url2 = $("#container-abc-url-id").text();
            var self = this;
            var data = $("#termMember").val();
            var term = $("#term").val();
            $("#total").val("");
            $("#futureytd").val("");
            $('#msgdiv').hide();
            $('#sponsorcheck').hide();
            $('#phone').prop('readonly', false);
            $('#email').prop('readonly', false);

            if (term != "") {
                const Memberid = data.split("-");
                if (term.trim() != "") {
                    $.ajax({
                        type: "POST",
                        data: {
                            memberid: data
                        },
                        url: url2 + "load.php?controller=PujaDonations&action=AllMemberNew",
                        success: function (res) {
                            let MemberName = "";
                            const memberNameElement = $(res).filter("input#MemberName");
                            if (memberNameElement.length) {
                                MemberName = memberNameElement[0].value;
                                //10julyupdate
                                if (MemberName == "") {
                                    $('#First_name').prop('readonly', false);
                                }
                                else {
                                    $('#First_name').prop('readonly', true);
                                }
                            }

                            let memberMname = "";
                            const memberMnameElement = $(res).filter("input#middle_name");
                            if (memberMnameElement.length) {
                                memberMname = memberMnameElement[0].value;
                            }

                            if (memberMname != "") {
                                document.getElementById("First_name").value = MemberName.concat(" ", memberMname);
                            } else {
                                document.getElementById("First_name").value = MemberName;
                            }

                            let LastName = "";
                            const LastNameElement = $(res).filter("input#last_name");
                            if (LastNameElement.length) {
                                LastName = LastNameElement[0].value;
                                //10julyupdate
                                if (LastName == "") {
                                    $('#last_name').prop('readonly', false);
                                }
                                else {
                                    $('#last_name').prop('readonly', true);
                                }
                            }
                            document.getElementById("last_name").value = LastName;

                            let memberid = "";
                            const memberElement = $(res).filter("input#memberid");
                            if (memberElement.length) {
                                memberid = memberElement[0].value;
                            }
                            document.getElementById("demmember").value = memberid;

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
                            document.getElementById("zip_code").value = zipcode;

                            let phoneNo = "";
                            const phoneNoElement = $(res).filter("input#Tele1");
                            if (phoneNoElement.length) {
                                phonetext = phoneNoElement[0].value;
                                phoneNo = phonetext.trim();
                                if (phoneNo != "") {
                                    $('#phone').prop('readonly', true);
                                    $('#phone').addClass('MIDtext2readonly');
                                }
                                else {
                                    $('#phone').prop('readonly', false);
                                    $('#phone').removeClass('MIDtext2readonly')
                                    $('#phone').addClass('MIDtext2');
                                }
                            }
                            new_phone = phoneNo.replace(/[-)(]/g, "");
                            document.getElementById("phone").value = new_phone;

                            let email = "";
                            const emailElement = $(res).filter("input#email");
                            if (emailElement.length) {
                                email = emailElement[0].value;
                                if (email != "") {
                                    $('#email').prop('readonly', true);
                                    $('#email').addClass('MIDtext2readonly');
                                }
                                else {
                                    $('#email').prop('readonly', false);
                                    $('#email').removeClass('MIDtext2readonly')
                                    $('#email').addClass('MIDtext2');
                                }

                            }
                            document.getElementById("email").value = email;
                        }

                    });
                } else {
                    $("#MemberName").val("");
                    $("#phone").val("");
                    $("#email").val("");
                    $("#First_name").val("");
                    $("#last_name").val("");
                    $("#memberid").val("");
                    $("#state").val("");
                    $("#city").val("");
                    $("#zip_code").val("");
                }
            }
        }

        //on change for existing member and new member dropdon
        function removeRecordOnChange() {
            var regmember = $("#registrationmember").val();
            selectVal = $('#registrationmember').val();
            $('#phone').prop('readonly', false);
            $('#email').prop('readonly', false);
            //add 11 july
            $('#memphone2fam').prop('readonly', false);
            if (selectVal == "member") {
                $("#IDMembertd").removeClass("disabledbutton");
                document.getElementById("First_name").value = "";
                document.getElementById("last_name").value = "";

                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";


                document.getElementById("term").value = "";
                document.getElementById("demmember").value = "";
                $('#IDMembertd').show();
                $("#term").prop('required', true);
                $("#demmember").prop('required', true);
                $('#phone').addClass('MIDtext2readonly');
                $('#email').addClass('MIDtext2readonly');

                //add 10 july
                $('#IDMembertd').show();
                $('#memberiddiv').show();
                $('#First_name').prop('readonly', true);
                $('#last_name').prop('readonly', true);

            }
            if (selectVal == "nonmember") {
                $("#IDMembertd").addClass("disabledbutton");
                document.getElementById("First_name").value = "";
                document.getElementById("last_name").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("term").value = "";
                document.getElementById("demmember").value = "";
                $('#IDMembertd').hide();
                $("#term").prop('required', false);
                $("#demmember").prop('required', false);
                $('#phone').removeClass('MIDtext2readonly')
                $('#phone').addClass('MIDtext2');
                $('#email').removeClass('MIDtext2readonly')
                $('#email').addClass('MIDtext2');

                $('#IDMembertd').hide();
                $('#memberiddiv').hide();
                $('#First_name').prop('readonly', false);
                $('#last_name').prop('readonly', false);

            }
            if (selectVal == "" || selectVal == " ") {
                document.getElementById("demmember").value = "";
                document.getElementById("First_name").value = "";
                document.getElementById("last_name").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                $('#phone').addClass('MIDtext2readonly');
                $('#email').addClass('MIDtext2readonly');
            }
        }

        $("#reset-btn-id").on('click', function () {
            $('#foodCoupon-frm-id')[0].reset();
        });

        const hiddenField = document.getElementById('selectedSessionName');
        const dropdown = document.getElementById('ddlCouponType');
        const form = document.getElementById('foodCoupon-frm-id');

        function updateHiddenField() {
            const selectedText = dropdown.options[dropdown.selectedIndex].text;
            hiddenField.value = selectedText;
        }

        form.addEventListener('submit', function () {
            updateHiddenField();
        });
    </script>
