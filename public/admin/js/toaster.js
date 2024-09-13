
function show_toastr(title, message, type) {
    var o, i;
    var icon = '';
    var cls = '';
    if (type == 'success') {
        icon = 'fas fa-check-circle';
        // $('.toast-body').addClass('bg-success');
        cls = 'primary';
    } else {
        icon = 'fas fa-times-circle';
        cls = 'danger';
    }

    $.notify({icon: icon, title: " " + title, message: message, url: ""},
    {
        element: "body",
        type: cls,
        allow_dismiss: !0,
        placement: {from: 'top', align: 'right'},
        offset: {x: 15, y: 15},
        spacing: 10,
        z_index: 1080,
        delay: 2500,
        timer: 2000,
        url_target: "_blank",
        mouse_over: !1,
        animate: {enter: o, exit: i},
        template: '<div class="toast text-white bg-'+cls+' fade show pr-5" role="alert" aria-live="assertive" aria-atomic="true">'
        +'<div class="d-flex">'
            +'<div class="toast-body"> '+message+' </div>'
            +'<button type="button" class="btn-close btn-close-white me-2 pt-3 m-auto" data-notify="dismiss" data-bs-dismiss="toast" aria-label="Close"></button>'
        +'</div>'
    +'</div>'
    });
}
