function showSpinner(className = '.stripe-payment-submit-btn-container button', text = 'Wait...') {
    setPaymentLoading(className, text);
}

function hideSpinner(className = '.stripe-payment-submit-btn-container button', text = 'Done') {
    destroyPaymentLoading(className, text);
}

function hideAlert() {
    $("#progress-bar").hide();
    setTimeout(() => {
        $('input-error').remove();
    }, 3000);
}

function setPaymentLoading(id, txt) {
    $(id).html('<i class="fa fa-refresh fa-spin"></i> ' + txt + '');
    $(id).prop('disabled', true);
    $("body").css("cursor", "progress");
}

function destroyPaymentLoading(id, txt) {
    $(id).html('' + txt + '');
    $(id).prop('disabled', false);
    $("body").css("cursor", "default");
}

function isEmpty(value) {
    let response = true;
    if (value != null && value != 'null' && value != 'undefined' && value != '') {
        response = false;
    }
    return response;
}

function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;

    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Fallback: Copying text command was ' + msg);
        updateCopyResponse();
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
    }

    document.body.removeChild(textArea);
}

function copyTextToClipboard(text) {
    if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
        return;
    }
    navigator.clipboard.writeText(text).then(function () {
        console.log('Async: Copying to clipboard was successful!');
        updateCopyResponse();
    }, function (err) {
        console.error('Async: Could not copy text: ', err);
    });
}
