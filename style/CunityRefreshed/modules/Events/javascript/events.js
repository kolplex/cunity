var currentDate = "NOW", currentTime = "", calendar = null;
$(document).ready(function() {
    $("#createEvent").on("shown.bs.modal", function() {
        $('#createEvent .input-group.date').datepicker({
            startDate: "now",
            autoclose: true,
            todayHighlight: true
        });
        $("#createEvent .input-group.time > input[type='text']").timepicker({
            template: false,
            showInputs: false,
            showMeridian: false
        });
    });
    $("#createEvent .input-group.date").on("changeDate", function(e) {
        currentDate = e.format(0, "yyyy-mm-dd");
        $("#startDate").val(currentDate + ' ' + currenTime);
    });
    $("#createEvent .input-group.time > input[type='text']").on("changeTime.timepicker", function(e) {
        currenTime = e.time.hours + ':' + e.time.minutes + ':00';
        $("#startDate").val(currentDate + ' ' + currenTime);
    });

    calendar = $("#calendar").calendar({
        tmpl_path: siteurl + "style/CunityRefreshed/modules/events/tmpls/",
        events_source: convertUrl({module: "events", action: "loadEvents"}),
        onAfterViewLoad: function(view) {
            $('.calendar-month').text(this.getTitle());
        }
    });

    $('.calendar-head button[data-calendar-nav]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.navigate($this.data('calendar-nav'));
        });
    });
    $(".cal-month-day,.cal-month-day-has-event span[data-cal-date]").unbind();
    $(document).on("click", ".cal-month-day span[data-cal-date]", function() {
        var el = $(this);
        if (el.data("events") == 0)
            bootbox.alert("No Events planned on this date!");
        else {
            var date = new Date($(this).data("cal-date"));
            var start = new Date(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);
            var end = parseInt(start.getTime() + 86400000);
            console.log(calendar.getEventsBetween(parseInt(start.getTime()), end));
        }
    });
}); 