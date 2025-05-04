<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**************************** Permission ****************************/
    const READ_DASHBOARD = 'Xem bảng tin';
    const ACCESS_ADMIN = 'Truy cập trang quản trị';
    const READ_SETTINGS = 'Truy cập trang cài đặt';
    const READ_LOGS = 'Xem nhật ký hệ thống';

    const READ_ROLES = 'Xem danh sách vai trò';
    const READ_ROLE = 'Xem chi tiết vai trò';
    const CREATE_ROLE = 'Thêm vai trò';
    const UPDATE_ROLE = 'Cập nhật vai trò';
    const DELETE_ROLE = 'Xóa vai trò';
    const DELETE_ROLES = 'Xóa hàng loạt vai trò';

    const READ_USERS = 'Xem danh sách tài khoản';
    const READ_USER = 'Xem chi tiết tài khoản';
    const CREATE_USER = 'Thêm tài khoản';
    const UPDATE_USER = 'Cập nhật tài khoản';
    const PASSWORD_USER = 'Đổi mật khẩu';
    const SWITCH_USER = 'Đổi trạng thái tài khoản';
    const DELETE_USER = 'Xóa tài khoản';
    const DELETE_USERS = 'Xóa hàng loạt tài khoản';
    const ROLE_USER = 'Cấp quyền cho tài khoản';
    const BRANCH_USER = 'Bố trí chi nhánh cho tài khoản';
    const WAREHOUSE_USER = 'Bố trí kho cho tài khoản';

    const READ_PETS = 'Xem danh sách thú cưng';
    const READ_PET = 'Xem chi tiết thú cưng';
    const CREATE_PET = 'Thêm thú cưng';
    const UPDATE_PET = 'Cập nhật thú cưng';
    const DELETE_PET = 'Xóa thú cưng';
    const DELETE_PETS = 'Xóa hàng loạt thú cưng';

    const READ_SUPPLIERS = 'Xem danh sách nhà cung cấp';
    const READ_SUPPLIER = 'Xem chi tiết nhà cung cấp';
    const CREATE_SUPPLIER = 'Thêm nhà cung cấp';
    const UPDATE_SUPPLIER = 'Cập nhật nhà cung cấp';
    const DELETE_SUPPLIER = 'Xóa nhà cung cấp';
    const DELETE_SUPPLIERS = 'Xóa hàng loạt nhà cung cấp';

    const READ_BRANCHES = 'Xem danh sách chi nhánh';
    const READ_BRANCH = 'Xem chi tiết chi nhánh';
    const CREATE_BRANCH = 'Thêm chi nhánh';
    const UPDATE_BRANCH = 'Cập nhật chi nhánh';
    const DELETE_BRANCH = 'Xóa chi nhánh';
    const DELETE_BRANCHES = 'Xóa hàng loạt chi nhánh';

    const READ_WAREHOUSES = 'Xem danh sách kho';
    const CREATE_WAREHOUSE = 'Thêm kho mới';
    const UPDATE_WAREHOUSE = 'Cập nhật thông tin kho';
    const DELETE_WAREHOUSE = 'Xóa kho';
    const DELETE_WAREHOUSES = 'Xóa hàng loạt kho';

    const READ_IMPORTS = 'Xem danh sách nhập hàng';
    const READ_IMPORT = 'Xem chi tiết nhập hàng';
    const CREATE_IMPORT = 'Thêm phiếu nhập hàng';
    const UPDATE_IMPORT = 'Cập nhật phiếu nhập hàng';
    const DELETE_IMPORT = 'Xóa phiếu nhập hàng';
    const DELETE_IMPORTS = 'Xóa hàng loạt phiếu nhập hàng';
    const PRINT_IMPORT = 'In phiếu nhập hàng';
    const EXCEL_IMPORT = 'Xuất excel phiếu nhập hàng';

    const READ_EXPORTS = 'Xem danh sách xuất hàng';
    const READ_EXPORT = 'Xem chi tiết xuất hàng';
    const CREATE_EXPORT = 'Thêm phiếu xuất hàng';
    const UPDATE_EXPORT = 'Cập nhật phiếu xuất hàng';
    const DELETE_EXPORT = 'Xóa phiếu xuất hàng';
    const DELETE_EXPORTS = 'Xóa hàng loạt phiếu xuất hàng';
    const PRINT_EXPORT = 'In phiếu xuất hàng';
    const EXCEL_EXPORT = 'Xuất excel phiếu xuất hàng';

    const READ_STOCKS = 'Xem danh sách tồn kho';
    const READ_STOCK = 'Xem chi tiết tồn kho';
    const PRINT_STOCK = 'In danh sách tồn kho';
    const EXCEL_STOCK = 'Xuất excel danh sách tồn kho';

    const READ_CATALOGUES = 'Xem danh sách danh mục';
    const CREATE_CATALOGUE = 'Thêm danh mục';
    const SORT_CATALOGUE = 'Sắp xếp danh mục';
    const UPDATE_CATALOGUE = 'Cập nhật danh mục';
    const DELETE_CATALOGUE = 'Xóa danh mục';
    const DELETE_CATALOGUES = 'Xóa hàng loạt danh mục';

    const READ_MAJORS = 'Xem danh sách xét nghiệm';
    const CREATE_MAJOR = 'Thêm xét nghiệm';
    const SORT_MAJOR = 'Sắp xếp xét nghiệm';
    const UPDATE_MAJOR = 'Cập nhật xét nghiệm';
    const DELETE_MAJOR = 'Xóa xét nghiệm';
    const DELETE_MAJORS = 'Xóa hàng loạt xét nghiệm';

    const READ_ATTRIBUTES = 'Xem danh sách thuộc tính';
    const CREATE_ATTRIBUTE = 'Thêm thuộc tính';
    const UPDATE_ATTRIBUTE = 'Cập nhật thuộc tính';
    const DELETE_ATTRIBUTE = 'Xóa thuộc tính';
    const DELETE_ATTRIBUTES = 'Xóa hàng loạt thuộc tính';

    const READ_PRODUCTS = 'Xem danh sách sản phẩm';
    const READ_PRODUCT = 'Xem chi tiết sản phẩm';
    const CREATE_PRODUCT = 'Thêm sản phẩm';
    const SWITCH_PRODUCT = 'Đổi trạng thái sản phẩm';
    const UPDATE_PRODUCT = 'Cập nhật sản phẩm';
    const DELETE_PRODUCT = 'Xóa sản phẩm';
    const DELETE_PRODUCTS = 'Xóa hàng loạt sản phẩm';
    const EXCEL_PRODUCT = 'Xuất excel danh sách sản phẩm';

    const READ_CRITERIALS = 'Xem danh sách tiêu chí';
    const CREATE_CRITERIAL = 'Thêm tiêu chí';
    const UPDATE_CRITERIAL = 'Cập nhật tiêu chí';
    const DELETE_CRITERIAL = 'Xóa tiêu chí';
    const DELETE_CRITERIALS = 'Xóa hàng loạt tiêu chí';

    const READ_SERVICES = 'Xem danh sách dịch vụ';
    const READ_SERVICE = 'Xem chi tiết dịch vụ';
    const CREATE_SERVICE = 'Thêm dịch vụ';
    const UPDATE_SERVICE = 'Cập nhật dịch vụ';
    const DELETE_SERVICE = 'Xóa dịch vụ';
    const DELETE_SERVICES = 'Xóa hàng loạt dịch vụ';

    const CREATE_VARIABLE = 'Thêm biến thể';
    const UPDATE_VARIABLE = 'Cập nhật biến thể';
    const DELETE_VARIABLE = 'Xóa biến thể';

    const READ_ORDERS = 'Xem danh sách đơn hàng';
    const READ_ORDER = 'Xem chi tiết đơn hàng';
    const CREATE_ORDER = 'Thêm đơn hàng';
    const UPDATE_ORDER = 'Cập nhật đơn hàng';
    const CANCEL_ORDER = 'Hủy đơn hàng';
    const DELETE_ORDER = 'Xóa đơn hàng';
    const DELETE_ORDERS = 'Xóa hàng loạt đơn hàng';
    const EXCEL_ORDERS = 'Xuất excel danh sách đơn hàng';
    const EXCEL_ORDER = 'Xuất excel chi tiết đơn hàng';
    const PRINT_ORDER = 'In đơn hàng';

    const UPDATE_ORDER_DETAIL = 'Cập nhật chi tiết đơn hàng';
    const DELETE_ORDER_DETAIL = 'Xóa chi tiết đơn hàng';

    const READ_DEBTS = 'Xem danh sách công nợ';
    const READ_TRANSACTIONS = 'Xem danh sách giao dịch';
    const READ_TRANSACTION = 'Xem chi tiết giao dịch';
    const CREATE_TRANSACTION = 'Thêm giao dịch';
    const UPDATE_TRANSACTION = 'Cập nhật giao dịch';
    const DELETE_TRANSACTION = 'Xóa giao dịch';
    const DELETE_TRANSACTIONS = 'Xóa hàng loạt giao dịch';
    const SEND_ZNS_TRANSACTION = 'Gửi zalo giao dịch cho khách hàng';

    const READ_DISEASES = 'Xem danh sách bệnh lý';
    const READ_DISEASE = 'Xem chi tiết bệnh lý';
    const CREATE_DISEASE = 'Thêm bệnh lý';
    const UPDATE_DISEASE = 'Cập nhật bệnh lý';
    const DELETE_DISEASE = 'Xóa bệnh lý';
    const DELETE_DISEASES = 'Xóa hàng loạt bệnh lý';

    const READ_INFOS = 'Xem danh sách p. khám';
    const READ_INFO = 'Xem chi tiết p. khám';
    const CREATE_INFO = 'Thêm p. khám';
    const UPDATE_INFO = 'Cập nhật p. khám';
    const DELETE_INFO = 'Xóa p. khám';
    const DELETE_INFOS = 'Xóa hàng loạt p. khám';
    const EXCEL_INFO = 'Xuất excel danh sách p. khám';
    const PRINT_INFO = 'In p. khám';

    const READ_INDICATIONS = 'Xem danh sách p. chỉ định';
    const READ_INDICATION = 'Xem chi tiết p. chỉ định';
    const CREATE_INDICATION = 'Thêm p. chỉ định';
    const DELETE_INDICATION = 'Xóa p. chỉ định';
    const PRINT_INDICATION = 'In p. chỉ định';

    const READ_QUICKTESTS = 'Xem danh sách p. kit test nhanh';
    const READ_QUICKTEST = 'Xem chi tiết p. kit test nhanh';
    const CREATE_QUICKTEST = 'Thêm p. kit test nhanh';
    const UPDATE_QUICKTEST = 'Cập nhật p. kit test nhanh';
    const CANCEL_QUICKTEST = 'Hủy p. kit test nhanh';
    const DELETE_QUICKTEST = 'Xóa p. kit test nhanh';
    const PRINT_QUICKTEST = 'In p. kit test nhanh';

    const READ_ULTRASOUNDS = 'Xem danh sách p. siêu âm';
    const READ_ULTRASOUND = 'Xem chi tiết p. siêu âm';
    const CREATE_ULTRASOUND = 'Thêm p. siêu âm';
    const UPDATE_ULTRASOUND = 'Cập nhật p. siêu âm';
    const CANCEL_ULTRASOUND = 'Hủy p. siêu âm';
    const DELETE_ULTRASOUND = 'Xóa p. siêu âm';
    const PRINT_ULTRASOUND = 'In p. siêu âm';

    const READ_BLOODCELLS = 'Xem danh sách p. XNTB máu';
    const READ_BLOODCELL = 'Xem chi tiết p. XNTB máu';
    const CREATE_BLOODCELL = 'Thêm p. XNTB máu';
    const UPDATE_BLOODCELL = 'Cập nhật p. XNTB máu';
    const CANCEL_BLOODCELL = 'Hủy p. XNTB máu';
    const DELETE_BLOODCELL = 'Xóa p. XNTB máu';
    const PRINT_BLOODCELL = 'In p. XNTB máu';

    const READ_BIOCHEMICALS = 'Xem danh sách p. XNSH máu';
    const READ_BIOCHEMICAL = 'Xem chi tiết p. XNSH máu';
    const CREATE_BIOCHEMICAL = 'Thêm p. XNSH máu';
    const UPDATE_BIOCHEMICAL = 'Cập nhật p. XNSH máu';
    const CANCEL_BIOCHEMICAL = 'Hủy p. XNSH máu';
    const DELETE_BIOCHEMICAL = 'Xóa p. XNSH máu';
    const PRINT_BIOCHEMICAL = 'In p. XNSH máu';

    const READ_MICROSCOPES = 'Xem danh sách p. soi KHV';
    const READ_MICROSCOPE = 'Xem chi tiết p. soi KHV';
    const CREATE_MICROSCOPE = 'Thêm p. soi KHV';
    const UPDATE_MICROSCOPE = 'Cập nhật p. soi KHV';
    const CANCEL_MICROSCOPE = 'Hủy p. soi KHV';
    const DELETE_MICROSCOPE = 'Xóa p. soi KHV';
    const PRINT_MICROSCOPE = 'In p. soi KHV';

    const READ_XRAYS = 'Xem danh sách p. x-quang';
    const READ_XRAY = 'Xem chi tiết p. x-quang';
    const CREATE_XRAY = 'Thêm p. x-quang';
    const UPDATE_XRAY = 'Cập nhật p. x-quang';
    const CANCEL_XRAY = 'Hủy p. x-quang';
    const DELETE_XRAY = 'Xóa p. x-quang';
    const PRINT_XRAY = 'In p. x-quang';

    const READ_SURGERIES = 'Xem danh sách p. phẫu thuật';
    const READ_SURGERY = 'Xem chi tiết p. phẫu thuật';
    const CREATE_SURGERY = 'Thêm p. phẫu thuật';
    const UPDATE_SURGERY = 'Cập nhật p. phẫu thuật';
    const CANCEL_SURGERY = 'Hủy p. phẫu thuật';
    const DELETE_SURGERY = 'Xóa p. phẫu thuật';
    const PRINT_SURGERY = 'In p. phẫu thuật';

    const READ_PRESCRIPTIONS = 'Xem danh sách đơn thuốc';
    const READ_PRESCRIPTION = 'Xem chi tiết đơn thuốc';
    const CREATE_PRESCRIPTION = 'Thêm đơn thuốc';
    const UPDATE_PRESCRIPTION = 'Cập nhật đơn thuốc';
    const CANCEL_PRESCRIPTION = 'Hủy đơn thuốc';
    const DELETE_PRESCRIPTION = 'Xóa đơn thuốc';
    const PRINT_PRESCRIPTION = 'In đơn thuốc';

    const READ_BOOKINGS = 'Xem danh sách p. đặt dịch vụ';
    const READ_BOOKING = 'Xem chi tiết p. đặt dịch vụ';
    const CREATE_BOOKING = 'Thêm p. đặt dịch vụ';
    const UPDATE_BOOKING = 'Cập nhật p. đặt dịch vụ';
    const CANCEL_BOOKING = 'Hủy p. đặt dịch vụ';
    const DELETE_BOOKING = 'Xóa p. đặt dịch vụ';
    const SEND_ZNS_BOOKING = 'Gửi zalo p. đặt dịch vụ cho khách hàng';

    const READ_BEAUTIES = 'Xem danh sách p. Spa & Grooming';
    const READ_BEAUTY = 'Xem chi tiết p. Spa & Grooming';
    const CREATE_BEAUTY = 'Thêm p. Spa & Grooming';
    const UPDATE_BEAUTY = 'Cập nhật p. Spa & Grooming';
    const CANCEL_BEAUTY = 'Hủy p. Spa & Grooming';
    const DELETE_BEAUTY = 'Xóa p. Spa & Grooming';
    const PRINT_BEAUTY = 'In p. Spa & Grooming';
    const SEND_ZNS_BEAUTY = 'Gửi zalo p. Spa & Grooming cho khách hàng';

    const READ_ROOMS = 'Xem danh sách chuồng';
    const READ_ROOM = 'Xem chi tiết chuồng';
    const CREATE_ROOM = 'Thêm chuồng';
    const UPDATE_ROOM = 'Cập nhật chuồng';
    const DELETE_ROOM = 'Xóa chuồng';

    const READ_ACCOMMODATIONS = 'Xem danh sách phiếu lưu trú';
    const READ_ACCOMMODATION = 'Xem chi tiết phiếu lưu trú';
    const CREATE_ACCOMMODATION = 'Thêm phiếu lưu trú';
    const UPDATE_ACCOMMODATION = 'Cập nhật phiếu lưu trú';
    const CANCEL_ACCOMMODATION = 'Hủy phiếu lưu trú';
    const DELETE_ACCOMMODATION = 'Xóa phiếu lưu trú';
    const PRINT_ACCOMMODATION = 'In phiếu lưu trú';
    const SEND_ZNS_ACCOMMODATION = 'Gửi zalo phiếu lưu trú cho khách hàng';

    const READ_POSTS = 'Xem danh sách bài viết';
    const READ_POST = 'Xem chi tiết bài viết';
    const CREATE_POST = 'Thêm bài viết';
    const SORT_POST = 'Sắp xếp bài viết';
    const UPDATE_POST = 'Cập nhật bài viết';
    const DELETE_POST = 'Xóa bài viết';
    const DELETE_POSTS = 'Xóa hàng loạt bài viết';

    const READ_CATEGORIES = 'Xem danh sách chuyên mục';
    const CREATE_CATEGORY = 'Thêm chuyên mục';
    const SORT_CATEGORY = 'Sắp xếp chuyên mục';
    const UPDATE_CATEGORY = 'Cập nhật chuyên mục';
    const DELETE_CATEGORY = 'Xóa chuyên mục';
    const DELETE_CATEGORIES = 'Xóa hàng loạt chuyên mục';

    const READ_IMAGES = 'Xem danh sách hình ảnh';
    const READ_IMAGE = 'Xem chi tiết hình ảnh';
    const CREATE_IMAGE = 'Thêm hình ảnh';
    const UPDATE_IMAGE = 'Cập nhật hình ảnh';
    const DELETE_IMAGE = 'Xóa hình ảnh';
    const DELETE_IMAGES = 'Xóa hàng loạt hình ảnh';

    const READ_WORKS = 'Xem danh sách chấm công';
    const READ_WORK = 'Xem chi tiết chấm công';
    const CREATE_WORK = 'Sắp lịch chấm công';
    const UPDATE_WORK = 'Cập nhật thời gian chấm công';
    const SUMMARY_WORK = 'Xem tổng kết tháng';

    const READ_ANIMALS = 'Xem danh sách động vật';
    const CREATE_ANIMAL = 'Thêm động vật';
    const UPDATE_ANIMAL = 'Cập nhật động vật';
    const DELETE_ANIMAL = 'Xóa động vật';
    const DELETE_ANIMALS = 'Xóa hàng loạt động vật';

    const READ_LOCALS = 'Xem danh sách địa phương';
    const CREATE_LOCAL = 'Thêm địa phương';
    const UPDATE_LOCAL = 'Cập nhật địa phương';
    const DELETE_LOCAL = 'Xóa địa phương';
    const DELETE_LOCALS = 'Xóa hàng loạt địa phương';

    const READ_COMPANIES = 'Xem danh sách công ty';
    const CREATE_COMPANY = 'Thêm công ty';
    const UPDATE_COMPANY = 'Cập nhật công ty';
    const DELETE_COMPANY = 'Xóa công ty';
    const DELETE_COMPANIES = 'Xóa hàng loạt công ty';

    const READ_SYMPTOMS = 'Xem danh sách triệu chứng';
    const CREATE_SYMPTOM = 'Thêm triệu chứng';
    const UPDATE_SYMPTOM = 'Cập nhật triệu chứng';
    const DELETE_SYMPTOM = 'Xóa triệu chứng';
    const DELETE_SYMPTOMS = 'Xóa hàng loạt triệu chứng';

    const READ_VERSIONS = 'Xem danh sách phiên bản';
    const CREATE_VERSION = 'Thêm phiên bản';
    const UPDATE_VERSION = 'Cập nhật phiên bản';
    const DELETE_VERSION = 'Xóa phiên bản';

    const READ_MEDICINES = 'Xem danh sách thuốc';
    const READ_MEDICINE = 'Xem chi tiết thuốc';
    const CREATE_MEDICINE = 'Thêm thuốc';
    const UPDATE_MEDICINE = 'Cập nhật thuốc';
    const DELETE_MEDICINE = 'Xóa thuốc';
    const DELETE_MEDICINES = 'Xóa hàng loạt thuốc';

    const READ_EXPENSES = 'Xem danh sách phiếu chi';
    const READ_EXPENSE = 'Xem chi tiết phiếu chi';
    const CREATE_EXPENSE = 'Thêm phiếu chi';
    const UPDATE_EXPENSE = 'Cập nhật phiếu chi';
    const DELETE_EXPENSE = 'Xóa phiếu chi';
    const DELETE_EXPENSES = 'Xóa hàng loạt phiếu chi';
    const APPROVE_EXPENSE = 'Duyệt phiếu chi';

    protected $appends = ['code', 'fullName', 'statusStr', 'genderStr', 'fullAddress', 'avatarUrl'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'avatar',
        'phone',
        'email',
        'gender',
        'password',
        'birthday',
        'address',
        'scores',
        'local_id',
        'status',
        'last_login_at',
        'note',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];


    public function customer_transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id');
    }

    public function cashier_transactions()
    {
        return $this->hasMany(Transaction::class, 'cashier_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'main_branch');
    }

    public function _branch()
    {
        return $this->belongsTo(Branch::class, 'main_branch')->withTrashed();
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }

    public function imports()
    {
        return $this->hasMany(Import::class);
    }

    public function exports()
    {
        return $this->hasMany(Export::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'author_id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    public function _local()
    {
        return $this->belongsTo(Local::class, 'local_id')->withTrashed();
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class);
    }

    public function _notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_id')->withTrashed();
    }

    public function works()
    {
        return $this->hasMany(Work::class, 'user_id');
    }

    public function debtOrders()
    {
        return $this->hasMany(Order::class, 'customer_id')->get()->filter(function ($order) {
            return $order->total > $order->paid;
        });
    }

    public function getDebt()
    {
        return $this->orders->sum('total') - $this->orders->sum('paid');
    }

    public function getAveragePaymentDelay()
    {
        $now = Carbon::now();

        // Lấy danh sách các đơn hàng của khách hàng
        $orders = $this->orders()->with(['transactions' => function ($query) {
            $query->whereNull('deleted_at');
        }])->whereNull('deleted_at')->get();

        $delays = [];

        foreach ($orders as $order) {
            if ($order->transactions->isNotEmpty()) {
                // Lấy ngày thanh toán cuối cùng
                $lastTransactionDate = $order->transactions->max('created_at');
                $delay = Carbon::parse($order->created_at)->diffInDays(Carbon::parse($lastTransactionDate));
            } else {
                // Tính từ ngày tạo đơn hàng đến hiện tại
                $delay = Carbon::parse($order->created_at)->diffInDays($now);
            }
            $delays[] = $delay;
        }

        // Tính độ trễ trung bình
        if (count($delays) > 0) {
            $averageDelay = array_sum($delays) / count($delays);
        } else {
            $averageDelay = 0;
        }

        return $averageDelay;
    }

    public function getCodeAttribute()
    {
        return 'U' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getFullNameAttribute()
    {
        $str = '<span class="' . ($this->deleted_at ? 'text-danger' : 'text-primary') . '">' . $this->name . '</span>';
        return $str;
    }

    public function getStatusStrAttribute()
    {
        return ($this->status) ? 'Active' : 'Inactive';
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address ? $this->address . ', ' : '';
        $location = $this->local ? ($this->local->district . ', ' . $this->local->city) : '';
        $fullAddress = $address . $location;
        return $fullAddress ?: "Unknown";
    }

    public function getAvatarUrlAttribute()
    {
        $path = 'public/user/' . $this->avatar;
        if ($this->avatar && Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE') . '/user/' . $this->avatar);
        } else {
            $image = asset('admin/images/placeholder_key.png');
        }
        return $image;
    }

    public function getGenderStrAttribute()
    {
        switch ($this->gender) {
            case '2':
                $result = 'Other';
                break;
            case '1':
                $result = 'Female';
                break;
            case '0':
                $result = 'Male';
                break;
            default:
                $result = 'Unknown';
                break;
        }
        return $result;
    }

    public function assignWarehouse($warehouse)
    {
        $result = DB::table('user_warehouse')->insert([
            'user_id' => $this->id,
            'warehouse_id' => $warehouse
        ]);
        return $result;
    }

    public function syncWarehouses($warehouses)
    {
        DB::table('user_warehouse')->where('user_id', $this->id)->delete();
        $array = $warehouses ?? [];
        foreach ($array as $index => $warehouse) {
            $this->assignWarehouse($warehouse);
        }
        return true;
    }

    public function assignBranch($branch)
    {
        $result = DB::table('branch_user')->insert([
            'user_id' => $this->id,
            'branch_id' => $branch
        ]);
        $this->main_branch = $branch;
        $this->save();
        return $result;
    }

    public function syncBranches($branches)
    {
        DB::table('branch_user')->where('user_id', $this->id)->delete();
        $array = $branches ?? [];
        foreach ($array as $index => $branch) {
            $this->assignBranch($branch);
        }
        return true;
    }

    public function canRemove()
    {
        if ($this->getDebt() > 0) {
            return false;
        }
        return true;
    }
}
