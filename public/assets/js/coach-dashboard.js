let svg_copy_tick = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 11L12 14L22 4" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>`;
let svg_copy = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 9H11C9.89543 9 9 9.89543 9 11V20C9 21.1046 9.89543 22 11 22H20C21.1046 22 22 21.1046 22 20V11C22 9.89543 21.1046 9 20 9Z"
                                stroke="#047CC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M5 15H4C3.46957 15 2.96086 14.7893 2.58579 14.4142C2.21071 14.0391 2 13.5304 2 13V4C2 3.46957 2.21071 2.96086 2.58579 2.58579C2.96086 2.21071 3.46957 2 4 2H13C13.5304 2 14.0391 2.21071 14.4142 2.58579C14.7893 2.96086 15 3.46957 15 4V5"
                                stroke="#047CC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>`;

function copyLink(url) {
    copyTextToClipboard(url);
}

function updateCopyResponse() {
    $('.qr-links .copy span').html('Copied');
    $('.qr-links .copy .icon').html(svg_copy_tick);
    setTimeout(() => {
        $('.qr-links .copy span').html('Copy profile link');
        $('.qr-links .copy .icon').html(svg_copy);
    }, 500);
}
$(function () {
    $('.qr-preference.radio').click(function () {
        $('#qr-preference-error').html('');
        $('.qr-preference.radio').removeClass('selected');
        $(this).addClass('selected');
        $('input[name="cart-qr-preference"]').val($(this).attr('data-value'));
    });
    $('.regular').slick({
        infinite: true,
        lazyLoad: 'anticipated', // ondemand progressive anticipated
        slidesToShow: 5,
        slidesToScroll: 5,
        responsive: [{
                breakpoint: 1256,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 978,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 786,
                settings: {
                    centerMode: true,
                    dots: true,
                    arrows: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });
    $('.thumbnail-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.product-detail-slider',
        dots: false,
        arrows: false,
        centerMode: true,
        focusOnSelect: true,
        vertical: true, // add this option
        verticalSwiping: true, // add this option for touch-swipe scrolling
        responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2
                }
            }
        ]
    });
    $('.product-detail .product-detail-slider').slick({
        dots: false,
        arrows: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        // autoplaySpeed: 3000,
        // autoplay: true,
        fade: true,
        asNavFor: '.thumbnail-slider'
    });
    if (zoomEffect == '1') {
        $('.imgZoom').mooZoom({
            zoom: {
                width: 200,
                height: 200,
                zIndex: 600
            },
            overlay: {
                opacity: 0.65,
                zIndex: 500,
                backgroundColor: '#000000',
                fade: true
            },
            detail: {
                zIndex: 600,
                margin: {
                    top: 0,
                    left: 10
                },
                fade: true
            },
        });
    }

});

$(function () {
    $('.add-to-cart-button').click(function () {
        addToTeamCart();
    });
});
