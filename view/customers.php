<?php
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../functions/customer_functions.php";

$customers = getAllCustomersList();
$app_root = get_app_root();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>All Customers - Shoppn</title>
	<link rel="stylesheet" href="<?= $app_root ?>css/style.css">
</head>
<body>
	<?php include_once __DIR__ . "/../views/layout/header.php"; ?>

	<div style="padding: 30px 20px; max-width: 1000px; margin: 0 auto;">
		<h1 style="margin-bottom: 10px;">All Registered Customers</h1>

		<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 15px; background: #fff;">
			<thead style="background: #0f172a; color: #fff;">
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Country</th>
					<th>City</th>
					<th>Contact</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($customers)) { ?>
					<?php foreach ($customers as $customer) { ?>
						<tr>
							<td>#<?php echo htmlspecialchars($customer['customer_id']); ?></td>
							<td><?php echo htmlspecialchars($customer['customer_name']); ?></td>
							<td><?php echo htmlspecialchars($customer['customer_email']); ?></td>
							<td><?php echo htmlspecialchars($customer['customer_country']); ?></td>
							<td><?php echo htmlspecialchars($customer['customer_city']); ?></td>
							<td><?php echo htmlspecialchars($customer['customer_contact']); ?></td>
						</tr>
					<?php } ?>
				<?php } else { ?>
					<tr>
						<td colspan="6" style="text-align: center; padding: 20px;">No customers found.</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

	<?php include_once __DIR__ . "/../views/layout/footer.php"; ?>
</body>
</html>
