$(document).ready(function() {
    loadBoards();
    loadCategoryCloud();
});

function loadBoards() {
    $("#forum-loader").show();
    sendRequest({id: $("#forum_id").val()}, "forums", "loadBoards", function(res) {
        $("#forum-loader").hide();
        if (typeof res.result !== "undefined" && res.result !== null) {
            for (var x in res.result)
                $("#boards").append(tmpl("board-template", res.result[x]));
        }
        if ($("#boards .topic-post").length === 0)
            $("#boards .alert").show();
        else
            $("#boards .alert").hide();
    });
}

function boardCreated(res) {
    $("#boards").prepend(tmpl("board-template", res.board));
    $("#boards .alert").hide();
}

function forumUpdated() {
    location.reload();
}

function deleteForum() {
    bootbox.confirm("Are You sure You want to delete this forum and all board, threads and posts which belongs to it?", function(r) {
        if (r) {
            sendRequest({id: $("#forum_id").val()}, "forums", "deleteForum", function(res) {
                location.href = convertUrl({"module": "forums"});
            });
        }
    });
}