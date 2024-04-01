<?php
include($_SERVER['DOCUMENT_ROOT'] . '/assets/function/connect.php');
session_start();
?>
<?php
if(isset($_POST['btn-back'])){
    header("Location: ./product-add-admin.php");
}
if(isset($_POST['update-product'])){
    //Cập nhật số lượng mặt hàng
    if(!empty($_POST['quantity'])){
        foreach($_POST['quantity'] as $id => $quantity){ 
            $sl = $_POST['quantity'][$id];
            $id = $id;
            if($sl >0){
                $updatesl = "UPDATE SAN_PHAM 
                             SET SoLuong = $sl where MaSP = '$id' ";
            }else{
                if($sl<=0){
                    $updatesl = "DELETE FROM SAN_PHAM WHERE MaSP = '$id' ";
                }
            }
            $connupdatesl = mysqli_query($conn, $updatesl);
        }
    }
    if(!empty($_POST['DMSP'])){
        $loaisp = $_POST['DMSP'];
        $uploai= "UPDATE SAN_PHAM 
                    SET Ma_Loai = '$loaisp' WHERE MaSP = '$id'";
        $connuploai = mysqli_query($conn, $uploai);
        
    }
    if(!empty($_POST['Price']) && is_numeric(str_replace('.','',$_POST['Price'])) == true){
        $gia = $_POST['Price'];
        
        $updateprice = "UPDATE SAN_PHAM 
                            SET Gia = $gia where MaSP = '$id' ";
        $connupdateprice = mysqli_query($conn, $updateprice);
        
    }
    if(!empty($_POST['nameSP'])){
        $tensp = $_POST['nameSP'];
        
        $updatename = "UPDATE SAN_PHAM 
                            SET TenSP = '$tensp' where MaSP = '$id' ";
        $connupdateprice = mysqli_query($conn, $updatename);
        
    }
    if(!empty($_POST['detail'])){
        $gt = $_POST['detail'];
       
        $updategt = "UPDATE SAN_PHAM 
                            SET GioiThieuSP = '$gt' where MaSP = '$id' ";
        $connupdateprice = mysqli_query($conn, $updategt);
        
    }

    include($_SERVER['DOCUMENT_ROOT'] ."/assets/function/uploadfile.php");
    if(isset($_FILES['img']) && !empty($_FILES['img']['name'][0])){
        $uploadimg = $_FILES['img'];
        $uploadname = $_FILES['img']['name'];
        $upresult = UpLoadImg($uploadimg);
        if(empty($upresult)){
            $upresult = UpLoadImg($uploadimg);
        }
        if(!empty($upresult)){
            
            $upimgdtb = "UPDATE SAN_PHAM 
                            SET HinhAnhSP = '$upresult' where MaSP = '$id' ";
            $connupimg = mysqli_query($conn, $upimgdtb);
           
        }
    }
    
    header("Location: ./product-admin.php?limit=6&page-num=1");
}

if(isset($_POST['add-product'])){
    if(!empty($_POST['quantity'])){
        $sl = $_POST['quantity'];
    }
    else{
        $error = '1';
    }
    if(!empty($_POST['Price']) && is_numeric(str_replace('.','',$_POST['Price'])) == true){
        $gia = $_POST['Price'];
    }else{
        $error='2';
    }
    if(!empty($_POST['nameSP'])){
        $tensp = $_POST['nameSP'];
    }else{
        $error = '3';
    }
    if(!empty($_POST['DMSP'])){
        $loaisp = $_POST['DMSP'];
    }else{
        $error = '4';
    }
    if(!empty($_POST['DMTH'])){
        $loaith = $_POST['DMTH'];
    }else{
        $error = '5';
    }
    if(!empty($_POST['detail'])){
        $gt = $_POST['detail'];
    }else{
        $error = '6';
    }

    $getid = "SELECT ID FROM SAN_PHAM ORDER BY ID DESC";
    $connget = mysqli_query($conn,$getid);
    $showid = mysqli_fetch_object($connget);
    $masp = $showid->ID;

    if(!empty($masp)){
        $idnew = $masp+1;
        $maspnew = 'SP'.$idnew;
    }else{
        $idnew = 1;
        $maspnew = 'SP'.$idnew;
    }

    include($_SERVER['DOCUMENT_ROOT'] ."/assets/function/uploadfile.php");
    if(isset($_FILES['img']) && !empty($_FILES['img']['name'][0])){
        $uploadimg = $_FILES['img'];
        $uploadname = $_FILES['img']['name'];
        $upresult = UpLoadImg($uploadimg);
        if(empty($upresult)){
            $upresult = NULL;
        }
    }


    if(empty($error)){
        $inproductsql = "INSERT INTO SAN_PHAM (MaSP,Ma_Loai, SoLuong,Gia,Ma_TH,TenSP,ID,GioiThieuSP,HinhAnhSP, HinhAnhCT1, HinhAnhCT2, HinhAnhCT3,HinhAnhCT4) 
           VALUES ('$maspnew','$loaisp','$sl','$gia','$loaith',N'$tensp','$idnew',N'$gt','$upresult','$upresult1','$upresult2','$upresult3','$upresult4')  ";
        $conninproduct = mysqli_query($conn, $inproductsql);
        header("Location: ./product-admin.php?limit=6&page-num=1");
    }else{
        $error = 'Không được để trống thông tin';
        header("Location: ./product-add-admin.php?error=$error");
    }
}
?>
