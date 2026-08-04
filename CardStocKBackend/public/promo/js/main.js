// ===== FILE: js/main.js =====

// --- Global variables ---
let allProductsCache = [];
let currentAllowedArray = [], currentExcludedArray = [], currentInStockItems = [];
let startPicker, endPicker;
let promotionsData = [];
let selectedTempProducts = [];
let pickerMode = '';
let actionPromo = "CreatePromo";
let mainPromoId = "none";
let myIndex = "none";

// --- Document ready ---
$(document).ready(async function() {
    // Fetch initial product catalog
    allProductsCache = await fetchProducts();
    renderPromotions();

    // Initialize date pickers and modal scroll
    setupDatePickers();
    initModalScrollBehavior();
    bindFormValidation();

    // --- Event bindings ---

    $('#openUserTypePickerBtn').on('click', openUserTypePicker);
    $('#userTypeSearch').on('input', function() {
        // Re‑render the list based on search
       // const availableTypes = ['partner', 'standard', 'premium', 'guest', 'vip', 'employee', 'enterprise'];
        const availableTypes = ['partner', 'standard'];
        renderUserTypeList(availableTypes);
    });
    $('#userTypeSearchReset').on('click', function() {
        $('#userTypeSearch').val('');
        //const availableTypes = ['partner', 'standard', 'premium', 'guest', 'vip', 'employee', 'enterprise'];
        const availableTypes = ['partner', 'standard'];
        renderUserTypeList(availableTypes);
    });
    $('#confirmUserTypeSelection').on('click', confirmUserTypeSelection);



    // Create new promotion
    $('#createNewPromoBtn').on('click', () => openPromoModal(null));

    // Edit promotion (delegated)
    $(document).on('click', '.edit-promo', function(e) {
        e.preventDefault();
        const promo = promotionsData.find(p => p.id === $(this).data('id'));
        myIndex = $(this).data('index');
        if (promo) openPromoModal(JSON.parse(JSON.stringify(promo)));
    });

    // Delete promotion (delegated)
    $(document).on('click', '.delete-promo', function(e) {
        e.preventDefault();
        deletePromoById($(this).data('id'));
    });

    // Submit promotion form
    $('#promoForm').on('submit', (e) => {
        e.preventDefault();
        savePromotion();
    });

    // Open product picker for allowed/excluded/instock
    $('#openAllowedApiBtn').on('click', () => openProductPicker('allowed'));
    $('#openExcludedApiBtn').on('click', () => openProductPicker('excluded'));
    $('#addItemFromApiBtn').on('click', () => openProductPicker('instock'));

    // Calculator preview
    $('#calculatorPreviewBtn').on('click', () => showCalculatorPreview());

    // Product filter rule change
    $('#productFilterRule').on('change', function() {
        updateUIBasedOnRule($(this).val());
    });

    //$('#addUserFilterBtn').on('click', addUserFilter);
    // Total to count change
    $('#totalToCount').on('change', updateTotalFieldsVisibility);

    // --- Console logger toggle ---
    let consoleVisible = false;
    $('#toggleConsoleBtn').on('click', function() {
        consoleVisible = !consoleVisible;
        $('#consolePanel').toggleClass('show', consoleVisible);
    });
    $('#closeConsoleBtn, #clearConsoleBtn').on('click', function() {
        $('#consolePanel').removeClass('show');
        consoleVisible = false;
    });

    // --- Product picker search reset ---
    $("#pickerSearch").on('input', function() {
        renderPickerList(allProductsCache);
    });
    $("#searchResetIcon").on('click', function() {
        $("#pickerSearch").val('');
        renderPickerList(allProductsCache);
    });

    // --- Confirm product picker selection ---
    $("#confirmPickerSelection").on('click', function() {
        if (pickerMode === 'allowed') {
            selectedTempProducts.forEach(p => {
                if (!currentAllowedArray.includes(p)) currentAllowedArray.push(p);
            });
        } else if (pickerMode === 'excluded') {
            selectedTempProducts.forEach(p => {
                if (!currentExcludedArray.includes(p)) currentExcludedArray.push(p);
            });
        } else if (pickerMode === 'instock') {
            selectedTempProducts.forEach(p => {
                if (!currentInStockItems.some(i => i.productName === p)) {
                    currentInStockItems.push({ productName: p, qty: 1 });
                }
            });
        }
        updateProductUIs();
        $('#productPickerModal').modal('hide');
    });
});
