<?php
session_start();
$open_connect = 1;
require('config.php');

if (!isset($_SESSION['id_account'])) {
    die(header('Location: login.php')); //ถ้าไม่มี sesstion id หรือ role ส่งไปหน้า login
} elseif (isset($_GET['logout'])) { //กด logout ทำลาย session ส่งไปหน้า login
    session_destroy();
    die(header('Location: login.php'));
} else {
    $id_account = $_SESSION['id_account'];
    $query_account_show = "SELECT * FROM account WHERE id_account = '$id_account'";
    $call_back_show = mysqli_query($conn, $query_account_show);
    $query_acc_show = "SELECT * FROM account";
    $call_back_acc_show = mysqli_query($conn, $query_acc_show);
    $result_show = mysqli_fetch_assoc($call_back_show);
    $query_account_show = "SELECT * FROM account";
    $result_account_show = mysqli_query($conn, $query_account_show);
    $account_row = mysqli_fetch_all($result_account_show);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>order-detail</title>
</head>

<body>
    <div class="navbar">
        <h1>ยินดีต้อนรับคุณ <?php echo $result_show['username_account']; ?> as <?php echo $result_show['role_account']; ?></h1>
        <h2><a href="admin.php?logout=1">ออกจากระบบ</a></h2>
    </div>
    <section>
        <nav>
            <ul>
                <li><a href="index.php">หน้าแรก</a></li>
                <li><a href="view-order-customer.php">รายการสั่งซื้อ</a></li>
                <li class="logout"><a href="admin.php?logout=1">ออกจากระบบ</a></li>
            </ul>
        </nav>
        <?php 
            if(isset($_GET['detail'])){
                $order_id = mysqli_real_escape_string($conn, $_GET['detail']);
                $sql = "SELECT * FROM orders WHERE order_id = $order_id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
            }
        ?>
        <div class="info">
            <div class="login-container">
                <img src="uploads_bill/QRCODE.jpg" style="width: 30%;" alt="">
                <form action="order-bill-db.php" method="post" enctype="multipart/form-data" class="upload-form">
                    <div class="register-form">
                        <h3>นาย สิงห์ทอง รุ่งเรืองวิทย์<br>พร้อมเพย์ 0917129841</h3>
                        <h3 style="color: orange;">กรุณาตรวจสอบจำนวนเงินก่อนโอนทุกครั้ง</h3><br><br>
                        <div class="img-input">
                            <h5>Select image file to upload</h5>
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                            <input type="text" name="name" id="name" placeholder="ใส่ชื่อรูปภาพ" required><br><br>
                            <input type="file" id="bill_name" name="bill_name" class="file-input" accept="image/gif, image/jpeg, image/png" required><br>
                            <h5>Note: Only JPG, JPEG, PNG & GIF files are allowed to upload</h5><br>
                        </div>

                        <input type="submit" name="bill_list_add">

                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>