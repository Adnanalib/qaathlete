function xhrLoader() {
    var xhr = new window.XMLHttpRequest();
    xhr.upload.addEventListener("progress", function(evt) {
        console.log("evt", evt);
        if (evt.lengthComputable) {
            var percentComplete = (evt.loaded / evt.total) * 100;
            console.log("Percent complete:", percentComplete);
            $("#progress .progress-bar").css({width: percentComplete + '%'});
        }
    }, false);

    xhr.addEventListener("progress", function(evt) {
        if (evt.lengthComputable) {
            var percentComplete = (evt.loaded / evt.total) * 100;
            console.log("Percent complete:", percentComplete);
            $("#progress").css({width: percentComplete + '%'});
        }
    }, false);

    return xhr;
}

$(document).ajaxStart(function () {
    if (ajaxLoaderNeed) {
        $('button[type="submit"]').prop('disabled', true);
        startLoaders();
    }
})
    .ajaxStop(function () {
        $('button[type="submit"]').prop('disabled', false);
        setTimeout(function () {
            disableLoaders();
        }, 1000);
    });

function ajaxMethod(
    _url,
    _method,
    data,
    successCallback,
    errorCallback,
    beforeSendCallback,
    enctype = 'multipart/form-data',
    dataType = "json",
    async = true,
    cache = true,
    processData = true,
    contentType = 'application/x-www-form-urlencoded; charset=UTF-8',
) {
    updateCsrfToken();
    $("#progress-bar").show();
    $.ajax({
        xhr: xhrLoader,
        url: base_url + _url,
        headers: $headers,
        type: _method,
        data: data,
        dataType: dataType,
        async: async,
        cache: cache,
        processData: processData,
        contentType: contentType,
        enctype: enctype, //'application/x-www-form-urlencoded'
        beforeSend: beforeSendCallback,
        success: successCallback,
        error: errorCallback
    });
}

function successDefaultCallBack(response) {
    let message = "<div class='alert alert-danger'><p>" + response.message + "</p></div>";
    if (response.status == true) {
        message = "<div class='alert alert-success'><p>" + response.message + "</p></div>";
    }
    response.status ? success_mini(response.message) : error_mini(response.message);
    $target.html(message);
    hideAlert();
}

function errorDefaultCallBack(xhr, status, error) {
    console.log('xhr', xhr);
    console.log('status', status);
    console.log('error', error);
    clearErrors();
    if (xhr.status === 400) {
        showValidationErrors(xhr.responseJSON.data);
    }else if (!isEmpty(xhr.responseJSON.error) && !isEmpty(xhr.responseJSON.key)) {
        $('#'+xhr.responseJSON.key+'-error').html('<p class="input-error mt-4 mb-0">'+xhr.responseJSON.error+'</p>');
    }else {
        error_mini(xhr.responseJSON.error);
    }
}



function beforeDefaultSendCallback() {
    clearErrors();
    $target.show();
    $target.html("<div class='alert alert-info'><p>Loading ...</p></div>");
}

function successNullCallBack(response) { }

function errorNullCallBack(xhr, status, error) { }

function beforeNullSendCallback() { }

function startLoaders() {
    previousSubmitButtonText = $('button[type="submit"]').html();
    showSpinner('button[type="submit"]', 'Waiting...');
}

function disableLoaders() {
    hideSpinner('button[type="submit"]', previousSubmitButtonText);
}

function isFormValid(form_id, should_call_nexPrev_function = false) {
    if ($(form_id).validate()) {
        return should_call_nexPrev_function ? should_call_nexPrev_function() : true;
    }
}

function clearErrors() {
    $('input').removeClass('is-invalid');
    $('select').removeClass('is-invalid');
    $('textarea').removeClass('is-invalid');
    $('span.is-invalid-text').remove();
    hideAlert();
}

function clearOnlyErrors(name) {
    $(name).removeClass('is-invalid');
    $(name).parent().find('span.is-invalid-text').remove();
}

function showValidationInputErrors(data, target = null, has_instant_parent = true) {
    clearErrors();
    $.each(errors, function (key, value) {
        $('[name=' + key + ']').addClass('is-invalid');
        let parent_object = $('[name=' + key + ']').parent();
        if (has_instant_parent) {
            parent_object = $('[name=' + key + ']');
        }
        $("<span class='is-invalid-text'>" + value + "</span>").insertAfter(parent_object);
        $('.is-invalid-text').parent().addClass('error-parent');
    });
    if (!isEmpty(target)) {
        scrollTo(target);
    }
}

function showValidationErrors(errors) {
    $.each(errors, function (key, value) {
        $('#'+key+'-error').html('<p class="input-error mt-4 mb-0">'+value+'</p>');
    });
}
