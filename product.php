<?php
session_start();
$open_connect = 1;
require('config.php');

if (isset($_GET['logout'])) { //กด logout ทำลาย session ส่งไปหน้า login
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
    <link rel="stylesheet" href="carousel.css">
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
            <div>
            <?php
                if (!isset($_SESSION['id_account']) || (!isset($_SESSION['role_account']))) { ?>
                <?php } else {
                    $id_account = $_SESSION['id_account'];
                    $query_account_show = "SELECT * FROM account WHERE id_account = '$id_account'";
                    $call_back_show = mysqli_query($conn, $query_account_show);
                    $query_acc_show = "SELECT * FROM account";
                    $call_back_acc_show = mysqli_query($conn, $query_acc_show);
                    $result_show = mysqli_fetch_assoc($call_back_show); ?>
                    <li class="dropdown" style="color:  white; font-size: 18px;">
                    ยินดีต้อนรับ คุณ <?php echo $result_show['username_account']; ?>
                    <div class="dropdown-content"><a href="view-order-customer.php">ดูรายการสั่งซื้อ</a></div>
                    </li>
                <?php } ?>
            </div>
            <nav>
                <ul>
                    <li>
                        <form action="search.php" class="search_bar" method="get">
                            <input type="text" name="search_name" placeholder="ค้นหาสินค้า">
                            <input type="submit" name="search_btn" value="Search">
                        </form>
                    </li>
                    <li class="dropdown">
                        <button class="dropdownbtn">
                            <a href="index.php">หน้าแรก</a>
                        </button>
                    </li>
                    <li class="dropdown"><button class="dropdownbtn"><a href="product.php">สินค้า</a></button></li>
                    <li class="dropdown"><button class="dropdownbtn"><a href="contact.php">ติดต่อเรา</a></button></li>
                </ul>
            </nav>
            <a href="cart.php"><img src="RedStore_Img/images/shopping-cart.png" width="60px" height="60px"></a>
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
                <div class="content-c">
                    <div class="sidebar-c">
                        <div class="sidebar-title">
                            <h3>หมวดหมู่สินค้า</h3><br>
                        </div>

                        <ul class="sidebar-catefories">
                            <?php
                            $query = "SELECT * FROM product_type ORDER BY type_id";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) == 0) {
                                echo "<li>ไม่มีหมวดหมู่สินค้า</li>";
                            } else { ?>
                                <?php foreach ($result as $results) { ?>
                                    <li class="categories-menu"><a href="categories.php?type=<?php echo $results['type_id']; ?>"><?php echo $results['type_name']; ?></a></li>
                            <?php }
                            } ?>
                        </ul>
                    </div>
                    <div class="product-c">
                        <div class="product-grid">
                            <?php
                            $sql = "SELECT * FROM product";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {

                            ?>
                                    <div class="product-items">
                                        <div class="pd-img">
                                            <h3><?php echo $row['productName']; ?></h3>
                                            <a href="product-details.php?detail=<?php echo $row['productID']; ?>">
                                                <img width="70%" src="uploads/<?php echo $row['ImageName'] ?>" alt="">
                                            </a>
                                        </div>
                                        <div class="pd-info">
                                            <h3>ราคา <?php echo $row['price'] ?> บาท</h3>
                                            <?php
                                            if ($row['quantity'] == 0) {
                                                echo "<p style='color: red;'>สินค้าหมด</p>";
                                            } else {
                                            ?>
                                                <a href="cart.php?addtocart=<?php echo $row['productID']; ?>" class="buy">สั่งซื้อ</a>
                                            <?php } ?>
                                            <p style="font-size: 14px;" class="label">จำนวนคงเหลือ <?php echo $row['quantity'] ?> ชิ้น</p>
                                        </div>
                                    </div>
                            <?php }
                            } else {
                                echo "<h1>ไม่มีสินค้า</h1>";
                            } ?>
                        </div>
                    </div>
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