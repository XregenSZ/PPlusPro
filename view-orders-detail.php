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
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="product-list.php">จัดการสินค้า</a></li>
                <li><a href="product-type.php">จัดการประเภทสินค้า</a></li>
                <li><a href="view-orders.php">จัดการออเดอร์</a></li>
                <li class="logout"><a href="admin.php?logout=1">ออกจากระบบ</a></li>
            </ul>
        </nav>
        <div class="info">
            <?php
            $detail_id = $_GET['detail'];
            $query = "SELECT * FROM orders_details as d INNER JOIN product as p ON d.product_id = p.productID WHERE order_id LIKE '%" . $detail_id . "%' ORDER BY detail_id";
            $result = mysqli_query($conn, $query);

            $query_bill = "SELECT * FROM order_bill WHERE order_id LIKE $detail_id ORDER BY order_id";
            $result_bill = mysqli_query($conn, $query_bill);

            ?>
            <table>
                <tr>
                    <td>Order id</td>
                    <td>รูปสินค้า</td>
                    <td>Product ID</td>
                    <td>จำนวน</td>
                    <td>รวม</td>
                    <td colspan="3">Action</td>
                </tr>
                <?php
                $total = 0;
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['order_id'] ?></td>
                        <td><img width="60px 60px" src="uploads/<?php echo $row['ImageName'] ?>" alt=""></td>
                        <td><?php echo $row['product_id'] ?></td>
                        <td><?php echo $row['quantity_detail'] ?></td>
                        <td><?php echo $row['total'] ?></td>
                        <td><a href="delete-orders.php?del=<?php echo $row['order_id']; ?>" onclick="return confirm('คุณต้องการลบออเดอร์ใช่ไหม');" class="btn">ลบ</a></td>
                    </tr>
                    <?php $sum = $row['total'];
                    $total += $sum; ?>
                <?php } ?>
                <tr>
                    <td colspan="4">
                        <h3>ราคารวม</h3>
                    </td>
                    <td colspan="2">
                        <h3><?php echo number_format($total, 2); ?></h3>
                    </td>
                </tr>
                <?php
                while ($billrow = mysqli_fetch_assoc($result_bill)) { ?>
                <tr>
                    <td colspan="6"><img width="50%" src="uploads_bill/<?php echo $billrow['bill_new_name'] ?>" alt=""></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </section>
</body>

</html>