var timer;

function translate_home_content (path) {
    $('#homeNav div').addClass("transitioningOut");
    timer = setInterval(function () {
        if (path == 'allGames') {
            $.get('views/ajaxHTML/nav/'+ path + 'View/'+ path + '.phtml', setNav);
        }
        else if (path == 'homeContent') {
            $.get('views/ajaxHTML/nav/'+ path + 'View/'+ path + '.phtml', loadHome);
            $.get('views/ajaxHTML/explain/'+ path + 'explain.phtml', setExplain);
        }
        else {
            $.get('views/ajaxHTML/nav/'+ path + 'View/'+ path + '.phtml', setNav);
            $.get('views/ajaxHTML/explain/'+ path + 'explain.phtml', setExplain);
        }
        clearInterval(timer);
    }, 550);
}