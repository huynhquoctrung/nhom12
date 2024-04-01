<?php
    include 'assets/function/database.php';
    $db = new Database();
    //include ('assets/function/connect.php');
    $errornum = false;
    if (isset($_POST['btn-reg'])) {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phonenumber = $_POST['phonenumber'];
        $MKH = 'KH'.$phonenumber;
        
        if (
            !empty($username) && !empty($password) && !empty($fullname)
            && !empty($email) && !empty($address) && !empty($phonenumber)
        ) 
        {
            if(empty(strstr($username,'Staff')) && empty(strstr($username,'staff')) && empty(strstr($username,'manage')) && empty(strstr($username,'Manage')) 
                && empty(strstr($username,'Employ')) && empty(strstr($username,'employ')) && empty(strstr($username,'Vice')) && empty(strstr($username,'vice'))
                && preg_match('/[A-Z]/',$password) && !empty(strstr($password,'@')) || !empty(strstr($password,'/') || !empty(strstr($password,'!'))) || !empty(strstr($password,'%'))
                || !empty(strstr($password,'&')) || !empty(strstr($password,'(')) || !empty(strstr($password,')')) ){
                $asql = "SELECT SDT FROM KHACH_HANG WHERE SDT LIKE '$phonenumber' ";
                $conn = mysqli_connect($db->host, $db->username, $db->password, $db->dbname);
                
                $tasql = mysqli_query($conn,$asql);
                $row = mysqli_fetch_object($tasql);
                //var_dump($row->SDT);exit;
                if(empty($row->SDT)){
                    echo "<pre>";
                    //print_r($_POST);
                    $queryUSER = "INSERT INTO TAI_KHOAN (TenDangNhapTK,MatKhau) VALUES ('$username','".md5($password)."')";
                    $db->insert($queryUSER);
                    $queryCUSTOMER = " INSERT INTO KHACH_HANG (MaKH,TenDangNhapTK,HoTenKH,SDT,DiaChi,Email)
                        VALUES ('$MKH','$username',N'$fullname','$phonenumber',N'$address','$email')";
                    $db->insert($queryCUSTOMER);
                    
                    if (isset($db)) {
                        echo "Tạo tài khoản thành công";
                        header('Location: ./login.html');
                    } else {
                    // echo "Lỗi {$queryUSER}".$db->error;
                        echo "Tạo tài khoản không thành công";
                        //$errornum = "Tạo tài khoản thành công";
                        if (isset($_SERVER["HTTP_REFERER"])) {
                            header("Location: " . $_SERVER["HTTP_REFERER"]);
                        }
                    }  
                } else {
                    echo '<p style="color:red">Số điện thoại đã có người sử dụng!</p>';
                    //var_dump($errornum);exit;
                    
                
                }
            
                
            }else{
                echo '<p style="color:red">Tài khoản bạn đăng kí không hợp lệ!</p></p>';
            }
            
    } else {
    echo '<p style="color:red">Cần phải nhập đầy đủ thông tin</p></p>';
    }
}
?>
