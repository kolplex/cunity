var msgxhr = null, selectedReceiver = new Array();
$(document).ready(function() {
    $(document).on("keydown", "#addReceiver", function(e) {
        var val = $(this).val();
        if (e.which === 13)
            e.preventDefault();
        else if (e.which === 8 && val.length === 0 && $(".receiver-token > .label").length > 0) {
            delete selectedReceiver[$(".receiver-token > .label:last").find("input[name='receiver[]']").val()];
            $(".receiver-token > .label:last").remove();

        } else
            $(this).width((1 + val.length) * 10);
        if (val.length + 1 > 1) {
            $("#receiver-suggestions-alert").hide();
            $("#receiver-suggestions-loader").show();
            if (msgxhr)
                msgxhr.abort();
            msgxhr = sendRequest({"q": val, "friends": true}, "search", "livesearch", function(res) {
                $("#receiver-suggestions-loader,#receiver-suggestions-alert").hide();
                if (typeof res.users !== "undefined") {
                    $("#receiver-suggestions").html("");
                    for (x in res.users) {
                        var user = res.users[x];
                        if (((user.privacy.message === 1 && user.status > 1) || user.privacy.message === 3) && typeof selectedReceiver[user.userid] == "undefined")
                            $("#receiver-suggestions").append(tmpl("message-modal-result", {userid: user.userid, name: user.name, profileImage: checkImage(user.pimg, "user", "cr_")}));
                    }
                }
                if ($("#receiver-suggestions .message-searchresult-item").length > 0)
                    $("#receiver-suggestions").show();
                else {
                    $("#receiver-suggestions").hide();
                    $("#receiver-suggestions-alert").show();
                }
            });
        } else
            $("#receiver-suggestions").hide();
    }).on("click", ".receiver-token > .label > .close", function() {
        delete selectedReceiver[$(this).siblings("input[name='receiver[]']").val()];
        $(this).parent(".label").remove();
    }).on("click", ".receiver-content", function() {
        $(this).find(".receiver-input").focus();
    }).on("keyup", ".message-content", function() {
        var val = $(this).val();
        if (val.length > 0)
            $("#sendmessagebutton").removeProp("disabled");
        else
            $("#sendmessagebutton").prop("disabled");
    });
    $("#messages_modal").on("shown.bs.modal", function() {
        $("#addReceiver").focus();
    });
    $("#messages_modal").on("hidden.bs.modal", function() {
        $(".closemodalbutton").removeClass("btn-primary");
        $(".messagesentmessage").hide();
        $("#sendMessageForm").show();
        $("#sendmessagebutton").show();
        $("#receiver-suggestions-alert").show();
        $(".receiver-token").html("");
        $(".message-content,.receiver-input").val("");
        selectedReceiver = new Array();
    });
});

function addReceiver(userid, name) {
    $(".receiver-token").append(tmpl("receiver-tpl", {name: name, userid: userid}));
    $("#addReceiver").width(10).val("");
    $("#receiver-suggestions").hide().html("");
    selectedReceiver[userid] = 1;
}

function sendMessage(name, userid) {
    $(".receiver-token").html(tmpl("receiver-tpl", {name: name, userid: userid}));
    $("#messages_modal").modal('show');
    selectedReceiver[userid] = 1;
}

function messageSent(result) {
    if (result.status === false)
        $(".messagefailedmessage").show();
    else
        $(".messagesentmessage").show();
    $("#sendMessageForm").hide();
    $("#sendmessagebutton").button('reset').hide();
    $(".closemodalbutton").addClass("btn-primary");
    if (typeof loadConversations == "function")
        loadConversations();
}