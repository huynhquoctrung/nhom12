<?php
include('assets/function/connect.php');
session_start();

$idlist = $_GET['i'];
if (isset($_GET['t'])) {
    $idth = $_GET['t'];

    $sql = "SELECT * FROM SAN_PHAM WHERE Ma_Loai LIKE '$idlist' AND Ma_TH LIKE '$idth'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
} else {
    $sql = "SELECT * FROM SAN_PHAM WHERE Ma_Loai = '$idlist'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $tsql_loai = "SELECT TenLoai, Ma_Loai FROM Loai_SP WHERE Ma_Loai LIKE '$idlist'";
    $stmt_loai = $conn->prepare($tsql_loai);
    $stmt_loai->execute();

    while ($row_loai = $stmt_loai->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Ma_Loai'] == $row_loai['Ma_Loai']) {
            echo '<div class="product">
                    <img src="' . $row['HinhAnhSP'] . '" alt="">
                    <div class="design">
                        <span>' . $row_loai['TenLoai'] . '</span>
                        <a href="product.php?id=' . $row['ID'] . '"><h5>' . $row['TenSP'] . '</h5></a>
                        <h4>' . number_format($row['Gia'], 0, ".", ".") . 'đ</h4>
                    </div>
                </div>';
        }
    }
}
?>
