<?php
session_start();
include 'db_connection.php';  // Kết nối cơ sở dữ liệu

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo "Bạn cần đăng nhập trước khi thực hiện rút tiền.";
    exit;
}

// Xử lý khi form được submit (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $user_id = $_SESSION['user_id'];

    // Kiểm tra số tiền hợp lệ
    if ($amount <= 0) {
        $error = "Số tiền cần rút phải lớn hơn 0.";
    } else {
        // Lấy thông tin tài khoản của người dùng từ cơ sở dữ liệu
        $query = "SELECT balance FROM accounts WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $account = $result->fetch_assoc();

        // Kiểm tra xem tài khoản có đủ số dư để rút hay không
        if ($account['balance'] < $amount) {
            $error = "Số dư không đủ để thực hiện giao dịch.";
        } else {
            // Trừ số tiền từ tài khoản
            $new_balance = $account['balance'] - $amount;
            $update_query = "UPDATE accounts SET balance = ? WHERE user_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("di", $new_balance, $user_id);
            $stmt->execute();



            // Lưu giao dịch vào bảng transactions
            $transaction_query = "INSERT INTO transactions (user_id, transaction_type, amount) VALUES (?, 'withdraw', ?)";
            $stmt = $conn->prepare($transaction_query);
            $stmt->bind_param("id", $user_id, $amount);
            $stmt->execute();


            //ghi log
            $action = 'Rút tiền';
            $description = 'Người dùng ' . $_SESSION['user_id'] . ' đã rút ' . $amount . ' từ tài khoản.';
            $log_sql = "INSERT INTO activity_logs (user_id, action, description) VALUES (?, ?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param('iss', $user_id, $action, $description);
            $log_stmt->execute();

            $success = "Giao dịch rút tiền thành công. Số dư còn lại: " . number_format($new_balance, 2) . " VND";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rút tiền - Hệ thống ngân hàng</title>
    <link rel="stylesheet" href="withdraw.css"> <!-- Thêm đường dẫn tới file CSS -->
</head>
<body class="withdraw-handler">
    <div class="withdraw-container">
        <h2>Rút tiền từ tài khoản của bạn</h2>

        <!-- Hiển thị thông báo lỗi hoặc thành công -->
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php elseif (isset($success)): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="withdraw_handler.php" method="post">
            <label for="amount">Số tiền cần rút:</label>
            <input type="number" id="amount" name="amount" step="0.01" required placeholder="Nhập số tiền cần rút">
            <input type="submit" value="Rút tiền" class="withdraw-button">
        </form>
    </div>
</body>
</html>