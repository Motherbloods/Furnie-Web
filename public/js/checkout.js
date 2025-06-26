document.addEventListener("DOMContentLoaded", function () {
    // Shipping cost calculator
    const shippingOptions = document.querySelectorAll('input[name="shipping"]');
    const shippingCostElement = document.getElementById("shippingCost");
    const totalAmountElement = document.getElementById("totalAmount");
    const totalInBtnElement = document.getElementById("totalInBtn");

    const shippingCosts = {
        regular: 25000,
        express: 50000,
        sameday: 75000,
    };

    const checkoutData = document.getElementById("checkoutData");
    const subtotal = parseInt(checkoutData.dataset.subtotal);
    const tax = parseInt(checkoutData.dataset.tax);
    const discount = parseInt(checkoutData.dataset.discount) || 0;

    function updateTotal() {
        const selectedShipping = document.querySelector(
            'input[name="shipping"]:checked'
        ).value;
        const shippingCost = shippingCosts[selectedShipping];
        const total = subtotal + shippingCost + tax - discount;

        shippingCostElement.textContent = `Rp ${shippingCost.toLocaleString(
            "id-ID"
        )}`;
        totalAmountElement.textContent = `Rp ${total.toLocaleString("id-ID")}`;
        totalInBtnElement.textContent = `Rp ${total.toLocaleString("id-ID")}`;
    }

    shippingOptions.forEach((option) => {
        option.addEventListener("change", updateTotal);
    });

    // Form validation and checkout
    const checkoutBtn = document.getElementById("checkoutBtn");
    const shippingForm = document.getElementById("shippingForm");

    checkoutBtn.addEventListener("click", function (e) {
        e.preventDefault();

        // Validate form
        const formData = new FormData(shippingForm);
        const isValid = shippingForm.checkValidity();

        if (!isValid) {
            shippingForm.reportValidity();
            return;
        }

        // Show loading state
        const originalText = checkoutBtn.innerHTML;
        checkoutBtn.innerHTML = `
                    <div class="flex items-center justify-center space-x-3">
                        <svg class="animate-spin w-6 h-6" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Memproses...</span>
                    </div>
                `;
        checkoutBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
            // Here you would integrate with Midtrans
            // For now, we'll show success message
            showSuccessMessage();
            checkoutBtn.innerHTML = originalText;
            checkoutBtn.disabled = false;
        }, 2000);
    });

    function showSuccessMessage() {
        const successDiv = document.createElement("div");
        successDiv.className =
            "fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50";
        successDiv.innerHTML = `
                    <div class="bg-white rounded-3xl p-8 max-w-md mx-4 text-center transform scale-95 opacity-0 transition-all duration-300">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Pesanan Berhasil!</h3>
                        <p class="text-slate-600 mb-6">Anda akan diarahkan ke halaman pembayaran Midtrans</p>
                        <button onclick="this.parentElement.parentElement.remove()" 
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-xl transition-colors">
                            OK
                        </button>
                    </div>
                `;

        document.body.appendChild(successDiv);

        // Animate in
        setTimeout(() => {
            const modal = successDiv.querySelector("div");
            modal.style.transform = "scale(1)";
            modal.style.opacity = "1";
        }, 100);
    }

    // Enhanced animations for shipping options
    const shippingLabels = document.querySelectorAll(".shipping-option label");
    shippingLabels.forEach((label) => {
        label.addEventListener("mouseenter", function () {
            this.style.transform = "translateX(4px)";
        });

        label.addEventListener("mouseleave", function () {
            this.style.transform = "translateX(0)";
        });
    });

    // Form field animations
    const formInputs = document.querySelectorAll("input, textarea");
    formInputs.forEach((input) => {
        input.addEventListener("focus", function () {
            this.parentElement.style.transform = "scale(1.02)";
        });

        input.addEventListener("blur", function () {
            this.parentElement.style.transform = "scale(1)";
        });
    });

    // Initialize total calculation
    updateTotal();

    // Smooth scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, observerOptions);

    // Observe all slide-up elements
    document.querySelectorAll(".slide-up").forEach((el) => {
        el.style.opacity = "0";
        el.style.transform = "translateY(20px)";
        el.style.transition = "all 0.6s ease-out";
        observer.observe(el);
    });
});

// Phone number formatting
document.getElementById("phone").addEventListener("input", function (e) {
    let value = e.target.value.replace(/\D/g, "");
    if (value.startsWith("0")) {
        value = value.substring(1);
    }
    if (value.length > 0) {
        value = "08" + value;
    }
    e.target.value = value;
});

// Postal code formatting
document.getElementById("postalCode").addEventListener("input", function (e) {
    let value = e.target.value.replace(/\D/g, "");
    if (value.length > 5) {
        value = value.substring(0, 5);
    }
    e.target.value = value;
});
