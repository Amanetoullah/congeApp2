<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    

    /**
     * Display the notifications page
     */
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('employee-views.notifications', compact('notifications'));
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($id)
    {
        try {
            $notification = Auth::user()
                ->notifications()
                ->findOrFail($id);

            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marquée comme lue'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error marking notification as read: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du marquage de la notification'
            ], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        try {
            DB::beginTransaction();

            Auth::user()
                ->unreadNotifications()
                ->update(['read_at' => now()]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Toutes les notifications ont été marquées comme lues'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error marking all notifications as read: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du marquage des notifications'
            ], 500);
        }
    }

    /**
     * Delete a specific notification
     */
    public function destroy($id)
    {
        try {
            $notification = Auth::user()
                ->notifications()
                ->findOrFail($id);

            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notification supprimée'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error deleting notification: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la notification'
            ], 500);
        }
    }

    /**
     * Clear all notifications
     */
    public function clearAll()
    {
        try {
            DB::beginTransaction();

            Auth::user()
                ->notifications()
                ->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Toutes les notifications ont été supprimées'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error clearing all notifications: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression des notifications'
            ], 500);
        }
    }

    /**
     * Get notification count for real-time updates
     */
    public function count()
    {
        $count = Auth::user()->notifications()->count();
        
        return response()->json([
            'count' => $count,
            'unread' => Auth::user()->unreadNotifications()->count()
        ]);
    }

    /**
     * Get filtered notifications via AJAX
     */
    public function getFiltered(Request $request)
    {
        $query = Auth::user()->notifications();

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($request->status === 'read') {
                $query->whereNotNull('read_at');
            }
        }

        // Type filter
        if ($request->filled('type')) {
            $query->whereJsonContains('data->type', $request->type);
        }

        // Date filter
        if ($request->filled('date')) {
            switch ($request->date) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
            }
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereJsonContains('data->title', $search)
                  ->orWhereJsonContains('data->message', $search)
                  ->orWhereJsonContains('data->body', $search);
            });
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'html' => view('employee-views.partials.notifications-list', compact('notifications'))->render()
        ]);
    }

    /**
     * Get notification statistics
     */
    public function stats()
    {
        $user = Auth::user();
        
        $stats = [
            'total' => $user->notifications()->count(),
            'unread' => $user->unreadNotifications()->count(),
            'read' => $user->readNotifications()->count(),
            'this_week' => $user->notifications()->where('created_at', '>=', now()->subDays(7))->count(),
            'this_month' => $user->notifications()->where('created_at', '>=', now()->subDays(30))->count(),
            'by_type' => [
                'conge' => $user->notifications()->whereJsonContains('data->type', 'conge')->count(),
                'system' => $user->notifications()->whereJsonContains('data->type', 'system')->count(),
                'reminder' => $user->notifications()->whereJsonContains('data->type', 'reminder')->count(),
            ]
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Mark notification as read and redirect to action URL if exists
     */
    public function markAsReadAndRedirect($id)
    {
        try {
            $notification = Auth::user()
                ->notifications()
                ->findOrFail($id);

            $notification->markAsRead();

            // Redirect to action URL if exists
            if (isset($notification->data['action_url'])) {
                return redirect($notification->data['action_url']);
            }

            return redirect()->route('notifications.index')
                ->with('success', 'Notification marquée comme lue');

        } catch (\Exception $e) {
            \Log::error('Error marking notification as read and redirecting: ' . $e->getMessage());

            return redirect()->route('notifications.index')
                ->with('error', 'Erreur lors du traitement de la notification');
        }
    }

    /**
     * Get unread notifications count for navbar
     */
    public function unreadCount()
    {
        $count = Auth::user()->unreadNotifications()->count();
        
        return response()->json([
            'count' => $count,
            'hasUnread' => $count > 0
        ]);
    }

    /**
     * Get recent notifications for dropdown
     */
    public function recent()
    {
        $notifications = Auth::user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }
}
