<?php 
    session_start();
    $open_connect = 1;
    require('config.php');

    if(isset($_GET['del'])){
        $account_id = $_GET['del'];

        $sql = "DELETE FROM account WHERE id_account = $account_id";
        $result = mysqli_query($conn, $sql);

        if($result){ //ลบสำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('ลบสมาชิกเรียบร้อยแล้ว');";
            echo "window. location = 'admin.php';";
            echo "</script>"; 
        }else{ //ลบไม่สำเร็จ
            echo $result;
        echo "<script type='text/javascript'>";
        echo "alert('มีบางอย่างผิดพลาด');";
        echo "window. location = 'admin.php';";
        echo "</script>"; 
    }
}
?>