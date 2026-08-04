// ===== FILE: js/calculator.js =====

/**
 * Calculate rewards based on eligible item count and gift items.
 * @param {number} eligibleItemCount - Number of eligible items in cart
 * @param {number} rewardAmount - Cash reward per unit
 * @param {Array} giftItems - Array of { productName, qty }
 * @param {number} minCount - Minimum items required per reward unit
 * @returns {Object} { reward, freeItems, units }
 */
 function calculateRewards(eligibleItemCount, rewardAmount, giftItems, minCount) {
    if (eligibleItemCount <= 0 || minCount <= 0) {
        return { reward: 0, freeItems: [], units: 0 };
    }
    const units = Math.floor(eligibleItemCount / minCount);
    const totalReward = rewardAmount * units;
    const scaledFreeItems = giftItems.map(gift => ({
        productName: gift.productName,
        qty: gift.qty * units,
        originalQty: gift.qty
    }));
    return { reward: totalReward, freeItems: scaledFreeItems, units: units };
}

/** Show the calculator preview modal with cart simulation */
function showCalculatorPreview() {
    const rule = $('#productFilterRule').val();
    const totalToCount = $('#totalToCount').val();
    const cardReq = $('#condCard').val();
    const cartTotalMin = parseInt($('#condCartTotal').val()) || 0;
    const cartCountMin = parseInt($('#condCartCount').val()) || 10;
    const rewardAmount = parseInt($('#promoAmount').val()) || 0;
    const giftItems = [...currentInStockItems];
    const allowedProducts = [...currentAllowedArray];
    const excludedProducts = [...currentExcludedArray];
    const promoName = $('#promoName').val() || 'Unnamed Promotion';

    let productFilterDetails = '';
    if (rule === 'only') {
        productFilterDetails = `
            <div class="mt-2 p-2 bg-light rounded">
                <strong>✅ Eligible Products (Only these qualify):</strong><br>
                ${allowedProducts.length ? allowedProducts.map(p => `<span class="badge bg-success me-1 mb-1">${escapeHtml(p)}</span>`).join('') : '<span class="text-muted">None selected</span>'}
            </div>`;
    } else if (rule === 'allExcept') {
        productFilterDetails = `
            <div class="mt-2 p-2 bg-light rounded">
                <strong>🚫 Excluded Products (All except these):</strong><br>
                ${excludedProducts.length ? excludedProducts.map(p => `<span class="badge bg-danger me-1 mb-1">${escapeHtml(p)}</span>`).join('') : '<span class="text-muted">None selected</span>'}
            </div>`;
    } else {
        productFilterDetails = `
            <div class="mt-2 p-2 bg-light rounded">
                <strong>🌍 All Products Qualify</strong><br>
                <span class="text-muted">No product restrictions applied</span>
            </div>`;
    }

    function isProductEligible(productName) {
        if (rule === 'only') return allowedProducts.includes(productName);
        if (rule === 'allExcept') return !excludedProducts.includes(productName);
        return true;
    }

    let cartItems = [];
    let productCatalog = [...allProductsCache];

    function renderCalculator() {
        let eligibleSubtotal = 0;
        let eligibleItemCount = 0;
        let ineligibleSubtotal = 0;
        let ineligibleItemCount = 0;
        const sortedItems = [...cartItems].sort((a, b) => (b.price * b.qty) - (a.price * a.qty));

        sortedItems.forEach(item => {
            if (isProductEligible(item.name)) {
                eligibleSubtotal += item.price * item.qty;
                eligibleItemCount += item.qty;
            } else {
                ineligibleSubtotal += item.price * item.qty;
                ineligibleItemCount += item.qty;
            }
        });

        const totalSubtotal = eligibleSubtotal + ineligibleSubtotal;
        let conditionMet = false;
        let conditionText = '';

        if (totalToCount === 'cCount') {
            conditionMet = eligibleItemCount >= cartCountMin;
            conditionText = `📦 Need at least ${cartCountMin} eligible item(s) in cart (currently ${eligibleItemCount} eligible)`;
        } else if (totalToCount === 'CTotal') {
            conditionMet = eligibleSubtotal >= cartTotalMin;
            conditionText = `💰 Need at least $${cartTotalMin} from eligible products (currently $${eligibleSubtotal.toFixed(2)} from eligible items)`;
        } else {
            conditionMet = (eligibleSubtotal >= cartTotalMin && eligibleItemCount >= cartCountMin);
            conditionText = `💰 Need $${cartTotalMin} from eligible products AND 📦 ${cartCountMin} eligible item(s)`;
        }

        const { reward: calculatedReward, freeItems: scaledFreeItems, units } = calculateRewards(
            eligibleItemCount, rewardAmount, giftItems, cartCountMin
        );

        let rewardMessage = '';
        let freeItemsHtml = '';

        if (conditionMet && units > 0) {
            rewardMessage = `
                <div class="alert alert-success mt-3">
                    <i class="bi bi-gift-fill fs-5 me-2"></i>
                    <strong>🎉 Promotion Applied!</strong><br>
                    You will receive <strong>$${calculatedReward}</strong> cashback/reward! (${units} x $${rewardAmount})
                </div>`;
            if (scaledFreeItems.length > 0) {
                freeItemsHtml = `
                    <div class="mt-3 p-3 bg-success bg-opacity-10 rounded">
                        <strong class="fs-6"><i class="bi bi-box-seam-fill me-2"></i>🎁 Free Items You Will Receive:</strong>
                        <ul class="mb-0 mt-2">
                            ${scaledFreeItems.map(gift => `<li><strong>${escapeHtml(gift.productName)}</strong> x ${gift.qty} (base ${gift.originalQty} x ${units} units)</li>`).join('')}
                        </ul>
                    </div>`;
            } else {
                freeItemsHtml = '<div class="alert alert-info mt-2 small">No free items configured for this promotion.</div>';
            }
        } else {
            let missing = [];
            if (totalToCount !== 'CTotal' && eligibleItemCount < cartCountMin) {
                missing.push(`📦 ${cartCountMin - eligibleItemCount} more eligible item(s) needed`);
            }
            if (totalToCount !== 'cCount' && eligibleSubtotal < cartTotalMin) {
                missing.push(`💰 $${(cartTotalMin - eligibleSubtotal).toFixed(2)} more from eligible products needed`);
            }
            rewardMessage = `
                <div class="alert alert-secondary mt-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Conditions Not Met</strong><br>
                    ${missing.join(' • ') || 'Requirements not satisfied'}
                </div>`;
            freeItemsHtml = '<div class="text-muted small mt-3">✨ Add more eligible items to qualify for free gifts and rewards</div>';
        }

        let html = `
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-primary text-white"><i class="bi bi-info-circle-fill me-2"></i> ${escapeHtml(promoName)}</div>
                        <div class="card-body">
                            <h6 class="fw-bold">📋 Conditions</h6>
                            <p><strong>Product Filter Rule:</strong> ${rule === 'only' ? '🔹 Only (Restrict to specific products)' : (rule === 'all' ? '🌍 All (No restrictions)' : '🚫 All Except (Exclude specific products)')}</p>
                            ${productFilterDetails}
                            <hr>
                            <p><strong>Total To Count:</strong> ${totalToCount === 'cCount' ? 'cCount (Eligible item count only)' : (totalToCount === 'CTotal' ? 'CTotal (Eligible cart total only)' : 'both (Eligible total + eligible count)')}</p>
                            ${totalToCount !== 'CTotal' ? `<p><strong>Min Eligible Items:</strong> ${cartCountMin} items</p>` : ''}
                            ${totalToCount !== 'cCount' ? `<p><strong>Min Eligible Cart Total:</strong> $${cartTotalMin}</p>` : ''}
                            <p><strong>Card Required:</strong> ${cardReq === 'yes' ? '✅ Yes' : '❌ No'}</p>
                            <hr>
                            <h6 class="fw-bold">🎁 Rewards (Per ${cartCountMin} eligible items)</h6>
                            <p><strong>Cash Reward per unit:</strong> <span class="text-success fw-bold">$${rewardAmount}</span></p>
                            <p><strong>Free Items per unit:</strong> ${giftItems.length ? giftItems.map(g => `<span class="badge bg-info me-1 mb-1">${escapeHtml(g.productName)} x${g.qty}</span>`).join('') : '<span class="text-muted">None</span>'}</p>
                            ${units > 0 ? `<div class="alert alert-info mt-2 small">✨ ${units} reward unit(s) based on ${eligibleItemCount} eligible items</div>` : ''}
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white"><i class="bi bi-cart-fill me-2"></i> Shopping Cart Simulator</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="fw-semibold">🛒 Add Product to Cart</label>
                                <div class="row g-2">
                                    <div class="col-7">
                                        <select class="form-select" id="productSelect">
                                            <option value="">-- Select Product with Price --</option>
                                            ${productCatalog.map(p => `<option value="${p.id}" data-price="${p.price}" data-name="${escapeHtml(p.name)}">${escapeHtml(p.name)} - $${p.price}</option>`).join('')}
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <input type="number" id="productQty" class="form-control" placeholder="Qty" value="1" min="1">
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-primary w-100" id="addToCartBtn"><i class="bi bi-plus-lg"></i> Add</button>
                                    </div>
                                </div>
                                <small class="text-muted">⚠️ Only eligible products (✅) count towards promotion conditions. Ineligible items (⚠️) are ignored for promotion calculation.</small>
                            </div>
                            <hr>
                            <div><strong>Cart Summary:</strong></div>
                            <div class="p-3 bg-light rounded mt-2">
                                <div class="d-flex justify-content-between mb-2"><strong>💰 Total Cart Value:</strong> <strong>$${totalSubtotal.toFixed(2)}</strong></div>
                                <div class="d-flex justify-content-between mb-2"><strong>✅ Eligible Items Value:</strong> <strong class="text-success">$${eligibleSubtotal.toFixed(2)}</strong></div>
                                <div class="d-flex justify-content-between mb-2"><strong>✅ Eligible Items Count:</strong> <strong class="text-success">${eligibleItemCount}</strong></div>
                                <div class="d-flex justify-content-between"><strong>⚠️ Ineligible Items (ignored):</strong> <strong class="text-warning">${ineligibleItemCount} items / $${ineligibleSubtotal.toFixed(2)}</strong></div>
                            </div>
                            <div class="mt-2"><strong>${conditionText}</strong></div>
                            ${rewardMessage}
                            ${freeItemsHtml}
                            <hr class="mt-3">
                            <div><strong>🛍️ Cart Items (sorted by total value - highest first):</strong></div>
                            <div id="cartItemsList" class="mt-2" style="max-height: 280px; overflow-y: auto;"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#calculatorContent').html(html);

        const cartContainer = $('#cartItemsList');
        if (sortedItems.length === 0) {
            cartContainer.html('<div class="text-muted text-center py-4 bg-white rounded">🛍️ No items in cart. Add products above to test promotion eligibility.</div>');
        } else {
            let cartHtml = '<div class="list-group">';
            sortedItems.forEach((item, idx) => {
                const eligible = isProductEligible(item.name);
                const originalIdx = cartItems.findIndex(i => i.name === item.name && i.price === item.price);
                cartHtml += `
                    <div class="list-group-item cart-item-row" data-item-idx="${originalIdx}">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div style="min-width: 150px;">
                                <strong>${escapeHtml(item.name)}</strong><br>
                                <small class="text-muted">$${item.price.toFixed(2)} each</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <label class="small mb-0">Qty:</label>
                                <input type="number" class="qty-input edit-qty" data-idx="${originalIdx}" value="${item.qty}" min="0" step="1" style="width: 70px;">
                                <span class="fw-bold ms-2" style="min-width: 80px;">Total: $${(item.price * item.qty).toFixed(2)}</span>
                                ${eligible ? '<span class="badge bg-success ms-2">✅ Eligible</span>' : '<span class="badge bg-secondary ms-2">⚠️ Not eligible</span>'}
                                <button class="btn btn-sm btn-outline-danger remove-cart-item" data-idx="${originalIdx}"><i class="bi bi-trash3"></i></button>
                            </div>
                        </div>
                    </div>`;
            });
            cartHtml += '</div>';
            cartContainer.html(cartHtml);
        }

        // Bind quantity changes
        $('.edit-qty').off('change').on('change', function() {
            const idx = $(this).data('idx');
            let newQty = parseInt($(this).val());
            if (isNaN(newQty) || newQty < 0) newQty = 0;
            if (newQty === 0) {
                cartItems.splice(idx, 1);
            } else if (cartItems[idx]) {
                cartItems[idx].qty = newQty;
            }
            renderCalculator();
        });

        // Bind add to cart
        $('#addToCartBtn').off('click').on('click', function() {
            const prodId = $('#productSelect').val();
            if (!prodId) { alert('Please select a product'); return; }
            const qty = parseInt($('#productQty').val()) || 1;
            const product = productCatalog.find(p => p.id === prodId);
            if (product) {
                const existing = cartItems.find(i => i.name === product.name);
                if (existing) existing.qty += qty;
                else cartItems.push({ name: product.name, price: product.price, qty: qty });
                renderCalculator();
            }
        });

        // Bind remove cart item
        $('.remove-cart-item').off('click').on('click', function() {
            const idx = $(this).data('idx');
            cartItems.splice(idx, 1);
            renderCalculator();
        });
    }

    renderCalculator();

    // Enable scroll-on-hover for calculator modal
    setTimeout(() => {
        const calcBody = $('#calculatorModalBody');
        calcBody.off('mousemove').on('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const width = rect.width;
            if (mouseX > width - 10) $(this).addClass('hover-scroll-calc');
            else $(this).removeClass('hover-scroll-calc');
        });
        calcBody.off('mouseleave').on('mouseleave', function() {
            $(this).removeClass('hover-scroll-calc');
        });
    }, 100);

    $('#calculatorModal').modal('show');
}
