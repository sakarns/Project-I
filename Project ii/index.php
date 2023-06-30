<?php
	$conn = mysqli_connect("localhost", "username", "password", "database");

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM products";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "
				<div class='product'>
					<img src='{$row['image']}' alt='{$row['name']}'>
					<h3>{$row['name']}</h3>
					<p>{$row['description']}</p>
					<p>Price: $.{$row['price']}</p>
                    <button>Add to Cart</button>
				</div>
			";
		}
	} else {
		echo "No products found.";
	}

	mysqli_close($conn);
?>