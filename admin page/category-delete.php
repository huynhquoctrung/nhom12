<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/assets/function/connect.php');
?>
<?php
    if(isset($_GET['type'])){
        //var_dump($_GET['type']);exit;
        $type = $_GET['type'];
        
        $deletesql = "DELETE FROM Loai_SP WHERE Ma_Loai = '$type' ";
        $conndeltype = mysqli_query($conn,$deletesql);
        //var_dump($conndeltype);exit;
        header("Location: ./category-admin.php");
    }
?>
