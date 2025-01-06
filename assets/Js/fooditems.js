document.addEventListener('DOMContentLoaded', function () {
    // Handle the increase and decrease buttons
    const increaseButtons = document.querySelectorAll('.quantity-controls .increase');
    const decreaseButtons = document.querySelectorAll('.quantity-controls .decrease');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    
    // Increase quantity
    increaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const foodId = button.getAttribute('data-id');
            const inputField = document.getElementById('quantity_' + foodId);
            let currentQuantity = parseInt(inputField.value);
            currentQuantity++;
            inputField.value = currentQuantity;

            updatePrice(foodId, currentQuantity);
        });
    });

    // Decrease quantity
    decreaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const foodId = button.getAttribute('data-id');
            const inputField = document.getElementById('quantity_' + foodId);
            let currentQuantity = parseInt(inputField.value);
            if (currentQuantity > 1) {
                currentQuantity--;
                inputField.value = currentQuantity;

                updatePrice(foodId, currentQuantity);
            }
        });
    });

    // Update price based on quantity
    function updatePrice(foodId, quantity) {
        const pricePerItem = parseFloat(document.querySelector(`#quantity_${foodId}`).getAttribute('data-price'));
        const totalPrice = (pricePerItem * quantity).toFixed(2);

        document.getElementById('price_' + foodId).innerText = `$${totalPrice}`;
    }
});
