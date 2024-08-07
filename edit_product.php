<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Collect form data
        $productName = $_POST['productName'];
        $productDescription = $_POST['productDescription'];
        $price = $_POST['productPrice'];
        $category = $_POST['productCategory'];
        $stockQuantity = $_POST['stockQuantity'];

        // Update the product
        $update_sql = "UPDATE Products SET product_name=?, productDescription=?, price=?, category=?, stock_quantity=? WHERE product_id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssdssi", $productName, $productDescription, $price, $category, $stockQuantity, $id);

        if ($stmt->execute()) {
            // Redirect with success message and product name
            header('Location: product_stock.php?message=updated&product=' . urlencode($productName));
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Fetch existing product data
        $sql = "SELECT * FROM Products WHERE product_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
    }
} else {
    echo "No product ID provided.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Product</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName"
                    value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="productDescription">Product Description</label>
                <textarea class="form-control" id="productDescription" name="productDescription" rows="3"
                    required><?php echo htmlspecialchars($product['productDescription']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="productPrice">Price</label>
                <input type="number" class="form-control" id="productPrice" name="productPrice"
                    value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="productCategory">Category</label>
                <input type="text" class="form-control" id="productCategory" name="productCategory"
                    value="<?php echo htmlspecialchars($product['category']); ?>" required>
            </div>
            <div class="form-group">
                <label for="stockQuantity">Stock Quantity</label>
                <input type="number" class="form-control" id="stockQuantity" name="stockQuantity"
                    value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>