<?php
session_start();
$open_connect = 1;
require('config.php');

if (isset($_POST['email_account']) && isset($_POST['password_account'])) {
    $email_account = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email_account']));
    $password_account = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password_account']));
    $query_check_account = "SELECT * FROM account WHERE email_account = '$email_account'";
    $call_back_check_account = mysqli_query($conn, $query_check_account);
    if (mysqli_num_rows($call_back_check_account) == 1) {
        $result_check_account = mysqli_fetch_assoc($call_back_check_account);
        $hash = $result_check_account['password_account'];
        $password_account = $password_account . $result_check_account['salt_account'];
        $count = $result_check_account['login_count_account'];
        $ban = $result_check_account['ban_account'];

        if ($result_check_account['lock_account'] == 1) { //เช็ค account lock
            echo '<h1>บัญชีนี้ถูกระงับชั่วคราว</h1>';
            echo "<h2>ระงับบัญชีนี้เป็นเวลา $time_ban_account นาที เพราะ ผู้ใช้กรอกรหัสผ่านผิดจำนวน $count ครั้ง</h2>";
            echo "<h2>บัญชีนี้จะถูกปลดระงับเมื่อถึงเวลา $ban</h2>";
            echo '<a href="login.php">กลับไปหน้าสู่ระบบ</a>';
        } elseif (password_verify($password_account, $hash)) {
            $query_reset_login_count_account = "UPDATE account SET login_count_account = 0 WHERE email_account = '$email_account'"; //login สำเร็จ reset ค่า login
            $call_back_reset = mysqli_query($conn, $query_reset_login_count_account);
            if ($result_check_account['role_account'] == 'member') { // member role
                $_SESSION['id_account'] = $result_check_account['id_account'];
                $_SESSION['role_account'] = $result_check_account['role_account'];
                die(header('Location: index.php'));
            } elseif ($result_check_account['role_account'] == 'admin') {
                $_SESSION['id_account'] = $result_check_account['id_account']; // admin role
                $_SESSION['role_account'] = $result_check_account['role_account'];
                die(header('Location: admin.php'));
            }
        } else {
            $query_login_count_account = "UPDATE account SET login_count_account = login_count_account + 1 WHERE email_account = '$email_account'"; //รหัสผ่านผิด +1
            $call_back_login_count_account = mysqli_query($conn, $query_login_count_account);
            if ($result_check_account['login_count_account'] + 1 >= $limit_login_account) { // login เกินลิมิต 5 ครั้ง ทำการ lock account
                $query_lock_account = "UPDATE account SET lock_account = 1, ban_account = DATE_ADD(NOW(), INTERVAL $time_ban_account MINUTE) WHERE email_account = '$email_account'";
                $call_back_lock_account = mysqli_query($conn, $query_lock_account);
                echo $query_lock_account;
                echo $call_back_lock_account;
            } //รหัสผ่านผิด
            echo "<script type='text/javascript'>";
            echo "alert('รหัสผ่านไม่ถูกต้อง');";
            echo "window. location = 'login.php';";
            echo "</script>";
        }
    } else { //ไม่มี email นี้ในระบบ
        echo "<script type='text/javascript'>";
        echo "alert('ไม่มี email นี้ในระบบ');";
        echo "window. location = 'admin.php';";
        echo "</script>";
    }
} else { //ไม่ได้กรอกข้อมูล
    echo "<script type='text/javascript'>";
    echo "alert('กรุณากรอกข้อมูล');";
    echo "window. location = 'admin.php';";
    echo "</script>";
}
