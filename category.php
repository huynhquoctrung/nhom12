<?php
include('assets/function/connect.php');
session_start();
?>

<script type="text/javascript" src="./ajax/jquery-3.6.3.min.js"></script>

<script>
    $(document).ready(function(){
        $(".loaihang").click(function(){
            var id = $(this).attr("dulieu");
            $.get("category-load.php",{i : id}, function(data){
                $("#ketqua").html(data);
            });
            
        }); 
        $(".loaisp").click(function(){
            var id = $(this).attr("dulieuid");
            var th = $(this).attr("dulieuth");
            $.get("category-load.php",{i : id, t : th}, function(datasp){
                $("#ketqua").html(datasp);
            });
            
        }); 
    });
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/category.css">
    <link rel="stylesheet" href="./assets/fonts/fontawesome-free-6.2.1-web/fontawesome-free-6.2.1-web/css/all.css">
    <title>shop</title>
</head>
<body>
    <header>
        <section id="header">
            <a href="#"><img src="/assets/img/logo.png" class="logo" alt=""></a>
            <form method="POST" action="search.php?action=Search" onsubmit="return submitSearch(this);" enctype="application/x-www-form-urlencoded">
                <div class="Card">
                    <div class="CardInner">
                        <div class="container">
                            <div class="Icon">
                                <button class="btn-search"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#657789" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></button>
                            </div>
                            <div class="InputContainer">
                                <input type="search" name="word" placeholder="Tìm kiếm sản phẩm..."> 
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            <div>
                <ul id="navbar">
                    <li><a href="index.php">TRANG CHỦ</a></li>
                    <li><a href="about.php">GIỚI THIỆU</a></li>
                    <li><a class="active" href="#">DANH MỤC SẢN PHẨM</a>
                        <ul class="sub-menu">
                            <?php
                            $DMsql = "SELECT * FROM Loai_SP";
                            $connDM = $conn->prepare($DMsql);
                            $connDM->execute();
                            while($rowDM = $connDM->fetch(PDO::FETCH_ASSOC)){ 
                                $danhmuc = $rowDM['Ma_Loai'];
                            ?>
                            <li><div class="loaihang" dulieu="<?php echo $rowDM['Ma_Loai'];?>"><?=$rowDM['TenLoai']?></div></li>
                            <?php
                                $sqlthsp = "SELECT C.TenTH,C.Ma_TH
                                    from SAN_PHAM A ,Loai_SP B,THUONG_HIEU C
                                    WHERE A.Ma_Loai=B.Ma_Loai AND A.Ma_TH=C.Ma_TH AND B.Ma_Loai='$danhmuc'
                                    GROUP BY C.TenTH,C.Ma_TH";
                                $connth = $conn->prepare($sqlthsp);
                                $connth->execute();
                                while($showth= $connth->fetch(PDO::FETCH_ASSOC)){
                                    if(!empty($showth['TenTH'])){
                                        $math = $showth['TenTH'];
                            ?>
                            <ul class="brand">
                                <li><div class="loaisp" dulieuid="<?php echo $rowDM['Ma_Loai'];?>" dulieuth="<?php echo $showth['Ma_TH']; ?>"><?=$math?></div></li>
                            </ul>
                            <?php
                                    }else{
                            ?>
                            <ul class="brand">
                                <li></li>
                            </ul>
                            <?php
                                    }   
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li><a href="insurance.php">CHÍNH SÁCH BẢO HIỂM</a></li>
                    <li><a href="cart.php"><i class="fa fa-shopping-bag"></i></a></li>
                    <li><a href="user.php"><i class="fa fa-user"></i></a>
                        <ul class="sub-menu-user">
                            <?php
                                if(empty($_SESSION["username"])){
                            ?>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="signup.html">Sign up</a></li>
                            <?php
                                }else {
                            ?>
                            <li><a href="logout.php">Logout</a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
    </header>

    <section id="page-header">
        <img src="/assets/img/banner-text.png" alt="">
    </section>

    <section class="product-list">
        <div class="product-container" id="ketqua">
            <?php 
            $idlist = $_GET['id'];
            if(isset($_GET['TH'])){
                $idth = $_GET['TH'];
                $sql = "SELECT * FROM SAN_PHAM WHERE Ma_Loai LIKE '$idlist' and Ma_TH LIKE '$idth'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
            }else{
                $sql = "SELECT * FROM SAN_PHAM WHERE Ma_Loai = '$idlist'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
            }
            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $tsql_loai = "SELECT TenLoai, Ma_Loai FROM Loai_SP WHERE Ma_Loai LIKE '$idlist'";
                $stmt_loai = $conn->prepare($tsql_loai);
                $stmt_loai->execute();
                while($row_loai = $stmt_loai->fetch(PDO::FETCH_ASSOC))
                {
                    if($row['Ma_Loai']==$row_loai['Ma_Loai'])
                    {
                        echo '<div class="product">
                            <img src="'.$row['HinhAnhSP'].'" alt="">
                            <div class="design">
                                <span>'.$row_loai['TenLoai'].'</span>
                                <a href="product.php?id='.$row['ID'].'"><h5>'.$row['TenSP'].'</h5></a>
                                <h4>'.number_format($row['Gia'],0,".",".").'đ</h4>
                            </div>
                            </div>';
                    }
                }
            }
            ?>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-container">
            <div class="row">
                <div class="footer-col">
                    <h4>Cửa hàng</h4>
                    <ul>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Dịch vụ</a></li>
                        <li><a href="#">Giấy phép</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Hổ trợ</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Phương thức thanh toán</a></li>
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Online Shopping</h4>
                    <ul>
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Giỏ hàng</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
