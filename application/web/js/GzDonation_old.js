(function ($) {
    $(function () {
        var url = $("#container-abc-url-id").text();

        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }
        
        $(document).delegate('#reset-btn-id', 'click',  function (e) {
             $('#donation-frm-id')[0].reset();
        }).delegate('#Donation_Type', 'change', function (e) {
            var val = $(this).val();

            if (val === '1') {
                $('#hide1').hide();
            } else {
                $('#hide1').show();
            }
        }).delegate('#PaymentOption', 'change', function (e) {
            var val = $(this).val();

            if (val == 'stripe') {
                $("#others_details").hide();
                $("#stripe_details").show();

                var elements = stripe.elements();

                var style = {
                    base: {
                        // Add your base input styles here. For example:
                        fontSize: '16px',
                        color: "#32325d",
                    }
                };

                var card = elements.create('card', {style: style});

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
                        } else {
                            $("#stripeToken").val(result.token.id);
                            form.submit();
                        }
                    });
                });
            } else if (val == 'others') {
                $("#stripe_details").hide();
                $("#others_details").show();
            } else {
                $("#stripe_details").hide();
                $("#others_details").hide();
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
        });
    });
}(jQuery));