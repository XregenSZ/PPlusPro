<?php 
    session_start();
    $open_connect = 1;
    require('config.php');

    if(isset($_POST['pd-type-edit'])){
        $type_id = mysqli_real_escape_string($conn, $_POST['type_id']);
        $type_name = mysqli_real_escape_string($conn, $_POST['type_name']);

        $sql = "UPDATE product_type SET type_name = '$type_name' WHERE type_id = $type_id";
        $result = mysqli_query($conn, $sql);

        if($result){ //แก้ไขสำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('แก้ไขประเภทสินค้าเรียบร้อยแล้ว');";
            echo "window. location = 'product-type.php';";
            echo "</script>"; 
        }else{ //แก้ไขไม่สำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('มีบางอย่างผิดพลาด');";
            echo "window. location = 'product-type.php';";
            echo "</script>"; 
    }
}
