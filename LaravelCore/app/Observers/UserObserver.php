<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;

class UserObserver
{
    // Biến tĩnh lưu dữ liệu cũ tạm theo id user
    protected static $oldData = [];

    protected function logAction($userModel, $action, $beforeChange = [], $afterChange = [])
    {
        // $agent = new Agent();
        // $ip = request()->ip();
        // $geo = Http::get("https://ipinfo.io/{$ip}/json?token=d89e4a0555c438")->json();

        // Log::create([
        //     'user_id'       => Auth::id(),
        //     'action'        => $action,
        //     'type'          => 'user',
        //     'object'        => $userModel->id,
        //     'geolocation'   => json_encode($geo),
        //     'agent'         => $agent->browser(),
        //     'platform'      => $agent->platform(),
        //     'device'        => $agent->device(),
        //     'before_change' => !empty($beforeChange) ? json_encode($beforeChange) : null,
        //     'after_change'  => !empty($afterChange) ? json_encode($afterChange) : null,
        // ]);
    }

    public function created(User $user)
    {
        $this->logAction($user, '1');
    }

    public function updating(User $user)
    {
        // Lưu dữ liệu gốc vào mảng tạm theo ID
       self::$oldData[$user->id] = $user->getOriginal();
    }


    public function updated(User $user)
    {
        $oldData = self::$oldData[$user->id] ?? [];
        $newData = $user->toArray();
    // Nếu chỉ có deleted_at thay đổi thì không log trong updated
    if (!(count($newData) === 1 && isset($newData['deleted_at']))) {
        $this->logAction($user, '2', $oldData, $newData);
    }
        // Xóa dữ liệu tạm
        unset(self::$oldData[$user->id]);
    }

    public function deleted(User $user)
    {
        $this->logAction($user, '3');
    }

    public function restored(User $user)
    {
        //
    }

    public function forceDeleted(User $user)
    {
        //
    }
}
