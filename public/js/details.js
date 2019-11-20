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
    var data = $(t).serialize();

    var user_name = $("input[name='name']").val();
    var email = $("input[name='friends_name']").val();

    if (user_name === "") {
        $("#error-status").html("<br />Please enter your name !").fadeOut(3500);
        return;
    }

    if (user_name.length < 2) {
        $("#error-status").html("<br />Your name should contain at least 2 characters !").fadeOut(3500);
        return;
    }

    if (email === "") {
        $("#error-status").html("<br />Please enter your email !").fadeOut(3500);
        return;
    }

    if (email.match("^\S+@\S+$")) {
        $("#error-status").html("<br />Please enter a valid email !").fadeOut(3500);
        return;
    }

    $.ajax({
        type: "GET",
        data: { fdata: data },
        url: "/sendemailfriend",
        beforeSend: function () {
            $(".email-friend-loader").css("display", "inline-block");
        },
        success: function (response) {
            $(".email-friend-loader").hide();
            $('#form').trigger("reset");
            $("#status").html('<br />Post emailed successfully!').fadeOut(5000);
        }
    })
}