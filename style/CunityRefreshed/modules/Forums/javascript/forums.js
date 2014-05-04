$(document).ready(function() {
    loadForums();
    loadCategoryCloud();
});

function loadForums() {
    sendRequest({}, "forums", "loadForums", function(res) {
        if (typeof res.result !== "undefined" && res.result !== null) {
            for (var x in res.result) {
                var boards = "";
                for (var y in res.result[x].boards)
                    boards += tmpl("board-template", res.result[x].boards[y]);
                if (res.result[x].boards.length > res.result[x].boardcount)
                    $("#forum-" + res.result[x].id + " .loadmoreboards").show();
                res.result[x].boards = boards;
                $("#forums").append(tmpl("forum-template", res.result[x]));
                if (boards === "")
                    $("#forum-" + res.result[x].id + " .noboards").show();
            }
            if($("#forums .forum").length === 0)
                $("#no-result").show();
        }
    });
}

function forumCreated(res) {
    $("#no-result").hide();
    $("#forums").append(tmpl("forum-template", res.forum));
    $("#forum-" + res.forum.id + " .noboards").show();
    $("#createForumForm")[0].reset();
}