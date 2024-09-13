(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
window.fbAsyncInit = function () {
    FB.init({
        appId: appId,
        cookie: true, // Enable cookies to allow the server to access the session.
        xfbml: true, // Parse social plugins on this webpage.
        version: version // Use this Graph API version for this call.
    });
}
function checkLoginState() { // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function (response) { // See the onlogin handler
        statusChangeCallback(response);
    });
}
function statusChangeCallback(response) { // Called with the results from FB.getLoginStatus().
    if (response.status === 'connected') { // Logged into your webpage and Facebook.
        SaveTheRecords(response);
    } else { // Not logged into your webpage or we are unable to tell.
        console.log('Not connected');
    }
}

function SaveTheRecords(getAccess) {
    FB.api('/me', function (response) {
        jQuery.ajax({
            type: "POST",
            url: admin_fb_connected_url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                // jQuery('#wait').show()
                $('#facebook-button-container').hide();
                $('#app-connection-loading').show();
            },
            data: {
                'postdata': response,
                'accessToken': getAccess
            },
            dataType: 'json',
            success: function (response) {
                if(response.status == 'true'){
                    window.location.reload();
                    $('#app-connection-loading').html('App Connected Successfully');
                }else{
                    $('#app-connection-loading').hide();
                    $('#app-connection-error').show();
                    $('#app-connection-error').html(response.message);
                    $('#facebook-button-container').show();
                }
            },error: function (error){
                console.log('error',error);
            }
        });
    }, {
        scope: fb_scope,
        return_scopes: true
    });
}
