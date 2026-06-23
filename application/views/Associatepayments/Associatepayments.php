<head>
<title>
        <?php
        $currentYear = date('Y');
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "04-01") {
            $currentYear = $currentYear - 1; 
        }
        echo "" . $currentYear . " PUJA REGISTRATION ASSOCIATED SYSTEM ";
        ?>
    </title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
.swal2-popup {
        font-size: 20px;
        font-weight: bold;
        width: 400px;
        height: auto;
    }

    .swal2-title {
        font-size: 22px;
        font-weight: bold;
    }

    .swal2-content {
        font-size: 25px;
    }

    .swal2-confirm {
        font-size: 12px;
        padding: 10px 20px;
    }
.wrapper {text-align: center; font-family: Arial, Helvetica, sans-serif;}
.a-box-special a {box-sizing: border-box; width: 379px; height: auto; text-decoration: none; padding: 10px; font-size: 30px; text-transform: uppercase; font-weight: 600; letter-spacing: 0.7px; cursor: pointer; border: none;}
.a-box-special { background: red;}
.a-box-special a:focus { outline: none;}
.btn_durga { background: #fff; color: #000; border: 2px solid red; border-radius: 5px;  transition: background 400ms ease-out, color 400ms ease-out; }
.btn_durga:hover { background: #000; color: #fff; border-radius: 5px; }
.layout { max-width: 100%; margin: 0 auto; display: flex; flex-flow: row wrap; justify-content: center;}
.a-box, .a-box-special {width: 30%!important; height: 155px; margin: 10px; display: flex; justify-content: center; align-items: center;}
body{background-color:#000!important;}
.page-title {position: relative; color: #ffffff; padding: 40px 0px 40px; background-position: center center; background-size: cover; background-repeat: no-repeat;}
.page-title:before {position: absolute; content: ''; left: 0px; top: 0px; width: 100%; height: 100%; display: block; background-color: rgba(0, 0, 0, 0.80);}
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
.help-widget .text {position: relative; color: #777777; font-size: 14px; line-height: 1.9em; margin-bottom: 15px;}
.help-widget .list {position: relative;}
.help-widget .list li {position: relative; color: #777777; font-size: 14px; line-height: 1.9em; padding-left: 30px; margin-bottom: 8px;}
select.choice {width:100%;padding: 10px;color: #fff;background-color: #ef260f; border-radius: 15px;}
select.choice2 { width: 100%; padding: 10px; margin-top: 20px; color: #fff; background-color: #ef260f; border-radius: 15px;}
select.choice3 { width: 100%; padding: 10px; margin-top: 0px; color: #fff; background-color: #ef260f; border-radius: 15px;}
input.MIDnumber {padding: 10px;margin-top: 3px;border-radius: 10px;}
input.MIDtext {padding: 10px; margin-top: 3px; border-radius: 10px;}
input.MIDtext2 {padding: 10px; margin-top: 20px; border-radius: 10px;}
input.number {padding: 10px;margin-top: 20px;border-radius: 10px;}
.checkbox label {font-size: 14px; color: #ef260f; margin-top: 36px;}
input.lookup {width: 100%; padding: 10px; border-radius: 10px;}
button.lookup_btn {padding: 5px; font-size: 21px; border-radius: 10px; width: 50%; background-color: #ef260f; color: #fff; font-weight: 600;}
h4.item_heading {font-size: 30px; padding: 10px;}
p.item_count {color: #ef260f; font-size: 40px; border-right: 3px solid; text-align: right; padding: 10px;}
p.item_count2 {text-align: right; padding: 10px;}
p.item_heading2 {font-size: 14px; padding: 10px;}
h4.item_heading2 {font-size: 20px; padding: 10px;}
span.payment_for {color: #ef260f;}
button.payment_btn {padding: 10px; font-size: 25px; border-radius: 10px; width: 100%; background-color: #ef260f; color: #fff; font-weight: 600;}
.copyright p {color: #fff;text-align: center;}
.myDiv{display:none; padding:10px; margin-top:20px;}  
#showOne{border:1px solid red;}
#showTwo{border:1px solid green;}
#showThree{border:1px solid blue;}
input#yesMG {width: 10%;}

</style>

<div style="background-image:url(../12.png);background-repeat: no-repeat; background-size: cover;">
<section class="page-title" style="background-image:url(<?php echo INSTALL_URL; ?>12.jpg);">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Title -->
                <div class="title-column col-lg-6 col-md-12 col-sm-12">
                    <img style="float:left;padding:20px" src="../1.svg" width="35%">
					<img style="border-radius: 96px;float: left;padding: 0px; margin-top: 2rem;" src="../merchandise.jpg" width="25%">
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
                        echo "" . $currentYear . " PUJA REGISTRATION ASSOCIATED SYSTEM ";
                        ?>
                    </h3>
                    <h4><a href="<?php echo INSTALL_URL; ?>onlinepujapayments/onlinepujapayments">Home / Puja Registration Associated</a></h4>
                  
                </div>
            </div>
        </div>
    </section>
	
	
<div class="container" style="position: relative;padding-top:80px;">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="wrapper">
                <div class="layout">
                    <div class="col-md-4">
                        <!--<a href="<?php echo INSTALL_URL; ?>PujaPaidparking/PujaPaidparking"><img src="../PujaBenefactor.png" width="100%"></a>-->
                        <a onclick="updateMsg('Puja Benefactor')"><img src="../PujaBenefactor.png" width="100%"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo INSTALL_URL; ?>PujaPaidpasses/PujaPaidpasses"><img src="../passes.svg" width="100%"></a> 
                    </div>
                    <div class="col-md-4">
                        <!-- <a href="<?php echo INSTALL_URL; ?>Underconstruction/Underconstruction"><img src="../tickets.svg" width="100%"></a> -->
                        <a onclick="updateMsg('Puja Tickets')"><img src="../tickets.svg" width="100%"></a>
                    </div>
					 <div class="col-md-4">
                        <!-- <a href="<?php echo INSTALL_URL; ?>PujaMagazine/PujaMagazine"><img src="../magazine.svg" width="100%"></a> -->
                        <a onclick="updateMsg('Puja Magazine')"><img src="../magazine.svg" width="100%"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo INSTALL_URL; ?>Help/Help"><img src="../help_n.svg" width="100%"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo INSTALL_URL; ?>Underconstruction/Underconstruction"><img src="../faq-n.svg" width="100%"></a>
                    </div>
                    
					<!--<div class="col-md-4">
                        <a href="https://durgabari.org/HDBS_Puja_Payments/Underconstruction/Underconstruction"><img src="../cart_pay.svg" width="100%"></a>
                    </div>-->
					<img src="../line.svg" width="100%">
					
                </div>
          
                <div class="layout" style="padding-bottom:70px;">
			        <div class="col-md-5">
                        <a href="<?php echo INSTALL_URL; ?>onlinepujapayments/onlinepujapayments"><img src="../puja_regi.svg" width="100%"></a>
                    </div>
			        <div class="col-md-5">
                        <a href="https://durgabari.org/payments/"><img src="../membership.svg" width="100%"></a>
                    </div>
                </div>
           

            </div>
        </div>
    </div>
</div>	

</div>

<script>
    function updateMsg(msgFor){
       let finalMsgHtml = "";
        switch (msgFor) {
            case "Puja Benefactor":
                finalMsgHtml = `<b>Puja Benefactor option is no longer available </b>`;
                break;
            case "Puja Passes":
                finalMsgHtml = `<b>Registration is now closed as the event has ended. Stay tuned! We'll be back soon.</b>`;
                break;
            case "Puja Tickets":
                finalMsgHtml = `<b>Registration is now closed as the event has ended. Stay tuned! We'll be back soon.</b>`;
                break;
            case "Puja Magazine":
                finalMsgHtml = `<b>Registration is now closed as the event has ended. Stay tuned! We'll be back soon.</b>`;
                break;
        }
        Swal.fire({
            icon: "info",
            title: msgFor,
            html: finalMsgHtml,
        });
    }
</script>

