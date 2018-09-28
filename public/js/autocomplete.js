
$(document).ready(function(){

    // Defining the local dataset
    var country = new Array();
    country = $('#weather_country').data('countries');
    
    // Constructing the suggestion engine
    var countries = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: country
    });
    
    // Initializing the typeahead
    $('.country').typeahead({
        hint: true,
        highlight: true, /* Enable substring highlighting */
        minLength: 1 /* Specify minimum characters required for showing result */
    },
    {
        name: 'countries',
        source: countries
    });

    $('#weather_country').change(function(){
        if(jQuery.inArray($('#weather_country').val(),country) > -1){
            var cities = null;
            var city = new Array();
            allCities = $('#weather_city').data('cities');
            city = allCities[$('#weather_country').val()];
            
            // Constructing the suggestion engine
            cities = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: city
            });

            // Initializing the typeahead
            $('#weather_city').typeahead({
                hint: true,
                highlight: true, /* Enable substring highlighting */
                minLength: 1 /* Specify minimum characters required for showing result */
            },
            {
                name: 'cities',
                source: cities
            });
        }

    });
});
