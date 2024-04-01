<?php
    
    // require 'assets/function/database.php';
    // $db = new Database();
    include ('assets/function/connect.php');
    session_start();
    
        if(isset($_POST['btn-reglog'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            // if(!empty(strchr($username,'Staff')) || !empty(strchr($username,'staff')) || !empty(strchr($username,'manage')) || !empty(strchr($username,'Manage')) 
            // || !empty(strchr($username,'Employ')) || !empty(strchr($username,'employ')) || !empty(strchr($username,'Vice')) || !empty(strchr($username,'vice')))
            $reqsql = "SELECT * FROM NHAN_VIEN WHERE TenDangNhapTK LIKE '%$username%' ";
            $reqquery = mysqli_query($conn,$reqsql);
            $row_req = mysqli_fetch_object($reqquery);
            if(isset($row_req))
            // if (preg_match('/(Staff|staff|manage|Manage|Employ|employ|Vice|vice)/', $username))
            {
                $fnhanvien = "SELECT * from TAI_KHOAN B,NHAN_VIEN A WHERE B.TenDangNhapTK LIKE ? and B.MatKhau like ? and A.TenDangNhapTK=B.TenDangNhapTK";
                //Trước khi bảo mật
                // $fnhanvien = "SELECT * from TAI_KHOAN B,NHAN_VIEN A WHERE B.TenDangNhapTK LIKE '$username' and B.MatKhau like '$password' and A.TenDangNhapTK=B.TenDangNhapTK";
                // $row_nv=$db->fetch_array($fnhanvien);
                
                //Sau Khi bảo mật
                
                $stmt_log = mysqli_prepare($conn, $fnhanvien);
                mysqli_stmt_bind_param($stmt_log, "ss", $usernameParam, $passwordParam);
                $usernameParam = "%$username%";
                $passwordParam = "%$password%";
                mysqli_stmt_execute($stmt_log);
                $result_log = mysqli_stmt_get_result($stmt_log);

                $row_log = mysqli_fetch_object($result_log);
                if(!isset($_SESSION["username"])){
                    $_SESSION["username"] = array();
                }
                if(!isset($_SESSION["Chuc-vu"])){
                    $_SESSION["chuc-vu"] = array();
                }
                if(!empty($row_log)){
                    if(isset($_SESSION["username"])){
                        $getcvsql = "SELECT * FROM CHUC_VU A, NHAN_VIEN B WHERE B.TenDangNhapTK LIKE ? and A.MaCV = B.MaCV ";
                        $stmt_cv = mysqli_prepare($conn, $getcvsql);
                        mysqli_stmt_bind_param($stmt_cv, "s", $usernameParam);
                        mysqli_stmt_execute($stmt_cv);
                        $result_cv = mysqli_stmt_get_result($stmt_cv);
                        $row_cv = mysqli_fetch_object($result_cv);
                        //$row_cv = $db->fetch_array($getcvsql);
                        $_SESSION["chuc-vu"] = $row_cv->MaCV;     
                        //var_dump($_SESSION["chuc-vu"]);exit;
                        $_SESSION["username"] = $row_log->TenDangNhapTK;
                    //var_dump($_SESSION["username"]);exit;
                    header("Location: ./admin page/admin-index.php");
                    }
                }else{

                    echo '<p style="color:red">Không tồn taị tài khoản này!</p>';
                    
                }
            }
            else{
                 $encryppass = md5($password); //password hasting
                 //Trước khi bảo mật
                // $query = "SELECT * from TAI_KHOAN B,KHACH_HANG A WHERE B.TenDangNhapTK ='$username'  and B.MatKhau ='$encryppass' and A.TenDangNhapTK=B.TenDangNhapTK  ";
               
                // $row=$db->fetch_array($query);

                // if(!isset($_SESSION["username"])){
                //     $_SESSION["username"] = array();
                //     }
                //     if(!empty($row)){
                //     if(isset($_SESSION["username"])){
                    
                //         $_SESSION["username"] = $row['TenDangNhapTK'];
                //     //var_dump($_SESSION["username"]);
                //     header("Location: ./index.php");
                //     }
                //     }else{
                //     echo '<p style="color:red">Tên đăng nhập hoặc mật khẩu không đúng!</p>';
                    
                //     }
                
                //Sau Khi bảo mật
                $logsql = "SELECT * from TAI_KHOAN WHERE TenDangNhapTK like ?  and MatKhau like ? ";
                
                $stmt_log = mysqli_prepare($conn, $logsql);
                mysqli_stmt_bind_param($stmt_log, "ss", $usernameParam, $passwordParam);
                $usernameParam = "%$username%";
                $passwordParam = "%$encryppass%";
                mysqli_stmt_execute($stmt_log);
                $result_log = mysqli_stmt_get_result($stmt_log);
                //$row=sqlsrv_fetch_object($result);
               //var_dump($stmt_log);
            
                
                    if(!isset($_SESSION["username"])){
                        $_SESSION["username"] = array();
                    }
                    $row_log = mysqli_fetch_object($result_log);
                    //var_dump($row_log);
                    if(isset($row_log->TenDangNhapTK)){
                       
                    if(isset($_SESSION["username"])){
                        $_SESSION["username"] = $row_log->TenDangNhapTK;
                        $_SESSION["USERIP"] = $_SERVER['REMOTE_ADDR'];
                        //var_dump($row_log->TenDangNhapTK);
                    //var_dump($_SESSION["username"]);exit;
                    header("Location: ./index.php");
                    }
                      
                    }else{
                    echo '<p style="color:red">Tên đăng nhập hoặc mật khẩu không đúng!</p>';
                    
                    }
                
                

            }
            
        }

?>
