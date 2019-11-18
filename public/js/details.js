$(document).ready(function () {
    $('.openmodale').click(function (e) {
        e.preventDefault();
        $('.modale').addClass('opened');
    });

    $('.closemodale').click(function (e) {
        e.preventDefault();
        $('.modale').removeClass('opened');
    });

    // $(".modale").on("click", function(e){
    //     e.preventDefault();
    //     $(this).removeClass('opened');
    // })
});

function submitEmailFriend(event, t) {
    event.preventDefault();
    console.log($(t).serialize());
}