<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['otp_code'])) {
    header("Location: login_handler.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác minh OTP</title>
    <link rel="stylesheet" href="style.css"> <!-- Đường dẫn đến tệp CSS -->
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_otp = $_POST['otp'];

    if ($entered_otp == $_SESSION['otp_code']) {
        unset($_SESSION['otp_code']); 
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<p>Mã OTP không chính xác. Vui lòng thử lại.</p>";
    }
} 
?>
</body>
</html>
