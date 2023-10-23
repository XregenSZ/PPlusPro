<?php
session_start();
$open_connect = 1;
require('config.php');

if (!isset($_SESSION['id_account']) || ($_SESSION['role_account'] != 'admin')) {
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
    <title>view-order</title>
</head>

<body>
    <div class="navbar">
        <h1>ยินดีต้อนรับคุณ <?php echo $result_show['username_account']; ?> as <?php echo $result_show['role_account']; ?></h1>
        <h2><a href="admin.php?logout=1">ออกจากระบบ</a></h2>
    </div>
    <section>
        <nav>
            <ul>
                <li><a href="admin.php">จัดการสมาชิก</a></li>
                <li><a href="product-list.php">จัดการสินค้า</a></li>
                <li><a href="product-type.php">จัดการประเภทสินค้า</a></li>
                <li><a href="view-orders.php">จัดการออเดอร์</a></li>
                <li class="logout"><a href="admin.php?logout=1">ออกจากระบบ</a></li>
            </ul>
        </nav>
        <div class="info">
            <?php
            $query = "SELECT * FROM orders ORDER BY order_id";
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
                        <td><?php if ($row['order_status'] == 1) { ?>
                                <a href="order-confirm.php?change=<?php echo $row['order_id'];?>" style="color: green">
                                ชำระเงินแล้ว
                            </a>
                            <?php  } else { ?>
                                <a href="order-confirm.php?change=<?php echo $row['order_id'];?>" style="color: red">ยังไม่ชำระเงิน</a>
                            <?php } ?>
                        </td>
                        <!--<td><a href="view-order-print.php?detail=" class="editbtn">Print</a></td> -->
                        <td><a href="view-orders-detail.php?detail=<?php echo $row['order_id']; ?>" class="editbtn">Detail</a></td>
                        <td><a href="delete-orders.php?del=<?php echo $row['order_id']; ?>" onclick="return confirm('คุณต้องการลบออเดอร์ใช่ไหม');" class="btn">ลบ</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </section>
</body>

</html>