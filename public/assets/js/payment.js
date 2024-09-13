$(document).ready(function() {
    $('form input').each(function() {
        let mask = $(this).attr('mask');
        if(mask) {
            Inputmask(mask, {
                placeholder: $(this).attr('placeholder'),
                greedy: false,
                jitMasking: true
            }).mask($(this));
        }
    });
});
