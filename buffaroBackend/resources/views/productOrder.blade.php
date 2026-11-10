<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise POS - Modern Sales Terminal</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --pos-bg: #f4f6f8;
            --pos-card-bg: #ffffff;
            --pos-border: #e9ecef;
            --pos-border-hover: #ced4da;
            --pos-text-main: #1e293b;
            --pos-text-muted: #64748b;
            --pos-primary: #2563eb;
            --pos-primary-hover: #1d4ed8;
            --pos-primary-light: #eff6ff;
            --pos-accent: #0f172a;
            --pos-success: #10b981;
            --pos-warning: #f59e0b;
            --pos-danger: #ef4444;
            --pos-shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.04);
            --pos-shadow-md: 0 4px 12px rgba(0, 0, 0, 0.05);
            --pos-shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.08);
            --pos-radius: 8px;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--pos-bg);
            color: var(--pos-text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: rgba(0,0,0,0.02); }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .pos-header-bar {
            background: var(--pos-card-bg);
            border-bottom: 1px solid var(--pos-border);
            padding: 12px 24px;
            box-shadow: var(--pos-shadow-sm);
        }

        .pos-card {
            background: var(--pos-card-bg);
            border: 1px solid var(--pos-border);
            border-radius: var(--pos-radius);
            box-shadow: var(--pos-shadow-sm);
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .pos-card:hover { border-color: var(--pos-border-hover); }

        .form-control, .form-select, .input-group-text {
            border-color: var(--pos-border);
            border-radius: 6px;
            font-size: 0.9rem;
            box-shadow: none !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--pos-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
        }

        .kbd-hint {
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 2px 6px;
            font-size: 0.725rem;
            font-weight: 600;
            color: #475569;
        }

        .autocomplete-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1050;
            background: #ffffff;
            border: 1px solid var(--pos-border);
            border-radius: 8px;
            box-shadow: var(--pos-shadow-lg);
            max-height: 350px;
            overflow-y: auto;
            margin-top: 4px;
            display: none;
        }

        .autocomplete-item {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: background-color 0.12s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .autocomplete-item:last-child { border-bottom: none; }
        .autocomplete-item:hover, .autocomplete-item.active { background-color: var(--pos-primary-light); }

        .product-img-thumb {
            width: 38px;
            height: 38px;
            border-radius: 6px;
            object-fit: cover;
            background-color: #f1f5f9;
            border: 1px solid var(--pos-border);
        }

        .category-chip {
            background-color: #ffffff;
            border: 1px solid var(--pos-border);
            color: var(--pos-text-muted);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 0.825rem;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.15s ease;
        }

        .category-chip:hover, .category-chip.active {
            background-color: var(--pos-accent);
            color: #ffffff;
            border-color: var(--pos-accent);
        }

        .cart-table-wrapper {
            background: #ffffff;
            border-radius: var(--pos-radius);
            overflow: hidden;
        }

        .cart-table th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--pos-text-muted);
            font-weight: 600;
            background-color: #f8fafc;
            border-bottom: 1px solid var(--pos-border);
            padding: 12px 16px;
        }

        .cart-table td {
            vertical-align: middle;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
        }

        .cart-row-editing { background-color: #f0f9ff !important; }

        .qty-btn {
            width: 28px;
            height: 28px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            font-size: 0.85rem;
            border: 1px solid var(--pos-border);
            background: #ffffff;
            color: var(--pos-text-main);
            transition: all 0.15s ease;
        }

        .qty-btn:hover { background-color: #f1f5f9; border-color: var(--pos-border-hover); }

        .qty-input {
            width: 48px;
            text-align: center;
            border: 1px solid var(--pos-border);
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 2px 4px;
        }

        .summary-grand-total {
            background: #f8fafc;
            border: 1px solid var(--pos-border);
            border-radius: 8px;
            padding: 16px;
        }

        .grand-total-amount {
            font-size: 2rem;
            font-weight: 700;
            color: var(--pos-primary);
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .toast-container { z-index: 1090; }

        @media (max-width: 767.98px) {
            .cart-table thead { display: none; }
            .cart-table, .cart-table tbody, .cart-table tr, .cart-table td { display: block; width: 100%; }
            .cart-table tr {
                margin-bottom: 12px;
                border: 1px solid var(--pos-border);
                border-radius: 8px;
                padding: 12px;
                background-color: #ffffff;
            }
            .cart-table td {
                padding: 6px 0;
                border: none;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .cart-table td::before {
                content: attr(data-label);
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                color: var(--pos-text-muted);
            }
        }
    </style>
</head>
<body>

    <header class="pos-header-bar mb-3">
        <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between gap-2">

            <div class="d-flex align-items-center gap-3">
                <div class="bg-dark text-white rounded p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-cart-check fs-5"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <h1 class="h5 mb-0 fw-bold tracking-tight">Sales Terminal</h1>
                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle uppercase px-2 py-1" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.05em;">DRAFT</span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle uppercase px-2 py-1" id="activeCurrencyBadge" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.05em;">USD ($)</span>
                    </div>
                    <div class="text-muted small d-flex align-items-center gap-2 mt-1">
                        <span>Ref: <strong class="text-dark" id="orderRefDisplay">#ORD-2026-8942</strong></span>
                        <span>•</span>
                        <span>Terminal #01</span>
                        <span>•</span>
                        <span id="currentTimeDisplay">--:--:--</span>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 flex-grow-1 flex-md-grow-0 justify-content-end">
                <div class="d-flex align-items-center gap-2 bg-light p-1 px-2 border rounded" style="max-width: 300px; width: 100%;">
                    <i class="bi bi-tags text-primary fs-6"></i>
                    <select id="priceListSelector" class="form-select form-select-sm border-0 bg-transparent fw-semibold text-dark shadow-none" style="cursor: pointer;">
                        <option value="LOCAL_USD">Local Price (USD)</option>
                        <option value="EXPORT_USD">Export Price (USD)</option>
                        <option value="EXPORT_EUR">Export Price (EUR)</option>
                        <option value="WHOLESALE_RWF">Wholesale Price (RWF)</option>
                    </select>
                </div>

                <div class="d-none d-lg-flex align-items-center gap-2 ms-2 me-2">
                    <span class="text-muted extra-small" style="font-size: 0.8rem;"><span class="kbd-hint">F2</span> Search</span>
                    <span class="text-muted extra-small" style="font-size: 0.8rem;"><span class="kbd-hint">F4</span> Client</span>
                    <span class="text-muted extra-small" style="font-size: 0.8rem;"><span class="kbd-hint">F9</span> Pay</span>
                </div>
                <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" onclick="resetSale(true)" title="Reset Terminal">
                    <i class="bi bi-arrow-counterclockwise"></i> <span class="d-none d-sm-inline">Reset</span>
                </button>
                <div class="vr h-50 my-auto mx-1 d-none d-sm-block"></div>
                <span class="badge bg-success-subtle text-success border border-success-subtle d-none d-sm-flex align-items-center gap-1 py-1 px-2">
                    <span class="spinner-grow spinner-grow-sm text-success" style="width: 6px; height: 6px;" role="status"></span>
                    Online
                </span>
            </div>

        </div>
    </header>

    <main class="container-fluid px-3 px-md-4 flex-grow-1 pb-4">
        <div class="row g-3">

            <div class="col-lg-7 col-xl-8 d-flex flex-column gap-3">

                <section class="pos-card p-3">
                    <div class="position-relative">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0 text-muted pe-1">
                                <i class="bi bi-search fs-5"></i>
                            </span>
                            <input type="text" id="productSearchInput" class="form-control border-start-0 border-end-0 ps-2" placeholder="Search product name, SKU, or scan barcode... (Press '/')" autocomplete="off">
                            <button class="btn btn-outline-secondary border-start-0 bg-white text-muted px-3" type="button" id="barcodeScanBtn" title="Simulate Barcode Scanner">
                                <i class="bi bi-qr-code-scan me-1"></i> <span class="d-none d-sm-inline fs-7">Scan</span>
                            </button>
                        </div>

                        <div id="productSearchResults" class="autocomplete-dropdown"></div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-3 overflow-x-auto pb-1" id="categoryChipsContainer">
                        <button class="category-chip active" data-category="ALL">All Items</button>
                        <button class="category-chip" data-category="Beverages">Beverages</button>
                        <button class="category-chip" data-category="Snacks">Snacks</button>
                        <button class="category-chip" data-category="Electronics">Electronics</button>
                        <button class="category-chip" data-category="Groceries">Groceries</button>
                        <button class="category-chip" data-category="Apparel">Apparel</button>
                    </div>
                </section>

                <section class="pos-card p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label small fw-bold text-muted mb-0 text-uppercase"><i class="bi bi-person me-1"></i>Client Selection</label>
                        <button class="btn btn-link text-primary text-decoration-none p-0 small fw-medium" data-bs-toggle="modal" data-bs-target="#addClientModal">
                            <i class="bi bi-person-plus me-1"></i>Add New Client
                        </button>
                    </div>

                    <div class="row g-2 align-items-center">
                        <div class="col-md-7 position-relative">
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" id="clientSearchInput" class="form-control" placeholder="Search client by name or phone... (F4)" autocomplete="off">
                            </div>

                            <div id="clientSearchResults" class="autocomplete-dropdown"></div>
                        </div>

                        <div class="col-md-5">
                            <div id="selectedClientCard" class="p-2 border rounded bg-light d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;" id="clientAvatar">
                                        WG
                                    </div>
                                    <div class="text-truncate" style="max-width: 140px;">
                                        <div class="fw-semibold text-dark small text-truncate" id="clientName">ERic</div>
                                        <div class="extra-small text-muted text-truncate" style="font-size: 0.725rem;" id="clientPhone">Standard Customer</div>
                                    </div>
                                </div>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill extra-small" id="clientPointsPill">
                                    <i class="bi bi-star-fill me-1"></i>0 pts
                                </span>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="pos-card d-flex flex-column flex-grow-1">
                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-bag-check text-muted fs-5"></i>
                            <h2 class="h6 mb-0 fw-bold">Shopping Cart <span class="text-muted extra-small font-normal">(Newest items on top)</span></h2>
                            <span class="badge rounded-pill bg-light text-dark border ms-1" id="cartItemCountBadge">0 items</span>
                        </div>
                        <button class="btn btn-link text-danger text-decoration-none p-0 border-0 small" onclick="clearCart()" id="clearCartBtn" style="display: none; font-size: 0.825rem;">
                            <i class="bi bi-trash me-1"></i>Clear Cart
                        </button>
                    </div>

                    <div class="cart-table-wrapper flex-grow-1">
                        <table class="table cart-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 42%;">Item Description</th>
                                    <th class="text-end" style="width: 18%;">Price</th>
                                    <th class="text-center" style="width: 20%;">Qty</th>
                                    <th class="text-end" style="width: 16%;">Total</th>
                                    <th class="text-center" style="width: 4%;"></th>
                                </tr>
                            </thead>
                            <tbody id="cartTableBody"></tbody>
                        </table>

                        <div id="emptyCartState" class="text-center py-5 px-3">
                            <div class="mb-3 text-muted opacity-50">
                                <i class="bi bi-cart-x display-3"></i>
                            </div>
                            <h3 class="h6 fw-semibold text-dark mb-1">Your shopping cart is empty</h3>
                            <p class="text-muted small mb-3" style="max-width: 320px; margin: 0 auto;">
                                Use the product search bar above or click category chips to add items to the order.
                            </p>
                            <button class="btn btn-sm btn-outline-primary" onclick="focusSearch()">
                                <i class="bi bi-plus-circle me-1"></i>Browse Products
                            </button>
                        </div>
                    </div>
                </section>

            </div>

            <div class="col-lg-5 col-xl-4 d-flex flex-column gap-3">

                <section class="pos-card p-4">
                    <h2 class="h6 fw-bold border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                        <span>Order Summary</span>
                        <span class="badge bg-light text-muted border fw-normal extra-small" id="summaryTotalItems">0 items</span>
                    </h2>

                    <div class="d-flex flex-column gap-2 small mb-3">
                        <div class="d-flex justify-content-between text-muted">
                            <span>Subtotal</span>
                            <span class="fw-semibold text-dark" id="summarySubtotal">$0.00</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center d-none">
                            <span class="text-muted">Discount</span>
                            <div class="d-flex align-items-center gap-1" style="width: 130px;">
                                <input type="number" id="discountInput" class="form-control form-control-sm text-end p-1" placeholder="0" min="0" value="0">
                                <select id="discountTypeSelect" class="form-select form-select-sm px-1" style="width: 50px;">
                                    <option value="PERCENT">%</option>
                                    <option value="FIXED">$</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center text-muted d-none">
                            <div class="d-flex align-items-center gap-1">
                                <span>Tax (10%)</span>
                                <div class="form-check form-switch ms-1 mb-0 min-height-0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="taxToggle" checked>
                                </div>
                            </div>
                            <span class="fw-semibold text-dark" id="summaryTax">$0.00</span>
                        </div>
                    </div>

                    <div class="summary-grand-total text-center mb-3">
                        <div class="text-uppercase fw-bold text-muted extra-small mb-1">Grand Total</div>
                        <div class="grand-total-amount" id="summaryGrandTotal">$0.00</div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-bold mb-0">Amount Paid</label>
                            <span class="extra-small text-muted">Editable Field</span>
                        </div>
                        <input type="number" id="clientPaidInput" class="form-control form-control-lg fw-bold text-end text-primary" placeholder="0.00" step="0.01">

                        <div class="d-flex gap-1 mt-2" id="cashPresetsContainer"></div>
                    </div>

                    <div id="balanceStatusAlert" class="p-3 rounded border text-center mb-3">
                        <div class="fw-bold fs-6" id="balanceStatusTitle">UNPAID / OUTSTANDING DEBT</div>
                        <div class="small mt-1" id="balanceStatusAmount">$0.00</div>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <button class="btn btn-primary btn-lg fw-bold py-3 w-100 d-flex align-items-center justify-content-center gap-2" id="payButton" onclick="openPaymentModal()" disabled>
                            <i class="bi bi-credit-card-2-back fs-4"></i>
                            <span>Submit Order & Pay (F9)</span>
                        </button>

                        <div class="row g-2">
                            <div class="col-6">
                                <button class="btn btn-outline-secondary w-100 fw-medium btn-sm py-2" onclick="saveDraftOrder()">
                                    <i class="bi bi-bookmark-check me-1"></i>Save Draft
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-danger w-100 fw-medium btn-sm py-2" onclick="cancelSale()">
                                    <i class="bi bi-x-circle me-1"></i>Cancel Draft
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

        </div>
    </main>

    <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Complete Order & Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <div class="p-3 bg-light rounded mb-3 border text-center">
                        <div class="row">
                            <div class="col-6 border-end">
                                <div class="text-muted extra-small uppercase fw-bold">Grand Total</div>
                                <div class="fs-4 fw-bold text-dark" id="modalGrandTotalDisplay">$0.00</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted extra-small uppercase fw-bold">Amount Paid</div>
                                <div class="fs-4 fw-bold text-primary" id="modalAmountPaidDisplay">$0.00</div>
                            </div>
                        </div>
                    </div>

                    <div id="modalStatusBanner" class="p-2 rounded border text-center mb-3 fw-bold small"></div>

                    <label class="form-label extra-small fw-bold text-muted uppercase">Payment Mode</label>
                    <ul class="nav nav-pills nav-justified mb-3 gap-2" id="paymentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active border fw-medium py-2" id="cash-tab" data-bs-toggle="pill" data-bs-target="#cash-panel" type="button" role="tab"><i class="bi bi-cash me-1"></i>Cash</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link border fw-medium py-2" id="card-tab" data-bs-toggle="pill" data-bs-target="#card-panel" type="button" role="tab"><i class="bi bi-credit-card me-1"></i>Card</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link border fw-medium py-2" id="account-tab" data-bs-toggle="pill" data-bs-target="#account-panel" type="button" role="tab"><i class="bi bi-person-badge me-1"></i>On Account</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="paymentTabsContent">
                        <div class="tab-pane fade show active" id="cash-panel" role="tabpanel">
                            <p class="extra-small text-muted mb-0">Cash tendered has been recorded. Verify change to return before finalizing transaction.</p>
                        </div>
                        <div class="tab-pane fade text-center py-2" id="card-panel" role="tabpanel">
                            <i class="bi bi-credit-card-2-front text-primary display-4"></i>
                            <p class="small text-muted mt-2 mb-0">Ready for contactless tap or card swipe on terminal POS-01.</p>
                        </div>
                        <div class="tab-pane fade py-2" id="account-panel" role="tabpanel">
                            <div class="p-2 bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded small">
                                <i class="bi bi-info-circle me-1"></i> Outstanding balance will be posted to customer credit balance: <strong id="modalCustomerAccountName">Walk-in Guest</strong>.
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">Back to Cart</button>
                    <button type="button" class="btn btn-success w-100 py-2 fw-bold" onclick="processFinalTransaction()">
                        <i class="bi bi-check-circle me-1"></i>Confirm & Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addClientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold fs-6">Add New Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newClientForm">
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Full Name</label>
                            <input type="text" id="newClientName" class="form-control" placeholder="e.g. Sarah Jenkins" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Phone Number</label>
                            <input type="tel" id="newClientPhone" class="form-control" placeholder="+1 (555) 000-0000">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Email Address</label>
                            <input type="email" id="newClientEmail" class="form-control" placeholder="sarah@example.com">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="saveNewClient()">Save Customer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="actionToast" class="toast align-items-center text-white bg-dark border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2" id="toastMessage">
                    <i class="bi bi-info-circle text-info"></i> Action completed.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

   <script>
    /* ============================================================
       APP VERSION — provided by the server (Blade / env).
       ============================================================ */
    window.APP_VERSION = (typeof window.APP_VERSION === 'string' && window.APP_VERSION !== '')
        ? window.APP_VERSION
        : '{{ env('APP_VERS') }}';
    window.DEFAULT_CURRENCY = (typeof window.DEFAULT_CURRENCY === 'string' && window.DEFAULT_CURRENCY !== '')
        ? window.DEFAULT_CURRENCY
        : '{{ env('DEFAULT_CURRENCY') }}';
    const userName = @json(auth()->user());

    console.log(userName);

    /* MOCK DATABASE */
    const MOCK_PRODUCTS = [
        { id: 'p1', code: 'PRD-101', name: 'Espresso Roast Coffee Beans 1kg', category: 'Beverages', prices: { 'LOCAL_USD': 18.50, 'EXPORT_USD': 14.80, 'EXPORT_EUR': 13.50, 'WHOLESALE_RWF': 24000 }, stock: 42, img: 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=100&q=80' },
        { id: 'p2', code: 'PRD-102', name: 'Organic Sparkling Oat Latte', category: 'Beverages', prices: { 'LOCAL_USD': 4.25, 'EXPORT_USD': 3.40, 'EXPORT_EUR': 3.10, 'WHOLESALE_RWF': 5500 }, stock: 120, img: 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=100&q=80' },
        { id: 'p3', code: 'PRD-103', name: 'Artisanal Almond Croissant', category: 'Snacks', prices: { 'LOCAL_USD': 3.75, 'EXPORT_USD': 3.00, 'EXPORT_EUR': 2.75, 'WHOLESALE_RWF': 4800 }, stock: 15, img: 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=100&q=80' },
        { id: 'p4', code: 'PRD-104', name: 'Wireless Ergonomic Mouse', category: 'Electronics', prices: { 'LOCAL_USD': 49.99, 'EXPORT_USD': 42.00, 'EXPORT_EUR': 38.50, 'WHOLESALE_RWF': 65000 }, stock: 8, img: 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=100&q=80' },
        { id: 'p5', code: 'PRD-105', name: 'USB-C Fast Charging Cable 2m', category: 'Electronics', prices: { 'LOCAL_USD': 12.99, 'EXPORT_USD': 9.99, 'EXPORT_EUR': 9.20, 'WHOLESALE_RWF': 16500 }, stock: 65, img: 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=100&q=80' },
        { id: 'p6', code: 'PRD-106', name: 'Dark Chocolate Bar 85%', category: 'Snacks', prices: { 'LOCAL_USD': 2.99, 'EXPORT_USD': 2.20, 'EXPORT_EUR': 2.00, 'WHOLESALE_RWF': 3800 }, stock: 85, img: 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?w=100&q=80' },
        { id: 'p7', code: 'PRD-107', name: 'Natural Mineral Water 750ml', category: 'Beverages', prices: { 'LOCAL_USD': 1.50, 'EXPORT_USD': 1.10, 'EXPORT_EUR': 1.00, 'WHOLESALE_RWF': 1900 }, stock: 200, img: 'https://images.unsplash.com/photo-1560023907-5f339617ea30?w=100&q=80' },
        { id: 'p8', code: 'PRD-108', name: 'Cotton Crewneck T-Shirt L', category: 'Apparel', prices: { 'LOCAL_USD': 24.00, 'EXPORT_USD': 19.50, 'EXPORT_EUR': 18.00, 'WHOLESALE_RWF': 31000 }, stock: 19, img: 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=100&q=80' }
    ];

    const PRICE_LISTS = {
        'LOCAL_USD': { id: 'LOCAL_USD', name: 'Local Price', currency: 'USD', symbol: '$', decimal: 2, orderType: 'local' },
        'EXPORT_USD': { id: 'EXPORT_USD', name: 'Export Price', currency: 'USD', symbol: '$', decimal: 2, orderType: 'export' },
        'EXPORT_EUR': { id: 'EXPORT_EUR', name: 'Export Price', currency: 'EUR', symbol: '€', decimal: 2, orderType: 'export' },
        'WHOLESALE_RWF': { id: 'WHOLESALE_RWF', name: 'Wholesale Price', currency: 'RWF', symbol: 'RWF ', decimal: 0, orderType: 'wholesale' }
    };

    const UserString = localStorage.getItem("User");
    let user = JSON.parse(UserString);

    const MOCK_CLIENTS = [
        { id: user.uid, name: user.name, phone: 'Standard Customer', points: 0, avatar: 'AD' },
        { id: 'c2', name: 'Alexander Wright', phone: '+1 (555) 234-5678', points: 420, avatar: 'AW' },
        { id: 'c3', name: 'Elena Rostova', phone: '+1 (555) 876-5432', points: 1150, avatar: 'ER' },
        { id: 'c4', name: 'Marcus Brody', phone: '+1 (555) 345-9988', points: 85, avatar: 'MB' }
    ];

    let activePriceListKey = 'LOCAL_USD';

    const API_CONFIG = {
        baseUrl: '/api',
        authToken: 'YOUR_AUTH_TOKEN'
    };

    let cartStore = {
        'LOCAL_USD': { cart: [], selectedClient: MOCK_CLIENTS[0], discountVal: 0, discountType: 'PERCENT', taxEnabled: true, amountPaid: '' },
        'EXPORT_USD': { cart: [], selectedClient: MOCK_CLIENTS[0], discountVal: 0, discountType: 'PERCENT', taxEnabled: false, amountPaid: '' },
        'EXPORT_EUR': { cart: [], selectedClient: MOCK_CLIENTS[0], discountVal: 0, discountType: 'PERCENT', taxEnabled: false, amountPaid: '' },
        'WHOLESALE_RWF': { cart: [], selectedClient: MOCK_CLIENTS[0], discountVal: 0, discountType: 'PERCENT', taxEnabled: true, amountPaid: '' }
    };

    let currencyLoad = PRICE_LISTS['LOCAL_USD'];
    let selectedCategory = 'ALL';
    let highlightedSearchIndex = -1;
    let searchDebounceTimer = null;
    let clientSearchDebounceTimer = null;
    let clientPrefetchDone = false;
    let bsPaymentModal = null;
    let bsAddClientModal = null;
    //let placeOrderBusy = false;
    let placeOrderBusy = false;
let submitOrderBusy = false;   // ✅ guards against double SubmitOrder POSTs

    /* Per-product debounce timers for EditTOrder */
    const qtyEditTimers = {};

    /* ============================================================
       Helpers — price resolution / normalization (unchanged)
       ============================================================ */
    function getUnitPrice(product) {
        if (!product || product.prices == null) return 0;
        if (typeof product.prices === 'number') {
            return parseFloat(product.prices) || 0;
        }
        const keyed = product.prices[activePriceListKey];
        if (keyed !== undefined && keyed !== null && !isNaN(parseFloat(keyed))) {
            return parseFloat(keyed);
        }
        const fallback = product.prices['LOCAL_USD'];
        if (fallback !== undefined && fallback !== null && !isNaN(parseFloat(fallback))) {
            return parseFloat(fallback);
        }
        const firstNum = Object.values(product.prices).find(v => v !== null && v !== undefined && !isNaN(parseFloat(v)));
        return firstNum !== undefined ? parseFloat(firstNum) : 0;
    }

    function normalizeProductPrices(product, basePrice, activeKey) {
        const price = parseFloat(basePrice) || 0;
        if (typeof product.prices !== 'object' || product.prices === null) {
            product.prices = {};
        }
        Object.keys(PRICE_LISTS).forEach(k => {
            if (product.prices[k] === undefined || product.prices[k] === null || isNaN(parseFloat(product.prices[k]))) {
                product.prices[k] = price;
            }
        });
        if (activeKey) {
            product.prices[activeKey] = price;
        }
        return product;
    }

    function pickField(data, candidates) {
        if (!data) return null;
        const firstItem = Array.isArray(data.result) && data.result.length > 0 ? data.result[0] : null;

        const containers = [
            data, data.order, data.customer, data.client, data.user, data.data, firstItem, data.result
        ].filter(Boolean);

        for (const container of containers) {
            for (const key of candidates) {
                if (container[key] !== undefined && container[key] !== null && container[key] !== '') {
                    return container[key];
                }
            }
        }
        return null;
    }

    function applyBackendOrderAndClient(data) {
        if (!data) return;

        const apiUid = pickField(data, ['uid', 'orderUid', 'OrderUid', 'order_uid', 'OrderUID', 'uid_order', 'ref', 'reference', 'orderReference']);
        if (apiUid) {
            const el = document.getElementById('orderRefDisplay');
            if (el) el.textContent = apiUid.toString().startsWith('#') ? apiUid.toString() : `#${apiUid}`;
            cartStore[activePriceListKey].apiUid = apiUid;
            console.log('[POS] Order ref updated from backend:', apiUid);
        }

        const apiName = pickField(data, ['name', 'Name', 'customerName', 'CustomerName', 'clientName', 'ClientName', 'fullName', 'FullName']);
        const apiPhone = pickField(data, ['PhoneNumber', 'phoneNumber', 'Phone', 'phone', 'telephone', 'Telephone', 'phone_number', 'Phone_Number', 'mobile', 'Mobile']);

        if (apiName || apiPhone) {
            const displayName = apiName ? String(apiName) : user.name;
            const displayPhone = apiPhone ? String(apiPhone) : 'Admin';

            const initials = displayName
                .split(' ')
                .filter(Boolean)
                .map(n => n[0])
                .join('')
                .toUpperCase()
                .slice(0, 2) || 'WG';

            let matchedClient = MOCK_CLIENTS.find(
                c => (apiPhone && c.phone === displayPhone) || (apiName && c.name === displayName)
            );

            if (!matchedClient) {
                matchedClient = {
                    id: `c_api_${Date.now()}`,
                    name: displayName,
                    phone: displayPhone,
                    points: 0,
                    avatar: initials
                };
                MOCK_CLIENTS.push(matchedClient);
            }

            cartStore[activePriceListKey].selectedClient = matchedClient;
            cartStore[activePriceListKey].apiClientName = displayName;
            cartStore[activePriceListKey].apiClientPhone = displayPhone;

            const avatarEl = document.getElementById('clientAvatar');
            const nameEl = document.getElementById('clientName');
            const phoneEl = document.getElementById('clientPhone');
            const pointsEl = document.getElementById('clientPointsPill');
            const modalNameEl = document.getElementById('modalCustomerAccountName');

            if (avatarEl) avatarEl.innerText = initials;
            if (nameEl) nameEl.innerText = displayName;
            if (phoneEl) phoneEl.innerText = displayPhone;
            if (pointsEl) pointsEl.innerHTML = `<i class="bi bi-star-fill me-1"></i>${matchedClient.points} pts`;
            if (modalNameEl) modalNameEl.innerText = displayName;

            console.log('[POS] Client updated from backend:', { name: displayName, phone: displayPhone });
        }
    }

    /* ============================================================
       Shared API helpers
       ============================================================ */
    function getAuthToken() {
        return localStorage.getItem("Usertoken")
            || localStorage.getItem("Auth_token")
            || API_CONFIG.authToken;
    }

    function buildUidClient(store) {
        const selectedClient = (store && store.selectedClient) || MOCK_CLIENTS[0];
        return (selectedClient && (selectedClient.uid || selectedClient.rawUid || selectedClient.id)) || 'none';
    }

    /* ============================================================
       Client search via GET /SearchUser
       ============================================================ */
    async function searchUsersApi(params) {
        try {
            const userToken = getAuthToken();

            const qs = new URLSearchParams();
            Object.keys(params).forEach(k => {
                if (params[k] !== undefined && params[k] !== null) {
                    qs.append(k, params[k]);
                }
            });

            const response = await fetch(`${API_CONFIG.baseUrl}/SearchUser?${qs.toString()}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'Authorization': `Bearer ${userToken}`
                }
            });

            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();
            console.log('[POS] SearchUser (GET) response:', data, '| params:', params);

            let list = [];
            if (data && Array.isArray(data.result)) list = data.result;
            else if (data && Array.isArray(data.data)) list = data.data;
            else if (Array.isArray(data)) list = data;

            return list.map(u => {
                const name = u.name || u.Name || u.fullName || u.FullName || u.customerName || u.CustomerName || 'Unknown';
                const phone = u.PhoneNumber || u.phoneNumber || u.phone || u.Phone || u.telephone || u.Telephone || '';
                const points = parseInt(u.points || u.Points || u.loyaltyPoints || 0) || 0;
                const uid = u.uid || u.id || u.userId || u.UserId || u.Id || `u_${Date.now()}_${Math.random().toString(36).slice(2,7)}`;
                const initials = name.split(' ').filter(Boolean).map(n => n[0]).join('').toUpperCase().slice(0, 2) || 'CU';

                return {
                    id: `api_client_${uid}`,
                    uid: uid,
                    name,
                    phone: phone || 'No phone',
                    points,
                    avatar: initials,
                    raw: u
                };
            });
        } catch (err) {
            console.warn('[POS] SearchUser (GET) failed, using local fallback:', err);
            return null;
        }
    }

    function classifyClientQuery(query) {
        const phoneRegex = /^[+\d\s\-()]+$/;
        if (query && phoneRegex.test(query)) {
            return { isPhone: true, name: 'none', phoneNumber: query, searchOption: 'true' };
        }
        return { isPhone: false, name: query || 'none', phoneNumber: 'none', searchOption: 'true' };
    }

    function buildClientSearchParams(query) {
        const c = classifyClientQuery(query);
        return {
            phoneNumber: c.phoneNumber,
            name: c.name,
            limitData: 10,
            platform: "4000",
            searchOption: c.searchOption,
            isAdmin: "false",
            isStatus: "offNotPick",
            sortOrder: "ASC"
        };
    }

    function renderClientDropdown(users, { isPrefetch = false, query = '' } = {}) {
        const dropdown = document.getElementById('clientSearchResults');
        if (!dropdown) return;

        if (!users || users.length === 0) {
            dropdown.innerHTML = `<div class="p-3 text-center text-muted small"><i class="bi bi-person-x me-1"></i> No clients found.</div>`;
            dropdown.style.display = 'block';
            return;
        }

        users.forEach(u => {
            if (!MOCK_CLIENTS.some(c => c.id === u.id || (u.phone !== 'No phone' && c.phone === u.phone))) {
                MOCK_CLIENTS.push(u);
            }
        });

        dropdown.innerHTML = users.map(c => `
            <div class="autocomplete-item" onclick="selectClient('${c.id}')">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:28px; height:28px; font-size:0.75rem;">${c.avatar}</div>
                    <div>
                        <div class="fw-semibold text-dark small">${c.name}</div>
                        <div class="extra-small text-muted">${c.phone}</div>
                    </div>
                </div>
                <span class="badge bg-light text-dark border extra-small">${c.points} pts</span>
            </div>
        `).join('');

        if (isPrefetch) {
            const hint = document.createElement('div');
            hint.className = 'p-2 text-center text-muted extra-small border-top';
            hint.style.fontSize = '0.7rem';
            hint.innerHTML = `<i class="bi bi-lightning-charge me-1"></i>Quick picks — type to refine`;
            dropdown.appendChild(hint);
        }

        dropdown.style.display = 'block';
    }

    async function prefetchClientsOnHover() {
        if (clientPrefetchDone) return;
        clientPrefetchDone = true;

        const dropdown = document.getElementById('clientSearchResults');
        dropdown.innerHTML = `<div class="p-3 text-center text-muted small"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Loading clients...</div>`;
        dropdown.style.display = 'block';

        const params = {
            phoneNumber: "none",
            name: "map",
            limitData: 10,
            platform: "4000",
            searchOption: "false",
            isAdmin: "false",
            isStatus: "offNotPick",
            sortOrder: "ASC"
        };

        const users = await searchUsersApi(params);
        if (users && users.length > 0) {
            renderClientDropdown(users, { isPrefetch: true });
        } else {
            renderClientDropdown(MOCK_CLIENTS.filter(c => c.id !== 'c1'), { isPrefetch: true });
        }
    }

    async function runClientSearch(query) {
        const dropdown = document.getElementById('clientSearchResults');
        dropdown.innerHTML = `<div class="p-3 text-center text-muted small"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Searching clients...</div>`;
        dropdown.style.display = 'block';

        const params = buildClientSearchParams(query);
        const users = await searchUsersApi(params);

        if (users && users.length > 0) {
            renderClientDropdown(users, { query });
        } else {
            const q = query.toLowerCase();
            const filtered = MOCK_CLIENTS.filter(c =>
                c.name.toLowerCase().includes(q) || c.phone.includes(query)
            );
            renderClientDropdown(filtered, { query });
        }
    }

    /* ============================================================
       POST /placeOrder/  (unchanged)
       ============================================================ */
    function currentOrderIdFromCart() {
        const store = cartStore[activePriceListKey];
        const cart = store.cart || [];
        if (store.apiUid) return store.apiUid;
        if (cart.length === 0) return 'none';
        const first = cart[0];
        return (
            first.orderId ||
            first.order_id ||
            first.orderUid ||
            (first.rawOrderItem && (first.rawOrderItem.orderUid || first.rawOrderItem.uid)) ||
            'none'
        );
    }

    async function placeOrderApi({ productCode, reqQty, comment = 'ok' }) {
        if (placeOrderBusy) {
            showToast('Order is being placed, please wait…', 'warning');
            return false;
        }
        if (!productCode) {
            showToast('Missing product code — cannot place order.', 'warning');
            return false;
        }

        placeOrderBusy = true;

        try {
            const userToken = getAuthToken();
            const meta = PRICE_LISTS[activePriceListKey] || PRICE_LISTS['LOCAL_USD'];
            const store = cartStore[activePriceListKey];

            const uidClient = buildUidClient(store);
            const apiCurrency = meta.id;

            const isDefaultCurrency = (meta.id === (window.DEFAULT_CURRENCY || 'LOCAL_USD'));
            const orderType = isDefaultCurrency ? 'default' : 'export';

            const payload = {
                productCode: productCode,
                uidClient: uidClient,
                orderType: orderType,
                req_qty: parseInt(reqQty) || 1,
                currency: apiCurrency,
                ref: 'test',
                comment: comment,
                statusForm: 'none',
                orderIdFromEdit: currentOrderIdFromCart(),
                app_vers: window.APP_VERSION || 'unknown'
            };

            console.log('[POS] placeOrder payload:', payload);

            const response = await fetch(`${API_CONFIG.baseUrl}/placeOrder/`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'Authorization': `Bearer ${userToken}`
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();
            console.log('[POS] placeOrder response:', data);

            const ok =
                (data && (data.status === true || data.success === true)) ||
                (data && data.error === undefined && data.message === undefined) ||
                (data && typeof data === 'object');

            if (!ok) {
                showToast(`placeOrder failed: ${data && (data.message || data.error) || 'Unknown error'}`, 'warning');
                return false;
            }

            showToast(`Placed order: ${payload.req_qty}x ${productCode}`);

            await fetchCartFromApi();
            return true;

        } catch (err) {
            console.error('[POS] placeOrder failed:', err);
            showToast(`placeOrder failed: ${err.message || err}`, 'warning');
            return false;
        } finally {
            placeOrderBusy = false;
        }
    }

    /* ============================================================
       GET /EditTOrder/  — change line qty
       ============================================================ */
    async function editTOrderApi({ productCode, reqQty, currentQty, uid, uidClient, currency }) {
        try {
            const userToken = getAuthToken();

            const params = new URLSearchParams({
                productCode: productCode,
                req_qty: String(reqQty),
                currentQtyEdit: String(currentQty),
                uid: uid,
                uidClient: uidClient,
                currency: currency,
                statusForm: 'editOrder'
            });

            const url = `${API_CONFIG.baseUrl}/EditTOrder/?${params.toString()}`;
            console.log('[POS] EditTOrder GET:', url);

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'Authorization': `Bearer ${userToken}`
                }
            });

            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();
            console.log('[POS] EditTOrder response:', data);

            const ok =
                (data && (data.status === true || data.success === true)) ||
                (data && data.error === undefined && data.message === undefined) ||
                (data && typeof data === 'object');
            return !!ok;

        } catch (err) {
            console.error('[POS] EditTOrder failed:', err);
            showToast(`EditTOrder failed: ${err.message || err}`, 'warning');
            return false;
        }
    }

    /* ============================================================
       GET /deleteTSingleOrder/  — remove a single line
       ============================================================ */
    async function deleteSingleOrderApi({ productCode, uid }) {
        try {
            const userToken = getAuthToken();

            const params = new URLSearchParams({
                productCode: productCode,
                uid: uid
            });

            const url = `${API_CONFIG.baseUrl}/deleteTSingleOrder/?${params.toString()}`;
            console.log('[POS] deleteTSingleOrder GET:', url);

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'Authorization': `Bearer ${userToken}`
                }
            });

            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();
            console.log('[POS] deleteTSingleOrder response:', data);

            const ok =
                (data && (data.status === true || data.success === true)) ||
                (data && data.error === undefined && data.message === undefined) ||
                (data && typeof data === 'object');
            return !!ok;

        } catch (err) {
            console.error('[POS] deleteTSingleOrder failed:', err);
            showToast(`deleteTSingleOrder failed: ${err.message || err}`, 'warning');
            return false;
        }
    }

    /* ============================================================
       GET /deleteTOrder/  — clear entire order
       ============================================================ */
    async function deleteOrderApi({ uid }) {
        try {
            const userToken = getAuthToken();

            const params = new URLSearchParams({ uid: uid });

            const url = `${API_CONFIG.baseUrl}/deleteTOrder/?${params.toString()}`;
            console.log('[POS] deleteTOrder GET:', url);

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'Authorization': `Bearer ${userToken}`
                }
            });

            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();
            console.log('[POS] deleteTOrder response:', data);

            const ok =
                (data && (data.status === true || data.success === true)) ||
                (data && data.error === undefined && data.message === undefined) ||
                (data && typeof data === 'object');
            return !!ok;

        } catch (err) {
            console.error('[POS] deleteTOrder failed:', err);
            showToast(`deleteTOrder failed: ${err.message || err}`, 'warning');
            return false;
        }
    }

    /* ============================================================
       API SHOPPING CART LOADER — now stores per-line backend uid
       ============================================================ */
    async function fetchCartFromApi() {
        try {
            const userToken = getAuthToken();
            const currentPriceListId = PRICE_LISTS[activePriceListKey]?.id || window.DEFAULT_CURRENCY || 'LOCAL_USD';

            const params = new URLSearchParams({ "currency": currentPriceListId });

            const response = await fetch(`${API_CONFIG.baseUrl}/ViewUserTempOrder?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'Authorization': `Bearer ${userToken}`
                }
            });

            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();

            if (data && data.status && Array.isArray(data.result)) {
                applyBackendOrderAndClient(data);

                const apiCartItems = data.result.map(item => {
                    const unitPrice = parseFloat(item.price) || 0;
                    const qty = parseInt(item.totalQty) || parseInt(item.pcs) || 1;
                    const pCode = item.productCode || item.uid || 'PRD-API';
                    const pName = item.productName || item.name || 'API Product';
                    const pImg = (item.img_url && item.img_url !== 'none') ? item.img_url : 'https://placehold.co/40x40/f1f5f9/64748b?text=Item';

                    /* Per-line backend identifiers */
                    const lineUid = item.uid
                        || item.orderUid
                        || item.order_id
                        || item.OrderUID
                        || 'none';
                    const lineOrderUid = item.orderUid
                        || item.order_id
                        || item.OrderUID
                        || lineUid;

                    let product = MOCK_PRODUCTS.find(p => p.code === pCode || p.id === `api_${lineUid}`);

                    if (!product) {
                        product = {
                            id: `api_${lineUid}`,
                            code: pCode,
                            name: pName,
                            category: 'General',
                            stock: 9999,
                            img: pImg,
                            prices: {
                                'LOCAL_USD': unitPrice,
                                'EXPORT_USD': unitPrice,
                                'EXPORT_EUR': unitPrice,
                                'WHOLESALE_RWF': unitPrice
                            }
                        };
                        MOCK_PRODUCTS.push(product);
                    } else {
                        normalizeProductPrices(product, unitPrice, activePriceListKey);
                    }

                    return {
                        product: product,
                        qty: qty,
                        rawOrderItem: {
                            uid: lineUid,
                            orderUid: lineOrderUid,
                            productCode: pCode,
                            currentQty: qty
                        }
                    };
                });

                cartStore[activePriceListKey].cart = apiCartItems;

                /* If the backend provided a top-level order uid, remember it for clearCart() */
                if (!cartStore[activePriceListKey].apiUid && apiCartItems.length > 0) {
                    cartStore[activePriceListKey].apiUid =
                        apiCartItems[0].rawOrderItem.orderUid || apiCartItems[0].rawOrderItem.uid || 'none';
                }

                renderPriceListBadges();
                renderCart();
                return true;
            }
        } catch (err) {
            console.warn('Backend API cart loading skipped/failed. Keeping local cart state.', err);
        }
        return false;
    }

    /* ============================================================
       Product search (unchanged)
       ============================================================ */
    async function fetchProductsFromApi(query) {
        try {
            const userToken = getAuthToken();

            const currentPriceListId = PRICE_LISTS[activePriceListKey]?.id || window.DEFAULT_CURRENCY || 'LOCAL_USD';
            const isDefaultCurrency = (currentPriceListId === (window.DEFAULT_CURRENCY || 'LOCAL_USD'));
            const searchOption = isDefaultCurrency ? 'search' : 'currencysearch';

            const params = new URLSearchParams({
                "productCode": query,
                "productName": "none",
                "productQr": "none",
                "LimitStart": "1",
                "LimitEnd": "10",
                "isProductAction": searchOption,
                "currency": currentPriceListId,
                "withTotal": "true"
            });

            const response = await fetch(`${API_CONFIG.baseUrl}/Products?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'Authorization': `Bearer ${userToken}`
                }
            });

            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();

            if (data && data.status && Array.isArray(data.result)) {
                return data.result.map(item => {
                    const basePrice = parseFloat(item.price) || 0;
                    return {
                        id: `api_${item.id}`,
                        code: item.productCode || `PRD-${item.id}`,
                        name: item.ProductName || item.productCode || 'Unnamed Product',
                        category: (item.catName && item.catName !== 'none') ? item.catName : 'General',
                        stock: parseInt(item.qty - item.qty_sold) || 0,
                        img: (item.img_url && item.img_url !== 'none') ? item.img_url : 'https://placehold.co/40x40/f1f5f9/64748b?text=Item',
                        prices: {
                            'LOCAL_USD': basePrice,
                            'EXPORT_USD': basePrice,
                            'EXPORT_EUR': basePrice,
                            'WHOLESALE_RWF': basePrice,
                            [currentPriceListId]: basePrice
                        }
                    };
                });
            }
        } catch (err) {
            console.warn('API Search unavailable or failed, falling back to local database search.', err);
        }
        return null;
    }

    async function renderProductSearchResults(query) {
        const dropdown = document.getElementById('productSearchResults');
        highlightedSearchIndex = -1;

        dropdown.innerHTML = `
            <div class="p-3 text-center text-muted small">
                <span class="spinner-border spinner-border-sm me-2" role="status"></span> Searching products...
            </div>`;
        dropdown.style.display = 'block';

        let apiProducts = await fetchProductsFromApi(query);
        let productsToDisplay = [];

        if (apiProducts && apiProducts.length > 0) {
            productsToDisplay = apiProducts;
        } else {
            productsToDisplay = MOCK_PRODUCTS.filter(p =>
                (selectedCategory === 'ALL' || p.category === selectedCategory) &&
                (p.name.toLowerCase().includes(query) || p.code.toLowerCase().includes(query))
            );
        }

        if (productsToDisplay.length === 0) {
            dropdown.innerHTML = `
                <div class="p-3 text-center text-muted small">
                    <i class="bi bi-search me-1"></i> No matching products found.
                </div>`;
        } else {
            dropdown.innerHTML = productsToDisplay.map((p, idx) => {
                const price = getUnitPrice(p);

                if (!MOCK_PRODUCTS.some(existing => existing.id === p.id)) {
                    MOCK_PRODUCTS.push(p);
                }

                return `
                    <div class="autocomplete-item align-items-center ${idx === 0 ? 'active' : ''}" onclick="event.stopPropagation()">
                        <div class="d-flex align-items-center gap-3 flex-grow-1 me-2" onclick="selectProductFromSearch('${p.id}')">
                            <img src="${p.img}" class="product-img-thumb" alt="${p.name}" onerror="this.src='https://placehold.co/40x40/f1f5f9/64748b?text=Item'">
                            <div>
                                <div class="fw-semibold text-dark small">${p.name}</div>
                                <div class="extra-small text-muted">${p.code} • ${p.category}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-end me-1">
                                <div class="fw-bold text-dark">${formatCurrency(price)}</div>
                                <span class="badge ${p.stock > 10 ? 'bg-light text-dark border' : 'bg-danger-subtle text-danger'} extra-small">
                                    ${p.stock} in stock
                                </span>
                            </div>
                            <div class="d-inline-flex align-items-center gap-1 bg-light p-1 rounded border">
                                <button type="button" class="qty-btn" onclick="adjustSearchQty('${p.id}', -1, event)">-</button>
                                <input type="number" id="search_qty_${p.id}" class="qty-input bg-white" value="1" min="1" onclick="event.stopPropagation()">
                                <button type="button" class="qty-btn" onclick="adjustSearchQty('${p.id}', 1, event)">+</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1 py-1 px-2" onclick="addWithQtyFromSearch('${p.id}', event)">
                                <i class="bi bi-cart-plus fs-6"></i> Add
                            </button>
                        </div>
                    </div>
                `;
            }).join('');
            if (productsToDisplay.length > 0) highlightedSearchIndex = 0;
        }

        dropdown.style.display = 'block';
    }

    /* ============================================================
       Client selection
       ============================================================ */
    function selectClient(clientId) {
        const client = MOCK_CLIENTS.find(c => c.id === clientId);
        if (client) {
            cartStore[activePriceListKey].selectedClient = client;
            updateSelectedClientUI();
            showToast(`Client assigned to current order: ${client.name}`);
        }
        document.getElementById('clientSearchInput').value = '';
        document.getElementById('clientSearchResults').style.display = 'none';
    }

    function updateSelectedClientUI() {
        const client = cartStore[activePriceListKey].selectedClient || MOCK_CLIENTS[0];
        document.getElementById('clientAvatar').innerText = client.avatar;
        document.getElementById('clientName').innerText = client.name;
        document.getElementById('clientPhone').innerText = client.phone;
        document.getElementById('clientPointsPill').innerHTML = `<i class="bi bi-star-fill me-1"></i>${client.points} pts`;
        document.getElementById('modalCustomerAccountName').innerText = client.name;
    }

    /* ============================================================
       Add to cart (local-only path — used by barcode scan)
       ============================================================ */
    function addToCart(productId, qtyToAdd = 1) {
        const product = MOCK_PRODUCTS.find(p => p.id === productId);
        if (!product) return;

        const unitPrice = getUnitPrice(product);
        if (unitPrice <= 0) {
            showToast(`Cannot add "${product.name}" because its price is zero.`, "warning");
            return;
        }

        const currentCart = cartStore[activePriceListKey].cart;
        const existingItem = currentCart.find(item => item.product.id === productId);
        const currentQtyInCart = existingItem ? existingItem.qty : 0;
        const amount = Math.max(1, parseInt(qtyToAdd) || 1);

        if (currentQtyInCart + amount > product.stock) {
            showToast(`Cannot add ${amount}x. Maximum available stock for "${product.name}" is ${product.stock} (In Cart: ${currentQtyInCart}).`, "warning");
            return;
        }

        const existingIndex = currentCart.findIndex(item => item.product.id === productId);
        if (existingIndex > -1) {
            const itemToMove = currentCart.splice(existingIndex, 1)[0];
            itemToMove.qty += amount;
            currentCart.unshift(itemToMove);
        } else {
            currentCart.unshift({ product: product, qty: amount });
        }

        renderPriceListBadges();
        renderCart(productId);
        showToast(`Added ${amount}x ${product.name} to ${PRICE_LISTS[activePriceListKey].name} cart.`);
    }

    function adjustSearchQty(productId, delta, event) {
        if (event) event.stopPropagation();
        const input = document.getElementById(`search_qty_${productId}`);
        const product = MOCK_PRODUCTS.find(p => p.id === productId);
        if (input && product) {
            let currentVal = parseInt(input.value) || 1;
            currentVal = currentVal + delta;
            if (currentVal < 1) currentVal = 1;
            if (currentVal > product.stock) {
                currentVal = product.stock > 0 ? product.stock : 1;
                showToast(`Cannot exceed stock limit of ${product.stock} items for "${product.name}".`, "warning");
            }
            input.value = currentVal;
        }
    }

    /* ============================================================
       ✅ IMPROVED: addWithQtyFromSearch — duplicate-product guard
       ============================================================ */
    async function addWithQtyFromSearch(productId, event) {
        if (event) event.stopPropagation();

        const input = document.getElementById(`search_qty_${productId}`);
        const qty = input ? parseInt(input.value) || 1 : 1;

        const product = MOCK_PRODUCTS.find(p => p.id === productId);
        if (!product) {
            showToast('Product not found locally.', 'warning');
            return;
        }

        /* ✅ Guard: product already in the active cart */
        const currentCart = cartStore[activePriceListKey].cart || [];
        const duplicate = currentCart.find(item =>
            item.product.code === product.code ||
            item.product.id === product.id ||
            (item.rawOrderItem && item.rawOrderItem.productCode === product.code)
        );

        if (duplicate) {
            showToast(
                `"${product.name}" already exists in the cart (qty ${duplicate.qty}). Use + / - to adjust the quantity instead of adding again.`,
                'warning'
            );
            return;
        }

        const ok = await placeOrderApi({
            productCode: product.code,
            reqQty: qty,
            comment: 'ok'
        });

        if (ok) {
            document.getElementById('productSearchResults').style.display = 'none';
            document.getElementById('productSearchInput').value = '';
        }
    }

    /* ============================================================
       ✅ IMPROVED: updateQty — calls GET /EditTOrder/ with debounce
       ============================================================ */
    function updateQty(productId, delta) {
        const currentCart = cartStore[activePriceListKey].cart;
        const item = currentCart.find(i => i.product.id === productId);
        if (!item) return;

        const targetQty = item.qty + delta;
        if (targetQty > item.product.stock) {
            showToast(`Stock limit reached! Only ${item.product.stock} items in stock for "${item.product.name}".`, "warning");
            return;
        }
        if (targetQty <= 0) {
            removeFromCart(productId);
            return;
        }

        const previousQty = item.qty;
        item.qty = targetQty;
        renderCart(productId);

        scheduleEditTOrder(productId, targetQty, previousQty);
    }

    function setQty(productId, value) {
        let qty = parseInt(value);
        const currentCart = cartStore[activePriceListKey].cart;
        const item = currentCart.find(i => i.product.id === productId);
        if (!item) return;

        if (isNaN(qty) || qty <= 0) {
            removeFromCart(productId);
            return;
        }
        if (qty > item.product.stock) {
            qty = item.product.stock;
            showToast(`Adjusted to maximum stock limit of ${item.product.stock} for "${item.product.name}".`, "warning");
        }

        const previousQty = item.qty;
        item.qty = qty;
        renderCart(productId);

        scheduleEditTOrder(productId, qty, previousQty);
    }

    function scheduleEditTOrder(productId, newQty, previousQty) {
        const item = cartStore[activePriceListKey].cart.find(i => i.product.id === productId);
        if (!item || !item.rawOrderItem) {
            /* Line was created locally — nothing to sync to backend */
            return;
        }

        if (qtyEditTimers[productId]) clearTimeout(qtyEditTimers[productId]);

        qtyEditTimers[productId] = setTimeout(async () => {
            delete qtyEditTimers[productId];

            const productCode = item.rawOrderItem.productCode || item.product.code;
            const lineUid = item.rawOrderItem.uid;
            if (!productCode || !lineUid || lineUid === 'none') {
                console.warn('[POS] EditTOrder skipped — missing productCode or line uid', { productCode, lineUid });
                return;
            }

            const meta = PRICE_LISTS[activePriceListKey];
            const store = cartStore[activePriceListKey];

            const ok = await editTOrderApi({
                productCode: productCode,
                reqQty: newQty,
                currentQty: previousQty,
                uid: lineUid,
                uidClient: buildUidClient(store),
                currency: meta.id
            });

            if (!ok) {
                /* Revert local qty on failure */
                item.qty = previousQty;
                renderCart(productId);
                showToast('Failed to update quantity on backend. Reverted.', 'warning');
                return;
            }

            /* Reload the cart from backend (per requirement) */
            await fetchCartFromApi();
        }, 350);
    }

    /* ============================================================
       ✅ IMPROVED: removeFromCart — GET /deleteTSingleOrder/
       ============================================================ */
    async function removeFromCart(productId) {
        const currentCart = cartStore[activePriceListKey].cart;
        const index = currentCart.findIndex(i => i.product.id === productId);
        if (index === -1) return;

        const removed = currentCart[index];
        const productCode = (removed.rawOrderItem && removed.rawOrderItem.productCode) || removed.product.code;
        const lineUid = removed.rawOrderItem && removed.rawOrderItem.uid;

        /* No backend line uid → just drop locally */
        if (!lineUid || lineUid === 'none') {
            currentCart.splice(index, 1);
            renderPriceListBadges();
            renderCart();
            showToast(`Removed "${removed.product.name}" from cart.`);
            return;
        }

        /* Optimistic removal */
        currentCart.splice(index, 1);
        renderPriceListBadges();
        renderCart();

        const ok = await deleteSingleOrderApi({
            productCode: productCode,
            uid: lineUid
        });

        if (!ok) {
            /* Restore on failure */
            currentCart.splice(index, 0, removed);
            renderPriceListBadges();
            renderCart();
            showToast('Failed to remove item on backend. Restored.', 'warning');
            return;
        }

        showToast(`Removed "${removed.product.name}" from cart.`);

        /* Per requirement: reload cart after this GET */
        await fetchCartFromApi();
    }

    /* ============================================================
       ✅ IMPROVED: clearCart — GET /deleteTOrder/ (no refetch)
       ============================================================ */
    async function clearCart() {
        const store = cartStore[activePriceListKey];
        const cart = store.cart || [];
        const orderUid = store.apiUid
            || (cart[0] && cart[0].rawOrderItem && cart[0].rawOrderItem.orderUid)
            || 'none';

        /* No backend order uid → just clear locally */
        if (!orderUid || orderUid === 'none') {
            store.cart = [];
            renderPriceListBadges();
            renderCart();
            showToast(`Cleared ${PRICE_LISTS[activePriceListKey].name} cart.`);
            return;
        }

        const ok = await deleteOrderApi({ uid: orderUid });

        if (!ok) {
            showToast('Failed to clear order on backend. Cart kept.', 'warning');
            return;
        }

        /* ✅ Per requirement: do NOT call fetchCartFromApi() after clearCart */
        store.cart = [];
        store.apiUid = undefined;
        renderPriceListBadges();
        renderCart();
        showToast(`Cleared ${PRICE_LISTS[activePriceListKey].name} cart.`);
    }

    function selectProductFromSearch(productId) {
        addWithQtyFromSearch(productId, null);
        document.getElementById('productSearchResults').style.display = 'none';
        document.getElementById('productSearchInput').value = '';
    }

    /* ============================================================
       Price list switching
       ============================================================ */
    async function switchPriceList(targetKey) {
        if (!PRICE_LISTS[targetKey]) return;

        activePriceListKey = targetKey;
        currencyLoad = PRICE_LISTS[activePriceListKey];

        const meta = PRICE_LISTS[activePriceListKey];
        document.getElementById('activeCurrencyBadge').innerText = `${meta.currency} (${meta.symbol.trim()})`;

        const store = cartStore[activePriceListKey];
        document.getElementById('discountInput').value = store.discountVal || 0;
        document.getElementById('discountTypeSelect').value = store.discountType || 'PERCENT';
        document.getElementById('taxToggle').checked = store.taxEnabled !== false;
        document.getElementById('clientPaidInput').value = store.amountPaid || '';

        renderCashPresets();
        updateSelectedClientUI();

        const loadedFromApi = await fetchCartFromApi();
        if (!loadedFromApi) {
            renderCart();
        }
        showToast(`Switched to ${meta.name} (${meta.currency}) mode.`);
    }

    function renderPriceListBadges() {
        const select = document.getElementById('priceListSelector');
        if (!select) return;
        Array.from(select.options).forEach(opt => {
            const key = opt.value;
            const count = cartStore[key].cart.reduce((sum, item) => sum + item.qty, 0);
            const baseName = PRICE_LISTS[key].name + ' (' + PRICE_LISTS[key].currency + ')';
            opt.text = count > 0 ? `${baseName} • ${count} items` : baseName;
        });
    }

      function renderCashPresets() {
        const container = document.getElementById('cashPresetsContainer');
        if (!container) return;

        const meta = PRICE_LISTS[activePriceListKey];
        let presets = [10, 20, 50, 100];
        if (meta.currency === 'RWF') {
            presets = [1000, 5000, 10000, 20000];
        } else if (meta.currency === 'EUR') {
            presets = [5, 10, 20, 50];
        }

        container.innerHTML = presets.map(val => `
            <button type="button" class="btn btn-sm btn-outline-secondary flex-grow-1" onclick="quickPayPreset(${val})">
                +${meta.symbol}${val}
            </button>
        `).join('') + `
            <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1 fw-semibold" onclick="payExactAmount()" title="Set paid amount to the current grand total">
                <i class="bi bi-bullseye me-1"></i>Exact
            </button>
        `;
    }

    /* ✅ NEW: set the paid amount to the current grand total (overwrites, does not add) */
    function payExactAmount() {
        const meta = PRICE_LISTS[activePriceListKey] || PRICE_LISTS['LOCAL_USD'];
        const store = cartStore[activePriceListKey];
        const cart = store.cart || [];

        if (cart.length === 0) {
            showToast('Cart is empty — nothing to pay.', 'warning');
            return;
        }

        /* Recompute grand total the same way calculateFinancials() does,
           so Exact always matches what the summary displays. */
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += getUnitPrice(item.product) * item.qty;
        });

        const discountVal = parseFloat(document.getElementById('discountInput').value) || 0;
        const discountType = document.getElementById('discountTypeSelect').value;

        let discountAmount = 0;
        if (discountType === 'PERCENT') {
            discountAmount = (subtotal * Math.min(100, Math.max(0, discountVal))) / 100;
        } else {
            discountAmount = Math.min(subtotal, Math.max(0, discountVal));
        }

        const afterDiscount = Math.max(0, subtotal - discountAmount);
        const grandTotal = Math.max(0, afterDiscount); // tax disabled in this build

        const input = document.getElementById('clientPaidInput');
        input.value = grandTotal.toFixed(meta.decimal);
        store.amountPaid = input.value;

        calculateFinancials();
    }

    function quickPayPreset(amount) {
        const input = document.getElementById('clientPaidInput');
        const current = parseFloat(input.value) || 0;
        input.value = (current + amount).toFixed(PRICE_LISTS[activePriceListKey].decimal);
        cartStore[activePriceListKey].amountPaid = input.value;
        calculateFinancials();
    }

    function formatCurrency(amount) {
        const meta = PRICE_LISTS[activePriceListKey] || PRICE_LISTS['LOCAL_USD'];
        const numeric = parseFloat(amount) || 0;
        return `${meta.symbol}${numeric.toLocaleString(undefined, { minimumFractionDigits: meta.decimal, maximumFractionDigits: meta.decimal })}`;
    }

    /* ============================================================
       Financials (unchanged)
       ============================================================ */
    function calculateFinancials() {
        const currentCart = cartStore[activePriceListKey].cart;
        let subtotal = 0;

        currentCart.forEach(item => {
            const unitPrice = getUnitPrice(item.product);
            subtotal += unitPrice * item.qty;
        });

        const discountVal = parseFloat(document.getElementById('discountInput').value) || 0;
        const discountType = document.getElementById('discountTypeSelect').value;
        cartStore[activePriceListKey].discountVal = discountVal;
        cartStore[activePriceListKey].discountType = discountType;

        let discountAmount = 0;
        if (discountType === 'PERCENT') {
            discountAmount = (subtotal * Math.min(100, Math.max(0, discountVal))) / 100;
        } else {
            discountAmount = Math.min(subtotal, Math.max(0, discountVal));
        }

        const afterDiscount = Math.max(0, subtotal - discountAmount);
        const taxAmount = 0;
        const grandTotal = Math.max(0, afterDiscount + taxAmount);

        const paidInput = document.getElementById('clientPaidInput');
        const amountPaid = parseFloat(paidInput.value) || 0;
        cartStore[activePriceListKey].amountPaid = paidInput.value;

        document.getElementById('summarySubtotal').innerText = formatCurrency(subtotal);
        document.getElementById('summaryTax').innerText = formatCurrency(taxAmount);
        document.getElementById('summaryGrandTotal').innerText = formatCurrency(grandTotal);

        const totalItemCount = currentCart.reduce((sum, item) => sum + item.qty, 0);
        document.getElementById('cartItemCountBadge').innerText = `${totalItemCount} items`;
        document.getElementById('summaryTotalItems').innerText = `${totalItemCount} items`;

        const balanceAlert = document.getElementById('balanceStatusAlert');
        const statusTitle = document.getElementById('balanceStatusTitle');
        const statusAmount = document.getElementById('balanceStatusAmount');
        const payBtn = document.getElementById('payButton');

        if (grandTotal === 0 || totalItemCount === 0) {
            balanceAlert.className = 'p-3 rounded border text-center mb-3 bg-light text-muted';
            statusTitle.innerText = 'UNPAID / OUTSTANDING DEBT';
            statusAmount.innerText = formatCurrency(0);
            payBtn.disabled = true;
        } else {
            payBtn.disabled = false;
            const diff = amountPaid - grandTotal;

            if (amountPaid === 0) {
                balanceAlert.className = 'p-3 rounded border text-center mb-3 bg-danger-subtle text-danger border-danger-subtle';
                statusTitle.innerText = 'UNPAID / OUTSTANDING DEBT';
                statusAmount.innerText = `Full Debt: ${formatCurrency(grandTotal)}`;
            } else if (diff < 0) {
                balanceAlert.className = 'p-3 rounded border text-center mb-3 bg-warning-subtle text-warning-emphasis border-warning-subtle';
                statusTitle.innerText = 'CUSTOMER DEBT / BALANCE DUE';
                statusAmount.innerText = `Remaining: ${formatCurrency(Math.abs(diff))}`;
            } else if (diff === 0) {
                balanceAlert.className = 'p-3 rounded border text-center mb-3 bg-success-subtle text-success border-success-subtle';
                statusTitle.innerText = 'FULLY PAID';
                statusAmount.innerText = 'No balance remaining';
            } else {
                balanceAlert.className = 'p-3 rounded border text-center mb-3 bg-info-subtle text-info-emphasis border-info-subtle';
                statusTitle.innerText = 'CHANGE DUE TO CUSTOMER';
                statusAmount.innerText = `Return: ${formatCurrency(diff)}`;
            }
        }
    }

    /* ============================================================
       Render cart (unchanged selectors; image src now escaped)
       ============================================================ */
    function renderCart(editedProductId = null) {
        const tbody = document.getElementById('cartTableBody');
        const emptyState = document.getElementById('emptyCartState');
        const clearBtn = document.getElementById('clearCartBtn');
        const currentCart = cartStore[activePriceListKey].cart;

        if (currentCart.length === 0) {
            tbody.innerHTML = '';
            emptyState.style.display = 'block';
            clearBtn.style.display = 'none';
        } else {
            emptyState.style.display = 'none';
            clearBtn.style.display = 'inline-block';

            tbody.innerHTML = currentCart.map(item => {
                const p = item.product;
                const isEditing = p.id === editedProductId;
                const unitPrice = getUnitPrice(p);
                const lineTotal = unitPrice * item.qty;
                const safeImg = (p.img && p.img !== 'none') ? p.img : 'https://placehold.co/40x40/f1f5f9/64748b?text=Item';

                return `
                    <tr class="${isEditing ? 'cart-row-editing' : ''}">
                        <td data-label="Item Description">
                            <div class="d-flex align-items-center gap-2">
                                <img src="${safeImg}" class="product-img-thumb" alt="${p.name}" onerror="this.src='https://placehold.co/40x40/f1f5f9/64748b?text=Item'">
                                <div>
                                    <div class="fw-semibold text-dark small">${p.name}</div>
                                    <div class="extra-small text-muted">${p.code}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end fw-medium" data-label="Price">${formatCurrency(unitPrice)}</td>
                        <td class="text-center" data-label="Qty">
                            <div class="d-inline-flex align-items-center gap-1">
                                <button type="button" class="qty-btn" onclick="updateQty('${p.id}', -1)">-</button>
                                <input type="number" class="qty-input" value="${item.qty}" min="1" max="${p.stock}" onchange="setQty('${p.id}', this.value)">
                                <button type="button" class="qty-btn" onclick="updateQty('${p.id}', 1)">+</button>
                            </div>
                        </td>
                        <td class="text-end fw-bold text-dark" data-label="Total">${formatCurrency(lineTotal)}</td>
                        <td class="text-center" data-label="Action">
                            <button type="button" class="btn btn-link text-muted text-hover-danger p-0 border-0" onclick="removeFromCart('${p.id}')">
                                <i class="bi bi-trash fs-6"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        calculateFinancials();
    }

    /* ============================================================
       Payment modal + finish transaction (unchanged)
       ============================================================ */
    function openPaymentModal() {
        calculateFinancials();
        const currentCart = cartStore[activePriceListKey].cart;
        if (currentCart.length === 0) return;

        const subtotal = currentCart.reduce((sum, item) => {
            return sum + (getUnitPrice(item.product) * item.qty);
        }, 0);

        const discountVal = cartStore[activePriceListKey].discountVal || 0;
        const discountType = cartStore[activePriceListKey].discountType;
        const discountAmt = discountType === 'PERCENT' ? (subtotal * discountVal) / 100 : discountVal;
        const taxAmt = 0;
        const grandTotal = Math.max(0, subtotal - discountAmt + taxAmt);

        const amountPaid = parseFloat(cartStore[activePriceListKey].amountPaid) || 0;

        document.getElementById('modalGrandTotalDisplay').innerText = formatCurrency(grandTotal);
        document.getElementById('modalAmountPaidDisplay').innerText = formatCurrency(amountPaid);

        const statusBanner = document.getElementById('modalStatusBanner');
        const diff = amountPaid - grandTotal;

        if (amountPaid === 0) {
            statusBanner.className = 'p-2 rounded border text-center mb-3 bg-danger-subtle text-danger border-danger-subtle small fw-bold';
            statusBanner.innerText = `Full Debt Pending: ${formatCurrency(grandTotal)}`;
        } else if (diff < 0) {
            statusBanner.className = 'p-2 rounded border text-center mb-3 bg-warning-subtle text-warning-emphasis border-warning-subtle small fw-bold';
            statusBanner.innerText = `Partial Payment. Balance Due: ${formatCurrency(Math.abs(diff))}`;
        } else if (diff === 0) {
            statusBanner.className = 'p-2 rounded border text-center mb-3 bg-success-subtle text-success border-success-subtle small fw-bold';
            statusBanner.innerText = 'Payment Settled in Full';
        } else {
            statusBanner.className = 'p-2 rounded border text-center mb-3 bg-info-subtle text-info-emphasis border-info-subtle small fw-bold';
            statusBanner.innerText = `Change Due to Return: ${formatCurrency(diff)}`;
        }

        if (!bsPaymentModal) {
            bsPaymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
        }
        bsPaymentModal.show();
    }

      /* ============================================================
       Payment mode detection (reads the active tab in the modal)
       ============================================================ */
    function getActivePaymentMode() {
        const cashTab = document.getElementById('cash-tab');
        const cardTab = document.getElementById('card-tab');
        const accountTab = document.getElementById('account-tab');

        if (cashTab && cashTab.classList.contains('active')) return 'cash';
        if (cardTab && cardTab.classList.contains('active')) return 'card';
        if (accountTab && accountTab.classList.contains('active')) return 'account';
        return 'cash';
    }

    /* ============================================================
       POST /SubmitOrder  — only used for Cash payments
       ============================================================ */
    async function submitOrderApi({ amountPaid }) {
        try {
            const userToken = getAuthToken();

            const meta = PRICE_LISTS[activePriceListKey] || PRICE_LISTS['LOCAL_USD'];
            const store = cartStore[activePriceListKey];

            /* uidUser: prefer the logged-in user, fall back to client id */
            const uidUser = (user && (user.uid || user.id))
                || (store.selectedClient && (store.selectedClient.uid || store.selectedClient.id))
                || 'none';

            /* OrderId: the backend order uid captured from ViewUserTempOrder */
            const orderId = store.apiUid
                || (store.cart[0] && store.cart[0].rawOrderItem && store.cart[0].rawOrderItem.orderUid)
                || 'none';

            const payload = {
                uid: 'Nyota_1672353378',              // promotion ID (fixed, per your spec)
                uidUser: uidUser,                      // user linked to order
                OrderId: orderId,                      // order ID
                inputData: String(amountPaid),         // amount client paid
                currencySub: meta.id,                  // currency id (LOCAL_USD, etc.)
                reach: '1200',                         // reserved / placeholder
                gain: '350',                           // reserved / placeholder
                systemUid: 'PointSales1',              // reserved / placeholder
                promoData: 'none',                     // no promotion
                app_vers: window.APP_VERSION || 'unknown'
            };

            console.log('[POS] SubmitOrder payload:', payload);

            const response = await fetch(`${API_CONFIG.baseUrl}/SubmitOrder`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${userToken}`
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();
            console.log('[POS] SubmitOrder response:', data);

            const ok =
                (data && (data.status === true || data.success === true)) ||
                (data && data.error === undefined && data.message === undefined) ||
                (data && typeof data === 'object');

            if (!ok) {
                showToast(`SubmitOrder failed: ${data && (data.message || data.error) || 'Unknown error'}`, 'warning');
                return false;
            }

            return true;

        } catch (err) {
            console.error('[POS] SubmitOrder failed:', err);
            showToast(`SubmitOrder failed: ${err.message || err}`, 'warning');
            return false;
        }
    }

    /* ============================================================
       Finalize transaction — guarded against double submission
       - Cash tab   → POST /SubmitOrder (once)
       - Card/Account → local close only (unchanged behavior)
       ============================================================ */
    async function processFinalTransaction() {
        /* ✅ Guard #1: synchronous check-and-set — blocks every second click
           and every re-entrant call before any await runs. */
        if (submitOrderBusy) {
            showToast('Order is already being submitted, please wait…', 'warning');
            return;
        }
        submitOrderBusy = true;

        /* ✅ Guard #2: lock the confirm button visually */
        const confirmBtn = document.getElementById('confirmOrderBtn');
        const originalBtnHtml = confirmBtn ? confirmBtn.innerHTML : null;
        if (confirmBtn) {
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing…';
        }

        try {
            const mode = getActivePaymentMode();

            /* Only Cash triggers the backend submission */
            if (mode === 'cash') {
                const amountPaid = parseFloat(cartStore[activePriceListKey].amountPaid) || 0;

                const ok = await submitOrderApi({ amountPaid });

                if (!ok) {
                    /* Keep the modal open so the cashier can retry */
                    return;
                }
            }

            if (bsPaymentModal) bsPaymentModal.hide();
            showToast(`Order processed successfully! Receipt printed for ${cartStore[activePriceListKey].selectedClient.name}.`);
            resetSale(false);

        } finally {
            /* ✅ Always release the guard + button, even if submitOrderApi threw */
            submitOrderBusy = false;
            if (confirmBtn) {
                confirmBtn.disabled = false;
                if (originalBtnHtml !== null) confirmBtn.innerHTML = originalBtnHtml;
            }
        }
    }

    function saveDraftOrder() {
        showToast(`Saved draft order for ${PRICE_LISTS[activePriceListKey].name}.`);
    }

    function cancelSale() {
        resetSale(true);
        showToast('Draft cancelled and reset.');
    }

    function resetSale(confirmNeeded = false) {
        cartStore[activePriceListKey] = {
            cart: [],
            selectedClient: MOCK_CLIENTS[0],
            discountVal: 0,
            discountType: 'PERCENT',
            taxEnabled: true,
            amountPaid: ''
        };
        document.getElementById('discountInput').value = 0;
        document.getElementById('discountTypeSelect').value = 'PERCENT';
        document.getElementById('taxToggle').checked = true;
        document.getElementById('clientPaidInput').value = '';

        document.getElementById('orderRefDisplay').textContent = '#ORD-2026-8942';

        clientPrefetchDone = false;
        Object.keys(qtyEditTimers).forEach(k => { clearTimeout(qtyEditTimers[k]); delete qtyEditTimers[k]; });

        renderPriceListBadges();
        updateSelectedClientUI();
        renderCart();
    }

    function saveNewClient() {
        const nameInput = document.getElementById('newClientName');
        const phoneInput = document.getElementById('newClientPhone');

        if (!nameInput.value.trim()) {
            showToast('Please enter customer full name.', 'warning');
            return;
        }

        const initials = nameInput.value.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2) || 'CU';
        const newClient = {
            id: `c_${Date.now()}`,
            name: nameInput.value.trim(),
            phone: phoneInput.value.trim() || 'No phone',
            points: 0,
            avatar: initials
        };

        MOCK_CLIENTS.push(newClient);
        selectClient(newClient.id);

        nameInput.value = '';
        phoneInput.value = '';
        document.getElementById('newClientEmail').value = '';

        if (!bsAddClientModal) {
            bsAddClientModal = bootstrap.Modal.getInstance(document.getElementById('addClientModal'));
        }
        if (bsAddClientModal) bsAddClientModal.hide();

        showToast(`Registered and selected new client "${newClient.name}".`);
    }

    function focusSearch() {
        document.getElementById('productSearchInput').focus();
    }

    function showToast(message, type = 'info') {
        const toastEl = document.getElementById('actionToast');
        const toastMsg = document.getElementById('toastMessage');

        const icon = type === 'warning' ? 'bi-exclamation-triangle-fill text-warning' : 'bi-check-circle-fill text-success';
        toastMsg.innerHTML = `<i class="bi ${icon}"></i> ${message}`;

        const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
        toast.show();
    }

    function updateClock() {
        const clockEl = document.getElementById('currentTimeDisplay');
        if (clockEl) {
            const now = new Date();
            clockEl.innerText = now.toLocaleTimeString();
        }
    }

    window.onload = function () {
        updateClock();
        setInterval(updateClock, 1000);

        const priceSelect = document.getElementById('priceListSelector');
        if (priceSelect) {
            priceSelect.addEventListener('change', (e) => switchPriceList(e.target.value));
        }

        const searchInput = document.getElementById('productSearchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.trim().toLowerCase();
                if (!query) {
                    document.getElementById('productSearchResults').style.display = 'none';
                    return;
                }
                if (searchDebounceTimer) clearTimeout(searchDebounceTimer);
                searchDebounceTimer = setTimeout(() => {
                    renderProductSearchResults(query);
                }, 300);
            });

            searchInput.addEventListener('keydown', (e) => {
                const dropdown = document.getElementById('productSearchResults');
                const items = dropdown.querySelectorAll('.autocomplete-item');
                if (!items.length || dropdown.style.display === 'none') return;

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    highlightedSearchIndex = (highlightedSearchIndex + 1) % items.length;
                    items.forEach((it, idx) => it.classList.toggle('active', idx === highlightedSearchIndex));
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    highlightedSearchIndex = (highlightedSearchIndex - 1 + items.length) % items.length;
                    items.forEach((it, idx) => it.classList.toggle('active', idx === highlightedSearchIndex));
                } else if (e.key === 'Enter' && highlightedSearchIndex >= 0) {
                    e.preventDefault();
                    items[highlightedSearchIndex].click();
                } else if (e.key === 'Escape') {
                    dropdown.style.display = 'none';
                }
            });
        }

        const clientSearchInput = document.getElementById('clientSearchInput');
        if (clientSearchInput) {
            clientSearchInput.addEventListener('mouseover', () => {
                prefetchClientsOnHover();
            });
            clientSearchInput.addEventListener('focus', () => {
                prefetchClientsOnHover();
            });

            clientSearchInput.addEventListener('input', (e) => {
                const query = e.target.value.trim();
                const dropdown = document.getElementById('clientSearchResults');

                if (!query) {
                    clientPrefetchDone = false;
                    prefetchClientsOnHover();
                    return;
                }

                if (clientSearchDebounceTimer) clearTimeout(clientSearchDebounceTimer);
                clientSearchDebounceTimer = setTimeout(() => {
                    runClientSearch(query);
                }, 300);
            });
        }

        document.querySelectorAll('.category-chip').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-chip').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                selectedCategory = btn.dataset.category;
                const searchVal = document.getElementById('productSearchInput').value.trim().toLowerCase();
                if (searchVal) renderProductSearchResults(searchVal);
            });
        });

        document.getElementById('discountInput').addEventListener('input', calculateFinancials);
        document.getElementById('discountTypeSelect').addEventListener('change', calculateFinancials);
        document.getElementById('taxToggle').addEventListener('change', calculateFinancials);
        document.getElementById('clientPaidInput').addEventListener('input', calculateFinancials);

        document.getElementById('barcodeScanBtn').addEventListener('click', () => {
            const randomItem = MOCK_PRODUCTS[Math.floor(Math.random() * MOCK_PRODUCTS.length)];
            addWithQtyFromSearch(randomItem.id, null);
            showToast(`Scanned barcode: ${randomItem.code}`);
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === '/') {
                if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'SELECT') {
                    e.preventDefault();
                    focusSearch();
                }
            } else if (e.key === 'F2') {
                e.preventDefault();
                focusSearch();
            } else if (e.key === 'F4') {
                e.preventDefault();
                document.getElementById('clientSearchInput').focus();
            } else if (e.key === 'F9') {
                e.preventDefault();
                const payBtn = document.getElementById('payButton');
                if (!payBtn.disabled) openPaymentModal();
            }
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#productSearchInput') && !e.target.closest('#productSearchResults')) {
                document.getElementById('productSearchResults').style.display = 'none';
            }
            if (!e.target.closest('#clientSearchInput') && !e.target.closest('#clientSearchResults')) {
                document.getElementById('clientSearchResults').style.display = 'none';
            }
        });

        switchPriceList('LOCAL_USD');
    };
</script>
</body>
</html>
