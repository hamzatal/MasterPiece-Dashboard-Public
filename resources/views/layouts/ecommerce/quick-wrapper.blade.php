<!-- Quickview Wrapper -->
<div class="modal" id="quickViewModal" style="display: none;" data-animation="slideInUp">
    <div class="modal-dialog quickview__main--wrapper">
        <header class="modal-header quickview__header">
            <button class="close-modal quickview__close--btn" aria-label="close modal" onclick="closeQuickViewModal()">✕</button>
        </header>
        <div class="quickview__inner" id="quickViewContent">
            <!-- Product details will be loaded dynamically using JavaScript -->
        </div>
    </div>
</div>
<!-- Quickview Wrapper End -->

<script>
    // Function to open the Quick View Modal
    function openQuickViewModal(productId) {
        const modal = document.getElementById('quickViewModal');
        const content = document.getElementById('quickViewContent');
        modal.style.display = 'block';

        // Display a loading spinner while fetching data
        content.innerHTML = '<div class="loading-spinner">Loading...</div>';

        // Fetch product details using AJAX
        fetch(`/products/quick-wrapper/${productId}`)
            .then(response => response.text())
            .then(html => {
                content.innerHTML = html;
            })
            .catch(error => {
                content.innerHTML = '<p class="error-message">Unable to load product details. Please try again later.</p>';
                console.error('Error loading product details:', error);
            });
    }

    // Function to close the Quick View Modal
    function closeQuickViewModal() {
        const modal = document.getElementById('quickViewModal');
        modal.style.display = 'none';
        document.getElementById('quickViewContent').innerHTML = ''; // Clear the modal content
    }
</script>
