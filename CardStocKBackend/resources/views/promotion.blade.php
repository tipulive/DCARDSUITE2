<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
 <title>PromoManager | Smart Inventory Control (API Integrated)</title>
 <!-- Bootstrap 5 + Icons + Fonts -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
 <!-- Google Fonts (Inter) -->
 <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
 <!-- Flatpickr CSS + JS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
 <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
 <!-- jQuery -->
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
 <!-- Bootstrap JS -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
 <style>
 .promo-dates-section {
display: flex;
gap: 8px;
flex-wrap: wrap;
justify-content: flex-end;
}
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
 .duplicate-warning { font-size: 0.7rem; animation: fadeWarning 0.3s ease; }
 @keyframes fadeWarning { from { opacity: 0; transform: translateX(-5px);} to { opacity: 1; transform: translateX(0);} }
 .product-ribbon { background: #f8fafc; border-radius: 20px; padding: 8px 12px; border: 1px solid #e2edf2; margin-top: 8px; display: flex; flex-wrap: wrap; gap: 8px; min-height: 52px; }
 .product-badge { background: white; border-radius: 40px; padding: 4px 10px 4px 14px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; }
 .allowed-badge { color: #0f3b5e; border: 1px solid #cbdde9; }
 .excluded-badge { color: #991b1b; background: #fff5f5; border: 1px solid #fecaca; }
 .product-badge i { cursor: pointer; opacity: 0.7; }
 .date-range-compact { background: #f8fafc; border-radius: 32px; padding: 4px 12px; font-size: 0.7rem; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; }
 .promo-header-flex { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 12px; margin-bottom: 12px; }
 .server-status { font-size: 0.7rem; background: #e6f7ec; border-radius: 20px; padding: 2px 8px; display: inline-flex; align-items: center; gap: 4px; }
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

<!-- Toggle Console Button -->
<button class="toggle-console" id="toggleConsoleBtn">
 <i class="bi bi-terminal-fill"></i> Console Logs
</button>

<!-- Console Log Panel -->
<div class="console-log-panel" id="consolePanel">
 <div class="console-header" id="clearConsoleBtn">
 <h6><i class="bi bi-bug"></i> Promotion Logger</h6>
 <i class="bi bi-x-lg" id="closeConsoleBtn" style="cursor: pointer;"></i>
 </div>
 <div id="consoleLogs">
 <div class="console-log-entry info">📋 Ready - Saving promotions will appear here</div>
 </div>
</div>

<!-- Modal: Add / Edit Promotion -->
<div class="modal fade" id="promoModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
 <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
 <div class="modal-content">
 <div class="modal-header border-0 pb-0 pt-4 px-4">
 <h5 class="modal-title fw-bold fs-3" id="modalTitle">✨ Create Promotion</h5>
 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
 </div>
 <div class="modal-body px-4 pb-4">
 <form id="promoForm">
 <input type="hidden" id="editId">
 <div class="row g-3">
 <div class="col-md-12">
 <label class="form-label fw-semibold"><i class="bi bi-tag-fill me-1"></i> Promotion Name</label>
 <input type="text" class="form-control" id="promoName" required>
 </div>
 <div class="col-md-6">
 <label class="form-label fw-semibold">Promotion ID</label>
 <input type="text" class="form-control" id="promoId" required>
 </div>
 <div class="col-md-6">
 <label class="form-label fw-semibold">Promo Type</label>
 <select class="form-select" id="promoType" required>
 <option value="quick">🔥 Quick</option>
 <option value="long">⏳ Long</option>
 </select>
 </div>
 <div class="col-md-6"><label class="form-label fw-semibold">Start Date & Time</label><input type="text" class="form-control" id="startDatetime" autocomplete="off"></div>
 <div class="col-md-6"><label class="form-label fw-semibold">End Date & Time</label><input type="text" class="form-control" id="endDatetime" autocomplete="off"></div>
 <div class="col-md-6"><label class="form-label fw-semibold">Amount (Reward)</label><input type="number" class="form-control" id="promoAmount" value="100" required></div>
 <div class="col-md-6"><label class="form-label fw-semibold">Cart Total</label><input type="number" class="form-control" id="condCartTotal" value="500" required></div>
 <div class="col-md-6"><label class="form-label fw-semibold">Cart Count</label><input type="number" class="form-control" id="condCartCount" value="10" required></div>
 <div class="col-md-6"><label class="form-label fw-semibold">Card Required?</label><select class="form-select" id="condCard"><option value="yes">Yes</option><option value="no">No</option></select></div>
 <div class="col-md-6"><label class="form-label fw-semibold">Total To Count</label><select class="form-select" id="totalToCount"><option value="cCount">cCount</option><option value="both">both</option><option value="CTotal">CTotal</option></select></div>

 <!-- Allowed Products with API -->
 <div class="col-md-12">
 <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
 <span><i class="bi bi-check-circle-fill text-success me-1"></i> Allowed Products (from API)</span>
 <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" id="openAllowedApiBtn"><i class="bi bi-database"></i> Browse Products</button>
 </label>
 <input type="hidden" id="allowedProducts" value="">
 <div id="allowedProductsRibbon" class="product-ribbon"></div>
 <small class="text-muted">Products fetched from server catalog. Click browse to add.</small>
 </div>

 <!-- Excluded Products with API -->
 <div class="col-md-12 mt-2">
 <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
 <span><i class="bi bi-x-circle-fill text-danger me-1"></i> Excluded Products (from API)</span>
 <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" id="openExcludedApiBtn"><i class="bi bi-database"></i> Browse Products</button>
 </label>
 <input type="hidden" id="excludedProductsHidden" value="">
 <div id="excludedProductsRibbon" class="product-ribbon"></div>
 <small class="text-muted">Excluded from promotion. Select from server catalog.</small>
 </div>

 <!-- InStock Items (gifts) with API -->
 <div class="col-12">
 <hr>
 <div class="d-flex justify-content-between align-items-center">
 <label class="fw-semibold mb-2"><i class="bi bi-box-seam"></i> InStock Items (gifts/items) — <span class="text-danger small">From server catalog</span></label>
 <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" id="addItemFromApiBtn"><i class="bi bi-plus-circle"></i> Add from Catalog</button>
 </div>
 <div id="itemsInStockContainer" class="bg-light bg-opacity-25 p-2 rounded-3"></div>
 <small class="text-muted mt-1">Each product name must be unique. Click "Add from Catalog" to select gift items.</small>
 </div>
 <div class="col-md-12"><label class="form-label fw-semibold">Target Point (optional)</label><input type="number" class="form-control" id="targetPoint" placeholder="7000"></div>
 </div>
 <div class="d-flex justify-content-end gap-2 mt-4 pt-2">
 <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
 <button type="submit" class="btn btn-dark rounded-pill px-5">Save Promotion</button>
 </div>
 </form>
 </div>
 </div>
 </div>
</div>

<!-- Universal Product Picker Modal (reusable for allowed/excluded/instock) -->
<div class="modal fade" id="productPickerModal" tabindex="-1" data-bs-backdrop="static">
 <div class="modal-dialog modal-dialog-centered">
 <div class="modal-content rounded-4">
 <div class="modal-header border-bottom-0">
 <h5 class="modal-title fw-bold" id="pickerModalTitle">Select Products</h5>
 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
 </div>
 <div class="modal-body">
 <div class="mb-2"><input type="text" id="pickerSearch" class="form-control" placeholder="Search products..."></div>
 <div id="pickerProductList" class="api-select"></div>
 </div>
 <div class="modal-footer border-0">
 <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
 <button type="button" class="btn btn-primary rounded-pill" id="confirmPickerSelection">Add Selected</button>
 </div>
 </div>
 </div>
</div>

<script>
 // Console Logger Function
 function addConsoleLog(message, type = 'info', data = null) {
 const timestamp = new Date().toLocaleTimeString();
 const logDiv = $('#consoleLogs');
 const logEntry = $(`<div class="console-log-entry ${type}">
 <strong>[${timestamp}]</strong> ${message}
 </div>`);

 if (data) {
 const dataStr = typeof data === 'object' ? JSON.stringify(data, null, 2) : String(data);
 logEntry.append(`<pre style="margin: 4px 0 0 0; font-size: 9px; color: #ce9178; white-space: pre-wrap;">${escapeHtml(dataStr)}</pre>`);
 }

 logDiv.append(logEntry);
 logDiv.scrollTop(logDiv[0].scrollHeight);

 // Also log to browser console
 console.log(`[PromoManager] ${message}`, data || '');
 }

 // ==================== REAL API CONFIGURATION ====================
 const API_BASE_URL = 'https://your-api-server.com'; // Change to your API URL
 const API_ENDPOINTS = {
 getAllProducts: `${API_BASE_URL}/api/products`,
 addProduct: `${API_BASE_URL}/api/products`,
 deleteProduct: `${API_BASE_URL}/api/products`,
 getAllowedProducts: `${API_BASE_URL}/api/promotions/allowed`,
 setAllowedProducts: `${API_BASE_URL}/api/promotions/allowed`,
 getExcludedProducts: `${API_BASE_URL}/api/promotions/excluded`,
 setExcludedProducts: `${API_BASE_URL}/api/promotions/excluded`
 };

 // Local fallback products
 const FALLBACK_PRODUCTS = [
 { id: "p1", name: "ibijumba", category: "food", price: 10.99 },
 { id: "p2", name: "bread", category: "bakery", price: 2.99 },
 { id: "p3", name: "coke", category: "beverage", price: 1.99 },
 { id: "p4", name: "simba", category: "snacks", price: 3.49 },
 { id: "p5", name: "fanta", category: "beverage", price: 1.99 },
 { id: "p6", name: "castel", category: "beer", price: 4.99 },
 { id: "p7", name: "primus", category: "beer", price: 4.99 },
 { id: "p8", name: "serengeti", category: "beer", price: 5.99 },
 { id: "p9", name: "chips", category: "snacks", price: 2.49 },
 { id: "p10", name: "milk", category: "dairy", price: 3.99 },
 { id: "p11", name: "soda", category: "beverage", price: 1.49 },
 { id: "p12", name: "water", category: "beverage", price: 0.99 }
 ];

 async function fetchProductsFromAPI() {
 updateAPIStatus('loading');
 try {
 const response = await fetch('https://fakestoreapi.com/products');
 if (response.ok) {
 const data = await response.json();
 const products = data.map(product => ({
 id: product.id.toString(),
 name: product.title.toLowerCase(),
 category: product.category,
 price: product.price
 }));
 updateAPIStatus('online');
 addConsoleLog(`✅ Fetched ${products.length} products from API`, 'success');
 return products;
 }
 } catch (error) {
 addConsoleLog(`⚠️ API fetch failed: ${error.message}`, 'error');
 }

 updateAPIStatus('offline');
 addConsoleLog(`📦 Using fallback products (${FALLBACK_PRODUCTS.length} items)`, 'info');
 return [...FALLBACK_PRODUCTS];
 }

 function updateAPIStatus(status) {
 const statusEl = $('#apiStatus');
 if (status === 'online') {
 statusEl.html('<i class="bi bi-cloud-check-fill text-success"></i> Server connected');
 } else if (status === 'offline') {
 statusEl.html('<i class="bi bi-cloud-slash-fill text-warning"></i> Offline mode');
 } else if (status === 'loading') {
 statusEl.html('<span class="loading-spinner"></span> Syncing...');
 }
 }

 // ==================== GLOBAL STATE ====================
 let promotionsData = [
 { "id": "1bv", "name": "Weekend Cashback", "startDate": "2025-05-01T10:00", "endDate": "2025-05-10T23:59", "promotype": "quick", "promotion": { "amount": 100, "items": { "inStock": [{"productName":"Castel","qty":3}], "OutStock": [] } }, "condition": { "products":["ibijumba"], "exProducts":["simba","fanta"], "TotalToCount":"cCount", "cartTotal":500, "cartCount":10, "card":"yes" } },
 { "id": "2xb", "name": "Bread Special", "startDate": "2025-05-15T08:00", "endDate": "2025-05-20T22:00", "promotype": "quick", "promotion": { "amount": 400, "items": { "inStock": [{"productName":"Castel","qty":1}], "OutStock": [] } }, "condition": { "products":["bread"], "exProducts":["simba"], "TotalToCount":"both", "cartTotal":500, "cartCount":5, "card":"yes" } }
 ];

 let currentAllowedArray = [];
 let currentExcludedArray = [];
 let currentInStockItems = [];
 let allProductsCache = [];
 let pickerMode = 'allowed';
 let selectedTempProducts = [];

 function normalizePromo(promo) {
 if (!promo.promotion.items) promo.promotion.items = { inStock: [], OutStock: [] };
 if (!promo.promotion.items.inStock) promo.promotion.items.inStock = [];
 if (!promo.condition.products) promo.condition.products = [];
 if (!promo.condition.exProducts) promo.condition.exProducts = [];
 if (!promo.name) promo.name = promo.id;
 return promo;
 }

 function escapeHtml(str) { if (!str) return ''; return String(str).replace(/[&<>]/g, m => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;' }[m])); }

 function formatDisplayDate(isoString) { if (!isoString) return null; try { return new Date(isoString).toLocaleString(); } catch(e) { return isoString; } }

 function renderPromotions() {
 const grid = $("#promotionsGrid");
 if (!promotionsData.length) { grid.html(`<div class="col-12"><div class="empty-state"><i class="bi bi-ticket-perforated fs-1 text-muted"></i><h4>No promotions</h4></div></div>`); return; }
 let html = '';
 promotionsData.forEach(promo => {
 const isQuick = promo.promotype === 'quick';
 const borderColor = isQuick ? '#f97316' : '#3b82f6';
 const startDisplay = formatDisplayDate(promo.startDate);
 const endDisplay = formatDisplayDate(promo.endDate);
 const dateChips = (startDisplay && endDisplay) ? `<div class="date-range-compact"><i class="bi bi-calendar-range"></i> ${startDisplay} — ${endDisplay}</div>` : '<div class="date-range-compact">No dates</div>';
 const itemsPreview = (promo.promotion.items.inStock || []).map(it => `<span class="stock-badge me-1">${escapeHtml(it.productName)} (x${it.qty})</span>`).join('');
 html += `<div class="col-md-6 col-xl-6"><div class="promo-card p-3 h-100" style="border-left-color: ${borderColor};">
 <div class="promo-header-flex"><div><span class="badge ${isQuick ? 'badge-quick' : 'badge-long'}">${isQuick ? 'QUICK' : 'LONG'}</span><h4 class="fw-bold mt-2">${escapeHtml(promo.name)}</h4><div class="text-muted small">${escapeHtml(promo.id)}</div></div>
 <div class="promo-dates-section">${dateChips}<div class="dropdown"><button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button><ul class="dropdown-menu"><li><a class="dropdown-item edit-promo" href="#" data-id="${promo.id}">Edit</a></li><li><a class="dropdown-item text-danger delete-promo" href="#" data-id="${promo.id}">Delete</a></li></ul></div></div></div>
 <div><span class="detail-chip">Reward: $${promo.promotion.amount}</span><span class="detail-chip">Cart ≥ $${promo.condition.cartTotal}</span><span class="detail-chip">Items ≥ ${promo.condition.cartCount}</span></div>
 <div class="small mt-2"><strong>Allowed:</strong> ${(promo.condition.products || []).join(', ') || '—'}</div>
 <div class="small"><strong>Excluded:</strong> ${(promo.condition.exProducts || []).join(', ') || '—'}</div>
 <div class="mt-2"><strong>🎁 Free items:</strong> <div>${itemsPreview || '—'}</div></div>
 </div></div>`;
 });
 grid.html(html);
 }

 function updateProductUIs() {
 const allowedRibbon = $('#allowedProductsRibbon');
 allowedRibbon.empty();
 if (currentAllowedArray.length === 0) allowedRibbon.html('<span class="text-muted fst-italic">No allowed products</span>');
 else currentAllowedArray.forEach(prod => { allowedRibbon.append(`<span class="product-badge allowed-badge"><span>${escapeHtml(prod)}</span><i class="bi bi-x-circle-fill remove-allowed" data-product="${escapeHtml(prod)}"></i></span>`); });
 $('#allowedProducts').val(currentAllowedArray.join(','));

 const excludedRibbon = $('#excludedProductsRibbon');
 excludedRibbon.empty();
 if (currentExcludedArray.length === 0) excludedRibbon.html('<span class="text-muted fst-italic">No excluded products</span>');
 else currentExcludedArray.forEach(prod => { excludedRibbon.append(`<span class="product-badge excluded-badge"><span>${escapeHtml(prod)}</span><i class="bi bi-x-circle-fill remove-excluded" data-product="${escapeHtml(prod)}"></i></span>`); });
 $('#excludedProductsHidden').val(currentExcludedArray.join(','));

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
 });
 $('.removeInstockBtn').off('click').on('click', function() {
 const row = $(this).closest('.inStockRow');
 const idx = row.data('idx');
 if (idx !== undefined) { currentInStockItems.splice(idx, 1); updateProductUIs(); }
 });
 }

 async function openProductPicker(mode) {
 pickerMode = mode;
 if (allProductsCache.length === 0) {
 $("#pickerProductList").html('<div class="text-center p-3"><span class="loading-spinner"></span> Loading products...</div>');
 allProductsCache = await fetchProductsFromAPI();
 }
 $("#pickerModalTitle").html(mode === 'allowed' ? '📋 Select Allowed Products' : (mode === 'excluded' ? '🚫 Select Excluded Products' : '🎁 Select Gift Items'));
 selectedTempProducts = [];
 renderPickerList(allProductsCache);
 const modal = new bootstrap.Modal(document.getElementById('productPickerModal'));
 modal.show();
 }

 function renderPickerList(products) {
 const container = $("#pickerProductList");
 container.empty();
 const searchTerm = $("#pickerSearch").val().toLowerCase();
 let filtered = products.filter(p => p.name.toLowerCase().includes(searchTerm));

 if (searchTerm && !products.some(p => p.name.toLowerCase() === searchTerm)) {
 filtered.unshift({ id: 'new', name: searchTerm, isNew: true });
 }

 if (filtered.length === 0) { container.html('<div class="text-muted p-3 text-center">No products found</div>'); return; }

 filtered.forEach(prod => {
 const isSelected = selectedTempProducts.includes(prod.name);
 const isNew = prod.isNew;
 container.append(`<div class="api-select-item ${isSelected ? 'selected-item' : ''}" data-product-name="${prod.name}" data-is-new="${isNew || false}">
 <span><i class="bi ${isNew ? 'bi-plus-circle-fill text-primary' : 'bi-box'}"></i> ${escapeHtml(prod.name)} ${isNew ? '<span class="badge bg-primary ms-2">Create New</span>' : ''}</span>
 <i class="bi ${isSelected ? 'bi-check-circle-fill text-success' : 'bi-plus-circle'}"></i>
 </div>`);
 });

 $('.api-select-item').off('click').on('click', async function() {
 const pname = $(this).data('product-name');
 const isNew = $(this).data('is-new');

 if (isNew) {
 const newProduct = { id: Date.now().toString(), name: pname, category: 'custom' };
 allProductsCache.push(newProduct);
 selectedTempProducts.push(pname);
 renderPickerList(allProductsCache);
 addConsoleLog(`✨ Created new product: "${pname}"`, 'success');
 } else {
 if (selectedTempProducts.includes(pname)) {
 selectedTempProducts = selectedTempProducts.filter(p => p !== pname);
 } else {
 selectedTempProducts.push(pname);
 }
 renderPickerList(filtered.filter(p => !p.isNew));
 }
 });
 }

 $("#pickerSearch").on('input', function() { renderPickerList(allProductsCache); });

 $("#confirmPickerSelection").on('click', function() {
 if (pickerMode === 'allowed') {
 selectedTempProducts.forEach(p => { if (!currentAllowedArray.includes(p)) currentAllowedArray.push(p); });
 addConsoleLog(`📋 Added ${selectedTempProducts.length} allowed products`, 'info', selectedTempProducts);
 } else if (pickerMode === 'excluded') {
 selectedTempProducts.forEach(p => { if (!currentExcludedArray.includes(p)) currentExcludedArray.push(p); });
 addConsoleLog(`🚫 Added ${selectedTempProducts.length} excluded products`, 'info', selectedTempProducts);
 } else if (pickerMode === 'instock') {
 selectedTempProducts.forEach(p => {
 if (!currentInStockItems.some(item => item.productName === p)) currentInStockItems.push({ productName: p, qty: 1 });
 });
 addConsoleLog(`🎁 Added ${selectedTempProducts.length} gift items`, 'info', selectedTempProducts);
 }
 updateProductUIs();
 $('#productPickerModal').modal('hide');
 });

 $(document).on('click', '.remove-allowed', function() { const prod = $(this).data('product'); currentAllowedArray = currentAllowedArray.filter(p => p !== prod); updateProductUIs(); addConsoleLog(`❌ Removed allowed product: "${prod}"`, 'info'); });
 $(document).on('click', '.remove-excluded', function() { const prod = $(this).data('product'); currentExcludedArray = currentExcludedArray.filter(p => p !== prod); updateProductUIs(); addConsoleLog(`❌ Removed excluded product: "${prod}"`, 'info'); });

 let currentModal = null, startPicker, endPicker;
 let  actionPromo="CreatePromo"

 function initFlatpickrs() { if (startPicker) startPicker.destroy(); if (endPicker) endPicker.destroy(); startPicker = flatpickr("#startDatetime", { enableTime: true, dateFormat: "Y-m-d H:i", time_24hr: true }); endPicker = flatpickr("#endDatetime", { enableTime: true, dateFormat: "Y-m-d H:i", time_24hr: true }); }

 function openPromoModal(promo = null) {
 $('#promoForm')[0].reset();
 $('#editId').val('');
 actionPromo="CreatePromo";
 initFlatpickrs();

 if (promo) {
 addConsoleLog(`✏️ Opening edit mode for promotion: "${promo.name}" (ID: ${promo.id})`, 'info');
 actionPromo="EditPromo";
 $('#modalTitle').text('✏️ Edit Promotion');
 $('#editId').val(promo.id);
 $('#promoName').val(promo.name);
 $('#promoId').val(promo.id);
 $('#promoType').val(promo.promotype);
 $('#promoAmount').val(promo.promotion.amount);
 $('#condCartTotal').val(promo.condition.cartTotal);
 $('#condCartCount').val(promo.condition.cartCount);
 $('#condCard').val(promo.condition.card || 'yes');
 $('#totalToCount').val(promo.condition.TotalToCount || 'cCount');
 $('#targetPoint').val(promo.condition.TargetPoint || '');
 if (promo.startDate) startPicker.setDate(new Date(promo.startDate));
 if (promo.endDate) endPicker.setDate(new Date(promo.endDate));
 currentAllowedArray = [...(promo.condition.products || [])];
 currentExcludedArray = [...(promo.condition.exProducts || [])];
 currentInStockItems = [...(promo.promotion.items.inStock || [])].map(i => ({ productName: i.productName, qty: i.qty }));
 } else {
 addConsoleLog(`✨ Opening create mode for new promotion`, 'info');
 $('#modalTitle').text('✨ Create New Promotion');
 $('#promoName').val('');
 $('#promoId').val('');
 $('#promoType').val('quick');
 $('#promoAmount').val(100);
 $('#condCartTotal').val(500);
 $('#condCartCount').val(10);
 $('#condCard').val('yes');
 $('#totalToCount').val('cCount');
 $('#targetPoint').val('');
 startPicker.clear(); endPicker.clear();
 currentAllowedArray = [];
 currentExcludedArray = [];
 currentInStockItems = [];
 }
 updateProductUIs();
 const modalEl = document.getElementById('promoModal');
 const modal = new bootstrap.Modal(modalEl);
 modal.show();
 currentModal = modal;
 }

 function savePromotionFromForm() {
 const id = $('#promoId').val().trim();
 const name = $('#promoName').val().trim();
 if (!id || !name) { alert("ID and Name required"); return false; }

 const finalInStock = currentInStockItems.map(item => ({ productName: item.productName, qty: item.qty, price: 0 }));
 const newPromo = {
 id: id,
 name: name,
 startDate: startPicker.input.value || '',
 endDate: endPicker.input.value || '',
 promotype: $('#promoType').val(),
 promotion: {
 amount: parseInt($('#promoAmount').val()),
 items: { inStock: finalInStock, OutStock: [] }
 },
 condition: {
 products: [...currentAllowedArray],
 exProducts: [...currentExcludedArray],
 TotalToCount: $('#totalToCount').val(),
 cartTotal: parseInt($('#condCartTotal').val()),
 cartCount: parseInt($('#condCartCount').val()),
 card: $('#condCard').val()
 }
 };

 const targetRaw = $('#targetPoint').val();
 if (targetRaw && newPromo.promotype === 'long') {
 newPromo.condition.TargetPoint = parseInt(targetRaw);
 }

 const editIdHidden = $('#editId').val();
 let action = '';

 if (editIdHidden === "") {
 // NEW PROMOTION
 if (promotionsData.find(p => p.id === id)) {
 alert("Duplicate ID");
 addConsoleLog(`❌ Failed to create: Duplicate ID "${id}"`, 'error');
 return false;
 }
 promotionsData.push(normalizePromo(newPromo));
 action = 'NEW';
 addConsoleLog(`🎉 NEW PROMOTION CREATED`, 'success', {
 action: 'CREATE',
 timestamp: new Date().toISOString(),
 promotion: newPromo
 });
 } else {
 // EDITING EXISTING PROMOTION
 const idx = promotionsData.findIndex(p => p.id === editIdHidden);
 if (idx !== -1) {
 const oldPromo = { ...promotionsData[idx] };
 promotionsData[idx] = normalizePromo(newPromo);
 action = 'EDIT';
 addConsoleLog(`✏️ PROMOTION EDITED`, 'success', {
 action: 'EDIT',
 timestamp: new Date().toISOString(),
 oldPromotion: oldPromo,
 newPromotion: newPromo,
 changes: {
 name: oldPromo.name !== newPromo.name ? `${oldPromo.name} → ${newPromo.name}` : 'unchanged',
 amount: oldPromo.promotion.amount !== newPromo.promotion.amount ? `${oldPromo.promotion.amount} → ${newPromo.promotion.amount}` : 'unchanged',
 allowedProducts: oldPromo.condition.products?.join(',') !== newPromo.condition.products?.join(',') ? 'changed' : 'unchanged',
 excludedProducts: oldPromo.condition.exProducts?.join(',') !== newPromo.condition.exProducts?.join(',') ? 'changed' : 'unchanged'
 }
 });
 } else {
 promotionsData.push(normalizePromo(newPromo));
 action = 'CREATE (fallback)';
 addConsoleLog(`⚠️ Promotion saved with new ID (edit target not found)`, 'info', newPromo);
 }
 }

 if (currentModal) currentModal.hide();
 renderPromotions();

 // Also output to console with clear formatting
 /* console.log('='.repeat(60));
 console.log(`[PROMO MANAGER] ${action === 'NEW' ? 'NEW PROMOTION' : 'PROMOTION UPDATED'}`);
 console.log('='.repeat(60));
 console.log(`ID: ${newPromo.id}`);
 console.log(`Name: ${newPromo.name}`);
 console.log(`Type: ${newPromo.promotype}`);
 console.log(`Amount: ${newPromo.promotion.amount}`);
 console.log(`Date Range: ${newPromo.startDate || 'N/A'} → ${newPromo.endDate || 'N/A'}`);
 console.log(`Conditions: Cart Total >= ${newPromo.condition.cartTotal}, Cart Count >= ${newPromo.condition.cartCount}`);
 console.log(`Allowed Products: ${newPromo.condition.products.join(', ') || 'none'}`);
 console.log(`Excluded Products: ${newPromo.condition.exProducts.join(', ') || 'none'}`);
 console.log(`Gift Items:`, newPromo.promotion.items.inStock);
 console.log('='.repeat(60));*/
 PromoNewEditDelete(newPromo);//to combine new ,edit,delete

 return true;
 }

 function deletePromoById(promoId) {
 if (confirm("Delete promotion?")) {

 const promo = promotionsData.find(p => p.id === promoId);
 promotionsData = promotionsData.filter(p => p.id !== promoId);
 actionPromo="DeletePromo";
 PromoNewEditDelete(promo);
 renderPromotions();
 addConsoleLog(`🗑️ PROMOTION DELETED: "${promo?.name}" (ID: ${promoId})`, 'error');
 }
 }

 // Console panel toggle
 let consoleVisible = false;
 $('#toggleConsoleBtn').on('click', function() {
 if (consoleVisible) {
 $('#consolePanel').removeClass('show');
 consoleVisible = false;
 } else {
 $('#consolePanel').addClass('show');
 consoleVisible = true;
 }
 });
 $('#closeConsoleBtn').on('click', function() {
 $('#consolePanel').removeClass('show');
 consoleVisible = false;
 });
 $('#clearConsoleBtn').on('click', function() {
 $('#consoleLogs').html('<div class="console-log-entry info">📋 Console cleared</div>');
 addConsoleLog('Console panel cleared', 'info');
 });

 $(document).ready(async function(){
 allProductsCache = await fetchProductsFromAPI();
 promotionsData = promotionsData.map(p => normalizePromo(p));
 renderPromotions();
 initFlatpickrs();
 addConsoleLog('🚀 PromoManager initialized', 'success');

 $('#createNewPromoBtn').on('click', () => openPromoModal(null));
 $(document).on('click', '.edit-promo', function(e){ e.preventDefault(); const promo = promotionsData.find(p => p.id === $(this).data('id')); if(promo) openPromoModal(JSON.parse(JSON.stringify(promo))); });
 $(document).on('click', '.delete-promo', function(e){ e.preventDefault(); deletePromoById($(this).data('id')); });
 $('#promoForm').on('submit', (e) => { e.preventDefault(); savePromotionFromForm(); });

 $('#openAllowedApiBtn').on('click', () => openProductPicker('allowed'));
 $('#openExcludedApiBtn').on('click', () => openProductPicker('excluded'));
 $('#addItemFromApiBtn').on('click', () => openProductPicker('instock'));
 });
 function PromoNewEditDelete(promo) {//to combine new ,edit,delete

var Usertoken = localStorage.getItem("Usertoken");

$.ajax({
    url: `./api/${actionPromo}`,
    type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
//dataType: "json",
data:{
promo:promo,
allowproducts:promo.condition.products.join(', ') || 'none',
exproducts:promo.condition.exProducts.join(', ') || 'none',

app_vers:'{{env('APP_VERS')}}'




},
    success: function (data) {
        console.log("SUCCESS:", data);
    },
    error: function (xhr, status, error) {
        console.error("Error:", error);
        console.error("Status:", status);
        console.error("Response:", xhr.responseText);
    }
});
}
</script>
</body>
</html>
