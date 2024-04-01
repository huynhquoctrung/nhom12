<?php
    include ("./assets/function/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
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
                    <li><a class="active" href="about.html">GIỚI THIỆU</a></li>
                    
                    <li><a href="#">DANH MỤC SẢN PHẨM</a>
                        <ul class="sub-menu">
                            <?php
                                $DMsql = "SELECT * FROM Loai_SP";
                                $connDM = mysqli_query($conn, $DMsql);
                                while($rowDM = mysqli_fetch_array($connDM, MYSQLI_ASSOC)){ 
                                    $danhmuc = $rowDM['Ma_Loai'];
                            ?>
                            <li><a href="category.php?id=<?=$rowDM['Ma_Loai']?>&limit=8&page-num=1"><?=$rowDM['TenLoai']?></a></li>
                                <?php
                                    $sqlthsp = "SELECT C.TenTH, C.Ma_TH
                                    FROM SAN_PHAM A
                                    INNER JOIN Loai_SP B ON A.Ma_Loai = B.Ma_Loai
                                    INNER JOIN THUONG_HIEU C ON A.Ma_TH = C.Ma_TH
                                    WHERE B.Ma_Loai = '$danhmuc'
                                    GROUP BY C.TenTH, C.Ma_TH";
                                    $connth = mysqli_query($conn, $sqlthsp);
                                    while($showth = mysqli_fetch_array($connth, MYSQLI_ASSOC)){
                                    if(!empty($showth['TenTH'])){
                                        $math = $showth['TenTH'];
                                ?>
                                <ul class="brand">
                                    <li><a href="category.php?id=<?=$rowDM['Ma_Loai']?>&limit=8&pagenum=1&TH=<?=$showth['Ma_TH']?>" ><?=$math?></a></li>
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
    
    <section class="product-list">
        <h2> GIỚI THIỆU DOANH NGHIỆP </h2>
        <div class="product-container">
            <h3> Ở đây chúng tôi có bán gear </h3>
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
                        <li><a href="index.php">Trang chủ</a></li>
                        <li><a href="cart.php">Giỏ hàng</a></li>
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
