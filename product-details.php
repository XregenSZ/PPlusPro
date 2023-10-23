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
                    <li class="dropdown"><button class="dropdownbtn"><a href="contact.html">ติดต่อเรา</a></button></li>
                </ul>
            </nav>
            <img src="RedStore_Img/images/shopping-cart.png" width="60px" height="60px">
            <div>
                <nav>
                    <ul>
                        <li class="dropdown"><button class="dropdownbtn"><a href="login.php">เข้าสู่ระบบ</a></button></li>
                    </ul>
                </nav>
            </div>
        </div>

        <!---- featured categories ----->
        <section>
            <div style="text-align:center;" class="container">
                <?php
                if (isset($_GET['detail'])) {
                    $productid = $_GET['detail'];
                    $sql = "SELECT * FROM product WHERE productID = $productid";
                    $query = mysqli_query($conn, $sql);
                    $result = mysqli_fetch_assoc($query);
                }
                ?>

                <div style="text-align: center;" class="product-details">
                    <br>
                    <h1><?php echo $result['productName']; ?></h1>
                    <br>
                    <img width="30%" src="uploads/<?php echo $result['ImageName']; ?>" alt="">
                    <br>
                    <p><?php echo $result['product_descripion'] ?></p>
                    <br>
                    <div class="pd-info">
                        <h3>ราคา <?php echo $result['price'] ?> บาท</h3>
                        <?php
                        if ($result['quantity'] == 0) {
                            echo "<p style='color: red;'>สินค้าหมด</p>";
                        } else {
                        ?>
                            <a href="cart.php?addtocart=<?php echo $result['productID']; ?>" 
                            style="text-decoration: none;
                            background: green;
                            color: #fff;
                            padding: .5rem;
                            display: inline-block;
                            font-size: 16px;
                            border-radius: 5px;" class="buy">สั่งซื้อ</a>
                        <?php } ?>
                        <p style="font-size: 14px;" class="label">จำนวนคงเหลือ <?php echo $result['quantity'] ?> ชิ้น</p>
                    </div>
                    <br><br>
                    <a href="index.php" style="background: #ccc; display: inline-block; padding: .5rem 1rem; color: #000; text-decoration: none; border-radius: 5px;">กลับไปหน้าแรก</a>
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