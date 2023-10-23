<?php 
    session_start();
    $open_connect = 1;
    require('config.php');

    if(isset($_POST['pd_type_add'])){
        $type_name = mysqli_real_escape_string($conn, $_POST['type_name']);

        $sql = "INSERT INTO product_type (type_name) VALUES ('$type_name')";
        $result = mysqli_query($conn, $sql);

        if($result){ //แก้ไขสำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('เพิ่มประเภทสินค้าเรียบร้อยแล้ว');";
            echo "window. location = 'product-type.php';";
            echo "</script>"; 
        }else{ //แก้ไขไม่สำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('มีบางอย่างผิดพลาด');";
            echo "window. location = 'product-type.php';";
            echo "</script>"; 
    }
}
?>
