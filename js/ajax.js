/* function used to change content in home navigator */
function setNav(content)
{
    $('#homeNav').html(content);
}

/* function used to change content in explain div*/
function setExplain(content)
{
    $('#homeExplain').html(content);
}

/*  allow homeNav to get new content wich replace previous content
(default : homeContent.phmtl ----> allGames.phtml or family.phtml ) */
var timer;

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
}