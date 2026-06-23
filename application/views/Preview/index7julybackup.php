<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>HDBS</title>
        <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style>
            .row{
                float: left;
                width: 100%;
            }
            .navigation{
                padding: 0px;
                margin:-0px; 
                box-shadow:0px 0px 0px 5px rgb(255 255 255 / 40%), 0px 4px 10px rgb(0 0 255);
                float: left;
                width: 100%;
            }
            #amc ul, #abc ul{
                padding: 0 20px;
                margin: 10px;
            }

            #amc ul li, #abc ul li{
                margin: 1em;
                margin: 1em 0;
                width: 100%;
            }

            .nav_left{
                width:50% ;
                float: left;
            }
            .nav_right{
                height:50% ;
                float:right;
                padding: 20px;
            }
            .nav_right a {
                font-size: 20px;
                overflow: hidden;
                padding: 10px;
                margin: 5px;

            }
            .btn {
                display: inline-block;
                width: 131px;
                border: 1px solid #2819cd;
                color: #2819cd;
                text-align: center;
                padding: 7px 0px;
                border-radius: 6px;
                margin: 0px 15px;
                font-weight: 700;
                cursor: pointer;
            }
            .container{
                box-shadow: 0px 8px 16px 0px;
                background-color:white;
                width: 750px;
                height:300px;
                border-radius:15px;
                margin-left: 350px;
                font-size:19px;

            }

            #amc{
                width: 25%;
                float: left;
                padding-top: 10px;
            }
            #abc{
                width: 25%;
                float: left;
                padding-top: 30px;
            }
            #ndr{
                width: 50%;
                float: left;
                padding-top: 40px;
            }

            @media only screen and (max-width: 1280px){
                #amc ul{
                    padding: 0;
                }
                #amc a{
                    width: 102%;
                }
                #abc ul{
                    padding: 0;
                }
                #abc a{
                    width: 100%;
                }
                #amc{
                    width: 25%;
                    float: left;
                }
                #abc{
                    width: 25%;
                    float: left;
                    padding-top: 30px;
                }
                #ndr{
                    width: 50%;
                    float: left;
                    padding-top: 40px;
                }
                #amc a span  p{
                    font-size:38px;
                }
                #amc ul li a h2{
                    font-size: 42px;
                }
                #abc a span  p{
                    font-size:35px;
                }
                #abc ul li a h2{
                    font-size: 39px;
                }
            }

            @media only screen and (max-width: 1160px){

                #amc{
                    width: 100%;
                    padding: 20px 50px;
                }
                #abc{
                    width: 100%;
                    padding: 20px 50px;
                }
                #ndr{
                    width: 100%;
                    padding: 20px 50px;
                }
                .amd a {
                    width: 100%;
                }
                .ab a {
                    width: 100%;
                }
                #amc a span  p{
                    font-size: 38px;
                }
                #amc ul li a h2{
                    font-size: 42px;
                }
                #abc a span  p{
                    font-size:35px;
                }
                #abc ul li a h2{
                    font-size: 39px;
                }
            }
            @media only screen  and (min-width: 1282px) and (min-width : 1824px) {
                #gz-abc-main-container {
                    margin-top:0px;
                    width:47%!important; 
                    height:0px;
                    margin-left:0px;
                } 
                #amc{
                    margin-left:175px!important;
                }
                #ndr{

                } 
                #abc > ul > li{
                    margin-top: 512px!important;
                    margin-left: -467px!important;
                }

                #vid{
                    transform: translateX(298%);
                }
                #amc a span  p{
                    font-size: 38px;
                }
                #amc ul li a h2{
                    font-size: 42px;
                }
                #abc a span  p{
                    font-size:35px;
                }
                #abc ul li a h2{
                    font-size: 39px;
                }
            } 
            /* @media screen and (max-width: ) */

            @media only screen  and (min-width: 1825px) and (min-width : 1920px )  {
                #gz-abc-main-container {
                    margin-top:0px;
                    width:120%!important;  
                    height:0px;
                    margin-left:0px;
                } 
                #amc{
                    margin-left:22px!important;
                }
                #abc > ul > li{
                    margin-top:11px!important;
                    margin-left:44px!important;
                }
                #vid{
                    transform: translateX(83%);
                }
                #amc a span  p{
                    font-size: 38px;
                }
                #amc ul li a h2{
                    font-size: 42px;
                }
                #abc a span  p{
                    font-size:35px;
                }
                #abc ul li a h2{
                    font-size: 39px;
                }
            } 



            /* Sticker css */
            h2 {
                font-weight: bold;
                font-size: 2rem;
            }
            p {
                font-size: 19px;
                margin-top:-23px;
                font-family: 'Reenie Beanie';

            }
            ul,li{
                list-style:none;
            }
            ul{
                display: flex;
                flex-wrap: wrap;
                /* justify-content: center; */
            }
            ul li a{
                text-decoration:none;
                color:#000;
                background:#ffc;
                display:block;
                min-height:31em;
                width:100%;
                padding:1em;
                word-break: keep-all;
                box-shadow: 5px 5px 7px rgba(33,33,33,.7);
                transform: rotate(0deg);
                transition: transform .15s linear;
            }

            .amd a{
                transform:rotate(0deg);
                position:relative;
                top:5px;
                background:#ffc;
            }
            .ab a{
                transform:rotate(0deg);
                position:relative;
                top:-5px;
                background:#cfc!important;
            }
            ul li:nth-child(5n) a{
                transform:rotate(0deg);
                position:relative;
                top:-10px;
            }

            ul li a:hover,ul li a:focus{
                box-shadow:10px 10px 7px rgba(0,0,0,.7);
                transform: scale(1.25);
                position:relative;
                z-index:5;
            }  

            .gzABCalButton {
                display:none!important;
            }
            .gzABCalCellSlots{
                display:none!important;
            }

            ul li{
                margin:1em;
            }
            .w3-display-topright {
                position: absolute;
                right: -132px;
                top: 0;
                color: white;
                background-color: royalblue;
            }
            .hdb{
                font-size:25px;
            }
        </style>
    </head>
    <body>
         <div class="row">
    <div class="col-lg-6 col-xs-2">
        <div class="navigation">
            <div class="nav_left">
                <img src="../full_logo.png">
            </div>
            <div class="nav_right">
                <a class="btn"href='https://durgabari.org/HDBS_Payment/Preview/index'>Home</a>
                <!--<a class="btn"href='https://durgabari.org/HDBS_Payment/Admin/login'>Login</a>&nbsp;  
                <a  class="btn" href='https://durgabari.org/HDBS_Payment/Member/create'>Register</a>-->
            </div>
        </div>
        </div>
        </div>
        <!-- Sticker section start -->
        <div class="row">
            <div class="col-sm-12 col-lg-4 col-md-4 amd" id="amc">
                <ul>
                    <li>
                        <a href="#">
                            <h2 class="hdb">HDBS Priest Service Reservation</h2>&nbsp;&nbsp;<br><br>
                            <span>
                                <p>
                                    Please select a date on the Calendar to start making your reservation. Please read detailed instructions.<br><br>
                                    <b> Contact <span style="color:#005a9c;">priest@durgabari.org</span> if you have questions before making the reservation.</b>
                                </p>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-12 col-lg-4 col-md-4" id="ndr" >
                <script type="text/javascript" src="<?php echo INSTALL_URL; ?>index.php?controller=GzFront&action=load&cid[]=<?php echo (empty($_REQUEST['calendars_id'])) ? $tpl['arr'][0]['id'] : implode('&cid[]=', $_POST['calendars_id']); ?>&view_month=<?php echo (empty($_POST['months'])) ? '1' : $_POST['months']; ?>"></script>
            </div>

            <div class="col-sm-12 col-lg-4 col-md-4 ab" id="abc" >
                <ul>
                    <li style="margin-top:6px; width: 100%;">
                        <a href="#">
                            <h2>Reservation Steps</h2>&nbsp;
                            <span> 
                                <p><b>You can reserve any Puja in 3 simple steps:</b><br>
                                    1. Select Puja date by clicking on the calendar.<br>
                                    2. Select a Puja slot.<br>
                                    3. Fill in the details and make payment.<br>
                                    You will receive a confirmation receipt once the reservation is done.For more details, please see the video.</p>
                            </span>

                        </a>
                    </li>
                </ul>
                <i class="fa fa-video-camera" id="vid"  onclick="document.getElementById('id01').style.display = 'block'" style="color:#1e90ff;font-size:-webkit-xxx-large; margin-top: -49px; margin-left:64px;"></i> 
            </div>
        </div>

        <div class="w3-container">
            <div id="id01" class="w3-modal">
                <div class="w3-modal-content">
                    <div class="w3-container">
                        <span onclick="document.getElementById('id01').style.display = 'none'" class="w3-button w3-display-topright">&times;</span>
                        <img src="../book_REC.gif" alt="Trulli" width="120%" height="120%">
                    </div>
                </div>
            </div>   
        </div> 
    </body>
</html>
<script>
    $(document).ready(function () {
        all_notes = $("li a");

        all_notes.on("keyup", function () {
            note_title = $(this).find("h2").text();
            note_content = $(this).find("p").text();

            item_key = "list_" + $(this).parent().index();

            data = {
                title: note_title,
                content: note_content
            };

            window.localStorage.setItem(item_key, JSON.stringify(data));
        });

        all_notes.each(function (index) {
            data = JSON.parse(window.localStorage.getItem("list_" + index));

            if (data !== null) {
                note_title = data.title;
                note_content = data.content;

                $(this).find("h2").text(note_title);
                $(this).find("p").text(note_content);
            }
        });
    });

</script>