<?php

namespace App\Providers;


use App\Models\Attachment;
use App\Models\Attribute;
use App\Models\Branch;
use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Models\Detail;
use App\Models\Discount;
use App\Models\Expense;
use App\Models\Export;
use App\Models\ExportDetail;
use App\Models\Image;
use App\Models\Import;
use App\Models\ImportDetail;
use App\Models\Local;
use App\Models\Log;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Variable;
use App\Models\Version;
use App\Models\Warehouse;
use App\Models\Work;
use App\Observers\AttachmentObserver;
use App\Observers\AttributeObserver;
use App\Observers\BranchObserver;
use App\Observers\CatalogueObserver;
use App\Observers\CategoryObserver;
use App\Observers\ConversationObserver;
use App\Observers\ConversationUserObserver;
use App\Observers\DetailObserver;
use App\Observers\DiscountObserver;
use App\Observers\ExpenseObserver;
use App\Observers\ExportDetailObserver;
use App\Observers\ExportObserver;
use App\Observers\ImageObserver;
use App\Observers\ImportDetailObserver;
use App\Observers\ImportObserver;
use App\Observers\LocalObserver;
use App\Observers\LogObserver;
use App\Observers\MessageObserver;
use App\Observers\NotificationObserver;
use App\Observers\OrderObserver;
use App\Observers\PostObserver;
use App\Observers\ProductObserver;
use App\Observers\RoleObserver;
use App\Observers\SettingObserver;
use App\Observers\StockObserver;
use App\Observers\SupplierObserver;
use App\Observers\TransactionObserver;
use App\Observers\UnitObserver;
use App\Observers\VariableObserver;
use App\Observers\VersionObserver;
use App\Observers\WarehouseObserver;
use App\Observers\WorkObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Observers\UserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Product::observe(ProductObserver::class);
        // Thêm các dòng tương tự cho tất cả các model:
        Attachment::observe(AttachmentObserver::class);
        Attribute::observe(AttributeObserver::class);
        Branch::observe(BranchObserver::class);
        Catalogue::observe(CatalogueObserver::class);
        Category::observe(CategoryObserver::class);
        Conversation::observe(ConversationObserver::class);
        ConversationUser::observe(ConversationUserObserver::class);
        Discount::observe(DiscountObserver::class);
        Expense::observe(ExpenseObserver::class);
        Export::observe(ExportObserver::class);
        ExportDetail::observe(ExportDetailObserver::class);
        Image::observe(ImageObserver::class);
        Import::observe(ImportObserver::class);
        ImportDetail::observe(ImportDetailObserver::class);
        Local::observe(LocalObserver::class);
        Log::observe(LogObserver::class);
        Message::observe(MessageObserver::class);
        Notification::observe(NotificationObserver::class);
        Order::observe(OrderObserver::class);
        Post::observe(PostObserver::class);
        Role::observe(RoleObserver::class);
        Setting::observe(SettingObserver::class);
        Stock::observe(StockObserver::class);
        Supplier::observe(SupplierObserver::class);
        Transaction::observe(TransactionObserver::class);
        Unit::observe(UnitObserver::class);
        Variable::observe(VariableObserver::class);
        Version::observe(VersionObserver::class);
        Warehouse::observe(WarehouseObserver::class);
        Work::observe(WorkObserver::class);
        Controller::init();
        Schema::defaultStringLength(191);
        Detail::observe(DetailObserver::class);
    }
}
