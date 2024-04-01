<?php
include($_SERVER['DOCUMENT_ROOT'] . '/assets/function/connect.php');

if(isset($_GET['id'])){
    $idtmp = $_GET['id'];
    
    //var_dump($idtmp);exit;
    if(isset($_GET['confirm'])){
        $updateconfirm = "UPDATE HOA_DON
                SET TinhTrangDH = 'Đã xác nhận' WHERE MaHÐ = '$idtmp'";
        $connconf = mysqli_query($conn, $updateconfirm);
        header("Location: ./invoice-admin.php?billid=$idtmp");
    }
    if(isset($_GET['Done'])){
        $updateconfirmbill = "UPDATE HOA_DON
                SET TinhTrangTT = 'Đã thanh toán' WHERE MaHÐ = '$idtmp'";
        $connconfbill = mysqli_query($conn, $updateconfirmbill);
        //var_dump($connconfbill);exit;
        header("Location: ./invoice-admin.php?billid=$idtmp");
    }

}

?>
