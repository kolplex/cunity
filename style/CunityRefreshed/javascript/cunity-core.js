var origShow = jQuery.fn.show, origHide = jQuery.fn.hide;
jQuery.fn.show = function() {
    $(this).removeClass("hidden");
    return origShow.apply(this, arguments);
};
jQuery.fn.hide = function() {
    $(this).addClass("hidden");
    return origHide.apply(this, arguments);
};

$.ajaxSetup({
    cache: false
});

function onBlur() {
    document.body.className = 'blurred';
}
function onFocus() {
    document.body.className = 'focused';
}

function getNotification(type) {
    sendRequest({type: type}, "notifications", "get", function(res) {
        $("#notification-dropdown").html(function() {
            var str = "";
            if (type !== "messages") {
                if (res.result !== null && typeof res.result !== "undefined" && res.result.length > 0) {
                    for (x in res.result)
                        str += tmpl("notification-" + type, res.result[x]);
                } else
                    str = tmpl("notification-empty", {});
                return str;
            } else if (type === "messages") {
                if (res.conversations !== null && typeof res.conversations !== "undefined" && res.conversations.length > 0) {
                    $.getJSON(siteurl + "style/" + design + "/img/emoticons/emoticons.json", function(data) {
                        smileys = new Array();
                        for (x in data)
                            smileys[data[x]] = '<img src="' + siteurl + 'style/' + design + '/img/emoticons/' + data[x] + '.png" class="message-smiley" data-key="' + data[x] + '">';
                        for (con in res.conversations) {
                            var c = res.conversations[con], i = 0, image = null;
                            if (c.users !== null && typeof c.users === "string") {
                                us = c.users.split(","), userstring = "";
                                for (user in us) {
                                    if (i === 2) {
                                        userstring += ", +" + (us.length - 2);
                                        break;
                                    }
                                    var tmp = us[user].split("|");
                                    userstring += ", " + tmp[0];
                                    i++;
                                }
                                userstring = userstring.substr(2);
                            } else if (c.users !== null & typeof c.users === "object") { // there is only one user                    
                                userstring = c.users.name;
                                image = c.users.pimg;
                            } else
                                userstring = "None";
                            c.message = c.message.substr(0, 35);
                            for (x in smileys)
                                c.message = replaceAll('[:' + x + ':]', smileys[x], c.message);

                            str += tmpl("notification-messages", {name: userstring, message: c.message, conversation: c.conversation, sendername: c.sendername, time: c.time, image: checkImage(image, "users", "cr_")});
                        }
                        $("#notification-dropdown").html(str);
                        return;
                    });
                } else
                    return tmpl("notification-empty", {});
            }
        }).removeClass("notification-messages notification-friends notification-general").addClass("notification-" + type).show();
    });
}

function sendRequest(requestData, module, action, callback) {
    if (typeof requestData !== "undefined") {
        return $.ajax({
            url: convertUrl({module: module, action: action}),
            dataType: "json",
            data: requestData,
            type: 'POST',
            success: function(data) {
                if (typeof data.session !== "undefined" && data.session === 0) {
                    alert("Your session is timed out! Please login again!");
                    location.href = convertUrl({module: "start"});
                } else if (data.status == false) {
                    if (typeof data.msg == "undefined")
                        data.msg = "Error";
                    bootbox.alert(data.msg);
                } else if (typeof callback == 'function') {
                    callback(data);
                    refreshTime();
                }
            }
        });
    }
    return null;
}

function convertUrl(data) {
    if (modrewrite) {
        var str = siteurl + data.module;
        if (typeof data.action !== "undefined" && data.action !== null)
            str += "/" + data.action;
        if (typeof data.x !== "undefined" && data.x !== null)
            str += "/" + data.x;
        if (typeof data.y !== "undefined" && data.y !== null)
            str += "/" + data.y;
        return str;
    } else {
        var str = siteurl + "index.php?m=" + data.module;
        if (typeof data.action !== "undefined" && data.x !== null)
            str += "&action=" + data.action;
        if (typeof data.x !== "undefined" && data.x !== null)
            str += "&x=" + data.y;
        if (typeof data.y !== "undefined" && data.x !== null)
            str += "&y=" + data.y;
        return str;
    }
}

function checkImage(filename, type, prefix) {
    prefix = (typeof prefix === "undefined") ? "" : prefix;
    if (filename === null || typeof filename === "undefined" || filename.length === 0)
        return siteurl + 'style/' + design + '/img/placeholders/noimg-' + type + '.png';
    return prefix + filename;
}
function getErrorMessage(tplname) {
    return tmpl(tplname, {});
}

function like(ref_name, ref_id, callback) {
    sendRequest({"ref_name": ref_name, "ref_id": ref_id}, "likes", "like", callback);
}

function dislike(ref_name, ref_id, callback) {
    sendRequest({"ref_name": ref_name, "ref_id": ref_id}, "likes", "dislike", callback);
}

function unlike(ref_name, ref_id, callback) {
    sendRequest({"ref_name": ref_name, "ref_id": ref_id}, "likes", "unlike", callback);
}

function comment(ref_name, ref_id, content, callback) {
    sendRequest({"ref_name": ref_name, "ref_id": ref_id, "content": content}, "comments", "add", callback);
}

function deleteComment(comment_id) {
    bootbox.confirm("Are You sure you want to delete this comment?", function(r) {
        if (r) {
            sendRequest({"comment_id": comment_id}, "comments", "remove", function() {
                $("#comment-" + comment_id).remove();
            });
        }
    });

}

function getLikes(refname, refid, dislike, title) {
    sendRequest({"ref_name": refname, "ref_id": refid, "dislike": dislike}, "likes", "get", function(res) {
        if (typeof res.likes !== "undefined" && res.likes.length > 0) {
            bootbox.dialog({
                message: function() {
                    var msg = "";
                    for (x in res.likes)
                        msg += tmpl("like-list", res.likes[x]);
                    return '<div class="likesmodalbox">' + msg + '</div>';
                },
                title: title,
                buttons: {
                    main: {
                        label: "Ok",
                        className: "btn-primary"
                    }
                },
                className: "likelistmodal"
            });
        }
    });
}

function refreshTime() {
    $(".timestring").each(function() {
        var el = $(this);
        el.replaceWith(function() {
            return convertDate(el.data("source"));
        });
    });
    $(".tooltip").remove();
    $(".tooltip-trigger").tooltip({
        container: 'body'
    });
}

function convertDate(timestring) {
    if (typeof timestring == "undefined" || timestring === "" || timestring === null)
        return "NaN";
    var now = new Date();
    var then = new Date(timestring.replace(/-/g, '/'));
    var r = "";
    then.setMinutes(then.getMinutes() + now.getTimezoneOffset() * (-1));
    var since = Math.round((now.getTime() - then.getTime()) / 1000);
    var chunks = [
        [22896000, 'year'],
        [2592000, 'month'],
        [604800, 'week'],
        [86400, 'day'],
        [3600, 'hour'],
        [60, 'minute']
    ];
    if (since < 60)
        r = "just now";
    else {
        var count;
        for (i = 0, j = chunks.length; i < j; i++) {
            seconds = chunks[i][0];
            name = chunks[i][1];
            count = Math.floor(since / seconds);
            if (count !== 0)
                break;
        }
        r = ((count === 1) ? '1 ' + name : count + " " + name + "s") + " ago";
    }
    return '<span class="tooltip-trigger timestring" data-source="' + timestring + '" data-title="' + then.toLocaleString() + '">' + r + '</span>';
}

function escapeRegExp(string) {
    return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}

function replaceAll(find, replace, str) {
    return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

$(document).ready(function() {

    if (/*@cc_on!@*/false) { // check for Internet Explorer
        document.onfocusin = onFocus;
        document.onfocusout = onBlur;
    } else {
        window.onfocus = onFocus;
        window.onblur = onBlur;
    }
    $(".sidebar").css("minHeight", window.innerHeight - 101);
    $('input.filefakeinput').change(function() {
        $($(this).data("rel")).val($(this).val());
    });

    $('.dropdown-menu').on('click', function(e) {
        if ($(this).hasClass('dropdown-checkbox-menu')) {
            e.stopPropagation();
        }
    });

    $('.btn[data-loading-text]').click(function() {
        $(this).button('loading');
    });

    $("a[href=\"#\"],a[href=\"\"]").click(function(e) {
        e.preventDefault();
    });

    $("#mobile-slide-nav > .mobile-menu").html($(".main-menu > .nav").html());

    $(document).on("click", "#menu-trigger", function() {
        if (login) {
            if ($("body").hasClass("menu-active"))
                $("body").removeClass("menu-active");
            else
                $("body").addClass("menu-active");
        } else
            location.href = convertUrl({module: "start"});
    }).on("mouseenter", ".notification-general-item:not(.read)", function() {
        var el = $(this);
        sendRequest({id: el.data("id")}, "notifications", "markRead", function() {
            el.addClass("read");
            el.find(".label-new").fadeOut("slow");
        });
    });

    if (login) {
        //Load unread messages badge
        sendRequest({type: "messages"}, "notifications", "get", function(res) {
            if (typeof res.conversations !== "undefined" && res.conversations.length > 0) {
                $(".main-menu-item-messages > a > .badge").html(res.conversations.length);
                $(".notification-link-messages").addClass("active");
            } else
                $(".notification-link-messages").removeClass("active");
        });
        sendRequest({type: "friends"}, "notifications", "get", function(res) {
            if (typeof res.result !== "undefined" && res.result !== null && res.result.length > 0) {
                $(".main-menu-item-friends > a > .badge").html(res.result.length);
                $(".notification-link-friends").addClass("active");
            } else
                $(".notification-link-friends").removeClass("active");
        });

        sendRequest({type: "general"}, "notifications", "get", function(res) {
            if (res.new > 0)
                $(".notification-link-general").addClass("active");
            else
                $(".notification-link-general").removeClass("active");
        });
    }

    $(document).on("click", "a.close", function(e) {
        e.stopPropagation();
    });

    $(document).on("submit", "form.ajaxform", function(e) {

        e.preventDefault();
        var form = $(this);
        form.find("input[type='submit'],button[type='submit']").button('loading');
        if (form.prop("ajaxform-send") === true)
            return;
        if (form.attr("enctype") === "multipart/form-data") {
            var name = "ajaxformframe" + Math.random();
            var frame = $("<iframe/>", {"name": name, class: "hidden"}).appendTo(form);
            form.attr("target", name).prop("ajaxform-send", true).submit();
            frame.on("load", function() {
                form.find("input[type='submit'],button[type='submit']").button('reset');
                if (form.find(".ajaxform-callback").length > 0) {
                    console.log(frame.contents().find('body').html());
                    var callback = window[form.find(".ajaxform-callback").val()];
                    if (typeof callback === "function")
                        callback(jQuery.parseJSON(frame.contents().find('body').html()));
                }
            });
        } else {
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                dataType: "json"
            }).done(function(data) {
                form.find("input[type='submit'],button[type='submit']").button('reset');
                if (form.find(".ajaxform-callback").length > 0) {
                    var callback = window[form.find(".ajaxform-callback").val()];
                    if (data.status === false) {
                        bootbox.alert(data.msg);
                    } else if (typeof callback === "function")
                        callback(data);
                }
            });
        }
    }).on("click", function(e) {
        if ($(e.target).attr("id") !== "notification-dropdown" && $("#notification-dropdown").length > 0)
            $("#notification-dropdown").hide();
    });

    $("#infoModal").on('show.bs.modal', function(e) {
        $("#infoModal").find(".modal-title").html($(e.relatedTarget).data("title"));
        if (typeof $(e.relatedTarget).data("href") !== "undefined")
            $("#infoModal").find(".modal-body").html('<iframe src="' + $(e.relatedTarget).data("href") + '" style="border:0;width:100%"></iframe>').css("padding", 10);
    });

    $("*[data-moveto]").each(function() {
        $(this).appendTo($(this).data("moveto")).removeAttr("data-moveto");
    });
});