<?php
    include("./assets/function/connect.php");
    session_start();
?>
<?php

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        //var_dump($id);exit;
        if(isset($_POST['back-cart'])){
            $deletecthd = "DELETE FROM CT_HD WHERE MaHÐ = '$id' ";
            $connhd = mysqli_query($conn, $deletecthd);
            $deletehd =  "DELETE FROM HOA_DON WHERE MaHÐ = '$id' ";
            $connhd = mysqli_query($conn, $deletehd);
            
            header('Location: ./cart.php');
        }
        if(isset($_POST['used-voucher-buy-now'])){
            if(isset($_POST['vouchertxt'])){
                var_dump($_POST['vouchertxt']);
                $vouch = $_POST['vouchertxt'];
                            if(!empty($vouch)){
                                $username = $_SESSION['username'];
                                $sqlkhused = "SELECT MaKH FROM KHACH_HANG WHERE TenDangNhapTK = '$username'";
                                $connkhused = mysqli_query($conn, $sqlkhused);
                                $showmakh = mysqli_fetch_object($connkhused);
                                $tmpmakh = $showmakh->MaKH;
                                //var_dump($tmpmakh);
                                $sqlvoucher = "SELECT Voucher FROM HOA_DON WHERE MaKH = '$tmpmakh' AND Voucher LIKE '$vouch' ";
                                $connvoucher = mysqli_query($conn, $sqlvoucher);
                                $showvoucher = mysqli_fetch_object($connvoucher);
                                    //var_dump($showvoucher->Voucher);
                                    if(empty($showvoucher->Voucher)){
                                            $_SESSION['voucher-used'] = $vouch;
                                            
                                                $vouchersaved = $_SESSION['voucher-used'];
                                                if($_SESSION['voucher-used'] == 'VZ06' ){ //Nếu thay bằng sql thì sẽ so sánh $SESSION với MaVoucher được lấy ra
                                                    $sqlprice = "SELECT TongHoaDon FROM HOA_DON WHERE MaHÐ = '$id' ";
                                                    $conntotalprice = mysqli_query($conn, $sqlprice);
                                                    $showtotalprice = mysqli_fetch_object($conntotalprice);
                                                    //var_dump($showtotalprice);exit;
                                                    $totalsave = $showtotalprice->TongHoaDon;
                                                    $totalsave= $totalsave - (10 * $totalsave)/100; //Số tiền 10 sẽ thay thế bằng Discount của sql
                                                    $upvouchsql = "UPDATE HOA_DON 
                                                                SET Voucher = '$vouchersaved', TongHoaDon= $totalsave WHERE MaHÐ= '$id'";
                                                    $upvc = mysqli_query($conn, $upvouchsql);
                                                    header("Location: ./payment.php?id=$id");
                                                }
                                               
                                    }else{
                                            $error= '*Lưu ý: Voucher đã được sử dụng!';
                                        //unset($_SESSION['voucher-used']);exit;
                                    }     
                                

                                
                            }else{
                                $error= '*Lưu ý: Bạn phải thêm voucher!';
                            }
                            if(!empty($error)){
                                header("Location: ./payment.php?error=$error");
                            }
                            
                        }
            }
            if(isset($_POST['buy-now-purchase'])){
                $selectproduct = "SELECT * FROM CT_HD WHERE MaHÐ = '$id'  ";
                $connsql = mysqli_query($conn, $selectproduct);
                while($showtypeproduct = mysqli_fetch_array($connsql,MYSQLI_ASSOC)){
                    $soluong = $showtypeproduct['SoLuong'];
                    $masp = $showtypeproduct['MaSP'];
                    //Lượt mua hàng
                    if(!isset($_SESSION['luottruycapmh'.$masp]))
                    {
                        $_SESSION['luottruycapmh'.$masp] = 0;
                    }
                    if(isset($_SESSION['luottruycapmh'.$masp]))
                    {
                        $_SESSION['luottruycapmh'.$masp] += 1*$soluong;
                    }
                    $sltc = $_SESSION['luottruycapmh'.$masp];

                    $findProductToUpdate = "SELECT SoLuong FROM SAN_PHAM where MaSP = '$masp' ";
                    $connectTOQuery = mysqli_query($conn, $findProductToUpdate);
                    $data = mysqli_fetch_object($connectTOQuery);
                    $SLHT = $data->SoLuong - $soluong;
                    $upsltcsql = "UPDATE SAN_PHAM SET SLTC = $sltc , SoLuong = $SLHT where MaSP = '$masp' ";
                    $connup = mysqli_query($conn, $upsltcsql);
                }
                unset($_SESSION['luottruycapmh'.$masp]);
                unset($_SESSION['voucher-used']);
                header("Location: ./index.php");
            }
        }
?>
