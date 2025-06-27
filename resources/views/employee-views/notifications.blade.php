@extends('layouts.user')

@section('title')
    Notifications | Laravel Employés App
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-bell text-primary mr-2"></i>
                        Notifications
                    </h1>
                    <p class="text-muted mb-0">Gérez vos notifications et restez informé</p>
                </div>
                <div class="d-flex">
                    <button class="btn btn-outline-primary mr-2" onclick="markAllAsRead()">
                        <i class="fas fa-check-double mr-1"></i>Tout marquer comme lu
                    </button>
                    <button class="btn btn-outline-danger" onclick="clearAllNotifications()">
                        <i class="fas fa-trash mr-1"></i>Effacer tout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-primary mb-3">
                        <i class="fas fa-bell text-white"></i>
                    </div>
                    <h2 class="text-primary mb-1">{{ $notifications->count() }}</h2>
                    <p class="text-muted mb-0">Total Notifications</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-warning mb-3">
                        <i class="fas fa-exclamation text-white"></i>
                    </div>
                    <h2 class="text-warning mb-1">{{ $notifications->where('read_at', null)->count() }}</h2>
                    <p class="text-muted mb-0">Non lues</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-success mb-3">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <h2 class="text-success mb-1">{{ $notifications->where('read_at', '!=', null)->count() }}</h2>
                    <p class="text-muted mb-0">Lues</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-info mb-3">
                        <i class="fas fa-calendar text-white"></i>
                    </div>
                    <h2 class="text-info mb-1">{{ $notifications->where('created_at', '>=', now()->subDays(7))->count() }}</h2>
                    <p class="text-muted mb-0">Cette semaine</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <select class="form-control" id="statusFilter">
                                <option value="">Tous les statuts</option>
                                <option value="unread">Non lues</option>
                                <option value="read">Lues</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="typeFilter">
                                <option value="">Tous les types</option>
                                <option value="conge">Congés</option>
                                <option value="system">Système</option>
                                <option value="reminder">Rappels</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="dateFilter">
                                <option value="">Toutes les dates</option>
                                <option value="today">Aujourd'hui</option>
                                <option value="week">Cette semaine</option>
                                <option value="month">Ce mois</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchFilter" placeholder="Rechercher...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="clearFilters()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list mr-2"></i>
                            Liste des Notifications
                        </h5>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary badge-pill mr-2">
                                {{ $notifications->count() }} notification(s)
                            </span>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="refreshNotifications()">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if($notifications->count() > 0)
                        <div class="notifications-list" id="notificationsList">
                            @foreach($notifications as $notification)
                            <div class="notification-item p-3 border-bottom {{ $notification->read_at ? 'read' : 'unread' }}" 
                                 data-id="{{ $notification->id }}" 
                                 data-type="{{ $notification->data['type'] ?? 'system' }}"
                                 data-date="{{ $notification->created_at->format('Y-m-d') }}">
                                <div class="d-flex align-items-start">
                                    <div class="notification-icon {{ $notification->read_at ? 'bg-secondary' : \App\Helpers\NotificationHelper::getNotificationIconClass($notification) }}">
                                        <i class="fas {{ \App\Helpers\NotificationHelper::getNotificationIcon($notification) }} text-white"></i>
                                    </div>
                                    <div class="ml-3 flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1 {{ $notification->read_at ? 'text-muted' : 'font-weight-bold' }}">
                                                    {{ $notification->data['title'] ?? 'Notification' }}
                                                </h6>
                                                <p class="mb-2 {{ $notification->read_at ? 'text-muted' : '' }}">
                                                    {{ $notification->data['message'] ?? $notification->data['body'] ?? 'Aucun message' }}
                                                </p>
                                                <div class="notification-meta">
                                                    <small class="text-muted mr-3">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ \App\Helpers\NotificationHelper::formatNotificationTime($notification) }}
                                                    </small>
                                                    @if(isset($notification->data['type']))
                                                        <span class="badge badge-{{ \App\Helpers\NotificationHelper::getNotificationBadgeClass($notification) }} badge-pill">
                                                            {{ ucfirst($notification->data['type']) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="notification-actions">
                                                @if(!$notification->read_at)
                                                    <button class="btn btn-sm btn-outline-success mr-1" 
                                                            onclick="markAsRead({{ $notification->id }})" 
                                                            title="Marquer comme lu">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteNotification({{ $notification->id }})" 
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        @if(isset($notification->data['action_url']))
                                            <div class="mt-2">
                                                <a href="{{ $notification->data['action_url'] }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-external-link-alt mr-1"></i>
                                                    {{ $notification->data['action_text'] ?? \App\Helpers\NotificationHelper::getNotificationActionText($notification) }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if($notifications->hasPages())
                            <div class="card-footer bg-white border-0 py-3">
                                <div class="d-flex justify-content-center">
                                    {{ $notifications->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-bell-slash text-muted mb-3" style="font-size: 4rem;"></i>
                                <h4 class="text-muted mb-2">Aucune notification</h4>
                                <p class="text-muted mb-4">Vous n'avez aucune notification pour le moment.</p>
                                <button class="btn btn-primary" onclick="refreshNotifications()">
                                    <i class="fas fa-sync-alt mr-1"></i>Actualiser
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
.card {
    border-radius: 15px;
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto;
}

.notification-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.notification-item {
    transition: all 0.3s ease;
    cursor: pointer;
}

.notification-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.notification-item.unread {
    background-color: rgba(0, 123, 255, 0.05);
    border-left: 4px solid #007bff;
}

.notification-item.read {
    opacity: 0.7;
}

.notification-item.read:hover {
    opacity: 1;
}

.notification-actions {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.notification-item:hover .notification-actions {
    opacity: 1;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

.btn {
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.15);
}

.badge {
    border-radius: 20px;
    padding: 0.5em 1em;
}

.form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.empty-state {
    padding: 2rem;
}

.notifications-list {
    max-height: 600px;
    overflow-y: auto;
}

.notification-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

/* Animation for new notifications */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.notification-item {
    animation: slideIn 0.3s ease;
}

/* Responsive design */
@media (max-width: 768px) {
    .notification-actions {
        opacity: 1;
        margin-top: 1rem;
    }
    
    .notification-meta {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .notification-meta .badge {
        margin-top: 0.5rem;
    }
}
</style>
@endsection

@section('js')
<script>
// Filter functionality
document.getElementById('statusFilter').addEventListener('change', filterNotifications);
document.getElementById('typeFilter').addEventListener('change', filterNotifications);
document.getElementById('dateFilter').addEventListener('change', filterNotifications);
document.getElementById('searchFilter').addEventListener('input', filterNotifications);

function filterNotifications() {
    const statusFilter = document.getElementById('statusFilter').value;
    const typeFilter = document.getElementById('typeFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;
    const searchFilter = document.getElementById('searchFilter').value.toLowerCase();
    
    const notifications = document.querySelectorAll('.notification-item');
    
    notifications.forEach(notification => {
        let show = true;
        
        // Status filter
        if (statusFilter) {
            const isRead = notification.classList.contains('read');
            if (statusFilter === 'unread' && isRead) show = false;
            if (statusFilter === 'read' && !isRead) show = false;
        }
        
        // Type filter
        if (typeFilter && notification.dataset.type !== typeFilter) {
            show = false;
        }
        
        // Date filter
        if (dateFilter) {
            const notificationDate = new Date(notification.dataset.date);
            const today = new Date();
            
            if (dateFilter === 'today') {
                const isToday = notificationDate.toDateString() === today.toDateString();
                if (!isToday) show = false;
            } else if (dateFilter === 'week') {
                const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                if (notificationDate < weekAgo) show = false;
            } else if (dateFilter === 'month') {
                const monthAgo = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);
                if (notificationDate < monthAgo) show = false;
            }
        }
        
        // Search filter
        if (searchFilter) {
            const text = notification.textContent.toLowerCase();
            if (!text.includes(searchFilter)) show = false;
        }
        
        notification.style.display = show ? 'block' : 'none';
    });
    
    updateNotificationCount();
}

function updateNotificationCount() {
    const visibleNotifications = document.querySelectorAll('.notification-item[style="display: block"], .notification-item:not([style*="display: none"])');
    const countBadge = document.querySelector('.badge-primary');
    if (countBadge) {
        countBadge.textContent = `${visibleNotifications.length} notification(s)`;
    }
}

function clearFilters() {
    document.getElementById('statusFilter').value = '';
    document.getElementById('typeFilter').value = '';
    document.getElementById('dateFilter').value = '';
    document.getElementById('searchFilter').value = '';
    filterNotifications();
}

// Notification actions
function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notification = document.querySelector(`[data-id="${notificationId}"]`);
            notification.classList.remove('unread');
            notification.classList.add('read');
            notification.querySelector('h6').classList.remove('font-weight-bold');
            notification.querySelector('h6').classList.add('text-muted');
            notification.querySelector('p').classList.add('text-muted');
            notification.querySelector('.notification-icon').classList.add('bg-secondary');
            
            // Update stats
            updateNotificationStats();
            
            Swal.fire({
                icon: 'success',
                title: 'Notification marquée comme lue',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Impossible de marquer la notification comme lue'
        });
    });
}

function markAllAsRead() {
    Swal.fire({
        title: 'Marquer toutes comme lues ?',
        text: 'Toutes les notifications non lues seront marquées comme lues.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Oui, marquer toutes',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/notifications/mark-all-as-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const unreadNotifications = document.querySelectorAll('.notification-item.unread');
                    unreadNotifications.forEach(notification => {
                        notification.classList.remove('unread');
                        notification.classList.add('read');
                        notification.querySelector('h6').classList.remove('font-weight-bold');
                        notification.querySelector('h6').classList.add('text-muted');
                        notification.querySelector('p').classList.add('text-muted');
                        notification.querySelector('.notification-icon').classList.add('bg-secondary');
                    });
                    
                    updateNotificationStats();
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Toutes les notifications ont été marquées comme lues',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Impossible de marquer toutes les notifications comme lues'
                });
            });
        }
    });
}

function deleteNotification(notificationId) {
    Swal.fire({
        title: 'Supprimer cette notification ?',
        text: 'Cette action ne peut pas être annulée.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notification = document.querySelector(`[data-id="${notificationId}"]`);
                    notification.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => {
                        notification.remove();
                        updateNotificationStats();
                        
                        // Check if no notifications left
                        const remainingNotifications = document.querySelectorAll('.notification-item');
                        if (remainingNotifications.length === 0) {
                            location.reload();
                        }
                    }, 300);
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Notification supprimée',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Impossible de supprimer la notification'
                });
            });
        }
    });
}

function clearAllNotifications() {
    Swal.fire({
        title: 'Effacer toutes les notifications ?',
        text: 'Toutes les notifications seront supprimées définitivement.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Oui, effacer tout',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/notifications/clear-all', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Toutes les notifications ont été supprimées',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Impossible de supprimer toutes les notifications'
                });
            });
        }
    });
}

function refreshNotifications() {
    location.reload();
}

function updateNotificationStats() {
    const totalNotifications = document.querySelectorAll('.notification-item').length;
    const unreadNotifications = document.querySelectorAll('.notification-item.unread').length;
    const readNotifications = document.querySelectorAll('.notification-item.read').length;
    
    // Update stats cards
    const statsCards = document.querySelectorAll('.stats-card h2');
    if (statsCards.length >= 3) {
        statsCards[0].textContent = totalNotifications;
        statsCards[1].textContent = unreadNotifications;
        statsCards[2].textContent = readNotifications;
    }
}

// Auto-refresh notifications every 30 seconds
setInterval(() => {
    // Only refresh if user is on the notifications page
    if (window.location.pathname.includes('/notifications')) {
        fetch('/notifications/count')
            .then(response => response.json())
            .then(data => {
                const currentCount = document.querySelectorAll('.notification-item').length;
                if (data.count !== currentCount) {
                    refreshNotifications();
                }
            });
    }
}, 30000);

// Add slideOut animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(-20px);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection 