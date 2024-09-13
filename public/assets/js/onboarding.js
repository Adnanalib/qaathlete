let __social_link_icon = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 13C10.4295 13.5741 10.9774 14.0491 11.6066 14.3929C12.2357 14.7367 12.9315 14.9411 13.6467 14.9923C14.3618 15.0435 15.0796 14.9403 15.7513 14.6897C16.4231 14.4392 17.0331 14.047 17.54 13.54L20.54 10.54C21.4508 9.59695 21.9548 8.33394 21.9434 7.02296C21.932 5.71198 21.4061 4.45791 20.4791 3.53087C19.5521 2.60383 18.298 2.07799 16.987 2.0666C15.676 2.0552 14.413 2.55918 13.47 3.46997L11.75 5.17997"
                                    stroke="#047CC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M14 11C13.5705 10.4259 13.0226 9.9508 12.3934 9.60704C11.7642 9.26328 11.0684 9.05886 10.3533 9.00765C9.63816 8.95643 8.92037 9.05961 8.24861 9.3102C7.57685 9.56079 6.96684 9.95291 6.45996 10.46L3.45996 13.46C2.54917 14.403 2.04519 15.666 2.05659 16.977C2.06798 18.288 2.59382 19.542 3.52086 20.4691C4.4479 21.3961 5.70197 21.922 7.01295 21.9334C8.32393 21.9447 9.58694 21.4408 10.53 20.53L12.24 18.82"
                                    stroke="#047CC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>`;
let __social_link_icon_remove = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 6L6 18" stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>`;
let currentFormButtonAction = 'Adding...';
$("#onboarding-form").submit(function (event) {
    showSpinner('#onboarding-form button', 'Wait...');
});
$("#onboarding-social-link-form").submit(function (event) {
    showSpinner('#onboarding-social-link-form button', currentFormButtonAction);
});
$('#social-link-btn-next').click(function () {
    $('#onboarding-social-link-form input[name="_moveToNext"]').val('true');
    $('#onboarding-social-link-form input[name="link"]').removeAttr('required');
    currentFormButtonAction = 'Wait...';
    $("#onboarding-social-link-form").submit();
});

function previousStep(step) {
    $('#redirectToUrl').append('<input type="hidden" name="previous_step" value="' + step + '">');
    $('#redirectToUrl').attr('action', '/athletes/onboarding');
    $('#redirectToUrl').attr('method', 'POST');
    showSpinner('.previous-onboarding-btn', '');
    $('#redirectToUrl').submit();
}

function editSocialLink(linkId, linkUrl) {
    currentFormButtonAction = 'Updating...';
    $('#onboarding-social-link-form input[name="_link_id"]').val(linkId);
    $('#onboarding-social-link-form input[name="link"]').val(linkUrl);
    $('#onboarding-social-link-form button[type="submit"]').html('Update Link');
    $('#onboarding-social-link-form .social-link-icon').html(`<span onclick="removeLink('` + linkId + `')">` + __social_link_icon_remove + `</span>`);
}

function removeLink(linkId) {
    currentFormButtonAction = 'Adding...';
    $('#onboarding-social-link-form input[name="_link_id"]').val('');
    $('#onboarding-social-link-form input[name="link"]').val('');
    $('#onboarding-social-link-form button[type="submit"]').html('Add Link');
    $('#onboarding-social-link-form .social-link-icon').html(__social_link_icon);
}

function deleteSocialLink(linkId) {
    if (confirm('Are you sure you want to delete?')) {
        window.location.href = baseUrl + '/athletes/social-link/' + linkId;
    }
}

function featureSocialLink(linkId) {
    if (confirm('Are you sure you want to make this as feature link?')) {
        window.location.href = baseUrl + '/athletes/feature-social-link/' + linkId;
    }
}
$(document).ready(function () {
    $('.link-feature-image').hover(
        function () {
            $(this).attr('src', baseUrl + '/assets/images/icons/star-full.png');
        },
        function () {
            $(this).attr('src', baseUrl + '/assets/images/icons/star.png');
        }
    );
});
