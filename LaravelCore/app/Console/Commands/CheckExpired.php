<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\NotificationController;
use App\Mail\SendMail;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\User;
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
            $start = microtime(true);
            $before = optional(Setting::where('key', 'expired_notification_before')->first())->value ?? 30;
            $expiredStocks = Stock::with(['import_detail._import._warehouse', 'import_detail._variable'])
                ->whereDate('expired', now()->addDays($before))
                ->get()
                ->groupBy(function ($stock) {
                    return $stock->import_detail->_import->warehouse_id;
                }); // Nhom theo kho
            $warehouses = Warehouse::with([
                'users' => function ($q) {
                    $q->where('status', 1)->with('permissions');
                }
            ])
            ->whereIn('status', [1, 2]) //Kho dang ban hoac kho noi bo
            ->whereIn('id', $expiredStocks->keys()->all()) 
            ->get()->keyBy('id');

            foreach ($expiredStocks as $warehouseId => $stocks) {
                $warehouse = $warehouses->get($warehouseId);
                if (!$warehouse) continue;

                $users = $warehouse->users->filter(function ($user) {
                    return $user->can(User::ACCESS_ADMIN);
                }); //Lay danh sach nguoi dung co quyen admin
                
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

            $this->info('Execution time: ' . round(microtime(true) - $start, 2) . 's');
            $this->info(Carbon::now()->format('d/m/Y') . ': Done.');
        } catch (\Throwable $throwable) {
            $this->info(Carbon::now()->format('d/m/Y') . ': Error:' . $throwable->getMessage());
        }
        return 0;
    }
}
