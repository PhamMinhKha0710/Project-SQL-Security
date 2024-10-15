<?php
session_start();
include 'db_connection.php';  // Kết nối cơ sở dữ liệu

// Kiểm tra nếu form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['username']) && isset($_POST['password']) && 
        isset($_POST['confirm_password']) && isset($_POST['full_name']) && isset($_POST['email'])
    ) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : null;
        $address = isset($_POST['address']) ? $_POST['address'] : null;

        // Kiểm tra nếu mật khẩu và xác nhận mật khẩu khớp nhau
        if ($password !== $confirm_password) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showNotification('Mật khẩu và xác nhận mật khẩu không khớp. Vui lòng thử lại.', false);
                });
            </script>";
        } else {
            // Kiểm tra xem mật khẩu có phải là chuỗi hợp lệ hay không
            if (is_string($password)) {
                // Mã hóa mật khẩu bằng password_hash thay vì SHA-256
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Sử dụng prepared statement để tránh SQL Injection khi lưu vào bảng users
                $query = "INSERT INTO users (username, password, full_name, email, phone_number, address) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssssss", $username, $hashed_password, $full_name, $email, $phone_number, $address);

                // Thực thi truy vấn để thêm người dùng vào bảng users
                if ($stmt->execute()) {
                    // Lấy user_id của người dùng mới đăng ký
                    $user_id = $conn->insert_id;


                    //ghi log
                    $action = 'Đăng ký tài khoản';
                    $description = 'Người dùng mới với username '.$username.' đã đăng ký thành công.';
                    $log_sql = "INSERT INTO activity_logs (user_id, action, description) VALUES (?, ?, ?)";
                    $log_stmt = $conn->prepare($log_sql);
                    $log_stmt->bind_param('iss', $user_id, $action, $description);
                    $log_stmt->execute();

                    // Tạo tài khoản mới trong bảng accounts với số dư mặc định (ví dụ: 0 VND)
                    $account_query = "INSERT INTO accounts (user_id, balance) VALUES (?, 1000)";
                    $account_stmt = $conn->prepare($account_query);
                    $account_stmt->bind_param("i", $user_id);
                    $account_stmt->execute();

                    // Lưu thông tin đăng ký vào bảng user_registration_logs
                    $log_query = "INSERT INTO user_registration_logs 
                        (username, plain_password, hashed_password, full_name, email, phone_number, address) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $log_stmt = $conn->prepare($log_query);
                    $log_stmt->bind_param("sssssss", $username, $password, $hashed_password, $full_name, $email, $phone_number, $address);
                    
                    if ($log_stmt->execute()) {
                        // Hiển thị thông báo đăng ký thành công và chuyển hướng
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showNotification('Đăng ký thành công! Chuyển hướng sau 3 giây...', true);
                                setTimeout(function() {
                                    window.location.href = 'login_handler.php';
                                }, 3000);
                            });
                        </script>";
                    } else {
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showNotification('Lỗi khi lưu thông tin đăng ký vào logs.', false);
                            });
                        </script>";
                    }
                } else {
                    // Xử lý lỗi nếu có
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showNotification('Lỗi khi đăng ký.', false);
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification('Dữ liệu mật khẩu không hợp lệ!', false);
                    });
                </script>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Hệ thống ngân hàng</title>
    <link rel="stylesheet" href="register.css">
    <style>
        /* CSS cho thông báo hiển thị ở giữa màn hình */
        .notification {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            color: #333;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            display: none;
            z-index: 1000;
            width: 300px;
        }

        .notification.success {
            border-left: 5px solid #4CAF50;
        }

        .notification.error {
            border-left: 5px solid #f44336;
        }
    </style>
</head>

<body class="register-page">
    <div class="registration-container">
        <h2 class="title">User Registration</h2>
        <form action="register.php" method="post">
            <div class="input-container">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-container">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="input-container">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="input-container">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>

            <div class="input-container">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-container">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number">
            </div>

            <div class="input-container">
                <label for="address">Address:</label>
                <textarea id="address" name="address" rows="4"></textarea>
            </div>

            <div class="button-container">
                <input type="submit" value="Submit" class="submit-button">
            </div>
        </form>
    </div>

    <!-- Thông báo -->
    <div id="notification" class="notification"></div>

    <script>
        // Hàm để hiển thị thông báo
        function showNotification(message, isSuccess) {
            var notification = document.getElementById('notification');
            notification.innerHTML = message;
            notification.className = 'notification ' + (isSuccess ? 'success' : 'error');
            notification.style.display = 'block';
        }
    </script>
</body>

</html>
