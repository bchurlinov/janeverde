
var select_options = "";
$(document).ready(function () {

    // Initialize Slick Slider
    $('.slider').slick();

    // Initialize selectric
    select_sorting.map(function (item, index) {
        select_options += `<option value="${item.option_value}">${item.option_name}</option>`
    });

    // Append Selectric Options - Mobile Native Look
    $("#select-sort").append(select_options).selectric({
        disableOnMobile: false,
        nativeOnMobile: false
    });

    // Toggle Grid Button - Active
    $("[data-toggle='grid']").css({ background: "#1c6d5a" });
    $("[data-toggle='grid'] i").css({ color: "white" });
});


var select_sorting = [
    { option_value: "newest", option_name: "Newest" },
    { option_value: "oldest", option_name: "Oldest" },
    { option_value: "price_high", option_name: "Price: ↑" },
    { option_value: "price_low", option_name: "Price: ↓" },
]

function renderGridView(t) {
    // Toggle Button Layout
    $(".grid-list-button").css({ background: "white" });
    $(".toggle-icon").css({ color: "#1c6d5a" });
    $(t).find("i").css({ color: "white" });
    $(t).css({ background: "#1c6d5a" });

    // Toggle Product Template Layout
    $(".product-template-wrap").removeClass("product-template-wrap-listview");
}

function renderListView(t) {
    // Toggle Button Layout
    $(".grid-list-button").css({ background: "white" });
    $(".toggle-icon").css({ color: "#1c6d5a" });
    $(t).find("i").css({ color: "white" });
    $(t).css({ background: "#1c6d5a" });

    // Toggle Product Template Layout
    $(".product-template-wrap").addClass("product-template-wrap-listview");
    $(".products-listing-wrap").css({ margin: "0" });
}

