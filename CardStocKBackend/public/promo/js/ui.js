// ===== FILE: js/ui.js =====

// ===== FILE: js/ui.js =====

// Global array for selected user types
let currentUserTypes = [];


/**
 * Handle promo type change: hide/show target fields accordingly.
 * For 'quick', hide both target fields and reset to 0.
 * For 'long', apply standard TotalToCount visibility rules.
 */
 function onPromoTypeChange() {
    const promoType = $('#promoType').val();
    const isQuick = promoType === 'quick';

    // Get the target field containers
    const targetCountField = $('#targetCountField');
    const targetTotalField = $('#targetTotalField');

    if (isQuick) {
        // Hide both and reset values to 0
        targetCountField.addClass('hidden-rule').hide();
        targetTotalField.addClass('hidden-rule').hide();
        $('#targetcCount').val(0);
        $('#targetTotal').val(0);
    } else {
        // For 'long', rely on TotalToCount logic
        // Remove hidden class and show (visibility will be managed by updateTotalFieldsVisibility)
        targetCountField.removeClass('hidden-rule').show();
        targetTotalField.removeClass('hidden-rule').show();
        // Now call the standard visibility update (which considers TotalToCount)
        updateTotalFieldsVisibility();
    }
}

/** Render the user types ribbon in the form */
function renderUserTypesRibbon() {
    const ribbon = $('#userTypesRibbon');
    ribbon.empty();
    if (currentUserTypes.length === 0) {
        ribbon.html('<span class="text-muted fst-italic">No user types selected</span>');
        return;
    }
    currentUserTypes.forEach(type => {
        ribbon.append(`
            <span class="product-badge allowed-badge">
                <span>${escapeHtml(type)}</span>
                <i class="bi bi-x-circle-fill remove-user-type" data-type="${escapeHtml(type)}"></i>
            </span>
        `);
    });
    // Bind remove event
    $('.remove-user-type').off('click').on('click', function() {
        const type = $(this).data('type');
        currentUserTypes = currentUserTypes.filter(t => t !== type);
        renderUserTypesRibbon();
    });
}

/** Open the User Types Picker Modal */
function openUserTypePicker() {
    // Predefined list of available user types (could be fetched from API)
   // const availableTypes = ['partner', 'standard'];
    const availableTypes = ['partner', 'standard'];
    renderUserTypeList(availableTypes);
    new bootstrap.Modal(document.getElementById('userTypePickerModal')).show();
}

/** Render the list of user types in the picker modal */
function renderUserTypeList(types) {
    const container = $('#userTypeList');
    container.empty();
    const searchTerm = $('#userTypeSearch').val().toLowerCase();
    let filtered = types.filter(t => t.toLowerCase().includes(searchTerm));

    if (filtered.length === 0) {
        container.html(`
            <div class="not-found-message">
                <i class="bi bi-emoji-frown"></i>
                <strong>No user types found</strong>
                <button class="btn btn-sm btn-outline-secondary mt-3 reset-search-btn">Reset search</button>
            </div>
        `);
        $('.reset-search-btn').off('click').on('click', () => {
            $('#userTypeSearch').val('').trigger('input');
        });
        return;
    }

    filtered.forEach(type => {
        const checked = currentUserTypes.includes(type) ? 'checked' : '';
        container.append(`
            <div class="api-select-item" data-type="${type}">
                <span><i class="bi bi-person"></i> ${escapeHtml(type)}</span>
                <input type="checkbox" class="form-check-input user-type-checkbox" value="${type}" ${checked} />
            </div>
        `);
    });

    // Bind click on the whole row to toggle checkbox
    $('.api-select-item').off('click').on('click', function(e) {
        // Ignore if click is directly on the checkbox (handled separately)
        if ($(e.target).is('input[type="checkbox"]')) return;
        const checkbox = $(this).find('.user-type-checkbox');
        checkbox.prop('checked', !checkbox.prop('checked'));
    });

    // Bind checkbox change to update temporary selection (optional)
    // We'll collect selection on confirm
}

/** Confirm selection from the picker and update currentUserTypes */
function confirmUserTypeSelection() {
    const selected = [];
    $('.user-type-checkbox:checked').each(function() {
        selected.push($(this).val());
    });
    // Replace the current list with the selected ones
    currentUserTypes = selected;
    renderUserTypesRibbon();
    $('#userTypePickerModal').modal('hide');
}
/**
 * Update visibility of Cart and Target fields based on:
 * 1. Promo Type (Quick → hide all target fields)
 * 2. TotalToCount (cCount / CTotal / both)
 */
 function updateTotalFieldsVisibility() {
    const promoType = $('#promoType').val();
    const val = $('#totalToCount').val();

    // --- 1. CART fields (always visible based on TotalToCount) ---
    // Cart Total field: visible unless TotalToCount = 'cCount'
    $('#cartTotalField').toggleClass('hidden-rule', val === 'cCount');
    // Cart Count field: visible unless TotalToCount = 'CTotal'
    $('#cartCountField').toggleClass('hidden-rule', val === 'CTotal');

    // --- 2. TARGET fields (affected by both Promo Type and TotalToCount) ---
    if (promoType === 'quick') {
        // Quick promotions: hide both target fields and set to 0
        $('#targetCountField').addClass('hidden-rule').hide();
        $('#targetTotalField').addClass('hidden-rule').hide();
        $('#targetcCount').val(0);
        $('#targetTotal').val(0);
    } else {
        // Long promotions: apply TotalToCount logic
        const showTargetCount = (val === 'cCount' || val === 'both');
        const showTargetTotal = (val === 'CTotal' || val === 'both');

        if (showTargetCount) {
            $('#targetCountField').removeClass('hidden-rule').show();
        } else {
            $('#targetCountField').addClass('hidden-rule').hide();
            $('#targetcCount').val(0);
        }

        if (showTargetTotal) {
            $('#targetTotalField').removeClass('hidden-rule').show();
        } else {
            $('#targetTotalField').addClass('hidden-rule').hide();
            $('#targetTotal').val(0);
        }
    }

    // Re-validate the calculator preview button
    validateCalculatorButton();
}
// --- UI update functions ---

/** Update the product ribbons (allowed, excluded) and in-stock items list */
function updateProductUIs() {
    const allowedRibbon = $('#allowedProductsRibbon');
    allowedRibbon.empty();
    if (currentAllowedArray.length === 0) {
        allowedRibbon.html('<span class="text-muted fst-italic">No products selected</span>');
    } else {
        currentAllowedArray.forEach(prod => {
            allowedRibbon.append(
                `<span class="product-badge allowed-badge">
                    <span>${escapeHtml(prod)}</span>
                    <i class="bi bi-x-circle-fill remove-allowed" data-product="${escapeHtml(prod)}"></i>
                </span>`
            );
        });
    }

    const excludedRibbon = $('#excludedProductsRibbon');
    excludedRibbon.empty();
    if (currentExcludedArray.length === 0) {
        excludedRibbon.html('<span class="text-muted fst-italic">No excluded products</span>');
    } else {
        currentExcludedArray.forEach(prod => {
            excludedRibbon.append(
                `<span class="product-badge excluded-badge">
                    <span>${escapeHtml(prod)}</span>
                    <i class="bi bi-x-circle-fill remove-excluded" data-product="${escapeHtml(prod)}"></i>
                </span>`
            );
        });
    }

    const container = $('#itemsInStockContainer');
    container.empty();
    if (currentInStockItems.length === 0) {
        container.html('<div class="alert alert-light small text-center">No gift items. Click "Add from Catalog" to add.</div>');
    } else {
        currentInStockItems.forEach((item, idx) => {
            container.append(`
                <div class="row g-2 mb-2 inStockRow align-items-center item-row" data-idx="${idx}">
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm itemName" value="${escapeHtml(item.productName)}" readonly style="background:#f3f4f6;">
                    </div>
                    <div class="col-3">
                        <input type="number" class="form-control form-control-sm itemQty" value="${item.qty}" min="1">
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill removeInstockBtn"><i class="bi bi-trash"></i> Remove</button>
                    </div>
                </div>
            `);
        });
    }

    // Bind quantity change event
    $('.itemQty').off('change').on('change', function() {
        const row = $(this).closest('.inStockRow');
        const idx = row.data('idx');
        if (idx !== undefined && currentInStockItems[idx]) {
            currentInStockItems[idx].qty = parseInt($(this).val()) || 1;
        }
        validateCalculatorButton();
    });

    // Bind remove event
    $('.removeInstockBtn').off('click').on('click', function() {
        const row = $(this).closest('.inStockRow');
        const idx = row.data('idx');
        if (idx !== undefined) {
            currentInStockItems.splice(idx, 1);
            updateProductUIs();
            validateCalculatorButton();
        }
    });

    validateCalculatorButton();
}

/** Open the product picker modal in the given mode */
async function openProductPicker(mode) {
    pickerMode = mode;
    if (!allProductsCache.length) {
        $("#pickerProductList").html('<div class="text-center p-3"><span class="loading-spinner"></span> Loading products...</div>');
        allProductsCache = await fetchProducts();
        updateAPIStatus('online');
    }
    $("#pickerModalTitle").html(
        mode === 'allowed' ? '📋 Select Eligible Products' :
        mode === 'excluded' ? '🚫 Select Excluded Products' :
        '🎁 Select Gift Items'
    );
    selectedTempProducts = [];
    $("#pickerSearch").val('');
    renderPickerList(allProductsCache);
    new bootstrap.Modal(document.getElementById('productPickerModal')).show();
}

/** Render the product list in the picker modal */
function renderPickerList(products) {
    const container = $("#pickerProductList");
    container.empty();
    const searchTerm = $("#pickerSearch").val().toLowerCase();
    let filtered = products.filter(p => p.name.toLowerCase().includes(searchTerm));

    if (filtered.length === 0) {
        container.html(`
            <div class="not-found-message">
                <i class="bi bi-emoji-frown"></i>
                <strong>No products found</strong><br>
                <small>No matches for "${escapeHtml(searchTerm)}" in the catalog</small>
                <button class="btn btn-sm btn-outline-secondary mt-3 reset-search-btn"><i class="bi bi-arrow-repeat"></i> Reset search</button>
            </div>
        `);
        $('.reset-search-btn').off('click').on('click', () => {
            $("#pickerSearch").val('').trigger('input');
        });
        return;
    }

    filtered.forEach(prod => {
        const isSelected = selectedTempProducts.includes(prod.name);
        container.append(`
            <div class="api-select-item ${isSelected ? 'selected-item' : ''}" data-product-name="${prod.name}">
                <span><i class="bi bi-box"></i> ${escapeHtml(prod.name)} (${prod.pcs=='none'?'0':prod.pcs} pcs) ($${prod.price})</span>
                <i class="bi ${isSelected ? 'bi-check-circle-fill text-success' : 'bi-plus-circle'}"></i>
            </div>
        `);
    });

    $('.api-select-item').off('click').on('click', function() {
        const pname = $(this).data('product-name');
        if (selectedTempProducts.includes(pname)) {
            selectedTempProducts = selectedTempProducts.filter(p => p !== pname);
        } else {
            selectedTempProducts.push(pname);
        }
        renderPickerList(products);
    });
}

/** Validate the calculator preview button state */
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

/** Bind form validation events */
function bindFormValidation() {
    $('#promoName, #startDatetime, #endDatetime, #productFilterRule').on('input change', () => validateCalculatorButton());
}

/** Show/hide total-dependent fields based on TotalToCount selection */
/*function updateTotalFieldsVisibility() {
    const val = $('#totalToCount').val();
    $('#cartTotalField').toggleClass('hidden-rule', val === 'cCount');
    $('#cartCountField').toggleClass('hidden-rule', val === 'CTotal');
    validateCalculatorButton();
}

/** Show/hide product selection sections based on product filter rule */
function updateUIBasedOnRule(rule) {
    $('#selectProductsSection').toggleClass('hidden-rule', rule !== 'only');
    $('#excludedSectionWrapper').toggleClass('hidden-rule', rule !== 'allExcept');
    validateCalculatorButton();
}

/** Initialize Flatpickr date pickers */
function setupDatePickers() {
    if (startPicker) startPicker.destroy();
    if (endPicker) endPicker.destroy();
    startPicker = flatpickr("#startDatetime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        onChange: () => validateCalculatorButton()
    });
    endPicker = flatpickr("#endDatetime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        onChange: () => validateCalculatorButton()
    });
}

/** Enable scroll-on-hover for the modal body */
function initModalScrollBehavior() {
    const mb = $('#scrollableModalBody');
    mb.off('mousemove').on('mousemove', function(e) {
        const rect = this.getBoundingClientRect();
        if (e.clientX - rect.left > rect.width - 10) $(this).addClass('hover-scroll');
        else $(this).removeClass('hover-scroll');
    });
    mb.off('mouseleave').on('mouseleave', function() {
        $(this).removeClass('hover-scroll');
    });
}

// --- Event delegates for removing products from ribbons ---
$(document).on('click', '.remove-allowed', function() {
    currentAllowedArray = currentAllowedArray.filter(p => p !== $(this).data('product'));
    updateProductUIs();
});
$(document).on('click', '.remove-excluded', function() {
    currentExcludedArray = currentExcludedArray.filter(p => p !== $(this).data('product'));
    updateProductUIs();
});
