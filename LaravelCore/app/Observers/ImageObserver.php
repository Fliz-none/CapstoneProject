<?php

namespace App\Observers;

use App\Models\Image;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;


class ImageObserver
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
            'type' => 'Image',
            'object' => 'IM' . str_pad($Model->id, 5, "0", STR_PAD_LEFT),
            'geolocation' => json_encode($geo),
            'agent' => $agent->browser(),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'before_change' => !empty($beforeChange) ? json_encode($beforeChange) : null,
            'after_change' => !empty($afterChange) ? json_encode($afterChange) : null,
        ]);
    }

    /**
     * Handle the Image "created" event.
     *
     * @param  \App\Models\Image  $model
     * @return void
     */
    public function created(Image $model)
    {
        
         $this->logAction($model, '1');
    }

        public function updating(Image $model)
    {
        // Lưu lại cả attributes thật + appends
        self::$oldData[$model->id] = $model->getOriginal();
       
    }

    /**
     * Handle the Image "updated" event.
     *
     * @param  \App\Models\Image  $model
     * @return void
     */
    public function updated(Image $model)
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
     * Handle the Image "deleted" event.
     *
     * @param  \App\Models\Image  $model
     * @return void
     */
    public function deleted(Image $model)
    {
         $this->logAction($model, '3');
    }

    /**
     * Handle the Image "restored" event.
     *
     * @param  \App\Models\Image  $model
     * @return void
     */
    public function restored(Image $model)
    {
        //
    }

    /**
     * Handle the Image "force deleted" event.
     *
     * @param  \App\Models\Image  $model
     * @return void
     */
    public function forceDeleted(Image $model)
    {
        //
    }
}
