// ===== FILE: js/promotions.js =====

/** Normalize a promotion object to ensure required fields exist */
function normalizePromo(promo) {
    if (!promo.promotion.items) promo.promotion.items = { inStock: [], OutStock: [] };
    if (!promo.promotion.items.inStock) promo.promotion.items.inStock = [];
    if (!promo.condition.products) promo.condition.products = [];
    if (!promo.condition.userTypes) promo.condition.userTypes = [];
    if (!promo.condition.exProducts) promo.condition.exProducts = [];
    if (!promo.name) promo.name = promo.id;

    // Default target fields
    if (!promo.condition.targetCount) promo.condition.targetCount = 0;
    if (!promo.condition.targetTotal) promo.condition.targetTotal = 0;

    // Default user eligibility & user types
    if (!promo.condition.userEligibility) promo.condition.userEligibility = [];
    if (!promo.condition.userTypes) promo.condition.userTypes = [];

    return promo;
}

/** Generate a random promotion ID */
function generateRandomPromoId() {
    return 'PRM_' + Date.now().toString(36).toUpperCase() + '_' + Math.random().toString(36).substring(2, 8).toUpperCase();
}

/** Open the promotion modal for create or edit */
/**
 * Open the promotion modal for create or edit.
 * If a promo object is passed, it loads the data for editing.
 * Otherwise, it sets defaults for a new promotion.
 * @param {Object|null} promo - The promotion to edit, or null for a new one.
 */
 function openPromoModal(promo) {
    // Reset the form
    $('#promoForm')[0].reset();
    $('#editId').val('');
    setupDatePickers();

    if (promo) {
        // ---- EDIT MODE ----
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

        // Target fields
        $('#targetcCount').val(promo.condition.targetCount || 0);
        $('#targetTotal').val(promo.condition.targetTotal || 0);

        // Dates
        if (promo.startDate) startPicker.setDate(new Date(promo.startDate));
        if (promo.endDate) endPicker.setDate(new Date(promo.endDate));

        // Product filter rule
        $('#productFilterRule').val(promo.condition.productRule);
        $('#promoDescription').val(promo.description || '');
        // Products (allowed, excluded, in-stock)
        currentAllowedArray = [...(promo.condition.products || [])];
        currentExcludedArray = [...(promo.condition.exProducts || [])];
        currentInStockItems = [...(promo.promotion.items.inStock || [])];

        // User Eligibility (dynamic filters)
       /* currentUserFilters = promo.condition.userEligibility ? [...promo.condition.userEligibility] : [];
        renderUserFilters(); // defined in ui.js
*/
        // User Types (ribbon)
        currentUserTypes = promo.condition.userTypes ? [...promo.condition.userTypes] : [];
        renderUserTypesRibbon(); // defined in ui.js

    } else {
        // ---- CREATE MODE ----
        actionPromo = "CreatePromo";
        $('#modalTitle').text('✨ Create New Promotion');
        $('#promoId').val(generateRandomPromoId());
        $('#promoDescription').val('');
        // Set default values
        $('#promoName').val('');
        $('#promoType').val('quick');
        $('#promoAmount').val(100);
        $('#condCartTotal').val(500);
        $('#condCartCount').val(10);
        $('#condCard').val('yes');
        $('#totalToCount').val('cCount');
        $('#targetPoint').val('');
        $('#targetcCount').val(0);
        $('#targetTotal').val(0);
        $('#productFilterRule').val('only');

        // Clear dates
        startPicker.clear();
        endPicker.clear();

        // Clear products and user data
        currentAllowedArray = [];
        currentExcludedArray = [];
        currentInStockItems = [];
        currentUserFilters = [];
        currentUserTypes = [];

        // Render empty UIs

        renderUserTypesRibbon();
    }

    // Apply visibility rules (this also resets hidden target fields to 0)
    updateUIBasedOnRule($('#productFilterRule').val());
    updateTotalFieldsVisibility();

    // Update product ribbons and in-stock items
    updateProductUIs();

    // Enable hover scroll on modal body
    setTimeout(() => initModalScrollBehavior(), 100);

    // Show the modal
    new bootstrap.Modal(document.getElementById('promoModal')).show();
}

/** Save the current promotion (create or edit) */
function savePromotion() {
    const promoId = $('#promoId').val();
    const name = $('#promoName').val();
    if (!name) { alert("Promotion Name required"); return false; }
    if (!startPicker.input.value || !endPicker.input.value) { alert("Start and End dates required"); return false; }
    const rule = $('#productFilterRule').val();
    if (rule === 'only' && currentAllowedArray.length === 0) { alert("Eligible products required for 'Only' rule"); return false; }
    if (rule === 'allExcept' && currentExcludedArray.length === 0) { alert("Excluded products required for 'All Except' rule"); return false; }

    const newPromo = {
        id: promoId,
        name,
        description: $('#promoDescription').val().trim(),
        startDate: startPicker.input.value,
        endDate: endPicker.input.value,
        promotype: $('#promoType').val(),
        promotion: {
            amount: parseInt($('#promoAmount').val()),
            items: {
                inStock: currentInStockItems.map(i => ({ productName: i.productName, qty: i.qty })),
                OutStock: []
            }
        },
        condition: {
            products: [...currentAllowedArray],
            exProducts: [...currentExcludedArray],
            productRule: rule,
            TotalToCount: $('#totalToCount').val(),
            cartTotal: parseInt($('#condCartTotal').val()) || 0,
            cartCount: parseInt($('#condCartCount').val()) || 0,
            card: $('#condCard').val(),
            TargetPoint: $('#targetPoint').val() || '',
            // Target fields
            targetCount: parseInt($('#targetcCount').val()) || 0,
            targetTotal: parseInt($('#targetTotal').val()) || 0,
            // User eligibility (dynamic filters)
            //userEligibility: currentUserFilters.map(f => ({ field: f.field, value: f.value })),
            // User types (multi-select)
            userTypes: currentUserTypes
        }
    };

    const target = $('#targetPoint').val();
    if (target && newPromo.promotype === 'long') newPromo.condition.TargetPoint = parseInt(target);

    const editId = $('#editId').val();
    if (!editId) promotionsData.push(newPromo);
    else {
        const idx = promotionsData.findIndex(p => p.id === editId);
        if (idx !== -1) promotionsData[idx] = newPromo;
    }
    console.log(newPromo);
    PromoNewEditDelete(newPromo);
    $('#promoModal').modal('hide');
    return true;
}

/** API call to create/update/delete a promotion */
function PromoNewEditDelete(promo) {
    console.log("promo:", promo);
    var Usertoken = localStorage.getItem("Usertoken");
    $.ajax({
        url: `./api/${actionPromo}`,
        type: 'post',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
        },
        data: {
            promoArrId: myIndex,
            promo: promo,
            products: promo.condition.products.join(', ') || 'none',
            products: promo.condition.products.join(', ') || 'none',
            userTypes: promo.condition.userTypes.join(', ') || 'none',
            mainPromoId: mainPromoId,
            app_vers: window.APP_VERSION
        },
        success: function (data) {
            renderPromotions();
            console.log("SUCCESS:", data);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

/** Render the promotions grid from server data */
/**
 * Fetch and render all promotions from the server.
 * Displays each promotion as a card in the grid.
 */
/**
 * Fetch and render all promotions from the server.
 * Displays each promotion as a card with dynamic fields.
 */
 function renderPromotions() {
    var Usertoken = localStorage.getItem("Usertoken");
    if (!Usertoken) {
        console.warn("No user token found. Please log in.");
        $("#promotionsGrid").html(`
            <div class="col-12">
                <div class="empty-state">
                    <i class="bi bi-exclamation-triangle-fill fs-1 text-warning"></i>
                    <h4>Authentication Required</h4>
                    <p>Please log in to view promotions.</p>
                </div>
            </div>
        `);
        return false;
    }

    // Show loading state
    $("#promotionsGrid").html(`
        <div class="col-12 text-center py-5">
            <div class="loading-spinner" style="width: 40px; height: 40px;"></div>
            <p class="mt-3 text-muted">Loading promotions...</p>
        </div>
    `);

    $.ajax({
        url: `./api/getPromoData`,
        type: 'get',
        headers: {
            "Content-Type": "application/json;charset=UTF-8",
            "Authorization": `Bearer ${Usertoken}`
        },
        data: { app_vers: window.APP_VERSION || '1.0' },
        success: function(response) {
            if (response.status && response.result && response.result.length > 0) {
                try {
                    const dataResult = response.result;
                    const firstRow = dataResult[0];
                    if (!firstRow || !firstRow["promoschema"]) {
                        throw new Error("Promo schema missing in response");
                    }

                    let promoArray = JSON.parse(firstRow["promoschema"]);
                    if (!Array.isArray(promoArray)) {
                        promoArray = [promoArray];
                    }

                    promotionsData = promoArray;
                    mainPromoId = firstRow["uid"] || "none";

                    const grid = $("#promotionsGrid");
                    if (promotionsData.length === 0) {
                        grid.html(`
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="bi bi-ticket-perforated fs-1 text-muted"></i>
                                    <h4>No promotions</h4>
                                    <p class="text-muted">Click "New Promotion" to create one.</p>
                                </div>
                            </div>
                        `);
                        return;
                    }

                    let html = '';
                    promotionsData.forEach((promo, index) => {
                        // --- Basic info ---
                        const isQuick = promo.promotype === 'quick';
                        const borderColor = isQuick ? '#f97316' : '#3b82f6';

                        // --- Dates ---
                        const startDisplay = promo.startDate ? new Date(promo.startDate).toLocaleString() : '';
                        const endDisplay = promo.endDate ? new Date(promo.endDate).toLocaleString() : '';
                        const dateChips = (startDisplay && endDisplay)
                            ? `<div class="date-range-compact"><i class="bi bi-calendar-range"></i> ${startDisplay} — ${endDisplay}</div>`
                            : '<div class="date-range-compact">No dates</div>';

                        // --- Gift items ---
                        const itemsPreview = (promo.promotion.items.inStock || [])
                            .map(it => `<span class="stock-badge me-1">${escapeHtml(it.productName)} (x${it.qty})</span>`)
                            .join('');

                        // --- Description ---
                        const description = promo.description || '';
                        const descriptionHtml = description
                            ? `<div class="small text-muted mt-1"><i class="bi bi-card-text me-1"></i>${escapeHtml(description)}</div>`
                            : '';

                        // --- Target withdrawal conditions ---
                        const targetCount = promo.condition.targetCount || 0;
                        const targetTotal = promo.condition.targetTotal || 0;
                        let targetHtml = '';
                        if (targetCount > 0 || targetTotal > 0) {
                            const parts = [];
                            if (targetCount > 0) parts.push(`<span class="detail-chip">Withdraw ≥ ${targetCount} items</span>`);
                            if (targetTotal > 0) parts.push(`<span class="detail-chip">Withdraw ≥ $${targetTotal}</span>`);
                            targetHtml = `<div class="mt-1">${parts.join(' ')}</div>`;
                        }

                        // --- User Eligibility (dynamic filters) ---
                        const userFilters = promo.condition.userEligibility || [];
                        const userEligibilityHtml = userFilters.length
                            ? userFilters.map(f =>
                                `<span class="badge bg-secondary me-1">${escapeHtml(f.field)}: ${escapeHtml(f.value)}</span>`
                              ).join('')
                            : '—';

                        // --- User Types (multi-select) ---
                        const userTypes = promo.condition.userTypes || [];
                        const userTypesHtml = userTypes.length
                            ? userTypes.map(type =>
                                `<span class="badge bg-info me-1">${escapeHtml(type)}</span>`
                              ).join('')
                            : '—';

                        // --- Cart threshold chips based on TotalToCount ---
                        const totalToCount = promo.condition.TotalToCount || 'cCount';
                        let cartChips = '';
                        if (totalToCount === 'cCount') {
                            cartChips = `<span class="detail-chip">Items ≥ ${promo.condition.cartCount || 0}</span>`;
                        } else if (totalToCount === 'CTotal') {
                            cartChips = `<span class="detail-chip">Cart ≥ $${promo.condition.cartTotal || 0}</span>`;
                        } else { // both
                            cartChips = `
                                <span class="detail-chip">Cart ≥ $${promo.condition.cartTotal || 0}</span>
                                <span class="detail-chip">Items ≥ ${promo.condition.cartCount || 0}</span>
                            `;
                        }

                        // --- Build card ---
                        html += `
                            <div class="col-md-6 col-xl-6">
                                <div class="promo-card p-3 h-100" style="border-left-color: ${borderColor};">
                                    <div class="promo-header-flex">
                                        <div>
                                            <span class="badge ${isQuick ? 'badge-quick' : 'badge-long'}">
                                                ${isQuick ? 'QUICK' : 'LONG'}
                                            </span>
                                            <h4 class="fw-bold mt-2">${escapeHtml(promo.name)}</h4>
                                            <div class="text-muted small">${escapeHtml(promo.id)}</div>
                                        </div>
                                        <div class="promo-dates-section">
                                            ${dateChips}
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item edit-promo" href="#" data-id="${promo.id}" data-index="${index}">Edit</a></li>
                                                    <li><a class="dropdown-item text-danger delete-promo" href="#" data-id="${promo.id}">Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    ${descriptionHtml}

                                    <!-- Reward & conditions -->
                                    <div>
                                        <span class="detail-chip">Reward: $${promo.promotion.amount}</span>
                                        ${cartChips}
                                    </div>
                                    ${targetHtml}

                                    <!-- Product filters -->
                                    <div class="small mt-2">
                                        <strong>Allowed:</strong> ${(promo.condition.products || []).join(', ') || '—'}
                                    </div>
                                    <div class="small">
                                        <strong>Excluded:</strong> ${(promo.condition.exProducts || []).join(', ') || '—'}
                                    </div>



                                    <!-- User Types -->
                                    <div class="small mt-1">
                                        <strong>👥 User Types:</strong> ${userTypesHtml}
                                    </div>

                                    <!-- Gift items -->
                                    <div class="mt-2">
                                        <strong>🎁 Free items:</strong>
                                        <div>${itemsPreview || '—'}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    grid.html(html);

                } catch (parseError) {
                    console.error("Error parsing promotion data:", parseError);
                    $("#promotionsGrid").html(`
                        <div class="col-12">
                            <div class="empty-state text-danger">
                                <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                                <h4>Data Error</h4>
                                <p>Failed to parse promotion data. Please refresh.</p>
                            </div>
                        </div>
                    `);
                }
            } else {
                console.warn("No promotions found or API error:", response);
                $("#promotionsGrid").html(`
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <h4>No promotions available</h4>
                            <p class="text-muted">Create your first promotion now.</p>
                        </div>
                    </div>
                `);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error fetching promotions:", textStatus, errorThrown);
            let errorMsg = "Could not load promotions. Please try again.";
            if (jqXHR.status === 401) {
                errorMsg = "Session expired. Please log in again.";
            } else if (jqXHR.status === 404) {
                errorMsg = "API endpoint not found. Check server configuration.";
            }
            $("#promotionsGrid").html(`
                <div class="col-12">
                    <div class="empty-state text-danger">
                        <i class="bi bi-wifi-off fs-1"></i>
                        <h4>Connection Error</h4>
                        <p>${errorMsg}</p>
                        <button class="btn btn-outline-secondary mt-3" onclick="renderPromotions()">
                            <i class="bi bi-arrow-repeat"></i> Retry
                        </button>
                    </div>
                </div>
            `);
        }
    });

    return false;
}

/** Delete a promotion by ID after confirmation */
function deletePromoById(promoId) {
    if (confirm("Delete promotion?")) {
        const promo = promotionsData.find(p => p.id === promoId);
        promotionsData = promotionsData.filter(p => p.id !== promoId);
        actionPromo = "DeletePromo";
        console.log(promo);
        PromoNewEditDelete(promo);
        renderPromotions();
    }
}

/** Escape HTML special characters */
function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, m => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;' }[m]));
}
