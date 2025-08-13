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
                    const colorCode = {
                        Payment: 'notif-success',
                        Appointment: 'notif-primary'
                    }
                    const bgColor = colorCode[notification.type] || 'notif-secondary';

                    $('#notif').append(`    
                        <a href="${notification.url}">
                            <div class="notif-icon ${bgColor}">
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
            });
            
        } else {
            return null
        }

    },
    error: null
})