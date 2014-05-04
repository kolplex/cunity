$(document).ready(function() {
    $.getJSON(siteurl + "data/resources/fontawesome-icons.json", function(data) {
        for (x in data)
            $("#select-icon-menu").append('<li><a href="javascript:selectIcon(\'' + data[x] + '\');"><i class="fa fa-fw fa-' + data[x] + '"></i>&nbsp;' + data[x] + '</a></li>');
    });
    $(".sortable-list").sortable({
        connectWith: ".sortable-list",
        items: ".list-group-item",
        placeholder: "sortable-list-group-item list-group-item",
        cursor: "move",
        update: function() {

        }
    });

    sendRequest({action: "loadPages"}, "admin", "settings", function(res) {
        if (res.pages !== null && res.pages.length > 0)
            for (x in res.pages)
                $("#menu-add-pages > .list-group").append(tmpl("pages-list-item", res.pages[x]));
    });

});

function addMainItem(type, content, title) {
    $("#main-menu-list").append(tmpl("menu-item", {type: type, content: content, title: title}))
}

function addFooterItem(type, content, title) {
    $("#footer-menu-list").append(tmpl("menu-item", {type: type, content: content, title: title}))
}