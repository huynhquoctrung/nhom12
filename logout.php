
<?php
    session_start();
    
    if(!isset($_SESSION["chuc-vu"])){
        header("Location: ./login.html");
    }else{
        header("Location: ./index.php");
    }
    unset($_SESSION["cart"]);
    unset($_SESSION['voucher-used']); // nếu có sql voucher thì sẽ update vào table voucher đã dùng theo SESSION username tài khoản trước khi xóa tên đăng nhập 
    unset($_SESSION["chuc-vu"]);
    unset($_SESSION["username"]);
    unset($_SESSION["USERIP"]);

?>