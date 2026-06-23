(function ($) {
    $(function () {
        
         $(function(){
            $('input[type="text"]').change(function(){
                this.value = $.trim(this.value);
            });
            
             $('#demmember').keydown(function(e) {
              e.preventDefault();
             return false;
            });

            $('#term').on('input', function() {
             $(this).val($(this).val().replace(/[^a-z0-9]/gi, ''));
            });
        }); 
        
        //debugger;
        $("#term").autocomplete({
            source: "http://localhost:8082:8082/HDBS_Payment/Parking&Badges/ajax-db-search.php",
            //source: 'https://durgabari.org/HDBS_Payment/ajax-db-search.php',
            select: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                MemberSelectticketevent();

            },
            onclick: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelectticketevent();
        },
         onchange: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelectticketevent();
        },
        });
        var url = $("#container-abc-url-id").text();
        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }

        
        function MemberSelectticketevent() {
            //debugger
            var self = this;
            var data = $("#termMember").val();
            var term = $("#term").val();
            if (term != "") {
                const Memberid = data.split("-");
                if (term.trim() != "") {
                    $.ajax({
                        type: "POST",
                        data: {
                            memberid: data
                        },
                        url: url + "load.php?controller=PujaDonations&action=AllMemberNew",
                        success: function (res) {
                            //debugger;

                            let MemberName = "";
                            const memberNameElement = $(res).filter("input#MemberName");
                            if (memberNameElement.length) {
                                MemberName = memberNameElement[0].value;
                            }
                            let LastName = "";
                            const LastNameElement = $(res).filter("input#last_name");
                            if (LastNameElement.length) {
                                LastName = LastNameElement[0].value;
                            }
                            document.getElementById("Your_Name").value = MemberName.concat(" ", LastName);

                            let memberid = "";
                            const memberElement = $(res).filter("input#memberid");
                            if (memberElement.length) {
                                memberid = memberElement[0].value;
                            }
                            document.getElementById("demmember").value = memberid;
                            // if(memberid != ""){
                            // document.getElementById("demmember").value = memberid;
                            // var url ="https://durgabari.org/HDBS_Payment/Member/membermaintenance/" +memberid
                            // window.location.assign(url);
                            // }
                            let phoneNo = "";
                            const phoneNoElement = $(res).filter("input#Tele1");
                            if (phoneNoElement.length) {
                                phoneNo = phoneNoElement[0].value;
                            }
                            document.getElementById("Tele1").value = phoneNo;

                            let email = "";
                            const emailElement = $(res).filter("input#email");
                            if (emailElement.length) {
                                email = emailElement[0].value;
                            }
                            document.getElementById("Email").value = email;

                            let street = "";
                            const streetElement = $(res).filter("input#ressidentalAddress");
                          if(streetElement.length){
                           street = streetElement[0].value; 
                           }
                           document.getElementById("Street").value = street;

                            let resaddress = "";
                   const resaddressElement = $(res).filter("input#Address");
                  if(resaddressElement.length){
                    resaddress = resaddressElement[0].value; 
                  }
                  document.getElementById("ressidentalAddress").value = resaddress;

                  let state = "";
                  const stateElement = $(res).filter("input#state");
                 if(stateElement.length){
                   state = stateElement[0].value; 
                 }
                 document.getElementById("state").value = state;
                 

                 let city = "";
                    const cityElement = $(res).filter("input#city");
                   if(cityElement.length){
                      city = cityElement[0].value; 
                   }
                   document.getElementById("city").value = city;

                   let zipcode = "";
                    const zipcodeElement = $(res).filter("input#zip_code");
                   if(zipcodeElement.length){
                    zipcode = zipcodeElement[0].value; 
                   }
                   document.getElementById("zip_code").value = zipcode;


                        }
                    });
                } else {
                    $("#MemberName").val("");
                    $("#phone").val("");
                    $("#MemberName").val("");
                    $("#memberid").val("");
                    $("#Tele1").val("");
                    $("#Email").val("");
                    $("#spousename").val("");
                    $("#Street").val("");
                    $("#ressidentalAddress").val("");
                    $("#state").val("");
                    $("#city").val("");
                    $("#zip_code").val("");

                }
            }
        }
        $(document).ready(function () {
            //debugger;
            //eventcurrent();
            $('#registrationmember').change(function () {
                selectVal = $('#registrationmember').val();
                if (selectVal == "member") {
                    $('#IDMembertd').find(':input').prop("disabled", false);
                    $("#demmember").prop('required',true);
                }
                else {
                    $('#IDMembertd').find(':input').prop("disabled", true);
                     $("#demmember").prop('required',false); 
                }
            })
        });
        // $("#ticket-table-id").delegate('a.icon-delete', 'click', function (e) {
        //     //debugger;
        //     e.preventDefault();
        //     $('#record_id').text($(this).attr('rev'));
        //     $('#dialogDelete').dialog('open');
        // });

        //image delete code 
       if ($("#dialogDelete").length > 0) {
            $("#dialogDelete").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function() {
                    $('#record_id').text('');
                },
                buttons: [{
                        html: "<i class='fa fa-trash-o'></i>&nbsp; Delete item",
                        "class": "btn btn-danger",
                        click: function() {
                            $.ajax({
                                type: "POST",
                                data: {
                                    id: $('#record_id').text(),
                                    controller: 'Ticketadmin',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=Ticketadmin&action=delete",
                                beforeSend: function() {
                                    $(".overlay").css('display', 'block');
                                    $(".loading-img").css('display', 'block');
                                },
                                success: function(res) {
                                    $("#table-frm-id").html(res);

                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');

                                    $('#gzhotel-booking-user-id').dataTable({
                                        "aoColumnDefs": [
                                            {'bSortable': false, 'aTargets': [5, 6]}
                                        ]
                                    });
                                }
                            });
                            $(this).dialog('close');

                        }}, {
                        html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                        "class": "btn btn-default",
                        click: function() {
                            $(this).dialog('close');
                        }}]
            });
        }
        if ($("a.gallery-delete").length > 0) {
            $("#table-frm-id").delegate("a.gallery-delete", 'click', function (e) {
                e.preventDefault();
                $('#record_id').text($(this).attr('rev'));
                $('#dialogDeleteGallery').dialog('open');
            });

            $("#edit_user").delegate("a.gallery-delete", 'click', function (e) {
                //debugger;
                e.preventDefault();
                $('#record_id').text($(this).attr('rev'));
                $('#dialogDeleteImage').dialog('open');
            });
        }
      if ($("#dialogDeleteImage").length > 0) {
            //debugger;
            $("#dialogDeleteImage").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function () {
                    $('#record_id').text('');
                },
                buttons: {
                    "Delete": function () {
                        $.ajax({
                            type: "POST",
                            data: {
                                id: $('#record_id').text(),
                                controller: 'Ticketadmin',
                                action: 'deleteEditedImage'
                            },
                            url: url + "index.php?controller=Ticketadmin&action=deleteEditedImage",
                            success: function (res) {
                                $("#img-file-id").html(res);
                            }
                        });
                        $(this).dialog('close');
                    },
                    'Cancel': function () {
                        $(this).dialog('close');
                    }
                }
            });
        }
        if ($("#dialogDeleteImage").length > 0) {
            //debugger;
            $("#dialogDeleteImage").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function () {
                    $('#record_id').text('');
                },
                buttons: {
                    "Delete": function () {
                        $.ajax({
                            type: "POST",
                            data: {
                                id: $('#record_id').text(),
                                controller: 'Ticketadmin',
                                action: 'deleteEditedticketImage'
                            },
                            url: url + "index.php?controller=Ticketadmin&action=deleteEditedticketImage",
                            success: function (res) {
                                $("#allticketevent").html(res);
                            }
                        });
                        $(this).dialog('close');
                    },
                    'Cancel': function () {
                        $(this).dialog('close');
                    }
                }
            });
        }
        $(document).delegate('#reset-btn-id', 'click', function (e) {
            $('#donation-frm-id')[0].reset();
        }).delegate('#Donation_Type', 'change', function (e) {
            var val = $(this).val();

            if (val === '1') {
                $('#hide1').hide();
            } else {
                $('#hide1').show();
            }
        }).delegate('#payment_method', 'change', function (e) {
            //debugger;
            var val = $(this).val();
            var amount = $("#Amount").val();
            if (amount == "" || amount == " ") {
                alert('please Select Ticket Type');
                $("#ticketday").prop('required', true);
                document.getElementById("payment_method").value = "";
                return;
            }
            if (val == 'stripe') {
                //debugger;
                $("#others_details").hide();
                $("#stripe_details").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $("#MemberID").prop('required',false);
                $('#payment_btn_id').prop('disabled', false);
                 $("#payment_btn_id").removeClass('disabled');
                var elements = stripe.elements();

                var style = {
                    base: {
                        // Add your base input styles here. For example:
                        fontSize: '16px',
                        color: "#32325d",
                    }
                };

                var card = elements.create('card', { style: style });

                card.mount('#card-element');

                card.addEventListener('change', function (event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });


                var form = document.getElementById('edit_ticketpaymentdata');

                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    stripe.createToken(card).then(function (result) {
                        if (result.error) {
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                            $("#stripeToken").val(result.token.id);
                            form.submit();
                        }
                    });
                });
            } else if (val == 'others') {
                //debugger
                var elem = document.createElement("img");
                elem.setAttribute("src", "https://durgabari.org/HDBS_PaymentTesting/zelleqrcode.jpg");
                elem.setAttribute("height", "600");
                elem.setAttribute("width", "600");

                elem.setAttribute("alt", "Zelle");
                $('#error_codeimg').html(elem);
                //document.getElementById("error_codeimg").style.marginLeft = "58px";  
                document.getElementById("error_codeimg").style.textAlign = "center";
                 document.getElementById("error_codeimg").style.marginTop = "30px";
                 document.getElementById("error_code1").style.marginLeft = "168px";
                 document.getElementById("error_code1").style.paddingTop = "12px";
                document.getElementById("checkPaymentData").style.display = "block";
                document.getElementById("MemberID1").style.display = "block";
                document.getElementById("error_code1").style.display = "block";
                document.getElementById("error_codeimg").style.display = "block";
                document.getElementById("error_code1").style.color = "#ff0000";
                $('#error_code1').html("Step 1 - Send your Zelle payment to treasurerpuja@durgabari.org." + "<br>" + "Step 2 - Click get zelle payment details button." + "<br>" + "Step 3 - Select your payment details from  dropdown.");
                $("#stripe_details").hide();
                $("#MemberID1").show();
                 $("#MemberID").prop('required',true);
                //$("#others_details").show();
            } else {
                $("#stripe_details").hide();
                $("#others_details").hide();
            }
        }).delegate('#confirm_code', 'change', function (event) {
            //debugger;
            var frm = $("#payment-form");
            $("#error_code1").css('display', 'none');
            $("#error_codeimg").css('display', 'none');
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode",
                success: function (res) {
                    //debugger;
                    var check = res.includes("Your payment code is matched you can book");

                    if (check == true) {
                        $("#payment_btn_id").removeClass('disabled');
                    } else {
                        $("#payment_btn_id").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
        }).delegate('#checkPaymentData', 'click', function (event) {
            //debugger
            var self = this;
            $("#error_code1").css('display', 'none');
            $("#error_codeimg").css('display', 'none');
            var frm = $("#payment-form");
            var cal_id = $("#calendar_id").val();
            $.LoadingOverlay("show");
            //$(".overlay").css('display', 'block');
            //$(".loading-img").css('display', 'block');
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode&cid=" + cal_id,
                success: function (res) {
                    //debugger
                    $.LoadingOverlay("hide");
                    //$(".overlay").css('display', 'none');
                    //$(".loading-img").css('display', 'none');
                    var check = res.includes("Your payment code is matched you can book");
                    if (check == true) {


                        $("#details_frm_btn_id").removeClass('disabled');


                    }
                    else {
                        $("#details_frm_btn_id").addClass('disabled');


                    }
                    $('#error_code').html(res);

                }
            });
        }).delegate('#MemberID', 'click', function (event) {
            var self = this;
            //debugger
            var frm = $("#payment-form");
            //$.LoadingOverlay("show");
            var cal_id = $("#calendar_id").val();
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCodeDD&cid=" + cal_id,
                success: function (res) {

                    //var myString = res.replace("echo", '');
                    var myString1 = res.replace("", '');
                    //= myString.replace("",'');
                    $('#MemberID').empty(); //remove all child nodes
                    var newOption = $(myString1);
                    var newOption1 = $('<option value="1">Please select your payment details</option>');
                    $('#MemberID').append(newOption1);
                    $('#MemberID').append(newOption);
                    $('#MemberID').trigger("chosen:updated");
                    var dd = $("#MemberID").val();

                    if (dd == "1") {
                        // gz$("#member_btn_id").addClass('disabled');
                        document.getElementById("payment_btn_id").disabled = true;
                    }
                    //  var parts = myString1.split("/"); 
                    //  var cmCode =parts[3];
                }
            });

        }).delegate('#MemberID', 'change', function (event) {
            debugger
            var dd = $("#MemberID").val();

            var parts = dd.split("/");
            var cmCode = parts[3];
            var name = parts[1];
            var price = parts[2].replace(/ /gi, '').trim();;
            var newprice = price.replace('$', "");
            //var totalprice =   $("#total").text();
            var totalprice = $("#totalamount").val();
            var ticketprice = totalprice.replace(/ /gi, '').trim();
            var totalticketprice =  ticketprice.split(".");
            var tot = totalticketprice[0];
            if (cmCode != null) {
                $("#Zellecode").val(cmCode);
            }

            if (tot === newprice) {
                $('#payment_btn_id').prop("disabled", false);
                $("#payment_btn_id").removeClass('disabled');
                //$("#payment_btn_id").removeClass('disabled');
            }
            else {

                $("#payment_btn_id").addClass('disabled');
                alert('Total price and select  price is not same please select correct payment');
            }

        }).delegate("a.icon-delete", 'click', function (e) {
            debugger;
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#cat_id').text($(this).attr('cat'));
            $('#dialogDelete').dialog('open');
        }).delegate('#registrationmember', 'change', function (event) {
            //debugger;
            var regmember = $("#registrationmember").val();
            selectVal = $('#registrationmember').val();
            if (selectVal == "member") {
                $("#IDMembertd").removeClass("disabledbutton");
                document.getElementById("demmember").value = "";
                document.getElementById("namenonmember").value = "";
                document.getElementById("Tele1").value = "";
                document.getElementById("Email").value = "";
                document.getElementById("term").value = "";

                document.getElementById("Street").value = "";
                document.getElementById("spousename").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip_code").value = "";
             

                $('#nonmembername').hide();
                $('#fieldtest').hide();
                $('#namemeemberregister').show();
                $('#IDMembertd').show();
                $("#namenonmember").prop('required', false);
                $("#term").prop('required', true);
                $("#demmember").prop('required',true); 
            }
            if (selectVal == "nonmember") {
                $("#IDMembertd").addClass("disabledbutton");
                document.getElementById("demmember").value = "";
                document.getElementById("namenonmember").value = "";
                document.getElementById("Tele1").value = "";
                document.getElementById("Email").value = "";
                document.getElementById("term").value = "";
                document.getElementById("Street").value = "";
                document.getElementById("spousename").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip_code").value = "";
                $('#namemeemberregister').hide();
                $('#IDMembertd').hide();
                $('#nonmembername').show();
                $('#fieldtest').show();
                $("#fieldtest").prop('readonly', true);
                $("#namenonmember").prop('required', true);
                $("#term").prop('required', false);
                $("#demmember").prop('required',false); 

            }
            if (selectVal == "" || selectVal == " ") {
                document.getElementById("demmember").value = "";
                document.getElementById("namenonmember").value = "";
                document.getElementById("Tele1").value = "";
                document.getElementById("Email").value = "";
                document.getElementById("term").value = "";
                document.getElementById("Street").value = "";
                document.getElementById("spousename").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip_code").value = "";
                $("#IDMembertd").removeClass("disabledbutton");
            }
        });
        if ($("#dialogDelete").length > 0) {
            debugger;
            $("#dialogDelete").dialog({

                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function () {
                    $('#record_id').text('');
                },
                buttons: [{
                        html: "<i class='fa fa-trash-o'></i>&nbsp; Delete item",
                        "class": "btn btn-danger",
                        click: function () {
                            $(".overlay").css('display', 'block');
                            $(".loading-img").css('display', 'block');

                            var cat = $('#cat_id').text();

                            $.ajax({
                                type: "POST",
                                data: {
                                    id: $('#record_id').text(),
                                    cat: cat,
                                    controller: 'PujaPassesadmin',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=PujaPassesadmin&action=delete",
                                success: function (res) {

                                   if (cat === '1') {
                                        $('#tab_1').html(res);

                                        if ($('#tab-1-table-id').length > 0) {
                                            $('#tab-1-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [7, 8]}
                                                ]
                                            });
                                        }
                                    }else if (cat === '3') {
                                        $('#tab_3').html(res);

                                        if ($('#tab-passesprice-table-id').length > 0) {
                                            $('#tab-passesprice-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [1, 3]}
                                                ]
                                            });
                                        }
                                    } 
                                    
                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');
                                }
                            });
                            $(this).dialog('close');
                        }
                    }, {
                        html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                        "class": "btn btn-default",
                        click: function () {
                            $(this).dialog("close");
                        }
                    }]
            });
        }

    });
}(jQuery));