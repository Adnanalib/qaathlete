function addToCartFormData() {
    return {
        variant: $('input[name="cart-variant"]').val(),
        preference: $('input[name="cart-qr-preference"]').val(),
        quantity: $('#qty').val(),
        uuid: $('input[name="product-uuid"]').val(),
    };
}

function addToCart() {
    ajaxMethod(
        __url.cart.add_to_cart,
        method.post,
        addToCartFormData(),
        successCallBack,
        errorDefaultCallBack,
        beforeNullSendCallback,
    );

    function successCallBack(response) {
        hideAlert();
        success_mini(response.message);
        $('.cart-count').show();
    }
}

function removeFromCart(productId) {
    ajaxMethod(
        __url.cart.remove_from_cart,
        method.post, {
            productId: productId
        },
        successCallBack,
        errorDefaultCallBack,
        beforeNullSendCallback,
    );

    function successCallBack(response) {
        hideAlert();
        success_mini(response.message);
        window.location.reload();
    }
}

function addToTeamCart() {
    ajaxMethod(
        __url.cart.add_to_cart,
        method.post, {
            uuid: $('input[name="product-uuid"]').val(),
            preference: $('input[name="cart-qr-preference"]').val(),
        },
        successCallBack,
        errorDefaultCallBack,
        beforeNullSendCallback,
    );

    function successCallBack(response) {
        hideAlert();
        success_mini(response.message);
        $('.cart-count').show();
    }
}
