<?php 
    session_start();
    $open_connect = 1;
    require('config.php');
    
    if(isset($_GET['change'])){
        $id = $_GET['change'];
        $status = "SELECT * FROM orders WHERE order_id LIKE $id ";
        $status_q = mysqli_query($conn, $status);
        $status_f = mysqli_fetch_assoc($status_q);
        
        if($status_f['order_status'] == 0){
            $sql = "UPDATE orders SET order_status = 1 WHERE order_id = '$id' ";
            $result = mysqli_query($conn, $sql);
        } else {
            $sql = "UPDATE orders SET order_status = 0 WHERE order_id = '$id' ";
            $result = mysqli_query($conn, $sql);
        }

        if($result){ //แก้ไขสำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('แก้ไขสินค้าเรียบร้อยแล้ว');";
            echo "window. location = 'view-orders.php';";
            echo "</script>"; 
        }else{ //แก้ไขไม่สำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('มีบางอย่างผิดพลาด');";
            echo "window. location = 'view-orders.php';";
            echo "</script>"; 
    }
} else {
    echo "<script type='text/javascript'>";
            echo "alert('มีบางอย่างผิดพลาด');";
            echo "window. location = 'view-orders.php';";
            echo "</script>"; 
}
