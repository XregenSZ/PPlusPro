<?php
session_start();
$open_connect = 1;
require('config.php');

if (!isset($_SESSION['id_account']) || !isset($_SESSION['role_account'])) {
    die(header('Location: login.php')); //ถ้าไม่มี session id หรือ role ส่งไปหน้า login
} elseif (isset($_GET['logout'])) {
    session_destroy();
    echo "<script type='text/javascript'>";
    echo "alert('ออกจากระบบเรียบร้อยแล้ว');";
    echo "window. location = 'index.php';";
    echo "</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>P Plus Store</title>
</head>

<body>
    <div class="header">
        <!-- nav menu -->
        <div class="navbar">
            <div class="logo">
                <div><img src="RedStore_Img/images/ppluslogo-white.png" width="60px" height="60px"></div>
            </div>
            <?php
            if (!isset($_SESSION['id_account']) || (!isset($_SESSION['role_account']))) { ?>
            <?php } else {
                $id_account = $_SESSION['id_account'];
                $query_account_show = "SELECT * FROM account WHERE id_account = '$id_account'";
                $call_back_show = mysqli_query($conn, $query_account_show);
                $query_acc_show = "SELECT * FROM account";
                $call_back_acc_show = mysqli_query($conn, $query_acc_show);
                $result_show = mysqli_fetch_assoc($call_back_show); ?>
                <li class="dropdown" style="color:  white; font-size: 18px;">ยินดีต้อนรับ คุณ <?php echo $result_show['username_account']; ?>

                    <div class="dropdown-content"><a href="view-order-customer.php">ดูรายการสั่งซื้อ</a></div>

                </li>
            <?php } ?>
            <nav>
                <ul>
                    <li>
                        <form action="" class="search_bar" method="post">
                            <input type="text" name="search_name" placeholder="ค้นหาสินค้า">
                            <input type="submit" name="search_btn" value="Search">
                        </form>
                    </li>
                    <li class="dropdown">
                        <button class="dropdownbtn">
                            <a href="index.php">หน้าแรก</a>
                        </button>
                    </li>
                    <li class="dropdown"><button class="dropdownbtn"><a href="">เกี่ยวกับ</a></button></li>
                    <li class="dropdown"><button class="dropdownbtn"><a href="contact.php">ติดต่อเรา</a></button></li>
                </ul>
            </nav>
            <img src="RedStore_Img/images/shopping-cart.png" width="60px" height="60px">
            <div>
                <nav>
                    <ul>
                        <?php
                        if (!isset($_SESSION['id_account']) || (!isset($_SESSION['role_account']))) { ?>
                            <li class="dropdown"><button class="dropdownbtn"><a href="login.php">เข้าสู่ระบบ</a></button></li>
                        <?php } else { ?>
                            <li class="dropdown"><button class="dropdownbtn"><a href="index.php?logout=1">ออกจากระบบ</a></button></li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>

        <!---- featured categories ----->
        <section>
            <div class="container">
                <?php

                if (isset($_GET['addtocart'])) {
                    $product_id = $_GET['addtocart'];

                    if (isset($_SESSION['cart'][$product_id])) {
                        $_SESSION['cart'][$product_id]++;
                    } else {
                        $_SESSION['cart'][$product_id] = 1;
                    }
                }
                if (isset($_GET['remove'])) {
                    $product_id = $_GET['remove'];
                    unset($_SESSION['cart'][$product_id]);
                }
                if (isset($_GET['update'])) {
                    $amount_array = $_POST['amount'];
                    foreach ($amount_array as $product_id => $amount) {
                        $_SESSION['cart'][$product_id] = $amount;
                    }
                }
                ?>


                <form action="?update" method="post" name="cart">
                    <h1>ตะกร้าสินค้า</h1>
                    <br>
                    <table width="100%" border="1" style="border-collapse: collapse; background: white; text-align: center;">
                        <tr>
                            <td>สินค้า</td>
                            <td>ราคา</td>
                            <td>จำนวน</td>
                            <td>รวม</td>
                            <td>ลบ</td>
                        </tr>
                        <?php

                        $total = 0;
                        if (!empty($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $product_id => $qty) {
                                $sql = "SELECT * FROM product WHERE productID = $product_id";
                                $query = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($query);
                                if ($qty > $row['quantity']) {
                                    $qty = $row['quantity'];
                                    echo "<script type='text/javascript'>";
                                    echo "alert('สินค้าไม่เพียงพอ');";
                                    echo "</script>";
                                }
                                $sum = $row['price'] * $qty;
                                $total += $sum;


                        ?>
                                <tr>
                                    <td><?php echo $row['productName']; ?></td>
                                    <td><?php echo number_format($row['price'], 2); ?></td>
                                    <td><input type="number" name="amount[<?php echo $product_id; ?>]" value="<?php echo $qty; ?>"></td>
                                    <td><?php echo number_format($sum, 2); ?></td>
                                    <td><a href="cart.php?remove=<?php echo $product_id; ?>" style="color: red;">X</a></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3">
                                    <h3>ราคารวม</h3>
                                </td>
                                <td>
                                    <h3><?php echo number_format($total, 2); ?></h3>
                                </td>
                            </tr>
                            <tr align="center">
                                <td align="left" colspan="3">
                                    <a style="width: 100%; cursor: pointer; background: #15abe3; color: #fff; padding: .5rem; text-decoration: none; border-radius: 5px;" href="index.php">กลับไปหน้ารายการสินค้า</a>
                                </td>
                                <td>
                                    <input style="width: 100%; cursor: pointer; background: #15abe3; color: #fff; padding: .5rem; text-decoration: none; border-radius: 5px;" type="submit" name="button" value="ปรับปรุง">
                                </td>
                                <td>
                                    <input style="width: 100%; cursor: pointer; background: green; color: #fff; padding: .5rem; text-decoration: none; border-radius: 5px;" type="button" value="สั่งซื้อ" onclick="window.location='confirm.php'">
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </form>
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