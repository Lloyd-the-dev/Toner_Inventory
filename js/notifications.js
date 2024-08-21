document.addEventListener('DOMContentLoaded', function() {
    fetchNotifications();
});

function fetchNotifications() {
    fetch('fetchNotifications.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('notificationContainer');
            container.innerHTML = ''; 

            data.notifications.forEach(notification => {
                const notificationDiv = document.createElement('div');
                notificationDiv.className = 'notification-item';
                
                notificationDiv.innerHTML = `
                    <p>${notification.notification_content}</p>
                    <button class="btn-clear" onclick="clearNotification(${notification.notification_id})">Clear</button>
                `;
                
                container.appendChild(notificationDiv);
            });
        })
        .catch(error => console.error('Error fetching notifications:', error));
}

function clearNotification(notificationId) {
    fetch(`clearNotification.php?id=${notificationId}`, { method: 'POST' })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                document.querySelector(`.notification-item button[onclick="clearNotification(${notificationId})"]`).parentElement.remove();
            } else {
                alert('Failed to clear notification.');
            }
        })
        .catch(error => console.error('Error clearing notification:', error));
}
