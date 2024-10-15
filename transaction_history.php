<?php
session_start();
include 'db_connection.php';

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "Bạn chưa đăng nhập. Vui lòng đăng nhập để tiếp tục.";
    exit;
}

// Kiểm tra quyền truy cập (admin có thể xem bất kỳ lịch sử giao dịch nào, người dùng thường chỉ có thể xem của chính họ)
$user_id_from_session = $_SESSION['user_id'];
$role = $_SESSION['role'];

// HTML header
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử giao dịch</title>
    <link rel="stylesheet" href="style.css"> <!-- Liên kết đến file CSS -->
</head>
<body>
<div class="container">

<?php
// Lấy user_id từ URL (hoặc từ session nếu người dùng không phải là admin)
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Nếu người dùng không phải admin và đang cố xem lịch sử giao dịch của người khác
    if ($role != 'admin' && $user_id != $user_id_from_session) {
        echo "<p>Bạn không có quyền xem lịch sử giao dịch của người dùng khác.</p>";
        exit;
    }

    // Lấy lịch sử giao dịch của người dùng
    $query = "SELECT * FROM transactions WHERE user_id = ? ORDER BY transaction_date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Lịch sử giao dịch của người dùng ID: $user_id</h2>";
    echo "<table>";
    echo "<tr><th>ID Giao dịch</th><th>Loại giao dịch</th><th>Số tiền</th><th>Ngày giao dịch</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['transaction_type'] . "</td>";
        echo "<td>" . number_format($row['amount'], 2) . " VND</td>"; // Định dạng số tiền
        echo "<td>" . $row['transaction_date'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Nếu user_id không được truyền, hiển thị lịch sử giao dịch của chính người dùng đang đăng nhập
    $query = "SELECT * FROM transactions WHERE user_id = ? ORDER BY transaction_date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id_from_session);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Lịch sử giao dịch của bạn</h2>";
    echo "<table>";
    echo "<tr><th>ID Giao dịch</th><th>Loại giao dịch</th><th>Số tiền</th><th>Ngày giao dịch</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['transaction_type'] . "</td>";
        echo "<td>" . number_format($row['amount'], 2) . " VND</td>"; // Định dạng số tiền
        echo "<td>" . $row['transaction_date'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}
?>
</div>
</body>
</html>
