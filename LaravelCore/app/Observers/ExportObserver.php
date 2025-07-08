<?php

namespace App\Observers;

use App\Models\Export;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;


class ExportObserver
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
            'type' => 'Export',
            'object' => 'EX' . str_pad($Model->id, 5, "0", STR_PAD_LEFT),
            'geolocation' => json_encode($geo),
            'agent' => $agent->browser(),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'before_change' => !empty($beforeChange) ? json_encode($beforeChange) : null,
            'after_change' => !empty($afterChange) ? json_encode($afterChange) : null,
        ]);
    }

    /**
     * Handle the Export "created" event.
     *
     * @param  \App\Models\Export  $model
     * @return void
     */
    public function created(Export $model)
    {
        
         $this->logAction($model, '3');
    }

        public function updating(Export $model)
    {
        // Lưu lại cả attributes thật + appends
        self::$oldData[$model->id] = $model->getOriginal();
       
    }

    /**
     * Handle the Export "updated" event.
     *
     * @param  \App\Models\Export  $model
     * @return void
     */
    public function updated(Export $model)
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
     * Handle the Export "deleted" event.
     *
     * @param  \App\Models\Export  $model
     * @return void
     */
    public function deleted(Export $model)
    {
        
         $this->logAction($model, '3');
    }

    /**
     * Handle the Export "restored" event.
     *
     * @param  \App\Models\Export  $model
     * @return void
     */
    public function restored(Export $model)
    {
        //
    }

    /**
     * Handle the Export "force deleted" event.
     *
     * @param  \App\Models\Export  $model
     * @return void
     */
    public function forceDeleted(Export $model)
    {
        //
    }
}
