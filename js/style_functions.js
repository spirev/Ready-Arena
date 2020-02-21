var timer;
/*  allow homeNav to get new content wich replace previous content
    (default : homeContent.phmtl ----> allGames.phtml or family.phtml ) */
function SetAjaxContent(path) {
    timer = setInterval(function () {
        if (path == 'homeContent') {
            $.get('views/ajaxHTML/nav/'+ path + 'View/'+ path + '.phtml', setNav);
            $.get('views/ajaxHTML/explain/'+ path + 'explain.phtml', setExplain);
        }
        else if (path == 'allGames') {
            $.get('views/ajaxHTML/nav/'+ path + 'View/'+ path + '.phtml', setNav);
        }
        else {
            $.get('views/ajaxHTML/nav/'+ path + 'View/'+ path + '.phtml', setNav);
            $.get('views/ajaxHTML/explain/'+ path + 'explain.phtml', setExplain);
        }
        clearInterval(timer);
    }, 1000);

    /*if (path == 'homeContent') {
        console.log('nada');
    }
    else if (path == 'allGames') {
        $('#allGamePhtml').addClass(".transitioningIn");
    }
    else {
    }*/
}