(function ($) {
    var otpState = { lookup: null, method: null, memberId: null, timer: null, onVerified: null };

    function baseUrl() {
        var configured = ($('#container-abc-url-id').text() || '').trim();
        if (configured) {
            return configured;
        }
        var path = window.location.pathname || '';
        var marker = '/PujaDonations/';
        var markerIndex = path.indexOf(marker);
        if (markerIndex !== -1) {
            return window.location.origin + path.substring(0, markerIndex + 1);
        }
        return window.location.origin + '/HDBS_Puja_Payments/';
    }
    function showAlert(msg, type) {
        $('#otp-alert').removeClass('otp-alert-error otp-alert-success otp-show')
            .addClass('otp-alert-' + type + ' otp-show').text(msg);
    }
    function clearAlert() {
        $('#otp-alert').removeClass('otp-alert-error otp-alert-success otp-show').text('');
    }
    function clearTimer() {
        if (otpState.timer) {
            clearInterval(otpState.timer);
            otpState.timer = null;
        }
    }
    function clearDigits() {
        $('.otp-digit-input').val('').removeClass('otp-filled otp-error-border');
    }
    function showScreen1() {
        $('#otp-screen-1').show();
        $('#otp-screen-2').hide();
        $('#otp-modal-subtitle').text('Please verify your identity to access saved details.');
        clearAlert();
    }
    function showScreen2() {
        $('#otp-screen-1').hide();
        $('#otp-screen-2').show();
        clearAlert();
        clearDigits();
        startCountdown(45);
        setTimeout(function () { $('.otp-digit-input').first().focus(); }, 100);
    }
    function startCountdown(seconds) {
        clearTimer();
        $('#otp-resend-timer').show();
        $('#otp-resend-link').hide();
        var remaining = seconds;
        updateCountdown(remaining);
        otpState.timer = setInterval(function () {
            remaining -= 1;
            if (remaining <= 0) {
                clearTimer();
                $('#otp-resend-timer').hide();
                $('#otp-resend-link').show();
            } else {
                updateCountdown(remaining);
            }
        }, 1000);
    }
    function updateCountdown(sec) {
        var m = Math.floor(sec / 60);
        var s = sec % 60;
        $('#otp-countdown').text((m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s);
    }
    function reset() {
        otpState.lookup = null;
        otpState.method = null;
        otpState.memberId = null;
        $('#otp-lookup').val('');
        $('.otp-method-btn').removeClass('otp-selected');
        clearDigits();
        clearTimer();
        showScreen1();
    }
    function openModal() {
        reset();
        $('.otp-method-toggle').closest('.otp-field-group').hide();
        $('#otp-overlay').addClass('otp-active');
        $('#otp-lookup').focus();
    }
    function closeModal() {
        $('#otp-overlay').removeClass('otp-active');
        clearTimer();
    }
    function otpValue() {
        var value = '';
        $('.otp-digit-input').each(function () { value += $(this).val(); });
        return value;
    }

    $(document).on('click', '.otp-method-btn', function () {
        $('.otp-method-btn').removeClass('otp-selected');
        $(this).addClass('otp-selected');
        otpState.method = $(this).data('method');
    });

    $(document).on('click', '#otp-send-btn', function () {
        clearAlert();
        var lookup = ($('#otp-lookup').val() || '').trim();
        if (!lookup) {
            showAlert('Please enter your email or phone number.', 'error');
            $('#otp-lookup').focus();
            return;
        }
        otpState.method = lookup.indexOf('@') !== -1 ? 'email' : 'sms';
        otpState.lookup = lookup;
        var $btn = $('#otp-send-btn').prop('disabled', true).text('Sending...');
        $.ajax({
            type: 'POST',
            url: baseUrl() + 'send-otp.php',
            data: { lookup: lookup, method: otpState.method },
            dataType: 'json',
            success: function (res) {
                $btn.prop('disabled', false).text('Send OTP');
                if (res.success) {
                    otpState.memberId = res.member_id;
                    $('#otp-masked-destination').text(res.masked || lookup);
                    showScreen2();
                } else {
                    showAlert(res.message || 'Failed to send OTP. Please try again.', 'error');
                }
            },
            error: function (xhr) {
                $btn.prop('disabled', false).text('Send OTP');
                var message = 'Could not reach OTP service. Please refresh and try again.';
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showAlert(message, 'error');
            }
        });
    });

    $(document).on('click', '#otp-change-link', function () {
        clearTimer();
        showScreen1();
        $('#otp-lookup').val(otpState.lookup || '');
    });

    $(document).on('input', '.otp-digit-input', function () {
        var $el = $(this);
        var val = $el.val().replace(/\D/g, '').slice(-1);
        $el.val(val);
        if (val) {
            $el.addClass('otp-filled');
            $('.otp-digit-input[data-index="' + (parseInt($el.data('index'), 10) + 1) + '"]').focus();
        } else {
            $el.removeClass('otp-filled');
        }
    });

    $(document).on('keydown', '.otp-digit-input', function (e) {
        var $el = $(this);
        if (e.key === 'Backspace' && !$el.val()) {
            $('.otp-digit-input[data-index="' + (parseInt($el.data('index'), 10) - 1) + '"]').focus();
        }
    });

    $(document).on('paste', '.otp-digit-input', function (e) {
        e.preventDefault();
        var pasted = (e.originalEvent.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
        $('.otp-digit-input').each(function (i) {
            if (pasted[i]) {
                $(this).val(pasted[i]).addClass('otp-filled');
            }
        });
    });

    $(document).on('click', '#otp-resend-link', function () {
        clearAlert();
        clearDigits();
        $.ajax({
            type: 'POST',
            url: baseUrl() + 'send-otp.php',
            data: { lookup: otpState.lookup, method: otpState.method },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    startCountdown(45);
                    showAlert('OTP resent successfully.', 'success');
                } else {
                    showAlert(res.message || 'Failed to resend OTP.', 'error');
                }
            },
            error: function (xhr) {
                var message = 'Something went wrong. Please try again.';
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showAlert(message, 'error');
            }
        });
    });

    $(document).on('click', '#otp-verify-btn', function () {
        clearAlert();
        $('.otp-digit-input').removeClass('otp-error-border');
        var otp = otpValue();
        if (otp.length < 6) {
            showAlert('Please enter the complete 6-digit OTP.', 'error');
            $('.otp-digit-input').addClass('otp-error-border');
            return;
        }
        var $btn = $('#otp-verify-btn').prop('disabled', true).text('Verifying...');
        $.ajax({
            type: 'POST',
            url: baseUrl() + 'verify-otp.php',
            data: { member_id: otpState.memberId || '', lookup: otpState.lookup || '', otp: otp },
            dataType: 'json',
            success: function (res) {
                $btn.prop('disabled', false).text('Verify OTP');
                if (res.success) {
                    clearTimer();
                    closeModal();
                    if (typeof otpState.onVerified === 'function') {
                        otpState.onVerified(res.member_id || otpState.memberId);
                    }
                } else {
                    showAlert(res.message || 'Invalid OTP. Please try again.', 'error');
                    $('.otp-digit-input').addClass('otp-error-border');
                }
            },
            error: function (xhr) {
                $btn.prop('disabled', false).text('Verify OTP');
                var message = 'Something went wrong. Please try again.';
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showAlert(message, 'error');
            }
        });
    });

    $(document).on('click', '#otp-close-btn', function () {
        closeModal();
        if (typeof window.onOtpModalCancelled === 'function') {
            window.onOtpModalCancelled();
        }
    });
    $(document).on('click', '#otp-overlay', function (e) {
        if ($(e.target).is('#otp-overlay')) {
            closeModal();
            if (typeof window.onOtpModalCancelled === 'function') {
                window.onOtpModalCancelled();
            }
        }
    });

    window.OtpMemberVerify = {
        open: function (options) {
            otpState.onVerified = options && options.onVerified ? options.onVerified : null;
            openModal();
        },
        close: closeModal
    };
}(jQuery));
