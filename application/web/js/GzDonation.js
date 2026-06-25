(function ($) {
    $(function () {
        var url = $("#container-abc-url-id").text();
        var selcetsubj = null;
        if ($('#stripe_secret_key_id').length > 0 && typeof Stripe === 'function') {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }
        function stopLoadingSoon() {
            if ($.LoadingOverlay) {
                $.LoadingOverlay("hide");
                setTimeout(function () { $.LoadingOverlay("hide"); }, 0);
            }
        }
        function parseMemberValue(res, id) {
            var el = $(res).filter("input#" + id);
            return el.length ? $.trim(el[0].value) : "";
        }
        function withCsrf(data) {
            var payload = $.extend({}, data || {});
            var token = $('input[name="csrf_token"]').first().val();
            if (token && !payload.csrf_token) {
                payload.csrf_token = token;
            }
            return payload;
        }
        function serializeWithCsrf($form) {
            var serialized = $form && $form.length ? $form.serialize() : '';
            var token = $('input[name="csrf_token"]').first().val();
            if (token && serialized.indexOf('csrf_token=') === -1) {
                serialized += (serialized ? '&' : '') + 'csrf_token=' + encodeURIComponent(token);
            }
            return serialized;
        }
        function getDonationTotalAmount() {
            return ($('#total').val() || $('#total').text() || '').replace(/[$,\s]/g, '').trim();
        }
        function getDonationPayerName() {
            if ($('#registrationmember').val() === 'member') {
                return ($('#Your_Name').val() || $.trim($('#First_name').val() + ' ' + $('#last_name').val())).trim();
            }
            return $.trim($('#First_name').val() + ' ' + $('#last_name').val());
        }
        function getChicagoDate() {
            return new Intl.DateTimeFormat('en-CA', {
                timeZone: 'America/Chicago',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).format(new Date());
        }
        function logZelleDebug(step, data) {
            if (window.console && console.log) {
                console.log('[PujaDonation Zelle] ' + step, data || {});
            }
        }
        window.sponsoramount = function () {
            var phonenumber = $("#phone").val();
            if (phonenumber) {
                if (isNaN(phonenumber)) {
                    alert("Please Enter mobile Number");
                    $("#payment_btn_id").addClass('disabled');
                } else if (phonenumber.length !== 10) {
                    alert("Number should be 10 digits");
                    $("#payment_btn_id").addClass('disabled');
                } else {
                    $("#payment_btn_id").removeClass('disabled');
                }
            } else {
                $("#phone").prop('required', true);
                $("#payment_btn_id").removeClass('disabled');
            }
        };
        function resetZelleVerification() {
            $('#Zellecode').val('');
            $('#MemberID').hide().empty().append('<option value="">Please select your payment details</option>');
            $('#zelle-action-btns').hide();
            $('#zelle-no-match').hide();
            $('#payment_btn_id').prop('disabled', true).addClass('disabled');
        }
        function showZelleManual(msg) {
            $('#MemberID1').show();
            $('#zelle-manual-fields').show();
            $('#zelle-action-btns').hide();
            $('#zelle-no-match').hide();
            $('#Zellecode').val('');
            $('#payment_btn_id').prop('disabled', true).addClass('disabled');
            if (msg) {
                $('#error_code1').css({ display: 'block', color: '#c0392b' }).html(msg);
            }
        }
        function searchZelleTransactions(donorName, zelleAmount, zelleDate) {
            $('#error_code1').css({ display: 'block', color: '#357ca5' }).html('<i class="fa fa-spinner fa-spin"></i> Searching your Zelle transaction...');
            resetZelleVerification();
            var query = $.param({ donor_name: donorName, zelle_amount: zelleAmount, zelle_date: zelleDate || '' });
            logZelleDebug('checkCodeDD request', {
                donor_name: donorName,
                zelle_amount: zelleAmount,
                zelle_date: zelleDate || '',
                url: url + "load.php?controller=GzFront&action=checkCodeDD&" + query
            });
            $.ajax({
                type: "POST",
                data: withCsrf({ donor_name: donorName, zelle_amount: zelleAmount, zelle_date: zelleDate || '' }),
                url: url + "load.php?controller=GzFront&action=checkCodeDD&" + query,
                success: function (res) {
                    var trimmed = $.trim(res);
                    logZelleDebug('checkCodeDD response', { raw: res, trimmed: trimmed });
                    if (!trimmed || trimmed === 'NO_MATCH') {
                        $('#error_code1').css('color', '#c0392b').html('No matching Zelle payment found. Check your Zelle name, amount, and payment date, then try again.');
                        $('#zelle-no-match').show();
                        showZelleManual('');
                        return;
                    }
                    var opts = $(trimmed).filter('option');
                    if (!opts.length) {
                        opts = $(trimmed);
                    }
                    if (!opts.length) {
                        $('#error_code1').css('color', '#c0392b').html('No matching Zelle payment found. Check your Zelle name, amount, and payment date, then try again.');
                        $('#zelle-no-match').show();
                        return;
                    }
                    if (opts.length > 25) {
                        logZelleDebug('too many matches', { count: opts.length });
                        $('#error_code1').css('color', '#c0392b').html('No unique Zelle payment found. Check your Zelle name, amount, and payment date, then try again.');
                        $('#zelle-no-match').show();
                        showZelleManual('');
                        return;
                    }
                    $('#MemberID').empty().append('<option value="">Please select your payment details</option>').append(opts).show();
                    $('#zelle-action-btns').show();
                    $('#zelle-manual-fields').hide();
                    $('#zelle-no-match').hide();
                    logZelleDebug('matches found', { count: opts.length });
                    if (opts.length === 1) {
                        $('#MemberID').val(opts.first().val()).trigger('change');
                        $('#error_code1').css('color', '#276632').html('<i class="fa fa-check-circle"></i> Zelle transaction matched and selected automatically.');
                    } else {
                        $('#error_code1').css('color', '#276632').html('Matching Zelle payments found. Please select yours, then click <b>Verify Selected Transaction</b>.');
                    }
                },
                error: function () {
                    logZelleDebug('checkCodeDD error');
                    $('#error_code1').css('color', '#c0392b').html('Could not search Zelle transactions. Please try again.');
                }
            });
        }
        function doDonationZelleAutoSearch() {
            var donorName = $.trim(getDonationPayerName());
            var zelleAmount = getDonationTotalAmount();
            var zelleDate = getChicagoDate();

            logZelleDebug('auto-search prepared', {
                donor_name: donorName,
                zelle_amount: zelleAmount,
                zelle_date: zelleDate,
                registrationmember: $('#registrationmember').val(),
                First_name: $('#First_name').val(),
                last_name: $('#last_name').val(),
                Your_Name: $('#Your_Name').val()
            });

            $('#zelle_donor_name').val(donorName);
            $('#zelle_date').val(zelleDate);

            if (!donorName) {
                logZelleDebug('auto-search fallback', { reason: 'missing donor name' });
                showZelleManual('Please enter your name as used in Zelle, then verify your payment.');
                $('#zelle_donor_name').focus();
                return;
            }
            if (!zelleAmount) {
                logZelleDebug('auto-search fallback', { reason: 'missing donation amount' });
                showZelleManual('Please enter donation amount first, then verify your Zelle payment.');
                $('#total').focus();
                return;
            }

            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                data: serializeWithCsrf($("#donation-frm-id")),
                url: url + "load.php?controller=GzFront&action=checkCode",
                complete: function () {
                    stopLoadingSoon();
                    searchZelleTransactions(donorName, zelleAmount, zelleDate);
                },
                success: function (res) {
                    logZelleDebug('checkCode import response', { raw: res });
                },
                error: function () {
                    logZelleDebug('checkCode import error');
                }
            });
        }
        $('#donation-frm-id').on('submit', function (event) {
            if ($('#PaymentOption').val() === 'others' && !$.trim($('#Zellecode').val() || '')) {
                event.preventDefault();
                stopLoadingSoon();
                showZelleManual('Please verify your Zelle transaction before continuing.');
                return false;
            }
        });
        //let emailvalid = true;
        //let phonevalid = true;
        // For Member Search option...........................
        function MemberSelect() {

            var self = this;
            var data = $("#termMember").val();
            var term = $("#term").val();
            if (term != "") {
                const Memberid = data.split("-");
                //var url = gz$("#container-abc-url-id").text(); 
                if (term.trim() != "") {
                    $.ajax({
                        type: "POST",
                        data: withCsrf({
                            memberid: data
                        }),
                        //url: self.options.server  +"load.php?controller=Donations&action=AllMember&cid=" + self.options.cal_id,
                        url: url + "load.php?controller=Donations&action=AllMember&cid",
                        success: function (res) {
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
                            new_phone = phoneNo.replace(/[-)(]/g,"");
                            document.getElementById("phone").value = new_phone;

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
                    $("#memberid").val(""); 
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

        $(document).delegate('#reset-btn-id', 'click', function (e) {
            $('#donation-frm-id')[0].reset();
            $('#msgdiv').hide();
            $('#sponsorcheck').hide();
        }).delegate('#PaymentOption', 'change', function (e) {
            var val = $(this).val();
            const price = parseInt($("#total").val());
            $("#payment_btn_id").removeClass('disabled');
            if (price < 1) {
                alert("Minimum Amount $1");
                $("#total").prop('required', true);
                $("#payment_btn_id").addClass('disabled');
                document.getElementById("PaymentOption").value = "";
                return;
            } 

            if (val == 'stripe') {
                if (!stripe) {
                    alert('Credit card payment is not available right now. Please use Zelle or refresh the page.');
                    document.getElementById("PaymentOption").value = "";
                    $("#payment_btn_id").addClass('disabled');
                    return;
                }
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#directdeposite").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#zelleProxyData").hide();
                $("#stripe_details").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
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
                $("#sumupid").prop('required', false);
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
                $("#sumupid").val("");
                $("#sumupprice").val("");
                $("#sumdatedate").val("");
                
                $("#proxyTrId").val("");
                $("#proxyTrdate").val("");
                $("#proxyprice").val("");
                $("#proxyTrId").prop('required', false);
                $("#proxyTrdate").prop('required', false);
                $("#proxyprice").prop('required', false);

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
            } 
            else if (val == 'others') {
                var elem = document.createElement("img");
                // elem.setAttribute("src", "https://durgabari.org/HDBS_Payment/zelle.png");
                elem.setAttribute("src", url + "zelleqrcode.jpg");
                elem.setAttribute("height", "600");
                elem.setAttribute("width", "600");

                elem.setAttribute("alt", "Zelle");
                $('#error_codeimg').html(elem);
                //document.getElementById("error_codeimg").style.marginLeft = "88px";
                document.getElementById("error_codeimg").style.textAlign = "center";
                document.getElementById("error_codeimg").style.marginTop = "30px";
                 //document.getElementById("error_code1").style.marginLeft = "75px";
                document.getElementById("error_code1").style.paddingTop = "12px";
                document.getElementById("checkPaymentData").style.display = "block";
                document.getElementById("MemberID1").style.display = "block";
                document.getElementById("error_code1").style.display = "block";
                document.getElementById("error_code2").style.display = "block";
                //change on 31-july
                //document.getElementById("error_codeimg").style.display = "block";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("error_code1").style.color = "#ff0000";
                document.getElementById("error_code2").style.color = "#ff0000";
                $('#error_code1').html("Step 1 - Without closing this page, open a new web page and go to your Bank’s portal." + "<br>" + "Step 2 - : From the Bank’s portal, send your Zelle payment to   <span style='font-weight: 700; color: #17af22;'>treasurerpuja@durgabari.org </span>. To register HDBS Puja as a new recipient, Name = Houston Durga Bari Society, Email = treasurerpuja@durgabari.org PLEASE DO NOT MAKE PAYMENT TO ANY OTHER ACCOUNT WITH A DIFFERENT EMAIL ADDRESS. This system will not be able to retrieve the payment information in that case." + "<br>" + "Step 3 - Return to this page and click ‘Get Zelle Payment Details’ button." + "<br>" + "Step 4 - Select your payment details from the dropdown (click on ‘Please select your payment details)." + "<br>" + "Step 5 - Make Payment." + "<br>");
                $('#error_code2').html("<br>" + "Note it may take some time for the Zelle payment information to appear (depending on network speed at both User and Bank ends). If you don’t find your records, please check back after 24 hours, and if you still don’t find the records, please contact registration@durgabari.org with full details.");
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdeposite").hide();
                $("#zelleProxyData").hide();
                $("#MemberID1").show();
                $("#MemberID").show();
                $("#MemberID").prop('required', true);
                 $('#zelledatadiv').show();
                resetZelleVerification();
                $('#zelle_donor_name').val(getDonationPayerName());
                $('#zelle-manual-fields').hide();
                $('#payment_btn_id').prop('disabled', true).addClass('disabled');
                $('#zelle-modal-overlay').css('display', 'flex');
                logZelleDebug('payment option selected', {
                    payment_option: val,
                    donor_name: getDonationPayerName(),
                    amount: getDonationTotalAmount()
                });
                //$("#others_details").show();

                
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
                $("#sumupid").prop('required', false);
                $("#sumupprice").prop('required', false);
                $("#sumdatedate").prop('required', false);

                $("#checkbankname").val("");
                $("#checkno").val("");
                $("#checkamount").val("");
                $("#checkdate").val("");
                $("#bankname").val("");
                $("#ISFCCode").val("");
                $("#stripe_details").hide();
                $("#directamount").val("");
                $("#directdeposite").val("");
                $("#receiveby").val("");
                $("#cashamount").val("");
                $("#cashdate").val("");
                $("#sumupid").val("");
                $("#sumupprice").val("");
                $("#sumdatedate").val("");
                
                $("#proxyTrId").val("");
                $("#proxyTrdate").val("");
                $("#proxyprice").val("");
                $("#proxyTrId").prop('required', false);
                $("#proxyTrdate").prop('required', false);
                $("#proxyprice").prop('required', false);
                
            }else if (val == 'check') {

                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdeposite").hide();
                $("#zelleProxyData").hide();
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
                $("#sumupid").val("");
                $("#sumupprice").val("");
                $("#sumdatedate").val("");
    
                $("#receiveby").prop('required', false);
                $("#cashamount").prop('required', false);
                $("#cashdate").prop('required', false);
    
                $("#bankname").prop('required', false);
                $("#ISFCCode").prop('required', false);
                $("#directamount").prop('required', false);
                $("#directdeposite").prop('required', false);
                
                $("#sumupid").prop('required', false);
                $("#sumupprice").prop('required', false);
                $("#sumdatedate").prop('required', false);
    
                $("#checkbankname").prop('required', true);
                $("#checkno").prop('required', true);
                $("#checkamount").prop('required', true);
                $("#checkdate").prop('required', true);
    
                $("#MemberID").prop('required', false);
                $("#proxyTrId").val("");
                $("#proxyTrdate").val("");
                $("#proxyprice").val("");
                $("#proxyTrId").prop('required', false);
                $("#proxyTrdate").prop('required', false);
                $("#proxyprice").prop('required', false);
                
                
            } else if (val == 'cash') {
    
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#directdeposite").hide();
                $("#checkdata").hide();
                $("#Sumupdata").hide();
                $("#zelleProxyData").hide();
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
                $("#sumupid").val("");
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
            
                $("#sumupid").prop('required', false);
                $("#sumupprice").prop('required', false);
                $("#sumdatedate").prop('required', false);
                
                $("#receiveby").prop('required', true);
                $("#cashamount").prop('required', true);
                $("#cashdate").prop('required', true);
    
                $("#MemberID").prop('required', false);
                
                $("#proxyTrId").val("");
                $("#proxyTrdate").val("");
                $("#proxyprice").val("");
                $("#proxyTrId").prop('required', false);
                $("#proxyTrdate").prop('required', false);
                $("#proxyprice").prop('required', false);
    
            } else if (val == 'directdeposit') {
    
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#zelleProxyData").hide();
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
                $("#sumupid").val("");
                $("#sumupprice").val("");
                $("#sumdatedate").val("");
    
                $("#checkbankname").prop('required', false);
                $("#checkno").prop('required', false);
                $("#checkamount").prop('required', false);
                $("#checkdate").prop('required', false);
    
                $("#receiveby").prop('required', false);
                $("#cashamount").prop('required', false);
                $("#cashdate").prop('required', false);
                
                $("#sumupid").prop('required', false);
                $("#sumupprice").prop('required', false);
                $("#sumdatedate").prop('required', false);
    
                $("#bankname").prop('required', true);
                $("#ISFCCode").prop('required', true);
                $("#directamount").prop('required', true);
                $("#directdepositdate").prop('required', true);
                
                $("#proxyTrId").val("");
                $("#proxyTrdate").val("");
                $("#proxyprice").val("");
                $("#proxyTrId").prop('required', false);
                $("#proxyTrdate").prop('required', false);
                $("#proxyprice").prop('required', false);
    
                $("#MemberID").prop('required', false);
    
            }
            else if (val == 'sumup') {
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdeposite").hide()
                $("#Sumupdata").show();
                $("#zelleProxyData").hide();
                
                $("#sumupid").prop('required', true);
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
                
                $("#proxyTrId").val("");
                $("#proxyTrdate").val("");
                $("#proxyprice").val("");
                $("#proxyTrId").prop('required', false);
                $("#proxyTrdate").prop('required', false);
                $("#proxyprice").prop('required', false);
                
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
    
            } 
            
            else if (val == 'zelleProxy') {
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdeposite").hide()
                $("#Sumupdata").hide();
                $("#MemberID1").show();
                $("#zelleProxyData").show();
                $("#MemberID").hide();
                $("#zelle-action-btns").hide();
                $("#zelle-manual-fields").hide();
                $("#zelle-no-match").hide();
                
                $("#sumupid").prop('required', false);
                $("#sumupprice").prop('required', false);
                $("#sumdatedate").prop('required', false);
                
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

                $("#proxyTrId").prop('required', true);
                $("#proxyTrdate").prop('required', true);
                $("#proxyprice").prop('required', true);

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
                $("#proxyTrId").val("");
                $("#proxyTrdate").val("");
                $("#proxyprice").val("");
                
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
            }
            else {
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdeposite").hide();
                $("#Sumupdata").hide();
                $("#zelleProxyData").hide();
            }
        }).delegate('#confirm_code', 'change', function (event) {
            var frm = $("#payment-form");
            $("#error_code1").css('display', 'none');
            $("#error_codeimg").css('display', 'none');
            $.ajax({
                type: "POST",
                data: serializeWithCsrf(frm),
                url: url + "load.php?controller=GzFront&action=checkCode",
                success: function (res) {
                    var check = res.includes("Your payment code is matched you can book");

                    if (check == true) {
                        $("#payment_btn_id").removeClass('disabled');
                    } else {
                        $("#payment_btn_id").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
        }).delegate('#zelle-modal-paid-btn', 'click', function (event) {
            event.preventDefault();
            $('#zelle-modal-overlay').hide();
            logZelleDebug('modal completed payment clicked');
            doDonationZelleAutoSearch();
            return false;
        }).delegate('#zelle-modal-cancel-btn, #zelle-modal-close', 'click', function (event) {
            event.preventDefault();
            $('#zelle-modal-overlay').hide();
            $('#PaymentOption').val('').trigger('change');
            resetZelleVerification();
            logZelleDebug('modal cancelled');
            return false;
        }).delegate('#checkPaymentData', 'click', function (event) {
            event.preventDefault();
            var donorName = $.trim($('#zelle_donor_name').val() || getDonationPayerName());
            var zelleAmount = getDonationTotalAmount();
            var zelleDate = $.trim($('#zelle_date').val() || '');
            logZelleDebug('manual verify clicked', {
                donor_name: donorName,
                zelle_amount: zelleAmount,
                zelle_date: zelleDate
            });
            if (!donorName) {
                alert('Please enter your name as used in Zelle.');
                $('#zelle_donor_name').focus();
                return false;
            }
            if (!zelleAmount) {
                alert('Please enter donation amount first.');
                $('#total').focus();
                return false;
            }
            if (!zelleDate) {
                alert('Please enter your Zelle payment date.');
                $('#zelle_date').focus();
                return false;
            }
            $('#zelle_donor_name').val(donorName);
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                data: serializeWithCsrf($("#donation-frm-id")),
                url: url + "load.php?controller=GzFront&action=checkCode",
                complete: function () {
                    stopLoadingSoon();
                    searchZelleTransactions(donorName, zelleAmount, zelleDate);
                }
            });
        }).delegate('#MemberID', 'change', function (event) {
            //debugger
            var dd = $("#MemberID").val();
            logZelleDebug('selected transaction changed', { value: dd });
            $("#Zellecode").val('');
            $('#payment_btn_id').prop("disabled", true).addClass('disabled');
            if (!dd || dd === '1') {
                logZelleDebug('selected transaction ignored', { reason: 'empty or placeholder' });
                return;
            }

            var parts = dd.split("/");
            var cmCode = $.trim(parts[3] || '');
            var price = parts[2] ? parseFloat(parts[2].replace(/[$,\s]/g, '').trim()) : NaN;

            var tot = parseFloat(getDonationTotalAmount());

            if (cmCode) {
                $("#Zellecode").val(cmCode);
            }

            if (!isNaN(tot) && !isNaN(price) && tot === price && cmCode) {
                logZelleDebug('selected transaction accepted', {
                    zelle_code: cmCode,
                    selected_amount: price,
                    total_amount: tot
                });
                $('#payment_btn_id').prop("disabled", false);
                $("#payment_btn_id").removeClass('disabled');
            }
            else {

                $("#Zellecode").val('');
                $('#payment_btn_id').prop("disabled", true).addClass('disabled');
                logZelleDebug('selected transaction rejected', {
                    zelle_code: cmCode,
                    selected_amount: price,
                    total_amount: tot
                });
                alert('Total amount and selected Zelle amount do not match. Please select the correct payment.');
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

        }).delegate('#zelle-verify-btn', 'click', function (event) {
            event.preventDefault();
            $('#MemberID').trigger('change');
            return false;
        }).delegate('#zelle-retry-btn', 'click', function (event) {
            event.preventDefault();
            resetZelleVerification();
            $('#zelle_donor_name').val(getDonationPayerName());
            $('#zelle-manual-fields').show();
            $('#zelle_donor_name').focus();
            return false;
        }).delegate('#MemberID', 'click', function (event) {
            return true;
        }).delegate('#email', 'change', function (event) {
            var email = $("#email").val();
            var phone = $("#phone").val();
            if (!!email) {
                $.ajax({
                    type: "POST",
                    data: withCsrf({
                        email: email
                    }),
                    url: url + "load.php?controller=PujaDonations&action=Membercheckregister&cid=email",
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
            var email = $("#email").val();
            var Tele = $("#phone").val();
            document.getElementById("ytd1").value = "";
            if (!!Tele) {
                $.ajax({
                    type: "POST",
                    data: withCsrf({
                        Tele: Tele
                    }),
                    url: url + "load.php?controller=PujaDonations&action=Membercheckregister&cid=email",
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
        }).delegate('#registrationmember', 'change', function (event) {
            var regmember = $("#registrationmember").val();
            selectVal = $('#registrationmember').val();
            $('#phone').prop('readonly', false);
            $('#email').prop('readonly', false);
            //add 11 july
            $('#memphone2fam').prop('readonly', false);
            if (selectVal == "member") {
                $("#IDMembertd").removeClass("disabledbutton");
                // 10julycomment
               // document.getElementById("spousename").value = "";
               document.getElementById("spouseFirst_name").value = "";
               document.getElementById("spouselast_name").value = "";
               document.getElementById("First_name").value = "";
               document.getElementById("last_name").value = "";
               document.getElementById("memphone2fam").value = "";
               document.getElementById("email2").value = "";
               
                document.getElementById("Street").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("ltd1").value = "";
                document.getElementById("ytd1").value = "";

                // 10julycomment
                //document.getElementById("namenonmember").value = "";
                document.getElementById("MembCategory").value = "";
                document.getElementById("term").value = "";
                document.getElementById("demmember").value = "";
                document.getElementById("sponser").value = "";
                document.getElementById("total").value = "";
                document.getElementById("futureytd").value = "";
                $("#total").val("");
                $("#futureytd").val("");
               // 10julycomment
                //$('#nonmembername').hide();
               // $('#fieldtest').hide();
                //$('#namemeemberregister').show();
                $('#IDMembertd').show();
               // 10julycomment
                //$("#namenonmember").prop('required', false);
                $("#term").prop('required', true);
                $("#demmember").prop('required', true);
                $('#sponsorcheck').hide();
                $('#msgdiv').hide();
                $('#regmsgdiv').hide();
                $('#phone').addClass('MIDtext2readonly');
                $('#email').addClass('MIDtext2readonly');
                
                //add 10 july
                $('#IDMembertd').show();
                $('#memberiddiv').show();
                $('#membercategorydiv').show();

                $('#First_name').prop('readonly', true);
                $('#last_name').prop('readonly', true);
                  
                  // 24julyupdate
                $('#IDMembertd').show();
                $('#memberiddiv').show();
                $('#membercategorydiv').show();
                $('#fnamediv').show();
                $('#lnamediv').show();
                $('#spfnamediv').show();
                $('#splnamediv').show();
                $('#streetdiv').show();
                $('#streetnamediv').show();
                $('#citydiv').show();
                $('#statediv').show();
                $('#zipdiv').show();
                $('#phonenodiv').show();
                $('#alterntenumberdiv').show();
                $('#emaildiv').show();
                $('#alternateemaildiv').show();
                $('#lifetimediv').show();
                $('#ytddiv').show();
                $('#amountdiv').show();
                $('#futureytddiv').show();
                $('#paydropdiv').show();
                $('#submitdatadiv').show();
                $('#otp-gate').hide();
                $('#otp-verified-banner').hide();

            }
            if (selectVal == "nonmember") {
                $('#otp-gate').hide();
                $('#otp-verified-banner').hide();
                $('#term').prop('readonly', false);
                $("#IDMembertd").addClass("disabledbutton");
                // 10julycomment
               // document.getElementById("spousename").value = "";
               document.getElementById("spouseFirst_name").value = "";
               document.getElementById("spouselast_name").value = "";
               document.getElementById("First_name").value = "";
               document.getElementById("last_name").value = "";
               document.getElementById("memphone2fam").value = "";
               document.getElementById("email2").value = "";

                document.getElementById("Street").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("ltd1").value = "";
                document.getElementById("ytd1").value = "";
                 // 10julycomment
                //document.getElementById("namenonmember").value = "";

                document.getElementById("MembCategory").value = "";
                document.getElementById("term").value = "";
                document.getElementById("demmember").value = "";
                document.getElementById("sponser").value = "";
                document.getElementById("futureytd").value = "";
                document.getElementById("total").value = "";
                $("#total").val("");
                $("#futureytd").val("");
                // 10julycomment
               // $('#namemeemberregister').hide();
                $('#IDMembertd').hide();
                // 10julycomment
                //$('#nonmembername').show();
                //$('#fieldtest').show();
                //$("#fieldtest").prop('readonly', true);
                //$("#namenonmember").prop('required', true);
                $("#term").prop('required', false);
                $("#demmember").prop('required', false);
                $('#sponsorcheck').hide();
                $('#msgdiv').hide();
                $('#regmsgdiv').hide();
                $('#sankalpapuja').hide();
                $('#eventone').hide();
                $('#twoevent').hide();
                $('#phone').removeClass('MIDtext2readonly')
                $('#phone').addClass('MIDtext2');
                $('#email').removeClass('MIDtext2readonly')
                $('#email').addClass('MIDtext2');
                
                 //add 10 july
                $('#IDMembertd').hide();
                $('#memberiddiv').hide();
                $('#membercategorydiv').hide();
                $('#First_name').prop('readonly', false);
                $('#last_name').prop('readonly', false);
                
                //add 11 july
                $('#memphone2fam').removeClass('MIDtext2readonly')
                $('#memphone2fam').addClass('MIDtext2');
                
                  // 24julyupdate
                 $('#fnamediv').show();
                $('#lnamediv').show();
                $('#spfnamediv').show();
                $('#splnamediv').show();
                $('#streetdiv').show();
                $('#streetnamediv').show();
                $('#citydiv').show();
                $('#statediv').show();
                $('#zipdiv').show();
                $('#phonenodiv').show();
                $('#alterntenumberdiv').show();
                $('#emaildiv').show();
                $('#alternateemaildiv').show();
                $('#lifetimediv').show();
                $('#ytddiv').show();
                $('#amountdiv').show();
                $('#futureytddiv').show();
                $('#paydropdiv').show();
                $('#submitdatadiv').show();

            }
            if (selectVal == "" || selectVal == " ") {
                $('#otp-gate').hide();
                $('#otp-verified-banner').hide();
                $('#term').prop('readonly', false);
                document.getElementById("sponser").value = "";
                document.getElementById("demmember").value = "";
               // 10julycomment
               // document.getElementById("spousename").value = "";
               document.getElementById("spouseFirst_name").value = "";
               document.getElementById("spouselast_name").value = "";
               document.getElementById("First_name").value = "";
               document.getElementById("last_name").value = "";
               document.getElementById("memphone2fam").value = "";
               document.getElementById("email2").value = "";
               
               
                document.getElementById("Street").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("ltd1").value = "";
                document.getElementById("ytd1").value = "";
                //document.getElementById("namenonmember").value = "";
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
                $('#phone').addClass('MIDtext2readonly');
                $('#email').addClass('MIDtext2readonly');
                
                // 24julyupdate
                $('#IDMembertd').hide();
                $('#memberiddiv').hide();
                $('#membercategorydiv').hide();
                $('#fnamediv').hide();
                $('#lnamediv').hide();
                $('#spfnamediv').hide();
                $('#splnamediv').hide();
                $('#streetdiv').hide();
                $('#streetnamediv').hide();
                $('#citydiv').hide();
                $('#statediv').hide();
                $('#zipdiv').hide();
                $('#phonenodiv').hide();
                $('#alterntenumberdiv').hide();
                $('#emaildiv').hide();
                $('#alternateemaildiv').hide();
                $('#lifetimediv').hide();
                $('#ytddiv').hide();
                $('#amountdiv').hide();
                $('#futureytddiv').hide();
                $('#paydropdiv').hide();
                $('#submitdatadiv').hide();
                $("#others_details").hide();
                $("#stripe_details").hide();
                $("#checkdata").hide();
                $("#directdeposite").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $('#zelledatadiv').hide();
                $('#MemberID1').hide();
                document.getElementById("PaymentOption").value = "";
                
                
            }

        }).delegate('#confirm_code', 'change', function (event) {
            var frm = $("#donation-frm-id");

            $.ajax({
                type: "POST",
                data: serializeWithCsrf(frm),
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
        }).delegate(".multiselect-checkbox", "change", function (e) {
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
            var checkamount = parseInt($("#checkamount").val());
            var donationamount = parseInt($("#total").val());
            if( donationamount != checkamount ){
                alert('Total amount and check amount not same please select correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
        }).delegate('#cashamount', 'change', function (e) {
            e.stopImmediatePropagation();
            var cashamount = parseInt($("#cashamount").val());
            var donationamount = parseInt($("#total").val());
            if( donationamount != cashamount){
                alert('Total amount and cash amount not same please select correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
         
        }).delegate('#directamount', 'change', function (e) {
            e.stopImmediatePropagation();
            var directdeposite = parseInt($("#directamount").val());
            var donationamount = parseInt($("#total").val());
            if(donationamount != directdeposite){
                alert('Total amount and direct deposit amount not same please select correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
        }).delegate('#sumupprice', 'change', function (e) {
            e.stopImmediatePropagation();
            var sumpumount = parseInt($("#sumupprice").val());
            var donationamount = parseInt($("#total").val());
            if(donationamount != sumpumount){
                alert('Sumup  amount and total amount not same please select correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
        }).delegate('#proxyprice', 'change', function (e) {
            e.stopImmediatePropagation();
            var proxyamount = $("#proxyprice").val();
            var donationamount = parseInt($("#total").val());
            if(donationamount != proxyamount){
                alert('Zelle Proxy  amount and total amount not same please select correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").prop("disabled", false);
                $("#payment_btn_id").removeClass('disabled');
            }
        });
;


    });

}(jQuery));
