let total = 0;
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
        total = subtotal + shippingCost + tax - discount;

        shippingCostElement.textContent = `Rp ${shippingCost.toLocaleString(
            "id-ID"
        )}`;
        totalAmountElement.textContent = `Rp ${total.toLocaleString("id-ID")}`;
        totalInBtnElement.textContent = `Rp ${total.toLocaleString("id-ID")}`;
    }

    shippingOptions.forEach((option) => {
        option.addEventListener("change", updateTotal);
    });

    // Form validation
    const checkoutBtn = document.getElementById("checkoutBtn");
    const shippingForm = document.getElementById("shippingForm");

    // Function to validate all required fields
    function validateForm() {
        const requiredFields = [
            "fullName",
            "phone",
            "address",
            "city",
            "province",
            "postalCode",
        ];

        let isValid = true;
        let firstInvalidField = null;

        requiredFields.forEach((fieldId) => {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add("border-red-500", "bg-red-50");
                field.classList.remove("border-slate-200");

                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            } else {
                field.classList.remove("border-red-500", "bg-red-50");
                field.classList.add("border-slate-200");
            }
        });

        // Update button state
        if (isValid) {
            checkoutBtn.disabled = false;
            checkoutBtn.classList.remove("opacity-50", "cursor-not-allowed");
            checkoutBtn.classList.add(
                "hover:from-emerald-700",
                "hover:to-green-700"
            );
        } else {
            checkoutBtn.disabled = true;
            checkoutBtn.classList.add("opacity-50", "cursor-not-allowed");
            checkoutBtn.classList.remove(
                "hover:from-emerald-700",
                "hover:to-green-700"
            );
        }

        return { isValid, firstInvalidField };
    }

    // Add real-time validation
    const formInputs = document.querySelectorAll(
        "#shippingForm input, #shippingForm textarea"
    );
    formInputs.forEach((input) => {
        input.addEventListener("input", validateForm);
        input.addEventListener("blur", validateForm);

        // Form field animations
        input.addEventListener("focus", function () {
            this.parentElement.style.transform = "scale(1.02)";
        });

        input.addEventListener("blur", function () {
            this.parentElement.style.transform = "scale(1)";
        });
    });

    // Initial validation check
    setTimeout(validateForm, 100);

    // Checkout button event listener
    checkoutBtn.addEventListener("click", async function (e) {
        e.preventDefault();
        console.log("Checkout button clicked");

        // Validate form before proceeding
        const validation = validateForm();
        if (!validation.isValid) {
            // Show error message
            showErrorMessage("Mohon lengkapi semua field yang diperlukan");
            if (validation.firstInvalidField) {
                validation.firstInvalidField.focus();
            }
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

        try {
            const dataForm = {
                full_name: document.getElementById("fullName").value.trim(),
                phone: document.getElementById("phone").value.trim(),
                address: document.getElementById("address").value.trim(),
                city: document.getElementById("city").value.trim(),
                province: document.getElementById("province").value.trim(),
                postal_code: document.getElementById("postalCode").value.trim(),
                shipping_method: document.querySelector(
                    'input[name="shipping"]:checked'
                ).value,
                total_amount: total,
            };

            console.log("Sending data:", dataForm);

            const response = await fetch("/checkout/token", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify(dataForm),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log("Midtrans response:", data);

            if (data.token) {
                window.snap.pay(data.token, {
                    onSuccess: function (result) {
                        console.log("SUKSES", result);

                        Swal.fire({
                            title: "Pembayaran Berhasil!",
                            text: "Terima kasih, pesanan Anda telah diterima.",
                            icon: "success",
                            confirmButtonText: "Lihat Pesanan Saya",
                        }).then(() => {
                            window.location.href = "/transaksi";
                        });
                    },
                    onPending: function (result) {
                        console.log("MENUNGGU", result);
                        window.location.href = "/checkout/pending";
                    },
                    onError: function (result) {
                        console.error("ERROR", result);
                        showErrorMessage(
                            "Pembayaran gagal. Silakan coba lagi."
                        );
                    },
                    onClose: function () {
                        showErrorMessage("Pembayaran dibatalkan.");
                    },
                });
            } else {
                throw new Error("Token pembayaran tidak ditemukan");
            }
        } catch (err) {
            console.error("Midtrans Error:", err);
            showErrorMessage(
                "Terjadi kesalahan saat memulai pembayaran. Silakan coba lagi."
            );
        } finally {
            // Restore button state
            checkoutBtn.innerHTML = originalText;
            validateForm(); // This will set the correct disabled state
        }
    });

    function showErrorMessage(message) {
        const errorDiv = document.createElement("div");
        errorDiv.className =
            "fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50";
        errorDiv.innerHTML = `
            <div class="bg-white rounded-3xl p-8 max-w-md mx-4 text-center transform scale-95 opacity-0 transition-all duration-300">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Error</h3>
                <p class="text-slate-600 mb-6">${message}</p>
                <button onclick="this.parentElement.parentElement.remove()" 
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-xl transition-colors">
                    OK
                </button>
            </div>
        `;

        document.body.appendChild(errorDiv);

        // Animate in
        setTimeout(() => {
            const modal = errorDiv.querySelector("div");
            modal.style.transform = "scale(1)";
            modal.style.opacity = "1";
        }, 100);
    }

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
document.addEventListener("DOMContentLoaded", function () {
    const phoneInput = document.getElementById("phone");
    if (phoneInput) {
        phoneInput.addEventListener("input", function (e) {
            let value = e.target.value.replace(/\D/g, "");
            if (value.startsWith("0")) {
                value = value.substring(1);
            }
            if (value.length > 0) {
                value = "08" + value;
            }
            if (value.length > 13) {
                value = value.substring(0, 13);
            }
            e.target.value = value;
        });
    }
});

// Postal code formatting
document.addEventListener("DOMContentLoaded", function () {
    const postalCodeInput = document.getElementById("postalCode");
    if (postalCodeInput) {
        postalCodeInput.addEventListener("input", function (e) {
            let value = e.target.value.replace(/\D/g, "");
            if (value.length > 5) {
                value = value.substring(0, 5);
            }
            e.target.value = value;
        });
    }
});
