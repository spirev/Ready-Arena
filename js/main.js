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
    $('body').on('click', '.homeContentDiv article button', function(){
        let quickBut = this.value;
        if (quickBut == 'create' || quickBut == 'find' || quickBut == 'team') {
            $('#homeNav div').addClass('transitioningOut');
            SetAjaxContent('allGames');
            $('#allGamesPhtml').addClass('transitioningOut');
        }
        else {
            $('#homeNav div').addClass('transitioningOut');
            SetAjaxContent('findFamily');
            $('#familyPhtml').addClass('transitioningIn');
        }
        lilProg.stage++;
        lilProg.name = this.value;
    })
    
    //listen helpBut & upBut for sroll down & up
    $('body').on('click', '#helpBut', function() {
        $('html, body').animate({scrollTop: 1500}, 'slow');
    })
    $('body').on('click', '#upBut', function() {
        $('html, body').animate({scrollTop: 0}, 'slow');
    })
    
    //listen return arrow button for going back in the home navigator
    $('body').on('click', "#returnArrow", function() {
        lilProg.stage--;
        console.log(lilProg.stage + 1 + "-->" + lilProg.stage + " " + lilProg.name);
        SetAjaxContent('homeContent');
        $('#homeNav div').addClass('transitioningIn');

    })

    $('body').on('click', "#allGamesPhtml .gameIcone", function() {
        console.log('CLICK CLICK');
    })
})