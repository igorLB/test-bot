var $cont = $(".conversation");
$cont[0].scrollTop = $cont[0].scrollHeight;

$(document).on("submit", "#conversation", function (e) {
    e.preventDefault();

    const formAction = $(this).attr("action");
    const form = new FormData();

    let message = $("#userInput").val();

    let msgBlock =
        "<div class='user-baloon-container'><p class='user-baloon'>" +
        message +
        "</p></div>";

    $(".conversation").append(msgBlock);
    $cont[0].scrollTop = $cont[0].scrollHeight;

    $("#botStatus").text("Digitando...");

    form.append("driver", "web");
    form.append("userId", "123543");
    form.append("message", message);
    form.append("attachment", "null");
    form.append("interactive", "0");

    $.ajax({
        url: formAction,
        method: "POST",
        dataType: "json",
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: form,
        success: function (response) {
            let { messages } = response;

            const milliseconds = messages.length * 1300;

            messages.map(function (msg) {
                let msgBlock =
                    "<div class='bot-baloon-container'><p class='bot-baloon'>" +
                    msg.text +
                    "</p></div>";

                $(".conversation")
                    .delay(1300)
                    .queue(function (next) {
                        $(this).append(msgBlock);
                        $cont[0].scrollTop = $cont[0].scrollHeight;
                        next();
                    });
            });

            setTimeout(function () {
                $("#botStatus").text("Online");
            }, milliseconds);

            $("#userInput").val("");
        },
    });
});
