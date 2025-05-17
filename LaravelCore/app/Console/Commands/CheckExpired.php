<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\NotificationController;
use App\Mail\SendMail;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stocks:checkexpired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expired stocks and send notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $before = optional(Setting::whereKey('expired_notification_before')->first())->value ?? 60;
            $expiredStocks = Stock::with(['import_detail._import._warehouse', 'import_detail._variable'])
                ->whereDate('expired', now()->addDays($before))
                ->get()
                ->groupBy(function ($stock) {
                    return $stock->import_detail->_import->_warehouse->id;
                });

            foreach ($expiredStocks as $warehouseId => $stocks) {
                $warehouse = Warehouse::find($warehouseId);
                $users = $warehouse->users->where('status', 1);
                if (!$warehouse) {
                    continue;
                }
                $expired_day = Carbon::now()->addDays($before);
                $str = '<div class="row">
                            <a class="d-flex align-items-center fw-bold text-start text-primary py-2" href="' . route('admin.stock', ['expired' => $expired_day->format('Y-m-d')]) . '">
                                <div class="col-2 px-0 d-flex justify-content-center">
                                    <div class="notification-icon bg-danger">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="notification-text text-wrap">
                                        <p class="notification-title fw-bold text-danger">Expiration Alert</p>
                                        <small class="notification-subtitle text-danger">Some products will expire on ' . $expired_day->format('d/m/Y') . '</small>
                                    </div>
                                </div>
                            </a>
                        </div>';
                $noti = NotificationController::create($str);
                NotificationController::push($noti, $users);
                //Gửi email thông báo
                if (!empty($users)) {
                    //Thông báo sản phẩm sắp hết hạn tại kho
                    Mail::to($users->pluck('email')->filter())->send(new SendMail('admin.templates.emails.expired_notification', $stocks, 'Expiration Alert at ' . $warehouse->name));
                }
            }

            $this->info(Carbon::now()->format('d/m/Y') . ': Done.');
        } catch (\Throwable $throwable) {
            $this->info(Carbon::now()->format('d/m/Y') . ': Error:' . $throwable->getMessage());
        }
        return 0;
    }
}
