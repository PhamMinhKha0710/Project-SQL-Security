<?php
session_start();
session_destroy();  // Hủy session
header("Location: login_handler.php");  // Chuyển hướng người dùng về trang đăng nhập
exit;
?>
