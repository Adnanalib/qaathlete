try {
    Lobibox.notify.DEFAULTS.iconSource = 'fontAwesome';
} catch (error) {
    console.error(error);
}
function successToaster(message) {
    Lobibox.notify('success', {
        sound: false,
        msg: message
    });
}
function errorToaster(message) {
    Lobibox.notify('error', {
        sound: false,
        msg: message
    });
}
function warningToaster(message) {
    Lobibox.notify('warning', {
        sound: false,
        msg: message
    });
}
function infoToaster(message) {
    Lobibox.notify('info', {
        sound: false,
        msg: message
    });
}
function success_mini(message) {
    Lobibox.notify('success', {
        size: 'mini',
        sound: false,
        msg: message
    });
}
function error_mini(message) {
    Lobibox.notify('error', {
        size: 'mini',
        sound: false,
        msg: message
    });
}
function warning_mini(message) {
    Lobibox.notify('warning', {
        size: 'mini',
        sound: false,
        msg: message
    });
}
function info_mini(message) {
    Lobibox.notify('info', {
        size: 'mini',
        sound: false,
        msg: message
    });
}
function success_large(message) {
    Lobibox.notify('success', {
        size: 'large',
        sound: false,
        msg: message
    });
}
function error_large(message) {
    Lobibox.notify('error', {
        size: 'large',
        sound: false,
        msg: message
    });
}
function warning_large(message) {
    Lobibox.notify('warning', {
        size: 'large',
        sound: false,
        msg: message
    });
}
function info_large(message) {
    Lobibox.notify('info', {
        size: 'large',
        sound: false,
        msg: message
    });
}
function showProgress(){
    Lobibox.progress({
        title: 'Please wait',
        label: 'Uploading files...',
        onShow: function ($this) {
            progress_element = $this;
        },
        closed: function () {
            progress_element = null;
            $('.lobibox-header .btn-close').click();
        }
    });
}
