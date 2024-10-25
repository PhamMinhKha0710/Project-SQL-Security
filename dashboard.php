<?php
session_start();
include 'db_connection.php';

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login_handler.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chính - Hệ thống ngân hàng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
    <div class="container">
        <h1>Chào mừng, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

        <h2>Tài khoản của bạn:</h2>
        <a href="account.php?user_id=<?php echo $_SESSION['user_id']; ?>">Truy cập tài khoản của bạn</a><br><br>

        <h2>Chức năng</h2>
        <ul>
            <li><a href="withdraw.php">Rút tiền</a></li>
            <li><a href="deposit.php">Nạp tiền</a></li> <!-- Thêm liên kết Nạp tiền -->
            <li><a href="transaction_history.php">Xem lịch sử giao dịch</a></li>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <li><a href="admin_dashboard.php">Trang quản trị</a></li>
            <?php endif; ?>
        </ul>

        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
