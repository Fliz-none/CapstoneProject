<?php

namespace App\Observers;

use App\Models\Local;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;


class LocalObserver
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
            'type' => 'Local',
            'object' => 'L' . str_pad($Model->id, 5, "0", STR_PAD_LEFT),
            'geolocation' => json_encode($geo),
            'agent' => $agent->browser(),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'before_change' => !empty($beforeChange) ? json_encode($beforeChange) : null,
            'after_change' => !empty($afterChange) ? json_encode($afterChange) : null,
        ]);
    }

    /**
     * Handle the Local "created" event.
     *
     * @param  \App\Models\Local  $model
     * @return void
     */
    public function created(Local $model)
    {
        
         $this->logAction($model, '1');
    }

        public function updating(Local $model)
    {
        // Lưu lại cả attributes thật + appends
        self::$oldData[$model->id] = $model->getOriginal();
       
    }

    /**
     * Handle the Local "updated" event.
     *
     * @param  \App\Models\Local  $model
     * @return void
     */
    public function updated(Local $model)
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
     * Handle the Local "deleted" event.
     *
     * @param  \App\Models\Local  $model
     * @return void
     */
    public function deleted(Local $model)
    {
         $this->logAction($model, '3');
    }

    /**
     * Handle the Local "restored" event.
     *
     * @param  \App\Models\Local  $model
     * @return void
     */
    public function restored(Local $model)
    {
        //
    }

    /**
     * Handle the Local "force deleted" event.
     *
     * @param  \App\Models\Local  $model
     * @return void
     */
    public function forceDeleted(Local $model)
    {
        //
    }
}
