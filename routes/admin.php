<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AttributeNameController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\FinancialSettingController;
use App\Http\Controllers\Admin\WebsiteSetController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\ShippingRuleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppSettingsController;
use App\Http\Controllers\Admin\BannedIpController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomPageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\MarqueeController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProductCollectionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DBbackupController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\HomeSettingController;
use App\Http\Controllers\Admin\EssentialSettingController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\Hrms\ExpenseController;
use App\Http\Controllers\Admin\OtherSettingController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\NotesController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\PrinterController;
use App\Http\Controllers\Admin\SignatureController;
use App\Http\Controllers\Admin\TaxRateController;
use App\Http\Controllers\Admin\TodoController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\WarrantiesController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;



Route::get('/admin/logout', [AdminController::class, "logout"])->name('admin.logout');
Route::match(["get", "post"], '/admin/login', [AdminController::class, "login"])->name('admin.login')->middleware('auth_redirect'); // login page

// Two Step Authentication
Route::middleware(['noBackOtp'])->group(function () {
    Route::get('/verify', [AdminController::class, "verify"])->name('verify');
    Route::get('/verify-resend', [AdminController::class, "verify_resend"])->name('verify.resend');
    Route::post('verify-code', [AdminController::class, "verify_code"])->name('verify.code');
});


Route::group(["as" => 'admin.',"prefix" => '/admin', 'middleware' => ['auth:admin', 'twoFactor', 'role:SuperAdmin|Admin']], function () {
    
    Route::get('/cc', [AdminController::class, "cacheClear"])->name('cacheClear');
    Route::get('/dashboard', [AdminController::class, "dashboard"])->name('dashboard');


    //______ Category _____//
    Route::resource('/categories', CategoryController::class)->names('category')->except('show');
    Route::get('/category-data', [CategoryController::class, 'getData'])->name('category-data');
    Route::post('/categories/status', [CategoryController::class, 'changeCategoryStatus'])->name('category.status');
    Route::get('/categories/view/{id}', [CategoryController::class, 'CategoryView'])->name('category.view');
    Route::get('/categories/pdf', [CategoryController::class, 'allCategoryPdf'])->name('category.pdf');


    //______ Subcategory _____//
    Route::resource('/subcategories', SubcategoryController::class)->names('subcategory')->except('show');
    Route::get('/subcategory-data', [SubcategoryController::class, 'getData'])->name('subcategory-data');
    Route::post('/subcategory/status', [SubcategoryController::class, 'changeSubCategoryStatus'])->name('subcategory.status');
    Route::get('/subcategories/view/{id}', [SubcategoryController::class, 'subCategoryView'])->name('subcategory.view');
    Route::get('/subcategories/pdf', [SubcategoryController::class, 'allSubcategoryPdf'])->name('subcategory.pdf');


    //______ ChildCategory _____//
    Route::resource('/childCategories', ChildCategoryController::class)->names('childCategory')->except('show');
    Route::get('/childCategory-data', [ChildCategoryController::class, 'getData'])->name('childCategory-data');
    Route::post('/childCategory/status', [ChildCategoryController::class, 'changeChildCategoryStatus'])->name('childCategory.status');
    Route::get('/childCategories/view/{id}', [ChildCategoryController::class, 'childSubCategoryView'])->name('childCategory.view');
    Route::get('/childCategories/pdf', [ChildCategoryController::class, 'allChildCategoryPdf'])->name('childCategory.pdf');
    Route::post('/get/subCategory-data', [ChildCategoryController::class, 'get_subCategory_data'])->name('childCategory.subCategory.data');


    //______ Warranties _____//
    Route::resource('/warranties', WarrantiesController::class)->names('warranties')->except('show');
    Route::get('/warranties-data', [WarrantiesController::class, 'getData'])->name('warranties-data');
    Route::post('/warranties/status', [WarrantiesController::class, 'changeWarrantiesStatus'])->name('warranties.status');
    Route::get('/warranties/view/{id}', [WarrantiesController::class, 'warrantiesView'])->name('warranties.view');
    Route::get('/warranties/pdf', [WarrantiesController::class, 'allWarrantiesPdf'])->name('warranties.pdf');


    //______ Brand _____//
    Route::resource('/brands', BrandsController::class)->names('brand')->except('show');
    Route::get('/brand-data', [BrandsController::class, 'getData'])->name('brand-data');
    Route::post('/change-brand-status', [BrandsController::class, 'changeBrandStatus'])->name('brand.status');
    Route::get('/brands/view/{id}', [BrandsController::class, 'brandView'])->name('brand.view');
    Route::get('/brands/pdf', [BrandsController::class, 'allBrandsPdf'])->name('brand.pdf');


    //______ Country _____//
    Route::resource('/country', CountryController::class)->names('country')->except('show');
    Route::get('/country-data', [CountryController::class, 'getData'])->name('country-data');
    Route::post('/change-country-status', [CountryController::class, 'changeCountryStatus'])->name('country.status');
    Route::get('/country/view/{id}', [CountryController::class, 'countryView'])->name('country.view');
    Route::get('/country/pdf', [CountryController::class, 'allCountryPdf'])->name('country.pdf');
    
    
    //______ State _____//
    Route::resource('/state', StateController::class)->names('state')->except('show');
    Route::get('/state-data', [StateController::class, 'getData'])->name('state-data');
    Route::post('/change-state-status', [StateController::class, 'changeStateStatus'])->name('state.status');
    Route::get('/state/view/{id}', [StateController::class, 'stateView'])->name('state.view');
    Route::get('/state/pdf', [StateController::class, 'allStatePdf'])->name('state.pdf');


    //______ City _____//
    Route::resource('/city', CityController::class)->names('city')->except('show');
    Route::get('/city-data', [CityController::class, 'getData'])->name('city-data');
    Route::post('/change-city-status', [CityController::class, 'changeCityStatus'])->name('city.status');
    Route::get('/city/view/{id}', [CityController::class, 'cityView'])->name('city.view');
    Route::get('/city/pdf', [CityController::class, 'allCityPdf'])->name('city.pdf');


    //______ Faq _____//
    Route::resource('/faq', FaqController::class)->names('faq')->except('show');
    Route::get('/faq-data', [FaqController::class, 'getData'])->name('faq-data');
    Route::post('/change-faq-status', [FaqController::class, 'changeFaqStatus'])->name('faq.status');
    Route::get('/faq/view/{id}', [FaqController::class, 'faqView'])->name('faq.view');
    Route::get('/faq/pdf', [FaqController::class, 'allFaqPdf'])->name('faq.pdf');


    //______ Units _____//
    Route::resource('/units', UnitController::class)->names('unit')->except('show');
    Route::get('/unit-data', [UnitController::class, 'getData'])->name('unit-data');
    Route::post('/change-unit-status', [UnitController::class, 'changeUnitStatus'])->name('unit.status');
    Route::get('/units/view/{id}', [UnitController::class, 'unitView'])->name('unit.view');
    Route::get('/units/pdf', [UnitController::class, 'allUnitsPdf'])->name('unit.pdf');


    //______ Todo List _____//
    Route::resource('/todo', TodoController::class)->names('todo')->except('show');
    Route::post('/change-important-todo', [TodoController::class, 'changeImportantStatus'])->name('todo.important');
    Route::post('/todo/cross/{id}', [TodoController::class, 'todoCross'])->name('todo.cross');
    Route::get('/todo/view/{id}', [TodoController::class, 'todoView'])->name('todo.view');


    //______ Notes _____//
    Route::resource('/notes', NotesController::class)->names('note')->except('show');
    Route::post('/change-important-note', [NotesController::class, 'changeImportantStatus'])->name('note.important');
    Route::get('/notes/view/{id}', [NotesController::class, 'noteView'])->name('note.view');


    //______ Warehouse _____//
    Route::resource('/warehouse', WarehouseController::class)->names('warehouse')->except('show');
    Route::get('/warehouse-data', [WarehouseController::class, 'getData'])->name('warehouse-data');
    Route::post('/change-warehouse-status', [WarehouseController::class, 'changeWarehouseStatus'])->name('warehouse.status');
    Route::get('/warehouse/view/{id}', [WarehouseController::class, 'warehouseView'])->name('warehouse.view');
    Route::get('/warehouse/pdf', [WarehouseController::class, 'allWarehousePdf'])->name('warehouse.pdf');


    //______ HRM System _____//
    Route::group(["as" => 'hrm.',"prefix" => '/hrm'], function () {
        //______ Employee _____//
        Route::resource('/employee', EmployeeController::class)->names('employee')->except('show');
        Route::get('/employee/view/{id}', [EmployeeController::class, 'employeeView'])->name('employee.view');
        Route::get('/employee/pdf', [EmployeeController::class, 'allEmployeePdf'])->name('employee.pdf');


        //______ Designation _____//
        Route::resource('/designation', DesignationController::class)->names('designation')->except('show');
        Route::get('/designation-data', [DesignationController::class, 'getData'])->name('designation-data');
        Route::post('/change-designation-status', [DesignationController::class, 'changeDesignationStatus'])->name('designation.status');
        Route::get('/designation/view/{id}', [DesignationController::class, 'designationView'])->name('designation.view');
        Route::get('/designation/pdf', [DesignationController::class, 'allDesignationPdf'])->name('designation.pdf');


        //______ Department _____//
        Route::resource('/department', DepartmentController::class)->names('department')->except('show');
        Route::get('/department/pdf', [DepartmentController::class, 'allDepartmentPdf'])->name('department.pdf');


        //______ Payroll _____//
        Route::resource('/payroll', PayrollController::class)->names('payroll')->except('show');
        Route::get('/payroll-data', [PayrollController::class, 'getData'])->name('payroll-data');
        Route::post('/change-payroll-status', [PayrollController::class, 'changePayrollStatus'])->name('payroll.status');
        Route::get('/payroll/view/{id}', [PayrollController::class, 'payrollView'])->name('payroll.view');
        Route::get('/payroll/pdf', [PayrollController::class, 'allPayrollPdf'])->name('payroll.pdf');
    });


    //______ Role & Permission _____//
    Route::resource('/permission', PermissionController::class)->names('permission');
    Route::get('/permission-data', [PermissionController::class, 'getData'])->name('permission-data');
    
    Route::resource('/role', RoleController::class)->names('role');
    Route::resource('/admin-role', AdminRoleController::class)->names('admin-role');


    //______ Settings _____//
    Route::resource('/settings', SettingController::class)->names('settings')->except('show');
    Route::get('/email-setup', [SettingController::class, 'emailSetupIndex'])->name('email.setup');
    Route::put('/email-setting-update', [SettingController::class, 'emailConfigSettingUpdate'])->name('email.setting.update');


   //______ Other Settings  _____//
    Route::group(["as" => 'other-settings.',"prefix" => '/other-settings'], function () {
        
        //______ Database Backup _____//
        Route::get('/pull-backup', [DBbackupController::class, 'pull_backup'])->name('pull.backup');
        Route::get('/list-backup', [DBbackupController::class, 'list_backup'])->name('list.backup');
        Route::get('/backup-download/{path}', [DBbackupController::class, 'backup_download'])->name('backup.download');
        Route::get('/backup-delete/{path}', [DBbackupController::class, 'backup_delete'])->name('backup.delete');


        //______ Ban Ip Address _____//
        Route::resource('/banIp', BannedIpController::class)->names('banIp')->except('show');
        Route::get('/banIp-data', [BannedIpController::class, 'getData'])->name('banIp-data');
        Route::post('/change-banIp-status', [BannedIpController::class, 'changeBanIpStatus'])->name('banIp.status');
    });


    //______ General Settings  _____//
    Route::group(["as" => 'general-settings.',"prefix" => '/general-settings'], function () {
        
        //______ Profile Setting  _____//
        Route::get('/profile', [GeneralSettingController::class, 'profile'])->name('profile');
        Route::put('/profile-update/{id}', [GeneralSettingController::class, 'profile_update'])->name('profile.update');

        //______ Security Setting  _____//
        Route::get('/security', [GeneralSettingController::class, 'security'])->name('security');
        Route::post('/password-change', [GeneralSettingController::class, 'password_change'])->name('password-change');
        Route::post('/current-password-check', [GeneralSettingController::class, 'checkCurrentPassword'])->name('current.password.check');
        Route::post('/two-factor-status', [GeneralSettingController::class, 'twoFactorStatus'])->name('two.factor.status');

        //______ Notification Setting  _____//
        Route::get('/notification', [GeneralSettingController::class, 'notification'])->name('notification');
    });
    
    
    //______ Website Settings  _____//
    Route::group(["as" => 'website-settings.',"prefix" => '/website-settings'], function () {
        
        //______ System Setting  _____//
        Route::get('/system-settings', [WebsiteSetController::class, 'system_settings'])->name('system');
         Route::put('/system-settings-update', [WebsiteSetController::class, 'system_update'])->name('system.update');

        //______ Company Setting  _____//
        Route::get('/company-settings', [WebsiteSetController::class, 'company_settings'])->name('company');
        Route::put('/company-settings-update', [WebsiteSetController::class, 'company_update'])->name('company.update');

        //______ Localization Setting  _____//
        Route::get('/localization', [WebsiteSetController::class, 'localization'])->name('localization');
        Route::put('/localization-update', [WebsiteSetController::class, 'localization_update'])->name('localization.update');
        
        //______ Prefixes Setting  _____//
        Route::get('/prefixes', [WebsiteSetController::class, 'prefixes'])->name('prefixes');
        Route::put('/prefixes-update', [WebsiteSetController::class, 'prefixes_update'])->name('prefixes.update');
    });


    //______ App Settings  _____//
    Route::group(["as" => 'app-settings.',"prefix" => '/app-settings'], function () {
    
        //______ Invoice Setting  _____//
        Route::get('/invoice-settings', [AppSettingsController::class, 'invoice_settings'])->name('invoice');
        Route::put('/invoice-settings-update', [AppSettingsController::class, 'invoice_settings_update'])->name('invoice.setting.update');

        Route::get('/invoice-template', [AppSettingsController::class, 'invoice_template'])->name('invoice.template');

        //______ Printer Setting  _____//
        Route::resource('/printer', PrinterController::class)->names('printer')->except('show');
        Route::get('/printer-data', [PrinterController::class, 'getData'])->name('printer-data');
        Route::post('/change-printer-status', [PrinterController::class, 'changePrinterStatus'])->name('printer.status');

        //______ POS Setting  _____//
        Route::get('/pos-setting', [AppSettingsController::class, 'pos_setting'])->name('pos.setting');
        Route::put('/pos-setting-update', [AppSettingsController::class, 'pos_setting_update'])->name('pos.setting.update');

        //______ Signature  _____//
        Route::resource('/signature', SignatureController::class)->names('signature')->except('show');
        Route::get('/signature-data', [SignatureController::class, 'getData'])->name('signature-data');
        Route::post('/change-signature-status', [SignatureController::class, 'changeSignatureStatus'])->name('signature.status');
    });


    //______ System Settings  _____//
    Route::group(["as" => 'system-settings.',"prefix" => '/system-settings'], function () {

        //______ Email Setting  _____//
        Route::get('/email-settings', [SystemSettingController::class, 'email_settings'])->name('email.settings');
        Route::put('/email-update', [SystemSettingController::class, 'email_update'])->name('email.update');

         //______ Email Template  _____//
        Route::get('/email-template', [SystemSettingController::class, 'email_template'])->name('email.template');
        
        //______ Otp Setting  _____//
        Route::get('/otp', [SystemSettingController::class, 'otp_setting'])->name('otp.setting');
        Route::put('/otp-update', [SystemSettingController::class, 'otp_update'])->name('otp.update');
    });

    //______ Financial Settings _____//
    Route::group(["as" => 'financial-settings.',"prefix" => '/financial-settings'], function () {
        //______Tax Rate Setting  _____//
        Route::get('/taxRate-settings', [FinancialSettingController::class, 'taxRate_settings'])->name('taxRate.settings');
    });
   


});




// Route::middleware('setLanguage')->group(function(){

//     Route::get('/cc', [AdminController::class, "cacheClear"])->name('cacheClear');
//     Route::get('/admin/logout', [AdminController::class, "logout"]);
//     Route::match(["get", "post"], '/admin/login', [AdminController::class, "login"]); // login page


//     Route::group(["as" => 'admin.',"prefix" => '/admin', 'middleware' => ['auth:admin', 'role:SuperAdmin|Admin']], function () {

//         Route::get('/dashboards', [AdminController::class, "dashboards"])->name('dashboards');
//         Route::get('/profiles', [AdminController::class, "profiles"])->name('profiles');
//         Route::get('/profile-update', [AdminController::class, "profileUpdate"])->name('profile-update');
//         Route::put('/profile-update', [AdminController::class, "changeProfile"])->name('change-profile');
//         Route::put('/change-password', [AdminController::class, "changePassword"])->name('change-password');
//         Route::post('/current-password', [AdminController::class, "checkCurrentPassword"])->name('current-password');

//         //______ Customers _____//
//         Route::resource('/customer', CustomerController::class)->names('customer');
//         Route::get('/customer-data', [CustomerController::class, 'getData'])->name('customer-data');
//         Route::get('/customer/view/{id}', [CustomerController::class, 'customerView'])->name('customer.view');


//         //______ Contacts _____//
//         Route::resource('/contact', ContactController::class)->names('contact');
//         Route::get('/contact-data', [ContactController::class, 'getData'])->name('contact-data');
//         Route::get('/contact/view/{id}', [ContactController::class, 'contactView'])->name('contact.view');


//         //______ Subscription _____//
//         Route::resource('/subscription', SubscriptionController::class)->names('subscription');
//         Route::get('/subscription-data', [SubscriptionController::class, 'getData'])->name('subscription-data');
//         Route::get('/subscription-view', [SubscriptionController::class, 'subscriptionView'])->name('subscription-view');


//         //______ FAQ _____//
//         Route::resource('/faq', FaqController::class)->names('faq');
//         Route::get('/faq-data', [FaqController::class, 'getData'])->name('faq-data');
//         Route::post('/faq/status', [FaqController::class, 'changeFaqStatus'])->name('faq.status');
//         Route::get('/faq/view/{id}', [FaqController::class, 'faqView'])->name('faq.view');


//         //______ Slider _____//
//         Route::resource('/slider', SliderController::class)->names('slider');
//         Route::get('/slider-data', [SliderController::class, 'getData'])->name('slider-data');
//         Route::post('/slider/status', [SliderController::class, 'changeSliderStatus'])->name('slider.status');
//         Route::get('/slider/view/{id}', [SliderController::class, 'sliderView'])->name('slider.view');


//         //______ Attribute Name _____//
//         // Route::resource('/attribute-name', AttributeNameController::class)->names('attribute.name')->except(['show']);
//         // Route::get('/attribute-name/data', [AttributeNameController::class, 'getData'])->name('attribute-name.data');
//         // Route::post('/attribute-name-status', [AttributeNameController::class, 'changeStatus'])->name('attribute-name.status');


//         //______ Attribute Values _____//
//         Route::resource('/attribute-value', AttributeValueController::class)->names('attribute.value')->except(['show']);
//         Route::get('/attribute-value/data', [AttributeValueController::class, 'getData'])->name('attribute-value.data');
//         Route::post('/attribute-value-status', [AttributeValueController::class, 'changeStatus'])->name('attribute-value.status');
//         Route::get('/attribute-value/view/{id}', [AttributeValueController::class, 'attributeView'])->name('attribute-value.view');
        

//         //______ Product _____//
//         Route::resource('/product', ProductController::class)->names('product');
//         Route::get('/product-data', [ProductController::class, 'getData'])->name('product-data');
//         // Route::get('/creates', [ProductController::class, 'creates']);
//         Route::post('/change-product-status', [ProductController::class, 'changeProductStatus'])->name('product.status');

//         Route::post('/get/product/subCategory-data', [ProductController::class, 'get_product_subCategory_data'])->name('get.product.subCategory.data');
//         Route::post('/get/product/childCategory-data', [ProductController::class, 'get_product_childCategory_data'])->name('get.product.childCategory.data');

//         Route::get('/product/variant/{id}', [ProductController::class, 'product_variant'])->name('product-variant');
//         Route::put('/product/variant/{id}', [ProductController::class, 'update_product_variant'])->name('product-variant.update'); 


//         Route::put('/product-images-store/{id}', [ProductController::class, 'product_images_store'])->name('product.images.store'); 
//         Route::post('/product-images-sortable', [ProductController::class, 'product_images_sortable'])->name('product.images.sortable'); 
//         Route::delete('/multiple-image/delete/{id}', [ProductController::class, 'delete_multiple_image'])->name('multiple-image.delete'); 


//         Route::delete('/size-variants/delete/{id}', [ProductController::class, 'delete_size_variants'])->name('size.variants.delete'); 
//         Route::delete('/color-variants/delete/{id}', [ProductController::class, 'delete_color_variants'])->name('color.variants.delete'); 


//         //______ Home Settings _____//
//         Route::controller(HomeSettingController::class)->group(function () {
//             Route::get('/home-page-setting', 'index')->name('home.page.setting');
//             Route::put('/popular-category-section', 'updatePopularCategorySection')->name('popular.category.section');
//             Route::put('/product-slider-section-one', 'updateProductSliderSectionOne')->name('product.slider.section.one');
//             Route::put('/product-slider-section-two', 'updateProductSliderSectionTwo')->name('product.slider.section.two');
//             Route::put('/product-slider-section-three', 'updateProductSliderSectionThree')->name('product.slider.section.three');

//             // ajax call 
//             Route::get('/get-subCategory-data', 'get_subCategory_data')->name('get.subCategory.data');
//             Route::get('/get-childCategory-data', 'get_childCategory_data')->name('get.childCategory.data');
//         });

//         //______ Product Collection _____//
//         Route::resource('/product-collection', ProductCollectionController::class)->names('product.collection');
//         Route::get('/product-collection-data', [ProductCollectionController::class, 'getData'])->name('product-collection.data');
//         Route::post('/product-collection-change-status', [ProductCollectionController::class, 'changeCollectionStatus'])->name('product.collection.status');
//         Route::delete('/product-collection/delete/{product_id}', [ProductCollectionController::class, 'productCollectionDelete'])->name('product.collection.delete');


//         //______ Orders _____//
//         // Route::resource('/order', OrderController::class)->names('order');
//         Route::get('/order/{status}', [OrderController::class, 'index'])->name('order.index');
//         Route::get('/order-data', [OrderController::class, 'getData'])->name('order-data');
//         Route::get('/order/show/{id}', [OrderController::class, 'orderShow'])->name('order.show');
//         Route::delete('/order/destroy/{id}', [OrderController::class, 'orderDestroy'])->name('order.destroy');
//         Route::post('/order/payment-status', [OrderController::class, 'changePaymentStatus'])->name('change.payment.status');
//         Route::post('/order/order-status', [OrderController::class, 'changeOrderStatus'])->name('change.order.status');
//         Route::get('/order/invoice-pdf/{id}', [OrderController::class, 'order_invoice_pdf'])->name('order.order_invoice_pdf');


//         //______ Transactions _____//
//         Route::resource('/transaction', TransactionController::class)->names('transaction');
//         Route::get('/transaction-data', [TransactionController::class, 'getData'])->name('transaction-data');
//         Route::get('/transaction/view/{id}', [TransactionController::class, 'transactionView'])->name('transaction.view');
        

//         //______ Flash Sale _____//
//         Route::put('/flash-sale', [FlashSaleController::class, 'flashSale_index'])->name('flashSale.index');
//         Route::resource('/flash-sale-item', FlashSaleController::class)->names('flashSale.item')->except(['show']);
//         Route::get('/flash-sale-item-data', [FlashSaleController::class, 'getData'])->name('flashSale.item-data');
//         Route::post('/flash-sale-item/status', [FlashSaleController::class, 'changeFlashSaleItemStatus'])->name('flashSale.item.status');
//         Route::post('/flash-sale-item/show-home', [FlashSaleController::class, 'showFlashSaleItem'])->name('flashSale.item.show');
        

//         //______ Coupon _____//
//         Route::resource('/coupons', CouponController::class)->names('coupons');
//         Route::get('/coupon-data', [CouponController::class, 'getData'])->name('coupon-data');
//         Route::post('/change-coupon-status', [CouponController::class, 'changeCouponStatus'])->name('coupon.status');
//         Route::get('/coupons/view/{id}', [CouponController::class, 'couponView'])->name('coupon.view');


//         //______ Shipping-Rule _____//
//         Route::resource('/shipping-rule', ShippingRuleController::class)->names('shipping-rule');
//         Route::get('/shipping-rule-data', [ShippingRuleController::class, 'getData'])->name('shipping-rule-data');
//         Route::post('/change-shipping-rule-status', [ShippingRuleController::class, 'changeShippingRuleStatus'])->name('shipping-rule.status');
//         Route::get('/shipping-rule/view/{id}', [ShippingRuleController::class, 'shippingRuleView'])->name('shipping-rule.view');


//         //______ Review _____//
//         Route::resource('/reviews', ReviewController::class)->names('reviews');
//         Route::get('/review-data', [ReviewController::class, 'getData'])->name('review-data');
//         Route::post('/change-review-status', [ReviewController::class, 'changeReviewStatus'])->name('review.status');


//         //______ Custom Page _____//
//         Route::resource('/customPage', CustomPageController::class)->names('customPage');
//         Route::get('/customPage-data', [CustomPageController::class, 'getData'])->name('customPage-data');
//         Route::post('/change-customPage-status', [CustomPageController::class, 'changeCustomPageStatus'])->name('customPage.status');


//         //______ Role & Permission _____//
//         Route::resource('/permission', PermissionController::class)->names('permission');
//         Route::get('/permission-data', [PermissionController::class, 'getData'])->name('permission-data');
        
//         Route::resource('/role', RoleController::class)->names('role');
//         Route::resource('/admin-role', AdminRoleController::class)->names('admin-role');


//         //______ Settings _____//
//         Route::resource('/settings', SettingController::class)->names('settings');
//         Route::get('/email-setup', [SettingController::class, 'emailSetupIndex'])->name('email.setup');
//         Route::put('/email-setting-update', [SettingController::class, 'emailConfigSettingUpdate'])->name('email.setting.update');

//         //______ Marquee _____//
//         Route::resource('/marquee', MarqueeController::class)->names('marquee');
//         Route::get('/marquee-data', [MarqueeController::class, 'getData'])->name('marquee-data');
//         Route::post('/marquee/status', [MarqueeController::class, 'changeMarqueeStatus'])->name('marquee.status');
//         Route::get('/marquee/view/{id}', [MarqueeController::class, 'marqueeView'])->name('marquee.view');

//         //______ Essential Setting _____//
//         Route::controller(EssentialSettingController::class)->group(function () {
//             Route::get('/essential-setting', 'index')->name('essential.setting');
//             Route::put('/time-schedule', 'timeScheduleSection')->name('time.schedule');
//             Route::put('/website-rules', 'websiteRules')->name('website-rules');
//         });  

//         //______ POS _____//
//         Route::resource('/pos', PosController::class)->names('pos');

//         //______ QRCode _____//
//         Route::resource('/qrcode', QRCodeController::class)->names('qrcode');
//         Route::get('/qrcode-data', [QRCodeController::class, 'getData'])->name('qrcode-data');
//         Route::post('/qrcode/status', [QRCodeController::class, 'changeQrcodeStatus'])->name('qrcode.status');
//         Route::get('/qrcode/view/{id}', [QRCodeController::class, 'qrcodeView'])->name('qrcode.view'); 
            
//         /****************************
//         *      All HRMS Modules
//         ******************************/
//         Route::group(["as" => 'hrms.',"prefix" => '/hrms'], function () {

//             //______ Expense _____//
//             Route::resource('/expense', ExpenseController::class)->names('expense');
//             Route::get('/expense-data', [ExpenseController::class, 'getData'])->name('expense-data');
//             Route::post('/expense/status', [ExpenseController::class, 'changeExpenseStatus'])->name('expense.status');
//             Route::get('/expense/view/{id}', [ExpenseController::class, 'expenseView'])->name('expense.view');


//             //______ Payroll _____//
//             Route::get('/multi', function (){
//                 return view('backend.pages.hrms.multi.index');
//             })->name('multi');

//             Route::get('/elementor', function (){
//                 return view('backend.pages.elementor.index');
//             })->name('elementor');
//         });
//     });


// });