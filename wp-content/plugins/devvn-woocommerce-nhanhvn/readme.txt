
= V1.1.6 - 22.12.2023 =

* Update core plugin

= V1.1.5 - 22.05.2023 =

* Fix điều kiện với đơn mới không hiện nút đăng đơn lên Nhanh

= V1.1.4 - 17.05.2023 =

* Fix lỗi khi đăng đơn có COD = 0

= V1.1.3 - 05.05.2023 =

GLOBAL:
* Tối ưu lại hình thức load địa chỉ

= V1.1.2 - 24.04.2023 =

* Tối ưu core

GLOBAL:
* Nâng cấp tương thích với chức năng High-Performance Order Storage (HPOS) trong Woocommerce. 1 chức năng tối ưu cho order trong Woocommerce và sẽ mặc định ở Woocommerce V8.0
* Nâng cấp thư viện recaptcha để hỗ trợ PHP8

= V1.1.1 - 18.03.2023 =

* Update thêm chức năng đồng bộ giá bán từ Nhanhvn về website. có thể bật/tắt chức năng này
* Thêm chức năng đồng bộ tồn kho chạy trong nền để cho các web có dữ liệu lớn không thể chạy trực tiếp được

= V1.1.0 - 07.02.2023 =

* Fix trường hợp thiếu lựa chọn tự vận chuyển

= V1.0.9 - 04.02.2023 =

* Thêm lựa chọn "Tự vận chuyển" khi đăng đơn lên Nhanhvn

= V1.0.8 - 05.01.2023 =

* Fix js với 1 số theme
* Fix lỗi tên quận huyện khác với hệ thống Nhanhvn

= V1.0.7 - 28.12.2022 =

GLOBAL
* Thêm placeholder vào field sđt và email
* Fix lỗi không load js với 1 số theme
* Thêm option chuyển giá sang dạng chữ
* Cập nhật thêm thông tin địa giới hành chính của Huyện Lý Sơn, Tỉnh Quảng Ngãi
* Thêm tuỳ chọn hiện trường Postcode. Mặc định là ẩn
* Fix lỗi một số trường hợp đã custom form checkout trước đó
* Fix lỗi với plugin Cartflows
* Fix lỗi không ẩn được field xã phường khi đã cài đặt trong setting
* Fix tương thích với 1 số theme
* Fix hiển thị địa chỉ với tiếng Việt trong đơn in với mẫu riêng
* Fix XSS security. Thanks for MINKYU (Patchstack Alliance)
* Tối ưu lại các field trong checkout, các field trong Sửa địa chỉ khách hàng...
* Fix lỗi: Sửa chức năng sao chép địa chỉ thanh toán sang địa chỉ giao hàng khi sửa đơn hàng
* Fix lỗi khi sử dụng chức năng tự động điền (autocomplete) của trình duyệt các field trong trang checkout

= V1.0.6 - 22.11.2022 =

* Fix lỗi phân trang trong quá trình sync tồn kho từ Nhanh về web

= V1.0.5 - 17.11.2022 =

* Tối ưu/Sửa lỗi lại phí thu khách hàng lúc đăng đơn lên Nhanh khi có giảm giá
* Tối ưu lại tốc độ tính phí ship

= V1.0.4 - 09.11.2022 =

* Thêm xã phường vào thông tin đăng đơn
* Cập nhật lại bản nén js gây lỗi ở bản trước

= V1.0.3 - 06.11.2022 =

* Tăng tốc tính phí ship khi hosting có hỗ trợ redis cache hoặc memcached
* Thêm chức năng search theo mã sản phẩm (sku) và ID nhanh trong quản lý tồn kho

GLOBAL

* Update core Vietnam Checkout

= V1.0.2 - 24.08.2022 =
* Update: Chỉ cập nhật tồn kho cho sp đơn giản và biến thể. Không lấy tồn kho sản phẩm cha

= V1.0.1 - 23.08.2022 =
* Thêm chức năng lọc sản phẩm có NhanhID hoặc chưa có NhanhID trong tab Quản lý tồn kho

= V1.0.0 - 21.08.2022 =
* Ra mắt plugin