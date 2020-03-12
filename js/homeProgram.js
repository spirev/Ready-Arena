
// Allow an easier navigation in home navigation (ajaxed content), with layer level indication & precise name of page
// these values will be called by buttons listener to know witch content need to be push

class Navigation {

    constructor(stage = 1, name = 'home', game = 'none'){
        this.stage = stage;
        this.name = name;
        this.game = game;

    }
}

// Generate a new Navigation object
lilProg = new Navigation();

    //listen buttons creat/find/team/family from homeNav
    // only findFamily doesn't need to select a specifiic game for further activities (else)
    $('body').on('click', '.homeContentDiv article button', function(){
        let quickBut = this.value;
        switch (quickBut){
            case 'create':
                $('#homeNav div').addClass('transitioningOut');
                SetAjaxContent('allGames');
                break;
            case 'find':
                $('#homeNav div').addClass('transitioningOut');
                SetAjaxContent('allGames');
                break;
            case 'team':
                $('#homeNav div').addClass('transitioningOut');
                SetAjaxContent('allGames');
                break;
            case 'family':
                /*$('#homeNav div').addClass('transitioningOut');
                SetAjaxContent('findFamily');*/
                break
        }

        //increment stage value to memorise current layer in the home nav
        lilProg.stage++;
        //taking the layer name for stage 3
        lilProg.name = this.value;
    })
    
    //listen helpBut & upBut for sroll down & up on click
    $('body').on('click', '#helpBut', function() {
        $('html, body').animate({scrollTop: 1500}, 'slow');
    })
    $('body').on('click', '#upBut', function() {
        $('html, body').animate({scrollTop: 0}, 'slow');
    })
    
    //listen to "return arrow" button for going back in home navigator (orange left arrow)
    $('body').on('click', "#returnArrow", function() {
        // decrement stage ofc...
        lilProg.stage--;
        SetAjaxContent('homeContent');          // WORKING HERE /!\ need function evaluating lilprog values to return to the right ajax page (and not necesserly home) !!
        $('#homeNav div').addClass('transitioningIn'); // WORKING HERE /!\ transitioning animation has to work !!
    })

    //listen to all the games button to transfer its game name to lilprog.game
    //then set new ajax content according to lilprog.name
    $('body').on('click', "#allGamesPhtml .gameIcone", function() {
        lilProg.game = this.value;
        switch(lilProg.name){
            case 'create':
                SetAjaxContent('create')
                break;
            case 'find':
                SetAjaxContent('find')
                break;
            case 'team':
                SetAjaxContent('team')
                break;
            case 'family':
                SetAjaxContent('family')
                break;
        }
    })