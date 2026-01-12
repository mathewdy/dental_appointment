document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");
    if (calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: '',
                center: 'title',
                right: ''
            },
            footerToolbar: {
                left: '',
                center: 'prev,next today',
                right: ''
            },
            initialView: "dayGridMonth",
            themeSystem: "standard",
            events: "../../includes/events/events.php",
            dateClick: function (info) {

                const clickedDate = info.dateStr;
                const eventsOnDate = calendar.getEvents().filter(event =>
                    event.startStr.startsWith(clickedDate));
                var prompt = new bootstrap.Modal(document.getElementById("appointmentInfo"))
                prompt.show()
                $.ajax({
                    url: "../../includes/events/event-info.php",
                    type: "POST",
                    data: { date: clickedDate },
                    success: function (res) {
                        document.getElementById("appointment_info").innerHTML = res
                    }
                })
            }
        });
        calendar.render();
    }
});