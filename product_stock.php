<?php
include 'db_connection.php';

// Fetch all products
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Stock</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script>
    function formatPrice(price) {
        return price.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const prices = document.querySelectorAll('.price');
        prices.forEach(priceElement => {
            let price = parseFloat(priceElement.textContent);
            priceElement.textContent = formatPrice(price);
        });
    });
    </script>

</head>

<body>
    <!-- Top Navbar -->
    <div id="navbar-container"></div>
    <script>
    fetch('navbar.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('navbar-container').innerHTML = data;
        });
    </script>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="admin.html">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-line"></i> Sales Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="product_management.html">
                                <i class="fas fa-box"></i> Product Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users"></i> User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-file-alt"></i> Report Generation
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cogs"></i> System Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Page content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="container mt-5">
                    <?php if (isset($_GET['message']) && $_GET['message'] == 'success') : ?>
                    <div class="alert alert-success" role="alert">
                        Product added successfully! Redirecting...
                    </div>
                    <script>
                    setTimeout(function() {
                        window.location.href = 'product_stock.php';
                    }, 3000);
                    </script>
                    <?php endif; ?>

                    <?php if (isset($_GET['message']) && $_GET['message'] == 'updated') : ?>
                    <div class="alert alert-success" role="alert">
                        Product "<?php echo htmlspecialchars($_GET['product']); ?>" updated successfully!
                    </div>
                    <script>
                    setTimeout(function() {
                        window.location.href = 'product_stock.php';
                    }, 3000);
                    </script>
                    <?php endif; ?>

                    <?php if (isset($_GET['message']) && $_GET['message'] == 'deleted') : ?>
                    <div class="alert alert-success" role="alert">
                        Product "<?php echo htmlspecialchars($_GET['product']); ?>" deleted successfully!
                    </div>
                    <script>
                    setTimeout(function() {
                        window.location.href = 'product_stock.php';
                    }, 3000);
                    </script>
                    <?php endif; ?>

                    <h2 class="text-center">Product Stock</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Product Description</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock Quantity</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0) : ?>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['productDescription']); ?></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td><?php echo 'Rs ' . number_format($row['price'], 2); ?></td>
                                <td><?php echo htmlspecialchars($row['stock_quantity']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image"
                                        width="100"></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $row['product_id']; ?>"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <a href="delete_product.php?id=<?php echo $row['product_id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center">No products found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
                <script src=".js/scripts.js"></script>
</body>

</html>

<?php
$conn->close();
?>