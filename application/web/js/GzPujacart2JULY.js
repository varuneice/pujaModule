(function ($) {
    $(function () {
        var url = $("#container-abc-url-id").text();
        var selcetsubj = null;
        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }
        //let emailvalid = true;
        //let phonevalid = true;
        // For Member Search option...........................
        function MemberSelect() {

            debugger
            var self = this;
            var data = $("#termMember").val();
            var term = $("#term").val();
            if (term != "") {
                const Memberid = data.split("-");
                //var url = gz$("#container-abc-url-id").text(); 
                if (term.trim() != "") {
                    $.ajax({
                        type: "POST",
                        data: {
                            memberid: data
                        },
                        //url: self.options.server  +"load.php?controller=Donations&action=AllMember&cid=" + self.options.cal_id,
                        url: url + "load.php?controller=Donations&action=AllMember&cid",
                        success: function (res) {
                            debugger;
                            //var Membertext = $("#MemberSelectValue").text();
                            //document.getElementById("MemberSelect").value = Membertext;
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

                            document.getElementById("Your_Name").value = MemberName.concat(" ", LastName);;



                            let memberid = "";
                            const memberElement = $(res).filter("input#memberid");
                            if (memberElement.length) {
                                memberid = memberElement[0].value;
                            }
                            document.getElementById("demmember").value = memberid;
                            // if(memberid != ""){
                            // document.getElementById("demmember").value = memberid;
                            // var url ="https://durgabari.org/HDBS_PaymentNew/Member/membermaintenance/" +memberid
                            // window.location.assign(url);
                            // }
                            let spouseName = "";
                            let spouseLastName = "";
                            const spouseNameElement = $(res).filter("input#Spouse");
                            const spouseLastNameElement = $(res).filter("input#Spouselast");
                            if (spouseLastNameElement.length) {
                                spouseLastName = spouseLastNameElement[0].value;
                            }
                            if (spouseNameElement.length) {
                                spouseName = spouseNameElement[0].value;
                            }
                            document.getElementById("spousename").value = spouseName.concat(" ", spouseLastName);

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
                                phoneNo = phoneNoElement[0].value;
                            }
                            document.getElementById("phone").value = phoneNo;

                            let email = "";
                            const emailElement = $(res).filter("input#email");
                            if (emailElement.length) {
                                email = emailElement[0].value;
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


                        }

                    });
                } else {
                    $("#MemberName").val("");
                    $("#phone").val("");
                    $("#Your_E-mail").val("");
                    $("#memberid").val(""); Member_id

                    $("#spousename").val("");
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

                }
            }
        }
        let emailvalid = true;
        let phonevalid = true;
        $(document).delegate('#reset-btn-id', 'click', function (e) {
           $('#pujaregistration-frm-id')[0].reset();
            $('#seniordismsg').hide();
            $("#documentuploaddiv").hide();
            $("#schoolnamediv").hide();
            $("#parentinputdiv").hide();
            $("#dvOptionalchild1").hide();
            $("#dvOptionalchild2").hide();
            $("#dvOptionalchild3").hide();

            $("#studentdivcheck").show();
            $("#oottdivcheck").show();
            $("#one").show();
            $("#two").show();

            $("#commonpricedrop").hide();
            $("#showMember").hide();
            $("#studentootcheck").hide();
            $("#membersearchdiv").hide();
            $("#memberinformationdiv").hide();
            
        }).delegate('#PaymentOption', 'change', function (e) {
            debugger;
            var val = $(this).val();
            const price = parseInt($("#total").val());
            $("#payment_btn").removeClass('disabled');
            if (price < 25) {
                alert("Minimum Amount $25");
                $("#total").prop('required', true);
                $("#payment_btn").addClass('disabled');
                document.getElementById("PaymentOption").value = "";
                return;
            } 

            if (val == 'stripe') {
                $('#userpaymethode').html("Credit Card Details:");
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
                $("#MemberID").prop('required', false);
                $('#payment_btn').prop('disabled', false);
                $("#payment_btn").removeClass('disabled');

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


                var form = document.getElementById('donation-frm-id');

                form.addEventListener('submit', function (event) {
                    debugger;
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
                $('#userpaymethode').html("Zelle:");
                var elem = document.createElement("img");
                elem.setAttribute("src", "https://durgabari.org/HDBS_PaymentTesting/zelleqrcode.jpg");
                elem.setAttribute("height", "600");
                elem.setAttribute("width", "600");

                elem.setAttribute("alt", "Zelle");
                $('#error_codeimg').html(elem);
                //document.getElementById("error_codeimg").style.marginLeft = "63px";
                document.getElementById("error_codeimg").style.textAlign = "center";
                document.getElementById("error_codeimg").style.marginTop = "30px";
                //document.getElementById("error_code1").style.marginLeft = "75px";
                document.getElementById("error_code1").style.paddingTop = "12px";
                document.getElementById("checkPaymentData").style.display = "block";
                document.getElementById("MemberID1").style.display = "block";
                document.getElementById("error_code1").style.display = "block";
                document.getElementById("error_code2").style.display = "block";
                //document.getElementById("error_codeimg").style.display = "block";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("error_code1").style.color = "#ff0000";
                document.getElementById("error_code2").style.color = "#ff0000";
                $("#error_code1").html("Step 1 - Without closing this page, open a new web page and go to your Bank’s portal." + "<br>" + "Step 2 - : From the Bank’s portal, send your Zelle payment to   <span style='font-weight: 700; color: #17af22;'>treasurerpuja@durgabari.org </span>. To register HDBS Puja as a new recipient, Name = Houston Durga Bari Society, Email = treasurerpuja@durgabari.org PLEASE DO NOT MAKE PAYMENT TO ANY OTHER ACCOUNT WITH A DIFFERENT EMAIL ADDRESS. This system will not be able to retrieve the payment information in that case." + "<br>" + "Step 3 - Return to this page and click ‘Get Zelle Payment Details’ button." + "<br>" + "Step 4 - Select your payment details from the dropdown (click on ‘Please select your payment details)." + "<br>" + "Step 5 - Make Payment." + "<br>");
                $("#error_code2").html("<br>" + "Note it may take some time for the Zelle payment information to appear (depending on network speed at both User and Bank ends). If you don’t find your records, please check back after 24 hours, and if you still don’t find the records, please contact registration@durgabari.org with full details.");
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
            } else if (val == 'check') {
                $('#userpaymethode').html("Check:");
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdeposite").hide();
                $("#checkdata").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
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
                $('#userpaymethode').html("Cash:");
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#directdeposite").hide();
                $("#checkdata").hide();
                $("#Sumupdata").hide();
                $("#cashdata").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
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
                $('#userpaymethode').html("Direct Deposit:");
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdeposite").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
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
                $('#userpaymethode').html("SumUp:");
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdeposite").hide()
                $("#Sumupdata").show();
                
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
    
            }
            else if(val == 'ComplimentaryRegistration'){
                $('#userpaymethode').html("Complimentary Registration:");
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#directdeposite").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#stripe_details").hide();

                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $("#MemberID").prop('required', false);

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
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdeposit").hide();
                $("#Sumupdata").hide();
                $('#userpaymethode').html("");
                 
            }
        }).delegate('#confirm_code', 'change', function (event) {
            debugger;
            var frm = $("#payment-form");
            $("#error_code1").css('display', 'none');
            $("#error_codeimg").css('display', 'none');
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode",
                success: function (res) {
                    debugger;
                    var check = res.includes("Your payment code is matched you can book");

                    if (check == true) {
                        $("#payment_btn").removeClass('disabled');
                    } else {
                        $("#payment_btn").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
        }).delegate('#checkPaymentData', 'click', function (event) {
            debugger
            var self = this;
            //$("#error_code1").css('display', 'none');
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
                    debugger
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
            var price =parts[2].replace(/[^\w\s]/gi, '').trim();

            var newprice = price.replace('$', "");
            //var totalprice =   $("#total").text();
            //var totalprice = $("#total").val();
            //var tot = totalprice.replace(/ /gi, '').trim();
            var pujatotalamount = document.getElementById("finalprice").innerHTML;
            var finalpujaprice =  pujatotalamount.replace(/[^\w\s]/gi, '').trim();
            if (cmCode != null) {
                $("#Zellecode").val(cmCode);
            }

            if (finalpujaprice === newprice) {
                $('#payment_btn').prop("disabled", false);
                $("#payment_btn").removeClass('disabled');
                // $("#payment_btn_id").removeClass('disabled');
            }
            else {

                $("#payment_btn").addClass('disabled');
                alert('Total price and select  price is not same please select correct payment');
            }

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
                         $("#payment_btn").addClass('disabled');
                        //document.getElementById("payment_btn_id").disabled = true;
                    }
                    //  var parts = myString1.split("/"); 
                    //  var cmCode =parts[3];
                }
            });

        }).delegate('#registrationmember', 'change', function (event) {
            debugger;
            var regmember = $("#registrationmember").val();
            selectVal = $('#registrationmember').val();
            if (selectVal == "member") {
                $("#IDMembertd").removeClass("disabledbutton");
                document.getElementById("spousename").value = "";
                document.getElementById("Street").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = ""; city
                document.getElementById("state").value = ""; state
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("ltd1").value = "";
                document.getElementById("ytd1").value = "";
                document.getElementById("namenonmember").value = "";
                document.getElementById("MembCategory").value = "";
                document.getElementById("term").value = "";
                document.getElementById("demmember").value = "";
                document.getElementById("sponser").value = "";
                document.getElementById("total").value = "";
                document.getElementById("futureytd").value = "";
                $("#total").val("");
                $("#futureytd").val("");
                $('#nonmembername').hide();
                $('#fieldtest').hide();
                $('#namemeemberregister').show();
                $('#IDMembertd').show();
                $("#namenonmember").prop('required', false);
                $("#term").prop('required', true);
                $("#demmember").prop('required', true);
                $('#sponsorcheck').hide();
                $('#msgdiv').hide();
                $('#regmsgdiv').hide();

            }
            if (selectVal == "nonmember") {
                $("#IDMembertd").addClass("disabledbutton");
                document.getElementById("spousename").value = "";
                document.getElementById("Street").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = ""; city
                document.getElementById("state").value = ""; state
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("ltd1").value = "";
                document.getElementById("ytd1").value = "";
                document.getElementById("namenonmember").value = "";
                document.getElementById("MembCategory").value = "";
                document.getElementById("term").value = "";
                document.getElementById("demmember").value = "";
                document.getElementById("sponser").value = "";
                document.getElementById("futureytd").value = "";
                document.getElementById("total").value = "";
                $("#total").val("");
                $("#futureytd").val("");
                $('#namemeemberregister').hide();
                $('#IDMembertd').hide();
                $('#nonmembername').show();
                $('#fieldtest').show();
                $("#fieldtest").prop('readonly', true);
                $("#namenonmember").prop('required', true);
                $("#term").prop('required', false);
                $("#demmember").prop('required', false);
                $('#sponsorcheck').hide();
                $('#msgdiv').hide();
                $('#regmsgdiv').hide();
                $('#sankalpapuja').hide();
                $('#eventone').hide();
                $('#twoevent').hide();
            }
            if (selectVal == "" || selectVal == " ") {
                document.getElementById("sponser").value = "";
                document.getElementById("demmember").value = "";
                document.getElementById("spousename").value = "";
                document.getElementById("Street").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = ""; city
                document.getElementById("state").value = ""; state
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("ltd1").value = "";
                document.getElementById("ytd1").value = "";
                document.getElementById("namenonmember").value = "";
                document.getElementById("MembCategory").value = "";
                document.getElementById("term").value = "";
                document.getElementById("futureytd").value = "";
                document.getElementById("total").value = "";
                $("#total").val("");
                $("#futureytd").val("");
                $("#IDMembertd").removeClass("disabledbutton");
                $('#sponsorcheck').hide();
                $('#sankalpapuja').hide();
                $('#eventone').hide();
                $('#twoevent').hide();
                $('#msgdiv').hide();
                $('#regmsgdiv').hide();
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
                        $("#payment_btn").prop("disabled", false);
                        $("#payment_btn").removeClass('disabled');
                    } else {
                        $("#payment_btn").prop("disabled", true);
                        $("#payment_btn").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
        }).delegate(".multiselect-checkbox", "change", function (e) {
            debugger;
            e.stopImmediatePropagation();
            var valnode = e.target.attributes[2].nodeValue;
            var ytd = $("#ytd1").val();
            var selected = [];
            for (var option of document.getElementById('sponsor').options) {
                if (option.selected) {
                    selected.push(option.value);
                }
            }
            selcetsubj = selected;
            if (ytd > 4600 && ytd < 9599) {
                if (selcetsubj.length > 1) {
                    selcetsubj.splice(-1);
                    $(this).val(last_valid_selection);
                    $('.multiselect-checkbox').val('valnode').prop('checked', false);
                    $("#sponsor_inputCount").empty('');
                    $("#sponsor option:selected").removeAttr("selected");
                    alert("Please Select only one");
                    $('.multiselect-input-div').find('input:text').val('');
                } else {
                    last_valid_selection = $(this).val();
                }
            }
            if (ytd >= 9600) {
                if (selcetsubj.length > 2) {
                    selcetsubj.splice(-1);
                    $(this).val(last_valid_selection);
                    $('.multiselect-checkbox').val('valnode').prop('checked', false);
                    $("#sponsor_inputCount").empty('');
                    $("#sponsor option:selected").removeAttr("selected");
                    alert("Please Select only Two");
                } else {
                    last_valid_selection = $(this).val();
                }

            }

        }).delegate('#checkamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var checkamount = $("#checkamount").val();
            var pujatotalamount = document.getElementById("finalprice").innerHTML;
            var finalpujaprice =  pujatotalamount.replace(/[^\w\s]/gi, '').trim();
            if( finalpujaprice != checkamount ){
                alert('Total amount and check amount not same please select correct amount');
                $("#payment_btn").addClass('disabled');
            }
            else{
                $("#payment_btn").removeClass('disabled');
            }
        }).delegate('#cashamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var cashamount = ($("#cashamount").val() * 1);
            var pujatotalamount = document.getElementById("finalprice").innerHTML;
            var finalpujaprice =  pujatotalamount.replace(/[^\w\s]/gi, '').trim();
            if( finalpujaprice != cashamount){
                alert('Total amount and cash amount not same please select correct amount');
                $("#payment_btn").addClass('disabled');
            }
            else{
                $("#payment_btn").removeClass('disabled');
            }
         
        }).delegate('#directamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var tickettotal = ($("#totalamount").val() * 1);
            var pujatotalamount = document.getElementById("finalprice").innerHTML;
            var finalpujaprice =  pujatotalamount.replace(/[^\w\s]/gi, '').trim();
            if(finalpujaprice != directprice){
                alert('Total amount and direct deposit amount not same please select correct amount');
                $("#payment_btn").addClass('disabled');
            }
            else{
                $("#payment_btn").removeClass('disabled');
            }
        }).delegate('#mememailfam', 'change', function (event) {
            //debugger;
               var email = $("#mememailfam").val();
               var baseUrl = $("#container-abc-url-id").text(); 
               if(!!email){
                             $.ajax({
                            type: "POST",
                            data: {
                                     email: email,
                                 },
                                url: baseUrl  + "load.php?controller=PujaOnlinePayments&action=Membercheck",
                                success: function (res) {
                                    //debugger
                                        let emailaddress = "";
                                        const EmailElement = $(res).filter("input#email");
                                            if(EmailElement.length){
                                                emailaddress = EmailElement[0].value; 
                                                if(emailaddress == 'true') {
                                                    alert('Email Already Registered');
                                                     //$("#gocartbutton").addClass('disabled');
                                                     $("#gocartbutton").hide();
                                                    emailvalid = false;
                                                } 
                                                else{
                                                    if(!!phonevalid){ 
                                                    $("#gocartbutton").show();
                                                    //$("#gocartbutton").removeClass('disabled');
                                                }
                                                else{
                                                    $("#gocartbutton").hide();
                                                    //$("#gocartbutton").addClass('disabled');
                                                }
                                                  emailvalid = true;
                                            }
                                }
                        }
                     });
                }else{
                    $("#gocartbutton").hide();
                    //$("#gocartbutton").addClass('disabled');
                    emailvalid = undefined;
                }
                   }).delegate('#memphonefam', 'change', function (event) {
                    //debugger; 
                    var Tele = $("#memphonefam").val();
                     var baseUrl = $("#container-abc-url-id").text();
                        if(!!Tele){   
                            $.ajax({
                            type: "POST",
                            data: {
                                 Tele: Tele
                                },
                                url: baseUrl  + "load.php?controller=PujaOnlinePayments&action=memberphone",
                                success: function (res) {
                                    //debugger;
                                    let mobile = "";
                                    const PhoneElement = $(res).filter("input#phone_mobile");
                                     if(PhoneElement.length){
                                         mobile = PhoneElement[0].value; 
                                            if(mobile == 'true') {
                                                alert('Mobile No Already Registered');
                                                $("#gocartbutton").hide();
                                               // $("#gocartbutton").addClass('disabled');
                                                phonevalid = false;

                                             } 
                                            else{
                                                if(!!emailvalid){ 
                                                    $("#gocartbutton").show();
                                                    //$("#gocartbutton").removeClass('disabled');
                               
                                                }
                                                else{
                                                    $("#gocartbutton").hide();
                                                    //$("#gocartbutton").addClass('disabled');
                                                }
                                                 phonevalid = true;
                                            }
                                        }
                                    }
                                });
                            }
                            else{
                                    $("#gocartbutton").hide();
                                    //$("#gocartbutton").addClass('disabled');
                                    phonevalid = undefined;
                                }
                        }).delegate('#sumupprice', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var sumpumount = ($("#sumupprice").val() * 1);
            var pujatotalamount = document.getElementById("finalprice").innerHTML;
            var finalpujaprice =  pujatotalamount.replace(/[^\w\s]/gi, '').trim();
            if(finalpujaprice != sumpumount){
                alert('Sumup  amount and direct deposit amount not same please select correct amount');
                $("#payment_btn").addClass('disabled');
            }
            else{
                $("#payment_btn").removeClass('disabled');
            }
        });

    });

}(jQuery));