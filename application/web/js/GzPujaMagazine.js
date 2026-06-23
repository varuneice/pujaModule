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
        function fillMagazineReturningUser(memberId) {
            $('#otp-session-verified').text(memberId || '');
            $('#showMember').show();
            $('#hide_nm').show();
            $('#term').prop('readonly', true).attr('autocomplete', 'off');
            $.ajax({
                type: "POST",
                data: { memberid: memberId || $('#otp-session-verified').text().trim(), member_id: memberId || $('#otp-session-verified').text().trim() },
                url: url + "load.php?controller=PujaDonations&action=AllMemberNew",
                success: function (res) {
                    if (!$.trim(res) || $.trim(res) === '0 results') {
                        $('#otp-verified-banner').show().html('<div style="background:#fdecea;border:1px solid #f5c6cb;color:#c0392b;border-radius:5px;padding:8px 12px;">Member not found. Please verify again.</div>');
                        return;
                    }
                    var first = parseMemberValue(res, 'MemberName');
                    var last = parseMemberValue(res, 'last_name');
                    var memberIdFromResponse = parseMemberValue(res, 'memberid') || memberId || '';
                    $('#termMember').val(memberIdFromResponse);
                    $('#term').val($.trim(first + ' ' + last)).prop('readonly', true);
                    $('#memidfam').val(memberIdFromResponse);
                    $('#memcatfam').val(parseMemberValue(res, 'membercategory'));
                    $('#memtypefam').val(parseMemberValue(res, 'membershiptype'));
                    $('#memfnamefam').val(first);
                    $('#memlnamefam').val(last);
                    $('#memstreetfam').val(parseMemberValue(res, 'ressidentalAddress'));
                    $('#memstreetnamefam').val(parseMemberValue(res, 'Address'));
                    $('#memunitfam').val(parseMemberValue(res, 'unitAddress'));
                    $('#memcityfam').val(parseMemberValue(res, 'city'));
                    $('#memstatefam').val(parseMemberValue(res, 'state'));
                    $('#mamzipcodefam').val(parseMemberValue(res, 'zip_code'));
                    $('#memphonefam').val(parseMemberValue(res, 'Tele1').replace(/[-)(]/g, '')).prop('readonly', true).addClass('MIDtext2readonly');
                    $('#memphone2fam').val(parseMemberValue(res, 'phone_work').replace(/[-)(]/g, ''));
                    $('#mememailfam').val(parseMemberValue(res, 'email')).prop('readonly', true).addClass('MIDtext2readonly');
                    $('#mememail2fam').val(parseMemberValue(res, 'email2'));
                    $('#otp-verified-banner').show().html('<div style="background:#eafaf1;border:1px solid #b7e4c7;color:#1e8449;border-radius:5px;font-size:13px;font-weight:600;padding:8px 12px;">Returning user verified and details auto-filled: <strong>' + $('<span>').text($.trim(first + ' ' + last)).html() + '</strong></div>');
                },
                error: function () {
                    $('#otp-verified-banner').show().html('<div style="background:#fdecea;border:1px solid #f5c6cb;color:#c0392b;border-radius:5px;padding:8px 12px;">Could not load member data. Please refresh and try again.</div>');
                }
            });
        }
        function getMagazineTotalAmount() {
            return ($('#total_value4').val() || '').replace(/[$,\s]/g, '').trim();
        }
        function getMagazinePayerName() {
            return $.trim($('#memfnamefam').val() + ' ' + $('#memlnamefam').val());
        }
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
            $.ajax({
                type: "POST",
                data: { donor_name: donorName, zelle_amount: zelleAmount, zelle_date: zelleDate || '' },
                url: url + "load.php?controller=GzFront&action=checkCodeDD&" + query,
                success: function (res) {
                    var trimmed = $.trim(res);
                    var opts = trimmed && trimmed !== 'NO_MATCH' ? $(trimmed).filter('option') : $();
                    if (!opts.length && trimmed && trimmed !== 'NO_MATCH') {
                        opts = $(trimmed);
                    }
                    if (!opts.length || opts.length > 25) {
                        $('#error_code1').css('color', '#c0392b').html('No matching Zelle payment found. Check your Zelle name, amount, and payment date, then try again.');
                        $('#zelle-no-match').show();
                        showZelleManual('');
                        return;
                    }
                    $('#MemberID').empty().append('<option value="">Please select your payment details</option>').append(opts).show();
                    $('#zelle-action-btns').show();
                    $('#zelle-manual-fields').hide();
                    if (opts.length === 1) {
                        $('#MemberID').val(opts.first().val()).trigger('change');
                        $('#error_code1').css('color', '#276632').html('<i class="fa fa-check-circle"></i> Zelle transaction matched and selected automatically.');
                    } else {
                        $('#error_code1').css('color', '#276632').html('Matching Zelle payments found. Please select yours, then click <b>Verify Selected Transaction</b>.');
                    }
                },
                error: function () {
                    $('#error_code1').css('color', '#c0392b').html('Could not search Zelle transactions. Please try again.');
                }
            });
        }
        function openMagazineReturningUserOtp() {
            if (otpAdminBypass) {
                return true;
            }
            if (typeof window.OtpMemberVerify === 'undefined') {
                alert('OTP verification is not available. Please refresh and try again.');
                return false;
            }
            window.OtpMemberVerify.open({
                onVerified: function (memberId) {
                    fillMagazineReturningUser(memberId);
                }
            });
            window.onOtpModalCancelled = function () {
                $('#pul2').val('');
                $('#showMember').hide();
            };
            return true;
        }
        $('#edit_registration').on('submit', function (event) {
            if ($('#payment_method').val() === 'others' && !$.trim($('#Zellecode').val() || '')) {
                event.preventDefault();
                stopLoadingSoon();
                showZelleManual('Please verify your Zelle transaction before continuing.');
                return false;
            }
        });
        $(document).on('keydown focus paste input', '#term', function (event) {
            if ($('#pul2').val() === 'Member' && !otpAdminBypass) {
                event.preventDefault();
                $(this).blur();
                return false;
            }
        });
        $(document).on('change', '#pul2', function () {
            if ($(this).val() === 'Member' && !otpAdminBypass) {
                setTimeout(function () {
                    var verifiedMemberIdOnLoad = $.trim($('#otp-session-verified').text());
                    if (verifiedMemberIdOnLoad) {
                        fillMagazineReturningUser(verifiedMemberIdOnLoad);
                    } else {
                        openMagazineReturningUserOtp();
                    }
                }, 0);
            }
        });
        var verifiedMemberIdOnLoad = $.trim($('#otp-session-verified').text());
        if ($('#pul2').val() === 'Member' && verifiedMemberIdOnLoad) {
            fillMagazineReturningUser(verifiedMemberIdOnLoad);
        }
        
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
            var val = $(this).val();
            $("#payment_btn_id").removeClass('disabled');
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


                var form = document.getElementById('edit_registration');

                form.addEventListener('submit', function (event) {
                    if ($('#payment_method').val() !== 'stripe') {
                        return true;
                    }
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
                $("#stripe_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdeposite").hide();
                $("#MemberID1").show();
                $("#MemberID").prop('required', true);
                $('#zelledatadiv').show();
                $('#error_codeimg').hide();
                $('#error_code1').css({ display: 'block', color: '#ff0000', marginLeft: '0', paddingTop: '12px' })
                    .html("Send your Zelle payment to treasurerpuja@durgabari.org, then enter the Zelle name and payment date below to verify it.");
                $('#error_code2').css({ display: 'block', color: '#ff0000' })
                    .html("<br>Note: It may take some time for the Zelle payment information to appear.");
                $('#zelle_donor_name').val(getMagazinePayerName());
                showZelleManual('');
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
                return;
                //debugger
                var elem = document.createElement("img");
                 elem.setAttribute("src", url + "zelleqrcode.jpg");
                elem.setAttribute("height", "600");
                elem.setAttribute("width", "600");

                elem.setAttribute("alt", "Zelle");
                $('#error_codeimg').html(elem);
                //document.getElementById("error_codeimg").style.marginLeft = "88px";
                document.getElementById("error_codeimg").style.textAlign = "center";
                document.getElementById("error_codeimg").style.marginTop = "30px";
                document.getElementById("error_code1").style.marginLeft = "75px";
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
                $('#error_code1').html("Step 1 - Without closing this page, open a new web page and go to your Bank’s portal." + "<br>" + "Step 2 - Send your Zelle payment from your Bank’s portal. To register as a new recipient, Name = Houston Durga Bari Society, Email = treasurerpuja@durgabari.org." + "<br>" + "Step 3 - Return to this page and click ‘Get Zelle Payment Details’ button." + "<br>" + "Step 4 - Select your payment details from the dropdown." + "<br>" + "Step 5 - Make Payment." + "<br>");
                $('#error_code2').html("<br>" + "Note:It may take some time for the Zelle payment information to appear (depending on network speed at both User and Bank ends).");
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#Sumupdata").hide();
                $("#directdeposite").hide();
                $("#MemberID1").show();
                $("#MemberID").prop('required', true);
                 $('#zelledatadiv').show();
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
            }else if (val == 'check') {

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
            } else if (val == 'cash') {
    
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
    
            } else if (val == 'directdeposit') {
    
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
    
                $("#MemberID").prop('required', false);
    
            }
            else if (val == 'sumup') {
               $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdeposite").hide()
                $("#Sumupdata").show();
                
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
                
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_code2").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
    
            } else {
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#checkdata").hide();
                $("#cashdata").hide();
                $("#directdeposite").hide();
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
                        $("#payment_btn_id").removeClass('disabled');
                    } else {
                        $("#payment_btn_id").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
        }).delegate('#checkPaymentData', 'click', function (event) {
            event.preventDefault();
            var donorName = $.trim($('#zelle_donor_name').val() || getMagazinePayerName());
            var amount = getMagazineTotalAmount();
            var zelleDate = $.trim($('#zelle_date').val() || '');
            if (!donorName || !amount || !zelleDate) {
                showZelleManual('Enter your Zelle name, amount, and payment date, then click Get Zelle Payment Details.');
                if (!donorName) {
                    $('#zelle_donor_name').focus();
                } else if (!zelleDate) {
                    $('#zelle_date').focus();
                }
                return false;
            }
            $('#zelle_donor_name').val(donorName);
            searchZelleTransactions(donorName, amount, zelleDate);
            return false;
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
            if (!otpAdminBypass) {
                event.preventDefault();
                return false;
            }
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
            var dd = $("#MemberID").val();
            if (!dd) {
                $("#Zellecode").val('');
                $('#payment_btn_id').prop("disabled", true).addClass('disabled');
                return;
            }

            var parts = dd.split("/");
            var cmCode = parts[3];
            var name = parts[1];
            var price = parts[2].replace(/ /gi, '').trim();;
            var newprice = price.replace('$', "");
            //var totalprice =   $("#total").text();
            var totalprice = $("#total_value4").val();
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

                $("#Zellecode").val('');
                $("#payment_btn_id").addClass('disabled');
                alert('Total price and select  price is not same please select correct payment');
            }

        }).delegate('#verifySelectedZelle', 'click', function (event) {
            event.preventDefault();
            $('#MemberID').trigger('change');
            if ($.trim($('#Zellecode').val() || '')) {
                $('#error_code1').css('color', '#276632').html('<i class="fa fa-check-circle"></i> Zelle transaction verified. You can submit now.');
            }
        }).delegate('#searchZelleManual', 'click', function (event) {
            event.preventDefault();
            resetZelleVerification();
            $('#zelle_donor_name').val(getMagazinePayerName());
            $('#zelle-manual-fields').show();
            $('#zelle_donor_name').focus();
        }).delegate("a.icon-delete", 'click', function (e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#cat_id').text($(this).attr('cat'));
            $('#dialogDelete').dialog('open');
        }).delegate('#checkamount', 'change', function (e) {
            e.stopImmediatePropagation();
            var checkamount = parseInt($("#checkamount").val());
            var totalamount = parseInt($("#total_value4").val());
            if( totalamount != checkamount ){
                alert('Total amount and check amount not same please select correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
        }).delegate('#cashamount', 'change', function (e) {
            e.stopImmediatePropagation();
            var cashamount = parseInt($("#cashamount").val());
            var totalamount = parseInt($("#total_value4").val());
            if( totalamount != cashamount){
                alert('Total amount and cash amount not same please select correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
         
        }).delegate('#directamount', 'change', function (e) {
            e.stopImmediatePropagation();
            var directdeposite = parseInt($("#directamount").val());
            var totalamount = parseInt($("#total_value4").val());
            if(totalamount != directdeposite){
                alert('Total amount and direct deposit amount not same please select correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
        }).delegate('#sumupprice', 'change', function (e) {
            e.stopImmediatePropagation();
            var sumpumount = parseInt($("#sumupprice").val());
            var totalamount = parseInt($("#total_value4").val());
            if(totalamount != sumpumount){
                alert('Sumup  amount and and total amount not same please select correct amount');
                $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
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
        if ($("#dialogDelete").length > 0) {
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
                                    controller: 'PujaMagazineadmin',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=PujaMagazineadmin&action=delete",
                                success: function (res) {

                                    if (cat === '1') {
                                        $('#tab_1').html(res);

                                        if ($('#tab-1-table-id').length > 0) {
                                            $('#tab-1-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [1, 2]}
                                                ]
                                            });
                                        }
                                    }else if (cat === '4') {
                                        $('#tab_4').html(res);

                                        if ($('#puja_magazineprice_table').length > 0) {
                                            $('#puja_magazineprice_table').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [7, 8]}
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
