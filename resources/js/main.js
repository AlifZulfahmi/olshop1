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

    function updateCart(productId, newQuantity) {
        fetch('/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: newQuantity
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Cart updated successfully!');
                } else {
                    alert('Failed to update cart.');
                }
            })
            .catch(error => console.error('Error:', error));
    }

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

        const productId = input.id.split('-').pop();
        updateCart(productId, value);
        updateSummary();
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

document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('#slider > div');
    const dots = document.querySelectorAll('[data-slide]');
    let currentIndex = 0;
    let autoplayInterval;
    let isSwiping = false;
    let startPos = 0;

    // Function to navigate to a specific slide
    function goToSlide(index) {
        const slider = document.getElementById('slider');
        slider.style.transform = `translateX(-${index * 100}%)`;
        currentIndex = index;
        updateDots();
    }

    // Function to update dot indicators
    function updateDots() {
        dots.forEach((dot, index) => {
            dot.classList.toggle('bg-gray-800', index === currentIndex);
            dot.classList.toggle('bg-gray-400', index !== currentIndex);
        });
    }

    // Autoplay function
    function startAutoplay() {
        autoplayInterval = setInterval(() => {
            currentIndex = (currentIndex + 1) % slides.length; // Loop back to first slide
            goToSlide(currentIndex);
        }, 3000); // Change slide every 3 seconds
    }

    // Stop autoplay when user interacts with the slider
    function stopAutoplay() {
        clearInterval(autoplayInterval);
    }

    // Swipe functionality
    function handleTouchStart(e) {
        stopAutoplay(); // Stop autoplay on touch start
        isSwiping = true;
        startPos = e.touches[0].clientX;
    }

    function handleTouchMove(e) {
        if (!isSwiping) return;
        const currentPos = e.touches[0].clientX;
        const diff = startPos - currentPos;
        if (diff > 50) {
            nextSlide();
            isSwiping = false;
        } else if (diff < -50) {
            prevSlide();
            isSwiping = false;
        }
    }

    function handleTouchEnd() {
        isSwiping = false;
        startAutoplay(); // Restart autoplay on touch end
    }

    // Navigate to next slide
    function nextSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        goToSlide(currentIndex);
    }

    // Navigate to previous slide
    function prevSlide() {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        goToSlide(currentIndex);
    }

    // Add event listeners to dots for navigation
    dots.forEach(dot => {
        dot.addEventListener('click', function () {
            const index = parseInt(this.getAttribute('data-slide'));
            goToSlide(index);
            stopAutoplay(); // Stop autoplay on manual navigation
            startAutoplay(); // Restart autoplay after a delay
        });
    });

    // Add touch event listeners for swipe navigation
    const slider = document.getElementById('slider');
    slider.addEventListener('touchstart', handleTouchStart, { passive: true });
    slider.addEventListener('touchmove', handleTouchMove, { passive: true });
    slider.addEventListener('touchend', handleTouchEnd);

    // Start autoplay
    startAutoplay();
    updateDots(); // Initialize the dots
});

//Count cart items
document.addEventListener('DOMContentLoaded', function () {
    // Fungsi untuk mengupdate item count
    function updateCartItemCount(count) {
        const itemCountElement = document.getElementById('cartItemCount');
        if (count > 0) {
            itemCountElement.textContent = count;
            itemCountElement.classList.remove('hidden');
        } else {
            itemCountElement.classList.add('hidden');
        }
    }

    // Ambil count dari session saat pertama kali load
    fetch('/cart/count')  // Sesuaikan dengan URL endpoint untuk mendapatkan jumlah item di cart
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartItemCount(data.count);
            }
        });

    // Ketika menambahkan produk ke cart
    document.querySelectorAll('.addToCartButton').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const productId = this.dataset.productId;
            const quantity = this.previousElementSibling ? this.previousElementSibling.value : 1; // Ambil kuantitas dari input jika ada

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update item count setelah produk berhasil ditambahkan
                    fetch('/cart/count')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateCartItemCount(data.count);
                            }
                        });
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});