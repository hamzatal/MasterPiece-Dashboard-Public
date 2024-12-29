document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/checkout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect_url;
        } else {
            alert(data.message || 'An error occurred while processing your order.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing your order.');
    });
});
function updateCouponUI(data) {
    const tbody = document.querySelector(
        ".cart__summary--total__table tbody"
    );
    document
        .querySelectorAll(".discount-row, .total-after-discount")
        .forEach((el) => el.remove());

    const discountHTML = `
        <tr class="cart__summary--total__list discount-row">
            <td class="cart__summary--total__title text-left">DISCOUNT</td>
            <td class="cart__summary--amount text-right">- JD ${data.discount.toFixed(
                2
            )}</td>
        </tr>
        <tr class="cart__summary--total__list total-after-discount">
            <td class="cart__summary--total__title text-left">TOTAL AFTER DISCOUNT</td>
            <td class="cart__summary--amount text-right">JD ${data.new_total.toFixed(
                2
            )}</td>
        </tr>
    `;

    tbody.insertAdjacentHTML("beforeend", discountHTML);
}
