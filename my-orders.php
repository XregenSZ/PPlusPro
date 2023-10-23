<?php
session_start();
$open_connect = 1;
require('config.php');

if (!isset($_SESSION['id_account']) || !isset($_SESSION['role_account'])) {
    die(header('Location: login.php')); //ถ้าไม่มี session id หรือ role ส่งไปหน้า login
} elseif (isset($_GET['logout'])) {
    session_destroy();
    die(header('Location: login.php'));
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
                <br>
                <h1>รายการสั่งซื้อของคุณ</h1>
                <br>
                <div class="content-c">
                    <?php
                    $query = "SELECT * FROM orders WHERE cust_name = '" . $_SESSION['username_account'] . "' ";
                    $result = mysqli_query($conn, $query);
                    ?>
                    <table width="100%" border="1" style="border-collapse: colapse;">
                        <tr>
                            <td>Order ID</td>
                            <td>Order Date</td>
                            <td>Order Name</td>
                            <td>Order Email</td>
                            <td>Order Phone</td>
                            <td>Order Address</td>
                            <td>Order Total</td>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['order_id']; ?></td>
                                <td><?php echo $row['order_date']; ?></td>
                                <td><?php echo $row['order_name']; ?></td>
                                <td><?php echo $row['order_email']; ?></td>
                                <td><?php echo $row['order_phone']; ?></td>
                                <td><?php echo $row['order_address']; ?></td>
                                <td><?php echo $row['total']; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
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