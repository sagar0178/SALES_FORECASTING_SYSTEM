<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the product name before deleting
    $select_sql = "SELECT product_name FROM Products WHERE product_id=?";
    $stmt = $conn->prepare($select_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $product_name = $product['product_name'];

        // Delete the product
        $delete_sql = "DELETE FROM Products WHERE product_id=?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Redirect with success message and product name
            header('Location: product_stock.php?message=deleted&product=' . urlencode($product_name));
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "No product ID provided.";
    exit();
}

$conn->close();