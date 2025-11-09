$(document).ready(function() {
    const $notifContainer = $('#notif');
    const $notifBadge = $('.notification');

    function timeAgo(datetime) {
        const now = new Date();
        const time = new Date(datetime);
        const diff = Math.floor((now - time) / 1000);

        const units = [
            { name: 'year',   value: 31553280 },
            { name: 'month',  value: 2629440 },
            { name: 'week',   value: 604800 },
            { name: 'day',    value: 86400 },
            { name: 'hour',   value: 3600 },
            { name: 'minute', value: 60 },
            { name: 'second', value: 1 }
        ];

        for (let unit of units) {
            if (diff >= unit.value) {
                const count = Math.floor(diff / unit.value);
                return `${count} ${unit.name}${count > 1 ? 's' : ''} ago`;
            }
        }
        return 'Just now';
    }

    function loadNotifications() {
        $.ajax({
            url: 'http://localhost/dental_appointment/includes/notifications.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $notifContainer.empty();
                data.notifications.sort((a, b) => a.read - b.read);
                const totalUnread = data.notifications.filter(n => n.read == 0).length;

                if (totalUnread > 0) {
                    $notifBadge.text(totalUnread).show();
                } else {
                    $notifBadge.hide();
                }

                if (!data.notifications || data.notifications.length === 0) {
                    $notifContainer.html('<p class="text-center text-muted mt-3">No notifications yet</p>');
                    return;
                }

                $.each(data.notifications, function(_, notif) {
                    const colorCode = {
                        Payment: 'notif-success',
                        Appointment: 'notif-primary'
                    };
                    const bgColor = colorCode[notif.type] || 'notif-secondary';
                    const unreadClass = notif.read == 0 ? 'notif-unread' : '';

                    const $notifItem = $(`
                        <a href="${notif.url}" class="notif-item ${unreadClass}" data-id="${notif.trans}">
                            <div class="notif-icon ${bgColor}">
                                <i class="${notif.icon}"></i>
                            </div>
                            <div class="notif-content">
                                <span class="block">${notif.message}</span>
                                <span class="time">${timeAgo(notif.datetime)}</span>
                            </div>
                        </a>
                    `);

                    $notifItem.on('click', function(e) {
                        e.preventDefault();
                        const id = $(this).data('id');

                        $.ajax({
                            url: 'http://localhost/dental_appointment/includes/mark-read.php',
                            method: 'POST',
                            data: { id: id },
                            dataType: 'json',
                            success: function(response) {
                                $notifBadge.text(response.total > 0 ? response.total : '').toggle(response.total > 0);
                                window.location.href = notif.url;
                            },
                            error: function() {
                                console.error('Error marking notification as read');
                            }
                        });
                    });

                    $notifContainer.append($notifItem);
                });
            },
            error: function() {
                console.error('Error loading notifications');
            }
        });
    }

    loadNotifications();
    setInterval(loadNotifications, 30000);
});
