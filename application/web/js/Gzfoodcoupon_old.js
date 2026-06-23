(function ($) {
    $(function () {
        var url = $("#container-abc-url-id").text();
        var selcetsubj = null;
        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }
       
        $(document).delegate('#reset-btn-id', 'click', function (e) {
            $('#donation-frm-id')[0].reset();
        }).delegate('#PaymentOption', 'change', function (e) {
            debugger;

            const price = parseInt($("#total").val());
            if (price == 0 ) {
                alert("Invalid Amount");
                $("#total").prop('required', true);
                $("#payment_btn_id").addClass('disabled');
                document.getElementById("PaymentOption").value = "";
                return;
            } 
            var val = $(this).val();

            if (val == 'stripe') {
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#directdepositedata").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#stripe_details").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $("#MemberID").prop('required', false);
                $('#payment_btn_id').prop('disabled', false);
                $("#payment_btn_id").removeClass('disabled');

                $("#receiveby").prop('required', false);
                $("#cashamount").prop('required', false);
                $("#cashdate").prop('required', false);
                $("#checkbankname").prop('required', false);
                $("#checkno").prop('required', false);
                $("#checkamount").prop('required', false);
                $("#checkdate").prop('required', false);
                $("#bankname").prop('required', false);
                $("#ISFCCode").prop('required', false);
                $("#directamount").prop('required', false);
                $("#directdepositdate").prop('required', false);

                $("#checkbankname").val("");
                $("#checkno").val("");
                $("#checkamount").val("");
                $("#checkdate").val("");
                $("#bankname").val("");
                $("#ISFCCode").val("");
                $("#directamount").val("");
                $("#directdepositdate").val("");
                $("#receiveby").val("");
                $("#cashamount").val("");
                $("#cashdate").val("");
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


                var form = document.getElementById('edit_Pujafoodcoupondata');

                form.addEventListener('submit', function (event) {
                    //debugger;
                    event.preventDefault();

                    stripe.createToken(card).then(function (result) {
                        if (result.error) {
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        }
                        else {
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
                //document.getElementById("error_codeimg").style.marginLeft = "30px";  
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
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdepositedata").hide();
                $("#MemberID1").show();
                $("#MemberID").prop('required', true);


                $("#receiveby").prop('required', false);
                $("#cashamount").prop('required', false);
                $("#cashdate").prop('required', false);
                $("#checkbankname").prop('required', false);
                $("#checkno").prop('required', false);
                $("#checkamount").prop('required', false);
                $("#checkdate").prop('required', false);
                $("#bankname").prop('required', false);
                $("#ISFCCode").prop('required', false);
                $("#directamount").prop('required', false);
                $("#directdepositdate").prop('required', false);

                $("#checkbankname").val("");
                $("#checkno").val("");
                $("#checkamount").val("");
                $("#checkdate").val("");
                $("#bankname").val("");
                $("#ISFCCode").val("");
                $("#directamount").val("");
                $("#directdepositdate").val("");
                $("#receiveby").val("");
                $("#cashamount").val("");
                $("#cashdate").val("");
                //$("#others_details").show();
            } else if (val == 'check') {

                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdepositedata").hide();
                $("#checkdata").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";

                $("#checkbankname").val("");
                $("#checkno").val("");
                $("#checkamount").val("");
                $("#checkdate").val("");
                $("#bankname").val("");
                $("#ISFCCode").val("");
                $("#directamount").val("");
                $("#directdepositdate").val("");
                $("#receiveby").val("");
                $("#cashamount").val("");
                $("#cashdate").val("");

                $("#receiveby").prop('required', false);
                $("#cashamount").prop('required', false);
                $("#cashdate").prop('required', false);

                $("#bankname").prop('required', false);
                $("#ISFCCode").prop('required', false);
                $("#directamount").prop('required', false);
                $("#directdepositdate").prop('required', false);

                $("#checkbankname").prop('required', true);
                $("#checkno").prop('required', true);
                $("#checkamount").prop('required', true);
                $("#checkdate").prop('required', true);

                $("#MemberID").prop('required', false);
            } else if (val == 'cash') {

                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#directdepositedata").hide();
                $("#checkdata").hide();
                $("#cashdata").show();
                $("#Sumupdata").hide();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";

                $("#checkbankname").val("");
                $("#checkno").val("");
                $("#checkamount").val("");
                $("#checkdate").val("");
                $("#bankname").val("");
                $("#ISFCCode").val("");
                $("#directamount").val("");
                $("#directdepositdate").val("");
                $("#receiveby").val("");
                $("#cashamount").val("");
                $("#cashdate").val("");

                $("#checkbankname").prop('required', false);
                $("#checkno").prop('required', false);
                $("#checkamount").prop('required', false);
                $("#checkdate").prop('required', false);
            
                $("#bankname").prop('required', false);
                $("#ISFCCode").prop('required', false);
                $("#directamount").prop('required', false);
                $("#directdepositdate").prop('required', false);
            
                $("#receiveby").prop('required', true);
                $("#cashamount").prop('required', true);
                $("#cashdate").prop('required', true);

                $("#MemberID").prop('required', false);

            } else if (val == 'directdeposit') {

                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdepositedata").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                
                $("#checkbankname").val("");
                $("#checkno").val("");
                $("#checkamount").val("");
                $("#checkdate").val("");
                $("#bankname").val("");
                $("#ISFCCode").val("");
                $("#directamount").val("");
                $("#directdepositdate").val("");
                $("#receiveby").val("");
                $("#cashamount").val("");
                $("#cashdate").val("");

                $("#checkbankname").prop('required', false);
                $("#checkno").prop('required', false);
                $("#checkamount").prop('required', false);
                $("#checkdate").prop('required', false);

                $("#receiveby").prop('required', false);
                $("#cashamount").prop('required', false);
                $("#cashdate").prop('required', false);

                $("#bankname").prop('required', true);
                $("#ISFCCode").prop('required', true);
                $("#directamount").prop('required', true);
                $("#directdepositdate").prop('required', true);

                $("#MemberID").prop('required', false);

            }  else if (val == 'sumup') {
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdeposite").hide()
                $("#Sumupdata").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
    
            }
         else {
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdepositedata").hide();
                $("#Sumupdata").hide();

                $("#receiveby").prop('required', false);
                $("#cashamount").prop('required', false);
                $("#cashdate").prop('required', false);
                $("#checkbankname").prop('required', false);
                $("#checkno").prop('required', false);
                $("#checkamount").prop('required', false);
                $("#checkdate").prop('required', false);
                $("#bankname").prop('required', false);
                $("#ISFCCode").prop('required', false);
                $("#directamount").prop('required', false);
                $("#directdepositdate").prop('required', false);
                $("#MemberID").prop('required', false);
                $("#sumdate").prop('required', false);

                $("#checkbankname").val("");
                $("#checkno").val("");
                $("#checkamount").val("");
                $("#checkdate").val("");
                $("#bankname").val("");
                $("#ISFCCode").val("");
                $("#directamount").val("");
                $("#directdepositdate").val("");
                $("#receiveby").val("");
                $("#cashamount").val("");
                $("#cashdate").val("");
                $("sumdata").val("");
                $("sumdate").val("");


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
                   // debugger;
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
        }).delegate('#MemberID', 'change', function (event) {
            //debugger
            var dd = $("#MemberID").val();

            var parts = dd.split("/");
            var cmCode = parts[3];
            var name = parts[1];
            var price = parts[2].replace(/ /gi, '').trim();;

            var newprice = price.replace('$', "");
            //var totalprice =   $("#total").text();
            var totalprice = $("#total").val();
            var tot = totalprice.replace(/ /gi, '').trim();

            if (cmCode != null) {
                $("#Zellecode").val(cmCode);
            }

            if (tot === newprice) {
                $('#payment_btn_id').prop("disabled", false);
                $("#payment_btn_id").removeClass('disabled');
                // $("#payment_btn_id").removeClass('disabled');
            }
            else {

                $("#payment_btn_id").addClass('disabled');
                alert('Total price and select  price is not same please select correct payment');
            }
            //$.LoadingOverlay("show");

            // $.ajax({
            //     type: "POST",
            //     data: {
            //         code: cmCode
            //     },
            //     url: self.options.server + "load.php?controller=GzFront&action=UpdateCodeData&cid=" + self.options.cal_id,
            //     success: function (res) {
            //         $("#details_frm_btn_id").removeClass('disabled');
            //         $('#error_code').html(res);
            //     }

            // });

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

        }).delegate('#registrationmember', 'change', function (event) {
            //debugger;
            var regmember = $("#registrationmember").val();
            selectVal = $('#registrationmember').val();
            if (selectVal == "member") {
                $("#IDMembertd").removeClass("disabledbutton");
                document.getElementById("term").value = "";
                document.getElementById("first_name").value = "";
                document.getElementById("second_name").value = "";
                document.getElementById("idmem").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("email").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip").value = "";
                document.getElementById("coupontime").value = "";
                document.getElementById("couponsfor").value = "";
                document.getElementById("total").value = "";
                $('#nonmembername').hide();
                $('#fieldtest').hide();
                $('#namemeemberregister').show();
                $('#IDMembertd').show();
                $("#namenonmember").prop('required', false);
                $("#term").prop('required', true);
                $("#demmember").prop('required', true);
            }
            if (selectVal == "nonmember") {
                $("#IDMembertd").addClass("disabledbutton");
                document.getElementById("term").value = "";
                document.getElementById("first_name").value = "";
                document.getElementById("second_name").value = "";
                document.getElementById("idmem").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("email").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip").value = "";
                document.getElementById("coupontime").value = "";
                document.getElementById("couponsfor").value = "";
                document.getElementById("total").value = "";
               
                $('#namemeemberregister').hide();
                $('#IDMembertd').hide();
                $('#nonmembername').show();
                $('#fieldtest').show();
                $("#fieldtest").prop('readonly', true);
                $("#namenonmember").prop('required', true);
                $("#term").prop('required', false);
                $("#demmember").prop('required', false);
            }
            if (selectVal == "" || selectVal == " ") {
                document.getElementById("term").value = "";
                document.getElementById("first_name").value = "";
                document.getElementById("second_name").value = "";
                document.getElementById("idmem").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("email").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip").value = "";
                document.getElementById("coupontime").value = "";
                document.getElementById("couponsfor").value = "";
                document.getElementById("total").value = "";
                $("#IDMembertd").removeClass("disabledbutton");
            }

        }).delegate('#confirm_code', 'change', function (event) {
            var frm = $("#donation-frm-id");

            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode",
                success: function (res) {
                    var check = res.includes("Your payment code is matched you can book");

                    if (check == true) {
                        $("#payment_btn_id").prop("disabled", false);
                        $("#payment_btn_id").removeClass('disabled');
                    } else {
                        $("#payment_btn_id").prop("disabled", true);
                        $("#payment_btn_id").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
        }).delegate("a.icon-delete", 'click', function (e) {
            debugger;
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#cat_id').text($(this).attr('cat'));
            $('#dialogDelete').dialog('open');
        }).delegate('#directamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var directdepositeamount = ($("#directamount").val() * 1);
            var totalamount = ($("#total").val() * 1);
            if(directdepositeamount != totalamount){
                alert('Food Coupon price and direct deposit amount not same please fill correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
        }).delegate('#cashamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var cashamount = ($("#cashamount").val() * 1);
            var totalamount = ($("#total").val() * 1);
            if( cashamount != totalamount){
                alert('Food Coupon price and cash amount not same please fill correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
         
        }).delegate('#checkamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var checkamount = $("#checkamount").val();
            var totalamount = $("#total").val();
            if( checkamount != totalamount ){
                alert('Food Coupon price and check amount not same please fill correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
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
                            debugger;
                            $.ajax({
                                type: "POST",
                                data: {
                                    id: $('#record_id').text(),
                                    cat: cat,
                                    controller: 'pujafoodcoupon',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=pujafoodcoupon&action=delete",
                                success: function (res) {

                                    if (cat === '1') {
                                        $('#tab_1').html(res);

                                        if ($('#foodcoupom_tab_data').length > 0) {
                                            $('#foodcoupom_tab_data').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '2') {
                                        $('#tab_2').html(res);
                                        if ($('#foodcoupon-price-table-id').length > 0) {
                                            $('#foodcoupon-price-table-id').dataTable({
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