var states_selectric = "";
$(document).ready(function () {

    // Looping through USA states to generate Selectric Options
    _.forOwn(states, function(state, index){
        states_selectric += `<option class="${state.class}" value="${state.value}">${state.name}</option>`
    });

    // Append Selectric Options - Mobile Native Look
    $("#select-states").append(states_selectric).selectric({
        disableOnMobile: false,
        nativeOnMobile: false
    });

    // Append Selectric Options - Mobile Native Look - Mobile View
    $("#select-states-mobile").append(states_selectric).selectric({
        disableOnMobile: false,
        nativeOnMobile: false
    });

    $("[data-account='verify']").on("mouseover",function(){
        $(this).find("img").attr("src", "/images/shield_white.svg")
    });

    $("[data-account='verify']").on("mouseleave",function(){
        $(this).find("img").attr("src", "/images/shield_green.svg")
    });

    // Toggle between HEMP and CANNABIS
    $("#switch").on('change', function () {
        if ($(this).is(':checked')) {
            switchStatus = $(this).is(':checked');
            if($(this).val() === "on") {
                $(".toggle-hemp-cannabis").text("HEMP")
            }
        }
        else {
            switchStatus = $(this).is(':checked');
            if($(this).val() === "on") {
                $(".toggle-hemp-cannabis").text("CANNABIS")
            }
        }
    });
});

// Switch between dropdown icons
function toggleCategory(t) {
    var target_data = $(t).data("click");
    $(`[data-clicked='${target_data}']`).attr('class', function (index, attr) {
        return attr == "fas fa-chevron-up" ? "fas fa-chevron-down" : "fas fa-chevron-up";
    });

    $(`[data-target='${target_data}']`).slideToggle();
}

// State object for Selectric
var states = [
    {value: "all", name: "All States", class: "special"},
    {value: "all_recreational", name: "All recreational cannabis states", class: "special"},
    {value: "alaska", name: "Alaska", class: "normal"},
    {value: "california", name: "California", class: "normal"},
    {value: "colorado", name: "Colorado", class: "normal"},
    {value: "maine", name: "Maine", class: "normal"},
    {value: "michigan", name: "Michigan", class: "normal"},
    {value: "nevada", name: "Nevada", class: "normal"},
    {value: "oregon", name: "Oregon", class: "normal"},
    {value: "vermont", name: "Vermont", class: "normal"},
    {value: "washington", name: "Washington", class: "normal"},
    {value: "all_recreational", name: "All medical/recreational cannabis states", class: "special"},
    {value: "alabama", name: "Alabama", class: "normal"},
    {value: "arkansas", name: "Arkansas", class: "normal"},
    {value: "american_samoa", name: "American Samoa", class: "normal"},
    {value: "arizona", name: "Arizona", class: "normal"},
    {value: "connecticut" , name: "Connecticut", class: "normal"},
    {value: "columbia_district", name: "District of Columbia", class: "normal"},
    {value: "delaware", name: "Delaware", class: "normal"},
    {value: "florida", name: "Florida", class: "normal"},
    {value: "georgia", name: "Georgia", class: "normal"},
    {value: "guam", name: "Guam", class: "normal"},
    {value: "hawaii", name: "Hawaii", class: "normal"},
    {value: "iowa", name: "Iowa", class: "normal"},
    {value: "idaho", name: "Idaho", class: "normal"},
    {value: "illinois", name: "Illinois", class: "normal"},
    {value: "indiana", name: "Indiana", class: "normal"},
    {value: "kansas", name: "Kansas", class: "normal"},
    {value: "kentucky", name: "Kentucky", class: "normal"},
    {value: "louisiana", name: "Lousiana", class: "normal"},
    {value: "massachusetts", name: "Massachusetts", class: "normal"},
    {value: "maryland", name: "Maryland", class: "normal"},
    {value: "minnesota", name: "Minnesota", class: "normal"},
    {value: "missouri", name: "Missouri", class: "normal"},
    {value: "mississippi", name: "Mississippi", class: "normal"},
    {value: "montana", name: "Montana", class: "normal"},
    {value: "north_carolina", name: "North Carolina", class: "normal"},
    {value: "north_dakota", name: "North Dakota", class: "normal"},
    {value: "nebraska", name: "Nebraska", class: "normal"},
    {value: "new_hampshire", name: "New Hampshire", class: "normal"},
    {value: "new_jersey", name: "New Jersey", class: "normal"},
    {value: "new_mexico", name: "New Mexico", class: "normal"},
    {value: "new_york", name: "New York", class: "normal"},
    {value: "ohio", name: "Ohio", class: "normal"},
    {value: "oklahoma", name: "Oklahoma", class: "normal"},
    {value: "pennsylvania", name: "Pennsylvania", class: "normal"},
    {value: "puerto_rico", name: "Puerto Rico", class: "normal"},
    {value: "rhode_island", name: "Rhode Island", class: "normal"},
    {value: "south_carolina", name: "South Carolina", class: "normal"},
    {value: "south_dakota", name: "South Dakota", class: "normal"},
    {value: "tennessee", name: "Tennessee", class: "normal"},
    {value: "texas", name: "Texas", class: "normal"},
    {value: "utah", name: "Utah", class: "normal"},
    {value: "virginia", name: "Virginia", class: "normal"},
    {value: "virgin_islands", name: "Virgin Islands", class: "normal"},
    {value: "wisconsin", name: "Wisconsin", class: "normal"},
    {value: "west_virginia", name: "West Virginia", class: "normal"},
    {value: "wyoming", name: "Wyoming", class: "normal"}
]
