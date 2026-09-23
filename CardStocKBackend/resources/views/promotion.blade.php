<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>PromoManager | Smart Inventory Control (API Integrated)</title>

    <!-- ===== EXTERNAL LIBS ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ===== CUSTOM STYLES ===== -->
    <link rel="stylesheet" href="promo/css/styles.css" />
</head>
<body>

    <!-- ===== MAIN UI ===== -->
    <div class="container py-4 py-md-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-5">
            <div>
                <h1 class="display-5 fw-bold hero-title">
                    <i class="bi bi-gift-fill text-warning me-2"></i>PromoStudio
                </h1>
                <p class="text-secondary-emphasis mt-1">
                    Smart inventory • <span id="apiStatus"><i class="bi bi-cloud-check"></i> Server-driven product catalog</span>
                </p>
            </div>
            <button class="btn btn-dark rounded-pill px-4 shadow-sm" id="createNewPromoBtn">
                <i class="bi bi-plus-lg me-2"></i>New Promotion
            </button>
        </div>
        <div id="promotionsGrid" class="row g-4"></div>
    </div>

    <!-- ===== CONSOLE LOGGER ===== -->
    <button class="toggle-console" id="toggleConsoleBtn">
        <i class="bi bi-terminal-fill"></i> Console Logs
    </button>
    <div class="console-log-panel" id="consolePanel">
        <div class="console-header" id="clearConsoleBtn">
            <h6><i class="bi bi-bug"></i> Promotion Logger</h6>
            <i class="bi bi-x-lg" id="closeConsoleBtn"></i>
        </div>
        <div id="consoleLogs">
            <div class="console-log-entry info">📋 Ready</div>
        </div>
    </div>

    <!-- ===== PROMO MODAL ===== -->
    <div class="modal fade" id="promoModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold fs-3" id="modalTitle">✨ Create Promotion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-4 modal-body-scroll" id="scrollableModalBody">
                    <form id="promoForm">
                        <input type="hidden" id="editId" />
                        <div class="row g-3">

                            <div class="col-md-12">
                                <label class="form-label fw-semibold required-star">
                                    <i class="bi bi-tag-fill me-1"></i> Promotion Name
                                </label>
                                <input type="text" class="form-control" id="promoName" required />
                            </div>

                            <div class="col-md-12">
    <label class="form-label fw-semibold">
        <i class="bi bi-card-text me-1"></i> Description
    </label>
    <textarea class="form-control" id="promoDescription" rows="2" placeholder="Brief description of the promotion (optional)"></textarea>
</div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-upc-scan me-1"></i> Promotion ID
                                </label>
                                <input type="text" class="form-control" id="promoId" readonly style="background:#e9ecef; font-family: monospace;" />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Promo Type</label>
                                <select class="form-select" id="promoType"  onchange="onPromoTypeChange()">
                                    <option value="quick">🔥 Quick</option>
                                    <option value="long">⏳ Long</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold required-star">Start Date &amp; Time</label>
                                <input type="text" class="form-control" id="startDatetime" autocomplete="off" />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold required-star">End Date &amp; Time</label>
                                <input type="text" class="form-control" id="endDatetime" autocomplete="off" />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Amount (Reward $)</label>
                                <input type="text" class="form-control" id="promoAmount" value="100" />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Total To Count</label>
                                <select class="form-select" id="totalToCount">
                                    <option value="cCount">cCount (Count items only)</option>
                                    <option value="both">both (Cart Total + Count)</option>
                                    <option value="CTotal">CTotal (Cart Total only)</option>
                                </select>
                            </div>

                            <div class="col-md-6 total-dependent-field" id="cartTotalField">
                                <label class="form-label fw-semibold">Cart Total (min $)</label>
                                <input type="number" class="form-control" id="condCartTotal" value="500" />
                            </div>

                            <div class="col-md-6 total-dependent-field" id="cartCountField">
                                <label class="form-label fw-semibold">Cart Count (min items)</label>
                                <input type="number" class="form-control" id="condCartCount" value="10" />
                            </div>
<!--Target Count-->
<!-- Target Count field -->
<div class="col-md-6 target-dependent-field" id="targetCountField">
    <label class="form-label fw-semibold">Target Count (min items to withdraw)</label>
    <input type="number" class="form-control" id="targetcCount" value="0" min="0" />
</div>
<!-- Target Total field -->
<div class="col-md-6 target-dependent-field" id="targetTotalField">
    <label class="form-label fw-semibold">Target Total (min $ to withdraw)</label>
    <input type="number" class="form-control" id="targetTotal" value="0" min="0" />
</div>
<!--Target Count-->
<div class="col-12">
    <div class="label-button-row">
        <label class="form-label fw-semibold">
            <i class="bi bi-person-badge me-1"></i> 👥 User Types Eligible
        </label>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" id="openUserTypePickerBtn">
            <i class="bi bi-person-plus"></i> Browse User Types
        </button>
    </div>
    <div id="userTypesRibbon" class="product-ribbon"></div>
    <small class="text-muted">Select one or more user types that are eligible for this promotion.</small>
</div>

<!-- User Types Picker Modal -->
<div class="modal fade" id="userTypePickerModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-badge me-2"></i>Select User Types</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="search-with-reset mb-2">
                    <input type="text" id="userTypeSearch" class="form-control" placeholder="Search user types..." />
                    <span class="search-reset-icon" id="userTypeSearchReset" title="Reset search">
                        <i class="bi bi-arrow-repeat"></i>
                    </span>
                </div>
                <div id="userTypeList" class="api-select" style="max-height: 300px; overflow-y: auto;">
                    <!-- Will be populated by JS -->
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill" id="confirmUserTypeSelection">Add Selected</button>
            </div>
        </div>
    </div>
</div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Card Required?</label>
                                <select class="form-select" id="condCard">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-funnel-fill me-1"></i> Product Filter Rule
                                </label>
                                <select class="form-select" id="productFilterRule">
                                    <option value="only">🔹 Only (Restrict to specific products)</option>
                                    <option value="all">🌍 All (No restrictions - any product qualifies)</option>
                                    <option value="allExcept">🚫 All Except (Exclude specific products)</option>
                                </select>
                            </div>

                            <div class="col-md-12 rule-dependent-section" id="selectProductsSection">
                                <div class="label-button-row">
                                    <label class="form-label fw-semibold required-star">
                                        <i class="bi bi-check-circle-fill text-success me-1"></i> ✅ Select Eligible Products (Required)
                                    </label>
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" id="openAllowedApiBtn">
                                        <i class="bi bi-database"></i> Browse Products
                                    </button>
                                </div>
                                <div id="allowedProductsRibbon" class="product-ribbon"></div>
                                <div id="allowedProductsError" class="text-danger small mt-1" style="display:none;">
                                    ⚠️ Please add at least one eligible product
                                </div>
                            </div>

                            <div class="col-md-12 rule-dependent-section" id="excludedSectionWrapper">
                                <div class="label-button-row">
                                    <label class="form-label fw-semibold required-star">
                                        <i class="bi bi-x-circle-fill text-danger me-1"></i> 🚫 Excluded Products (Required)
                                    </label>
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" id="openExcludedApiBtn">
                                        <i class="bi bi-database"></i> Browse Products
                                    </button>
                                </div>
                                <div id="excludedProductsRibbon" class="product-ribbon"></div>
                                <div id="excludedProductsError" class="text-danger small mt-1" style="display:none;">
                                    ⚠️ Please add at least one excluded product
                                </div>
                            </div>

                            <div class="col-12">
                                <hr />
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                    <label class="fw-semibold">
                                        <i class="bi bi-box-seam"></i> 🎁 InStock Items (Gifts / Rewards)
                                    </label>
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" id="addItemFromApiBtn">
                                        <i class="bi bi-plus-circle"></i> Add from Catalog
                                    </button>
                                </div>
                                <div id="itemsInStockContainer" class="bg-light bg-opacity-25 p-2 rounded-3"></div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Target Point (optional)</label>
                                <input type="number" class="form-control" id="targetPoint" placeholder="7000" />
                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-2">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-info rounded-pill px-4 text-white" id="calculatorPreviewBtn" disabled>
                                <i class="bi bi-calculator-fill me-1"></i> Calculator Preview
                            </button>
                            <button type="submit" class="btn btn-dark rounded-pill px-5">Save Promotion</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== CALCULATOR PREVIEW MODAL ===== -->
    <div class="modal fade" id="calculatorModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold fs-3">
                        <i class="bi bi-calculator-fill me-2"></i>Promotion Calculator Preview
                    </h5>
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

    <!-- ===== PRODUCT PICKER MODAL ===== -->
    <div class="modal fade" id="productPickerModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold" id="pickerModalTitle">Select Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="search-with-reset mb-2">
                        <input type="text" id="pickerSearch" class="form-control" placeholder="Search products..." />
                        <span class="search-reset-icon" id="searchResetIcon" title="Reset search">
                            <i class="bi bi-arrow-repeat"></i>
                        </span>
                    </div>
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
    window.APP_VERSION = '{{ env('APP_VERS') }}';
</script>
    <!-- ===== SPLIT SCRIPTS ===== -->
    <script src="promo/js/api.js"></script>
    <script src="promo/js/ui.js"></script>
    <script src="promo/js/calculator.js"></script>
    <script src="promo/js/promotions.js"></script>
    <script src="promo/js/main.js"></script>

</body>
</html>
