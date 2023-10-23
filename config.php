<?php

if($open_connect != 1){
    die(header('Location: login.php'));
}

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "ppluspro";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $database, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    mysqli_set_charset($conn, 'utf8');
    $limit_login_account = 5; // จำนวนครั้งที่กรอกรหัสผ่านผิด
    $time_ban_account = 1; //จำนวนนาทีที่ระงับบัญชี
    $query_reset_ban_account = "UPDATE account SET lock_account = 0, login_count_account = 0 WHERE ban_account <= NOW() AND login_count_account >= '$limit_login_account'";
    $call_back_reset_ban_account = mysqli_query($conn, $query_reset_ban_account);
}
?>