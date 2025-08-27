
    const pricePerItem = 500000; // Harga per item
    const quantityInput = document.getElementById('quantity');
    const totalPriceElement = document.getElementById('totalPrice');

    function updateTotalPrice() {
        const quantity = parseInt(quantityInput.value);
        const totalPrice = pricePerItem * quantity;
        totalPriceElement.textContent = `Rp. ${totalPrice.toLocaleString('id-ID')}`;
    }

    function decreaseQuantity() {
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantity--;
            quantityInput.value = quantity;
            updateTotalPrice();
        }
    }

    function increaseQuantity() {
        let quantity = parseInt(quantityInput.value);
        quantity++;
        quantityInput.value = quantity;
        updateTotalPrice();
    }

    quantityInput.addEventListener('input', updateTotalPrice);

