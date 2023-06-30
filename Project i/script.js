// Get the cart icon element and the shopping cart modal
const cartIcon = document.getElementById("cart-icon");
const cartModal = document.getElementById("cart-modal");

// Get the close button element for the shopping cart modal
const closeModalBtn = document.getElementsByClassName("close")[0];

// When the cart icon is clicked, show the shopping cart modal
cartIcon.onclick = function() {
	cartModal.style.display = "block";
}

// When theclose button is clicked, hide the shopping cart modal
closeModalBtn.onclick = function() {
	cartModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if (event.target == cartModal) {
		cartModal.style.display = "none";
	}
}

// Get all the "Add to Cart" buttons
const addToCartButtons = document.querySelectorAll(".add-to-cart");

// Add a click event listener to each "Add to Cart" button
addToCartButtons.forEach(function(button) {
	button.addEventListener("click", addToCartClicked);
});

// When an "Add to Cart" button is clicked, add the product to the shopping cart
function addToCartClicked(event) {
	const button = event.target;
	const product = button.parentElement;
	const productName = product.querySelector("h3").innerText;
	const productPrice = product.querySelector(".price").innerText.replace("$", "");
	addItemToCart(productName, productPrice);
}

// Add the item to the shopping cart
function addItemToCart(productName, productPrice) {
	const cartTable = document.querySelector("#cart-table tbody");
	const cartItemNames = cartTable.querySelectorAll(".cart-item-name");

	// Check if the item is already in the cart
	for (let i = 0; i < cartItemNames.length; i++) {
		if (cartItemNames[i].innerText === productName) {
			const cartItemQuantity = cartItemNames[i].parentElement.querySelector(".cart-item-quantity");
			cartItemQuantity.value++;
			updateCartTotal();
			return;
		}
	}

	// If the item is not already in the cart, add it
	const cartRow = document.createElement("tr");
	cartRow.classList.add("cart-row");
	cartRow.innerHTML = `
		<td class="cart-item-name">${productName}</td>
		<td class="cart-item-price">$${productPrice}</td>
		<td><input class="cart-item-quantity" type="number" value="1"></td>
		<td class="cart-item-total">$${productPrice}</td>
		<td><button class="remove-btn">Remove</button></td>
	`;
	cartTable.appendChild(cartRow);

	// Add a click event listener to the "Remove" button
	cartRow.querySelector(".remove-btn").addEventListener("click", removeCartItem);

	// Add a change event listener to the quantity input field
	cartRow.querySelector(".cart-item-quantity").addEventListener("change", quantityChanged);

	updateCartTotal();
}

// Remove the item from the shopping cart
function removeCartItem(event) {
	const buttonClicked = event.target;
	buttonClicked.parentElement.parentElement.remove();
	updateCartTotal();
}

// Update the shopping cart total
function updateCartTotal() {
    const cartTable = document.querySelector("#cart-table tbody");
    const cartRows = cartTable.querySelectorAll(".cart-row");
    let total = 0;
    for (let i = 0; i < cartRows.length; i++) {
    const cartRow = cartRows[i];
    const priceElement = cartRow.querySelector(".cart-item-price");
    const quantityElement = cartRow.querySelector(".cart-item-quantity");
    const price = parseFloat(priceElement.innerText.replace("$", ""));
    const quantity = quantityElement.value;
    const totalElement = cartRow.querySelector(".cart-item-total");
    const itemTotal = price * quantity;
    totalElement.innerText = "$" + itemTotal.toFixed(2);
    total += itemTotal;
    }
    const cartTotalElement = document.querySelector("#cart-total");
    cartTotalElement.innerText = "$" + total.toFixed(2);
    }

    // Add a change event listener to the quantity input field
    function quantityChanged(event) {
    const input = event.target;
    if (isNaN(input.value || input.value < 1)) {
		input.value = 1;
	}
	updateCartTotal();
}

// When the "Checkout" button is clicked, redirect the user to the checkout page
const checkoutBtn = document.querySelector(".checkout-btn");
checkoutBtn.addEventListener("click", function(event) {
	event.preventDefault();
	alert("Redirecting to checkout page...");
	// Code to redirect the user to the checkout page goes here
});