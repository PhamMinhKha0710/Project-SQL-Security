<?php
session_start();
include 'db_connection.php';

// Lấy user_id từ URL
$target_user_id = $_GET['user_id'];

// Lấy user_id và vai trò của người dùng hiện tại từ session
$current_user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
// $target_user_id = $current_user_id; // Người dùng sẽ xem thông tin tài khoản của chính họ




function isAdmin($role) {
    return $role === 'admin';
}

// Hàm kiểm tra xem người dùng có quyền cập nhật thông tin người dùng khác không
function canUpdateUser($current_user_id, $target_user_id, $role) {
    // Admin có thể cập nhật bất kỳ tài khoản nào
    if ($role === 'admin') {
        return true;
    }
    
    // Người dùng thông thường chỉ có thể cập nhật tài khoản của chính họ
    if ($role === 'user' && $current_user_id === $target_user_id) {
        return true;
    }

    // Các trường hợp còn lại, không có quyền
    return false;
}


// Hàm kiểm tra quyền truy cập lịch sử giao dịch
function canViewTransactionHistory($current_user_id, $target_user_id, $role) {
    // Nếu là admin, có thể xem tất cả các tài khoản
    if ($role === 'admin') {
        return true;
    }

    // Nếu là người dùng thông thường, chỉ có thể xem tài khoản của chính mình
    if ($role === 'user' && $current_user_id === $target_user_id) {
        return true;
    }

    // Trường hợp còn lại, không có quyền truy cập
    return false;
}

// Kiểm tra quyền truy cập
if (canViewTransactionHistory($current_user_id, $target_user_id, $role)) {
    // Truy vấn thông tin tài khoản và thông tin cá nhân của người dùng
    $query = "SELECT u.username, u.created_at, a.balance, u.full_name, u.address, u.phone_number, u.email FROM users u 
              JOIN accounts a ON u.id = a.user_id WHERE u.id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $target_user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_info = $result->fetch_assoc();

        if ($user_info) {
            // Kiểm tra và xử lý các giá trị rỗng
            $username = htmlspecialchars($user_info['username']);
            $created_at = htmlspecialchars($user_info['created_at']);
            $balance = number_format($user_info['balance'], 2) . " VND";
            $full_name = !empty($user_info['full_name']) ? htmlspecialchars($user_info['full_name']) : "Không có thông tin";
            $address = !empty($user_info['address']) ? htmlspecialchars($user_info['address']) : "Không có thông tin";
            $phone_number = !empty($user_info['phone_number']) ? htmlspecialchars($user_info['phone_number']) : "Không có thông tin";
            $email = !empty($user_info['email']) ? htmlspecialchars($user_info['email']) : "Không có thông tin";
        } else {
            echo "Không tìm thấy thông tin người dùng.";
            exit;
        }
    } else {
        echo "Lỗi truy vấn thông tin tài khoản.";
        exit;
    }
    // Truy vấn lịch sử giao dịch của người dùng
    $transaction_query = "SELECT transaction_type, amount, transaction_date FROM transactions WHERE user_id = ?";
    
    if ($transaction_stmt = $conn->prepare($transaction_query)) {
        $transaction_stmt->bind_param("i", $target_user_id);
        $transaction_stmt->execute();
        $transaction_result = $transaction_stmt->get_result();
    } else {
        echo "Lỗi truy vấn lịch sử giao dịch.";
        exit;
    }
    } else {
        echo "Bạn không có quyền truy cập vào lịch sử giao dịch này.";
        exit;
    }
    // Kiểm tra nếu phương thức là POST và người dùng có quyền cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST' && canUpdateUser($current_user_id, $target_user_id, $role)) {

    // Chỉ cho phép admin chỉnh sửa thông tin của người dùng
    if ($_SESSION['role'] === 'admin' || isAdmin($current_user_id, $target_user_id)) {
        // Lấy các thông tin mới từ form và làm sạch dữ liệu
        $new_full_name = htmlspecialchars($_POST['full_name']);
        $new_address = htmlspecialchars($_POST['address']);
        $new_phone_number = htmlspecialchars($_POST['phone_number']);
        $new_email = htmlspecialchars($_POST['email']);

        // Truy vấn cập nhật thông tin người dùng
        $update_query = "UPDATE users SET full_name = ?, address = ?, phone_number = ?, email = ? WHERE id = ?";

        if ($update_stmt = $conn->prepare($update_query)) {
            // Liên kết các tham số và thực thi câu lệnh
            $update_stmt->bind_param("ssssi", $new_full_name, $new_address, $new_phone_number, $new_email, $target_user_id);
            $update_stmt->execute();
            echo "Thông tin người dùng đã được cập nhật thành công!";

            // Ghi log hành động cập nhật thông tin
            $log_query = "INSERT INTO activity_logs (user_id, action, description) VALUES (?, ?, ?)";
            if ($log_stmt = $conn->prepare($log_query)) {
                $action = "Cập nhật thông tin cá nhân";
                $description = "Admin đã cập nhật thông tin người dùng: Họ tên: $new_full_name, Địa chỉ: $new_address, Số điện thoại: $new_phone_number, Email: $new_email.";
                $log_stmt->bind_param("iss", $current_user_id, $action, $description);
                $log_stmt->execute();
                $log_stmt->close();
            }

        } else {
            echo "Lỗi khi cập nhật thông tin.";
        }
    } else {
        echo "Bạn không có quyền chỉnh sửa thông tin người dùng này.";
    }
}



    
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết tài khoản - Hệ thống ngân hàng</title>
    <link rel="stylesheet" href="account.css">
    <style>
        .info-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .info-label {
            flex: 1;
            font-weight: bold;
            color: #333;
        }

        .info-value {
            flex: 2;
            padding: 5px;
        }

        .edit-button {
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #1f5a87;
        }

        .input-edit {
            display: none;
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .save-button {
            background-color: green;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: none;
        }

        .save-button:hover {
            background-color: darkgreen;
        }

        /* Style for success message */
        .success-message {
            display: none;
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }
    </style>
</head>
<body class="account-page">
    <div class="container">
        <h1>Thông tin tài khoản của <?php echo $username; ?></h1>

        <!-- Thông báo cập nhật thành công -->
        <div id="successMessage" class="success-message">Cập nhật thông tin thành công!</div>

        <h2>Thông tin cá nhân</h2>

        <!-- Họ tên -->
        <div class="info-group">
            <div class="info-label">Họ tên:</div>
            <div class="info-value">
                <span id="full_name_display"><?php echo $full_name; ?></span>
                <input type="text" id="full_name_input" class="input-edit" value="<?php echo $full_name; ?>">
            </div>
            <button class="edit-button" onclick="editField('full_name')">Chỉnh sửa</button>
            <button class="save-button" id="full_name_save" onclick="saveField('full_name')">Lưu</button>
        </div>

        <!-- Địa chỉ -->
        <div class="info-group">
            <div class="info-label">Địa chỉ:</div>
            <div class="info-value">
                <span id="address_display"><?php echo $address; ?></span>
                <input type="text" id="address_input" class="input-edit" value="<?php echo $address; ?>">
            </div>
            <button class="edit-button" onclick="editField('address')">Chỉnh sửa</button>
            <button class="save-button" id="address_save" onclick="saveField('address')">Lưu</button>
        </div>

        <!-- Số điện thoại -->
        <div class="info-group">
            <div class="info-label">Số điện thoại:</div>
            <div class="info-value">
                <span id="phone_number_display"><?php echo $phone_number; ?></span>
                <input type="text" id="phone_number_input" class="input-edit" value="<?php echo $phone_number; ?>">
            </div>
            <button class="edit-button" onclick="editField('phone_number')">Chỉnh sửa</button>
            <button class="save-button" id="phone_number_save" onclick="saveField('phone_number')">Lưu</button>
        </div>

        <!-- Email -->
        <div class="info-group">
            <div class="info-label">Email:</div>
            <div class="info-value">
                <span id="email_display"><?php echo $email; ?></span>
                <input type="email" id="email_input" class="input-edit" value="<?php echo $email; ?>">
            </div>
            <button class="edit-button" onclick="editField('email')">Chỉnh sửa</button>
            <button class="save-button" id="email_save" onclick="saveField('email')">Lưu</button>
        </div>

        <h2>Thông tin tài khoản</h2>
        <p><strong>Số dư hiện tại:</strong> <?php echo $balance; ?></p>

        <h2>Lịch sử giao dịch</h2>
        <?php if ($transaction_result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Loại giao dịch</th>
                        <th>Số tiền</th>
                        <th>Ngày giao dịch</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($transaction = $transaction_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['transaction_type']); ?></td>
                            <td><?php echo number_format($transaction['amount'], 2) . " VND"; ?></td>
                            <td><?php echo htmlspecialchars($transaction['transaction_date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không có giao dịch nào được tìm thấy.</p>
        <?php endif; ?>
    </div>

    <script>
        function editField(fieldId) {
            document.getElementById(fieldId + '_display').style.display = 'none';
            document.getElementById(fieldId + '_input').style.display = 'inline-block';
            document.getElementById(fieldId + '_save').style.display = 'inline-block';
        }

        function saveField(fieldId) {
            var input = document.getElementById(fieldId + '_input').value;
            document.getElementById(fieldId + '_display').textContent = input;
            document.getElementById(fieldId + '_display').style.display = 'inline-block';
            document.getElementById(fieldId + '_input').style.display = 'none';
            document.getElementById(fieldId + '_save').style.display = 'none';

            // Hiển thị thông báo thành công sau khi lưu
            document.getElementById('successMessage').style.display = 'block';

            // Tự động ẩn thông báo sau 3 giây
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'none';
            }, 3000);

            // AJAX để gửi thông tin cập nhật về máy chủ
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_user.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("field=" + fieldId + "&value=" + input);

            // Ghi log ngay khi người dùng thực hiện thao tác
            var logXhr = new XMLHttpRequest();
            logXhr.open("POST", "log_action.php", true);
            logXhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            logXhr.send("action=update&description=Cập nhật " + fieldId + " với giá trị mới: " + input);


            // Handle server response
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log(xhr.responseText); // Optional: Display server response for debugging
                } else {
                    console.error("Failed to update user information.");
                }
            };
        }
    </script>
</body>
</html>


