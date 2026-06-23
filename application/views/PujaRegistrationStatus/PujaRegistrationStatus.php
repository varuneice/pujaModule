<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<style>
.swal2-popup {
            font-size: 20px; /* Increase font size */
            font-weight:bold;
            width: 400px; /* Increase width */
            height: auto; /* Adjust height */
        }
        .swal2-title {
            font-size: 22px;
            font-weight:bold; 
        }
        .swal2-content {
            font-size: 25px;/* Increase content font size */
        }
        .swal2-confirm {
            font-size: 12px;/* Increase button font size */
            padding: 10px 20px; /* Increase button padding */
        }
    @property --angle {
        syntax: "<angle>";
        initial-value: 0deg;
        inherits: false;
    }

    .search-container::before {
        --deg: 0deg;
        content: '';
        position: absolute;
        width: calc(100% + .3rem);
        height: calc(100% + .3rem);
        background: linear-gradient(var(--angle, 0deg), #e66465, transparent, #3b82f6);
        z-index: -1;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 1rem;
        animation: rotate 2s infinite;
    }

    @keyframes rotate {
        to {
            --angle: 360deg;
        }
    }
    .layout {
        max-width: 100%;
        margin: 0 auto;
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
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
        /*margin-top: 30px;*/
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

    input.MIDtext3 {
        padding: 12px;
        font-size: 20px;
        margin-top: 20px;
        border-radius: 10px;
        width: 100%;
    }

    .table {
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
        overflow: hidden;
    }

    .table thead tr {
        background-image: none !important;
        font-size: 1em !important;
        background-color: #ef4444;
        color: #fff;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .table thead tr th:first-child {
        border-top-left-radius: 1rem;
    }

    .table thead tr th:last-child {
        border-top-right-radius: 1rem;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #0ea5e9;
        color: #fff;
    }

    .table tbody tr:nth-child(even) {
        background-color: #8b5cf6;
        color: #fff;
    }

    .table tbody tr td {
        transition: all 300ms ease-in-out;
    }

    .table tbody tr:hover td {
        background-color: #000;
        color: #fff;
    }

    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 1rem;
    }

    .table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 1rem;
    }

    input.MIDtext3 {
        margin-top: 0;
        border: none;
    }
</style>
<title>Puja Registration Status</title>
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

<section class="page-title" style="background-image:url(<?php echo INSTALL_URL; ?>12.jpg);">
    <div class="auto-container">
        <div class="row clearfix">
            <!--Title -->
            <!--<div class="title-column col-lg-6 col-md-12 col-sm-12">-->
            <!--    <img style="float:left;padding:20px" src="../1.svg" width="35%">-->
            <!--   <img style="border-radius: 96px;float: left;padding: 0px;" src="../puja_logo.png" width="37%">-->
            <!--</div>-->
            
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
                <h3>Check Puja Registration Status</h3>
                <ul class="bread-crumb clearfix">
                            <li><a style="text-decoration:none;color:#fff;"
                                    href="<?php echo INSTALL_URL; ?>onlinepujapayments/onlinepujapayments">Home
                                </a></li>
                            <li class="active">Puja Registration Status</li>
                        </ul>
            </div>
        </div>
    </div>
</section>

<div class="container" style="position: relative;padding: 40px 0px 60px;">
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div>
                <div class="clear"></div>
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-9">
                        <div class="search-container position-relative mb-3">
                            <input type="text" name="term" id="term" placeholder="search records here.... *"
                                class="MIDtext3" tabindex="2" required>
                        </div>
                        <input type="text" style="display:none" name="termMember" id="termMember"
                            placeholder="search member here...." class="MIDtext2 form-control">
                        <div class="text_placeholders">Search by : First Name, Last Name, Zip, MID *</div>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <button type="reset" id="btnReset" class="go_cart_btn btn-lg">Reset</button> 
                    </div>
                </div>
            </div>
        </div>
        <div id="tblPujaRegistrationStatus" class="pt-3" style="display:none;">
            <table width="100%" class="table table-hover" id="">
                <thead>
                    <tr>
                        <th>Member Id</th>
                        <th>Member Name</th>
                        <th>Spouse Name</th>
                        <th>Puja Type</th>
                        <th>Family Status</th>
                        <th>Registration Date</th>
                        <th>Registration Status</th>
                    </tr>
                </thead>
                <tbody id="tblRegistrationStatus">
                
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function () {
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
                getRegistrationStatus(this);
            },
            onclick: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                getRegistrationStatus();
            },
            onchange: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                getRegistrationStatus();
            },
        });
        $("#term").on("keydown", function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
                getRegistrationStatus();
            }
        });
        $("#term").on("change blur", function () {
            if ($.trim($(this).val()) !== "" && /^\d+$/.test($.trim($(this).val()))) {
                getRegistrationStatus();
            }
        });
    });
    ////Lookup.......................End..............................////


    //Method for get  status for memeber is register or not
    function getRegistrationStatus(e) {
        const memberId = $.trim($("#termMember").val() || $("#term").val());
        if (memberId === "") {
            return;
        }
        const url1 = $("#container-abc-url-id").text();
        $.ajax({
            type: "POST",
            data: {
                memberId: memberId
            },
            url: url1 + "load.php?controller=PujaRegistrationStatus&action=GetRegistrationStatus",
            success: function (res) {
                let response = res.match(/{.*}/s);
                if (!response || !response[0]) {
                    $("#tblRegistrationStatus").html("");
                    $("#tblPujaRegistrationStatus").hide();
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        html: "<b>Record Not Found</b>",
                    });
                    return;
                }
                var data = JSON.parse(response[0]);
                if (data.status === 200) {
                    setRegistrationStatus(data.data);
                }
                else if (data.status === 300) {
                    $("#tblRegistrationStatus").html("");
                    $("#tblPujaRegistrationStatus").hide();
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        html: "<b>Record Not Found</b>",
                    });
                }
            }
        });
    }

    //Method for show registration status
    function setRegistrationStatus(obj) {
        let output = "";
        for (i = 0; i < obj.length; i++) {
            const memberId = obj[i].Member_id != null ? obj[i].Member_id : '';
            const firstName = obj[i].First_name != null ? obj[i].First_name : '';
            const lastName = obj[i].Last_name != null ? obj[i].Last_name : '';
            const pujaType = obj[i].puja_type != null ? obj[i].puja_type : '';
            const pujaDate = obj[i].pay_date != null ? obj[i].pay_date : '';
            const paymentStatus = obj[i].payment_status != null ? obj[i].payment_status : '';
            const spouseFName = obj[i].Sp_fname != null ? obj[i].Sp_fname : '';
            const spouseLName = obj[i].Sp_lname != null ? obj[i].Sp_lname : '';
            const familyStatus = obj[i].member_status != null ? obj[i].member_status : '';
            output += `<tr>
            <td style="white-space:normal;">${memberId}</td>
            <td style="white-space:normal;">${firstName + " " + lastName}</td>
            <td style="white-space:normal;">${spouseFName + " " + spouseLName}</td>
            <td style="white-space:normal;">${pujaType}</td>
            <td style="white-space:normal;">${familyStatus}</td>
            <td style="white-space:normal;">${pujaDate}</td>
            <td style="white-space:normal;">${paymentStatus}</td>
        </tr>`;
        }
        if (output) {
            $("#tblRegistrationStatus").html("");
            $("#tblRegistrationStatus").html(output);
            $("#tblPujaRegistrationStatus").show();
        }
        else {
            $("#tblRegistrationStatus").html("");
            $("#tblPujaRegistrationStatus").hide();
        }
    }
    
    function dataReset(){
        $("#termMember").val("");
        $("#term").val("");
        $("#tblRegistrationStatus").html("");
        $("#tblPujaRegistrationStatus").hide();
    }

    $("#btnReset").click(function() {
        dataReset();
    });
</script>
