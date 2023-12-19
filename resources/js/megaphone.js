document.addEventListener('alpine:init', () => {
    Alpine.data('notifications', (config={}) =>({
            unreadNotifications: 0,
            unreadCount: 0,
            isShowingFilterSection: false,
            receivedUnreadNotifications: [],
            notificationComponentWireId: null,

            init() {
                this.notificationComponentWireId = this.$el.getAttribute('wire:id');
                this.fetchNotifications();
                if(config.polling && config.pollInterval){
                    setInterval(() => {
                        this.fetchNotifications();
                    }, config.pollInterval);
                }else{
                    console.error('Poll interval not set. Notifications will not be polled for.');
                }
                this.$watch('receivedUnreadNotifications', (value) => {
                    this.unreadCount = value.length ;
                })
            },

            // Function to fetch new (unread) notifications from the server
            fetchNotifications() {
                fetch(config.pollRouteUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.unread_notifications) {
                            // Handle new notifications
                            data.unread_notifications.forEach(notification => {
                                if(!this.receivedUnreadNotifications.includes(notification)){
                                    window.Livewire.dispatch('refreshNotifications', {unread_notifications: data.unread_notifications});
                                    this.receivedUnreadNotifications.push(notification);
                                }
                            })
                        } else {
                            // No new notifications
                        }
                    })
                    .catch(error => console.error('Error fetching notifications:', error));
            },

            markAsRead(id){
                if(this.receivedUnreadNotifications.includes(id)){
                    this.receivedUnreadNotifications = this.receivedUnreadNotifications.filter(notification => notification !== id);
                    document.getElementById(`unread-notification-${id}`).style.opacity = 0.5;
                    window.Livewire.find(this.notificationComponentWireId).markAsRead(id);
                }
            },

            markAllAsRead() {
                this.receivedUnreadNotifications.forEach(notification => {
                    window.Livewire.find(this.notificationComponentWireId).call('markAsRead', notification);
                })
                this.receivedUnreadNotifications = [];
                window.Livewire.dispatch('refreshNotifications', {unread_notifications: this.unreadCount});
            },
        })
    );
})
