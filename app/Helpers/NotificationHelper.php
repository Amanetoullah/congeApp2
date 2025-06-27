<?php

namespace App\Helpers;

use Illuminate\Notifications\DatabaseNotification;

class NotificationHelper
{
    /**
     * Get the appropriate icon for a notification
     */
    public static function getNotificationIcon($notification)
    {
        $type = $notification->data['type'] ?? 'system';
        
        switch ($type) {
            case 'conge':
                return 'fa-calendar-check';
            case 'reminder':
                return 'fa-clock';
            case 'system':
                return 'fa-cog';
            case 'success':
                return 'fa-check-circle';
            case 'warning':
                return 'fa-exclamation-triangle';
            case 'error':
                return 'fa-times-circle';
            case 'info':
                return 'fa-info-circle';
            default:
                return 'fa-bell';
        }
    }

    /**
     * Get the appropriate icon class for a notification
     */
    public static function getNotificationIconClass($notification)
    {
        $type = $notification->data['type'] ?? 'system';
        
        switch ($type) {
            case 'conge':
                return 'bg-primary';
            case 'reminder':
                return 'bg-warning';
            case 'system':
                return 'bg-secondary';
            case 'success':
                return 'bg-success';
            case 'warning':
                return 'bg-warning';
            case 'error':
                return 'bg-danger';
            case 'info':
                return 'bg-info';
            default:
                return 'bg-primary';
        }
    }

    /**
     * Get the appropriate badge class for a notification
     */
    public static function getNotificationBadgeClass($notification)
    {
        $type = $notification->data['type'] ?? 'system';
        
        switch ($type) {
            case 'conge':
                return 'primary';
            case 'reminder':
                return 'warning';
            case 'system':
                return 'secondary';
            case 'success':
                return 'success';
            case 'warning':
                return 'warning';
            case 'error':
                return 'danger';
            case 'info':
                return 'info';
            default:
                return 'primary';
        }
    }

    /**
     * Format notification time
     */
    public static function formatNotificationTime($notification)
    {
        $createdAt = $notification->created_at;
        $now = now();
        $diff = $createdAt->diff($now);

        if ($diff->days > 0) {
            return $createdAt->format('d/m/Y à H:i');
        } elseif ($diff->h > 0) {
            return "Il y a {$diff->h} heure" . ($diff->h > 1 ? 's' : '');
        } elseif ($diff->i > 0) {
            return "Il y a {$diff->i} minute" . ($diff->i > 1 ? 's' : '');
        } else {
            return "À l'instant";
        }
    }

    /**
     * Get notification priority
     */
    public static function getNotificationPriority($notification)
    {
        $type = $notification->data['type'] ?? 'system';
        
        switch ($type) {
            case 'error':
                return 1;
            case 'warning':
                return 2;
            case 'reminder':
                return 3;
            case 'conge':
                return 4;
            case 'info':
                return 5;
            case 'system':
                return 6;
            default:
                return 7;
        }
    }

    /**
     * Check if notification is urgent
     */
    public static function isUrgent($notification)
    {
        $type = $notification->data['type'] ?? 'system';
        return in_array($type, ['error', 'warning', 'reminder']);
    }

    /**
     * Get notification summary
     */
    public static function getNotificationSummary($notification)
    {
        $message = $notification->data['message'] ?? $notification->data['body'] ?? '';
        return strlen($message) > 100 ? substr($message, 0, 100) . '...' : $message;
    }

    /**
     * Get notification action text
     */
    public static function getNotificationActionText($notification)
    {
        $type = $notification->data['type'] ?? 'system';
        
        switch ($type) {
            case 'conge':
                return 'Voir le congé';
            case 'reminder':
                return 'Voir le rappel';
            case 'system':
                return 'Voir les détails';
            default:
                return 'Voir plus';
        }
    }
} 