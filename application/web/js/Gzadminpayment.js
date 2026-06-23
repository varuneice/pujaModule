(function ($) {
    $(function () {
       debugger;
            var url1 = $("#container-abc-url-id").text();
        var url = $("#container-abc-url-id").text();
        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }

        $(document).delegate('#reset-btn-id', 'click', function (e) {
            $('#edit_Pujafoodcoupondata')[0].reset();
        }).delegate('#PaymentOption', 'change', function (e) {
        debugger;

        //const price = parseInt($("#total").val());
        // if (price == 0 ) {
        //     alert("Invalid Amount");
        //     $("#total").prop('required', true);
        //     $("#payment_btn_id").addClass('disabled');
        //     document.getElementById("PaymentOption").value = "";
        //     return;
        // } 
        var val = $(this).val();

        if (val == 'stripe') {
            $("#others_details").hide();
            $("#checkdata").hide();
            $("#directdeposite").hide();
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
            $("#directdeposite").prop('required', false);

            $("#checkbankname").val("");
            $("#checkno").val("");
            $("#checkamount").val("");
            $("#checkdate").val("");
            $("#bankname").val("");
            $("#ISFCCode").val("");
            $("#directamount").val("");
            $("#directdeposite").val("");
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


            var form = document.getElementById('donation-adminpayment-id');

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
            elem.setAttribute("src", url + "zelleqrcode.jpg");
            elem.setAttribute("height", "600");
            elem.setAttribute("width", "600");

            elem.setAttribute("alt", "Flower");
            $('#error_codeimg').html(elem);
            document.getElementById("error_codeimg").style.marginLeft = "63px";
            document.getElementById("error_codeimg").style.marginTop = "30px";
            document.getElementById("error_code1").style.marginLeft = "163px";
            document.getElementById("error_code1").style.paddingTop = "12px";
            document.getElementById("checkPaymentData").style.display = "block";
            document.getElementById("MemberID1").style.display = "block";
            document.getElementById("error_code1").style.display = "block";
            document.getElementById("error_codeimg").style.display = "block";
            document.getElementById("error_code1").style.color = "#ff0000";
            $('#error_code1').html("Step 1 - Send your Zelle payment to treasurer@durgabari.org." + "<br>" + "Step 2 - Click get zelle payment details button." + "<br>" + "Step 3 - Select your payment details from  dropdown.");
            $("#stripe_details").hide();
            $("#checkdata").hide();
            $("#cashdata").hide();
            $("#Sumupdata").hide();
            $("#directdeposite").hide();
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
            $("#directdeposite").prop('required', false);

            $("#checkbankname").val("");
            $("#checkno").val("");
            $("#checkamount").val("");
            $("#checkdate").val("");
            $("#bankname").val("");
            $("#ISFCCode").val("");
            $("#directamount").val("");
            $("#directdeposite").val("");
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
            $("#directdeposite").val("");
            $("#receiveby").val("");
            $("#cashamount").val("");
            $("#cashdate").val("");

            $("#receiveby").prop('required', false);
            $("#cashamount").prop('required', false);
            $("#cashdate").prop('required', false);

            $("#bankname").prop('required', false);
            $("#ISFCCode").prop('required', false);
            $("#directamount").prop('required', false);
            $("#directdeposite").prop('required', false);

            $("#checkbankname").prop('required', true);
            $("#checkno").prop('required', true);
            $("#checkamount").prop('required', true);
            $("#checkdate").prop('required', true);

            $("#MemberID").prop('required', false);
        } else if (val == 'cash') {

            $("#stripe_details").hide();
            $("#others_details").hide();
            $("#directdeposite").hide();
            $("#checkdata").hide();
            $("#Sumupdata").hide();
            $("#cashdata").show();
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
            $("#directdeposite").val("");
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
            $("#directdeposite").prop('required', false);
        
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
            $("#directdeposite").show();
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
            $("#directdeposite").val("");
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

        }
        else if (val == 'sumup') {
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
            $("#directdeposite").hide();
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
            $("#directdeposite").prop('required', false);
            $("#MemberID").prop('required', false);
            $("#sumdate").prop('required', false);
           
            

            $("#checkbankname").val("");
            $("#checkno").val("");
            $("#checkamount").val("");
            $("#checkdate").val("");
            $("#bankname").val("");
            $("#ISFCCode").val("");
            $("#directamount").val("");
            $("#directdeposite").val("");
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

    }).delegate('#email', 'change', function (event) {
        debugger;
        var email = $("#email").val();
        var phone = $("#phone").val();
        var url1 = $("#container-abc-url-id").text();
        if (!!email) {
            $.ajax({
                type: "POST",
                data: {
                    email: email,
                },
                url: url1 + "load.php?controller=PujaDonations&action=Membercheckregister",
                success: function (res) {
                    let ytd = "";

                    const YTDElement = $(res).filter("input#previousytd");
                    if (YTDElement.length) {
                        ytd = YTDElement[0].value;
                       
                        if(ytd!=""){
                            document.getElementById("ytd1").value = ytd;
                            let ltd = "";
                            const ltdElement = $(res).filter("input#LifetimeContribution");
                           if(ltdElement.length){
                            ltd = ltdElement[0].value; 
                           }
                           document.getElementById("ltd1").value = ltd;
                            $('#ytdmess').html("Your Email/Phone No. already exist in System.");
                            $('#msgdiv').show();
                        }
                        
                        else{
                            $('#msgdiv').hide(); 
                            document.getElementById("ytd1").value = "";
                            document.getElementById("ltd1").value = "";
                        }
                       
                    }

                    else {
                        $('#msgdiv').hide();
                        document.getElementById("ytd1").value = "";
                        document.getElementById("ltd1").value = "";
                    }
                }

            });
        }
        if (email == "" && phone != "") {
            $('#msgdiv').show();
        }
        else {
            $('#msgdiv').hide();
            document.getElementById("ytd1").value = "";
            document.getElementById("ltd1").value = "";
        }
    }).delegate('#phone', 'change', function (event) {
        debugger;
        var email = $("#email").val();
        var Tele = $("#phone").val();
        document.getElementById("ytd1").value = "";
        var url1 = $("#container-abc-url-id").text();
        if (!!Tele) {
            $.ajax({
                type: "POST",
                data: {
                    Tele: Tele
                },
                url: url1 + "load.php?controller=PujaDonations&action=Membercheckregister",
                success: function (res) {
                    let ytd = "";
                    const YTDElement = $(res).filter("input#previousytd");
                    if (YTDElement.length) {
                        ytd = YTDElement[0].value;
                        if(ytd!=""){
                        document.getElementById("ytd1").value = ytd;
                        let ltd = "";
                            const ltdElement = $(res).filter("input#LifetimeContribution");
                           if(ltdElement.length){
                            ltd = ltdElement[0].value; 
                           }
                           document.getElementById("ltd1").value = ltd;
                        $('#ytdmess').html("Your Email/Phone No. already exist in System.");
                        $('#msgdiv').show();
                        }
                        else{
                            $('#msgdiv').hide(); 
                            document.getElementById("ytd1").value = "";
                            document.getElementById("ltd1").value = "";
                        }
                    }

                    else {
                        $('#msgdiv').hide();
                        document.getElementById("ytd1").value = "";
                        document.getElementById("ltd1").value = "";
                    }
                }

            }

            );
        }
        if (email != "" && Tele == "") {
            $('#msgdiv').show();
        }
        else {
            $('#msgdiv').hide();
            document.getElementById("ytd1").value = "";
            document.getElementById("ltd1").value = "";
        }
    });
});
}(jQuery));