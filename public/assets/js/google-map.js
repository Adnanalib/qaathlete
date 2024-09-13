function initAutoComplete() {
    // Add an event listener to the address input field
    $(googleMap.inputId).on('input', function () {
        var input = $(this).val();

        // Call the autocomplete route with the input address
        $.get(baseUrl + __url.googleMap.autocomplete, {
            address: input
        }, function (data) {
            var suggestions = data;

            // Create a list of autocomplete suggestions
            var html = '';
            for (var i = 0; i < suggestions.length; i++) {
                html += '<li onclick="setGoogleData(`' + suggestions[i].description + '`)">' + suggestions[i].description + '</li>';
            }
            // Display the list of suggestions in a dropdown menu
            $(googleMap.targetDiv).html(html).show();
        });
    });

    // Add an event listener to hide the suggestions when the input field loses focus
    $(googleMap.inputId).on('blur', function () {
        setTimeout(() => {
            $(googleMap.targetDiv).hide();
        }, 100);
    });

}

function setGoogleData(suggestion) {
    console.log('suggestion', suggestion);
    $(googleMap.inputId).val(suggestion);
    $(googleMap.targetDiv).hide();
}
