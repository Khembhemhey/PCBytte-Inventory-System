// Get the success modal element
const successModal = document.getElementById('success-modal');

// Function to open the success modal
function openSuccessModal(message) {
    // Set the success message
    $('#success-message').text(message);
    successModal.style.display = 'block';
}

// Function to close the success modal
function closeSuccessModal() {
    successModal.style.display = 'none';
}

// Event listener for the close button of the success modal
successModal.querySelector('.close').addEventListener('click', closeSuccessModal);

// Update the checkout button event listener to display the success modal
checkoutBtn.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent form submission
    openModal(event);
});

// Function to open the modal and display cart items
function openModal(event) {
    // Fetch cart items using AJAX or any other method
    // and update the contents of the "cart-items" div
    const cartItemsContainer = document.querySelector('.cart-items');
    fetch('includes/get_cart_item.php') // Replace with your server-side script to fetch cart items
        .then(response => response.text())
        .then(data => {
            cartItemsContainer.innerHTML = data;
            modal.style.display = 'block';
            setTimeout(() => {
                openSuccessModal('Checkout process completed successfully.'); // Set the success message
            }, 2000); // Display success modal after 2 seconds
        });
}

// Function to close the modal
function closeModal() {
    modal.style.display = 'none';
    closeSuccessModal(); // Close the success modal when closing the main modal
}

// Event listeners
checkoutBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        closeModal();
    }
});
