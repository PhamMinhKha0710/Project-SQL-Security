<?php
session_start();
include 'db_connection.php';  // Kết nối cơ sở dữ liệu

// Kiểm tra nếu form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

    //    //Truy vấn SQL không an toàn để kiểm thử SQL Injection
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        

        // Thực thi truy vấn
        $result = $conn->query($query);


       // tan con ban cach rest password
        // $query = "SELECT * FROM users WHERE username = '$username'; UPDATE users SET password='newpassword' WHERE username='user1';";

        // if ($conn->multi_query($query)) {
        //     do {
        //         if ($result = $conn->store_result()) {
        //             // Xử lý kết quả của SELECT
        //             while ($row = $result->fetch_assoc()) {
        //                 // Xử lý kết quả của SELECT
        //             }
        //             $result->free();
        //         } else {
        //             // Nếu không phải câu lệnh SELECT, chỉ cần kiểm tra lỗi
        //             if ($conn->errno) {
        //                 echo "Lỗi: " . $conn->error;
        //             }
        //         }
        //     } while ($conn->next_result());
        // }
        



        //protect bien gia tri 'or 1=1 -- thanh mot string thong thuong select * from user where username = ? and password = ? -> select * from user where username = ''or 1=1 -- ' and password = '?'
        //Truy vấn SQL an toàn bằng cách sử dụng prepared statement
        // $query = "SELECT * FROM users WHERE username = ? AND password = ?";
        // $stmt = $conn->prepare($query);
        // // Liên kết các tham số (s = string, i = integer, d = double, b = blob) 
        // $stmt->bind_param("ss", $username, $password);
        // $stmt->execute();
        // $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Người dùng tồn tại
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Truy vấn lấy vai trò của user
            $roleQuery = "SELECT r.role_name FROM roles r 
                          JOIN user_roles ur ON r.id = ur.role_id 
                          WHERE ur.user_id = ?";
            $stmt = $conn->prepare($roleQuery);
            $stmt->bind_param("i", $user['id']);
            $stmt->execute();
            $roleResult = $stmt->get_result();
            $role = $roleResult->fetch_assoc();
            $_SESSION['role'] = $role['role_name'];
            //ghi log 
            $action = 'Đăng nhập';
                $description = 'Người dùng '.$user['username'].' đã đăng nhập thành công.';
                $log_sql = "INSERT INTO activity_logs (user_id, action, description) VALUES (?, ?, ?)";
                $log_stmt = $conn->prepare($log_sql);
                $log_stmt->bind_param('iss', $user['id'], $action, $description);
                $log_stmt->execute();

            // Kiểm tra quyền và điều hướng
            // if ($_SESSION['role'] === 'admin' && $user['is_2fa_enabled'] == 1) {
            //     header("Location: otp_verification.php");
            //     exit();
            // } else {
            //     if ($_SESSION['role'] === 'admin'){
            //         header("Location: admin_dashboard.php");
            //     }else{
            //         header("Location: dashboard.php");
            //     }
            //     exit();
            // }
            //
            if ($_SESSION['role'] === 'admin') {
                $otp_code = rand(100000, 999999);
                $_SESSION['otp_code'] = $otp_code;
                header("Location: display_otp.php");//nhảy vô trang otp, trang otp xử lý đk $user['is_2fa_enabled'] == 1
            } else {
                header("Location: dashboard.php");   
            }
        } else {
            echo "Tenn Nguoi Dung Hoac Mat Khau Khong Dung. Vui Long Thu Lai.";
        }
    } else {
        header("Location: error.php");
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hệ thống ngân hàng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class ="login-page">
    <h2></h2>
    <form action="login_handler.php" method="post">
        <label for="username">Tên đăng nhập:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Đăng nhập">
        <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
    </form>
</body>
</html>
