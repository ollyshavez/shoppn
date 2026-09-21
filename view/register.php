<?php
require_once __DIR__ . "/../core/core.php";
$app_root = get_app_root();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register Customer - Shoppn</title>
	<link rel="stylesheet" href="<?= $app_root ?>css/style.css">
</head>
<body>
	<?php include_once __DIR__ . "/../views/layout/header.php"; ?>

	<div style="padding: 30px 20px; max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-top: 20px;">
		<h1>Customer Registration</h1>

		<form id="registerForm" style="margin-top: 20px;">
			<div style="margin-bottom: 15px;">
				<label style="display: block; font-weight: bold; margin-bottom: 5px;">Full Name *</label>
				<input type="text" name="customer_name" id="customer_name" style="width: 100%; padding: 8px; box-sizing: border-box;">
			</div>
			<div style="margin-bottom: 15px;">
				<label style="display: block; font-weight: bold; margin-bottom: 5px;">Email Address *</label>
				<input type="email" name="customer_email" id="customer_email" style="width: 100%; padding: 8px; box-sizing: border-box;">
			</div>
			<div style="margin-bottom: 15px;">
				<label style="display: block; font-weight: bold; margin-bottom: 5px;">Password *</label>
				<input type="password" name="customer_pass" id="customer_pass" style="width: 100%; padding: 8px; box-sizing: border-box;">
			</div>
			<div style="margin-bottom: 15px;">
				<label style="display: block; font-weight: bold; margin-bottom: 5px;">Country *</label>
				<input type="text" name="customer_country" id="customer_country" style="width: 100%; padding: 8px; box-sizing: border-box;">
			</div>
			<div style="margin-bottom: 15px;">
				<label style="display: block; font-weight: bold; margin-bottom: 5px;">City *</label>
				<input type="text" name="customer_city" id="customer_city" style="width: 100%; padding: 8px; box-sizing: border-box;">
			</div>
			<div style="margin-bottom: 15px;">
				<label style="display: block; font-weight: bold; margin-bottom: 5px;">Contact Number *</label>
				<input type="text" name="customer_contact" id="customer_contact" style="width: 100%; padding: 8px; box-sizing: border-box;">
			</div>
			<div style="margin-bottom: 15px;">
				<label style="display: block; font-weight: bold; margin-bottom: 5px;">Profile Image URL (optional)</label>
				<input type="text" name="customer_image" id="customer_image" style="width: 100%; padding: 8px; box-sizing: border-box;">
			</div>
			<div>
				<button type="button" onclick="registerCustomer()" style="background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-size: 1em; cursor: pointer;">Register</button>
			</div>
		</form>

		<p id="formMessage" style="margin-top: 15px; font-weight: bold;"></p>
	</div>

	<script src="<?= $app_root ?>js/customer.js"></script>
	<?php include_once __DIR__ . "/../views/layout/footer.php"; ?>
</body>
</html>
