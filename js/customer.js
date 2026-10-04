// This function runs when the "Register" button on view/register.php is clicked.
function registerCustomer() {
	var nameEl = document.getElementById("customer_name");
	var emailEl = document.getElementById("customer_email");
	var passEl = document.getElementById("customer_pass");
	var countryEl = document.getElementById("customer_country");
	var cityEl = document.getElementById("customer_city");
	var contactEl = document.getElementById("customer_contact");

	var name = nameEl ? nameEl.value.trim() : "";
	var email = emailEl ? emailEl.value.trim() : "";
	var pass = passEl ? passEl.value.trim() : "";
	var country = countryEl ? countryEl.value.trim() : "";
	var city = cityEl ? cityEl.value.trim() : "";
	var contact = contactEl ? contactEl.value.trim() : "";

	var messageEl = document.getElementById("formMessage");
	var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	var passPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

	if (!name || !email || !pass || !country || !city || !contact) {
		if (messageEl) {
			messageEl.style.color = "red";
			messageEl.textContent = "Please fill in all required fields.";
		}
		return;
	}

	if (!emailPattern.test(email)) {
		if (messageEl) {
			messageEl.style.color = "red";
			messageEl.textContent = "Please enter a valid email address.";
		}
		return;
	}

	if (!passPattern.test(pass)) {
		if (messageEl) {
			messageEl.style.color = "red";
			messageEl.textContent = "Password must be at least 8 characters long and include uppercase, lowercase, numbers, and a special character.";
		}
		return;
	}

	var formObj = document.getElementById("registerForm");
	if (!formObj) return;

	var formData = new FormData(formObj);

	fetch("../actions/customer_register_action.php", {
		method: "POST",
		body: formData
	})
		.then(function (response) {
			return response.json();
		})
		.then(function (data) {
			if (messageEl) {
				messageEl.style.color = data.success ? "green" : "red";
				messageEl.textContent = data.message;
			}

			if (data.success) {
				formObj.reset();
			}
		})
		.catch(function () {
			if (messageEl) {
				messageEl.style.color = "red";
				messageEl.textContent = "Something went wrong. Please try again.";
			}
		});
}

// This function runs when the "Login" button on view/login.php is clicked.
function loginCustomer() {
	var emailEl = document.getElementById("customer_email");
	var passEl = document.getElementById("customer_pass");

	var email = emailEl ? emailEl.value.trim() : "";
	var pass = passEl ? passEl.value.trim() : "";

	var messageEl = document.getElementById("formMessage");
	var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

	if (!email || !pass) {
		if (messageEl) {
			messageEl.style.color = "red";
			messageEl.textContent = "Please enter both email and password.";
		}
		return;
	}

	if (!emailPattern.test(email)) {
		if (messageEl) {
			messageEl.style.color = "red";
			messageEl.textContent = "Please enter a valid email address.";
		}
		return;
	}

	var formObj = document.getElementById("loginForm");
	if (!formObj) return;

	var formData = new FormData(formObj);

	fetch("../actions/customer_login_action.php", {
		method: "POST",
		body: formData
	})
		.then(function (response) {
			return response.json();
		})
		.then(function (data) {
			if (messageEl) {
				messageEl.style.color = data.success ? "green" : "red";
				messageEl.textContent = data.message;
			}

			if (data.success) {
				setTimeout(function () {
					window.location.href = "../index.php";
				}, 1000);
			}
		})
		.catch(function () {
			if (messageEl) {
				messageEl.style.color = "red";
				messageEl.textContent = "Something went wrong during login. Please try again.";
			}
		});
}
