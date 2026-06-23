<head>
    <title>Under Construction</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />


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
            padding: 10px 0px 10px;
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
    </style>


    <section class="page-title" style="background-image:url(<?php echo INSTALL_URL; ?>12.jpg);">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Title -->
                <div class="title-column col-lg-6 col-md-12 col-sm-12">
                    <img style="float:left;padding:20px" src="../1.svg" width="30%">
					<img style="border-radius: 96px;float: left;padding: 0px; margin-top: 2rem;" src="../merchandise.jpg" width="20%">
                </div>
                <!--Bread Crumb -->
                <div class="breadcrumb-column col-lg-6 col-md-12 col-sm-12">
                    <h1>Houston Durga Bari Society</h1>
                    <h3>FAQs</h3>
                    <!-- <h4><span>Contact : </span><a href="mailto:registration@durgabari.org"> registration@durgabari.org</a></h4>-->
                    <ul class="bread-crumb clearfix">
                        <li><a style="text-decoration:none;color:#fff;"
                                href="<?php echo INSTALL_URL; ?>onlinepujapayments/onlinepujapayments">Home</a>
                        </li>
                        <li class="active">FAQs</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">


            <iframe src="../FAQ2025.pdf#toolbar=0" width="100%" height="600px" style="border:none;"></iframe>


            <a href="../FAQ2025.pdf" download="MyDocument.pdf" class="btn btn-primary mt-3">
                Download PDF
            </a>
        </div>
    </div>

    <br><br><br><br>
