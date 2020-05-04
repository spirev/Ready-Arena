const $asideMenu = $('aside nav');

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
})