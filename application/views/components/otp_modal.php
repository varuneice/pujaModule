<style>
.otp-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9000;justify-content:center;align-items:center}
.otp-overlay.otp-active{display:flex}
.otp-modal{background:#fff;border-radius:8px;width:420px;max-width:95vw;box-shadow:0 8px 32px rgba(0,0,0,.22);overflow:hidden;position:relative;font-family:Arial,sans-serif}
.otp-modal-header{background:#357ca5;padding:18px 20px 14px;text-align:center;position:relative}
.otp-modal-header h4{color:#fff;margin:0 0 4px;font-size:18px;font-weight:bold}
.otp-modal-header p{color:rgba(255,255,255,.88);margin:0;font-size:13px}
.otp-close-btn{position:absolute;top:10px;right:14px;background:none;border:none;color:#fff;font-size:22px;cursor:pointer;line-height:1;padding:0;opacity:.85}
.otp-modal-body{padding:22px 24px 18px}
#otp-screen-2{display:none}
.otp-field-group{margin-bottom:14px}
.otp-field-group label{display:block;font-size:13px;font-weight:bold;color:#444;margin-bottom:5px}
.otp-field-group input{width:100%;height:36px;padding:6px 10px;border:1px solid #ccc;border-radius:4px;font-size:14px;color:#555;background:#f9fcfa;box-sizing:border-box}
.otp-method-toggle{display:flex;gap:10px;margin-top:4px}
.otp-method-btn{flex:1;padding:8px 0;border:2px solid #ccc;border-radius:5px;background:#f5f5f5;color:#666;font-size:13px;font-weight:bold;cursor:pointer}
.otp-method-btn.otp-selected{border-color:#357ca5;background:#357ca5;color:#fff}
.otp-submit-btn{width:100%;padding:10px;background:#357ca5;color:#fff;border:none;border-radius:5px;font-size:15px;font-weight:bold;cursor:pointer;margin-top:6px}
.otp-submit-btn:disabled{opacity:.6;cursor:not-allowed}
.otp-alert{padding:8px 12px;border-radius:4px;font-size:13px;margin-bottom:12px;display:none}
.otp-alert.otp-alert-error{background:#fdecea;border:1px solid #f5c6cb;color:#c0392b}
.otp-alert.otp-alert-success{background:#eaf6ec;border:1px solid #c3e6cb;color:#276632}
.otp-alert.otp-show{display:block}
.otp-sent-to{text-align:center;font-size:13px;color:#555;margin-bottom:16px;line-height:1.5}
.otp-change-link{color:#357ca5;font-weight:bold;text-decoration:none;cursor:pointer;font-size:13px}
.otp-digits{display:flex;justify-content:center;gap:8px;margin:10px 0 14px}
.otp-digit-input{width:42px;height:48px;text-align:center;font-size:22px;font-weight:bold;border:2px solid #ccc;border-radius:6px;color:#333}
.otp-digit-input.otp-filled{border-color:#357ca5;background:#f0f7fb}
.otp-digit-input.otp-error-border{border-color:#ff5252}
.otp-security-note{text-align:center;font-size:12px;color:#888;margin-top:12px}
</style>

<div id="otp-overlay" class="otp-overlay">
    <div class="otp-modal">
        <div class="otp-modal-header">
            <button id="otp-close-btn" type="button" class="otp-close-btn">&times;</button>
            <h4>Verify Returning User</h4>
            <p id="otp-modal-subtitle">Please verify your identity to access saved details.</p>
        </div>
        <div class="otp-modal-body">
            <div id="otp-alert" class="otp-alert"></div>
            <div id="otp-screen-1">
                <div class="otp-field-group">
                    <label for="otp-lookup">Email or Phone Number <span style="color:#ff5252">*</span></label>
                    <input type="text" id="otp-lookup" autocomplete="off">
                </div>
                <div class="otp-field-group">
                    <label>Send OTP via <span style="color:#ff5252">*</span></label>
                    <div class="otp-method-toggle">
                        <button type="button" class="otp-method-btn" data-method="email">Email</button>
                        <button type="button" class="otp-method-btn" data-method="sms">SMS</button>
                    </div>
                </div>
                <button type="button" id="otp-send-btn" class="otp-submit-btn">Send OTP</button>
            </div>
            <div id="otp-screen-2">
                <div class="otp-sent-to">
                    OTP has been sent to<br>
                    <strong id="otp-masked-destination"></strong>
                    <a id="otp-change-link" class="otp-change-link">Change</a>
                </div>
                <label style="font-size:13px;font-weight:bold;color:#444;">Enter OTP <span style="color:#ff5252">*</span></label>
                <div class="otp-digits">
                    <input class="otp-digit-input" data-index="0" maxlength="1" inputmode="numeric">
                    <input class="otp-digit-input" data-index="1" maxlength="1" inputmode="numeric">
                    <input class="otp-digit-input" data-index="2" maxlength="1" inputmode="numeric">
                    <input class="otp-digit-input" data-index="3" maxlength="1" inputmode="numeric">
                    <input class="otp-digit-input" data-index="4" maxlength="1" inputmode="numeric">
                    <input class="otp-digit-input" data-index="5" maxlength="1" inputmode="numeric">
                </div>
                <div style="text-align:center;margin:8px 0 12px;">
                    <span id="otp-resend-timer">Resend OTP in <span id="otp-countdown">00:45</span></span>
                    <a id="otp-resend-link" class="otp-change-link" style="display:none;">Resend OTP</a>
                </div>
                <button type="button" id="otp-verify-btn" class="otp-submit-btn">Verify OTP</button>
            </div>
            <div class="otp-security-note">Your information is secure and will not be shared.</div>
        </div>
    </div>
</div>
