// File: public/js/cart.js
// Global cart management functions

class CartManager {
    constructor() {
        this.csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");
        this.baseUrl = window.location.origin;
        this.init();
    }

    init() {
        // Initialize cart counter on page load
        this.updateCartCounter();

        // Add event listeners
        this.addEventListeners();
    }

    addEventListeners() {
        // Add to cart buttons
        document.addEventListener("click", (e) => {
            if (e.target.closest(".add-to-cart-btn")) {
                e.preventDefault();
                const button = e.target.closest(".add-to-cart-btn");
                const productId = button.dataset.productId;
                const quantity = button.dataset.quantity || 1;
                this.addToCart(productId, quantity, button);
            }

            // Quick add buttons
            if (e.target.closest(".quick-add-btn")) {
                e.preventDefault();
                const button = e.target.closest(".quick-add-btn");
                const productId = button.dataset.productId;
                this.addToCart(productId, 1, button);
            }

            // Buy now buttons
            if (e.target.closest(".buy-now-btn")) {
                e.preventDefault();
                const button = e.target.closest(".buy-now-btn");
                const productId = button.dataset.productId;
                const quantity = button.dataset.quantity || 1;
                this.buyNow(productId, quantity, button);
            }
        });

        // Quantity input changes
        document.addEventListener("change", (e) => {
            if (e.target.classList.contains("quantity-input")) {
                const input = e.target;
                const productId = input.dataset.productId;
                const quantity = parseInt(input.value) || 1;

                // Update button data
                const addBtn = document.querySelector(
                    `[data-product-id="${productId}"].add-to-cart-btn`
                );
                if (addBtn) {
                    addBtn.dataset.quantity = quantity;
                }

                const buyBtn = document.querySelector(
                    `[data-product-id="${productId}"].buy-now-btn`
                );
                if (buyBtn) {
                    buyBtn.dataset.quantity = quantity;
                }
            }
        });

        // Cart item quantity updates
        document.addEventListener("change", (e) => {
            if (e.target.classList.contains("cart-item-quantity")) {
                const input = e.target;
                const cartItemId = input.dataset.cartItemId;
                const quantity = parseInt(input.value) || 1;
                this.updateCartItemQuantity(cartItemId, quantity);
            }
        });

        // Remove cart item buttons
        document.addEventListener("click", (e) => {
            if (e.target.closest(".remove-cart-item")) {
                e.preventDefault();
                const button = e.target.closest(".remove-cart-item");
                const cartItemId = button.dataset.cartItemId;
                this.removeCartItem(cartItemId, button);
            }
        });
    }

    async addToCart(productId, quantity = 1, button = null) {
        try {
            // Show loading state
            if (button) {
                this.setButtonLoading(button, true);
            }

            const response = await fetch(`${this.baseUrl}/cart`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity),
                }),
            });
            console.log(this.baseUrl);

            const data = await response.json();

            if (data.success) {
                this.showNotification("Berhasil", data.message, "success");
                this.updateCartCounter();

                // Trigger custom event
                document.dispatchEvent(
                    new CustomEvent("cartUpdated", {
                        detail: { action: "add", productId, quantity, data },
                    })
                );

                // Update button text temporarily
                if (button) {
                    const originalText = button.textContent;
                    button.textContent = "✓ Ditambahkan";
                    setTimeout(() => {
                        button.textContent = originalText;
                    }, 2000);
                }
            } else {
                this.showNotification("Error", data.error, "error");

                // Shake button on error
                if (button) {
                    button.classList.add("animate-shake");
                    setTimeout(
                        () => button.classList.remove("animate-shake"),
                        500
                    );
                }
            }
        } catch (error) {
            console.error("Cart Error:", error);
            this.showNotification(
                "Error",
                "Terjadi kesalahan saat menambahkan produk",
                "error"
            );
        } finally {
            // Remove loading state
            if (button) {
                this.setButtonLoading(button, false);
            }
        }
    }

    async buyNow(productId, quantity = 1, button = null) {
        try {
            // Show loading state
            if (button) {
                this.setButtonLoading(button, true);
            }

            // First add to cart
            const response = await fetch(`${this.baseUrl}/cart/add`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity),
                }),
            });

            const data = await response.json();

            if (data.success) {
                // Redirect to checkout
                window.location.href = `${this.baseUrl}/checkout`;
            } else {
                this.showNotification("Error", data.error, "error");
            }
        } catch (error) {
            console.error("Buy Now Error:", error);
            this.showNotification(
                "Error",
                "Terjadi kesalahan saat melakukan pembelian",
                "error"
            );
        } finally {
            // Remove loading state
            if (button) {
                this.setButtonLoading(button, false);
            }
        }
    }

    async updateCartItemQuantity(cartItemId, quantity) {
        try {
            const response = await fetch(`${this.baseUrl}/cart/update`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
                body: JSON.stringify({
                    cart_item_id: cartItemId,
                    quantity: parseInt(quantity),
                }),
            });

            const data = await response.json();

            if (data.success) {
                this.updateCartCounter();
                this.updateCartSubtotal();

                // Trigger custom event
                document.dispatchEvent(
                    new CustomEvent("cartUpdated", {
                        detail: {
                            action: "update",
                            cartItemId,
                            quantity,
                            data,
                        },
                    })
                );
            } else {
                this.showNotification("Error", data.error, "error");
            }
        } catch (error) {
            console.error("Update Cart Error:", error);
            this.showNotification(
                "Error",
                "Terjadi kesalahan saat mengupdate keranjang",
                "error"
            );
        }
    }

    async removeCartItem(cartItemId, button = null) {
        try {
            // Show loading state
            if (button) {
                this.setButtonLoading(button, true);
            }

            const response = await fetch(`${this.baseUrl}/cart/remove`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
                body: JSON.stringify({
                    cart_item_id: cartItemId,
                }),
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification("Berhasil", data.message, "success");
                this.updateCartCounter();
                this.updateCartSubtotal();

                // Remove cart item element from DOM
                const cartItem = document.querySelector(
                    `[data-cart-item-id="${cartItemId}"]`
                );
                if (cartItem) {
                    cartItem.remove();
                }

                // Trigger custom event
                document.dispatchEvent(
                    new CustomEvent("cartUpdated", {
                        detail: { action: "remove", cartItemId, data },
                    })
                );
            } else {
                this.showNotification("Error", data.error, "error");
            }
        } catch (error) {
            console.error("Remove Cart Error:", error);
            this.showNotification(
                "Error",
                "Terjadi kesalahan saat menghapus produk",
                "error"
            );
        } finally {
            // Remove loading state
            if (button) {
                this.setButtonLoading(button, false);
            }
        }
    }

    async updateCartCounter() {
        try {
            const response = await fetch(`${this.baseUrl}/cart/count`);
            const data = await response.json();

            if (data.success) {
                // Update all cart counter elements
                document
                    .querySelectorAll(".cart-counter")
                    .forEach((counter) => {
                        counter.textContent = data.count;
                        counter.style.display =
                            data.count > 0 ? "block" : "none";
                    });

                // Update cart badge
                document.querySelectorAll(".cart-badge").forEach((badge) => {
                    badge.textContent = data.count;
                    badge.classList.toggle("hidden", data.count === 0);
                });
            }
        } catch (error) {
            console.error("Failed to update cart counter:", error);
        }
    }

    async updateCartSubtotal() {
        try {
            const response = await fetch(`${this.baseUrl}/cart/subtotal`);
            const data = await response.json();

            if (data.success) {
                // Update subtotal elements
                document
                    .querySelectorAll(".cart-subtotal")
                    .forEach((element) => {
                        element.textContent = `Rp ${data.subtotal.toLocaleString(
                            "id-ID"
                        )}`;
                    });

                // Update total elements
                document.querySelectorAll(".cart-total").forEach((element) => {
                    element.textContent = `Rp ${data.total.toLocaleString(
                        "id-ID"
                    )}`;
                });
            }
        } catch (error) {
            console.error("Failed to update cart subtotal:", error);
        }
    }

    async getCartItems() {
        try {
            const response = await fetch(`${this.baseUrl}/cart/items`);
            const data = await response.json();

            if (data.success) {
                return data;
            }
            return null;
        } catch (error) {
            console.error("Failed to get cart items:", error);
            return null;
        }
    }

    async clearCart() {
        try {
            const response = await fetch(`${this.baseUrl}/cart/clear`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification(
                    "Berhasil",
                    "Keranjang telah dikosongkan",
                    "success"
                );
                this.updateCartCounter();
                this.updateCartSubtotal();

                // Remove all cart items from DOM
                document.querySelectorAll(".cart-item").forEach((item) => {
                    item.remove();
                });

                // Trigger custom event
                document.dispatchEvent(
                    new CustomEvent("cartUpdated", {
                        detail: { action: "clear", data },
                    })
                );
            } else {
                this.showNotification("Error", data.error, "error");
            }
        } catch (error) {
            console.error("Clear Cart Error:", error);
            this.showNotification(
                "Error",
                "Terjadi kesalahan saat mengosongkan keranjang",
                "error"
            );
        }
    }

    setButtonLoading(button, isLoading) {
        if (isLoading) {
            button.dataset.originalContent = button.innerHTML;
            button.innerHTML = '<div class="loading-spinner"></div>';
            button.disabled = true;
            button.classList.add("opacity-50");
        } else {
            button.innerHTML = button.dataset.originalContent;
            button.disabled = false;
            button.classList.remove("opacity-50");
        }
    }

    showNotification(title, message, type = "success") {
        // Create notification element if doesn't exist
        let notification = document.getElementById("cart-notification");
        if (!notification) {
            notification = this.createNotificationElement();
            document.body.appendChild(notification);
        }

        // Set notification content
        const icon = notification.querySelector(".notification-icon");
        const titleEl = notification.querySelector(".notification-title");
        const messageEl = notification.querySelector(".notification-message");

        // Set icon and colors based on type
        let iconHtml = "";
        let bgColor = "";

        switch (type) {
            case "success":
                iconHtml =
                    '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
                bgColor = "bg-emerald-500";
                break;
            case "error":
                iconHtml =
                    '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
                bgColor = "bg-red-500";
                break;
            case "warning":
                iconHtml =
                    '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
                bgColor = "bg-yellow-500";
                break;
        }

        icon.innerHTML = iconHtml;
        icon.className = `w-8 h-8 rounded-full flex items-center justify-center ${bgColor} notification-icon`;
        titleEl.textContent = title;
        messageEl.textContent = message;

        // Show notification
        notification.classList.add("show");

        // Auto hide after 3 seconds
        setTimeout(() => {
            notification.classList.remove("show");
        }, 3000);
    }

    createNotificationElement() {
        const notification = document.createElement("div");
        notification.id = "cart-notification";
        notification.className =
            "fixed top-4 right-4 z-50 bg-white shadow-lg rounded-xl p-4 border border-gray-200 max-w-sm transform translate-x-full transition-transform duration-300";

        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="notification-icon w-8 h-8 rounded-full flex items-center justify-center">
                    <!-- Icon will be inserted here -->
                </div>
                <div>
                    <p class="notification-title font-semibold text-sm"></p>
                    <p class="notification-message text-xs text-gray-600"></p>
                </div>
            </div>
        `;

        // Add styles for show state
        const style = document.createElement("style");
        style.textContent = `
            #cart-notification.show {
                transform: translateX(0);
            }
            .loading-spinner {
                border: 2px solid #f3f3f3;
                border-top: 2px solid #10b981;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                animation: spin 1s linear infinite;
                margin: 0 auto;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .animate-shake {
                animation: shake 0.5s;
            }
            @keyframes shake {
                0%, 20%, 40%, 60%, 80%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            }
        `;
        document.head.appendChild(style);

        return notification;
    }
}

// Initialize cart manager when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    window.cartManager = new CartManager();
});
