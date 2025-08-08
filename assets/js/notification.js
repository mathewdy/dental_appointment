$.ajax({
    url: "../../includes/notifications.php",
    type: "GET",
    dataType: "json",
    success: function(res) {
        if (Array.isArray(res)) {
            let totalCount = 0;

            $.each(res, function(index, notificationGroup) {
                totalCount += notificationGroup.count[0];  

                $.each(notificationGroup.data, function(i, notification) {
                    $('#notif').append(`
                        <a href="#">
                            <div class="notif-icon notif-primary">
                                <i class="${notification.icon}"></i>
                            </div>
                            <div class="notif-content">
                                <span class="block">${notification.message}</span>
                                <span class="time">${notification.time}</span>
                            </div>
                        </a>
                    `);
                });
                
                if (totalCount > 0) {
                    $('#notifDropdown').append(`
                        <span class="notification bg-danger">${totalCount}</span>
                    `);
                }
                // $('#notifDropdown').append(`
                //     <span class="notification bg-danger" style="width: 8px !important;">${totalCount}</span>
                // `)
            });
            
        } else {
            return null
        }

    },
    error: null
})