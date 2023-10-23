<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login-register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;700&display=swap"
        rel="stylesheet">
    <title>Register</title>
</head>
<body>
    <div class="header">
    <div class="login-container">
        <div><img src="RedStore_Img/images/ppluslogo-white.png" width="180px" height="180px"></div>
        <h2>สร้างบัญชีของคุณ</h2>
        <form action="process-register.php" method="post">
            <div class="register-form">
                <input type="text" name="username_account" id="" placeholder="User name" required> <br><br>
                <input type="text" name="email_account" id="" placeholder="Email" required><br><br>
                <input type="password" name="password_account1" id="" placeholder="Password" required><br><br>
                <input type="password" name="password_account2" id="" placeholder="Confirm password" required><br><br>
            </div><br><br>
            <button>สร้างบัญชีใหม่</button><br><br>
            <a href="login.php">มีบัญชีอยู่แล้วใช่ไหม?</a>
        </form>
    </div>
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