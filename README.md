
# Web Bán Hàng - LTMNM 

Dự án website thương mại điện tử được phát triển bằng PHP, thực hiện cho bài tập lớn môn **Lập Trình Mạng Ngôn Ngữ Mở (LTMNM)**.

## Công Nghệ Sử Dụng

* **Backend:** PHP (hỗ trợ chuẩn PSR-4, quản lý thư viện qua Composer)
* **Frontend:** HTML5, CSS3, JavaScript, Bootstrap (nếu có)
* **Cơ Sở Dữ Liệu:** MySQL
* **Môi trường phát triển:** XAMPP, HeidiSQL / phpMyAdmin

## Cấu Trúc Thư Mục 

Dự án được triển khai theo mô hình **MVC (Model - View - Controller)** giúp tách biệt logic xử lý, truy xuất dữ liệu và giao diện người dùng, thuận tiện cho việc làm việc nhóm.

```text
WebBanHang-LTMNM/
│
├── app/
│   ├── Controllers/       # Xử lý logic, nhận request từ người dùng và gọi Model/View
│   ├── Models/            # Xử lý các thao tác với cơ sở dữ liệu (CRUD)
│   └── Core/              # Chứa các file cấu hình hệ thống (Database connection, Router...)
│
├── public/                # Nơi chứa các tài nguyên tĩnh (Client-side)
│   ├── css/               # File định dạng giao diện
│   ├── js/                # File script xử lý phía client
│   └── images/            # Hình ảnh sản phẩm, banner, logo...
│
├── views/                 # Chứa các file giao diện người dùng (HTML/PHP)
│   ├── admin/             # Giao diện trang quản trị
│   ├── user/              # Giao diện trang khách hàng
│   └── layouts/           # Các thành phần dùng chung (Header, Footer, Sidebar...)
│
├── vendor/                # (Nếu dùng Composer) Chứa các thư viện của bên thứ 3
├── index.php              # File gốc (Entry point), điều hướng mọi request
├── .gitignore             # Các file/thư mục không đẩy lên Git (vd: /vendor)
└── README.md              # Tài liệu hướng dẫn dự án

```

##  Hướng Dẫn Cài Đặt

Để chạy dự án trên máy cá nhân, vui lòng làm theo các bước sau:

**Bước 1: Clone dự án về máy**
Mở Terminal/PowerShell ở thư mục `C:\laragon\www` (hoặc `htdocs` của XAMPP) và chạy lệnh:

```bash
git clone [https://github.com/biuisme/WebBanHang-LTMNM.git](https://github.com/biuisme/WebBanHang-LTMNM.git)
cd WebBanHang-LTMNM

```

**Bước 2: Cài đặt thư viện (Nếu có sử dụng Composer)**

```bash
composer install

```

**Bước 3: Thiết lập Cơ Sở Dữ Liệu**

1. Khởi động **Apache** và **MySQL** trên XAMPP/Laragon.
2. Mở trình quản lý cơ sở dữ liệu (HeidiSQL hoặc phpMyAdmin).
3. Tạo một Database mới (ví dụ: `phukien_web_db`).
4. Import file SQL (thường nằm trong thư mục `database/` hoặc được đính kèm ở thư mục gốc) vào Database vừa tạo.

**Bước 4: Cấu hình kết nối**
Mở file cấu hình database (thường là `config.php`, `database.php` hoặc `.env`) và cập nhật thông tin:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Mật khẩu mặc định của XAMPP là rỗng
define('DB_NAME', 'phukien_web_db');

```

**Bước 5: Chạy ứng dụng**
Mở trình duyệt web và truy cập vào đường dẫn:

```text
http://localhost/WebBanHang-LTMNM/

```

## Chức Năng Chính

**User:**

* Đăng ký, đăng nhập và quản lý tài khoản.
* Duyệt sản phẩm theo danh mục.
* Tìm kiếm sản phẩm.
* Thêm vào giỏ hàng và tiến hành đặt hàng.

**Admin:**

* Quản lý danh mục (Thêm, Sửa, Xóa).
* Quản lý sản phẩm (Cập nhật giá, hình ảnh, tồn kho).
* Quản lý đơn hàng của khách.
* Quản lý thông tin người dùng.

---

*Dự án được thực hiện bởi nhóm sinh viên cho mục đích học tập.*

```
