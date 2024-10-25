<?php
session_start();
include 'db_connection.php';  // Kết nối cơ sở dữ liệu

// Kiểm tra xem admin đã đăng nhập chưa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo "Bạn cần đăng nhập với quyền admin để thực hiện giao dịch này.";
    exit;
}

// Lấy thông tin từ form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];

    // Kiểm tra số tiền hợp lệ
    if ($amount <= 0) {
        echo "Số tiền cần rút phải lớn hơn 0.";
        exit;
    }

    // Lấy thông tin tài khoản của người dùng từ cơ sở dữ liệu
    $query = "SELECT balance FROM accounts WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $account = $result->fetch_assoc();

    // Kiểm tra xem tài khoản có đủ số dư để rút hay không
    if ($account['balance'] < $amount) {
        echo "Số dư không đủ để thực hiện giao dịch.";
        exit;
    }

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

    echo "Admin đã rút tiền thành công từ tài khoản người dùng. Số dư còn lại: " . $new_balance;
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
<!-- admin_withdraw.php -->
<h2>Rút tiền từ tài khoản người dùng</h2>
<form action="admin_withdraw_handler.php" method="post">
    <link rel="stylesheet" href="admin_withdraw.css">
    <label for="user_id">Chọn người dùng:</label><br>
    <select id="user_id" name="user_id">
        <?php
        // Lấy danh sách tất cả người dùng
        include 'db_connection.php';
        $query = "SELECT id, username FROM users";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
        }
        ?>
    </select><br><br>

    <label for="amount">Số tiền cần rút:</label><br>
    <input type="number" id="amount" name="amount" step="0.01" required><br><br>
    <input type="submit" value="Rút tiền">
</form>
