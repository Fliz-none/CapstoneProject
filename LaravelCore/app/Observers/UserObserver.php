<?php

namespace App\Observers;

use App\Models\Branch;
use App\Models\Local;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;

class UserObserver
{
    // Biến tĩnh lưu dữ liệu cũ tạm theo id user
    protected static $oldData = [];

    protected function logAction($userModel, $action, $beforeChange = [], $afterChange = [])
    {
        $agent = new Agent();
        $ip = request()->ip();
        $geo = Http::get("https://ipinfo.io/{$ip}/json?token=d89e4a0555c438")->json();

        Log::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'type' => 'User',
            'object' => 'U' . str_pad($userModel->id, 5, "0", STR_PAD_LEFT),
            'geolocation' => json_encode($geo),
            'agent' => $agent->browser(),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'before_change' => !empty($beforeChange) ? json_encode($beforeChange) : null,
            'after_change' => !empty($afterChange) ? json_encode($afterChange) : null,
        ]);
    }

    public function created(User $user)
    {
        $this->logAction($user, '1');
    }

    public function updating(User $user)
    {

        // Ép load quan hệ trước nếu cần cho các accessor dùng nó
        $user->loadMissing([ '_branch']);

        self::$oldData[$user->id] = $user->getOriginal();
       
    }


    public function updated(User $user)
    {
        // Load quan hệ nếu chưa có (bao gồm bản ghi soft-delete)
        $user->loadMissing([ '_branch']);
        $oldData = self::$oldData[$user->id] ?? [];
        $newData = $user->toArray();
        // Nếu chỉ có deleted_at thay đổi thì không log trong updated
        if (!(count($newData) === 1 && isset($newData['deleted_at']))) {
            // --------- LOCAL ID ---------
            if (isset($oldData['local_id'])) {
                $oldLocal = Local::withTrashed()->find($oldData['local_id']);
                $oldData['local_id'] = $oldLocal
                    ? trim("{$oldLocal->district}, {$oldLocal->city}", ', ')
                    : $oldData['local_id'];
            }

            if (isset($newData['local_id'])) {
                $newLocal = $user->_local;
                $newData['local_id'] = $newLocal
                    ? trim("{$newLocal->district}, {$newLocal->city}", ', ')
                    : $newData['local_id'];
            }

            // ===== MAIN_BRANCH =====
            if (isset($oldData['main_branch'])) {
                $oldBranch = Branch::withTrashed()->find($oldData['main_branch']);
                $oldData['main_branch'] = $oldBranch ? $oldBranch->name : $oldData['main_branch'];
            }

            if (isset($newData['main_branch'])) {
                $newBranch = Branch::withTrashed()->find($newData['main_branch']);
                $newData['main_branch'] = $newBranch ? $newBranch->name : $newData['main_branch'];
            }

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
