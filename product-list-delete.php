<?php 
    session_start();
    $open_connect = 1;
    require('config.php');

    if(isset($_GET['del'])){
        $product_id = $_GET['del'];

        $sql = "DELETE FROM product WHERE productID = $product_id";
        $result = mysqli_query($conn, $sql);

        if($result){ //ลบสำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('ลบประเภทสินค้าเรียบร้อยแล้ว');";
            echo "window. location = 'product-list.php';";
            echo "</script>"; 
        }else{ //ลบไม่สำเร็จ
            echo $result;
            echo "<script type='text/javascript'>";
            echo "alert('มีบางอย่างผิดพลาด');";
            echo "window. location = 'product-list.php';";
            echo "</script>"; 
    }
    }
?>