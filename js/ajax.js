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
(default : homeContent.phmtl ----> allGames.phtml or family.phtml ----> create/find/team/family  stage 3 ) */
var timer;

function SetAjaxContent(path) {
    timer = setInterval(function () {
        if (path == 'homeContent') {
            $.get('views/ajaxHTML/nav/'+ path + 'View/'+ path + '.phtml', setNav);
            $.get('views/ajaxHTML/explain/'+ path + 'explain.phtml', setExplain);
        }
        else if (path == 'allGames') {
            $.get('views/ajaxHTML/nav/'+ path + 'View/'+ path + '.phtml', setNav);
            $.get('views/ajaxHTML/explain/homeContentExplain.phtml', setExplain);
        }
        else if (path == 'Team') {
            $.get('views/ajaxHTML/nav/find'+ path + 'View/find'+ path + '.phtml', setNav);
        }
        else if (path == 'create') {
            $.get('views/ajaxHTML/nav/'+ path+ 'TournamentView/'+ path+ 'Tournament.phtml', setNav);
            $.get('views/ajaxHTML/explain/createTournamentExplain.phtml', setExplain);
        }
        else if (path == 'find') {
            $.get('views/ajaxHTML/nav/findTournamentView/findTournament.phtml', setNav);

        }
        else {
            $.get('views/ajaxHTML/nav/'+ path + 'View/'+ path + '.phtml', setNav);
            $.get('views/ajaxHTML/explain/'+ path + 'explain.phtml', setExplain);
        }
        clearInterval(timer);
    }, 1000);
}