const $asideMenu = $('aside nav');

$(document).ready(function () {

    // listen to the click of menu/arrow to hide & show aside menu*/
    $('#arrowMenu').on('click', function () {
        $asideMenu.toggleClass("showAside");
        $asideMenu.toggleClass("hideAside");
        if ($('main aside nav').hasClass("showAside"))
            $('#arrowMenu').html("<i class=\"fas fa-arrow-left\"></i>");
        else
            $('#arrowMenu').html("<i class=\"fas fa-arrow-right\"></i>");
    })

    $('#arrowMenu').on('mouseover', function () {
        if ($('main aside nav').hasClass("showAside"))
            $('#arrowMenu').html("<i class=\"fas fa-arrow-left\" ></i>");
        else
            $('#arrowMenu').html("<i class=\"fas fa-arrow-right\"></i>");
    })

    $('#arrowMenu').on('mouseleave', function () {
        $('#arrowMenu').html("MENU");
    })
})