<?php 
    session_start();
    $open_connect = 1;
    require('config.php');

    date_default_timezone_set('Asia/Bangkok');

    if (isset($_POST['save_order'])){
        $order_name = mysqli_real_escape_string($conn, $_POST['name']);
        $order_phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $order_email = mysqli_real_escape_string($conn, $_POST['email']);
        $order_address = mysqli_real_escape_string($conn, $_POST['address']);

        $total = mysqli_real_escape_string($conn, $_POST['total']);
        $cust_name = mysqli_real_escape_string($conn, $_POST['cust_name']);
        $order_date = Date("Y-m-d G:i:s");

        $sql1 = "INSERT INTO orders (order_date, order_name, order_email, order_phone , order_address, total, cust_name)
                VALUE ('$order_date', '$order_name','$order_email','$order_phone','$order_address','$total','$cust_name')";
        $query1 = mysqli_query($conn, $sql1);

        $sql2 = "SELECT max(order_id) as o_id FROM orders WHERE order_name = '$order_name' AND order_email = '$order_email' AND order_date = '$order_date'";
        $query2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_assoc($query2);
        $o_id = $row['o_id'];

        foreach($_SESSION['cart'] as $product_id => $qty){
            $sql3 = "SELECT * FROM product WHERE productID = $product_id";
            $query3 = mysqli_query($conn, $sql3);
            $row3 = mysqli_fetch_assoc($query3);
            $total = $row3['price'] * $qty;
            $count = mysqli_num_rows($query3);

            $sql4 = "INSERT INTO orders_details (order_id, product_id, quantity_detail, total)
                    VALUE ($o_id,$product_id,$qty,$total)";
            $query4 = mysqli_query($conn, $sql4);

            //Cut stock
            for($i = 0; $i < $count; $i++){
                $instock = $row3['quantity'];
                $stock = $instock - $qty;
                $sqlstock = "UPDATE product SET quantity = '$stock' WHERE productID = $product_id";
                $querystock = mysqli_query($conn, $sqlstock);
            }
        }

        if($query1 && $query4 && $querystock){
            foreach($_SESSION['cart'] as $product_id){
                unset($_SESSION['cart']);
            } //แก้ไขสำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
            echo "window. location = 'view-order-customer.php';";
            echo "</script>"; 
        }else{ //แก้ไขไม่สำเร็จ
            echo "<script type='text/javascript'>";
            echo "alert('มีบางอย่างผิดพลาด');";
            echo "</script>"; 
    }
}
?>