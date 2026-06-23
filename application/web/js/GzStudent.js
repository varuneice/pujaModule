(function ($) {
    $(function () {
        var url = $("#container-abc-url-id").text();

        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }

        if ($('#MemberID').length > 0) {
            $('#MemberID').selectpicker();
        }

        $(document).delegate('#reset-btn-id', 'click',  function (e) {
            $('#new_student')[0].reset();
        }).delegate('#payment_method', 'change', function (e) {
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
                var form = document.getElementById('new_student');
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
            var frm = $("#new_student");
            $.ajax({
                type: "POST",
                data: frm.serialize(),
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
        });
    });
}(jQuery));