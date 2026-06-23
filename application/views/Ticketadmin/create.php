<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    @media only screen and (max-width: 499px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media (min-width: 500px) and (max-width: 767px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media (min-width: 768px) and (max-width: 830px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media(min-width: 831px) and (max-width: 990px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    th {
        border: 1px solid black;
        text-align: left;
        background-color: #f6f6f6;
        border-collapse: collapse;
    }
</style>

<section class="content-header">
    <h1>
        <?php echo __('Add Ticket'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                <?php echo __('home'); ?>
            </a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Eventadmin/index"><?php echo __('title_ticket'); ?></a></li>
        <li class="active">
            <?php echo __('create_ticket'); ?>
        </li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Ticketadmin/create"
        method="post" name="create" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <table class="table" id="eventsecond">
                    <tr class="tr">
                        <th>Event Name</th>
                        <th>Image</th>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                                <select data-rule-required='true' required name="ticketevents" id="ticketevent" class="form-control input-sm" >
                                 <option value="">Select Puja Type</option>
                                 <option value="kalipuja">Kali Puja </option>
                                 <option value="saraswatipuja">Saraswati Puja</option>
                                </select> 
                            </td>
                        <td class="td" colspan="5"><input class="form-control" type="file" name="image"></td>
                    </tr>
                </table>
                <div style="border: 1px solid mediumvioletred;" id="desdiv">
                    <p><label for="description">Description:</label></p>
                    <textarea id="description" class="form-control input-sm" name="descriptionTable" value=""
                        placeholder="To add message details, put a full stop after each line." rows="4" cols="50"
                        style="border: 1px solid mediumvioletred;"></textarea>
                </div>
                <br>
                <div id="ticketaddfield" style="display:none;">
                    <!-- <input type="button" onclick='addMoreField()' class="no add1" value="Add More Field" style="cursor: pointer;"> -->
                    <i class="fa fa-plus" id="addmore"  onclick='addMoreField()'
                        style="font-size:25px;color:green;cursor:pointer;">Add Field</i>
                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="contactContainername">
                            <label for="contact">Event Day:</label>


                            <div id="contactName_0" class="flex contactname">
                                <select class="form-control input-sm" id="ticketday" name="itemeventday[]"  onchange="ticketprice(this.id)" >
                                </select>
                                <br>
                                <!-- <input class="removeButton" type="button" onclick='removeField(0)' value="Remove" style="cursor: pointer;display:none"> -->
                                <i class='fa fa-trash' id='removeButton' onclick='removeField(0)'
                                    style="font-size: 20px;color: red;cursor: pointer;position: relative;bottom: 9px;display:none"></i>
                                <br>

                            </div>

                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="contactContainer">

                            <label for="contact">Price:</label>

                            <div id="contactNo_0" class="flex contact">
                                <input id="validationcontact" name="ticketprice[]" type="text" class="form-control"
                                    placeholder="$100">
                                <input type="button" class="ar add" value="Add More Field" style="cursor: pointer;"
                                    hidden>&nbsp;&nbsp;
                                <br>
                                <span class="ar remove"><label style="cursor: pointer; padding-top: 5px;"><i
                                            style="width: 20px; height: 20px; color: lightseagreen;"
                                            data-feather="x"></i></label></span>
                                <br>

                            </div>
                        </div>
                    </div>
                </div>


                <fieldset>
                    <input type="hidden" name="create" value="1" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>"
                        name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;
                        <?php echo __('save') ?>
                    </button>
                </fieldset>
            </fieldset>



        </div>

    </form>
</section>
<script>

    function addMoreField() {
        var maxField = 4;
        var addButton = $('#addmore');
        const $contactContainername = $('#contactContainername');
        const $contactContainerNo = $('#contactContainer');
        const $contactNameinput = $contactContainername.find(".contactname");
        const $contactNoInput = $contactContainerNo.find(".contact");

        const $newContactNameinput = $contactNameinput.eq(0).clone(true);
        $newContactNameinput.find("[name=contactname]").attr("id", `contactNameInput_${$contactNameinput.length}`).val("");
        $newContactNameinput.attr("id", `contactName_${$contactNameinput.length}`);
        const removeButton = $newContactNameinput.find("#removeButton");
        removeButton.attr("onclick", `removeField(${$contactNameinput.length})`);
        removeButton.show();

        const $newContactNoinput = $contactNoInput.eq(0).clone(true);
        $newContactNoinput.attr("id", `contactNo_${$contactNameinput.length}`);
        $newContactNoinput.find("[name=contact]").attr("id", `contactNoInput_${$contactNoInput.length}`).val("");


        $contactContainername.append($newContactNameinput);
        $contactContainerNo.append($newContactNoinput);

        
    }

    function removeField(id) {

        if (id === 0) return;
        const $contactContainername = $('#contactContainername');
        const $contactContainerNo = $('#contactContainer');

        const $contactNameinput = $contactContainername.find(`#contactName_${id}`);

        const $contactNoinput = $contactContainerNo.find(`#contactNo_${id}`);

        $contactNameinput.remove();
        $contactNoinput.remove();

        // new changes
        allticketday = document.getElementById("ticketday").length;
        var finalticket = allticketday - 1;
        var priceticketdiv = $('#contactContainername div').length;
        if(finalticket == priceticketdiv){
        $("#addmore").hide();
        }
       if(finalticket != priceticketdiv){
        $("#addmore").show();
       }

    }


function ticketprice(){

    var allticketday = document.getElementById("ticketday").length;
    var finalticket = allticketday - 1;
        var priceticketdiv = $('#contactContainername div').length;
        var eventday = $("#ticketday").val();

        if(finalticket == priceticketdiv){
        $("#addmore").hide();
        }
       if(finalticket != priceticketdiv){
        $("#addmore").show();
       }

}

    $("#startickettdate").change(function () {
        //
        var ticketd1 = document.getElementById("startickettdate").value;
        var ticketd2 = document.getElementById("endticketdate").value;
        let date1 = new Date(ticketd1).getTime();
        let date2 = new Date(ticketd2).getTime();

        if (date1 < date2) {
            //alert("hi");

        } else if (date1 > date2) {
            alert("Start date should be less than End date");
            document.getElementById("startickettdate").value = "";;
        } else {
            //alert("by");
        }

    });


    ////Ticket Date time Section end................................................................................///////
    ////Ticket Date time Section start..............................................................................///////
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    $('#startickettdate').attr('min', today);
    // Startdate Previous Date disabled from current date.....

    //End date should be greater than start date........
    $("#endticketdate").change(function () {
        var startickettdate = document.getElementById("startickettdate").value;
        var endticketdate = document.getElementById("endticketdate").value;

        if ((Date.parse(startickettdate) > Date.parse(endticketdate))) {
            alert("End date should be greater than Start date");
            document.getElementById("endticketdate").value = "";
        }
    });

    ///END time should be greater/................/////
    $("#endtickettime").change(function () {
        //
        var starttickettime = document.getElementById("starttickettime").value;
        var endtickettime = document.getElementById("endtickettime").value;

        //if ((Date.parse(starttime) > Date.parse(endtime))) {
        if (Date.parse('01/01/2011 ' + starttickettime) >= Date.parse('01/01/2011 ' + endtickettime)) {
            alert("End time should be greater than Start time");
            document.getElementById("endtickettime").value = "";
        }
    });
    ///END time should be greater....////////
    ////Ticket Date time Section end..............................................................................///////

    // Validate amount start.....
    $("#validationcontact").change(function () {
       //

        const price = $("#validationcontact").val();
        if (price > 0) {
            $("#validationcontact").prop('required', true);
            $("#submit").removeClass('disabled');
        }
        else {
            alert("Amount will be greater than 0");
            $("#submit").addClass('disabled');
        }
    });
    // Validate amount end.....  
    // Find day
    function finddate() {
        //
        var date1 = document.getElementById("startickettdate").value;
        var date2 = document.getElementById("endticketdate").value;
        date1 = new Date(date1);
        date2 = new Date(date2);
        var milli_secs = date2.getTime() - date1.getTime();

        // Convert the milli seconds to Days 
        var days = milli_secs / (1000 * 3600 * 24);
        var totalday = Math.round(Math.abs(days));
        $('#ticketday').empty(); //remove all child nodes
        var newOption1 = $('<option>Please select event ticket day</option>');
        $('#ticketday').append(newOption1);

        const date = new Date(date1.getTime());

        const dates = [];
        while (date <= date2) {
            dates.push(new Date(date));
            date.setDate(date.getDate() + 1);

        }
        dates.forEach(function (datenew) {
            var dayweek = "weekday";
            const d = datenew;
            let day = d.getDay()
            if (day == 0) {
                dayweek = "Sunday" + '-' + convert(datenew);
                var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            } else if (day == 1) {
                dayweek = "Monday" + '-' + convert(datenew);
                var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            }
            else if (day == 2) {
                dayweek = "Tuesday" + '-' + convert(datenew);
                var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            }
            else if (day == 3) {
                dayweek = "Wednesday" + ' ' + convert(datenew);
                var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            }
            else if (day == 4) {
                dayweek = "Thursday" + '-' + convert(datenew);
                var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            }
            else if (day == 5) {
                dayweek = "Friday" + '-' + convert(datenew);
                var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            }
            else if (day == 6) {
                dayweek = "Saturday" + '-' + convert(datenew);
                var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");

            }
        })
    }

    function convert(str) {
        var date = new Date(str),
            mnth = ("0" + (date.getMonth() + 1)).slice(-2),
            day = ("0" + date.getDate()).slice(-2);
        return [mnth, day, date.getFullYear()].join("/");
        //return [date.getFullYear(), mnth, day].join("/");
    }



</script>