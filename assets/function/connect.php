<?php
include ('config.php'); // Sử dụng __DIR__ thay vì __ROOT__

$servername = "localhost"; // Thay đổi servername thành localhost hoặc địa chỉ máy chủ MySQL của bạn
$username = "root"; // Thay đổi username và password theo thông tin đăng nhập MySQL của bạn
$password = "";
$dbname = "nhom12"; // Thay đổi tên cơ sở dữ liệu nếu cần

// Kết nối đến MySQL
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Đặt các cài đặt ký tự UTF-8
mysqli_set_charset($conn, "utf8");

// Bạn có thể bỏ qua phần đặt ký tự UTF-8 nếu đã thiết lập trong cấu hình MySQL của bạn

?>
