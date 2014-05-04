function loadChat() {
    sendRequest({}, "friends", "loadOnline", function(data) {        
//        if (data.result === null || data.result.length === 0)
//            $("#friendslist > .list").html(getErrorMessage('nofriends'));
//        else
            for (x in data.result)
                $("#chat-container > .chat-list").prepend(tmpl("onlinefriends", data.result[x]));
    });
}

$(document).ready(function(){
    loadChat();
});