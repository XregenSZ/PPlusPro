<?php 
    session_start();
    $open_connect = 1;
    require('config.php');

    if(isset($_POST['pd-list-edit'])){
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $descripion = mysqli_real_escape_string($conn, $_POST['descripion']);
        $type_id = mysqli_real_escape_string($conn, $_POST['type_id']);

        $sql = "UPDATE product SET productName ='$product_name', quantity = '$quantity', price = '$price', product_descripion = '$descripion', type_id = '$type_id' WHERE productID = $product_id";
        $result = mysqli_query($conn, $sql);

        if($result){ //แก้ไขสำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('แก้ไขสินค้าเรียบร้อยแล้ว');";
            echo "window. location = 'product-list.php';";
            echo "</script>"; 
        }else{ //แก้ไขไม่สำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('มีบางอย่างผิดพลาด');";
            echo "window. location = 'product-list.php';";
            echo "</script>"; 
    }
}
    
