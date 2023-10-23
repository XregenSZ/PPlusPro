<?php 
    session_start();
    $open_connect = 1;
    require('config.php');

    if(isset($_POST['bill_list_add'])){

        $name = $_POST["name"];
        if ($_FILES["bill_name"]["error"] === 4) {
        echo
        "<script> 
            alert('Image Does Not Exist); 
            document.location.href = 'admin.php';
        </script>";
    } else {
        $fileName = $_FILES["bill_name"]["name"];
        $fileSize = $_FILES["bill_name"]["size"];
        $tmpName = $_FILES["bill_name"]["tmp_name"];

        $validImageExtention = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if (!in_array($imageExtension, $validImageExtention)) {
            echo
            "<script> 
                alert('Image Does Not Exist); 
                document.location.href = 'product-img.php';
            </script>";
        } else if ($fileSize > 10000000) {
            echo
            "<script> 
                alert('Image Size Is Too Large'); 
                document.location.href = 'product-img.php';
            </script>";
        } else {
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);

            move_uploaded_file($tmpName, 'uploads_bill/' . $newImageName);
            $sql = "INSERT INTO order_bill VALUES ('','$order_id','$name','$newImageName')";
            $result = mysqli_query($conn, $sql);

            if($result){ //แก้ไขสำเร็จ
                echo "<script type='text/javascript'>";
                echo "alert('แจ้งชำระเรียบร้อยแล้ว รอการตรวจสอบชำระเงิน');";
                echo "window. location = 'view-order-customer.php';";
                echo "</script>"; 
            }else{ //แก้ไขไม่สำเร็จ
                echo "<script type='text/javascript'>";
                echo "alert('ไม่สามารถแจ้งชำระเงินได้ มีบางอย่างผิดพลาด');";
                echo "window. location = 'view-order-customer.php';";
                echo "</script>"; 
        }
    }
    }
}
