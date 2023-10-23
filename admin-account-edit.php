<?php
session_start();
$open_connect = 1;
require('config.php');

if (!isset($_SESSION['id_account']) || ($_SESSION['role_account'] != 'admin')) {
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
    $query_account_show = "SELECT * FROM account";
    $result_account_show = mysqli_query($conn, $query_account_show);
    $account_row = mysqli_fetch_all($result_account_show);

    if (isset($_GET['del'])) {
        $id = $_GET['del'];
        $delete = mysqli_query($conn, "DELETE FROM `account` WHERE `id_account` = '$id'");
    }
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
    <title>Admin</title>
</head>

<body>
    <div class="navbar">
        <h1>ยินดีต้อนรับคุณ <?php echo $result_show['username_account']; ?> as <?php echo $result_show['role_account']; ?></h1>
    </div>

    <section>
        <nav>
            <ul>
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="product-list.php">จัดการสินค้า</a></li>
                <li><a href="product-type.php">จัดดการประเภทสินค้า</a></li>
                <li><a href="view-orders.php">จัดการออเดอร์</a></li>
                <li class="logout"><a href="admin.php?logout=1">ออกจากระบบ</a></li>
            </ul>
        </nav>
        <div class="info">
            <div class="login-container">
                <div><img src="RedStore_Img/images/ppluslogo-white.png" width="180px" height="180px"></div>
                <h2>ฟอร์มแก้ไข สมาชิก</h2>
                <?php
                if (isset($_GET['edit'])) {
                    $account_id = $_GET['edit'];
                    $sql = "SELECT * FROM account WHERE id_account = $account_id";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                }
                ?>
                <form action="admin-account-edit-db.php" method="post">
                    <div class="register-form">
                        <input type="hidden" name="id_account" value="<?php echo $account_id; ?>">
                        <h3>Username</h3>
                        <input type="text" name="username_account" value="<?php echo $row['username_account']; ?>" placeholder="User name" required> <br><br>
                        <h3>Email</h3>
                        <input type="text" name="email_account" value="<?php echo $row['email_account']; ?>" placeholder="Email" required><br><br>
                        <h3>Password</h3>
                        <input type="password" name="password_account1" value="<?php echo $row['password_account']; ?>" placeholder="Password" required><br><br>
                        <input type="submit" name="update" value="update">
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>