<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rút tiền</title>
    <link rel="stylesheet" href="admin_withdraw.css"> <!-- Include this CSS file -->
</head>
<body>
    <div class="container">
        <h2>Rút tiền từ tài khoản người dùng</h2>
        <form action="admin_withdraw_handler.php" method="post" class="withdraw-form">
            <div class="form-group">
                <label for="user_id">Chọn người dùng:</label>
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
                </select>
            </div>

            <div class="form-group">
                <label for="amount">Số tiền cần rút:</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
            </div>

            <input type="submit" value="Rút tiền" class="submit-btn">
        </form>
    </div>
</body>
</html>
