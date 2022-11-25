
USE 22ac3d03;

CREATE TABLE Store (
	`store_id` INT AUTO_INCREMENT,
	`location` VARCHAR(255) NOT NULL,

	PRIMARY KEY (`store_id`)
);

CREATE TABLE AccessLevel (
	`accessLevel_id` INT,
	`name` VARCHAR(80) NOT NULL,

	PRIMARY KEY (`accessLevel_id`)
);

CREATE TABLE Staff (
	`staff_id` INT AUTO_INCREMENT,
	`store_id` INT,
	`accessLevel_id` INT,
	`firstname` VARCHAR(80) NOT NULL,
	`lastname` VARCHAR(80) NOT NULL,
	`pay` DOUBLE NOT NULL,
	`address` VARCHAR(255) NOT NULL,
	`contactNumber` VARCHAR(14) NOT NULL,
	`contractedHours` DOUBLE NOT NULL,
	`login_username` VARCHAR(80) NOT NULL UNIQUE,
	`login_password` VARCHAR(80) NOT NULL,

	PRIMARY KEY (`staff_id`),
	FOREIGN KEY (`store_id`) REFERENCES Store(`store_id`),
	FOREIGN KEY (`accessLevel_id`) REFERENCES AccessLevel(`accessLevel_id`)
);

CREATE TABLE Shift (
	`shift_id` INT AUTO_INCREMENT,
	`staff_id` INT,
	`start` TIMESTAMP NOT NULL,
	`end` TIMESTAMP NOT NULL,

	PRIMARY KEY (`shift_id`),
	FOREIGN KEY (`staff_id`) REFERENCES Staff(`staff_id`)
);

CREATE TABLE Product (
	`sku_code` INT,
	`name` VARCHAR(255) NOT NULL,
	`description` TEXT,
	`price` DOUBLE NOT NULL,
	`image_count` INT NOT NULL,

	PRIMARY KEY (`sku_code`)
);

CREATE TABLE PriceAdjustment (
	`priceAdjustment_id` INT AUTO_INCREMENT,
	`sku_code` INT,
	`newPrice` DOUBLE NOT NULL,
	`date` TIMESTAMP DEFAULT now(),

	PRIMARY KEY (`priceAdjustment_id`),
	FOREIGN KEY (`sku_code`) REFERENCES Product(`sku_code`)
);

CREATE TABLE Sale (
	`sale_id` INT AUTO_INCREMENT,
	`store_id` INT,
	`staff_id` INT,
	`date` TIMESTAMP DEFAULT now(),
	`totalCost` DOUBLE NOT NULL,
	`review_code` CHAR(40) UNIQUE,

	PRIMARY KEY (`sale_id`),
	FOREIGN KEY (`staff_id`) REFERENCES Staff(`staff_id`),
	FOREIGN KEY (`store_id`) REFERENCES Store(`store_id`)
);

CREATE TABLE Sale_Product (
	`sale_product_id` INT AUTO_INCREMENT,
	`sale_id` INT,
	`sku_code` INT,
	`quantity` INT NOT NULL,

	PRIMARY KEY (`sale_product_id`),
	FOREIGN KEY (`sale_id`) REFERENCES Sale(`sale_id`),
	FOREIGN KEY (`sku_code`) REFERENCES Product(`sku_code`)
);


CREATE TABLE Delivery (
	`delivery_id` INT AUTO_INCREMENT,
	`sale_id` INT,
	`address` VARCHAR(255) NOT NULL,
	`title` VARCHAR(4) NOT NULL,
	`firstname` VARCHAR(80) NOT NULL,
	`lastname` VARCHAR(80) NOT NULL,
	`contactNumber` VARCHAR(14) NOT NULL,
	`email` VARCHAR(80) NOT NULL,
	`deliveryCharge` DOUBLE NOT NULL,

	PRIMARY KEY (`delivery_id`),
	FOREIGN KEY (`sale_id`) REFERENCES Sale(`sale_id`)
);

CREATE TABLE Review (
	`review_id` INT AUTO_INCREMENT,
	`sku_code` INT,
	`rating` INT NOT NULL,
	`title` TEXT,
	`content` TEXT,
	`review_date` TIMESTAMP DEFAULT now(),

	PRIMARY KEY (`review_id`),
	FOREIGN KEY (`sku_code`) REFERENCES Product(`sku_code`)
);


CREATE TABLE StockLevel (
	`stockLevel_id` INT AUTO_INCREMENT,
	`sku_code` INT UNIQUE,
	`store_id` INT,

	`count` INT,
	
	PRIMARY KEY (`stockLevel_id`),
	FOREIGN KEY (`sku_code`) REFERENCES Product(`sku_code`),
	FOREIGN KEY (`store_id`) REFERENCES Store(`store_id`)	
);

CREATE TABLE CashPayment (
	`cashPayment_id` INT AUTO_INCREMENT,
	`sale_id` INT,
	`initialTender` DOUBLE,
	`change` DOUBLE,
	
	PRIMARY KEY (`cashPayment_id`),
	FOREIGN KEY (`sale_id`) REFERENCES Sale(`sale_id`) 
);

CREATE TABLE CardPayment (
	`cardPayment_id` INT AUTO_INCREMENT,
	`sale_id` INT,
	`last4Digits` INT,
	
	PRIMARY KEY (`cardPayment_id`),
	FOREIGN KEY (`sale_id`) REFERENCES Sale(`sale_id`) 
);

