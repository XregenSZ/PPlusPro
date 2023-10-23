<?php

$open_connect = 1;
require('config.php');

if(isset($_POST['username_account']) && isset($_POST['email_account']) && isset($_POST['password_account1']) && isset($_POST['password_account2'])){
    $username_account = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['username_account']));
    $email_account = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email_account'])); 
    $password_account1 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password_account1'])); 
    $password_account2 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password_account2']));

    if(empty($username_account)){
        die(header('Location: form-register.php')); // ไม่ได้กรอกชื่อผู้ใช้
    }else if(empty($email_account) && ($email_account)){
        die(header('Location: form-register.php')); // ไม่ได้กรอกอีเมล
    }else if(empty($password_account1)){
        die(header('Location: form-register.php')); // ไม่ได้รหัสผ่าน
    }else if(empty($password_account2)){
        die(header('Location: form-register.php')); // ไม่ได้กรอกยืนยันรหัสผ่าน
    }else if($password_account1 != $password_account2){
        die(header('Location: register.php'));
    }else{
        $query_check_email_account = "SELECT email_account FROM account WHERE email_account = '$email_account'";
        $call_back_query_check_email_account = mysqli_query($conn, $query_check_email_account);
        if(mysqli_num_rows($call_back_query_check_email_account) > 0){
            die(header('Location : register.html')); //มีผู้ใช้อีเมลนี้แล้ว
        }else{
            $length = random_int(97, 128);
            $salt_account = bin2hex(random_bytes($length)); //สร้างค่าเกลือ
            $password_account1 = $password_account1 . $salt_account; //เอาหรัสผ่านต่อกับค่าเกลือ
            $algo = PASSWORD_ARGON2ID;
            $options = [
                'cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
                'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
                'thread' => PASSWORD_ARGON2_DEFAULT_THREADS
            ];
            $password_account = password_hash($password_account1, $algo, $options); //นำรหัสผ่านที่รวมค่าเกลือแล้ว เข้ารหัสด้วยวิธี ARGON2ID
            $query_create_account = "INSERT INTO account VALUES ('','$username_account','$email_account','$password_account','$salt_account','member','default_image_account.jpg','','','')";
            $call_back_create_account = mysqli_query($conn, $query_create_account);
            if($call_back_create_account){ //สมัครสมาชิกสำเร็จ
                echo "<script type='text/javascript'>";
                echo "alert('สมัครสมาชิกเรียบร้อยแล้ว');";
                echo "window. location = 'login.php';";
                echo "</script>";
            }else{ // error
                echo "<script type='text/javascript'>";
                echo "alert('ไม่สามารถสมัครสมาชิกได้');";
                echo "window. location = 'register.php';";
                echo "</script>";
            }
        }
    }
} else {
    die(header('Location: register.html')); // ไม่มีข้อมูล
};