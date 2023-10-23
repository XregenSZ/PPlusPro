<?php 
    session_start();
    $open_connect = 1;
    require('config.php');

    if(isset($_POST['pd_list_add'])){
        $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $descreipion = mysqli_real_escape_string($conn, $_POST['descreipion']);
        $product_type_id = mysqli_real_escape_string($conn, $_POST['product_type_id']);

        $name = $_POST["name"];
        if ($_FILES["imageName"]["error"] === 4) {
        echo
        "<script> 
            alert('Image Does Not Exist); 
            document.location.href = 'admin.php';
        </script>";
    } else {
        $fileName = $_FILES["imageName"]["name"];
        $fileSize = $_FILES["imageName"]["size"];
        $tmpName = $_FILES["imageName"]["tmp_name"];

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

            move_uploaded_file($tmpName, 'uploads/' . $newImageName);
            $sql = "INSERT INTO product VALUES ('','$product_name','$quantity','$price','$descreipion',NOW(),'$product_type_id','$newImageName','$name')";
            $result = mysqli_query($conn, $sql);

            if($result){ //แก้ไขสำเร็จ
                echo "<script type='text/javascript'>";
                echo "alert('เพิ่มสินค้าเรียบร้อยแล้ว');";
                echo "window. location = 'product-list.php';";
                echo "</script>"; 
            }else{ //แก้ไขไม่สำเร็จ
                echo "<script type='text/javascript'>";
                echo "alert('มีบางอย่างผิดพลาด');";
                echo "window. location = 'product-list.php';";
                echo "</script>"; 
        }
    }
    }
}
