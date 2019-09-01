
var states_selectric = "";
$(document).ready(function () {
    

    // Looping through USA states to generate Selectric Options
    states.map(function (state) {
        states_selectric += `<option value="${state.toLowerCase()}">${state}</option>`
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
        $(this).find("img").attr("src", "./svg/shield_white.svg")
    });

    $("[data-account='verify']").on("mouseleave",function(){
        $(this).find("img").attr("src", "./svg/shield_green.svg")
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

var states = [
    "All States",
    "Alaska",
    "Alabama",
    "Arkansas",
    "American Samoa",
    "Arizona",
    "California",
    "Colorado",
    "Connecticut",
    "District of Columbia",
    "Delaware",
    "Florida",
    "Georgia",
    "Guam",
    "Hawaii",
    "Iowa",
    "Idaho",
    "Illinois",
    "Indiana",
    "Kansas",
    "Kentucky",
    "Louisiana",
    "Massachusetts",
    "Maryland",
    "Maine",
    "Michigan",
    "Minnesota",
    "Missouri",
    "Mississippi",
    "Montana",
    "North Carolina",
    " North Dakota",
    "Nebraska",
    "New Hampshire",
    "New Jersey",
    "New Mexico",
    "Nevada",
    "New York",
    "Ohio",
    "Oklahoma",
    "Oregon",
    "Pennsylvania",
    "Puerto Rico",
    "Rhode Island",
    "South Carolina",
    "South Dakota",
    "Tennessee",
    "Texas",
    "Utah",
    "Virginia",
    "Virgin Islands",
    "Vermont",
    "Washington",
    "Wisconsin",
    "West Virginia",
    "Wyoming"
]
