<?php
include 'db_connection.php';

$productName = $_POST['productName'];
$productDescription = $_POST['productDescription'];
$productPrice = $_POST['productPrice'];
$productCategory = $_POST['productCategory'];
$stockQuantity = $_POST['stockQuantity'];

// Handle image upload
$image = $_FILES['image'];
$imagePath = 'uploads/' . basename($image['name']);

// Check if the uploads directory exists, if not, create it
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

if (move_uploaded_file($image['tmp_name'], $imagePath)) {
    // Insert data into the Products table
    $sql = "INSERT INTO Products (product_name, productDescription, category, price, stock_quantity, image) 
            VALUES ('$productName', '$productDescription','$productCategory', '$productPrice', '$stockQuantity', '$imagePath')";

    if ($conn->query($sql) === TRUE) {
        // Redirect with a success message
        header("Location: product_stock.php?message=success");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error uploading image.";
}

$conn->close();