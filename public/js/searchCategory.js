// Integrated Search and Category AJAX functionality

// Force scroll to top before DOM is ready
if (window.history.scrollRestoration) {
    window.history.scrollRestoration = "manual";
}

// Immediate scroll to top
window.scrollTo(0, 0);
document.documentElement.scrollTop = 0;

document.addEventListener("DOMContentLoaded", function () {
    // Search elements
    const searchForm = document.getElementById("search-form");
    const searchInput = document.querySelector('input[name="query"]');

    // Category elements
    const categoryButtons = document.querySelectorAll(".category-btn");

    // Display elements
    const productsGrid = document.getElementById("products-grid");
    const productTitle = document.getElementById("product-title");
    const loadingIndicator = document.getElementById("loading-indicator");
    const productListSection = document.getElementById("product-list-section");

    // State management
    let currentQuery = "";
    let currentCategory = "";
    let currentPage = 1;
    let isLoading = false;
    let hasMorePages = true;

    // Force scroll to top immediately when page loads
    window.scrollTo(0, 0);
    document.documentElement.scrollTop = 0;
    document.body.scrollTop = 0;

    // Reset URL parameters and scroll to top on page load/refresh
    resetOnPageLoad();

    // === Event Listeners ===

    // Search form submission
    if (searchForm) {
        searchForm.addEventListener("submit", function (e) {
            e.preventDefault();
            handleSearch();
        });
    }

    // Real-time search (debounced)
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length >= 2 || query.length === 0) {
                searchTimeout = setTimeout(() => {
                    if (query !== currentQuery) {
                        handleSearch();
                    }
                }, 500);
            }
        });
    }

    // Category button clicks
    if (categoryButtons) {
        categoryButtons.forEach((button) => {
            button.addEventListener("click", (e) => {
                e.preventDefault();
                if (isLoading) return;

                const category = button.getAttribute("data-category");
                handleCategoryFilter(category);
            });
        });
    }

    // === Main Functions ===

    function resetOnPageLoad() {
        // Force scroll to top with multiple methods
        window.scrollTo(0, 0);
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;

        // Clear URL parameters
        const url = new URL(window.location);
        url.searchParams.delete("query");
        url.searchParams.delete("category");

        // Update URL without reloading
        window.history.replaceState({}, "", url);

        // Reset state
        currentQuery = "";
        currentCategory = "";
        currentPage = 1;
        hasMorePages = true;

        // Reset search input
        if (searchInput) {
            searchInput.value = "";
        }

        // Reset active category button
        updateActiveCategoryButton("");

        // Load all products (initial state)
        performSearch("", "", 1, true);

        // Additional scroll to top after a brief delay
        setTimeout(() => {
            window.scrollTo({ top: 0, behavior: "auto" });
            document.documentElement.scrollTop = 0;
            document.body.scrollTop = 0;
        }, 50);

        // Another attempt after content loads
        setTimeout(() => {
            window.scrollTo(0, 0);
        }, 200);
    }

    function handleSearch() {
        const query = searchInput ? searchInput.value.trim() : "";

        // When user searches, reset category to "all"
        if (query !== currentQuery) {
            currentQuery = query;
            currentCategory = ""; // Reset category when searching
            currentPage = 1;
            hasMorePages = true;

            // Update active category button to show "all"
            updateActiveCategoryButton("");

            performSearch(currentQuery, "", 1, true);
        }
    }

    function handleCategoryFilter(category) {
        // When user clicks category, keep current search query
        if (category !== currentCategory) {
            currentCategory = category;
            currentPage = 1;
            hasMorePages = true;

            // Update active category button
            updateActiveCategoryButton(category);

            // Perform search with current query and new category
            performSearch(currentQuery, category, 1, true);
        }
    }

    function performSearch(
        query = "",
        category = "",
        page = 1,
        replace = true
    ) {
        if (isLoading) return;

        isLoading = true;
        showLoading();

        // Determine the correct endpoint
        const url = new URL(window.location.origin);

        if (query) {
            // Use search endpoint for queries
            url.pathname = "/search";
            url.searchParams.set("query", query);
            if (category) {
                url.searchParams.set("category", category);
            }
        } else {
            // Use main dashboard endpoint for category-only filters
            url.pathname = "/";
            if (category) {
                url.searchParams.set("category", category);
            }
        }

        url.searchParams.set("page", page);

        console.log("Performing search/filter:", { query, category, page });

        fetch(url, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                console.log("Search/filter result:", data);
                handleResponse(data, replace);

                // Update URL only if not initial load
                if (query || category) {
                    updateURL(query, category);
                }

                // Scroll to product list if this is a new search/filter
                if (replace && (query || category)) {
                    scrollToProductList();
                }
            })
            .catch((error) => {
                console.error("Search/filter error:", error);
                showError(
                    "Terjadi kesalahan saat memuat produk. Silakan coba lagi."
                );
            })
            .finally(() => {
                isLoading = false;
                hideLoading();
            });
    }

    function handleResponse(data, replace = true) {
        if (data.success) {
            // Update product title
            updateProductTitle(currentQuery, currentCategory);

            // Update products grid
            if (productsGrid) {
                let html = "";

                if (data.html) {
                    html = data.html;
                } else if (data.products && Array.isArray(data.products)) {
                    html = renderProducts(data.products);
                }

                if (replace) {
                    productsGrid.innerHTML = html;
                } else {
                    productsGrid.insertAdjacentHTML("beforeend", html);
                }
            }

            // Update pagination info
            hasMorePages = data.hasMore || false;
            currentPage = data.currentPage || 1;

            clearErrors();
        } else {
            showError(data.message || "Terjadi kesalahan saat memuat produk.");
        }
    }

    function updateProductTitle(query, category) {
        if (!productTitle) return;

        if (query && category) {
            productTitle.textContent = `Hasil Pencarian "${query}" - Kategori ${capitalize(
                category
            )}`;
        } else if (query) {
            productTitle.textContent = `Hasil Pencarian "${query}"`;
        } else if (category) {
            productTitle.textContent = `Kategori ${capitalize(category)}`;
        } else {
            productTitle.textContent = "Produk Terbaru";
        }
    }

    function updateActiveCategoryButton(category) {
        // Remove active class from all buttons
        categoryButtons.forEach((btn) => {
            btn.classList.remove("active");
        });

        // Add active class to selected button
        if (category) {
            const targetButton = document.querySelector(
                `[data-category="${category}"]`
            );
            if (targetButton) {
                targetButton.classList.add("active");
            }
        } else {
            // If no category, activate "all" button (assuming it has data-category="")
            const allButton =
                document.querySelector('[data-category=""]') ||
                document.querySelector(".category-btn:first-child");
            if (allButton) {
                allButton.classList.add("active");
            }
        }

        // Update active category indicator if exists
        const activeCategoryDiv = document.getElementById("active-category");
        const categoryNameSpan = document.getElementById("category-name");

        if (activeCategoryDiv && categoryNameSpan) {
            if (category) {
                activeCategoryDiv.style.display = "block";
                categoryNameSpan.textContent = `Kategori: ${capitalize(
                    category
                )}`;
            } else {
                activeCategoryDiv.style.display = "none";
            }
        }
    }

    function updateURL(query, category) {
        const url = new URL(window.location);

        // Clear existing parameters
        url.searchParams.delete("query");
        url.searchParams.delete("category");

        // Add parameters if they exist
        if (query && query.trim() !== "") {
            url.searchParams.set("query", query.trim());
        }

        if (category && category !== "") {
            url.searchParams.set("category", category);
        }

        // Update URL without reloading
        window.history.replaceState(
            { query: query, category: category },
            "",
            url
        );
    }

    // === Utility Functions ===

    function renderProducts(products) {
        if (!products || products.length === 0) {
            return renderEmptyState();
        }

        return products.map((product) => renderProduct(product)).join("");
    }

    function renderProduct(product) {
        const stars = renderStars(product.rating || 4.5, product.id);
        const formattedPrice = new Intl.NumberFormat("id-ID").format(
            product.price || product.harga || 0
        );

        const productId = product.id || product._id || "unknown";

        return `
        <a href="/product-detail/${productId}" class="block">
            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-slate-200/50 
                        hover:shadow-xl hover:bg-white/90 transition-all duration-300 overflow-hidden
                        hover:-translate-y-1 cursor-pointer">

                <!-- Product Image -->
                <div class="relative overflow-hidden">
                    <img src="${
                        product.image || "https://via.placeholder.com/300x200"
                    }" 
                         alt="${product.name || product.nama}"
                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy">

                    <!-- Badge/Tag -->
                    <div class="absolute top-3 left-3">
                        <span class="bg-blue-600 text-white text-xs font-medium px-2 py-1 rounded-full">
                            ${capitalize(
                                product.kategori || product.category || "umum"
                            )}
                        </span>
                    </div>

                    <!-- Quick Action Buttons -->
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="flex flex-col space-y-2">
                            <button class="p-2 bg-white/90 rounded-full shadow-lg hover:bg-white transition-colors duration-200" onclick="event.preventDefault()">
                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </button>
                            <button class="p-2 bg-white/90 rounded-full shadow-lg hover:bg-white transition-colors duration-200" onclick="event.preventDefault()">
                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-4">
                    <!-- Product Name -->
                    <h3 class="font-semibold text-slate-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
                        ${product.name || product.nama}
                    </h3>

                    <!-- Product Description -->
                    <p class="text-sm text-slate-600 mb-3 line-clamp-2">
                        ${product.description || "Deskripsi tidak tersedia"}
                    </p>

                    <!-- Rating -->
                    <div class="flex items-center mb-3">
                        <div class="flex items-center">
                            ${stars}
                        </div>
                        <span class="text-sm text-slate-500 ml-2">(${
                            product.rating || "4.5"
                        })</span>
                    </div>

                    <!-- Price and Action -->
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-lg font-bold text-slate-900">
                                Rp ${formattedPrice}
                            </span>
                        </div>
                        <button class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white 
                                     rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 
                                     shadow-md hover:shadow-lg text-sm font-medium
                                     transform hover:scale-105 active:scale-95" onclick="event.preventDefault()">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6">
                                </path>
                            </svg>
                            Beli
                        </button>
                    </div>
                </div>
            </div>
        </a>
    `;
    }

    function renderStars(rating, productId) {
        let starsHtml = "";
        for (let i = 1; i <= 5; i++) {
            if (i <= Math.floor(rating)) {
                starsHtml += `
                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                `;
            } else {
                starsHtml += `
                    <svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                `;
            }
        }
        return starsHtml;
    }

    function renderEmptyState() {
        return `
            <div class="col-span-full text-center py-12">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-slate-600 mb-6">
                        Maaf, kami tidak dapat menemukan produk yang sesuai dengan pencarian Anda.
                        Coba gunakan kata kunci lain atau jelajahi kategori produk kami.
                    </p>
                    <button
                        onclick="resetSearch()"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white 
                               rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 
                               shadow-lg hover:shadow-xl font-medium">
                        Lihat Semua Produk
                    </button>
                </div>
            </div>
        `;
    }

    // === UI Helper Functions ===

    function showLoading() {
        if (loadingIndicator) {
            loadingIndicator.classList.remove("hidden");
        }
        if (searchInput) searchInput.disabled = true;
    }

    function hideLoading() {
        if (loadingIndicator) {
            loadingIndicator.classList.add("hidden");
        }
        if (searchInput) searchInput.disabled = false;
    }

    function showError(message) {
        clearErrors();

        const errorDiv = document.createElement("div");
        errorDiv.id = "search-error";
        errorDiv.className =
            "bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 mx-4 lg:mx-8";

        errorDiv.innerHTML = `
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600">
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        `;

        if (productListSection) {
            productListSection.insertBefore(errorDiv, productsGrid);
        }

        setTimeout(() => {
            if (errorDiv && errorDiv.parentNode) {
                errorDiv.remove();
            }
        }, 5000);
    }

    function clearErrors() {
        const existingError = document.getElementById("search-error");
        if (existingError) {
            existingError.remove();
        }
    }

    function scrollToProductList() {
        if (productListSection) {
            const yOffset = -100;
            const y =
                productListSection.getBoundingClientRect().top +
                window.pageYOffset +
                yOffset;

            window.scrollTo({
                top: y,
                behavior: "smooth",
            });
        }
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // === Global Functions ===

    // Reset function that can be called from empty state button
    window.resetSearch = function () {
        currentQuery = "";
        currentCategory = "";
        currentPage = 1;
        hasMorePages = true;

        if (searchInput) {
            searchInput.value = "";
        }

        updateActiveCategoryButton("");
        updateURL("", "");
        performSearch("", "", 1, true);
    };

    // === Browser Navigation ===

    // Handle browser back/forward buttons
    window.addEventListener("popstate", function (event) {
        const urlParams = new URLSearchParams(window.location.search);
        const query = urlParams.get("query") || "";
        const category = urlParams.get("category") || "";

        // Update state
        currentQuery = query;
        currentCategory = category;
        currentPage = 1;
        hasMorePages = true;

        // Update UI
        if (searchInput) {
            searchInput.value = query;
        }

        updateActiveCategoryButton(category);
        performSearch(query, category, 1, true);

        // Scroll to top when navigating with browser buttons
        setTimeout(() => {
            window.scrollTo({ top: 0, behavior: "smooth" });
        }, 100);
    });

    // Additional event listener for page show (handles back/forward and refresh)
    window.addEventListener("pageshow", function (event) {
        // Force scroll to top on page show
        window.scrollTo(0, 0);
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
    });

    // Handle before unload to ensure scroll position is reset
    window.addEventListener("beforeunload", function () {
        window.scrollTo(0, 0);
    });
});
