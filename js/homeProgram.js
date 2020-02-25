
// Allow an easier navigation with layer level indication & precise name of page
// these values will be call with the buttons listener to know witch content need to be push

class Navigation {

    constructor(stage = 1, name = 'home'){
        this.stage = stage;
        this.name = name;
    }
}

lilProg = new Navigation();