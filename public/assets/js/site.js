$('.dropdown-toggle').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).closest('.search-dropdown').toggleClass('open');
});

$('.dropdown-menu > li > a').click(function (e) {
    e.preventDefault();
    var clicked = $(this);
    clicked.closest('.dropdown-menu').find('.menu-active').removeClass('menu-active');
    clicked.parent('li').addClass('menu-active');
    clicked.closest('.search-dropdown').find('.toggle-active').html(clicked.html());
});

// $(document).ready(function () {
/* Search bar */

var resizeElements;

$(document).ready(function () {

    // Set up common variables
    // --------------------------------------------------

    var bar = ".search_bar";
    var input = bar + " input[type='text']";
    var button = bar + " button[type='submit']";
    var dropdown = bar + " .search_dropdown";
    var dropdownLabel = dropdown + " > span";
    var dropdownList = dropdown + " ul";
    var dropdownListItems = dropdownList + " li";


    // Set up common functions
    // --------------------------------------------------

    resizeElements = function () {
        var barWidth = $(bar).outerWidth();

        var labelWidth = $(dropdownLabel).outerWidth();
        $(dropdown).width(labelWidth);

        var dropdownWidth = $(dropdown).outerWidth();
        var buttonWidth = $(button).outerWidth();
        var inputWidth = barWidth - dropdownWidth - buttonWidth;
        var inputWidthPercent = inputWidth / barWidth * 100 + "%";

        $(input).css({
            'margin-left': dropdownWidth,
            'width': inputWidthPercent
        });
    }

    function dropdownOn() {
        $(dropdownList).fadeIn(25);
        $(dropdown).addClass("active");
    }

    function dropdownOff() {
        $(dropdownList).fadeOut(25);
        $(dropdown).removeClass("active");
    }


    // Initialize initial resize of initial elements
    // --------------------------------------------------
    resizeElements();


    // Toggle new dropdown menu on click
    // --------------------------------------------------

    $(dropdown).click(function (event) {
        if ($(dropdown).hasClass("active")) {
            dropdownOff();
        } else {
            dropdownOn();
        }

        event.stopPropagation();
        return false;
    });

    $("html").click(dropdownOff);


    // Activate new dropdown option and show tray if applicable
    // --------------------------------------------------

    $(dropdownListItems).click(function () {
        $(this).siblings("li.selected").removeClass("selected");
        $(this).addClass("selected");

        // Focus the input
        $(this).parents("form.search_bar:first").find("input[type=text]").focus();

        var labelText = $(this).text();
        $(dropdownLabel).text(labelText);

        resizeElements();

    });


    // Resize all elements when the window resizes
    // --------------------------------------------------

    $(window).resize(function () {
        resizeElements();
    });

    // Get User Unread Notification
    setInterval(() => {
        $.ajax({
            type: "GET",
            processData: false,
            contentType: false,
            url: window.location.origin + "/notifications/count",
            data: [],// serializes the form's elements.
            success: function (data) {
                if (data.status == 1) {
                    $('#user-notification-count').html(data.data);
                }
            },
            error: function (data) {
                $.each(data.responseJSON.errors, function (key, value) {
                    // console.error("error", value);
                });
            }
        });
    }, 10000);
});
// });

$(document).ready(function () {
    $(".search-type li").click(function () {
        // Code to be executed when li is clicked
        $('.search_type_').each(function (index, element) {
            $(element).removeClass('selected');
        })
        $(this).addClass('selected')
        $('.search_type_input').val($(this).val());
        $('.search_type_input-1').val($(this).val());
    });
});