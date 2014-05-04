$(document).ready(function() {
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        $(this).siblings().removeClass("active");
        $(e.target).addClass("active");
    });
});