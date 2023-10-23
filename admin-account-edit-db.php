<?php 
    session_start();
    $open_connect = 1;
    require('config.php');

    if(isset($_POST['update'])){
        $account_id = mysqli_real_escape_string($conn,$_POST['id_account']);
        $user_name = mysqli_real_escape_string($conn,$_POST['username_account']);
        $user_email = mysqli_real_escape_string($conn,$_POST['email_account']);
        $user_password = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['password_account1']));
        
        if(empty($user_name)){
            die(header('Location: form-register.php')); // ไม่ได้กรอกชื่อผู้ใช้
        }else if(empty($user_email) && ($email_account)){
            die(header('Location: form-register.php')); // ไม่ได้กรอกอีเมล
        }else if(empty($user_password)){
            die(header('Location: form-register.php')); // ไม่ได้รหัสผ่าน
        }else{
            $length = random_int(97, 128);
            $salt_account = bin2hex(random_bytes($length)); //สร้างค่าเกลือ
            $password_account1 = $user_password . $salt_account; //เอาหรัสผ่านต่อกับค่าเกลือ
            $algo = PASSWORD_ARGON2ID;
            $options = [
                'cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
                'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
                'thread' => PASSWORD_ARGON2_DEFAULT_THREADS
            ];
            $password_account = password_hash($password_account1, $algo, $options); //นำรหัสผ่านที่รวมค่าเกลือแล้ว เข้ารหัสด้วยวิธี ARGON2ID
            $sql = "UPDATE account SET username_account = '$user_name', email_account = '$user_email', password_account = '$password_account', salt_account = '$salt_account' WHERE id_account = $account_id";
            $result = mysqli_query($conn, $sql);

            if($result){ //แก้ไขสำเร็จ
                echo "<script type='text/javascript'>";
                echo "alert('แก้ไขสมาชิกเรียบร้อยแล้ว');";
                echo "window. location = 'admin.php';";
                echo "</script>"; 
            }else{ //แก้ไขไม่สำเร็จ
                echo $result;
            echo "<script type='text/javascript'>";
            echo "alert('มีบางอย่างผิดพลาด');";
            echo "window. location = 'admin.php';";
            echo "</script>"; 
        }
        }
        
    }
?>