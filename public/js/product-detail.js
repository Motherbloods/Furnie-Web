function changeMainImage(imageSrc) {
    document.getElementById("mainImage").src = imageSrc;
}

function decreaseQuantity() {
    const quantityInput = document.getElementById("quantity");
    const currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
        updateButtonQuantity();
    }
}

function increaseQuantity() {
    const quantityInput = document.getElementById("quantity");
    const currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.max);
    if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
        updateButtonQuantity();
    }
}

function updateButtonQuantity() {
    const quantity = document.getElementById("quantity").value;
    const productId = document.getElementById("quantity").dataset.productId;

    // Update button data attributes
    const addToCartBtn = document.querySelector(".add-to-cart-btn");
    const buyNowBtn = document.querySelector(".buy-now-btn");

    if (addToCartBtn) {
        addToCartBtn.dataset.quantity = quantity;
    }
    if (buyNowBtn) {
        buyNowBtn.dataset.quantity = quantity;
    }
}

function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll(".tab-content");
    tabContents.forEach((content) => {
        content.classList.add("hidden");
    });

    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll(".tab-button");
    tabButtons.forEach((button) => {
        button.classList.remove("active", "text-blue-600", "border-blue-500");
        button.classList.add("text-slate-600");
    });

    // Show selected tab content
    document.getElementById(tabName).classList.remove("hidden");

    // Add active class to clicked tab button
    event.target.classList.add("active", "text-blue-600", "border-blue-500");
    event.target.classList.remove("text-slate-600");
}

// Initialize first tab as active
document.addEventListener("DOMContentLoaded", function () {
    const firstTabButton = document.querySelector(".tab-button");
    firstTabButton.classList.add("text-blue-600", "border-blue-500");
    firstTabButton.classList.remove("text-slate-600");

    // Initialize quantity
    updateButtonQuantity();
});
