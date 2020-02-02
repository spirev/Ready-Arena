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
    $('#indexPDiv button').on('click', function () {

        let quickBut = this.value;
        //let homePage = $('#indexPhtml');

        //homePage.fadeOut();
        switch (quickBut) {
            case 'creat':
                $.get('creatTurnament.phtml', setContent);
                break;
            case 'find':
                $.get('findTurnament.phtml', setContent);
                break;
            case 'team':
                $.get('team.phtml', setContent);
                break;
            case 'family':
                $get('family.phtml', setContent);
                break;
        }
    })
})