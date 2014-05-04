var smileys = new Object();
$(document).ready(function() {
    loadCategoryCloud();
    $.getJSON(siteurl + "style/" + design + "/img/emoticons/emoticons.json", function(data) {
        for (x in data) {
            $("#thread-new-emoticons > div").append('<img src="' + siteurl + 'style/' + design + '/img/emoticons/' + data[x] + '.png" data-key="' + data[x] + '" class="emoticon-select">');
            smileys[data[x]] = '<img src="' + siteurl + 'style/' + design + '/img/emoticons/' + data[x] + '.png" class="message-smiley" data-key="' + data[x] + '">';
        }
    });

    $("#thread-new-emoticon-button").popover({
        html: true,
        container: 'body',
        content: function() {
            return $("#thread-new-emoticons > div").html();
        }
    });

    $("#summernote-startThread").summernote({
        height: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']]
                    //['insert', ['picture', 'link']]
        ],
        onblur: function(e) {
            $("#startThreadForm input[name='content']").val($("#summernote-startThread").code());
        },
        oninit: function() {
            $("#summernote-newpost").code("");
        }
    });
    loadThreads();
});

function sendThreadForm() {
    $("#startThreadForm input[name='content']").val($("#summernote-startThread").code());
    $("#startThreadForm").submit();
}

function threadStarted(res) {
    location.href = convertUrl({module: "forums", action: "thread", x: res.id});
}

function loadThreads() {
    $("#board-loader").show();
    sendRequest({id: $("#board_id").val()}, "forums", "loadThreads", function(res) {
        $("#board-loader").hide();
        if (typeof res.result !== "undefined" && res.result !== null) {
            for (var x in res.result)
                $("#threads").append(tmpl("thread-template", res.result[x]));
        }
        if ($("#threads .topic-post").length === 0)
            $("#threads .alert").show();
        else
            $("#threads .alert").hide();
    });
}

function boardUpdated() {
    location.reload();
}

function deleteBoard() {
    bootbox.confirm("Are You sure You want to delete this board and all threads and posts which belongs to it?", function(r) {
        if (r) {
            sendRequest({id: $("#board_id").val()}, "forums", "deleteBoard", function(res) {
                location.href = convertUrl({"module": "forums"});
            });
        }
    });
}