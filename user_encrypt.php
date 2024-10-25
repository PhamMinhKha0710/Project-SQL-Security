<?php
session_start();
include 'db_connection.php';  // Đảm bảo db_connection.php có kết nối MySQLi

/**
 * Hàm mã hóa SHA-256 cho các thông tin quan trọng.
 * @param string|null $data Thông tin cần mã hóa
 * @return string|null Giá trị đã mã hóa hoặc null nếu dữ liệu trống
 */
function encrypt_sha256($data) {
    return $data ? hash('sha256', $data) : null;
}

try {
    // Kiểm tra nếu kết nối thành công
    if (!$conn) {
        throw new Exception("Kết nối tới cơ sở dữ liệu không thành công.");
    }

    // Lấy dữ liệu từ bảng users
    $query = "SELECT id, password, full_name, email, phone_number FROM users";
    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Lỗi truy vấn cơ sở dữ liệu: " . $conn->error);
    }

    // Lặp qua từng người dùng để mã hóa dữ liệu và lưu vào bảng mới
    while ($user = $result->fetch_assoc()) {  // Sửa từ $users thành $user để phù hợp với các biến trong vòng lặp
        // Mã hóa từng thông tin quan trọng bằng hàm encrypt_sha256
        $hashed_password = encrypt_sha256($user['password']);
        $hashed_full_name = encrypt_sha256($user['full_name']);
        
        // Xử lý giá trị NULL hoặc email trống
        $hashed_email = $user['email'] ? encrypt_sha256($user['email']) : encrypt_sha256('default_email@example.com');
        $hashed_phone = $user['phone_number'] ? encrypt_sha256($user['phone_number']) : null; // Mã hóa số điện thoại nếu có

        // Chèn thông tin đã mã hóa vào bảng users_encrypted
        $stmt = $conn->prepare("
            INSERT INTO users_encrypted (id, hashed_password, hashed_full_name, hashed_email, hashed_phone)
            VALUES (?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
        }

        // Thực thi câu lệnh với dữ liệu đã mã hóa
        $stmt->bind_param('issss', $user['id'], $hashed_password, $hashed_full_name, $hashed_email, $hashed_phone);
        if (!$stmt->execute()) {
            throw new Exception("Lỗi thực thi câu lệnh: " . $stmt->error);
        }

        $stmt->close();
    }

    echo "Đã mã hóa thành công và lưu vào bảng users_encrypted.";

} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}

$conn->close();
?>
