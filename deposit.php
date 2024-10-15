<?php
session_start();
include 'db_connection.php';

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login_handler.php");
    exit;
}

// Xử lý khi form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];

    // Kiểm tra số tiền nạp có hợp lệ hay không
    if ($amount <= 0) {
        $error = "Số tiền nạp phải lớn hơn 0.";
    } else {
        // Nạp tiền vào tài khoản người dùng
        $user_id = $_SESSION['user_id'];
        $query = "UPDATE accounts SET balance = balance + ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("di", $amount, $user_id);

        //ghi log
        $action = 'Nạp tiền';
        $description = 'Người dùng '.$user_id.' đã nạp '.$amount.' vào tài khoản.';
        $log_sql = "INSERT INTO activity_logs (user_id, action, description) VALUES (?, ?, ?)";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->bind_param('iss', $user_id, $action, $description);
        $log_stmt->execute();
        
        if ($stmt->execute()) {
            $success = "Nạp tiền thành công!";
        } else {
            $error = "Lỗi khi nạp tiền.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nạp tiền - Hệ thống ngân hàng</title>
    <link rel="stylesheet" href="deposit.css"> <!-- Đường dẫn tới file CSS -->
</head>
<body class="deposit-page">
    <div class="deposit-container">
        <h2>Nạp tiền vào tài khoản của bạn</h2>

        <!-- Hiển thị thông báo lỗi hoặc thành công -->
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif (isset($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form action="deposit.php" method="post">
            <label for="amount">Số tiền cần nạp:</label>
            <input type="number" id="amount" name="amount" step="0.01" required placeholder="Nhập số tiền cần nạp">
            <input type="submit" value="Nạp tiền" class="deposit-button">
        </form>
    </div>
</body>
</html>
