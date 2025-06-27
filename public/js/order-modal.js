document.addEventListener("DOMContentLoaded", () => {
    const orderModal = document.getElementById("orderModal");
    const closeModal = document.getElementById("closeModal");
    const modalContent = document.getElementById("modalContent");

    // Tombol "Lihat Detail"
    const detailButtons = document.querySelectorAll(".btn-detail");
    detailButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const orderId =
                this?.dataset?.order || this?.getAttribute("data-order");
            console.log("Order ID:", orderId);
            if (orderId) {
                showOrderDetail(orderId);
            } else {
                console.warn("Order ID tidak ditemukan di tombol.");
            }
        });
    });

    closeModal.addEventListener("click", function () {
        orderModal.classList.add("hidden");
    });

    window.showOrderDetail = function (orderId) {
        modalContent.innerHTML = `
            <div class="animate-pulse">
                <div class="h-4 bg-slate-200 rounded w-3/4 mb-4"></div>
                <div class="h-4 bg-slate-200 rounded w-1/2 mb-4"></div>
                <div class="h-4 bg-slate-200 rounded w-2/3"></div>
            </div>
        `;
        orderModal.classList.remove("hidden");

        // Get order data
        const order = orderData[orderId];
        console.log("Order data:", order);
        if (!order) {
            modalContent.innerHTML = `
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Pesanan Tidak Ditemukan</h3>
                    <p class="text-slate-600">Data pesanan tidak dapat dimuat</p>
                </div>
            `;
            return;
        }

        // Build order items HTML
        let orderItemsHtml = "";
        let itemsTotal = 0;

        if (order.items && order.items.length > 0) {
            orderItemsHtml = order.items
                .map((item) => {
                    const productImage =
                        item.product && item.product.image
                            ? `${item.product.image}`
                            : "";
                    const productName =
                        item.product && item.product.name
                            ? item.product.name
                            : "Produk";
                    const productDescription =
                        item.product && item.product.description
                            ? item.product.description
                            : "Deskripsi produk";

                    const itemPrice = Number(item.price) || 0;
                    itemsTotal += itemPrice;

                    return `
                    <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-2xl">
                        <div class="w-16 h-16 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl flex items-center justify-center overflow-hidden">
                            ${
                                productImage
                                    ? `<img src="${productImage}" alt="${productName}" class="w-full h-full object-cover">`
                                    : `<svg class="w-8 h-8 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z" />
                                    </svg>`
                            }
                        </div>
                        <div class="flex-1">
                            <h5 class="font-semibold text-slate-900">${productName}</h5>
                            <p class="text-sm text-slate-600">${
                                productDescription.length > 50
                                    ? productDescription.substring(0, 50) +
                                      "..."
                                    : productDescription
                            }</p>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-sm text-slate-500">Qty: ${
                                    item.quantity || 1
                                }</p>
                                <p class="text-sm font-semibold text-slate-900">${formatCurrency(
                                    itemPrice
                                )}</p>
                            </div>
                        </div>
                    </div>
                `;
                })
                .join("");
        } else {
            orderItemsHtml = `
                <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-2xl">
                    <div class="w-16 h-16 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h5 class="font-semibold text-slate-900">Produk Furniture</h5>
                        <p class="text-sm text-slate-600">Detail produk</p>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-sm text-slate-500">Qty: 1</p>
                            <p class="text-sm font-semibold text-slate-900">${formatCurrency(
                                order.total_amount || 0
                            )}</p>
                        </div>
                    </div>
                </div>
            `;
            itemsTotal = Number(order.total_amount) || 0;
        }

        // Calculate totals
        const subtotal = itemsTotal;
        const tax = subtotal * 0.11;
        const shippingCost = Number(order.shipping_cost) || 0;
        const grandTotal = subtotal + tax + shippingCost;

        // Build additional sections
        let additionalSections = "";

        // Shipping address section
        if (order.shipping_address) {
            additionalSections += `
                <div>
                    <h4 class="font-semibold text-slate-900 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat Pengiriman
                    </h4>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <p class="text-sm text-slate-700">${
                            order.shipping_address
                        }</p>
                        ${
                            order.shipping_method
                                ? `<p class="text-sm text-slate-500 mt-2">Metode: ${order.shipping_method}</p>`
                                : ""
                        }
                    </div>
                </div>
            `;
        }

        // Notes section
        if (order.notes) {
            additionalSections += `
                <div>
                    <h4 class="font-semibold text-slate-900 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Catatan
                    </h4>
                    <div class="bg-amber-50 rounded-2xl p-4">
                        <p class="text-sm text-slate-700">${order.notes}</p>
                    </div>
                </div>
            `;
        }

        // Cancel reason section
        if (
            order.order_status &&
            order.order_status.toLowerCase() === "dibatalkan" &&
            order.cancel_reason
        ) {
            additionalSections += `
                <div>
                    <h4 class="font-semibold text-red-800 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Alasan Pembatalan
                    </h4>
                    <div class="bg-red-50 rounded-2xl p-4 border border-red-200">
                        <p class="text-sm text-red-700">${order.cancel_reason}</p>
                    </div>
                </div>
            `;
        }

        setTimeout(() => {
            modalContent.innerHTML = `
                <div class="space-y-6">
                    <div>
                        <h4 class="font-semibold text-slate-900 mb-3">Informasi Pesanan</h4>
                        <div class="bg-slate-50 rounded-2xl p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-slate-500">ID Pesanan:</span>
                                    <span class="font-semibold ml-2">#${
                                        order.order_id || "N/A"
                                    }</span>
                                </div>
                                <div>
                                    <span class="text-slate-500">Status:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold ml-2 ${getStatusClass(
                                        order.order_status
                                    )}">
                                        ${
                                            order.order_status
                                                ? order.order_status
                                                      .charAt(0)
                                                      .toUpperCase() +
                                                  order.order_status.slice(1)
                                                : "Belum ditentukan"
                                        }
                                    </span>
                                </div>
                                <div>
                                    <span class="text-slate-500">Tanggal Pesan:</span>
                                    <span class="font-semibold ml-2">${
                                        order.created_at
                                            ? formatDate(order.created_at)
                                            : "N/A"
                                    }</span>
                                </div>
                                <div>
                                    <span class="text-slate-500">Metode Bayar:</span>
                                    <span class="font-semibold ml-2">${
                                        order.payment_type
                                            ? order.payment_type.toUpperCase()
                                            : "Belum ditentukan"
                                    }</span>
                                </div>
                                ${
                                    order.paid_at
                                        ? `
                                        <div>
                                            <span class="text-slate-500">Tanggal Bayar:</span>
                                            <span class="font-semibold ml-2">${formatDate(
                                                order.paid_at
                                            )}</span>
                                        </div>
                                        `
                                        : ""
                                }
                                ${
                                    order.completed_at
                                        ? `
                                        <div>
                                            <span class="text-slate-500">Tanggal Selesai:</span>
                                            <span class="font-semibold ml-2">${formatDate(
                                                order.completed_at
                                            )}</span>
                                        </div>
                                        `
                                        : ""
                                }
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-slate-900 mb-3">Detail Produk</h4>
                        <div class="space-y-3">
                            ${orderItemsHtml}
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-slate-900 mb-3">Ringkasan Pembayaran</h4>
                        <div class="bg-slate-50 rounded-2xl p-4">
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span>Subtotal:</span>
                                    <span>${formatCurrency(subtotal)}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span>PPN (11%):</span>
                                    <span>${formatCurrency(tax)}</span>
                                </div>

                                ${
                                    shippingCost > 0
                                        ? `
                                        <div class="flex justify-between">
                                            <span>Ongkir:</span>
                                            <span>${formatCurrency(
                                                shippingCost
                                            )}</span>
                                        </div>
                                        `
                                        : ""
                                }

                                <hr class="my-2">

                                <div class="flex justify-between font-semibold text-base">
                                    <span>Total:</span>
                                    <span>${formatCurrency(grandTotal)}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    ${additionalSections}
                </div>
            `;
        }, 500);
    };

    function formatDate(dateString) {
        if (!dateString) return "-";
        const date = new Date(dateString);
        return date.toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "short",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
        });
    }

    // Format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(amount);
    }

    // Get status badge class
    function getStatusClass(status) {
        const statusColors = {
            pending: "bg-yellow-100 text-yellow-800",
            menunggu: "bg-yellow-100 text-yellow-800",
            menunggu_konfirmasi: "bg-yellow-100 text-yellow-800",
            diproses: "bg-blue-100 text-blue-800",
            dikirim: "bg-purple-100 text-purple-800",
            selesai: "bg-green-100 text-green-800",
            dibatalkan: "bg-red-100 text-red-800",
        };
        return (
            statusColors[status.toLowerCase()] || "bg-gray-100 text-gray-800"
        );
    }
});
