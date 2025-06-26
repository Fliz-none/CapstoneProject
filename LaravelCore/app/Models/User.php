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
    const READ_DASHBOARD = 'Read dashboard';
    const READ_CHATS = 'Read chats';
    const ACCESS_ADMIN = 'Access admin panel';
    const UPDATE_ADMIN = 'Update admin information';
    const READ_SETTINGS = 'Access settings page';
    const READ_LOGS = 'Read system logs';

    const READ_ROLES = 'Read roles list';
    const READ_ROLE = 'Read role details';
    const CREATE_ROLE = 'Create role';
    const UPDATE_ROLE = 'Update role';
    const DELETE_ROLE = 'Delete role';
    const DELETE_ROLES = 'Delete multiple roles';

    const READ_USERS = 'Read user list';
    const READ_USER = 'Read user details';
    const CREATE_USER = 'Create user';
    const UPDATE_USER = 'Update user';
    const PASSWORD_USER = 'Change user password';
    const SWITCH_USER = 'Switch user status';
    const DELETE_USER = 'Delete user';
    const DELETE_USERS = 'Delete multiple users';
    const ROLE_USER = 'Assign role to user';
    const BRANCH_USER = 'Assign branch to user';
    const WAREHOUSE_USER = 'Assign warehouse to user';

    const READ_SUPPLIERS = 'Read supplier list';
    const READ_SUPPLIER = 'Read supplier details';
    const CREATE_SUPPLIER = 'Create supplier';
    const UPDATE_SUPPLIER = 'Update supplier';
    const DELETE_SUPPLIER = 'Delete supplier';
    const DELETE_SUPPLIERS = 'Delete multiple suppliers';

    const READ_BRANCHES = 'Read branch list';
    const READ_BRANCH = 'Read branch details';
    const CREATE_BRANCH = 'Create branch';
    const UPDATE_BRANCH = 'Update branch';
    const DELETE_BRANCH = 'Delete branch';
    const DELETE_BRANCHES = 'Delete multiple branches';

    const READ_WAREHOUSES = 'Read warehouse list';
    const CREATE_WAREHOUSE = 'Create warehouse';
    const UPDATE_WAREHOUSE = 'Update warehouse';
    const DELETE_WAREHOUSE = 'Delete warehouse';
    const DELETE_WAREHOUSES = 'Delete multiple warehouses';

    const READ_IMPORTS = 'Read import list';
    const READ_IMPORT = 'Read import details';
    const CREATE_IMPORT = 'Create import';
    const UPDATE_IMPORT = 'Update import';
    const DELETE_IMPORT = 'Delete import';
    const DELETE_IMPORTS = 'Delete multiple imports';
    const PRINT_IMPORT = 'Print import';
    const EXCEL_IMPORT = 'Export excel import';

    const READ_EXPORTS = 'Read export list';
    const READ_EXPORT = 'Read export details';
    const CREATE_EXPORT = 'Create export';
    const UPDATE_EXPORT = 'Update export';
    const DELETE_EXPORT = 'Delete export';
    const DELETE_EXPORTS = 'Delete multiple exports';
    const PRINT_EXPORT = 'Print export';
    const EXCEL_EXPORT = 'Export excel export';

    const READ_STOCKS = 'Read stock list';
    const READ_STOCK = 'Read stock details';
    const PRINT_STOCK = 'Print stock list';
    const EXCEL_STOCK = 'Export excel stock list';

    const READ_CATALOGUES = 'Read catalogue list';
    const CREATE_CATALOGUE = 'Create catalogue';
    const SORT_CATALOGUE = 'Sort catalogue';
    const UPDATE_CATALOGUE = 'Update catalogue';
    const DELETE_CATALOGUE = 'Delete catalogue';
    const DELETE_CATALOGUES = 'Delete multiple catalogues';

    const READ_ATTRIBUTES = 'Read attribute list';
    const CREATE_ATTRIBUTE = 'Create attribute';
    const UPDATE_ATTRIBUTE = 'Update attribute';
    const DELETE_ATTRIBUTE = 'Delete attribute';
    const DELETE_ATTRIBUTES = 'Delete multiple attributes';

    const READ_PRODUCTS = 'Read product list';
    const READ_PRODUCT = 'Read product details';
    const CREATE_PRODUCT = 'Create product';
    const SWITCH_PRODUCT = 'Switch product status';
    const UPDATE_PRODUCT = 'Update product';
    const DELETE_PRODUCT = 'Delete product';
    const DELETE_PRODUCTS = 'Delete multiple products';
    const EXCEL_PRODUCT = 'Export excel product list';

    const CREATE_VARIABLE = 'Create variable';
    const UPDATE_VARIABLE = 'Update variable';
    const DELETE_VARIABLE = 'Delete variable';

    const READ_DISCOUNTS = 'Read discount list';
    const READ_DISCOUNT = 'Read discount details';
    const CREATE_DISCOUNT = 'Create discount';
    const UPDATE_DISCOUNT = 'Update discount';
    const DELETE_DISCOUNT = 'Delete discount';
    const DELETE_DISCOUNTS = 'Delete multiple discount';

    const READ_ORDERS = 'Read order list';
    const READ_ORDER = 'Read order details';
    const CREATE_ORDER = 'Create order';
    const UPDATE_ORDER = 'Update order';
    const CANCEL_ORDER = 'Cancel order';
    const DELETE_ORDER = 'Delete order';
    const DELETE_ORDERS = 'Delete multiple orders';
    const EXCEL_ORDERS = 'Export excel order list';
    const EXCEL_ORDER = 'Export excel order details';
    const PRINT_ORDER = 'Print order';

    const UPDATE_ORDER_DETAIL = 'Update order detail';
    const DELETE_ORDER_DETAIL = 'Delete order detail';

    const READ_DEBTS = 'Read debt list';
    const READ_TRANSACTIONS = 'Read transaction list';
    const READ_TRANSACTION = 'Read transaction details';
    const CREATE_TRANSACTION = 'Create transaction';
    const UPDATE_TRANSACTION = 'Update transaction';
    const DELETE_TRANSACTION = 'Delete transaction';
    const DELETE_TRANSACTIONS = 'Delete multiple transactions';

    const READ_POSTS = 'Read post list';
    const READ_POST = 'Read post details';
    const CREATE_POST = 'Create post';
    const SORT_POST = 'Sort post';
    const UPDATE_POST = 'Update post';
    const DELETE_POST = 'Delete post';
    const DELETE_POSTS = 'Delete multiple posts';

    const READ_CATEGORIES = 'Read category list';
    const CREATE_CATEGORY = 'Create category';
    const SORT_CATEGORY = 'Sort category';
    const UPDATE_CATEGORY = 'Update category';
    const DELETE_CATEGORY = 'Delete category';
    const DELETE_CATEGORIES = 'Delete multiple categories';

    const READ_IMAGES = 'Read image list';
    const READ_IMAGE = 'Read image details';
    const CREATE_IMAGE = 'Create image';
    const UPDATE_IMAGE = 'Update image';
    const DELETE_IMAGE = 'Delete image';
    const DELETE_IMAGES = 'Delete multiple images';

    const READ_WORKS = 'Read work list';
    const READ_WORK = 'Read work details';
    const CREATE_WORK = 'Create work';
    const UPDATE_WORK = 'Update work';
    const SUMMARY_WORK = 'Read work summary';

    const READ_LOCALS = 'Read local list';
    const CREATE_LOCAL = 'Create local';
    const UPDATE_LOCAL = 'Update local';
    const DELETE_LOCAL = 'Delete local';
    const DELETE_LOCALS = 'Delete multiple locals';

    const READ_VERSIONS = 'Read version list';
    const CREATE_VERSION = 'Create version';
    const UPDATE_VERSION = 'Update version';
    const DELETE_VERSION = 'Delete version';

    const READ_EXPENSES = 'Read expense list';
    const READ_EXPENSE = 'Read expense details';
    const CREATE_EXPENSE = 'Create expense';
    const UPDATE_EXPENSE = 'Update expense';
    const DELETE_EXPENSE = 'Delete expense';
    const DELETE_EXPENSES = 'Delete multiple expenses';
    const APPROVE_EXPENSE = 'Approve expense';

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


    /**
     * Các cuộc trò chuyện mà user là customer (one-to-many)
     */
    public function conversationsAsCustomer()
    {
        return $this->hasMany(Conversation::class, 'customer_id');
    }

    /**
     * Các cuộc trò chuyện mà user tham gia (many-to-many qua conversation_user)
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user')
                ->withPivot('role')
                ->withTimestamps();
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
        return $this->status ? __('messages.active') : __('messages.inactive');
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address ? $this->address . ', ' : '';
        $location = $this->local ? ($this->local->district . ', ' . $this->local->city) : '';
        $fullAddress = $address . $location;
        return $fullAddress ?: __('messages.unknown');
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
                $result = __('messages.unknown');
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
