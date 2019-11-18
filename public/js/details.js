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
    var c = $(t).serialize();
    
    $.get(
        "/sendemailfriend", {
            fdata: c
        },
        function (data) {
            data = data.trim();
            if(data === "1"){
                $('#form').trigger("reset");
                $("#status").html('<br />Post emailed successfully!').fadeOut(5000);
            }
        }
    );

}