<head>
    <title>Puja Donations</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"  crossorigin="anonymous"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>  -->

    <!-- multiselect uses layout jQuery — no CDN override -->

    <script>

        function InvalidMsg(textbox) {
            //debugger

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
        #eventone>div>div.multiselect-dropdown {
            display: none;
        }

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
    </style>
    <?php
    if (!empty($_POST['create_donation'])) {
        $event = $tpl['Eventdata']['EventName'] ?? '';

        ?>
        <section class="content left width_100">
            <div class="padding-19 nav-tabs-custom left width_100" style="text-align: -webkit-center;">
                <?php
                if (!empty($_SESSION['status'])) {
                    ?>
                    <div class="alert alert-danger in">
                        <strong><?php echo $_SESSION['status']; ?></strong>
                    </div>
                    <?php
                    unset($_SESSION['status']);
                } else {
                    // if ($_POST['PaymentOption'] == 'stripe')
                    if (($tpl['arr'] ?? [])['PaymentOption'] ?? '' != "" && ($tpl['arr'] ?? [])['payment_status'] ?? '' == 'succeeded') {
                        $alldonationdata = $tpl['arr'];
                        $notregister = "General Donor";
                        $dataregister = $_SESSION['memberregisterpuja'];
                        $newytd = $_SESSION['ytdvalue'];
                        $donationid = $_SESSION['donationid'];
                        $membertype = $_SESSION['membercategory'];
                        $pujaregistered = $_SESSION['pujareg'];
                        $sponsoreventfirst = $_SESSION['sponsoreventfirst'];
                        $sponsoreventsecond = $_SESSION['sponsoreventsecond'];
                        $memberid = ($tpl['arr'] ?? [])['Member_id'] ?? '';
                        $paydate = ($tpl['arr'] ?? [])['pay_date'] ?? '';
                        $paymentmethod = ($tpl['arr'] ?? [])['PaymentOption'] ?? '';
                        $pujaYtdTiers = $tpl['puja_ytd_tiers'] ?? array();
                        $pujaYtdTiers = is_array($pujaYtdTiers) ? $pujaYtdTiers : array();
                        $pujaDonationTierValue = function ($tier, $key, $default = null) {
                            if (is_array($tier)) {
                                return $tier[$key] ?? $default;
                            }
                            if (is_object($tier)) {
                                return $tier->{$key} ?? $default;
                            }
                            return $default;
                        };
                        $pujaDonationGetTier = function ($amount) use ($pujaYtdTiers) {
                            $value = is_numeric($amount) ? (float) $amount : 0;
                            foreach ($pujaYtdTiers as $tier) {
                                if (!is_array($tier) && !is_object($tier)) {
                                    continue;
                                }
                                $minRaw = is_array($tier) ? ($tier['min_amount'] ?? null) : ($tier->min_amount ?? null);
                                $maxRaw = is_array($tier) ? ($tier['max_amount'] ?? null) : ($tier->max_amount ?? null);
                                $tierName = is_array($tier) ? ($tier['tier_name'] ?? '') : ($tier->tier_name ?? '');
                                $min = is_numeric($minRaw) ? (float) $minRaw : 0;
                                $max = ($maxRaw === null || $maxRaw === '') ? null : (float) $maxRaw;
                                if ($value >= $min && ($max === null || $value <= $max)) {
                                    return strtolower(trim((string) $tierName));
                                }
                            }
                            return '';
                        };
                        $pujaDonationTierIs = function ($amount, $names) use ($pujaDonationGetTier) {
                            return in_array($pujaDonationGetTier($amount), (array) $names, true);
                        };
                        $pujaDonationTierMin = function ($name, $fallback) use ($pujaYtdTiers, $pujaDonationTierValue) {
                            $name = strtolower($name);
                            foreach ($pujaYtdTiers as $tier) {
                                $minAmount = $pujaDonationTierValue($tier, 'min_amount');
                                if (strtolower(trim((string) $pujaDonationTierValue($tier, 'tier_name', ''))) === $name && is_numeric($minAmount)) {
                                    return (float) $minAmount;
                                }
                            }
                            return (float) $fallback;
                        };
                        $pujaDonationEmeraldMax = function () use ($pujaYtdTiers, $pujaDonationTierValue) {
                            foreach ($pujaYtdTiers as $tier) {
                                $maxAmount = $pujaDonationTierValue($tier, 'max_amount');
                                if (strtolower(trim((string) $pujaDonationTierValue($tier, 'tier_name', ''))) === 'emerald' && is_numeric($maxAmount)) {
                                    return (float) $maxAmount;
                                }
                            }
                            return 4559;
                        };
                        $pujaDonationDiamondMin = $pujaDonationTierMin('diamond', 5000);
                        $pujaDonationDoubleDiamondMin = $pujaDonationDiamondMin * 2;
                        $pujaDonationReceiptYtd = $newytd;
                        if ($dataregister == 'true' && $pujaregistered == 'true' && $newytd >= $pujaDonationEmeraldMax() && $newytd < $pujaDonationDiamondMin) {
                            $pujaDonationReceiptYtd = $pujaDonationDiamondMin;
                        }
                        $pujaDonationTierLabel = function ($name, $fallback) use ($pujaYtdTiers, $pujaDonationTierValue) {
                            $name = strtolower($name);
                            foreach ($pujaYtdTiers as $tier) {
                                if (strtolower(trim((string) $pujaDonationTierValue($tier, 'tier_name', ''))) === $name) {
                                    $minRaw = $pujaDonationTierValue($tier, 'min_amount');
                                    $maxRaw = $pujaDonationTierValue($tier, 'max_amount');
                                    $min = is_numeric($minRaw) ? (int) $minRaw : null;
                                    if ($min === null) {
                                        return $fallback;
                                    }
                                    if ($maxRaw === null || $maxRaw === '') {
                                        return '$' . $min . '+';
                                    }
                                    return '$' . $min . ' - $' . (int) $maxRaw;
                                }
                            }
                            return $fallback;
                        };

                        $pujaregisteredfirstattempt = $_SESSION['pujasankalpaattempt1arr'];
                        $pujaregisteredsecondattempt = $_SESSION['pujasankalpaattempt2arr'];

                        if ($paymentmethod == 'stripe') {
                            $paymentdata = 'Credit Card';
                        } else if ($paymentmethod == "others") {
                            $paymentdata = 'Zelle';
                        } else if ($paymentmethod == "zelleProxy") {
                            $paymentdata = 'Zelle Proxy';
                        } else if ($paymentmethod == "cash") {
                            $paymentdata = 'Cash';
                        } else if ($paymentmethod == "check") {
                            $paymentdata = 'Check';
                        } else if ($paymentmethod == "directdeposit") {
                            $paymentdata = 'Direct Deposit';
                        } else if ($paymentmethod == "sumup") {
                            $paymentdata = 'SumUp';
                        }

                        ?>
                        <table border="4" width='585px'>
                            <tr>
                                <!-- <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> </tr> -->
                                <!-- <td colspan='2'> <img src='../create.png' alt='' height='102px' ></td>-->
                                <td colspan='2'> <img src='<?php echo INSTALL_URL; ?>thankyouscreen.jpg' alt='' height='167px'
                                        style="margin-left:12em;">
                                    <h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari
                                            Society</b></h1>
                                </td>

                            </tr>
                            <tr>
                            <tr>
                                <td style="width:50%;">Order ID</td>
                                <td style="width:50%;"><?php echo ($tpl['arr'] ?? [])['oid'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>Member Id</td>
                                <td><?php echo ($tpl['arr'] ?? [])['Member_id'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><?php echo ($tpl['arr'] ?? [])['MemberName'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>Donation Amount</td>
                                <td><span style="color:red;">$</span><?php echo ($tpl['arr'] ?? [])['Amount'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>Payment Method</td>
                                <td><?php echo $paymentdata; ?></td>
                            </tr>
                            <tr>
                                <td>Purpose</td>
                                <td><?php echo ($tpl['arr'] ?? [])['purpose'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>New Ytd</td>
                                <td><span style="color:red;">$</span><?php echo $_SESSION['ytdvalue']; ?></td>
                            </tr>
                            <tr>
                                <td>Payment Status</td>
                                <td><?php echo ($tpl['arr'] ?? [])['payment_status'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight: bold;color:red;">An email with your payment information has been
                                    sent to your registered email address. Please check your spam folder if you cannot find the
                                    email in your inbox</td>
                            </tr>
                            <?php if ($dataregister == 'true' && $pujaDonationTierIs($pujaDonationReceiptYtd, 'silver')) {
                                echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> parking at Green Field</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationTierIs($pujaDonationReceiptYtd, 'gold') && $membertype != 'PM' && $membertype != 'FP') {
                                echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationTierIs($pujaDonationReceiptYtd, 'platinum')) {
                                echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationTierIs($pujaDonationReceiptYtd, 'emerald')) {
                                echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationTierIs($pujaDonationReceiptYtd, 'diamond')) {
                                echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationTierIs($pujaDonationReceiptYtd, 'gold') && ($membertype == "PM" || $membertype == "FP")) {
                                echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationTierIs($pujaDonationReceiptYtd, 'emerald') && $pujaregistered != 'true') {
                                echo "<tr class='tr' id='sankalpapujamsgprice'>
                        <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                         <td class='td'>
                             <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                  <option value=''>Nothing Selected</option> 
                                  <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                  <option value='Maha Sashti'>Maha Sashti</option>
                                  <option value='Maha Saptami'>Maha Saptami</option>
							         <option value='Maha Astami'>Maha Astami</option>
							         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option>
                                
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                            }
                            ?>
                            <!-- second time show puja option condition total work Start -->
                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDiamondMin && $pujaDonationReceiptYtd < $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                 <option value=''>Nothing Selected</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
                                 <option value='Maha Astami'>Maha Astami</option>
                                 <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDiamondMin && $pujaDonationReceiptYtd < $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                            }
                            ?>


                            <!-- update condition new 20 july  -->
                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDiamondMin && $pujaDonationReceiptYtd < $pujaDonationDoubleDiamondMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                            }
                            ?>
                            <!-- new 20 july end -->
                            <!-- update condition new 20 july  -->
                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDiamondMin && $pujaDonationReceiptYtd < $pujaDonationDoubleDiamondMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                            }
                            ?>
                            <!-- new 20 july end -->
                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDiamondMin && $pujaDonationReceiptYtd < $pujaDonationDoubleDiamondMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                                echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                            }
                            ?>
                            <!-- 20 july add new condition -->

                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDiamondMin && $pujaDonationReceiptYtd < $pujaDonationDoubleDiamondMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                                echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                            }
                            ?>
                            <!-- 20july new condition end -->

                            <!-- second time show puja option condition total work end  -->

                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                    ?>
                                <select name='type' id='sponsoreventcategory2' class='form-control input-sm' aria-required='true'
                                    onchange='mysponsorcategory2()' aria-invalid='false' required>
                                    <?php
                                    foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                        ?>
                                        <option value=''>Nothing Selected</option>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                    ?>
                                <select name='type' id='sponsoreventcategory2' class='form-control input-sm' aria-required='true'
                                    onchange='mysponsorcategory2()' aria-invalid='false' required>
                                    <?php
                                    foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                        ?>
                                        <option value=''>Nothing Selected</option>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td'  style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                    ?>
                                <select name='type' id='sponsoreventcategory2' class='form-control input-sm' aria-required='true'
                                    onchange='mysponsorcategory2()' aria-invalid='false' required>
                                    <?php
                                    foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                        ?>
                                        <option value=''>Nothing Selected</option>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'> <span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister == 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                                echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                    ?>
                                <select name='type' id='sponsoreventcategory2' class='form-control input-sm' aria-required='true'
                                    onchange='mysponsorcategory2()' aria-invalid='false' required>
                                    <?php
                                    foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                        ?>
                                        <option value=''>Nothing Selected</option>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>




                            <?php if ($dataregister != 'true' && $pujaDonationTierIs($_SESSION['ytdvalue'], 'silver') && $membertype != 'PM' && $membertype != 'FP') {
                                echo "<tr><td>Parking Area</td> <td style='color:red;' >You will be assigned parking at Green Field</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationTierIs($_SESSION['ytdvalue'], 'gold') && $membertype != 'PM' && $membertype != 'FP') {
                                echo "<tr><td>Parking Area</td> <td style='color:red;' >You will be assigned Gold Sponsor Parking</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationTierIs($_SESSION['ytdvalue'], 'platinum')) {
                                echo "<tr><td>Parking Area</td><td style='color:red;' >You will be assigned Main or Kala Bhavan(KB) Parking.</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationTierIs($_SESSION['ytdvalue'], 'emerald')) {
                                echo "<tr><td>Parking Area</td><td style='color:red;'>You will be assigned Main Parking.</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationTierIs($_SESSION['ytdvalue'], 'diamond')) {
                                echo "<tr><td>Parking Area</td><td style='color:red;'>You will be assigned Main Parking.</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationTierIs($_SESSION['ytdvalue'], 'gold') && ($membertype == "PM" || $membertype == "FP")) {
                                echo "<tr><td>Parking Area</td><td style='color:red;'>You will be assigned Kala Bhavan Parking.</td></tr>";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationTierIs($_SESSION['ytdvalue'], 'emerald') && $pujaregistered != 'true') {
                                echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option>
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                            }
                            ?>
                            <!-- second time show puja option condition total work Start -->
                            <?php if ($dataregister != 'true' && $pujaDonationReceiptYtd >= $pujaDonationDiamondMin && $pujaDonationReceiptYtd < $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationReceiptYtd >= $pujaDonationDiamondMin && $pujaDonationReceiptYtd < $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                            }
                            ?>


                            <!--  update condition new 20 july  -->
                            <?php if ($dataregister != 'true' && $pujaDonationReceiptYtd >= $pujaDonationDiamondMin && $pujaDonationReceiptYtd < $pujaDonationDoubleDiamondMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                            }
                            ?>
                            <!-- new 20 july end -->
                            <!--update condition new 20 july  -->
                            <?php if ($dataregister != 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                    ?>
                                <select name='type' id='sponsoreventcategory2' class='form-control input-sm' aria-required='true'
                                    onchange='mysponsorcategory2()' aria-invalid='false' required>
                                    <?php
                                    foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                        ?>
                                        <option value=''>Nothing Selected</option>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                    ?>
                                <select name='type' id='sponsoreventcategory2' class='form-control input-sm' aria-required='true'
                                    onchange='mysponsorcategory2()' aria-invalid='false' required>
                                    <?php
                                    foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                        ?>
                                        <option value=''>Nothing Selected</option>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                    ?>
                                <select name='type' id='sponsoreventcategory2' class='form-control input-sm' aria-required='true'
                                    onchange='mysponsorcategory2()' aria-invalid='false' required>
                                    <?php
                                    foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                        ?>
                                        <option value=''>Nothing Selected</option>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'> <span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                    ?>
                                <select name='type[]' id='sponsor' class='form-control input-sm selectpicker' aria-required='true'
                                    aria-invalid='false' onchange='myFunction()' multiple required>
                                    <?php
                                    foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <?php if ($dataregister != 'true' && $pujaDonationReceiptYtd >= $pujaDonationDoubleDiamondMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                                echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                    ?>
                                <select name='type' id='sponsoreventcategory2' class='form-control input-sm' aria-required='true'
                                    onchange='mysponsorcategory2()' aria-invalid='false' required>
                                    <?php
                                    foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                        ?>
                                        <option value=''>Nothing Selected</option>
                                        <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php

                                echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                            }
                            ?>
                            <tr style="display:none" id="sankalpaselected">
                                <td>Sankalpa Puja</td>
                                <td id="selectpuja"></td>
                            </tr>
                            <tr style="display:none" id="event1">
                                <td>Sponsor Event Name Category A</td>
                                <td id="sponsoreventame"></td>
                            </tr>
                            <tr style="display:none" id="event2">
                                <td>Sponsor Event Name Category B</td>
                                <td id="sponsoreventcategorydatatr"></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            </tr>
                        </table>


                        <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                            <a href='<?php echo INSTALL_URL; ?>PujaDonations/pujadonation'>Go to home</a>
                        <?php } ?>
                        <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                            <a href='<?php echo INSTALL_URL; ?>donationdata/index'>Go to home</a>
                        <?php } ?>
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-success  in">
                            <i class="fa-fw fa fa-check"></i>
                            <strong><?php echo __('success'); ?></strong>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </section>
        <?php

    } else {
        ?>

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
                        <h3>Payment for Puja Donation/Sponsorship</h3>

                        <!-- <h4><span>Contact : </span><a href="mailto:registration@durgabari.org"> registration@durgabari.org</a></h4>-->
                        <ul class="bread-crumb clearfix">
                            <li><a style="text-decoration:none;color:#fff;"
                                    href="<?php echo INSTALL_URL; ?>onlinepujapayments/onlinepujapayments">Home</a></li>
                            <li class="active">Donation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div style="position: relative;padding: 40px 0px 60px;" class="container">
            <div class="row">

                <div style="border-left: 3px solid #ef260f;border-right: 3px solid #ef260f;border-bottom: 3px solid #ef260f;"
                    class="col-lg-8 col-md-12 col-sm-12">

                    <div id="" style="width:100%; margin:3px auto;">
                        <div id="page-body">
                            <main role="main">

                                <div id="container-abc-url-id" style="display:none;"><?php echo INSTALL_URL; ?></div>
                                <div id="otp-admin-bypass" style="display:none;">
                                    <?php echo !empty($tpl['otp_admin_bypass']) ? '1' : '0'; ?></div>
                                <form id="donation-frm-id" class="form-horizontal" method="post" action="" role="form">
                                    <input type="hidden" name="create_donation" value="1" />
                                    <fieldset class="asb">

                                        <div class="row">

                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <select required="" name="regmember" id="registrationmember" class="choice"
                                                    aria-required="true" aria-invalid="false" tabindex="1">
                                                    <!-- <option value="">Please select Member type</option>   -->
                                                    <option value="">Returning or New User</option>
                                                    <?php
                                                    $otpVerifiedMember = $_SESSION['otp_verified_member'] ?? '';
                                                    if (is_array($otpVerifiedMember)) {
                                                        $otpVerifiedMember = $otpVerifiedMember['member_id'] ?? '';
                                                    }
                                                    ?>
                                                    <option value="member" <?php echo ($otpVerifiedMember !== '') ? 'selected' : ''; ?>>Returning User</option>
                                                    <option value="nonmember">New User</option>
                                                </select>
                                                <div class="text_placeholders">Returning or New User *</div>
                                            </div>
                                            <div id="otp-gate" class="col-lg-12 col-md-12 col-sm-12"
                                                style="display:none;margin-top:8px;">
                                                <div
                                                    style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;background:#f0f8ff;border:1px solid #b0d0f0;border-radius:5px;padding:8px 12px;">
                                                    <span><strong>Returning User Verification:</strong></span>
                                                    <button type="button" id="otp-gate-btn"
                                                        class="btn btn-info btn-sm">Verify via OTP</button>
                                                </div>
                                            </div>
                                            <div id="otp-verified-banner" class="col-lg-12 col-md-12 col-sm-12"
                                                style="display:none;margin-top:8px;">
                                                <div
                                                    style="display:flex;align-items:center;gap:8px;background:#eafaf1;border:1px solid #b7e4c7;border-radius:5px;color:#1e8449;font-size:13px;font-weight:600;padding:8px 12px;">
                                                    <i class="fa fa-check-circle" style="color:#276632;font-size:16px;"></i>
                                                    <span>Returning user verified and details auto-filled.</span>
                                                </div>
                                            </div>

                                            <div id="IDMembertd" class="col-lg-12 col-md-12 col-sm-12 disabledbutton">
                                                <input type="text" name="term" id="term"
                                                    placeholder="search records here.... *" class="MIDtext3" tabindex="2"
                                                    required>
                                                <div class="text_placeholders">Search by : First Name, Last Name, Zip, MID *
                                                </div>
                                            </div>

                                            <!--10july comment-->
                                            <!--   <div id="fieldtest" class="col-lg-12 col-md-12 col-sm-12" style="display:none;">-->
                                            <!--       <input id="namenonmember" class="MIDtext3" type="text" name="namenonmember" placeholder="Full Name" tabindex="2" >-->
                                            <!--<div class="text_placeholders">Full Name *</div>-->
                                            <!--   </div>-->

                                            <input type="text" style="display:none" name="termMember" id="termMember"
                                                placeholder="search member here...." class="MIDtext2 form-control">

                                            <div class="col-lg-6 col-md-6 col-sm-6" id="memberiddiv">
                                                <input type="text" name='demmember' id="demmember" class="MIDtext2 point"
                                                    oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);">
                                                <div class="text_placeholders">Member ID</div>
                                            </div>

                                            <!--10july comment-->
                                            <!--     <div class="col-lg-4 col-md-4 col-sm-4">-->
                                            <!--         <input  id="spousename" class="MIDtext2" type="text" placeholder="Spouse Name" value="" name="spousename" tabindex="3" >-->
                                            <!--<div class="text_placeholders">Spouse Name</div>-->
                                            <!--    </div>-->
                                            <!--  puja donation -->

                                            <div class="col-lg-6 col-md-6 col-sm-6" id="membercategorydiv">
                                                <input id="MembCategory" class="MIDtext2readonly" type="text"
                                                    placeholder="Membership Category" name="membercategory" tabindex="14"
                                                    readonly>
                                                <div class="text_placeholders">Membership Category</div>
                                            </div>

                                            <!-- Add new field for split first name and last name  -->

                                            <div class="col-lg-6 col-md-4 col-sm-6" id="fnamediv">
                                                <input type="text" name='fisrtname' id="First_name" placeholder="First Name"
                                                    class="MIDtext2" required>
                                                <div class="text_placeholders">First Name *</div>
                                            </div>


                                            <div class="col-lg-6 col-md-4 col-sm-6" id="lnamediv">
                                                <input type="text" name='lastname' id="last_name" placeholder="Last Name*"
                                                    class="MIDtext2" required>
                                                <div class="text_placeholders">Last Name *</div>
                                            </div>

                                            <div class="col-lg-6 col-md-4 col-sm-6" id="spfnamediv">
                                                <input type="text" name='spfname' id="spouseFirst_name"
                                                    placeholder="Spouse First Name" class="MIDtext2">
                                                <div class="text_placeholders">Spouse First Name </div>
                                            </div>


                                            <div class="col-lg-6 col-md-4 col-sm-6" id="splnamediv">
                                                <input type="text" name='splname' id="spouselast_name"
                                                    placeholder="Spouse Last Name" class="MIDtext2">
                                                <div class="text_placeholders">Spouse Last Name </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6" id="streetdiv">
                                                <input id="Street" class="MIDtext2" type="text" placeholder="Street No. *"
                                                    value="" name="Street" tabindex="5" required="">
                                                <div class="text_placeholders">Street No. *</div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6" id="streetnamediv">
                                                <input id="ressidentalAddress" class="MIDtext2" type="text"
                                                    placeholder="Street Name *" value="" name="Address" tabindex="6"
                                                    required="">
                                                <div class="text_placeholders">Street Name *</div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4" id="citydiv">
                                                <input id="city" class="MIDtext2" type="text" name="City" size="25" value=""
                                                    placeholder="City *" tabindex="7" required="">
                                                <div class="text_placeholders">City *</div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4" id="statediv">
                                                <input id="state" class="MIDtext2" type="text" name="State" size="25"
                                                    value="" placeholder="State *" tabindex="7" required="">
                                                <div class="text_placeholders">State *</div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4" id="zipdiv">
                                                <input id="zip_code" class="MIDtext2" type="text" placeholder="Zip Code *"
                                                    value="" name="Zip_Code" tabindex="9" required="">
                                                <div class="text_placeholders">Zip Code *</div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6 phone" id="phonenodiv">
                                                <input id="phone" class="MIDtext2readonly" type="text" required=""
                                                    placeholder="##########" value="" name="Tele1"
                                                    onchange="sponsoramount(this.id)" maxlength="10" tabindex="11">
                                                <div class="text_placeholders">Phone Number *</div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6 phone" id="alterntenumberdiv">
                                                <input class="MIDtext2" type="text" required name="alternatenumber"
                                                    id="memphone2fam" maxlength="10" placeholder="##########" />
                                                <div class="text_placeholders">Mobile Number *</div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6" id="emaildiv">
                                                <input required="" id="email" class="MIDtext2readonly" type="text"
                                                    placeholder="name@company.com" value="" name="email" tabindex="11"
                                                    pattern="[^@\s]+@[^@\s]+\.[^@\s]+">
                                                <div class="text_placeholders">Email *</div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6" id="alternateemaildiv">
                                                <input id="email2" class="MIDtext2" type="text"
                                                    placeholder="name@company.com" value="" name="alternateemail"
                                                    tabindex="11" pattern="[^@\s]+@[^@\s]+\.[^@\s]+">
                                                <div class="text_placeholders">Alternate Email</div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6" id="lifetimediv">
                                                <input id="ltd1" class="MIDtext2readonly" type="text"
                                                    placeholder="Lifetime Contribution" value="" name="LTC" tabindex="12"
                                                    readonly>
                                                <div class="text_placeholders">Lifetime Contribution</div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6" id="ytddiv">
                                                <input id="ytd1" class="MIDtext2readonly" type="text"
                                                    placeholder="Annual Donation" value="" name="YTD" tabindex="13"
                                                    readonly>
                                                <div class="text_placeholders">Annual Donation</div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6" id="amountdiv">
                                                <input required id="total" class="MIDtext2" type="number"
                                                    placeholder="( $ ) Donation Amount *" value="" name="Amount"
                                                    tabindex="15" onchange="amountvalid(this.id)" pattern="[0-9]">
                                                <div class="text_placeholders">($) Donation Amount *</div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6" id="futureytddiv">
                                                <input name="newytdfeature" id="futureytd" class="MIDtext2readonly"
                                                    type="text" placeholder="( $ ) Your future YTD" value=""
                                                    style="width:100%;  height:50%;" tabindex="16" readonly>
                                                <input type="hidden" id="greenFieldParkingDecision"
                                                    name="greenFieldParkingDecision" value="">
                                                <div class="text_placeholders">($) Your Future YTD will be</div>
                                            </div>
                                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                                <div class="col-lg-6 col-md-6 col-sm-6" id="purposediv">
                                                    <input type="text" class="MIDtext2" name="purpose">
                                                    <div class="text_placeholders">Purpose </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <table class="table">

                                            <tr class="tr">

                                            <tr id="msgdiv" style="display:none;">
                                                <td style="color: rgb(255, 0, 0)" id="ytdmess" colspan="4"></td>
                                            </tr>
                                            <tr id="regmsgdiv" style="display:none;">
                                                <td style="color: rgb(255, 0, 0)" id="optionmsg" colspan="4"></td>

                                            </tr>



                                            <!-- OPTIONS DROPDOWN PUJA DONATION  Start-->
                                            <table class="table">
                                                <tr class="tr" style="display:none;" id="sponsorcheck">
                                                    <td class="td" colspan="2">
                                                        <select name="" id="sponser" onchange="ListCreate()" class="choice"
                                                            aria-required="true" aria-invalid="false">
                                                            <option value="">Please select</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                        <div class="text_placeholders">Are you Interested in Sponsor Parking
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <!-- Adding bootstrap table classes to style a table-->

                                                                <!-- The Modal -->
                                                                <div id="myModal" class="modal">

                                                                    <!-- Modal content -->
                                                                    <div class="modal-content">
                                                                        <span id="close" class="close">&times;</span>
                                                                        <div class="popup_title"><b>Sponsorship Privileges
                                                                                (Information only, please go back to
                                                                                Donation field to adjust your donation)</b>
                                                                        </div>
                                                                        <table
                                                                            class="table table-bordered table-condensed table-hover table-striped text-center popup_table">
                                                                            <tbody id="data"
                                                                                class="feature text-left popup_tbody">
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
                                                                                    <td class="td" id="diamond">$5000+(
                                                                                        Registration optional)</td>
                                                                                    <td class="td"
                                                                                        style="background-color: #f3f4f5;">
                                                                                        Main Parking.<br> Named slots for
                                                                                        $10K</td>

                                                                                </tr>
                                                                                <!-- PUJA_DONATION_DIAMOND_RENDER_FIX_20260614 -->
                                                                                <tr class="tr" id="emeraldtr">
                                                                                    <td class="td"
                                                                                        style="background-color:#98FB98;color:black;">
                                                                                        Emerald</td>
                                                                                    <td class="td" id="emerald"
                                                                                        style="background-color:white;">
                                                                                        $2200 - $4559</td>
                                                                                    <td class="td">Main Parking<br>
                                                                                        (in order of date of Sponsorship)
                                                                                    </td>


                                                                                </tr>
                                                                                <tr class="tr" id="platinumtr">
                                                                                    <td class="td"
                                                                                        style="background-color:#000080;color:white;">
                                                                                        Platinum</td>
                                                                                    <td class="td" id="platinum">$1500 -
                                                                                        $2199</td>
                                                                                    <td class="td">Main or Kala Bhavan
                                                                                        (KB)Parking<br>
                                                                                        (in order of date of Sponsorship)
                                                                                    </td>

                                                                                </tr>
                                                                                <tr class="tr" id="goldtr">
                                                                                    <td class="td"
                                                                                        style="background-color:yellow;color:black;">
                                                                                        Gold</td>
                                                                                    <td class="td" id="gold"
                                                                                        style="background-color:white;">
                                                                                        $1000 - $1499</td>
                                                                                    <td class="td">Green Field. <br> KB
                                                                                        Parking for CT Gold Sponsors</td>

                                                                                </tr>

                                                                                <tr class="tr" id="silvertr">
                                                                                    <td class="td"
                                                                                        style="background-color:#E6E6FA;color:black;">
                                                                                        Silver</td>
                                                                                    <td class="td" id="silver">$750 - $999
                                                                                    </td>
                                                                                    <td class="td"
                                                                                        style="background-color: #f3f4f5;">
                                                                                        Green Field. <br> KB Parking for CT
                                                                                        Senior Silver Sponsors</td>
                                                                                </tr>
                                                                            </tbody>

                                                                        </table>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!--  <div id="fade" class="black_overlay"></div> -->



                                                <!-- OPTIONS DROPDOWN PUJA DONATION  END-->

                                                <tr style="display:none;">
                                                    <td class="td" style="display:none;"> <input id="Your_Name"
                                                            class="form-control input-sm" type="test" name="MemberName"
                                                            style="display:none;"> </td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td class="td" style="display:none;"> <input id="Zellecode"
                                                            class="form-control input-sm" type="text" name="code"
                                                            style="display:none;"> </td>
                                                </tr>
                                                <div id="otp-session-verified" style="display:none">
                                                    <?= htmlspecialchars((string) ($otpVerifiedMember ?? ''), ENT_QUOTES) ?>
                                                </div>
                                                <table class="table" id="paydropdiv">
                                                    <tr class="tr">
                                                        <td class="td" colspan="2">
                                                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                                                <select name="PaymentOption" style="width:100%;  height:50%;"
                                                                    id="PaymentOption"
                                                                    class="choice form-control input-sm  valid" required>
                                                                    <option value="">Please Select</option>
                                                                    <option value="check">Check</option>
                                                                    <option value="cash">Cash</option>
                                                                    <option value="directdeposit">Online Deposit</option>
                                                                    <option value="sumup">Sumup</option>
                                                                    <option value="stripe">Credit card</option>
                                                                    <option value="others">Zelle (Preferred)</option>
                                                                    <option value="zelleProxy">Zelle Proxy</option>
                                                                </select>
                                                            <?php } ?>
                                                            <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                                                                <select required="" name="PaymentOption" id="PaymentOption"
                                                                    class="choice form-control input-sm  valid"
                                                                    aria-required="true" aria-invalid="false"
                                                                    style="width:100%;  height:50%;" tabindex="17">
                                                                    <option value="" class="amd">---</option>
                                                                    <?php
                                                                    $payment_method_arr = __('payment_method_arr');
                                                                    $renderedPaymentOptions = 0;
                                                                    foreach ($payment_method_arr as $k => $v) {
                                                                        if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                                                            $renderedPaymentOptions++;
                                                                            ?>
                                                                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    if ($renderedPaymentOptions === 0) {
                                                                        ?>
                                                                        <option value="others">Zelle (Preferred)</option>
                                                                        <option value="stripe">Credit card</option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <!-- <option value="zelleProxy">Zelle Proxy</option> -->
                                                                </select>
                                                            <?php } ?>

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
                                                                    class="form-control input-sm" type="text"
                                                                    name="confirm_code" size="25" value=""
                                                                    title="<?php echo __('confirm_code'); ?>"
                                                                    placeholder="<?php echo __('confirm_code'); ?>">
                                                                <div class="control-group"></div>
                                                                <div id="error_code"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <table class="table">
                                                        <tr class="tr" id="MemberID1" style="display: none;"
                                                            class="form-group">
                                                            <td id="error_code1"></td>
                                                            <label class="control-label" for="F_Name"
                                                                style="color:rgba(237,237,237) !important;">Payment
                                                                Details:</label>
                                                            <!-- <td  class="td" colspan="2" class="auto-widget"> -->
                                                            <td style="display: block;">
                                                                <div class="d-flex justify-content-between gap-3"><button
                                                                        class="btn btn-style-1"
                                                                        style="display: none;float:left!important;"
                                                                        type="button" id="checkPaymentData">Get Zelle
                                                                        Payment
                                                                        Details</button>
                                                                    <select data-rule-required='true' id="MemberID"
                                                                        name="oid"
                                                                        class="form-control form-select input-sm shadow"
                                                                        style="font-weight: bold;float:right!important;">
                                                                        <option value="">Please select your payment details
                                                                        </option>
                                                                        <?php
                                                                        foreach (($tpl['Amount'] ?? []) as $key => $value) {
                                                                            ?>

                                                                            <option value="<?php echo $value['Amount']; ?>">
                                                                                <?php echo $value['Amount']; ?>
                                                                            </option>
                                                                            <?php
                                                                            //echo '<option value="'.$value['Amount'].'">'.$value['Amount']. '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div id="zelle-action-btns"
                                                                    style="display:none;margin-top:8px;">
                                                                    <!-- <button type="button" id="zelle-verify-btn" class="btn btn-success btn-sm">Verify Selected Transaction</button> -->
                                                                    <button type="button" id="zelle-retry-btn"
                                                                        class="btn btn-default btn-sm"
                                                                        style="margin-left:8px;">Search Again</button>
                                                                </div>
                                                                <div id="zelle-manual-fields"
                                                                    style="display:none;margin-top:10px;">
                                                                    <div class="form-group">
                                                                        <label style="font-size:13px;">Your name as used in
                                                                            Zelle:</label>
                                                                        <input type="text" id="zelle_donor_name"
                                                                            class="form-control input-sm"
                                                                            placeholder="Full name used for Zelle transfer">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label style="font-size:13px;">Zelle payment
                                                                            date:</label>
                                                                        <input type="date" id="zelle_date"
                                                                            class="form-control input-sm"
                                                                            style="max-width:220px;">
                                                                    </div>
                                                                </div>
                                                                <div id="zelle-no-match"
                                                                    style="display:none;color:#c0392b;font-size:13px;margin-top:8px;padding:8px;background:#fdecea;border-radius:4px;">
                                                                    No matching Zelle payment found. Please check your Zelle
                                                                    name, amount, and payment date.
                                                                </div>
                                                                <table
                                                                    class="table table-bordered table-hover table-striped"
                                                                    style="display:none;margin-top: -42px;"
                                                                    id="zelleProxyData">
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
                                                                            <td class="td"><input style="WIDTH: 100%;"
                                                                                    type="text" id="proxyTrId"
                                                                                    name="zelleProxyTid"
                                                                                    class="form-control input-sm" value="">
                                                                            </td>
                                                                            <td class="td"><input style="WIDTH: 100%;"
                                                                                    type="date" id="proxyTrdate"
                                                                                    name="proxydate"
                                                                                    class="form-control input-sm" value="">
                                                                            </td>
                                                                            <td class="td">
                                                                                <input style="WIDTH: 100%;" type="number"
                                                                                    id="proxyprice" name="proxyamount"
                                                                                    class="form-control input-sm" value="">
                                                                            </td>
                                                                            <td class="td">
                                                                                <select name="zelleProxyDepositAccount"
                                                                                    class="choice">
                                                                                    <option value="PujaAccount">Puja Account
                                                                                    </option>
                                                                                    <option value="RegularAccount">Regular
                                                                                        Account</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <!-- <input data-rule-required='true' id="MemberID" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>"> -->
                                                            <!-- <td class="td" colspan="3"><select  data-rule-required='true'
                                                                    id="MemberID" name="oid" class="form-control form-select input-sm"
                                                                    style="font-weight: bold;float:right!important;">
                                                                    <option value="">Please select your payment details
                                                                    </option>
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
                                                            </td> -->
                                                            <!-- </td> -->

                                                        </tr>
                                                    </table>
                                                    <table class="table" id="zelledatadiv">
                                                        <tr>
                                                            <td id="error_code2"></td>
                                                            <!-- <td id="error_code"></td> -->
                                                            <td id="error_codeimg"></td>
                                                        </tr>
                                                    </table>
                                                    <div id="zelle-modal-overlay"
                                                        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9100;justify-content:center;align-items:center;">
                                                        <div
                                                            style="background:#fff;border-radius:8px;width:660px;max-width:96vw;max-height:90vh;overflow-y:auto;box-shadow:0 8px 32px rgba(0,0,0,0.25);position:relative;font-family:Arial,sans-serif;">
                                                            <div
                                                                style="background:#357ca5;padding:16px 20px 12px;text-align:center;position:relative;border-radius:8px 8px 0 0;">
                                                                <button id="zelle-modal-close" type="button"
                                                                    style="position:absolute;top:10px;right:14px;background:none;border:none;color:#fff;font-size:24px;cursor:pointer;line-height:1;padding:0;opacity:0.85;">&times;</button>
                                                                <h4
                                                                    style="color:#fff;margin:0;font-size:18px;font-weight:bold;">
                                                                    Pay via Zelle</h4>
                                                                <p
                                                                    style="color:rgba(255,255,255,0.88);margin:4px 0 0;font-size:13px;">
                                                                    Send to treasurerpuja@durgabari.org</p>
                                                            </div>
                                                            <div
                                                                style="padding:18px 24px 16px;font-size:14px;color:#333;line-height:1.8;">
                                                                <b>Step 1</b> - Open your bank app and navigate to
                                                                Zelle.<br>
                                                                <b>Step 2</b> - Send your donation amount to
                                                                <b>treasurerpuja@durgabari.org</b>.<br>
                                                                <b>Step 3</b> - After sending, click <b>"I've Completed
                                                                    Zelle Payment"</b> below.
                                                            </div>
                                                            <div
                                                                style="padding:0 24px 22px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                                                                <button id="zelle-modal-paid-btn" type="button"
                                                                    class="btn btn-primary"
                                                                    style="min-width:200px;font-size:15px;">I've Completed
                                                                    Zelle Payment</button>
                                                                <button id="zelle-modal-cancel-btn" type="button"
                                                                    class="btn btn-default"
                                                                    style="min-width:120px;font-size:15px;background:#f5f5f5;border:1px solid #ccc;">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="greenFieldParkingModal"
                                                        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:9200;justify-content:center;align-items:center;">
                                                        <div
                                                            style="background:#fff;border-radius:8px;width:520px;max-width:94vw;box-shadow:0 10px 30px rgba(0,0,0,0.25);overflow:hidden;font-family:Arial,sans-serif;">
                                                            <div
                                                                style="background:#357ca5;color:#fff;padding:14px 18px;font-size:18px;font-weight:bold;">
                                                                Green Field Parking
                                                            </div>
                                                            <div
                                                                style="padding:18px;color:#333;font-size:14px;line-height:1.6;">
                                                                On completion of your payment, you will be assigned parking
                                                                at Green Field.
                                                                Continue with this donation or cancel and change the amount.
                                                            </div>
                                                            <div
                                                                style="padding:0 18px 18px;display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap;">
                                                                <button type="button" class="btn btn-primary"
                                                                    onclick="handleGreenFieldParkingChoice('donation')">Continue</button>
                                                                <button type="button" class="btn btn-default"
                                                                    onclick="handleGreenFieldParkingChoice('Cancelled')">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                            <td class="td"><input style="WIDTH: 100%;" type="text"
                                                                    id="checkbankname" name="checkbankname"
                                                                    class="form-control input-sm" value=""></td>
                                                            <td class="td"><input style="WIDTH: 100%;" type="text"
                                                                    id="checkno" name="chkno" class="form-control input-sm"
                                                                    value=""></td>

                                                            <td class="td">
                                                                <input style="WIDTH: 100%;" type="number" id="checkamount"
                                                                    name="checkAmount" class="form-control input-sm"
                                                                    value="">
                                                            </td>
                                                            <td class="td"><input style="WIDTH: 100%;" type="date"
                                                                    id="checkdate" name="CheckDate"
                                                                    class="form-control input-sm" value=""></td>
                                                            <td class="td"><select name="CheckDepositAccount"
                                                                    class="choice">
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
                                                            <td class="td"><input type="text" id="receiveby"
                                                                    name="ReceiveBy" class="form-control input-sm" value="">
                                                            </td>

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
                                                            <td class="td"><input style="WIDTH: 100%;" type="text"
                                                                    id="bankname" name="directbank"
                                                                    class="form-control input-sm" value=""></td>
                                                            <td class="td"><input style="WIDTH: 100%;" type="text"
                                                                    id="ISFCCode" name="transactioncode"
                                                                    class="form-control input-sm" value=""></td>

                                                            <td class="td">
                                                                <input style="WIDTH: 100%;" type="number" id="directamount"
                                                                    name="directdepositeamount"
                                                                    class="form-control input-sm" value="">
                                                            </td>
                                                            <td class="td"><input style="WIDTH: 100%;" type="date" id="date"
                                                                    name="transactiondate" class="form-control input-sm"
                                                                    value=""></td>
                                                            <td class="td"><select name="DirectPayDepositAccount"
                                                                    class="choice">
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
                                                            <td class="td"><input style="WIDTH: 100%;" type="text"
                                                                    id="sumdata" name="sumupid"
                                                                    class="form-control input-sm" value=""></td>
                                                            <td class="td">
                                                                <input style="WIDTH: 100%;" type="number" id="sumupprice"
                                                                    name="sumupamount" class="form-control input-sm"
                                                                    value="">
                                                            </td>
                                                            <td class="td"><input style="WIDTH: 100%;" type="date"
                                                                    id="sumdatedate" name="sumupdate"
                                                                    class="form-control input-sm" value=""></td>
                                                            <td class="td"><select name="SumUpDepositAccount"
                                                                    class="choice">
                                                                    <option value="PujaAccount">Puja Account</option>
                                                                    <option value="RegularAccount">Regular Account</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>



                                                <div class="row" id="submitdatadiv">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <button id="reset-btn-id" class="go_cart_btn btn" autocomplete="off"
                                                            value="Save" name="Reset" tabindex="16" type="submit"><i
                                                                class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Reset</button>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <button id="payment_btn_id" class="go_cart_btn btn"
                                                            autocomplete="off" value="Save" name="Payment" tabindex="17"
                                                            type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Make
                                                            Payment</button>
                                                    </div>

                                                </div>

                                                <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                                            </table>
                                            <div id="stripe_secret_key_id" style="display: none">
                                                <?php echo $tpl['option_arr_values']['stripe_publish_key']; ?></div>

                                            <?php require __DIR__ . '/../components/otp_modal.php'; ?>
                                </form>
                            </main>
                        </div>
                    </div>

                </div>

                <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                    <aside class="sidebar">

                        <div class="sidebar-widget help-widget">
                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                <a style="font-size: 24px; text-decoration: none;color:#000; font-weight:600;"
                                    href="<?php echo INSTALL_URL; ?>donationdata/index">Go Back to Dashboard</a>
                                <br><br>
                            <?php } ?>
                            <div class="sidebar-title">
                                <h2><span style="color: #ef260f;">General</span> Guidelines</h2>
                            </div>
                            <div class="widget-content">
                                <div class="text">1. Sponsorship level is defined based on Year-to-Date (YTD) donation</div>
                                <div class="text">2. Diamond sponsors can sponsor key Puja events: </div>
                                <div class="text">a. Diamond sponsors with $5-10K contribution may select one event from
                                    Category A</div>
                                <div class="text">b. Diamond sponsors with >$10K contribution may select two events from
                                    Category A or one from Category B</div>
                                <div class="text">3. Sponsorship privileges include onsite parking <a
                                        href="<?php echo INSTALL_URL; ?>Sponsorship/Sponsorship">Click here for a full
                                        description of sponsorship privileges</a> </div>
                                <div class="text">4. Registration is mandatory to avail Sponsorship privileges. Diamond
                                    sponsors can optionally include the registration fee within the sponsorship amount or do
                                    a separate registration. </div>
                                <div class="text">5. All donations to HDBS during the calendar year are counted towards
                                    sponsorship designation</div>
                                <div class="text">6. Emerald and Diamond sponsors are eligible for a free Puja Sankalpa.
                                    Select online after making the payment, or via the Puja Sankalpa icon later</div>
                                <div class="text">7. The event sponsors will by recognized prominently on a range of media
                                    (digital screen, magazine, public address system)</div>
                                <div class="text">8. Puja Benefactors (minimum YTD $150 for Seniors, $300 for general
                                    Registrants) may apply for Green Field Parking via the Puja Benefactor icon.
                                    Registration is mandatory to apply. Parking privilege is subject to availability.</div>
                            </div>
                        </div>

                        <div class="sidebar-widget help-widget">
                            <div class="sidebar-title">
                                <h2><span style="color: #ef260f;">Need</span> Help?</h2>
                            </div>
                            <div class="widget-content">
                                <div class="text">If you have any questions, please contact us</div>
                                <p style="padding-bottom:30px;"><span><i class="fa fa-envelope"
                                            aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;"
                                        href="mailto:registration@durgabari.org"> registration@durgabari.org</a></p>
                                <!--  <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;" href="tel:+17134948782"> <strong style="font-size:26px;"> +1 713-494-8782</strong> <br><span style="font-size:20px;color:#000;">Enakshi Lahiri</span></a></p> 
                        <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a style="color:#000;text-decoration:none;" href="tel:+18322478794"> <strong style="font-size:26px;"> +1 832-247-8794</strong> <br><span style="font-size:20px;color:#000;">Urmimala Mukhopadhyay</span></a></p> -->
                                <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                        style="color:#000;text-decoration:none;" href="tel:+18322478794"> <strong
                                            style="font-size:26px;">(832)247-8794</strong> <br><span
                                            style="font-size:20px;color:#000;">Urmimala</span></a></p>
                                <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                        style="color:#000;text-decoration:none;" href="tel:+13462571068"> <strong
                                            style="font-size:26px;">(346)257-1068</strong> <br><span
                                            style="font-size:20px;color:#000;">Sampurna</span></a></p>
                                <p><span><i class="fa fa-phone" aria-hidden="true"></i></span><a
                                        style="color:#000;text-decoration:none;" href="tel:+15407978261"> <strong
                                            style="font-size:26px;">(540)797-8261</strong> <br><span
                                            style="font-size:20px;color:#000;">Raj</span></a></p>
                            </div>
                        </div>

                    </aside>
                </div>

            </div>
        </div>


    <?php } ?>

    <script type="text/javascript">
        var pujaDonationYtdTiers = <?php echo json_encode($tpl['puja_ytd_tiers'] ?? array()); ?>;

        function getDonationYtdTier(amount) {
            var value = parseFloat(amount);
            if (isNaN(value)) {
                return null;
            }
            for (var i = 0; i < pujaDonationYtdTiers.length; i++) {
                var tier = pujaDonationYtdTiers[i];
                var minAmount = parseFloat(tier.min_amount);
                var maxAmount = tier.max_amount === null || tier.max_amount === '' ? null : parseFloat(tier.max_amount);
                if (value >= minAmount && (maxAmount === null || value <= maxAmount)) {
                    return tier;
                }
            }
            return null;
        }

        function donationYtdTierIs(amount, names) {
            var tier = getDonationYtdTier(amount);
            var tierName = tier && tier.tier_name ? String(tier.tier_name).toLowerCase() : '';
            if (!Array.isArray(names)) {
                names = [names];
            }
            return names.indexOf(tierName) !== -1;
        }

        function donationYtdTierMin(name, fallback) {
            name = String(name || '').toLowerCase();
            for (var i = 0; i < pujaDonationYtdTiers.length; i++) {
                var tier = pujaDonationYtdTiers[i];
                if (String(tier.tier_name || '').toLowerCase() === name && !isNaN(parseFloat(tier.min_amount))) {
                    return parseFloat(tier.min_amount);
                }
            }
            return fallback;
        }
        //debugger;

        // $(window).bind("pageshow", function() {
        //        var form = $('form'); 
        //        form[0].reset();
        //      });

        const phoneInputField = document.querySelector("#phone");
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


        $(function () {
            $('input[type="text"]').change(function () {
                this.value = $.trim(this.value);
            });
        });

        ////Lookup.......................Start..............................////
        $(function () {
            $("#term").autocomplete({
                //source: "http://localhost/HDBS_Puja_Payments/ajax-db-search.php",
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

        $('#term').on('input', function () {
            $(this).val($(this).val().replace(/[^a-z0-9 \-]/gi, ''));
        });


        function sponsoramount(elem) {
            //debugger;
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

        let checkSenior = false;
        let pujaChcek = false;
        let pujaRegistration = false;

        function checkPujaRegistration(memberid) {
            var url2 = $("#container-abc-url-id").text();
            var data = memberid && memberid[0] ? memberid[0] : "";

            if (!data) {
                checkSenior = false;
                pujaChcek = false;
                pujaRegistration = false;
                return;
            }

            $.ajax({
                type: "POST",
                url: url2 + "load.php?controller=PujaOnlinePayments&action=checkPujaRegitration2",
                data: {
                    memberid: data
                },
                success: function (res) {
                    checkSenior = false;
                    pujaChcek = false;
                    pujaRegistration = false;

                    let all3Puja = $(res).filter("input#all3Puja")[0]?.value || "";
                    let durgaPuja = $(res).filter("input#durgaPuja")[0]?.value || "";
                    let all3PujaSenior = $(res).filter("input#all3PujaSenior")[0]?.value || "";
                    let durgaPujaSenior = $(res).filter("input#durgaPujaSenior")[0]?.value || "";

                    all3PujaSenior = parseInt(all3PujaSenior, 10) || 0;
                    durgaPujaSenior = parseInt(durgaPujaSenior, 10) || 0;

                    if (all3Puja == "All 3 Pujas" || durgaPuja == "Durga Puja") {
                        pujaChcek = true;
                    }

                    if (all3PujaSenior > 0 || durgaPujaSenior > 0) {
                        checkSenior = true;
                    }

                    amountvalid();
                }
            });
        }

        function amountvalid() {
            var amount = parseFloat($("#total").val());
            var currentYtd = parseFloat($("#ytd1").val());
            var membertype = $("#MembCategory").val();
            var isPreferredMember = membertype === 'PM' || membertype === 'FP';
            var futureYtd = isNaN(currentYtd) ? amount : currentYtd + amount;

            if (isNaN(amount)) {
                $("#futureytd").val('');
                $('#msgdiv').hide();
                $('#sponsorcheck').hide();
                return;
            }

            $("#futureytd").val(futureYtd);

            if (amount < 1) {
                alert("Minimum Amount $1");
                $("#total").prop('required', true);
                $("#payment_btn_id").addClass('disabled');
            } else {
                $("#payment_btn_id").removeClass('disabled');
            }

            var silverMinAmount = donationYtdTierMin('silver', 750);
            if (futureYtd > 25 && futureYtd < silverMinAmount) {
                $('#ytdmess').html('');
                $('#msgdiv').hide();
                $('#sponsorcheck').show();
            } else if (donationYtdTierIs(futureYtd, 'silver') && isPreferredMember) {
                $('#ytdmess').html("You will be assigned parking at KalaBhavan");
                $('#msgdiv').show();
                $('#sponsorcheck').hide();
            } else if (donationYtdTierIs(futureYtd, 'silver')) {
                $('#ytdmess').html("You will be assigned parking at Green Field");
                $('#msgdiv').show();
                $('#sponsorcheck').hide();
            } else if (donationYtdTierIs(futureYtd, 'gold') && isPreferredMember) {
                $('#ytdmess').html("You will be assigned parking at KalaBhavan");
                $('#msgdiv').show();
                $('#sponsorcheck').hide();
            } else if (donationYtdTierIs(futureYtd, 'gold')) {
                $('#ytdmess').html("On completion of your payment, you will be assigned Gold Sponsor Parking, contingent on Puja registration (All 3 Pujas / Durga Puja).");
                $('#msgdiv').show();
                $('#sponsorcheck').hide();
            } else if (donationYtdTierIs(futureYtd, 'platinum')) {
                $('#ytdmess').html("On completion of your payment, you will be assigned Main or Kala Bhavan(KB) Parking, contingent on Puja registration (All 3 Pujas / Durga Puja).");
                $('#msgdiv').show();
                $('#sponsorcheck').hide();
            } else if (donationYtdTierIs(futureYtd, ['emerald', 'diamond'])) {
                $('#ytdmess').html("On completion of your payment, you will be assigned Main Parking.");
                $('#msgdiv').show();
                $('#sponsorcheck').hide();
            } else {
                $('#ytdmess').html('');
                $('#msgdiv').hide();
                $('#sponsorcheck').hide();
            }
        }
        function amountvalidbackup() {

            const price = parseInt($("#total").val());
            const ytd = parseInt($("#ytd1").val());
            var regmember = $("#registrationmember").val();
            var membertype = $("#MembCategory").val();
            // if(regmember == 'member'){
            if (isNaN(ytd)) {
                document.getElementById("futureytd").value = price;
                if (donationYtdTierIs(price, ['base 1', 'base 2'])) {
                    $('#sponsorcheck').show();
                    $('#msgdiv').hide();
                }

                else if (isNaN(ytd) && isNaN(price)) {
                    document.getElementById("futureytd").value = '';
                    $('#msgdiv').hide();
                    $('#sponsorcheck').hide();
                }
                else if (donationYtdTierIs(price, 'silver')) {
                    $('#ytdmess').html("You will be assigned parking at Green Field");
                    $('#msgdiv').show();
                    $('#sponsorcheck').show();
                    showGreenFieldParkingPopup();
                }
                else if (donationYtdTierIs(price, 'gold') && membertype != "PM" && membertype != "FP") {
                    $('#ytdmess').html("On completion of your payment, you will be assigned Gold Sponsor Parking.");
                    $('#msgdiv').show();
                    $('#sponsorcheck').hide();
                }
                else if (donationYtdTierIs(price, 'gold') && (membertype == "PM" || membertype == "FP")) {
                    $('#ytdmess').html("You will be assigned parking at KalaBhavan");
                    $('#msgdiv').show();
                    $('#sponsorcheck').hide();
                }
                else if (donationYtdTierIs(price, 'platinum')) {
                    $('#ytdmess').html("On completion of your payment, you will be assigned Main or Kala Bhavan(KB) Parking.");
                    $('#msgdiv').show();
                    $('#sponsorcheck').hide();
                }
                else if (donationYtdTierIs(price, 'emerald')) {
                    $('#ytdmess').html("On completion of your payment, you will be assigned Main or Kala Bhavan(KB) Parking.");
                    $('#msgdiv').show();
                    $('#sponsorcheck').hide();
                }
                else if (donationYtdTierIs(price, 'diamond')) {
                    $('#ytdmess').html("On completion of your payment, you will be assigned Main Parking.");
                    $('#msgdiv').show();
                    $('#sponsorcheck').hide();
                }

                else {
                    $('#sponsorcheck').hide();
                    $('#msgdiv').hide();
                }
            } else {
                const newytd = price + ytd;
                document.getElementById("futureytd").value = newytd;
                if (donationYtdTierIs(newytd, ['base 1', 'base 2'])) {
                    //alert("Are You Intersted in assigned Sponsor Parking");
                    $('#sponsorcheck').show();
                    $('#msgdiv').hide();
                }
                else if (isNaN(newytd)) {
                    document.getElementById("futureytd").value = '';
                    $('#msgdiv').hide();
                    $('#sponsorcheck').hide();
                }
                else if (donationYtdTierIs(newytd, 'silver')) {
                    $('#ytdmess').html("You will be assigned parking at Green Field");
                    $('#msgdiv').show();
                    $('#sponsorcheck').show();
                    showGreenFieldParkingPopup();
                }
                else if (donationYtdTierIs(newytd, 'gold') && membertype != "PM" && membertype != "FP") {
                    $('#ytdmess').html("On completion of your payment, you will be assigned Gold Sponsor Parking.");
                    $('#msgdiv').show();
                    $('#sponsorcheck').hide();
                }
                else if (donationYtdTierIs(newytd, 'gold') && (membertype == "PM" || membertype == "FP")) {
                    $('#ytdmess').html("You will be assigned parking at KalaBhavan");
                    $('#msgdiv').show();
                    $('#sponsorcheck').hide();
                }
                else if (donationYtdTierIs(newytd, 'platinum')) {
                    $('#ytdmess').html("On completion of your payment, you will be assigned Main or Kala Bhavan(KB) Parking.");
                    $('#msgdiv').show();
                    $('#sponsorcheck').hide();
                }
                else if (donationYtdTierIs(newytd, 'emerald')) {
                    $('#ytdmess').html("On completion of your payment, you will be assigned Main or Kala Bhavan(KB) Parking.");
                    $('#msgdiv').show();
                    $('#sponsorcheck').hide();
                }
                else if (donationYtdTierIs(newytd, 'diamond')) {
                    $('#ytdmess').html("On completion of your payment, you will be assigned Main Parking.");
                    $('#msgdiv').show();
                    $('#sponsorcheck').hide();
                }
                else {
                    $('#sponsorcheck').hide()
                    $('#msgdiv').hide();
                }
            }

            if (price < 1) {
                alert("Minimum Amount $1");
                $("#total").prop('required', true);
                $("#payment_btn_id").addClass('disabled');
            } else {
                $("#payment_btn_id").removeClass('disabled');
            }
        }
        //autocomplete  

        function donationCsrfData(data) {
            var payload = $.extend({}, data || {});
            var token = $('input[name="csrf_token"]').first().val();
            if (token && !payload.csrf_token) {
                payload.csrf_token = token;
            }
            return payload;
        }

        function MemberSelectdonation(e) {
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
                        data: donationCsrfData({
                            memberid: data
                        }),
                        url: "<?php echo INSTALL_URL; ?>load.php?controller=PujaDonations&action=AllMemberNew",
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
                            //document.getElementById("memMnamefam").value = memberMname;

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
                            //10julyupdate
                            //document.getElementById("Your_Name").value =  MemberName.concat(" ", LastName);
                            document.getElementById("last_name").value = LastName;



                            let memberid = "";
                            const memberElement = $(res).filter("input#memberid");
                            if (memberElement.length) {
                                memberid = memberElement[0].value;
                            }
                            document.getElementById("demmember").value = memberid;

                            let spouseName = "";
                            const spouseNameElement = $(res).filter("input#Spouse");
                            if (spouseNameElement.length) {
                                spouseName = spouseNameElement[0].value;
                            }
                            //10julyupdate
                            //document.getElementById("spousename").value = spouseName.concat(" ",spouseLastName);
                            document.getElementById("spouseFirst_name").value = spouseName;

                            let spouseLastName = "";
                            const spouseLastNameElement = $(res).filter("input#Spouselast");
                            if (spouseLastNameElement.length) {
                                spouseLastName = spouseLastNameElement[0].value;
                            }
                            //10julyupdate
                            document.getElementById("spouselast_name").value = spouseLastName;



                            let street = "";
                            const streetElement = $(res).filter("input#ressidentalAddress");
                            if (streetElement.length) {
                                street = streetElement[0].value;
                            }
                            document.getElementById("Street").value = street;

                            let resaddress = "";
                            const resaddressElement = $(res).filter("input#Address");
                            if (resaddressElement.length) {
                                resaddress = resaddressElement[0].value;
                            }
                            document.getElementById("ressidentalAddress").value = resaddress;

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

                            //add 11 july
                            let mobile = "";
                            const mobileNoElement = $(res).filter("input#phone_work");
                            if (mobileNoElement.length) {
                                mobiletext = mobileNoElement[0].value;
                                mobile = mobiletext.trim();
                                // 21-july update
                                // if(mobile !="" ){
                                //     $('#memphone2fam').prop('readonly', true);
                                //     $('#memphone2fam').addClass('MIDtext2readonly');
                                //   }
                                //   else{
                                //     $('#memphone2fam').prop('readonly', false);
                                //      $('#memphone2fam').removeClass('MIDtext2readonly')
                                //      $('#memphone2fam').addClass('MIDtext2');
                                //   }

                            }
                            const new_mobile = mobile.replace(/[-)(]/g, "");
                            document.getElementById("memphone2fam").value = new_mobile;



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

                            let ltd = "";
                            const ltdElement = $(res).filter("input#ltd");
                            if (ltdElement.length) {
                                ltd = ltdElement[0].value;
                            }
                            document.getElementById("ltd1").value = ltd;

                            let ytd = "";
                            const ytdElement = $(res).filter("input#ytd");
                            if (ytdElement.length) {
                                ytd = ytdElement[0].value;
                            }
                            document.getElementById("ytd1").value = ytd;


                            let cat = "";
                            const catElement = $(res).filter("input#membercategory");
                            if (catElement.length) {
                                cat = catElement[0].value;
                            }
                            document.getElementById("MembCategory").value = cat;

                            checkPujaRegistration(Memberid);


                        }

                    });
                } else {
                    $("#MemberName").val("");
                    $("#phone").val("");
                    //10 july update
                    //$("#Your_E-mail").val("");
                    $("#email").val("");
                    $("#email2").val("");
                    $("#First_name").val("");
                    $("#last_name").val("");


                    $("#memberid").val("");

                    //10 july update
                    //$("#spousename").val("");
                    $("#spouseFirst_name").val("");
                    $("#spouselast_name").val("");
                    $("#memphone2fam").val("");


                    $("#Street").val("");
                    $("#ressidentalAddress").val("");
                    $("#state").val("");
                    $("#city").val("");
                    $("#zip_code").val("");
                    $("#phone").val("");
                    $("#email").val("");
                    $("#ltd1").val("");
                    $("#ytd1").val("");
                    $("#MembCategory").val("");
                    $("#total").val("");
                    $("#futureytd").val("");
                }
            }
        }

        function showGreenFieldParkingPopup() {
            var modal = document.getElementById("greenFieldParkingModal");
            var decision = document.getElementById("greenFieldParkingDecision");
            if (modal) {
                modal.style.display = "flex";
            }
            if (decision) {
                decision.value = "";
            }
        }

        function handleGreenFieldParkingChoice(choice) {
            var modal = document.getElementById("greenFieldParkingModal");
            var decision = document.getElementById("greenFieldParkingDecision");

            if (decision) {
                decision.value = choice;
            }
            if (modal) {
                modal.style.display = "none";
            }

            if (choice == "Cancelled") {
                document.getElementById("donation-frm-id").reset();
                return;
            }

            if (choice == "donation") {
                document.getElementById("total").focus();
            }
        }

        function ListCreate() {

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

                if (ytd == 0 || ytd == null || ytd == "") {
                    $('#diamondtr').append(`<td class="td"  id="newdiamondtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngrand" class="form-control" value= "${diamondfinal}"></td>`);
                    $('#emeraldtr').append(`<td class="td" id="newemeraldtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btngold" class="form-control" value="${emeraldfinal}"></td>`);
                    $('#platinumtr').append(`<td class="td" id="newplatinumtd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver" class="form-control" value="${platinumfinal}"></td>`);
                    $('#goldtr').append(`<td class="td" id="newgold"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;" readonly type="text" id="btnsilver" class="form-control" value="${Goldfinal}"></td>`);
                    $('#silvertr').append(`<td class="td" id="newsilvertd"><input style="font-size:20px;font-weight:bold;color:rgb(173 255 47);background-color:black;text-align: center;"  readonly type="text" id="btnplat" class="form-control" value="${silverfinal}"></td>`);
                }
                else if (parseFloat(ytd) < donationYtdTierMin('silver', 750)) {

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

                else if (donationYtdTierIs(ytd, 'silver')) {

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
                else if (donationYtdTierIs(ytd, 'gold')) {
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
                else if (donationYtdTierIs(ytd, 'platinum')) {
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
                else if (donationYtdTierIs(ytd, 'emerald')) {
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
                else if (donationYtdTierIs(ytd, 'diamond')) {
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



        // function buttonval(e){
        //   //debugger;
        // var selectamount = e.attributes.value.nodeValue;
        //  $("#total").val(selectamount);
        //  var modal = document.getElementById("myModal");
        //   modal.style.display = "none";
        // }

        $('#close').click(function (e) {
            //debugger
            var modal = document.getElementById("myModal");
            modal.style.display = "none";

        });

        // end

        function myFunction() {
            //debugger;
            //alert('hello');
            var txtstarttime = $("#sponsor option:selected").text();
            var mynewytd = <?php echo json_encode($newytd ?? 0); ?>;
            if (txtstarttime != "") {
                $('#sponsoreventcategory2').attr('disabled', true);
                $("#sponsoreventcategory2").val("");
            } else {
                $('#sponsoreventcategory2').attr('disabled', false);
                $("#sponsoreventcategory2").val("");
            }
            var selected = [];
            for (var option of document.getElementById('sponsor').options) {
                if (option.selected) {
                    selected.push(option.value);
                }
            }
            selectpuja = selected;
            var donationDiamondMin = donationYtdTierMin('diamond', 5000);
            var donationDoubleDiamondMin = donationDiamondMin * 2;
            if (mynewytd >= donationDiamondMin && mynewytd < donationDoubleDiamondMin) {
                if (selectpuja.length > 1) {
                    selectpuja.splice(-1);
                    $("#sponsor").val(selectpuja);
                    alert("Please Select only one");
                    $('.selectpicker').selectpicker('deselectAll');
                } else {
                    last_valid_selection = $(this).val();
                }
            }
            if (mynewytd >= donationDoubleDiamondMin) {
                if (selectpuja.length > 2) {
                    selectpuja.splice(-1);
                    $("#sponsor").val(selectpuja);
                    alert("Please Select only Two");
                    $('.selectpicker').selectpicker('deselectAll');
                } else {
                    last_valid_selection = $(this).val();
                }

            }

        }
        // end



        function nextscreen() {
            //debugger;
            var donationArray = <?php echo json_encode($alldonationdata ?? null); ?>;
            var donationcategory = <?php echo json_encode($categorydata ?? null); ?>;
            var registrationdata = "donationpagedata";
            var member_idpay = <?php echo json_encode($memberid ?? null); ?>;
            var paydate = <?php echo json_encode($paydate ?? null); ?>;
            var finaldonationid = <?php echo json_encode($donationid ?? null); ?>;
            var membercategory = <?php echo json_encode($membertype ?? null); ?>;
            var selectsankalpapuja = $("#pujasankalp").val();
            var categone = $("#sponsor option:selected").text();
            var categtwo = $("#sponsoreventcategory2").val();
            var totalnewytd = <?php echo json_encode($newytd ?? 0); ?>;

            if (donationYtdTierIs(totalnewytd, 'emerald') && selectsankalpapuja !== "" && selectsankalpapuja != undefined) {
                pujasankalpaattempt1 = '1';
                pujasankalpaattempt2 = '0';
            }
            else if (donationYtdTierIs(totalnewytd, 'diamond') && selectsankalpapuja !== "" && selectsankalpapuja != undefined) {
                pujasankalpaattempt1 = '0';
                pujasankalpaattempt2 = '1';
            }
            else {
                pujasankalpaattempt1 = '';
                pujasankalpaattempt2 = '';
            }

            if ((selectsankalpapuja != "" && selectsankalpapuja != undefined) ||
                (categone != "" && categone != undefined) ||
                (categtwo != "" && categtwo != undefined)) {
                pujanamecategory = [selectsankalpapuja, membercategory, registrationdata];
                $.ajax({
                    type: "POST",
                    data: donationCsrfData({
                        finaldonationid: finaldonationid,
                        sankalpapuja: selectsankalpapuja,
                        categone: categone,
                        categtwo: categtwo,
                        member_idpay: member_idpay,
                        paydate: paydate,
                        pujasankalpaattempt1: pujasankalpaattempt1,
                        pujasankalpaattempt2: pujasankalpaattempt2
                    }),
                    //url: "https://durgabari.org/HDBS_PaymentNew/load.php?controller=RentalBooking&action=locationprice",
                    url: "<?php echo INSTALL_URL; ?>load.php?controller=PujaDonations&action=pujaparkingdata",

                });
            }
            if (selectsankalpapuja != "" && categone != "" && categtwo !== undefined && categtwo !== "") {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#submitbuttontr").hide();
                $("#sankalpaselected").show();
                $("#event1").show();
                $("#event2").show();
                document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
                document.getElementById('sponsoreventame').innerHTML = categone;
                document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;

                if (selectsankalpapuja != "") {
                    window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
                    //window.location.replace("http://localhost/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
                    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
                    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
                }


            }
            else if (selectsankalpapuja != "" && categone == "" && categtwo != "" && categtwo == undefined) {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#submitbuttontr").hide();
                $("#sankalpaselected").show();
                $("#event1").hide();
                $("#event2").hide();
                document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
                if (selectsankalpapuja != "") {
                    window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
                    //window.location.replace("http://localhost/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
                    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
                    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
                }

            }
            else if (selectsankalpapuja == undefined && categone == "" && categtwo != "") {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#submitbuttontr").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#sankalpaselected").hide();
                $("#event1").hide();
                $("#event2").show();
                document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;

            }

            else if (selectsankalpapuja != "" && categone == "" && categtwo == "") {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#submitbuttontr").hide();
                $("#sankalpaselected").show();
                $("#event1").hide();
                $("#event2").hide();
                document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
                if (selectsankalpapuja != "") {
                    window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
                    //window.location.replace("http://localhost/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
                    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
                    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
                }
            }
            else if (selectsankalpapuja != "" && categone == "" && categtwo != "") {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#submitbuttontr").hide();
                $("#sankalpaselected").show();
                $("#event1").hide();
                $("#event2").show();
                document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
                document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;
                if (selectsankalpapuja != "") {
                    window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
                    //window.location.replace("http://localhost/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
                    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
                    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
                }

            }
            // add new condition start
            else if (selectsankalpapuja == "" && categone != "" && categtwo != "" && categtwo != undefined) {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#submitbuttontr").hide();
                $("#sankalpaselected").hide();
                $("#event1").show();
                $("#event2").show();
                document.getElementById('sponsoreventame').innerHTML = categone;
                document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;

            }

            else if (selectsankalpapuja == "" && categone != "" && categtwo != "" && categtwo == undefined) {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#submitbuttontr").hide();
                $("#sankalpaselected").hide();
                $("#event1").show();
                //$("#event2").show();
                document.getElementById('sponsoreventame').innerHTML = categone;
                //document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;

            }
            // add new condition end

            else if (selectsankalpapuja != "" && categone != "" && categtwo == "") {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#submitbuttontr").hide();
                $("#sankalpaselected").show();
                $("#event1").show();
                $("#event2").hide();
                document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
                document.getElementById('sponsoreventame').innerHTML = categone;
                if (selectsankalpapuja != "") {
                    window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
                    //window.location.replace("http://localhost/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
                    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
                    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
                }

            }
            else if (selectsankalpapuja != "" && categone != "" && categtwo == undefined) {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#submitbuttontr").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#sankalpaselected").hide();
                $("#event1").show();
                $("#event2").hide();
                document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
                document.getElementById('sponsoreventame').innerHTML = categone;
                if (selectsankalpapuja != "") {
                    window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
                    //window.location.replace("http://localhost/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
                    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
                    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
                }
            }

            else if (selectsankalpapuja != "" && categone == "" && categtwo == undefined) {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#submitbuttontr").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#sankalpaselected").show();
                document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
                if (selectsankalpapuja != "") {
                    window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
                    //window.location.replace("http://localhost/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
                    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
                    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
                }
            }

            else if (selectsankalpapuja == "" && categone != "" && categtwo == "") {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#submitbuttontr").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#sankalpaselected").hide();
                $("#event1").show();
                document.getElementById('sponsoreventame').innerHTML = categone;
            }

            else if (selectsankalpapuja == "" && categone == "" && categtwo != "" && categtwo != undefined) {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#submitbuttontr").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#sankalpaselected").hide();
                $("#event2").show();
                document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;
            }
            else if (selectsankalpapuja == "" && categone != "" && categtwo != "") {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#submitbuttontr").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#sankalpaselected").hide();
                $("#event1").show();
                $("#event2").show();
                document.getElementById('sponsoreventame').innerHTML = categone;
                document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;

            }
            else if (selectsankalpapuja != "" && categone != "" && categtwo != "") {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#submitbuttontr").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#sankalpaselected").show();
                $("#event1").show();
                $("#event2").show();
                document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
                document.getElementById('sponsoreventame').innerHTML = categone;
                document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;
                if (selectsankalpapuja != "") {
                    window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
                    //window.location.replace("http://localhost/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
                    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
                    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
                }


            }
            else {
                $("#eligiblemsg").hide();
                $("#sankalpapujamsgprice").hide();
                $("#optiondropdown").hide();
                $("#optiondropdown2").hide();
                $("#submitbuttontr").hide();
                $("#sankalpaselected").hide();
                $("#event1").hide();
                $("#event2").hide();

            }
        }


        function mysponsorcategory2() {
            //debugger;
            var sponsorcat1 = $("#sponsoreventcategory2").val();
            var sponsorcat2 = $("#sponsor").val();
            if (sponsorcat1 != "") {
                //$('#eventone').attr('disabled', true);
                $('.selectpicker').attr("disabled", "disabled");
                $("#sponsor").attr("disabled", "disabled");
                $('.selectpicker').selectpicker('deselectAll');
            } else {
                $('.selectpicker').attr('disabled', false);
                $('#sponsor').attr('disabled', false);
                $('.selectpicker').selectpicker('deselectAll');

            }

        }

        function openReturningUserOtpForDonation() {
            if (typeof window.OtpMemberVerify === 'undefined') {
                alert('OTP verification is not available. Please refresh and try again.');
                return false;
            }
            window.OtpMemberVerify.open({
                onVerified: function (memberId) {
                    var verifiedMemberId = memberId || '';
                    $('#otp-session-verified').text(verifiedMemberId);
                    $('#termMember').val(verifiedMemberId);
                    $('#term').val('Verified Member ' + verifiedMemberId).prop('readonly', true).attr('autocomplete', 'off');
                    $('#IDMembertd').hide().addClass('disabledbutton');
                    $('#otp-gate').hide();
                    $('#otp-verified-banner').show();
                    MemberSelectdonation();
                }
            });
            window.onOtpModalCancelled = function () {
                $('#registrationmember').val('');
                $('#otp-gate').hide();
                $('#otp-verified-banner').hide();
            };
            return true;
        }

        $(document).on('click', '#otp-gate-btn', function () {
            openReturningUserOtpForDonation();
        });

        $(document).on('change', '#registrationmember', function () {
            var regmember = $.trim($(this).val() || '');
            var otpAdminBypass = $.trim($('#otp-admin-bypass').text() || '') === '1';

            if (regmember !== 'member') {
                return;
            }

            if (otpAdminBypass) {
                $('#otp-gate').hide();
                $('#otp-verified-banner').hide();
                $('#IDMembertd').show().removeClass('disabledbutton');
                $('#term').prop('readonly', false);
                return;
            }

            var verifiedMemberId = $.trim($('#otp-session-verified').text() || '');
            if (verifiedMemberId) {
                $('#termMember').val(verifiedMemberId);
                $('#term').val('Verified Member ' + verifiedMemberId).prop('readonly', true).attr('autocomplete', 'off');
                $('#IDMembertd').hide().addClass('disabledbutton');
                $('#otp-gate').hide();
                $('#otp-verified-banner').show();
                MemberSelectdonation();
            } else {
                $('#otp-verified-banner').hide();
                $('#IDMembertd').hide().addClass('disabledbutton');
                $('#term').prop('readonly', true).attr('autocomplete', 'off');
                openReturningUserOtpForDonation();
            }
        });

        $(document).ready(function () {
            if ($.trim($('#otp-session-verified').text())) {
                $('#registrationmember').val("member").trigger('change');
            }
        });

    </script>