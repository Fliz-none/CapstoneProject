<?php

use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BeautyController;
use App\Http\Controllers\Admin\BiochemicalController;
use App\Http\Controllers\Admin\BloodcellController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DebtController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\ExportDetailController;
use App\Http\Controllers\Admin\AccommodationController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\IndicationController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\LocalController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\MicroscopeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PrescriptionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QuicktestController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SurgeryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CriterialController;
use App\Http\Controllers\Admin\DetailController;
use App\Http\Controllers\Admin\DiseaseController;
use App\Http\Controllers\Admin\DosageController;
use App\Http\Controllers\Admin\ImportDetailController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\PrescriptionDetailController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UltrasoundController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VariableController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Admin\XrayController;
use App\Http\Controllers\Admin\SelfController;
use App\Http\Controllers\Admin\SymptomController;
use App\Http\Controllers\Admin\TrackingController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\VersionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true, 'register' => true]);

// Route::middleware(['verified'])->group(function () {
// });

Route::group(['prefix' => 'quantri'], function () {
    Route::get('/', function () { return redirect('quantri/dashboard'); })->name('admin.home');
    Route::get('login', [LoginController::class, 'index'])->name('admin.login');
    Route::get('register', [RegisterController::class, 'index'])->name('admin.register');

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('analytics', [DashboardController::class, 'analytics'])->name('admin.dashboard.analytics');
        Route::get('statistics', [DashboardController::class, 'statistics'])->name('admin.dashboard.statistics');
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('{key?}/{action?}', [OrderController::class, 'index'])->name('admin.order');
        Route::post('create', [OrderController::class, 'create'])->name('admin.order.create');
        Route::post('update', [OrderController::class, 'update'])->name('admin.order.update');
        Route::post('remove', [OrderController::class, 'remove'])->name('admin.order.remove');
    });

    Route::group(['prefix' => 'detail'], function () {
        Route::get('{key?}/{action?}', [DetailController::class, 'index'])->name('admin.detail');
        Route::post('create', [DetailController::class, 'create'])->name('admin.detail.create');
        Route::post('update', [DetailController::class, 'update'])->name('admin.detail.update');
        Route::post('remove', [DetailController::class, 'remove'])->name('admin.detail.remove');
    });

    Route::group(['prefix' => 'transaction'], function () {
        Route::get('{key?}/{action?}', [TransactionController::class, 'index'])->name('admin.transaction');
        Route::post('create', [TransactionController::class, 'create'])->name('admin.transaction.create');
        Route::post('update', [TransactionController::class, 'update'])->name('admin.transaction.update');
        Route::post('send-zns', [TransactionController::class, 'send_zns'])->name('admin.transaction.send_zns');
        Route::post('remove', [TransactionController::class, 'remove'])->name('admin.transaction.remove');
    });

    Route::group(['prefix' => 'debt'], function () {
        Route::get('{key?}', [DebtController::class, 'index'])->name('admin.debt');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('{key?}/{action?}', [UserController::class, 'index'])->name('admin.user');
        Route::post('create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('update', [UserController::class, 'update'])->name('admin.user.update');
        Route::post('update/role', [UserController::class, 'updateRole'])->name('admin.user.update.role');
        Route::post('update/password', [UserController::class, 'updatePassword'])->name('admin.user.update.password');
        Route::post('remove', [UserController::class, 'remove'])->name('admin.user.remove');
        Route::post('/changepassword', [UserController::class, 'changePassword'])->name('admin.user.changepassword');
    });

    Route::group(['prefix' => 'pet'], function () {
        Route::get('{key?}', [PetController::class, 'index'])->name('admin.pet');
        Route::post('create', [PetController::class, 'create'])->name('admin.pet.create');
        Route::post('update', [PetController::class, 'update'])->name('admin.pet.update');
        Route::post('remove', [PetController::class, 'remove'])->name('admin.pet.remove');
        Route::post('remove/avatar', [PetController::class, 'removeAvatar'])->name('admin.pet.remove.avatar');
    });

    Route::group(['prefix' => 'supplier'], function () {
        Route::get('{key?}', [SupplierController::class, 'index'])->name('admin.supplier');
        Route::post('create', [SupplierController::class, 'create'])->name('admin.supplier.create');
        Route::post('update', [SupplierController::class, 'update'])->name('admin.supplier.update');
        Route::post('remove', [SupplierController::class, 'remove'])->name('admin.supplier.remove');
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('{key?}/{action?}', [ProductController::class, 'index'])->name('admin.product');
        Route::post('/sort', [ProductController::class, 'sort'])->name('admin.product.sort');
        Route::post('/save', [ProductController::class, 'save'])->name('admin.product.save');
        Route::post('create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('update', [ProductController::class, 'update'])->name('admin.product.update');
        Route::post('remove', [ProductController::class, 'remove'])->name('admin.product.remove');
        Route::post('refill', [ProductController::class, 'refill'])->name('admin.product.refill');
        Route::post('add_catalogues', [ProductController::class, 'add_catalogues'])->name('admin.product.add_catalogues');
        Route::post('remove_catalogues', [ProductController::class, 'remove_catalogues'])->name('admin.product.remove_catalogues');
    });

    Route::group(['prefix' => 'catalogue'], function () {
        Route::get('{key?}', [CatalogueController::class, 'index'])->name('admin.catalogue');
        Route::post('/sort', [CatalogueController::class, 'sort'])->name('admin.catalogue.sort');
        Route::post('create', [CatalogueController::class, 'create'])->name('admin.catalogue.create');
        Route::post('update', [CatalogueController::class, 'update'])->name('admin.catalogue.update');
        Route::post('remove', [CatalogueController::class, 'remove'])->name('admin.catalogue.remove');
    });

    Route::group(['prefix' => 'major'], function () {
        Route::get('{key?}', [MajorController::class, 'index'])->name('admin.major');
        Route::post('/sort', [MajorController::class, 'sort'])->name('admin.major.sort');
        Route::post('create', [MajorController::class, 'create'])->name('admin.major.create');
        Route::post('update', [MajorController::class, 'update'])->name('admin.major.update');
        Route::post('remove', [MajorController::class, 'remove'])->name('admin.major.remove');
    });

    Route::group(['prefix' => 'attribute'], function () {
        Route::get('{key?}', [AttributeController::class, 'index'])->name('admin.attribute');
        Route::post('create', [AttributeController::class, 'create'])->name('admin.attribute.create');
        Route::post('update', [AttributeController::class, 'update'])->name('admin.attribute.update');
        Route::post('remove', [AttributeController::class, 'remove'])->name('admin.attribute.remove');
    });

    Route::group(['prefix' => 'variable'], function () {
        Route::get('{key?}', [VariableController::class, 'index'])->name('admin.variable');
        Route::post('create', [VariableController::class, 'create'])->name('admin.variable.create');
        Route::post('update', [VariableController::class, 'update'])->name('admin.variable.update');
        Route::post('remove', [VariableController::class, 'remove'])->name('admin.variable.remove');
    });

    Route::group(['prefix' => 'service'], function () {
        Route::get('{key?}', [ServiceController::class, 'index'])->name('admin.service');
        Route::post('/sort', [ServiceController::class, 'sort'])->name('admin.service.sort');
        Route::post('/save', [ServiceController::class, 'save'])->name('admin.service.save');
        Route::post('remove', [ServiceController::class, 'remove'])->name('admin.service.remove');
    });

    Route::group(['prefix' => 'booking'], function () {
        Route::get('{key?}/{action?}', [BookingController::class, 'index'])->name('admin.booking');
        Route::post('create', [BookingController::class, 'create'])->name('admin.booking.create');
        Route::post('update', [BookingController::class, 'update'])->name('admin.booking.update');
        Route::post('send-zns', [BookingController::class, 'send_zns'])->name('admin.booking.send_zns');
        Route::post('remove', [BookingController::class, 'remove'])->name('admin.booking.remove');
    });

    Route::group(['prefix' => 'import'], function () {
        Route::get('{key?}/{action?}', [ImportController::class, 'index'])->name('admin.import');
        Route::post('create', [ImportController::class, 'create'])->name('admin.import.create');
        Route::post('update', [ImportController::class, 'update'])->name('admin.import.update');
        Route::post('remove', [ImportController::class, 'remove'])->name('admin.import.remove');
    });

    Route::group(['prefix' => 'import_detail'], function () {
        Route::get('{key?}/{action?}', [ImportDetailController::class, 'index'])->name('admin.import_detail');
        Route::post('update', [ImportDetailController::class, 'update'])->name('admin.import_detail.update');
        Route::post('remove', [ImportDetailController::class, 'remove'])->name('admin.import_detail.remove');
    });

    Route::group(['prefix' => 'stock'], function () {
        Route::get('{key?}', [StockController::class, 'index'])->name('admin.stock');
        Route::post('create', [StockController::class, 'create'])->name('admin.stock.create');
        Route::post('update', [StockController::class, 'update'])->name('admin.stock.update');
        Route::post('remove', [StockController::class, 'remove'])->name('admin.stock.remove');
        Route::post('sync', [StockController::class, 'sync'])->name('admin.stock.sync');
    });

    Route::group(['prefix' => 'export'], function () {
        Route::get('{key?}/{action?}', [ExportController::class, 'index'])->name('admin.export');
        Route::post('create', [ExportController::class, 'create'])->name('admin.export.create');
        Route::post('update', [ExportController::class, 'update'])->name('admin.export.update');
        Route::post('remove', [ExportController::class, 'remove'])->name('admin.export.remove');
    });

    Route::group(['prefix' => 'export_detail'], function () {
        Route::get('{key?}/{action?}', [ExportDetailController::class, 'index'])->name('admin.export_detail');
        Route::post('update', [ExportDetailController::class, 'update'])->name('admin.export_detail.update');
        Route::post('remove', [ExportDetailController::class, 'remove'])->name('admin.export_detail.remove');
    });

    Route::group(['prefix' => 'info'], function () {
        Route::get('{key?}/{action?}', [InfoController::class, 'index'])->name('admin.info');
        Route::post('expand', [InfoController::class, 'expand'])->name('admin.info.expand');
        Route::post('create', [InfoController::class, 'create'])->name('admin.info.create');
        Route::post('update', [InfoController::class, 'update'])->name('admin.info.update');
        Route::post('remove', [InfoController::class, 'remove'])->name('admin.info.remove');
    });

    Route::group(['prefix' => 'indication'], function () {
        Route::get('{key?}/{action?}', [IndicationController::class, 'index'])->name('admin.indication');
        Route::post('save', [IndicationController::class, 'save'])->name('admin.indication.save');
        Route::post('remove', [IndicationController::class, 'remove'])->name('admin.indication.remove');
    });

    Route::group(['prefix' => 'quicktest'], function () {
        Route::get('{key?}/{action?}', [QuicktestController::class, 'index'])->name('admin.quicktest');
        Route::post('create', [QuicktestController::class, 'create'])->name('admin.quicktest.create');
        Route::post('update', [QuicktestController::class, 'update'])->name('admin.quicktest.update');
        Route::post('remove', [QuicktestController::class, 'remove'])->name('admin.quicktest.remove');
    });

    Route::group(['prefix' => 'ultrasound'], function () {
        Route::get('{key?}/{action?}', [UltrasoundController::class, 'index'])->name('admin.ultrasound');
        Route::post('create', [UltrasoundController::class, 'create'])->name('admin.ultrasound.create');
        Route::post('update', [UltrasoundController::class, 'update'])->name('admin.ultrasound.update');
        Route::post('remove', [UltrasoundController::class, 'remove'])->name('admin.ultrasound.remove');
    });

    Route::group(['prefix' => 'unit'], function () {
        Route::get('{key?}', [UnitController::class, 'index'])->name('admin.unit');
        Route::post('create', [UnitController::class, 'create'])->name('admin.unit.create');
        Route::post('update', [UnitController::class, 'update'])->name('admin.unit.update');
        Route::post('remove', [UnitController::class, 'remove'])->name('admin.unit.remove');
    });

    Route::group(['prefix' => 'bloodcell'], function () {
        Route::get('{key?}/{action?}', [BloodcellController::class, 'index'])->name('admin.bloodcell');
        Route::post('create', [BloodcellController::class, 'create'])->name('admin.bloodcell.create');
        Route::post('update', [BloodcellController::class, 'update'])->name('admin.bloodcell.update');
        Route::post('remove', [BloodcellController::class, 'remove'])->name('admin.bloodcell.remove');
    });

    Route::group(['prefix' => 'biochemical'], function () {
        Route::get('{key?}/{action?}', [BiochemicalController::class, 'index'])->name('admin.biochemical');
        Route::post('create', [BiochemicalController::class, 'create'])->name('admin.biochemical.create');
        Route::post('update', [BiochemicalController::class, 'update'])->name('admin.biochemical.update');
        Route::post('remove', [BiochemicalController::class, 'remove'])->name('admin.biochemical.remove');
    });

    Route::group(['prefix' => 'microscope'], function () {
        Route::get('{key?}/{action?}', [MicroscopeController::class, 'index'])->name('admin.microscope');
        Route::post('create', [MicroscopeController::class, 'create'])->name('admin.microscope.create');
        Route::post('update', [MicroscopeController::class, 'update'])->name('admin.microscope.update');
        Route::post('remove', [MicroscopeController::class, 'remove'])->name('admin.microscope.remove');
    });

    Route::group(['prefix' => 'xray'], function () {
        Route::get('{key?}/{action?}', [XrayController::class, 'index'])->name('admin.xray');
        Route::post('create', [XrayController::class, 'create'])->name('admin.xray.create');
        Route::post('update', [XrayController::class, 'update'])->name('admin.xray.update');
        Route::post('remove', [XrayController::class, 'remove'])->name('admin.xray.remove');
    });

    Route::group(['prefix' => 'surgery'], function () {
        Route::get('{key?}/{action?}', [SurgeryController::class, 'index'])->name('admin.surgery');
        Route::post('create', [SurgeryController::class, 'create'])->name('admin.surgery.create');
        Route::post('update', [SurgeryController::class, 'update'])->name('admin.surgery.update');
        Route::post('remove', [SurgeryController::class, 'remove'])->name('admin.surgery.remove');
    });

    Route::group(['prefix' => 'criterial'], function () {
        Route::get('{key?}', [CriterialController::class, 'index'])->name('admin.criterial');
        Route::post('create', [CriterialController::class, 'create'])->name('admin.criterial.create');
        Route::post('update', [CriterialController::class, 'update'])->name('admin.criterial.update');
        Route::post('remove', [CriterialController::class, 'remove'])->name('admin.criterial.remove');
    });

    Route::group(['prefix' => 'prescription'], function () {
        Route::get('{key?}/{action?}', [PrescriptionController::class, 'index'])->name('admin.prescription');
        Route::post('create', [PrescriptionController::class, 'create'])->name('admin.prescription.create');
        Route::post('update', [PrescriptionController::class, 'update'])->name('admin.prescription.update');
        Route::post('remove', [PrescriptionController::class, 'remove'])->name('admin.prescription.remove');
        Route::post('refund', [PrescriptionController::class, 'refund'])->name('admin.prescription.refund');
    });

    Route::group(['prefix' => 'prescription_detail'], function () {
        Route::post('remove', [PrescriptionDetailController::class, 'remove'])->name('admin.prescription_detail.remove');
    });

    Route::group(['prefix' => 'beauty'], function () {
        Route::get('{key?}', [BeautyController::class, 'index'])->name('admin.beauty');
        Route::post('create', [BeautyController::class, 'create'])->name('admin.beauty.create');
        Route::post('update', [BeautyController::class, 'update'])->name('admin.beauty.update');
        Route::post('remove', [BeautyController::class, 'remove'])->name('admin.beauty.remove');
    });

    Route::group(['prefix' => 'accommodation'], function () {
        Route::get('{key?}', [AccommodationController::class, 'index'])->name('admin.accommodation');
        Route::post('create', [AccommodationController::class, 'create'])->name('admin.accommodation.create');
        Route::post('update', [AccommodationController::class, 'update'])->name('admin.accommodation.update');
        Route::post('remove', [AccommodationController::class, 'remove'])->name('admin.accommodation.remove');
    });

    Route::group(['prefix' => 'tracking'], function () {
        Route::get('{key?}', [TrackingController::class, 'index'])->name('admin.tracking');
        Route::post('create', [TrackingController::class, 'create'])->name('admin.tracking.create');
        Route::post('update', [TrackingController::class, 'update'])->name('admin.tracking.update');
        Route::post('remove', [TrackingController::class, 'remove'])->name('admin.tracking.remove');
    });

    Route::group(['prefix' => 'room'], function () {
        Route::get('{key?}', [RoomController::class, 'index'])->name('admin.room');
        Route::post('create', [RoomController::class, 'create'])->name('admin.room.create');
        Route::post('update', [RoomController::class, 'update'])->name('admin.room.update');
        Route::post('remove', [RoomController::class, 'remove'])->name('admin.room.remove');
    });

    Route::group(['prefix' => 'post'], function () {
        Route::get('{key?}', [PostController::class, 'index'])->name('admin.post');
        Route::post('/sort', [PostController::class, 'sort'])->name('admin.post.sort');
        Route::post('/save', [PostController::class, 'save'])->name('admin.post.save');
        Route::post('remove', [PostController::class, 'remove'])->name('admin.post.remove');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('{key?}', [CategoryController::class, 'index'])->name('admin.category');
        Route::post('/sort', [CategoryController::class, 'sort'])->name('admin.category.sort');
        Route::post('create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('update', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::post('remove', [CategoryController::class, 'remove'])->name('admin.category.remove');
    });

    Route::group(['prefix' => 'image'], function () {
        Route::get('{key?}', [ImageController::class, 'index'])->name('admin.image');
        Route::post('/upload', [ImageController::class, 'upload'])->name('admin.image.upload');
        Route::post('update', [ImageController::class, 'update'])->name('admin.image.update');
        Route::post('/delete', [ImageController::class, 'delete'])->name('admin.image.delete');
    });

    Route::group(['prefix' => 'work'], function () {
        Route::get('{key?}', [WorkController::class, 'index'])->name('admin.work');
        Route::post('update', [WorkController::class, 'update'])->name('admin.work.update');
        Route::post('remove', [WorkController::class, 'remove'])->name('admin.work.remove');
        Route::post('timekeeping', [WorkController::class, 'timekeeping'])->name('admin.work.timekeeping');
        Route::post('schedule', [WorkController::class, 'schedule'])->name('admin.work.schedule');
    });

    Route::group(['prefix' => 'animal'], function () {
        Route::get('{key?}', [AnimalController::class, 'index'])->name('admin.animal');
        Route::post('create', [AnimalController::class, 'create'])->name('admin.animal.create');
        Route::post('update', [AnimalController::class, 'update'])->name('admin.animal.update');
        Route::post('remove', [AnimalController::class, 'remove'])->name('admin.animal.remove');
    });

    Route::group(['prefix' => 'local'], function () {
        Route::get('{key?}', [LocalController::class, 'index'])->name('admin.local');
        Route::post('create', [LocalController::class, 'create'])->name('admin.local.create');
        Route::post('update', [LocalController::class, 'update'])->name('admin.local.update');
        Route::post('remove', [LocalController::class, 'remove'])->name('admin.local.remove');
    });

    Route::group(['prefix' => 'branch'], function () {
        Route::get('{key?}', [BranchController::class, 'index'])->name('admin.branch');
        Route::post('create', [BranchController::class, 'create'])->name('admin.branch.create');
        Route::post('update', [BranchController::class, 'update'])->name('admin.branch.update');
        Route::post('remove', [BranchController::class, 'remove'])->name('admin.branch.remove');
    });

    Route::group(['prefix' => 'warehouse'], function () {
        Route::get('{key?}', [WarehouseController::class, 'index'])->name('admin.warehouse');
        Route::post('create', [WarehouseController::class, 'create'])->name('admin.warehouse.create');
        Route::post('update', [WarehouseController::class, 'update'])->name('admin.warehouse.update');
        Route::post('remove', [WarehouseController::class, 'remove'])->name('admin.warehouse.remove');
    });

    Route::group(['prefix' => 'expense'], function () {
        Route::get('{key?}', [ExpenseController::class, 'index'])->name('admin.expense');
        Route::post('create', [ExpenseController::class, 'create'])->name('admin.expense.create');
        Route::post('update', [ExpenseController::class, 'update'])->name('admin.expense.update');
        Route::post('remove', [ExpenseController::class, 'remove'])->name('admin.expense.remove');
    });

    Route::group(['prefix' => 'company'], function () {
        Route::get('{key?}', [CompanyController::class, 'index'])->name('admin.company');
        Route::post('create', [CompanyController::class, 'create'])->name('admin.company.create');
        Route::post('update', [CompanyController::class, 'update'])->name('admin.company.update');
        Route::post('remove', [CompanyController::class, 'remove'])->name('admin.company.remove');
        Route::post('login', [CompanyController::class, 'login'])->name('admin.company.login');
    });

    Route::group(['prefix' => 'log'], function () {
        Route::get('{key?}', [LogController::class, 'index'])->name('admin.log');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('{key?}', [SelfController::class, 'index'])->name('admin.profile');
        Route::post('change_avatar', [SelfController::class, 'change_avatar'])->name('admin.profile.change_avatar');
        Route::post('change_settings', [SelfController::class, 'change_settings'])->name('admin.profile.change_settings');
        Route::post('change_password', [SelfController::class, 'change_password'])->name('admin.profile.change_password');
        Route::post('change_branch', [SelfController::class, 'change_branch'])->name('admin.profile.change_branch');
    });

    Route::group(['prefix' => 'setting'], function () {
        Route::get('{key?}', [SettingController::class, 'index'])->name('admin.setting');
        Route::post('image', [SettingController::class, 'updateImage'])->name('admin.setting.image');
        Route::post('pay', [SettingController::class, 'updatePay'])->name('admin.setting.pay');
        Route::post('company', [SettingController::class, 'updateCompany'])->name('admin.setting.company');
        Route::post('email', [SettingController::class, 'updateEmail'])->name('admin.setting.email');
        Route::post('social', [SettingController::class, 'updateSocial'])->name('admin.setting.social');
        Route::post('shop', [SettingController::class, 'updateShop'])->name('admin.setting.shop');
        Route::post('expense', [SettingController::class, 'updateExpense'])->name('admin.setting.expense');
        Route::post('clinic', [SettingController::class, 'updateClinic'])->name('admin.setting.clinic');
        Route::post('website', [SettingController::class, 'updateWebsite'])->name('admin.setting.website');
        Route::post('work', [SettingController::class, 'updatework'])->name('admin.setting.work');
        Route::post('zalo', [SettingController::class, 'updateZalo'])->name('admin.setting.zalo');
        Route::post('symptom_disease', [SettingController::class, 'updateSymptom_Disease'])->name('admin.setting.symptom_disease');
        Route::post('print', [SettingController::class, 'updatePrint'])->name('admin.setting.print');
    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('{key?}', [RoleController::class, 'index'])->name('admin.role');
        Route::post('create', [RoleController::class, 'create'])->name('admin.role.create');
        Route::post('update', [RoleController::class, 'update'])->name('admin.role.update');
        Route::post('remove', [RoleController::class, 'remove'])->name('admin.role.remove');
    });

    Route::group(['prefix' => 'disease'], function () {
        Route::get('{key?}/{action?}', [DiseaseController::class, 'index'])->name('admin.disease');
        Route::post('create', [DiseaseController::class, 'create'])->name('admin.disease.create');
        Route::post('update', [DiseaseController::class, 'update'])->name('admin.disease.update');
        Route::post('remove', [DiseaseController::class, 'remove'])->name('admin.disease.remove');
    });
    Route::group(['prefix' => 'symptom'], function () {
        Route::get('{key?}', [SymptomController::class, 'index'])->name('admin.symptom');
        Route::post('create', [SymptomController::class, 'create'])->name('admin.symptom.create');
        Route::post('update', [SymptomController::class, 'update'])->name('admin.symptom.update');
        Route::post('remove', [SymptomController::class, 'remove'])->name('admin.symptom.remove');
    });
    Route::group(['prefix' => 'medicine'], function () {
        Route::get('{key?}', [MedicineController::class, 'index'])->name('admin.medicine');
        Route::post('create', [MedicineController::class, 'create'])->name('admin.medicine.create');
        Route::post('update', [MedicineController::class, 'update'])->name('admin.medicine.update');
        Route::post('remove', [MedicineController::class, 'remove'])->name('admin.medicine.remove');
    });
    Route::group(['prefix' => 'dosage'], function () {
        Route::get('{key?}', [DosageController::class, 'index'])->name('admin.dosage');
        Route::post('create', [DosageController::class, 'create'])->name('admin.dosage.create');
        Route::post('update', [DosageController::class, 'update'])->name('admin.dosage.update');
        Route::post('remove', [DosageController::class, 'remove'])->name('admin.dosage.remove');
    });
    Route::group(['prefix' => 'version'], function () {
        Route::get('{key?}/{action?}', [VersionController::class, 'index'])->name('admin.version');
        Route::post('create', [VersionController::class, 'create'])->name('admin.version.create');
        Route::post('update', [VersionController::class, 'update'])->name('admin.version.update');
        Route::post('remove', [VersionController::class, 'remove'])->name('admin.version.remove');
    });
    Route::group(['prefix' => 'notification'], function () {
        Route::post('mark', [NotificationController::class, 'mark'])->name('admin.notification.mark');
    });
});

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'auth'])->name('login.auth');
Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::get('forgot', [ForgotPasswordController::class, 'index'])->name('forgot');
Route::get('local', [HomeController::class, 'local'])->name('local');
Route::get('tim-kiem/{q?}', [HomeController::class, 'home'])->name('search');
Route::get('lien-he', [HomeController::class, 'contact'])->name('contact');
Route::get('tai-khoan', [ProfileController::class, 'profile'])->name('profile');
Route::get('tai-khoan/don-hang', [ProfileController::class, 'orders'])->name('profile.orders');
Route::get('tai-khoan/thiet-lap', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
Route::get('tai-khoan/doi-mat-khau', [ProfileController::class, 'updateSettings'])->name('profile.update.settings');
Route::get('tai-khoan', [ProfileController::class, 'profile'])->name('profile');
Route::get('don-hang', [ProfileController::class, 'orders'])->name('orders');
Route::get('gio-hang/thanh-toan', [CartController::class, 'index'])->name('checkout');
Route::get('gio-hang/thanh-toan/hoan-thanh', [CartController::class, 'index'])->name('checkout');
Route::get('cua-hang/{catalogue?}/{slug?}', [ShopController::class, 'index'])->name('shop');

Route::get('ajax/{type}{key?}', [ShopController::class, 'getAjax'])->name('ajax');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'gio-hang'], function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::get('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::get('checkout/success', [CartController::class, 'checkout'])->name('cart.checkout.success');
        Route::post('add', [CartController::class, 'add'])->name('cart.add');
        Route::post('update', [CartController::class, 'update'])->name('cart.update');
        Route::post('remove', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('clear', [CartController::class, 'clear'])->name('cart.clear');
    });
});
Route::get('{sub?}/{category?}/{post?}', [PostsController::class, 'post'])->name('post');
