<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>PromoManager | Smart Inventory Control (API Integrated)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .promo-dates-section { display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end; align-items: center; }
        @media (max-width: 576px) { .promo-dates-section { justify-content: flex-start; margin-top: 8px; } .promo-header-flex { flex-direction: column; align-items: flex-start; } }
        * { font-family: 'Inter', sans-serif; }
        body { background: linear-gradient(145deg, #f4f7fc 0%, #eef2f5 100%); min-height: 100vh; padding-bottom: 3rem; }
        .promo-card { border-left: 6px solid; transition: all 0.2s; background: white; border-radius: 24px; box-shadow: 0 8px 20px rgba(0,0,0,0.03), 0 2px 4px rgba(0,0,0,0.05); }
        .promo-card:hover { transform: translateY(-3px); box-shadow: 0 20px 30px -12px rgba(0,0,0,0.12); }
        .badge-quick { background: #f97316; color: white; font-weight: 600; padding: 6px 12px; border-radius: 40px; }
        .badge-long { background: #3b82f6; color: white; font-weight: 600; }
        .detail-chip { background: #f1f5f9; border-radius: 40px; padding: 4px 12px; font-size: 0.75rem; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; }
        .form-control, .form-select { border-radius: 18px; padding: 0.6rem 1rem; border: 1px solid #e2e8f0; }
        .hero-title { font-weight: 700; background: linear-gradient(135deg, #1f2b3c, #2c3e50); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .stock-badge { background: #e6f7ec; color: #2b6e3c; border-radius: 20px; font-size: 0.7rem; padding: 2px 8px; }
        .empty-state { background: #f8fafc; border-radius: 48px; text-align: center; padding: 3rem; }
        .item-row { background: #fafcff; border-radius: 16px; padding: 0.5rem; }
        .product-ribbon { background: #f8fafc; border-radius: 20px; padding: 8px 12px; border: 1px solid #e2edf2; margin-top: 8px; display: flex; flex-wrap: wrap; gap: 8px; min-height: 52px; max-height: 150px; overflow-y: auto; }
        .product-badge { background: white; border-radius: 40px; padding: 4px 10px 4px 14px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; }
        .allowed-badge { color: #0f3b5e; border: 1px solid #cbdde9; }
        .excluded-badge { color: #991b1b; background: #fff5f5; border: 1px solid #fecaca; }
        .product-badge i { cursor: pointer; opacity: 0.7; }
        .date-range-compact { background: #f8fafc; border-radius: 32px; padding: 4px 12px; font-size: 0.7rem; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; }
        @media (max-width: 576px) { .date-range-compact { white-space: normal; word-break: break-word; } }
        .promo-header-flex { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 12px; margin-bottom: 12px; }
        .api-select { max-height: 200px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 16px; padding: 8px; margin-top: 8px; background: white; }
        .api-select-item { padding: 8px 12px; cursor: pointer; border-radius: 12px; transition: 0.1s; display: flex; justify-content: space-between; align-items: center; }
        .api-select-item:hover { background: #f1f5f9; }
        .selected-item { background: #e0e7ff; }
        .loading-spinner { display: inline-block; width: 16px; height: 16px; border: 2px solid #f3f3f3; border-top: 2px solid #3498db; border-radius: 50%; animation: spin 1s linear infinite; margin-right: 8px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .console-log-panel { position: fixed; bottom: 20px; right: 20px; width: 350px; background: #1e1e1e; color: #d4d4d4; border-radius: 12px; padding: 12px; font-family: monospace; font-size: 11px; z-index: 9998; box-shadow: 0 4px 12px rgba(0,0,0,0.3); max-height: 300px; overflow-y: auto; display: none; }
        .console-log-panel.show { display: block; }
        .console-header { display: flex; justify-content: space-between; margin-bottom: 8px; padding-bottom: 4px; border-bottom: 1px solid #444; cursor: pointer; }
        .console-header h6 { margin: 0; color: #4ec9b0; }
        .console-log-entry { padding: 4px 0; border-bottom: 1px solid #333; font-size: 10px; word-break: break-word; }
        .console-log-entry.success { color: #4ec9b0; }
        .console-log-entry.error { color: #f48771; }
        .console-log-entry.info { color: #9cdcfe; }
        .toggle-console { position: fixed; bottom: 20px; right: 20px; background: #1e1e1e; color: white; border: none; border-radius: 30px; padding: 8px 16px; font-size: 12px; z-index: 9999; cursor: pointer; display: flex; align-items: center; gap: 8px; }
        .toggle-console:hover { background: #333; }
        .rule-dependent-section, .total-dependent-field { transition: all 0.2s ease; }
        .hidden-rule { display: none !important; }
        .modal-body-scroll { max-height: 70vh; overflow-y: hidden; overflow-x: hidden; position: relative; transition: overflow-y 0.2s ease; }
        .modal-body-scroll.hover-scroll { overflow-y: auto; }
        .modal-body-scroll::-webkit-scrollbar { width: 8px; }
        .modal-body-scroll::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .modal-body-scroll::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
        .required-star::after { content: " *"; color: #dc3545; font-weight: bold; }
        .label-button-row { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 8px; }
        .label-button-row label { margin-bottom: 0; }
        @media (max-width: 768px) {
            .modal-body-scroll { max-height: 65vh; }
            .product-badge { white-space: normal; word-break: break-word; }
            .label-button-row { flex-direction: column; align-items: flex-start; }
        }
        .modal-content { border-radius: 28px; }
        .cart-item-row { background: #f8f9fa; border-radius: 12px; padding: 10px; margin-bottom: 8px; transition: all 0.2s; }
        .cart-item-row:hover { background: #e9ecef; }
        .calculator-modal-scroll { max-height: 75vh; overflow-y: hidden; position: relative; }
        .calculator-modal-scroll.hover-scroll-calc { overflow-y: auto; }
        .calculator-modal-scroll::-webkit-scrollbar { width: 8px; }
        .calculator-modal-scroll::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .calculator-modal-scroll::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
        .qty-input { width: 70px; text-align: center; border-radius: 20px; border: 1px solid #dee2e6; padding: 4px 8px; }
        .qty-input:focus { outline: none; border-color: #86b7fe; box-shadow: 0 0 0 2px rgba(13,110,253,0.25); }
    </style>
</head>
<body>

<div class="container py-4 py-md-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-5">
        <div>
            <h1 class="display-5 fw-bold hero-title"><i class="bi bi-gift-fill text-warning me-2"></i>PromoStudio</h1>
            <p class="text-secondary-emphasis mt-1">Smart inventory • <span id="apiStatus"><i class="bi bi-cloud-check"></i> Server-driven product catalog</span></p>
        </div>
        <button class="btn btn-dark rounded-pill px-4 shadow-sm" id="createNewPromoBtn"><i class="bi bi-plus-lg me-2"></i>New Promotion</button>
    </div>
    <div id="promotionsGrid" class="row g-4"></div>
</div>

<button class="toggle-console" id="toggleConsoleBtn"><i class="bi bi-terminal-fill"></i> Console Logs</button>
<div class="console-log-panel" id="consolePanel">
    <div class="console-header" id="clearConsoleBtn"><h6><i class="bi bi-bug"></i> Promotion Logger</h6><i class="bi bi-x-lg" id="closeConsoleBtn"></i></div>
    <div id="consoleLogs"><div class="console-log-entry info">📋 Ready</div></div>
</div>

<!-- Main Promo Modal -->
<div class="modal fade" id="promoModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold fs-3" id="modalTitle">✨ Create Promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4 modal-body-scroll" id="scrollableModalBody">
                <form id="promoForm">
                    <input type="hidden" id="editId">
                    <div class="row g-3">
                        <div class="col-md-12"><label class="form-label fw-semibold required-star"><i class="bi bi-tag-fill me-1"></i> Promotion Name</label><input type="text" class="form-control" id="promoName" required></div>
                        <div class="col-md-12"><label class="form-label fw-semibold"><i class="bi bi-upc-scan me-1"></i> Promotion ID</label><input type="text" class="form-control" id="promoId" readonly style="background:#e9ecef; font-family: monospace;"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Promo Type</label><select class="form-select" id="promoType"><option value="quick">🔥 Quick</option><option value="long">⏳ Long</option></select></div>
                        <div class="col-md-6"><label class="form-label fw-semibold required-star">Start Date & Time</label><input type="text" class="form-control" id="startDatetime" autocomplete="off"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold required-star">End Date & Time</label><input type="text" class="form-control" id="endDatetime" autocomplete="off"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Amount (Reward $)</label><input type="number" class="form-control" id="promoAmount" value="100"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Total To Count</label><select class="form-select" id="totalToCount"><option value="cCount">cCount (Count items only)</option><option value="both">both (Cart Total + Count)</option><option value="CTotal">CTotal (Cart Total only)</option></select></div>
                        <div class="col-md-6 total-dependent-field" id="cartTotalField"><label class="form-label fw-semibold">Cart Total (min $)</label><input type="number" class="form-control" id="condCartTotal" value="500"></div>
                        <div class="col-md-6 total-dependent-field" id="cartCountField"><label class="form-label fw-semibold">Cart Count (min items)</label><input type="number" class="form-control" id="condCartCount" value="10"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Card Required?</label><select class="form-select" id="condCard"><option value="yes">Yes</option><option value="no">No</option></select></div>
                        <div class="col-md-12"><label class="form-label fw-semibold"><i class="bi bi-funnel-fill me-1"></i> Product Filter Rule</label><select class="form-select" id="productFilterRule"><option value="only">🔹 Only (Restrict to specific products)</option><option value="all">🌍 All (No restrictions - any product qualifies)</option><option value="allExcept">🚫 All Except (Exclude specific products)</option></select></div>
                        <div class="col-md-12 rule-dependent-section" id="selectProductsSection"><div class="label-button-row"><label class="form-label fw-semibold required-star"><i class="bi bi-check-circle-fill text-success me-1"></i> ✅ Select Eligible Products (Required)</label><button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" id="openAllowedApiBtn"><i class="bi bi-database"></i> Browse Products</button></div><div id="allowedProductsRibbon" class="product-ribbon"></div><div id="allowedProductsError" class="text-danger small mt-1" style="display:none;">⚠️ Please add at least one eligible product</div></div>
                        <div class="col-md-12 rule-dependent-section" id="excludedSectionWrapper"><div class="label-button-row"><label class="form-label fw-semibold required-star"><i class="bi bi-x-circle-fill text-danger me-1"></i> 🚫 Excluded Products (Required)</label><button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" id="openExcludedApiBtn"><i class="bi bi-database"></i> Browse Products</button></div><div id="excludedProductsRibbon" class="product-ribbon"></div><div id="excludedProductsError" class="text-danger small mt-1" style="display:none;">⚠️ Please add at least one excluded product</div></div>
                        <div class="col-12"><hr><div class="d-flex flex-wrap justify-content-between align-items-center gap-2"><label class="fw-semibold"><i class="bi bi-box-seam"></i> 🎁 InStock Items (Gifts / Rewards)</label><button type="button" class="btn btn-sm btn-outline-primary rounded-pill" id="addItemFromApiBtn"><i class="bi bi-plus-circle"></i> Add from Catalog</button></div><div id="itemsInStockContainer" class="bg-light bg-opacity-25 p-2 rounded-3"></div></div>
                        <div class="col-md-12"><label class="form-label fw-semibold">Target Point (optional)</label><input type="number" class="form-control" id="targetPoint" placeholder="7000"></div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4 pt-2">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-info rounded-pill px-4 text-white" id="calculatorPreviewBtn" disabled><i class="bi bi-calculator-fill me-1"></i> Calculator Preview</button>
                        <button type="submit" class="btn btn-dark rounded-pill px-5">Save Promotion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Calculator Preview Modal -->
<div class="modal fade" id="calculatorModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold fs-3"><i class="bi bi-calculator-fill me-2"></i>Promotion Calculator Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4 calculator-modal-scroll" id="calculatorModalBody">
                <div id="calculatorContent">Loading...</div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Product Picker Modal -->
<div class="modal fade" id="productPickerModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-bottom-0"><h5 class="modal-title fw-bold" id="pickerModalTitle">Select Products</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body"><div class="mb-2"><input type="text" id="pickerSearch" class="form-control" placeholder="Search products..."></div><div id="pickerProductList" class="api-select"></div></div>
            <div class="modal-footer border-0"><button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary rounded-pill" id="confirmPickerSelection">Add Selected</button></div>
        </div>
    </div>
</div>

<script>
    let allProductsCache = [];
    let currentAllowedArray = [], currentExcludedArray = [], currentInStockItems = [];
    let startPicker, endPicker;
    let promotionsData = [];

    const FALLBACK_PRODUCTS = [
        { id: "p1", name: "Fresh Milk", category: "dairy", price: 3.99 },
        { id: "p2", name: "Whole Wheat Bread", category: "bakery", price: 2.99 },
        { id: "p3", name: "Coca Cola", category: "beverage", price: 1.99 },
        { id: "p4", name: "Potato Chips", category: "snacks", price: 3.49 },
        { id: "p5", name: "Orange Juice", category: "beverage", price: 4.49 },
        { id: "p6", name: "Premium Beer", category: "alcohol", price: 5.99 },
        { id: "p7", name: "Chocolate Bar", category: "candy", price: 1.49 },
        { id: "p8", name: "Frozen Pizza", category: "frozen", price: 8.99 }
    ];

    async function fetchProducts() {
        try {
            const res = await fetch('https://fakestoreapi.com/products');
            if (res.ok) {
                const data = await res.json();
                return data.slice(0, 15).map(p => ({
                    id: p.id.toString(), name: p.title.substring(0, 30),
                    category: p.category, price: p.price }));
            }
        } catch(e) {}
        return [...FALLBACK_PRODUCTS];
    }

    function updateAPIStatus(status) { $('#apiStatus').html(status === 'online' ? '<i class="bi bi-cloud-check-fill text-success"></i> Server connected' : '<i class="bi bi-cloud-slash-fill text-warning"></i> Offline mode'); }

    function validateCalculatorButton() {
        const name = $('#promoName').val().trim();
        const startDate = $('#startDatetime').val();
        const endDate = $('#endDatetime').val();
        const rule = $('#productFilterRule').val();
        let isValid = name && startDate && endDate;
        if (rule === 'only') isValid = isValid && currentAllowedArray.length > 0;
        if (rule === 'allExcept') isValid = isValid && currentExcludedArray.length > 0;
        $('#calculatorPreviewBtn').prop('disabled', !isValid);
        return isValid;
    }

    function bindFormValidation() { $('#promoName, #startDatetime, #endDatetime, #productFilterRule').on('input change', () => validateCalculatorButton()); }

    function calculateRewards(eligibleItemCount, rewardAmount, giftItems, minCount) {
        if (eligibleItemCount <= 0 || minCount <= 0) return { reward: 0, freeItems: [], units: 0 };
        const units = Math.floor(eligibleItemCount / minCount);
        const totalReward = rewardAmount * units;
        const scaledFreeItems = giftItems.map(gift => ({
            productName: gift.productName,
            qty: gift.qty * units,
            originalQty: gift.qty
        }));
        return { reward: totalReward, freeItems: scaledFreeItems, units: units };
    }
    function normalizePromo(promo) {
 if (!promo.promotion.items) promo.promotion.items = { inStock: [], OutStock: [] };
 if (!promo.promotion.items.inStock) promo.promotion.items.inStock = [];
 if (!promo.condition.products) promo.condition.products = [];
 if (!promo.condition.exProducts) promo.condition.exProducts = [];
 if (!promo.name) promo.name = promo.id;
 return promo;
}
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
            productFilterDetails = `<div class="mt-2 p-2 bg-light rounded"><strong>✅ Eligible Products (Only these qualify):</strong><br>${allowedProducts.length ? allowedProducts.map(p => `<span class="badge bg-success me-1 mb-1">${escapeHtml(p)}</span>`).join('') : '<span class="text-muted">None selected</span>'}</div>`;
        } else if (rule === 'allExcept') {
            productFilterDetails = `<div class="mt-2 p-2 bg-light rounded"><strong>🚫 Excluded Products (All except these):</strong><br>${excludedProducts.length ? excludedProducts.map(p => `<span class="badge bg-danger me-1 mb-1">${escapeHtml(p)}</span>`).join('') : '<span class="text-muted">None selected</span>'}</div>`;
        } else {
            productFilterDetails = `<div class="mt-2 p-2 bg-light rounded"><strong>🌍 All Products Qualify</strong><br><span class="text-muted">No product restrictions applied</span></div>`;
        }

        function isProductEligible(productName) {
            if (rule === 'only') return allowedProducts.includes(productName);
            if (rule === 'allExcept') return !excludedProducts.includes(productName);
            return true;
        }

        let cartItems = [];
        let productCatalog = [...allProductsCache];

        function renderCalculator() {
            // Calculate eligible subtotal and eligible count ONLY
            let eligibleSubtotal = 0;
            let eligibleItemCount = 0;
            let ineligibleSubtotal = 0;
            let ineligibleItemCount = 0;

            // Sort cart items in descending order by total price (price * qty)
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
            const totalItems = eligibleItemCount + ineligibleItemCount;

            // Check conditions using ONLY eligible items for both count AND total
            let conditionMet = false;
            let conditionText = '';

            if (totalToCount === 'cCount') {
                conditionMet = eligibleItemCount >= cartCountMin;
                conditionText = `📦 Need at least ${cartCountMin} eligible item(s) in cart (currently ${eligibleItemCount} eligible)`;
            } else if (totalToCount === 'CTotal') {
                conditionMet = eligibleSubtotal >= cartTotalMin;
                conditionText = `💰 Need at least $${cartTotalMin} from eligible products (currently $${eligibleSubtotal.toFixed(2)} from eligible items)`;
            } else { // both
                conditionMet = (eligibleSubtotal >= cartTotalMin && eligibleItemCount >= cartCountMin);
                conditionText = `💰 Need $${cartTotalMin} from eligible products AND 📦 ${cartCountMin} eligible item(s)`;
            }

            // Calculate rewards based on eligible items
            const { reward: calculatedReward, freeItems: scaledFreeItems, units } = calculateRewards(eligibleItemCount, rewardAmount, giftItems, cartCountMin);

            let rewardMessage = '';
            let freeItemsHtml = '';

            if (conditionMet && units > 0) {
                rewardMessage = `<div class="alert alert-success mt-3"><i class="bi bi-gift-fill fs-5 me-2"></i> <strong>🎉 Promotion Applied!</strong><br>You will receive <strong>$${calculatedReward}</strong> cashback/reward! (${units} x $${rewardAmount})</div>`;
                if (scaledFreeItems.length > 0) {
                    freeItemsHtml = '<div class="mt-3 p-3 bg-success bg-opacity-10 rounded"><strong class="fs-6"><i class="bi bi-box-seam-fill me-2"></i>🎁 Free Items You Will Receive:</strong><ul class="mb-0 mt-2">';
                    scaledFreeItems.forEach(gift => {
                        freeItemsHtml += `<li><strong>${escapeHtml(gift.productName)}</strong> x ${gift.qty} (base ${gift.originalQty} x ${units} units)</li>`;
                    });
                    freeItemsHtml += '</ul></div>';
                } else {
                    freeItemsHtml = '<div class="alert alert-info mt-2 small">No free items configured for this promotion.</div>';
                }
            } else {
                let missing = [];
                if (totalToCount !== 'CTotal' && eligibleItemCount < cartCountMin) missing.push(`📦 ${cartCountMin - eligibleItemCount} more eligible item(s) needed`);
                if (totalToCount !== 'cCount' && eligibleSubtotal < cartTotalMin) missing.push(`💰 $${(cartTotalMin - eligibleSubtotal).toFixed(2)} more from eligible products needed`);
                rewardMessage = `<div class="alert alert-secondary mt-3"><i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Conditions Not Met</strong><br>${missing.join(' • ') || 'Requirements not satisfied'}</div>`;
                freeItemsHtml = '<div class="text-muted small mt-3">✨ Add more eligible items to qualify for free gifts and rewards</div>';
            }

            let html = `
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-3 shadow-sm"><div class="card-header bg-primary text-white"><i class="bi bi-info-circle-fill me-2"></i> ${escapeHtml(promoName)}</div>
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
                        </div></div>
                    </div>
                    <div class="col-md-8">
                        <div class="card shadow-sm"><div class="card-header bg-dark text-white"><i class="bi bi-cart-fill me-2"></i> Shopping Cart Simulator</div>
                        <div class="card-body">
                            <div class="mb-3"><label class="fw-semibold">🛒 Add Product to Cart</label>
                            <div class="row g-2"><div class="col-7"><select class="form-select" id="productSelect"><option value="">-- Select Product with Price --</option>${productCatalog.map(p => `<option value="${p.id}" data-price="${p.price}" data-name="${escapeHtml(p.name)}">${escapeHtml(p.name)} - $${p.price}</option>`).join('')}</select></div>
                            <div class="col-3"><input type="number" id="productQty" class="form-control" placeholder="Qty" value="1" min="1"></div>
                            <div class="col-2"><button class="btn btn-primary w-100" id="addToCartBtn"><i class="bi bi-plus-lg"></i> Add</button></div></div>
                            <small class="text-muted">⚠️ Only eligible products (✅) count towards promotion conditions. Ineligible items (⚠️) are ignored for promotion calculation.</small></div>
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
                        </div></div>
                    </div>
                </div>
            `;

            $('#calculatorContent').html(html);

            const cartContainer = $('#cartItemsList');
            if (sortedItems.length === 0) cartContainer.html('<div class="text-muted text-center py-4 bg-white rounded">🛍️ No items in cart. Add products above to test promotion eligibility.</div>');
            else {
                let cartHtml = '<div class="list-group">';
                sortedItems.forEach((item, idx) => {
                    const eligible = isProductEligible(item.name);
                    const originalIdx = cartItems.findIndex(i => i.name === item.name && i.price === item.price);
                    cartHtml += `<div class="list-group-item cart-item-row" data-item-idx="${originalIdx}">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div style="min-width: 150px;"><strong>${escapeHtml(item.name)}</strong><br><small class="text-muted">$${item.price.toFixed(2)} each</small></div>
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

            // Bind inline edit quantity events
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
            $('.remove-cart-item').off('click').on('click', function() {
                const idx = $(this).data('idx');
                cartItems.splice(idx, 1);
                renderCalculator();
            });
        }

        renderCalculator();

        setTimeout(() => {
            const calcBody = $('#calculatorModalBody');
            calcBody.off('mousemove').on('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const mouseX = e.clientX - rect.left;
                const width = rect.width;
                if (mouseX > width - 10) $(this).addClass('hover-scroll-calc');
                else $(this).removeClass('hover-scroll-calc');
            });
            calcBody.off('mouseleave').on('mouseleave', function() { $(this).removeClass('hover-scroll-calc'); });
        }, 100);

        $('#calculatorModal').modal('show');
    }

    // UI Management (same as before)
    function updateProductUIs() {
        const allowedRibbon = $('#allowedProductsRibbon');
        allowedRibbon.empty();
        if (currentAllowedArray.length === 0) allowedRibbon.html('<span class="text-muted fst-italic">No products selected</span>');
        else currentAllowedArray.forEach(prod => { allowedRibbon.append(`<span class="product-badge allowed-badge"><span>${escapeHtml(prod)}</span><i class="bi bi-x-circle-fill remove-allowed" data-product="${escapeHtml(prod)}"></i></span>`); });

        const excludedRibbon = $('#excludedProductsRibbon');
        excludedRibbon.empty();
        if (currentExcludedArray.length === 0) excludedRibbon.html('<span class="text-muted fst-italic">No excluded products</span>');
        else currentExcludedArray.forEach(prod => { excludedRibbon.append(`<span class="product-badge excluded-badge"><span>${escapeHtml(prod)}</span><i class="bi bi-x-circle-fill remove-excluded" data-product="${escapeHtml(prod)}"></i></span>`); });

        const container = $('#itemsInStockContainer');
        container.empty();
        if (currentInStockItems.length === 0) container.html('<div class="alert alert-light small text-center">No gift items. Click "Add from Catalog" to add.</div>');
        else {
            currentInStockItems.forEach((item, idx) => {
                container.append(`<div class="row g-2 mb-2 inStockRow align-items-center item-row" data-idx="${idx}">
                    <div class="col-6"><input type="text" class="form-control form-control-sm itemName" value="${escapeHtml(item.productName)}" readonly style="background:#f3f4f6;"></div>
                    <div class="col-3"><input type="number" class="form-control form-control-sm itemQty" value="${item.qty}" min="1"></div>
                    <div class="col-3"><button type="button" class="btn btn-sm btn-outline-danger rounded-pill removeInstockBtn"><i class="bi bi-trash"></i> Remove</button></div>
                </div>`);
            });
        }
        $('.itemQty').off('change').on('change', function() {
            const row = $(this).closest('.inStockRow');
            const idx = row.data('idx');
            if (idx !== undefined && currentInStockItems[idx]) currentInStockItems[idx].qty = parseInt($(this).val()) || 1;
            validateCalculatorButton();
        });
        $('.removeInstockBtn').off('click').on('click', function() {
            const row = $(this).closest('.inStockRow');
            const idx = row.data('idx');
            if (idx !== undefined) { currentInStockItems.splice(idx, 1); updateProductUIs(); validateCalculatorButton(); }
        });
        validateCalculatorButton();
    }

    function updateTotalFieldsVisibility() {
        const val = $('#totalToCount').val();
        $('#cartTotalField').toggleClass('hidden-rule', val === 'cCount');
        $('#cartCountField').toggleClass('hidden-rule', val === 'CTotal');
        validateCalculatorButton();
    }

    function updateUIBasedOnRule(rule) {
        $('#selectProductsSection').toggleClass('hidden-rule', rule !== 'only');
        $('#excludedSectionWrapper').toggleClass('hidden-rule', rule !== 'allExcept');
        validateCalculatorButton();
    }

    function initModalScrollBehavior() {
        const mb = $('#scrollableModalBody');
        mb.off('mousemove').on('mousemove', function(e) { const rect = this.getBoundingClientRect(); if (e.clientX - rect.left > rect.width - 10) $(this).addClass('hover-scroll'); else $(this).removeClass('hover-scroll'); });
        mb.off('mouseleave').on('mouseleave', function() { $(this).removeClass('hover-scroll'); });
    }

    function setupDatePickers() {
        if (startPicker) startPicker.destroy();
        if (endPicker) endPicker.destroy();
        startPicker = flatpickr("#startDatetime", { enableTime: true, dateFormat: "Y-m-d H:i", time_24hr: true, onChange: () => validateCalculatorButton() });
        endPicker = flatpickr("#endDatetime", { enableTime: true, dateFormat: "Y-m-d H:i", time_24hr: true, onChange: () => validateCalculatorButton() });
    }

    let selectedTempProducts = [], pickerMode = '';
    async function openProductPicker(mode) {
        pickerMode = mode;
        if (!allProductsCache.length) { $("#pickerProductList").html('<div class="text-center p-3"><span class="loading-spinner"></span> Loading products...</div>'); allProductsCache = await fetchProducts(); updateAPIStatus('online'); }
        $("#pickerModalTitle").html(mode === 'allowed' ? '📋 Select Eligible Products' : (mode === 'excluded' ? '🚫 Select Excluded Products' : '🎁 Select Gift Items'));
        selectedTempProducts = [];
        renderPickerList(allProductsCache);
        new bootstrap.Modal(document.getElementById('productPickerModal')).show();
    }

    function renderPickerList(products) {
        const container = $("#pickerProductList");
        container.empty();
        const searchTerm = $("#pickerSearch").val().toLowerCase();
        let filtered = products.filter(p => p.name.toLowerCase().includes(searchTerm));
        if (searchTerm && !products.some(p => p.name.toLowerCase() === searchTerm)) filtered.unshift({ id: 'new', name: searchTerm, isNew: true, price: 0 });
        filtered.forEach(prod => {
            const isSelected = selectedTempProducts.includes(prod.name);
            container.append(`<div class="api-select-item ${isSelected ? 'selected-item' : ''}" data-product-name="${prod.name}" data-is-new="${prod.isNew || false}"><span><i class="bi ${prod.isNew ? 'bi-plus-circle-fill text-primary' : 'bi-box'}"></i> ${escapeHtml(prod.name)} ${prod.price ? `- $${prod.price}` : ''}</span><i class="bi ${isSelected ? 'bi-check-circle-fill text-success' : 'bi-plus-circle'}"></i></div>`);
        });
        $('.api-select-item').off('click').on('click', function() {
            const pname = $(this).data('product-name');
            const isNew = $(this).data('is-new');
            if (isNew) { allProductsCache.push({ id: Date.now().toString(), name: pname, category: 'custom', price: 0 }); selectedTempProducts.push(pname); renderPickerList(allProductsCache); }
            else { if (selectedTempProducts.includes(pname)) selectedTempProducts = selectedTempProducts.filter(p => p !== pname); else selectedTempProducts.push(pname); renderPickerList(products); }
        });
    }

    $("#pickerSearch").on('input', function() { renderPickerList(allProductsCache); });
    $("#confirmPickerSelection").on('click', function() {
        if (pickerMode === 'allowed') selectedTempProducts.forEach(p => { if (!currentAllowedArray.includes(p)) currentAllowedArray.push(p); });
        else if (pickerMode === 'excluded') selectedTempProducts.forEach(p => { if (!currentExcludedArray.includes(p)) currentExcludedArray.push(p); });
        else if (pickerMode === 'instock') selectedTempProducts.forEach(p => { if (!currentInStockItems.some(i => i.productName === p)) currentInStockItems.push({ productName: p, qty: 1 }); });
        updateProductUIs();
        $('#productPickerModal').modal('hide');
    });
    $(document).on('click', '.remove-allowed', function() { currentAllowedArray = currentAllowedArray.filter(p => p !== $(this).data('product')); updateProductUIs(); });
    $(document).on('click', '.remove-excluded', function() { currentExcludedArray = currentExcludedArray.filter(p => p !== $(this).data('product')); updateProductUIs(); });

    function generateRandomPromoId() { return 'PRM_' + Date.now().toString(36).toUpperCase() + '_' + Math.random().toString(36).substring(2, 8).toUpperCase(); }

    function openPromoModal(promo) {
        $('#promoForm')[0].reset();
        $('#editId').val('');
        setupDatePickers();
        if (promo) {
            actionPromo = "EditPromo";
            $('#modalTitle').text('✏️ Edit Promotion');
            $('#editId').val(promo.id);
            $('#promoId').val(promo.id);
            $('#promoName').val(promo.name);
            $('#promoType').val(promo.promotype);
            $('#promoAmount').val(promo.promotion.amount);
            $('#condCartTotal').val(promo.condition.cartTotal);
            $('#condCartCount').val(promo.condition.cartCount);
            $('#condCard').val(promo.condition.card);
            $('#totalToCount').val(promo.condition.TotalToCount);
            $('#targetPoint').val(promo.condition.TargetPoint || '');
            if (promo.startDate) startPicker.setDate(new Date(promo.startDate));
            if (promo.endDate) endPicker.setDate(new Date(promo.endDate));
            $('#productFilterRule').val(promo.condition.productRule);
            currentAllowedArray = [...(promo.condition.products || [])];
            currentExcludedArray = [...(promo.condition.exProducts || [])];
            currentInStockItems = [...(promo.promotion.items.inStock || [])];
        } else {
            $('#modalTitle').text('✨ Create New Promotion');
            $('#promoId').val(generateRandomPromoId());
            $('#promoName').val('');
            $('#promoType').val('quick');
            $('#promoAmount').val(100);
            $('#condCartTotal').val(500);
            $('#condCartCount').val(10);
            $('#condCard').val('yes');
            $('#totalToCount').val('cCount');
            $('#targetPoint').val('');
            startPicker.clear(); endPicker.clear();
            $('#productFilterRule').val('only');
            currentAllowedArray = [];
            currentExcludedArray = [];
            currentInStockItems = [];
        }
        updateUIBasedOnRule($('#productFilterRule').val());
        updateTotalFieldsVisibility();
        updateProductUIs();
        setTimeout(() => initModalScrollBehavior(), 100);
        new bootstrap.Modal(document.getElementById('promoModal')).show();
    }
    function savePromotion() {
        const promoId = $('#promoId').val();
        const name = $('#promoName').val();
        if (!name) { alert("Promotion Name required"); return false; }
        if (!startPicker.input.value || !endPicker.input.value) { alert("Start and End dates required"); return false; }
        const rule = $('#productFilterRule').val();
        if (rule === 'only' && currentAllowedArray.length === 0) { alert("Eligible products required for 'Only' rule"); return false; }
        if (rule === 'allExcept' && currentExcludedArray.length === 0) { alert("Excluded products required for 'All Except' rule"); return false; }

        const newPromo = {
            id: promoId, name, startDate: startPicker.input.value, endDate: endPicker.input.value,
            promotype: $('#promoType').val(),
            promotion: { amount: parseInt($('#promoAmount').val()), items: { inStock: currentInStockItems.map(i => ({ productName: i.productName, qty: i.qty })), OutStock: [] } },
            condition: {
                products: [...currentAllowedArray], exProducts: [...currentExcludedArray], productRule: rule,
                TotalToCount: $('#totalToCount').val(), cartTotal: parseInt($('#condCartTotal').val()) || 0,
                cartCount: parseInt($('#condCartCount').val()) || 0, card: $('#condCard').val()
            }
        };
        const target = $('#targetPoint').val();
        if (target && newPromo.promotype === 'long')
        newPromo.condition.TargetPoint = parseInt(target);

        const editId = $('#editId').val();
        if (!editId) promotionsData.push(newPromo);
        else { const idx = promotionsData.findIndex(p => p.id === editId); if (idx !== -1) promotionsData[idx] = newPromo; }
       //
        //console.log((newPromo);
        PromoNewEditDelete(newPromo);
        $('#promoModal').modal('hide');
        return true;
    }

    /*function savePromotion() {
        const promoId = $('#promoId').val();
        const name = $('#promoName').val();
        if (!name) { alert("Promotion Name required"); return false; }
        if (!startPicker.input.value || !endPicker.input.value) { alert("Start and End dates required"); return false; }
        const rule = $('#productFilterRule').val();
        if (rule === 'only' && currentAllowedArray.length === 0) { alert("Eligible products required for 'Only' rule"); return false; }
        if (rule === 'allExcept' && currentExcludedArray.length === 0) { alert("Excluded products required for 'All Except' rule"); return false; }

        const newPromo = {
            id: promoId, name, startDate: startPicker.input.value, endDate: endPicker.input.value,
            promotype: $('#promoType').val(),
            promotion: { amount: parseInt($('#promoAmount').val()), items: { inStock: currentInStockItems.map(i => ({ productName: i.productName, qty: i.qty })), OutStock: [] } },
            condition: {
                products: [...currentAllowedArray], exProducts: [...currentExcludedArray], productRule: rule,
                TotalToCount: $('#totalToCount').val(), cartTotal: parseInt($('#condCartTotal').val()) || 0,
                cartCount: parseInt($('#condCartCount').val()) || 0, card: $('#condCard').val()
            }
        };
        const target = $('#targetPoint').val();
        if (target && newPromo.promotype === 'long') newPromo.condition.TargetPoint = parseInt(target);

        const editId = $('#editId').val();
        if (!editId) promotionsData.push(newPromo);
        else { const idx = promotionsData.findIndex(p => p.id === editId); if (idx !== -1) promotionsData[idx] = newPromo; }
       //
        //console.log((newPromo);
        PromoNewEditDelete(newPromo);
        $('#promoModal').modal('hide');
        return true;
    }*/
    function PromoNewEditDelete(promo) {
 var Usertoken = localStorage.getItem("Usertoken");
 $.ajax({
   url: `./api/${actionPromo}`, type: 'post',
   beforeSend: function (xhr) { xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`); },
   data: { promoArrId: myIndex, promo: promo, allowproducts: promo.condition.products.join(', ') || 'none', exproducts: promo.condition.exProducts.join(', ') || 'none', mainPromoId: mainPromoId, app_vers: '{{env('APP_VERS')}}' },
   success: function (data) {
    renderPromotions();
       console.log("SUCCESS:", data); },
   error: function (xhr, status, error) { console.error("Error:", error); }
 });
}
    /*function renderPromotions() {
        const grid = $("#promotionsGrid");
        if (!promotionsData.length) { grid.html(`<div class="col-12"><div class="empty-state"><i class="bi bi-ticket-perforated fs-1 text-muted"></i><h4>No promotions</h4><button class="btn btn-dark mt-3" id="createFirstPromoBtn"><i class="bi bi-plus-lg"></i> Create First Promotion</button></div></div>`); $('#createFirstPromoBtn').off('click').on('click', () => openPromoModal(null)); return; }
        let html = '';
        promotionsData.forEach(promo => {
            const isQuick = promo.promotype === 'quick';
            const borderColor = isQuick ? '#f97316' : '#3b82f6';
            const startDisplay = promo.startDate ? new Date(promo.startDate).toLocaleString() : '';
            const endDisplay = promo.endDate ? new Date(promo.endDate).toLocaleString() : '';
            const itemsPreview = (promo.promotion.items.inStock || []).map(it => `<span class="stock-badge me-1">${escapeHtml(it.productName)} (x${it.qty})</span>`).join('');
            html += `<div class="col-md-6 col-xl-6"><div class="promo-card p-3 h-100" style="border-left-color: ${borderColor};">
                <div class="promo-header-flex"><div><span class="badge ${isQuick ? 'badge-quick' : 'badge-long'}">${isQuick ? 'QUICK' : 'LONG'}</span><h4 class="fw-bold mt-2">${escapeHtml(promo.name)}</h4><div class="text-muted small">${escapeHtml(promo.id)}</div></div>
                <div class="promo-dates-section"><div class="date-range-compact"><i class="bi bi-calendar-range"></i> ${startDisplay} — ${endDisplay}</div><div class="dropdown"><button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button><ul class="dropdown-menu"><li><a class="dropdown-item edit-promo" href="#" data-id="${promo.id}">Edit</a></li><li><a class="dropdown-item text-danger delete-promo" href="#" data-id="${promo.id}">Delete</a></li></ul></div></div></div>
                <div><span class="detail-chip">Reward: $${promo.promotion.amount}</span><span class="detail-chip">${promo.condition.TotalToCount === 'cCount' ? '📦 Count only' : (promo.condition.TotalToCount === 'CTotal' ? '💰 Total only' : 'Both')}</span></div>
                <div class="mt-2"><strong>🎁 Free items:</strong> <div>${itemsPreview || '—'}</div></div>
            </div></div>`;
        });
        grid.html(html);
    }*/
    function renderPromotions() {
 var Usertoken = localStorage.getItem("Usertoken");
 $.ajax({
   url: `./api/getPromoData`,
   type: 'get',
   headers: { "Content-Type": "application/json;charset=UTF-8", "Authorization": `Bearer ${Usertoken}` },
   data: { app_vers: '{{env('APP_VERS')}}' },
   success: function(data) {
     if (data.status) {
       var dataResult = data.result;
       var promo = (Array.isArray(JSON.parse(dataResult[0]["promoschema"]))) ? JSON.parse(dataResult[0]["promoschema"]) : [JSON.parse(dataResult[0]["promoschema"])];
       promotionsData = promo;
       mainPromoId = dataResult[0]["uid"];
       const grid = $("#promotionsGrid");
       if (!promotionsData.length) { grid.html(`<div class="col-12"><div class="empty-state"><i class="bi bi-ticket-perforated fs-1 text-muted"></i><h4>No promotions</h4></div></div>`); return; }
       let html = '';
       promotionsData.forEach((promo, index) => {
         const isQuick = promo.promotype === 'quick';
         const borderColor = isQuick ? '#f97316' : '#3b82f6';
         const startDisplay = promo.startDate ? new Date(promo.startDate).toLocaleString() : '';
            const endDisplay = promo.endDate ? new Date(promo.endDate).toLocaleString() : '';

         const dateChips = (startDisplay && endDisplay) ? `<div class="date-range-compact"><i class="bi bi-calendar-range"></i> ${startDisplay} — ${endDisplay}</div>` : '<div class="date-range-compact">No dates</div>';
         const itemsPreview = (promo.promotion.items.inStock || []).map(it => `<span class="stock-badge me-1">${escapeHtml(it.productName)} (x${it.qty})</span>`).join('');
         html += `<div class="col-md-6 col-xl-6"><div class="promo-card p-3 h-100" style="border-left-color: ${borderColor};">
           <div class="promo-header-flex"><div><span class="badge ${isQuick ? 'badge-quick' : 'badge-long'}">${isQuick ? 'QUICK' : 'LONG'}</span><h4 class="fw-bold mt-2">${escapeHtml(promo.name)}</h4><div class="text-muted small">${escapeHtml(promo.id)}</div></div>
           <div class="promo-dates-section">${dateChips}<div class="dropdown"><button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button><ul class="dropdown-menu"><li><a class="dropdown-item edit-promo" href="#" data-id="${promo.id}" data-index=${index}>Edit</a></li><li><a class="dropdown-item text-danger delete-promo" href="#" data-id="${promo.id}">Delete</a></li></ul></div></div></div>
           <div><span class="detail-chip">Reward: $${promo.promotion.amount}</span><span class="detail-chip">Cart ≥ $${promo.condition.cartTotal}</span><span class="detail-chip">Items ≥ ${promo.condition.cartCount}</span></div>
           <div class="small mt-2"><strong>Allowed:</strong> ${(promo.condition.products || []).join(', ') || '—'}</div>
           <div class="small"><strong>Excluded:</strong> ${(promo.condition.exProducts || []).join(', ') || '—'}</div>
           <div class="mt-2"><strong>🎁 Free items:</strong> <div>${itemsPreview || '—'}</div></div>
         </div></div>`;
       });
       grid.html(html);
     } else { console.log("error "); }
   },
   error: function(data) { console.log("error"); }
 });
 return false;
}

   /* function deletePromoById(id) { if (confirm("Delete this promotion?")) {
        promotionsData = promotionsData.filter(p => p.id !== id);
        renderPromotions();
        } }*/
        function deletePromoById(promoId) {
 if (confirm("Delete promotion?")) {
   const promo = promotionsData.find(p => p.id === promoId);
   promotionsData = promotionsData.filter(p => p.id !== promoId);
   actionPromo = "DeletePromo";
   console.log(promo)
   PromoNewEditDelete(promo);
   renderPromotions();
   //addConsoleLog(`🗑️ PROMOTION DELETED: "${promo?.name}" (ID: ${promoId})`, 'error');
 }
}
    function escapeHtml(str) { if (!str) return ''; return String(str).replace(/[&<>]/g, m => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;' }[m])); }
    let actionPromo = "CreatePromo";
    let mainPromoId = "none";
let myIndex = "none";
    $(document).ready(async function(){
        allProductsCache = await fetchProducts();
        renderPromotions();
        setupDatePickers();
        initModalScrollBehavior();
        bindFormValidation();

        $('#createNewPromoBtn').on('click', () => openPromoModal(null));
        $(document).on('click', '.edit-promo', function(e){ e.preventDefault();
         const promo = promotionsData.find(p => p.id === $(this).data('id'));
         myIndex = $(this).data('index');
         if(promo) openPromoModal(JSON.parse(JSON.stringify(promo)));


          });
        $(document).on('click', '.delete-promo', function(e){ e.preventDefault(); deletePromoById($(this).data('id')); });
        $('#promoForm').on('submit', (e) => { e.preventDefault();
         savePromotion();
          });
        $('#openAllowedApiBtn').on('click', () => openProductPicker('allowed'));
        $('#openExcludedApiBtn').on('click', () => openProductPicker('excluded'));
        $('#addItemFromApiBtn').on('click', () => openProductPicker('instock'));
        $('#calculatorPreviewBtn').on('click', () => showCalculatorPreview());
        $('#productFilterRule').on('change', function() { updateUIBasedOnRule($(this).val()); });
        $('#totalToCount').on('change', updateTotalFieldsVisibility);

        let consoleVisible = false;
        $('#toggleConsoleBtn').on('click', function() { consoleVisible = !consoleVisible; $('#consolePanel').toggleClass('show', consoleVisible); });
        $('#closeConsoleBtn, #clearConsoleBtn').on('click', function() { $('#consolePanel').removeClass('show'); consoleVisible = false; });
    });
</script>
</body>
</html>

