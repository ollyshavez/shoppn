<?php
require_once __DIR__ . "/core/core.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Shoppn - E-Commerce Store</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php include_once __DIR__ . "/views/layout/header.php"; ?>

	<div style="padding: 30px 20px; max-width: 800px; margin: 0 auto; background: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-top: 30px;">
		<?php if (is_logged_in()): ?>
			<h1>Welcome back, <?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'Customer'); ?>!</h1>
			<p style="font-size: 1.1em; color: #555; margin-top: 10px;">
				Welcome to your Shoppn account dashboard.
			</p>
			
			<div style="margin-top: 25px; padding: 20px; background: #f8f9fa; border-left: 4px solid #0056b3; border-radius: 4px;">
				<h3 style="margin-top: 0;">Quick Actions</h3>
				<ul style="list-style-type: none; padding-left: 0; line-height: 2.2em; font-size: 1.05em;">
					<li>👥 <a href="view/customers.php" style="color: #0056b3; text-decoration: none; font-weight: bold;">View All Customers</a></li>
					<li>👤 <a href="views/account/my_account.php" style="color: #0056b3; text-decoration: none;">My Account Details</a></li>
					<li>🚪 <a href="logout.php" style="color: #dc3545; text-decoration: none;">Log Out</a></li>
				</ul>
			</div>
		<?php else: ?>
			<h1>Welcome to Shoppn E-Commerce</h1>
			<p style="font-size: 1.1em; color: #555; margin-top: 10px;">
				Your one-stop platform for online shopping.
			</p>

			<div style="margin-top: 25px; padding: 20px; background: #f8f9fa; border-left: 4px solid #28a745; border-radius: 4px;">
				<h3 style="margin-top: 0;">Get Started</h3>
				<ul style="list-style-type: none; padding-left: 0; line-height: 2.2em; font-size: 1.05em;">
					<li>📝 <a href="view/register.php" style="color: #28a745; text-decoration: none; font-weight: bold;">Register as a New Customer</a></li>
					<li>🔑 <a href="view/login.php" style="color: #0056b3; text-decoration: none; font-weight: bold;">Customer Login</a></li>
					<li>👥 <a href="view/customers.php" style="color: #0056b3; text-decoration: none;">View All Customers</a></li>
				</ul>
			</div>
		<?php endif; ?>
	</div>

	<?php include_once __DIR__ . "/views/layout/footer.php"; ?>
</body>
</html>