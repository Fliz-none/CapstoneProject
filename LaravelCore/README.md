# Quản lý vận hành - TruongDung Pet

Phần mềm quản lý vận hành TruongDung Pet
Truy cập website tại http://truongdungpet.com

---

-   Chủ đầu tư: CÔNG TY TNHH THƯƠNG MẠI DỊCH VỤ TRUONGDUNG PET
-   Đơn vị thực hiện: Công ty TNHH Giải pháp Công nghệ Nam Quân
-   Website đơn vị thực hiện: http://keydigital.vn
-   Năm thực hiện: 2024

---

-   Mô hình triển khai: Ứng dụng nền web
-   Ngôn ngữ lập trình: PHP, Javascript
-   Framework: Laravel 8, jQuery 3.6
-   Platform: Centos 7.9, PHP 8.0, mySQL 15.1
-   Cơ sở dữ liệu: mySQL

## 08.04.2024

UPDATE: Cập nhật tên quyền trong seeder `PermissionsTableSeeder`
UPDATE: Cập nhật tên quyền trong model `User`
UPDATE: Cập nhật giao diện trang web chính
UPDATE: Làm giàn khung cho trang admin
UPDATE: Cập nhật giao diện trang chủ

## 10.04.2024

UPDATE: Sửa lỗi link bảng tin của các trang con
UPDATE: Cập nhật chức năng đăng nhập, đăng nhập xong trả về trang chủ
UPDATE: Cập nhật chức năng đăng xuất
UPDATE: Thêm bộ role cho chuyên mục, bài viết và hình ảnh
UPDATE: Cài thêm dataTable, permissions và jessenger, laravel excel
UPDATE: Cập nhật thư viện composer
UPDATE: Thêm controller `SettingController`
UPDATE: Bố trí lại toàn bộ các route, tạo khung sườn cho hệ thống
UPDATE: Bổ sung modal image
UPDATE: Nhúng modal image vào `app.blade`
UPDATE: Sửa màu primary color
UPDATE: Hoàn thiện chức năng thêm sửa xóa hình ảnh
FIXBUG: Sửa lỗi datatable không load đúng thư viện JS ~> CSS bị lỗi
FIXBUG: Sửa lỗi hết session không trả ra được trang login
UPDATE: Cập nhật thêm phần image, đã upload và xem được hình ảnh
UPDATE: Xóa và xóa hàng loạt hình ảnh trong thư viện

## 10.04.2024

FIXBUG: Giao diện quên mật khẩu, giao diện reset mật khẩu, giao diện xác thực
UPDATE: Xóa migration `indications`
UPDATE: Xóa Model `Indication`
UPDATE: Cập nhật hàm `load` trong Controller `PetController`
UPDATE: Cập nhật hàm `remove` trong Controller `PetController`
UPDATE: Thêm trường `unsignedBigInteger('branch_id')` - Khóa ngoại của bảng `branches` vào các migration
`warehouses, logs, infos, quicktests, ultrasounds, beauties, biochemicals, bloodcells, microscopes, xrays, surgeries, treatments, prescriptions, rooms`
UPDATE: Thêm mối quan hệ với `Branch` thông qua hàm `branch` vào các Model
`Warehouse, Log, Info, Quicktest, Ultrasound, Beauty, Biochemical, Bloodcell, Microscope, Xray, Surgery, Treatment, Prescription, Room`
UPDATE: Thêm trường `unsignedBigInteger('info_id')` - Khóa ngoại của bảng `info` vào migration `orders`
UPDATE: Thêm các hàm quan hệ
`indications, warehouses, logs, infos, quicktests, ultrasounds, beauties,biochemicals, bloodcells, microscopes, xrays, surgeries, treatments, prescriptions, rooms`
của `Branch` với các bảng khác vào Model `Branch`
UPDATE: Cập nhật dữ liệu mẫu vào seeder `SampleDataSeeder
UPDATE: Di chuyển tất cả modal ra `app.blade`UPDATE: ĐỔi quan hệ giữa`Product`và`Attribute`từ một nhiều thành nhiều nhiều
    - Tạo thêm bảng`attribute_product`và ràng buộc khóa ngoại
    - Đổi quan hệ`attributes()`trong model`Product`thành belongsToMany
    - Đổi quan hệ`products()`trong model`Attribute`thành belongsToMany
UPDATE: Tạo tên đối tượng cố định cho mỗi controller
UPDATE: Tách`Product`và`Service`thành 2 đối tượng riêng biệt
    - Tạo bảng`services`và model`Service`
    - Tách các trường trong bảng`products`ra bảng`services`
    - Tạo bảng`criterials`và model`Criterial`
    - Tạo bảng`criterial_service`và bảng`attribute_product`
    - Tách các trường trong bảng`attributes`ra bảng`criterials`
    - Thêm các trường fillables trong model`Service`
    - Thêm các trường fillables trong model`Criterial`
    - Điều chỉnh quan hệ`Product`và`Attribute`thành nhiều - nhiều

    - Điều chỉnh quan hệ`Servce`và`Criterial`thành nhiều - nhiều

UPDATE: Thêm model`Desease`để lưu trữ các loại bệnh nhằm mục đích gợi ý bệnh cho việc chẩn đoán

    - Tạo bảng`deseases`và model`Desease`
    - Thêm các trường trong bảng`deseases`: name, symptoms, incubation, transmission, prevention, regimen

    - Thêm các trường fillables trong model `Desease`

## 11.04.2024

UPDATE: Bổ sung permission cho model `Desease`
UPDATE: Bổ sung permission cho model `Service`
UPDATE: Bổ sung permission cho model `Criterial`
FIXBUG: Sửa lỗi đặt tên quyền cho các permission liên quan đến xuất file excel
UPDATE: Thêm xem danh sách user

FIXBUG: Điều chỉnh lại dữ liệu hiển thị ở cột `last_examination_at` trong hàm `load` của Controller `PetController`
UPDATE: Thêm trường `string('lineage')` vào migration `pets`
UPDATE: Cập nhật lại dữ liệu mẫu bảng `Pet, User`

## 12.04.2024

UPDATE: Loại bỏ `card mb-3` trong tất cả modal
UPDATE: Hoàn thiện thêm sửa xóa của model `Attribute`
UPDATE: Cập nhật trạng thái các checkbox trong datatable khi thay đổi trạng thái `all-choices`
UPDATE: Đổi trạng thái nút `btn-removes` sang `process-btns` để áp dụng cho các nút hàng loạt sau này
UPDATE: Đồng bộ confirm delete cho sweetAlert
UPDATE: Bổ sung sự kiện click `btn-removes` và `btn-remove-detail`
UPDATE: Bỏ trường `branch_id` trong model `Log`
UPDATE: Đưa các nội dung validate vào `Controller` để tái sử dụng
UPDATE: Fix lỗi trong `AttributeController`
UPDATE: Hoàn thiện chức năng thêm sửa xóa cho model `Catalogue`
UPDATE: Bổ sung chức năng sort dùng chung cho các model
UPDATE: Thêm thuộc tính avatarUrl cho model `Catalogue`
UPDATE: Bổ sung chức năng chọn hình ảnh, dùng chung trong hệ thống
UPDATE: Bổ sung placeholder.webp
UPDATE: Bổ sung hàm `number_format` và `string_to_slug` trong `main.js`
UPDATE: Nhúng biến vào modal đổi thành biến `options` cho đồng bộ

UPDATE: Đổi thuộc tính `image` thành `avatarUrl` cho đồng bộ
UPDATE: Thêm class `cursor-pointer` cho `thumb`
UPDATE: Bổ sung thuộc tính `dimension` và `size` cho model `Image`, rút gọn code trong `ImageController`
UPDATE: Bổ sung class `object-fit-cover` và `object-fit-contain` cho `key.css`
UPDATE: Đổi thuộc tính `thumb` của model `Image` thành `link` để dễ sử dụng về sau
UPDATE: Đổi tên `quick_images-edit-form` thành `quick_images-update-form` cho đồng bộ
UPDATE: Đổi tên `btn-edit-image` thành `btn-update-image` cho đồng bộ
UPDATE: Hoàn thiện thêm sửa xóa của model `Category`, cập nhật lại validate cho `Catalogue`
UPDATE: Đổi tên trường của moddel `Category` order => sort, code => slug

UPDATE: Thêm migration `animals` và Model `Animal`
UPDATE: Xóa 2 trường `animal` và `lineage` trong migration `pets`
UPDATE: Thêm trường `unsignedBigInteger('animal_id')` vào migration `pets`
UPDATE: Thêm hàm `animal` trong Model `Pet` để tạo ràng buộc với `Animal`
UPDATE: Thêm hàm `pets` trong Model `Animal` để tạo ràng buộc với `Pet`
UPDATE: Thêm seeder `AmimalSeeder` để tạo dữ liệu cho cái loài động vật
UPDATE: Cập nhật giao diện modal `modal_pet`

UPDATE: Cập nhật `bootstrap.css` lên 5.1.3
FIXBUG: Sửa lỗi hàm `resetForm()` không clear `input[type=hidden]`
UPDATE: Tải MomentJS về trực tiếp trong source
UPDATE: Tích hợp thêm `select2`
UPDATE: Cập nhật giao diện bảng cho `attribute.blade` và `catalogue.blade`
FIXBUG: Dọn lại modal `pet`
FIXBUG: Sửa tên trường `species` thành `specie` trong bảng animals
FIXBUG: Sửa bảng seeder của bảng `animals`

## 12.04.2024

UPDATE: Xóa trường `location` trong migration `suppliers`
UPDATE: Thêm trường `locals_id` trong migration `suppliers`
UPDATE: Thêm hàm `local` trong Model `Supplier` để tạo ràng buộc với `Local`
UPDATE: Thêm hàm `suppliers` trong Model `Local` để tạo ràng buộc với `Supplier`
FIXBUG: Điều chỉnh dữ liệu `Supplier` trong seeder `SampleDataSeeder`
UPDATE: Cập nhật giao diện danh sách nhà cung cấp
UPDATE: Cập nhật modal `modal_supplier`

## 13.04.2024

UPDATE: Hoàn thiện thêm sửa xóa cho model `Animal`
UPDATE: Tạo model `Local` và hoàn thiện thêm sửa xóa cho `Local`
UPDATE: Thêm class `object-fit-cover` cho các ảnh trong datatables
FIXBUG: Sửa lỗi chỉ lưu nhật ký sau cùng khi xóa catalogue trong `CatalogueController`
UPDATE: Cập nhật hàm `get()` cho `UserController` để hỗ trợ select2
FIXBUG: Sửa lỗi hàm `getDimensionAttribute()` báo lỗi khi file không tồn tại trong model `Image`
UPDATE: Bổ sung thuộc tính `avatarUrl` cho model `Pet`
UPDATE: Thêm quyền `READ_SETTINGS` cho phép truy cập trang cài đặt
UPDATE: Thêm bộ quyền cho `Local` và `Animal` trong model `User` và `PermissionSeeder`
UPDATE: Cập nhật file CSS cho `select2`
UPDATE: Bổ sung tiếng Việt cho `select2`
UPDATE: Hoàn thiện xử lý chọn `khách`, `loài` và `giống` trong `pet-modal`, sử dụng `select2` mượt mà
UPDATE: Bổ sung quyền truy cập khi hiển thị `sidebar.blade`

UPDATE: Loại bỏ các thuộc tính hiển thị modal tại các nút tạo đối tượng trên blade
UPDATE: Loại bỏ các thuộc tính `aria-hidden="true" tabindex="-1"` khỏi các modal và bổ sung `data-bs-backdrop="static"`
UPDATE: Bổ sung giao diện dạng lưới cho thú cưng - Điều chỉnh cột `customer` thành `customer_info` - Điều chỉnh cột `infor` thành `info` - Thêm quan hệ `customer` và `animal` cho câu truy vấn - Đổi tên cột ID thành cột code - Đổi tên cột `last_examination_at` thành `lastest_order` - Bổ sung thuộc tính `code`, `genderStr`, `neuterStr` cho model `Pet`
UPDATE: Bổ sung thuộc tính `code` cho tất cả các `model` có tính chất giao dịch
FIXBUG: Sửa lỗi tooltip bị chớp
UPDATE: Bật tính năng khóa modal Bootstrap, không cho đóng modal khi click backdrop
FIXBUG: Sửa trường neuter của `Pet` thành kiểu dữ liệu `UnsignTinyInteger`
FIXBUG: Sửa lỗi hiển thị trạng thái triệt sản của thú cưng trên blade

## 15.04.2024

UPDATE: Thêm chức năng xóa hàng loạt thú cưng
UPDATE: Thêm xét quyền truy cập trong blade `pet.balde`
UPDATE: Kiểm tra xem người dùng có quyền cập nhật thú cưng không
UPDATE: Cập nhật chức năng cập nhật thú cưng (chưa xử lý được lưu ảnh và gán giá trị cho select2)

## 16.04.2024

FIXBUG: Sửa lỗi lưu ảnh thú cưng và hiển thị ảnh thú cưng
FIXBUG: Hiển thị giá trị cho thẻ select2 trong `modal_pet`
FIXBUG: Thay đổi điều kiện hiển thị ảnh của hàm `getAvatarUrlAttribute` trong Model `Pet`
UPDATE: Thêm nút trạng thái hoạt động vào `modal_pet`
UPDATE: Cập nhập các hàm `get`, `create`, `update` trong `UserController`
UPDATE: Sửa trường `location` thành `local_id` trong model `User`, trong `migration` và `user.blade.php`
UPDATE: Hoàn thiện các chức năng CRUD của `User`

## 17.04.2024

UPDATE: Xóa trường `local_id` trong migration `suppliers`
UPDATE: Xóa hàm `local` trong Model `Supplier`
UPDATE: Cập nhật hàm `get` trong Controller `SupplierController`
UPDATE: Cập nhật hàm `create` trong Controller `SupplierController`
UPDATE: Cập nhật hàm `update` trong Controller `SupplierController`
UPDATE: Điều chỉnh thông báo trả về của hàm `remove` trong Controller `SupplierController`
UPDATE: Cập nhật hiển thị của hàm `load` trong Controller `SupplierController`
UPDATE: Thêm thao tác reset nút submit trong hàm `resetForm` trong `public/admin/js/main.js`
UPDATE: Chuyển từ thông báo mặc định sang thông báo trả về từ controller khi thao tác gặp lỗi trong
hàm `submitForm` trong `public/admin/js/main.js`
UPDATE: Thay đổi đường dẫn lưu ảnh của `User`
UPDATE: Thêm các modal, route,.. cho chức năng cập nhật vai trò người dùng sau này
UPDATE: Thêm chức năng đổi mật khẩu

## 18.04.2024

UPDATE: Cập nhập các hàm `get`, `create`, `update` trong `WarehouseController`
UPDATE: Sửa trường `location` thành `local_id` trong model `Warehouse`, trong `migration` và `warehouse.blade.php`
UPDATE: Hoàn thiện các chức năng CRUD của `Warehouse`
UPDATE: Thay const `UPDATE_PRINT_WAREHOUSE` thành `UPDATE_WAREHOUSE` trong modwl `User`
UPDATE: Thêm `statusStr` trong model `Warehouse`
UPDATE: Cập nhật các khóa ngoại cho các bảng `User`
UPDATE: Thêm hàm `isValidRemove` trong model `User` validate xóa một bảng ghi

UPDATE: Thêm các hàm `load, get, create, update, remove, sync` vào Controller `BranchController`
UPDATE: Xóa trường `branch_id` trong các migration
`quicktests, ultrasounds, beauties, biochemicals, bloodcells, microscopes, xrays, surgeries, treatments, prescriptions`
UPDATE: Xóa hàm `branch` trong các Model
`Quicktest, Ultrasound, Beauty, Biochemical, Bloodcell, Microscope, Xray, Surgery, Treatment, Prescription`
UPDATE: Xóa các hàm
`quicktests, ultrasounds, beauties, biochemicals, bloodcells, microscopes, xrays, surgeries, treatments, prescriptions`
trong Model `Branch`
UPDATE: Thêm hàm `isValidRemove` vào Model `Branch` để kiểm tra ràng buộc của branch, và xóa các kho thuộc chi nhánh
nếu hợp lệ

## 19.04.2024

UPDATE: Chuyển đoạn script nhận action `click` của `.btn-create-catalogue` từ `catalogue.blade` sang `app.blade`
UPDATE: Thêm hàm `children` vào Model `Catalogue`
UPDATE: Thêm các hàm `createdAt, createdDate, createdTime` vào Model `Product`
UPDATE: Thêm các hàm `assignCatalog, syncCatalogs, catalogsName` vào Model `Product`
FIXBUG: Điều chỉnh hàm `getStatus` trong Model `Product` từ 2 sang 4 trạng thái
UPDATE: Cập nhật giao diện danh sách sản phẩm
UPDATE: Cập nhật giao diện sản phẩm

## 19.04.2024

UPDATE: Hoàn thiện các tính năng CRUD cho `Criterial`
UPDATE: Thêm dữ liệu mẩu cho `Criterial`

## 22.04.2024

UPDATE: Thêm dữ liệu mẩu cho `Service`  
UPDATE: Thêm model và migration cho `Major`
UPDATE: Validate cho `Criterial`
UPDATE: Tạo model `Service` và hoàn thiện xem thêm sửa xóa cho `Service`
UPDATE: Thêm trường `avatar` và `major_id` cho model `Service`
UPDATE: Thêm các quyền `READ_MAJORS`, `CREATE_MAJOR`, `SORT_MAJOR`, `UPDATE_MAJOR`, `DELETE_MAJOR`, `DELETE_MAJORS`
trong model `User`
FIXBUG: Sửa lỗi hiển thị cho `Criterial`
UPDATEL: Sửa tên hàm `isValidRemove` trong các model `Serive`, `User` thành `canRemove`

## 22.04.2024

UPDATE: Thêm thư viện `jquery.mask.js` vào `public/admin/vendors/jquery-mask`
UPDATE: Thay đổi tên hàm `isValidRemove` của Model `Branch` thành `canRemove`
UPDATE: CRUD product
UPDATE: Thêm trường `decimal('price', 10, 0)` vào migration `variables`
UPDATE: Thêm css `accordion` vào `public/admin/css/bootstrap.min.css`
UPDATE: Thêm js cho class `money` vào `public/admin/js/main.js`

## 23.04.2024

UPDATE: Sửa lại thông báo validate cho `Criterial`
UPDATE: Thêm `criterials` khi get một `Service`
UPDATE: Thêm hai hàm `assignCriterial` và `syncCriterials` cho model `Service`
UPDATE: Thêm dữ liệu mẩu cho `Major`
UPDATE: Chuyển hàm bắt sự kiện nút tạo `Criterial` sang `app.blade.php`

## 22.04.2024

UPDATE: Điều chỉnh, bố trí lại giao diện sản phẩm
UPDATE: Di chuyển js bắt thao tác `click` của `.btn-update.catalogue` từ `catalogue.blade` ra `app.blade`
UPDATE: Cập nhật thêm thuộc tính `cataloguesName` cho Model `Product`
UPDATE: Loại bỏ cột `Mô tả ngắn` trong bảng danh sách sản phẩm
UPDATE: Thêm route cho `variable`
UPDATE: Lược bỏ thao tác tạo, cập nhật variable trong hàm `save` ở Controller `ProductController`
UPDATE: Thêm thuộc tính `statusStr` cho Model `Variable`
UPDATE: Thêm modal `modal_variable.blade`

## 24.04.2024

UPDATE: Thêm các hàm `load, get, create, update, remove` trong Controller `VariableController`
UPDATE: Thêm hàm `canRemove` trong Model `Variable`
UPDATE: Xóa bảng phụ `attribute_product`
UPDATE: Thêm bảng phụ `attribute_variable`
UPDATE: Xóa quan hệ với bảng `attributes` trong Model `Product`
UPDATE: Thêm quan hệ với bảng `variables` trong Model `Attribute`
UPDATE: Thêm quan hệ với bảng `attributes` trong Model `Variable`
UPDATE: Thêm hàm `assignAttributes, syncAttributes` trong Model `Variable`
UPDATE: Cập nhật tính năng sắp xếp danh sách sản phẩm
UPDATE: Cập nhật hàm `canRemove` trong Model `Branch`

## 24.04.2024

UPDATE: Xóa `majors` trong `Controller`
UPDATE: Thêm sắp xếp trong `Service`
UPDATE: Thêm `keyword` vào `Service`
UPDATE: Thêm `select2` cho `Major`
UPDATE: Thêm ràng buộc xóa `Criterial`
UPDATE: Thêm route `get` trong `web`
UPDATE: Thêm tính năng sắp xếp theo select của `Service`

## 25.04.2024

UPDATE: Cấu trúc lại hàm `index()` của `ServiceController`
UPDATE: Cấu trúc lại hàm `index()` của `ProductController`

UPDATE: Thêm tính năng tạo sản phẩm nhanh ở giao diện danh sách sản phẩm
UPDATE: Thêm hàm `create` ở Controller `ProductController` để tạo nhanh product và variable
UPDATE: Thêm mối quan hệ với bảng `variables` trong Model `Product`
UPDATE: Thêm hàm `canRemove` trong Model `Product`
UPDATE: Cập nhật lại giao diện và thành phần của modal `modal_product.blade`
FIXBUG: Thêm điều kiện return cho hàm `load` trong Controller `VariableController`
FIXBUG: Sửa lại hàm `get` trong `MajorController`
FIXBUG: Sửa `id` thành `key` khi tạo hoặc cập nhật thành công một `Servvice`
FIXBUG: Sửa lại hàm `canRemove` trong model `User`, `Criterial`, và thêm hàm `canRemove` trong model `Post`
UPDATE: Thêm tính năng CRUD cho `Post`
UPDATE: Chuyển hai hàm bắt sự kiện để tạo và update `Category` ra `app.blade.php`
UPDATE: Định nghĩa route cho `Post` trong `web.php`
UPDATE: Chuyển các hàm bắt sự kiện `create`, `update` của pet ra `app.blade.php`
UPDATE: Include `service-modal` vào `app.blade.php`
UPDATE: Cập nhật lại `service-modal`
UPDATE: Thêm tính năng tạo dịch vụ nhanh

## 26.04.2024

UPDATE: Cập nhật hàm `index()` của `ProductController` cho phép lấy dữ liệu theo mảng ID
UPDATE: Chuyển hàm `getCatalogueChildren()` ra `Controller` - Thay đổi tham chiếu trong `Controller`, `ProductController` và `CatalogueController`
UPDATE: Bố sung `catalogueController` cho phép trả về dữ liệu phân nhánh
UPDATE: Hiển thị chữ mặc định canh trái trong các bảng danh sách dataTables
UPDATE: Bổ sung điều kiện lấy variable theo product_id trong hàm hiển thị variable trả về dataTables
UPDATE: Bổ sung thuộc tính `avatarUrl` cho model `Product`
UPDATE: Bổ sung thuộc tính `onDelete` và `onUpdate` cho bảng phụ `attribute_variable` trong migration
UPDATE: Điều chỉnh `main.js` tự động ẩn sidebar nếu chiều rộng màn hình nhỏ hơn 1441px
UPDATE: Tích hợp plugin `onScan` để phát hiện thao tác quét barcode trên hệ thống
UPDATE: Bổ sung nút chức năng refresh cây danh sách `catalogues` khi thêm catalogue từ `modal_product` và `product.blade`
UPDATE: Cập nhật rút gọn code cho phần hiển thị cây danh sách catalogues khi load `modal_product` và `product.blade`
UPDATE: Sắp xếp lại vị trí các cột trong bảng `products.blade`
UPDATE: Loại bỏ cột `email` và `last_login_at` khỏi bảng `users.blade`
UPDATE: Điều chỉnh `modal_product` - Loại bỏ `selected` trong `[name=status]` - Đổi nút `btn-create-variable-quick` thành `btn-append-variable`
UPDATE: Thêm điều kiện khi load `modal_product` và `modal_service` trong `app.blade` - Phải vừa không có biến `$product`, vừa không phải url `quantri/service/new` hoặc `quantri/product/new`
UPDATE: Đưa code js của `Product` ra ngoài `app.blade`

## 27.04.2024

UPDATE: Bổ sung cập nhật theo lựa chọn cho `Catalogue` và `Major`
FIXBUG: Điều chỉnh thông báo khi xóa đối tượng ở
UPDATE: Thêm hàm `update()` cho Controller `ProductController`
UPDATE: Thêm tính năng xóa variable trong modal `modal_product.blade`
UPDATE: Thay đổi cách gán giá trị cho `product_id` của modal `modal_variable.blade` trong `product.blade` khi
`click` vào `btn-create-variable` hoặc `btn-update-variable`
UPDATE: Thay đổi phương thức bắt `focus` và `blur` của `.money` trong `main.js`
UPDATE: Cập nhật lại `modal_service`
UPDATE: Cập nhật lại nút tạo dịch vụ nhanh
FIXBUG: Sửa ràng buộc xóa và cập nhật xóa các hàm trong
`ServiceController`, `MajorController`, `UserController`, `CriterialController`, `WarehouseController`

## 28.04.2024

UPDATE: Tái cấu trúc toàn bộ phần truy cập, đọc và get dữ liệu - Loại bỏ route get và load của tất cả các đối tượng - Gộp hàm `get()` và `load()` trong Controller của tất cả đối tượng vào hàm index xét theo cấu trúc điều kiện - Chuyển tất cả tên blade hiển thị danh sách datatable thành số nhiều
UPDATE: Bổ sung hàm `getSettings()` trong `Controller` truy xuất dữ liệu từ cache, giảm tải cho DB
UPDATE: Cập nhật cấu trúc tên đối tượng cho phần FrontEnd
UPDATE: Cập nhật cấu trúc đường dẫn cho các trang trong phần FrontEnd
UPDATE: Thêm hiệu ứng `:hover` khi di chuột upload ảnh avatar trực tiếp
UPDATE: Điều chỉnh cột hiển thị của danh sách `PetController`
UPDATE: Bổ sung thuộc tính `neuterIcon` cho model `Pet`
FIXBUG: Sửa lỗi không thể tìm kiến theo quan hệ của dataTables
UPDATE: Cài thêm `predis` để xử lý dữ liệu dạng NoSql
UPDATE: Cập nhật cách xử lý dữ liệu của các `permisisons` trong bảng datatable `RoleController`
UPDATE: Cập nhật cách xử lý dữ liệu của các đối tượng khi lọc từ select2

## 29.04.2024

UPDATE: Cấu trúc lại đường dẫn website, điều chỉnh css trên mobile cho sidebar

## 11.06.2024

UPDATE: Bổ sung quan hệ cho các object đã xóa - Thêm `_doctor()`, `_detail()` cho `Beauty` v.v... - Tất cả các quan hệ truy vấn ngược đều được thêm một quan hệ tương đương bao gồm cả các phần tử đã bị xóa (deleted_at IS NOT NULL)
UPDATE: Hoàn thiện `ExportController` - Khởi tạo hàm `index()`, `create()`, `update()`, `sync()`, `remove()`, `remove_exec()` - Bóc tách các quy tắc xác minh dữ liệu (validation rules) thành hằng riêng trong `ExportController` - Hàm `create()` và `update()` bổ sung xử lý các `ExportDetail` khi tạo mới hoặc cập nhật
UPDATE: Khởi tạo `ExportDetailController` - Khởi tạo hàm `index()`, `sync()`, `remove()`, `remove_exec()` - Hàm `sync()` thêm thao tác cập nhật stock dựa vào số lượng truyền vào
UPDATE: Hoàn thiện `ImportController` - Khởi tạo hàm `index()`, `create()`, `update()`, `sync()`, `remove()`, `remove_exec()` - Bóc tách các quy tắc xác minh dữ liệu (validation rules) thành hằng riêng trong `ImportController` - Hàm `create()` và `update()` bổ sung xử lý các `ImportDetail` khi tạo mới hoặc cập nhật
UPDATE: Khởi tạo `ImportDetailController` - Khởi tạo hàm `index()`, `sync()`, `remove()`, `remove_exec()` - Hàm `sync()` thêm thao tác cập nhật stock dựa vào số lượng truyền vào
UPDATE: `ProductController` không yêu cầu barcode nữa
UPDATE: `ProductController` không yêu cầu tên biến thể và mã phụ nữa
UPDATE: Hoàn thiện `StockController` - Khởi tạo hàm `index()`, `update()`, `sync()`, `remove()`, `remove_exec()`
UPDATE: Điều chỉnh `SuppplierController::index()` gộp các hàm đọc dữ liệu về 1 hàm `index()` duy nhất
UPDATE: Điều chỉnh `VariableController::index()` gộp các hàm đọc dữ liệu về 1 hàm `index()` duy nhất
UPDATE: Thêm quyền xem chi tiết tồn kho vào CSDL và update `User`
UPDATE: Thêm symlink vào public cho storage/pet và storage/user
UPDATE: Thêm bảng `user_warehouse` để quản lý nhân sự của một kho
UPDATE: Thêm bảng `branch_user` để quản lý nhân sự của một chi nhánh
UPDATE: Thêm bảng `product_catalogue` để quản lý các sản phẩm của từng danh mục
UPDATE: Thêm bảng `critical_service` để quản lý các dịch vụ của từng chuyên môn
FIXBUG: Load lại datatables sau khi `submitForm()` vẫn giữ nguyên trạng thái hiển thị của bảng $(this).DataTable().ajax.reload(null, false)
FIXBUG: Sửa lỗi lưu gender, neuter khi không có trong request của PetController
UPDATE: Validate password - Tối thiểu 8 ký tự - Phải có 1 ký tự viết hoa - 1 ký tự viết thường - 1 chữ số - 1 ký tự đặc biệt - Mật khẩu mới không được trùng với mật khẩu cũ - Mật khẩu mới không được có 3 ký tự hoặc ký số liên tục
UPDATE: Thêm trường `scores` cho User
UPDATE: Cập nhật `neuterStr` và `genderStr` cho `Pet`
UPDATE: Tạo tài khoản không bắt buộc phải có email
UPDATE: Xử lý hiển thị `select2()` sau khi `submitForm()`
UPDATE: Thêm class `.select2` cho tất cả các thẻ select có sử dụng select2
UPDATE: Bổ sung giới tính khác và triệt sản khác cho giao diện `Pet`
UPDATE: Bổ sung tính năng thêm thú cưng cho user ngay trong quản lý tài khoản
UPDATE: Câp nhật hàm `updateAvatar()`, `updateRole()` và `changePassword()` của `UserController`
UPDATE: Cập nhật tính năng phân quyền, phân bổ nhân sự kho, phân bổ nhân sự cửa hàng cho giao diện - Khởi tạo modal user_role, user_password - Đưa các phần javascript xử lý user ra app.blade - Thêm các route hỗ trợ cập nhật mật khẩu và tài khoản

## 15.06.2024

UPDATE: Bổ sung compressorjs để nén ảnh
UPDATE: Cập nhật nén ảnh trước khi upload lên thư viện
UPDATE: Cập nhật nén ảnh khi chọn ảnh avatar
UPDATE: Chuyển barcode vào variable, bỏ barcode trên sản phẩm
UPDATE: Bỏ qua check CSRF khi login
UPDATE: Upload ảnh trực tiếp khi tạo sản phẩm nhanh
UPDATE: Bổ sung Middleware isAdmin
UPDATE: Bổ sung Middleware HttpsProtocol
UPDATE: Bổ sung Middleware GlobalSettings
UPDATE: Chuyển User, Pet và Product datatables sang Eloquent
UPDATE: Cập nhật tìm kiếm datatables cho các model trên

## 16.06.2024

UPDATE: Hoàn thiện thêm sản phẩm, up hình trực tiếp khi thêm nhanh sản phẩm
UPDATE: Thêm phần phân bổ chi nhánh và kho cho user
UPDATE: Code lại giao diện nhập hàng
UPDATE: Sửa tên quyền trong seeder và DB
UPDATE: Hoàn thiện phần nhập sản phẩm

## 19.06.2024

UPDATE: Cập nhật giao diện website bán hàng - Thêm phương thức `HomeController::getAjax()` để lấy dữ liệu sản phẩm hiển thị lên website
UPDATE: Xây chức năng bán hàng POS
UPDATE: Xử lý hiển thị đơn hàng
UPDATE: Xây dựng hoàn thiện giao diện bán hàng POS
UPDATE: Thêm ràng buộc trùng barcode khi nhập trùng và khi trùng với DB
UPDATE: Thêm chức năng syncWarehouses và syncBranch cho user
UPDATE: Thêm dealer_id cho `orders` trong DB
UPDATE: Sửa `product_id` thành `service_id` trong `order_details`
UPDATE: CSS cho thanh trượt
UPDATE: Cập nhật hiển thị tiền khi focus() vào bất kỳ input .money nào
UPDATE: Fix giao diện website trang sản phẩm - Chuyển `HomeController::getAjax()` sang `ShopController::getAjax()` - Bổ sung file catalogue_recursion.blade

## 21.06.2024

UPDATE: Gom các xử lý lỗi get ajax về một mối ajaxSetup
UPDATE: Tạo giao diện bài viết cho web
UPDATE: Chuyển code thành slug hết trong tất cả dữ liệu liên quan đến post
UPDATE: Cập nhật lại trạng thái bài viết và trang thái sản phẩm cho hợp lý hơn
UPDATE: Bổ sung giảm giá bằng % với card và tab trên giao diện POS
UPDATE: Bổ sung phần xử lý khách hàng cho giao diện bán hàng POS - Thêm thuộc tính `debt`, `getAveragePaymentDelay()` cho `User` - Thêm cột `discount` cho `Order` và `Detail`
UPDATE: Bổ sung giảm giá bằng % với card và tab trên giao diện POS

## 24.06.2024

UPDATE: Lưu được đơn hàng vào CSDL và xử lý nhập xuất tồn
UPDATE: Thêm hàm `sync()` cho `DetailController`
UPDATE: Hoàn thiện phần xem danh sách phiếu xuất hàng
UPDATE: Hoàn thiện chức năng xóa phiếu xuất hàng (có xét điều kiện)
UPDATE: Hoàn thiện chức năng xóa chi tiết xuất hàng (có xét điều kiện)
UPDATE: Hoàn thiện phần xem danh sách phiếu nhập hàng
UPDATE: Hoàn thiện chức năng xóa phiếu nhập hàng (có xét điều kiện)
UPDATE: Hoàn thiện phần xem danh sách đơn hàng
UPDATE: Sửa lỗi vặt (code -> slug) của model Post
UPDATE: Xác thực kho hàng xuất bán theo cửa hàng
UPDATE: Xác thực kho hàng nhập theo danh sách kho của người dùng
UPDATE: Khởi tạo trường chi nhánh mặc định cho người dùng
UPDATE: Xây dựng chức năng tạo giao dịch
UPDATE: Đề xuất lịch sử khách hàng cho giao diện POS
UPDATE: Thêm các thuộc tính phái sinh cho model `Export`, `ExportDetail`, `Import`, `Stock`, `Order`, `User`
UPDATE: Hoàn thiện giao diện xuất hàng toàn màn hình
UPDATE: Xử lý các tính năng giảm giá cho card và tab trên giao diện POS
UPDATE: Bổ sung xử lý barcode cho quá trình xuất hàng
UPDATE: Tận dụng quan hệ cho các tính năng update, không cần gọi ajax thứ cấp
UPDATE: Update giao diên bài viết, sản phẩm
UPDATE: Bỏ `warehouse_id` trong `Export`

## 26.06.2024

UPDATE: Điều chỉnh stocks.quantity cho phép số âm
UPDATE: Điều chỉnh `transactions`.`customer_id` cho phép null
UPDATE: Loại bỏ các cột thời gian trong bảng `settings`
UPDATE: Loại bỏ softDelete trong model `Setting`
UPDATE: Cho phép giảm giá cho từng hàng hóa của đơn hàng
UPDATE: Cho phép giảm giá trên tổng đơn hàng
UPDATE: Điều chỉnh phản hồi chưa phân quyền thành lỗi 422 trên tất cả controller
UPDATE: Thêm tác vụ in sau khi tạo đơn hàng thành công
FIXBUG: Fix lỗi chọn gói tồn kho khi thêm vào đơn hàng hoặc xuất hàng
UPDATE: Xử lý tạo nhiều đơn hàng cùng lúc (thêm tab)
UPDATE: Tối đa được tạo 5 đơn hàng cùng lúc
FIXBUG: Sửa lỗi thông báo trùng barcode với sản phẩm đã xóa

## 05.07.2024

UPDATE: Xong phần quản lý (thêm sửa xóa đơn hàng)
UPDATE: Bỏ order_id ra khỏi Model `Export`
UPDATE: Thêm order_id cho Model `ExportDetail`
UPDATE: Thêm HSD (nếu có cho các card hàng hóa lấy ra)
UPDATE: Hiển thị gợi ý thanh toán ngay khi chọn tiền mặt
UPDATE: Thêm `realPrice` cho `OrderDetail` tính đơn giá thực tế dựa trên price và discount
UPDATE: Note cho phiếu xuất hàng chuyển lại thành text
UPDATE: Bỏ route create và update trong `OrderController`, gom hết về save
UPDATE: Thêm chức năng xem các công nợ
UPDATE: Thêm chức năng xem, thêm, sửa, xóa thanh toán
UPDATE: Truy vấn gói tồn kho để thêm vào đơn hàng dựa vào ngày hết hạn và ngày tạo, ưu tiên ngày hết hạn
UPDATE: Thêm nút download excel cho DataTables
UPDATE: Hiển thị ngày hết hạn của gói tồn kho lên chi tiết đơn hàng
UPDATE: Sắp xếp lại cho breadcrumb chuyển xuống dưới page title trong phần Admin
UPDATE: Cài đặt daterang-picker
UPDATE: Làm giao diện bảng tin
UPDATE: Get một số dữ liệu quan trọng (chưa trình bày)
UPDATE: Kéo breadcrumb trang trong admin về bên trái trên giao diện mobile

## 14.07.2024

UPDATE: Loại bỏ hàm Controller::options()

-   Loại bỏ gọi biến $option khỏi tất cả các hàm index() của Object Controller
-   Những chỗ nào triển khai select2 được thì triển khai luôn
-   Những chỗ đơn giản thì gọi Model trực tiếp trong blade
    UPDATE: Bổ sung phần profile trong trang admin
    FIXBUG: Fix lỗi hàm totalOrder() trong blade tính tiền theo form
    UPDATE: Thêm nút xem tất cả đơn hàng cho modal User

## 20.07.2024

UPDATE: Khắc phục lỗi phương thức Auth::user()->can() trong Intelephense
UPDATE: Cài đặt thêm telescope
UPDATE: Hoàn thiện phần admin profile

## 31.07.2024

UPDATE: Xóa `GlobalSettings` gọi thừa trong `Kernel`
UPDATE: Cập nhật phương thức `getCatalogueChildren()`
UPDATE: Loại bỏ `getSettings()` trong Controller gốc
UPDATE: Tích hợp sử dụng CSDL `Redis` cho `Cache` và `Session`
UPDATE: Gọi các đối tượng thường dùng vào trong `GlobalSettings` và lưu vào cache để tiện dùng - cache `attributes`, có cập nhật thì xóa cache để nó tái tạo lại dữ liệu mới - cache `branches`, có cập nhật, phân quyền cho `User`, `Warehouse` thì xóa cache để nó tái tạo lại dữ liệu mới - cache `dealer` và `cashier` tự động xóa khi có cập nhật `User` hoặc `Role` - gọi cache `catalogues` thay cho session `catalogues` trong `modal_catalogue.blade` tại trường `parent_id` - thêm trường kho nhận trong `modal_export.blade` - gọi cache `catalogues` thay cho session `catalogues` trong `modal_product.blade` tại trường `catalogues[]` - tận dụng cache `spatie.permission.cache` có sẵn của spatie/laravel-permissions để trình bày `permissions[]` trong `modal_role.blade` - gọi cache `cashiers` thay cho truy vấn CSDL trong `modal_transaction.blade` tại trường `cashier_id` - gọi cache `roles`, `warehouses`, `branches` thay cho truy vấn CSDL trong `modal_user.blade` - gọi cache `attributes` khi liệt kê thuộc tính trong `modal_variable.blade` - gọi cache `brances` khi liệt kê chi nhánh trong `modal_warehouse.blade` - gọi cache `settings` trong `c80.blade`
UPDATE: Giới hạn số ký tự tối đa trong mô tả danh mục sản phẩm và chuyên mục bài viết là 320, thay vì 125 như trước đây
UPDATE: Không giới hạn số từ tối đa của mô tả dịch vụ trong `service.blade`
UPDATE: Bỏ điều kiện mã sản phẩm không được trùng
UPDATE: Bổ sung quan hệ cashier và customer trong `EagleLoading` của `OrderController`
UDDATE: Tạo chỉ thị màu cho đơn hàng còn thiếu, trả đủ và trả dư cho mã đơn hàng, icon thanh toán
UPDATE: Gắn tooltip cho số tiền đã thanh toán chỉ thị số tiền thừa hay thiếu sau thanh toán
UPDATE: Set cố định tổng số lượng record của bảng để giảm lượng truy vấn DataTables - OrderController - PetController - PostController - ProductController
UPDATE: Bỏ phương thức `cataloguesName()` trong `Post`
UPDATE: Thay đổi cơ chế thanh toán cho phép chi tiền thừa lại cho khách dễ dàng hơn. Không còn trạng thái hoàn tiền mà lưu vào số âm thì là hoàn tiền - Bỏ trường `transactions`(`status`) - Chấp nhận số âm cho trường `transactions`(`amount`) - Tạo thêm một nút checkbox phía trước số tiền thanh toán trong phần tạo đơn của POS, nút đó check nghĩa là hoàn tiền - Hàm `addPayToOrder()` thêm trường ẩn `name=transaction_refund[]` lưu trạng thái giao dịch là hoàn tiền hay thanh toán, mặc định là 0 - Khi thay đổi trạng thái giao dịch thì thay đổi tiêu đề và ghi chú thanh toán - Cập nhật hàm tính toán lại tiền thừa khi thay đổi trạng thái giao dịch - Thêm chỉ thị màu cho số tiền thanh toán và dấu +/- hỗ trợ xác định trạng thái thanh toán trong `transactions.blade` - Thay đổi cách đặt tên trạng thái giao dịch trong `modal_transaction.blade` để tránh hiểu lầm khi xử lý ở Controller - Trình bày nội dung thanh toán khi thêm hoặc cập nhật thanh toán - Tạo chỉ thị màu cho đơn hàng còn thiếu, trả đủ và trả dư cho mã đơn hàng, icon thanh toán - Gắn tooltip cho số tiền đã thanh toán chỉ thị số tiền thừa hay thiếu sau thanh toán
UPDATE: Trình bày nội dung thanh toán của một đơn hàng trong `modal_order.blade` - Ẩn nội dung thanh toán khi tạo đơn hàng mới - Hiển thị nội dung thanh toán khi cập nhật - Trình bày dữ liệu thanh toán của đơn hàng - Cập nhật nút thanh toán `Hoàn tiền` (nếu có tiền thừa) hoặc `Thu tiền` (nếu thu chưa đủ)
UPDATE: Chuyển cách đặt tên class của phần thanh toán trong tạo đơn POS thành `transaction` thay vì `order` như trước tránh hiểu nhầm
UPDATE: Gộp tất cả xử lý select2 vào một snippet code đặt trong main.js, data-ajax--url đưa trực tiếp và thuộc tính của thẻ select luôn
UPDATE: Thêm url trở về trang danh sách cho `post.blade`, `product.blade`, `service`
UPDATE: Thêm nút tải excel cho `services.blade`
UPDATE: Chuyển vị trí nội dung thanh toán xuống dưới của `modal_transaction.blade`
UPDATE: Tích hợp barcodeJS để in barcode cho cho sản phẩm
UPDATE: Chuyển script của quick_images vào `admin.includes.quick_images` và chỉ load danh sách hình ảnh khi bật modal hoặc trong `images.blade`
UPDATE: Cơ chế đơn vị tính linh hoạt cho sản phẩm - Bỏ trường `products`(`unit`) - Thêm bảng `units`(`term`,`variable_id`,`rate`, `barcode`, `price`) vào CSDL và model `Unit` tương ứng - Mỗi `Variable` sẽ có nhiều `Unit` và có tỷ lệ quy đổi riêng - Xóa bỏ các trường `variables`(`sub_sku`, `barcode`,`price`), chuyển vào bảng `units` - Xóa bỏ trường `unit` trong `modal_product.blade`, thay trường `status` vào vị trí đó - Tách script xử lý product thành hàm `showProducts()` - Tách script xử lý variable thành hàm `showVariables()` - Các modal có chứa DataTables thì DataTables sẽ được gọi khi modal bật và hủy khi modal đóng - Bổ sung cột các biến thể cho danh sách sản phẩm `products.blade` - Gắn bảng DataTables cho variables trong `modal_product.blade` - Bố trí lại bảng variables trong `product.blade` - Loại bỏ các xử lý update CSDL liên quan đến `unit`, `variables` ra khỏi `ProductController` - Loại bỏ trường `unit` khỏi `Product` Model - Bổ sung các xử lý lưu vào bảng `units` và bỏ các xử lý liên quan đến `barcode`,`price`,`sub_sku` trong `VariableController` - Loại bỏ phương thức canRemove() khi không cần thiết - Khởi tạo hàm `index()`, `sync()` và `remove()` trong `UnitController` - Overflow-auto cho Danh sách danh mục trong bảng sản phẩm - Chuyển trường trạng thái sang cột bên phải để tối ưu không gian - Tạo bảng unit trình bày các đơn vị tính của từng biến thể trong `modal_variable.blade` - Xử lý khi nhập hàng hóa vào kho: - Trong `modal_import.blade`, bổ sung thêm input ẩn chứa `.import-stock_variable_unit_id` và `.import-stock_variable_unit_rate` - Chuyển hướng tìm kiếm sang các `unit` thay vì `variable` như trước đây - Cập nhật chỗ các đơn vị tính thay vì cố định thì đổi thành select - Trong `modal_import.blade`, khi quét trúng mã vạch, load dữ liệu liên quan đến mã vạch đó lên, Eager Loading các quan hệ đầy đủ - Nếu ID của đơn vị tính đó đã tồn tại thì tăng số lượng lên 1 đơn vị - Nếu ID của đơn vị tính đó chưa tồn tại thì thêm sản phẩm mới vào phiếu nhập hàng - Nếu chưa tồn tại ID của đơn vị tính thì bật modal tạo sản phẩm mới - Trong `modal_import.blade`, khi chọn sản phẩm từ select thì quét qua 1 lượt các sản phẩm đang có - Nếu ID của đơn vị tính đó đã tồn tại đó thì tăng số lượng lên 1 đơn vị - Nếu chưa tồn tại thì thêm sản phẩm mới vào phiếu nhập hàng - Khi thay đổi đơn vị tính thì `import-stock_variable_unit_id`, `import-stock_variable_unit_rate` được cập nhật và `stock_quantity[]` cũng cập nhật theo công thức - Khi lưu dữ liệu nhập hàng thì quy đổi ra đơn vị nhỏ nhất trước khi lưu vào
UPDATE: Tách các cài đặt Toastify ra thành hàm `pushToasify()` riêng
UPDATE: Tích hợp tính năng in mã vạch cho hệ thống sản phẩm - Thêm nút mã vạch cho `products.blade` - Thêm `modal_barcode.blade` và nhúng vào `app.blade` - Khi click vào nút mã vạch thì sẽ collect các sản phẩm đang được check để trình bày lên `modal_barcode` - Khi click vào nút in barcode trên modal thì xuất nội dung in vào print-container và bật dialog in của trình duyệt - Khi thay đổi lựa chọn variable thì cập nhật lại các unit ở dưới, chỉ hiển thị unit của variable đó - Khi quét mã vạch mà không có modal nào đang mở thì nếu mã vạch có tồn tại sẽ bật modal sản phẩm và biến thể chứa mã vạch đó lên
UPDATE: Thêm thiết lập delay lâu cho SweetAlert, tái sử dụng code
UPDATE: Xây dựng CSDL bệnh và các tác vụ hỗ trợ chẩn đoán, điều trị, kê toa thuốc - Khởi tạo bảng `diseases`(`name`, `incubation`, `communicability`, `complication`, `prevention`) để lưu các bệnh - Khởi tạo bảng `symptoms`(`name`, `group`, `frequency`) để lưu các triệu chứng - Khởi tạo bảng `medicines`(`name`, `product_id`, `ingredients`, `indications`, `contraindications`, `manufacturer`) để lưu các loại thuốc - Khởi tạo bảng `medicine_dosage`(`medicine_id`, `dosage`, `route`, `quantity`, `specie`, `age`, `weight`) để lưu các liều lượng dùng của từng loại thuốc - Khởi tạo các bảng phụ `disease_symptom`, `disease_medicine`, `medicine_symptom` để lưu quan hệ giữa các bảng
UPDATE: Bỏ cột ngày bán trong bảng danh sách đơn hàng, dồn vào cột mã đơn hàng

## 12.08.2024

UPDATE: Bổ sung tính năng lọc sản phẩm theo danh mục trong `ProductController::index()`
UPDATE: Xử lý bán hàng theo cơ chế đơn vị tính mới - Điều chỉnh phần tìm kiếm hàng tồn kho trong phần find và search của `StockController::index()` - Bổ sung select đơn vị tính cho phần POS - Thêm phương thức trình bày số lượng theo đơn vị tính trong `Stock::convertUnit()`
UPDATE: Set cố định tổng số lượng record của bảng để giảm lượng truy vấn DataTables - AnimalController - ExportController - ImportController
UPDATE: Cập nhật phần phân tích dữ liệu trên bảng tin - Cập nhật đầy đủ các biến dữ liệu trả về của DashboardController::analytics() - Trình bày dữ liệu trả về lên giao diện -
FIXBUG: Sửa lỗi phần trạng thái nhập hàng, kiểm tra `$request->has('status')`
UPDATE: Bổ sung đơn vị tính khi lưu đơn hàng trong phần xử lý cập nhật đơn hàng
UPDATE: Bổ sung tìm kiếm sản phẩm bằng tên danh mục và biến thể trong `ProductController`
UPDATE: Bổ sung tìm kiếm gói tồn kho theo đơn vị tính, kiểm tra gói tồn kho còn đủ hàng theo đơn vị tính thì mới hiển thị
FIXBUG: Sửa lỗi quét mã vạch thì lấy luôn cả gói tồn kho trong kho khác đưa vào đơn hàng
UPDATE: Bổ sung đơn vị tính khi tìm dữ liệu tồn kho bằng mã vạch
UPDATE: Bổ sung tồn kho đã chuyển đổi khi hiển thị danh sách gói tồn kho ra cho người dùng chọn
UPDATE: Đổi truy vấn DataTables của Stock thành Eloquent thay vì Collection như cũ
UPDATE: Đổi truy xuất dữ liệu stock trong giao diện quản lý tồn kho từ cột biến thể sang cột mã, đổi mã sang hiển thị thống nhất (gồm mã và ngày tạo)
UPDATE: Truy vấn giao dịch bổ sung thêm phần tổng giá trị đơn hàng của đơn hàng được chọn và tổng giá trị thanh toán của đơn hàng được chọn
UPDATE: Bổ sung hàm xóa giao dịch
FIXBUG: Xác thực unit trong VariableController, variable phải có tối thiểu một unit và unit đó phải có rate bằng 1
FIXBUG: Bổ sung xác thực barcode không được trùng với unit khác
UPDATE: Thêm to_warehouse_id vào Export Model và from_warehouse_id vào Import Modal, các trường dữ liệu trong CSDL cũng bổ sung tương tự
UPDATE: Thêm Stock::convertUnit() để chuyển đổi tồn kho thành đơn vị dễ tính
UPDATE: Bổ sung tooltip gợi ý hướng dẫn nhập liệu cho nhân viên
UPDATE: Điều chỉnh barcode hiển thị tên sản phẩm thành 2 hàng
UPDATE: Thay đổi cơ cấu xử lý dữ liệu sau khi quét mã vạch trong phẩn POS - Với mỗi stock tìm được, tìm trong đơn hàng có gói tồn kho đó đã tồn tại chưa - Nếu đã tồn tại thì chạy vòng lặp kiểm tra từng gói tồn kho đã tồn tại - Nếu đơn vị tính của gói tồn kho đó đúng với đơn vị tính mã vạch đã quét thì tăng số lượng lên 1 và kiểm tra khớp tồn kho - Nếu khớp tồn kho thì chạy `totalOrder()` tính tổng đơn hàng, đánh dấu đã tìm được biến, thoát tất cả vòng lặp - Nếu không khớp tồn kho thì bỏ qua, chạy tiếp vòng lặp khác

<!-- - Nếu chạy hết vòng lặp rồi mà không tìm thấy gói tồn kho nào trùng đơn vị tính thì thêm gói tồn kho đơn vị tính mới -->

    - Nếu chưa tồn tại thì cũng thêm gói tồn kho đơn vị tính mới - Nếu chạy hết stock rồi mà không tồn tại gói tồn kho nào khớp hay thêm được gói tồn kho nào thì báo hết hàng

UPDATE: Bổ sung đơn vị tính cho modal trong phần xuất kho, đơn hàng - Bổ sung đơn vị tính cho phần tạo xuất kho - Bổ sung đơn vị tính cho phần cập nhật xuất kho - Bổ sung đơn vị tính cho phần tạo đơn hàng - Bổ sung đơn vị tính cho phần cập nhật đơn hàng - Khóa phần đơn vị tính của các gói tồn kho có sẵn khi hiển thị cập nhật đơn hàng - Thêm bộ nút xử lý cho các gói tồn kho bổ sung khi cập nhật đơn hàng
UPDATE: Trình bày các giao dịch thanh toán của đơn hàng dưới dạng datatable trong `modal_order.blade`
UPDATE: Load dữ liệu đơn hàng từ ajax trong phần tạo giao dịch thanh toán thay vì load từ thuộc tính nút như trước
UPDATE: Kiểm tra khớp tồn kho của sản phẩm với số lượng bán được cập nhật cho phù hợp với các bổ sung đơn vị tính - Vì một gói tồn kho bây giờ có thể xuất hiện 2 lần trong 1 đơn hàng (dưới 2 đơn vị tính khác nhau) nên tổng (số lượng các gói tồn kho x chỉ số rate của đơn vị tính) mà lớn hơn số tồn kho là sẽ không hợp lệ - 2 gói tồn kho cũng không được trùng đơn vị tính với nhau
UPDATE: Tối ưu hàm `totalOrder()` bằng cách chuyển khai báo tab vào trong hàm luôn cho gọn
UPDATE: Bổ sung cột kho cho phần quản lý tồn kho
UPDATE: Điều chỉnh biểu mẫu in cho số tiền nổi bật hơn và thông tin trực quan hơn
FIXBUG: Loại bỏ các danh mục, sản phẩm, biến thể, đơn vị tính đã bị xóa hoặc không hoạt động ra khỏi tìm kiếm trong `modal_import.blade`
FIXBUG: Sửa lỗi không lưu được số tiền giao dịch khi click hoàn tiền trong phần POS

## 13.08.2024

FIXBUG: Sửa lỗi danh mục bị khóa nhưng vẫn thêm sản phẩm vào được
FIXBUG: Sửa lỗi nhập kho số lượng bằng 0
FIXBUG: Sửa lỗi biến thể bị khóa nhưng vẫn nhập hàng được
FIXBUG: Sửa lỗi biến thể bị khóa thì không thể click vào xem chi tiết được
FIXBUG: Sửa lỗi lưu trạng thái phiếu xuất nhập kho
FIXBUG: Loại bỏ phương thức `canRemove()` trong Product Model và xóa product không check ràng buộc nữa (vì xóa mềm nên vẫn có thể truy xuất lại dữ liệu cũ)
UPDATE: Thêm CRUD cho bệnh lý trong `DiseaseController`
UPDATE: Thêm các hàm ràng buộc `assign, sync` với `Medicine, Symptom` trong Model `Disease`
UPDATE: Triển khai xử lý dữ liệu cho `disease.blade.php`
UPDAPE: Tách `form#disease-form .modal` từ `disease.blade.php` sang `modal_disease.blade.php`
UPDATE: Thêm cache cho `diseases, medicines, symptoms` trong `GlobalSetting`
UPDATE: Điều chỉnh tên class Model `Symptoms` thành `Symptom`
UPDATE: Bổ sung thêm các biến `symptoms`, `diseases`, `medicines` trong `Cache` của `GlobalSetting`
UPDATE: Sửa tên class và file `Symptoms` thành `Symptom`
UPDATE: Đổi tên các CONST của `DISEASE` trong User từ `DESEASE` thành `DISEASE`
UPDATE: Thêm dữ liệu mẫu cho `Symptom` trong `Seeder`
UPDATE: Thêm tính năng thêm, sửa, xóa, search cho `Symptom`

## 14.08.2024

UPDATE: Thêm tooltip cho các label (giải thích chi tiết title của input)

## 14.08.2024

UPDATE: Đổi id của thẻ input trong `modal-symptom` theo cấu trúc
UPDATE: Bổ sung khóa ngoại với `products` thông qua `product_id` ở `medicines`
UPDATE: Bổ sung ràng buộc giữa `Product` và `Medicine` (ở Model)
UPDATE: Bổ sung khóa ngoại với `medicines` thông qua `medicine_id` ở `dosages`
UPDATE: Bổ sung ràng buộc giữa `Medicine` và `Dosage` (ở Model)
UPDATE: Thêm seeder `DiseaseSeeder` để tạo dữ liệu mẫu cho `Disease`
UPDATE: Thêm seeder `SymptomSeeder` để tạo dữ liệu mẫu cho `Symptom`
UPDATE: Thêm seeder `CatalogueSeeder` để tạo dữ liệu mẫu cho `Catalogue`
UPDATE: Thêm seeder `ProductSeeder` để tạo dữ liệu mẫu cho `Product` và bảng phụ `catalogue_product`
UPDATE: Thêm seeder `VariableSeeder` để tạo dữ liệu mẫu cho `Variable`
UPDATE: Thêm seeder `UnitSeeder` để tạo dữ liệu mẫu cho `Unit`

## 15.08.2024

UPDATE: Thay đổi tên class Model `Dosages` thành `Dosage`
UPDATE: Thêm các hàm xử lý thao tác CRUD ở `MedicineController`
UPDATE: Bổ sung ràng buộc giữa `Medicine` và `Symptom`, `Disease`
UPDATE: Tách `form#medicine-form .modal` từ `medicine.blade.php` ra `modal_medicine.blade.php`
UPDATE: Loại bỏ tính năng thêm triệu chứng và bệnh ở modal medicine (Loại bỏ button thêm, xóa modal thêm triệu chứng và bệnh ở `medicine.blade.php`)
UPDATE: Triển khai, xử lý dữ liệu của medicine `medicine.blade.php`
UPDATE: Chuyển tính năng chọn loài của liều dùng ở modal medicine từ `Select2` sang `Select`

UPDATE: Điều chỉnh gom cột mã sản phẩm và tên sản phẩm, bổ sung cột `code` làm 1 trong `ProductController`
UPDATE: Cập nhật sắp xếp thứ tự cột `code` theo id trong `StockController`
UPDATE: Bỏ tìm kiếm theo `term` trong `UnitController`
FIXBUG: Sửa lỗi trùng gói tồn kho vẫn bị tạo mới trong khi thêm đơn hàng
FIXBUG: Sửa lỗi hiện trang trống trên `ImageController`
UPDATE: Chuyển select danh mục cha trong `modal_catalogues.blade` thành select2
UPDATE: Thêm phiếu nhập khi tạo phiếu xuất trong `ExportController::create()`
UPDATE: Bổ sung `to_warehouse_id` vào Export Model - Bổ sung vào hàm `create()` và `update()` `ExportController` - Thêm quan hệ trong Export Model
UPDATE: Bổ sung `from_warehouse_id` vào Import Model - Bổ sung vào hàm `create()` và `update()` `ImportController` - Thêm quan hệ trong Import Model
FIXBUG: Bổ sung validate `status` khi tạo và cập nhật Import Model
UPDATE: Tạo chức năng đổi chi nhánh mặc định cho user - Thêm nút bấm trên menu tài khoản `header.blade` - Tạo SweetAlert2 với modal để cập nhật - Tạo hàm `SelfController::update_branch()` - Thêm `route('admin.profile.change_branch')`
UPDATE: Thêm điều kiện tìm kiếm warehouse trong switch find khi `$request->has('user_id')`
UPDATE: Bỏ trường `warehouse_id` trong `modal_export.blade`

## 16.08.2024

UPDATE: Thêm `services` trong `Cache`, và hai hàm `assignService`, `syncServices` trong model `Symptom`
UPDATE: Thêm phần gợi ý dịch vụ vào `modal_symptom`

## 16.08.2024

FIXBUG: Tách trường `parent_id` ra để cập nhật sau khi đã tạo các catalogue ở `CatalogueSeeder`
FIXBUG: Sửa lại vòng lặp thêm dữ liệu cho `catalogue_product` trong `ProductSeeder`
FIXBUG: Thay đổi trường `product_id` thành `variable_id`
UPDATE: Xóa ràng buộc giữa `Product` và `Medicine`(ở Model)
UPDATE: Thêm ràng buộc giữa `Variable` và `Medicine` (ở Model)
UPDATE: Thay đổi lại thao tác dữ liệu của các hàm CRU ở `MedicineController` từ `product_id` thành `variable_id`
UPDATE: Thêm phần chọn biến thể vào `form#medicine-form .modal` từ script `medicine.blade.php`
UPDATE: Tạo hàm `syncVariables()` ở `medicine.blade.php` để thiết lập các biến thể tương ứng với mục sản phẩm được chọn
UPDATE: Tạo hàm `setUnit()` để thay đổi đơn vị tính của số lượng dùng trong liều dùng tương ứng với biến thể được chọn

UPDATE: Xóa trường `warehouse_id` trong Export Model
UPDATE: Xóa trường `exports`.`warehouse_id` trong CSDL
FIXBUG: Điều chỉnh điều kiện lọc gói tồn kho trong phần find của `StockController::index()`
UPDATE: Thêm select chọn kho xuất hàng tại `modal_export.blade`
UPDATE: Sửa điều kiện `Warehouse::canRemove()` chỉ xóa được kho khi không còn hàng tồn kho
UPDATE: Hiển thị chi nhánh chính hiện tại khi mở modal cập nhật chi nhánh chính trong `app.blade`
FIXBIG: Cập nhật sử dụng select2 cho `select[name=branch_id]` trong `modal_warehouse.blade` để khi xóa branch rồi thì mở warehouse lên vẫn select branch đã xóa
FIXBUG: Sửa lỗi kho không có chi nhánh thì mở modal update kho bị lỗi
UPDATE: Chuyển code khởi tạo và cập nhật warehouse, branch ra `app.blade`
FIXBUG: Sửa lỗi link liên kết cập nhật branch trong `WarehouseController:index()`
FIXBUG: Loại bỏ `Branch::canRemove()` và cập nhật `BranchController::remove()` phù hợp
FIXBUG: Truy xuất chi nhánh thì chi nhánh xóa rồi vẫn mở lên xem và update được
FIXBUG: Điều chỉnh cột `code` và `name` trong danh sách chi nhánh
FIXBUG: Điều chỉnh cột `code` và `name` trong danh sách kho hàng
FIXBUG: Đồng bộ màu label trong `modal_warehouse.blade`
UPDATE: Khởi tạo select2 ngay khi load trang xong nếu trong nội dung chính `$('#main-content')` có chứa select2 trong `main.js`
FIXBUG: Khởi tạo lại select2 trong nội dung chính `$('#main-content')` khi đóng modal

## 17.08.2024

UPDATE: Xóa seeder `DiseaseSeeder`
UPDATE: Xóa seeder `SymptomSeeder`
UPDATE: Tạo seeder `MedicalSeeder` để tạo dữ liệu mẫu liên quan đến `Symptom`, `Disase` và `Medicine`
UPDATE: Tạo seeder `PetSeeder` để tạo dữ liệu mẫu cho `Pet`
UPDATE: Xử lý hiển thị thông tin khách hàng, thú cưng khi tạo phiếu khám ở `info.blade`
UPDATE: Xử lý tải lên dữ liệu, thao tác liên quan đối với `symptom` và `medicine` ở giao diện phiếu khám `info.blade`
UPDATE: Thay đổi cấu trúc dữ liệu đưa lên Cache của `medicines` - Không còn xử dụng `pluck()` - Sử dụng `get()` và `with('symptoms', 'dosages')` - Điều chỉnh code lấy và sử dụng dữ liệu đối với `cache()->get('medicines')` ở `modal_symptom.blade` và `modal_disease.blade`
UPDATE: Thay đổi cấu trúc dữ liệu đưa lên Cache của `symptoms` - Không còn xử dụng `pluck()` - Sử dụng `where('id', '>', 3)->orderBy('group')->get()` - Điều chỉnh code lấy và sử dụng dữ liệu đối với `cache()->get('symptoms')` ở `modal_medicine.blade` và `modal_disease.blade`
UPDATE: Ở bảng `presciption_details`: - Thay đổi tên trường `dose` thành `dosage`
-Thay đổi tên trường `usage` thành `route`

## 26.08.2024

UPDATE: Thêm trường `frequency` vào migration `dosages` để biểu thị thời gian lặp lại của liều dùng
FIXBUG: Thay đổi lại kiểu dữ liệu của các trường `dosage`, `age`, `weight`, `quantity` của migration `dosages` cho phù hợp
UPDATE: Điều chỉnh, thêm `RULES` và `MESSAGES` ở `InfoController` lại để phù hợp với kiểu dữ liệu của các trường vừa thay đổi
UPDATE: Điều chỉnh dữ liệu lại cho dữ liệu mẫu của `Medicine` ở `MedicalSeeder` - Thêm dữ liệu mẫu cho trường `frequency` - Điều chỉnh lại dữ liệu mẫu của trường `dosage`
UPDATE: Thêm controller `InfoDetailController` để quản lý các triệu chứng lâm sàn của phiếu khám - Tạo hàm `InfoDetailController::sync()` để xử lý tạo, cập nhật chi tiết phiếu khám
UPDATE: Thêm input quản lý trường `frequency` vào `form[id="medicine-form] .modal` từ script ở `medicine.blade`
UPDTAE: Điều chỉnh hàm `InfoController::create()` hoàn tất tạo được đơn hàng -> phiếu khám -> chi tiết phiếu khám
UPDATE: Bổ sung thêm dữ liệu lưu lên cach() của `medicines` để lấy đơn vị tính (ở `GlobalSettings`)
UDATE: Thay đổi lệnh truy vấn dữ liệu khi lưu lên cach() của `symptoms` để lọc các triệu chứng thuộc nhóm `Khác` về cuối (ở `GlobalSettings`)

## 28.08.2024

UPDATE: Viết hàm `exportStock()` ở Model `Medicine` để kiểm tra số lượng thuốc trong kho có đủ cung cấp cho toa thuốc hay không
UPDATE: Thêm ràng buộc giữa `Export` và `Prescription` - Thêm trường `prescription_id` vào `Export` - Thêm hàm `prescription()` vào Model `Export` - Thêm hàm `export()` vào Model `Prescription`
UPDATE: Thêm ràng buộc giữa `ExportDetail` và `ExportDetail` - Thêm trường `prescription_detail_id` vào `ExportDetail` - Thêm hàm `prescriptionDetail()` vào Model `ExportDetail` - Thêm hàm `exportDetails()` vào Model `PrescriptionDetail`
UPDATE: Thêm trường `frequency` vào `PrescriptionDetail`
UPDATE: Ở `Export`, cho phép trường `receiver_id` có giá trị null
UPDATE: Loại bỏ trường `stock_id` của `Prescription`

## 29.08.2024

UPDATE: Thêm ImportSeeder để tạo dữ liệu mẫu cho `Import` và `Stock`
UPDATE: Cho phép trường `measure` của `InfoDrtail` có giá trị null
UPDATE: Thay đổi giao diện phần chỉ định thuốc ở `info.blade`
UPDATE: Thêm hàm `Prescription:create()` để tạo đơn thuốc
UPDATE: Thêm hàm `Prescription:index()` để trả về dữ liệu của danh sách phiếu khám chữ hoặc một phiếu khám chữa cụ thể
UPDATE: Thêm hàm ở `getTypeStrAttribute()` ở Model `Info` để hiển thị địa điểm khám tương ứng
UPDATE: Thêm hàm `infoDetails()` ở Model `Info` để tạo ràng buộc với `InfoDetail`
UPDATE: Thêm hàm `InfoController::remove()` để xóa phiếu khám chữa

## 30.08.2024

UPDATE: Cập nhật hàm `pets()` ở Model `User`: chỉ lấy ra những thú cưng đang hoạt động
UPDATE: Cập nhật hàm `getNeuterStrAttribute()` và `getNeuterIconAttribute` ở Model `Pet` cho phù hợp khi có giới tính hoặc trạng thái triệt sản chưa rõ
UPDATE: Cập nhật giá trị random của giới tình và trạng thái triệt sản của Pet tại `Petseeder`
UPDATE: Cho phép 2 trường `age` và `weight` của `Dosage` được mang giá trị null
UPDATE: Gợi ý liều dùng khi tạo toa thuốc theo loài của thú cưng được khám chữa
UPDATE: Thay đổi mối quan hệ giữa `Detail` và `Prescription` ở Model `Detail` thành quan hệ một - một
UPDATE: Thêm trường `medicine_id` vào `PrescriptionDetail` - Thêm hàm `medicine()` ở Model `PrescriptionDetail` để tạo ràng buộc với `Medicine` - Thêm hàm `prescriptionDetails()` ở Model `Medicine` để tạo ràng buộc với `PrescriptionDetail`
UPDATE: Thêm hàm `PrescriptionController::update()` để cập nhật đơn thuốc
UPDATE: Thêm hàm `PrescriptionDetailController::sync()` để tạo - cập nhật chi tiết đơn thuốc
UPDATE: Thêm hàm `PrescriptionDetailController::remove()` để xóa chi tiết đơn thuốc

## 03.09.2024

UPDATE: Thay đổi các checkbox ở giao diện tạo phiếu khám thành input-list-group (click chọn trực tiếp)
UPDATE: Thay đổi script, tên class cho phù hợp với việc loại bỏ checkbox
UPDATE: Thêm ràng buộc giữa `service` và `detail` - Thêm hàm `service` và `_service` vào Model `Detail` - Thêm hàm `indication_details` và Model `Service`
UPDATE: Thêm hàm `InfoController::remove()` để xóa đơn lẻ chi tiết phiếu khám chữa
UPDATE: Thêm hàm `IndicationDetailController::sync()` để hỗ trợ việc tạo và cập nhật chi tiết phiếu chỉ định
UPDATE: Thêm hàm `IndicationController::create()` để tạo phiếu chỉ định
UPDATE: Thêm hàm `IndicationController::update()` để cập nhật phiếu chỉ định
UPDATE: Cập nhật tính năng có thể thêm nhiều đơn thuốc cho một phiếu khám chữa
UPDATE: Thay đổi script xử lý hiển thị đơn thuốc ở `info.blade` để phù hợp cho việc thêm nhiều đơn thuốc
UPDATE: Cập nhật lại bảng `Info` - Thêm trường `prognosis` để biểu diễn dữ liệu tiên lượng của phiếu khám chữa - Thêm trường `final_diag` để biểu diễn dữ liệu chuẩn đoán bệnh của phiếu khám chữa - Thay thế trường `conclusion` bằng trường `prelim_diag` để biểu diễn dữ liệu chuẩn đoán sơ bộ của phiếu khám chữa - Thêm trường `treatment_plan` để biểu diễn dữ liệu phác đồ điều trị của phiếu khám chữa
UPDATE: Cập nhật `InfoController::create()` và `InfoController::update` cho phù hợp với các trường được thêm, thay đổi
UPDATE: Cập nhật giao diện tạo phiếu khám (Thêm input cho các trường mới)
trong `main.js`

## 18.08.2024 - Quân

UPDATE: Tùy chọn chỉ được xuất bán các sản phẩm còn hạn sử dụng - Thêm tùy chọn chỉ được xuất bán các sản phẩm còn hạn sử dụng vào settings - Thêm ràng buộc tìm gói tồn kho trong `StockController`, khi cài đặt xuất hàng theo hạn sử dụng bật thì chỉ tìm trong các gói tồn kho còn HSD
UPDATE: Điều chỉnh phương thức tìm kiếm gói tồn kho dựa trên tìm kiếm thủ công, không dùng thư viện - Chuyển đổi khung tìm kiếm gói tồn kho trong POS thành AJAX Search để tái sử dụng trong các vị trí khác - Loại bỏ `table.export_details` trong `modal_export.blade` - Loại bỏ `table.order_details` trong `modal_order.blade` - Tự động ẩn khung hiển thị kết quả tìm kiếm trong form tìm kiếm ajax-search khi unfocus vào input - Điều chỉnh tìm kiếm ajax-search đưa stock vào đơn hàng khi người dùng click vào kết quả tìm kiếm và sửa lỗi phát sinh - Điều chỉnh quét mã để thêm hàng cho POS và modal_order giống nhau và fix lỗi phát sinh - Cập nhật `ExportController::create()` và `ExportController::update()` theo các trường dữ liệu đã thay đổi khi sử dụng ajax-search - Đưa chuyển code phần ghi chú chỉ tiết đơn hàng lên `app.blade` - Điều chỉnh hàm thêm `.detail` khi người dùng thêm mặt hàng từ ajax-search hoặc quét barcode - Toàn bộ phần validate dữ liệu của đơn hàng đều sử dụng name hết thay cho class trước đây
UPDATE: Thêm cột `code` trong `catalogues.blade` bao gồm và search và sort
FIXBUG: Chỉ được chọn danh mục cha là các danh mục đã tạo trước danh mục hiện tại
FIXBUG: Thêm tùy chọn không có danh mục cha cho catalogue
FIXBUG: Sửa lỗi hàm sắp xếp khi không chọn ID thì không lưu được thứ tự trong `Category::sort()`, `Catalogue::sort()`, `ProductController::sort()`
UPDATE: Bổ sung `unit_id` trong `details` và `export_details` - Thêm trường `unit_id` trong database thông qua migrations - Thêm trường `unit_id` trong fillable của Model Detail và ExportDetail - Bổ sung quan hệ đến Unit Model trong Detail Model và ExportDetail Model - Điều chỉnh hàm `OrderController::save()` và tạo, cập nhật trong `ExportController`
UPDATE: Thêm tính năng xuất nhập kho nội bộ - Khi tạo xuất kho mà có chọn kho đích thì sẽ tạo phiếu nhập kho với số hàng đã xuất tương ứng - Bỏ trống trường người nhập `imports.user_id` và trạng thái là chờ hàng - Khi người dùng mở phiếu nhập lên & kiểm hàng thành công thì xác nhận đã nhập và lưu tên người nhập (tự động) - Phiếu nhập kho nội bộ không được điều chỉnh hay xóa trực tiếp mà phải qua phiếu xuất tương ứng - Phiếu nhập đã xác nhận nhập kho thì không thể xóa hay điều chỉnh phiếu xuất nữa - Bổ sung các điều kiện hiển thị `supplier`, `warehouse` và `user` khi trình bày datatables của `ImportController::index()`
UPDATE: Hiển thị chi nhánh bán khi xem đơn hàng
FIXBUG: Điều chỉnh điều kiện truy vấn để không tìm kiến nhập kho các sản phẩm hoặc biến thể đã bị xóa trong phần `find` của `UnitController::index()`
FIXBUG: Chỉ cho xóa đơn vị tính có rate khác 1
UPDATE: Ràng buộc điều kiện khi truy vấn user là phải tìm được người đó thì mới được trả về kết quả, không thì trả về 404
UPDATE: Thêm sắp xếp và tìm kiếm cho thiết lập datatables trong `WarehouseController::index`
UPDATE: Thêm thuộc tính code cho Catalogue Model
UPDATE: Set NULL cho select.parent_id trong `main.js:resetForm()`
UPDATE: Sửa lỗi dính nút hoàn tiền trên POS
UPDATE: Điều chỉnh lỗi só tiền tổng khi xuất in đơn hàng trên `c80.blade`
FIXBUG: Chỉ chọn được 1 check box trong cùng 1 `.accordion-body` và tự động tạo tên biến thể dựa vào ô đã check
UPDATE: Thêm ràng buộc trả về khi submit xóa unit

## 22.08.2024 - Quân

FIXBUG: Bổ sung ImportDetail để điều chỉnh hệ thống để trình bày số lượng nhập kho theo đơn vị tính - Bổ sung bảng `import_details`(`import_id`, `variable_id`, `unit_id`, `quantity`, `price`) để lưu chi tiết nhập hàng - Điều chỉnh bảng `stocks`(`import_detail_id`, `quantity`, `lot`, `expired`) để phù hợp với bảng `import_details` mới thêm - Cập nhật dữ liệu đã nhập cho chính xác - Loại bỏ các cột `timestamp` khỏi các bảng phụ quan hệ nhiều - nhiều - Điều chỉnh quan hệ khi truy xuất dữ liệu từ Import - Khởi tạo `ImportDetailController` với các phương thức `index()`, `create()`, `update()`, `remove()` - Cập nhật `StockController::create()` - Khởi tạo các `route()` thêm, sửa, xóa cho `ImportDetailController`
UPDATE: Chuyển đổi Datatables trong `ImportController::index()` sang sử dụng Eloquent - Cột supplier trong `ImportController` nếu nhập kho nội bộ thì hiện tên kho - Bổ sung các phương thức `filterColumn()` và `orderColumn()` phù hợp cho các cột
UPDATE: Bổ sung trường `imports`.`export_id`, bỏ trường `imports`.`from_warehouse_id` - Điều chỉnh quan hệ trong các Model `Warehouse`, `Import` và `Export` - Điều chỉnh `index()`, `create()` và `update()` trong `ImportController`
UPDATE: Chỉ được xóa Import khi chưa có ImportDetail nào có Stock đã từng xuất hàng và Import đó không phải nhập kho nội bộ
UPDATE: Chỉ được xóa ImportDetail nếu ImportDetail đó không phải từ nhập kho nội bộ và ImportDetail đó có Stock chưa từng xuất kho
UPDATE: Xóa ImportDetail đồng thời cũng xóa Stock, không được xóa Stock trực tiếp - Loại bỏ nút xóa ở cột `action` trong DataTables của `StockController::index()`
UPDATE: Loại bỏ xem chi tiết Stock, click vào cột mã sẽ mở chi tiết phiếu xuất hàng
UPDATE: Sử dụng phương thức gọi trực tiếp Controller - Controller thay vì gọi đến phương thức static trung gian như trước - Truyền dữ liệu sang controller khác bằng phương thức `$request->replace()` - Bổ sung xác thực người dùng khi gọi Controller sang Controller khác
UPDATE: Bổ sung `StockController::create()`
UPDATE: Loại bỏ `sync()` và `remove_exec()` trong `StockController`, gọi phương thức trực tiếp từ Controller đến Controller
UPDATE: Loại bỏ `sync()` và `remove_exec()` trong `ImportController`, gọi phương thức trực tiếp từ Controller đến Controller
UPDATE: Loại bỏ `export_details`.`order_id`, bổ sung `export_detail`.`detail_id`, cập nhật quan hệ tương ứng trong Model
UPDATE: Bổ sung `import_detail`.`export_detail_id`, cập nhật quan hệ tương ứng trong Model

FIXBUG: Sửa lỗi `ImportController::create()`, `ImportDetailController::create()`, `Stock::create()`
UPDATE: Cập nhật tên cho các modal phù hợp với ngữ cảnh thêm hoặc sửa đối tượng

## 25.08.2024 - Quân

UPDATE: bổ sung hàm `Controller::resetAutoIncrement()`
UPDATE: Thêm tùy chọn 'Không chọn chi nhánh' và 'Không chọn kho hàng' khi xử lý select2
UPDATE: Cập nhật quan hệ stock.import_detail cho `DashboardController::analytics()`
UPDATE: Bổ sung giờ truy vấn của ngày bắt đầu và ngày kết thúc trong `DashboardController::analytics()`
UPDATE: Cập nhật quan hệ stock.import_detail cho `ExportController`
UPDATE: Quản lý xuất kho chỉ hiển thị các phiếu xuất kho nào có xuất hàng từ kho người dùng đang quản lý
UPDATE: Áp dụng xử lý code xuôi theo mạch đổi với ImportController, ImportDetailController, ExportController, ExportDetailController, OrderController, DetailController - Chuyển đổi sang truy vấn Eloquent cho DataTables trong `ExportController::index()` - Bổ sung `DB::transactions()` cho `create()`, `update()`, `remove()` của `ExportController` - Code xuôi và xử lý tất cả obj trong cùng 1 Controller thay vì truyền sang Controller của obj đó - Xóa phiếu thì phải hoàn kho và chuyển số lượng về 0 - Kiểm duyệt điều kiện update hoặc remove với từng đối tượng - Điều chỉnh cách đặt tên trường import_detail của `modal_import.blade` - Bỏ `Detail::remove_exec()`, cập nhật phương thức `remove()` xử lý các dữ liệu liên quan
UPDATE: Tách phương thức `OrderController::save()` thành `create()` và `update()`
UPDATE: Tích hợp select2, cho trường `role_id`, `warehouse_id`, `branch_id` trong `user_role-modal.blade`
UPDATE: Cập nhật điều kiện truy vấn cho `StockController` và `UnitController`
UPDATE: Điều chỉnh tăng tốc độ trượt khi active sidebar
UPDATE: Loại bỏ xử lý reload cho DataTables, thay thế hết bằng global reload khi gọi ajax
UPDATE: Bổ sung xử lý biểu đồ cho bảng tin
UPDATE: Bổ sung lưu dữ liệu vào bộ nhớ trình duyệt, tránh gọi phân tích, thống kê nhiều lần lên DB
UPDATE: Điều chỉnh trình bày sidebar cho bệnh, triệu chứng và thuốc nhập vào cài đặt hệ thống
UPDATE: Làm validate riêng cho `create()` và `update()` trong `OrderController`
FIXBUG: Sửa lỗi xử lý lưu `Export` và `ExportDetail` trong `OrderController::update()`
FIXBUG: Sửa lỗi truy xuất dữ liệu cho select2 của `RoleController::index()`
FIXBUG: Lọc cả email người dùng trong DataTables của `UserController::index()`
FIXBUG: Không yêu cầu chọn chi nhánh khi tạo hoặc sửa kho hàng
FIXBUG: Sửa lỗi quan hệ `Import::_export()`
FIXBUG: Không load dữ liệu khi không có quyền xem nội dung bảng tin
FIXBUG: Bổ sung tính tổng giá trị phiếu nhập hàng
UPDATE: Bổ sung quan hệ cho Unit Model
UPDATE: Xóa dữ liệu, nếu dữ liệu chưa được liên kết quan hệ thì thực hiện xóa cứng luôn - Áp dụng cho Product, Variable, Unit
UPDATE: Xóa đối tượng cha thì cũng xóa luôn đối tượng con - Áp dụng cho Product. Varible, Unit
UPDATE: Lập và in phiếu xuất kho, phiếu nhập kho, phiếu thanh toán

## 28.08.2024 - Đăng

UPDATE: Thêm các route tương ứng và cách hàm `updateImage`, `updatePay`, `updateCompany`, `updateEmail`, `updateSocial` trong `SettingController`
UPDATE: Thêm `nullable()` cho trường `value` trong `migration` của `Setting`
UPDATE: Thêm tính năng cho cài đặt
UPDATE: Trong `SettingSeeder` đổi `social_whatsapp` thành `social_tiktok`

## 28.08.2024 - Quân

UPDATE: Bổ sung tìm kiếm dữ liệu theo ngày trong các DataTables Controller
UPDATE: Bỏ cột `date` khỏi DataTables của `ExportController::index()`, thay bằng cột type để biết là xuất bán hay xuất nội bộ
UPDATE: Điều chỉnh thời gian trong cột `code` của các Controller theo định dạng "d/m/Y H:i"
FIXBUG: Sửa lỗi sắp xếp cột theo người xuất và kho xuất trong DataTable của `ImportController::index()`
FIXBUG: Sửa lỗi nhập kho số lượng 0 trong `create()` và `update()` của `ImportController`
FIXBUG: Ẩn phần loading DataTables của `quick_images.blade`
UPDATE: Ngày mặc định của bảng tin sẽ là ngày hiện tại

## 28.08.2024 - Quân

FIXBUG: Hiển thị đúng ngày tạo đơn hàng khi mở đơn hàng lên xem chi tiết
UPDATE: Khi tạo mới đơn hàng, thời gian tạo đơn được cập nhật liên tục theo mỗi lần cập nhật đơn
UPDATE: Dữ liệu đã bị xóa thì không thể cập nhật. Nút cập nhật sẽ được ẩn đi
UPDATE: Cập nhật chức năng đăng xuất / đăng nhập nhanh - Thêm phương thức `LoginController::auth()` để xử lý đăng nhập qua ajax - Thêm phương thức `LoginController::logout()` ghi đè phương thức đang có trong Trails - Trong các phương thức mới của `LoginController`, kết quả trả về phải có token CSRF mới nhất - Bổ sung login modal tiêu chuẩn và nhúng vào `app.blade` - Bổ sung `route('login.auth')` để xử lý đăng nhập qua ajax - Điều chỉnh code khi hết phiên đăng nhập thì mở modal đăng nhập thay vì trả về trang login như trước - Bổ sung hàm `showLoginForm()` và hàm `updateCsrfToken()` - Khi nhấn tổ hợp phím Ctrl + `thì tự động logout và cập nhật token mới nhất do server gửi về
    - Khi đăng nhập xong thì tự động cập nhật token mới nhất do server gửi về
    - Chỉ load lại DataTables khi reponse trả về không có token (nghĩa là liên quan đến đăng nhập, đăng xuất thì không load lại DB)
UPDATE: Bổ sung tính năng ẩn nút lưu khi mở xem đối tượng đã bị xóa
UPDATE: Bổ sung chức năng tự động logout nếu không có thao tác gì trong vòng 5 phút cho`main.js`UPDATE: Không cho cập nhật`rate`của`units`đã tạo trước đó
FIXBUG: Xóa hiển thị ngày tạo trên`DiseaseController`, `SymptomController`, `MedicineController`FIXBUG: Tạo khoảng cách đồng bộ cho filter DataTable của tất cả các blade trong`key.css:223`

UPDATE: Cập nhật routeMiddleware 'admin' cho tất cả `Admin\Controller`, bên cạnh middleware 'auth'
UPDATE: Cập nhật bộ giao diện thông báo lỗi mới
UPDATE: Cập nhật tính năng xóa cứng nếu có thể đối với Product, Variable, Unit, Import, ImportDetail, Export, ExportDetail - Kiểm tra các bảng có quan hệ với bảng cần xóa coi có khóa ngoại liên quan đến trường cần xóa không - Nếu quan hệ nhiều nhiều thì xóa records trong bảng phụ - Nếu quan hệ 1 - 1 thì xóa và `$obj->unsetRelation('relation_name')` - Nếu quan hệ 1 nhiều thì xóa con trước, sau đó tiếp tục xóa cha - Nếu còn liên kết khóa ngoại thì chỉ xóa mềm thôi
FIXBUG: Sửa lỗi tạo phiếu xuất kho mới cho đơn hàng được nhồi thêm hàng hóa trong `OrderController::update()`
UPDATE: Cập nhật tính năng xác thực đăng nhập bằng ajax cho `LoginController::auth()` - Tạo thêm `modal_login.blade` và nhúng vào `app.blade` - Bỏ qua xác thực CSRF khi đăng nhập - Khi đăng nhập xong thì trả về token và update vào các trường `[name='_token']` của các form và thẻ meta
UPDATE: Cập nhật tính năng đăng xuất qua ajax - Thêm tính năng nhấn vào tổ hợp phím Ctrl + End để đăng xuất - Đăng xuất xong thì hiện modal đăng nhập lên và cập nhật csrf_token qua dữ liệu trả về từ ajax
UPDATE: Chỉ hiển thị các sản phẩm bán online trên giao diện website

## 03.09.2024 - Đăng

UPDATE: Chức năng gửi mail thông báo các sản phẩm sắp hết hạn đến các tài khoản trực thuộc tại kho đó
UPDATE: Thêm `class CheckExpired extend Command` để tạo `Command` mới `stocks:checkexpired`
UPDATE: Thêm phương thức `getProductNameAttribute` trong Model `Stock`
UPDATE: Thêm view `expired_notification.blade` để render danh sách sản phẩm sắp hết hạn sử dụng
UPDATE: Thêm `Mail` SendMail
FIXBUG: Fix lỗi login fail
UPDATE: Chỉ gửi mail tự động với các tài khoản đang hoạt động

## 31.08.2024 - Quân

UPDATE: Chỉnh sửa search và sort theo `code` của dataTables trong tất cả bảng
UPDATE: Cho phép sort theo cột `status` của DataTables trong tất cả bảng
UPDATE: Thêm EagerLoading cho DataTables trong `ProductController::index()`, `ServiceController::index()`
UPDATE: Chuyển đổi DataTables của `CategoryController::index()`, `CrtiterialController::index()` sang dùng Eloquent
FIXBUG: Kiểm tra null `$detail->export_detail` trước khi tạo `ExportDetail` trong bảng `Order`
UPDATE: Thêm hàm search trong `UnitController`
FIGBUG: Thêm điều kiện kiểm tra lỗi `abort` trong `main.js`, sữa lỗi hiển thị placeholder của `select2`
UPDATE: Thêm class `table-responsive` cho các `table`
UPDATE: Đổi search `select2` của `modal_import` thành search theo kĩ thuật `debounce`
UPDATE: Đổi giao diện phân quyền `User` từ `select2` thành các checkbox
UPDATE: Thêm các hàm để lọc các `ROLE`, `BRANCH`, `WAREHOUSE`
UPDATE: Sửa lại giao diện các `modal_transaction`, `modal_user`

UPDATE: Cho phép cập nhật tất cả thông tin nhập hàng ngoại trừ trạng thái nhập hàng, giá, số lượng trên phiếu nhập khi đã có xuất bán
UPDATE: Thêm cài đặt tùy chỉnh trong Setting cho phép bật tắt cập nhật phiếu nhập hàng khi đã có xuất bán
FIXBUG: Điều chỉnh đơn hàng khi nhập nhồi sản phẩm thì các hàng hóa phát sinh sẽ tạo phiếu nhập mới
FIXBUG: Điều chỉnh cập nhật phân quyền cho tài khoản không yêu cầu phải có chi nhánh và kho
FIXBUG: Cập nhật biến thể sẽ tự động tạo mã vạch nếu dữ liệu truyền vào không có mã vạch
UPDATE: Cho phép người dùng đăng xuất và đăng nhập trong admin bằng ajax thay vì submit form trực tiếp
UPDATE: Cập nhật tạo đơn hàng và xuất hàng sử dụng ajax-search sẽ tự động thêm hàng hóa mới vào trên cùng (thay vì dưới cùng như trước đây)
FUXBUG: Sửa lỗi chọn option đơn vị tính khi in mã vạch. Chỉ hiển thị các option của biến thể đầu tiên
FIXBUG: Sửa lỗi khi quét mã vạch xuất hàng thì không hiện cảnh báo nữa mà lấy mã vạch điền vào ajax-search để tìm kiếm
UPDATE: Cập nhật bán hàng POS, bổ sung giao dịch trả tiền thừa cho khách
UPDATE: Cập nhật thêm trường tồn kho tối thiểu `stock_limit` cho `products`

## 03.09.2024 - Quân

UPDATE: Chuyển trường tồn kho tối thiểu `stock_limit` từ `products` sang `variables`
UPDATE: Đăng nhập xong thì đổi tên người dùng, cập nhật chi nhánh cho người dùng
UPDATE: Cập nhật tên chi nhánh khi người dùng đổi chi nhánh mặc định từ menu cá nhân
UPDATE: Hiển thị tên chi nhánh bán theo chi nhánh của người dùng hiện tại khi tạo đơn hàng mới
UPDATE: Bổ sung cột chi nhánh cho DataTables của `OrderController::index()`

## 06.09.2024 - Đăng

UPDATE: Thêm `bank_name` vào SettingController
UPDATE: Chỉnh sửa hàm `getPaymentStrAttribute` trong `Transaction` theo thứ tự đúng của `payment`
UPDATE: Chỉnh sửa `transaction` migration theo thứ tự của `payment`
UPDATE: Chỉnh sửa lại giao diện `setting`, `order` và thêm QR thanh toán vào bill

## 06.09.2024 - Quân

FIXBUG: Sửa lỗi mở khung chọn hình nhanh bị lỗi từ lần thứ 2
FIXBUG: Cập nhật tiếng Việt cho các label và tooltip cài đặt tài khoản người dùng
FIXBUG: Cập nhật nội dung chuyển khoản cho QR của đơn hàng

## 09.09.2024 - Đăng

UPDATE: Chức năng thông báo khi hàng hóa hết hạn sử dụng
UPDATE: Cập nhật hàm `handle()` trong `CheckExpired` command
UPDATE: Thêm `NotificationController` và hàm `markAsRead` để cập nhật trạng thái đã đọc thông báo
UPDATE: Thêm `Model` Notification, thêm quan hệ của `Notification` với `User` và ngược lại
UPDATE: Thêm `Migration` cho `Notificaition`
UPDATE: Cập nhật `PermissionSeeder`
UPDATE: Cập nhật giao diện của thông báo, Fix lỗi giao diện
UPDATE: Thêm `route` `admin.notification.markAsRead`
UPDATE: Bắt sự kiện và cập nhật trạng thái đã đọc `Notification`

## 10.09.2024 - Đăng
UPDATE: Đổi hàm kiểm tra stock trong 20 ngày tới thành ngày thứ 20 so với hiện tại (kiểm tra mỗi ngày)
UPDATE: Thẻ `<a>` của mỗi thông báo không mở modal nữa mà chuyển thành url
UPDATE: Bắt sự kiện click đánh dấu thông báo đã đọc

## 10.09.2024 - Quân
FIXBUG: Tách chi tiết đơn hàng của sản phẩm và dịch vụ ra riêng
UPDATE: Thêm điều kiện lọc gói tồn kho theo hạn sử dụng trong truy vấn DataTables

## 05.09.2024 - Thắng
UPDATE: Cập nhật lại hàm `exportStock()` ở Model `Medicine` cho phù hợp với cấu trúc dữ liệu mới

## 05.09.2024 - Quân
UPDATE: Xóa `modal_info.blade`
UPDATE: Tách cột thành tiền trong thanh toán thành tiền mặt và chuyển khoản, thêm thông tin là 'mua hàng' hay 'trả nợ' bên dưới

## 10.09.2024 - Quân
UPDATE: Loại bỏ các bảng chi tiết dịch vụ và các model tương ứng - ultrasound_details - UltraSoundDetail - treatment_details - TreatmentDetail - biochemical_details - BiochemicalDetail - bloodcell_details - BloodcellDetail - xray_details - XrayDetail - surgery_details - SurgeryDetail
UPDATE: Loại bỏ các controller của chi tiết dịch vụ - BeautyDetailController - BiochemicalDetailController - BookingDetailController - HotelDetailController - IndicationDetailController - MicroscopeDetailController - QuicktestDetailController - SurgeryDetailController - TreatmentDetailController - UltrasoundDetailController - XrayDetailController
UPDATE: Thêm các trường `details` cho các bảng dịch vụ và fillable cho Model tương ứng, bỏ các quan hệ không cần thiết - ultrasounds - biochemicals - bloodcells - xrays - surgeries - treatments
FIXBUG: Loại bỏ tổng đơn hàng trong website của c80-order.blade
UPDATE: Giảm size QRcode thanh toán và cập nhật hướng dẫn thanh toán
UPDATE: Thêm dấu tách nội dung order `<hr>`
FIXBUG: Đổi `lastest_order` thành `latest_info` trong Datatables của `PetController::index()`
FIXBUG: Cập nhật hiển thị cho `medicines.blade`
UPDATE: Thêm thuộc tính `fullName` cho `Variable` Model
FIXBUG: Sửa lỗi trùng cột `id` khi `sort` column theo quan hệ trong các DataTables

## 11.09.2024 - Thắng
UPDATE: Cập nhật hiển thị cân nặng thú cưng trong `infos.blade`
UPDATE: Cập nhật hiển thị số tiền tổng trong `transactions.blade`
UPDATE: Cập nhật lại tên biến trong `DashboardController::analytics()` cho hợp lý
UPDATE: Tối ưu truy vấn get medicine trong `MedicineController::index()`

## 11.09.2024 - Quân
FIXBUG: Cập nhật tìm gói tồn kho đưa vào đơn hàng theo trạng thái kho hàng
UPDATE: Bổ sung trạng thái `Dùng nội bộ` cho `Warehouse` Model
UPDATE: Tối ưu code javascript của `medicines.blade`
UPDATE: Bổ sung autocomplete="off" cho các input của ajax-search
UPDATE: Thêm danh sách đường dùng thuốc cho `modal_medicine.blade`
FIXBUG: Hiện dấu tách số khi nhập số tiền tạo dịch vụ mới trong `modal_service.blade`
UPDATE: Chuyển đơn thuốc trong phiếu khám thành dạng bảng (thay vì dạng div.column như trước)
UPDATE: Tối ưu truy vấn get info trong `InfoController::index()`
FIXBUG: Sửa lỗi mở modal từ thông báo không được
FIXBUG: Bổ sung `modal_preview.blade` để phục vụ preview mọi thứ
UPDATE: Tích hợp đẩy thông báo mỗi khi có nâng cấp phần mềm mới

## 12.09.2024 - Đăng
UPDATE: Thêm validate cho `consumables` trong ServiceController
UPDATE: Ẩn 4 `Sysmptom` đầu tiên khi load lên danh sách
UPDATE: Thêm `consumables` vào Model `Service` và migration tương ứng
UPDATE: Chỉnh sửa giao diện và thêm tính năng search cho các `medicine`, `service`, `disease` trong `symptom`
UPDATE: Xóa hàm `filter_local` trong `app.blade.php`
UPDATE: Thêm card sản phẩm tiêu hao trong dịch vụ

UPDATE: Tạo phương thức `NotificationController::create()` và tối ưu phương thức tạo Notification mới
FIXBUG: Sửa lỗi load unit.term của variable trong `modal_medicines.blade`
UPDATE: Bổ sung middelware readNoti() để cập nhật Notification đã đọc

## 12.09.2024 - Quân
UPDATE: Bổ sung quan hệ EagerLoading cho truy vấn DataTables của `OrderController::index()`
UPDATE: Giữ nguyên quan hệ nhiều nhiều khi xóa Product trong `ProductController::remove()`
UPDATE: Thu gọn tên sản phẩm cho stock và chuyển vào phương thức `Stock::fullName`
FIXBUG: Liệt kê danh sách kho có trạng thái lớn hơn 0 thay vì trạng thái bằng 1 trong `WarehouseController::index()` và `GlobalSettings`
UPDATE: Loại bỏ các cột timestamps của Model Attribute và Local
UPDATE: Bổ sung chỉ thị màu cho các model thông qua thuộc tính fullName
UPDATE: Điều chỉnh `Stock::getProductNameAttribute()` để hiển thị tên có chỉ thị màu
FIXBUG: Sửa lỗi không tìm thấy unit khi chuyển đổi đơn vị tính trong `Stock::convertUnit()`
UPDATE: Bỏ softDelete của Attribute Model

## 12.09.2024 - Thắng
UPDATE: Chuyển đổi phương thức tạo - cập nhật phiếu khám từ dùng `.save-form` sang lưu trực tiếp
UPDATE: Thêm triệu chứng `Nhiệt độ` vào nhóm triệu chứng `Thông tin chung`
UPDATE: Thêm mục nhiệt độ vào thông tin mặc định của phiếu khám
UPDATE: Loại bỏ validate: bắt buộc phải có triệu chứng khi tạo - cập nhật phiếu khám

## 16.09.2024 - Thắng
UPDATE: Thêm tooltip cho các tiêu đề của phiếu khám
UPDATE: Thêm hàm `getPrescriptionsAttribute()` ở Model `Info` để thêm thuộc tính prescriptions cho `Info` hỗ trợ việc truy xuất các đơn thuốc của phiếu khám
UPDATE: Thêm hàm `getIndicationDetailsAttribute()` ở Model `Info` để thêm thuộc tính indicationDetails cho `Info` hỗ trợ việc truy xuất các phiếu chỉ định của phiếu khám
UPDATE: Thêm trường `name` cho đơn `Prescription`
FIGBUG: Load dữ liệu của phiếu chỉ định và các đơn thuốc của phiếu khám bằng trang thay vì script

UPDATE: Thiết lập cảnh báo hết hạn sử dụng trước số ngày cài đặt trong CSDL
UPDATE: Tìm kiếm cho danh mục sản phẩm trong `modal_product.blade` và `product.blade`
FIXBUG: Sửa lỗi phân tích dữ liệu lợi nhuận cho `DashboardController::analytics()`
UPDATE: Chuyển xử lý ajax-search và local-search từ `app.blade` vào `main.js`
UPDATE: Cập nhật nội dung thông báo hết hạn sử dụng, chỉ hiện 1 thông báo
FIXBUG: Sửa lỗi đánh dấu đã đọc thông báo
UPDATE: Bổ sung tính năng kéo thả để up ảnh avatar cho thú cưng, khách hàng và sản phẩm
UPDATE: Tối ưu hiển thị variable của Service (tạo phương thức cho Service::`getVariablesAttribute()` từ consumables)
UPDATE: Tối ưu tìm kiếm gói tồn kho cho `StockController::index()`
UPDATE: Đưa label lên hiển thị cùng hàng với checbox khi bị dài quá dòng

FIXBUG: Cập nhật `$pageName` cho các blade xác thực người dùng
FIXBUG: `overflow-auto` cho danh mục, xử lý lỗi tràn khung danh mục
FIXBUG: Sửa cho không phép bán hàng trong kho nội bộ nhưng được xuất hàng
FIXBUG: Không cho bán hàng và không load danh sách `stock` thuộc `import` có trạng thái đang chờ
FIXBUG: Đưa xét quyền hiển thị checkboxes xử lý hàng loạt khi không được cấp quyền tại `pets.blade`
FIXBUG: Sửa lỗi cập nhật thông tin tài khoản của người dùng đang đăng nhập tại `SelfController::change_settings()`
FIXBUG: Cập nhật ghi chú nhà cung cấp khi cập nhật nhà cung cấp tại `SupplierController::update()`

## 15.09.2024 - Nguyên
UPDATE: Thiết lập giao diện phiếu chỉ định `quicktests` và `ultrasounds` làm giao diện chuẩn
UPDATE: Bổ sung chức năng thêm thư viện ảnh dùng chung cho các phiếu chỉ định có dùng hình ảnh trong `main.js`
UPDATE: Tạo mẫu in phiếu khám `info_a4.blade.php` trong thư mục `prints`

## 15.09.2024 - Quân
UPDATE: Điều chỉnh cột Mã của tất cả các bảng DataTables dữ liệu cho hiển thị ngày ở cả nhân viên không được cấp quyền xem
FIXBUG: Cho phép xuất hàng cả kho nội bộ và kho bán hàng (ở cả quét mã và tìm kiếm)
UPDATE: Tính năng phiếu thu cho giao dịch
UPDATE: Tính năng preview cho đơn hàng
UPDATE: Thêm thuộc tính `originalTotal` và `total` cho Detail Model
UPDATE: Thêm thuộc tính tối ưu `saveAmount` và tối ưu thuộc tính `total` cho Order Modal
UPDATE: Tối ưu thuộc tính `productName` của Stock và `fullName` của Variable
FIXBUG: Điều chỉnh thêm số lượng stock vào đơn hàng xuống còn 1 (xóa mã thừa gây lỗi chạy 2 lần trong `main.js`)
UPDATE: Tối ưu biểu mẫu đơn hàng in trên khổ giấy C80

## 16.09.2024 - Quân
FIXBUG: Đổi tên nút `.btn-upload-images` của quick_images thành `.btn-upload-quick_images` trong `quick_images.blade`
UPDATE: Thêm trường commission cho dịch vụ để tính hoa hồng dịch vụ cho nhân viên
FIXBUG: Thay đổi trường `unit_ids` thành `dosage_ids` khi xử lý chi tiết form trong `medicines.blade`
FIXBUG: Ngăn chặn sắp xếp theo cột `address` trong bảng DataTables của `users.blade`

## 17.09.2024 - Quân
UPDATE: Loại bỏ `IndicationController`
FIXBUG: Loại bỏ trường `weight` (cân nặng) và tham số `$request->ip()` khi `update()` hoặc `create()` trong `MedicineController`
FIXBUG: Sửa trường `unit_ids` thành `dosage_ids` trong `MedicineController::update()`
FIXBUG: Mở `modal_import` khi click vào Stock trong DataTables của `StockController::index()`
UPDATE: Ràng buộc phải có quyền cập nhật tài khoản thì mới được truy xuất thông tin tài khoản
UPDATE: Khôi phục `Indication` (chỉ định) để quản lý các dịch vụ thuộc một `Info` Model (phiếu khám) - Cập nhật quan hệ `indications` thành `hasMany()` trong Info Model - Cập nhật quan hệ `indication` thành `hasOne()` trong Detail Model - Cập nhật quan hệ giữa `Indication` với các phiếu con thành `hasOne()`, thêm trường `indication_id` cho tất cả phiếu con - Cập nhật quan hệ `belongsTo()` cho `Indication::info()` và `Indication::detail()` - Mỗi `Service` (dịch vụ) sẽ được liên kết đến 1 chi tiết đơn hàng (qua `service_id`) để biết `Service` (dịch vụ) đó của chi tiết đơn hàng nào - Một `Info` (phiếu khám) sẽ có nhiều `Indication` (chỉ định) - Mỗi `Indication` (chỉ định) sẽ liên kết đến phiếu dịch vụ con tương ứng (qua `indication_id`) và liên kết đến 1 chi tiết đơn hàng (qua `detail_id`)
UPDATE: Loại bỏ quan hệ product() trong `Detail` Model
UPDATE: Đổi trường `infos`(`order_id`) thành `infos`(`detail_id`) - Cập nhật tên trường trong `fillable` của Info Model - Cập nhật quan hệ `_order()` và `order()` thành `_detail()` và `detail()` trong Info Model - Bổ sung quan hệ `Detail::info()` là `hasOne()`
UPDATE: Điều chỉnh quan hệ `infoDetails` thành `info_details` theo đúng pattern thống nhất
UPDATE: Điều chỉnh quan hệ `prescriptionDetails` thành `prescription_details` theo đúng pattern thống nhất
UPDATE: Điều chỉnh quan hệ `bloodcells` thành `bloodcell` theo đúng pattern thống nhất
UPDATE: Điều chỉnh quan hệ `biochemicals` thành `biochemical` theo đúng pattern thống nhất
UPDATE: Thêm trường `medicines`(`sample_dosages`)
UPDATE: Đảo chiều quan hệ giữa Prescription và Export - Xóa trường `prescription_id` trong bảng `exports` và thêm trường `export_id` cho `prescriptions` - Xóa trường `prescription_detail_id` trong bảng `export_details` - Đổi quan hệ `Prescription::export()` thành `belongsTo()` và `Export::prescription()` thành `hasOne()` - Bỏ quan hệ `ExportDetail::prescriptionDetail()`
UPDATE: Chuyển quan hệ giữa Detail với các phiếu con thành `hasOne()`
UPDATE: Điều chỉnh Model `Hotel` thành `Accommodation` - Loại bỏ model Hotel, bảng `treatments`, đổi tên model Treatment thành `Accommodation`, đổi tên bảng `hotels` thành `accommodations` - Cập nhật tên quan hệ trong Model Detail từ `hotel()` thành `accommodation()`
UPDATE: Bổ sung Model Expense để quản lý các giao dịch chi tiêu - Tạo bảng `expenses`(`user_id`,`receiver_id`,`method`,`amount`, `images`,`note`) để lưu dữ liệu chi tiêu - Thiết lập quan hệ `belongsTo()` cho `Expense::user()` và `Expense::receiver()`
UPDATE: Bổ sung model Tracking để lưu các chỉ số thú cưng lưu trú - Tạo bảng `trackings`(`accommodation_id`, `assistant_id`, `parameters`, `images`, `score`, `note`) - Thiết lập quan hệ trong model
UPDATE: Điều chỉnh cho phép null phần số điện thoại, địa chỉ và email của nhà cung cấp - Set `nullable()` cho các trường trong DB `suppliers`(`address`, `phone`, `email`)
UPDATE: Thêm trường xác định nhóm dịch vụ là khám chữa hay chăm sóc trong bảng `majors`(`type`)
UPDATE: Thêm trường đơn vị tính và chi phí lương cho nhân viên trong bảng `services`(`commision`, `unit`)
UPDATE: Trường giá dịch vụ, giá đơn vị tính, giá bán, giá nhập set mặc định là 0 trong CSDL
UPDATE: Thêm trường `infos`(`requirements`)
UPDATE: Cập nhật tên trường cho đúng với chức năng của nhân sự `prescriptions`(`pharmacist_id`), `quicktests`(`technician_id`), `ultrasounds`(`technician_id`), `xrays`(`technician_id`), `beauties`(`technician_id`), `bloodcells`(`technician_id`), `biochemicals`(`technician_id`), `microscopes`(`technician_id`)
UPDATE: Bổ sung tính năng tìm kiếm menu chức năng cho `sidebar.blade` trong `main.js` tận dụng 1 phần local-search
UPDATE: Thêm phương thức search trong `ServiceController::index()`
UPDATE: Điều chỉnh ajax-search để có thể gắn nhiều ajax search trên 1 trang HTML (xác định class `search-result` của từng cụm)

## 18.09.2024 - Thắng
FIGBUG: Sửa lại hàm `InfoController::create()`
UPDATE: Điều chỉnh lại các mối quan hệ ở `Info` và `Prescription`
UPDATE: Xóa một số đoạn liên quan đến đơn thuốc trong `info.blade` do chưa phù hợp -> gây lỗi
UPDATE: Thêm case `search` vào `ServiceController:index()` để tìm dịch vụ theo tên và triệu chứng liên quan
UPDATE: Chuyển thao tác search dịch vụ ở phiếu khám từ `Local search` thành `Ajax search`

## 18.09.2024 - Quân
UPDATE: Bỏ phân quyền ở các cột checkbox của DataTables trong tất cả Admin\Controller
UPDATE: Đổi HotelController thanh AccommodationController
UPDATE: Cập nhật `unit` và `commission` cho ServiceController
UPDATE: Loại bỏ trường `branch_id` trong tất cả Model phiếu con
UPDATE: Cập nhật trường `doctor_id` thành các trường đúng theo CSDL
UPDATE: Bổ sung quan hệ `_units` bao gồm cả các unit đã bị xóa mềm của Model Variable
UPDATE: Đổi trường `indication_id` trong `prescriptions` thành `info_id` - Đổi quan hệ và trường trong Model Prescription, Info và Indication
UPDATE: Thêm trường `quicktests`(`conclusion`) và trường 'conclusion' trong model Quicktest
UPDATE: Loại bỏ trường `detail_id` trong các phiếu con
UPDATE: Cập nhật tên `hotels.blade` thành `acomodations.blade` và `modal_hotel.blade` thành `modal_accommodation.blade`
UPDATE: Cập nhật tính năng đơn vị tính và cơ số lương cho Dịch vụ - Thêm trường unit và commission cho `modal_service.blade` và `service.blade` - Cập nhật validation và trường dữ liệu trong phương thức `SeviceController::save()`

## 19.09.2024 - Quân
UPDATE: Khởi tạo Model Booking và migration tương ứng, thêm các quan hệ phù hợp
UPDATE: Cập nhật tên quyền trong Model User
UPDATE: Chuyển `work.css` ra `app.blade`
UPDATE: Khởi tạo `BookingController`
UPDATE: Đổi tên HotelController thành AccommodationController
UPDATE: Cập nhật toàn bộ booking thành booking cho phù hợp với CSDL
FIXBUG: Nếu người dùng không có chi nhánh chính thì sẽ không tìm được hàng hóa để bán
FIXBUG: Nếu không chọn chi nhánh và kho trong phần phân quyền thì sẽ xóa hết các phân quyền hiện tại
FIXBUG: Nếu không chọn danh mục trong phần sản phẩm thì sẽ xóa hết các danh mục đã chọn
FIXBUG: Thêm đường dẫn đến trang quản lý dịch vụ cho breadcrum của `service.blade`
UPDATE: Cập nhật `sidebar.blade` phù hợp với mindset người dùng

## 19.09.2024 - Đăng
UPDATE: Thêm tính năng đặt lịch hẹn - Thêm hàm `create`, `sync` trong `BookingController` - Thêm `case 'doctor'` và `case 'search'` cho `searchAjax` của `UserController` - Chỉnh màu nhạt hơn cho `--bs-light` - Sửa hàm `searchAjax`: bắt sự kiện `keyup` thay cho `input` - Thêm hai input để searchAjax `customer` và `doctor` trong `bookings.blade`

## 20.09.2024 - Quân
UPDATE: Bổ sung lọc hàng hóa tồn kho theo kho trong `stocks.blade`

## 19.09.2024 - Thắng
UPDATE: Thêm `Admin/IndicationController()`
UPDATE: Thêm các hàm `save()`, `sync()`, `remove()` trong `IndicationController()`
UPDATE: Thêm ràng buộc `Order:indications()` và `Order:infos()` bằng `HasManyThrough()`
UPDATE: Thêm case `search` trong `UserController::index()`, `ServiceController::index()` và `MedicineController::index()` để tìm đối tượng theo từ khóa
UPDATE: Điều chỉnh lại `PrescriptionController::create()` và `PrescriptionController::update()`

UPDATE: Bổ sung lọc đơn hàng và thanh toán theo chi nhánh
UPDATE: Khi tạo đơn hàng, nếu không có thanh toán thì phải chọn một khách hàng để lưu công nợ
UPDATE: Hiển thị danh sách hàng tồn kho theo kho người dùng quản lý
UPDATE: Hoàn thiện `modal_booking.blade`
UPDATE: Hoàn thiện phần hiển thị `bookings.blade`
UPDATE: Chỉ trả về các User có quyền tạo phiếu khám trong search ajax của `UserController::index()`
UPDATE: Thêm trường `type` và `note` cho Model Booking
UPDATE: Tự động xổ tuần hiện tại của năm trong giao diện `bookings.blade`
UPDATE: Tự động highlight ngày hiện tại trong giao diện `bookings.blade`

## 20.09.2024 - Đăng
UPDATE: Thêm hàm `update` trong `BookingController` và `orderBy` danh sách lịch hiển thị ra
UPDATE: Sửa quan hệ từ `transactions` thành `customer_transactions` và thêm quan hệ với `cashier` trong model `User`
UPDATE: Thêm `case: find` để seach bằng `select2` trong `ServiceController`
UPDATE: Xóa thuộc tính `avatarUrl` và thêm `typeStr` trong model `Booking`
UPDATE: Hoàn thiện update `Booking` - Cập nhật giao diện hiển thị của thẻ card lịch dịch vụ và thêm hàm `update` - Thêm hàm `getDateRange` để tái sử dụng khi load lại lịch hẹn

## 20.09.2024 - Quân
FIXBUG: Cập nhật hiển thị thông báo theo chuẩn và tắt thông báo chính xác
UPDATE: Tạo thêm phương thức `NotificationController::push()` để đẩy thông báo đến người dùng
UPDATE: Bổ sung thêm điều kiện lọc theo variable_id trong DataTables của `StockController::index()`
UPDATE: Thêm phương thức `isExhausted()` và `sumStock()` để kiểm tra số lượng hàng tồn kho và đếm tổng số hàng tồn kho của một `Variable` Model
UPDATE: Bổ sung lọc phiếu xuất kho theo kho - Thêm select chọn kho trong `imports.blade` và `exports.blade` - Thêm js tự động chuyển tới url sau khi chọn kho trong `imports.blade` và `exports.blade` - Thêm điều kiện sàng lọc trong `ImportController` và `ExportController`
UPDATE: Tối ưu code JS sử dụng chung `modal_preview` và bắt sự kiện click chuột trong `app.blade`

## 20.09.2024 - Quân
UPDATE: Cập nhật hiển thị lịch hẹn sau khi tạo mới lịch hẹn

## 21.09.2024 - Thắng
UPDATE: Thêm input để nhập mô tả cho triệu chứng ở danh sách triệu chứng của phiếu khám
UPDATE: Thêm datalist cho các loại thuốc khi tạo đơn thuốc
UPDATE: Thêm data-url vào `btn-print print-info`

## 23.09.2024 - Quân
UPDATE: Loại bỏ cơ chế truyền ip the mỗi request, sử dụng ip của toàn bộ session
UPDATE: Đổi toàn bộ truy vấn của select2 trên Controller thành `select2` thay vì `find` như trước
UPDATE: Tối ưu truy vấn danh sách công nợ của khách hàng
UPDATE: Chuyển giá trị của select chọn đơn vị tính trong `modal_import.blade`, `modal_export.blade`, `modal_order.blade` và `order.blade`
UPDATE: Tách nhánh riêng cho switch-case `barcode` trong `StockController`, `UnitController` và `VariableController`
UPDATE: Tối ưu quét mã barcode không bị điền nối tiếp khi quét lần 2
UPDATE: Bổ sung trường `infos`(`history`) và `pets`(`vaccination`) và điều chỉnh Model phù hợp

## 21.09.2024 - Đăng
UPDATE: Cập nhật tính năng thông báo và nhắc nhở khi sắp đến lịch hẹn bằng email và danh sách `<li>` - Tạo command mới `CheckBookingReminder` để kiểm tra các cuộc hẹn và gửi thông báo nếu đúng giờ remind_at - Thêm kiểm tra action là `preview` để xem nhanh - Thêm thuộc tính và hàm `remindStr` trong model `Booking` - Sửa lại migration `Booking` cho phép `doctor_id` nullable - Sửa lại kiểm tra quyền trong `modal_bookings` từ `CREATE_CATALOGUE` thành `CREATE_BOOKING` - Thêm view `reminder_notification.blade` để gửi mail - Thêm view `booking.blade` để xem preview lịch hẹn - Thêm `/{action?}` trong `web.php` của route `admin.booking`
UPDATE: Kiểm tra trong `CheckBookingReminder` chỉ lấy các `Booking` có status là 1
UPDATE: Thêm tính năng xóa cho `Booking` - Thêm hàm `remove` trong `BookingController` - Cập nhật giao diện và thêm nút xóa cho thẻ card trong `bookings.blade` - `Empty()` các nút trong trong giao diện khi load lại ở `bookings.blade`

## 23.09.2024 - Đăng
UPDATE: Chỉnh sửa thông báo nhắc lịch hẹn - Kiểm tra `$booking->appointment_at == $now` mới tạo lịch hẹn mới dựa theo `frequency`
trong `CheckBookingReminder` - Đổi `customer_id` thành `pet_id` trong model, migration, controller của `Booking` - Kiểm tra ngày hôm sau có lịch thì không cho tạo hoặc cập nhật lịch ở hàm `sync` trong `BookingController` - Thêm `case: 'search'` trong `PetController` search ajax cuả `pet` - Thêm các quan hệ `customer_id`, `author_id`, `doctor_id`, `pet_id` của `Booking` - Chỉnh sửa quan hệ của `Booking` với `_customer` thành `_pet` - Xóa quan hệ `booking_customers` của `User` với `Booking`

## 23.09.2024 - Quân
UPDATE: Bổ sung thêm trường `service_id` cho lịch nhắc hẹn - Thêm quan hệ trong Model Service - Cập nhật xét điều kiện Pet phải chưa book dịch vụ đó sau thời điểm hiện tại thì mới được book
UPDATE: Bổ sung thêm quan hệ many - many giữa Disease và Service
UPDATE: Cập nhật câu lệnh command `CheckBookingReminder` tự động kiểm tra book lịch sau mỗi giờ đồng hồ
UPDATE: Cập nhật câu lệnh command `CheckExpired` thêm EagerLoading để tối ưu truy vấn trích xuất hạn sử dụng
UPDATE: Hoàn thiện Booking
UPDATE: Chuyển phương thức convertUnit() từ Stock sang Variable
FIXBUG: Sửa lỗi click vào kết quả tìm kiếm gói tồn kho không xử lý thêm vào phiếu nhập hàng trong `app.blade`
UPDATE: Bỏ type trong Booking
UPDATE: Thêm màu cho Major và hiển thị lên Booking, sử dụng màu linh hoạt hơn theo cơ cấu màu của bootstrap phát triển thêm
UPDATE: Cho phép xem thông tin major từ danh sách quản lý dịch vụ trong `services.blade`
FIXBUG: Đổi nhánh `barcode` khi truy vấn dữ liệu thành `scan` trong `VariableController`, `UnitController`, `StockController`
UPDATE: Bổ sung tính năng in danh sách hàng tồn tại thời điểm hiện tại
UPDATE: Bổ sung tính năng hiển thị tổng số hàng hóa còn lại khi xem tồn kho theo kho và có truy vấn tìm kiếm
UPDATE: Tạo bảng `disease_service` và các quan hệ cần thiết trong 2 model
UPDATE: Chỉ xóa thông báo lỗi sau các input khi `resetForm()` trong `main.js`

## 24.09.2024 - Thắng
UPDATE: Thêm `button` in phiếu chỉ định ở giao diện phiếu khám
UPDATE: Thêm `button` đặt lịch hẹn cho mỗi dịch vụ trong phần chỉ định dịch vụ
UPDATE: Thêm `button` in toa thuốc và đặt lịch hẹn cho mỗi đơn thuốc của phiếu khám
UPDATE: Chuyển phần `Lý do khám` của phiếu khám lên phía trên các triệu chứng lâm sàn
UPDATE: Thêm phần `Bệnh sử` cho phiếu khám
UPDATE: Thêm lựa chọn loại dịch vụ khám cho phiếu khám
FIXBUG: Gọi hàm xử lý tạo 1 toa thuốc trống khi phiếu khám không tồn tại đơn thốc nào
UPDATE: Thay đổi thông báo khi tạo - cập nhật `prescription` và `info` (sử dụng name - code)
UPDATE: Điều chỉnh mẫu in phiếu khám, chuyển thông tin khách hàng và thú cưng thành 2 hàng ngang nhau
UPDATE: Load dữ liệu phiếu khám cho mẫu in
UPDATE: Thay đổi dữ liệu nhập vào khi tạo - cập nhật `Pet` - Chuyển thì chọn ngày sinh sang nhập số tháng tuổi của pet - Xử lý trước lưu: dựa trên số tháng tìm -> quy đổi tháng ngày đầu tiên của tháng tương ứng
UPDATE: Thêm gợi ý liều dùng cho đơn thuốc

## 25.09.2024 - Đăng
UPDATE: Cập nhật các tính năng xem, thêm, sửa, xóa phiếu chi. - Tạo ExpenseController và thêm các hàm xử lý `index`, `create`, `update`, `delete` - Đổi `statusStr` trong thuộc tính `appends` của model `Expense` thành `paymentStr` và thêm `avatarUrl` - Đổi `method` thành `payment` và `images` thành `avatar`, thêm hàm `getAvatarUrlAttribute` trong model `Expense` và migration tương ứng - Thêm các CONST `READ_EXPENSES`, `READ_EXPENSE`, `CREATE_EXPENSE`, `UPDATE_EXPENSE`, `DELETE_EXPENSE`, `DELETE_EXPENSES`, trong model `User` và PermissionSeeder với các quyền tương ứng - Thêm view, modal và các route tương ứng cho `CRUD_Expense`
FIXBUG: Chỉnh sửa lại sự kiện của `btn-remove-image` xóa `avatar` trong main.js

## 26.09.0224 - Đăng
Cập nhật CSDL bổ sung company_id và bảng `companies`

## 27.09.2024 - Đăng
FIXBUG: Xóa `cache()->forget('expenses');` trong `ExpenseController`
UPDATE: Thêm `company_id` trong `LogController::create`
UPDATE: Thêm trường `company_id`, quan hệ tương ứng trong các model và migration `Accommodation`,`Attribute`,`Beauty`,`Biochemical`,`Bloodcell`,`Booking Ticket`,`Branch`,`Catalogue`,`Category`,`Company`,`Criterial`,`Disease`,`Dosage`,`Expense`,`Export`,`Image`,`Import`,`Indication`,`Info`,`Log`,`Major`,`Medicine`,`Microscope`,`Notification`,`Order`,`Pet`,`Post`,`Prescription`,`Product`,`Quicktest`,`Room`,`Service`,`Setting`,`Stock`,`Supplier`,`Surgery`,`Symptom`,`Tracking`,`Transaction`,`Ultrasound`,`User`,`Warehouse`,`Xray`.
UPDATE: Tạo migration và model cho `Company`
UPDATE: Cập nhật `company_id` vào `add_main_branch_to_users `
UPDATE: Tạo migration `add_user_id_to_companies ` để cập nhật user_id sau khi tạo `company`
UPDATE: Thêm trường `company_id` có giá trị là 1 (TruongDungPet) vào cấc Seeder có sẵn
UPDATE: Cập nhật các tính năng xem, thêm, sửa, xóa công ty. - Tạo `CompanyController` và các hàm `index`, `create`, `update` và `remove` - Đổi `statusStr` trong thuộc tính `appends` của model `Expense` thành `paymentStr` và thêm `avatarUrl` - Đổi `method` thành `payment` và `images` thành `avatar`, thêm hàm `getAvatarUrlAttribute` trong model `Expense` và migration tương ứng - Thêm các CONST `READ_COMPANIES`, `CREATE_COMPANY`, `UPDATE_COMPANY`, `DELETE_COMPANY`, `DELETE_COMPANIES`, trong model `User` và PermissionSeeder với các quyền tương ứng - Thêm view, modal và các route tương ứng cho `company`

## 28.09.2024 - Đăng
UPDATE: Chình sửa các truy vấn của các Controller `AttributeController`,`BookingController`,`BranchController`,`CatalogueController`,`CategoryController`,`Criterial Controller`,`DebtController`,`Disease Controller`,`Expense Controller`,`ExportController`,`ImageController`,`ImportController`,`MajorController`,`Medicine Controller`,`NotificationController`,`OrderController`,`PetController`,`PostController`,`PrescriptionController`,`ProductController`,`RoleController`,`ServiceController`,`SettingController`,`StockController`,`SupplierController`,`SymptomController`,`TransactionController`,`UnitController`,`UserController`,`VariableController`,`WarehouseController`, thêm điều kiện `where('company_id', Auth::user()->company_id)`
UPDATE: Thêm trường `domain` vào model `Company` và migration tương ứng
UPDATE: Thêm quan hệ `company` trong model `User` và sửa quan hệ `company` (hasOne) thành `ownerCompany`
UPDATE: Thêm validate required của `note` trong `ExpenseController`

## 29.09.2024 - Quân
UPDATE: Chuyển khai báo `company_id` của bảng `users` trong migrations về khai báo chung với bảng `users`
UPDATE: Thêm giờ thông báo vào log nhắc lịch hẹn
UPDATE: Thêm trường `level` cho bảng `users`
UPDATE: Thêm menu Phiếu chi cho `sidebar.blade`

## 01.10.2024 - Đăng
UPDATE: Thêm tên bảng trước từng truy vấn `where('company_id', Auth::user()->company_id)` trong các Controller `AttributeController`,`BookingController`,`BranchController`,`CatalogueController`,`CategoryController`,`CompanyController`,`CriterialController`,`DashboardController`,`DebtController`,`Disease Controller`,`ExpenseController`,`ExportController`,`ImageController`,`ImportController`,`MajorController`,`MedicineController`,`OrderController`,`PetController`,`PostController`,`PrescriptionController`,`ProductController`,`RoleController`,`ServiceController`,`SettingController`,`StockController`,`SupplierController`,`SymptomController`,`TransactionController`,`UnitController`,`UserController`,`VariableController`,`Warehouse Controller`
UPDATE: Thêm truy vấn `where('company_id', Auth::user()->company_id)` ở tất cả các `Cache` trong `GlobalSettings`
UPDATE: Bắt sự kiện chuyển `company` của `btn-company-login` trong `company.blade`
UPDATE: Kiểm tra chi nhánh của tài khoản chuyển company để hiển thị đúng trong `header.blade`
FIXBUG: Kiểm tra `Cache` của sympton trong `modal_symptom`
UPDATE: Sửa truy vấn của bảng service theo `company_id`
UPDATE: Thêm route `admin.company.login` để cho phép chuyển công ty

## 02.10.2024 - Thắng
UPDATE: Các controller từ trên xuống: `AccommodationController` đến `MedicineController` - Xóa tất các hàm `sync()` - Ở các hàm `create()` và `update()` sử dụng `Object::create()` và `Object::update()` thay cho `$this->sync()`

## 02.10.2024 - Đăng
UPDATE: Group các truy vấn của case `select2`, `find`, `search` tìm kiếm theo `$request->q` để tạo thành truy vấn đã lượt bỏ theo `company_id` trong các controller `Disease Controller`,`MedicineController`,`PetController`,`ServiceController`,`SymptomController`,`UnitController`,`UserController`,
FIXBUG: Truy vấn của `Unit` đi tìm theo `variable.product` -> `company_id` trong `UnitController`
UPDATE: Thêm điều kiện if để kiểm tra quyền của `Auth:user()` là `Super Admin` mới cho phép thiết lập gửi mail

## 02.10.2024 - Đăng
UPDATE: Group các truy vấn của case `select2`, `find`, `search` tìm kiếm theo `$request->q` để tạo thành truy vấn đã lượt bỏ theo `company_id` trong các controller `Disease Controller`,`MedicineController`,`PetController`,`ServiceController`,`SymptomController`,`UnitController`,`UserController`,
FIXBUG: Truy vấn của `Unit` đi tìm theo `variable.product` -> `company_id` trong `UnitController`
UPDATE: Thêm điều kiện if để kiểm tra quyền của `Auth:user()` là `Super Admin` mới cho phép thiết lập gửi mail
UPDATE: Đổi `method` thành cột `payment` trong `ExpenseController` và view tương ứng (fix lỗi sort)
UPDATE: Thêm hai `orderColumn` author và `category` trong `PostController` và `major` trong `ServiceController`
UPDATE: Put thêm `logoUrl` vào `cache()->get('settings')` trong `GlobalSettings` Middleware
UPDATE: Chỉnh sửa lại `columnDefs` trong `transactions.blade`

## 02.10.2024 - Quân
UPDATE: Thêm `company_id` cho `InfoController`
UPDATE: Thay đổi dữ liệu trả về của `InfoController` và `PrescriptionController`
UPDATE: Cập nhật tin nhắn `validate` trả về khi gặp lỗi thêm hoặc sửa `PrescriptionController`
UPDATE: Thay đổi luồng truy cập cài đặt, chia nhỏ giao diện theo tính năng của `Setting` thành general, shop, clinic, website
UPDATE: Bổ sung phương thức `SettingController::updateClinic()` để cập nhật cài đặt phòng khám
UPDATE: Reset cache sau mỗi cập nhật Setting
UPDATE: Khóa Major, không mở cho khách hàng truy cập tự do mà dùng như công cụ kiểm soát dịch vụ, hạn chế thêm sửa xóa
UPDATE: Đưa danh sách dịch vụ trong major `Khám bệnh` vào thay cho info_service trong bảng `settings`
UPDATE: Với mỗi phần tử trong danh sách triệu chứng, tạo thành `symptom-item-form` để xử lý nhập phiếu khám khi submit form
UPDATE: Chuyển script booking ticket ra `app.blade`
UPDATE: Load lại dữ liệu quan hệ của indication sau khi cập nhật
UPDATE: Bổ sung `company_id` khi tạo và cập nhật phiếu khám
UPDATE: Bổ sung service_id, pet_id, doctor_id vào `modal_booking.blade` khi button có giá trị đó

## 03.10.2024 - Quân
FIXBUG: Tự chọn khách hàng khi click thanh toán công nợ trong phần quản lý công nợ

## 03.10.2024 - Thắng
UPDATE: Các controller từ trên xuống: `OrderController` đến `WarehouseController` - Xóa tất các hàm `sync()` - Ở các hàm `create()` và `update()` sử dụng `Object::create()` và `Object::update()` thay cho `$this->sync()`

## 03.10.2024 - Đăng
UPDATE: Put thêm các biến `favicon_url`, `logo_horizon_url`, `logo_square_url`, `logo_horizon_bw_url`, `logo_square_bw_url`, vào `cache() của settings` trong `GlobalSettings` và xóa `logoUrl`
UPDATE: Chỉnh các `placeholder` của hàm `getAvatarUrlAttribute` và `getLinkAttribute` trong các model `Catalogue`,`Expense`,`Image`,`Major`,`Pet`,`Post`,`Product`,`Service`,`User`, thành `placeholder_key`
UPDATE: Chỉnh và kiểm tra điều kiện để hiển thị ảnh trong các view `header.blade`, `sidebar.blade`, `app.blade`, `import_c80.blade`, `info_a4.blade`, `order_c80.blade`
UPDATE: Validate `amount` của phiếu chi
UPDATE: Kiểm tra module của `company` để hiển thị đặt lịch trong info.blade `has_booking`
UPDATE: Cập nhật lại avatar của user đang đăng nhập trong `header`
UPDATE: Chỉnh sửa giao diện của `modal_expense`
UPDATE: Kiểm tra điều kiện để hiển thị các `sidebar-item` theo company_id của user đang đăng nhập

## 04.10.2024 - Đăng
UPDATE: Thêm điều kiện ẩn pet trong dataTable của `user.blade`
FIXBUG: Tái sử dụng biến `$this->user` trong tất cả `Controller` ngoại trừ `InfoController`, `IndicationController`,
và `InfoDetailController`
UPDATE: Ẩn quyền `Super Admin` ở giao diện phân quyền user - Loại bỏ role có id là 1 trong `cache() roles` và `RoleController` và chỉ put thêm khi `User` đang đăng là `Super Admin` - Cập nhật lại truy vấn trong `ImportController`

## 27.09.2024 - Thắng
UPDATE: Thêm trường 'ticket' vào bảng `major` để nhận biết mẫu phiếu con được tạo ra tương ứng - Thêm `select[name="ticket"]` vào modal `modal_major.blade` - Cập nhật lại `MajorController::create()` và `MajorController::update()` cho phù hợp
UPDATE: Tạo phiếu con tương ứng cho từng phiếu chỉ định khi tạo các phiếu chỉ định của phiếu khám
UPDATE: Tăng giới hạn ký tự của các trường chuẩn đoán sơ bộ, chuẩn đoán bệnh, phát đồ điều trị và tiên lượng lên 255 ký tự
UPDATE: Điều chỉnh case `search` trong `ServiceController::index()` - Nếu tồn tại `$request->except` thì sẽ tìm ra các dịch vụ thuộc danh mục khác với `$request->except`
UPDATE: Thêm thông tin `pet`, `customer` và link liên kết dẫn đến phiếu khám trong danh sách đơn thuốc
UPDATE: Thêm case print vào PrescriptionController:index()
UPDATE: Truyền dữ liệu vào mẫu in đơn thuốc

## 04.10.2024 - Thắng
UPDATE: Điều chỉnh kiểu dữ liệu trường `frequency` của `dosages` từ `string` thành `unsignInteger`
FIXBUG: Điều chỉnh, bổ sung biến cho phù hợp với trang `prescription_a5.blade`
UPDATE: Cập nhật `PrescriptionController::index()` để phù hợp với nhu cầu truy vấn
UPDATE: Bỏ tính năng tạo đơn thuốc ở trang quản lý danh sách đơn thuốc
UPDATE: Xử lý dữ liệu khi hiện modal cho `modal_prescription.blade`
UPDATE: Thêm script xử lý khi xem chi tiết đơn thuốc ở trang danh sách đơn thuốc
UPDATE: Chuyển code từ `info.blade` sang `app.blade` - Chuyển hàm `removeDetail()` - Chuyển script bắt sự kiện `click` của `btn-remove-tr-medicine`

## 04.10.2024 - Quân
UPADTE: Xóa trường `company_id` trong `Dosage` Model - Dọn luôn `company_id` khi xử lý `dosage` ở phương thức `create()` và `update()` trong MedicineController - Xóa quan hệ `company` trong Model Dosage và `dosages` trong `Company` - Xóa luôn fillable của Dosage Model
UPDATE: Xóa trường website trong bảng `companies` - Cập nhật fillable trong mode Company - Cập nhật trường dữ liệu xử lý trong CompanyController - Cập nhật `modal_company.blade` và `companies.blade`
UPDATE: Đổi `medicines`(`ingredients`, `manufacture`) thành `medicines`(`prognosis`,`advice`) - Cập nhật Model Medicine tương ứng - Cập nhật MedicineController - Cập nhật `modal_medicine.blade` và `medicines.blade`
UPDATE: Đổi `company_id` trong Permission Model thành `scope`

## 05.10.2024 - Quân
UPDATE: Khi tạo đơn hàng, nếu không có thanh toán thì phải chọn một khách hàng để lưu công nợ
UPDATE: Không thể xem quyền Super Admin nếu không phải Super Admin
UPDATE: Cập nhật dữ liệu seeder mới nhất theo dữ liệu thực tế cuối ngày 04.10.2024
UPDATE: Bổ sung company_id khi tạo phiếu xuất kho

## 06.10.2024 - Thắng
UPDATE: Thêm dữ liệu `company_id` khi tạo các phiếu con trong các `case` ở `IndicationController::save()`
FIXBUG: Điều chỉnh danh sách các indication được trả về sau khi lưu phiếu xong (trả về toàn bộ indication của info)
UPDATE: Xóa tính năng xóa phiếu khám
UPDATE: Điều chỉnh validate giới hạn min của liều dùng và ngày dùng trong `PrescriptionController()`
UPDATE: Thêm `QuicktestController::index()` - hiển thị danh sách các phiếu kit test nhanh
UPDATE: Thêm điều kiện "ngoại trừ các dịch vụ thuốc nhóm `đơn thuốc` và `khám chữa`" ở `ServiceController::index() - case "search"`
UPDATE: Thêm dữ liệu cho trường `ticket` cho `majors` khi tạo dữ liệu mẫu ở `MajorSeeder`
UPDATE: Hiển thị danh sách các phiếu kit test nhanh `admin.quicktests.blade`
UPDATE: Ở danh sách phiếu khám: chuyển dữ liệu cột bác sĩ thành button cập nhật user để xem thông tin bác sĩ
FIXBUG: Sửa lỗi hiển thị `null` nếu user không có số điện thoại khi search user

## 06.10.2024 - Quân
FIXBUG: Xác nhận cập nhật phiếu nhập kho nội bộ
FIXBUG: Lưu cả ghi chú Nhà cung cấp khi Thêm nhà cung cấp
UPDATE: Sửa lỗi xem chi tiết vai trò luôn chỉ hiển thị vai trò Super Admin
FIXBUG: Cho phép xuất hàng từ kho nội bộ
UPDATE: Chuyển truy xuất dữ liệu logo vào Model Company
FIXBUG: Tự động chọn dịch vụ khám mặc định trên phiếu khám từ dữ liệu cài đặt trong Setting
FIXBUG: Load dữ liệu pet cho phiếu khám khi người dùng không phải Super Admin
UPDATE: Hiển thị hình mặc định khi load các hình ảnh bị lỗi trong `setting_general.blade`
UPDATE: Hiển thị hình ảnh logo theo công ty trong `sidebar.blade` và các mẫu phiếu in, nếu không có thì dùng logo mặc định

UPDATE: Ẩn số tiền trên dashboard và hiển thị nút hiện số tiền khi click vào
UPDATE: Cập nhật dữ liệu Dashboard theo công ty của người dùng hiện tại
UPDATE: Hiển thị tất cả nhân viên trong phần chọn bác sĩ/kỹ thuật viên đặt lịch hẹn của `modal_bookings.blade`
UPDATE: Thêm phần ghi chú vào bảng quản lý phiếu chi `expenses.blade`
UPDATE: Cập nhật tiêu đề cho các label trong `modal_product.blade` và `modal_variable.blade`

## 08.10.2024 - Đăng
UPDATE: Thêm hai tính năng upload thư mục `storage/app/public` lên GG drive để backup - Tạo command `BackupImage` và cho phép sử dụng lệnh `img:backup` - Tạo hàm `createGoogleDriveFolder` để tái sử dụng và tạo thư mục trên GG Drive - Tạo hàm đệ quy `uploadFolderToGoogleDrive` để duyệt qua từng folder và file có trong thư mục cha sau đó upload lên GG Drive sử dụng stream để mở file từng phần tránh quá tải - Tạo command `BackupDatabase` và cho phép sử dụng lệnh `db:backup` - Tạo hàm `handle` xử lý file theo stream tương tự file - Thêm `GoogleDriveServiceProvider` vào `app.php` (config) - Thêm thiết lập `Google Drive disk` (`google`) vào filesystem.php (config) để trỏ vào env lấy biến môi trường - Tạo Provider mới `GoogleDriveServiceProvider` cung cấp cho dịch vụ upload file lên GG Drive

UPDATE: Cập nhật tính năng in phiếu chỉ định
FIXBUG: Đồng nhất tên `quicktest`, `bloodcell`, `biochemical` cho toàn hệ thống
FIXBUG: Lưu phiếu khám thì cũng cộng giá dịch vụ khám cho đơn hàng
UPDATE: Đồng bộ tính năng xóa chi tiết đơn thuốc, chi tiết phiếu khám và chi tiết chỉ định cho phiếu khám
UPDATE: Tối ưu code phương thức `IndicationController::create()`
UPDATE: Loại bỏ thông tin kỹ thuật viên / bác sĩ của phiếu con khi lưu chỉ định, chỉ lưu trạng thái chưa hoàn thành trong `IndicationController::create()`
UPDATE: Cập nhật trạng thái mặc định và hint comment của các phiếu con trong CSDL và các migrations
UPDATE: Cập nhật phương thức `IndicationController::remove()` xóa phiếu chỉ định hoàn chỉnh, xóa luôn phiếu con và xóa cứng chỉ định nếu phiếu con chưa hoàn thành
UPDATE: Bổ sung mã phiếu chỉ định cho Model Indication
UPDATE: Bổ sung lại quyền tạo và xóa phiếu chỉ định
UPDATE: Trong trang chi tiết phiếu khám thì sẽ không load modal đơn thuốc
UPDATE: Bổ sung mã vạch cho các mẫu in phiếu khám và phiếu con
UPDATE: Xóa hàm `removeDetail()` và bắt sự kiện `.btn-remove-tr-medicine` trong `app.blade`
UPDATE: Điều chỉnh trình bày thông tin công ty trên tiêu đề các mẫu phiếu khám và phiếu con
UPDATE: Tái sử dụng code lắng nghe sự kiện `btn-remove-detail` cho toàn bộ phiếu khám
UPDATE: Bỏ load trực tiếp các chỉ định khi cập nhật phiếu khám trong `info.blade`, thay vào tái sử dụng hàm `reloadIndication()` trong script
UPDATE: Loại bỏ class `save-form` ở tất cả form của nút xóa chi tiết trong `info.blade`
UPDATE: Bỏ lắng nghe sự kiện của `.btn-remove-tr-symptom`, `.btn-remove-tr-service` và `.btn-remove-tr-medicine` trong `info.blade`
UPDATE: Đổi hàm `setPrescriptionOnForm()` và `setIndicationOnForm()` thành `reloadPrescription()` và `reloadIndication()`
UPDATE: Chuyển chức năng in phiếu chỉ định của toàn bộ phiếu khám thành in từng chỉ định đơn lẻ
UPDATE: Cập nhật tính năng đặt lịch hẹn theo phiếu khám và theo toa thuốc

## 08.10.2024 - Thắng
UPDATE: Thêm hàm `QuicktestController::update()` để xử lý cập nhật phiếu kit test nhanh
UPDATE: Thêm `Quicktest::getGalleryUrlAttribute()` để trả về mảng các đường dẫn ảnh của quick test
UPDATE: Cập nhật script xử lý hiển thị dữ liệu quick test khi click `btn-update-quicktest`

## 08.10.2024 - Quân
UPDATE: Thêm nút tắt thông báo rời cho chuông thông báo, tách chức năng tắt thông báo và xem thông báo
UPDATE: Thay đổi cấu trúc thông báo, tách rời nút tắt thông báo và xem thông báo
UPDATE: Điều chỉnh dropdown thông báo chỉ tắt khi click outside dropdown thông báo
UPDATE: Click vào nút tắt thông báo sẽ tự động đánh dấu thông báo đã đọc, không hiển thị lại nữa và cập nhật lại toàn bộ thông báo
UPDATE: Quá trình đánh dấu thông báo đã đọc, nếu tất cả thành viên được thông báo (qua chuông thông báo) đều đã đọc thì sẽ tự động xóa thông báo
UPDATE: Đưa thông báo chưa đọc vào trong cache(), tự động clear khi có người tắt thông báo
UPDATE: Thêm hàm `cleanStr()` vào thư viện helpers để dọn tất cả ký tự xuống hàng và khoảng trắng thừa của chuỗi
UPDATE: Loại bỏ middleware `readNoti`, dọn dẹp trong Kernel, đưa vào cấu trúc trong `NotificationController::index()`
UPDATE: Thêm tính năng tự động đóng `sidebar` khi click outside của `sidebar`
UPDATE: Đưa xử lý `.btn-preview` từ `app.blade` vào `main.js
UPDATE: Cập nhật thư viện JS của boostrap lên 5.3.3
UPDATE: Tự động thông báo mất kết nối Internet và tắt thông báo khi có internet trở lại
UPDATE: Bổ sung trường `infos`(`advice`) và `diseases`(`pronosis`,`advice`)
UPDATE: Nếu sidebar đang bật thì sẽ tự động tắt khi click ra ngoài

## 13.10.2024 - Đăng
UPDATE: Hoàn thiện tính năng nhập và xuất file `xlsx,xls,csv` - Thêm case `render` trong `ProductController::index` - Thêm thư viện `xlsx.full.min.js` vào `public/admin/vendor/xlsx` - Chỉnh sửa và thêm các hàm bắt sự kiện xuất, nhập file - Thêm modal `modal_render_product.blade` - Thêm `<div class="d-none" id="render-wrapper"></div>` để render dữ liệu xuất file - Thêm route `admin.product.refill` để nhập file và hàm `ProductController::refill` - Thêm class `UnitsImport` để chuyển file nhập vào thành dạng mảng với thư viện `Maatwebsite\Excel\Facades\Excel`

## 14.10.2024 - Thắng
UPDATE: Thêm hàm `UltrasoundController::update()` để xử lý cập nhật phiếu kit test nhanh
UPDATE: Thêm `Ultrasound::getGalleryUrlAttribute()` để trả về mảng các đường dẫn ảnh của quick test
UPDATE: Thêm `Ultrasound::getStatusStrAttribute()` để trả về trạng thái hiện tại của phiếu
UPDATE: Cập nhật `modal_ultrasound.blade`
UPDATE: Cập nhật script xử lý hiển thị dữ liệu quick test khi click `btn-update-ultrasound`

UPDATE: Thêm tính năng tìm bệnh theo triệu chứng, chọn bệnh cho triệu chứng bệnh

## 09.10.2024 - Quân
UPDATE: Loại bỏ bảng `info_details`, chuyển đổi sang lưu dưới dạng json và `infos`
UPDATE: Cập nhật bảng `infos`(`pet_id`, `detail_id`, `doctor_id`, `company_id`, `general`, `symptoms`, `diags`, `form`, `type`) - Cập nhật model tương ứng
UPDATE: Đổi cấu trúc trình bày phiếu khám - Đưa các thông tin cố định lên trên, ngang hàng với lý do đến khám và bệnh sử. Tất cả dữ liệu này sẽ lưu vào 1 trường `infos`(`generals`) dưới dạng json - Người dùng có thể nhập triệu chứng ngay trong phiếu khám mà không cần chọn bên menu triệu chứng - Áp dụng datalist vào input tên triệu chứng trong phiếu khám để gợi ý triệu chứng - Từ tên triệu chứng, xét theo danh sách triệu chứng trong menu triệu chứng để tự động điền phần nhóm cơ quan, nếu không khớp với gợi ý thì để nội dung thành `khác` - Từ tên triệu chứng, xét theo danh sách bệnh liên quan trong menu triệu chứng để tự động điền các bệnh lý nghi ngờ - Phần mô tả nếu có nhập mà bỏ trống phần tên triệu chứng thì sẽ báo lỗi (thêm class `is-invalid`, set input là `required` và thêm validate trong Controller) - Áp dụng `.local-select[multiple]` cho input nghi bệnh - Tất cả triệu chứng sẽ lưu vào trường `infos`(`symptoms`) dưới dạng json - Nếu triệu chứng chưa gặp bao giờ thì cũng lưu vào CSDL để phục vụ chẩn đoán về sau - Khi lưu triệu chứng mới thì sẽ kiểm tra bệnh lý liên quan và lưu liên kết bệnh với triệu chứng phục vụ các chẩn đoán y khoa về sau - Khi click gợi ý dịch vụ theo bệnh hoặc theo triệu chứng mới thì cũng lưu liên kết với bệnh hoặc triệu chứng đó để gợi ý về sau - Khi chọn bệnh đưa vào chẩn đoán thì tự động bổ sung tiên lượng, lời dặn bác sĩ v.v... của bệnh đó vào input tương ứng - Tất cả các chẩn đoán sẽ đưa vào trường `infos`(`diags`) dưới dạng json - Cập nhật các xử lý trong InfoController - Cập nhật các xử lý thuộc tính trong model Info - Điều chỉnh các cột trong DB `infos` - Cập nhật mẫu in phiếu khám và phiếu chỉ định `admin.template.info_a4`, `admin.template.info_a5`, `admin.template.indication_a5`
UPDATE: Bổ sung thiết lập xử lý quan hệ giữa bệnh và dịch vụ - Điều chỉnh bố cục `modal_disease.blade` - Cập nhật `create()` và `update()` trong `DiseaseController` - Cập nhật Model Disease
UPDATE: Bổ sung xử lý lời dặn của bác sĩ và tiên lượng cho quản lý bệnh lý - Điều chỉnh bố cục `modal_disease.blade` - Điều chỉnh `DiseaseController`
UPDATE: Cập nhật nút đặt lịch hẹn và tạo phiếu khám cho cho giao diện thú cưng trong `PetController`
UPDATE: Cập nhật nút thêm khách hàng và thêm thú cưng cho giao diện đặt lịch hẹn trong `PetController`
UPDATE: Cập nhật nút thêm khách hàng trong giao diện thêm thú cưng trong `UserController`
UPDATE: Bổ sung nút tạo phiếu khám cho thú cưng trong xử lý DataTables của `PetController`
FIXBUG: Cập nhật chỉ validate trùng dữ liệu phone và email của người dùng trong cùng 1 công ty trong `UserController`

## 10.10.2024 - Quân
FIXBUG: Bỏ `advice` và `prognosis` trong Medicine, xử lý lưu `sample_dosages` cho MedicineController - Đưa sample_dosage lên trên cột thông tin thuốc trong giao diện `modal_medicine.blade`, chuyển đổi thành `textarea` - Cập nhật `create()` và `update()` trong `MedicineController` - Cập nhật Model Medicine - Cập nhật load dữ liệu khi update trong `medicines.blade`

## 12.10.2024 - Quân
UPDATE: Cập nhật hàm `Controller::resetAutoIncrement()` cho phép xử lý dữ liệu mảng, cập nhật cho tất cả các Controller, tránh lặp code
FIXBUG: Bổ sung `company_id` khi nhập nhồi sản phẩm trong phiếu nhập hàng `ImportController::update()`
UPDATE: Đảo ngược tự động lựa chọn giống theo loài thú cưng để hiển thị danh sách giống mới lên trên cùng
UPDATE: Cập nhật xóa đơn hàng, cho phép xóa các phiếu lẻ
UPDATE: Thêm thuộc tính tên trạng thái cho Model `Accommodation`, `Biochemical`, `Bloodcell`, `Microscope`, `Prescription`, `Surgery`, `Ultrasound`, `Xray`
UPDATE: Điều chỉnh assignServices() trong model Disease cho phép xử lý dữ liệu mảng
UPDATE: Bổ sung thuộc tính `has_booking` cho model Indication (để kiểm tra dịch vụ của chỉ định đó đã được đặt trong tương lai chưa)
UPDATE: Cập nhật tên phân quyền Major thành `xét nghiệm`
UPDATE: Cập nhật phạm vi dữ liệu của các trường `diseases`(`prevention`, `advice`, `prognosis`) thành text và chuyển độ dài cho phép của string thành 255
UPDATE: Cập nhật các trường dữ liệu `technician_id`, `pharmacist_id`, `surgeon_id` của các phiếu con cho phép nullable
UPDATE: Cập nhật màu sắc giao diện cho nổi bật và bắt mắt hơn
FIXBUG: Điều chỉnh giao diện hiển thị các lịch hẹn, không bị tràn khung khi quá nhiều lịch hẹn trong ngày
UPDATE: Bổ sung danh sách dịch vụ vào phần cập nhật đơn hàng - Hiển thị dịch vụ nếu có phát sinh dịch vụ trong đơn hàng - Có thể mở đơn hàng ngay trong phiếu khám và thêm sản phẩm vào đơn hàng - Menu xử lý dịch vụ (ở góc trên bên phải của dịch vụ) linh hoạt theo dịch vụ
UPDATE: Khôi phục thư viện bootstrap về 5.0.2 (do xung đột với select2)
UPDATE: Nếu chưa có lịch hẹn cho pet_id với service_id trong tương lai thì hiển thị nút tạo lịch hẹn, nếu có rồi thì hiển thị nút cập nhật lịch hẹn

## 14.10.2024 - Quân
FIXBUG: Xử lý lưu phiếu khám ngay cả khi không thêm triệu chứng nào
FIXBUG: Xử lý lưu danh sách bệnh chẩn đoán sơ bộ, ngay cả khi không thêm bệnh nào
FIXBUG: Xử lý lưu danh sách chẩn đoán sơ bộ vào chung với các triệu chứng ngay cả khi không chọn nghi bệnh nào
UPDATE: Yêu cầu phải nhập cân nặng khi lưu phiếu khám
UPDATE: Xử lý lưu đơn hàng khi cập nhật giá dịch vụ chỉ định
FIXBUG: Bổ sung mã thuốc khi lưu toa thuốc
FIXBUG: Sửa lỗi không chọn được khách hàng sau khi tìm kiếm trong phiếu khám
UPDATE: Đảo ngược danh sách khách hàng để hiển thị những khách hàng mới nhất lên đầu tiên
FIXBUG: Cập nhật trích xuất thuộc tính chẩn đoán sơ bộ của triệu chứng trong phiếu khám nếu có dữ liệu
UPDATE: Chuyển nút xem đơn hàng xuống dưới cùng của phiếu khám và đổi màu cho dễ nhìn
FIXBUG: Cập nhật mẫu in của phiếu toa thuốc - Hiển thị lý do đến khám dưới dạng văn bản - Cập nhật xử lý hiển thị tuổi thú cưng
UPDATE: Nếu không có chẩn đoán sơ bộ hoặc chẩn đoán bệnh thì nội dung hiển thị sẽ là "Chưa ghi nhận bất thường

## 15.10.2024 - Quân
FIXBUG: Đổi phương thức `join(', ')` bên trong phương thức `map()` của `Info::getPrelimDiagAttribute()` thành hàm `implode()`
UPDATE: Cập nhật thêm phần dịch vụ cho form xem thông tin đơn hàng
FIXBUG: Cho phép modal trượt nội tuyến ở tất cả modal có thể bị kéo dài
FIXBUG: Không hiển thị tên kỹ thuật viên thực hiện phiếu khám lên phần cập nhật đơn hàng nếu không có
UPDATE: Bắt buộc phải nhập thân nhiệt trong phiếu khám thú cưng
UPDATE: Hiển thị form xem đơn hàng trong phiếu khám thay cho modal cập nhật đơn hàng
FIXBUG: Cho phép ngày hẹn trước thời điểm hiện tại khi cập nhật phiếu hẹn
UPDATE: Điều chỉnh TTL của tất cả cache chỉ cho sống trong 15 phút ngoại trừ `version`
UPDATE: Tách riêng phần khám sơ bộ và chẩn đoán trong phiếu khám
UPDATE: Ẩn phần triệu chứng trong mẫu in phiếu khám nếu không có triệu chứng nào
FIXBUG: Nếu ticket của major là `info` hoặc `prescription` thì không đưa vô xóa trong indication
FIXBUG: Load lại mã phiếu khám khi validate bị lỗi
FIXBUG: Không xóa phiếu con nếu không tìm thấy phiếu con trong `OrderController::remove()`
UPDATE: Cân nặng tối thiểu của thú cưng là 0.1kg
UPDATE: Điều chỉnh dữ liệu và cách thức trả về của phiếu khám khi gặp lỗi
FIXBUG: Lưu mô tả triệu chứng khi tạo danh sách triệu chứng trong cả `create()` và `update()` của `InfoController`
FIXBUG: Xóa đơn hàng thì xóa luôn phiếu khám, đơn thuốc và các phiếu chỉ định nếu đơn thuốc chưa phát và phiếu con của các chỉ định chưa thực hiện

## 16.10.2024 - Quân
UPDATE: Điều chỉnh câu lệnh gọi backup thư viện ảnh `php artisan image:backup` và nhắc hẹn `php artisan db:backup`
UPDATE: Bổ sung mốc thời gian vào thông báo truy vấn
UPDATE: Loại bỏ khách hàng ra khỏi danh sách thông báo
UPDATE: Đổi quy cách lặp lại nhắc nhở thành số giờ (thay cho số thứ tự quy ước trước đây)
UPDATE: Điều chỉnh câu lệnh kết xuất CSDL để backup gồm cả mật khẩu để không hỏi mật khẩu khi backup tự động
FIXBUG: Cập nhật lưu trữ trạng thái phiếu đặt lịch hẹn
UPDATE: Thêm danh xưng phía trước ghi chú dịch vụ trong phần cập nhật đơn hàng
UPDATE: Thay đổi cách trình bày tần suất lặp lại và các tùy chọn của phiếu đặt lịch hẹn - Điều chỉnh phạm vi của `bookings`(`frequency`) phù hợp
UPDATE: Cho phép cập nhật giá nhập, hạn sử dụng và lô hàng của phiếu nhập kho nội bộ hoặc phiếu đã có xuất mẻ hàng trong `ImportController`
FIXBUG: Cập nhật gọi phương thức `resetAutoIncrement()` trong `ImportController` sử dụng mảng để tránh trùng lặp code
UPDATE: Loại bỏ quyền `UPDATE_PRESCRIPTION_DETAIL` và `DELETE_PRESCRIPTION_DETAIL` trong `User` Model, thay bằng quyền cập nhật đơn thuốc
FIXBUG: Đồng bộ biến đếm khi hiển thị đơn thuốc trong phiếu khám
FIXBUG: Xóa nhanh chi tiết đơn thuốc nếu chưa lưu đơn thuốc
FIXBUG: Khi tạo thuốc mới cần phải xét tính duy nhất của thuốc sẽ loại trừ thuốc đã bị xóa
FIXBUG: Xử lý không lưu toa thuốc nếu không tìm thấy dịch vụ `Đơn thuốc điều trị` để thêm vào đơn hàng trong `ServiceController`
UPDATE: Thêm option `khác` để chọn danh mục dịch vụ khi tạo mới dịch vụ trong `MajorController` - Xử lý hiển thị `Không có` khi một dịch vụ không có danh mục
UPDATE: Bổ sung xử lý tính tổng giá trị vật tư tiêu hao cho dịch vụ trong `services.blade`
UPDATE: Cập nhật form xem đơn hàng, không xử lý chi tiết đơn hàng đối với hàng hóa hoặc dịch vụ nếu không tìm thấy chi tiết đơn hàng của nhóm tương ứng

## 17.10.2024 - Quân
FIXBUG: Điều chỉnh cân nặng thú cưng hiển thị trong danh sách phiếu khám
UPDATE: Bổ sung thêm cột Chỉ định trong danh sách DataTables phiếu khám
FIXBUG: Điều chỉnh nếu không có Dịch vụ Đơn thuốc điều trị thì không được tạo đơn thuốc
UPDATE: Rút gọn và loại bỏ các chẩn đoán sơ bộ bị trùng
FIXBUG: Tự động tính tổng giá trị hàng hóa tiêu hao khi xóa bớt một món trong `service.blade`
FIXBUG: Bao gồm cả các dịch vụ không có danh mục trong kết quả tìm kiếm dịch vụ trong `ServiceController::index()`
FIXBUG: Cho phép thêm chỉ định dịch vụ nếu dịch vụ không có danh mục trong `IndicationController::create()`
FIXBUG: Hiển thị đúng dịch vụ khám khi phiếu khám đổi dịch vụ khác với dịch vụ mặc định trong info.blade
FIXBUG: Cập nhật giá dịch vụ khám khi thay đổi dịch vụ khám trong `InfoController::update()`

## 17.10.2024 - Thắng
UPDATE: Nén ảnh khi lưu cho phần ảnh của các phiếu con
FIXBUG: Sửa lỗi thêm 2 lần ảnh khi thêm ảnh ở phiếu kit test nhanh

## 17.10.2024 - Quân
UPDATE: Bổ sung tính năng thêm thanh toán vào form xem đơn hàng (nếu người dùng có quyền xem thanh toán)
FIXBUG: Hủy tất cả select2 trước khi `submitForm()` và gọi lại sau khi `submitForm()`
FIXBUG: Load lại các select.local-select sau khi mở/đóng modal hoặc gọi hàm ``submitForm()`
FIXBUG: Bổ sung tên biến thể vào kết quả tìm kiếm thuốc trong `info.blade`
FIXBUG: Thử nghiệm bắt sự kiện `.btn-remove-detail` mới
FIXBUG: Sửa lỗi select2 trên `.local-select` khi mở modal hoặc submit form
FIXBUG: Sửa lỗi select2 `.local-select` khi `submitForm()` hoàn tất
UPDATE: Thay đổi cấu trúc xóa các chi tiết, tái tạo form mới để submit thay cho form có sẵn trong HTML, tránh lồng form
FIXBUG: Chỉ xác thực chi tiết phiếu nhập có tồn tại khi đó là phiếu xuất kho nội bộ khi xóa chi tiết xuất hàng trong ExportDetailController
FIXBUG: Loại bỏ các chi tiết phiếu nhập bị nhồi thêm trong các phiếu nhập nội bộ hoặc phiếu nhập đã có bán mẻ hàng. Chỉ chấp nhận cập nhật các chi tiết đã có trong `ImportController::update()`

## 18.10.2024 - QUân
UPDATE: Bổ sung tính năng tìm kiếm lịch hẹn - Thêm case `search` trong `BookingController::index()` - Tạo input search sử dụng cơ chế ajax-search trong `bookings.blade`
FIXBUG: Cập nhật lưu chuỗi bệnh vào CSDL trong `InfoController::create()` và `InfoController::update()`
FIXBUG: Cập nhật lưu giá tiền thuốc là tổng tiền tất cả loại thuốc trong đơn thuốc tính theo giá biến thể (ở ĐVT nhỏ nhất) _ liều dùng _ số lần/ngày \* số ngày
UPDATE: Xóa đơn thuốc đồng thời cũng xóa chi tiết đơn hàng liên kết với đơn thuốc
UPDATE: Không cần lưu đơn vị tính vào chi tiết đơn hàng
UPDATE: Tối ưu tìm kiếm khách hàng trong phiếu khám
FIXBUG: Không điền tên người khách hàng nếu không có khách hàng trong chi tiết phiếu khám
FIXBUG: Đưa hàm `fillCustomer()`, `fillListPet()` xuống thành scope gốc để truy cập trên toàn hệ thống
UPDATE: Hiển thị ghi chú trên thẻ lịch hẹn thay cho mô tả gửi khách trong `bookings.blade`
FIXBUG: Điều chỉnh hiển thị bán lẻ POS khi chọn hàng thì số lượng, đơn vị tính, đơn giá và thành tiền chia thành 2 hàng
UPDATE: Khi lưu khách hàng mới trong phiếu khám xong thì chạy hàm tự động điền thông tin phiếu khám và liệt kê danh sách thú cưng của khách hàng đó

## 19.10.2024 - Quân
UPDATE: Điều chỉnh hiển thị `sidebar.blade`, phân bổ các xét nghiệm thành cụm theo lĩnh vực để người dùng tiện tìm kiếm
UPDATE: Đổi cột `Nội dung` thành cột `Chỉ định` trong tất cả danh sách phiếu con xét nghiệm
UPDATE: Bổ sung data-term và data-description cho các mục trong danh sách bộ phận cần siêu âm.
UPDATE: Thay đổi bố trí nội dung phiếu siêu âm thành 2 cột cơ quan với hình ảnh và mô tả kết quả.
UPDATE: Truyền mô tả của chỉ tiêu của các cơ quan vào mô tả kết quả trong phiếu siêu âm
UPDATE: Điều chỉnh nội dung tiêu đề của các trường thông tin trong `modal_criterial.blade` cho dễ hiểu hơn

## 21.10.2024 - Quân
UPDATE: Bổ sung case `advice` và `prognosis` cho `DiseaseController`
UPDATE: Sử dụng cache đồng bộ cho Disease
UPDATE: Chuyển script của disease ra `app.blade` và bóc tách thành các hàm chức năng `initCreateDisease()` và `initUpdateDisease()` để tiện gọi
UPDATE: Điều chỉnh các tên hàm initial thành init cho gọn và tiện tìm kiếm
UPDATE: Cập nhật giao diện phiếu khám mới - Bố trí chỉ định dịch vụ lên trên phần chẩn đoán - Phần chẩn đoán thay đổi bố cục thành 4 cột để các khối nội dung có nhiều diện tích nhập liệu hơn - Bỏ phần danh sách triệu chứng bên trái, chuyển đổi thành `info_symptoms-modal`, khi click vào nút `Quy trình chuẩn` sẽ mở modal với các thao tác như cũ - Bỏ phần danh sách thuốc, chuyển đổi thành `info_medicines-modal`. Khi click nút gọi ý `Thuốc` thì sẽ mở modal với các thao tác như cũ - Bố trí hình thức khám và dịch vụ khám xuống dưới, rút gọn lại để tối ưu không gian sử dụng phiếu - Tối ưu giao diện phiếu khám trên mobile dễ dàng sử dụng với bác sĩ và các kỹ thuật viên - Xử lý lưu chỉ định chung với phiếu khám, truyền `$request` từ `create()` và `update()` của `InfoController` sang `IndicationController::save()` - Bổ sung tính năng tự động điền tiên lượng và lời dặn từ các chẩn đoán bệnh - Bổ sung tính năng điều chỉnh bệnh trực tiếp trong phiếu khám - Load chỉ định trực tiếp chung với load trang, loại bỏ hàm `reloadIndication()`
UPDATE: Điều chỉnh `IndicationController::save()` không cần check tồn tại `service_ids` nữa

## 21.10.2024 - Quân
FIXBUG: Cập nhật đúng id đơn hàng vào trường `[name=order_id]`, đảm bảo lưu chỉ định dịch vụ vào đúng đơn hàng
UPDATE: Loại bỏ `DB::beginTransaction()`, `DB::commit()` và `DB::rollBack()` trong `IndicationController::save()` tránh gọi 2 lần từ `InfoConController`
UPDATE: Chuyển xử lý kiểm tra dữ liệu tồn tại trong `InfoController::update()` ra khỏi khối try-catch
UPDATE: Thêm nút bật danh sách gợi ý thuốc xuống dưới toa thuốc
UPDATE: Cập nhật toàn xử lý tại các nút chức năng in, truyền id vào thuộc tính `data-id` của nút thay vì dùng `input[name=id]` cùng form, giảm sự phụ thuộc form
UPDATE: Check quan hệ `prescription_details` trước khi xóa thuốc. Nếu được thì `forceDelete()` trước luôn
UPDATE: Điều chỉnh liên kết đến lần khám cuối cùng trong xử lý DataTables tại `PetController::index()`
UPDATE: Nếu Pet đã có phiếu khám thì chỉ xóa mềm, còn mới tạo nhầm thì `forceDelete()` luôn
UPDATE: Cập nhật tên phiếu khám vào chi tiết đơn hàng khi lưu phiếu khám
UPDATE: Check quan hệ với `medicine` và `prescription_details` khi xóa sản phẩm và biến thể
FIXBUG: Nếu Notification không được tạo thì không push đến người dùng trong `StockController::pushExhaustedNoti()`
UPDATE: Điều chỉnh `prescriptionDetails()` thành `prescription_details()`
UPDATE: Tăng tốc mở submenu trên sidebar trong `main.js`
FIXBUG: Đổi toàn bộ `initSelect2()` thành `initLocalSelect()` trong `main.js`
FIXBUG: Cập nhật nút đặt lịch hẹn cho các chỉ định trong `info.blade`
FIXBUG: Bổ sung nút thêm thuốc vào đơn thuốc trong phiếu khám và trả lại id ẩn cho đơn thuốc
FIXBUG: Xử lý đơn vị tính mặc định khi không tìm thấy đơn vị tính nào khi hiển thị danh sách thuốc

## 20.10.2024 - Thắng
UPDATE: Cập nhật `ExportController::create()` - Nếu là xuất hàng cho đơn thuốc hoặc phiếu chỉ định thì cập nhật trường `export_id` của đối tượng tương ứng - Thêm dữ liệu cho `order_id` khi tạo export
UPDATE: Thêm case `export` trong `switch($request->action)` ở case default của `IndicationController:index()` và PrescriptionController::index()`để trả về dữ liệu cần thiết khi tạo đơn xuất hàng
UPDATE: Thêm script xử lý khi xuất đơn thuốc ở`prescriptions.balde`UPDATE: Thêm script xử lý xuất vật tư tiêu hao ở cho phiếu chỉ định ở`info.blade`UPDATE: Thêm trường`export_id`ở`indications`        - Thêm ràng buộc với`Indication`trong Model`Export`        - Thêm ràng buộc với`Export`trong Model`Indication`UPDATE: Xóa`Medicine::exportStock()`UPDATE: Thêm`Variable::getStocksToExport()` để truy xuất các kho cung cấp biến thể hiện cần cho việc xuất hàng

## 23.10.2024 - Quân
FIXBUG: Cập nhật cấu trúc hiển thị trên chuông thông báo cho các lịch hẹn
FIXBUG: Cập nhật số lượng thông báo chính xác trên chuông thông báo theo số thực tế của người dùng trong `GlobalSettings`
FIXBUG: Cập nhật lỗi liên quan đến cấp quyền và validate trong `BranchController`
UPDATE: Cập nhật validate cho `CriterialController` và cho phép nhập tối đa 255 ký tự trong phần mô tả của `modal_criterial.blade`
FIXBUG: Cho phép tìm kiếm và sắp xếp dữ liệu cho danh sách phiếu khám trong `InfoController::index`
UPDATE: Bổ sung cột chỉ định bệnh trong DataTables của `InfoController::index()`
UPDATE: Hiển thị gợi ý liều dùng khi chọn thuốc để thêm vào toa thuốc - Cập nhật case `search` trong `MedicineController::index()` - Cập nhật `#info_medicines-modal` trong `modal_info.blade` để click vào thuốc thì sẽ xổ ra các liều dùng gợi ý - Cập nhật bắt sự kiện `.btn-create-prescription_detail` trong `info.blade` để truyền dữ liệu liều dùng gợi ý xuống toa thuốc - Bổ sung bắt sự kiện click vào `.medicine-item-title` thì tính toán lại liều dùng thuốc theo khối lượng thú cưng
UPDATE: Bổ sung phần dịch vụ cho mẫu in đơn hàng
UPDATE: Bổ sung khổ in A5 cho đơn hàng
UPDATE: Chuyển bắt sự kiện gọi lệnh in đơn hàng vào dropdown để người dùng có thể dễ dàng chọn khổ in
UPDATE: Cập nhật phần trạng thái đơn hàng bổ sung chỉ thị màu và hiển thị đầy đủ trạng thái
UPDATE: Điều chỉnh hàm `addFinalDiagControl()` và `addPrelimDiagControl` trong `info.blade`, hiển thị nút bấm trực tiếp thay vì dropdown
UPDATE: Bắt sự kiện click vào `.btn-dismiss-select2` thì sẽ tắt gợi ý tùy chọn để khi click vào nút bổ sung thì không bị rối giao diện
UPDATE: Ngăn chặn sắp xếp với các cột chỉ định và chẩn đoán của DataTables phiếu khám
UPDATE: Đổi cột `pet_id` và `doctor_id` thành `pet` và `doctor`
UPDATE: Đồng bộ nút truyền dữ liệu từ modal xuống phiếu khám để tăng tính nhận diện
UPDATE: Truyền thêm template vào Controller để chọn mẫu in, nếu không có thì dùng mẫu in mặc định
UPDATE: Đổi toàn bộ ngày tháng năm dưới phần ký tên của các mẫu phiếu in thành ngày hiện tại
UPDATE: Bỏ danh xưng bác sĩ ở dưới phần ký tên các mẫu in
UPDATE: Load lại toàn bộ nút bấm khi load lại toàn bộ đơn thuốc
UPDATE: Đơn thuốc đã phát thì không thể cập nhật hay xóa chi tiết đơn thuốc
UPDATE: Chuyển `modal_info.blade` ra `app.blade`
UPDATE: Chuyển `modal_booking.blade` xuống dưới hiển thị đè lên các modal phiếu con khác
UPDATE: Bỏ phần thêm thuốc vào đơn thuốc trong `modal_prescription.blade`
UPDATE: Bổ sung `service_id`,`doctor_id`,`pet_id` vào nút đặt lịch hẹn cho đơn thuốc

## 24.10.2024 - Quân
UPDATE: Điều chỉnh kiểu dữ liệu lưu số lượng trong chi tiết phiếu xuất và số lượng tồn kho là số thập phân 2 chữ số
UPDATE: Hiển thị danh sách gợi ý dịch vụ thêm vào phiếu khám trên mobile
FIXBUG: Thêm thuộc tính export_id vào đối tượng tái tạo từ old() của `indications` trong `info.blade`
UPDATE: Bổ sung responsive cho table unit và transaction trong `modal_variable.blade` và `modal_order.blade()

## 28.10.2024 - Quân
UPDATE: Điều chỉnh tự động nhắc lịch hẹn và tạo lịch nhắc lại nếu trạng thái là đang chờ hoặc sẽ tới
UPDATE: Hiển thị thêm thông tin thú cưng trong chi tiết lịch hẹn
UPDATE: Điều chỉnh kiểu dữ liệu lưu trong `criterials`(`normal_index`) thành kiểu float
UPDATE: Cập nhật xóa Criterial là xóa cứng
UPDATE: Điều chỉnh nội dung phiếu nhập kho nội bộ thêm cụm từ 'Nhập từ ' phía trước mã phiếu xuất
FIXBUG: Hiển thị tên người nhập hàng trong DataTables `ImportController::index()`
UPDATE: Chỉ được thêm, sửa, xóa nếu Major thuộc type 1
FIXBUG: Chỉ xóa phiếu con nếu có phiếu con khi xóa đơn hàng
UPDATE: Chỉ hiển thị ngày tạo nếu ngày tạo không null trong cột `code` của các DataTables
UPDATE: Loại bỏ phương thức canRemove() trong Criterial Model
FIXBUG: Điều chỉnh số tiền của trường `expenses`(`amount`) là dạng decimal,10,0
FIXBUG: Điều chỉnh hiển thị nút lưu đon hàng khi người dùng có quyền tạo đơn hàng
UPDATE: Thêm tùy chọn không có mẫu phiếu con cho danh mục dịch vụ

## 28.10.2024 - Quân
UPDATE: Cập nhật lưu cache theo từng company_id tránh bị hiển thị trùng dữ liệu giữa các Công ty
UPDATE: Khi tạo lịch nhắc lại cho tạo lịch dịch vụ thì set trạng thái là Đang chờ trong `console\Commands\CheckBookingReminder
UPDATE: Thêm tùy chọn yêu cầu biên nhận khi lưu phiếu chi trong `ExpenseController::create()`UPDATE: Thêm tính năng xử lý hàng loạt cho phiếu chi
UPDATE: Yêu cầu phải chọn hình ảnh khi lập phiếu chi
FIXBUG: Điều chỉnh cấu trúc xử lý khi xóa sản phẩm, xóa thuốc, liều dùng liên quan khi xóa sản phẩm trong`ProductController::remove()`UPDATE: Hiển thị thêm đơn vị tính cho DataTables quản lý dịch vụ trong`ServiceController::index()`UPDATE: Tìm kiếm với từ khóa trong DataTables quản lý dịch vụ trong`ServiceController::index()`UPDATE: Thêm ràng buộc chỉ được tạo 1 và chỉ 1 đơn vị tính có tỷ lệ chuyển đổi là 1 và không được tạo đơn vị tính có tỷ lệ chuyển đổi trùng nhau trong cùng 1 biến thể
UPDATE: Thêm các thư mục lưu trữ của`quicktest`, `ultrasound`, `bloodcell`, `biochemical`, `microscope`, `xray`trong`config\filesystems.php`UPDATE: Điều chỉnh mẫu in A5 của đơn hàng tối ưu không gian hiển thị nội dung
UPDATE: Gộp 2 cột`diseases`(`incubation`,`communicability`) thành `diseases`(`infection_chain`) và bổ sung thêm cột `diseases`(`counsel`)
    - Cập nhật các trường `fillable`trong Model Disease
    - Cập nhật DiseaseController validate, datatables, lưu và cập nhật các trường tương ứng
    - Cập nhật`modal_disease.blade`cho các tên trường tương ứng
    - Cập nhật`app.blade`hiển thị đúng nội dung khi cập nhật Disease
    - Cập nhật`diseases.blade` hiển thị các cột dữ liệu của DataTables tương ứng

## 29.10.2024 - Quân
UPDATE: Điều chỉnh phương thức gọi cache() toàn cục
FIXBUG: Cho phép lưu trùng tên vai trò nếu khác công ty - Điều chỉnh migration `2024_04_05_095211_create_permission_tables`, thêm ràng buộc unique cho `name`,`guard_name` và `company_id` - Khi tạo role, kiểm tra nếu tên bị trùng với một role đã có nhưng khác công ty thì vẫn được tạo - Khi cập nhật role, kiểm tra nếu tên bị trùng nhưng cùng $request->id và cùng công ty thì không được tạo - Xây dựng model Role kế thừa model Role mặc định của Spatie và ghi đè phương thức `Role::create()` - Cập nhật lại class Role gọi trong `RoleController` là `App\Models\Role` thay cho `Spatie\Permission\Models\Role` mặc định
FIXBUG: Cho phép tạo người dùng trùng tên và số điện thoại nếu khác công ty
FIXBUG: Điều chỉnh cột của DataTables trong `diseases.blade`, đổi `ủ bệnh` thành `chuỗi lây nhiễm` và bỏ cột `lây lan`
UPDATE: Cập nhật cách thức ghi nhận lỗi với nhiều thông tin hơn, hỗ trợ cho quá trình debug hiệu quả
UPDATE: Bổ sung try-catch cho `save()`,`remove()` của `Indication`; `create()`,`update()`,`remove()` của `Prescription`; `remove()` của `ProductController`
UPDATE: Bổ sung tính năng xem chi tiết về bệnh đối với những người dùng không có quyền cập nhật thông tin bệnh
UPDATE: Bổ sung hàm `sortCheckedInput()` trong `main.js` tự động di chuyển những checkbox đã được check lên đầu danh sách

## 03.11.2024 - Quân
UPDATE: Thiết lập tùy chọn tự động lưu bệnh và triệu chứng mới vào CSDL khi lưu phiếu khám
FIXBUG: Tự động chọn chính xác nhóm triệu chứng khi tạo triệu chứng mới
FIXBUG: Loại bỏ hàng hóa tiêu hao nếu không có hàng hóa tiêu hao lưu kèm dịch vụ trong `ServiceController::update()`
FIXBUG: Cập nhật quyền người dùng khi hiển thị nút tạo và lưu đơn hàng trong `modal_order.blade`
UPDATE: Chuyển tất cả cột checkbox của DataTables ra phía sau cùng
UPDATE: Chuyển tất cả cột "Thứ tự" (nếu có) của DataTables ra trước cột thao tác
UPDATE: Chuyển tất cả sắp xếp cột mặc định là cột đầu tiên (trừ Model có sắp xếp thì sắp theo cột "Thứ tự")

## 06.11.2024 - Quân
UPDATE: Điều chỉnh cách thức khởi tạo dữ liệu mặc định cho Công ty trong CompanyController
UPDATE: Bổ sung `company_id` và `group` cho Expense
UPDATE: Bổ sung `expense_group` để lưu danh mục chi mặc định
UPDATE: Bổ sung tính năng xem phiếu khám, nếu không có quyền sửa phiếu khám mà có quyền xem phiếu khám thì vẫn xem phiếu khám được
UPDATE: Cập nhật cấu trúc DataTables của Expense, Ultrasound, Quicktest - Tiền xử lý các phân quyền - Dồn cột khách hàng vào cột thú cưng - Bổ sung phần chi nhánh và hiển thị danh sách theo chi nhánh (như nhập xuất kho)
UPDATE: Bổ sung phần sổ tiêm chủng cho thú cưng - Nếu chỉ định được tạo thuộc về danh mục tiêm chủng thì sẽ đưa vào sổ tiêm chủng - Hiển thị sổ tiêm chủng trong chi tiết thú cưng
UPDATE: Tối ưu hàm `number_format()` trong `main.js`
UPDATE: Chuyển script của `.btn-indication-export` ra `app.blade`
UPDATE: Điều chỉnh route bloodcell thành bloodcell và cách đặt tên class, id của Bloodcell tương tự
UPDATE: Điều chỉnh route biochemical thành biochemical và cách đặt tên class, id của BioChemical tương tự
UPDATE: Điều chỉnh route quicktest thành quicktest và cách đặt tên class, id của Quicktest tương tự
UPDATE: Sắp xếp thứ tự hiển thị dữ liệu phiếu khám thành requirements, environment, daily_food, weight, recent_food, temperature, bcs

## 07.11.2024 - Quân
UPDATE: Bổ sung tính năng xem thông tin bệnh (nếu không được update nhưng vẫn có quyền xem)
UPDATE: Bổ sung tính năng xem đơn thuốc
UPDATE: Điều chỉnh tự động lặp lại trong Đặt lịch hẹn là 'Không nhắc'
UPDATE: Dời phần chi nhánh sang cột khám tại trong `infos.blade`
UPDATE: Thiết lập điều kiện hiển thị nút Xuất kho thuốc khi có quyền xuất kho
UPDATE: Điều chỉnh hiển thị tất cả thông báo
UPDATE: Bổ sung chức năng thêm lịch tiêm chủng riêng cho thú cưng
FIXBUG: Điều chỉnh bỏ trống nếu trong cache() không lưu danh sách permissions mặc định
FIXBUG: Cập nhật quyền Thêm và Sửa Biến thể trong DataTables của `ProductController::index()`

## 08.11.2024 - Quân
UPDATE: Tối ưu tốc độ ghi dữ liệu cập nhật phân quyền vai trò
FIXBUG: Điều chỉnh tự động thêm nút chức năng cho Bệnh không bị lặp lại trong Chi tiết phiếu khám
UPDATE: Cho phép chọn ngân hàng thực hiện thanh toán giao dịch
UPDATE: Thêm cài đặt hiển thị mã QR thanh toán trên mẫu in của C80 và a5 của đơn hàng trong `templates.prints.order_a5.blade` và `templates.prints.order_c80.blade`
FIXBUG: Cập nhật sản phẩm có hình ảnh sẽ lưu thêm hình ảnh vào công ty của tài khoản đang đăng nhập
FIXBUG: Hiển thị thuốc bao gồm thuốc đã bị xóa của chi tiết đơn thuốc trong phiếu khám `info.blade`
FIXBUG: Điều chỉnh mẫu in đơn thuốc chia khách hàng thành thú cưng thành 2 cột cứng
UPDATE: Điều chỉnh luôn hiển thị 'Chưa ghi nhận bất thường' với chẩn đoán sơ bộ và chẩn đoán bệnh
UPDATE: Cho phép load lại phiếu khám đối với các loại thuốc đã bị xóa
FIXBUG: Đổi tên cột trong `bloodcells`(`conslution`) thành `bloodcells`(`conclution`)

## 25.10.2024 - Thắng
UPDATE: Thêm `BloodcellController::index()` và `BloodcellController::update()`
UPDATE: Ở Model `Bloodcell` - Thêm `indication()` để tạo ràng buộc với `Indication` - Thêm `getGalleryUrl()` để lấy đường dẫn các ảnh của phiếu
FIXBUG: Cập nhật lại tên trường `conslusion` của `bloodcells` thành `conclusion`
UPDATE: Cập nhật `modal_bloodcell.blade` để phù hợp cho việc đổ dữ liệu vào
UPDATE: Ở `bloodcells.blade` : Thêm script xử lý hiển thị danh sách phiếu, các thao tác liên quan

UPDATE: Thêm `BiochemicalController::index()` và `BiochemicalController::update()`
UPDATE: Ở Model `Biochemical` - Thêm `indication()` để tạo ràng buộc với `Indication` - Thêm `getGalleryUrl()` để lấy đường dẫn các ảnh của phiếu
UPDATE: Cập nhật `modal_biochemical.blade` để phù hợp cho việc đổ dữ liệu vào
UPDATE: Ở `biochemicals.blade` : Thêm script xử lý hiển thị danh sách phiếu, các thao tác liên quan
UPDATE: Chuyển các function, script xử lý giống nhau ở `bloodcells.blade` và `biochemical.blade` ra `app.blade`

UPDATE: Thêm `MicroscopeController::index()` và `MicroscopeController::update()`
UPDATE: Ở Model `Microscope` - Thêm `indication()` để tạo ràng buộc với `Indication` - Thêm `getGalleryUrl()` để lấy đường dẫn các ảnh của phiếu
UPDATE: Cập nhật `modal_microscope.blade` để phù hợp cho việc đổ dữ liệu vào
UPDATE: Ở `microscope.blade` : Thêm script xử lý hiển thị danh sách phiếu, các thao tác liên quan

UPDATE: Thêm `XrayController::index()` và `XrayController::update()`
UPDATE: Ở Model `Xray` - Thêm `indication()` để tạo ràng buộc với `Indication` - Thêm `getGalleryUrl()` để lấy đường dẫn các ảnh của phiếu
UPDATE: Cập nhật `modal_xray.blade` để phù hợp cho việc đổ dữ liệu vào
UPDATE: Ở `xray.blade` : Thêm script xử lý hiển thị danh sách phiếu, các thao tác liên quan

## 11.11.2024 - Thắng
UPDATE: Điều chỉnh hàm `index()` phần trả về danh sách các phiếu của các phiếu con - Gộp cột khách hàng và thú cưng lại thành một cột - Thêm tên chi nhánh vào bên dưới kĩ thuật viên
UPDATE: Thêm tên dịch vụ thực hiện vào modal các phiếu con

## 12.11.2024 - Thắng
UPDATE: Ở các bảng `microscropes`, `quicktests`, `biochemicals`, `bloodcell` đổi trường `image` từ kiểu dữ liệu string sang text
FIXBUG: Điều chỉnh chỉ xuất kho với những tồn kho đã nhập thành công

## 12.11.2024 - Quân
UPDATE: Cập nhật hiển thị bổ sung phần chi nhánh và phiếu khám cho bảng dữ liệu của `microscope`,`xray`,`bloodcell`,`biochemical` tương tự như `ultrasound` và `quicktest`
FIXBUG: Xóa hình ảnh thú cưng triệt để trong phần chi tiết thú cưng
UPDATE: Bổ sung nút xóa cho chi tiết phiếu `xray` và `ultrasound`
FIXBUG: Hiển thị số tiền trong cột giá của bảng quản lý Dịch vụ

## 16.11.2024 - Quân
UPDATE: Loại bỏ 'Chưa ghi nhận bất thường' khi hiển thị Chẩn đoán bệnh
UPDATE: Xóa cache sau khi đẩy thông báo mới cho người dùng trong `NotificationController::push()`
FIXBUG: Khi tìm gói tồn kho để thêm vào giỏ hàng hoặc phiếu xuất kho thì chỉ lấy theo các đơn vị tính chưa bị xóa trong case `seach` của `StockController::index()`
FIXBUG: Xác thực dữ liệu các giá trị quy đổi không được trùng nhau trong `VariableController::update()`
FIXBUG: Hiển thị chính xác dữ liệu quy đổi đơn vị tính đối với các dữ liệu số thực. Dùng fmod() để chia lấy phần dư trong `Variable::convertUnit()`
FIXBUG: Thay đổi đơn vị tính sẽ tự động tính lại tổng thành tiền đơn hàng trong `app.blade`
FIXBUG: Chỉ lấy hàng từ các phiếu nhập kho đã xác nhận để đưa vào phiếu xuất thuốc hoặc phiếu xuất vật tư tồn kho trong `Variable::getStockToExport()`

## 16.11.2024 - Thắng
UPDATE: Thêm `DetailController:index()` để trả về danh sách details theo điều kiện đầu vào
UPDATE: Thêm `modal_detail.balde` để hiển thị danh sách details
UPDATE: Thêm tính năng hiển thị các details liên quan đến stock chỉ định ở `stock.blade`

## 18.11.2024 - Thắng
UPDATE: Thêm `/{action?}` vào url của các phiếu con
UPDATE: Thêm tính năng in cho các phiếu con

## 18.11.2024 - Quân
UPDATE: Điều chỉnh công nợ thành đối soát trong `app.blade` - Liệt kê tất cả đơn hàng có chênh lệch thanh toán so với tổng giá trị đơn hàng - Số tiền là thừa thì hiện màu xanh có dấu dương (+), Số tiền là thiếu thì hiện màu đỏ có dấu âm (-) - Nếu số tiền là thiếu thì mới hiện nút thanh toán trong `DebtController::index()`
UPDATE: Hiển thị công nợ theo chi nhánh người dùng đang trực thuộc và hiển thị ô chọn chi nhánh xem công nợ trong `debts.blade`
UPDATE: Hiên thị thêm mã đơn hàng dưới mã phiếu khám trong danh sách phiếu khám `InfoController::index()`
UPDATE: Thêm dấu hiệu nhận biết đơn hàng có điều chỉnh giá kế bên mã đơn hàng
UPDATE: Bổ sung `DB::beginTransaction()` trong `ServiceController::save()`
UPDATE: Xác thực dữ liệu khi xóa hàng loạt trong `ServiceController::remove()`
UPDATE: Tối ưu truy vấn truy xuất dữ liệu trước khi xóa hàng loạt trong `ServiceController::remove()`
UPDATE: Nếu dịch vụ chưa từng đặt hàng hoặc chưa từng đặt lịch thì xóa cứng luôn
FIXBUG: Hiển thị số tiền và hình thức thanh toán đúng khi hiển thị các giao dịch thanh toán trong giao diện xem đơn hàng `TransactionController::index()`
UPDATE: Cập nhật `Service::criterial_details()` thành `Service::details()`
UPDATE: Xóa `Service::canRemove()`
UPDATE: Tăng giới hạn đơn thuốc tối đa lên 10 đơn và tối ưu không gian trống
FIXBUG: Bỏ định dạng tách số cho các trường `dosage`, `frequency`, `quantity` trong `prescription.blade.php`

## 20.11.2024 - Quân
FIXBUG: Chỉ hiển thị đơn vị tính đã lưu trong phiếu nhập hàng
FIXBUG: Điều chỉnh cấu trúc Indication tái tạo dữ liệu từ input đã submit
UPDATE: Điều chỉnh hiển thị số tiền đối soát khi gợi ý khách hàng cho đơn hàng hoặc phiếu khám

## 21.11.2024 - Thắng
UPDATE: Đổi tên file: - `admin.previews.quicktest` thành `admin.previews.quicktest` - `admin.prints.quicktest` thành `admin.prints.quicktest`
UPDATE: Thêm tính năng preview cho các phiếu con
UPDATE: Đổi lại name các phần tử con liên quan đến `criterial` trong trường `details` của các bảng `xrays`, `ultrasounds`, `biochemicals`, `bloodcells`
UPDATE: Chuyển script hiển thị modal update và các xử lý liên quan từ blade của phiếu con ra `app.blade`
UPDATE: Fill data cho các trang preview
FIXBUG: Điều chỉnh name trong các trang print của phiếu con lại cho phù hợp, xử lý lỗi vòng lặp khi không có chi tiết phiếu
UPDATE: Thêm validate cho các phiếu con - Kiểm tra request ảnh nếu rỗng thì truy xuất từ dữ liệu trước đó + Nếu có tồn tại ảnh tương ứng với cơ quan / tiêu chí thì thay thế vào + Nếu không tồn tại cơ quan / tiêu chí tương ứng -> thông báo lỗi

## 22.11.2024 - Thắng
UPDATE: Thêm hình ảnh liên quan vào phiếu in của các phiếu con
UPDATE: Thêm tính năng hủy xuất đơn thuốc - hoàn trả thuốc đã xuất về đúng stock
UPDATE: Thêm route `admin.prescription.refund` và hàm `PrescriptionController::refund()` để thực hiện hoàn trả thuốc đã xuất
UPDATE: Thêm trường `diagram` và `advice` vào bảng `surgeries`

## 23.11.2024 - Thắng
UPDATE: Thêm UpdateTicketSeeder để cập nhật dữ liệu trường details của các phiếu con

## 28.11.2024 - Thắng
UPDATE: Thêm `SurgeryController::index()` và `SurgeryController::update()` để xử lý hiển thị danh sách, truy xuất và cập nhật phiếu phẫu thuật
UPDATE: Tại Model Surgery: - Thêm ràng buộc với indication - Thêm thuộc tính galleryUrl để lấy hình ảnh trước và sau phẫu thuật
UPDATE: Cập nhật cấu trúc bảng `surgeries` - Thêm trường `surgical_method` - Thay đổi tên trường `diagnosis_before` thành `images_before` - Thay đổi tên trường `diagnosis_after` thành `images_after`
UPDATE: Xử lý fill dữ liệu cho `surgeries.blade` và `modal_surgery.blade`
UPDATE: Thêm script xử lý cập nhật phiếu phẫu thuật ở `app.blade`
UPDATE: Cập nhật fill dữ liệu cho `admin.prints.surgery_a5` và `admin.previews.surgery`

## 30.11.2024 - Quân
FIXBUG: Cập nhật object accomodation thành accommodation đồng bộ trên toàn hệ thống
FIXBUG: Điều chỉnh hiển thị chính xác thông báo - Cập nhật `route('admin.notification.mark')` thay cho case 'mark' trong NotificationController::index() - Cập nhật bắt sự kiện cho .btn-mark-noti yêu cầu submit form để gửi lệnh tắt thông báo - Cập nhật xóa nút tắt thông báo khỏi phần nội dung lưu vào CSDL mà sẽ thêm khi hiển thị thông báo - Điều chỉnh CSDL thông báo - Bỏ qua cache thông báo, hiển thị dữ liệu thông báo trực tiếp từ DB
FIXBUG: Bổ sung thư viện jQueryUI về local
UPDATE: Bổ sung phân loại dịch vụ qua chỉ định và không qua chỉ định
UPDATE: Chuyển tùy chọn mẫu phiếu từ Major sang Service
UPDATE: Khởi tạo CSDL lưu trữ thông tin chấm công
UPDATE: Bổ sung bảng phụ lưu quan hệ nhiều nhiều giữa Pet và Room
UPDATE: Bổ sung `accommodation_id` cho bảng `infos`

## 01.12.2024 - Quân
UPDATE: Cài đặt package Intervention để hỗ trợ xử lý hình ảnh
UPDATE: Cập nhật phương thức xoay ảnh `Image::rotate()`
UPDATE: Cập nhật phương thức tính tuổi thú cưng theo năm, tháng trong model Pet
FIXBUG: Cập nhật phương thức tìm kiếm dịch vụ qua select2 cho các dịch vụ online và offline trong `ServiceController::index()`
FIXBUG: Xóa chi tiết phiếu xuất thì đồng thời cũng xóa luôn trên giao diện phiếu xuất sau khi xử lý xong
UPDATE: Tối ưu cách hiển thị tên kỹ thuật viên trong phần chữ ký các phiếu con
FIXBUG: Cập nhật thuộc tính `autocomplete="off"` cho các trường trong `modal_company.blade`
FIXBUG: Nếu đơn vị tính đã xóa và không còn đơn vị tính nào khác thì hiển thị đơn vị tính đã xóa của sản phẩm được chọn thêm vào phiếu xuất/đơn hàng
FIXBUG: Tối ưu không gian hiển thị mẫu in các phiếu con
UPDATE: Điều chỉnh kích thước mẫu in hình ảnh của các phiếu con

## 01.12.2024 - Quân
UPDATE: Cập nhật tính năng gửi Zalo cuộc hẹn cho khách hàng - Bổ sung class Services/Zalo - Bổ sung các thiết lập khóa API cho zalo trong `.env` - Bổ sung route('admin.booking.send_zns') - Điều chỉnh class Zalo vào dependency injection của cấu trúc `BookingController` - Bổ sung phương thức `BookingController::send_zns()` - Bổ sung nút gửi Zalo cho khách hàng và cho bác sĩ trong chi tiết lịch hẹn - Bắt sự kiện click nút .btn-send-zns trong `app.blade`
UPDATE: Cho phép gọi điện trực tiếp từ số điện thoại của khách hàng trong danh sách khách hàng và chi tiết lịch hẹn - Bổ sung cập nhật cột `phone` trong `UserController::index()` - Điều chỉnh số điện thoại khách hàng có thể click vào gọi trực tiếp trong `modal_booking.blade`
UPDATE: Bổ sung tính năng liệt kê lịch sử giá nhập hàng cho phiếu nhập - Ẩn dấu mũi tên của `input[list]` trong `key.css` - Bổ sung lọc lịch sử giá nhập của sản phẩm nhập kho theo đơn vị tính khi quét barcode và khi tìm kiếm - Hiển thị giá nhập dưới dạng datalist của sản phẩm khi thêm vào phiếu nhập hoặc hiển thị cập nhật phiếu nhập trong `app.blade`

## 02.12.2024 - Quân
UPDATE: Loại bỏ thuộc tính aria-hidden trên toàn bộ modal
UPDATE: Cập nhật trạng thái trả về khi gặp lỗi là 'error' (thay vì 'danger') như trước
UPDATE: Đổi toàn bộ quick_test thành quicktest, QuickTest thành Quicktest
UPDATE: Đổi toàn bộ biochemical_test thành biochemical, BiochemicalTest thành Biochemical
UPDATE: Đổi toàn bộ bloodcell_test thành bloodcell, BloodcellTest thành Bloodcell
UPDATE: Đổi toàn bộ booking_ticket thành booking, BookingTicket thành Booking
FIXBUG: Điều chỉnh phản hồi lỗi trên toàn bộ hệ thống với status là `danger` đổi thành `error`
UPDATE: Nếu `submitForm()` không nhận được thông báo trả về nào thì không hiển thị thông báo thất bại trong `main.js`

UPDATE: Bổ sung tính năng gửi giao dịch thanh toán qua Zalo cho khách hàng - Bổ sung `route('admin.transaction.send_zns')` - Bổ sung phương thức `Transaction::send_zns()` - Bổ sung class Zalo vào dependency injection của cấu trúc `TransactionController` - Bổ sung khu vực hiển thị nút zalo cho `modal_transaction.blade` - Bổ sung xử lý hiển thị nút gửi zalo cho transaction trong `app.blade`

## 03.12.2024 - Quân
UPDATE: Tái cấu trúc lại phần dịch vụ, chia thành 2 loại là có chỉ định và không cần chỉ định - Bổ sung checkbox `is_indicated` cho `modal_service.blade` - Bổ sung checkbox `is_indicated` cho `admin/service.blade`
UPDATE: Chuyển mẫu phiếu `ticket` từ Major sang Service
UPDATE: Cập nhật `tracking_ticket` thành `tracking`, `TrackingTicket` thành `Tracking` trên toàn hệ thống
UPDATE: Bổ sung trường `ticket` cho Indication Model
UPDATE: Cập nhật `Prescription` là một chỉ định của `Info` - Loại bỏ trường `detail_id` và `info_id` trong `prescriptions` - Thêm trường `indication_id` trong bảng `prescriptions` - Khi tạo đơn thuốc thì đồng thời cũng tạo 1 chỉ định trong phiếu khám tương ứng - Điều chỉnh quan hệ `Info` với `Prescription` trong `info.blade` - Điều chỉnh quan hệ `Detail` với `Prescription` khi gọi `modal_order.blade` trong `app.blade`

## 05.12.2024 - Đăng
UPDATE: Thêm tính năng chấm công, giao diện chấm công - Thêm `model` Work , `WorkController` các route cần thiết - Cập nhật giao diện cấm công của nhân viên

## 07.12.2024 - Đăng
UPDATE: Tính năng cài đặt chấm công - Thêm hàm `SettingController::updateWork()` - Thêm forget Cache của user trong `UserController` `cache()->forget('users_' . $this->user->company_id)` - Thêm RUD cho work thêm các hàm CRUD cho `Work` - Thêm `Cache` cho `users`
UPDATE: Tính năng sắp lịch, xem chấm công - Sửa các const trong `Model` User
-CREATE_WORKS, UPDATE_WORK => CREATE_WORK, UPDATE_WORK - Sửa `note` trong `migration` của work => nullable - Thêm `moment.locale('vi');` trong main.js - Thêm thư viện js `moment-with-locales.js`, `webcam.js` - Sửa lại view `works` => `work_list.blade` và `work_calendar.blade` - Sửa lại modal `modal_schedule.blade`, `modal_timekeeping.blade` thêm chấm công và cập nhật lại chấm công

## 13.12.2024 - Đăng
UPDATE: Fix lỗi cho chấm công - Thêm phân quyền cho chấm công - Sửa màu lại cho các chấm công - Thêm ràng buộc sửa đổi setting khi đã có nhân viên đăng ký ca

## 13.12.2024 - Quân
UPDATE: Điều chỉnh truy vấn dữ liệu case 'filter' trong `BookingController::index()`
UPDATE: Điều chỉnh lấy tất cả User là nhân viên khi load trang trong `WorkController::index()`
FIXBUG: Không validate khi xóa lượt đăng ký chấm công
UPDATE: Xóa cache 'users' trong `GlobalSettings`
UPDATE: Thêm quan hệ `User::works()`
UPDATE: Không dùng SoftDelete cho Work Model
UPDATE: Hiển thị tất cả ca trong tất cả ngày trong giao diện lịch làm việc `work_calendar.blade`
UPDATE: Chuyển CSS của tooltip vào `key.css`UPDATE: Cập nhật tên bảng DataTable của tất cả danh sách quản lý
FIXBUG: Sửa lỗi không tự động load bảng DataTable trên tất cả danh sách
UPDATE: Cập nhật quyền 'sắp lịch chấm công' thành CREATE_WORK trong User Model
UPDATE: Điều chỉnh template gửi zalo ZNS đặt lịch hẹn

## 04.12.2024 - Quân
UPDATE: Cập nhật core Laravel
UPDATE: Tách phương thức khởi tạo phiếu con cho các chỉ định thành `IndicationController::create_ticket()`
UPDATE: Điều chỉnh phương thức xoá phiếu chỉ định `IndicationController::remove()` theo đúng quan hệ của đơn thuốc
UPDATE: Lưu ghi chú ngày giờ cho chi tiết đơn hàng của phiếu khám theo ngày giờ tạo phiếu khám tại `InfoController::create()`
UPDATE: Điều chỉnh quan hệ của phiếu lưu trú với chi tiết đơn hàng là quan hệ trực tiếp, không qua phiếu khám Detail Model
UPDATE: Điều chỉnh quan hệ của đơn thuốc với đơn hàng là phải qua phiếu chỉ định trong `PrescriptionController::class`
UPDATE: Điều chỉnh fillable của Prescription Model, xoá trường `detail_id` và `info_id`
UPDATE: Điều chỉnh phương thức xoá đơn thuốc truyền mảng `[id]` theo $request->choices theo thông lệ
FIXBUG: Điều chỉnh bảng quản lý của các đối tượng có thuộc tính sort
FIXBUG: Hiển thị tên danh mục khi mở modal cập nhật dịch vụ trong script tại `services.blade`
FIXBUG: Điều chỉnh quan hệ của đơn thuốc với đơn hàng khi mở modal cập nhật đơn hàng và modal xuất đơn thuốc trong script `admin.app.blade`
UPDATE: Điều chỉnh quan hệ của đơn thuốc khi xem đơn thuốc và in đơn thuốc tại `admin.templates.prescription.blade`

## 05.12.2024 - Quân
UPDATE: Thêm trường `orders`(`total`) và `users`(`debt`)
UPDATE: Đổi thiết lập `allow_negative_stock` thành `scores_rate_exchange` trong Settings
UPDATE: Thú cưng đã bị khóa (chết) thì không hiển thị trong lịch hẹn nữa trong `BookingController::index()`

## 06.12.2024 - Quân
UPDATE: Chỉ hiển thị lịch hẹn của những thú cưng chưa bị khóa
FIXBUG: Cập nhật cách tính giá vốn hàng bán theo đơn vị tính
FIXBUG: Tự động tạo đơn thuốc khi thêm chỉ định dùng thuốc vào phiếu khám
FIXBUG: Tìm kiếm dịch vụ theo tên hoặc theo từ khóa trong đặt lịch hẹn
UPDATE: Chuyển sang lưu các thông số zalo vào `settings` và trích xuất từ cache()
UPDATE: Thay đổi hình thức gửi zalo thành dấu checkbox gửi zalo cho khách sau khi lưu
UPDATE: Thêm quyền gửi zalo cho khách hàng trên các loại phiếu (Giao dịch thanh toán, Đặt lịch hẹn, Phiếu làm đẹp, Phiếu điều trị)

## 10.12.2024
UPDATE: Chỉ đổi tên thư mục đầu ngoài cùng của thư mục backup image lên Google Drive
UPDATE: Xóa chỉ định thì đồng thời cũng xóa luôn phiếu con của chỉ định đó

## 13.12.2024
UPDATE: Chỉ đặt tên theo ngày giờ đối với thư mục gốc khi backup hình ảnh lên Google Drive
UPDATE: Thêm hàm parseDate() cho helper hỗ trợ xử lý tìm dữ liệu theo ngày
UPDATE: Xóa chỉ định thì đồng thời cũng xóa luôn phiếu con của chỉ định đó
UPDATE: Tự động tích điểm khi khách hàng thanh toán đơn hàng - Tích điểm khi tạo đơn hàng - Trừ điểm khi xóa đơn hàng - Tích điểm khi tạo giao dịch - Cộng / trừ điểm khi điều chỉnh giao dịch - Trừ điểm khi xóa giao dịch
UPDATE: Cập nhật giá trị đơn hàng cho đơn hàng khi lưu hoặc xóa đơn hàng - Khởi tạo `DetailObServer` và đăng ký với `AppServiceProvider` - Tạo phương thức `saved` và `deleted` cho `DetailObserver` để cập nhật giá trị đơn hàng khi xóa hoặc lưu với Model Detail
FIXBUG: Điều chỉnh cách tính giá trị gốc của đơn hàng khi preview và print

## 14.12.2024 - Quân
UPDATE: Bổ sung chức năng tìm kiếm phiếu nhập hàng, phiếu xuất hàng, giao dịch thanh toán theo trạng thái (tìm bằng cụm từ viết liền không dấu)
UPDATE: Bổ sung tool, kiểm tra lệch tồn kho
UPDATE: Ẩn nút xóa trên tab tên đơn thuốc
UPDATE: Điều chỉnh chức năng chấm công

## 16.12.2024 - Quân
FIXBUG: Cập nhật hiển thị ngày trong giao diện bảng tin
FIXBUG: Trình bày dữ liệu theo ngày, tuần, tháng, quý, năm

## 17.12.2024 - Lộc
UPDATE: Thêm tính năng thiết lập phiếu chi trong `settings`

## 19.12.2024 - Huy
UPDATE: Trong `DashboardController` gọi dữ liệu trả về để vẽ dữ liệu so sánh
FIXBUG: Trong `dashboard.blade.php` cập nhật lại hàm buidchart để vẽ biểu đồ
FIXBUG: Cập nhật lại thư viện của CharJS

## 17.12.2024 - Quân
UPDATE: Cập nhật bổ sung liên kết đến modal khách hàng và thú cưng trên modal_booking.blade
UPDATE: modal_pet đưa xuống dưới modal_booking khi load code

## 24.12.2024 - Đăng
UPDATE: Thêm `case 'summary'` cho `WorkController::index()` cho render `modal_work_summary`
UPDATE: Đem thư viện `daterangepicker` từ `dashboard.blade` ra `app.blade` để sử dụng chung cho `modal_work_summary`
UPDATE: Xóa nút lưu của modal sắp lịch `modal_schedule`
UPDATE: Thêm tính năng tổng kết chấm công trong tháng

## 20.12.2024 - Quân
FIXBUG: Cập nhật việc gọi cache trên toàn cục, tránh việc gọi sai do thiếu company_id
UPDATE: Chuyển thiết lập phiếu khám sang `setting_clinic.blade`
UPDATE: Chuyển thiết lập QR trên đơn hàng sang `setting_shop.blade`
UPDATE: Điều chỉnh nội dung các label cho hợp lý

## 19.12.2024 - Lộc
UPDATE: Tạo thêm trường mới tên là status cho migrations `expense`
UPDATE: Thêm quyền duyệt phiếu chi cho người có quyền duyệt phiếu chi
UPDATE: Tính tổng số tiền theo ngày cho phiếu chi
UPDATE: Chỉnh sửa giao diện của `expenses.blade.php`

## 19.12.2024 - Đăng
UPDATE: Thêm hàm `getDescendantIds` trong `Controller` để lấy danh sách ID của các danh mục con (bao gồm các đời cháu).
UPDATE: Lấy danh sách sản phẩm trong xuất excel bao gồm các sản phẩm trong danh mục con của danh mục đang được chọn

## 19.12.2024 - Quân
FIXBUG: Điều chỉnh cách hiển thị dữ liệu của bảng tin
FIXBUG: Điều chỉnh cách hiển thị các nhóm quyền trong `modal_permission.blade`
UPDATE: Bổ sung thư viện tạo sinh QRcode

## 20.12.2024 Tố
UPDATE: Bổ sung tính năng tìm kiếm chi tiết cho các bảng dữ liệu
UPDATE: Bổ sung tính năng nhảy trang cho các bảng dữ liệu

## 20.12.2024 - Quân
UPDATE: Cập nhật tính năng kiểm kho
UPDATE: Cập nhật tính năng tìm kiếm chi tiết cho các bảng dữ liệu
UPDATE; Cập nhật tính năng nhảy trang cho các bảng dữ liệu
UPDATE: Cập nhật tính năng thống kê kho theo chu kỳ được chọn
UPDATE: Cập nhật tính năng refresh bảng dữ liệu của tất cả các bảng trong hệ thống để xóa các sắp xếp, bộ lọc hoặc tìm kiếm trước đó

## 21.12.2024 - Đăng
UPDATE: Update tính năng thêm nhanh phiếu khám 
    - Xóa đoạn `formId !== "info-form"` để resetForm trong hàm `submitForm (main.js)`
    - Trong hàm `InfoController::create()` thêm các điều kiện `if($request->ajax())` để trả về dữ liệu đúng cấu trúc submitForm nhận
    - Thêm `info-form` trong `modal_info`
    - Mang một số đoạn code sử dụng chung cho `info.blade` (tạo trên trang) và `modal_info` (tạo trên modal) ra `app.blade`


## 21.12.2024 Tố
UPDATE: Bổ sung trường `commitment_required` và `commitment` vào model `Serivce`.
UPDATE: Bổ sung trường toggle `commitment_required` và textarea `commitment` vào `modal_serivce.blade`.
UPDATE: Bổ sung `commitment_required` và `commitment` vào `SerivceController`.
UPDTAE: Thêm function toggleCommitment() vào `service.blade`.

## 21.12.2024 - Quân
UPDATE: Cập nhật chức năng in phiếu cam kết điều trị
FIXBUG: Cập nhật trình bày xuống hàng cho các nội dung json trong phiếu khám trong Info Model

## 22.12.2024 - Quân
FIXBUG: Cập nhật cách tính cột tồn kho đầu kỳ của giao diện kiểm kho
UPDATE: Thêm trường commitment_required và commitment_note cho bảng service
UPDATE: Điều chỉnh route detail chấp nhận thêm các action
UPDATE: Thêm action 'print' cho chi tiết đơn hàng để xử lý các in phiếu liên quan đến dịch vụ
FIXBUG: Điều chỉnh commitment thành commitment_note
    - Cập nhật trường `commitment` thành `commitment_note` trong `modal_service.blade`
    - Cập nhật fillable của Modal Service
    - Cập nhật phương thức lưu dịch vụ của `ServiceController::create()`
FIXBUG: Validate trường `commitment_note` không được trống khi `commitment_required` được check
UPDATE: Thêm nút in cam kết điều trị trong phần chỉ định dịch vụ của phiếu khám
UPDATE: Điều chỉnh mẫu in `commitment_a5.blade` cho hiển thị `commitment_note` theo nội dung khách tự điền trong dịch vụ
UPDATE: Cập nhật tính năng khám nhanh dành cho các dịch vụ cơ bản
    - Có thể click vào ô mở rộng để chuyển đổi sang khám chi tiết dễ dàng với dữ liệu đã nhập sẽ được giữ nguyên
UPDATE: Cập nhật không load phiếu khám nhanh khi đang ở trong trang chi tiết phiếu khám
UPDATE: Sửa lỗi trả về 404 khi lưu phiếu khám gặp lỗi
UPDATE: Hiển thị ngày đầu tuần là thứ Hai khi sắp lịch chấm công

## 23.12.2024 - Quân
FIXBUG: Điều chỉnh quan hệ `indication.detail` thành `indication._detail` trên toàn hệ thống
FIXBUG: Bổ sung tình huống chỉ định không có phiếu khi xóa phiếu đơn hàng trong `OrderController:remove()`
FIXBUG: Nếu chưa có người phát thuốc thì hiển thị là chưa phát thuốc trong DataTables của `PrescriptionController::index()`
FIXBUG: refresh trang thì xóa luôn bộ lọc của DataTables trong tất cả các bảng giao diện dữ liệu DataTables
FIXBUG: Nếu có phiếu info và phiếu info phải có id thì `.info-form[action]` là cập nhật, còn lại là tạo mới
UPDATE: Chỉ hiện nút xuất vật tư tiêu hao khi dịch vụ có vật tư tiêu hao và vật tư đó chưa xuất lần nào cho chỉ định đó
UPDATE: Chỉ hiện thị các đơn thuốc nếu có truyền vào biến $info và $info phải có id (đề phòng chuyển form mở rộng)
UPDATE: Thêm nút thêm tất cả chỉ định cho `modal_biochemical` và `modal_bloodcell` đồng thời xử lý khi click vào nó thì tất cả tiêu chí đều add vào phiếu
UPDATE: Tự động xuống hàng đối với tất cả phiếu con khi in dữ liệu nhập vào từ textarea

## 23.12.2024 - Huy
UPDATE: Trong `DashboardController` viết hàm `customer`, `product`, `service`
UPDATE: Trong `dashboard.blade` viết hàm  `dataTable` để vẽ bảng cho `customer`, `product`, `service`
UPDAYE: Trong `web.php` viết đường dẫn cho  `customer`, `product`, `service`

## 23.12.2024 - Đăng
FIXBUG: Xóa nút `Thêm` trong `work_list.blade`
FIXBUG: fix lỗi search datatable của work và điều chỉnh truy vấn của hàm `WorkController::current()`
UDPATE: Thêm thời gian trễ là giây cho hai hàm `gap_checkin` và `gap_checkout` trong model Work

## 26.12.2024 - Tố
UPDATE:Sửa lại hàm `btn-create-criterial`, thêm cộng chuỗi html vào.
UPDATE: UPDATE lại giao diện `modal_criterial.blade`.
UPDTAE: Thêm hàm tự động cộng hàng input `add-row-trigger` và cập nhật lại hàm `btn-update-criterial` trong `criterial.blade`.
UPDATE: Sửa lại `normal_index` từ mảng thành json trong `CriterialSeeder`.
UPDATE: Thêm rules và message, và sửa lại dữ liệu cho $normal_index trong hàm `index`, `create`, `update`. 

## 27.12.2024 - Tố
UPDATE: Trong `app.blade`.
        Thêm hàm `appendRowForCriterial()` .
        Sửa lại `$.each(biochemical.indication._detail._service.criterials`.
        Sửa lại `$.each(bloodcell.indication._detail._service.criterials,`.
UPDATE: Trong `criterial.blade`.
        Sửa lại `data_min` và `data_max` của `normal_index`.
        Thêm `newRow` để cộng chuỗi html và thêm điều kiện `if esle` để hiển ô input cho các tiêu chí có trường lưu `normal_indexx == null`.
        Xóa class `add-row-trigger` trong các ô input. 
UPDTAE: Đổi dữ liệu trường `normal_index` trong file `CriterialSeeder`.
UPDATE: Đổi kiểu dữ liệu trường `normal_index` từ `string` thành `text` trong file `create_criterials_table.php` trong `migration`.
UPDATE: Trong `CriterialController`.
        Sửa rule và message cho `specie`, `age_max`, `data_min`, `data_max`.
        Sửa lại  `->editColumn('normal_index',` hiển thị dữ liệu theo json mới.
        Thêm điều kiện `if else` và lưu `normal_index` theo dạng json mới trong hàm `create`, `update`.
        
## 26.12.2024 - Đăng
UPDATE: Thêm `\Fruitcake\Cors\HandleCors::class` vào $middlewareGroups trong `app\Http\Kernel.php`
UPDATE: Thêm `app\Http\Controller\Api\ImageController.php`, `app\Http\Controller\Api\ProductController.php` cho request api
UPDATE: Chuyển `Route::prefix('api')` lên trên `Route::prefix('web')` để api hoạt động (trong file RouteServiceProvider.php)
UPDATE: Thêm các `route`  trong file `api.php` cho product và image
UPDATE: Cài gói `Laravel\Sanctum\Sanctum` cho việc cung cấp API token-based authentication để xác thực người dùng từ bên thứ ba sau này

## 24.12.2024 - Tố
UPDATE: Cập nhật tính năng xem nhật ký hệ thống.
UPDATE: Thêm hàm `getPosition()` và `getCodeAttribute()` vào model `Log`.
UPDATE: Cập nhật hàm `index()` trong `LogController`.
UPDATE: Cập nhật `logs.balade`.
UPDATE: Thêm `searchable: true,` vào  `config.datatable.columns.code` trong `app.blade`.

## 24.12.2024 - Tố
UPDATE: Cập nhật tính năng xem nhật ký hệ thống.
UPDATE: Thêm hàm `getPosition()` và `getCodeAttribute()` vào model `Log`.
UPDATE: Cập nhật hàm `index()` trong `LogController`.
UPDATE: Cập nhật `logs.balade`.
UPDATE: Thêm `searchable: true,` vào  `config.datatable.columns.code` trong `app.blade`.

## 24.12.2024 - Quân
FIXBUG: Khôi phục phiếu khám về lại giao diện lớn
FIXBUG: Cập nhật lại giá trị đơn hàng khi cập nhật đơn hàng
FIXBUG: Loại bỏ ca hiện tại khi tìm kiếm ca liền kề trong ngày

## 25.12.2024 - Quân
UPDATE: Cập nhật cấu trúc bảng tin, code tối ưu hơn
UPDATE: Bổ sung tính năng chọn nhanh khoảng thời gian trên Bảng tin
UPDATE: Không cập nhật chi nhánh cho phiếu chi khi cập nhật phiếu chi
UPDATE: Chỉ người có quyền duyệt phiếu chi mới được cập nhật trạng thái phiếu chi
UPDATE: Cập nhật giao diện chấm công
    - Hiển thị khung camera cân đối
    - Hiển thị hình chụp không bị bóp méo
    - Ẩn camera và chỉ hiện khi bấm nút checkin hoặc checkout
UPDATE: Cố định cột tên và hàng thời gian trên bảng sắp lịch làm việc
FIXBUG: Loại bỏ ca hiện tại khi tìm kiếm ca liền kề trong ngày

## 26.12.2024 - Đăng
FIXBUG: Sửa lỗi giao diện trong `work_calendar.blade` không hiển thị được các ca từ ngày thứ 4 trở đi
UPDATE: Thêm API cho `Catalogue`

## 30.12.2024 - Quân
FIXBUG: Xử lý quan hệ xóa khi xóa chi tiết phiếu xuất kho
FIXBUG: Không thống kê dữ liệu tồn kho của các gói tồn kho có trạng thái phiếu nhập là chờ nhập
FIXBUG: Cập nhật tool kiểm kê tồn kho theo kho hàng
UPDATE: Tối ưu xử lý dữ liệu, tái sử dụng code của Criterial

## 31.12.2024 - Tố
UPDATE: Viết `message` và sửa lỗi lưu `normal_index` hàm `create`, sửa hàm `usort` theo `specie` && `age_max` trong `CriterialController`.
UPDATE: Sửa lại điều kiện và tối ưu code `bloodcell-list` và `biochemical-list` trong `app.blade`.

## 01.01.2025 - Quân
UPDATE: Giới hạn số ký tự của tên dịch vụ khi gửi thông báo lịch hẹn qua Zalo
FIXBUG: Cập nhật tìm kiếm phiếu khám theo ID phiếu
FIXBUG: Cập nhật sắp xếp cột thú cưng và bác sĩ trong bảng quản lý phiếu khám
FIXBUG: Xử lý tìm kiếm thuốc theo tên bệnh và chỉnh sửa thuật toán tìm kiếm, bọc các điều kiện theo từ khóa tìm kiếm trong case 'search' của `MedicineController::index()`
FIXBUG: Xử lý lưu đơn hàng, nếu bỏ trống giảm giá thì mặc định hiểu giá là 0
FIXBUG: Tìm kiếm trạng thái đơn hàng không phân biệt hoa - thường
FIXBUG: Tìm đơn hàng trong quản lý phiếu khám theo ID đơn hàng
FIXBUG: Bổ sung phương thức `SettingController::updateShop()`
FIXBUG: Điều chỉnh thuật toán kiểm đếm lượng xuất hàng trong kỳ phải tính theo ngày xuất chứ không tính theo ngày nhập của lô hàng được xuất theo kỳ kiểm kho
FIXBUG: Loại trừ các sản phẩm bị trùng khi kiểm kho các sản phẩm có cùng danh mục trong `Catalogue::all_products()`
FIXBUG: Điều chỉnh hiển thị khung tìm kiếm của lịch hẹn với khách lên ngang hàng với breadcrumb
FIXBUG: Điều chỉnh tháng truyền vào xử lý theo đúng tháng hiện tại của năm (số 0 là tháng 1)
FIXBUG: Hiển thị thông báo quyền truy cập đúng cho danh mục đối soát trong `debts.blade.php`
FIXBUG: Thêm chức năng tìm kiếm chi tiết trong danh sách chấm công
FIXBUG: Ẩn nút in khi in danh sách kiểm kho
UPDATE: Cập nhật thuật toán tìm kiếm theo ngày tạo, ngày checkin, ngày checkout, ngày hết HSD .v.v... cho ExportController, ImportController, InfoController, LogController, OrderController, StockController, WorkController
## 04.01.2025 - Tố
UPDATE: Sửa hàm `initDataTable` ở các file `blade` và `main.js`.
UPDATE: Sửa `status` từ `chỉ bán offine` thành `chỉ bán offline` trong model `Product`.
UPDATE: Thêm modal `import_detail` và `export_detail`.
UPDATE: Thêm `filterColumn` trong các trường còn thiếu trong `controller`.
UPDATE: Sửa route `index` (thêm `action`) trong `Import_Detail` và `Export_Detail`.
UPDATE: Bổ sung return `datatable` trong hàm `index` của `ExportDetailController`.
UPDATE: Thêm hàm `index` trong `ImportDetailController`.
UPDATE: Thêm `@include` modal `import_detail` và `export_detail` trong `app.blade`.
        Thêm hàm on click `btn-view-import_detail` và `btn-view-import_detail` trong `app.blade`.
        Thêm hàm `resetModalDataTable`, `showImportDetails`, `showExportDetails` trong `app.blade`.

## 20.12.2024
UPDATE: Cập nhật CRUD cho phiếu lưu trú, chuồng và phiếu theo dõi
UPDATE: Đổi tên controller `TrackingTicketController` thành `TrackingController`
UPDATE: Loại bỏ indication:
        - Xóa bảng `indications`
        - Loại bỏ trường `indication_id` ở các phiếu con
        - Thêm trường `info_id` và `detail_id` vào các phiếu con
        - Tạo seeder `RemoveIndicationSeeder` để cập nhật dữ liệu cho trường `info_id` và `detail_id` tương ứng với indication cũ
        - Cập nhật lại các mối quan hệ truy vấn liên quan ở các phiếu con và các đối tượng liên quan
        - Cập nhật lại `ExportController::create()` cho phù hợp khi xuất vật tư tiêu hao
UPDATE: Tại `DetailController::index()` thêm điều kiện cho dữ liệu trả về khi in hoặc xuất vật tư tiêu hao
UPDATE: Thêm `InfoController::create_ticket()` để tạo các phiếu con tương ứng với các chỉ định của phiếu khám
            - Cập nhật hàm `create()` và `update()` lại cho phù hợp
UPDATE: Tại `OrderController:update()`, thêm case để tạo phiếu khám và phiếu lưu trú cho phần dịch vụ đơn hàng
UPDATE: Thêm điều kiện trả về cho case 'search' ở `ServiceController:index()`
UPDATE: Thêm các quyền truy cập đối với ROOM cho User
UPDATE: Cập nhật cấu trúc hiển thị dữ liệu tại `info.blade`
FIXBUG: Sửa lỗi load danh sách permission tại `modal_role.blade`
UPDATE: Cập nhật script xử lý hiển thị dữ liệu cho đơn hàng tại `app.blade`

## 27.12.2024
UPDATE: Giới hạn lại kho nội khi xuất vật tư tiêu hao
UPDATE: Validation số lượng âm đối với đơn hàng và xuất hàng
UPDATE: Cập nhật lại cấu trúc bảng `beauties` và ràng buộc quan hệ với `infos`, thêm tạo phiếu beauty ở chỉ định dịch vụ của phiếu khám

## 2.01.2025
UPDATE: Chuyển script xử lý sự kiện ở `accommodation.blade` ra `app.blade`
UPADATE: Thêm datalist cho các input của parameter ở phiếu theo dõi
UPDATE: Loại bỏ validate required `stock_ids` ở `OrderController:create()` để phù hợp cho việc tạo đơn chỉ gồm dịch vụ
UPDATE: Viết lại `fillTracking()` ở `app.blade`

## 06.01.2025
UPDATE: Chỉnh sửa $this trong `ImportDetailController::updateStockRecursive()`
UPDATE: Thêm case `render_stock-form` trong hàm bắt sự kiện submit của `save-form`
UPDATE: Đồng bộ kho trong `StockController`
 - Tách truy vấn `print` ra thành hàm `calculate_stock`
 - Thêm hàm `sync` trong
UPDATE: Thêm và xóa danh mục chung
 - Thêm hai hàm `add_catalogues`, `remove_catalogues` trong `ProductController`
 - Cấu hình lại `SweetAlert` trong `products.blade` cho việc chọn 1 danh mục để thêm cho nhiều sản phẩm

 ## 07.01.2025
 UPDATE: Tối ưu truy vấn get product trong phần kết xuất kho của `StockController::index()`
 UPDATE: Điều chỉnh cấu trúc `Catalogue::all_products()` tối ưu truy vấn lấy tất cả sản phẩm của danh mục (cả danh mục con)
 UPDATE: Cho phép lọc tất cả sản phẩm của tất cả danh mục khi không chọn danh mục kết xuất kho trong `stocks.blade`