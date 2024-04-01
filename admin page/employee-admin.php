<?php
include($_SERVER['DOCUMENT_ROOT'] . '/assets/function/connect.php');
session_start();

if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'deletenv':
            $limit = $_GET['limit'];
            $page = $_GET['page-num'];
            $nv = $_GET['id'];
            $timtk = "SELECT TenDangNhapTK,MaCV FROM NHAN_VIEN WHERE MaNV = '$nv'";
            $conntk = mysqli_query($conn,$timtk);
            $showpass= mysqli_fetch_object($conntk);
            $passtmp = $showpass->TenDangNhapTK;
            $user = $_SESSION['username'];
            $cvtmp = $showpass->MaCV;
            if($passtmp == $user ){
                echo '<p style="color:red">You need higher rank to do it!</p>';
            }
            else{
                if(!empty(strstr($_SESSION["username"],'manage')) || !empty(strstr($_SESSION["username"],'Manage'))){
                    if(empty(strstr($cvtmp,'PGD'))){
                        $delete = "DELETE FROM NHAN_VIEN WHERE MaNV = '$nv' ";
                        $deleteacc = "DELETE FROM TAI_KHOAN WHERE TenDangNhapTK = '$passtmp'";
                        $conndel = mysqli_query($conn,$delete);
                        $conndelacc = mysqli_query($conn,$deleteacc);
                        header("Location: ./employee-admin.php");  
                    }else{
                        echo '<p style="color:red">You need higher rank to do it!</p>';
                    }
                }else{
                    $delete = "DELETE FROM NHAN_VIEN WHERE MaNV = '$nv' ";
                    $deleteacc = "DELETE FROM TAI_KHOAN WHERE TenDangNhapTK = '$passtmp'";
                    $conndel = mysqli_query($conn,$delete);
                    $conndelacc = mysqli_query($conn,$deleteacc);
                    header("Location: ./employee-admin.php?limit=$limit&page-num=$page");  
                }                        
            }                       
            break;
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/admin page/assets/css/employee-admin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="storefront"></ion-icon></span>
                        <span class="title">Shop name</span>
                    </a>
                </li>
                <li>
                    <a href="/admin page/admin-index.php">
                        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                        <span class="title">Trang chủ</span>
                    </a>
                </li>
                <li>
                    <a href="/admin page/customers-admin.php?limit=4&page-num=1">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                        <span class="title">Khách hàng</span>
                    </a>
                </li>
                
                <?php
                
                if(!empty($_SESSION["username"])){
                    if(!empty(strstr($_SESSION["username"],'Staff')) || !empty(strstr($_SESSION["username"],'staff')) || !empty(strstr($_SESSION["username"],'manage')) 
                    || !empty(strstr($_SESSION["username"],'Manage')) 
                    ){
                
                ?>
                <li>
                    <a class="active" href="/admin page/employee-admin.php?limit=4&page-num=1">
                        <span class="icon"><ion-icon name="man-outline"></ion-icon></span>
                        <span class="title">Nhân viên</span>
                    </a>
                </li>
                <?php
                    }
                }
                ?>
                <li>
                    <a href="/admin page/category-admin.php">
                        <span class="icon"><ion-icon name="reorder-four-outline"></ion-icon></span>
                        <span class="title">Danh mục sản phẩm</span>
                    </a>
                </li>
                <li>
                    <a href="/admin page/product-admin.php?limit=6&page-num=1">
                        <span class="icon"><i class='bx bx-box'></i></span>
                        <span class="title">Sản phẩm</span>
                    </a>
                </li>
                <li>
                    <a href="../logout.php">
                        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="title">Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- main -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <!-- <div class="search">
                    <label>
                        <input type="text" placeholder = "Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div> -->
            </div>

            <div class="detail">
                <div class="recentEmployees">
                    <div class="cardHeader">
                        <h2>Danh sách nhân viên</h2>
                        <a href="/admin page/employee-add-admin.php" class="btn">Thêm nhân viên</a>
                    </div>
                    <form method="post" action="searchNhanVien.php" >
                        <div class="search">
                            <label>
                                <input type ="search" name ="word" class="search-field" placeholder="Tìm kiếm nhân viên...">
                                <button name='searchcus'><ion-icon  name="search-outline"></button>
                            </label>
                        </div>
                    </form>
                    <table>
                        <thead>
                            <tr>
                                <td>Mã số nhân viên</td>
                                <td>Tên nhân viên</td>
                                <td>Chức vụ</td>
                                <td>Số lương</td>
                            </tr>
                        </thead>
                        <?php
                            $limititem = !empty($_GET['limit']) ? $_GET['limit'] : 4; // Nếu Tồn tại limit, số sản phẩm/trang = số limit, còn kh thì số limit sẽ = 2 
                            $pagenum = !empty($_GET['page-num']) ? $_GET['page-num'] : 1;
                            $upload = $pagenum-1;
                            if($pagenum==1){
                                $offset = $pagenum-1;
                            }    
                            elseif($pagenum != 1){
                                $offset = $upload+$limititem-1;
                                $upload = $offset;
                            }
                            $NVSQL = "SELECT * FROM NHAN_VIEN WHERE MaCV <> 'GD'";
                            $findtotal = mysqli_query($conn, $NVSQL);
                            $countitem = mysqli_num_rows($findtotal);
                            $totaladminpage = ceil($countitem/$limititem);
                            $tsql = "SELECT * FROM NHAN_VIEN WHERE MaCV <> 'GD' LIMIT $offset, $limititem";
                            $connNVSQL = mysqli_query($conn,$tsql);
                            while($showNV= mysqli_fetch_array($connNVSQL)){ 
                        ?>
                        <tbody>
                            <tr>
                                <td><?=$showNV['MaNV']?></td>
                                <td><?=$showNV['HoTen']?></td>
                                <?php
                                    $chucvu = $showNV['MaCV'];
                                    $idlog = $_SESSION['username'];
                                    $CVsql = "SELECT * FROM CHUC_VU WHERE MaCV = '$chucvu'";
                                    $connCV = mysqli_query($conn,$CVsql);
                                    while($showCV = mysqli_fetch_array($connCV)){
                                ?>
                                    <form id="delete-form" action='employee-admin.php?limit=4&page-num=<?=$pagenum?>&action=deletenv' method="POST">
                                    <td><?=$showCV['ChucVu']?></td>
                                    <?php
                                        if(!empty(strstr($showCV['ChucVu'],'Nhân viên')))
                                        {
                                    ?>
                                    <td>5.000.000đ</td>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        if(!empty(strstr($showCV['ChucVu'],'Quản lý')))
                                        {
                                    ?>
                                    <td>7.000.000đ</td>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        if(!empty(strstr($showCV['ChucVu'],'Phó Giám Đốc')))
                                        {
                                    ?>
                                    <td>15.000.000đ</td>
                                    <?php
                                        } 
                                    ?>
                                   
                                    <td><a href="employee-add-admin.php?membersid=<?=$showNV['MaNV']?>">Chi tiết</a></td>
                                    
                                    <td><a href="employee-admin.php?limit=4&page-num=<?=$pagenum?>&action=deletenv&id=<?=$showNV['MaNV']?>" class="delete">Xóa nhân viên</a></td>
                                    </form>
                                    
                            </tr>
                        </tbody>
                        <?php
                                }
                            }
                        ?>
                        
                    </table>
                    <div class="pagigation">
                        <?php
                            include ('../admin page/admin-page-num.php');
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="/admin page/assets/js/admin-script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>