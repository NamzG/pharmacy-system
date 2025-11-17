// Simple alerts, confirmations, or future enhancements
document.addEventListener("DOMContentLoaded", function() {
    console.log("Pharmacy System JS Loaded ✅");

    // Example: confirm before delete
    let deleteBtns = document.querySelectorAll(".btn-delete");
    deleteBtns.forEach(btn => {
        btn.addEventListener("click", function(e) {
            if (!confirm("Are you sure you want to delete this record?")) {
                e.preventDefault();
            }
        });
    });
});
