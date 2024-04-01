<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/assets/function/connect.php');
    session_start();
?>

<?php
    if(isset($_POST['btn-add-brand'])){
        $error = ""; // Khởi tạo biến lỗi

        // Kiểm tra xem 'brand-id' đã được gửi hay chưa
        if(isset($_POST['brand-id'])){
            $brandid = $_POST['brand-id'];
        }else{
            $error = '1'; // Nếu chưa, gán lỗi 1
        }

        // Kiểm tra xem 'brand-name' đã được gửi hay chưa
        if(isset($_POST['brand-name'])){
            $brandname = $_POST['brand-name'];
        }else{
            $error = '2'; // Nếu chưa, gán lỗi 2
        }

        // Nếu không có lỗi
        if(empty($error)){
            // Kiểm tra xem có sự trùng lặp với các thương hiệu đã có không
            $sqlbrand = "SELECT * FROM THUONG_HIEU WHERE Ma_TH <> '$brandid' and TenTH <> '$brandname'";
            $connbrand = mysqli_query($conn,$sqlbrand);
            while($comparebrand = mysqli_fetch_array($connbrand,MYSQLI_ASSOC)){
                // Nếu không có sự trùng lặp
                if(!empty($comparebrand)){
                    // Thực hiện chèn dữ liệu vào bảng THUONG_HIEU
                    $insertbrandSQL = "INSERT INTO THUONG_HIEU (Ma_TH, TenTH) VALUES ('$brandid',N'$brandname')";
                    $conninsert = mysqli_query($conn,$insertbrandSQL);
                    header("Location: ./category-admin.php"); // Chuyển hướng về trang quản lý danh mục sản phẩm
                }
            }
        }else{
            echo "Nhập chưa đủ thông tin!"; // Hiển thị thông báo lỗi nếu có
        }
    }
?>
