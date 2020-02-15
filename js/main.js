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

    //écoute des bouton creat/find/team/family de la page home du navigateur
    $('#homeNav button').on('click', function () {
        let quickBut = this.value;
        //let homePage = $('#indexPhtml');
        
        //homePage.fadeOut();
        switch (quickBut) {
            case 'creat':
                $.get('views/ajaxHTML/nav/creatTournamentView/creatTournament.phtml', setNav),
                $.get('views/ajaxHTML/explain/create_explain.phtml', setExplain);
                break;
            case 'find':
                $.get('views/ajaxHTML/nav/findTournamentView/findTournament.phtml', setNav),
                $.get('views/ajaxHTML/explain/find_explain.phtml', setExplain);
                break;
            case 'team':
                $.get('views/ajaxHTML/nav/findTeamView/findTeam.phtml', setNav),
                $.get('views/ajaxHTML/explain/team_explain.phtml', setExplain);
                break;
            case 'family':
                $get('views/ajaxHTML/nav/findFamilyView/findFamily.phtml', setNav),
                $.get('views/ajaxHTML/explain/family_explain.phtml', setExplain);
                break;
        }
    })
})