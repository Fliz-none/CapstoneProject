<?php

namespace App\Observers;

use App\Models\Branch;
use App\Models\Discount;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;


class DiscountObserver
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
            'type' => 'Discount',
            'object' => 'GG' . str_pad($Model->id, 5, "0", STR_PAD_LEFT),
            'geolocation' => json_encode($geo),
            'agent' => $agent->browser(),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'before_change' => !empty($beforeChange) ? json_encode($beforeChange) : null,
            'after_change' => !empty($afterChange) ? json_encode($afterChange) : null,
        ]);
    }

    /**
     * Handle the Discount "created" event.
     *
     * @param  \App\Models\Discount  $discount
     * @return void
     */
    public function created(Discount $model)
    {
        $this->logAction($model, '1');
    }


    public function updating(Discount $model)
    {
        // Lưu lại cả attributes thật + appends
        self::$oldData[$model->id] = $model->getOriginal();
 
    }

    /**
     * Handle the Discount "updated" event.
     *
     * @param  \App\Models\Discount  $discount
     * @return void
     */
    public function updated(Discount $model)
    {
        $oldData = self::$oldData[$model->id] ?? [];
        $newData = $model->toArray();
        // Format branch_id trong oldData
        if (isset($oldData['branch_id']) && !empty($oldData['branch_id'])) {
            $branch = Branch::find($oldData['branch_id']);
            if ($branch) {
                $oldData['branch_id'] =  $branch->name;
            }
        }

        // Format branch_id trong newData
        if (isset($newData['branch_id']) && !empty($newData['branch_id'])) {
            $branch = Branch::find($newData['branch_id']);
            if ($branch) {
                $newData['branch_id'] =  $branch->name;
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
     * Handle the Discount "deleted" event.
     *
     * @param  \App\Models\Discount  $discount
     * @return void
     */
    public function deleted(Discount $model)
    {
        $this->logAction($model, '3');
    }

    /**
     * Handle the Discount "restored" event.
     *
     * @param  \App\Models\Discount  $discount
     * @return void
     */
    public function restored(Discount $discount)
    {
        //
    }

    /**
     * Handle the Discount "force deleted" event.
     *
     * @param  \App\Models\Discount  $discount
     * @return void
     */
    public function forceDeleted(Discount $discount)
    {
        //
    }
}
