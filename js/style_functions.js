var timer;

function translate_home_content (path) {
    $('#homeNav div').addClass("transitioningOut");
    timer = setInterval(function () {
        $.get('views/ajaxHTML/nav/'+ path + 'View/'+ path + '.phtml', setNav);
        $.get('views/ajaxHTML/explain/'+ path + 'explain.phtml', setExplain);
        clearInterval(timer);
    }, 550);
}