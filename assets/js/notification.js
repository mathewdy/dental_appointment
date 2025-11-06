fetch('http://localhost/dental_appointment/includes/notifications.php')
  .then(response => response.json())
  .then(data => {
    const notifContainer = document.getElementById('notif');
    const notifBadge = document.querySelector('.notification'); 
    notifContainer.innerHTML = '';

    if (data.total && data.total > 0) {
      notifBadge.textContent = data.total;
      notifBadge.style.display = 'inline-block';
    } else {
      notifBadge.style.display = 'none';
    }

    if (!data.notifications || data.notifications.length === 0) {
      notifContainer.innerHTML = '<p class="text-center text-muted">No notifications yet</p>';
      return;
    }

    data.notifications.forEach(notif => {
      const colorCode = {
        Payment: 'notif-success',
        Appointment: 'notif-primary'
      };
      const bgColor = colorCode[notif.type] || 'notif-secondary';

      const notifItem = `
        <a href="${notif.url}">
          <div class="notif-icon ${bgColor}">
            <i class="${notif.icon}"></i>
          </div>
          <div class="notif-content">
            <span class="block">${notif.message}</span>
            <span class="time">${notif.time}</span>
          </div>
        </a>
      `;
      notifContainer.innerHTML += notifItem;
    });
  })
  .catch(error => console.error('Error loading notifications:', error));
