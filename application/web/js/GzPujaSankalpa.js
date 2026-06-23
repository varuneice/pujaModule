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
        var otpAdminBypass = $.trim($('#otp-admin-bypass').text() || '') === '1';
        function hideSankalpaOtpGate() {
            $('#otp-gate').hide();
            $('#otp-verified-banner').hide().empty();
        }
        hideSankalpaOtpGate();
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
        function fillSankalpaReturningUser(memberId) {
            var verifiedMemberId = memberId || $.trim($('#otp-session-verified').text() || '');
            if (!verifiedMemberId) {
                return;
            }
            $('#otp-session-verified').text(verifiedMemberId);
            $('#otp-gate').hide();
            $('#otp-verified-banner').show();
            $.ajax({
                type: "POST",
                data: { memberid: verifiedMemberId, member_id: verifiedMemberId },
                url: url + "load.php?controller=PujaSankalpa&action=AllMemberNew",
                success: function (res) {
                    if (!$.trim(res) || $.trim(res) === '0 results') {
                        $('#otp-verified-banner').html('<div style="background:#fdecea;border:1px solid #f5c6cb;color:#c0392b;border-radius:5px;padding:8px 12px;">Member not found. Please verify again.</div>');
                        return;
                    }
                    var first = parseMemberValue(res, 'MemberName');
                    var middle = parseMemberValue(res, 'middle_name');
                    var last = parseMemberValue(res, 'last_name');
                    $('#term').val($.trim(first + ' ' + middle + ' ' + last)).prop('readonly', true).attr('autocomplete', 'off');
                    $('#termMember').val(verifiedMemberId);
                    $('#memberid').val(parseMemberValue(res, 'memberid') || verifiedMemberId);
                    $('#firstname').val(first).prop('readonly', true);
                    $('#lastname').val(last).prop('readonly', true);
                    $('#membertype').val(parseMemberValue(res, 'membershiptype'));
                    $('#MembCategory').val(parseMemberValue(res, 'membercategory'));
                    $('#streetno').val(parseMemberValue(res, 'ressidentalAddress'));
                    $('#ressidentalAddress').val(parseMemberValue(res, 'Address'));
                    $('#unitname').val(parseMemberValue(res, 'unitAddress'));
                    $('#city').val(parseMemberValue(res, 'city'));
                    $('#state').val(parseMemberValue(res, 'state'));
                    $('#zip_code').val(parseMemberValue(res, 'zip_code'));
                    $('#phone').val(parseMemberValue(res, 'Tele1').replace(/[-)(]/g, '')).prop('readonly', true);
                    $('#alternatephonenumber').val(parseMemberValue(res, 'phone_No').replace(/[-)(]/g, ''));
                    $('#email').val(parseMemberValue(res, 'email')).prop('readonly', true);
                    $('#alternateemail').val(parseMemberValue(res, 'email2'));
                    $('#gotraname').val(parseMemberValue(res, 'gotra'));
                    $('#searchidrow').hide();
                    $('#memberinformationdiv').show();
                    $('#otp-verified-banner').html('<div style="background:#eafaf1;border:1px solid #b7e4c7;color:#1e8449;border-radius:5px;font-size:13px;font-weight:600;padding:8px 12px;">Returning user verified and details auto-filled: <strong>' + $('<span>').text($.trim(first + ' ' + last)).html() + '</strong></div>');
                },
                error: function () {
                    $('#otp-verified-banner').html('<div style="background:#fdecea;border:1px solid #f5c6cb;color:#c0392b;border-radius:5px;padding:8px 12px;">Could not load member data. Please refresh and try again.</div>');
                }
            });
        }
        function openSankalpaOtp() {
            if (typeof window.OtpMemberVerify === 'undefined') {
                alert('OTP verification is not available. Please refresh and try again.');
                hideSankalpaOtpGate();
                return false;
            }
            $('#otp-gate').hide();
            window.OtpMemberVerify.open({
                onVerified: function (memberId) {
                    fillSankalpaReturningUser(memberId);
                }
            });
            window.onOtpModalCancelled = function () {
                $('#regmember').val('');
                $('#otp-gate').hide();
            };
            return true;
        }
        function getSankalpaTotalAmount() {
            return ($('#totalamount').val() || $('input[name="item_cost"]').val() || $('#pricepayment').text() || '').replace(/[$,\s]/g, '').trim();
        }
        function getSankalpaPayerName() {
            return $.trim(($('#firstname').val() || '') + ' ' + ($('#lastname').val() || ''));
        }
        function resetZelleVerification() {
            $('#Zellecode').val('');
            $('#MemberID').hide().empty().append('<option value="">Please select your payment details</option>');
            $('#zelle-action-btns').hide();
            $('#zelle-no-match').hide();
            $('#finalpaymentbutton').prop('disabled', true).addClass('disabled');
        }
        function showZelleManual(msg) {
            $('#MemberID1').show();
            $('#zelle-manual-fields').show();
            $('#zelle-action-btns').hide();
            $('#zelle-no-match').hide();
            $('#Zellecode').val('');
            $('#finalpaymentbutton').prop('disabled', true).addClass('disabled');
            if (msg) {
                $('#error_code1').css({ display: 'block', color: '#c0392b' }).html(msg);
            }
        }
        function searchZelleTransactions(donorName, zelleAmount, zelleDate) {
            $('#error_code1').css({ display: 'block', color: '#357ca5' }).html('<i class="fa fa-spinner fa-spin"></i> Searching your Zelle payment...');
            resetZelleVerification();
            var query = $.param({ donor_name: donorName, zelle_amount: zelleAmount, zelle_date: zelleDate || '' });
            $.ajax({
                type: "POST",
                data: { donor_name: donorName, zelle_amount: zelleAmount, zelle_date: zelleDate || '' },
                url: url + "load.php?controller=GzFront&action=checkCodeDD&" + query,
                success: function (res) {
                    var trimmed = $.trim(res);
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
                    if (!opts.length || opts.length > 25) {
                        $('#error_code1').css('color', '#c0392b').html('No unique Zelle payment found. Check your Zelle name, amount, and payment date, then try again.');
                        $('#zelle-no-match').show();
                        showZelleManual('');
                        return;
                    }
                    $('#MemberID').empty().append('<option value="">Please select your payment details</option>').append(opts).show();
                    $('#zelle-action-btns').show();
                    $('#zelle-manual-fields').hide();
                    $('#zelle-no-match').hide();
                    if (opts.length === 1) {
                        $('#MemberID').val(opts.first().val()).trigger('change');
                        $('#error_code1').css('color', '#276632').html('<i class="fa fa-check-circle"></i> Zelle payment matched and selected automatically.');
                    } else {
                        $('#error_code1').css('color', '#276632').html('Matching Zelle payments found. Please select yours, then click <b>Verify Selected Transaction</b>.');
                    }
                },
                error: function () {
                    $('#error_code1').css('color', '#c0392b').html('Could not search Zelle payment. Please try again.');
                }
            });
        }
        $('#registration-frm-id').on('submit', function (event) {
            if (!otpAdminBypass && $('#PaymentOption').val() === 'others' && !$.trim($('#Zellecode').val() || '')) {
                event.preventDefault();
                stopLoadingSoon();
                showZelleManual('Please verify your Zelle transaction before continuing.');
                return false;
            }
        });
        $(document).on('change', '#regmember', function () {
            if (otpAdminBypass) {
                hideSankalpaOtpGate();
                return true;
            }
            if ($(this).val() === 'member') {
                var verifiedMemberId = $.trim($('#otp-session-verified').text() || '');
                if (verifiedMemberId) {
                    fillSankalpaReturningUser(verifiedMemberId);
                    return true;
                }
                $('#searchidrow').hide();
                $('#term').val('').prop('readonly', true);
                openSankalpaOtp();
            } else {
                hideSankalpaOtpGate();
                $('#term').prop('readonly', false);
            }
            return true;
        });
        $(document).on('keydown focus paste input', '#term', function (event) {
            if (!otpAdminBypass && $('#regmember').val() === 'member') {
                event.preventDefault();
                $(this).blur();
                return false;
            }
        });
        if (!otpAdminBypass && $('#regmember').val() === 'member' && $.trim($('#otp-session-verified').text())) {
            fillSankalpaReturningUser($.trim($('#otp-session-verified').text()));
        } else if (otpAdminBypass || $('#regmember').val() !== 'member') {
            hideSankalpaOtpGate();
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
            
                 $("#zelleProxyData").hide(); 
            $('#payremovediv').remove();
            $('#cartbutton').prop('disabled', false);
            $('.selectpicker').selectpicker('deselectAll');
            $('#cartbutton').html("Add to cart");
        }).delegate('#PaymentOption', 'change', function (e) {
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
                 
                 $("#proxyTrId").val("");
                 $("#proxyTrdate").val("");
                 $("#proxyprice").val("");   
                 $("#proxyTrId").prop('required', false);
                 $("#proxyTrdate").prop('required', false);
                 $("#proxyprice").prop('required', false);    
                 $("#zelleProxyData").hide(); 

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
                elem.setAttribute("src", url + "zelleqrcode.jpg");
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
                $('#error_code1').html("Step 1 - Without closing this page, open a new web page and go to your Bank's portal." + "<br>" + "Step 2 - Send your Zelle payment from your Bank's portal. To register as a new recipient, Name = Houston Durga Bari Society, Email = treasurerpuja@durgabari.org." + "<br>" + "Step 3 - Return to this page, enter the name used in Zelle and payment date, then click 'Get Zelle Payment Details'." + "<br>" + "Step 4 - Select your payment details from the dropdown and verify it." + "<br>" + "Step 5 - Make Payment." + "<br>");
                $('#error_code2').html("<br>" + "Note:It may take some time for the Zelle payment information to appear (depending on network speed at both User and Bank ends).");
                $("#stripe_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdeposite").hide();
                $("#MemberID1").show();
                $("#MemberID").prop('required', true);
                resetZelleVerification();
                $('#zelle_donor_name').val(getSankalpaPayerName());
                $('#zelle-manual-fields').show();
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
                
                $("#proxyTrId").val("");
                 $("#proxyTrdate").val("");
                 $("#proxyprice").val("");   
                 $("#proxyTrId").prop('required', false);
                 $("#proxyTrdate").prop('required', false);
                 $("#proxyprice").prop('required', false);    
                 $("#zelleProxyData").hide(); 

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
                
                $("#proxyTrId").val("");
                 $("#proxyTrdate").val("");
                 $("#proxyprice").val("");   
                 $("#proxyTrId").prop('required', false);
                 $("#proxyTrdate").prop('required', false);
                 $("#proxyprice").prop('required', false);    
                 $("#zelleProxyData").hide(); 
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
                
                $("#proxyTrId").val("");
                 $("#proxyTrdate").val("");
                 $("#proxyprice").val("");   
                 $("#proxyTrId").prop('required', false);
                 $("#proxyTrdate").prop('required', false);
                 $("#proxyprice").prop('required', false);    
                 $("#zelleProxyData").hide(); 
    
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
                
                $("#proxyTrId").val("");
                 $("#proxyTrdate").val("");
                 $("#proxyprice").val("");   
                 $("#proxyTrId").prop('required', false);
                 $("#proxyTrdate").prop('required', false);
                 $("#proxyprice").prop('required', false);    
                 $("#zelleProxyData").hide(); 
    
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
                
                $("#proxyTrId").val("");
                 $("#proxyTrdate").val("");
                 $("#proxyprice").val("");   
                 $("#proxyTrId").prop('required', false);
                 $("#proxyTrdate").prop('required', false);
                 $("#proxyprice").prop('required', false);    
                 $("#zelleProxyData").hide(); 

                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $('#finalpaymentbutton').prop('disabled', false);
                $("#finalpaymentbutton").removeClass('disabled');
    
            }
            else if(val == 'ComplimentaryRegistration'){
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
                 $("#proxyTrId").val("");
                 $("#proxyTrdate").val("");
                 $("#proxyprice").val("");   
                 $("#proxyTrId").prop('required', false);
                 $("#proxyTrdate").prop('required', false);
                 $("#proxyprice").prop('required', false);    
                 $("#zelleProxyData").hide(); 
            }
              else if (val == 'zelleProxy') {
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdeposite").hide()
                $("#Sumupdata").hide();
                $("#paymentbuttondiv").show();
                $("#zelleProxyData").show();
                
                $("#sumdata").prop('required', false);
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
                document.getElementById("MemberID1").style.display = "none";
                $('#finalpaymentbutton').prop('disabled', false);
                $("#finalpaymentbutton").removeClass('disabled');
    
            }
            else {
                $("#paymentbuttondiv").hide();
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdeposite").hide()
                $("#Sumupdata").hide();
                 $("#zelleProxyData").hide();
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
            event.preventDefault();
            $("#error_codeimg").css('display', 'none');
            var donorName = $.trim($('#zelle_donor_name').val() || getSankalpaPayerName());
            var zelleAmount = getSankalpaTotalAmount();
            var zelleDate = $.trim($('#zelle_date').val() || '');
            if (!donorName) {
                alert('Please enter your name as used in Zelle.');
                $('#zelle_donor_name').focus();
                return false;
            }
            if (!zelleAmount) {
                alert('Please add Puja items before searching Zelle payment.');
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
                data: $("#registration-frm-id").serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode",
                complete: function () {
                    stopLoadingSoon();
                    searchZelleTransactions(donorName, zelleAmount, zelleDate);
                }
            });
        }).delegate('#MemberID', 'click', function (event) {
            return true;
        }).delegate('#MemberID', 'change', function (event) {
            var $selected = $("#MemberID option:selected");
            var dd = $("#MemberID").val();
            $("#Zellecode").val('');
            $('#finalpaymentbutton').prop("disabled", true).addClass('disabled');
            if (!dd || dd === '1') {
                return;
            }

            var parts = dd.split("/");
            var cmCode = $.trim($selected.data('code') || parts[3] || '');
            var selectedPriceRaw = $selected.data('amount') || parts[2] || '';
            var selectedPrice = selectedPriceRaw ? parseFloat(String(selectedPriceRaw).replace(/[$,\s]/g, '').trim()) : NaN;
            var total = parseFloat(getSankalpaTotalAmount());
            
            if (cmCode) {
                $("#Zellecode").val(cmCode);
            }

            if (!isNaN(total) && !isNaN(selectedPrice) && Math.abs(total - selectedPrice) < 0.01 && cmCode) {
                $('#finalpaymentbutton').prop("disabled", false);
                $("#finalpaymentbutton").removeClass('disabled');
            }
            else {
                $("#Zellecode").val('');
                $('#finalpaymentbutton').prop("disabled", true);
                $("#finalpaymentbutton").addClass('disabled');
                alert('Total price and select  price is not same please select correct payment');
            }

        }).delegate('#zelle-verify-btn', 'click', function (event) {
            event.preventDefault();
            $('#MemberID').trigger('change');
            return false;
        }).delegate('#zelle-retry-btn', 'click', function (event) {
            event.preventDefault();
            resetZelleVerification();
            $('#zelle_donor_name').val(getSankalpaPayerName());
            $('#zelle-manual-fields').show();
            $('#zelle_donor_name').focus();
            return false;
        }).delegate("a.icon-delete", 'click', function (e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#cat_id').text($(this).attr('cat'));
            $('#dialogDelete').dialog('open');
        }).delegate('#checkamount', 'change', function (e) {
            e.stopImmediatePropagation();
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
        }).delegate('#proxyprice', 'change', function (e) {
            e.stopImmediatePropagation();
            var proxyumount = ($("#proxyprice").val() * 1);
            var pujatotalamount = document.getElementById("pricepayment").innerHTML;
            var finalpujaprice =  pujatotalamount.split(" ");
            if(finalpujaprice[0] != proxyumount){
                alert('Zelle Proxy amount and direct deposit amount not same please select correct amount');
                $("#finalpaymentbutton").addClass('disabled');
            }
            else{
              
                $("#finalpaymentbutton").removeClass('disabled');
            }
        }).delegate('#sumupprice', 'change', function (e) {
            e.stopImmediatePropagation();
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
