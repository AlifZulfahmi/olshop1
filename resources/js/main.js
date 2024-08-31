// //add product to cart
// document.addEventListener('DOMContentLoaded', function () {
//     const addToCartButton = document.getElementById('addToCartButton');

//     if (addToCartButton) {
//         addToCartButton.addEventListener('click', function () {
//             const productId = this.getAttribute('data-product-id');
//             const quantity = document.getElementById('quantity').value;

//             fetch('/cart/add', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                 },
//                 body: JSON.stringify({
//                     product_id: productId,
//                     quantity: quantity
//                 })
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.success) {
//                         alert('Product added to cart!');
//                     } else {
//                         alert('Failed to add product to cart.');
//                     }
//                 })
//                 .catch(error => {
//                     console.error('Error:', error);
//                     alert('An error occurred while adding the product to the cart.');
//                 });
//         });
//     }
// });

// //remove product form cart
// document.addEventListener('DOMContentLoaded', function () {
//     let productIdToRemove = null;

//     // Show modal when clicking the remove button
//     document.querySelectorAll('.remove-from-cart').forEach(button => {
//         button.addEventListener('click', function () {
//             productIdToRemove = this.getAttribute('data-product-id');
//             document.getElementById('confirmation-modal').classList.remove('hidden');
//         });
//     });

//     // Confirm removal
//     document.getElementById('confirm-remove').addEventListener('click', function () {
//         if (productIdToRemove) {
//             fetch(`/cart/remove/${productIdToRemove}`, {
//                 method: 'DELETE',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                 }
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.success) {
//                         // Remove the product from the DOM
//                         document.querySelector(`[data-product-id="${productIdToRemove}"]`).closest('.rounded-lg').remove();
//                         // Optionally, update cart total and summary
//                     } else {
//                         alert('Failed to remove item from cart.');
//                     }
//                     document.getElementById('confirmation-modal').classList.add('hidden');
//                 })
//                 .catch(error => console.error('Error:', error));
//         }
//     });

//     // Cancel removal
//     document.getElementById('cancel-remove').addEventListener('click', function () {
//         document.getElementById('confirmation-modal').classList.add('hidden');
//     });
// });

// document.addEventListener('DOMContentLoaded', function () {
//     // Fungsi untuk mengatur nilai input counter
//     function updateCounter(input, increment) {
//         let value = parseInt(input.value, 10);
//         if (isNaN(value)) value = 0;

//         if (increment) {
//             value += 1;
//         } else {
//             if (value > 1) value -= 1; // Mencegah nilai menjadi kurang dari 1
//         }

//         input.value = value;
//     }

//     // Menambahkan event listener ke tombol increment dan decrement
//     document.querySelectorAll('[data-input-counter-increment]').forEach(button => {
//         button.addEventListener('click', function () {
//             const inputId = this.getAttribute('data-input-counter-increment');
//             const input = document.getElementById(inputId);
//             updateCounter(input, true);
//         });
//     });

//     document.querySelectorAll('[data-input-counter-decrement]').forEach(button => {
//         button.addEventListener('click', function () {
//             const inputId = this.getAttribute('data-input-counter-decrement');
//             const input = document.getElementById(inputId);
//             updateCounter(input, false);
//         });
//     });
// });

document.addEventListener('DOMContentLoaded', function () {
    // ADD TO CART FUNCTIONALITY
    const addToCartButtons = document.querySelectorAll('.addToCartButton');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            const quantityInput = this.previousElementSibling; // Assuming input is right before the button
            const quantity = quantityInput ? quantityInput.value : 1;

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const alertContainer = document.getElementById('alert-container');
                        alertContainer.classList.remove('hidden'); // Tampilkan alert

                        setTimeout(() => {
                            alertContainer.classList.add('hidden'); // Sembunyikan alert setelah 5 detik
                        }, 2000);
                    } else {
                        alert('Failed to add product to cart.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while adding the product to the cart.');
                });
        });
    });

    // REMOVE PRODUCT FUNCTIONALITY WITH MODAL CONFIRMATION
    let productIdToRemove = null;

    document.querySelectorAll('.remove-from-cart').forEach(button => {
        button.addEventListener('click', function () {
            productIdToRemove = this.getAttribute('data-product-id');
            document.getElementById('confirmation-modal').classList.remove('hidden');
        });
    });

    document.getElementById('confirm-remove').addEventListener('click', function () {
        if (productIdToRemove) {
            fetch(`/cart/remove/${productIdToRemove}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`[data-product-id="${productIdToRemove}"]`).closest('.rounded-lg').remove();
                        updateSummary(); // Update summary after removing item
                    } else {
                        alert('Failed to remove item from cart.');
                    }
                    document.getElementById('confirmation-modal').classList.add('hidden');
                })
                .catch(error => console.error('Error:', error));
        }
    });

    document.getElementById('cancel-remove').addEventListener('click', function () {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    // UPDATE QUANTITY AND ORDER SUMMARY FUNCTIONALITY
    function updateCounter(input, increment) {
        let value = parseInt(input.value, 10);
        if (isNaN(value)) value = 0;

        if (increment) {
            value += 1;
        } else {
            if (value > 1) value -= 1;
        }

        input.value = value;
        updateSummary(); // Update summary after changing quantity
    }

    document.querySelectorAll('[data-input-counter-increment]').forEach(button => {
        button.addEventListener('click', function () {
            const inputId = this.getAttribute('data-input-counter-increment');
            const input = document.getElementById(inputId);
            updateCounter(input, true);
        });
    });

    document.querySelectorAll('[data-input-counter-decrement]').forEach(button => {
        button.addEventListener('click', function () {
            const inputId = this.getAttribute('data-input-counter-decrement');
            const input = document.getElementById(inputId);
            updateCounter(input, false);
        });
    });

    // FUNCTION TO UPDATE SUMMARY
    function updateSummary() {
        let totalQuantity = 0;
        let totalPrice = 0;

        document.querySelectorAll('[data-input-counter]').forEach(input => {
            const quantity = parseInt(input.value, 10);
            if (!isNaN(quantity)) {
                totalQuantity += quantity;
                const productId = input.id.split('-').pop(); // Assuming ID format "counter-input-<productId>"
                const priceElement = document.querySelector(`[data-product-id="${productId}"]`).closest('.rounded-lg').querySelector('.text-base.font-bold');
                const price = parseInt(priceElement.textContent.replace(/\D/g, ''), 10);
                totalPrice += price * quantity;
            }
        });

        document.getElementById('total-quantity').textContent = totalQuantity;
        document.getElementById('total-price').textContent = 'Rp. ' + totalPrice.toLocaleString('id-ID');
    }

    // INITIALIZE SUMMARY ON PAGE LOAD
    updateSummary();
});
