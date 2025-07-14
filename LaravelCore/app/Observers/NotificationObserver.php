<?php

namespace App\Observers;

use App\Models\Notification;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;


class NotificationObserver
{

    // Biến tĩnh lưu dữ liệu cũ tạm theo id user
    protected static $oldData = [];

    protected function logAction($Model, $action, $beforeChange = [], $afterChange = [])
    {
        $agent = new Agent();
        $ip = request()->ip();
        $geo = Http::get("https://ipinfo.io/{$ip}/json?token=d89e4a0555c438")->json();

        Log::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'type' => 'Notification',
            'object' => 'NO' . str_pad($Model->id, 5, "0", STR_PAD_LEFT),
            'geolocation' => json_encode($geo),
            'agent' => $agent->browser(),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'before_change' => !empty($beforeChange) ? json_encode($beforeChange) : null,
            'after_change' => !empty($afterChange) ? json_encode($afterChange) : null,
        ]);
    }

    /**
     * Handle the Notification "created" event.
     *
     * @param  \App\Models\Notification  $model
     * @return void
     */
    public function created(Notification $model)
    {
        
         $this->logAction($model, '1');
    }

        public function updating(Notification $model)
    {
        // Lưu lại cả attributes thật + appends
        self::$oldData[$model->id] = $model->getOriginal();
       
    }

    /**
     * Handle the Notification "updated" event.
     *
     * @param  \App\Models\Notification  $model
     * @return void
     */
    public function updated(Notification $model)
    {
           $oldData = self::$oldData[$model->id] ?? [];
        $newData = $model->toArray();
        // Nếu chỉ có deleted_at thay đổi thì không log trong updated
        if (!(count($newData) === 1 && isset($newData['deleted_at']))) {
            $this->logAction($model, '2', $oldData, $newData);
        }
        // Xóa dữ liệu tạm
        unset(self::$oldData[$model->id]);
    }

    /**
     * Handle the Notification "deleted" event.
     *
     * @param  \App\Models\Notification  $model
     * @return void
     */
    public function deleted(Notification $model)
    {
        
         $this->logAction($model, '3');
    }

    /**
     * Handle the Notification "restored" event.
     *
     * @param  \App\Models\Notification  $model
     * @return void
     */
    public function restored(Notification $model)
    {
        //
    }

    /**
     * Handle the Notification "force deleted" event.
     *
     * @param  \App\Models\Notification  $model
     * @return void
     */
    public function forceDeleted(Notification $model)
    {
        //
    }
}
