// ===== FILE: js/api.js =====

// Fallback product catalog when API is unavailable
const FALLBACK_PRODUCTS = [];

/**
 * Fetch product list from the server using the stored token.
 * Adapts to various API response structures.
 * @returns {Promise<Array>} Array of product objects { id, name, category, price }
 */
async function fetchProducts() {
    try {
        const token = localStorage.getItem('Usertoken');
        if (!token) {
            console.warn('No token found in localStorage');
        }

        const response = await fetch('./api/getProducts', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        if (!response.ok) {
            console.error(`API responded with status ${response.status}`);
            throw new Error(`HTTP ${response.status}`);
        }

        const data = await response.json();
        console.log('API response sample:', data);

        let products = [];
        if (Array.isArray(data)) {
            products = data;
        } else if (data.data && Array.isArray(data.data)) {
            products = data.data;
        } else if (data.result && Array.isArray(data.result)) {
            products = data.result;
        } else {
            console.warn('Unexpected API response format', data);
            throw new Error('Invalid response structure');
        }

        // Map to the format expected by the UI
        return products.slice(0, 15).map(p => ({
            id: p.id?.toString() || p.uid?.toString() || '',
            name: (p.productName || p.title || p.name || '').substring(0, 30),
            category: p.category || p.productCategory || 'general',
            pcs: p.pcs,
            price: parseFloat(p.price || p.unitPrice || 0)
        }));

    } catch (error) {
        console.error('Fetch products error:', error);
        updateAPIStatus('offline');
        return [...FALLBACK_PRODUCTS];
    }
}

/**
 * Update the API status indicator in the UI.
 * @param {string} status - 'online' or 'offline'
 */
function updateAPIStatus(status) {
    const el = document.getElementById('apiStatus');
    if (el) {
        el.innerHTML = status === 'online'
            ? '<i class="bi bi-cloud-check-fill text-success"></i> Server connected'
            : '<i class="bi bi-cloud-slash-fill text-warning"></i> Offline mode';
    }
}
