document.addEventListener('DOMContentLoaded', function () {
    const icon = document.getElementById('notification-icon');
    const dropdown = document.getElementById('notif-dropdown');
    const list = document.getElementById('notif-list');
    const indicator = document.getElementById('notif-indicator');

    async function fetchNotifications() {
        const res = await fetch('/notifications/unread');
        const data = await res.json();

        // Affiche ou cache le rond rouge
        if (data.length > 0) {
            indicator.classList.remove('hidden');
        } else {
            indicator.classList.add('hidden');
        }

        // Nettoie et affiche la liste
        list.innerHTML = '';
        if (data.length === 0) {
            list.innerHTML = '<li class="p-4 text-sm text-gray-500">Aucune notification</li>';
        } else {
            data.forEach(notif => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <a href="${notif.data.url}" class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-800">
                        ${notif.data.message}
                    </a>
                `;
                list.appendChild(li);
            });
        }
    }

    // Clique sur la cloche
    icon.addEventListener('click', function () {
        dropdown.classList.toggle('hidden');
        fetchNotifications(); // Recharge les notifications à l’ouverture
    });

    // Optionnel : actualiser toutes les X secondes
    setInterval(fetchNotifications, 60000); // toutes les 60s
});



function fetchNotifications() {
    fetch('/notifications')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('notifications');
            container.innerHTML = '';

            data.notifications.forEach(notif => {
                const div = document.createElement('div');
                div.className = 'bg-yellow-100 p-2 mb-1 rounded text-sm';
                div.textContent = notif.message;
                container.appendChild(div);
            });

            if (data.notifications.length > 0) {
                document.getElementById('notification-icon').classList.add('text-red-500');
            } else {
                document.getElementById('notification-icon').classList.remove('text-red-500');
            }
        });
}

setInterval(fetchNotifications, 5000); // appel toutes les 5 secondes
fetchNotifications(); // appel initial
