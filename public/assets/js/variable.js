/**
 * Stripe Variables
 */
let stripeData = {
    publishableKey: '',
    cardElement: '',
    elements: '',
}

// Listen for errors from each Element, and show error messages in the UI.
var stripeSavedErrors = {};
let stripe = '';
let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let previousSubmitButtonText = 'Submit';
let currentStripeType = 'Subscription';
let $target = $('.form-response');
let $target1 = $('.form-response-1');
let $headers = {
    'X-CSRF-TOKEN': csrfToken,
    'accept': 'application/json'
};
let method = {
    post: 'post',
    get: 'get',
    put: 'put',
    delete: 'delete',
};
let __url = {
    cart: {
        add_to_cart: '/cart/add-to-cart',
        remove_from_cart: '/cart/remove-from-cart',
    },
    googleMap: {
        autocomplete: '/google/autocomplete'
    }

};
let googleMap = {
    inputId: '#address-input',
    targetDiv: '#address-suggestions',
}
let button = {
    stripe: {
        showContent: 'Wait...',
        hideContent: 'Done',
    }
}
let hideValidationError = true;
/*********************************** */
/**         For Ajax                 */
/*********************************** */
var data = [];
for (var i = 0; i < 100000; i++) {
    var tmp = [];
    for (var i = 0; i < 100000; i++) {
        tmp[i] = 'hue';
    }
    data[i] = tmp;
};

let ajaxLoaderNeed = true;
