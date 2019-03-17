<?php
// Hàm include files
function inc() {
	include '../incs/class_db.php';
	include '../incs/class_admin.php';
}

// Gọi hàm inc() để bắt đầu include file
inc ();

// Khởi tạo class_home.php
$adminlib = new adminlib();

// Kiểm tra có bấm nút Đăng ký hay không! nếu có thực hiện đăng ký
if (isset ( $_POST ["login_action"] )) {
	$message = $adminlib->login();
	$error = $message[0];
	$data = $message[1];
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Đăng Nhập</title>
<meta charset="UTF-8">
</head>
<body>
	<h1>Đăng Nhập</h1>
	<?php echo isset($error['message']) ? $error['message'] : ''; ?>
	<form method="post" action="login.php">
		<table cellspacing="0" cellpadding="5">
			<tr>
				<td>Tên của bạn</td>
				<td><input type="text" name="username" id="username"
					value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>" />
                  <?php echo isset($error['username']) ? $error['username'] : ''; ?>
               </td>
			</tr>
			<tr>
				<td>Mật khẩu của bạn</td>
				<td><input type="text" name="password" id="password"
					value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>" />
                  <?php echo isset($error['password']) ? $error['password'] : ''; ?>
               </td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="login_action" value="Đăng nhập" /></td>
			</tr>
		</table>
	</form>
</body>
</html>