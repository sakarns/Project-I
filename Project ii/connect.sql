CREATE TABLE products (
	id INT(11)NOT NULL PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	price DECIMAL(10,2) NOT NULL,
	description TEXT,
	image VARCHAR(255)
);

INSERT INTO products (id, name, price, description, image) VALUES
(1, 'Fertilizer A', 10.99, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vitae nisl velit. Aliquam erat volutpat. Sed in ultricies lorem.', 'product1.jpg'),
(2, 'Insecticide B', 8.99, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vitae nisl velit. Aliquam erat volutpat. Sed in ultricies lorem.', 'product2.jpg');