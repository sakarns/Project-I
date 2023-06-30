const products = [
	{
	id: 1,
		name: "Fertilizer A",
		price: 10.99,
		description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vitae nisl velit. Aliquam erat volutpat. Sed in ultricies lorem.",
		image: "product1.jpg"
	},
	{
		id: 2,
		name: "Insecticide B",
		price: 8.99,
		description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vitae nisl velit. Aliquam erat volutpat. Sed in ultricies lorem.",
		image: "product2.jpg"
	}
];

function displayProducts() {
	const productContainer = document.querySelector(".products");
	let output = "";
	products.forEach(product => {
		output += `
			<div class="product">
				<img src="${product.image}" alt="${product.name}">
				<h3>${product.name}</h3>
				<p>${product.description}</p>
				<p>Price: $${product.price}</p>
				<button onclick="addToCart(${product.id})">Add to Cart</button>
			</div>
		`;
	});
	productContainer.innerHTML = output;
}

function addToCart(productId) {
	// Add code to add product to cart
	console.log(`Product with ID ${productId} added to cart.`);
}

displayProducts();