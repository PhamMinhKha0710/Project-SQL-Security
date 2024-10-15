<?php
session_start();
include 'db_connection.php';

// Kiểm tra nếu admin đã đăng nhập và có quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_handler.php");
    exit;
}

// Chức năng xóa người dùng (chỉ admin mới có quyền)
if (isset($_POST['delete_user_id'])) {
    $target_user_id = $_POST['delete_user_id']; // Lấy ID người dùng từ form
    $admin_id = $_SESSION['user_id']; // Lấy ID của admin từ session

    // Kiểm tra xem ID người dùng có hợp lệ không
    if (!empty($target_user_id) && is_numeric($target_user_id)) {
        // Kiểm tra xem người dùng có tồn tại không
        $check_query = "SELECT * FROM users WHERE id = ?";
        if ($check_stmt = $conn->prepare($check_query)) {
            $check_stmt->bind_param("i", $target_user_id);
            $check_stmt->execute();
            $result = $check_stmt->get_result();

            if ($result->num_rows > 0) {
                // Nếu người dùng tồn tại, tiếp tục xóa
                $delete_query = "DELETE FROM users WHERE id = ?";
                if ($delete_stmt = $conn->prepare($delete_query)) {
                    $delete_stmt->bind_param("i", $target_user_id);
                    if ($delete_stmt->execute()) {
                        // Ghi log vào bảng activity_logs
                        $log_query = "INSERT INTO activity_logs (user_id, action, description) VALUES (?, ?, ?)";
                        if ($log_stmt = $conn->prepare($log_query)) {
                            $action = "Xóa người dùng";
                            $description = "Admin đã xóa người dùng có ID: " . $target_user_id;
                            $log_stmt->bind_param("iss", $admin_id, $action, $description);
                            $log_stmt->execute();
                            $log_stmt->close();
                        }

                        header("Location: admin_dashboard.php?message=success"); // Chuyển hướng với thông báo thành công
                        exit();
                    } else {
                        header("Location: admin_dashboard.php?message=error"); // Chuyển hướng với thông báo lỗi
                        exit();
                    }
                    $delete_stmt->close();
                } else {
                    header("Location: admin_dashboard.php?message=query_error"); // Lỗi khi chuẩn bị truy vấn
                    exit();
                }
            } else {
                // Người dùng không tồn tại
                header("Location: admin_dashboard.php?message=user_not_found");
                exit();
            }
        }
        $check_stmt->close();
    } else {
        header("Location: admin_dashboard.php?message=invalid_id"); // ID không hợp lệ
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng điều khiển Admin - Hệ thống ngân hàng</title>
    <link rel="stylesheet" href="style.css"> <!-- Đường dẫn tới file CSS -->
    <style>
        /* Các thiết lập chung */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0; /* Màu nền trung tính */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #004080;
            text-align: center;
            margin-bottom: 20px;
            font-size: 36px;
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        /* Các thiết lập bảng */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f8f8;
            color: #333;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Các thiết lập nút */
        .action-button {
            padding: 10px 18px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 4px 2px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }

        /* Màu sắc nút theo chức năng */
        .account-button {
            background-color: #004080;
            color: white;
        }

        .account-button:hover {
            background-color: #0073e6;
        }

        .transaction-button {
            background-color: #1abc9c;
            color: white;
        }

        .transaction-button:hover {
            background-color: #16a085;
        }

        .withdraw-button {
            background-color: #f39c12;
            color: white;
        }

        .withdraw-button:hover {
            background-color: #e67e22;
        }

        .delete-button {
            background-color: #e74c3c;
            color: white;
        }

        .delete-button:hover {
            background-color: #c0392b;
        }

        /* Nút Đăng xuất */
        .logout-button {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: block;
            width: 150px;
            text-align: center;
            margin: 30px auto 0;
            font-size: 16px;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        /* Cải thiện trải nghiệm người dùng */
        .container {
            padding: 30px;
        }

        /* Media Queries cho thiết kế đáp ứng */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            table, th, td {
                font-size: 14px;
            }

            .action-button {
                padding: 8px 12px;
                font-size: 12px;
            }

            .logout-button {
                padding: 8px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body class="admin-page">
    <div class="container">
        <header>
            <h1>Bảng điều khiển Admin</h1>
        </header>

        <h2>Danh sách tất cả các tài khoản:</h2>

        <table>
            <thead>
                <tr>
                    <th>Tên tài khoản</th>
                    <th>Truy cập tài khoản</th>
                    <th>Lịch sử giao dịch</th>
                    <th>Thao tác rút tiền</th>
                    <th>Xóa người dùng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Truy vấn danh sách người dùng
                $query = "SELECT * FROM users";
                $result = $conn->query($query);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td><a href='account.php?user_id=" . $row['id'] . "' class='action-button account-button'>Truy cập tài khoản</a></td>";
                    echo "<td><a href='transaction_history.php?user_id=" . $row['id'] . "' class='action-button transaction-button'>Xem lịch sử giao dịch</a></td>";
                    echo "<td><a href='admin_withdraw.php?user_id=" . $row['id'] . "' class='action-button withdraw-button'>Thao tác rút tiền</a></td>";
                    
                    // Form xóa người dùng
                    echo "<td>
                            <form method='post' action=''>
                                <input type='hidden' name='delete_user_id' value='" . $row['id'] . "'>
                                <button type='submit' class='action-button delete-button'>Xóa</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Nút Đăng xuất nằm dưới cùng của trang -->
        <a href="logout.php" class="logout-button">Đăng xuất</a>
    </div>

    <!-- Div thông báo -->
    <div id="notification" class="notification">
        <!-- Nội dung thông báo sẽ thay đổi -->
    </div>

    <script>
        // Kiểm tra URL để hiển thị thông báo
        const urlParams = new URLSearchParams(window.location.search);
        const message = urlParams.get('message');
        const notificationDiv = document.getElementById('notification');

        if (message) {
            if (message === 'success') {
                notificationDiv.textContent = "Người dùng đã được xóa thành công!";
                notificationDiv.classList.add('show');
            } else if (message === 'error') {
                notificationDiv.textContent = "Lỗi khi xóa người dùng.";
                notificationDiv.classList.add('show', 'error');
            } else if (message === 'invalid_id') {
                notificationDiv.textContent = "ID người dùng không hợp lệ.";
                notificationDiv.classList.add('show', 'error');
            } else if (message === 'query_error') {
                notificationDiv.textContent = "Lỗi khi chuẩn bị truy vấn.";
                notificationDiv.classList.add('show', 'error');
            } else if (message === 'user_not_found') {
                notificationDiv.textContent = "Người dùng không tồn tại.";
                notificationDiv.classList.add('show', 'error');
            }

            // Ẩn thông báo sau 3 giây
            setTimeout(function() {
                notificationDiv.classList.remove('show', 'error');
            }, 3000);
        }
    </script>
</body>
</html>
