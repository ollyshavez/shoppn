// Cart client-side enhancements
document.addEventListener("DOMContentLoaded", function () {
    // Validate quantity inputs before update submission
    var updateForm = document.getElementById("updateForm");
    if (updateForm) {
        updateForm.addEventListener("submit", function (e) {
            var qtyInputs = document.querySelectorAll('input[name="qty[]"]');
            for (var i = 0; i < qtyInputs.length; i++) {
                var val = parseInt(qtyInputs[i].value, 10);
                if (isNaN(val) || val < 1) {
                    e.preventDefault();
                    alert("Please enter a valid quantity of 1 or greater for all items.");
                    qtyInputs[i].focus();
                    return false;
                }
            }
        });
    }

    // Ensure at least one item is checked before remove submission
    var removeForm = document.getElementById("removeForm");
    if (removeForm) {
        removeForm.addEventListener("submit", function (e) {
            var checked = document.querySelectorAll('input[name="remove[]"]:checked');
            if (checked.length === 0) {
                e.preventDefault();
                alert("Please select at least one item checkbox to remove.");
                return false;
            }
            if (!confirm("Are you sure you want to remove the selected item(s) from your cart?")) {
                e.preventDefault();
                return false;
            }
        });
    }
});
