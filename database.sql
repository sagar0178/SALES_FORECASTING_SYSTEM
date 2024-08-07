/* Create Admin Table */

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adminid VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

/* Add Admin User in Admin Table */

INSERT INTO admin (adminid, password) VALUES ('admin', 'adminpass');

-- Create Users table
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Products table
CREATE TABLE Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Orders table
CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- Create Order_Items table
CREATE TABLE Order_Items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);

-- Create Sales_Forecast table
CREATE TABLE Sales_Forecast (
    forecast_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    forecast_date DATE NOT NULL,
    forecasted_sales INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);

