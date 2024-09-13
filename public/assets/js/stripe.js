var formSelector = null;
var resetButton = null;
var error = null;
var errorMessage = null;

function initStripe() {
    formSelector = document.querySelector('#payment-form');
    resetButton = formSelector.querySelector('a.reset');
    error = formSelector.querySelector('.error');
    errorMessage = error.querySelector('.message');

    function enableInputs() {
        Array.prototype.forEach.call(
            formSelector.querySelectorAll(
                "input[type='text'], input[type='email'], input[type='tel']"
            ),
            function (input) {
                input.removeAttribute('disabled');
            }
        );
        $('.package-select-button').show();
    }

    function disableInputs() {
        Array.prototype.forEach.call(
            formSelector.querySelectorAll(
                "input[type='text'], input[type='email'], input[type='tel']"
            ),
            function (input) {
                input.setAttribute('disabled', 'true');
            }
        );
        $('.package-select-button').hide();
    }

    function triggerBrowserValidation() {
        // The only way to trigger HTML5 form validation UI is to fake a user submit
        // event.
        var submit = document.createElement('input');
        submit.type = 'submit';
        submit.style.display = 'none';
        formSelector.appendChild(submit);
        submit.click();
        submit.remove();
    }

    showSpinner('.stripe-payment-submit-btn-container button[type="submit"]', button.stripe.showContent);
    getStripeKey().then(
        result => {
            $('#card-errors .message').html('');
            $('#card-errors').removeClass('visible');
            hideSpinner('.stripe-payment-submit-btn-container button[type="submit"]', button.stripe.hideContent);
            stripe = Stripe(result.token);
            let cardType = $('input[name="payment_type"]:checked').val() == '2' ? 'paypal' : 'card';
            if (cardType == 'card') {
                $('#cardPayment').show();
                $('#paypalPayment').hide();
                stripeData.subscriptions = result.subscriptions;
                stripeData.cardElement = getElements();
                stripeData.cardElement.forEach(function (element, idx) {
                    element.on('change', function (event) {
                        showCardError(event);
                    });
                });
            } else if (cardType == 'paypal') {
                $('#paypalPayment').show();
                $('#cardPayment').hide();
                setupPaypalPayment();
            }
        }
    );

    // Listen on the form's 'submit' handler...
    formSelector.addEventListener('submit', function (e) {
        e.preventDefault();

        // Trigger HTML5 validation UI on the form if any of the inputs fail
        // validation.
        var plainInputsValid = true;
        Array.prototype.forEach.call(formSelector.querySelectorAll('input'), function (
            input
        ) {
            if (input.checkValidity && !input.checkValidity()) {
                plainInputsValid = false;
                return;
            }
        });
        if (!plainInputsValid) {
            triggerBrowserValidation();
            return;
        }
        // Disable all inputs.
        disableInputs();

        showSpinner('.stripe-payment-submit-btn-container button[type="submit"]', button.stripe.showContent);

        createPaymentMethod(stripeData.cardElement);
    });

    resetButton.addEventListener('click', function (e) {
        e.preventDefault();
        // Resetting the form (instead of setting the value to `''` for each input)
        // helps us clear webkit autofill styles.
        formSelector.reset();

        // Clear each Element.
        elements.forEach(function (element) {
            element.clear();
        });

        // Reset error state as well.
        error.classList.remove('visible');

        // Resetting the form does not un-disable inputs, so we need to do it separately:
        enableInputs();
        formSelector.classList.remove('submitted');
    });
}

function createPaymentMethod(cardElement) {
    // Gather additional customer data we may have collected in our formSelector.
    var name = formSelector.querySelector('#stripe-card-name');
    var address = formSelector.querySelector('#address-input');
    var addMorePlayerSize = formSelector.querySelector('#addMorePlayerSize');

    var additionalData = {
        name: name ? name.value : undefined,
    };
    var paymentAdditionalData = {
        name: name ? name.value : undefined,
        address: address ? address.value : undefined,
        addMorePlayerSize: addMorePlayerSize ? addMorePlayerSize.value : 0,
    }
    let cardType = $('input[name="payment_type"]:checked').val() == '2' ? 'paypal' : 'card';
    let paymentMethod = {
        type: cardType,
        card: cardElement[0],
        billing_details: additionalData,
    };
    if (cardType == 'paypal') {
        paymentMethod = {
            type: cardType,
            billing_details: additionalData,
        };
    }
    return stripe.createPaymentMethod(paymentMethod)
        .then((result) => {
            if (result.error) {
                displayError(result.error);
            } else {
                $('.modal.show .modal-body').prepend('<div class="progress ajax-progress"></div>');
                paymentMethod = result.paymentMethod.id;
                processServerPayment(result.paymentMethod.id, paymentAdditionalData);
            }
        });
}

function processServerPayment(paymentMethodId, additionalData) {
    return (
        fetch(currentStripeType == 'Product' ? routes.stripe.placeOrder : routes.stripe.subscription.create, {
            method: 'post',
            headers: {
                'Content-type': 'application/json',
                'X-CSRF-Token': csrfToken
            },
            body: JSON.stringify({
                paymentMethodId: paymentMethodId,
                additionalData: additionalData,
                paymentMethodType: $('input[name="payment_type"]:checked').val(),
            }),
        })
        .then((response) => {
            return response.json();
        })
        // If the card is declined, display an error to the user.
        .then((result) => {
            if (result.error) {
                // The card had an error when trying to attach it to a customer.
                throw result;
            }
            return result;
        })
        // Normalize the result to contain the object returned by Stripe.
        // Add the addional details we need.
        .then((result) => {
            hideSpinner('.stripe-payment-submit-btn-container button[type="submit"]', button.stripe.hideContent);
            //Successfully subscribed to the subscription.
            //TODO Code here
            formSelector.classList.add('submitted');
            $('.reset').hide();
            if (currentStripeType == 'Product') {
                window.location.href = baseUrl + routes.stripe.orderSuccess;
            } else if (currentStripeType == 'Subscription') {
                window.location.href = routes.stripe.subscriptionSuccess
            }
        })
        // Some payment methods require a customer to be on session
        // to complete the payment process. Check the status of the
        // payment intent to handle these actions.
        .then(handlePaymentThatRequiresCustomerAction)
        // If attaching this card to a Customer object succeeds,
        // but attempts to charge the customer fail, you
        // get a requires_payment_method error.
        .then(handlePaymentMethodRequired)
        // No more actions required. Provision your service for the user.
        .then(onSubscriptionComplete)
        .catch((error) => {
            // An error has happened. Display the failure to the user here.
            // We utilize the HTML element we created.
            showCardError(error);
        })
    );
}

function onSubscriptionComplete(result) {
    hideSpinner('.stripe-payment-submit-btn-container button[type="submit"]', button.stripe.hideContent);
    console.log('result', result);
    // Payment was successful.
    if (result.subscription.status === 'active') {
        if (currentStripeType == 'Product') {
            window.location.href = baseUrl + routes.stripe.orderSuccess;
        } else if (currentStripeType == 'Subscription') {
            window.location.href = routes.stripe.subscriptionSuccess
        }
    }
}

function handlePaymentThatRequiresCustomerAction({
    subscription,
    invoice,
    priceId,
    paymentMethodId,
    isRetry,
}) {
    hideSpinner('.stripe-payment-submit-btn-container button[type="submit"]', button.stripe.hideContent);
    if (subscription && subscription.status === 'active') {
        // Subscription is active, no customer actions required.
        return {
            subscription,
            priceId,
            paymentMethodId
        };
    }

    // If it's a first payment attempt, the payment intent is on the subscription latest invoice.
    // If it's a retry, the payment intent will be on the invoice itself.
    let paymentIntent = invoice ? invoice.payment_intent : subscription.latest_invoice.payment_intent;

    if (
        paymentIntent.status === 'requires_action' ||
        (isRetry === true && paymentIntent.status === 'requires_payment_method')
    ) {
        return stripe
            .confirmCardPayment(paymentIntent.client_secret, {
                payment_method: paymentMethodId,
            })
            .then((result) => {
                if (result.error) {
                    // Start code flow to handle updating the payment details.
                    // Display error message in your UI.
                    // The card was declined (i.e. insufficient funds, card has expired, etc).
                    throw result;
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        // Show a success message to your customer.
                        // There's a risk of the customer closing the window before the callback.
                        // We recommend setting up webhook endpoints later in this guide.
                        return {
                            priceId: priceId,
                            subscription: subscription,
                            invoice: invoice,
                            paymentMethodId: paymentMethodId,
                        };
                    }
                }
            })
            .catch((error) => {
                displayError(error);
            });
    } else {
        // No customer action needed.
        return {
            subscription,
            priceId,
            paymentMethodId
        };
    }
}

function handlePaymentMethodRequired({
    subscription,
    paymentMethodId,
    priceId,
}) {
    hideSpinner('.stripe-payment-submit-btn-container button[type="submit"]', button.stripe.hideContent);
    if (subscription.status === 'active') {
        // subscription is active, no customer actions required.
        return {
            subscription,
            priceId,
            paymentMethodId
        };
    } else if (
        subscription.latest_invoice.payment_intent.status ===
        'requires_payment_method'
    ) {
        // Using localStorage to manage the state of the retry here,
        // feel free to replace with what you prefer.
        // Store the latest invoice ID and status.
        localStorage.setItem('latestInvoiceId', subscription.latest_invoice.id);
        localStorage.setItem(
            'latestInvoicePaymentIntentStatus',
            subscription.latest_invoice.payment_intent.status
        );
        throw {
            error: {
                message: 'Your card was declined.'
            }
        };
    } else {
        return {
            subscription,
            priceId,
            paymentMethodId
        };
    }
}


function displayError(error) {
    $('#card-errors .message').html(error.message);
    $('#card-errors').addClass('visible');
    hideSpinner('.stripe-payment-submit-btn-container button[type="submit"]', button.stripe.hideContent);
}

function showCardError(event) {
    if (event.error) {
        $('#card-errors .message').html(event.error.message);
        $('#card-errors').addClass('visible');
    } else {
        $('#card-errors .message').html('');
        $('#card-errors').removeClass('visible');
    }
    $('.package-select-button').show();
    hideSpinner('.stripe-payment-submit-btn-container button[type="submit"]', button.stripe.hideContent);
}

async function getStripeKey() {
    const data = await fetch(routes.stripe.token, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    });
    const data_1 = await data.json();
    return data_1;
}

async function getCustomer() {
    const data = await fetch(routes.stripe.customerId, {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': csrfToken
        }
    });
    const response = await data.json();
    if (response.data) {
        return response.data.stripeId;
    }
}

function getElements() {
    var elements = stripe.elements({
        fonts: [{
            cssSrc: 'https://fonts.googleapis.com/css?family=Source+Code+Pro',
        }, ],
        // Stripe's examples are localized to specific languages, but if
        // you wish to have Elements automatically detect your user's locale,
        // use `locale: 'auto'` instead.
        locale: 'auto'
    });

    // Floating labels
    var inputs = document.querySelectorAll('#payment-form input');
    Array.prototype.forEach.call(inputs, function (input) {
        input.addEventListener('focus', function () {
            input.classList.add('focused');
        });
        input.addEventListener('blur', function () {
            input.classList.remove('focused');
        });
        input.addEventListener('keyup', function () {
            if (input.value.length === 0) {
                input.classList.add('empty');
            } else {
                input.classList.remove('empty');
            }
        });
    });

    var elementStyles = {
        base: {
            color: '#32325D',
            fontWeight: 500,
            fontFamily: 'Source Code Pro, Consolas, Menlo, monospace',
            fontSize: '16px',
            fontSmoothing: 'antialiased',

            '::placeholder': {
                color: '#CFD7DF',
            },
            ':-webkit-autofill': {
                color: '#e39f48',
            },
        },
        invalid: {
            color: '#E25950',

            '::placeholder': {
                color: '#E25950',
            },
        },
    };

    var elementClasses = {
        focus: 'focused',
        empty: 'empty',
        invalid: 'invalid',
    };
    var cardNumber = elements.create('cardNumber', {
        style: elementStyles,
        classes: elementClasses,
    });
    cardNumber.mount('#stripe-card-number');

    var cardExpiry = elements.create('cardExpiry', {
        style: elementStyles,
        classes: elementClasses,
    });
    cardExpiry.mount('#stripe-expiry');

    var cardCvc = elements.create('cardCvc', {
        style: elementStyles,
        classes: elementClasses,
    });
    cardCvc.mount('#stripe-cvv');
    return [cardNumber, cardExpiry, cardCvc];
}

initStripe();


$(function () {
    $('input[type=radio][name=payment_type]').change(function () {
        initStripe();
    });
});

function setupPaypalPayment() {
    if (typeof paypal === 'undefined') {
        $('#card-errors .message').html('Paypal Integration failed');
        $('#card-errors').addClass('visible');
    } else {
        var paypal = paypal.SDK({
            "currency": 'usd',
            "intent": "subscription"
        });

        // Handle form submission
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            var plan = $('#plan').val();
            paypal.Buttons({
                createSubscription: function (data, actions) {
                    return actions.subscription.create({
                        'plan_id': plan
                    });
                },
                onApprove: function (data, actions) {
                    // Send the subscription ID to your server to activate the subscription
                    $.post('/paypal/subscription', {
                        _token: '{{ csrf_token() }}',
                        subscription_id: data.subscriptionID
                    }).done(function (data) {
                        // Redirect to the success page
                        window.location.href = '/success';
                    });
                }
            }).render('#paypalPayment');
        });
    }
}
