<?php

namespace App\Observers;

use App\Models\Catalogue;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;

class CatalogueObserver
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
            'type' => 'Catalogue',
            'object' => 'CATA' . str_pad($Model->id, 5, "0", STR_PAD_LEFT),
            'geolocation' => json_encode($geo),
            'agent' => $agent->browser(),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'before_change' => !empty($beforeChange) ? json_encode($beforeChange) : null,
            'after_change' => !empty($afterChange) ? json_encode($afterChange) : null,
        ]);
    }

    /**
     * Handle the Catalogue "created" event.
     *
     * @param  \App\Models\Catalogue  $catalogue
     * @return void
     */
    public function created(Catalogue $model)
    {
        $this->logAction($model, '1');
    }


    public function updating(Catalogue $model)
    {
        // Lưu lại cả attributes thật + appends
        self::$oldData[$model->id] = $model->getOriginal();

    }

    /**
     * Handle the Catalogue "updated" event.
     *
     * @param  \App\Models\Catalogue  $catalogue
     * @return void
     */
    public function updated(Catalogue $model)
    {
        $oldData = self::$oldData[$model->id] ?? [];
        $newData = $model->toArray();


        // Format parent_id trong oldData
        if (isset($oldData['parent_id']) && !empty($oldData['parent_id'])) {
            $parent = Catalogue::find($oldData['parent_id']);
            if ($parent) {
                $oldData['parent_id'] =  $parent->name;
            }
        }

        // Format parent_id trong newData
        if (isset($newData['parent_id']) && !empty($newData['parent_id'])) {
            $parent = Catalogue::find($newData['parent_id']);
            if ($parent) {
                $newData['parent_id'] =  $parent->name;
            }
        }

        // Nếu chỉ có deleted_at thay đổi thì không log trong updated
        if (!(count($newData) === 1 && isset($newData['deleted_at']))) {
            $this->logAction($model, '2', $oldData, $newData);
        }

        // Xóa dữ liệu tạm
        unset(self::$oldData[$model->id]);
    }

    /**
     * Handle the Catalogue "deleted" event.
     *
     * @param  \App\Models\Catalogue  $catalogue
     * @return void
     */
    public function deleted(Catalogue $model)
    {

        $this->logAction($model, '3');
    }

    /**
     * Handle the Catalogue "restored" event.
     *
     * @param  \App\Models\Catalogue  $catalogue
     * @return void
     */
    public function restored(Catalogue $catalogue)
    {
        //
    }

    /**
     * Handle the Catalogue "force deleted" event.
     *
     * @param  \App\Models\Catalogue  $catalogue
     * @return void
     */
    public function forceDeleted(Catalogue $catalogue)
    {
        //
    }
}
