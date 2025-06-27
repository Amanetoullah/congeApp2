<?php

namespace App\Providers;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use App\Helpers\NotificationHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot():void
    {
       RateLimiter::for('login',function(Request $request){
        return
    Limit::perMinute(5)->by($request->email ?:$request->ip());
       });
       Fortify::authenticateUsing(function (Request $request){
        $user=User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){
            return $user;
        }
        return null;
       });

       // Register helper functions for Blade templates
       \Blade::directive('notificationIcon', function ($notification) {
           return "<?php echo App\Helpers\NotificationHelper::getNotificationIcon($notification); ?>";
       });

       \Blade::directive('notificationIconClass', function ($notification) {
           return "<?php echo App\Helpers\NotificationHelper::getNotificationIconClass($notification); ?>";
       });

       \Blade::directive('notificationBadgeClass', function ($notification) {
           return "<?php echo App\Helpers\NotificationHelper::getNotificationBadgeClass($notification); ?>";
       });

       \Blade::directive('notificationTime', function ($notification) {
           return "<?php echo App\Helpers\NotificationHelper::formatNotificationTime($notification); ?>";
       });

       \Blade::directive('notificationSummary', function ($notification) {
           return "<?php echo App\Helpers\NotificationHelper::getNotificationSummary($notification); ?>";
       });

       \Blade::directive('notificationActionText', function ($notification) {
           return "<?php echo App\Helpers\NotificationHelper::getNotificationActionText($notification); ?>";
       });
    }
}
