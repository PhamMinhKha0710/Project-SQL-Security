<!-- admin_transaction_history.php -->
<?php
session_start();
include 'db_connection.php';  // Kết nối cơ sở dữ liệu

// Kiểm tra xem admin đã đăng nhập chưa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo "Bạn cần đăng nhập với quyền admin để xem lịch sử giao dịch.";
    exit;
}

// Lấy tất cả giao dịch từ cơ sở dữ liệu
$query = "SELECT t.*, u.username FROM transactions t JOIN users u ON t.user_id = u.id ORDER BY t.transaction_date DESC";
$result = $conn->query($query);

echo "<h2>Lịch sử giao dịch trong hệ thống:</h2>";
echo "<table border='1'>";
echo "<tr><th>ID Giao dịch</th><th>Người dùng</th><th>Loại giao dịch</th><th>Số tiền</th><th>Ngày giao dịch</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['transaction_type'] . "</td>";
    echo "<td>" . $row['amount'] . "</td>";
    echo "<td>" . $row['transaction_date'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
