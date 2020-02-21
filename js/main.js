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

    //listen buttons creat/find/team/family from homeNav
    $('.homeContentDiv article button').on('click', function(){
        let quickBut = this.value;
        if (quickBut == 'create' || quickBut == 'find' || quickBut == 'team') {
            $('#homeNav div').addClass("transitioningOut");
            SetAjaxContent('allGames');
        }
        else {
            $('#homeNav div').addClass("transitioningOut");
            SetAjaxContent('findFamily');
        }
    })

    $('#helpBut').on('click', function() {
        $('html, body').animate({scrollTop: 2000}, 'slow');
    })
    $('#upBut').on('click', function() {
        $('html, body').animate({scrollTop: 0}, 'slow');
    })
})