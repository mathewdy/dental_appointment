<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/config.php');
echo '
<script src="' . BASE_PATH . '/assets/js/core/jquery-3.7.1.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/core/popper.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/core/bootstrap.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/plugin/chart.js/chart.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/plugin/datatables/datatables.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/plugin/jsvectormap/world.js"></script>
<script src="' . BASE_PATH . '/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/kaiadmin.min.js"></script>
<script src="' . BASE_PATH . '/assets/js/datatable-init.js"></script>
<script src="' . BASE_PATH . '/libs/fullcalendar/index.global.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var calendarEl = document.getElementById("calendar");
        var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        themeSystem: "standard",
        events: "'. BASE_PATH .'/includes/events.php",
        dateClick: function(info) {
            const clickedDate = info.dateStr;        
            const eventsOnDate = calendar.getEvents().filter(event=>
            event.startStr.startsWith(clickedDate));  
            if(eventsOnDate.length === 0){
                var prompt = new bootstrap.Modal(document.getElementById("doctorModal"))
                prompt.show()
            }else{
                var offCanvas = new bootstrap.Offcanvas(document.getElementById("infoPanel"))
                offCanvas.show()

                $.ajax({
                    url: "event-info.php",
                    type: "POST",
                    data: {date : clickedDate},
                    success: function(res){
                        document.getElementById("appointment_info").innerHTML = res
                        console.log(clickedDate)
                    }
                })
            }
        }
    });
    calendar.render();
});
</script>
';
?>