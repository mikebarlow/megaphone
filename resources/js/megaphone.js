document.addEventListener('alpine:init', () => {
    Alpine.data('notifications', (config={}) =>({
            unreadNotifications: 0,
            isShowingFilterSection: false,
            receivedUnreadNotifications: [],
             // Used to store the expanded notifications. That is rather than just storing the notification ID, we store the whole notification object
             // This is because we need to store the notification object for some manipulations.
            receivedUnreadNotificationsExpanded: [],
            error: null,
            notificationComponentWireId: null,
            isShowingFilterSection: false,
            filterType: null,

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
            },

            // Function to fetch new (unread) notifications from the server
            fetchNotifications() {
                fetch(config.pollRouteUrl+'?notifiable='+config.notifiable, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': config.csrfToken,
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.data.unread_notifications.length > 0) {
                            // Handle new notifications
                            data.data.unread_notifications.forEach(notification => {
                                if(!this.receivedUnreadNotifications.includes(notification)){
                                    window.Livewire.dispatch('refreshNotifications', {unread_notifications: data.unread_notifications});
                                    this.receivedUnreadNotifications.push(notification);
                                }
                            })
                        } else {
                            // No new notifications
                        }
                        if(data.error){
                            console.error(data.error);
                            this.error = data.error;
                        }
                    })
                    .finally(() => {
                        if(!this.areArraysInSync()){
                            this.expandReceivedUnreadNotifications()
                        }
                    })
                    .catch(error => console.error('Error fetching notifications:', error));
            },
            // Convert the notification IDs to notification objects and store them in the expanded array
            expandReceivedUnreadNotifications() {
                return new Promise((resolve, reject) => {
                    Promise.all(
                        this.receivedUnreadNotifications.map(notificationId =>
                            window.Livewire.find(this.notificationComponentWireId).findNotification(notificationId)
                        )
                    )
                    .then(receivedUnreadNotificationsExpanded => {
                        this.receivedUnreadNotificationsExpanded = receivedUnreadNotificationsExpanded;
                        resolve(this.receivedUnreadNotificationsExpanded);
                    })
                    .catch(error => {
                        console.error(error);
                        reject(error);
                    });
                });
            },

            // Check if the receivedUnreadNotifications and receivedUnreadNotificationsExpanded arrays are in sync
            // by looping through the unread notifications and checking if the notification ID is in the expanded array
            // (i.e. the notification has been expanded)
            areArraysInSync() {
                return this.receivedUnreadNotifications.every(notification => {
                    return this.receivedUnreadNotificationsExpanded.find(
                        notificationExpanded => notificationExpanded.id === notification
                    );
                });
            },

            // Get the number of unread notifications

            getUnreadCount(filterType = null){
                if(filterType === null){
                    return this.receivedUnreadNotifications.length;
                }
                const filteredUnreadNotifs = this.receivedUnreadNotificationsExpanded.filter(notification => {
                    return notification.type === filterType;
                })

                return filteredUnreadNotifs.length;
            },

            markAsRead(id){
                if(this.receivedUnreadNotifications.includes(id)){
                    this.receivedUnreadNotifications = this.receivedUnreadNotifications.filter(notification => notification !== id);
                    document.getElementById(`unread-notification-${id}`).style.opacity = 0.5;
                    window.Livewire.find(this.notificationComponentWireId).markAsRead(id);
                }
            },

            markAllAsRead() {
                this.receivedUnreadNotifications = [];
                window.Livewire.find(this.notificationComponentWireId).call('markAllAsRead', notification);
                window.Livewire.dispatch('refreshNotifications', {unread_notifications: []});
            },

            shouldShowNotification(notification){
                if(
                    this.filterType === null ||
                    this.filterType === notification.type
                ){
                    return true;
                }
                return false;

            },

            filterByType(type){
                this.filterType = type;
                this.isShowingFilterSection = false;
                this.expandReceivedUnreadNotifications(); // essential to update the unread count
            }
        })
    );
})
