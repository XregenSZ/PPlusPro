<?php 
    session_start();
    $open_connect = 1;
    require('config.php');

    if(isset($_GET['del'])){
        $order_id = mysqli_real_escape_string($conn, $_GET['del']);

        $sql = "DELETE FROM orders WHERE order_id = $order_id";
        $result1 = mysqli_query($conn, $sql);

        $sql2 = "DELETE FROM orders_details WHERE order_id = $order_id";
        $result2 = mysqli_query($conn, $sql2);

        if($result1 && $result2){ //ลบสำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
            echo "window. location = 'view-orders.php';";
            echo "</script>"; 
        }else{ //ลบไม่สำเร็จ
            echo $result;
            echo "<script type='text/javascript'>";
            echo "alert('มีบางอย่างผิดพลาด');";
            echo "window. location = 'view-orders.php';";
            echo "</script>"; 
    }
    }
?>