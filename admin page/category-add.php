
<?php
 include($_SERVER['DOCUMENT_ROOT'] . '/assets/function/connect.php');
 session_start();
 
    if(isset($_POST['btn-add-type'])){
        $error = ""; // Khởi tạo biến lỗi

        // Kiểm tra xem 'MaDM' đã được gửi hay chưa
        if(isset($_POST['MaDM'])){
            $idtype = $_POST['MaDM'];
        }else{
            $error = '1'; // Nếu chưa, gán lỗi 1
        }

        // Kiểm tra xem 'TenDM' đã được gửi hay chưa
        if(isset($_POST['TenDM'])){
            $nametype = $_POST['TenDM'];
        }else{
            $error = '2'; // Nếu chưa, gán lỗi 2
        }

        // Nếu không có lỗi
        if(empty($error)){
            // Kiểm tra xem có sự trùng lặp với các loại sản phẩm đã có không
            $sqltype = "SELECT * FROM Loai_SP WHERE Ma_Loai <> '$idtype' and TenLoai <> '$nametype'";
            $conntype = mysqli_query($conn,$sqltype);
            
            while($comparetype = mysqli_fetch_array($conntype,MYSQLI_ASSOC)){
                // var_dump($comparetype);exit;
                // Nếu không có sự trùng lặp
                if(!empty($comparetype)){
                    // Thực hiện chèn dữ liệu vào bảng Loai_SP
                    $inserttypeSQL = "INSERT INTO Loai_SP(Ma_Loai, TenLoai) VALUES ('$idtype','$nametype')";
                    $conninsert = mysqli_query($conn,$inserttypeSQL);
                    header("Location: ./category-admin.php"); // Chuyển hướng về trang quản lý danh mục sản phẩm
                }
            }
        }else{
            echo "Nhập chưa đủ thông tin!"; // Hiển thị thông báo lỗi nếu có
        }
    }
?>
