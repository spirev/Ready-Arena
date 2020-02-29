
// Allow an easier navigation with layer level indication & precise name of page
// these values will be call with the buttons listener to know witch content need to be push

class Navigation {

    constructor(stage = 1, name = 'home'){
        this.stage = stage;
        this.name = name;
    }
}

lilProg = new Navigation();

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
    
    //listen to "return arrow" button for going back in home navigator
    $('body').on('click', "#returnArrow", function() {
        lilProg.stage--;
        SetAjaxContent('homeContent');
        $('#homeNav div').addClass('transitioningIn');

    })

    $('body').on('click', "#allGamesPhtml .gameIcone", function() {
    })