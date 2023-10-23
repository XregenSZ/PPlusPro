<?php
session_start();
$open_connect = 1;
require('config.php');

if (!isset($_SESSION['id_account'])) {
    die(header('Location: login.php')); //ถ้าไม่มี sesstion id หรือ role ส่งไปหน้า login
} elseif (isset($_GET['logout'])) { //กด logout ทำลาย session ส่งไปหน้า login
    session_destroy();
    echo "<script type='text/javascript'>";
    echo "alert('ออกจากระบบเรียบร้อยแล้ว');";
    echo "window. location = 'index.php';";
    echo "</script>";
} else {
    $id_account = $_SESSION['id_account'];
    $query_account_show = "SELECT * FROM account WHERE id_account = '$id_account'";
    $call_back_show = mysqli_query($conn, $query_account_show);
    $query_acc_show = "SELECT * FROM account";
    $call_back_acc_show = mysqli_query($conn, $query_acc_show);
    $result_show = mysqli_fetch_assoc($call_back_show);
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
    <title>P Plus Store</title>
</head>

<body>
    <div class="navbar">
        <h1>ยินดีต้อนรับคุณ <?php echo $result_show['username_account']; ?></h1>
    </div>

    <!-- content -->
    <section>
        <nav>
            <ul>
                <li><a href="index.php">หน้าแรก</a></li>
                <li><a href="view-order-customer.php">รายการสั่งซื้อ</a></li>
                <li class="logout"><a href="admin.php?logout=1">ออกจากระบบ</a></li>
            </ul>
        </nav>
        <div class="info">
            <?php
            $customer = $result_show['username_account'];
            $query = "SELECT * FROM orders WHERE cust_name = '$customer' ORDER BY order_id";
            $result = mysqli_query($conn, $query);

            ?>
            <table>
                <tr>
                    <td>Order id</td>
                    <td>Order Date</td>
                    <td>Order Name</td>
                    <td>Order Email</td>
                    <td>Order Phone</td>
                    <td>Address</td>
                    <td>Status</td>
                    <td colspan="3">Action</td>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['order_id'] ?></td>
                        <td><?php echo $row['order_date'] ?></td>
                        <td><?php echo $row['order_name'] ?></td>
                        <td><?php echo $row['order_email'] ?></td>
                        <td><?php echo $row['order_phone'] ?></td>
                        <td><?php echo $row['order_address'] ?></td>
                        <td><?php if ($row['order_status'] == 1){?>
                            <p style="color: green;">ชำระเงินแล้ว</p>
                          <?php  } else {?>
                            <p style="color : red;">รอตรวจสอบ ชำระเงิน</p>
                        <?php }?>
                        </td>
                        <td><a href="order-bill.php?detail=<?php echo $row['order_id']; ?>" class="editbtn">แจ้ง ชำระเงิน</a></td>
                        <td><a href="view-order-customer-detail.php?detail=<?php echo $row['order_id']; ?>" class="editbtn">ดูรายละเอียด</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </section>

    <!-- footer -->
    <footer>
        <div class="foot-logo">
            <center><img src="RedStore_Img/images/ppluslogo-white.png" width="260px"></center>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <center>
                    <img src="footer-img/telephone.png" width="60px">
                    <p>เบอร์โทร</p>
                    <strong>123456789</strong>
                </center>
            </div>
            <div class="col-sm-4">
                <center>
                    <img src="footer-img/line.png" width="60px">
                    <p>LINE ID</p>
                    <strong>@P PLUS STORE</strong>
                </center>
            </div>
            <div class="col-sm-4">
                <center>
                    <img src="footer-img/facebook.png" width="60px">
                    <p>FANPAGE FACEBOOK</p>
                    <strong>P PLUS STORE</strong>
                </center>
            </div>
            <div class="col-sm-4">
                <center>
                    <img src="footer-img/messenger.png" width="60px">
                    <p>MESSENGER</p>
                    <strong>P PLUS STORE</strong>
                </center>
            </div>
        </div>
        <div>
            <center>
                <p>ร้านจัดจำหน่ายอุปกรณ์ช่าง เครื่องมือช่าง สว่านคุณภาพดี ไขควง โซล่าแซล หลอดไฟ อุปกรณ์ช่างอื่นๆ
                </p>
            </center>
        </div>
    </footer>
</body>

</html>