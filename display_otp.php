<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login_handler.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_otp'])) {
    include 'db_connection.php';

    $user_id = $_SESSION['user_id'];
    $entered_full_name = $_POST['full_name'];

    // Kiểm tra full_name và username từ cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT full_name, username FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($full_name, $username);
    $stmt->fetch();

    // Kiểm tra nếu full_name đúng và user là admin (giả sử admin có username là 'admin')
    if ($entered_full_name == $full_name && $username == 'admin') {
        // Tạo mã OTP và lưu vào session
        $otp_code = rand(100000, 999999);
        $_SESSION['otp_code'] = $otp_code;

        // Hiển thị mã OTP và form nhập OTP
        $_SESSION['otp_verified'] = true; // Đánh dấu đã yêu cầu OTP thành công
    } else {
        echo "<p>Thông tin không khớp hoặc bạn không phải là admin.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];

    // Kiểm tra mã OTP từ session
    if (isset($_SESSION['otp_code']) && $entered_otp == $_SESSION['otp_code']) {
        // Xác minh thành công, cho phép truy cập trang admin
        unset($_SESSION['otp_code']); // Xóa mã OTP khỏi session
        unset($_SESSION['otp_verified']); // Xóa đánh dấu xác thực OTP
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<p>Mã OTP không chính xác. Vui lòng thử lại.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu cầu OTP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
        }
        h1, h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            margin-bottom: 10px;
            font-size: 14px;
            color: #555;
        }
        .input-box {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .btn:hover {
            background-color: #45a049;
        }
        p {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    // Nếu đã yêu cầu OTP thành công, chỉ hiển thị form nhập OTP
    if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true) {
        echo "<h1>Mã OTP của bạn là: " . $_SESSION['otp_code'] . "</h1>";
        echo '
        <form method="POST" action="" class="form">
            <label>Nhập mã OTP:</label>
            <input type="text" name="otp" required class="input-box">
            <button type="submit" name="verify_otp" class="btn">Xác minh</button>
        </form>';
    } else {
        // Hiển thị form yêu cầu mã OTP (full_name)
        echo '
        <form method="POST" action="" class="form">
            <h2>Yêu cầu mã OTP</h2>
            <label>Nhập họ tên đầy đủ (full name):</label>
            <input type="text" name="full_name" required class="input-box">
            <button type="submit" name="request_otp" class="btn">Yêu cầu cấp OTP</button>
        </form>';
    }
    ?>
</div>

</body>
</html>
