<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\NotificationController;
use App\Models\Booking;
use App\Mail\SendMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckBookingReminder extends Command
{
    protected $signature = 'booking:reminder';
    protected $description = 'Kiểm tra các cuộc hẹn và gửi thông báo nếu đúng giờ remind_at';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $now = Carbon::now()->format('Y-m-d H:i:00');
            $bookings = Booking::where(function ($query) use ($now) {
                $query->where('remind_at', $now)
                    ->orWhere('appointment_at', $now);
            })->whereIn('status', [1,2])->get();

            if ($bookings->isEmpty()) {
                $this->info($now . ': Không có cuộc hẹn nào cần nhắc nhở.');
                return 0;
            }

            foreach ($bookings as $booking) {
                $str = '<div class="row">
                            <a class="d-flex align-items-center fw-bold text-start text-primary py-2 btn-update-booking" data-id="' . $booking->id . '">
                                <div class="col-2 px-0 d-flex justify-content-center">
                                    <div class="notification-icon bg-success">
                                        <i class="bi bi-calendar4-range"></i>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="notification-text text-wrap">
                                        <p class="notification-title fw-bold text-success">Nhắc nhở cuộc hẹn</p>
                                        <small class="notification-subtitle text-success">Bạn có cuộc hẹn vào lúc ' . Carbon::parse($booking->appointment_at)->format('H:i \n\g\à\y d/m/Y') . '. Vui lòng click để xem chi tiết</small>
                                    </div>
                                </div>
                            </a>
                        </div>';
                $users = collect([$booking->_doctor, $booking->_author])->filter();

                $noti = NotificationController::create(cleanStr($str), $booking->company_id);
                NotificationController::push($noti, $users->reject(function ($user) use ($booking) {
                    return $user === $booking->_pet->_customer;
                }));

                $emails = $users->pluck('email');
                if ($emails->isNotEmpty()) {
                    Mail::to($emails)->send(new SendMail('admin.templates.emails.reminder_notification', [
                        'data' => $booking,
                    ], (cache()->get('settings_' . Auth::user()->company_id)['company_brandname'] ?? '') . ': Nhắc nhở cuộc hẹn'));
                }

                // Kiểm tra nếu appointment_at bằng $now mới thực hiện tạo booking mới
                if ($booking->appointment_at == $now) {
                    if($booking->frequency) {
                        $newBooking = $booking->replicate();
                        $newBooking->remind_at = Carbon::parse($booking->remind_at)->addHours($booking->frequency);
                        $newBooking->status = 1;
                        $newBooking->appointment_at = Carbon::parse($booking->appointment_at)->addHours($booking->frequency);
                        $newBooking->save();
                    }
                }

                $this->info($now . ': Đã gửi thông báo lịch hẹn: ' . $booking->name);
            }
        } catch (\Throwable $e) {
            $this->error('Đã xảy ra lỗi: ' . $e->getMessage());
        }
        return 0;
    }
}