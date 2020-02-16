const $asideMenu = $('aside nav');

$(function () {
    
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
    $('#homeNav button').on('click', function () {
        let quickBut = this.value;
        //let homePage = $('#indexPhtml');
        
        //homePage.fadeOut();
        switch (quickBut) {
            case 'creat':
                translate_home_content("createTournament");
                break;
            case 'find':
                translate_home_content("findTournament");
                break;
            case 'team':
                translate_home_content("findFamily");
                break;
            case 'family':
                translate_home_content("findTeam");
                break;
        }
    })
})