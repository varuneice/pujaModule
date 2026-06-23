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

        }); 
        
        //debugger;
        var url = $("#container-abc-url-id").text();
        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
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
        $(document).delegate('#reset-btn-id', 'click', function (e) {
           $('#registration-frm-id')[0].reset();
            $("#childrenHaatekhori").val("");
            $("#personsoffering").val("");
            $("#fullnamesponsorpuja").val("");
            $("#childname").val("");
            $("#personsoffering").val("");
            $("#fathernamehathekhori").val("");
            $("#mothernamehathekhori").val("");
            $("#gotraname").val("");

            $("#searchidrow").hide();
            $("#memberinformationdiv").hide();
            $("#pujanamediv").hide();
            $("#namefield").hide();
            $("#street").hide();
            $("#address").hide();
            $("#phonediv").hide();
            $("#emaildiv").hide();
            $("#offeringPujaSankalpa").hide();
            $("#haateekhorichildren").hide();
            $("#hatkhorifmparentdiv").hide();
            $("#gotradiv").hide();
            $("#totalamountdiv").hide();
            $("#imgdiv").hide();
            $("#memberhathekhoridiv").hide();
            $("#cartresetdiv").hide();
            $("#cartmaindiv").hide();
            $("#creditcardpaymentdiv").hide();
            $("#others_details").hide();
            $("#checkdata").hide();
            $("#cashdata").hide();
            $("#directdeposite").hide();
            $("#Sumupdata").hide();
            $("#paymentbuttondiv").hide();
            $("#stripe_details").hide();
            $('#payremovediv').remove();
            $('#cartbutton').prop('disabled', false);
            $('.selectpicker').selectpicker('deselectAll');
            $('#cartbutton').html("Add to cart");
        }).delegate('#PaymentOption', 'change', function (e) {
           debugger;
            var val = $(this).val();
            $("#finalpaymentbutton").removeClass('disabled');
            if (val == 'stripe') {
                //debugger;
                
                 $("#paymentbuttondiv").show();
                 $("#others_details").hide();
                 $("#checkdata").hide();
                 $("#directdeposite").hide();
                 $("#cashdata").hide();
                 $("#Sumupdata").hide();
                 $("#stripe_details").show();
                 document.getElementById("error_code1").style.display = "none";
                 document.getElementById("error_code2").style.display = "none";
                 document.getElementById("error_codeimg").style.display = "none";
                 document.getElementById("checkPaymentData").style.display = "none";
                 document.getElementById("MemberID1").style.display = "none";
                 $("#MemberID").prop('required',false);
                 $('#finalpaymentbutton').prop('disabled', false);
                 $("#finalpaymentbutton").removeClass('disabled');

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
                 $("#sumdata").prop('required', false);
                 $("#sumupprice").prop('required', false);
                 $("#sumdatedate").prop('required', false);
 
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
                 $("#sumdata").val("");
                 $("#sumupprice").val("");
                 $("#sumdatedate").val("");

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


                var form = document.getElementById('registration-frm-id');

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
                $("#paymentbuttondiv").show();
                $("#others_details").show();
                //debugger
                var elem = document.createElement("img");
                elem.setAttribute("src", "https://durgabari.org/HDBS_PaymentTesting/zelleqrcode.jpg");
                //elem.setAttribute("height", "600");
                elem.setAttribute("width", "100%");

                elem.setAttribute("alt", "Zelle");
                $('#error_codeimg').html(elem);
                //document.getElementById("error_codeimg").style.marginLeft = "30px"; 
                 document.getElementById("error_codeimg").style.textAlign = "center";                 
                document.getElementById("error_codeimg").style.marginTop = "30px";
                document.getElementById("error_code1").style.marginLeft = "20px";
                document.getElementById("error_code1").style.fontSize = "16px";
                document.getElementById("error_code2").style.fontSize = "16px";
                document.getElementById("error_code1").style.paddingTop = "12px";
                document.getElementById("checkPaymentData").style.display = "block";
                document.getElementById("MemberID1").style.display = "block";
                document.getElementById("error_code1").style.display = "block";
                document.getElementById("error_code2").style.display = "block";
                //document.getElementById("error_codeimg").style.display = "block";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("error_code1").style.color = "#ff0000";
                document.getElementById("error_code2").style.color = "#ff0000";
                $('#error_code1').html("Step 1 - Without closing this page, open a new web page and go to your Bank’s portal." + "<br>" + "Step 2 - Send your Zelle payment from your Bank’s portal. To register as a new recipient, Name = Houston Durga Bari Society, Email = treasurerpuja@durgabari.org." + "<br>" + "Step 3 - Return to this page and click ‘Get Zelle Payment Details’ button." + "<br>" + "Step 4 - Select your payment details from the dropdown." + "<br>" + "Step 5 - Make Payment." + "<br>");
                $('#error_code2').html("<br>" + "Note:It may take some time for the Zelle payment information to appear (depending on network speed at both User and Bank ends).");
                $("#stripe_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdeposite").hide();
                $("#MemberID1").show();
                $("#MemberID").prop('required',true);
                $("#finalpaymentbutton").addClass('disabled');

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
                $("#sumdata").prop('required', false);
                $("#sumupprice").prop('required', false);
                $("#sumdatedate").prop('required', false);

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
                $("#sumdata").val("");
                $("#sumupprice").val("");
                $("#sumdatedate").val("");

                //$("#others_details").show();
            }
            else if (val == 'check') {

                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdeposite").hide();
                $("#checkdata").show();
                $("#paymentbuttondiv").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $('#finalpaymentbutton').prop('disabled', false);
                $("#finalpaymentbutton").removeClass('disabled');
                
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
                $("#sumdata").val("");
                $("#sumupprice").val("");
                $("#sumdatedate").val("");
    
                $("#receiveby").prop('required', false);
                $("#cashamount").prop('required', false);
                $("#cashdate").prop('required', false);
    
                $("#bankname").prop('required', false);
                $("#ISFCCode").prop('required', false);
                $("#directamount").prop('required', false);
                $("#directdeposite").prop('required', false);
                
                $("#sumdata").prop('required', false);
                $("#sumupprice").prop('required', false);
                $("#sumdatedate").prop('required', false);
    
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
                $("#paymentbuttondiv").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $('#finalpaymentbutton').prop('disabled', false);
                $("#finalpaymentbutton").removeClass('disabled');
                
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
                $("#sumdata").val("");
                $("#sumupprice").val("");
                $("#sumdatedate").val("");
    
                $("#checkbankname").prop('required', false);
                $("#checkno").prop('required', false);
                $("#checkamount").prop('required', false);
                $("#checkdate").prop('required', false);
            
                $("#bankname").prop('required', false);
                $("#ISFCCode").prop('required', false);
                $("#directamount").prop('required', false);
                $("#directdeposite").prop('required', false);
                
                $("#sumdata").prop('required', false);
                $("#sumupprice").prop('required', false);
                $("#sumdatedate").prop('required', false);
            
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
                $("#paymentbuttondiv").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $('#finalpaymentbutton').prop('disabled', false);
                $("#finalpaymentbutton").removeClass('disabled');
                
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
                $("#sumdata").val("");
                $("#sumupprice").val("");
                $("#sumdatedate").val("");
    
                $("#checkbankname").prop('required', false);
                $("#checkno").prop('required', false);
                $("#checkamount").prop('required', false);
                $("#checkdate").prop('required', false);
    
                $("#receiveby").prop('required', false);
                $("#cashamount").prop('required', false);
                $("#cashdate").prop('required', false);
                
                $("#sumdata").prop('required', false);
                $("#sumupprice").prop('required', false);
                $("#sumdatedate").prop('required', false);
    
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
                $("#paymentbuttondiv").show();
                
                $("#sumdata").prop('required', true);
                $("#sumupprice").prop('required', true);
                $("#sumdatedate").prop('required', true);
                
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
                $("#sumdata").val("");
                $("#sumupprice").val("");
                $("#sumdatedate").val("");

                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $('#finalpaymentbutton').prop('disabled', false);
                $("#finalpaymentbutton").removeClass('disabled');
    
            }
            else if(val == 'ComplimentaryRegistration'){
                //debugger;
                 $("#stripe_details").hide();
                 $("#others_details").hide();
                 $("#checkdata").hide();
                 $("#directdeposite").hide();
                 $("#cashdata").hide();
                 $("#Sumupdata").hide();
                 $("#paymentbuttondiv").show();
                 
                 document.getElementById("error_code1").style.display = "none";
                 document.getElementById("error_code2").style.display = "none";
                 document.getElementById("error_codeimg").style.display = "none";
                 document.getElementById("checkPaymentData").style.display = "none";
                 document.getElementById("MemberID1").style.display = "none";
                 $("#MemberID").prop('required',false);
                 $('#finalpaymentbutton').prop('disabled', false);
                 $("#finalpaymentbutton").removeClass('disabled');
                 
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
                 $("#sumdata").prop('required', false);
                 $("#sumupprice").prop('required', false);
                 $("#sumdatedate").prop('required', false);
				 
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
                 $("#sumdata").val("");
                 $("#sumupprice").val("");
                 $("#sumdatedate").val("");           
            }
            else {
                $("#paymentbuttondiv").hide();
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdeposite").hide()
                $("#Sumupdata").hide();
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
                        $("#finalpaymentbutton").removeClass('disabled');
                    } else {
                        $("#finalpaymentbutton").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
        }).delegate('#checkPaymentData', 'click', function (event) {
            //debugger
            var self = this;
           // $("#error_code1").css('display', 'none');
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
            //debugger
            var dd = $("#MemberID").val();

            var parts = dd.split("/");
            var cmCode = parts[3];
            var name = parts[1];
            var price =parts[2].replace(/[^\w\s]/gi, '').trim();
            var newprice = price.replace('$', "");
            //var totalprice =   $("#total").text();
            // var totalprice = $("#totalamount").val();
            // var ticketprice = totalprice.replace(/ /gi, '').trim();
            // var totalticketprice =  ticketprice.split(".");
            // var tot = totalticketprice[0];

            var pujatotalamount = document.getElementById("pricepayment").innerHTML;
            var valueOfPujaPrice =  pujatotalamount.split(" ");
            var finalpujaprice = valueOfPujaPrice[0];
            
            if (cmCode != null) {
                $("#Zellecode").val(cmCode);
            }

            if (finalpujaprice === newprice) {
                $('#finalpaymentbutton').prop("disabled", false);
                $("#finalpaymentbutton").removeClass('disabled');
                //$("#payment_btn_id").removeClass('disabled');
            }
            else {

                $("#finalpaymentbutton").addClass('disabled');
                alert('Total price and select  price is not same please select correct payment');
            }

        }).delegate("a.icon-delete", 'click', function (e) {
            debugger;
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#cat_id').text($(this).attr('cat'));
            $('#dialogDelete').dialog('open');
        }).delegate('#checkamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var checkamount = $("#checkamount").val();
            var pujatotalamount = document.getElementById("pricepayment").innerHTML;
            var finalpujaprice =  pujatotalamount.split(" ");
            if( finalpujaprice[0] != checkamount ){
                alert('Total amount and check amount not same please select correct amount');
                $("#finalpaymentbutton").addClass('disabled');
            }
            else{
                $("#finalpaymentbutton").removeClass('disabled');
            }
        }).delegate('#cashamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var cashamount = ($("#cashamount").val() * 1);
            var pujatotalamount = document.getElementById("pricepayment").innerHTML;
            var finalpujaprice =  pujatotalamount.split(" ");
            if( finalpujaprice[0] != cashamount){
                alert('Total amount and cash amount not same please select correct amount');
                $("#finalpaymentbutton").addClass('disabled');
            }
            else{
                $("#finalpaymentbutton").removeClass('disabled');
            }
         
        }).delegate('#directamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var directdeposite = parseInt($("#directamount").val());
            var pujatotalamount = document.getElementById("pricepayment").innerHTML;
            var finalpujaprice =  pujatotalamount.split(" ");
            if(finalpujaprice[0] != directdeposite){
                alert('Total amount and direct deposit amount not same please select correct amount');
                $("#finalpaymentbutton").addClass('disabled');
            }
            else{
                $("#finalpaymentbutton").removeClass('disabled');
            }
        }).delegate('#sumupprice', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var sumpumount = ($("#sumupprice").val() * 1);
            var pujatotalamount = document.getElementById("pricepayment").innerHTML;
            var finalpujaprice =  pujatotalamount.split(" ");
            if(finalpujaprice[0] != sumpumount){
                alert('Sumup  amount and direct deposit amount not same please select correct amount');
                $("#finalpaymentbutton").addClass('disabled');
            }
            else{
                $("#finalpaymentbutton").removeClass('disabled');
            }
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
    });
}(jQuery));