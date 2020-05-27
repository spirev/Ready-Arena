const $asideMenu = $('aside nav');
var state = 0;
const sliders = [
    {
        src: '/finalProject/img/slider/scene1.jpeg',
    },
    {
        src: '/finalProject/img/slider/fond5.jpg',
    },
    {
        src: '/finalProject/img/slider/scene2.jpg'
    }
]

$(document).ready(function () {

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

    //redirect to the right ladder page considering option chose (by name / rank)
    $('body').on('click', '.ladderButt', function () {
        if(this.value == 'name') {
            window.location.replace(`LadderController.php?path=Ladder&order=name`);
        }
        else {
            window.location.replace(`LadderController.php?path=Ladder&order=rank`);
        }
    })

    setInterval(function() {
        if (state == sliders.length - 1) {
            state = 0;
        }
        else {
            state++;
        }
        $('body').css(`background-image`,`url('${sliders[state].src}')`);
    }, 6000);

    $('#onePlayerPhtml #seekTeam i').on('click', function() {
        $('#onePlayerPhtml #seekTeam section').toggleClass('hideAddLFT');
        $('#onePlayerPhtml #seekTeam section').toggleClass('showAddLFT');
    })

    $('#flash').on('click', function() {
        $('#flash').css('display', 'none');
    })
    $('#redFlash').on('click', function() {
        $('#redFlash').css('display', 'none');
    })
})