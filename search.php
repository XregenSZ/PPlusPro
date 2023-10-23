<?php
session_start();
$open_connect = 1;
require('config.php');

if (isset($_GET['logout'])) {
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
    <title>search</title>
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
                    <li class="dropdown"><button class="dropdownbtn"><a href="">เกี่ยวกับ</a></button></li>
                    <li class="dropdown"><button class="dropdownbtn"><a href="contact.php">ติดต่อเรา</a></button></li>
                </ul>
            </nav>
            <img src="RedStore_Img/images/shopping-cart.png" width="60px" height="60px">
            <div>
                <nav>
                    <?php
                    if (!isset($_SESSION['id_account']) || (!isset($_SESSION['role_account']))) { ?>
                        <li class="dropdown"><button class="dropdownbtn"><a href="login.php">เข้าสู่ระบบ</a></button></li>
                    <?php } else { ?>
                        <li class="dropdown"><button class="dropdownbtn"><a href="index.php?logout=1">ออกจากระบบ</a></button></li>
                    <?php } ?>
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
                    <div class="search_c">
                        <?php
                        if (isset($_GET['search_name'])) {
                            $search_name = $_GET['search_name'];
                            $query = "SELECT * FROM product WHERE productName LIKE '%" . $search_name . "%' ";
                            $result = mysqli_query($conn, $query);

                        ?>
                            <div class="search-grid">
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {

                                ?>
                                <div class="search-items">
                                    <h3><?php echo $row['productName']; ?></h3>
                                    <img src="uploads/<?php echo $row['ImageName']; ?>"></img>
                                    <div class="pd-info">
                                    <h3>ราคา <?php echo $row['price']; ?> บาท</h3>
                                    <?php if ($row['quantity'] == 0) {
                                        echo "<p style='color: red;'>สินค้าหมด</p>";
                                    } else { ?>
                                            <a href="cart.php?addtocart=<?php echo $row['productID']; ?>" class="buy">สั่งซื้อ</a>
                                            <p style="font-size: 14px;" class="label">จำนวนคงเหลือ <?php echo $row['quantity'] ?> ชิ้น</p>
                                        <?php } ?> 
                                    </div>
                                </div>
                            <?php }
                                } else {
                                    echo "<h1>NO Results</h1>";
                                }
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